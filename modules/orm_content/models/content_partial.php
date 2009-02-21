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
} // End Content Partial Model