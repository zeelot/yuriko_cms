<?php
/*
 * Output Basic Content
 */
class Content_Basic_Controller extends Controller {

	/**
	 *
	 * @param <mixed> $id The primary_key value of the Basic_Content_Model
	 * @param <string> $view the view to use to render the content
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $view = 'default', $args = NULL)
	{
		$model = ORM::factory('basic_content', $id);
		if (!$model->loaded) return FALSE;
		echo View::factory('content/basic/'.$view)
			->set('node', $model);
	}
}