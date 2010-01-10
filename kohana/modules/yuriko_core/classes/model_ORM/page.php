<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Model_Page extends ORM {

	protected $_has_many = array
	(
		'page_nodes' => array(),
		'page_settings' => array(),
		//@TODO: 'content_page_inheritances',
	);

	protected $_rules = array
	(
		'name' => array
		(
			'not_empty' => NULL,
			'$this::custom_rule'          => NULL,

		),
		'uri'  => array('not_empty' => NULL)
	);
	
	protected $_filters = array(TRUE => array('trim' => NULL));

	public function custom_rule()
	{
		return false;
	}

}