<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'name' => array
	(
		'length'   => 'The Name field needs to be between 1 and 127 characters.',
		'chars'    => 'Invalid Characters in Name field.',
		'required' => 'The Name field is required.',
		'unique_name' => 'Name is taken.',
	),
	'alias' => array
	(
		'length'   => 'The Alias field needs to be between 1 and 127 characters.',
		'chars'    => 'Invalid Characters in Alias field.',
		'required' => 'The Alias field is required.',
		'unique_alias' => 'Alias is taken.',
	),
	'template' => array
	(
		'template_exists' => 'Invalid Template file.',
	),
	'content' => array
	(
		'required' => 'You need to enter some content.',
		'default'  => 'Invalid Input.',
	),
);
