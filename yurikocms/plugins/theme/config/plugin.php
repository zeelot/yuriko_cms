<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

return array
(
	'theme' => array
	(
		'version'       => '0.2.0',
		'installer'     => TRUE,
		'arguments_key' => 'theme',
		'dependencies' => array
		(
			'core' => array
			(
				'min' => '0.2.0',
			),
		),
		''
	),
);