<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Controller extends Website_Controller{

    public function  __construct() {
        parent::__construct();
		$this->auth = new Auth;
    }
	/**
	 *
	 * @param <Bool> $login_form  - shows login form if user is not logged in
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
		if(isset($_POST['yuriko_login_form']))
		{
			// Load the user
			$user = ORM::factory('user')->find($_POST['username']);
			// orm user object or $form['username'] could be used
			if($user->login($_POST))
			{
				notice::add('Login Successfull!', 'success');
				url::redirect(Router::$current_uri);
			}
			else
			{
				notice::add('Login Failed!', 'error');
			}
		}
		if ( ! Auth::instance()->logged_in())
		{
			echo View::factory('content/user/login');
		}
    }
	public function logout()
    {
		$this->auth->logout();
		url::redirect('');
    }
}