<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Controller extends Website_Controller{

    public function  __construct() {
        parent::__construct();
		$this->auth = new Auth;
    }
	public function logout()
    {
		$this->auth->logout();
		url::redirect('');
    }
}