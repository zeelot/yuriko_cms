SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `nodes`;
CREATE TABLE IF NOT EXISTS `nodes` (
  `id` tinyint(11) unsigned NOT NULL auto_increment,
  `node_route_id` tinyint(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `nodes` (`id`, `node_route_id`) VALUES
(1, 1),
(2, 1);

DROP TABLE IF EXISTS `node_routes`;
CREATE TABLE IF NOT EXISTS `node_routes` (
  `id` tinyint(11) unsigned NOT NULL auto_increment,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

INSERT INTO `node_routes` (`id`, `name`) VALUES
(1, 'yuriko_admin');

DROP TABLE IF EXISTS `node_route_parameters`;
CREATE TABLE IF NOT EXISTS `node_route_parameters` (
  `id` tinyint(11) unsigned NOT NULL auto_increment,
  `key` varchar(127) collate utf8_unicode_ci NOT NULL,
  `value` varchar(127) collate utf8_unicode_ci NOT NULL,
  `node_id` tinyint(11) unsigned default NULL,
  `page_node_id` tinyint(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `node_route_parameters` (`id`, `key`, `value`, `node_id`, `page_node_id`) VALUES
(1, 'action', 'navigation', 1, NULL),
(2, 'action', 'dashboard', 2, NULL);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `permalink` varchar(127) collate utf8_unicode_ci NOT NULL,
  `template` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `pages` (`id`, `name`, `permalink`, `template`) VALUES
(1, 'Home', 'home', 'default'),
(2, 'Admin Dashboard', 'admin', 'admin/default');

DROP TABLE IF EXISTS `page_nodes`;
CREATE TABLE IF NOT EXISTS `page_nodes` (
  `id` tinyint(11) unsigned NOT NULL auto_increment,
  `page_id` tinyint(11) unsigned NOT NULL,
  `node_id` tinyint(11) unsigned NOT NULL,
  `section` varchar(125) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `page_nodes` (`id`, `page_id`, `node_id`, `section`) VALUES
(1, 2, 1, 'Side Panel'),
(2, 2, 2, 'Main Content');
