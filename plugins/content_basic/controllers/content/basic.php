<?php
/*
 * Output Basic Content
 */
class Content_Basic_Controller extends Controller {

	/**
	 *
	 * @param <mixed> $id The primary_key value of the Basic_Content_Model
	 * @param <ORM> $pivot The pivot table row for this model
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $pivot = NULL, $args = NULL)
	{
		$model = ORM::factory('basic_content', $id);
		if (!$model->loaded OR !$pivot->loaded) return FALSE;
		echo View::factory('content/basic/'.$pivot->view)
			->set('node', $model);
	}
}