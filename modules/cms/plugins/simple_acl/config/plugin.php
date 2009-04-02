<?php

$config['simple_acl'] = array
(
	'name'          => 'Simple ACL',
	'dir'           => 'simple_acl',
	'description'   => 'A simple Router Based ACL',
	'notice_enable' => 'Enabling this module might lock you out of the
                        Admin Panel.',
	'notice_disable'=> 'Disabling the Simple ACL Module might make all
                        sections of your website accessible to unauthorized
                        users, are you sure you want to disable this plugin?',
	'version'       => '0.1.0',
	'dependencies'  => array
	(
		'core'     => array('0.1.0'),
		'zend_acl' => array('0.1.0', '0.2.0'),//this means zend_acl must be between these 2 versions
	)
);