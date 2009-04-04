<?php

abstract class Admin_Controller extends Website_Controller{

	public $template = 'admin/templates/default';

	public function __construct()
	{
		//login widget for pages to use
		widget::set('user_info', Component::factory('widget_user')->method('info'));
		parent::__construct();
	}
    
}