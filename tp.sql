-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2015 at 07:57 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `commentor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Friends`
--

CREATE TABLE IF NOT EXISTS `Friends` (
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Friend_Requests`
--

CREATE TABLE IF NOT EXISTS `Friend_Requests` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Interest`
--

CREATE TABLE IF NOT EXISTS `Interest` (
`entry_id` int(11) NOT NULL,
  `interest_text` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE IF NOT EXISTS `Notifications` (
`notification_id` int(11) NOT NULL,
  `notification_text` text NOT NULL,
  `user_meant_for_id` int(11) NOT NULL,
  `user_sent_by_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Poll_Answers`
--

CREATE TABLE IF NOT EXISTS `Poll_Answers` (
`poll_answer_id` int(11) NOT NULL,
  `option_selected` int(11) NOT NULL,
  `user_answered_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Poll_Question`
--

CREATE TABLE IF NOT EXISTS `Poll_Question` (
`poll_question_id` int(11) NOT NULL,
  `question_text` varchar(300) NOT NULL,
  `option1` varchar(50) NOT NULL,
  `option2` varchar(50) NOT NULL,
  `option3` varchar(50) NOT NULL,
  `option4` varchar(50) NOT NULL,
  `count1` int(11) NOT NULL,
  `count2` int(11) NOT NULL,
  `count3` int(11) NOT NULL,
  `count4` int(11) NOT NULL,
  `user_asked_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE IF NOT EXISTS `Post` (
`post_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
`user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `age` int(11) NOT NULL,
  `country` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `dob` date NOT NULL,
  `work_college` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `Friends`
--
ALTER TABLE `Friends`
 ADD PRIMARY KEY (`id1`,`id2`);

--
-- Indexes for table `Friend_Requests`
--
ALTER TABLE `Friend_Requests`
 ADD PRIMARY KEY (`sender_id`,`receiver_id`);

--
-- Indexes for table `Interest`
--
ALTER TABLE `Interest`
 ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
 ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `Poll_Answers`
--
ALTER TABLE `Poll_Answers`
 ADD PRIMARY KEY (`poll_answer_id`);

--
-- Indexes for table `Poll_Question`
--
ALTER TABLE `Poll_Question`
 ADD PRIMARY KEY (`poll_question_id`);

--
-- Indexes for table `Post`
--
ALTER TABLE `Post`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Interest`
--
ALTER TABLE `Interest`
MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Poll_Answers`
--
ALTER TABLE `Poll_Answers`
MODIFY `poll_answer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Poll_Question`
--
ALTER TABLE `Poll_Question`
MODIFY `poll_question_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Post`
--
ALTER TABLE `Post`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
