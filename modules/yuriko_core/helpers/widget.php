<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * Helper that holds widget output for views to use
 */
class widget_Core
{
	static protected $widgets = array();

	static public function set($title, $widget)
	{
		self::$widgets[$title] = $widget;
	}

	static public function get($title, $render = FALSE)
	{
		if (isset(self::$widgets[$title]))
		{
			if($render)
				echo self::$widgets[$title];
			return self::$widgets[$title];
		}
		else
		{
			return false;
		}
	}
} // End widget_Core