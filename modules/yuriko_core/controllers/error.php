<?php defined('SYSPATH') OR die('No direct access allowed.');

class Error_Controller extends Website_Controller {

	public function _404()
	{
		$this->template->content = View::factory('errors/404');
		$this->template->render(TRUE);
	}
	public function _403()
	{
		$this->template->content = View::factory('errors/403');
		$this->template->render(TRUE);
	}

} // End Error Controller