SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `basic_contents`;
CREATE TABLE IF NOT EXISTS `basic_contents` (
  `id` tinyint(11) NOT NULL auto_increment,
  `node_id` int(11) NOT NULL,
  `format_id` tinyint(11) NOT NULL default '1',
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'content/basic/default',
  `name` varchar(125) collate utf8_unicode_ci NOT NULL,
  `content` longtext collate utf8_unicode_ci NOT NULL,
  `html` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

DROP TABLE IF EXISTS `content_formats`;
CREATE TABLE IF NOT EXISTS `content_formats` (
  `id` tinyint(11) NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `content_formats` (`id`, `name`) VALUES
(2, 'html'),
(1, 'markdown');

DROP TABLE IF EXISTS `content_nodes`;
CREATE TABLE IF NOT EXISTS `content_nodes` (
  `id` int(11) NOT NULL auto_increment,
  `content_type_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `alias` varchar(127) collate utf8_unicode_ci NOT NULL,
  `template` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

DROP TABLE IF EXISTS `content_pages`;
CREATE TABLE IF NOT EXISTS `content_pages` (
  `id` int(11) NOT NULL auto_increment,
  `alias` varchar(127) collate utf8_unicode_ci NOT NULL,
  `name` varchar(127) collate utf8_unicode_ci NOT NULL,
  `template` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

DROP TABLE IF EXISTS `content_pivots`;
CREATE TABLE IF NOT EXISTS `content_pivots` (
  `id` int(11) NOT NULL auto_increment,
  `content_page_id` int(11) NOT NULL,
  `content_node_id` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `has_nodes_FKIndex2` (`content_node_id`),
  KEY `has_pages_FKIndex2` (`content_page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `content_types` (`id`, `name`) VALUES
(1, 'basic'),
(2, 'navigation');

DROP TABLE IF EXISTS `navigation_contents`;
CREATE TABLE IF NOT EXISTS `navigation_contents` (
  `id` tinyint(10) NOT NULL auto_increment,
  `node_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL default '0' COMMENT 'if this is set, the item becomes a link to the page using its alias',
  `level` int(11) NOT NULL,
  `lft` tinyint(10) NOT NULL,
  `rgt` tinyint(10) NOT NULL,
  `tag` varchar(255) collate utf8_unicode_ci NOT NULL,
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `anchor` varchar(255) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=44 ;

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(127) NOT NULL,
  `dir` varchar(127) NOT NULL,
  `description` text NOT NULL,
  `dependencies` text,
  `notice_enable` text,
  `notice_disable` text,
  `enabled` binary(1) NOT NULL default '0',
  `version` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `dir` (`dir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

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
  `key` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `value` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

INSERT INTO `site_settings` (`id`, `key`, `value`) VALUES
(1, 'site_name', 'Zeelots Site'),
(2, 'site_description', 'Just a sample site'),
(3, 'site_theme', 'yuriko_cms');

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
(60, 'admin', 'fe9e44914dbb6bab93a29191b3c160f601a61e576a1da7693e', 'admin@admin.com', 39, 1238914359),
(63, 'zeelot', '718cdc5d4e4372f50d4cb30ce217cb85fa117e734bb2d0a181', 'zeelot3k@gmail.com', 1, 1238913498);

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


ALTER TABLE `content_pivots`
  ADD CONSTRAINT `has_nodes_ibfk_1` FOREIGN KEY (`content_node_id`) REFERENCES `content_nodes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `has_pages_ibfk_2` FOREIGN KEY (`content_page_id`) REFERENCES `content_pages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;


ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
