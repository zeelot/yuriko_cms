<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Argument retriever for Plugins to use.
 * Plugins should be using 1 $_GET parameter for all arguments related
 * to that plugin.  This class will combine $_GET, Node, and Pivot arguments.
 * This class will also help build links without breaking current plugin
 * arguments.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @license    http://yurikocms.com/license
 * @todo       put together some methods to work with html:: helper..not sure yet.
 */

class Arguments_Core {

	protected $arguments = array();

	public function instance()
	{
		static $instance;
		empty ($instance) AND $instance = new Arguments();
		return $instance;
	}

	protected function __construct()
	{
		$this->arguments = Input::instance()->get();
	}

	public function defaults($plugin)
	{
		$data = Kohana::config('plugin.'.$plugin);
		if (isset($data['arguments']['default']))
		{
			return $data['arguments']['default'];
		}
		else
		{
			return array();
		}
	}
	public function get($key = FALSE, $allowed = FALSE)
	{
		if (!$key) return $this->arguments;

		$data = Kohana::key_string($this->arguments, $key);

		//remove any args that not allowed
		if (is_array($allowed))
		{
			foreach ($data as $k => $v)
			{
				if ( !array_key_exists($k, $allowed))
				{
					unset($data[$key]);
				}
			}
		}
		return $data;
	}
	public function pivot(Content_Pivot_Model &$pivot, $merge = FALSE)
	{
		$args = $this->get_model_args($pivot);
		if (!$merge) return $args;
		$node = $pivot->content_node;
		
		$plugin = $node->plugin;

		$node_args = $this->node($node);
		$get_args = $this->get();
	}
	public function node(Content_Node_Model &$node)
	{
		$args = $this->get_model_args($node);
		return $args;
	}
	/**
	 * Returns the arguments assigned to a specific ORM model.
	 * The model must 'has_many' content_arguments
	 *
	 *
	 * @param <ORM> $obj - the model to return arguments for
	 */
	public function get_model_args(ORM &$obj)
	{
		$args = array();
		foreach ($obj->content_arguments as $arg)
		{
			$args[$arg->key] = $arg->value;
		}
		return $args;
	}
	
}