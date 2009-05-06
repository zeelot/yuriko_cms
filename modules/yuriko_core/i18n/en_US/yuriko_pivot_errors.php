<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'content_page_id' => array
	(
		'required'   => 'content_page_id is required.',
		'digit'    => 'content_page_id should be a digit.',
		'page_exists' => 'Invalid Page.',
		'pivot_unique' => 'Content is already on this page.',
	),
	'content_node_id' => array
	(
		'required'   => 'content_node_id is required.',
		'digit'    => 'content_node_id should be a digit.',
		'node_exists' => 'Invalid Node.',
	),
	'section' => array
	(
		'required' => 'Section is required.',
		'digit' => 'Section should be a digit.',
	),
	'view' => array
	(
		'view_exists' => 'Invalid View.',
	),
);
