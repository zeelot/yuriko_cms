<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Section_Model extends ORM {

	protected $has_many = array
	(
		'content_pages_sections_nodes',
	);

} // End Content Section Model