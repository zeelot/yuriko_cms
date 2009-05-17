<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Model extends Auth_User_Model {
	
	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('email', 'required', 'length[4,127]', 'valid::email')
			->add_rules('username', 'length[4,32]', 'chars[a-zA-Z0-9_.]')
			->add_rules('password', 'length[5,42]');

		if($this->loaded)
		{
			//user is editing, username must exist
			$array->add_rules('username', array($this, 'username_exists'));
			
		}
		else
		{
			//creating a new user, username must be available
			$array->add_rules('username', 'required', array($this, 'username_available'))
				->add_rules('password', 'required', 'matches[password_confirm]');
		}
		//skip Auth_User::validate();
		return ORM::validate($array, $save);
	}
	
} // End User Model