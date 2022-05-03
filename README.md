# LosBloggy
A blog I made using TinyMCE, PHP, MySQL and JavaScript

![Preview](https://i.imgur.com/xpzAsm0.png)

# Populate MariaDB database
```sql
-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2021 at 10:27 AM
-- Server version: 5.5.65-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-wul`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(64) NOT NULL,
  `blog_preview` varchar(256) NOT NULL,
  `blog_content` varchar(512) NOT NULL,
  `create_date` datetime NOT NULL,
  `last_edit` date DEFAULT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `last_editor` varchar(64) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `medium_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `blog_tag_id` int(11) DEFAULT NULL,
  `blog_medium_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_medium`
--

CREATE TABLE IF NOT EXISTS `blog_medium` (
  `blog_medium_id` int(11) NOT NULL,
  `medium_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_tag`
--

CREATE TABLE IF NOT EXISTS `blog_tag` (
  `blog_tag_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(1024) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medium`
--

CREATE TABLE IF NOT EXISTS `medium` (
  `medium_id` int(11) NOT NULL,
  `blog_medium_id` int(11) NOT NULL,
  `path_to_media` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) NOT NULL,
  `blog_tag_id` int(11) NOT NULL,
  `tag` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `initial_ip` varchar(64) NOT NULL,
  `last_login` date DEFAULT NULL,
  `last_login_ip` varchar(64) DEFAULT NULL,
  `last_password_change` datetime DEFAULT NULL,
  `amnt_failed_login` int(11) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `blog_medium`
--
ALTER TABLE `blog_medium`
  ADD PRIMARY KEY (`blog_medium_id`);

--
-- Indexes for table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD PRIMARY KEY (`blog_tag_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `medium`
--
ALTER TABLE `medium`
  ADD PRIMARY KEY (`medium_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `blog_medium`
--
ALTER TABLE `blog_medium`
  MODIFY `blog_medium_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blog_tag`
--
ALTER TABLE `blog_tag`
  MODIFY `blog_tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `medium`
--
ALTER TABLE `medium`
  MODIFY `medium_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
```

# config.php
The configuration for the database and its credentials are found in the config.php:
```php
$conf['db']['host']         = "localhost";
$conf['db']['db']           = "project-wul";
$conf['db']['user']         = "root";
```

# Known major bugs
- For some weird reason, the site is not able to load any images dynamically allocated on blog previews or uploaded through tinyMCE.
- The header and footer aren't in their separate file and need to be added to each .php file. This could be easily fixed using `<?php require_once "./../header.php"; ?>`
