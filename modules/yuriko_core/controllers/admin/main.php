<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
 * 
 */
class Main_Controller extends Admin_Controller {

	public function home()
	{
		$this->template->content = View::factory('admin/content/main/home');
	}

} // End Admin Main Controller