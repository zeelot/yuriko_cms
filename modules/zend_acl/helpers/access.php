<?php defined('SYSPATH') or die('No direct script access.');

class Access
{
	public static function check($resource, $location)
	{
		$session	= new Session;
		$acl_model	= new Acl_Model;
		
		$acl		= $acl_model->getAcl();
		
		$agent_role	= trim($session->get('role'));
	 	
 		switch(True)
 		{
 			case !isset($agent_role)	:
 				$agent_role = 'guest';
 				break;
 			case empty($agent_role)		:
 				$agent_role = 'guest';
 				break;
 			case $agent_role == ''		:
 				$agent_role = 'guest';
 				break;
 			case is_null($agent_role)	:
 				$agent_role = 'guest';
 				break;
 		}
 		
 		if((int)$session->get('status') == 0)
 			url::redirect('auth/logout', 301);
 		
 		if(!$acl->isAllowed($agent_role, $resource))
 		{
 			url::redirect($location, 301);
 		} else {
 			return True;
 		}
	}
}