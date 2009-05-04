<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Content_Page_Inheritance_Model extends ORM {

	protected $belongs_to = array
	(
		'content_page',
		'inherited_page' => 'content_page',
	);
}