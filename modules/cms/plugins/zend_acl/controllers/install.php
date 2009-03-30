<?php defined('SYSPATH') or die('No direct script access.');

class Install_Controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function buildAcl()
	{
		// Instantiate our ACL & AUTH modules.
		$acl		= new Acl;
		$acl_model	= new Acl_Model;
		
		// Build ACL list (this is just for testing purposes!
		$acl->addRole(new Acl_Role('guest'))
			->addRole(new Acl_Role('editor'))
			->addRole(new Acl_Role('admin', 'editor'))
			->addRole(new Acl_Role('suser', 'admin'));
		
		// Build resource
		$acl->add(new Acl_Resource('console'))
			->add(new Acl_Resource('users'))
			->add(new Acl_Resource('acl'))
			->add(new Acl_Resource('column'))
			->add(new Acl_Resource('news'))
			->add(new Acl_Resource('bulletin'));
		
		// Build rules
		$acl->deny('guest', 'console');
		$acl->allow('editor', null, array('news', 'column', 'bulletin'));
		$acl->allow('admin');
		
		$acl_model->saveAcl($acl);
		
		die('ACL Built');
	}
}