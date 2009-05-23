<?php

$config['simple_acl'] = array
(
	'name'          => 'Simple ACL',
	'dir'           => 'simple_acl',
	'description'   => 'A simple Router Based ACL',
	'notice_enable' => 'Enabling this plugin might lock you out of the
                        Admin Panel. Make sure you have an admin account
						before enabling this plugin.',
	'notice_disable'=> 'Disabling the Simple ACL plugin might make all
                        sections of your website accessible to unauthorized
                        users, are you sure you want to disable this plugin?',
	'version'       => '0.1.0',
	'dependencies'  => array
	(
		'core'     => array('0.1.0'),
		'auth'     => array('1.0.0'),
	)
);