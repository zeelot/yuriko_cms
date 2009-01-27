<?php

/**
 * This hook checks the Access Control List to see if the user is
 * allowed to view this page before the controller is loaded.
 */
class controller_acl{

	public function __construct()
	{
		Event::add('system.routing', array($this, 'allowed'));
	}
	public function allowed()
	{
		
	}
}
new controller_acl;
