<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

//check if this plugin is loaded or if this is the installer
if (plugin::models('Themes'))
{
	//load the current theme
	$theme = ORM::factory('site_setting')
		->where('key', '=', 'theme')
		->find();
	if ($theme->loaded())
	{

	}
	else
	{
		//use default theme
		Kohana::modules(array_merge(array
		(
			'themes/default' => DOCROOT.'themes/default',
		), Kohana::modules()));
	}
}