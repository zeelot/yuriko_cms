<?php

/**
 *
 */
class simple_acl_hook{

	protected $acl;
	protected $cache;
	protected $user_roles;

	public function __construct()
	{
		$this->cache = new Cache;
		$this->user_roles = ($user = Auth::instance()->get_user())?
			(array) $user->roles : array('guest');

		$acl = $this->cache->get('ACL');
		if($acl)
		{
			$this->acl	= unserialize($acl);
		} else {
			$this->acl	= new Acl;
			// Define the ACL roles
			$this->acl->addRole(new Acl_Role('guest'))
					  ->addRole(new Acl_Role('login'))
					  ->addRole(new Acl_Role('admin'), 'login');
			//key = role required, values = routes allowed
			$controllerResources	= array('guest'	=>array('default',),
											'login'	=>array('profile'),
											'admin'	=>array('admin'));

			/*
			 * The below loops may be redundant, but, it helps to keep
			 * it as readable as possible until somone de-couples the
			 * ACL definitions into a lib/helper - for now this will work
			 * just fine.
			 */

			// Define the ACL resources (CONTROLLER NAMES!!!)
			foreach($controllerResources as $resourceGroup)
			{
				foreach($resourceGroup as $resourceItem)
					$this->acl->add(new Acl_Resource($resourceItem));
			}

			// Allow the 'user' and 'admin' roles SOME console controllers listed
			foreach($controllerResources as $resourceKey => $resourceValue)
			{
			// Don't forget, above, we defined superuser as inheriting the admin role permissions
				if($resourceKey=='guest')
				{
					foreach($resourceValue as $resourceItem)
						$this->acl->allow(NULL, $resourceItem);
				} elseif($resourceKey=='login') {
					foreach($resourceValue as $resourceItem)
					{
						$this->acl->deny('guest', $resourceItem);
						$this->acl->allow('login', $resourceItem);
					}
				}
				elseif($resourceKey=='admin') {
					foreach($resourceValue as $resourceItem)
					{
						$this->acl->deny('login', $resourceItem);
						$this->acl->allow('admin', $resourceItem);
					}
				}
			}
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
