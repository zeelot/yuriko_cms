<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'index',
		'directory'  => 'yuriko/admin',
	));