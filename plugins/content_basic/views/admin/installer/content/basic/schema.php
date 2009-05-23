-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 22, 2009 at 03:52 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `<?php echo Kohana::config('database.default.connection.database');?>`
--

-- --------------------------------------------------------

--
-- Table structure for table `basic_contents`
--

DROP TABLE IF EXISTS `<?php echo Kohana::config('database.default.table_prefix');?>basic_contents`;
CREATE TABLE IF NOT EXISTS `<?php echo Kohana::config('database.default.table_prefix');?>basic_contents` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `node_id` int(11) unsigned NOT NULL,
  `format_id` int(11) unsigned NOT NULL default '1',
  `view` varchar(127) collate utf8_unicode_ci NOT NULL default 'default',
  `name` varchar(125) collate utf8_unicode_ci NOT NULL,
  `content` longtext collate utf8_unicode_ci NOT NULL,
  `html` longtext collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Table structure for table `content_formats`
--

DROP TABLE IF EXISTS `<?php echo Kohana::config('database.default.table_prefix');?>content_formats`;
CREATE TABLE IF NOT EXISTS `<?php echo Kohana::config('database.default.table_prefix');?>content_formats` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

--
-- Dumping data for table `content_formats`
--

INSERT INTO `<?php echo Kohana::config('database.default.table_prefix');?>content_formats` (`id`, `name`) VALUES
(2, 'html'),
(1, 'markdown');
