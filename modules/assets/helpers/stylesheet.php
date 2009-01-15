<?php defined('SYSPATH') OR die('No direct access allowed.');

class stylesheet_Core
{
	static protected $stylesheets = array();

	static public function add($file)
	{
		self::$stylesheets[] = $file;
	}

	static public function render($print = FALSE)
	{
		$output = '';
		foreach (self::$stylesheets as $stylesheet)
			$output .= html::stylesheet($stylesheet);

		if ($print)
			echo $output;

		return $output;
	}
} // End stylesheet_Core