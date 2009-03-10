<?php

/*
 * Temporary demo controller
 *
 *
 */

class Content_Controller extends Website_Controller{

	/**
	 * loads the specified page
	 *
	 * @param <int> $id
	 */
	public function basic($tag = FALSE)
	{
		if(!$tag) Event::run('system.404');
		$node = ORM::factory('basic_content', $tag);
		if(!$node->loaded) Event::run('system.404');
		$this->template->content = View::factory('content/content/basic')
			->set('node', $node);
	}
}