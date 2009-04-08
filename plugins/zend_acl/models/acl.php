<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Key model for all ACL data that may be
 * serialized and stored in a DB/file/etc..
 */
class Acl_Model extends Model
{
	protected static $_acl;
	protected $chk_sum;
	
	/**
	 * Setup up the ACL model, adapter is there
	 * in anticipation of a public release, as
	 * there may be other storage needs such as
	 * file based, XML, etc...
	 *
	 * @param	varchar	$adapter
	 */
	public function __construct($xml=null)
	{
		parent::__construct();
		
		$xml_file = is_null($xml) ? config::item('acl.xml_model') : $xml;
		
		if(!file_exists($xml_file))
			throw new Kohana_User_Exception('Missing file', "The provided xml file: $this->xml could not be found");
			
		// Generate our checksum
		$this->chk_sum	= md5_file($xml_file);
		
		/* First things first, if acl in DB doesn't exist,
		 * we need to create a default one...
		 */
		$query	= $this->db->where(array('id' => 1))->get('acl')->current();

		if(!$query)
		{
			// If it doesn't match, we need to rebuild it, save it and return it!
			$build	= new Acl_Xml;
			self::saveAcl($build->buildAcl(), null, False);
		} elseif($query->hash != $this->chk_sum) {
			// If it doesn't match, we need to rebuild it, save it and return it!
			$build	= new Acl_Xml;
			self::saveAcl($build->buildAcl());
		}
	}
	
	/**
	 * Retreive the serialized ACL object and
	 * return it.
	 * 
	 * We also need to test to see if the acl.xml
	 * model has been modified.
	 *
	 * @return object
	 */
	public function getAcl($xml=null)
	{
		return unserialize(stripcslashes($this->db->where(array('id' => 1))->get('acl')->current()->data));
	}
	
	/**
	 * Method for setting roles and inheritence
	 * (if there are any).
	 *
	 * @param	array	$array
	 * @return	bool	True/False
	 */
	public function setRole($array)
	{
		if(!is_array($array))
			die('A horrible death');
		
		self::$_acl	= unserialize($this->getAcl());
		
		foreach($array as $role => $inherit)
		{
			self::$_acl->addRole(new Acl_Role($role), $inherit);
		}
		
		return (count($this->saveAcl()) > 0) ? True : False;
	}
	
	/**
	 * Method for setting resources.
	 *
	 * @param	array	$array
	 * @return	bool	True/False
	 */
	public function setResource($array)
	{
		if(!is_array($array))
			die('A watery death!');
		
		self::$_acl = unserialize($this->getAcl());
		
		foreach($array as $resource)
		{
			self::$_acl->add(new Acl_Resource($resource));
		}
		
		return ($this->saveAcl() > 0) ? True : False;
	}
	
	/**
	 * Method sets the rule for a specified
	 * role & resource.
	 *
	 * @param	array	$array
	 * @return	bool	True/False
	 */
	public function setRule($array)
	{
		if(!is_array($array))
			die('An even more horrid death!');
		
		self::$_acl = unserialize($this->getAcl());
		
		foreach($array as $rule => $vals)
		{
			if($rule == 'deny')
			{
				self::$_acl->deny($vals['role'], $vals['resource']);
			} elseif ($rule == 'allow') {
				self::$_acl->allow($vals['role'], $vals['resource']);
			}
		}
		
		return ($this->saveAcl() > 0) ? True : False;
	}
	
	/**
	 * Method for saving and serializing the ACL object
	 * into the database table.
	 * 
	 * If the $acl param isn't set, the method will default
	 * to the static member self::$_acl.
	 *
	 * @param	object	$acl
	 * @return	int
	 */
	public function saveAcl($acl=null, $update=True)
	{
		if($update)
		{
			$stat = $this->db->update('acl', array('hash' => $this->chk_sum, 'data' => serialize(is_null($acl)?self::$_acl:$acl)), array('id' => 1));
		} else {
			$stat = $this->db->insert('acl', array('hash' => $this->chk_sum, 'data' => serialize(is_null($acl)?self::$_acl:$acl)));
		}
		
		return count($stat);
	}
}