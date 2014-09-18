-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 18, 2014 at 06:20 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collegeprospectnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `athlete_id` int(11) DEFAULT NULL,
  `coach_id` int(11) DEFAULT NULL,
  `leadership` tinyint(3) DEFAULT NULL,
  `work_ethic` tinyint(3) DEFAULT NULL,
  `primacy_go_to_guy` tinyint(3) DEFAULT NULL,
  `mental_toughness` tinyint(3) DEFAULT NULL,
  `composure` tinyint(3) DEFAULT NULL,
  `awareness` tinyint(3) DEFAULT NULL,
  `instincts` tinyint(3) DEFAULT NULL,
  `vision` tinyint(3) DEFAULT NULL,
  `conditioning` tinyint(3) DEFAULT NULL,
  `physical_toughness` tinyint(3) DEFAULT NULL,
  `tenacity` tinyint(3) DEFAULT NULL,
  `hustle` tinyint(3) DEFAULT NULL,
  `strength` tinyint(3) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `add_date` date DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `athlete_id`, `coach_id`, `leadership`, `work_ethic`, `primacy_go_to_guy`, `mental_toughness`, `composure`, `awareness`, `instincts`, `vision`, `conditioning`, `physical_toughness`, `tenacity`, `hustle`, `strength`, `status`, `add_date`, `modified_date`) VALUES
(26, 86, 52, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 1, '2012-02-20', '2012-02-20 04:28:49'),
(27, 182, 141, 6, 9, 6, 7, 8, 9, 8, 8, 8, 6, 4, 9, 5, 1, '2012-02-29', '2012-02-29 22:17:43'),
(28, 88, 58, 9, 9, 9, 8, 9, 8, 8, 8, 8, 9, 8, 9, 9, 1, '2012-03-04', '2012-03-05 00:11:56'),
(29, 80, 154, 6, 9, 3, 7, 7, 8, 7, 5, 9, 9, 8, 8, 5, 1, '2012-03-09', '2012-03-09 02:47:23'),
(30, 269, 171, 10, 10, 10, 9, 9, 9, 10, 10, 9, 10, 10, 10, 10, 1, '2012-03-22', '2012-03-22 22:47:00'),
(31, 284, 186, 10, 10, 10, 10, 9, 10, 10, 10, 9, 8, 8, 8, 8, 1, '2012-04-10', '2012-04-10 17:09:42'),
(32, 301, 144, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 9, 1, '2012-04-17', '2012-04-17 14:25:40'),
(33, 306, 224, 9, 9, 6, 10, 7, 9, 10, 9, 9, 10, 10, 10, 9, 1, '2012-04-18', '2012-04-18 11:18:37'),
(34, 313, 219, 6, 9, 3, 4, 4, 5, 5, 5, 5, 5, 10, 10, 5, 1, '2012-04-18', '2012-04-18 23:19:54'),
(35, 312, 219, 9, 10, 9, 9, 8, 8, 8, 7, 10, 10, 10, 10, 10, 1, '2012-04-18', '2012-04-18 23:22:39'),
(36, 330, 219, 8, 8, 8, 8, 8, 7, 7, 6, 7, 6, 7, 6, 8, 1, '2012-04-25', '2012-04-25 00:03:19'),
(37, 344, 243, 8, 8, 8, 9, 10, 8, 8, 8, 9, 8, 8, 8, 8, 1, '2012-05-23', '2012-05-23 18:23:34'),
(38, 368, 260, 9, 9, 10, 8, 8, 10, 10, 10, 8, 8, 7, 8, 8, 1, '2012-08-21', '2012-08-21 09:54:10'),
(39, 382, 263, 10, 10, 10, 10, 9, 9, 9, 9, 10, 9, 10, 10, 10, 1, '2012-08-25', '2012-08-25 19:17:03'),
(40, 437, 293, 9, 10, 9, 10, 9, 10, 8, 10, 10, 10, 10, 10, 10, 1, '2013-03-22', '2013-03-22 08:09:11'),
(41, 438, 293, 9, 10, 10, 10, 10, 10, 10, 9, 10, 9, 10, 10, 10, 1, '2013-03-22', '2013-03-22 08:36:43'),
(42, 439, 293, 9, 10, 9, 10, 9, 10, 10, 10, 10, 10, 10, 10, 10, 1, '2013-03-22', '2013-03-22 08:59:18'),
(43, 440, 293, 10, 10, 9, 10, 9, 10, 9, 9, 10, 10, 10, 10, 10, 1, '2013-03-23', '2013-03-23 00:31:26'),
(44, 289, 293, 9, 9, 10, 10, 10, 10, 10, 9, 10, 9, 10, 10, 10, 1, '2013-03-23', '2013-03-23 02:33:38'),
(45, 428, 290, 8, 9, 7, 9, 6, 7, 8, 6, 8, 9, 9, 10, 8, 1, '2013-04-11', '2013-04-11 13:59:35'),
(46, 453, 290, 5, 7, 5, 5, 5, 5, 5, 5, 5, 8, 9, 5, 9, 1, '2013-05-03', '2013-05-03 13:27:04'),
(47, 460, 297, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 1, '2013-05-11', '2013-05-11 07:26:36'),
(48, 464, 297, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 1, '2013-05-11', '2013-05-11 07:26:57'),
(49, 466, 298, 7, 8, 8, 6, 6, 9, 8, 9, 8, 8, 8, 8, 6, 1, '2013-05-24', '2013-05-24 13:12:01'),
(50, 485, 299, 10, 10, 9, 10, 10, 10, 10, 10, 10, 10, 10, 10, 9, 1, '2013-08-07', '2013-08-07 18:28:22');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
