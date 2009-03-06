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
		'groups'			=> array
		/**
		 * these are predefined groups outside of themes
		 * you can find the list in modules/assets/config/assets.php
		 *
		 * This makes it easier for a theme to use common libs for example:
		 * 960 or 960gs
		 * common typography stuff
		 * the latest jquery or mootools or any js lib (as long as it's listed
		 * in the assets config and is in the global media dir
		 *
		 */
		(
			'960',			//the 960 css files
			'common',		//the reset and typography stuff
		),
		/*
		 * These can be specific theme css files or even global css files
		 * but have to be defined by their full path
		 */
		'stylesheets'		=> array
		(
			/**
			 * you can also use Kohana::config('themes.active.dir') to include
			 * the themes css file automatically like so
			 * 'themes/'.Kohana::config('themes.active.dir').'/media/css/styles
			 */
			'themes/default/media/css/styles',
		),
		'scripts'			=> array
		(

		),
	),
	'content/admin/content/edit'		=> array
	(
		'groups'			=> array
		(
			'jquery',
			'editor',
		),
		'stylesheets'		=> array
		(

		),
		'scripts'			=> array
		(

		),
	),
);
