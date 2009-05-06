<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'name' => array
	(
		'required' => 'Name is required.',
		'length' => 'Name needs to be between %s and %s characters.',
		'chars' => 'Name can only contain these characters: %s.',
	),
	'tag' => array
	(
		'required' => 'Tag is required.',
		'length' => 'Tag needs to be between %s and %s characters.',
		'item_available' => 'Tag is not unique',
	),
	'page_id' => array
	(
		'digit' => 'Invalid Page',
	),
	'parent_id' => array
	(
		'required' => 'Parent is required.',
		'digit' => 'Invalid Parent',
		'item_exists' => 'Parent does not exist.',
	),
	'anchor' => array
	(
		'chars' => 'Anchor can only contain these characters: %s.',
	),
);
