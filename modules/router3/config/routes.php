<?php defined('SYSPATH') or die('No direct access');

// Remove the standard default route
unset($configuration['_default'], $config['_default']);

$config['default'] = array
(
	'uri' => ':controller/:method/:id',

	'defaults' => array
	(
		'controller' => 'welcome',
		'method' => 'index',
		'id' => FALSE,
	),
);