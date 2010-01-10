<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

// Add all the enabled plugins to the modules
$enabled = Sprig::factory('plugin', array('status' => 'enabled'))
	->load(NULL, FALSE);

$modules = Kohana::modules();

// Start with the default template at the top
$array = array('default_theme' => DOCROOT.'yurikocms/themes/default');

foreach ($enabled as $plugin)
{
	$array[$plugin->name] = DOCROOT.'yurikocms/plugins/'.$plugin->name;
}

Event::instance('yuriko_core.init.loading_plugins')
	->bind('modules', $modules)
	->execute();

Kohana::modules($array + $modules);

// Clean up
unset($modules, $enabled);

/**
 * Setup the YurikoCMS page route, this is a catch all route that any
 * custom routes need to preceed.
 */
Route::set('page', '(<uri>)', array
	(
		'uri' => '.*',
	))
	->defaults(array(
		'controller' => 'page',
		'action'     => 'index',
		'directory'  => 'yuriko',
	));