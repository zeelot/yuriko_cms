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
		'content_page_id'    => '',
		'content_section_id' => '',
		'content_node_id'    => '',
	);

	protected $aliases = array
	(
		'section' => 'content_section',
		'page' => 'content_page',
		'node' => 'content_node',
	);
}