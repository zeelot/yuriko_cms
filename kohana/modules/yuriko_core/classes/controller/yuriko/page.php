<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */
 
class Controller_Yuriko_Page extends Controller_Template {

	//can't auto render because template is in DB
	public $auto_render = FALSE;
	
	/**
	 * 'Builds' the page based on $uri.
	 * Finds all the different nodes this page is made of
	 * and initializes all the sub-requests, placing the response
	 * in the right section of the page.
	 *
	 * @param string $uri - page uri
	 */
	public function action_index($uri = NULL)
	{
		$this->title = 'hello';
		$this->template = View::factory('templates/default');
		$this->request->response = $this->template;
		return;

		// parse the URI and find parameters
		$segments = explode('/', $uri);
		$current_segment = NULL;
		$page = ORM::factory('page');
		foreach($segments as $segment)
		{
			if ($current_segment === NULL)
			{
				$current_segment = $segment;
				$page = $page->where('uri', '=', $current_segment);
			}
			else
			{
				$current_segment .= '/'.$segment;
				$page = $page->or_where('uri', '=', $current_segment);
			}
		}
		// find the most complete match
		$page = $page->order_by('uri', 'DESC')->find();

		if ( ! $page->loaded())
		{
			// yuriko page doesn't exist
			Event::run('yuriko.404');
			return;
		}

		// get parameters
		$parameters = substr($uri, strlen($page->uri));

		// set the template defined in the database
		$this->template = new View('templates/'.$page->template);

		//get all nodes on this page
		$page_nodes = $page->page_nodes->find_all();

		foreach ($page_nodes as $page_node)
		{
			$route_params = array();

			//get this node
			$node = $page_node->node;

			//get custom parameters for this node
			$params = $node->node_route_parameters->find_all();

			foreach ($params as $param)
			{
				$route_params[$param->key] = $param->value;
			}

			//replace node params with page_node params
			$params = $page_node->node_route_parameters->find_all();

			foreach ($params as $param)
			{
				$route_params[$param->key] = $param->value;
			}

			//get the route
			$node_route = $node->node_route;

			//route name (to make the sub-request)
			$route = route::get($node_route->name);

			//find the uri and append the parameters to it
			$uri = $route->uri($route_params).$parameters;

			if ($page_node->section === NULL)
			{
				//execute sub-request and let the node handle outputting
				Request::factory($uri)
					->execute();
			}
			else
			{
				//execute sub-request and put output in the right section
				section::set($page_node->section, Request::factory($uri)
					->execute());
			}
		}

		$this->request->response = $this->template;
	}

} // End Yuriko Page Controller
