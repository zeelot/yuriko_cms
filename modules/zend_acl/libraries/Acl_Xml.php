<?php defined('SYSPATH') or die('No direct script access.');

class Acl_Xml_Core
{
	protected $xml;
	protected $xml_obj;
	
	/**
	 * Test to see if the ACL XML file exists, if so, load it!
	 *
	 * @param	varchar	$xml
	 */
	public function __construct($xml=null)
	{
		$this->xml = is_null($xml) ? config::item('acl.xml_model') : $xml;
		
		if(!file_exists($this->xml))
			throw new Kohana_User_Exception('Missing file', "The provided xml file: $this->xml could not be found");
		
		$this->xml_obj	= simplexml_load_file($this->xml);
	}
	
	/**
	 * Method readAcl takes the SimpleXMLObject and
	 * flattens it into a consumable array.
	 *
	 * @return array $items
	 */
	public function readAcl()
	{
		$items = array();
		
		foreach($this->xml_obj as $item => $val)
		{
			$items[$item] = (array) $val;
		}
		
		return $items;
	}
	
	/**
	 * Method buildAcl takes the flattened SimpleXMLObj
	 * and builds an Acl object from it; including rules.
	 *
	 * @return object $acl
	 */
	public function buildAcl()
	{
		$acl_arr	= self::readAcl();
		
		$acl		= new Acl;
		
		foreach($acl_arr as $group => $value)
		{
			switch(True)
			{
				case $group == 'aro'	:
					foreach($value as $role)
					{
						foreach($role as $agent)
						{
							$acl->addRole(new Acl_Role($agent));
						}
					}
					break;
					
				case $group == 'aco'	:
					foreach($value as $resource)
					{
						foreach($resource as $res)
						{
							$acl->add(new Acl_Resource($res));
						}
					}
					break;
					
				// This one will be a bit more complex, has our rule defs in it
				case $group == 'rules'	:
					foreach($value as $rules)
					{
						foreach($rules as $val)
						{
							foreach($val as $ruleKey => $ruleItem)
							{
								if($ruleKey == 'agent')
								{
									$object = $ruleItem;
								}
								
								if($ruleKey == 'allowed')
								{
									foreach($ruleItem as $ruleObject)
									{
										$acl->allow($object, $ruleObject);
									}
								}
								
								// We need to cleanup before we go tackling the denied AROs...
								unset($ruleObject);
								
								if($ruleKey == 'denied')
								{
									foreach($ruleItem as $ruleObject)
									{
										$acl->deny($object, $ruleObject);
									}
								}
							}
						}
					}
					break;
			}
		}
		
		return $acl;
	}
	
	/**
	 * Method writeAcl is responsible for taking
	 * input and either producing or modifying
	 * the current acl.xml model to reflect needed
	 * changes.
	 * 
	 * @return file	$xml
	 */
	public function writeAcl()
	{
		// Should use DOM for this, gives finer control...
	}
}