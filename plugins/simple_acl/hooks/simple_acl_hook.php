<?php

/**
 *
 */
class simple_acl_hook{

	protected $user_roles = array();

	public function __construct()
	{
		if($user = Session::instance()->get('auth_user', FALSE))
		{
			foreach($user->roles as $role)
			{
				$this->user_roles[] = $role->name;
			}
		}
		if (count($this->user_roles) < 1)
		{
			$this->user_roles[] = 'guest';
		}
		Event::add('system.routing', array($this, 'route_check'));
	}

	/**
	 * Check to see if the user can continue to the controller
	 */
	public function route_check()
	{
		$allowed = FALSE;
		$allowed_roles = Kohana::config('routes.'.Router::$current_route.'.allowed_roles');
		if($allowed_roles === NULL)
		{
			//everyone is allowed to access this route
			$allowed = TRUE;
		}
		if(!$allowed)
		{
			foreach($allowed_roles as $role)
			{
				if (in_array($role, $this->user_roles))
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
}
new simple_acl_hook;
