<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['views']['admin/templates/default'] = array
(
	'globals'			=> array
	(
		'960',			//the 960 css files
		'reset',
		'typography',
		'divcorners',
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/css/styles' => 100,
	),
);
$config['views']['templates/page/default'] = array
(
	'globals'			=> array
	(
		'reset',
		'960',
		'typography',
		'jquery',
		'divcorners',
		'roundcorners',
	),
	'scripts'			=> array
	(
		'themes/yuriko_cms/media/js/effects' => 100,
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/css/styles' => 100,
	),
);
$config['views']['templates/static/default'] = array
(
	'globals'			=> array
	(
		'reset',
		'960',
		'typography',
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/css/styles' => 100,
	),
);
/**
 * Basic Content Admin Section
 */
$config['views']['admin/content/basic/manage'] = array
(
	'globals'			=> array
	(
		'jquery',
		'markitup',
		'colorbox',
		'livequery',
	),
	'scripts'			=> array
	(
		'themes/default/media/js/markitup' => 100,
		'themes/yuriko_cms/media/js/effects' => 100,
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/colorbox/example1/colorbox-custom' => 100,
	),
);
$config['views']['admin/content/basic/create'] =
$config['views']['admin/content/basic/edit']   = array
(
	'globals'			=> array
	(
		'jquery',
		'markitup',
		'colorbox',
		'livequery',
	),
	'scripts'			=> array
	(
		'themes/default/media/js/markitup' => 100,
		'themes/yuriko_cms/media/js/effects' => 100,
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/colorbox/example1/colorbox-custom' => 100,
	),
);

/**
 * Admin Sections
 */
$config['views']['admin/content/navigation/manage']	=
$config['views']['admin/content/pages/manage']      =
$config['views']['admin/content/pages/edit']        =
$config['views']['admin/plugins/manage']    = array
(
	'globals'			=> array
	(
		'jquery',
		'colorbox',
	),
	'scripts'			=> array
	(
		'themes/yuriko_cms/media/js/effects' => 100,
	),
	'stylesheets'		=> array
	(
		'themes/yuriko_cms/media/colorbox/example1/colorbox-custom' => 100,
	),
);