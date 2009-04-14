<?php

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
	public function load($route = FALSE)
	{
		$segs = explode(':', $route);
		$alias = $segs[0];
		$page = ORM::factory('content_page', $alias);
		if(!$page->id) Event::run('system.404');
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
			$sections = array();
			foreach ($pivots as $pivot)
			{
				$node = $pivot->content_node;
				$type = $node->content_type;
				$node_view = View::factory('templates/node/'.$node->template);
				$node_view->content = Component::factory('content/'.$type->name)
					->method('index', array($node->content_id));
				$sections[$pivot->section][] = $node_view;
			}
			foreach (Kohana::config('theme.sections') as $key => $val)
			{
				if(!isset($sections[$key]))
				{
					$sections[$key] = array();
				}
			}
			$this->template->sections = $sections;
		}
	}

	public function load_node($alias = FALSE)
	{
		$this->auto_render = FALSE;
		$node = ORM::factory('content_node', $alias);
		if(!$node->id) Event::run('system.404');

		echo View::factory('templates/node/'.$node->template)->set('node', $node->find_content());
	}
}