<?php
/*
 * Associates a view with a group of assets to be included when that view is used.
 * This should also cascade with the default theme so each new theme only has
 * to associate assets for views if they need different ones
 * 
 * For example a certain theme might use mootools instead of jquery for their
 * effects.  Or a different editor.
 *
 * The goal of this config is to keep assets out of the controller code.
 * Because I believe the designer should be in charge of JS and CSS and the
 * designer should NOT be allowed in the controller!
 *
 */
$config['views'] = array(); //DO NOT DO THIS IN OTHER THEMES!!
$config['views']['admin/templates/default'] = array
(
	'globals'			=> array
	(
		'960',			//the 960 css files
		'common',		//the reset and typography stuff
	),
	'stylesheets'		=> array
	(
		'themes/default/media/css/styles' => 100,
	),
);
$config['views']['templates/page/default'] = array
(
	'globals'			=> array
	(
		'960',			//the 960 css files
		'common',		//the reset and typography stuff
	),
	'stylesheets'		=> array
	(
		'themes/default/media/css/styles' => 100,
	),
);
/**
 * Basic Content Admin Section
 */
$config['views']['admin/basic/manage'] = array
(
	'globals'			=> array
	(
		'jquery',
		'markitup',
		'thickbox',
		'livequery',
	),
	'scripts'			=> array
	(
		'themes/default/media/js/markitup' => 100,
	),
);
$config['views']['admin/basic/create'] =
$config['views']['admin/basic/edit']   = array
(
	'globals'			=> array
	(
		'jquery',
		'markitup',
		'livequery',
	),
	'scripts'			=> array
	(
		'themes/default/media/js/markitup' => 100,
	),
);

/**
 * Admin Sections
 */
$config['views']['admin/navigation/manage']	=
$config['views']['admin/pages/manage']      =
$config['views']['admin/pages/edit']        =
$config['views']['admin/plugins/manage']    = array
(
	'globals'			=> array
	(
		'jquery',
		'thickbox',
	),
);
