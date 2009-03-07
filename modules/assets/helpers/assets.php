<?php defined('SYSPATH') OR die('No direct access allowed.');

class assets_Core
{
	static protected $scripts = array();
	static protected $stylesheets = array();
	static protected $loaded_dependencies = FALSE;

	/*
	 * adds a group of scripts from the assets config file
	 */
	static public function add($tag)
	{
		if ($files = Kohana::config('assets.global.'.$tag))
		{
			$weight = $files['weight'];
			if (isset($files['stylesheets']))
			{
				foreach($files['stylesheets'] as $file)
				{
					self::add_stylesheet($file, $weight);
				}
			}
			if (isset($files['scripts']))
			{
				foreach($files['scripts'] as $file)
				{
					self::add_script($file, $weight);
				}
			}
		}
	}

	static public function add_script($file, $weight = 0)
	{
		if (arr::in_array($file, self::$scripts)) return;
		self::$scripts[$weight][] = $file;
	}

	static public function add_stylesheet($file, $weight = 0)
	{
		if (arr::in_array($file, self::$stylesheets)) return;
		self::$stylesheets[$weight][] = $file;
	}

	static public function scripts()
	{
		ksort(self::$scripts);
		$output = '';
		foreach (self::$scripts as $script)
		{
			$output .= '	'.html::script($script);
		}
		return $output;
	}
	
	static public function stylesheets()
	{
		ksort(self::$stylesheets);
		$output = '';
		foreach (self::$stylesheets as $stylesheet)
		{
			$output .= '	'.html::stylesheet($stylesheet);
		}
		return $output;
	}

	static public function all()
	{
		
		self::load_dependencies();
		return self::stylesheets().self::scripts();
	}

	static public function load_dependencies()
	{
		if (self::$loaded_dependencies) return;
		foreach(View::$loaded as $view)
		{
			$required = Kohana::config('assets.views.'.$view);
			if ($required)
			{
				if (isset($required['globals']))
				{
					foreach($required['globals'] as $global)
					{
						self::add($global);
					}
				}
				if (isset($required['stylesheets']))
				{
					foreach($required['stylesheets'] as $stylesheet => $weight)
					{
						self::add_stylesheet($stylesheet, $weight);
					}
				}
				if (isset($required['scripts']))
				{
					foreach($required['scripts'] as $script => $weight)
					{
						self::add_script($script, $weight);
					}
				}
			}
		}
	}
} // End assets_Core