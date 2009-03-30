<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Pages_Sections_Nodes_Model extends ORM {

	/**
	 * This is my pivot table
	 *
	 */
	protected $belongs_to = array
	(
		'content_page',
		'content_section',
		'content_node',
	);
}