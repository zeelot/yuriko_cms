<?php defined('SYSPATH') or die('No direct script access.');

class Acl_Controller extends Controller
{
	public static $_model;
	
	public function __construct()
	{
		parent::__construct();
		 
		self::$_model	= new Acl_Model;
	}
	
	/**
	 * Nab the acl object and unserialize it,
	 * don't forget that the MSSQL driver is
	 * a tad bit too effective with the add
	 * slashes - so we need to be sure and run
	 * a stripcslashes() on the data result.
	 * 
	 * MySQL users shouldn't worry about it, and
	 * the stripcslashes() shouldn't effect results.
	 */
	public function index()
	{
		$object	= self::$_model->getAcl();
		$acl	= unserialize(stripcslashes($object->data));
		
		/* Now we need to tabulate the ACL into a 
		 * readable format so an admin can see
		 * what resources exist, what users exist,
		 * and who has acccess to what.
		 */
		
	}
}