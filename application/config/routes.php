<?php defined('SYSPATH') or die('No direct access');

// Remove the standard default route
unset($configuration['_default'], $config['_default']);

$config['user'] = array
(
	'uri' => 'user/:method',
	'allowed_roles' => array
	(
		'login',
		'admin',
	),
	'defaults' => array
	(
		'controller' => 'user',
		'method' => 'profile',
	),
);

$config['admin'] = array
(
	'uri' => 'admin/:controller/:method/:id/:ad',
	'allowed_roles' => NULL,
	'prefix' => array('controller' => 'admin_'),
	'defaults' => array
	(
		'controller' => 'main',
		'method' => 'home',
		'id' => FALSE,
		'ad' => FALSE,
	),
);
$config['nodes'] = array
(
	'uri' => 'node/:alias',
	'allowed_roles' => NULL,
	'defaults' => array
	(
		'controller' => 'pages',
		'method' => 'load_node',
		'alias' => FALSE,
	),
	'regex' => array
	(
		'alias' => '.*'
	),
);
$config['pages'] = array
(
	'uri' => ':alias',
	'allowed_roles' => NULL,
	'defaults' => array
	(
		'controller' => 'pages',
		'method' => 'load',
		'alias' => 'home',
	),
	'regex' => array
	(
		'alias' => '.*'
	),
);
$config['default'] = array
(
	'uri' => ':controller/:method/:id',
	'allowed_roles' => NULL,
	'defaults' => array
	(
		'controller' => 'main',
		'method' => 'home',
		'id' => FALSE,
	),
);