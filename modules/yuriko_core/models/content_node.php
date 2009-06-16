<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
* @package    YurikoCMS
* @author     Lorenzo Pisani - Zeelot
* @license    http://yurikocms.com/license
*/

class Content_Node_Model extends ORM {

	protected $has_many = array
	(
		'content_pivots',
		'content_arguments'
	);
	protected $belongs_to = array('plugin');

	public function validate(array & $array, $save = FALSE)
	{
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required')
			->add_rules('alias', 'required')
			->add_rules('content_id', 'required', 'digit')
			->add_rules('plugin_id', 'required', 'digit');
		//if this is a new page the name and alias should be unique
		if(!$this->loaded)
		{
			$array
				->add_rules('alias', array($this, 'unique_alias'));
		}
		return parent::validate($array, $save);
	}
	public function unique_key($id)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'alias';
		}
		return parent::unique_key($id);
	}

	public function find_content()
	{
		//return the model of the content related to this node
		return ORM::factory($this->content_type->name.'_content', $this->content_id);
	}

	public function render()
	{
		echo View::factory('templates/node/'.$this->template)
			->set('node', $this->find_content());
	}


} // End Content Node Model