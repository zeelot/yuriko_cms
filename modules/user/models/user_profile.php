<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Profile_Model extends ORM {

	public $has_one = array('theme');

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('theme_id', 'required')
			->add_rules('name', 'length[4,127]')
			->add_rules('location', 'length[4,127]')
			->add_rules('email', 'required', 'length[4,127]', 'valid::email')
			->add_rules('msn', 'length[4,127]', 'valid::email')
			->add_rules('yahoo', 'length[4,127]')
			->add_rules('aim', 'length[4,127]')
			->add_rules('skype', 'length[4,127]');

		return parent::validate($array, $save);
	}

} // End Auth User Profile Model