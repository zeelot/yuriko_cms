<?php

class Widget_User_Controller extends Widget_Controller{

    public function  __construct() {
        parent::__construct();
		$this->auth = Auth::instance();
		
    }

	/*
	 * $login_form if TRUE shows the login form when not logged in
	 */
	public function info($login_form = TRUE)
	{
		if (Auth::instance()->logged_in())
        {
			echo View::factory('content/user/info')
				->set('user', $this->user=Session::instance()->get('auth_user'));
		}
		else
		{
			if($login_form)
			{
				$this->login();
			}
		}
	}
    public function login()
    {
		if(isset($_POST['login_form']))
		{
			// Load the user
			$user = ORM::factory('user')->find($_POST['username']);
			// orm user object or $form['username'] could be used
			if($user->login($_POST))
			{
				notice::add('Login Successfull!', 'success');
				url::redirect(Router::$current_uri);
			}
		}
		if ( ! Auth::instance()->logged_in())
		{
			echo View::factory('content/user/login');
		}
    }
}
