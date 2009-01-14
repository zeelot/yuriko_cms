<?php defined('SYSPATH') OR die('No direct access allowed.');

/*

CREATE TABLE `locations` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `created` int(10) unsigned NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(127) NOT NULL,
  `link` varchar(127) NOT NULL,
  `lon` float(10,6) NOT NULL,
  `lat` float(10,6) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_ll` (`lon`,`lat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

*/

class Location_Model extends ORM {

	// Exciting!

} // End Location Model