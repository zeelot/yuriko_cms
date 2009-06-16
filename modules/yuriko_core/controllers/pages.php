<?php defined('SYSPATH') OR die('No direct access allowed.');

/*
 * Controller to render ORM_Content
 *
 */

class Pages_Controller extends Website_Controller{

	public $template = FALSE;
	/**
	 * loads the specified page
	 *
	 */
	public function load($alias = FALSE)
	{
		$alias = rtrim($alias, '/');
		$page = ORM::factory('content_page', $alias);
		if (!$page->id) Event::run('system.404');
		if (!$page->has_content())
		{
			$this->template = View::factory('templates/static/default');
			$this->template->content = View::factory('errors/empty_page');
		}
		else
		{
			$this->template = View::factory('templates/page/'.$page->template);
			$pages = array();
			$pages[] = $page->id;
			foreach ($page->content_page_inheritances as $inh)
			{
				$pages[] = $inh->inherited_page_id;
			}
			$pivots = ORM::factory('content_pivot')
			->in('content_page_id', $pages)
			->find_all();
			foreach ($pivots as $pivot)
			{
				$node = $pivot->content_node;
				$plugin = $node->plugin;
				/**
				 * load the view defined in the pivots table
				 * so that a view can be defined when adding a node to a page.
				 * this makes it possible to use a different view for
				 * a menu displayed at the top of the page and a menu on the
				 * side of the page.
				 */
				$node_view = View::factory('templates/node/'.$node->template);
				$node_view->content = Component::factory($plugin->dir)
					->method('pivot', array($pivot));
				section::set(Kohana::config('theme.sections.'.$pivot->section),$node_view);
			}
		}
	}

	public function load_node($alias = FALSE)
	{
		$this->auto_render = FALSE;
		$alias = rtrim($alias, '/');

		$node = ORM::factory('content_node', $alias);
		if(!$node->id) Event::run('system.404');
		$type = $node->content_type;

		echo Component::factory('content/'.$type->name)
				->method('index', array($node->content_id, 'default', arguments::get_model_args($node)));
	}
}