<?php
/*
 * Output Navigation Content
 */
class Content_Navigation_Controller extends Controller {

	/**
	 *
	 * @param <mixed> $id The primary_key value of the Navigation_Content_Model
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $args = NULL)
	{
		$content = ORM::factory('navigation_content', $id);
		if (!$content->loaded) return FALSE;
		$content->render();
	}
}