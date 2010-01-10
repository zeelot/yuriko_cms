<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * site_settings table is a Key/Value DB table for storing general site settings.
 * It can be used by other plugins like the theme plugin.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

class Model_Site_Setting extends ORM {

	protected $_rules = array
	(
		'key' => array('not_empty' => NULL),
		'value' => array('not_empty' => NULL)
	);

	protected $_filters = array
	(
		TRUE => array('trim' => NULL, 'security::xss_clean' => NULL),
	);


	public function check()
	{
		if ( ! isset($this->_validate))
		{
			// Initialize the validation object
			$this->_validate();
		}

		// add custom rules to $this->_validate();
		event::run('yuriko_core.model.validate.site_settings', $this->_validate);

		return parent::check();
	}

}