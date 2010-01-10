<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

/**
 * Add all the enabled plugins to the modules
 */
$enabled = Sprig::factory('plugin', array('status' => 'enabled'))
	->load(NULL, FALSE);

$modules = Kohana::modules();
foreach ($enabled as $plugin)
{
	$modules[$plugin->name] = DOCROOT.'yurikocms/plugins/'.$plugin->name;
}

class testclass{
	public static function foobar()
	{
		echo 'hello';
	}
}

Event::instance('yuriko_core.init.loading_plugins')
	//->callback(array('testclass', 'foobar'))
	->bind('modules', $modules)
	->execute();

Kohana::modules($modules);

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