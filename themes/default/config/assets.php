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
$config['views'] = array
(
	'template/default'		=> array
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
		'scripts'			=> array
		(

		),
	),
	'content/admin/content/edit'		=> array
	(
		'globals'			=> array
		(
			'jquery',
			'markitup',
		),
	),
);
