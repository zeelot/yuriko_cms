<?php

/*
 * Controller to render ORM_Content
 *
 *
 */

class Pages_Controller extends Website_Controller{

	public $template = FALSE;//template = $page->template;
	/**
	 * loads the specified page
	 *
	 * @param <string> $name
	 */
	public function load($alias = FALSE)
	{
		$page = Auto_Modeler::factory('content_page', $alias);
		if(!$page->id) Event::run('system.404');
		$this->template = View::factory($page->template)
		                          ->set('page', $page);
	}

	public function load_node($alias = FALSE)
	{
		$this->auto_render = FALSE;
		$node = Auto_Modeler::factory('content_node', $alias);
		if(!$node->id) Event::run('system.404');

		echo View::factory($node->template)->set('node', $node->find_content());
	}
}