<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Pages_Sections_Nodes_Model extends Auto_Modeler_ORM {

	/**
	 * This is my pivot table
	 *
	 */
	protected $table_name = 'content_pages_sections_nodes';

	protected $data = array
	(
		'id'         => '',
		'page_id'    => '',
		'section_id' => '',
		'node_id'    => '',
	);

	protected $rules = array
	(
		'page_id'    => array('required', 'digit'),
		'section_id' => array('required', 'digit'),
		'node_id'    => array('required', 'digit'),
	);

	protected $aliases = array
	(
		'section' => 'content_section',
		'page' => 'content_page',
		'node' => 'content_node',
	);
}