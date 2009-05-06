<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* Helper that holds widget output for views to use
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
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