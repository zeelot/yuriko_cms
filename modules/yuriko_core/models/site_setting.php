<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Site_Setting_Model extends ORM {

	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'key';
		}

		return parent::unique_key($id);
	}
	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('key', 'required', 'length[1,50]', 'chars[a-zA-Z 0-9_./]')
			->add_rules('value', 'required', 'length[1,255]', 'chars[a-zA-Z 0-9_./]');
		return parent::validate($array, $save);
	}
}
