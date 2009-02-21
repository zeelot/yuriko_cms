<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Section_Model extends ORM {

	protected $has_and_belongs_to_many = array
	(
		'pages'		=> 'content_pages',
		'partials'	=> 'content_partials'
	);

} // End Content Section Model