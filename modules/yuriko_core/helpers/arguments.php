<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Argument retriever for Plugins to use.
 * Plugins should be using 1 $_GET parameter for all arguments related
 * to that plugin.  This class will combine $_GET, Node, and Pivot arguments.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @license    http://yurikocms.com/license
 */

class arguments_Core {


	/**
	 * Will return a merged array from $_GET, Content_Pivot, and Content_Node
	 *
	 * @param <ORM> $pivot - The pivot table item to get parameters for
	 */
	public static function get(&$pivot)
	{
		if (!$pivot->loaded) return false;
		
		//get the node and model rows
		$node = $pivot->content_node;
		$model = $node->find_content();
		$get_key = Kohana::config('plugin.content_'
		       .$node->content_type->name
			   .'.arguments.key');
		//$_GET params should be specified like:
		//?basic[node_id][param]=value
		$input = Input::instance();
		$get = $input->get($get_key);
		$get = (isset($get[$node->name]))? $get[$node->name] : array();
		$arguments = Kohana::config('plugin.content_'
		       .$node->content_type->name
			   .'.arguments.defaults');
		is_array($arguments) OR $arguments = array();
		foreach ($node->content_arguments as $arg)
		{
			$arguments[$arg->key] = $arg->value;
		}
		//pivot args replace node args
		foreach ($pivot->content_arguments as $arg)
		{
			$arguments[$arg->key] = $arg->value;
		}
		//get args replace all args
		$arguments = array_merge($arguments, $get);
		return $arguments;
	}
}