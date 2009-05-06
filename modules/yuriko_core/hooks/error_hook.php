<?php defined('SYSPATH') OR die('No direct access allowed.');

class error_hook{

	public function __construct()
	{
		//clear 404 and add my own errors
		Event::clear('system.404', array('Kohana', 'show_404'));
		Event::add('system.404', array($this, 'show_404'));
		Event::add('system.403', array($this, 'show_403'));
	}

	//not found
	public function show_404()
	{
		$page = new Error_Controller();
		$page->_404();
		die();
	}

	//forbidden
	public function show_403()
	{
		$page = new Error_Controller();
		$page->_403();
		die();
	}
}
new error_hook;