<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['groups'] = array
(
	'login'		=> 1,
	'admin'		=> 2,
);

$config['permissions'] = array(
   "owner_read"   => 256,
   "owner_write"  => 128,
   "owner_delete" => 64,
   "group_read"   => 32,
   "group_write"  => 16,
   "group_delete" => 8,
   "other_read"   => 4,
   "other_write"  => 2,
   "other_delete" => 1
);