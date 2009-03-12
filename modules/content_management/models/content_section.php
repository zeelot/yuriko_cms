<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Section_Model extends Auto_Modeler_ORM {

	protected $table_name = 'content_sections';

	protected $data = array
	(
		'id'   => '',
		'name' => ''
	);

	protected $aliases = array
	(
		'pages'   => 'content_pages_sections_nodes',
		'nodes'   => 'content_pages_sections_nodes',
		'objects' => 'content_pages_sections_nodes'
		
	);

	protected $has_many = array
	(
		'content_pages_sections_nodes',
	);

} // End Content Section Model