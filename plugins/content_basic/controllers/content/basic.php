<?php
/*
 * Output Basic Content
 */
class Content_Basic_Controller extends Controller {

	/**
	 *
	 * @param <mixed> $id The primary_key value of the Basic_Content_Model
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $args = NULL)
	{
		$content = ORM::factory('basic_content', $id);
		if (!$content->loaded) return FALSE;
		$content->render();
	}
}