<?php

/*
 * Controller to render ORM_Content
 *
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
		$page = ORM::factory('content_page', $alias);
		if(!$page->id) Event::run('system.404');
		$sections = $page->get_sections();
		$this->template = View::factory('templates/page/'.$page->template);
		$this->template->sections = $sections;
	}

	public function load_node($alias = FALSE)
	{
		$this->auto_render = FALSE;
		$node = ORM::factory('content_node', $alias);
		if(!$node->id) Event::run('system.404');

		echo View::factory('templates/node/'.$node->template)->set('node', $node->find_content());
	}
}