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
		$page = ORM::factory('content_page', $alias);
		if(!$page->id) Event::run('system.404');
		$content = $page->render_children();
		if(!$content)
		{
			//page has no content yet
			$content = View::factory('errors/empty_page');
		}
		$this->template = View::factory($page->template)
		                          ->set('content', $content);
	}

	public function load_node($alias = FALSE)
	{
		$this->auto_render = FALSE;
		$node = ORM::factory('content_node', $alias);
		if(!$node->id) Event::run('system.404');

		echo View::factory($node->template)->set('node', $node->find_content());
	}
}