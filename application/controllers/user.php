<?php

class User_Controller extends Website_Controller{

    public function  __construct() {
        parent::__construct();
		$this->auth = new Auth;
    }

    public function login($role = '')
    {
		if (Auth::instance()->logged_in($role))
        {
			url::redirect($this->session->get('requested_url', '')); //return to page where login was called
		}
		else
		{
			if (Auth::instance()->logged_in()){
			    $this->template->content = new View('content/user/access_denied');
			}else{
			    $this->template->content = new View('content/user/login');
			}
		}
		if($_POST)
		{
			// Load the user
			$user = ORM::factory('user', $_POST['username']);
			// orm user object or $form['username'] could be used
			Auth::instance()->login($user, $_POST['password']);
			url::redirect('/user/login');
		}

    }
	public function logout()
    {
		$this->auth->logout();
		url::redirect('');
    }
}
