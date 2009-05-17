<?php

class auth_hook{

	public function __construct()
	{
		Event::add('yuriko.post_admin_nav_plugins', array($this, 'add_info_to_admin_panel'));
		Event::add('yuriko.admin_nav_plugins', array($this, 'add_plugin_link'));
	}
	public function add_info_to_admin_panel()
	{
		echo Component::factory('user')->method('info');
	}
	public function add_plugin_link()
	{
		echo View::factory('admin/nav/generic_item')
			->set('item', html::anchor('admin/users/manage', 'Auth Users'));
	}
}
new auth_hook;