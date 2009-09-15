<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * This module should just make developing easier.
 * For now I will use it to create the basic yuriko admin pages
 * OMG PROCEDURAL SUX!! THIS TOOK ME SO LONG TO MAKE!! BLAH!!!
 *
 * @package    YurikoCMS
 * @author     Lorenzo Pisani - Zeelot
 * @copyright  (c) 2008-2009 Lorenzo Pisani
 * @license    http://yurikocms.com/license
 */

DB::query(5, 'TRUNCATE `node_route_parameters`')->execute();
DB::query(5, 'TRUNCATE `nodes`')->execute();
DB::query(5, 'TRUNCATE `page_nodes`')->execute();
DB::query(5, 'TRUNCATE `pages`')->execute();
DB::query(5, 'TRUNCATE `node_routes`')->execute();

//ROUTE
$route = ORM::factory('node_route');
$route->name = 'yuriko_admin';
$route->save();

//MAIN/INDEX NODE
$index_node = ORM::factory('node');
$index_node->node_route_id = $route->id;
$index_node->save();
//MAIN/INDEX NODE ROUTE PARAMS
$param = ORM::factory('node_route_parameter');
$param->key = 'controller';
$param->value = 'main';
$param->node_id = $index_node->id;
$param->save();
$param = ORM::factory('node_route_parameter');
$param->key = 'action';
$param->value = 'index';
$param->node_id = $index_node->id;
$param->save();
//MAIN/NAV NODE
$nav_node = ORM::factory('node');
$nav_node->node_route_id = $route->id;
$nav_node->save();
//MAIN/NAV NODE ROUTE PARAMS
$param = ORM::factory('node_route_parameter');
$param->key = 'controller';
$param->value = 'main';
$param->node_id = $nav_node->id;
$param->save();
$param = ORM::factory('node_route_parameter');
$param->key = 'action';
$param->value = 'nav';
$param->node_id = $nav_node->id;
$param->save();
//ADMIN HOMEPAGE
$admin_page = ORM::factory('page');
$admin_page->permalink = 'admin';
$admin_page->save();
//ADMIN HOMEPAGE NODES
$admin_page_index_node = ORM::factory('page_node');
$admin_page_index_node->page_id = $admin_page->id;
$admin_page_index_node->node_id = $index_node->id;
$admin_page_index_node->section = 'Main Content';
$admin_page_index_node->save();
$admin_page_nav_node = ORM::factory('page_node');
$admin_page_nav_node->page_id = $admin_page->id;
$admin_page_nav_node->node_id = $nav_node->id;
$admin_page_nav_node->section = 'Side Panel';
$admin_page_nav_node->save();
//MAIN/SITE_SETTINGS NODE
$site_settings_node = ORM::factory('node');
$site_settings_node->node_route_id = $route->id;
$site_settings_node->save();
//MAIN/SITE_SETTINGS NODE ROUTE PARAMS
$param = ORM::factory('node_route_parameter');
$param->key = 'controller';
$param->value = 'main';
$param->node_id = $site_settings_node->id;
$param->save();
$param = ORM::factory('node_route_parameter');
$param->key = 'action';
$param->value = 'site_settings';
$param->node_id = $site_settings_node->id;
$param->save();
//ADMIN SITE_SETTINGS PAGE
$site_settings_page = ORM::factory('page');
$site_settings_page->permalink = 'admin/site_settings';
$site_settings_page->save();
//ADMIN SITE_SETTINGS PAGE NODES
$site_settings_page_settings_node = ORM::factory('page_node');
$site_settings_page_settings_node->page_id = $site_settings_page->id;
$site_settings_page_settings_node->node_id = $site_settings_node->id;
$site_settings_page_settings_node->section = 'Main Content';
$site_settings_page_settings_node->save();
$site_settings_page_nav_node = ORM::factory('page_node');
$site_settings_page_nav_node->page_id = $site_settings_page->id;
$site_settings_page_nav_node->node_id = $nav_node->id;
$site_settings_page_nav_node->section = 'Side Panel';
$site_settings_page_nav_node->save();