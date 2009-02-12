<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Page_Model extends ORM {

	protected $has_and_belongs_to_many = array
	(
		'sections'	=> 'content_sections'
	);

} // End Content Page Model