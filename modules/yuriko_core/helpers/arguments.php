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
		//load the default arguments
		$arguments = Kohana::config('plugin.content_'
		       .$node->content_type->name
			   .'.arguments.defaults');
		is_array($arguments) OR $arguments = array();
		//node args replace default args
		$arguments = array_merge($arguments, self::get_model_args($node));
		//pivot args replace node args
		$arguments = array_merge($arguments, self::get_model_args($pivot));
		//get args replace all args
		$get_key = Kohana::config('plugin.content_'
		       .$node->content_type->name
			   .'.arguments.key');
		//remove any args that not allowed
		$allowed = Kohana::config('plugin.content_'
		       .$node->content_type->name
			   .'.arguments.get');
		if ( !is_array($allowed))
		{
			//no $_GET args are allowed for this plugin
			$get_args = array();
		}
		else
		{
			//$_GET params should be specified like:
			//?basic[node_id][param]=value
			$input = Input::instance();
			$get = $input->get($get_key);
			$get_args = (isset($get[$node->name]))? $get[$node->name] : array();
			foreach ($get_args as $key => $value)
			{
				if ( !array_key_exists($key, $allowed))
				{
					unset($get_args[$key]);
				}
			}
		}
		
		//get args replace all args
		$arguments = array_merge($arguments, $get_args);
		return $arguments;
	}

	/**
	 * Returns the arguments assigned to a specific ORM model.
	 * The model must 'has_many' content_arguments
	 *
	 *
	 * @param <ORM> $obj - the model to return arguments for
	 */
	public static function get_model_args(ORM &$obj)
	{
		$args = array();
		foreach ($obj->content_arguments as $arg)
		{
			$args[$arg->key] = $arg->value;
		}
		return $args;
	}
}