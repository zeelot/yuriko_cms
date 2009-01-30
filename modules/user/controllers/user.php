<?php

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
	public function profile()
	{
		widget::set('user_info', Component::factory('widget_user')->method('info'));
		$this->profiler = new Profiler;
		$user = Session::instance()->get('auth_user');
		if(isset($_POST['profile_form']))
		{
			$profile = $user->profile;
			if($profile->validate($_POST))
			{
				$profile->load_values($_POST->as_array());
				$profile->save();
			}
			if(isset($_POST['password']) AND ($_POST['password'] != ''))
			{
				//if($user->change_password($_POST->as_array(), TRUE))
				//{
				//	url::redirect('user/profile');
				//}
			}
			else
			{
				url::redirect('user/profile');
			}
		}
		$this->template->content = View::factory('content/user/profile')
				->set('user', $user);
		
	}
	public function memberlist()
	{
		
	}
}