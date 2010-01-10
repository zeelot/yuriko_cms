<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * An installer helper to run repetitive tasks for plugin installers.
 * Things like running SQL from a view.
 * 
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

 class Yuriko_Installer {

	/**
	 * Runs SQL from a View or other String.
	 *
	 * @param <string> $view - the SQL string usually rendered from a View
	 * @param <stromg> $database - database config to use
	 */
	public static function run_sql($view, $database = 'default')
	{
		/**
		 * @TODO:
		 * Need to rewrite this to work with new DB Library
		 */
	}

	/**
	 * Deletes all the Content_Node entries for a certain plugin.
	 * Usually used for Content_* plugins
	 *
	 * @param Plugin_Model $plugin - The plugin of which to delete all the nodes for.
	 */
	public static function delete_nodes(Plugin_Model $plugin)
	{
		if (!$plugin->loaded) return false;
		foreach ($plugin->content_nodes as $node)
		{
			$node->delete();
		}
	}
 }