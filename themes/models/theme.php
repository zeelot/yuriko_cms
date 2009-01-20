<?php defined('SYSPATH') OR die('No direct access allowed.');

class Theme_Model extends ORM {

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[4,127]')
			->add_rules('dir', 'required', 'length[2,75]', 'chars[a-zA-Z0-9_.]');

		return parent::validate($array, $save);
	}

} // End Auth User Profile Model