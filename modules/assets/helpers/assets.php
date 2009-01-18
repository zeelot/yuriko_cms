<?php defined('SYSPATH') OR die('No direct access allowed.');

class assets_Core
{
	static protected $scripts = array();
	static protected $stylesheets = array();

	//support for groups so you can add a group for global scripts (like jquery)
	//and local theme scripts (like page-specific scripts)
	//take a look at a theme template view for usage
	static public function add_script($file, $group = 'default')
	{
		self::$scripts[$group][] = $file;
	}
	static public function add_stylesheet($file, $group = 'default')
	{
		self::$stylesheets[$group][] = $file;
	}

	static public function get_scripts($prefix = FALSE, $group = FALSE, $print = FALSE)
	{
		$group = ($group)? $group : 'default';
		//default to the global js folder
		$prefix = ($prefix)? $prefix : 'media/js/';
		$output = '';
		foreach (self::$scripts[$group] as $script)
			$output .= html::script($prefix.$script);

		if ($print)
			echo $output;

		return $output;
	}
	static public function get_stylesheets($prefix = FALSE, $group = FALSE, $print = FALSE)
	{
		$group = ($group)? $group : 'default';
		//default to the global media folder
		$prefix = ($prefix)? $prefix : 'media/';
		$output = '';
		foreach (self::$stylesheets[$group] as $stylesheet)
			$output .= html::stylesheet($prefix.$stylesheet);

		if ($print)
			echo $output;

		return $output;
	}
} // End assets_Core