<?php
/*
 * Global assets are the ones available to all themes.
 * A theme only has to specify the group name and all the assets in the
 * group will be automatically added.
 *
 * These definitions CAN be overwritten in the themes but really shouldn't be.
 * This makes it easier to keep jquery up to date since the theme won't know
 * which version it is including, the theme includes 'jquery' and the app
 * serves the latest.
 *
 * For compatibility issues if the theme needs a different jquery, it can
 * replace it with it's own 'local' version.
 *
 * Example to add jquery to the page:
 * assets::add('jquery')
 *
 * Weight is to keep the order in which scripts are loaded.
 * JQuery should have a lower weight than anything that uses JQuery
 *
 * Also the themed styles.css file usually loads last to overwrite defaults
 * so give it a high weight.
 * 
 */
$config['global'] = array
(
	'reset'	=> array
	(
		'weight'		=> 0,
		'stylesheets'	=> array
		(
			'media/css/reset',
		),
	),
	'typography'	=> array
	(
		'weight'		=> 1,
		'stylesheets'	=> array
		(
			'media/css/typography',
		),
	),
	'jquery'	=> array
	(
		'weight'		=> 0,
		'scripts'		=> array
		(
			'media/js/jquery-1.3.2.min',
		),
	),
	'livequery' => array
	(
		'weight'		=> 2,
		'scripts'		=> array
		(
			'media/js/jquery.livequery',
		),
	),
	'markitup'	=> array
	(
		'weight'		=> 5, //has to load after jquery
		'stylesheets'	=> array
		(
			'media/editor/markitup/sets/markdown/style',
			'media/editor/markitup/skins/markitup/style',
		),
		'scripts'		=> array
		(
			'media/editor/markitup/jquery.markitup',
		),
	),
	'thickbox'	=> array
	(
		'weight'		=> 5, //has to load after jquery
		'stylesheets'	=> array
		(
			'media/thickbox/thickbox',
		),
		'scripts'		=> array
		(
			'media/thickbox/thickbox',
		),
	),
	'colorbox'	=> array
	(
		'weight'		=> 5, //has to load after jquery
		'stylesheets'	=> array
		(
			'media/colorbox/colorbox',
		),
		'scripts'		=> array
		(
			'media/colorbox/jquery.colorbox-min',
		),
	),
	'960'		=> array
	(
		'weight'		=> 0,
		'stylesheets'	=> array
		(
			'media/css/960',
		),
	),
	'debug'		=> array
	(
		'weight'		=> 0,
		'stylesheets'	=> array
		(
			'media/css/kohana',
		),
	),
);
