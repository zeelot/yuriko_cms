<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
	'integration'           => TRUE,        // Enable/Disable Smarty integration
	'templates_ext'         => 'tpl',
	'global_templates_path' => APPPATH.'views/',
	'cache_path'            => APPPATH.'cache/smarty_cache/',
	'compile_path'          => APPPATH.'cache/smarty_compile/',
	'configs_path'          => APPPATH.'views/smarty_configs/',
	'plugins_path'          => APPPATH.'views/smarty_plugins/',
	'debug_tpl'             => APPPATH.'views/debug.tpl',
	'debugging_ctrl'        => FALSE,
	'debugging'             => TRUE,
	'caching'               => FALSE,
	'force_compile'         => FALSE,
	'security'              => TRUE,
	'secure_dirs'           => array         // Smarty secure directories
	(
        MODPATH.'smarty/views'
	),
	'if_funcs'              => array         // We'll allow these functions in if statement
	(
		'array',  'list',     'trim',       'isset', 'empty',
		'sizeof', 'in_array', 'is_array',   'true',  'false',
		'null',   'reset',    'array_keys', 'end',   'count'
	),
	'modifier_funcs'        => array         // We'll allow these modifiers
	(
		'sprintf', 'count'
	),

	'post_filters'          => array
	(
	),
	'output_filters'        => array
	(
		'trimwhitespace'
	),
	'pre_filters'           => array
	(
	),
	'escape_exclude_list'   => array
	(
	),
);
