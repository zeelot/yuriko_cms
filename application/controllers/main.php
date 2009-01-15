<?php

class Main_Controller extends Website_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function home()
	{
        if(isset($_POST['theme']))
        {
            $this->session->set('theme', $_POST['theme']);
			$this->session->set('theme_set', TRUE);
            url::redirect();
        }
		$changed = ($this->session->get_once('theme_set', FALSE))? TRUE : FALSE;
		$this->template->content = View::factory('content/main/home');
		$this->template->content = View::factory('content/main/home');
        $this->template->theme_selection = View::factory('content/theme/selection')
            ->set('themes', kohana::config('themes.available'))
            ->set('active', kohana::config('themes.active'))
			->set('changed', $changed);
	}

} // End Main Controller
