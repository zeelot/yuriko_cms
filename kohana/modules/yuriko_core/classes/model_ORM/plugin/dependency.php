<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Model_Plugin_Dependency extends ORM {

	protected $_belongs_to = array
	(
		'plugin' => array(),
		'depends_on' => array
		(
			'model' => 'plugin',
			'foreign_key' => 'depends_on',
		),
	);

	public function __get($column)
	{
		switch ($column) {
			case 'compatible_versions' OR 'incompatible_versions':
				return unserialize(parent::__get($column));
			default:
				return parent::__get($column);
		}
	}

	public function __set($column, $value)
	{
		switch ($column) {
			case 'compatible_versions' OR 'incompatible_versions':
				parent::__set($column, serialize($value));
				break;
			default:
				parent::__set($column, $value);
				break;
		}
	}

}