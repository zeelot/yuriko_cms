<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Node_Model extends ORM {

	protected $rules = array
	(
		'alias' => array('required'),
		'name' => array('required'),
		'content_id' => array('required', 'digit'),
		'content_type_id' => array('required', 'digit'),
	);

	protected $has_many = array
	(
		'content_pages_sections_nodes',
	);
	protected $belongs_to = array('content_type');

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


} // End Content Node Model