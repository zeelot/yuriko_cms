<?php defined('SYSPATH') or die('No direct access');

// Remove the standard default route
unset($configuration['_default'], $config['_default']);

$config['profile'] = array
(
	'uri' => 'user/profile',

	'defaults' => array
	(
		'controller' => 'user',
		'method' => 'profile',
	),
);
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