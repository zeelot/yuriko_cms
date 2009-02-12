-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2009 at 12:58 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `zeelot_kmodules`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_navigations`
--

DROP TABLE IF EXISTS `content_navigations`;
CREATE TABLE IF NOT EXISTS `content_navigations` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `content_navigations`
--

INSERT INTO `content_navigations` (`id`, `title`, `description`) VALUES
(1, 'Main Menu', 'The Main Menu');

-- --------------------------------------------------------

--
-- Table structure for table `content_partials`
--

DROP TABLE IF EXISTS `content_partials`;
CREATE TABLE IF NOT EXISTS `content_partials` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `alias` varchar(32) NOT NULL default '',
  `type` varchar(32) NOT NULL default 'view',
  `module_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`),
  UNIQUE KEY `uniq_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `content_partials`
--

INSERT INTO `content_partials` (`id`, `name`, `alias`, `type`, `module_id`) VALUES
(1, 'Main Menu', 'navigation/main_menu', 'navigation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `location` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `email` varchar(90) character set utf8 collate utf8_unicode_ci default NULL,
  `msn` varchar(90) character set utf8 collate utf8_unicode_ci default NULL,
  `aim` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `yahoo` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `skype` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `theme_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_user_id` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `location`, `email`, `msn`, `aim`, `yahoo`, `skype`, `theme_id`) VALUES
(2, 'Lorenzo', 'Behind you', 'Zeelot3k@gmail.com', 'Zeelot3k@hotmail.com', 'Zeelot3k', 'Zeelot3k', 'Zeelot3k', 1),
(3, '', '', 'email@gmail.com', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(127) collate utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `data` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `last_activity`, `data`) VALUES
('6a528ac4b28c1293f86baf148986a79e', 1234306957, 'c2Vzc2lvbl9pZHxzOjMyOiI2YTUyOGFjNGIyOGMxMjkzZjg2YmFmMTQ4OTg2YTc5ZSI7dG90YWxfaGl0c3xpOjU7X2tmX2ZsYXNoX3xhOjA6e311c2VyX2FnZW50fHM6MTA1OiJNb3ppbGxhLzUuMCAoWDExOyBVOyBMaW51eCBpNjg2OyBlbi1VUzsgcnY6MS45LjAuNSkgR2Vja28vMjAwODEyMTYyMiBVYnVudHUvOC4xMCAoaW50cmVwaWQpIEZpcmVmb3gvMy4wLjUiO2lwX2FkZHJlc3N8czo5OiIxMjcuMC4wLjEiO2xhc3RfYWN0aXZpdHl8aToxMjM0MzA2OTU3O2F8czoxOiJiIjs='),
('512925f92dd5baba00087e0bc3c293cf', 1234084252, 'c2Vzc2lvbl9pZHxzOjMyOiI1MTI5MjVmOTJkZDViYWJhMDAwODdlMGJjM2MyOTNjZiI7dG90YWxfaGl0c3xpOjI4O19rZl9mbGFzaF98YTowOnt9dXNlcl9hZ2VudHxzOjEwNToiTW96aWxsYS81LjAgKFgxMTsgVTsgTGludXggaTY4NjsgZW4tVVM7IHJ2OjEuOS4wLjUpIEdlY2tvLzIwMDgxMjE2MjIgVWJ1bnR1LzguMTAgKGludHJlcGlkKSBGaXJlZm94LzMuMC41IjtpcF9hZGRyZXNzfHM6OToiMTI3LjAuMC4xIjtsYXN0X2FjdGl2aXR5fGk6MTIzNDA4NDI1Mjs='),
('5e0e79deaa8688e74c5ec57228167010', 1234080791, 'c2Vzc2lvbl9pZHxzOjMyOiI1ZTBlNzlkZWFhODY4OGU3NGM1ZWM1NzIyODE2NzAxMCI7dG90YWxfaGl0c3xpOjMzO19rZl9mbGFzaF98YTowOnt9dXNlcl9hZ2VudHxzOjEwNToiTW96aWxsYS81LjAgKFgxMTsgVTsgTGludXggaTY4NjsgZW4tVVM7IHJ2OjEuOS4wLjUpIEdlY2tvLzIwMDgxMjE2MjIgVWJ1bnR1LzguMTAgKGludHJlcGlkKSBGaXJlZm94LzMuMC41IjtpcF9hZGRyZXNzfHM6OToiMTI3LjAuMC4xIjtsYXN0X2FjdGl2aXR5fGk6MTIzNDA4MDc5MTs='),
('83e69634667a04d0236e418ba167931f', 1234416350, 'c2Vzc2lvbl9pZHxzOjMyOiI4M2U2OTYzNDY2N2EwNGQwMjM2ZTQxOGJhMTY3OTMxZiI7dG90YWxfaGl0c3xpOjM7X2tmX2ZsYXNoX3xhOjA6e311c2VyX2FnZW50fHM6MTA1OiJNb3ppbGxhLzUuMCAoWDExOyBVOyBMaW51eCBpNjg2OyBlbi1VUzsgcnY6MS45LjAuNikgR2Vja28vMjAwOTAyMDkxMSBVYnVudHUvOC4xMCAoaW50cmVwaWQpIEZpcmVmb3gvMy4wLjYiO2lwX2FkZHJlc3N8czo5OiIxMjcuMC4wLjEiO2xhc3RfYWN0aXZpdHl8aToxMjM0NDE2MzUwO2F8czoxOiJiIjs='),
('2b096c7d9b40ac601c461f27484f0edc', 1234398103, 'c2Vzc2lvbl9pZHxzOjMyOiIyYjA5NmM3ZDliNDBhYzYwMWM0NjFmMjc0ODRmMGVkYyI7dG90YWxfaGl0c3xpOjE7X2tmX2ZsYXNoX3xhOjA6e311c2VyX2FnZW50fHM6MTA1OiJNb3ppbGxhLzUuMCAoWDExOyBVOyBMaW51eCBpNjg2OyBlbi1VUzsgcnY6MS45LjAuNikgR2Vja28vMjAwOTAyMDkxMSBVYnVudHUvOC4xMCAoaW50cmVwaWQpIEZpcmVmb3gvMy4wLjYiO2lwX2FkZHJlc3N8czo5OiIxMjcuMC4wLjEiO2xhc3RfYWN0aXZpdHl8aToxMjM0Mzk4MTAzOw=='),
('bdcd857af8e20c27279fc62fb9653801', 1234406071, 'c2Vzc2lvbl9pZHxzOjMyOiJiZGNkODU3YWY4ZTIwYzI3Mjc5ZmM2MmZiOTY1MzgwMSI7dG90YWxfaGl0c3xpOjM7X2tmX2ZsYXNoX3xhOjA6e311c2VyX2FnZW50fHM6MTA1OiJNb3ppbGxhLzUuMCAoWDExOyBVOyBMaW51eCBpNjg2OyBlbi1VUzsgcnY6MS45LjAuNikgR2Vja28vMjAwOTAyMDkxMSBVYnVudHUvOC4xMCAoaW50cmVwaWQpIEZpcmVmb3gvMy4wLjYiO2lwX2FkZHJlc3N8czo5OiIxMjcuMC4wLjEiO2xhc3RfYWN0aXZpdHl8aToxMjM0NDA2MDcxO2F8czoxOiJiIjs='),
('fcf279ff18d523d89c135046383044a2', 1234368940, 'c2Vzc2lvbl9pZHxzOjMyOiJmY2YyNzlmZjE4ZDUyM2Q4OWMxMzUwNDYzODMwNDRhMiI7dG90YWxfaGl0c3xpOjM7X2tmX2ZsYXNoX3xhOjA6e311c2VyX2FnZW50fHM6MTA1OiJNb3ppbGxhLzUuMCAoWDExOyBVOyBMaW51eCBpNjg2OyBlbi1VUzsgcnY6MS45LjAuNikgR2Vja28vMjAwOTAyMDkxMSBVYnVudHUvOC4xMCAoaW50cmVwaWQpIEZpcmVmb3gvMy4wLjYiO2lwX2FkZHJlc3N8czo5OiIxMjcuMC4wLjEiO2xhc3RfYWN0aXZpdHl8aToxMjM0MzY4OTQwO2F8czoxOiJiIjs=');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `dir` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`),
  UNIQUE KEY `uniq_dir` (`dir`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `dir`) VALUES
(1, 'Default Theme', 'default'),
(2, 'Zeelot''s Sandbox Theme', 'zeelots_sandbox'),
(3, 'Zeelot''s Other Theme', 'zeelots_other_theme');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL default '0',
  `last_login` int(10) unsigned default NULL,
  `profile_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `logins`, `last_login`, `profile_id`) VALUES
(1, 'zeelot', '925845547728c7f100d5d8cc393ad45b348b565c84ab7ab949', 54, 1233618272, 2),
(2, 'demo', 'b4e9dff624962f7f2cd01706f95a6d19eece36d23be7328d0d', 46, 1233626935, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `created`, `expires`) VALUES
(1, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'JjCZSteKjZj4LwmK2zTsHJck7L0nM6aQ', 1232350171, 1233559771),
(2, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'zsLQYWCppUDuGcsLSHWTDCpLaUuD1rs6', 1232385038, 1233594638),
(3, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'HZJ93hJGvm1iTZ8k580Kmhf2o3LShapc', 1232387199, 1233596799),
(4, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'xPXyCLQs4SPMM9ingAw9waoJLUP9CNaR', 1232405559, 1233615159),
(5, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'VkHXCL4gWCjwUvHtDTvgz61HsoaMYbhL', 1232421305, 1233630905),
(6, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'ug0HvKwBtJtuZR53vnqRep36mgI3WbPD', 1232421342, 1233630942),
(7, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'oSjOnJHKX8pR5uv0SE7iEWbUFsKkpgLg', 1232421368, 1233630968),
(8, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'spAE5claWhxSq1yyR7uIrDpvAb80X656', 1232422804, 1233632404),
(9, 2, 'f4f954107c386c563faf64c9836001dd7dc348da', 'b69r3CsWWc0MMFDuxH7YEwdiOmqgSQVX', 1232423970, 1233633570),
(10, 2, 'd1c27ffd1eeb2417f39cfd5723b75ff24d4f5f30', 'krIrisgpUke3Lp9FUHIG4SWPl4XBqqyV', 1232464528, 1233674128),
(11, 1, 'd2183a6ee70aa07ec4fb357effd9d1dac4c24a98', 'IwT3EnjC34elRLDKL3LqbWSJf7lbcGX5', 1232495219, 1233704819);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
