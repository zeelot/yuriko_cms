<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugin extends Sprig {

	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(array(
				'unique' => TRUE,
				'max_length' => 32,
			)),
			'title' => new Sprig_Field_Char(array(
				'max_length' => 64,
			)),
			'status' => new Sprig_Field_Enum(array(
				'default' => 'uninstalled',
				'choices' => array
				(
					'uninstalled',
					'disabled',
					'enabled',
				)
			)),
		);
	}

} // End Plugin