SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `basic_contents`;
CREATE TABLE IF NOT EXISTS `basic_contents` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `node_id` int(11) unsigned NOT NULL,
  `format_id` int(11) unsigned NOT NULL default '1',
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  `name` varchar(125) collate utf8_unicode_ci NOT NULL,
  `content` longtext collate utf8_unicode_ci NOT NULL,
  `html` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `content_formats`;
CREATE TABLE IF NOT EXISTS `content_formats` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `content_formats` (`id`, `name`) VALUES
(2, 'html'),
(1, 'markdown');

DROP TABLE IF EXISTS `content_nodes`;
CREATE TABLE IF NOT EXISTS `content_nodes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `content_type_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(127) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

INSERT INTO `content_nodes` (`id`, `content_type_id`, `content_id`, `name`, `alias`) VALUES
(1, 2, 1, 'root', 'navigation/root');

DROP TABLE IF EXISTS `content_pages`;
CREATE TABLE IF NOT EXISTS `content_pages` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `alias` varchar(127) collate utf8_unicode_ci NOT NULL,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `template` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  `locked` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

INSERT INTO `content_pages` (`id`, `alias`, `name`, `template`, `locked`) VALUES
(1, 'home', 'Home', 'default', 0);

DROP TABLE IF EXISTS `content_page_inheritances`;
CREATE TABLE IF NOT EXISTS `content_page_inheritances` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `content_page_id` int(11) unsigned NOT NULL,
  `inherited_page_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`content_page_id`,`inherited_page_id`,`id`),
  KEY `pages_has_inheritances_FKIndex2` (`inherited_page_id`),
  KEY `page_inheritances_FKIndex2` (`content_page_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `content_pivots`;
CREATE TABLE IF NOT EXISTS `content_pivots` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `content_page_id` int(11) unsigned NOT NULL,
  `content_node_id` int(11) unsigned NOT NULL,
  `section` int(11) NOT NULL,
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  PRIMARY KEY  (`id`),
  KEY `has_nodes_FKIndex2` (`content_node_id`),
  KEY `has_pages_FKIndex2` (`content_page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `content_types` (`id`, `name`) VALUES
(1, 'basic'),
(2, 'navigation');

DROP TABLE IF EXISTS `navigation_contents`;
CREATE TABLE IF NOT EXISTS `navigation_contents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `node_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL default '0' COMMENT 'if this is set, the item becomes a link to the page using its alias',
  `level` int(11) NOT NULL,
  `lft` tinyint(10) NOT NULL,
  `rgt` tinyint(10) NOT NULL,
  `tag` varchar(255) collate utf8_unicode_ci NOT NULL,
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `anchor` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `navigation_contents` (`id`, `node_id`, `page_id`, `level`, `lft`, `rgt`, `tag`, `view`, `name`, `anchor`) VALUES
(1, 1, 0, 0, 1, 2, 'root', 'default', 'root', NULL);

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `dir` varchar(127) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `dependencies` text collate utf8_unicode_ci,
  `notice_enable` text collate utf8_unicode_ci,
  `notice_disable` text collate utf8_unicode_ci,
  `enabled` binary(1) NOT NULL default '0',
  `version` varchar(10) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `dir` (`dir`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `plugins` (`id`, `name`, `dir`, `description`, `dependencies`, `notice_enable`, `notice_disable`, `enabled`, `version`) VALUES
(1, 'Zend ACL', 'zend_acl', 'A Port of the Zend ACL Module', 'a:1:{s:4:"core";a:1:{i:0;s:5:"0.1.0";}}', 'You should only enable this plugin if it is required\n                        by other plugins. Continue enabling this plugin?', 'Disable this plugin?', '0', '0.1.0'),
(2, 'Simple ACL', 'simple_acl', 'A simple Router Based ACL', 'a:2:{s:4:"core";a:1:{i:0;s:5:"0.1.0";}s:8:"zend_acl";a:2:{i:0;s:5:"0.1.0";i:1;s:5:"0.2.0";}}', 'Enabling this plugin might lock you out of the\n                        Admin Panel. Make sure you have an admin account\n						before enabling this plugin.', 'Disabling the Simple ACL plugin might make all\n                        sections of your website accessible to unauthorized\n                        users, are you sure you want to disable this plugin?', '0', '0.1.0'),
(3, 'Kohana Debug Toolbar', 'debug_toolbar', 'A nice alternative to the Kohana Profiler', 'a:0:{}', 'Enabling this module will add a debug toolbar\n                        to all your pages, try to enable this only in testing\n                        environments. Are you sure you want to enable this plugin?', 'Disable the Debug Toolbal?', '1', '0.2.1'),
(4, 'YurikoCMS Navigation Content', 'content_navigation', 'Adds the ability to create navigation content for your pages', 'a:1:{s:4:"core";a:1:{i:0;s:5:"0.1.0";}}', 'Are you sure you want to enable this plugin?', 'Disable the Navigation Content plugin?', '1', '0.1.0'),
(5, 'YurikoCMS Basic Content', 'content_basic', 'Adds the ability to create basic text content for your pages', 'a:1:{s:4:"core";a:1:{i:0;s:5:"0.1.0";}}', 'Are you sure you want to enable this plugin?', 'Disable the Basic Content plugin?', '1', '0.1.0');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.');

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `role_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`role_id`,`user_id`),
  KEY `users_has_roles_FKIndex2` (`role_id`),
  KEY `roles_users_FKIndex2` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `roles_users` (`role_id`, `user_id`) VALUES
(1, 60),
(1, 63),
(2, 60),
(2, 63);

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(127) collate utf8_unicode_ci NOT NULL,
  `last_activity` int(10) NOT NULL,
  `data` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(50) collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `site_settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'Zeelots Site'),
(2, 'site_description', 'Just a sample site'),
(3, 'site_theme', 'default');

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `dir` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`),
  UNIQUE KEY `uniq_dir` (`dir`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `themes` (`id`, `name`, `dir`) VALUES
(1, 'Default Theme', 'default'),
(2, 'Zeelot''s Sandbox Theme', 'zeelots_sandbox'),
(3, 'Zeelot''s Other Theme', 'zeelots_other_theme');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(32) collate utf8_unicode_ci NOT NULL,
  `password` varchar(50) collate utf8_unicode_ci NOT NULL,
  `email` varchar(127) collate utf8_unicode_ci NOT NULL,
  `logins` int(10) unsigned NOT NULL default '0',
  `last_login` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=64 ;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `logins`, `last_login`) VALUES
(60, 'admin', 'fc320cff004e31b7811d4770f6d3a6a77d10566fc54eedfd43', 'admin@admin.com', 39, 1238914359),
(63, 'zeelot', '4a007c2707b09a0cce2cc81b392e917aff1b5affd9ca4025dd', 'zeelot3k@gmail.com', 11, 1241016426);

DROP TABLE IF EXISTS `user_labels`;
CREATE TABLE IF NOT EXISTS `user_labels` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(32) collate utf8_unicode_ci NOT NULL,
  `value` varchar(127) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`,`user_id`),
  KEY `user_labels_FKIndex1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `label` varchar(32) collate utf8_unicode_ci NOT NULL,
  `value` varchar(127) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`,`user_id`),
  KEY `user_settings_FKIndex1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) collate utf8_unicode_ci NOT NULL,
  `token` varchar(32) collate utf8_unicode_ci NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`,`user_id`),
  KEY `user_tokens_FKIndex1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

ALTER TABLE `content_page_inheritances`
  ADD CONSTRAINT `page_inheritances_ibfk_1` FOREIGN KEY (`content_page_id`) REFERENCES `content_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_inheritances_ibfk_2` FOREIGN KEY (`inherited_page_id`) REFERENCES `content_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `content_pivots`
  ADD CONSTRAINT `has_nodes_ibfk_1` FOREIGN KEY (`content_node_id`) REFERENCES `content_nodes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `has_pages_ibfk_2` FOREIGN KEY (`content_page_id`) REFERENCES `content_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_labels`
  ADD CONSTRAINT `user_labels_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
