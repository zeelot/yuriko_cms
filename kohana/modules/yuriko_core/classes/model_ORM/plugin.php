<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Model_Plugin extends ORM {

	protected $_has_many = array
	(
		'dependencies' => array
		(
			'model'       => 'plugin_dependency',
			'foreign_key' => 'plugin_id',
		),
		'used_by' => array
		(
			'model'       => 'plugin_dependency',
			'foreign_key' => 'depends_on',
		),
	);

	public function __get($column)
	{
		switch ($column) {
			case 'installer':
				return (bool) parent::__get('installer');
			default:
				return parent::__get($column);
		}
	}

	public function __set($column, $value)
	{
		switch ($column) {
			case 'installer':
				parent::__set($column, (int) $value);
				break;
			default:
				parent::__set($column, $value);
				break;
		}
	}
}