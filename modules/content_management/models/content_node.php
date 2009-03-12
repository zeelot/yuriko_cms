<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Node_Model extends Auto_Modeler_ORM {

	protected $table_name = 'content_nodes';

	protected $data = array
	(
		'id'   => '',
		'name' => ''
	);

	protected $aliases = array
	(
		'page'    => 'content_pages_sections_nodes',
		'section' => 'content_pages_sections_nodes',
		'objects' => 'content_pages_sections_nodes',
	);

	protected $has_many = array
	(
		'content_pages_sections_nodes',
	);


} // End Content Node Model