<?php defined('SYSPATH') OR die('No direct access allowed.');

class javascript_Core
{
	static protected $scripts = array();

	static public function add($file)
	{
		self::$scripts[] = $file;
	}

	static public function render($print = FALSE)
	{
		$output = '';
		foreach (self::$scripts as $script)
			$output .= html::script($script);

		if ($print)
			echo $output;

		return $output;
	}
} // End javascript_Core