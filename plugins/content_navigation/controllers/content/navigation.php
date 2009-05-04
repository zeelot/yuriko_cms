<?php
/*
 * Output Navigation Content
 */
class Content_Navigation_Controller extends Controller {

	/**
	 *
	 * @param <mixed> $id The primary_key value of the Navigation_Content_Model
	 * @param <ORM> $pivot The pivot table row for this model
	 * @param <array> $args the arguments for rendering the view
	 */
	public function index($id = NULL, $pivot = NULL, $args = NULL)
	{
		$model = ORM::factory('navigation_content', $id);
		if (!$model->loaded OR !$pivot->loaded) return FALSE;
		echo View::factory('content/navigation/'.$pivot->view)
			->set('node', $model);
	}
}