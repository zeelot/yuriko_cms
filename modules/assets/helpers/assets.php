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
		if ($files = Kohana::config('assets.groups.'.$tag))
		{
			if (isset($files['stylesheets']))
			{
				foreach($files['stylesheets'] as $file)
				{
					self::add_stylesheet($file);
				}
			}
			if (isset($files['scripts']))
			{
				foreach($files['scripts'] as $file)
				{
					self::add_script($file);
				}
			}
		}
	}

	static public function add_script($file)
	{
		if (in_array($file, self::$scripts)) return;
		self::$scripts[] = $file;
	}

	static public function add_stylesheet($file)
	{
		if (in_array($file, self::$stylesheets)) return;
		self::$stylesheets[] = $file;
	}

	static public function scripts()
	{
		$output = '';
		foreach (self::$scripts as $script)
		{
			$output .= '	'.html::script($script);
		}
		return $output;
	}
	
	static public function stylesheets()
	{
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
				if (isset($required['groups']))
				{
					foreach($required['groups'] as $group)
					{
						self::add($group);
					}
				}
				if (isset($required['stylesheets']))
				{
					foreach($required['stylesheets'] as $stylesheet)
					{
						self::add_stylesheet($stylesheet);
					}
				}
				if (isset($required['scripts']))
				{
					foreach($required['scripts'] as $script)
					{
						self::add_script($script);
					}
				}
			}
		}
	}
} // End assets_Core