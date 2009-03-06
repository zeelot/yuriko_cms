<?php

$config['groups'] = array
(
	'common'	=> array
	(
		'stylesheets'	=> array
		(
			'media/css/reset',
			'media/css/styles',
			'media/css/typography',
		),
	),
	'jquery'	=> array
	(
		'scripts'	=> array
		(
			'media/js/jquery-1.3.2.min',
		),
	),
	/*
	 * assets::add_common('editor'); will add all these assets to the page
	 */
	'editor'	=> array
	(
		'scripts'		=> array
		(
			'media/editor/markitup/jquery.markitup',
			'media/editor/markitup/sets/markdown/set',
		),

		'stylesheets'	=> array
		(
			'media/editor/markitup/sets/markdown/style',
			'media/editor/markitup/skins/markitup/style',
		),
	),
	//adds the 960 grid system files to the page
	'960'		=> array
	(
		'stylesheets'	=> array
		(
			'media/css/960',
		),
	),
	//the css for the kohana profiler in a neat css file
	'debug'		=> array
	(
		'stylesheets'	=> array
		(
			'media/css/kohana',
		),
	),
);
