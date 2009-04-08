<?php defined('SYSPATH') or die('No direct script access.');

class DebugToolbar_Core {

	// system.log events
	public static $logs = array();
	
	public static $benchmark_name = 'debug_toolbar';
	
	// show the toolbar
	public static function render($print = false) 
	{
		Benchmark::start(self::$benchmark_name);
		
		$template = new View('toolbar');
		
		if (Kohana::config('debug_toolbar.panels.database'))
			$template->set('queries', self::queries());
			
		if (Kohana::config('debug_toolbar.panels.benchmarks'))
			$template->set('benchmarks', self::benchmarks());
			
		if (Kohana::config('debug_toolbar.panels.logs'))
			$template->set('logs', self::logs());
			
		if (Kohana::config('debug_toolbar.panels.vars_and_config'))
			$template->set('configs', self::configs());
		
		if (Kohana::config('debug_toolbar.firephp_enabled'))
			self::firephp();
		
		$align = '';
		switch (Kohana::config('debug_toolbar.align'))
		{
			case 'right':
				$align = 'right: 0';
				break;
			case 'center':
				$align = '';
				break;
			default:
				$align = 'left: 0';		
		}
		$template->set('align', $align);
		
		$template->set('styles', file_get_contents(Kohana::find_file('views', 'toolbar', false, 'css')));
		$template->set('scripts', file_get_contents(Kohana::find_file('views', 'toolbar', true, 'js')));
		
		if (Event::$data and Kohana::config('debug_toolbar.auto_render'))
		{			
			/*
			 * Inject toolbar html before </body> tag.  If there is
			 * no closing body tag, I dont know what to do :P
			 */
			Event::$data = preg_replace('/<\/body>/', $template->render(false) . '</body>', Event::$data);
		}
		else
		{
			$template->render($print);
		}
		
		Benchmark::stop(self::$benchmark_name);
	}
	
	/*
	 * Hooks the system.log event to catch 
	 * all log messages and save to 
	 * self::$logs;
	 */
	public static function log() 
	{
		self::$logs[] = Event::$data;
	}
	
	public static function logs()
	{
		return self::$logs;
	}
	
	public static function queries()
	{
		return Database::$benchmarks;
	}
	
	public static function benchmarks()
	{
		$benchmarks = array();
		foreach (Benchmark::get(true) as $name => $benchmark)
		{
			$benchmarks[$name] = array(
				'name'   => ucwords(str_replace(array('_', '-'), ' ', str_replace(SYSTEM_BENCHMARK.'_', '', $name))),
				'time'   => $benchmark['time'],
				'memory' => $benchmark['memory']
			);
		}
		$benchmarks = array_slice($benchmarks, 1) + array_slice($benchmarks, 0, 1);
		return $benchmarks;
	}
	
	/*
	 * Add toolbar data to FirePHP console
	 */
	private static function firephp()
	{
		$firephp = FirePHP::getInstance(true);
		
		$firephp->fb('KOHANA DEBUG TOOLBAR:');
		
		// globals
		
		$globals = array(
			'Post'    => empty($_POST)    ? array() : $_POST,
			'Get'     => empty($_GET)     ? array() : $_GET,
			'Cookie'  => empty($_COOKIE)  ? array() : $_COOKIE,
			'Session' => empty($_SESSION) ? array() : $_SESSION
		);
		
		foreach ($globals as $name => $global)
		{
			$table = array();
			$table[] = array($name,'Value');
			
			foreach($global as $key => $value)
			{
				if (is_object($value))
					$value = get_class($value).' [object]';
					
				$table[] = array($key, $value);
			}
			
			$firephp->fb(
				array(
					"$name: ".count($global).' variables',
					$table
				),
				FirePHP::TABLE
			);
		}
		
		// database
		
		$queries = self::queries();
		
		$total_time = $total_rows = 0;
		$table = array();
		$table[] = array('SQL Statement','Time','Rows');
		
		foreach ($queries as $query)
		{
			$table[] = array(
				str_replace("\n",' ',$query['query']), 
				number_format($query['time'], 3), 
				$query['rows']
			);
			
			$total_time += $query['time'];
			$total_rows += $query['rows'];
		}
		
		$firephp->fb(
			array(
				'Queries: ' . count($queries).' SQL queries took '.number_format($total_time,3).' seconds and returned '.$total_rows.' rows',
				$table
			),
			FirePHP::TABLE
		);
		
		// benchmarks
		
		$benchmarks = self::benchmarks();
		
		$table = array();
		$table[] = array('Benchmark','Time','Memory');
		
		foreach ($benchmarks as $name => $benchmark)
		{
			// Clean unique id from system benchmark names
			$name = ucwords(str_replace(array('_', '-'), ' ', str_replace(SYSTEM_BENCHMARK.'_', '', $name)));
			
			$table[] = array(
				$name, 
				number_format($benchmark['time'], 3), 
				number_format($benchmark['memory'] / 1024 / 1024, 2).'MB'
			);
		}
		
		$firephp->fb(
			array(
				'Benchmarks: ' . count($benchmarks).' benchmarks took '.number_format($benchmark['time'], 3).' seconds and used up '. number_format($benchmark['memory'] / 1024 / 1024, 2).'MB'.' memory',
				$table
			),
			FirePHP::TABLE
		); 
	}
	
	/*
	 * Config is only directly accessible from inside
	 * the Kohana core class.  So, unfortunately, I have
	 * to go through and load every config file manually. 
	 * This is pretty inneficient but I can't think of a way
	 * around it.
	 */
	private static function configs() 
	{	
		if (Kohana::config('debug_toolbar.skip_configs') === true)
			return array();
		
		// paths to application and system config
		$paths = array(
			APPPATH.'config/', 
			SYSPATH.'config/'
		);
		
		// paths to module config
		foreach ((array)Kohana::config('core.modules') as $modpath)
		{
			if (is_dir("$modpath/config/"))
			{
				$paths[] = "$modpath/config/";
			}
		}
		
		$configuration = array();
		
		// load and merge configs in each path
		foreach ($paths as $path) 
		{
			if ($handle = opendir($path)) 
			{
				// read all files in config dir
				while (($file = readdir($handle)) !== false) 
				{
					// remove file extension from file name
					$filename = self::_strip_ext($file);
					
					// filter skip configs
					if (in_array($filename, (array)Kohana::config('debug_toolbar.skip_configs')))
					{
						continue;
					}
					
					// let Kohana find full path to file
					if ($files = Kohana::find_file('config', $filename))
					{
						foreach ($files as $file)
						{
							require $file;
							if (isset($config) AND is_array($config))
							{
								$configuration[$filename] = isset($configuration[$filename]) ? array_merge($configuration[$filename], $config) : $config;
							}
							$config = array();
						}
					}
				}
			}
		}
		return $configuration;
	}
	
	// return a filename without extension
	private static function _strip_ext($filename)
	{
		if (($pos = strrpos($filename, '.')) !== false)
		{
			return substr($filename, 0, $pos);
		}
		else
		{
			return $filename;
		}
	}

}