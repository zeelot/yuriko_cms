<?php

class Main_Controller extends Website_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function home()
	{
		$this->template->content = View::factory('content/main/home');
	}
	public function about()
	{
		$this->template->content = View::factory('content/main/about');
	}

} // End Main Controller