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
	public function load($name = FALSE)
	{
		$page = Auto_Modeler::factory('content_page', $name);
		if(!$page->id) Event::run('system.404');
		$this->template = View::factory($page->template)
		                          ->set('page', $page);
		$objects = $page->find_related('objects');
		$sections = array();
		$current_section = NULL;
		$section = NULL;
		foreach($objects as $obj)
		{
			if ($current_section != $obj->content_section_id)
			{
				$section = $obj->section;
				$current_section = $section->id;
			}
			$sections[$section->name]['object'] = $section;
			$sections[$section->name]['nodes'][] = $obj->node;
		}
		$this->template->sections = $sections;
	}
}