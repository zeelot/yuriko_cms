<?php

class Error_Controller extends Website_Controller {

	public function _404()
	{
		$this->template->content = View::factory('errors/404');
		$this->template->render(TRUE);
	}
	public function _403()
	{
		$this->template->content = View::factory('errors/403');
		widget::set('user_info', Component::factory('widget_user')->method('login'));
		$this->template->render(TRUE);
	}

} // End Error Controller