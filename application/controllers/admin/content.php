<?php

class Content_Controller extends Website_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function manage()
	{
		$this->template->content = View::factory('content/admin/content/edit');
		$this->template->content->item = ORM::factory('basic_content', 'site_intro');
	}

	public function pages()
	{

	}

} // End Admin Content Controller