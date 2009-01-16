<?php

class Theme_Controller extends Widget_Controller{

	public $auto_render = FALSE;

    public function __construct()
    {
        parent::__construct();
        $this->session = Session::instance();
    }

    public function selection()
    {
        if(isset($_POST['theme']))
        {
            $this->session->set('theme', $_POST['theme']);
			$this->session->set('theme_set', TRUE);
            url::redirect();
        }
		$changed = ($this->session->get_once('theme_set', FALSE))? TRUE : FALSE;

        echo View::factory('content/theme/selection')
            ->set('themes', kohana::config('themes.available'))
            ->set('active', kohana::config('themes.active'))
			->set('changed', $changed);
    }
}