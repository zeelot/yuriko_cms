<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_Setting_Model extends ORM {

	public $has_one = array('theme');

	//create the initial settings when a user is created
	public function initialize($id)
	{

	}
	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('theme_id', 'required');

		return parent::validate($array, $save);
	}

} // End Auth User Setting Model