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
			$this->acl	= new Zend_Acl;
			//create the acl roles and add the guest role
			$this->acl->addRole(new Zend_Acl_Role('guest'));
			foreach (ORM::factory('role')->find_all() as $role)
			{
				$this->acl->addRole(new Zend_Acl_Role($role->name));
			}
			//load route-based permissions
			foreach(Kohana::config('routes') as $resource => $info)
			{
				$this->acl->add(new Zend_Acl_Resource($resource));
				if(((!isset($info['allowed_roles']))
					OR $info['allowed_roles'] === NULL))
				{
					//everyone is allowed
					$this->acl->allow(NULL, $resource);
				}
				else
				{
					foreach($info['allowed_roles'] as $role)
					{
						$this->acl->allow($role, $resource);
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
