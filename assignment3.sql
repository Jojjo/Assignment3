-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2014 at 12:15 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `assignment3`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(26, NULL, NULL, NULL, 'controllers', 1, 52),
(27, 26, NULL, NULL, 'Groups', 2, 13),
(28, 27, NULL, NULL, 'index', 3, 4),
(29, 27, NULL, NULL, 'view', 5, 6),
(30, 27, NULL, NULL, 'add', 7, 8),
(31, 27, NULL, NULL, 'edit', 9, 10),
(32, 27, NULL, NULL, 'delete', 11, 12),
(33, 26, NULL, NULL, 'Images', 14, 27),
(34, 33, NULL, NULL, 'index', 15, 16),
(35, 33, NULL, NULL, 'view', 17, 18),
(36, 33, NULL, NULL, 'add', 19, 20),
(37, 33, NULL, NULL, 'edit', 21, 22),
(38, 33, NULL, NULL, 'delete', 23, 24),
(39, 26, NULL, NULL, 'Pages', 28, 31),
(40, 39, NULL, NULL, 'display', 29, 30),
(41, 26, NULL, NULL, 'Users', 32, 49),
(42, 41, NULL, NULL, 'initDB', 33, 34),
(43, 41, NULL, NULL, 'index', 35, 36),
(44, 41, NULL, NULL, 'login', 37, 38),
(45, 41, NULL, NULL, 'logout', 39, 40),
(46, 41, NULL, NULL, 'view', 41, 42),
(47, 41, NULL, NULL, 'add', 43, 44),
(48, 41, NULL, NULL, 'edit', 45, 46),
(49, 41, NULL, NULL, 'delete', 47, 48),
(50, 26, NULL, NULL, 'AclExtras', 50, 51),
(51, 33, NULL, NULL, 'display_images', 25, 26);

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(3, NULL, 'Group', 1, NULL, 1, 4),
(4, 3, 'User', 1, NULL, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 3, 26, '1', '1', '1', '1'),
(2, 3, 45, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Administrators', '2014-10-23 22:26:46', '2014-10-23 22:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_images_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`id`),
  KEY `fk_users_groups_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `created`, `modified`, `group_id`) VALUES
(1, 'jojjo', 'b7db70c99a8ed53f155618ec3640f9cc35cfc989', 'Johanna', 'Welander', 'welander@abeoweb.co.uk', '2014-10-23 22:27:09', '2014-10-23 22:30:00', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
