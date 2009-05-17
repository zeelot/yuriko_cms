<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Admin_Controller extends Website_Controller{

	public $template = 'admin/templates/default';

	public function __construct()
	{
		parent::__construct();
	}
    
}