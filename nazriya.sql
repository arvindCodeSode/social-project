-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 11:54 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nazriya`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
-- Creation: Mar 27, 2020 at 04:04 PM
--

CREATE TABLE `admin` (
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `admin`:
--

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `email`, `password`) VALUES
('Arvind Parkash', 'arvindparkash@gmail.com', '$6$6000$83lTvvTfnPy7T8RPrjJHXOde2aeCWZNUElDUHaFbO/qhiaw71D/mVOECR75m5ZtZrAMzz0.HfZ8Edz4aIA8LG0');

-- --------------------------------------------------------

--
-- Table structure for table `all_notification`
--
-- Creation: Mar 16, 2020 at 06:47 AM
--

CREATE TABLE `all_notification` (
  `notification_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `like_id` int(11) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `reacter` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `all_notification`:
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_like`
--
-- Creation: Mar 16, 2020 at 09:14 AM
--

CREATE TABLE `comment_like` (
  `comment_like_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) UNSIGNED NOT NULL,
  `comment_like` int(11) DEFAULT NULL,
  `like_status` int(2) NOT NULL DEFAULT '0',
  `comment_like_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `comment_like`:
--   `comment_id`
--       `post_comment` -> `comment_id`
--   `post_id`
--       `post_data` -> `post_id`
--   `user_id`
--       `user` -> `user_id`
--

--
-- Dumping data for table `comment_like`
--

INSERT INTO `comment_like` (`comment_like_id`, `post_id`, `user_id`, `comment_id`, `comment_like`, `like_status`, `comment_like_date`) VALUES
(1, 3, 22, 1, 1, 0, '2020-02-01 06:48:38'),
(2, 3, 25, 1, 1, 0, '2020-02-01 06:48:38'),
(3, 3, 23, 1, 1, 0, '2020-02-01 06:48:38'),
(4, 25, 20, 8, 1, 0, '2020-02-01 06:48:38'),
(7, 25, 26, 7, 1, 0, '2020-02-01 06:48:38'),
(9, 11, 22, 6, 1, 0, '2020-02-01 10:01:51'),
(14, 11, 23, 6, 1, 0, '2020-02-03 09:01:55'),
(20, 24, 23, 26, 1, 0, '2020-02-03 09:16:47'),
(27, 19, 23, 3, 1, 0, '2020-02-03 09:20:49'),
(30, 16, 23, 23, 1, 0, '2020-02-03 09:21:58'),
(31, 25, 25, 8, 1, 0, '2020-02-03 14:49:23'),
(32, 25, 25, 31, 1, 0, '2020-02-03 14:49:49'),
(33, 22, 25, 29, 1, 0, '2020-02-03 17:00:53'),
(34, 20, 25, 16, 1, 0, '2020-02-03 17:36:53'),
(35, 23, 25, 28, 1, 0, '2020-02-03 18:59:03'),
(36, 24, 20, 33, 1, 0, '2020-02-04 08:45:01'),
(48, 24, 26, 26, 1, 0, '2020-02-06 06:20:25'),
(50, 23, 26, 28, 1, 0, '2020-02-06 06:20:37'),
(75, 22, 26, 32, 1, 0, '2020-02-06 06:45:05'),
(78, 20, 26, 16, 1, 0, '2020-02-06 06:45:19'),
(79, 118, 23, 40, 1, 0, '2020-02-06 08:03:20'),
(80, 118, 23, 39, 1, 0, '2020-02-06 08:03:22'),
(81, 120, 23, 41, 1, 0, '2020-02-06 08:03:55'),
(82, 121, 23, 42, 1, 0, '2020-02-06 08:06:29'),
(83, 122, 23, 44, 1, 0, '2020-02-06 08:09:45'),
(84, 123, 23, 45, 1, 0, '2020-02-06 08:14:51'),
(85, 124, 23, 46, 1, 0, '2020-02-06 08:17:27'),
(86, 133, 22, 64, 1, 0, '2020-02-06 10:16:12'),
(87, 134, 22, 65, 1, 0, '2020-02-06 10:17:16'),
(88, 132, 22, 62, 1, 0, '2020-02-06 10:26:03'),
(89, 138, 26, 74, 1, 0, '2020-02-08 07:42:01'),
(90, 144, 22, 75, 1, 0, '2020-02-08 18:53:21'),
(91, 150, 25, 79, 1, 0, '2020-02-08 19:41:02'),
(92, 153, 24, 80, 1, 0, '2020-02-09 07:27:53'),
(93, 155, 24, 81, 1, 0, '2020-02-09 15:10:46'),
(94, 187, 22, 83, 1, 0, '2020-02-13 12:16:14'),
(95, 191, 22, 84, 1, 0, '2020-02-19 16:32:08'),
(97, 206, 25, 96, 1, 0, '2020-04-01 09:47:14'),
(98, 245, 24, 97, 1, 0, '2020-04-01 10:29:22'),
(99, 249, 25, 98, 1, 0, '2020-04-03 04:45:11'),
(100, 249, 22, 98, 1, 0, '2020-04-03 04:45:28'),
(101, 255, 24, 99, 1, 0, '2020-04-05 08:27:07'),
(102, 257, 24, 100, 1, 0, '2020-04-05 08:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `comment_reply`
--
-- Creation: Mar 16, 2020 at 09:14 AM
--

CREATE TABLE `comment_reply` (
  `reply_id` int(11) NOT NULL,
  `reply` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) UNSIGNED NOT NULL,
  `reply_status` int(2) NOT NULL DEFAULT '0',
  `reply_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `comment_reply`:
--   `comment_id`
--       `post_comment` -> `comment_id`
--   `user_id`
--       `user` -> `user_id`
--   `post_id`
--       `post_data` -> `post_id`
--

--
-- Dumping data for table `comment_reply`
--

INSERT INTO `comment_reply` (`reply_id`, `reply`, `post_id`, `user_id`, `comment_id`, `reply_status`, `reply_date`) VALUES
(1, 'he baby', 3, 24, 1, 0, '2020-02-01 06:39:24'),
(2, 'very goodl', 19, 25, 3, 0, '2020-02-01 06:40:23'),
(3, 'vary good', 3, 20, 1, 0, '2020-02-01 06:43:10'),
(4, 'aow your can remove any charecter here becoudse you are very initida aow your can remove any charecter here becoudse you are very initida ', 3, 22, 1, 0, '2020-02-01 06:44:23'),
(5, 'hello world this', 25, 24, 11, 0, '2020-02-03 07:21:06'),
(6, 'this new cooment', 25, 22, 11, 0, '2020-02-03 07:21:06'),
(7, 'beatiful', 25, 25, 11, 0, '2020-02-03 07:21:06'),
(8, 'comment', 25, 23, 13, 0, '2020-02-03 07:40:22'),
(9, 'hello  world', 22, 25, 32, 0, '2020-02-03 17:24:32'),
(10, 'my name is khan', 22, 25, 32, 0, '2020-02-03 17:25:39'),
(11, 'this is new', 20, 25, 16, 0, '2020-02-03 17:26:22'),
(12, 'this is how', 20, 25, 16, 0, '2020-02-03 17:33:35'),
(13, 'my new commment', 22, 25, 32, 0, '2020-02-03 18:44:15'),
(14, 'this is new ocmment', 23, 25, 28, 0, '2020-02-03 18:59:14'),
(15, 'hello ji', 23, 25, 27, 0, '2020-02-03 18:59:42'),
(16, 'beatuful', 23, 25, 28, 0, '2020-02-03 19:00:56'),
(17, 'so what', 18, 25, 21, 0, '2020-02-03 19:01:27'),
(18, 'hello', 18, 25, 21, 0, '2020-02-03 19:02:07'),
(19, 'good for helth', 18, 25, 20, 0, '2020-02-03 19:02:47'),
(20, 'hello', 18, 25, 20, 0, '2020-02-03 19:03:27'),
(21, 'hell arvind i am sonu', 23, 25, 14, 0, '2020-02-03 19:07:32'),
(22, 'hello ji', 23, 25, 14, 0, '2020-02-03 19:09:44'),
(23, 'this is new', 20, 25, 16, 0, '2020-02-03 19:14:16'),
(24, 'some time', 18, 25, 34, 0, '2020-02-03 19:18:08'),
(25, 'hello ji', 11, 25, 6, 0, '2020-02-03 19:22:10'),
(26, 'hello raul', 11, 25, 5, 0, '2020-02-03 19:26:16'),
(27, 'sonu', 11, 25, 2, 0, '2020-02-03 19:35:26'),
(28, 'heii world', 24, 25, 25, 0, '2020-02-03 19:40:39'),
(29, 'kiya hal he', 24, 20, 33, 0, '2020-02-04 08:45:15'),
(30, 'badiya hu', 24, 26, 33, 0, '2020-02-04 08:46:40'),
(32, 'ddddddddd', 104, 26, 38, 0, '2020-02-05 21:08:09'),
(33, 'ddddddddddddddddddddddddddddd', 104, 26, 38, 0, '2020-02-05 21:08:34'),
(34, 'hello world', 104, 26, 38, 0, '2020-02-06 07:05:09'),
(35, 'aaaaaaaaaa', 121, 23, 42, 0, '2020-02-06 08:09:24'),
(36, 'aaaaaaaaa', 131, 22, 63, 0, '2020-02-06 10:15:19'),
(37, 'ddddddd', 131, 22, 63, 0, '2020-02-06 10:15:25'),
(38, 'ddddddddddddd', 133, 22, 64, 0, '2020-02-06 10:15:56'),
(39, 'aaaaaaaaaaaaa', 133, 22, 64, 0, '2020-02-06 10:15:59'),
(40, 'ddddddddd', 133, 22, 64, 0, '2020-02-06 10:16:03'),
(41, 'ddddddddddd', 133, 22, 64, 0, '2020-02-06 10:16:08'),
(42, 'no', 134, 22, 65, 0, '2020-02-06 10:17:22'),
(43, 'aaaaaaaaaaa', 132, 22, 58, 0, '2020-02-06 10:26:08'),
(44, 'ddddddddddd', 134, 22, 65, 0, '2020-02-06 10:45:19'),
(45, 'aaaaaaaaaaa', 134, 22, 65, 0, '2020-02-06 10:45:25'),
(46, 'this is new', 134, 22, 65, 0, '2020-02-06 10:54:22'),
(47, 'sachin1000 hello', 131, 24, 57, 0, '2020-02-06 15:26:53'),
(48, '@arvind hi arvind', 131, 24, 57, 0, '2020-02-06 15:27:23'),
(50, 'Sonu hi sonu', 134, 24, 66, 0, '2020-02-06 15:33:26'),
(51, 'Sonu hello world', 133, 24, 64, 0, '2020-02-06 15:37:09'),
(52, 'Sachin hi shacin', 130, 24, 54, 0, '2020-02-06 15:39:21'),
(53, 'Sachin dddddddddddddd', 129, 24, 51, 0, '2020-02-06 15:39:48'),
(54, 'hello beatiful', 129, 24, 51, 0, '2020-02-06 15:41:31'),
(55, 'Sonu hi sonu', 132, 24, 58, 0, '2020-02-06 16:01:13'),
(56, 'hello hi kaho', 130, 24, 54, 0, '2020-02-06 16:02:03'),
(57, 'hari dddddddddddddd', 138, 26, 74, 0, '2020-02-08 07:42:05'),
(58, 'Sonu kiyahar he', 134, 22, 65, 0, '2020-02-08 18:51:14'),
(59, 'Sonu ffffffffff', 144, 22, 75, 0, '2020-02-08 18:53:31'),
(60, 'rahul helllo ranul', 150, 25, 79, 0, '2020-02-08 19:41:10'),
(61, 'rahul I am fine', 150, 25, 79, 0, '2020-02-08 19:43:11'),
(62, 'Sonu dddddddddddd', 187, 22, 83, 0, '2020-02-13 12:16:18'),
(63, 'Rahul Arya hi', 249, 22, 98, 0, '2020-04-03 04:45:34'),
(64, 'Rahul Arya hell rahl', 255, 24, 99, 0, '2020-04-05 08:27:16'),
(65, 'Nayak hi', 255, 25, 99, 0, '2020-04-05 08:27:48'),
(66, 'Nayak hello', 257, 24, 100, 0, '2020-04-05 08:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--
-- Creation: Mar 27, 2020 at 10:25 AM
--

CREATE TABLE `contact` (
  `contactId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` int(12) DEFAULT NULL,
  `emailid` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `subject` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `contact`:
--

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contactId`, `name`, `mobile`, `emailid`, `subject`, `date`, `ip`) VALUES
(1, 'sonu', 1111111111, 'arvind@gmail.com', 'dd', '2020-03-27 11:32:22', '0'),
(2, 'arvind', 1111111111, 'rahul@gmail.com', 'subject', '2020-03-27 11:34:32', '0'),
(3, 'arvind', 1111111111, 'arvind@gmail.com', 'd', '2020-03-27 11:35:46', '0');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--
-- Creation: Mar 15, 2020 at 02:36 PM
--

CREATE TABLE `post_comment` (
  `comment_id` int(11) UNSIGNED NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_status` int(2) DEFAULT '0',
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `post_comment`:
--   `post_id`
--       `post_data` -> `post_id`
--   `user_id`
--       `user` -> `user_id`
--

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`comment_id`, `comment`, `post_id`, `user_id`, `comment_status`, `comment_date`) VALUES
(1, 'nice idea!', 3, 26, 0, '2020-02-01 06:30:10'),
(2, 'nice thought', 11, 25, 1, '2020-03-18 16:33:46'),
(3, 'very goood', 19, 20, 0, '2020-02-01 06:32:34'),
(4, 'hello this is a world werher you can survive the life whitout fear and arugment of nay person', 25, 22, 0, '2020-02-01 06:32:34'),
(5, 'hello wrthis is', 11, 25, 1, '2020-03-18 16:33:46'),
(6, 'this is new world', 11, 24, 1, '2020-03-18 16:33:46'),
(7, 'nice pic', 25, 23, 0, '2020-02-01 06:34:36'),
(8, 'cogrutulation', 25, 20, 0, '2020-02-01 06:34:36'),
(11, 'ddddddddddddd', 25, 26, 0, '2020-02-01 12:55:59'),
(12, 'hell world im arvind', 25, 26, 0, '2020-02-01 12:59:15'),
(13, 'aaaaaaaaaa', 25, 26, 0, '2020-02-01 13:02:19'),
(14, 'hello this arinvd', 23, 27, 0, '2020-02-01 18:19:23'),
(15, 'hello this arinvd', 23, 27, 0, '2020-02-01 18:19:32'),
(16, 'Hello i am arvind', 20, 27, 0, '2020-02-01 18:20:45'),
(17, 'good pic', 19, 27, 0, '2020-02-01 18:39:10'),
(18, 'beautiful pic', 19, 27, 0, '2020-02-01 18:40:38'),
(19, 'this is new brand', 19, 27, 0, '2020-02-01 18:41:15'),
(20, 'gedddd', 18, 27, 1, '2020-03-17 16:03:08'),
(21, 'this is new comment', 18, 27, 1, '2020-03-17 16:03:08'),
(22, 'hello wrld', 19, 27, 0, '2020-02-01 19:20:52'),
(23, 'new coment', 16, 27, 1, '2020-03-17 16:03:08'),
(24, 'hello world', 24, 25, 0, '2020-02-02 16:20:10'),
(25, 'dddddd', 24, 25, 0, '2020-02-02 16:20:35'),
(26, 'this is new comment', 24, 25, 0, '2020-02-02 16:22:09'),
(27, 'i ma arvind', 23, 25, 0, '2020-02-02 16:23:10'),
(28, 'nice pic', 23, 25, 0, '2020-02-02 16:24:21'),
(29, 'comment', 22, 25, 0, '2020-02-02 16:26:28'),
(30, 'my new comment', 25, 25, 0, '2020-02-02 19:17:57'),
(31, 'nice idea', 25, 23, 0, '2020-02-03 07:49:37'),
(32, 'new', 22, 25, 0, '2020-02-03 17:00:50'),
(33, 'my name is khan', 24, 25, 0, '2020-02-03 17:20:23'),
(34, 'hello world', 18, 25, 1, '2020-03-17 16:03:08'),
(38, 'dddddd', 104, 26, 0, '2020-02-05 21:07:58'),
(39, 'aaaaaaaa', 118, 23, 1, '2020-03-18 07:01:18'),
(40, 'hello wolrd', 118, 23, 1, '2020-03-18 07:01:18'),
(41, 'hello world', 120, 23, 1, '2020-03-18 07:01:18'),
(42, 'new thourt', 121, 23, 1, '2020-03-18 07:01:18'),
(43, 'ddddd', 121, 23, 1, '2020-03-18 07:01:18'),
(44, 'aaaaaaaaaaaaaa', 122, 23, 1, '2020-03-18 07:01:18'),
(45, 'aaaaaaaaaaa', 123, 23, 1, '2020-03-18 07:01:17'),
(46, 'new', 124, 23, 1, '2020-03-18 07:01:17'),
(47, 'this is new', 125, 23, 1, '2020-03-18 07:01:17'),
(48, 'dddddd', 126, 23, 1, '2020-03-18 07:01:17'),
(49, 'ddddd', 127, 23, 1, '2020-03-18 07:01:17'),
(50, 'dddddd', 128, 23, 1, '2020-03-18 07:01:17'),
(51, 'ddddd', 129, 23, 1, '2020-03-18 07:01:17'),
(52, 'aaaaaaaa', 129, 23, 1, '2020-03-18 07:01:17'),
(53, 'ddddd', 129, 23, 1, '2020-03-18 07:01:17'),
(54, 'zzzzzzzzzz', 130, 23, 1, '2020-03-18 07:01:17'),
(55, 'aaaaaaa', 130, 23, 1, '2020-03-18 07:01:17'),
(56, 'aaaaaaaaa', 120, 23, 1, '2020-03-18 07:01:18'),
(57, 'dddddddddddddd', 131, 23, 1, '2020-03-18 07:01:17'),
(58, 'eeeeeeeee', 132, 23, 1, '2020-03-18 07:01:17'),
(59, 'ffffffffffff', 132, 23, 1, '2020-03-18 07:01:17'),
(60, 'this is new', 132, 22, 1, '2020-03-18 07:01:17'),
(61, 'ddddd', 132, 22, 1, '2020-03-18 07:01:17'),
(62, 'dddddd', 132, 22, 1, '2020-03-18 07:01:17'),
(63, 'dddddddddddd', 131, 22, 1, '2020-03-18 07:01:17'),
(64, 'aaaaaaaaaa', 133, 22, 1, '2020-03-18 13:47:03'),
(65, 'hello', 134, 22, 1, '2020-03-18 13:47:02'),
(66, 'this is world', 134, 22, 1, '2020-03-18 13:47:02'),
(70, 'aaaaaaaaaa', 130, 24, 1, '2020-03-18 07:01:17'),
(71, 'ddddddddddddddddddddddddddddd', 127, 24, 1, '2020-03-18 07:01:17'),
(72, 'hello world', 127, 24, 1, '2020-03-18 07:01:17'),
(73, 'dddddddddd', 127, 24, 1, '2020-03-18 07:01:17'),
(74, 'this is new', 138, 26, 0, '2020-02-08 07:41:58'),
(75, 'fffffffff', 144, 22, 1, '2020-03-18 13:47:02'),
(76, 'hello this is new', 145, 22, 1, '2020-03-18 13:47:02'),
(77, 'hello', 146, 22, 1, '2020-03-18 13:47:02'),
(78, 'aaaaaaaaaa', 147, 26, 0, '2020-02-08 19:18:05'),
(79, 'this is new comment', 150, 25, 1, '2020-03-17 07:16:01'),
(80, 'nice', 153, 24, 1, '2020-03-17 16:03:08'),
(81, 'aaaaaaaaaaaa', 155, 24, 1, '2020-03-17 16:03:08'),
(82, 'dddddddddd', 185, 22, 1, '2020-03-18 13:47:02'),
(83, 'dddddddddd', 187, 22, 1, '2020-03-18 13:47:02'),
(84, 'nnnnnnnnn', 191, 22, 1, '2020-03-18 13:47:02'),
(86, 'very good', 204, 22, 1, '2020-03-17 07:16:01'),
(88, 'hi sonu', 192, 25, 1, '2020-03-18 13:47:02'),
(89, 'very ood', 164, 26, 1, '2020-03-17 16:03:08'),
(93, 'hi', 186, 25, 1, '2020-03-18 13:47:02'),
(96, 'nice video', 206, 24, 1, '2020-04-01 09:47:42'),
(97, 'nnn', 245, 24, 1, '2020-04-04 14:53:03'),
(98, 'hello hi', 249, 25, 1, '2020-04-04 15:18:35'),
(99, 'nice post', 255, 25, 0, '2020-04-05 08:26:18'),
(100, 'nice post', 257, 24, 0, '2020-04-05 08:35:07'),
(101, 'dd', 254, 24, 0, '2020-04-05 08:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `post_data`
--
-- Creation: Mar 14, 2020 at 02:50 PM
--

CREATE TABLE `post_data` (
  `post_id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `post_text` text CHARACTER SET utf8 COLLATE utf8_bin,
  `post_image_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `share_parent_id` int(11) DEFAULT NULL,
  `share_text` text CHARACTER SET utf8 COLLATE utf8_bin,
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `post_data`:
--   `user_Id`
--       `user` -> `user_id`
--   `share_parent_id`
--       `post_data` -> `post_id`
--

--
-- Dumping data for table `post_data`
--

INSERT INTO `post_data` (`post_id`, `user_Id`, `post_text`, `post_image_text`, `share_parent_id`, `share_text`, `type`, `post_date`) VALUES
(1, 20, 'hello world', 'cars120200118210619pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(2, 20, 'hello world', 'img_band_chicago20200120120253pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(3, 20, 'my name is khan', 'img_5terre_wide20200120120316pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(4, 20, 'hello world', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(5, 20, 'ddddddddddddddddd', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(6, 20, 'hello world', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(7, 20, 'ddaaaaaaaaa', '720200120130647pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(8, 20, 'arvind', 'IMG_20181023_17524020200120130837pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(9, 20, 'thisis is', 'cars120200120130925pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(10, 20, 'dddddddddd', 'img_pulpit20200120131038pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(11, 27, 'hello world', 'avatar_g20200126212947pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(12, 24, 'hello world', 'bridge20200127205610pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(13, 24, 'hello world', 'bridge20200127205613pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(14, 24, 'hello world', 'bridge20200127205715pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(15, 24, 'my name is arvind', 'bridge20200127205921pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(16, 24, 'arvd', 'bridge20200127211635pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(17, 24, 'ar', 'bridge20200127211739pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(18, 24, 'aaaaaaaaa', 'bridge20200127212045pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(19, 26, 'Welcome', 'sanfran20200128202524pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(20, 26, 'Welcome', 'sanfran20200128202533pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(21, 26, 'hello wrold', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(22, 26, 'hell world', 'cars320200128202659pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(23, 26, NULL, 'forest20200128202721pm.jpeg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(24, 26, NULL, 'img_flowers20200128202820pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(25, 26, 'thisd is new', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(59, 26, NULL, 'img_5terre_wide20200205212356pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(60, 26, NULL, 'ajax20200205212430pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(61, 26, NULL, 'ajax20200205212529pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(96, 26, 'ffffffffff', '720200206014438am.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(103, 26, NULL, 'ajax20200206021123am.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(104, 26, NULL, '620200206021524am.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(105, 26, 'aaaaaaa', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(106, 26, NULL, 'art20200206024346am.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(107, 26, NULL, 'ajax20200206024706am.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(108, 26, NULL, 'cars320200206025809am.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(109, 26, NULL, 'ajax20200206030624am.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(110, 26, NULL, 'cars320200206111950am.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(111, 26, 'this is new', 'avatar_g20200206124054pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(112, 26, NULL, 'ajax20200206124154pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(113, 26, 'ddddddd', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(114, 26, NULL, '720200206125141pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(115, 23, NULL, '620200206125256pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(116, 23, 'dddddddddddd', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(117, 23, 'aaaaaaa', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(118, 23, NULL, 'ajax20200206125927pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(119, 23, NULL, '720200206131233pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(120, 23, NULL, 'avatar_g20200206133343pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(121, 23, NULL, 'ajax20200206133614pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(122, 23, NULL, '120200206133935pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(123, 23, NULL, '220200206134441pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(124, 23, 'aaaaaaaaaaaa', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(125, 23, NULL, 'art20200206134927pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(126, 23, NULL, 'avatar_g20200206135054pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(127, 23, '', NULL, 125, 'fff', 'image/jpg', '2020-03-14 15:10:28'),
(128, 23, 'aaaaaaaaaaaaaaaaaa', NULL, 126, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(129, 23, NULL, 'avatar_g20200206141740pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(130, 23, 'dddddddddddd', NULL, 129, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(131, 23, NULL, 'ajax20200206144522pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(132, 23, 'aaaaaaaaa', NULL, 130, 'this si new', 'image/jpg', '2020-03-14 15:10:28'),
(133, 22, 'ddddddddddddddddd', NULL, 25, 'hello world', 'image/jpg', '2020-03-14 15:10:28'),
(134, 22, NULL, 'bridge20200206154659pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(135, 26, NULL, NULL, 114, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(136, 26, NULL, NULL, 121, 'hello new share', 'image/jpg', '2020-03-14 15:10:28'),
(137, 26, NULL, NULL, 18, '', 'image/jpg', '2020-03-14 15:10:28'),
(138, 26, NULL, NULL, 15, '', 'image/jpg', '2020-03-14 15:10:28'),
(139, 26, NULL, NULL, 134, '', 'image/jpg', '2020-03-14 15:10:28'),
(140, 26, NULL, NULL, 120, '', 'image/jpg', '2020-03-14 15:10:28'),
(141, 22, NULL, NULL, 120, '', 'image/jpg', '2020-03-14 15:10:28'),
(142, 22, NULL, NULL, 117, 'happing', 'image/jpg', '2020-03-14 15:10:28'),
(143, 22, NULL, NULL, 134, '', 'image/jpg', '2020-03-14 15:10:28'),
(144, 22, 'this is new  post', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(145, 22, 'this is new type of coomebt', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(146, 22, NULL, 'flower20200209004230am.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(147, 26, 'helllo ji', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(148, 26, NULL, NULL, 147, '', 'image/jpg', '2020-03-14 15:10:28'),
(149, 25, NULL, NULL, 146, '', 'image/jpg', '2020-03-14 15:10:28'),
(150, 25, 'hello I am Rahul', 'ajax20200209011046am.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(151, 25, NULL, NULL, 150, '', 'image/jpg', '2020-03-14 15:10:28'),
(152, 24, 'hello this is new', 'ajax20200209125109pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(153, 24, NULL, 'avatar_g20200209125416pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(154, 24, 'may name is khan', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(155, 24, NULL, 'forest20200209130420pm.jpeg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(156, 20, NULL, 'ajax20200209130702pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(157, 24, 'dddddddddd', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(158, 24, 'a', 'bridge20200209204103pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(159, 24, NULL, NULL, 134, '', 'image/jpg', '2020-03-14 15:10:28'),
(160, 24, NULL, NULL, 146, 'dddddddddd', 'image/jpg', '2020-03-14 15:10:28'),
(161, 24, 'hellllo world', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(162, 24, 'arvind', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(163, 24, NULL, NULL, 162, '', 'image/jpg', '2020-03-14 15:10:28'),
(164, 24, NULL, NULL, 161, 'dddddddddddd', 'image/jpg', '2020-03-14 15:10:28'),
(165, 24, NULL, NULL, 158, '', 'image/jpg', '2020-03-14 15:10:28'),
(166, 24, NULL, NULL, 158, 'heeee', 'image/jpg', '2020-03-14 15:10:28'),
(169, 22, NULL, 'ajax20200212203934pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(170, 22, NULL, 'ajax20200212203934pm.gif', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(171, 22, 'aaaaaaaaaaaaa', 'ar20200212204359pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(172, 22, NULL, 'avatar_g20200212204452pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(173, 22, 'ffffffffff', 'cm20200212204522pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(174, 22, NULL, 'camp20200212204555pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(175, 22, 'this is my new post', 'ar20200212230139pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(176, 23, 'ddddddddddddd', 'grilco20200212230826pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(177, 23, 'sssssssss', 'newyork20200212230942pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(178, 23, NULL, 'avatar_g20200212231141pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(179, 23, NULL, 'cars120200212231928pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(180, 23, NULL, 'cmm20200212232045pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(181, 25, NULL, 'camp20200213001654am.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(182, 25, NULL, 'cars320200213001740am.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(183, 22, NULL, 'grilco20200213145818pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(184, 22, NULL, 'bridge20200213150645pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(185, 22, 'this is me and you', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(186, 22, NULL, 'camp20200213174551pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(187, 22, NULL, NULL, 186, '', 'image/jpg', '2020-03-14 15:10:28'),
(188, 22, 'ddddddddddddddddd', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(189, 22, NULL, NULL, 188, 'aaaaaaaa', 'image/jpg', '2020-03-14 15:10:28'),
(190, 22, NULL, NULL, 182, 'share now', 'image/jpg', '2020-03-14 15:10:28'),
(191, 22, NULL, 'cars120200213175239pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(192, 22, 'ddddddddddddd', 'camp20200213175345pm.jpg', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(195, 22, 'hello world', NULL, NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(201, 25, NULL, 'Screenshot_(15908)20200314195428pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(202, 25, NULL, 'Screenshot_(15908)20200314200147pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(203, 25, NULL, 'Screenshot_(15908)20200314200214pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(204, 25, NULL, 'Screenshot_(15906)20200314202804pm.png', NULL, NULL, 'image/jpg', '2020-03-14 15:10:28'),
(206, 25, NULL, 'best_south_movie_action20200314210008pm.mp4', NULL, NULL, 'video/mp4', '2020-03-14 15:30:08'),
(207, 25, 'helllo world this arvind', NULL, NULL, NULL, '', '2020-03-17 13:00:15'),
(208, 25, NULL, 'A_GUJARNE_BALI_HAVA20200317185220pm.mp4', NULL, NULL, 'video/mp4', '2020-03-17 13:22:20'),
(211, 22, 'hello this', 'IMG-20190930-WA000520200330144425pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 09:14:25'),
(212, 24, 'this is new', 'IMG-20200228-WA000020200330145649pm.jpeg', NULL, NULL, 'image/jpeg', '2020-03-30 09:26:49'),
(213, 24, NULL, 'IMG-20190930-WA000520200330145707pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 09:27:07'),
(214, 24, 'dddd', 'IMG-20190930-WA000520200330145712pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 09:27:12'),
(220, 24, 'ss', 'IMG-20190929-WA000220200330154042pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:10:42'),
(221, 24, 'aaaaaaaaa', 'IMG-20190929-WA000520200330154119pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:11:19'),
(222, 24, 'dddd', 'IMG-20190929-WA000420200330154227pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:12:27'),
(223, 24, 'dddddd', 'IMG-20190929-WA000520200330154246pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:12:46'),
(224, 24, NULL, 'IMG-20190930-WA000020200330154305pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:13:05'),
(225, 24, 'sss', 'IMG-20190930-WA000020200330154311pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:13:11'),
(230, 24, 'sss', 'IMG-20190930-WA000020200330155851pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:28:51'),
(231, 24, 'ddd', 'arvind20200330155913pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:29:13'),
(233, 24, 'ww', 'IMG-20190930-WA000420200330160227pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:32:27'),
(234, 24, NULL, 'arvind20200330160327pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:33:27'),
(235, 24, 'dddd', 'arvind20200330160332pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:33:32'),
(241, 24, 'ss', 'IMG-20181028-WA011620200330160945pm.jpg', NULL, NULL, 'image/jpeg', '2020-03-30 10:39:51'),
(245, 24, NULL, NULL, 211, '', NULL, '2020-04-01 10:29:05'),
(246, 24, 'my college', 'IMG-20181028-WA013920200401160023pm.jpg', NULL, NULL, 'image/jpeg', '2020-04-01 10:30:39'),
(247, 24, NULL, 'IMG-20181101-WA000820200401160140pm.jpg', NULL, NULL, 'image/jpeg', '2020-04-01 10:31:43'),
(248, 24, 'hello im amd \\r\\nyou nown me very well\\r\\nsoe are you', NULL, NULL, NULL, NULL, '2020-04-02 16:26:29'),
(249, 25, 'my name is khan nad \\r\\nyour name what is \\r\\nse ethis', NULL, NULL, NULL, NULL, '2020-04-03 04:44:17'),
(250, 22, NULL, NULL, 249, 'nice post\\nsay hi', NULL, '2020-04-03 04:46:02'),
(251, 22, NULL, NULL, 248, 'hello world Why are your \\ndddd\\nsss\\naa', NULL, '2020-04-03 04:46:56'),
(252, 22, '#arvind', NULL, NULL, NULL, NULL, '2020-04-03 04:59:53'),
(253, 24, 'ना तु गिरेगा\\r\\nना तु थकेगा ।\\r\\nये तेरा हे लक्ष्य\\r\\nबस तु बढ़ेगा\\r\\nये दुनिया तुझे सतायेगी\\r\\nहर समय तुझे रूलायेगी\\r\\nहर पथ तेरा कांटे आऐगे ।\\r\\nफिर भी तु नही थगेगा ।\\r\\nये तेरा हे लक्ष्य\\r\\nबस तु बढ़ेगा ।\\r\\n\\r\\nना तु रूकेगा\\r\\nना तु गिरेगा\\r\\nना तु थकेगा ।\\r\\n\\r\\nये तेरा हे लक्ष्य....\\r\\n\\r\\n\\r\\n⇠बस तु बढ़ेगा⇢', NULL, NULL, NULL, NULL, '2020-04-04 16:12:01'),
(254, 37, NULL, 'IMG2018052307320320200404221548pm.jpg', NULL, NULL, 'image/jpeg', '2020-04-04 16:45:56'),
(255, 37, 'hello i am a teacher and your for adnd athis arind students\\r\\ndaddd\\r\\n#arvindkk', NULL, NULL, NULL, NULL, '2020-04-05 08:25:55'),
(256, 25, NULL, NULL, 255, 'nice post', NULL, '2020-04-05 08:26:35'),
(257, 24, NULL, NULL, 249, 'hello world', NULL, '2020-04-05 08:34:54'),
(258, 24, NULL, 'IMG-20180311-WA002920200405140606pm.jpg', NULL, NULL, 'image/jpeg', '2020-04-05 08:36:12'),
(259, 24, NULL, NULL, 258, '', NULL, '2020-04-05 09:27:06');

-- --------------------------------------------------------

--
-- Table structure for table `post_like`
--
-- Creation: Mar 16, 2020 at 09:15 AM
--

CREATE TABLE `post_like` (
  `like_co_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `post_like_status` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `post_like`:
--   `user_id`
--       `user` -> `user_id`
--   `post_id`
--       `post_data` -> `post_id`
--

--
-- Dumping data for table `post_like`
--

INSERT INTO `post_like` (`like_co_id`, `user_id`, `post_id`, `likes`, `post_like_status`) VALUES
(1, 20, 1, 0, 0),
(2, 20, 1, 0, 0),
(3, 23, 1, 0, 0),
(5, 20, 2, 0, 0),
(16, 20, 1, 1, 0),
(17, 20, 2, 0, 0),
(18, 20, 8, 1, 0),
(19, 26, 4, 0, 0),
(20, 26, 10, 0, 0),
(21, 27, 11, 0, 1),
(22, 27, 11, 1, 1),
(23, 27, 10, 1, 0),
(24, 27, 1, 1, 0),
(25, 24, 11, 0, 1),
(26, 24, 11, 1, 1),
(27, 24, 1, 1, 0),
(28, 24, 18, 0, 1),
(29, 24, 17, 0, 1),
(30, 24, 16, 0, 1),
(31, 24, 16, 1, 1),
(32, 24, 12, 1, 1),
(33, 24, 13, 1, 1),
(34, 26, 18, 1, 1),
(35, 26, 17, 1, 1),
(36, 26, 19, 1, 0),
(37, 26, 20, 1, 0),
(38, 26, 21, 0, 0),
(40, 26, 4, 1, 0),
(42, 25, 25, 0, 0),
(43, 25, 24, 0, 0),
(44, 25, 1, 1, 0),
(45, 23, 24, 1, 0),
(46, 23, 1, 1, 0),
(47, 23, 6, 1, 0),
(48, 26, 21, 1, 0),
(50, 25, 25, 1, 0),
(51, 25, 22, 1, 0),
(53, 25, 18, 1, 1),
(54, 23, 25, 0, 0),
(55, 23, 11, 1, 1),
(56, 25, 14, 1, 1),
(57, 25, 23, 1, 0),
(58, 20, 25, 1, 0),
(65, 26, 23, 1, 0),
(66, 26, 59, 1, 0),
(67, 26, 61, 1, 0),
(68, 26, 25, 1, 0),
(72, 26, 107, 1, 0),
(73, 26, 106, 1, 0),
(78, 26, 105, 1, 0),
(80, 26, 109, 1, 0),
(88, 25, 104, 1, 0),
(92, 25, 103, 1, 0),
(103, 25, 109, 1, 0),
(113, 26, 108, 1, 0),
(114, 26, 111, 1, 0),
(116, 26, 113, 1, 0),
(117, 23, 114, 1, 0),
(118, 23, 116, 1, 1),
(119, 23, 120, 1, 1),
(120, 23, 121, 1, 1),
(121, 23, 122, 1, 1),
(122, 23, 123, 1, 1),
(123, 23, 124, 1, 1),
(127, 22, 133, 1, 1),
(132, 22, 124, 1, 1),
(134, 22, 132, 1, 1),
(135, 22, 131, 1, 1),
(137, 25, 134, 1, 1),
(139, 25, 133, 1, 1),
(140, 24, 131, 1, 1),
(142, 24, 128, 1, 1),
(144, 23, 130, 1, 1),
(145, 23, 132, 1, 1),
(147, 26, 138, 1, 0),
(148, 22, 142, 1, 1),
(149, 22, 144, 1, 1),
(150, 26, 147, 1, 0),
(151, 25, 150, 1, 1),
(152, 25, 149, 1, 1),
(153, 24, 153, 1, 1),
(154, 20, 156, 1, 0),
(155, 24, 155, 1, 1),
(156, 24, 157, 1, 1),
(157, 24, 158, 1, 1),
(158, 24, 161, 1, 1),
(159, 24, 162, 1, 1),
(160, 24, 165, 1, 1),
(161, 24, 160, 1, 1),
(162, 23, 176, 1, 1),
(163, 22, 171, 1, 1),
(164, 22, 185, 1, 1),
(165, 22, 186, 1, 1),
(166, 22, 188, 1, 1),
(169, 24, 192, 1, 1),
(177, 22, 177, 1, 1),
(178, 22, 195, 1, 1),
(179, 22, 191, 1, 1),
(180, 22, 176, 1, 1),
(182, 25, 190, 1, 1),
(184, 25, 195, 1, 1),
(188, 25, 204, 1, 1),
(189, 26, 182, 1, 1),
(190, 25, 148, 1, 0),
(196, 25, 206, 1, 1),
(197, 25, 207, 1, 1),
(198, 25, 208, 1, 1),
(199, 24, 207, 1, 1),
(202, 22, 201, 1, 1),
(208, 24, 208, 1, 1),
(209, 24, 206, 1, 1),
(210, 24, 230, 1, 1),
(211, 24, 241, 1, 1),
(212, 24, 245, 1, 1),
(213, 24, 246, 1, 1),
(214, 24, 247, 1, 1),
(215, 24, 248, 1, 1),
(216, 25, 249, 1, 1),
(217, 24, 251, 1, 0),
(218, 24, 253, 1, 0),
(219, 37, 255, 1, 0),
(220, 25, 255, 1, 0),
(222, 24, 256, 1, 0),
(223, 24, 255, 1, 0),
(224, 25, 256, 1, 0),
(225, 24, 224, 1, 0),
(226, 24, 257, 1, 0),
(227, 24, 233, 1, 0),
(228, 24, 258, 1, 0),
(229, 24, 254, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reply_like`
--
-- Creation: Mar 16, 2020 at 09:16 AM
--

CREATE TABLE `reply_like` (
  `reply_like_id` int(11) NOT NULL,
  `comment_id` int(11) UNSIGNED NOT NULL,
  `reply_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply_like` int(11) DEFAULT NULL,
  `reply_like_status` int(2) NOT NULL DEFAULT '0',
  `reply_like_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `reply_like`:
--   `reply_id`
--       `comment_reply` -> `reply_id`
--   `user_id`
--       `user` -> `user_id`
--   `comment_id`
--       `post_comment` -> `comment_id`
--   `post_id`
--       `post_data` -> `post_id`
--

--
-- Dumping data for table `reply_like`
--

INSERT INTO `reply_like` (`reply_like_id`, `comment_id`, `reply_id`, `post_id`, `user_id`, `reply_like`, `reply_like_status`, `reply_like_date`) VALUES
(71, 1, 1, 3, 27, 1, 0, '2020-02-01 07:08:27'),
(72, 1, 1, 3, 24, 1, 0, '2020-02-01 07:08:27'),
(73, 1, 3, 3, 23, 1, 0, '2020-02-01 07:08:27'),
(74, 1, 3, 3, 22, 1, 0, '2020-02-01 07:08:27'),
(75, 1, 4, 3, 20, 1, 0, '2020-02-01 07:08:27'),
(76, 3, 2, 19, 25, 1, 0, '2020-02-01 07:08:27'),
(77, 3, 2, 19, 22, 1, 0, '2020-02-01 07:08:36'),
(78, 3, 2, 19, 24, 1, 0, '2020-02-01 07:08:39'),
(79, 3, 2, 19, 26, 1, 0, '2020-02-01 07:08:27'),
(80, 3, 2, 19, 23, 1, 0, '2020-02-01 07:08:27'),
(92, 32, 9, 22, 25, 1, 0, '2020-02-03 18:39:01'),
(96, 38, 32, 104, 26, 1, 0, '2020-02-06 07:04:36'),
(98, 38, 34, 104, 26, 1, 0, '2020-02-06 07:05:12'),
(99, 38, 33, 104, 26, 1, 0, '2020-02-06 07:05:16'),
(100, 13, 8, 25, 26, 1, 0, '2020-02-06 07:06:58'),
(101, 11, 5, 25, 26, 1, 0, '2020-02-06 07:07:02'),
(102, 64, 38, 133, 22, 1, 0, '2020-02-06 10:16:11'),
(103, 64, 41, 133, 22, 1, 0, '2020-02-06 10:16:13'),
(104, 58, 43, 132, 22, 1, 0, '2020-02-06 10:26:10'),
(105, 65, 44, 134, 22, 1, 0, '2020-02-06 10:45:21'),
(106, 65, 45, 134, 22, 1, 0, '2020-02-06 10:54:12'),
(107, 65, 46, 134, 22, 1, 0, '2020-02-08 18:51:05'),
(108, 65, 58, 134, 22, 1, 0, '2020-02-08 18:51:20'),
(110, 83, 62, 187, 25, 1, 0, '2020-03-14 08:31:36'),
(111, 98, 63, 249, 22, 1, 0, '2020-04-03 04:45:38'),
(112, 99, 64, 255, 25, 1, 0, '2020-04-05 08:27:42'),
(113, 100, 66, 257, 24, 1, 0, '2020-04-05 08:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--
-- Creation: Mar 27, 2020 at 10:45 AM
--

CREATE TABLE `report` (
  `reportId` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `report` text CHARACTER SET utf8 COLLATE utf8_bin,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `report`:
--

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportId`, `name`, `image`, `type`, `report`, `date`, `ip`) VALUES
(1, 'arvind', 'Screenshot_(6434)20200327174333pm.png', 'image/png', 'sssss', '2020-03-27 12:13:33', NULL),
(2, 'arvind', 'Screenshot_(6433)20200327174453pm.png', 'image/png', 'hello world', '2020-03-27 12:14:53', 0),
(3, 'sonu', 'Screenshot_(6437)20200327174633pm.png', 'image/png', 'dddd', '2020-03-27 12:16:33', 0),
(4, 'arvind', 'Screenshot_(6431)20200327174700pm.png', 'image/png', 'dddddddd', '2020-03-27 12:17:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `share`
--
-- Creation: Feb 06, 2020 at 04:20 PM
--

CREATE TABLE `share` (
  `share_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `share` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `share`:
--   `user_id`
--       `user` -> `user_id`
--

--
-- Dumping data for table `share`
--

INSERT INTO `share` (`share_id`, `post_id`, `user_id`, `share`) VALUES
(1, 94, 25, 'hello world thi s me'),
(2, 78, 26, 'hi hh this '),
(3, 129, 20, 'ki'),
(4, 129, 22, NULL),
(5, 130, 23, NULL),
(6, 130, 23, 'ddddddd'),
(7, 133, 20, 'ffffffffffff'),
(8, 133, 27, NULL),
(9, 130, 25, 'aaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `suggest`
--
-- Creation: Mar 27, 2020 at 10:27 AM
--

CREATE TABLE `suggest` (
  `suggestId` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `suggest` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `suggest`:
--

--
-- Dumping data for table `suggest`
--

INSERT INTO `suggest` (`suggestId`, `name`, `suggest`, `ip`, `date`) VALUES
(1, 'arvind', 'ddd', '0', '2020-03-27 11:43:28'),
(2, 'dd', 'aaa', '0', '2020-03-27 11:43:49'),
(3, 'arvind', 'dd', '0', '2020-03-27 12:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
-- Creation: Mar 18, 2020 at 04:39 PM
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` int(12) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `uname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_bio` text CHARACTER SET utf8 COLLATE utf8_bin,
  `location` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `profession` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `join_date` datetime DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `user`:
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `mobile`, `email`, `uname`, `password`, `user_bio`, `location`, `profession`, `join_date`, `reg_date`) VALUES
(20, 'arvidn', 1111111111, 'arivnd@gmail.com', '@arvin', '$6$6000$oSlwOQLS.Ng7mPIaZYwrCDALvI.zlPH6s9NIm8tP5uPqu6jQOHuXXt.fmvGHylELI5YncUzHkPrnclhKS1iZu0', 'Arvind\r\n  parkash\r\n  studend artpasd\r\n  aaaaaaaaaaaaaaaaaaaaaaaa\r\n  a\r\n  a\r\n  a\r\n  a', '0', '0', '2020-02-04 08:21:10', '2020-02-12 18:32:48'),
(22, 'Sonu', 1111111111, 'sonu@gmail.com', '@sonu_1999', '$6$6000$uTYyRjSfjTh4l.OwaBB38xunosG9tOc.qLDUSZSdG/lITtR6g037mqYvWDyN73wsyte5OL/kScNRwQnXJs//v0', 'i am indian army\\r\\nso you can\\r\\nsurvive this is our problem\\r\\nand you can', '', '', '2020-02-05 05:43:19', '2020-03-18 16:23:24'),
(23, 'Sachin', 2147483647, 'sachin@gmail.com', '@sachin1000', '$6$6000$oSlwOQLS.Ng7mPIaZYwrCDALvI.zlPH6s9NIm8tP5uPqu6jQOHuXXt.fmvGHylELI5YncUzHkPrnclhKS1iZu0', 'ddddddddddddddddddd \\r\\n this is s \\r\\n thissls sssss\\r\\nddddddddddddddd', '', '', '2020-02-06 20:48:43', '2020-03-18 16:23:31'),
(24, 'Nayak', 2147483641, 'arvind@gmail.com', '@arvind', '$6$6000$uTYyRjSfjTh4l.OwaBB38xunosG9tOc.qLDUSZSdG/lITtR6g037mqYvWDyN73wsyte5OL/kScNRwQnXJs//v0', 'ddd', 'location', 'dddddddddddd', '2020-01-06 00:10:14', '2020-04-04 15:41:56'),
(25, 'rahul arya', 2147483111, 'rahul@gmail.com', '@the_rahul', '$6$6000$uTYyRjSfjTh4l.OwaBB38xunosG9tOc.qLDUSZSdG/lITtR6g037mqYvWDyN73wsyte5OL/kScNRwQnXJs//v0', '', 'Delhi', 'Web developer', '2020-02-09 04:11:20', '2020-03-18 16:02:51'),
(26, 'hari', 1235658214, 'hari@gmail.com', '@hari@19', '$6$6000$oSlwOQLS.Ng7mPIaZYwrCDALvI.zlPH6s9NIm8tP5uPqu6jQOHuXXt.fmvGHylELI5YncUzHkPrnclhKS1iZu0', '', '0', '0', '2020-01-05 02:05:22', '2020-03-18 16:23:36'),
(27, 'sonu', 1111111111, 'sonua@gmail.com', '@sonu@199', '$6$6000$oSlwOQLS.Ng7mPIaZYwrCDALvI.zlPH6s9NIm8tP5uPqu6jQOHuXXt.fmvGHylELI5YncUzHkPrnclhKS1iZu0', '', '0', '0', '2020-02-10 16:19:15', '2020-03-18 16:23:43'),
(35, 'tanuj', NULL, 'tanuj@gmail.com', 'tanuj@1999', '$6$6000$UyWjyWKO0vk.E1.ROYaLW7D1leofjM2ozYcbZ1PL0vz6bCtHIPPhDPv0ljl6MBlyBttXny1iR4qMvr8jF5THe1', NULL, NULL, NULL, '2020-03-18 22:12:08', '2020-03-18 16:42:08'),
(36, 'pooja', NULL, 'pooja@gmail.com', 'pooja_100', '$6$6000$UyWjyWKO0vk.E1.ROYaLW7D1leofjM2ozYcbZ1PL0vz6bCtHIPPhDPv0ljl6MBlyBttXny1iR4qMvr8jF5THe1', NULL, NULL, NULL, '2020-03-18 22:14:19', '2020-03-18 16:44:19'),
(37, 'kulddeep', NULL, 'kuldeep@gmail.com', '@kuldeep@122', '$6$6000$JO2McWJvMur2osyKSNlGrqE0pcyXFWTveH/9I67dRdjbPc5cVKcSaA77MeNizEREp2A/7xADiXVHTVjhnPcQF.', NULL, NULL, NULL, '2020-03-18 22:19:55', '2020-03-18 16:49:55'),
(38, 'Arvind Parkash', NULL, 'arvindparkash1999@gmail.com', '@arvind1999', '$6$6000$83lTvvTfnPy7T8RPrjJHXOde2aeCWZNUElDUHaFbO/qhiaw71D/mVOECR75m5ZtZrAMzz0.HfZ8Edz4aIA8LG0', NULL, NULL, NULL, '2020-03-27 21:32:02', '2020-03-27 16:02:02'),
(39, 'neena', NULL, 'neena@gmail.com', '@the_neena', '$6$6000$oSlwOQLS.Ng7mPIaZYwrCDALvI.zlPH6s9NIm8tP5uPqu6jQOHuXXt.fmvGHylELI5YncUzHkPrnclhKS1iZu0', NULL, NULL, NULL, '2020-04-04 22:22:53', '2020-04-04 16:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_image`
--
-- Creation: Jan 15, 2020 at 06:15 AM
--

CREATE TABLE `user_image` (
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_image` text CHARACTER SET utf8 COLLATE utf8_bin,
  `image` text CHARACTER SET utf8 COLLATE utf8_bin,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `user_image`:
--   `user_id`
--       `user` -> `user_id`
--

--
-- Dumping data for table `user_image`
--

INSERT INTO `user_image` (`image_id`, `user_id`, `profile_image`, `image`, `upload_date`) VALUES
(1, 20, 'wedding_location.jpg', 'cm.jpg', '2020-01-18 17:14:18'),
(2, 27, 'cm.jpg', 'people3.jpg', '2020-01-27 14:32:54'),
(3, 24, 'IMG-20181101-WA000820200401160140pm.jpg', 'IMG-20180311-WA002920200405140606pm.jpg', '2020-04-05 08:36:12'),
(4, 26, 'ar.jpg', 'sonu.jpg', '2020-01-28 19:02:39'),
(5, 22, 'camp20200213175345pm.jpg', 'IMG-20190930-WA000420200330144211pm.jpg', '2020-03-30 09:12:51'),
(6, 23, 'cars120200212231928pm.jpg', 'cmm20200212232045pm.jpg', '2020-02-12 17:50:47'),
(7, 25, 'camp20200213001654am.jpg', 'IMG-20190929-WA000420200330150909pm.jpg', '2020-03-30 09:39:11'),
(8, 37, NULL, 'IMG2018052307320320200404221548pm.jpg', '2020-04-04 16:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_image_p`
--
-- Creation: Feb 12, 2020 at 11:29 AM
--

CREATE TABLE `user_image_p` (
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_image` text CHARACTER SET utf8 COLLATE utf8_bin,
  `image` text CHARACTER SET utf8 COLLATE utf8_bin,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `user_image_p`:
--

--
-- Dumping data for table `user_image_p`
--

INSERT INTO `user_image_p` (`image_id`, `user_id`, `profile_image`, `image`, `upload_date`) VALUES
(1, 20, 'wedding_location.jpg', 'cm.jpg', '2020-01-18 17:14:18'),
(2, 27, 'cm.jpg', 'people3.jpg', '2020-01-27 14:32:54'),
(4, 26, 'ar.jpg', 'sonu.jpg', '2020-01-28 19:02:39'),
(6, 23, 'cars120200212231928pm.jpg', 'cmm20200212232045pm.jpg', '2020-02-12 17:50:45'),
(11, 25, NULL, 'IMG-20190930-WA000020200330153703pm.jpg', '2020-03-30 10:07:03'),
(13, 24, 'IMG-20180201-WA000420200405140719pm.jpg', 'IMG-20180201-WA000420200405140651pm.jpg', '2020-04-05 08:37:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_notification`
--
ALTER TABLE `all_notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `comment_like`
--
ALTER TABLE `comment_like`
  ADD PRIMARY KEY (`comment_like_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_Id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `comment_reply`
--
ALTER TABLE `comment_reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactId`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_data`
--
ALTER TABLE `post_data`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_Id` (`user_Id`),
  ADD KEY `share_parent_id` (`share_parent_id`);

--
-- Indexes for table `post_like`
--
ALTER TABLE `post_like`
  ADD PRIMARY KEY (`like_co_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `reply_like`
--
ALTER TABLE `reply_like`
  ADD PRIMARY KEY (`reply_like_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `reply_id` (`reply_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportId`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suggest`
--
ALTER TABLE `suggest`
  ADD PRIMARY KEY (`suggestId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_image_p`
--
ALTER TABLE `user_image_p`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_notification`
--
ALTER TABLE `all_notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_like`
--
ALTER TABLE `comment_like`
  MODIFY `comment_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `comment_reply`
--
ALTER TABLE `comment_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contactId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `post_data`
--
ALTER TABLE `post_data`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `post_like`
--
ALTER TABLE `post_like`
  MODIFY `like_co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `reply_like`
--
ALTER TABLE `reply_like`
  MODIFY `reply_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suggest`
--
ALTER TABLE `suggest`
  MODIFY `suggestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_image_p`
--
ALTER TABLE `user_image_p`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_like`
--
ALTER TABLE `comment_like`
  ADD CONSTRAINT `comment_like_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `post_comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_like_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_like_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_reply`
--
ALTER TABLE `comment_reply`
  ADD CONSTRAINT `comment_reply_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `post_comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_reply_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_reply_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `post_comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_data`
--
ALTER TABLE `post_data`
  ADD CONSTRAINT `post_data_ibfk_1` FOREIGN KEY (`user_Id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_data_ibfk_2` FOREIGN KEY (`share_parent_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_like`
--
ALTER TABLE `post_like`
  ADD CONSTRAINT `post_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_like_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_like`
--
ALTER TABLE `reply_like`
  ADD CONSTRAINT `reply_like_ibfk_1` FOREIGN KEY (`reply_id`) REFERENCES `comment_reply` (`reply_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_like_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `post_comment` (`comment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_like_ibfk_4` FOREIGN KEY (`post_id`) REFERENCES `post_data` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_image`
--
ALTER TABLE `user_image`
  ADD CONSTRAINT `user_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table admin
--

--
-- Metadata for table all_notification
--

--
-- Metadata for table comment_like
--

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'nazriya', 'comment_like', '{\"sorted_col\":\"`comment_like` ASC\"}', '2020-03-17 08:43:18');

--
-- Metadata for table comment_reply
--

--
-- Metadata for table contact
--

--
-- Metadata for table post_comment
--

--
-- Metadata for table post_data
--

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'nazriya', 'post_data', '{\"CREATE_TIME\":\"2020-01-13 02:15:54\"}', '2020-04-04 16:02:50');

--
-- Metadata for table post_like
--

--
-- Metadata for table reply_like
--

--
-- Metadata for table report
--

--
-- Metadata for table share
--

--
-- Metadata for table suggest
--

--
-- Metadata for table user
--

--
-- Metadata for table user_image
--

--
-- Metadata for table user_image_p
--

--
-- Metadata for database nazriya
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
