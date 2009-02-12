<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Partial_Model extends ORM {

	/**
	 * Schema:
	 * name			- name of the partial
	 * alias		- alias for ajax calls and such
	 * type			- type of partial (static, navigation, gallery)
	 * module_id	- the id of the item (gallery.id)
	 */

	protected $has_and_belongs_to_many = array
	(
		'sections'		=>'content_sections',
	);
	protected $has_one = array
	(
		//dynamically added based on type of partial
		'module'	=> NULL,
	);

	public function __get($column)
	{
		if ( ! array_key_exists($column, $this->object))
		{
			if($column == $this->type)
			{
				//switch which module this model is for
				$this->has_one['module'] = 'content_'.$column;
				return parent::__get('module');
			}
		}
		return parent::__get($column);
	}
} // End Content Partial Model