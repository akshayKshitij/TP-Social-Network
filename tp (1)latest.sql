-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2015 at 04:01 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `post_id`, `commentor_id`, `user_id`, `text`) VALUES
(1, 2, 5, 3, 'haha');

-- --------------------------------------------------------

--
-- Table structure for table `Friends`
--

CREATE TABLE IF NOT EXISTS `Friends` (
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Friends`
--

INSERT INTO `Friends` (`id1`, `id2`) VALUES
(4, 5),
(5, 4),
(5, 6),
(6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Friend_Requests`
--

CREATE TABLE IF NOT EXISTS `Friend_Requests` (
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Friend_Requests`
--

INSERT INTO `Friend_Requests` (`sender_id`, `receiver_id`) VALUES
(4, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Post`
--

INSERT INTO `Post` (`post_id`, `poster_id`, `user_id`, `Text`) VALUES
(2, 4, 4, 'Yeah i''m back'),
(22, 4, 4, '<p>sdfg</p>'),
(23, 4, 4, '<p>aaa</p>'),
(24, 4, 4, '<p>asdfaaa</p>'),
(25, 4, 4, '<p>asdf</p>'),
(26, 4, 4, '<p>aaa</p>'),
(27, 4, 0, '5'),
(28, 4, 5, '<p>wasssup?????</p>'),
(29, 5, 6, '<p>ASDFS</p>'),
(30, 5, 6, '<p>aaa</p>'),
(34, 5, 5, '<p>adfsd</p>'),
(35, 5, 6, '<p>taa</p>');

-- --------------------------------------------------------

--
-- Table structure for table `Post_Notifications`
--

CREATE TABLE IF NOT EXISTS `Post_Notifications` (
`post_notification_id` int(11) NOT NULL,
  `posted_to_id` int(11) NOT NULL,
  `posted_by_id` int(11) NOT NULL
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `name`, `username`, `email`, `password`, `age`, `country`, `gender`, `dob`, `work_college`) VALUES
(4, 'Akshay U', 'akshayu', 'asd@sdf.in', '$2y$10$UHfV3.lTIPQwCpdjkW2PY.1BgMY7xbrSsRnFsMZYP/9s8jOZEyEzW', 23, 'India', 0, '0000-00-00', NULL),
(5, 'Kshitij T', 'kshitij', 'assdd@sdf.in', '$2y$10$RvZQftxefuGGNZ/fDB6FLuUKUb0WKA53J0MH65GAjgzTOsXr1i.Gq', 23, 'India', 0, '2015-04-08', NULL),
(6, 'Vishal R', 'vishal', 'assddas@sdf.in', '$2y$10$bybaQxeu2E6KYnOoVDfI0..in3bnb2WMpbc7yygF763ZCDre6P2f2', 23, 'India', 0, '2015-04-01', NULL),
(7, 'Akshay Varma', 'varma', 'asd@sdf.in', '$2y$10$zP3.WacQwVy.e6Bz6srVRed2V76GpkHenXRiBULc3q.h.Bc9JLrea', 23, 'India', 0, '0000-00-00', NULL);

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
-- Indexes for table `Post_Notifications`
--
ALTER TABLE `Post_Notifications`
 ADD PRIMARY KEY (`post_notification_id`);

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
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `Post_Notifications`
--
ALTER TABLE `Post_Notifications`
MODIFY `post_notification_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
