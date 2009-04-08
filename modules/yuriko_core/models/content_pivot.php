<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Pivot_Model extends ORM {

	/**
	 * This is my pivot table that contains pages, nodes, and sections
	 *
	 */
	protected $belongs_to = array
	(
		'content_page',
		'content_node',
	);
}