<?php

class Main_Controller extends Website_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
		$this->profiler = new Profiler;
	}

	public function home()
	{
		$this->template->content = View::factory('content/main/home');
        widget::set('theme_selection', Component::factory('widget_theme')->method('selection'));
		widget::set('user_info', Component::factory('widget_user')->method('info'));
	}

} // End Main Controller