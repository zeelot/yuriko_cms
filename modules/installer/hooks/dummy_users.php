<?php

class Dummy_Users{

	public function __construct()
	{
		/* users */
		$users = ORM::factory('user')->find_all();
		foreach($users as $user)
		{
			$user->delete();
		}
		$user = new User_Model;
		$user->username = 'admin';
		$user->password = 'admin';
		$user->email = 'admin@admin.com';
		$user->save();
		$user->add(ORM::factory('role', 'login'));
		$user->add(ORM::factory('role', 'admin'));
		$user->clear();

		$user->username = 'demo';
		$user->password = 'demo';
		$user->email = 'demo@demo.com';
		$user->save();
		$user->add(ORM::factory('role', 'login'));
		$user->save();
	}
}
new Dummy_Users;