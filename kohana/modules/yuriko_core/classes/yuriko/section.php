<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* Helper that holds Section output for views to use
 *
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Yuriko_Section {
	
	static protected $data = array();

	static public function set($section, $data)
	{
		self::$data[$section][] = $data;
	}

	/**
	 * returns an array of views from a given section
	 * or the entire data array if $section = FALSE
	 * @param <String> $section
	 * @return <Array> - An array of views
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
} // End Yuriko_Section