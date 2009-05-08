<?php

$config['content_feed'] = array
(
	'name'          => 'YurikoCMS Feed Content',
	'dir'           => 'content_feed',
	'description'   => 'Adds the ability to create feed content for your pages, like rss feeds.',
	'notice_enable' => 'Are you sure you want to enable this plugin?',
	'notice_disable'=> 'Disable the Feed Content plugin?',
	'version'       => '0.1.0',
	'dependencies'  => array
	(
		'core'     => array('0.1.1'),
	)
);
