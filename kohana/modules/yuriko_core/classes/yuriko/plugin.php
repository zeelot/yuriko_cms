<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Yuriko_Plugin {

	//array of plugin models that have been loaded
	protected static $_models = array();

	public static function init($force = FALSE)
	{
		$plugins = ORM::factory('plugin')
			->where('status', '=', 'enabled')
			->find_all();

		foreach ($plugins as $plugin)
		{
			self::load($plugin);
		}
	}

	/**
	 * Loads a plugin
	 *
	 * @param mixed $plugin
	 * @return bool - if plugin was successfully loaded
	 */
	public static function load($plugin = NULL)
	{
		if ( ! $plugin instanceof ORM)
		{
			if (is_string($plugin))
			{
				$plugin = ORM::factory('plugin')
					->where('name', '=', $plugin)
					->find();
			}
			if (is_int($pluigin))
			{
				$plugin = ORM::factory('plugin', $plugin)->find();
			}
		}

		if ( ! $plugin->loaded())
			return FALSE;

		self::$_models[$plugin->name] = $plugin;
		Kohana::modules(array_merge(Kohana::modules(), array
		(
			$plugin->name => DOCROOT.'plugins/'.$plugin->path
		)));

		$check = Kohana::modules();
		if ( ! isset($check[$plugin->name]))
		{
			unset(self::$_models[$plugin->name]);
			return FALSE;
		}
		return TRUE;
	}

	public static function unload($plugin = NULL)
	{
		if ( ! $plugin instanceof ORM)
		{
			if (is_string($plugin))
			{
				$plugin = ORM::factory('plugin')
					->where('name', '=', $plugin)
					->find();
			}
			if (is_int($pluigin))
			{
				$plugin = ORM::factory('plugin', $plugin)->find();
			}
		}

		if ( ! $plugin->loaded())
			return FALSE;
	}

	public static function models($key = NULL)
	{
		if ($key === NULL)
			return self::$_models;
			
		if (isset(self::$_models[$key]))
			return self::$_models[$key];

		return FALSE;
	}
}