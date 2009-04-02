<?php

$config['zend_acl'] = array
(
	'name'          => 'Zend ACL',
	'dir'           => 'zend_acl',
	'description'   => 'A Port of the Zend ACL Module',
	'notice_enable' => 'You should only enable this plugin if it is required
                        by other plugins. Continue enabling this plugin?',
	'notice_disable'=> 'Disable this plugin?',
	'version'       => '0.1.0',
	'dependencies'  => array
	(
		'core' => array('0.1.0'),
	)
);