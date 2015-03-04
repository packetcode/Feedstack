-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jan 02, 2015 at 01:44 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fdsk`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
`id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `comment` mediumtext,
  `time_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `uid`, `feed_id`, `comment`, `time_stamp`) VALUES
(1, 1, 2, 'sample comment', '2014-11-14 15:05:44'),
(2, 1, 2, 'another sample comment', '2014-11-14 15:05:50'),
(3, 1, 3, 'wow', '2014-11-14 15:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
`id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `feed_original` longtext,
  `feed` longtext,
  `feed_url` varchar(500) DEFAULT NULL,
  `feed_container` longtext,
  `feed_type` varchar(10) DEFAULT NULL,
  `time_stamp` datetime DEFAULT NULL,
  `views` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
`id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `follow_id` int(11) DEFAULT NULL,
  `time_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `uid`, `follow_id`, `time_stamp`) VALUES
(1, 1, 1, '2014-11-14 15:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
`id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `time_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `uid`, `feed_id`, `time_stamp`) VALUES
(1, 1, 2, '2014-11-14 15:05:39');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
`id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `agent` int(11) DEFAULT NULL,
  `target` int(11) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `time_stamp` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `bio` varchar(100) DEFAULT NULL,
  `image_type` varchar(20) DEFAULT NULL,
  `block` int(11) DEFAULT NULL,
  `activation` varchar(10) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `feeds_per_page` int(11) DEFAULT NULL,
  `creation_timestamp` datetime DEFAULT NULL,
  `lastlogin_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `email`, `bio`, `image_type`, `block`, `activation`, `type`, `access`, `feeds_per_page`, `creation_timestamp`, `lastlogin_timestamp`) VALUES
(1, 'Administrator', 'administrator', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 'Hey people im a new entry to this website..hope to have fun..follow me to get updates.', 'server', 0, '1', 2, 1, 10, '2014-11-14 15:00:07', '2015-01-02 13:44:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;