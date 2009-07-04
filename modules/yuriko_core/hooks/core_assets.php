<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This file can be used to define various assets using the assets helper.
 * Theme developers can create a theme_assets.php hook and do a similar thing.
 *
 * The assets helper has methods for merging and replacing definitions.
 *
 * The order is important.
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

//define groups for css files
assets::define_css_group('reset',array('media/css/reset'));
assets::define_css_group('typography',array('media/css/typography'));
assets::define_css_group('960',array('media/css/960'));
assets::define_css_group('main',array('media/css/styles'));
assets::define_css_group('debug',array('media/css/kohana'));
assets::define_css_group('markitup',array
	(
		'media/editor/markitup/skins/markitup/style',
		'media/editor/markitup/sets/markdown/style',
	));

//define groups for js files
assets::define_js_group('jquery',array('media/js/jquery-1.3.2.min'));
assets::define_js_group('livequery',array('media/js/jquery.livequery'));
assets::define_js_group('markitup',array('media/editor/markitup/jquery.markitup'));
assets::define_js_group('markitup-loader',array('media/js/markitup-loader'));


/**
 * define dependencies for views
 *
 * usage:
 * assets::define_css_dependency(array(views),array(css groups))
 */

assets::define_css_dependency
(
	array
	(
		'templates/page/default',
		'templates/static/default',
		'admin/templates/default',
	),
	array('reset','960','typography','main')
);

assets::define_css_dependency
(
	array('admin/content/basic/form'),
	array('markitup')
);
assets::define_js_dependency
(
	array('admin/content/basic/form'),
	array('jquery', 'markitup', 'markitup-loader')
);

assets::define_js_dependency
(
	array
	(
		'admin/content/navigation/manage',
		'admin/content/pages/manage',
		'admin/content/pages/edit',
		'admin/plugins/manage',
	),
	array('jquery')
);