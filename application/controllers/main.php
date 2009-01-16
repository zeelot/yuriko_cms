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
        widget::set('theme', Component::factory('theme')->method('selection'));
	}

} // End Main Controller
