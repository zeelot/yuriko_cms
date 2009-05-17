<?php

$config['auth'] = array
(
	'name'          => 'Kohana Auth Module',
	'dir'           => 'auth',
	'description'   => 'Enables the Kohana Euth Module.  There are a few
                        alterations to the Model for Validation changes.',
	'notice_enable' => 'Are you sure you want to enable this plugin?',
	'notice_disable'=> 'Disable the Auth plugin? This could be a security
                        risk if you do not have an alernative authentication
                        plugin enabled.',
	'version'       => '1.0.0',
	'dependencies'  => array
	(
		'core'     => array('0.2.0'),
	),
);
