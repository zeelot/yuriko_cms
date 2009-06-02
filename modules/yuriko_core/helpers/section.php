<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* Helper that holds Section output for views to use
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/
class section_Core
{
	static protected $data = array();

	static public function set($section, $data)
	{
		self::$data[$section][] = $data;
	}

	/**
	 * returns an array of views from a given section
	 * or the entire data array if $section = false
	 * @param <String> $section
	 * @return <array> - An array of views
	 */
	static public function get($section = FALSE)
	{
		if (!$section) return self::$data;
		if (isset(self::$data[$section]))
		{
			return self::$data[$section];
		}
		else
		{
			return array();
		}
	}
} // End widget_Core