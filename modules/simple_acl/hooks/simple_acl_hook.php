<?php

/**
 *
 */
class simple_acl_hook{

	protected $acl;
	protected $cache;
	protected $user_roles = array();

	public function __construct()
	{
		$this->cache = new Cache;
		if($user = Session::instance()->get('auth_user', FALSE))
		{
			foreach($user->roles as $role)
			{
				$this->user_roles[] = $role->name;
			}
		}
		else
		{
			$this->user_roles[] = 'guest';
		}

		$acl = $this->cache->get('ACL');
		if($acl)
		{
			$this->acl	= unserialize($acl);
		} else {
			$this->acl	= new Acl;
			// Define the ACL roles
			$this->acl->addRole(new Acl_Role('guest'))
					  ->addRole(new Acl_Role('login'))
					  ->addRole(new Acl_Role('admin'));
			//key = role required, values = routes allowed
			$controllerResources	= array(
											'guest'	=>array
												(
													'default',
												),
											'login'	=>array
												(
													'profile'
												),
											'admin'	=>array
												(
													'admin'
												)
											);
			$this->acl->add(new Acl_Resource('default'));
			$this->acl->add(new Acl_Resource('profile'));
			$this->acl->add(new Acl_Resource('admin'));

			$this->acl->allow(NULL, 'default');
			$this->acl->deny('guest', 'profile');
			$this->acl->allow('login', 'profile');


			// Put the ACL into memcache if we are in production!
			$setCache = $this->cache->set('ACL', serialize($this->acl));
		}
		Event::add('system.routing', array($this, 'route_check'));
	}

	/**
	 * Check to see if the user can continue to the controller
	 */
	public function route_check()
	{
		$allowed = FALSE;
		foreach($this->user_roles as $role)
		{
			if($this->acl->isAllowed($role, Router::$current_route))
			{
				$allowed = TRUE;
			}
		}
		if (!$allowed)
		{
			Event::run('system.403');
		}
	}
}
new simple_acl_hook;
