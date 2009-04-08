<?php

$config['debug_toolbar'] = array
(
	'name'          => 'Kohana Debug Toolbar',
	'dir'           => 'debug_toolbar',
	'description'   => 'A nice alternative to the Kohana Profiler',
	'notice_enable' => 'Enabling this module will add a debug toolbar
                        to all your pages, try to enable this only in testing
                        environments. Are you sure you want to enable this plugin?',
	'notice_disable'=> 'Disable the Debug Toolbal?',
	'version'       => '0.2.1',
	'dependencies'  => array
	(
		//none
	)
);
