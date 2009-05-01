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
	'uri' => 'admin/:controller/:method/:id',
	'allowed_roles' => array
	(
		'admin',
	),
	'prefix' => array('controller' => 'admin_'),
	'defaults' => array
	(
		'controller' => 'main',
		'method' => 'home',
		'id' => FALSE,
	),
	'regex' => array
	(
		'id' => '.*'
	),
);
/*
 * @TODO: these two routes need a way to detect segments.
 * This will be needed for the different content types like blogs
 * or wiki
 */
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