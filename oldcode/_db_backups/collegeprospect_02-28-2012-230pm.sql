-- phpMyAdmin SQL Dump
-- version 3.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2012 at 04:28 PM
-- Server version: 5.1.53
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db142079_cpn`
--
CREATE DATABASE `db142079_cpn` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db142079_cpn`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addtonetwork_request`
--

CREATE TABLE IF NOT EXISTS `tbl_addtonetwork_request` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `collegeid` varchar(50) DEFAULT NULL,
  `athleteid` int(50) DEFAULT NULL,
  `athname` varchar(50) DEFAULT NULL,
  `status` varchar(16) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `uemail` varchar(150) NOT NULL,
  `usertype` varchar(10) NOT NULL DEFAULT 'admin',
  `status` varchar(15) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `uemail`, `usertype`, `status`) VALUES
(2, 'admin', 'admin123', 'mike@teknicks.com', 'admin', '1'),
(4, 'mike', 'gretzky99', 'mike@teknicks.com', 'admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_athelete_register`
--

CREATE TABLE IF NOT EXISTS `tbl_athelete_register` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldUsername` varchar(50) DEFAULT NULL,
  `fldPassword` varchar(50) DEFAULT NULL,
  `fldEmail` varchar(60) DEFAULT NULL,
  `fldFirstname` varchar(50) DEFAULT NULL,
  `fldDemo` int(5) DEFAULT '0',
  `fldLastname` varchar(50) DEFAULT NULL,
  `fldClass` varchar(50) DEFAULT NULL,
  `fldHeight` varchar(50) DEFAULT NULL,
  `fldWeight` varchar(50) DEFAULT NULL,
  `fldSport` varchar(50) DEFAULT NULL,
  `fldPrimaryPosition` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldSecondaryPosition` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldVertical` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldDescription` text,
  `fldSchool` varchar(50) DEFAULT NULL,
  `fldCoach` varchar(50) DEFAULT NULL,
  `fldImage` varchar(50) DEFAULT 'default.jpg',
  `fldStatus` varchar(20) DEFAULT 'DEACTIVE',
  `fldOthers` varchar(50) DEFAULT NULL,
  `fldComments` text,
  `fldDivision` varchar(255) DEFAULT NULL,
  `fld40_yardDash` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldShuttleRun` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldBenchPressMax` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldSquatMax` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldGPA` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldSATScore` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldACTScore` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldClassRank` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldClearinghouseEligible` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT 'No',
  `fldIntendedMajor` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldApproveCoachId` int(11) DEFAULT '0',
  `fldAdminAthleticStat` varchar(255) DEFAULT '0',
  `fldQuestion` varchar(255) DEFAULT NULL,
  `fldAnswer` varchar(255) DEFAULT NULL,
  `fldState` varchar(255) DEFAULT NULL,
  `fldJerseyNumber` varchar(255) DEFAULT NULL,
  `fldAddDate` date DEFAULT NULL,
  `fldDateLastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldNotificationSent` int(11) DEFAULT '0',
  PRIMARY KEY (`fldId`),
  UNIQUE KEY `fldUsername` (`fldUsername`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

--
-- Dumping data for table `tbl_athelete_register`
--

INSERT INTO `tbl_athelete_register` (`fldId`, `fldUsername`, `fldPassword`, `fldEmail`, `fldFirstname`, `fldDemo`, `fldLastname`, `fldClass`, `fldHeight`, `fldWeight`, `fldSport`, `fldPrimaryPosition`, `fldSecondaryPosition`, `fldVertical`, `fldDescription`, `fldSchool`, `fldCoach`, `fldImage`, `fldStatus`, `fldOthers`, `fldComments`, `fldDivision`, `fld40_yardDash`, `fldShuttleRun`, `fldBenchPressMax`, `fldSquatMax`, `fldGPA`, `fldSATScore`, `fldACTScore`, `fldClassRank`, `fldClearinghouseEligible`, `fldIntendedMajor`, `fldApproveCoachId`, `fldAdminAthleticStat`, `fldQuestion`, `fldAnswer`, `fldState`, `fldJerseyNumber`, `fldAddDate`, `fldDateLastUpdated`, `fldNotificationSent`) VALUES
(57, 'Njee4208', 'colts55', 'njee_armstrong@yahoo.com', 'Njee', 0, 'Armstrong', '2012', '5-10', '156-170', '11', 'Point Guard', 'Shooting Guard', '', 'I live in Lake Charles Louisiana.\r\nIm 17 years old born April 12, 1994', '295', NULL, 'cpn_1328064928.jpg', 'ACTIVE', '', '', '', '', '', '', '', '2.0-2.5', '', '', '', 'No', 'Education', 0, '0', 'what is your brothers job', 'Navy', 'New Jersey', '15', '2012-01-17', '2012-02-20 00:13:39', 0),
(86, 'teknicksmike', 'teknicks', 'evolvemk@gmail.com', 'Demo', 0, 'Athlete', '2013', '6-2', '186-200', '10', 'Quarterback (QB)', 'Running Back (RB)', '33 inches', 'Lionel Eugene Dotson, Jr. (born February 11, 1985 in Houston, Texas) is an American football defensive end for the Buffalo Bills of the National Football League. \r\n\r\nHe was drafted by the Miami Dolphins in the seventh round of the 2008 NFL Draft. He played college football at Arizona.', '568', NULL, 'cpn_1329749253.png', 'ACTIVE', '', 'Demo Athlete is a good kid with a great work ethic and upside.', 'DivisionI', '4.8 seconds', '9.4 seconds', '225 lbs.', '410 lbs.', '3.6-4.0', '1601-1800', '26-30', 'Top 10% - Top 6%', 'No', 'Liberal Arts', 52, '0', 'Best hockey player', 'gretzky', 'New Jersey', '99', '2012-02-19', '2012-02-24 19:18:35', 0),
(87, 'lthomas17', 'thomas', 'lthomS@dadeschools.net', 'Lily', 0, 'Thomas', '2013', '5-10', '156-170', '12', '', '', '', '', '145', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Education', 65, '0', 'schpol mascot?', 'bucanner', 'Florida', '25', '2012-02-20', '2012-02-21 19:02:17', 0),
(88, 'mikelatucker', 'summitcds3', 'mikelatucker@aol.com', 'Mikela', 0, 'Tucker', '2014', '6-2', '156-170', '12', NULL, NULL, NULL, NULL, '439', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'My dogs name', 'Bethany', 'Texas', '34', '2012-02-20', '2012-02-20 22:43:22', 0),
(72, 'Raven Pappion', 'nike0930', 'ciara.pappion@yahoo.com', 'Raven', 1, 'Pappion', '2012', '5-2', 'under140', '12', '', '', '', NULL, '292', NULL, 'default.jpg', 'DEACTIVE', '', '', '', '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'Whats my favorite number ?', '99', 'Louisiana', '14', '2012-01-26', '2012-02-08 13:57:13', 0),
(80, 'kendall2195', 'takailah', 'kendall2195@gmail.com', 'Kendall', 0, 'Wright', '2012', '5-8', '156-170', '11', '', '', '', '', '295', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Engineering', 0, '0', 'favorite point guard', 'chris paul', 'Louisiana', '4', '2012-02-14', '2012-02-25 14:55:34', 0),
(89, 'Jarren', 'jmoney', 'jarren28@gmail.com', 'Jarren', 0, 'McBryde', '2013', '6-0', '186-200', '10', NULL, NULL, NULL, NULL, '285', NULL, 'default.jpg', 'ACTIVE', '', 'This kid is super athletic, can play all of the skill positions, and excell at anyone of them. Pure Athlete.', 'DivisionI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 78, '0', 'what number am i', '2', 'New Jersey', '2', '2012-02-21', '2012-02-21 16:09:51', 0),
(90, 'chris nelson', 'chris24', 'chrisnelson2455@yahoo.com', 'Chris', 0, 'Nelson', '2014', '6-3', '246-260', '10', '', '', '', '', '595', NULL, 'default.jpg', 'ACTIVE', '', 'Good kid with GPA', 'DivisionI', '', '', '', '', '', '', '', '', 'No', 'Business', 98, '0', 'when was i born', '1995', 'Florida', '26', '2012-02-21', '2012-02-21 19:22:54', 0),
(91, 'bryan23', 'hunters3', 'bryanrice37@yahoo.com', 'Bryan', 0, 'Rice', '2013', '6-0', '156-170', '10', '', '', '', '', '595', NULL, 'default.jpg', 'ACTIVE', '', 'Goood kid', 'DivisionII', '', '', '', '', '', '', '', '', 'No', 'Other', 98, '0', 'what my first uncle name', 'gary', 'Florida', '58', '2012-02-21', '2012-02-21 19:23:24', 0),
(92, 'anthonytubbs64', 'tubbz55', 'anthonytubbs15@gmail.com', 'Anthony', 0, 'Tubbs', '2013', '5-8', 'Over260', '10', NULL, NULL, NULL, NULL, '595', NULL, 'default.jpg', 'ACTIVE', '', 'good kid', 'DivisionII', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Engineering', 98, '0', 'whats your jersey number', '64', 'Florida', '64', '2012-02-21', '2012-02-21 19:24:03', 0),
(93, 'tonyreeves', 'moota28', 'moota087@gmail.com', 'Anthony', 0, 'Reeves', '2013', '5-6', '171-185', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Engineering', 0, '0', 'What is mom name?', 'vanessa', 'Florida', '28', '2012-02-21', '2012-02-21 19:01:38', 0),
(94, 'justin henderson', 'hatchet33', 'hatchethenderson@yahoo.com', 'Justin', 0, 'Henderson', '2015', '5-8', '186-200', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Math', 0, '0', 'my team is', 'jets', 'Florida', '25', '2012-02-21', '2012-02-21 19:01:05', 0),
(95, 'Luke Hiers', 'lhiers54', 'lukehiers1@gmail.com', 'Luke', 0, 'Hiers', '2015', '6-2', '246-260', '10', NULL, NULL, NULL, NULL, '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Agriculture', 0, '0', 'am i tall', 'yes', 'Florida', '54', '2012-02-21', '2012-02-21 17:57:07', 0),
(96, 'zacharysorrentino', 'mason0521', 'zacharysorrentino@yahoo.com', 'Zachary', 0, 'Sorrentino', '2013', '6-3', '', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'am i tall', 'yes', 'Florida', '66', '2012-02-21', '2012-02-21 19:00:29', 0),
(97, 'Andre18', 'erickaa1494', 'erickakablacknight@yahoo.com', 'Erick', 0, 'Andre', '2012', '6-2', '201-215', '10', NULL, NULL, NULL, NULL, '597', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'What year were you born', '04141994', 'Florida', '18', '2012-02-21', '2012-02-21 18:01:55', 0),
(98, 'festa22', 'kingfesta', 'dakarialscott@ymail.com', 'Dakarial', 0, 'Scott', '2013', '5-11', '186-200', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Engineering', 0, '0', 'favorite uncle', 'steve', 'Florida', '22', '2012-02-21', '2012-02-21 18:59:44', 0),
(99, 'Jayce Webster', 'dec1094', 'websterjayce@yahoo.com', 'Jayce', 0, 'Webster', '2013', '5-9', '141-155', '10', '', '', '', '', '572', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'birthday', 'december 10 1994', '', '6', '2012-02-21', '2012-02-21 18:59:16', 0),
(100, 'Dillanfontaine', 'kicker07', 'dillanfontaine@aol.com', 'Dillan', 0, 'Fontaine', '2012', '6-1', '156-170', '10', '', '', '', '', '598', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Business', 0, '0', 'Whats your position and number', 'kicker plus 7', 'Florida', '7', '2012-02-21', '2012-02-21 18:58:31', 0),
(101, 'godenzic94', 'Torrington1', 'godenzic94@hotmail.com', 'Cameron', 0, 'Godenzi', '2012', '6-2', '216-230', '10', NULL, NULL, NULL, NULL, '598', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 0, '0', 'where was i born', 'Connecticut', 'Florida', '64', '2012-02-21', '2012-02-21 18:13:25', 0),
(102, 'jermelmoment', 'jermelmoment', 'momentjermel@ymail.com', 'Jermel', 0, 'Moment', '2013', '5-9', '171-185', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Undecided / General Studies', 0, '0', 'whats your favorite color?', 'blue', 'Florida', '27', '2012-02-21', '2012-02-21 18:58:00', 0),
(103, 'cameron', 'youngboss1', 'edwardscameron22@yahoo.com', 'Cameron', 0, 'Edwards', '2015', '6-3', '156-170', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Business', 0, '0', 'who is your mom', 'barbara mincy', 'Florida', '5', '2012-02-21', '2012-02-21 18:57:35', 0),
(104, 'eddiej05', 'eddiej98', 'ebabilw30@ymail.com', 'Edward', 0, 'Joseph', '2015', '5-8', '186-200', '10', '', '', '', '', '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Business', 0, '0', 'who&#39;s your favorite uncles', 'jessie', 'Florida', '5', '2012-02-21', '2012-02-21 18:57:07', 0),
(105, 'Leon', '423703', 'woodie.hawthorne@yahoo.com', 'Leon', 0, 'Hawthorne', '2015', '5-11', '201-215', '10', NULL, NULL, NULL, NULL, '563', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'nickname', 'woodie', 'Florida', '2', '2012-02-21', '2012-02-21 18:32:01', 0),
(106, 'lorenzo12', 'howa3466232', 'myshell7@verizon.net', 'Lorenzo', 0, 'Howard', '2015', '6-0', '141-155', '10', NULL, NULL, NULL, NULL, '597', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Math', 0, '0', 'my NAME', 'LORENZO', 'Florida', '28-80', '2012-02-21', '2012-02-21 18:34:39', 0),
(107, 'darius2020', 'alice34', 'darius.williams59@yahoo.com', 'Darius', 0, 'Williams', '2012', '5-11', '171-185', '10', '', '', '', '', '605', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'what is your football number', '2', 'Florida', '2', '2012-02-21', '2012-02-22 16:38:26', 0),
(108, 'dom 21', 'beatrice21', 'kelli_3@comcast.net', 'Domaneek', 0, 'Brown-Hurd', '2013', '6-0', '216-230', '10', NULL, NULL, NULL, NULL, '285', NULL, 'default.jpg', 'ACTIVE', '', 'Strong, powerful athlete, able to play multiple postitions.\r\nWeightroom warrior.', 'DivisionI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 78, '0', 'grand mother name', 'mommom', 'New Jersey', '21', '2012-02-21', '2012-02-22 13:15:48', 0),
(109, 'Austin', '52reiter', 'reiter52@hotmail.com', 'Austin', 0, 'Reiter', '2012', '6-1', '201-215', '10', NULL, NULL, NULL, NULL, '605', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Architecture', 0, '0', 'Mothers Name', 'Jule', 'Florida', '52', '2012-02-21', '2012-02-21 20:08:30', 0),
(110, 'clandrum', 'cannon', 'landrum@consolidated.net', 'Cannon', 0, 'Landrum', '2013', '5-8', '141-155', '10', NULL, NULL, NULL, NULL, '586', NULL, 'default.jpg', 'ACTIVE', '', 'Cannon is a very hard worker and a tough competitor.  He lacks great size, but plays extremely hard.  He is also a very intelligent player.', 'DivisionIII', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Engineering', 82, '0', '1st born', 'cannon', 'Texas', '37', '2012-02-21', '2012-02-21 22:45:26', 0),
(111, 'RNOON12', 'chase2006', 'Rnoon123@yahoo.com', 'Ryan', 0, 'Noon', '2013', '6-0', '171-185', '10', 'Quarterback (QB)', 'Safety (S)', '', '', '604', NULL, 'default.jpg', 'ACTIVE', '', 'Athletic, good work ethic, tough competitor and has good football knowledge.  ', NULL, '', '', '250', '300', '', '', '', '', 'No', 'Undecided / General Studies', 100, '0', 'What&#39;s my dogs name', 'Chase', 'New Jersey', '12', '2012-02-21', '2012-02-22 20:33:49', 0),
(113, 'willcioffi94', 'bulldog94', 'willcioffi94@gmail.com', 'Will', 0, 'Cioffi', '2013', '5-11', '201-215', '10', '', '', '', '', '604', NULL, 'default.jpg', 'ACTIVE', '', 'Athletic, strong, powerful athlete.  Good instincts, has a nose for the football, good tackler.', 'DivisionI', '', '', '', '', '', '', '', '', 'No', 'Undecided / General Studies', 100, '0', 'where did we get angus', 'the puppy stop', 'New Jersey', '32', '2012-02-21', '2012-02-22 16:37:48', 0),
(114, 'shelbyhaggard22', 'cvilleathenians2211', 'shelbyhaggard22@yahoo.com', 'Shelby', 0, 'Haggard', '2013', '', '', '12', NULL, NULL, NULL, NULL, '268', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'please contact us using Contact Page', '1313851005', 'Indiana', '22', '2012-02-21', '2012-02-21 21:36:17', 0),
(115, 'Simons_B', 'HMSathlete', 'mijoseivert@iowatelecom.net', 'Blake', 0, 'Simons', '2015', '6-4', '186-200', '11', 'Shooting Guard', 'Small Forward', '', '', '608', NULL, 'default.jpg', 'ACTIVE', '', 'Blake is a 14 year old, freshman guard who finished this season as our second leading scorer. He is a very skilled, long athlete that is currently 6&#39;4 with more room to grow. He is a smooth, explosive athlete and has great shooting touch. Has participated in both the University of Minnesota and University of Iowa basketball skills camps. Will participate on the AAU level within the state of Iowa this summer.', 'DivisionII', '', '', '', '', '3.6-4.0', '', '', 'Top 10% - Top 6%', 'No', 'Undecided / General Studies', 102, '0', 'Who is my receivers coach?', 'Coach Raymond', 'Iowa', '24-25', '2012-02-21', '2012-02-23 03:28:59', 0),
(116, 'bryant', 'rhodes', 'hitmanrhodes11@yahoo.com', 'Bryant', 0, 'Rhodes', '2013', '6-1', '141-155', '10', '', '', '', '', '591', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'what is my girlfriend name', 'hannah', 'Arkansas', '11', '2012-02-22', '2012-02-22 18:28:04', 0),
(117, 'alexholt7', 'AlexHolt7', 'sunshine951089@hotmail.com', 'Alex', 0, 'Holt', '2013', '6-0', '171-185', '10', NULL, NULL, NULL, NULL, '591', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What is your mom&#39;s middle name?', 'Denise', 'Arkansas', '7', '2012-02-22', '2012-02-22 20:05:01', 0),
(118, 'bigred', 'C112257', 'toottinghambigred@aol.com', 'Austin', 0, 'Tottingham', '2013', '6-1', 'Over260', '10', NULL, NULL, NULL, NULL, '586', NULL, 'default.jpg', 'ACTIVE', '', 'Austin has the potential to be an excellent football player.  He has good size, is strong and moves well.  With a lot of hard work and dedication over the next few months he could become an outstanding player.', 'DivisionII', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 82, '0', 'What is my middle name?', 'Tyler', 'Texas', '76', '2012-02-22', '2012-02-23 15:07:50', 0),
(119, 'Jase_saulsbury', 'coltsfootball', 'jase_saulsbury@yahoo.com', 'Jase', 0, 'Saulsbury', '2013', '6-0', '171-185', '10', NULL, NULL, NULL, NULL, '591', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What is my nickname?', 'i dont have one', 'Arkansas', '3', '2012-02-22', '2012-02-23 04:28:58', 0),
(120, 'Demetrius Anderson', 'pb23083009', 'Demejoe@aol.com', 'Demetrius', 0, 'Anderson', '2012', '5-10', '201-215', '10', '', '', '', '', '619', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Engineering', 0, '0', 'Who&#39;s your favorite uncles', 'uncle frank', 'Florida', '22', '2012-02-23', '2012-02-24 21:04:57', 0),
(121, 'fred taylor', 'tre4561', 'flt1993@yahoo.com', 'Fred', 0, 'Taylor', '2012', '5-10', '156-170', '10', '', '', '', '', '619', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'whats your position and number?', '6 and wide receiver and return', 'Florida', '6', '2012-02-23', '2012-02-24 20:55:59', 0),
(122, 'Tyshiek Wright', 'dolphins25', 'shiekyolo@ymail.com', 'Tyshiek', 0, 'Wright', '2013', '5-9', '156-170', '10', NULL, NULL, NULL, NULL, '285', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Arts', 78, '0', 'where im from?', 'backmaryland', 'New Jersey', '3', '2012-02-23', '2012-02-24 13:25:26', 0),
(123, 'RobertGlanville', 'football23', 'Ri.glanville@comcast.net', 'Robert', 0, 'Glanville', '2013', '6-0', '186-200', '10', NULL, NULL, NULL, NULL, '285', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 78, '0', 'Whats my dogs name', 'Lana', 'New Jersey', '52', '2012-02-24', '2012-02-24 13:26:37', 0),
(124, 'keithnm51', 'killer1234', 'keithnm51@gmail.com', 'Theodore', 0, 'Griffin', '2013', '6-0', '246-260', '10', NULL, NULL, NULL, NULL, '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Computers / Information Technology', 0, '0', 'what do i love', 'computers', 'Florida', '51', '2012-02-25', '2012-02-25 18:46:56', 0),
(125, 'jglasser', 'hotmail211995', 'jglasser20@yahoo.com', 'Jake', 0, 'Glasser', '2013', '5-10', '201-215', '10', NULL, NULL, NULL, NULL, '620', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Engineering', 116, '0', 'Favorite color?', 'blue', 'California', '9', '2012-02-25', '2012-02-25 22:48:22', 0),
(126, 'JEstinor', 'j8202541', 'jeanrestinor@yahoo.com', 'Jean', 0, 'Estinor', '2013', '6-2', '246-260', '10', NULL, NULL, NULL, NULL, '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Engineering', 0, '0', 'What is your middle name?', 'Rodner', 'Florida', '76', '2012-02-25', '2012-02-25 23:56:15', 0),
(127, 'David5', '0034182dp', 'david_phanor@yahoo.com', 'david', 0, 'phanor', '2013', '6-2', '171-185', '10', NULL, NULL, NULL, NULL, '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 0, '0', 'what my mom name', 'irenne c phanor', 'Florida', '5', '2012-02-25', '2012-02-26 00:03:40', 0),
(128, 'shawn', 'shawndricka2011', 'shawndrickasmith@yahoo.com', 'Dashawn', 0, 'Smith', '2013', '5-8', '156-170', '10', '', '', '', '', '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'pet name', 'king', 'Florida', '4', '2012-02-25', '2012-02-28 21:16:55', 0),
(129, 'Eden_Jilot', 'mac305', 'eden.jilot@yahoo.com', 'Eden', 0, 'Jilot', '2013', '6-1', 'Over260', '10', NULL, NULL, NULL, NULL, '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What&#39;s My Nickname?', 'Big Meech', 'Florida', '65', '2012-02-25', '2012-02-26 01:21:42', 0),
(130, 'Brent Breslau', 'fplancer1', 'bbreslau2013@francisparker.org', 'Brent', 0, 'Breslau', '2013', '6-1', '186-200', '10', NULL, NULL, NULL, NULL, '620', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Science', 116, '0', 'What is your dog&#39;s name?', 'Hayden', 'California', 'n/a', '2012-02-25', '2012-02-26 02:08:45', 0),
(131, 'Lloyd_warrior', 'lloyd123', 'NIcklloyd@neo.rr.com', 'Nick', 0, 'Lloyd', '2015', '5-10', '171-185', '10', NULL, NULL, NULL, NULL, '621', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 0, '0', 'what is your freshmen football jersey number?', '42', 'Ohio', '42', '2012-02-25', '2012-02-26 02:26:32', 0),
(132, 'mazza0416', 'balla1', 'mazza0416@yahoo.com', 'Anthony', 0, 'Mazza', '2013', '6-2', '171-185', '10', NULL, NULL, NULL, NULL, '622', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'whats my moms name?', 'candace', 'Florida', '7', '2012-02-26', '2012-02-26 18:34:20', 0),
(133, 'Jasonjonengel', 'momdad', 'jasonjonengel@aol.com', 'jason', 0, 'engel', '2013', '6-2', '201-215', '10', NULL, NULL, NULL, NULL, '622', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'Whats my moms name?', 'Jody', 'Florida', '33', '2012-02-26', '2012-02-26 18:36:46', 0),
(134, 'razzy', 'raz123', 'raziel_pena@yahoo.com', 'Raziel', 0, 'Pena Vargas', '2012', '6-0', '201-215', '10', NULL, NULL, NULL, NULL, '622', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'where were you born', 'salem', 'Florida', '44/39', '2012-02-26', '2012-02-26 18:42:16', 0),
(135, '1mikeconey', '3tankwezzy', 'Minchaelconey28@yahoo.com', 'Michael', 0, 'Coney', '2012', '5-8', '141-155', '10', '', '', '', '', '622', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'whats the key to greatness', 'humble', 'Florida', '1', '2012-02-26', '2012-02-26 19:39:56', 0),
(136, 'julian12', 'ballplayer33', 'jumann10@gmail.com', 'Julian', 0, 'Gray', '2012', '5-10', '186-200', '10', NULL, NULL, NULL, NULL, '622', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'Whats my moms name?', 'julie', '', '30', '2012-02-26', '2012-02-26 18:45:20', 0),
(137, 'brutus', 'polowit3', 'witerson@yahoo.com', 'witerson', 0, 'brutus', '2012', '5-11', '201-215', '10', NULL, NULL, NULL, NULL, '623', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'high school name?', 'boyd anderson high', 'Florida', '17', '2012-02-26', '2012-02-26 18:48:25', 0),
(138, 'vildor8', 'sh0wtime', 'vildor8@yahoo.com', 'Blundy', 0, 'Vildor', '2012', '6-2', 'Over260', '10', NULL, NULL, NULL, NULL, '144', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 117, '0', 'Whats your position?', 'Center', 'Florida', '54', '2012-02-26', '2012-02-26 19:01:15', 0),
(139, 'Shad757', 'map4life', 'Shadharris65@yahoo.com', 'Breshad', 0, 'Harris', '2012', '6-0', '171-185', '10', NULL, NULL, NULL, NULL, '624', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Communications', 0, '0', 'my first dog', 'spot', 'Florida', '3', '2012-02-26', '2012-02-26 18:58:14', 0),
(140, 'Shad7576', 'map4life', 'Shadharris65@yahoo.com', 'Breshad', 0, 'Harris', '2012', '', '', '10', NULL, NULL, NULL, NULL, '624', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Communications', 0, '0', 'my first dog', 'spot', 'Florida', '3', '2012-02-26', '2012-02-26 18:59:29', 0),
(141, 'MStroud134', '134fougeron', 'big-mike24@live.com', 'Michael', 0, 'Stroud', '2012', '6-0', '231-245', '10', NULL, NULL, NULL, NULL, '144', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Computers / Information Technology', 117, '0', 'Mothers Name', 'Mary Bernice Douglas', 'Florida', '56', '2012-02-26', '2012-02-27 13:34:41', 0),
(142, 'jseays', 'jlove1313', 'seaysjustin@yshoo.com', 'Justin', 0, 'Seays', '2012', '6-1', '246-260', '10', '', '', '', '', '623', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Business', 0, '0', 'julie', 'julie', 'Florida', '13/', '2012-02-26', '2012-02-28 21:14:30', 0),
(143, 'Jdbrady2013', 'Parkland15', 'jdbrady2013@aol.com', 'John', 0, 'Brady', '2013', '6-0', '246-260', '10', NULL, NULL, NULL, NULL, '625', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 0, '0', 'What city were you born in?', 'Coral Springs', 'Florida', '45', '2012-02-26', '2012-02-26 19:14:23', 0),
(144, 'MrJD56', 'naruto', 'jes_del56@yahoo.com', 'Jess', 0, 'Delgardo', '2012', '6-4', '216-230', '10', NULL, NULL, NULL, NULL, '144', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 117, '0', 'Best man at you wedding?', 'Heavy D', 'Florida', '66', '2012-02-26', '2012-02-27 13:36:39', 0),
(145, 'ryan', 'navarro55', 'navarro230@gmail.com', 'Ryan', 0, 'Navarro', '2012', '6-2', '231-245', '10', '', '', '', '', '145', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'moms last name', 'garcia', 'Florida', '55', '2012-02-26', '2012-02-28 21:16:31', 0),
(146, 'Nathaniel Dionte Jones', 'mimrin', 'NdionteJ@gmail.com', 'Nathaniel', 0, 'Jones', '2012', '6-1', '156-170', '10', NULL, NULL, NULL, NULL, '626', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What was your first pet&#39;s name?', 'Baxter', 'Florida', '30', '2012-02-26', '2012-02-26 19:23:26', 0),
(147, 'shonnardo bodie', '07211992', 'sb0698008714@yahoo.com', 'Shonnardo', 0, 'Bodie', '2012', '6-0', '201-215', '10', '', '', '', '', '144', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Engineering', 117, '0', 'favorite food', 'everything', 'Florida', '14/54', '2012-02-26', '2012-02-28 21:14:03', 0),
(148, 'willie', 'wewe123', 'will.brown78@yahoo.com', 'Willie', 0, 'Brown', '2012', '5-9', '156-170', '10', '', '', '', '', '627', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, '', '', '', '', '', '', '', '', 'No', 'Other', 0, '0', 'were i was born', 'deerfield beach', 'Florida', '5', '2012-02-26', '2012-02-28 21:12:40', 0),
(149, 'Kitlo Meme', 'Creek2', 'kitlom@yahoo.com', 'Kitlo', 0, 'Meme', '2012', '5-11', '186-200', '10', NULL, NULL, NULL, NULL, '627', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 0, '0', 'What city were you born in?', 'Haiti', 'Florida', '1', '2012-02-26', '2012-02-26 19:43:23', 0),
(150, 'jbaker_11', 'mygoal1', 'baker.jamari@ymail.com', 'Ja&#39;Mari', 0, 'Baker', '2014', '5-10', '141-155', '11', NULL, NULL, NULL, NULL, '286', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What&#39;s my nickname?', 'j-smoove or baker', 'Georgia', '11', '2012-02-26', '2012-02-27 01:03:23', 0),
(151, 'Zachschmid', 'Parker88', 'Zachschmid@yahoo.com', 'Zachary', 0, 'Schmid', '2014', '6-0', '201-215', '10', NULL, NULL, NULL, NULL, '620', NULL, 'default.jpg', 'ACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Other', 116, '0', 'what is combined name of both dogs', 'Parkerberty', 'California', '33', '2012-02-26', '2012-02-27 03:50:15', 0),
(152, 'Charles_Romane', 'charles305', 'eden.jilot@yahoo.com', 'Charles', 0, 'Romane', '2013', '5-9', '171-185', '10', NULL, NULL, NULL, NULL, '606', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'What&#39;s My Nickname?', 'He Loose', 'Florida', '7', '2012-02-27', '2012-02-28 02:22:49', 0),
(153, 'LeonMiles1', 'baller10', 'Miles_leon@yahoo.com', 'Leon', 0, 'Miles', '2013', '5-9', '171-185', '10', NULL, NULL, NULL, NULL, '572', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Undecided / General Studies', 0, '0', 'my moms middle name?', 'Latrice', 'California', '1', '2012-02-28', '2012-02-28 18:09:01', 0),
(154, 'Rob_Scott21', 'lilrob21', 'R.scott33@yahoo.com', 'Robert', 0, 'Scott', '2012', '5-10', '156-170', '10', NULL, NULL, NULL, NULL, '629', NULL, 'default.jpg', 'DEACTIVE', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'No', 'Business', 0, '0', 'My first pet dog name', 'Smokey', 'Florida', '21', '2012-02-28', '2012-02-28 21:24:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_athelete_stat`
--

CREATE TABLE IF NOT EXISTS `tbl_athelete_stat` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldPrograme` int(11) NOT NULL,
  `fldAtheleteId` int(11) DEFAULT NULL,
  `fldCategoryId` int(11) NOT NULL,
  `fldValue` varchar(255) DEFAULT NULL,
  `fldLabelname` varchar(255) NOT NULL,
  `fldStatus` int(2) DEFAULT '0',
  `fldCoachId` int(15) NOT NULL,
  `fldSportid` int(15) NOT NULL,
  `fldAddDate` date DEFAULT NULL,
  `fldModifiedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldGroup` varchar(50) DEFAULT '',
  `fldSortOrder` int(11) DEFAULT '100',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=422 ;

--
-- Dumping data for table `tbl_athelete_stat`
--

INSERT INTO `tbl_athelete_stat` (`fldId`, `fldPrograme`, `fldAtheleteId`, `fldCategoryId`, `fldValue`, `fldLabelname`, `fldStatus`, `fldCoachId`, `fldSportid`, `fldAddDate`, `fldModifiedDate`, `fldGroup`, `fldSortOrder`) VALUES
(418, 124, 86, 90, '0', 'Extra Points Attempted', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 240),
(419, 124, 86, 91, '0', 'Punt Average', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 250),
(415, 124, 86, 87, '0', 'Field Goals Attempted', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 210),
(416, 124, 86, 88, '0', 'Longest Field Goal', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 220),
(417, 124, 86, 89, '0', 'Extra Points Made', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 230),
(414, 124, 86, 86, '0', 'Field Goals Made', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 200),
(413, 124, 86, 85, '0', 'Punt Return TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 190),
(412, 124, 86, 81, '64', 'Punt Return Yards', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 180),
(411, 124, 86, 82, '2', 'Punt Return Attempts', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 170),
(410, 124, 86, 84, '0', 'Kick Return TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 160),
(408, 124, 86, 80, '1', 'Kick Returns Attempts', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 140),
(409, 124, 86, 79, '15', 'Kick Return Yards', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 150),
(407, 124, 86, 77, '1', 'Defensive TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 130),
(406, 124, 86, 75, '1', 'Forced Fumbles', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 120),
(405, 124, 86, 74, '1', 'Interceptions', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 110),
(404, 124, 86, 83, '0', 'Special Teams TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Special Teams', 100),
(403, 124, 86, 76, '2', 'Recovered Fumbles', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 100),
(402, 124, 86, 73, '2', 'Pass Deflections', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 100),
(401, 124, 86, 72, '10', 'Sacks', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 100),
(400, 124, 86, 69, '1', 'Receiving TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 97),
(399, 124, 86, 68, '86', 'Receiving Yards', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 94),
(398, 124, 86, 56, '7', 'Receptions', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 90),
(397, 124, 86, 71, '3', 'Tackles for a Loss', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 86),
(396, 124, 86, 70, '3', 'Tackles', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Defense', 80),
(395, 124, 86, 67, '2', 'Rushing TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 70),
(394, 124, 86, 55, '140', 'Rushing Yards', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 60),
(393, 124, 86, 66, '14', 'Rushing Attempts', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 50),
(392, 124, 86, 65, '4', 'Passing TDs', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 40),
(391, 124, 86, 54, '3', 'Passing Yards', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 30),
(390, 124, 86, 64, '2', 'Passing Attempts', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 20),
(389, 124, 86, 63, '1', 'Passing Completions', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:08', 'Offense', 10),
(420, 124, 86, 92, '0', 'Longest Punt', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 260),
(421, 124, 86, 93, '0', 'Punts Inside the 20', 1, 52, 10, '2012-02-28', '2012-02-28 07:46:09', 'Special Teams', 270);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_athlete_stats_catagory`
--

CREATE TABLE IF NOT EXISTS `tbl_athlete_stats_catagory` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(255) DEFAULT NULL,
  `fldNameint` varchar(255) NOT NULL,
  `fldParentId` varchar(11) DEFAULT '0',
  `fldStatus` varchar(255) DEFAULT '0',
  `fldGroup` varchar(50) DEFAULT '',
  `fldSortOrder` int(11) DEFAULT '500',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `tbl_athlete_stats_catagory`
--

INSERT INTO `tbl_athlete_stats_catagory` (`fldId`, `fldName`, `fldNameint`, `fldParentId`, `fldStatus`, `fldGroup`, `fldSortOrder`) VALUES
(39, 'Rebounds', 'RPG', '11', '1', 'Defense', 30),
(62, 'Two-pointers Attempted', '2PA', '11', '1', 'Offense', 120),
(43, 'Turnovers', 'TOs', '11', '1', 'Defense', 60),
(61, 'Two-pointers Made', '2PM', '11', '1', 'Offense', 110),
(38, 'Points', 'PPG', '11', '1', 'Offense', 10),
(55, 'Rushing Yards', 'RUYDS', '10', '1', 'Offense', 60),
(42, 'Blocks', 'BPG', '11', '1', 'Defense', 50),
(41, 'Steals', 'SPG', '11', '1', 'Defense', 40),
(40, 'Assists', 'APG', '11', '1', 'Offense', 20),
(44, 'Three-Pointers Made', '3PM', '11', '1', 'Offense', 130),
(45, 'Three-Pointers Attempted', '3PA', '11', '1', 'Offense', 140),
(46, 'Free Throws Made', 'FTM', '11', '1', 'Offense', 90),
(47, 'Free Throws Attempted', 'FTA', '11', '1', 'Offense', 100),
(54, 'Passing Yards', 'PYDS', '10', '1', 'Offense', 30),
(56, 'Receptions', 'REC', '10', '1', 'Offense', 90),
(63, 'Passing Completions', 'PCS', '10', '1', 'Offense', 10),
(64, 'Passing Attempts', 'PAT', '10', '1', 'Offense', 20),
(66, 'Rushing Attempts', 'RATT', '10', '1', 'Offense', 50),
(65, 'Passing TDs', 'PTDS', '10', '1', 'Offense', 40),
(67, 'Rushing TDs', 'RUTDS', '10', '1', 'Offense', 70),
(68, 'Receiving Yards', 'RYDS', '10', '1', 'Offense', 94),
(69, 'Receiving TDs', 'RECTDS', '10', '1', 'Offense', 97),
(70, 'Tackles', 'TACK', '10', '1', 'Defense', 80),
(71, 'Tackles for a Loss', 'TCKFL', '10', '1', 'Defense', 86),
(72, 'Sacks', 'SACK', '10', '1', 'Defense', 100),
(73, 'Pass Deflections', 'PDEF', '10', '1', 'Defense', 100),
(74, 'Interceptions', 'INT', '10', '1', 'Defense', 110),
(75, 'Forced Fumbles', 'FFUM', '10', '1', 'Defense', 120),
(76, 'Recovered Fumbles', 'RFUM', '10', '1', 'Defense', 100),
(77, 'Defensive TDs', 'DEFTD', '10', '1', 'Defense', 130),
(79, 'Kick Return Yards', 'KRYDS', '10', '1', 'Special Teams', 150),
(80, 'Kick Returns Attempts', 'KRATT', '10', '1', 'Special Teams', 140),
(81, 'Punt Return Yards', 'PRYDS', '10', '1', 'Special Teams', 180),
(82, 'Punt Return Attempts', 'PRATT', '10', '1', 'Special Teams', 170),
(83, 'Special Teams TDs', 'STTDS', '10', '1', 'Special Teams', 100),
(84, 'Kick Return TDs', 'KRTDS', '10', '1', 'Special Teams', 160),
(85, 'Punt Return TDs', 'PRTDs', '10', '1', 'Special Teams', 190),
(86, 'Field Goals Made', 'FGM', '10', '1', 'Special Teams', 200),
(87, 'Field Goals Attempted', 'FGA', '10', '1', 'Special Teams', 210),
(88, 'Longest Field Goal', 'LFG', '10', '1', 'Special Teams', 220),
(89, 'Extra Points Made', 'XPM', '10', '1', 'Special Teams', 230),
(90, 'Extra Points Attempted', 'XPA', '10', '1', 'Special Teams', 240),
(91, 'Punt Average', 'PA', '10', '1', 'Special Teams', 250),
(92, 'Longest Punt', 'LP', '10', '1', 'Special Teams', 260),
(93, 'Punts Inside the 20', 'P20', '10', '1', 'Special Teams', 270);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_athlete_video`
--

CREATE TABLE IF NOT EXISTS `tbl_athlete_video` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldTitle` varchar(255) DEFAULT NULL,
  `fldVideo` text,
  `fldAddDate` date DEFAULT NULL,
  `fldStatus` int(11) DEFAULT '0',
  `fldAthleteId` int(11) DEFAULT '0',
  `fldVideoType` varchar(25) DEFAULT 'Original (not trimmed)',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `tbl_athlete_video`
--

INSERT INTO `tbl_athlete_video` (`fldId`, `fldTitle`, `fldVideo`, `fldAddDate`, `fldStatus`, `fldAthleteId`, `fldVideoType`) VALUES
(95, 'My New Video Title', 'cpn_86-1330096999.flv', '2012-02-24', 0, 86, 'Original (not trimmed)'),
(98, 'My New Video Title', 'cpn_86-1330097676.flv', '2012-02-24', 1, 86, 'Highlight Video');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE IF NOT EXISTS `tbl_banner` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldTitle` varchar(255) DEFAULT NULL,
  `fldImage` varchar(255) DEFAULT NULL,
  `fldThirdParty` text,
  `fldPosition` varchar(255) NOT NULL,
  `fldStatus` int(11) DEFAULT '0',
  `fldAddDate` date DEFAULT '0000-00-00',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`fldId`, `fldTitle`, `fldImage`, `fldThirdParty`, `fldPosition`, `fldStatus`, `fldAddDate`) VALUES
(4, 'Athlete Profile Bottom Right', '', '<a href=&#34;http://www.jdoqocy.com/click-3709056-10583520&#34; target=&#34;_top&#34;>\r\n<a href=&#34;http://www.jdoqocy.com/click-3709056-10925341&#34; target=&#34;_top&#34;>\r\n<img src=&#34;http://www.awltovhc.com/image-3709056-10925341&#34; width=&#34;275&#34; height=&#34;200&#34; alt=&#34;Shop for NCAA Team Gear at Fanatics&#34; border=&#34;0&#34;/></a>', 'bottom-left', 1, '2011-07-23'),
(2, 'example', '', '<a href=&#34;http://www.kqzyfj.com/click-3709056-10789811&#34; target=&#34;_top&#34;> <img\r\nsrc=&#34;http://www.ftjcfx.com/image-3709056-10789811&#34; width=&#34;125&#34;\r\nheight=&#34;125&#34; alt=&#34;Build Your Body With Muscle & Strength!&#34; border=&#34;0&#34;/></a>', 'bottom-left', 1, '2011-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_block_message`
--

CREATE TABLE IF NOT EXISTS `tbl_block_message` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldFrom` varchar(50) DEFAULT NULL,
  `fldSport` varchar(50) DEFAULT NULL,
  `fldTo` varchar(50) DEFAULT NULL,
  `fldStartdate` date DEFAULT '0000-00-00',
  `fldEndDate` date DEFAULT '0000-00-00',
  `fldStatus` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_block_message`
--

INSERT INTO `tbl_block_message` (`fldId`, `fldFrom`, `fldSport`, `fldTo`, `fldStartdate`, `fldEndDate`, `fldStatus`) VALUES
(11, 'college', '10', 'athlete', '2011-10-27', '2011-10-05', 'unblocked'),
(14, 'college', '11', 'athlete', '2011-10-25', '2011-10-27', 'blocked'),
(15, 'college', '10', 'athlete', '2011-10-25', '2011-10-26', 'unblocked'),
(16, 'coach', '12', 'athlete', '2011-10-25', '2011-10-29', 'unblocked');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_catagory`
--

CREATE TABLE IF NOT EXISTS `tbl_catagory` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(255) DEFAULT NULL,
  `fldDescription` text,
  `fldStatus` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_catagory`
--

INSERT INTO `tbl_catagory` (`fldId`, `fldName`, `fldDescription`, `fldStatus`) VALUES
(9, 'Division III', 'All NCAA Division III athletic programs fall under this category.', 1),
(10, 'Junior College', 'All Junior College Division I and Junior College Division II athletic programs fall under this category.', 1),
(8, 'Division I', 'All NCAA Division I athletic programs fall under this category.', 1),
(6, 'Division II', 'All NCAA Division II athletic programs fall under this category.', 1),
(11, 'N.A.I.A.', 'All National Association of Intercollegiate Athletics athletic programs fall under this category.', 1),
(12, 'High School and Prep School', 'All high school and prep school athletic programs fall under this category.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE IF NOT EXISTS `tbl_class` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldClass` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`fldId`, `fldClass`) VALUES
(1, '2012'),
(2, '2013'),
(22, '2014'),
(23, '2015');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college`
--

CREATE TABLE IF NOT EXISTS `tbl_college` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(100) DEFAULT NULL,
  `fldAddress` text,
  `fldCity` varchar(50) DEFAULT NULL,
  `fldState` varchar(50) DEFAULT NULL,
  `fldZipCode` varchar(50) DEFAULT NULL,
  `fldStatus` int(11) DEFAULT '1',
  `fldDivison` varchar(100) DEFAULT NULL,
  `fldLatitude` float DEFAULT NULL,
  `fldLongitude` float DEFAULT NULL,
  `fldAdminApproved` int(1) DEFAULT '1',
  `fldAddByCollegeUsername` varchar(50) DEFAULT NULL,
  `fldAddDate` date DEFAULT NULL,
  `fldDateLastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `tbl_college`
--

INSERT INTO `tbl_college` (`fldId`, `fldName`, `fldAddress`, `fldCity`, `fldState`, `fldZipCode`, `fldStatus`, `fldDivison`, `fldLatitude`, `fldLongitude`, `fldAdminApproved`, `fldAddByCollegeUsername`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(62, 'San Jacinto College', '8060 Spencer Hwy.', 'Pasadena', 'Texas', '77505', 1, 'JUCO', 48.9734, 24.0033, 0, 'san_jac', '2012-02-20', '2012-02-20 06:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college_coach_register`
--

CREATE TABLE IF NOT EXISTS `tbl_college_coach_register` (
  `fldId` int(50) NOT NULL AUTO_INCREMENT,
  `fldUserName` varchar(75) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `fldPassword` varchar(60) NOT NULL,
  `fldStatus` varchar(20) DEFAULT 'ACTIVE',
  `fldCollegecode` varchar(50) DEFAULT NULL,
  `fldCollegename` varchar(50) DEFAULT NULL,
  `fldCity` varchar(50) DEFAULT NULL,
  `fldState` varchar(30) DEFAULT NULL,
  `fldAddress` text,
  `fldZipCode` varchar(50) DEFAULT NULL,
  `fldSport` varchar(50) DEFAULT NULL,
  `fldCoachname` varchar(25) DEFAULT NULL,
  `fldPosition` varchar(75) DEFAULT NULL,
  `fldNeedType` int(11) DEFAULT NULL,
  `fldLastPaymentType` varchar(50) DEFAULT NULL,
  `fldLastPaymentDate` date DEFAULT NULL,
  `fldLastPayAmount` float(10,2) DEFAULT '0.00',
  `fldEmail` varchar(75) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `fldAlternativeEmail` varchar(75) DEFAULT NULL,
  `fldFirstName` varchar(75) NOT NULL,
  `fldLastName` varchar(75) NOT NULL,
  `fldPhone` varchar(75) DEFAULT NULL,
  `fldAlternativePhone` varchar(75) DEFAULT NULL,
  `fldDivison` varchar(75) DEFAULT NULL,
  `fldQuestion` varchar(100) DEFAULT NULL,
  `fldAnswer` varchar(100) DEFAULT NULL,
  `fldNeeds` varchar(100) DEFAULT NULL,
  `fldEnrollmentNumber` varchar(100) DEFAULT NULL,
  `fldSubscribe` int(11) DEFAULT '2',
  `fldSubscriptionType` varchar(50) DEFAULT NULL,
  `fldCancelCount` int(11) DEFAULT NULL,
  `fldCancelDate` date DEFAULT NULL,
  `fldReason` text,
  `fldOtherReason` text,
  `fldAddDate` date DEFAULT NULL,
  `fldDateLastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `tbl_college_coach_register`
--

INSERT INTO `tbl_college_coach_register` (`fldId`, `fldUserName`, `fldPassword`, `fldStatus`, `fldCollegecode`, `fldCollegename`, `fldCity`, `fldState`, `fldAddress`, `fldZipCode`, `fldSport`, `fldCoachname`, `fldPosition`, `fldNeedType`, `fldLastPaymentType`, `fldLastPaymentDate`, `fldLastPayAmount`, `fldEmail`, `fldAlternativeEmail`, `fldFirstName`, `fldLastName`, `fldPhone`, `fldAlternativePhone`, `fldDivison`, `fldQuestion`, `fldAnswer`, `fldNeeds`, `fldEnrollmentNumber`, `fldSubscribe`, `fldSubscriptionType`, `fldCancelCount`, `fldCancelDate`, `fldReason`, `fldOtherReason`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(74, 'san_jac', 'san_jac', 'ACTIVE', NULL, '62', 'Pasadena', 'Texas', '8060 Spencer Hwy.', '77505', '10', NULL, 'Assistant Coach', 10, NULL, '2012-02-20', 14.99, 'thefather34@hotmail.com', '', 'Demo', 'College', '(281) 993-9933', '', 'JUCO', 'san_jac', 'san_jac', NULL, '', 2, 'Monthly Subscription - $14.99 (Monthly)', 0, NULL, NULL, NULL, '2012-02-20', '2012-02-28 02:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE IF NOT EXISTS `tbl_event` (
  `fldEventId` int(11) NOT NULL AUTO_INCREMENT,
  `fldEventName` text,
  `fldSport` int(255) DEFAULT NULL,
  `fldEventDescription` text,
  `fldEventLocation` text,
  `fldEventStartDate` datetime DEFAULT NULL,
  `fldEventEndDate` datetime DEFAULT NULL,
  `fldHomeTeam` int(255) DEFAULT NULL,
  `fldAwayTeam` int(255) DEFAULT NULL,
  `fldEventOpponent` varchar(255) DEFAULT NULL,
  `fldEventStatus` tinyint(3) DEFAULT '0',
  `fldUserName` varchar(255) DEFAULT NULL,
  `fld_PaymentDate` varchar(255) DEFAULT NULL,
  `fld_TransectionId` varchar(255) DEFAULT NULL,
  `fld_PaymentStatus` varchar(255) DEFAULT NULL,
  `fld_UserType` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fldEventId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`fldEventId`, `fldEventName`, `fldSport`, `fldEventDescription`, `fldEventLocation`, `fldEventStartDate`, `fldEventEndDate`, `fldHomeTeam`, `fldAwayTeam`, `fldEventOpponent`, `fldEventStatus`, `fldUserName`, `fld_PaymentDate`, `fld_TransectionId`, `fld_PaymentStatus`, `fld_UserType`) VALUES
(123, 'Middletown HS North - NJ vs. Linden High School - NJ', 10, '', '63 Tindall Road\r\nMiddletown, New Jersey 07748', '2012-01-06 08:49:00', '2012-01-06 10:49:00', 568, 541, NULL, 1, 'teknicksmike', NULL, NULL, NULL, 'athlete'),
(124, 'Middletown HS North - NJ vs. North Bergen High School - NJ', 10, '', '63 Tindall Road\r\nMiddletown, New Jersey 07748', '2012-02-25 07:30:00', '2012-02-25 09:30:00', 568, 542, NULL, 1, 'teknicksmike', NULL, NULL, NULL, 'athlete');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_subsription`
--

CREATE TABLE IF NOT EXISTS `tbl_event_subsription` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(255) DEFAULT NULL,
  `fldCost` float(10,2) DEFAULT '0.00',
  `fldStatus` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_content`
--

CREATE TABLE IF NOT EXISTS `tbl_home_content` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldTitle` varchar(255) DEFAULT NULL,
  `fldDescription` text,
  `fldStatus` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_home_content`
--

INSERT INTO `tbl_home_content` (`fldId`, `fldTitle`, `fldDescription`, `fldStatus`) VALUES
(1, 'College Programs', '<p class=&#34;content&#34;>College Prospect Network is the only recruiting website that screens our athletes before allowing them to register. Join today and gain access to our entire database of players who have all been approved and rated by the people who see them play every day, their high school and AAU coaches. Watch the 30-second video to the right for a quick preview then click the link below to join the Free Five-Day Trial today and find your difference-maker.</p>', 1),
(2, 'High School and AAU Coaches', '<p class=&#34;content&#34;>College Prospect Network understands that you care about your student-athletes and want to see them succeed. As such, our website is designed to make it as easy as possible for you to help your players connect with a college program that fits their talent level and personality. CPN is 100 percent free for you and your athletes to join. Watch the 30-second video to the right for a quick tour and then register to begin helping your athletes.</p>', 1),
(3, 'Athletes', '<p class=&#34;content&#34;>Are you talented enough to play college sports but for some reason you are under-recruited? It happens every year to hundreds of athletes all over the country but College Prospect Network is here to help. It is 100 percent free for you to join our site. All you have to do is apply by clicking the link below and filling out the application form. Watch the short video to the right and get started today!&nbsp;</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_coach`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_coach` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldUsername` varchar(50) NOT NULL,
  `fldPassword` varchar(50) NOT NULL,
  `fldName` varchar(60) DEFAULT NULL,
  `fldLastName` varchar(50) DEFAULT NULL,
  `fldEmail` varchar(60) DEFAULT NULL,
  `fldAEmail` varchar(50) DEFAULT NULL,
  `fldPhone` varchar(50) DEFAULT NULL,
  `fldAPhone` varchar(50) DEFAULT NULL,
  `fldDescription` varchar(60) DEFAULT NULL,
  `fldSchool` varchar(20) DEFAULT NULL,
  `fldSport` varchar(50) DEFAULT NULL,
  `fldPosition` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldStatus` varchar(60) DEFAULT NULL,
  `fldQuestion` varchar(255) NOT NULL,
  `fldAnswer` varchar(255) NOT NULL,
  `fldAddDate` date DEFAULT NULL,
  `fldDateLastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

--
-- Dumping data for table `tbl_hs_aau_coach`
--

INSERT INTO `tbl_hs_aau_coach` (`fldId`, `fldUsername`, `fldPassword`, `fldName`, `fldLastName`, `fldEmail`, `fldAEmail`, `fldPhone`, `fldAPhone`, `fldDescription`, `fldSchool`, `fldSport`, `fldPosition`, `fldStatus`, `fldQuestion`, `fldAnswer`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(44, 'Coach Bill', 'TEAMTEXAS', 'Bill', 'Williams', 'STEELBILLHOOPS@YAHOO.COM', '', '4694630788', '', NULL, '226', '11', 'COACH', 'ACTIVE', 'best laker player', 'KOBE', '2012-01-17', '2012-02-21 19:58:14'),
(54, 'kswartwood', 'clyde22', 'Kevin', 'Swartwood', 'kswartwood@muhsd.k12.ca.us', '', '209 769-9845', '', NULL, '572', '10', 'Head Football Coach', 'ACTIVE', 'What is Mom&#39;s Maiden name?', 'Barno', '2012-02-20', '2012-02-20 17:02:42'),
(52, 'teknickshs', 'teknicks', 'Christian', 'Gaviria', 'evolvemk@gmail.com', 'evolmk@gmail.com', '7323916145', '7325002212', NULL, '568', '11', 'Head Basketball Coach', 'ACTIVE', 'Best hockey player', 'gretzky', '2012-02-19', '2012-02-21 10:55:13'),
(53, 'mrtonythomas', 'tt9312', 'Tony', 'Thomas', 'tthomas@cville.k12.in.us', 'tt74354@yahoo.com', '765.366.6901', '765.362.5284', NULL, '268', '12', 'Head Coach', 'ACTIVE', 'mother&#39;s maiden name', 'Beville', '2012-02-20', '2012-02-20 15:50:36'),
(59, 'tewing', 'Mustangs11', 'Tj', 'Ewing', 'tewing@egusd.net', '', '916-688-0050 x4251', '916-688-0050 x4267', NULL, '570', '10', 'Varsity Head Football Coach', 'ACTIVE', 'my question', '0000000051446', '2012-02-20', '2012-02-20 18:31:37'),
(58, 'ttuckers', 'alby52', 'Terry', 'Tucker', 'ttucker@emeryweiner.org', '', '513-284-6098', '832-204-5900', NULL, '569', '12', 'Girls Varsity Basketball Coach', 'ACTIVE', 'my question', '00000009', '2012-02-20', '2012-02-20 18:30:05'),
(60, 'Tammy Velasco', '121975cw', 'Tammy', 'Velasco', 'tvelasco@logan.echalk.com', 'velascotammy@yahoo.com', '575-403-5952', '', NULL, '578', '12', 'Assistant Coach', 'ACTIVE', 'my question', '002105616535', '2012-02-20', '2012-02-20 18:36:36'),
(61, 'jeffry1', 'rasta1', 'Jeff', 'Hildebrand', 'hildebrandj@wra.net', 'hildebrandj@wra.net', '330-696-7178', '', NULL, '571', '10', 'Head Coach', 'ACTIVE', 'my question', '64135433843843', '2012-02-20', '2012-02-20 18:38:42'),
(62, 'edmc06', 'frostbite', 'Edward', 'McMillon', 'mcmiec@fusd.net', 'edmc06@aol.com', '909-714-5084', '909-357-6300', NULL, '579', '10', 'Head Football Coach', 'ACTIVE', 'question', '15126548400', '2012-02-20', '2012-02-20 18:43:18'),
(68, 'RTiller2', '0123456', 'Ray', 'Tiller', 'Tillerr@Duvalschools.org', 'RTiller2@Yahoo.com', '904-240-5022', '904-630-6760', NULL, '582', '10', 'Head', 'ACTIVE', 'fav number', 'six', '2012-02-20', '2012-02-20 19:29:14'),
(64, 'dwilkins', 'nickelfish25', 'Dave', 'Wilkins', 'dwilkins@plainsisd.net', '', '806-786-9048', '', NULL, '573', '10', 'Offensive backs and defensive line', 'ACTIVE', 'my question', '02515141358', '2012-02-20', '2012-02-20 18:45:26'),
(65, 'cbart002', 'kathryn3', 'collin', 'bartley', 'cbartley@dadeschool.net', 'cbartley@dadeschools.net', '7866237097', '7866237097', NULL, '145', '12', 'coach', 'ACTIVE', 'what is the name of pet', 'blanky', '2012-02-20', '2012-02-20 18:52:34'),
(67, 'Coach Shawn Clark', 'irish2012', 'Shawn', 'Clark', 'sclark@bmchs.org', '', '4057353128', '', NULL, '581', '12', 'n/a', 'ACTIVE', 'Where did I go to College?', 'Oklahoma', '2012-02-20', '2012-02-20 19:27:40'),
(69, 'Bruin', 'Ncarolina1', 'Kevin', 'Bianco', 'Kbianco0508@yahoo.com', 'Kbianco23@hotmail.com', '201-602-8187', '', NULL, '542', '11', 'Head coach', 'ACTIVE', 'Favorite football team', 'Raiders', '2012-02-20', '2012-02-20 19:48:40'),
(116, 'John Morrison', '2yardline', 'John', 'Morrison', 'jmorrison@francisparker.org', '', '858-569-7900', '', NULL, '620', '10', 'Head Coach', 'ACTIVE', 'Mother&#39;s maiden name', 'Schram', '2012-02-25', '2012-02-25 22:31:14'),
(117, 'Rome3233', 'jah3233', 'Jerome', 'Harriott', 'jerome.harriott@gmail.com', 'jeromeflexx@yahoo.com', '7865215233', '', NULL, '144', '10', 'AHC/OC', 'ACTIVE', 'Fathers Middle Name', 'Patrick', '2012-02-26', '2012-02-26 18:59:44'),
(72, 'jpmeyer33', 'tylercash', 'Justin', 'Meyer', 'jmeyer@twpunionschools.org', 'Motley74J@verizon.net', '732-598-7097', '732-952-5958', NULL, '522', '12', 'Head Coach', 'ACTIVE', 'What is your Mother&#39;s Maiden name?', 'Rossi', '2012-02-20', '2012-02-20 22:23:59'),
(73, 'jaynia', 'carrie27', 'Jerry', 'Williams', 'jwilliams@swlahealth.org', '', '337564-6497', '337405-8832', NULL, '295', '11', 'Head Coach', 'ACTIVE', 'my favor color', 'black', '2012-02-20', '2012-02-20 22:50:18'),
(74, 'Ole Ball Coach King', '96impalass', 'Towandi', 'King', 'towandi.king@dooly.k12.ga.us', 'jawjaboytk@gmail.com', '2299470901', '2292688428', NULL, '286', '11', 'Head Coach', 'ACTIVE', 'What is the name of the whip?', 'Avalanche', '2012-02-20', '2012-02-21 02:00:32'),
(75, 'Ray Fenton', '111111', 'Ray', 'Fenton', 'coachrayfenton@yahoo.com', 'rfenton@webb.org', '702 759 2749', '0', NULL, '583', '10', 'Head Football Coach', 'ACTIVE', 'where do you coach', 'webb', '2012-02-20', '2012-02-21 04:44:58'),
(76, 'coronado', 'Nicki07', 'David', 'Coronado', 'dcoronad@egusd.net', 'coronado7@hotmail.com', '916-515-4670', '', NULL, '570', '10', 'Coach', 'ACTIVE', 'School mascot', 'Honker', '2012-02-21', '2012-02-21 05:39:29'),
(78, 'tkelly', 'omarlove2445', 'Thomas', 'Kelly', 'tkelly@acboe.org', '', '609-892-3139', '', NULL, '285', '10', 'Head Coach', 'ACTIVE', 'first elementary school', 'westside', '2012-02-21', '2012-02-21 13:19:36'),
(79, 'Bucks71762', 'bucks1', 'brian', 'strickland', 'outlawswin@msn.com', 'brian.strickland@smackover.net', '870-557-0619', '870-725-3101', NULL, '591', '10', 'Head Football Coach', 'ACTIVE', 'What is my school mascot?', 'Buckaroo', '2012-02-21', '2012-02-21 16:33:53'),
(80, 'aaronabel', 'spacemanspiff', 'Aaron', 'Abel', 'aaron.abel@wsh2.k12.wy.us', 'aaronabel2010@gmail.com', '307-899-2093', '307-366-2233', NULL, '589', '11', 'Head Coach', 'ACTIVE', 'what was your first car', 'lizard', '2012-02-21', '2012-02-21 16:25:56'),
(81, 'coachbob', 'sylf65', 'Robert', 'Hurtado', 'rhurtad2@tularehhsa.org', 'sylf65@hotmail.com', '559-789-7902', '', NULL, '585', '10', 'Head Coach', 'ACTIVE', 'High school football team mascot', 'Cardinals', '2012-02-21', '2012-02-21 15:13:20'),
(82, 'John Bolfing', '3727', 'John', 'Bolfing', 'jbolfing@misd.org', '', '936-597-3116', '', NULL, '586', '10', 'Head Football Coach', 'ACTIVE', 'Mothers Maiden Name', 'Oakes', '2012-02-21', '2012-02-21 15:21:28'),
(83, 'ElkCity22', 'ElkCity', 'Jason', 'Scheck', 'scheck.jason@elkcityschools.com', '', '580-374-1603', '580-225-5793', NULL, '587', '10', 'Head Coach', 'ACTIVE', 'Dogs Name?', 'Husker', '2012-02-21', '2012-02-21 15:41:40'),
(84, 'Billy Langford', 'bray5911', 'Billy', 'Langford', 'billylangford1@mooreschools.com', '', '405-735-4821', '', NULL, '588', '10', 'Head Football Coach', 'ACTIVE', 'Name of wife', 'natalie', '2012-02-21', '2012-02-21 16:19:01'),
(99, 'jnelso1', 'alexis888', 'Jeff', 'nelson', 'jnelso1@beaumont.k12.tx.us', '', '409-617-5474', '', NULL, '602', '10', 'Head Coach', 'ACTIVE', 'Daughters Name', 'alexis', '2012-02-21', '2012-02-21 19:27:56'),
(98, 'Jeff', '19Gate61', 'Jeff', 'Schaum', 'jschaum@victorylakeland.org', 'jeffschaum@hotmail.com', '863-858-6000', '850-212-0180', NULL, '595', '10', 'Head Coach', 'ACTIVE', 'mother&#39;s maiden name', 'Whitehill', '2012-02-21', '2012-02-21 19:21:17'),
(88, 'CoachB', '1tigercoach', 'Reginald', 'Bellamy', 'bellamyr@manateeschools.net', 'rjbtiger@gmail.com', '941-773-9374', '941-723-4848 ext. 2087', NULL, '590', '11', 'Head Coach', 'ACTIVE', 'What is mom name?', 'Lucinda', '2012-02-21', '2012-02-21 16:36:39'),
(97, 'catdeck', 'C112257', 'Christy', 'Tottingham', 'catdeck@aol.com', '', '936-851-2002', '936-525-7003', NULL, '586', '10', 'Offensive Lineman', 'ACTIVE', 'What was your first dog&#39;s name?', 'Cindy', '2012-02-21', '2012-02-21 19:15:25'),
(90, 'Hurricane', 'Scott39', 'Lavaar', 'Scott', 'Scottl@highlands.k12.fl.us', '', '863 214-3880', '', NULL, '592', '10', 'Head Coach', 'ACTIVE', 'My College', 'University of Miami', '2012-02-21', '2012-02-21 17:21:48'),
(92, 'dbourdon', 'db7011', 'Daniel', 'Bourdon', 'dbourdon.ahs@wscuhsd.k12.ca.us', 'dbourdon1@aol.com', '707-824-2318', '707-217-6321', NULL, '596', '10', 'Head Coach', 'ACTIVE', 'mother maiden name', 'angst', '2012-02-21', '2012-02-21 17:47:14'),
(93, 'CoachRobson', 'Wishbone', 'Dave', 'Robson', 'dave.robson@polk-fl.net', '', '863-661-3240', '', NULL, '599', '10', 'Head Coach', 'ACTIVE', 'Best Offense', 'Wishbone', '2012-02-21', '2012-02-21 18:23:24'),
(95, 'coachk31', '3131dk', 'Dustin', 'Kupcik', 'kupcik_d@hcsb.k12.fl.us', '', '3525846589', '', NULL, '594', '10', 'O-Line Coach', 'ACTIVE', 'pets name?', 'marlie', '2012-02-21', '2012-02-21 18:37:30'),
(100, 'skahoun', 'football', 'Sean', 'Kahoun', 'skahoun@pitman.k12.nj.us', 'stkahoun@yahoo.com', '856-589-2121 Ext 1230', '856-404-2507', NULL, '604', '10', 'Head Coach', 'ACTIVE', 'Dog&#39;s Name', 'Blitz', '2012-02-21', '2012-02-21 19:32:23'),
(101, 'Price Harris', 'cowboy65', 'Price', 'Harris', 'price.harris@polk-fl.net', '', '863.635.7876', '904.769.6374', NULL, '603', '10', 'Head Coach', 'ACTIVE', 'First Pets Name?', 'tayco', '2012-02-21', '2012-02-21 19:55:48'),
(102, 'HMS_Coach', 'SOSalumni17', 'Steve', 'Raymond', 'coachraymondhms@gmail.com', '', '712-260-8269', '', NULL, '608', '11', 'Head Boy&#39;s Basketball Coach', 'ACTIVE', 'What college did I graduate from?', 'Northwestern College', '2012-02-21', '2012-02-22 01:15:33'),
(103, 'bbeller', 'football', 'Brad', 'Beller', 'bbeller@washington.k12.ok.us', '', '405-831-0911', '', NULL, '610', '10', 'Head Coach', 'ACTIVE', 'the day that changed your life', 'december 9', '2012-02-22', '2012-02-24 21:43:31'),
(118, 'premierschool2124', 'tw9543411', 'Tabarus', 'Wright', 'tabaruswright@gmail.com', '', '954-6380920', '954-969-7172', NULL, '627', '10', 'Director', 'ACTIVE', 'Bird', 'Falcons', '2012-02-26', '2012-02-26 19:54:17'),
(105, 'aoharatexcan', 'michigan1', 'Andrew', 'OHara', 'aohara@texanscan.org', 'aohara@texanscan.org', '2109231226', '2109231226', NULL, '611', '11', 'Head Coach', 'ACTIVE', 'What is your mascot', 'Dragons', '2012-02-22', '2012-02-22 15:55:51'),
(106, 'evawarriors', 'greenblack', 'Ryan', 'Keith', 'rkeith@evajax.com', 'rkeith@evajax.com', '904 304-2925', '904 786-1411', NULL, '612', '10', 'Head Football Coach', 'ACTIVE', 'offense', 'air raid', '2012-02-22', '2012-02-22 16:46:40'),
(107, 'carmazzid', 'pirateship2011', 'Dan', 'Carmazzi', 'carmazzid@jhssac.org', '', '916-482-6060', '916-682-2171', NULL, '613', '10', 'Head Coach', 'ACTIVE', 'What is your wife&#39;s maiden name?', 'Parilo', '2012-02-22', '2012-02-24 21:45:17'),
(108, 'Ray Hermann', 'Cornhusker', 'Ray', 'Hermann', 'rhermann@suhsd.net', 'rchermann@sbcglobal.net', '530-222-6601', '530-604-2990', NULL, '119', '12', 'Head Coach', 'ACTIVE', 'Favorite team?', 'Nebraska Cornhuskers', '2012-02-22', '2012-02-22 18:05:20'),
(109, 'schew', 'freethrow', 'Sherman', 'Chew', 'chews@calcoisd.org', 'chewjr24@yahoo.com', '8064707529', '2814844668', NULL, '437', '12', 'Head Girls BB Coach', 'ACTIVE', 'My dream car', 'corvette', '2012-02-22', '2012-02-22 21:56:39'),
(110, 'pdawg3358', 'suns18', 'Patsy', 'Lombardi', 'sunsbball18@hotmail.com', '', '7328955596', '', NULL, '567', '11', 'Assistant', 'ACTIVE', 'favorite sport?', 'basketball', '2012-02-22', '2012-02-24 21:21:45'),
(111, 'bgregory20', 'mickeyg20', 'Brice', 'Gregory', 'gregoryfour@pldi.net', 'hotshotgregory@hotmail.com', '580-994-2140', '580-334-0296', NULL, '614', '10', 'quarterback, saftey', 'ACTIVE', 'Mother&#39;s maiden name?', 'Stephens', '2012-02-22', '2012-02-23 02:30:40'),
(112, 'barbara', 'basketballlady', 'barbara', 'wilburn', 'barbaraann102@hotmail.com', '', '8702700527', '', NULL, '615', '11', 'Head Coach', 'ACTIVE', 'Husband name', 'michael', '2012-02-23', '2012-02-23 16:58:50'),
(113, 'jarvisgibson', 'shaker12', 'Jarvis', 'Gibson', 'gibson_j@shaker.org', '', '216-295-2930', '216-470-9029', NULL, '616', '10', 'Head Football Coach', 'ACTIVE', 'My son name', 'junior', '2012-02-23', '2012-02-23 17:21:13'),
(114, 'blackmonr', 'anythang7', 'Roosevelt', 'Blackmon', 'roosevelt.blackmon@palmbeachschools.org', '', '561-261-3391', '561-993-440', NULL, '617', '10', 'Head Coach', 'ACTIVE', 'first car', 'chevy', '2012-02-23', '2012-02-23 23:36:35'),
(115, 'Nate Hawkins', 'aleigha0728', 'Nate', 'Hawkins', 'nhawkins@sedubois.k12.in.us', '', '812-661-9218', '', NULL, '271', '11', 'Head Coach', 'ACTIVE', 'What is Middle name of Father?', 'Edward', '2012-02-24', '2012-02-24 14:10:39'),
(119, 'Ujima333', 'Beach333', 'Norbert', 'Herriott', '284091@dadeschools.net', '284091@dadeschools.net', '8502187509', '3053248900', NULL, '213', '10', 'Linebackers', 'ACTIVE', 'Hometown', 'Myrtle Beach', '2012-02-26', '2012-02-27 03:51:26'),
(120, 'burch1159', 'bronson1', 'Stephen', 'Burcham', 'stephen.burcham@cowetaps.org', 'coweta59@gmail.com', '918-486-4474', '918-639-2524', NULL, '657', '10', 'Head Coach', 'ACTIVE', 'wifey', 'miranda', '2012-02-27', '2012-02-27 18:10:51'),
(121, 'jros_11', 'baseball', 'Jeremy', 'Rosenbalm', 'rosenbj@morrow.k12.or.us', '', '5416769138', '5419808159', NULL, '37', '11', 'Head Basketball Coach', 'ACTIVE', 'What subject do you teach?', 'math', '2012-02-27', '2012-02-27 19:06:55'),
(122, 'shields52', 'bryan1', 'steve', 'shields', 'shieldss@duvalschools.org', '', '904-266-1200', '', NULL, '658', '10', 'Head Coach', 'ACTIVE', 'wifes name', 'Jennifer', '2012-02-28', '2012-02-28 14:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_coach_rate`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_coach_rate` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldHs_Aau_Coach_id` int(11) DEFAULT NULL,
  `fld_College_Coach_id` int(11) DEFAULT NULL,
  `fldAthlete_contribue` tinyint(3) DEFAULT NULL,
  `fldComunication` tinyint(3) DEFAULT NULL,
  `fldRequest_Game_Tape` tinyint(3) DEFAULT NULL,
  `fldHonest` tinyint(3) DEFAULT NULL,
  `fldPrepration` tinyint(3) DEFAULT NULL,
  `fldStatus` tinyint(3) DEFAULT '1',
  `fldAddDate` date DEFAULT NULL,
  `fldmodifiedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_hs_aau_coach_rate`
--

INSERT INTO `tbl_hs_aau_coach_rate` (`fldId`, `fldHs_Aau_Coach_id`, `fld_College_Coach_id`, `fldAthlete_contribue`, `fldComunication`, `fldRequest_Game_Tape`, `fldHonest`, `fldPrepration`, `fldStatus`, `fldAddDate`, `fldmodifiedDate`) VALUES
(10, 52, 74, 10, 9, 9, 8, 9, 1, '2012-02-20', '2012-02-20 15:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_coach_sportposition`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_coach_sportposition` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldSportId` int(10) DEFAULT NULL,
  `fldPosition` varchar(255) DEFAULT NULL,
  `fldCoachNameId` int(10) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=291 ;

--
-- Dumping data for table `tbl_hs_aau_coach_sportposition`
--

INSERT INTO `tbl_hs_aau_coach_sportposition` (`fldId`, `fldSportId`, `fldPosition`, `fldCoachNameId`) VALUES
(178, 10, 'Head Football Coach', 75),
(169, 12, 'n/a', 67),
(168, 10, 'Head', 66),
(167, 12, 'coach', 65),
(166, 10, 'Offensive backs and defensive line', 64),
(165, 10, 'Head', 63),
(180, 10, 'Coach', 76),
(231, 11, 'Head Basketball Coach', 77),
(177, 10, 'LB/ RB Coach', 74),
(176, 11, 'Head Coach', 74),
(170, 10, 'Head', 68),
(171, 11, 'Head coach', 69),
(172, 12, 'Head Coach', 70),
(173, 12, 'Head Coach', 71),
(174, 12, 'Head Coach', 72),
(175, 11, 'Head Coach', 73),
(164, 10, 'Head Football Coach', 62),
(163, 10, 'Head Coach', 61),
(162, 12, 'Assistant Coach', 60),
(161, 10, 'Varsity Head Football Coach', 59),
(160, 12, 'Girls Varsity Basketball Coach', 58),
(159, 10, 'head football coach', 57),
(158, 11, 'assistant basketball coach', 57),
(232, 10, 'Head Coach', 78),
(157, 11, 'Assistant Coach', 56),
(156, 11, 'Coach', 55),
(155, 11, 'Head Coach test', 0),
(154, 10, 'Offensive backs and defensive line', 0),
(153, 10, 'Head Football Coach', 0),
(152, 10, 'Head Football Coach', 0),
(151, 10, 'Head Football Coach', 54),
(150, 10, 'Head Coach', 0),
(258, 11, 'COACH', 44),
(147, 10, 'Varsity Head Football Coach', 0),
(149, 10, 'Head Coach', 0),
(148, 12, 'Assistant Coach', 0),
(146, 12, 'Girls Varsity Basketball Coach', 0),
(145, 12, 'Head Coach', 53),
(230, 10, 'Head Football Coach', 52),
(229, 11, 'Head Basketball Coach', 52),
(233, 10, 'Head Football Coach', 79),
(234, 11, 'Head Coach', 80),
(237, 10, 'Head Coach', 81),
(238, 10, 'Head Football Coach', 82),
(239, 10, 'Head Coach', 83),
(240, 10, 'Head Football Coach', 84),
(241, 11, 'Head Basketball Coach', 85),
(242, 11, 'Head Basketball Coach', 86),
(243, 11, 'Head Basketball Coach', 87),
(244, 11, 'Head Coach', 88),
(245, 11, 'basketball', 89),
(246, 10, 'Head Coach', 90),
(247, 10, 'GAURD AND DEFFENSIVE TAKLE', 91),
(248, 10, 'Head Coach', 92),
(249, 10, 'Head Coach', 93),
(250, 11, 'Head Basketball Coach', 94),
(251, 10, 'O-Line Coach', 95),
(252, 11, 'Head Coach', 96),
(253, 10, 'Offensive Lineman', 97),
(254, 10, 'Head Coach', 98),
(255, 10, 'Head Coach', 99),
(256, 10, 'Head Coach', 100),
(257, 10, 'Head Coach', 101),
(259, 11, 'Head Boy&#39;s Basketball Coach', 102),
(260, 10, 'Assistant Football Coach', 102),
(281, 10, 'Head Coach', 103),
(280, 10, 'Head Coach', 104),
(263, 11, 'Head Coach', 105),
(264, 10, 'Head Coach', 105),
(265, 12, 'Asst. Coach', 105),
(266, 10, 'Head Football Coach', 106),
(282, 10, 'Head Coach', 107),
(268, 12, 'Head Coach', 108),
(269, 10, 'Defensive Coordinator', 108),
(271, 12, 'Head Girls BB Coach', 109),
(279, 11, 'Assistant', 110),
(273, 10, 'quarterback, saftey', 111),
(275, 11, 'Head Coach', 112),
(276, 10, 'Head Football Coach', 113),
(277, 10, 'Head Coach', 114),
(278, 11, 'Head Coach', 115),
(283, 10, 'Head Coach', 116),
(284, 10, 'AHC/OC', 117),
(285, 10, 'Director', 118),
(286, 10, 'Linebackers', 119),
(287, 10, 'Head Coach', 120),
(289, 11, 'Head Basketball Coach', 121),
(290, 10, 'Head Coach', 122);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_team`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_team` (
  `fldId` int(50) NOT NULL AUTO_INCREMENT,
  `fldUserName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `fldSchoolcode` varchar(50) DEFAULT NULL,
  `fldPassword` varchar(50) DEFAULT NULL,
  `fldSchoolname` varchar(60) DEFAULT NULL,
  `fldAddress` text,
  `fldCity` varchar(50) DEFAULT NULL,
  `fldState` varchar(50) DEFAULT NULL,
  `fldZipcode` varchar(50) DEFAULT NULL,
  `fldLogo` varchar(50) DEFAULT NULL,
  `fldSport` varchar(50) DEFAULT NULL,
  `fldCoachname` varchar(25) DEFAULT NULL,
  `fldStatus` varchar(20) DEFAULT 'ACTIVE',
  `fldEmail` varchar(100) DEFAULT NULL,
  `fldAthleteUrl` varchar(100) DEFAULT NULL,
  `fldCoachPhone` varchar(50) DEFAULT NULL,
  `fldEnrollment` varchar(100) DEFAULT NULL,
  `fldLatitude` float DEFAULT NULL,
  `fldLongitude` float DEFAULT NULL,
  `fldAdminApproved` int(11) DEFAULT '1',
  `fldAddByCoachUsername` varchar(50) DEFAULT NULL,
  `fldAddByAthleteUsername` varchar(50) DEFAULT NULL,
  `fldAddDate` date DEFAULT NULL,
  `fldDateLastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=659 ;

--
-- Dumping data for table `tbl_hs_aau_team`
--

INSERT INTO `tbl_hs_aau_team` (`fldId`, `fldUserName`, `fldSchoolcode`, `fldPassword`, `fldSchoolname`, `fldAddress`, `fldCity`, `fldState`, `fldZipcode`, `fldLogo`, `fldSport`, `fldCoachname`, `fldStatus`, `fldEmail`, `fldAthleteUrl`, `fldCoachPhone`, `fldEnrollment`, `fldLatitude`, `fldLongitude`, `fldAdminApproved`, `fldAddByCoachUsername`, `fldAddByAthleteUsername`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(456, NULL, NULL, '', 'Cranston West High School - RI', '80 Metropolitan Avenue', 'Cranston', 'Rhode Island', '02920', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4501, 30.5234, 1, NULL, NULL, NULL, NULL),
(455, NULL, NULL, '', 'East Providence High - RI', '2000 Pawtucket Ave.', 'East Providence', 'Rhode Island', '02914', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4501, 30.5234, 1, NULL, NULL, NULL, NULL),
(32, NULL, NULL, '', 'Murray High School - UT', '5440 S State St', 'Murray', 'Utah', '84107', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.6233, 12.0328, 1, NULL, NULL, NULL, NULL),
(526, NULL, NULL, '', 'Fulton High School - MO', '1 Hornet Drive', 'Fulton', 'Missouri', '65251', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 19.4458, 41.7855, 1, NULL, NULL, NULL, NULL),
(525, NULL, NULL, '', 'Fordland High School - MO', '1248 School Street', 'Fordland', 'Missouri', '65652', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 19.8754, 41.6037, 1, NULL, NULL, NULL, NULL),
(524, NULL, NULL, '', 'Hiram High School - GA', '702 Ballentine Dr', 'Hiram', 'Georgia', '30141', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.3374, 26.6405, 1, NULL, NULL, NULL, NULL),
(520, NULL, NULL, '', 'Bradleyville High School - MO', '16474 N State Hwy 125', 'Bradleyville', 'Missouri', '65614', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4667, 8.15149, 1, NULL, NULL, NULL, NULL),
(31, NULL, NULL, '', 'Clear Creek High School - TX', '2305 E. Main Street', 'League City', 'Texas', '77573', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.6341, 38.0049, 1, NULL, NULL, NULL, NULL),
(33, NULL, NULL, '', 'Grantsville High School - UT', '155 E. Cherry St.', 'Grantsville', 'Utah', '84029', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.5868, 15.3014, 1, NULL, NULL, NULL, NULL),
(26, NULL, NULL, '', 'Clear Brook High School - TX', '4607 FM 2351', 'Friendswood', 'Texas', '77546', '', '', '', 'ACTIVE', NULL, NULL, '', '', 30.6268, 38.0261, 1, NULL, NULL, NULL, NULL),
(34, NULL, NULL, '', 'Provo High School - UT', '1125 N University Ave', 'Provo', 'Utah', '84601', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.3071, 38.0296, 1, NULL, NULL, NULL, NULL),
(35, NULL, NULL, '', 'Tooele High School - UT', '301 W Vine', 'Tooele', 'Utah', '84074', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.2638, 15.0733, 1, NULL, NULL, NULL, NULL),
(36, NULL, NULL, '', 'Buckfield Jr-Sr High School - ME', '160 Morrill St', 'Buckfield', 'Maine', '4220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 47.6926, 21.4779, 1, NULL, NULL, NULL, NULL),
(37, NULL, NULL, '', 'Heppner Jr-Sr High School - OR', '710 Morgan Street', 'Heppner', 'Oregon', '97836', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.8599, 9.5104, 1, NULL, NULL, NULL, NULL),
(38, NULL, NULL, '', 'Needham High School - MA', '609 Webster Street', 'Needham', 'Massachusetts', '02492', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4501, 30.5234, 1, NULL, NULL, NULL, NULL),
(39, NULL, NULL, '', 'Barlett High School - MA', '52 Lake Parkway', 'Webster', 'Massachusetts', '01570', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.3634, 4.89911, 1, NULL, NULL, NULL, NULL),
(40, NULL, NULL, '', 'Minnechaug Regional High - ME', '621 Main St', 'Wilbraham', 'Massachusetts', '01095', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.1301, -72.4377, 1, NULL, NULL, NULL, NULL),
(41, NULL, NULL, '', 'Maumee High School - OH', '1147 Saco St', 'Maumee', 'Ohio', '43537', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 26.9241, 37.9255, 1, NULL, NULL, NULL, NULL),
(42, NULL, NULL, '', 'Groton-Dunstable High School - MA', '703 Chicopee Row', 'Groton', 'Massachusetts', '01450', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.352, 25.073, 1, NULL, NULL, NULL, NULL),
(43, NULL, NULL, '', 'Essex Ag and Tech High - MA', '562 Maple Street', 'Hawthorne', 'Massachusetts', '01937', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.5868, -70.972, 1, NULL, NULL, NULL, NULL),
(44, NULL, NULL, '', 'Gardner High School - MA', '200 Catherine St', 'Gardner', 'Massachusetts', '01440', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.2527, 5.23048, 1, NULL, NULL, NULL, NULL),
(45, NULL, NULL, '', 'Riverside Jr-Sr High School - OR', '210 NE Boardman Ave', 'Boardman', 'Oregon', '97818', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.7764, -119.789, 1, NULL, NULL, NULL, NULL),
(46, NULL, NULL, '', 'Madison High School - OR', '501 North Dixon Street', 'Portland', 'Oregon', '97227', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.2792, 34.8712, 1, NULL, NULL, NULL, NULL),
(47, NULL, NULL, '', 'Country Christian High School', '16975 S Hwy 211', 'Molalla', 'Oregon', '97038', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(48, NULL, NULL, '', 'Wakefield Memorial High School', '60 Farm St', 'Wakefield', 'Massachusetts', '1880', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(49, NULL, NULL, '', 'Montachusett Regional High', '1050 Westminster Street', 'Fitchburg', 'Massachusetts', '1420', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(50, NULL, NULL, '', 'Nokomis Regional High School', '266 Williams Road', 'Newport', 'Maine', '4953', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(51, NULL, NULL, '', 'Carbon High School', '750 East 400 North', 'Price', 'Utah', '84501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(52, NULL, NULL, '', 'Brush High School', '4875 Glenlyn Rd', 'Lyndhurst', 'Ohio', '44124', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(53, NULL, NULL, '', 'Troy High School', '500 N. Market St.', 'Troy', 'Ohio', '45373', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(54, NULL, NULL, '', 'Chase Collegiate High School', '565 Chase Pkwy', 'Waterbury', 'Connecticut', '6708', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(55, NULL, NULL, '', 'Westerville Central High', '7118 Mt Royal Ave', 'Westerville', 'Ohio', '43082', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(56, NULL, NULL, '', 'Streetsboro High School', '1900 Annalane Dr', 'Streetsboro', 'Ohio', '44241', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(57, NULL, NULL, '', 'South Central Ohio ESC - OH', '411 Court Street Room 105', 'Portsmouth', 'Ohio', '45662', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 39.7782, -4.83133, 1, NULL, NULL, NULL, NULL),
(58, NULL, NULL, '', 'Western High School', '7959 State Route 124', 'Latham', 'Ohio', '45646', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(66, NULL, NULL, '', 'Hannah Pamplico High School', '2121 South Pamplico Highway', 'Pamplico', 'South Carolina', '29583', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(60, NULL, NULL, '', 'Salem High School', '1200 East 6th Street', 'Salem', 'Ohio', '44460', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(61, NULL, NULL, '', 'Purcell Marian High School', '2935 Hackberry St', 'Cincinnati', 'Ohio', '45206', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(62, NULL, NULL, '', 'North Royalton High School', '6579 Royalton Road', 'North Royalton', 'Ohio', '44133', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(63, NULL, NULL, '', 'Riverdale High School', '20613 State Route 37', 'Mt. Blanchard', 'Ohio', '45867', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(64, NULL, NULL, '', 'Norton High School', '4028 Cleveland Massillon Rd', 'Norton', 'Ohio', '44203', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(65, NULL, NULL, '', 'Norwood City High School', '2020 Sherman Avenue', 'Norwood', 'Ohio', '45212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(67, NULL, NULL, '', 'Kalani High School', '4680 Kalanianaole Highway', 'Honolulu', 'Hawaii', '96821', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(68, NULL, NULL, '', 'Stonington High School', '176 S Broad St', 'Stonington', 'Connecticut', '6379', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(69, NULL, NULL, '', 'Danbury High School', '43 Clapboard Ridge Rd', 'Danbury', 'Connecticut', '6811', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(70, NULL, NULL, '', 'Bunnel High School', '1 Bulldog Blvd', 'Stratford', 'Connecticut', '6614', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(71, NULL, NULL, '', 'Our Lady of the Elms School - OH', '1375 W Exchange St', 'Akron', 'Ohio', '44313', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 23.8605, 40.6448, 1, NULL, NULL, NULL, NULL),
(72, NULL, NULL, '', 'Unioto High School', '1432 Egypt Pike', 'Chillicothe', 'Ohio', '45601', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(73, NULL, NULL, '', 'Lincolnview Jr-Sr High School', '15945 Middle Point Road', 'Van Wert', 'Ohio', '45891', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(74, NULL, NULL, '', 'Franklin Monroe High School', '8591 Oakes Road', 'Arcanum', 'Ohio', '45304', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(75, NULL, NULL, '', 'Dayton Jefferson High School', '2701 South Union Road', 'Dayton', 'Ohio', '45417', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(76, NULL, NULL, '', 'Cambridge High School', '65328 Creek Rd', 'Cambridge', 'Ohio', '43725', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(77, NULL, NULL, '', 'Carrollton High School', '252 Third St. NE', 'Carrollton', 'Ohio', '44615', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(78, NULL, NULL, '', 'Adena High School', '3367 Cr 550', 'Frankfort', 'Ohio', '45628', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(79, NULL, NULL, '', 'Brookville High School', '1 Blue Pride Drive', 'Brookville', 'Ohio', '45309', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(80, NULL, NULL, '', 'Xenia High School', '303 Kinsey Rd', 'Xenia', 'Ohio', '45385', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(81, NULL, NULL, '', 'Horizon Honors High School', '16233 South 48th Street', 'Phoenix', 'Arizona', '85048', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(82, NULL, NULL, '', 'Apollo High School', '8045 N. 47th Ave.', 'Glendale', 'Arizona', '85302', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(83, NULL, NULL, '', 'Cortez High School', '8828 N 31st Ave', 'Phoenix', 'Arizona', '85051', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(84, NULL, NULL, '', 'Glendale High School', '6216 W. Glendale Avenue', 'Glendale', 'Arizona', '85301', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(85, NULL, NULL, '', 'Greenway High School', '3930 West Greenway Road', 'Phoenix', 'Arizona', '85053', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(86, NULL, NULL, '', 'Independence High School', '6602 N 75th Ave', 'Glendale', 'Arizona', '85303', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(87, NULL, NULL, '', 'Glendale Union High School', '7650 North 43rd Avenue', 'Glendale', 'Arizona', '85301', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(88, NULL, NULL, '', 'Moon Valley High School', '3625 W Cactus Rd', 'Phoenix', 'Arizona', '85029', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(89, NULL, NULL, '', 'Sunnyslope High School', '35 W Dunlap Ave', 'Phoenix', 'Arizona', '85021', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(90, NULL, NULL, '', 'Thunderbird High School', '1750 W Thunderbird Rd', 'Phoenix', 'Arizona', '85023', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(91, NULL, NULL, '', 'Washington HS - Phoenix', '2217 W Glendale Ave', 'Phoenix', 'Arizona', '85021', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.4827, 37.0279, 1, NULL, NULL, NULL, '2012-02-24 21:51:01'),
(92, NULL, NULL, '', 'San Luis High School', '1250 N 8Th Ave', 'San Luis', 'Arizona', '85349', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(93, NULL, NULL, '', 'Cornerstone Christian Academy', '6450 North Camino Rival', 'Tucson', 'Arizona', '85718', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(94, NULL, NULL, '', 'Tempe High School', '1730 S. Mill Ave.', 'Tempe', 'Arizona', '85281', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(95, NULL, NULL, '', 'McClintock High School', '1830 E. Del Rio Drive', 'Tempe', 'Arizona', '85282', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(96, NULL, NULL, '', 'Marcos De Niza High School', '6000 S. Lakeshore Dr.', 'Tempe', 'Arizona', '85283', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(97, NULL, NULL, '', 'Corona del Sol High School', '1001 East Knox Road', 'Tempe', 'Arizona', '85284', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(98, NULL, NULL, '', 'Mountain Pointe High School', '4201 East Knox Road', 'Phoenix', 'Arizona', '85044', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(99, NULL, NULL, '', 'Desert Vista High School', '16440 S 32nd Street', 'Phoenix', 'Arizona', '85048', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(100, NULL, NULL, '', 'Camelback High School', '4612 N 28Th St', 'Phoenix', 'Arizona', '85016', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(101, NULL, NULL, '', 'Kearny High School', '336 Devon Street', 'Kearny', 'New Jersey', '7032', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(102, NULL, NULL, '', 'Kearny High School - CA', '7651 Wellington St', 'San Diego', 'California', '92111', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(103, NULL, NULL, '', 'Murrieta Valley High School', '24105 Washington Ave', 'Murrieta', 'California', '92562', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(104, NULL, NULL, '', 'Lancaster High School - CA', '44701 32Nd St W', 'Lancaster', 'California', '93536', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(105, NULL, NULL, '', 'John Burroughs School - MO', '755 South Price Road', 'St Louis', 'Missouri', '63124', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(106, NULL, NULL, '', 'John Burroughs High - CA', '1920 Clark Avenue', 'Burbank', 'California', '91506', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(107, NULL, NULL, '', 'La Jolla Country Day - CA', '9490 Genesee Ave', 'La Jolla', 'California', '92037', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(108, NULL, NULL, '', 'Bolsa Grande High School - CA', '9401 Westminster Ave', 'Garden Grove', 'California', '92844', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(109, NULL, NULL, '', 'Garden Grove High School - CA', '11271 Stanford Ave', 'Garden Grove', 'California', '92840', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(110, NULL, NULL, '', 'Hare High School - CA', '12012 S. Magnolia Street', 'Garden Grove', 'California', '92841', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(111, NULL, NULL, '', 'La Quinta High School - CA', '10372 McFadden Ave.', 'Westminster', 'California', '92683', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(112, NULL, NULL, '', 'Lincoln Continuation High - CA', '11262 Garden Grove Blvd.', 'Garden Grove', 'California', '92843', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(113, NULL, NULL, '', 'Los Amigos High School - CA', '16566 Newhope Street', 'Fountain Valley', 'California', '92708', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(114, NULL, NULL, '', 'Pacifica High School - CA', '6851 Lampson Ave.', 'Garden Grove', 'California', '92845', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(115, NULL, NULL, '', 'Rancho Alamitos High - CA', '11351 Dale Street', 'Garden Grove', 'California', '92841', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(116, NULL, NULL, '', 'Santiago High School - CA', '12342 Trask Ave.', 'Garden Grove', 'California', '92843', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(117, NULL, NULL, '', 'Foothill High School - CA', '9733 Deschutes Rd', 'Palo Cedro', 'California', '96073', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(118, NULL, NULL, '', 'Granada Hills Charter - CA', '10535 Zelzah Avenue', 'Granada Hills', 'California', '91344', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(119, NULL, NULL, '', 'Enterprise High School - CA', '3411 Churn Creek Road', 'Redding', 'California', '96002', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(120, NULL, NULL, '', 'North State Independence - CA', '590 Mary Street', 'Redding', 'California', '96001', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(121, NULL, NULL, '', 'Shasta High School - CA', '2500 Eureka Way', 'Redding', 'California', '96001', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(122, NULL, NULL, '', 'University Prep School - CA', '2200 Eureka Way', 'Redding', 'California', '96001', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(123, NULL, NULL, '', 'Gustine High School - CA', '501 North Avenue', 'Gustine', 'California', '95322', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(124, NULL, NULL, '', 'Pioneer High School - CA', '501 North Avenue', 'Gustine', 'California', '95322', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(125, NULL, NULL, '', 'Serrano High School - CA', '9292 Sheep Creek Rd', 'Phelan', 'California', '92371', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(126, NULL, NULL, '', 'Chaparral High School - CA', '9258 Malpaso Rd', 'Phelan', 'California', '92371', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(127, NULL, NULL, '', 'Desert View Independent - CA', '9298 Sheep Creek Rd', 'Phelan', 'California', '92371', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(128, NULL, NULL, '', 'Central Fresno High - CA', '3535 N Cornelia', 'Fresno', 'California', '93722', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(129, NULL, NULL, '', 'Avenal High School - CA', '601 Mariposa St.', 'Avenal', 'California', '93204', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(130, NULL, NULL, '', 'Sunrise High School - CA', '209 N. Park Ave.', 'Avenal', 'California', '93204', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(131, NULL, NULL, '', 'Half Moon Bay High School - CA', 'Lewis Foster Dr', 'Half Moon Bay', 'California', '94019', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(132, NULL, NULL, '', 'San Diego High School - TX', '235 South Highway 359', 'San Diego', 'Texas', '78384', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(133, NULL, NULL, '', 'Fairbanks High School - OH', '11158 Sr 38', 'Milford Center', 'Ohio', '43045', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(134, NULL, NULL, '', 'Kirtland High School - OH', '9150 Chillicothe Road', 'Kirtland', 'Ohio', '44094', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(135, NULL, NULL, '', 'Kirtland Central High  - NM', '550 CR 6100', 'Kirtland', 'New Mexico', '87417', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(136, NULL, NULL, '', 'Shiprock High School - NM', 'P.O. Box 3578', 'Shiprock', 'New Mexico', '87420', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(137, NULL, NULL, '', 'Newcomb High School - NM', 'PO Box 7973', 'Newcomb', 'New Mexico', '87455', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(138, NULL, NULL, '', 'Meadowdale High School - OH', '4417 Williamson Dr', 'Dayton', 'Ohio', '45416', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(139, NULL, NULL, '', 'Whitinsville Christian - MA', '279 Linwood Ave', 'Whitinsville', 'Massachusetts', '1588', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(140, NULL, NULL, '', 'Little Miami High School - OH', '3001 East US 22 and 3', 'Morrow', 'Ohio', '45152', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(141, NULL, NULL, '', 'Jefferson High School - OH', '901 Wildcat Ln', 'Delphos', 'Ohio', '45833', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(142, NULL, NULL, '', 'Canton South High School - OH', '600 Faircrest St SE', 'Canton', 'Ohio', '44707', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(143, NULL, NULL, '', 'Monarch HS - Coconut Creek', '5050 Wiles Rd.', 'Coconut Creek', 'Florida', '33073', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:55:37'),
(144, NULL, NULL, '', 'American Heritage HS - Plantation', '12200 W Broward Blvd', 'Plantation', 'Florida', '33325', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 26.1361, 49.4771, 1, NULL, NULL, NULL, '2012-02-26 20:02:34'),
(145, NULL, NULL, '', 'South Dade Senior High - FL', '28401 Southwest 167th Avenue', 'Homestead', 'Florida', '33030', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(146, NULL, NULL, '', 'Northview High School - FL', '4100 West Highway 4', 'Bratt', 'Florida', '32535', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(147, NULL, NULL, '', 'Gilbert Christian High - AZ', '3632 E. Jasper', 'Gilbert', 'Arizona', '85296', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(148, NULL, NULL, '', 'Celebration High School - FL', '1809 Celebration Boulevard', 'Kissimmee', 'Florida', '34747', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(149, NULL, NULL, '', 'Texas Tarheels AAU - TX', 'Not available - AAU', 'Lewisville', 'Texas', '75067', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(150, NULL, NULL, '', 'North Fort Myers High - FL', '5000 Orange Grove Boulevard', 'Fort Myers', 'Florida', '33903', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(151, NULL, NULL, '', 'Evergreen High School - CO', '29300 Buffalo Park Road', 'Evergreen', 'Colorado', '80439', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(152, NULL, NULL, '', 'Evergreen High School - WA', '14300 NE 18th St.', 'Vancouver', 'Washington', '98684', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(153, NULL, NULL, '', 'Heritage High School - WA', '7825 NE 130th Avenue', 'Vancouver', 'Washington', '98682', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(154, NULL, NULL, '', 'Legacy High School - WA', '2205 NE 138th Avenue', 'Vancouver', 'Washington', '98684', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(155, NULL, NULL, '', 'Mountainview High School - WA', '1500 SE Blairmont Dr.', 'Vancouver', 'Washington', '98683', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(156, NULL, NULL, '', 'Union High School - WA', '6201 NW Friberg-Strunk St.', 'Camas', 'Washington', '98607', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(157, NULL, NULL, '', 'Piper HS - Sunrise', '8000 Northwest 44th Street', 'Sunrise', 'Florida', '33351', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-27 00:06:48'),
(158, NULL, NULL, '', 'Tenaha High School - TX', 'PO Box 318', 'Tenaha', 'Texas', '75974', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(159, NULL, NULL, '', 'Cascade High School - WA', '801 E. Casino Road', 'Everett', 'Washington', '98203', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(160, NULL, NULL, '', 'Everett High School - WA', '2416 Colby Ave.', 'Everett', 'Washington', '98201', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(161, NULL, NULL, '', 'HM Jackson High School - WA', '1508 136th St. SE', 'Mill Creek', 'Washington', '98012', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(162, NULL, NULL, '', 'Sequoia High School - WA', '3516 Rucker Ave.', 'Everett', 'Washington', '98201', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(163, NULL, NULL, '', 'Roscoe High School - TX', 'PO Box 579', 'Roscoe', 'Texas', '79545', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(164, NULL, NULL, '', 'Puget Sound Flight AAU - WA', 'Not available - AAU', 'Sammamish', 'Washington', '98075', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(165, NULL, NULL, '', 'Clear Lake High School - TX', '2929 Bay Area Blvd.', 'Houston', 'Texas', '77058', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(166, NULL, NULL, '', 'Conroe High School - TX', '3200 West Davis', 'Conroe', 'Texas', '77304', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(167, NULL, NULL, '', 'Cypress Ridge High School - TX', '7900 N. Eldridge Parkway', 'Houston', 'Texas', '77041', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(168, NULL, NULL, '', 'Cypress Woods High School - TX', '16825 Spring Cypress Rd.', 'Cypress', 'Texas', '77429', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(169, NULL, NULL, '', 'Dawson High School - TX', '4717 Bailey Rd.', 'Pearland', 'Texas', '77584', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(170, NULL, NULL, '', 'Elkins High School - TX', '7007 Knights Court', 'Missouri City', 'Texas', '77459', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(171, NULL, NULL, '', 'FB Kempner High School - TX', '14777 Voss Rd', 'Sugarland', 'Texas', '77478', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(172, NULL, NULL, '', 'Fort Bend Marshall High - TX', '1220 Buffalo Run', 'Missouri City', 'Texas', '77489', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(173, NULL, NULL, '', 'Humble High School - TX', '1700 Wilson Road', 'Humble', 'Texas', '77338', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(175, NULL, NULL, '', 'Lufkin High School - TX', '900 E. Denman Ave.', 'Lufkin', 'Texas', '75901', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(176, NULL, NULL, '', 'Magnolia High School - TX', '14350 FM 1488', 'Magnolia', 'Texas', '77354', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(177, NULL, NULL, '', 'Magnolia West High School - TX', '42202 FM 1774 Rd', 'Magnolia', 'Texas', '77354', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(178, NULL, NULL, '', 'New Caney High School - TX', '21650 Loop 494', 'New Caney', 'Texas', '77357', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(179, NULL, NULL, '', 'North Shore Senior High - TX', '353 North Castlegory', 'Houston', 'Texas', '77049', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(180, NULL, NULL, '', 'Oak Ridge High School - TX', '27330 Oak Ridge School Rd.', 'Conroe', 'Texas', '77385', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(181, NULL, NULL, '', 'South Houston High School - TX', '3820 S. Shaver Rd.', 'South Houston', 'Texas', '77587', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(182, NULL, NULL, '', 'Spring High School - TX', '19428 I-45 North', 'Spring', 'Texas', '77373', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(183, NULL, NULL, '', 'Strake Jesuit High School - TX', '8900 Bellaire Blvd', 'Houston', 'Texas', '77036', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(184, NULL, NULL, '', 'Tomball High School - TX', '30330 Quinn Road', 'Tomball', 'Texas', '77375', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(185, NULL, NULL, '', 'The Woodlands High School - TX', '6101 Research Forest Drive', 'The Woodlands', 'Texas', '77381', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(186, NULL, NULL, '', 'College Park High School - TX', '3701 College Park Dr', 'The Woodlands', 'Texas', '77384', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(187, NULL, NULL, '', 'Venice High School - FL', '1 Indian Avenue', 'Venice', 'Florida', '34285', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(188, NULL, NULL, '', 'Bayside High School - FL', '14405 49th St. N', 'Clearwater', 'Florida', '33762', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(189, NULL, NULL, '', 'Boca Ciega High School - FL', '924 58th St. S', 'Gulfport', 'Florida', '33707', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(190, NULL, NULL, '', 'Clearwater High School - FL', '540 S Hercules Ave.', 'Clearwater', 'Florida', '33764', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(191, NULL, NULL, '', 'Countryside High School - FL', '3000 SR 580', 'Clearwater', 'Florida', '33761', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(192, NULL, NULL, '', 'Dixie Hollins High School - FL', '4940 62nd St. N', 'St Petersburg', 'Florida', '33709', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(193, NULL, NULL, '', 'Dunedin High School - FL', '1651 Pinehurst Rd.', 'Dunedin', 'Florida', '34698', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(194, NULL, NULL, '', 'East Lake High School - FL', '1300 Silver Eagle Dr.', 'Tarpon Springs', 'Florida', '34688', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(195, NULL, NULL, '', 'Gibbs High School - FL', '850 34th St. S', 'St Petersburg', 'Florida', '33711', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(196, NULL, NULL, '', 'Lakewood High School - FL', '1400 54th Ave. S', 'St Petersburg', 'Florida', '33705', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(197, NULL, NULL, '', 'Largo High School - FL', '410 Missouri Ave.', 'Largo', 'Florida', '33770', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(198, NULL, NULL, '', 'Northeast HS - St Petersburg', '5500 16th St. N', 'St Petersburg', 'Florida', '33703', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.7421, 13.6057, 1, NULL, NULL, NULL, '2012-02-26 23:51:26'),
(199, NULL, NULL, '', 'Osceola Fundamental High - FL', '9751 98th St. N', 'Seminole', 'Florida', '33777', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(200, NULL, NULL, '', 'Palm Harbor Univ. High - FL', '1900 Omaha St.', 'Palm Harbor', 'Florida', '34683', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(201, NULL, NULL, '', 'Pinellas Park High - FL', '6305 118th Ave. N', 'Largo', 'Florida', '33773', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(202, NULL, NULL, '', 'Seminole High School - FL', '8401 131st St. N', 'Seminole', 'Florida', '33776', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(203, NULL, NULL, '', 'St Petersburg High School - FL', '2501 Fifth Ave. N', 'St Petersburg', 'Florida', '33713', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(204, NULL, NULL, '', 'Tarpon Springs High School - F', '1411 Gulf Rd.', 'Tarpon Springs', 'Florida', '34689', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(205, NULL, NULL, '', 'Auburndale High School - FL', '1 Bloodhound Trl', 'Auburndale', 'Florida', '33823', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(206, NULL, NULL, '', 'Landmark Christian School - GA', '50 SE Broad Street', 'Fairburn', 'Georgia', '30213', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(207, NULL, NULL, '', 'Landmark Christian School - FL', '2020 East Hinson Avenue', 'Haines City', 'Florida', '33844', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(208, NULL, NULL, '', 'Merritt Island High - FL', '100 E. Mustang Way', 'Merritt Island', 'Florida', '32953', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(209, NULL, NULL, '', 'Sebastian River High - FL', '9001 Shark Boulevard', 'Sebastian', 'Florida', '32958', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(210, NULL, NULL, '', 'Lakewood Ranch High - FL', '5500 Lakewood Ranch Boulevard', 'Bradenton', 'Florida', '34211', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(211, NULL, NULL, '', 'Oak Ridge High School - FL', '700 W Oak Ridge Rd', 'Orlando', 'Florida', '32809', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(212, NULL, NULL, '', 'East Ridge High School - FL', '13322 Excalibur Road', 'Clermont', 'Florida', '34711', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(213, NULL, NULL, '', 'Booker T Washington HS - Miami', '1200 NW 6TH AVENUE', 'Miami', 'Florida', '33136', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-24 21:50:02'),
(214, NULL, NULL, '', 'Dacula High School - GA', '123 Broad Street', 'Dacula', 'Georgia', '30019', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(215, NULL, NULL, '', 'East Paulding High School - GA', '3320 East Paulding Drive', 'Dallas', 'Georgia', '30157', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(216, NULL, NULL, '', 'Bainbridge High School - GA', 'One Bearcat Blvd', 'Bainbridge', 'Georgia', '39819', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(217, NULL, NULL, '', 'McEachern High School - GA', '2400 New Macland Road', 'Powder Springs', 'Georgia', '30127', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(218, NULL, NULL, '', 'North Gwinnet High - GA', '20 Level Creek Road', 'Suwanee', 'Georgia', '30024', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(219, NULL, NULL, '', 'Glenn Hills High School - GA', '2840 Glenn Hills Drive', 'Augusta', 'Georgia', '30906', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(220, NULL, NULL, '', 'Lakeview Academy - GA', '796 Lakeview Drive', 'Gainesville', 'Georgia', '30501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(221, NULL, NULL, '', 'St Joseph Academy High - FL', '155 State Road 207', 'St Augustine', 'Florida', '32084', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(222, NULL, NULL, '', 'Lithonia High School - GA', '2440 Phillips Rd', 'Lithonia', 'Georgia', '30058', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(223, NULL, NULL, '', 'Walton High School - GA', '1590 Bill Murdock Road', 'Marietta', 'Georgia', '30062', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(224, NULL, NULL, '', 'Hart County High School - GA', '59 5th St.', 'Hartwell', 'Georgia', '30643', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(225, NULL, NULL, '', 'Harris County High School - GA', '8281 Highway 116', 'Hamilton', 'Georgia', '31811', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(226, NULL, NULL, '', 'DFW Elite AAU - TX', 'Not available - AAU', 'Dallas', 'Texas', '75201', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(227, NULL, NULL, '', 'Etowah High School - GA', '6565 Putnam Ford Drive', 'Woodstock', 'Georgia', '30189', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(228, NULL, NULL, '', 'Crawford County High - GA', '400 State Route 42 South', 'Roberta', 'Georgia', '31078', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(229, NULL, NULL, '', 'Calvary Day High School - GA', '4625 Waters Avenue', 'Savannah', 'Georgia', '31404', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(230, NULL, NULL, '', 'Eagles Landing Christian - GA', '2400 Highway 42 North', 'McDonough', 'Georgia', '30253', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(231, NULL, NULL, '', 'Barringer High School - NJ', '90 Parker St', 'Newark', 'New Jersey', '7104', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(232, NULL, NULL, '', 'Kent Place School - NJ', '42 Norwood Ave', 'Summit', 'New Jersey', '7901', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.619, 3.59027, 1, NULL, NULL, NULL, NULL),
(233, NULL, NULL, '', 'Cedartown High School - GA', '167 Frank Lott Drive', 'Cedartown', 'Georgia', '30125', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(234, NULL, NULL, '', 'Rockmart High School - GA', '990 Cartersville Hwy.', 'Rockmart', 'Georgia', '30153', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(235, NULL, NULL, '', 'Ola High School - GA', '357 North Ola Road', 'McDonough', 'Georgia', '30252', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(236, NULL, NULL, '', 'Bowdon High School - GA', '504 West College Street', 'Bowdon', 'Georgia', '30108', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(237, NULL, NULL, '', 'Mt Zion High School - GA', '132 Eagle Dr.', 'Mount Zion', 'Georgia', '30150', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(238, NULL, NULL, '', 'Temple High School - GA', '589 Sage St.', 'Temple', 'Georgia', '30179', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(239, NULL, NULL, '', 'Villa Rica High School - GA', '600 Rocky Branch Road', 'Villa Rica', 'Georgia', '30180', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(240, NULL, NULL, '', 'Central High School - GA', '113 Central Road', 'Carrollton', 'Georgia', '30116', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(241, NULL, NULL, '', 'West Hall High School - GA', '5500 McEver Road', 'Oakwood', 'Georgia', '30566', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(242, NULL, NULL, '', 'Druid Hills High School - GA', '1798 Haygood Dr.', 'Atlanta', 'Georgia', '30307', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(243, NULL, NULL, '', 'Boyd County High School - KY', '12307 Midland Trail Road', 'Ashland', 'Kentucky', '41102', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(244, NULL, NULL, '', 'Petrides High School - NY', '715 Ocean Terrace', 'Staten Island', 'New York', '10301', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(245, NULL, NULL, '', 'Monroe County High School - KY', '755 Old Mulkey Road', 'Tompkinsville', 'Kentucky', '42167', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(246, NULL, NULL, '', 'Moore Traditional High - KY', '6415 Outer Loop', 'Louisville', 'Kentucky', '40228', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(247, NULL, NULL, '', 'Napavine High School - WA', '404 4th Avenue Northeast', 'Napavine', 'Washington', '98565', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(248, NULL, NULL, '', 'Glasgow High School - KY', '1601 Columbia Ave.', 'Glasgow', 'Kentucky', '42141', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(250, NULL, NULL, '', 'Fulton City High School - KY', '700 Stephen Beale Drive', 'Fulton', 'Kentucky', '42041', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(251, NULL, NULL, '', 'Stockbridge High School - GA', '1151 Old Conyers Road', 'Stockbridge', 'Georgia', '30281', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(252, NULL, NULL, '', 'Shelby Valley High School - KY', '125 Douglas Park', 'Pikeville', 'Kentucky', '41501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(253, NULL, NULL, '', 'Todd County Central High - KY', '806 South Main Street', 'Elkton', 'Kentucky', '42220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(254, NULL, NULL, '', 'Dixie Heights High School - KY', '1055 Eaton Drive Ft.', 'Wright', 'Kentucky', '41017', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(255, NULL, NULL, '', 'Scott High School - KY', '5400 Old Taylor Mill Rd', 'Taylor Mill', 'Kentucky', '41015', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(256, NULL, NULL, '', 'Simon Kenton High School - KY', '11132 Madison Pike', 'Independence', 'Kentucky', '41051', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(257, NULL, NULL, '', 'Lewis County High School - KY', '51 Middle School Lane', 'Vanceburg', 'Kentucky', '41179', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(258, NULL, NULL, '', 'Seneca High School - KY', '3510 Goldsmith Lane', 'Louisville', 'Kentucky', '40220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(259, NULL, NULL, '', 'Shelby County High School - KY', '1701 Frankfort Road', 'Shelbyville', 'Kentucky', '40065', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(260, NULL, NULL, '', 'Fort Pierce High School - FL', '4101 South 25th Street', 'Fort Pierce', 'Florida', '34981', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(261, NULL, NULL, '', 'Garrard County High - KY', '304 Maple Ave', 'Lancaster', 'Kentucky', '40444', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(262, NULL, NULL, '', 'Hilliard Middle Sr High - FL', '1 Flashes Ave', 'Hilliard', 'Florida', '32046', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(263, NULL, NULL, '', 'Union County High School - KY', '4464 US Highway 60 W', 'Morganfield', 'Kentucky', '42437', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(264, NULL, NULL, '', 'Trinity Catholic High - FL', '2600 SW 42nd Street', 'Ocala', 'Florida', '34471', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(265, NULL, NULL, '', 'Bleckley County High - GA', '1 Royal Drive', 'Cochran', 'Georgia', '31014', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(266, NULL, NULL, '', 'Brownstown Central High - IN', '500 North Elm Street', 'Brownstown', 'Indiana', '47220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(267, NULL, NULL, '', 'Charlestown High School - IN', '1 Pirate Place', 'Charlestown', 'Indiana', '47111', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(268, NULL, NULL, '', 'Crawsfordsville High - IN', '1 West Athenian Drive', 'Crawsfordville', 'Indiana', '47933', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(269, NULL, NULL, '', 'Bradford High School - FL', '581 North Temple Avenue', 'Starke', 'Florida', '32091', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(270, NULL, NULL, '', 'Butler High School - MO', '420 South Fulton Street', 'Butler', 'Missouri', '64730', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(271, NULL, NULL, '', 'Forest Park High School - IN', '1440 Michigan Street', 'Ferdinand', 'Indiana', '47532', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(272, NULL, NULL, '', 'Faith Ministries High - IN', '5526 State Road 26 East', 'Lafayette', 'Indiana', '47905', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(273, NULL, NULL, '', 'Rose Hill Christian High - KY', '1001 Winslow Road', 'Ashland', 'Kentucky', '41102', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(274, NULL, NULL, '', 'Freeman High School - SD', '1001 S Wipf St', 'Freeman', 'South Dakota', '57029', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(275, NULL, NULL, '', 'Avon High School - SD', '210 Pine St N', 'Avon', 'South Dakota', '57315', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(276, NULL, NULL, '', 'Colman-Egan High School - SD', '200 S Loban', 'Colman', 'South Dakota', '57017', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(277, NULL, NULL, '', 'Lincoln County High - WV', '81 Lincoln Panther Way', 'Hamlin', 'West Virginia', '25523', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(278, NULL, NULL, '', 'East Fairmont High School - WV', '1993 Airport Road', 'Fairmont', 'West Virginia', '26554', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(279, NULL, NULL, '', 'Weir High School - WV', '100 Red Rider Road', 'Weirton', 'West Virginia', '26062', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(280, NULL, NULL, '', 'Elwood High School - IN', '1137 North 19th Street', 'Elwood', 'Indiana', '46036', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(281, NULL, NULL, '', 'Oelrichs High School - SD', '625 Walnut Street', 'Oelrichs', 'South Dakota', '57763', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(282, NULL, NULL, '', 'Stanley County High - SD', '10 East Main Avenue', 'Fort Pierre', 'South Dakota', '57532', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(283, NULL, NULL, '', 'Chaffee High School - MO', '517 West Yoakum Avenue', 'Chaffee', 'Missouri', '63740', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(284, NULL, NULL, '', 'Caesar Rodney High School - DE', '239 Old North Road', 'Camden', 'Delaware', '19934', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(285, NULL, NULL, '', 'Atlantic City High School - NJ', '1400 Albany Ave', 'Atlantic City', 'New Jersey', '8401', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(286, NULL, NULL, '', 'Dooly County High School - GA', '715 N 3rd St', 'Vienna', 'Georgia', '31092', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(287, NULL, NULL, '', 'Connersville High School - IN', '1100 Spartan Drive', 'Connersville', 'Indiana', '47331', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(288, NULL, NULL, '', 'Ramapo High School - NJ', '331 George Street', 'Franklin Lakes', 'New Jersey', '7417', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(289, NULL, NULL, '', 'Indian Hills High School - NJ', '97 Yawpo Avenue', 'Oakland', 'New Jersey', '7436', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(468, NULL, NULL, '', 'George Westinghouse High - NY', '105 Johnson St', 'Brooklyn', 'New York', '11201', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.8706, 27.8191, 1, NULL, NULL, NULL, NULL),
(469, NULL, NULL, '', 'Selden Newfield High - NY', '145 Marshall Dr', 'Selden', 'New York', '11784', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4622, 27.8718, 1, NULL, NULL, NULL, NULL),
(292, NULL, NULL, '', 'LaGrange High School - LA', '3420 Louisiana Ave', 'Lake Charles', 'Louisiana', '70605', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.6366, 25.6799, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tbl_hs_aau_team` (`fldId`, `fldUserName`, `fldSchoolcode`, `fldPassword`, `fldSchoolname`, `fldAddress`, `fldCity`, `fldState`, `fldZipcode`, `fldLogo`, `fldSport`, `fldCoachname`, `fldStatus`, `fldEmail`, `fldAthleteUrl`, `fldCoachPhone`, `fldEnrollment`, `fldLatitude`, `fldLongitude`, `fldAdminApproved`, `fldAddByCoachUsername`, `fldAddByAthleteUsername`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(293, NULL, NULL, '', 'Washington-Marion High - LA', '2802 Pineview Street', 'Lake Charles', 'Louisiana', '70615', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.2492, -93.1077, 1, NULL, NULL, NULL, NULL),
(294, NULL, NULL, '', 'Barbe High School - LA', '2200 West McNeese', 'Lake Charles', 'Louisiana', '70605', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.6366, 25.6799, 1, NULL, NULL, NULL, NULL),
(295, NULL, NULL, '', 'Lake Charles Heat AAU - LA', 'Not available - AAU', 'Lake Charles', 'Louisiana', '70605', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.6366, 25.6799, 1, NULL, NULL, NULL, NULL),
(296, NULL, NULL, '', 'Kingwood High School - TX', '2701 Kingwood Dr.', 'Kingwood', 'Texas', '77339', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.0653, 38.0049, 1, NULL, NULL, NULL, NULL),
(297, NULL, NULL, '', 'Parkersburg South High - WV', '1511 Blizzard Drive', 'Parkersburg', 'West Virginia', '26101', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.6934, 14.0096, 1, NULL, NULL, NULL, NULL),
(298, NULL, NULL, '', 'Shepherd High School - TX', '1 Pirate Lane', 'Shepherd', 'Texas', '77371', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.8337, 37.7078, 1, NULL, NULL, NULL, NULL),
(299, NULL, NULL, '', 'Sterling High School - TX', '11625 Martindale Rd', 'Houston', 'Texas', '77048', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6246, -95.3207, 1, NULL, NULL, NULL, NULL),
(300, NULL, NULL, '', 'Sunset High School - TX', '2120 W Jefferson Blvd', 'Dallas', 'Texas', '75208', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.3273, 25.0674, 1, NULL, NULL, NULL, NULL),
(301, NULL, NULL, '', 'St Dominic Savio - TX', '9300 Neenah Avenue', 'Austin', 'Texas', '78717', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.493, -97.7525, 1, NULL, NULL, NULL, NULL),
(302, NULL, NULL, '', 'Sweetwater High School - TX', '1205 Ragland', 'Sweetwater', 'Texas', '79556', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 32.423, -100.395, 1, NULL, NULL, NULL, NULL),
(303, NULL, NULL, '', 'Juan Seguin High School - TX', '7001 Silo Road', 'Arlington', 'Texas', '76002', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2268, 24.0241, 1, NULL, NULL, NULL, NULL),
(304, NULL, NULL, '', 'Dobie High School - TX', '10220 Blackhawk', 'Houston', 'Texas', '77089', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.5881, -95.2215, 1, NULL, NULL, NULL, NULL),
(305, NULL, NULL, '', 'Pasadena Memorial High - TX', '4410 Crenshaw', 'Pasadena', 'Texas', '77504', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6527, -95.1954, 1, NULL, NULL, NULL, NULL),
(306, NULL, NULL, '', 'Pasadena High School - TX', '206 South Shaver', 'Pasadena', 'Texas', '77506', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7045, -95.2006, 1, NULL, NULL, NULL, NULL),
(307, NULL, NULL, '', 'Sam Rayburn High School - TX', '2121 Cherrybrook', 'Pasadena', 'Texas', '77502', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6814, -95.2006, 1, NULL, NULL, NULL, NULL),
(308, NULL, NULL, '', 'Schulenburg High School - TX', '150 College Street', 'Schulenburg', 'Texas', '78956', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6767, -96.9424, 1, NULL, NULL, NULL, NULL),
(309, NULL, NULL, '', 'Seminole High School - TX', '2100 N.W. Avenue D', 'Seminole', 'Texas', '79360', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.7738, 14.8008, 1, NULL, NULL, NULL, NULL),
(310, NULL, NULL, '', 'Brackenridge High School - TX', '400 Eagleland Dr.', 'San Antonio', 'Texas', '78210', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8062, 2.06623, 1, NULL, NULL, NULL, NULL),
(311, NULL, NULL, '', 'Burbank High School - TX', '1002 Edwards St.', 'San Antonio', 'Texas', '78204', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.8107, 24.5935, 1, NULL, NULL, NULL, NULL),
(312, NULL, NULL, '', 'Edison High School - TX', '701 Santa Monica Dr.', 'San Antonio', 'Texas', '78212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.8658, 24.4875, 1, NULL, NULL, NULL, NULL),
(313, NULL, NULL, '', 'Fox Tech High School - TX', '637 N. Main Ave.', 'San Antonio', 'Texas', '78205', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.9746, 24.4478, 1, NULL, NULL, NULL, NULL),
(314, NULL, NULL, '', 'Highlands High School - TX', '3118 Elgin Ave.', 'San Antonio', 'Texas', '78210', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8062, 2.06623, 1, NULL, NULL, NULL, NULL),
(315, NULL, NULL, '', 'Houston High School - TX', '4635 E. Houston St.', 'San Antonio', 'Texas', '78220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8018, 2.16919, 1, NULL, NULL, NULL, NULL),
(316, NULL, NULL, '', 'Jefferson High School - TX', '723 Donaldson Ave.', 'San Antonio', 'Texas', '78201', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.7811, 24.5209, 1, NULL, NULL, NULL, NULL),
(317, NULL, NULL, '', 'Lanier High School - TX', '1514 W. Cesar E. Chavez Blvd.', 'San Antonio', 'Texas', '78207', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.7729, 24.5993, 1, NULL, NULL, NULL, NULL),
(318, NULL, NULL, '', 'Navarro High School - TX', '623 S. Pecos St.', 'San Antonio', 'Texas', '78207', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.7729, 24.5993, 1, NULL, NULL, NULL, NULL),
(319, NULL, NULL, '', 'Travis Early Charter - TX', '1915 N. Main Ave.', 'San Antonio', 'Texas', '78212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.8658, 24.4875, 1, NULL, NULL, NULL, NULL),
(320, NULL, NULL, '', 'Seagraves High School - TX', 'P.O. Box 1505', 'Seagraves', 'Texas', '79359', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.1476, 7.75133, 1, NULL, NULL, NULL, NULL),
(321, NULL, NULL, '', 'Rider High School - TX', '4611 Cypress', 'Wichita Falls', 'Texas', '76310', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.1466, 24.4445, 1, NULL, NULL, NULL, NULL),
(322, NULL, NULL, '', 'Hirschi High School - TX', '3106 Borton', 'Wichita Falls', 'Texas', '76306', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.1414, 24.5467, 1, NULL, NULL, NULL, NULL),
(323, NULL, NULL, '', 'Wichita Falls High School - TX', '2149 Avenue H', 'Wichita Falls', 'Texas', '76309', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.215, 24.4699, 1, NULL, NULL, NULL, NULL),
(324, NULL, NULL, '', 'Rosehill Christian High - TX', '19830 Fm 2920 Rd', 'Tomball', 'Texas', '77377', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.7975, 37.8141, 1, NULL, NULL, NULL, NULL),
(325, NULL, NULL, '', 'Rockwall Christian High - TX', '6005 Dalrock Rd', 'Rowlett', 'Texas', '75088', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 32.8976, -96.525, 1, NULL, NULL, NULL, NULL),
(326, NULL, NULL, '', 'Van Vleck High School - TX', '133 S 4th St', 'Van Vleck', 'Texas', '77482', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.3178, 37.3239, 1, NULL, NULL, NULL, NULL),
(327, NULL, NULL, '', 'Richards High School - TX', '9477 Panther Drive', 'Richards', 'Texas', '77873', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.5596, 37.6919, 1, NULL, NULL, NULL, NULL),
(328, NULL, NULL, '', 'Waxahachie High School - TX', '1000 North Highway 77', 'Waxahachie', 'Texas', '75165', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 32.3997, -96.7922, 1, NULL, NULL, NULL, NULL),
(329, NULL, NULL, '', 'Westwood High School - TX', '12400 Mellow Meadow', 'Austin', 'Texas', '78750', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.879, 2.07433, 1, NULL, NULL, NULL, NULL),
(330, NULL, NULL, '', 'Palestine Westwood High - TX', '1820 Chism Drive', 'Westwood', 'Texas', '75802', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.2559, 33.299, 1, NULL, NULL, NULL, NULL),
(331, NULL, NULL, '', 'Petersburg Jr-Sr High - TX', '1411 West Fourth St', 'Petersburg', 'Texas', '79250', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.9596, -0.583312, 1, NULL, NULL, NULL, NULL),
(332, NULL, NULL, '', 'Houston Westside High - TX', '14201 Briar Forest', 'Houston', 'Texas', '77077', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7502, -95.6353, 1, NULL, NULL, NULL, NULL),
(333, NULL, NULL, '', 'Houston Austin High - TX', '1700 Dumble', 'Houston', 'Texas', '77023', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4456, 24.5995, 1, NULL, NULL, NULL, NULL),
(334, NULL, NULL, '', 'Bellaire High School - TX', '5100 Maple St.', 'Bellaire', 'Texas', '77401', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9002, 24.852, 1, NULL, NULL, NULL, NULL),
(335, NULL, NULL, '', 'Carnegie Vanguard High - TX', '10401 Scott Street', 'Houston', 'Texas', '77051', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3082, 24.4458, 1, NULL, NULL, NULL, NULL),
(336, NULL, NULL, '', 'Houston Chavez High - TX', '8501 Howard', 'Houston', 'Texas', '77017', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4247, 24.4071, 1, NULL, NULL, NULL, NULL),
(337, NULL, NULL, '', 'Houston Davis High - TX', '1101 Quitman', 'Houston', 'Texas', '77009', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8017, -95.3678, 1, NULL, NULL, NULL, NULL),
(338, NULL, NULL, '', 'DeBakey High for Health - TX', '3100 Shenandoah', 'Houston', 'Texas', '77021', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4871, 24.5981, 1, NULL, NULL, NULL, NULL),
(339, NULL, NULL, '', 'Houston Furr High School - TX', '520 Mercury', 'Houston', 'Texas', '77013', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4545, 24.5539, 1, NULL, NULL, NULL, NULL),
(340, NULL, NULL, '', 'Houston Jones High School - TX', '7414 St. Lo', 'Houston', 'Texas', '77033', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3295, 24.4826, 1, NULL, NULL, NULL, NULL),
(341, NULL, NULL, '', 'Houston Jordan High - TX', '5800 Eastex Freeway', 'Houston', 'Texas', '77026', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8034, -95.3259, 1, NULL, NULL, NULL, NULL),
(342, NULL, NULL, '', 'Houston Kashmere High - TX', '6900 Wileyvale', 'Houston', 'Texas', '77028', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8342, -95.2789, 1, NULL, NULL, NULL, NULL),
(343, NULL, NULL, '', 'Houston Lamar High School - TX', '3325 Westheimer', 'Houston', 'Texas', '77098', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7333, -95.4175, 1, NULL, NULL, NULL, NULL),
(344, NULL, NULL, '', 'Houston Lee High School - TX', '6529 Beverly Hill', 'Houston', 'Texas', '77057', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7504, -95.4935, 1, NULL, NULL, NULL, NULL),
(345, NULL, NULL, '', 'Houston Madison High - TX', '13719 White Heather Dr.', 'Houston', 'Texas', '77045', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3562, 24.7222, 1, NULL, NULL, NULL, NULL),
(346, NULL, NULL, '', 'Houston Milby High School - TX', '1601 Broadway', 'Houston', 'Texas', '77012', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.2027, 14.869, 1, NULL, NULL, NULL, NULL),
(347, NULL, NULL, '', 'N Houston Early College - TX', '99 Lyerly', 'Houston', 'Texas', '77022', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4712, 24.7042, 1, NULL, NULL, NULL, NULL),
(348, NULL, NULL, '', 'Houston Reagan High - TX', '413 East 13th', 'Houston', 'Texas', '77008', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7996, -95.4201, 1, NULL, NULL, NULL, NULL),
(349, NULL, NULL, '', 'Scarborough High School - TX', '4141 Costa Rica', 'Houston', 'Texas', '77092', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8321, -95.4725, 1, NULL, NULL, NULL, NULL),
(350, NULL, NULL, '', 'Sharpstown High School - TX', '7504 Bissonnet', 'Houston', 'Texas', '77074', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 36.8081, 34.6053, 1, NULL, NULL, NULL, NULL),
(351, NULL, NULL, '', 'Houston Sterling High - TX', '11625 Martindale', 'Houston', 'Texas', '77048', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6246, -95.3207, 1, NULL, NULL, NULL, NULL),
(352, NULL, NULL, '', 'Waltrip High School - TX', '1900 West 34th', 'Houston', 'Texas', '77018', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4156, 24.4717, 1, NULL, NULL, NULL, NULL),
(353, NULL, NULL, '', 'Washington HS - Houston', '119 East 39th', 'Houston', 'Texas', '77018', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4156, 24.4717, 1, NULL, NULL, NULL, '2012-02-24 21:51:49'),
(354, NULL, NULL, '', 'Houston Westbury High - TX', '11911 Chimney Rock', 'Houston', 'Texas', '77035', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3471, 24.5245, 1, NULL, NULL, NULL, NULL),
(355, NULL, NULL, '', 'Houston Wheatley High - TX', '4801 Providence', 'Houston', 'Texas', '77020', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', -10.1816, -48.3153, 1, NULL, NULL, NULL, NULL),
(356, NULL, NULL, '', 'Houston Worthing High - TX', '9215 Scott', 'Houston', 'Texas', '77051', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3082, 24.4458, 1, NULL, NULL, NULL, NULL),
(357, NULL, NULL, '', 'Houston Yates High School - TX', '3703 Sampson', 'Houston', 'Texas', '77004', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4099, 24.6106, 1, NULL, NULL, NULL, NULL),
(358, NULL, NULL, '', 'Westbury Christian Prep - TX', '10420 Hillcroft Street', 'Houston', 'Texas', '77096', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.67, -95.483, 1, NULL, NULL, NULL, NULL),
(359, NULL, NULL, '', 'Three Rivers High School - TX', '108 North School Road', 'Three Rivers', 'Texas', '78071', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 28.5665, -98.1776, 1, NULL, NULL, NULL, NULL),
(360, NULL, NULL, '', 'Richmond Foster High - TX', '4400 FM 723', 'Richmond', 'Texas', '77469', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.2208, 37.3854, 1, NULL, NULL, NULL, NULL),
(361, NULL, NULL, '', 'George Ranch High School - TX', '8181 FM 762', 'Richmond', 'Texas', '77469', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.2208, 37.3854, 1, NULL, NULL, NULL, NULL),
(362, NULL, NULL, '', 'Lamar Consolidated High - TX', '4606 Mustang Avenue', 'Rosenberg', 'Texas', '77471', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8277, 24.8993, 1, NULL, NULL, NULL, NULL),
(363, NULL, NULL, '', 'Rosenberg Terry High - TX', '5500 Avenue N', 'Rosenberg', 'Texas', '77471', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8277, 24.8993, 1, NULL, NULL, NULL, NULL),
(364, NULL, NULL, '', 'WH Adamson High School - TX', '201 E. Ninth Street', 'Dallas', 'Texas', '75203', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.3618, 33.5327, 1, NULL, NULL, NULL, NULL),
(365, NULL, NULL, '', 'Dallas Bryan Adams High - TX', '2101 Millmar', 'Dallas', 'Texas', '75228', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.784, 38.5638, 1, NULL, NULL, NULL, NULL),
(366, NULL, NULL, '', 'Dallas David Carter High - TX', '1819 W. Wheatland Rd', 'Dallas', 'Texas', '75232', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.7435, 38.6635, 1, NULL, NULL, NULL, NULL),
(367, NULL, NULL, '', 'Dallas Conrad High School - TX', '7502 Fair Oaks Ave.', 'Dallas', 'Texas', '75231', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.8573, 17.6038, 1, NULL, NULL, NULL, NULL),
(368, NULL, NULL, '', 'Dallas FDR High School - TX', '525 Bonnie View Rd.', 'Dallas', 'Texas', '75203', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.3618, 33.5327, 1, NULL, NULL, NULL, NULL),
(369, NULL, NULL, '', 'H Grady Spruce High - TX', '9733 Old Seagoville Rd.', 'Dallas', 'Texas', '75217', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2652, 25.0702, 1, NULL, NULL, NULL, NULL),
(370, NULL, NULL, '', 'Dallas Hillcrest High - TX', '9924 Hillcrest Rd.', 'Dallas', 'Texas', '75230', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.4567, 33.8724, 1, NULL, NULL, NULL, NULL),
(371, NULL, NULL, '', 'Dallas James Madison High - TX', '3000 Martin L. King Jr. Blvd.', 'Dallas', 'Texas', '75215', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2744, 25.2639, 1, NULL, NULL, NULL, NULL),
(372, NULL, NULL, '', 'Dallas Kimball High - TX', '3606 S. Westmoreland Rd.', 'Dallas', 'Texas', '75233', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.4129, 33.8777, 1, NULL, NULL, NULL, NULL),
(373, NULL, NULL, '', 'Dallas LG Pinkston High - TX', '2200 Dennison St.', 'Dallas', 'Texas', '75212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.304, 25.1806, 1, NULL, NULL, NULL, NULL),
(374, NULL, NULL, '', 'Dallas Lincoln High - TX', '2826 Hatcher St.', 'Dallas', 'Texas', '75215', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2744, 25.2639, 1, NULL, NULL, NULL, NULL),
(375, NULL, NULL, '', 'Maya Angelou High School - TX', '3313 S. Beckley', 'Dallas', 'Texas', '75224', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.734, 38.5953, 1, NULL, NULL, NULL, NULL),
(376, NULL, NULL, '', 'Middle College High - TX', '701 Elm St.', 'Dallas', 'Texas', '75202', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.3618, 33.5327, 1, NULL, NULL, NULL, NULL),
(377, NULL, NULL, '', 'Dallas Moises Molina High - TX', '2355 Duncanville Rd.', 'Dallas', 'Texas', '75211', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.4258, 33.3303, 1, NULL, NULL, NULL, NULL),
(378, NULL, NULL, '', 'N Dallas High School - TX', '3120 N. Haskell Ave.', 'Dallas', 'Texas', '75204', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.3618, 33.5327, 1, NULL, NULL, NULL, NULL),
(379, NULL, NULL, '', 'Seagoville High School - TX', '15920 Seagoville Rd.', 'Dallas', 'Texas', '75253', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.6748, 38.7473, 1, NULL, NULL, NULL, NULL),
(380, NULL, NULL, '', 'Dallas Skyline High - TX', '7777 Forney Rd.', 'Dallas', 'Texas', '75227', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.7498, 38.5375, 1, NULL, NULL, NULL, NULL),
(381, NULL, NULL, '', 'Dallas S. Oak Cliff High - TX', '3601 S. Marsalis Ave.', 'Dallas', 'Texas', '75216', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.3207, 25.2042, 1, NULL, NULL, NULL, NULL),
(382, NULL, NULL, '', 'Dallas Jefferson High - TX', '4001 Walnut Hill Ln.', 'Dallas', 'Texas', '75229', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.8669, 17.6101, 1, NULL, NULL, NULL, NULL),
(383, NULL, NULL, '', 'Dallas WT White High - TX', '4505 Ridgeside Dr.', 'Dallas', 'Texas', '75244', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.8333, 17.6057, 1, NULL, NULL, NULL, NULL),
(384, NULL, NULL, '', 'Wilmer-Hutchins High - TX', '5520 Langdon Rd.', 'Dallas', 'Texas', '75241', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.8639, 38.7054, 1, NULL, NULL, NULL, NULL),
(385, NULL, NULL, '', 'Dallas Wilson High School - TX', '5520 Langdon Rd.', 'Dallas', 'Texas', '75214', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2799, 25.1778, 1, NULL, NULL, NULL, NULL),
(386, NULL, NULL, '', 'Dallas WW Samuell High - TX', '8928 Palisade Dr.', 'Dallas', 'Texas', '75217', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2652, 25.0702, 1, NULL, NULL, NULL, NULL),
(387, NULL, NULL, '', 'Tarkington High School - TX', '2770 Fm 163 Rd', 'Cleveland', 'Texas', '77327', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.0316, 37.761, 1, NULL, NULL, NULL, NULL),
(388, NULL, NULL, '', 'Knippa High School - TX', '100 Kessler Lane', 'Knippa', 'Texas', '78870', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8361, 2.07958, 1, NULL, NULL, NULL, NULL),
(389, NULL, NULL, '', 'Woodlands Christian Acad - TX', '5800 Academy Way', 'The Woodlands', 'Texas', '77384', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.8321, 37.8565, 1, NULL, NULL, NULL, NULL),
(390, NULL, NULL, '', 'Priddy High School - TX', 'PO Box 40', 'Priddy', 'Texas', '76870', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.0849, 8.19081, 1, NULL, NULL, NULL, NULL),
(391, NULL, NULL, '', 'Goose Creek Memorial High - TX', '6001 E. Wallisville', 'Baytown', 'Texas', '77521', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.6812, 37.8671, 1, NULL, NULL, NULL, NULL),
(392, NULL, NULL, '', 'Baytown Robert E Lee High - TX', '1809 Market Street', 'Baytown', 'Texas', '77520', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.4965, 3.121, 1, NULL, NULL, NULL, NULL),
(393, NULL, NULL, '', 'Baytown Sterling High - TX', '300 W. Baker Road', 'Baytown', 'Texas', '77521', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.6812, 37.8671, 1, NULL, NULL, NULL, NULL),
(396, NULL, NULL, '', 'Pleasanton High School - TX', '900 West Adams Street', 'Pleasanton', 'Texas', '78064', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 61.0238, 13.0908, 1, NULL, NULL, NULL, NULL),
(395, NULL, NULL, '', 'Prestonwood Christian HS - TX', '6801 W Park Blvd', 'Plano', 'Texas', '75093', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 33.0398, -96.8029, 1, NULL, NULL, NULL, NULL),
(397, NULL, NULL, '', 'North Forney High School - TX', '6170 N. Mason Blvd.', 'Forney', 'Texas', '75126', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2364, 25.2691, 1, NULL, NULL, NULL, NULL),
(398, NULL, NULL, '', 'Forney High School - TX', '800 FM 741', 'Forney', 'Texas', '75126', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2364, 25.2691, 1, NULL, NULL, NULL, NULL),
(399, NULL, NULL, '', 'Millsap High School - TX', '600 Bulldog Boulevard', 'Millsap', 'Texas', '76066', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9226, 24.7111, 1, NULL, NULL, NULL, NULL),
(400, NULL, NULL, '', 'Northland Christian High - TX', '4363 Sylvanfield Drive', 'Houston', 'Texas', '77014', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.224, 14.9779, 1, NULL, NULL, NULL, NULL),
(401, NULL, NULL, '', 'Mansfield High School - TX', '3001 East Broad Street', 'Mansfield', 'Texas', '76063', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9226, 24.7111, 1, NULL, NULL, NULL, NULL),
(402, NULL, NULL, '', 'Mansfield Legacy High - TX', '1263 N Main St - A', 'Mansfield', 'Texas', '76063', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9226, 24.7111, 1, NULL, NULL, NULL, NULL),
(403, NULL, NULL, '', 'Mansfield Summit High - TX', '1071 West Turner Warnell Road', 'Arlington', 'Texas', '76001', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 55.9846, 23.3268, 1, NULL, NULL, NULL, NULL),
(404, NULL, NULL, '', 'Mansfield Timberview High - TX', '7700 S Watson Rd', 'Arlington', 'Texas', '76002', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.2268, 24.0241, 1, NULL, NULL, NULL, NULL),
(405, NULL, NULL, '', 'Linden-Kildare High - TX', '205 Kildare Road', 'Linden', 'Texas', '75563', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.1884, 39.1179, 1, NULL, NULL, NULL, NULL),
(406, NULL, NULL, '', 'Crane High School - TX', '809 W. 8th Street', 'Crane', 'Texas', '79731', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.3688, -102.369, 1, NULL, NULL, NULL, NULL),
(407, NULL, NULL, '', 'Harlandale High School - TX', '114 E. Gerald.', 'San Antonio', 'Texas', '78214', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.5261, 25.1177, 1, NULL, NULL, NULL, NULL),
(408, NULL, NULL, '', 'McCollum High School - TX', '500 W. Formosa', 'San Antonio', 'Texas', '78221', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.7235, 24.7532, 1, NULL, NULL, NULL, NULL),
(409, NULL, NULL, '', 'Marion High School - TX', '506 Bulldog Drive', 'Marion', 'Texas', '78124', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8801, 1.85961, 1, NULL, NULL, NULL, NULL),
(410, NULL, NULL, '', 'Leakey High School - TX', '429 Hwy 83 N', 'Leakey', 'Texas', '78873', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.7509, -99.7679, 1, NULL, NULL, NULL, NULL),
(411, NULL, NULL, '', 'Laredo LBJ High School - TX', '5626 Cielito Lindo', 'Laredo', 'Texas', '78046', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8057, 25.2312, 1, NULL, NULL, NULL, NULL),
(412, NULL, NULL, '', 'Lampasas High School - TX', '2716 S. Hwy. 281', 'Lampasas', 'Texas', '76550', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.8704, 1.05189, 1, NULL, NULL, NULL, NULL),
(413, NULL, NULL, '', 'La Joya High School - TX', '604 N Coyote Blvd', 'La Joya', 'Texas', '78560', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.4816, 24.5819, 1, NULL, NULL, NULL, NULL),
(414, NULL, NULL, '', 'Loraine High School - TX', '800 S Lightfoot', 'Loraine', 'Texas', '79532', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.939, 15.1298, 1, NULL, NULL, NULL, NULL),
(415, NULL, NULL, '', 'Lubbock High School - TX', '2004 19th Street', 'Lubbock', 'Texas', '79401', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.0596, 24.9494, 1, NULL, NULL, NULL, NULL),
(416, NULL, NULL, '', 'Leon High School - TX', '12168 US Highway 79', 'Jewett', 'Texas', '75846', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.8415, 39.6621, 1, NULL, NULL, NULL, NULL),
(417, NULL, NULL, '', 'Galveston O&#39;Connel Prep - TX', '1320 Tremont Street', 'Galveston', 'Texas', '77550', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.6195, 2.60451, 1, NULL, NULL, NULL, NULL),
(418, NULL, NULL, '', 'Andrews High School - TX', '405 NW 3Rd St', 'Andrews', 'Texas', '79714', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 32.3426, -102.714, 1, NULL, NULL, NULL, NULL),
(419, NULL, NULL, '', 'University High School - TX', '3201 South New Road', 'Waco', 'Texas', '76706', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.1702, 8.42028, 1, NULL, NULL, NULL, NULL),
(420, NULL, NULL, '', 'Waco High School - TX', '2020 N. 42nd Street', 'Waco', 'Texas', '76710', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 59.3421, 24.2776, 1, NULL, NULL, NULL, NULL),
(521, NULL, NULL, '', 'Paterson Eastside High - NJ', '150 Park Avenue', 'Paterson', 'New Jersey', '07501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.3507, 31.3189, 1, NULL, NULL, NULL, NULL),
(425, NULL, NULL, '', 'Orange Grove HS - TX', '100 Bulldog Ln', 'Orange Grove', 'Texas', '78372', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.5508, 17.3403, 1, NULL, NULL, NULL, '2012-02-28 16:35:32'),
(426, NULL, NULL, '', 'Aldine Senior High School - TX', '11101 Airline Drive', 'Houston', 'Texas', '77037', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.3602, 24.6097, 1, NULL, NULL, NULL, NULL),
(427, NULL, NULL, '', 'A Maceo Smith High School - TX', '3030 Stag Road', 'Dallas', 'Texas', '75241', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.8639, 38.7054, 1, NULL, NULL, NULL, NULL),
(428, NULL, NULL, '', 'All Saints Episcopal HS - Forth Worth', '9700 Saints Circle', 'Fort Worth', 'Texas', '76108', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9226, 24.7111, 1, NULL, NULL, NULL, '2012-02-28 16:36:05'),
(429, NULL, NULL, '', 'Houston Carver High - TX', '2100 South Victory Street', 'Houston', 'Texas', '77088', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8791, -95.4516, 1, NULL, NULL, NULL, NULL),
(430, NULL, NULL, '', 'Houston MacArthur Sr High - TX', '4400 Aldine Mail Route', 'Houston', 'Texas', '77039', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.9068, -95.3364, 1, NULL, NULL, NULL, NULL),
(431, NULL, NULL, '', 'Victory Early College - TX', '4141 Victory Drive', 'Houston', 'Texas', '77088', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8791, -95.4516, 1, NULL, NULL, NULL, NULL),
(432, NULL, NULL, '', 'Nimitz Senior High School - TX', '2005 W.W. Thorne Drive', 'Houston', 'Texas', '77073', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.2913, 24.7349, 1, NULL, NULL, NULL, NULL),
(433, NULL, NULL, '', 'Houston Eisenhower Senior - TX', '2005 W.W. Thorne Drive', 'Houston', 'Texas', '77088', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8791, -95.4516, 1, NULL, NULL, NULL, NULL),
(434, NULL, NULL, '', 'Columbus High School - TX', '103 Cardinal Lane', 'Columbus', 'Texas', '78934', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.6502, -96.557, 1, NULL, NULL, NULL, NULL),
(435, NULL, NULL, '', 'Cypress Falls High School - TX', '9811 Huffmeister Road', 'Houston', 'Texas', '77095', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.9108, -95.6563, 1, NULL, NULL, NULL, NULL),
(436, NULL, NULL, '', 'Buna High School - TX', '177 FM 253', 'Buna', 'Texas', '77612', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9942, 24.1867, 1, NULL, NULL, NULL, NULL),
(437, NULL, NULL, '', 'Calhoun HS - Port Lavaca', '201 Sandcrab Boulevard', 'Port Lavaca', 'Texas', '77979', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.6216, 38.6897, 1, NULL, NULL, NULL, '2012-02-28 16:38:56'),
(438, NULL, NULL, '', 'Carrizo Springs High - TX', '286 FM 1556', 'CarrizoSprings', 'Texas', '78834', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 28.4481, -99.9465, 1, NULL, NULL, NULL, NULL),
(439, NULL, NULL, '', 'The Emery-Weiner School - TX', '9825 Stella Link', 'Houston', 'Texas', '77025', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4424, 24.7119, 1, NULL, NULL, NULL, NULL),
(440, NULL, NULL, '', 'Fayetteville High School - TX', '618 North Rusk Street', 'Fayetteville', 'Texas', '78940', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.7988, 1.75171, 1, NULL, NULL, NULL, NULL),
(441, NULL, NULL, '', 'Fairfield High School - TX', '631 Post Oak', 'Fairfield', 'Texas', '75840', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.119, 33.4786, 1, NULL, NULL, NULL, NULL),
(442, NULL, NULL, '', 'Fort Bend Christian - TX', '1250 Seventh Street', 'Sugarland', 'Texas', '77478', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.2401, 37.2919, 1, NULL, NULL, NULL, NULL),
(443, NULL, NULL, '', 'Caney Creek High School - TX', '13470 F M 1485', 'Conroe', 'Texas', '777306', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(444, NULL, NULL, '', 'Kingwood Park High School - TX', '4015 Woodland Hills Drive', 'Humble', 'Texas', '77339', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.0653, 38.0049, 1, NULL, NULL, NULL, NULL),
(445, NULL, NULL, '', 'Marshall High School - TX', '1900 Maverick Dr', 'Marshall', 'Texas', '75670', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 32.5744, -94.3771, 1, NULL, NULL, NULL, NULL),
(446, NULL, NULL, '', 'Eastlake HS - El Paso', '12300 Eastlake Dr', 'El Paso', 'Texas', '79928', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.6578, -106.135, 1, NULL, NULL, NULL, '2012-02-28 16:38:28'),
(447, NULL, NULL, '', 'Converse Judson High - TX', '9142 FM 78', 'Converse', 'Texas', '78109', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.472, -98.2979, 1, NULL, NULL, NULL, NULL),
(448, NULL, NULL, '', 'Katy Taylor High School - TX', '20700 Kingsland Boulevard', 'Katy', 'Texas', '77450', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9241, 24.6654, 1, NULL, NULL, NULL, NULL),
(449, NULL, NULL, '', 'Seven Lakes High School - TX', '9251 South Fry Road', 'Katy', 'Texas', '77494', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.327, 37.2383, 1, NULL, NULL, NULL, NULL),
(450, NULL, NULL, '', 'Morton Ranch High School - TX', '21000 Franz Rd', 'Katy', 'Texas', '77449', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.2717, 37.4308, 1, NULL, NULL, NULL, NULL),
(451, NULL, NULL, '', 'Mayde Creek High School - TX', '19202 Groschke Road', 'Houston', 'Texas', '77084', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 29.8297, -95.6668, 1, NULL, NULL, NULL, NULL),
(452, NULL, NULL, '', 'Katy Raines High School - TX', '1732 Katyland Drive', 'Katy', 'Texas', '77493', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 60.1439, 16.0461, 1, NULL, NULL, NULL, NULL),
(453, NULL, NULL, '', 'Katy High School - TX', '6331 Highway Boulevard', 'Katy', 'Texas', '77494', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.327, 37.2383, 1, NULL, NULL, NULL, NULL),
(454, NULL, NULL, '', 'Cinco Ranch High School - TX', '23440 Cinco Ranch Boulevard', 'Katy', 'Texas', '77494', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 31.327, 37.2383, 1, NULL, NULL, NULL, NULL),
(457, NULL, NULL, '', 'Cranston East High School - RI', '899 Park Avenue', 'Cranston', 'Rhode Island', '02910', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.4501, 30.5234, 1, NULL, NULL, NULL, NULL),
(458, NULL, NULL, '', 'Benson Polytechnic High - OR', '546 NE 12th Ave.', 'Portland', 'Oregon', '97232', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.6434, 9.93619, 1, NULL, NULL, NULL, NULL),
(459, NULL, NULL, '', 'Cleveland High School - OR', '3400 SE 26th Ave', 'Portland', 'Oregon', '97202', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.3417, 34.9325, 1, NULL, NULL, NULL, NULL),
(460, NULL, NULL, '', 'Portland Franklin High - OR', '5405 SE Woodward', 'Portland', 'Oregon', '97206', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.4856, -122.595, 1, NULL, NULL, NULL, NULL),
(461, NULL, NULL, '', 'Portland Grant High - OR', '2245 NE 36th Ave', 'Portland', 'Oregon', '97212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8238, 18.6759, 1, NULL, NULL, NULL, NULL),
(462, NULL, NULL, '', 'Portland Jefferson High - OR', '5210 N Kerby', 'Portland', 'Oregon', '97217', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.8211, 18.5673, 1, NULL, NULL, NULL, NULL),
(463, NULL, NULL, '', 'Portland Lincoln High - OR', '1600 SW Salmon St', 'Portland', 'Oregon', '97205', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.3417, 34.9325, 1, NULL, NULL, NULL, NULL),
(464, NULL, NULL, '', 'Portland Madison High - OR', '2735 NE 82nd', 'Portland', 'Oregon', '97220', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.337, 35.0678, 1, NULL, NULL, NULL, NULL),
(465, NULL, NULL, '', 'Portland Roosevelt High - OR', '6941 N. Central', 'Portland', 'Oregon', '97203', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.3417, 34.9325, 1, NULL, NULL, NULL, NULL),
(466, NULL, NULL, '', 'Portland Wilson High - OR', '1151 SW Vermont', 'Portland', 'Oregon', '97219', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 45.4618, -122.718, 1, NULL, NULL, NULL, NULL),
(467, NULL, NULL, '', 'Midland Park High School - NJ', '250 Prospect Street', 'MidlandPark', 'New Jersey', '07432', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.9965, -74.1387, 1, NULL, NULL, NULL, NULL),
(470, NULL, NULL, '', 'Newfield Senior High - NY', '247 Main St', 'Newfield', 'New York', '14867', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 24.9594, 47.3609, 1, NULL, NULL, NULL, NULL),
(471, NULL, NULL, '', 'Centereach High School - NY', '14 43rd St', 'Centereach', 'New York', '11720', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', -24.0072, -46.4579, 1, NULL, NULL, NULL, NULL),
(472, NULL, NULL, '', 'Holy Trinity Diocesan - NY', '98 Cherry Lane', 'Hicksville', 'New York', '11801', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.7581, -73.5241, 1, NULL, NULL, NULL, NULL),
(473, NULL, NULL, '', 'Cuba-Rushford High School - NY', '5476 Rte 305 N', 'Cuba', 'New York', '14727', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 52.5395, 12.3564, 1, NULL, NULL, NULL, NULL),
(477, NULL, NULL, '', 'Cheektowaga JFK High - NY', '305 Cayuga Creek Rd', 'Cheektowaga', 'New York', '14227', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 51.4982, 31.2894, 1, NULL, NULL, NULL, NULL),
(475, NULL, NULL, '', 'The Dwight School - NY', '291 Central Park West', 'York', 'New York', '10024', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 44.9923, 7.71082, 1, NULL, NULL, NULL, NULL),
(476, NULL, NULL, '', 'Sacred Heart High School - NY', '34 Convent Ave', 'Yonkers', 'New York', '10703', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.9508, -73.886, 1, NULL, NULL, NULL, NULL),
(478, NULL, NULL, '', 'Niagara Wheatfield High - NY', '2292 Saunders Settlement Road', 'Sanborn', 'New York', '14132', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 51.4982, 31.2894, 1, NULL, NULL, NULL, NULL),
(479, NULL, NULL, '', 'Middletown High School - NY', '24 Gardner Avenue', 'Middletown', 'New York', '10940', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 39.6742, -6.53565, 1, NULL, NULL, NULL, NULL),
(480, NULL, NULL, '', 'New Lebanon Central High - NY', '14665 New York 22', 'NewLebanon', 'New York', '12125', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.1342, -0.440804, 1, NULL, NULL, NULL, '2012-02-07 10:09:23'),
(481, NULL, NULL, '', 'Caledonia High School - MS', '99 Confederate Drive', 'Caledonia', 'Mississippi', '39740', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 43.4561, -3.44479, 1, NULL, NULL, NULL, NULL),
(482, NULL, NULL, '', 'Brookhaven High School - MS', '443 E Monticello St', 'Brookhaven', 'Mississippi', '39601', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.5556, 15.3181, 1, NULL, NULL, NULL, NULL),
(483, NULL, NULL, '', 'Alcorn Central High - MS', '8 Cr 254', 'Glen', 'Mississippi', '38846', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 22.271, 48.1201, 1, NULL, NULL, NULL, NULL),
(484, NULL, NULL, '', 'Southaven High School - MS', '899 Rasco Rd', 'Southaven', 'Mississippi', '38671', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 21.9184, 50.0598, 1, NULL, NULL, NULL, NULL),
(485, NULL, NULL, '', 'Enterprise High School - MS', '501 S River Rd', 'Enterprise', 'Mississippi', '39330', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.4006, 34.0988, 1, NULL, NULL, NULL, NULL),
(486, NULL, NULL, '', 'Hillcrest Christian High - MS', '4060 South Siwell Road', 'Jackson', 'Mississippi', '39212', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 43.0687, -4.20259, 1, NULL, NULL, NULL, NULL),
(487, NULL, NULL, '', 'DeRidder High School - LA', '723 Oâ€™Neal Street', 'DeRidder', 'Louisiana', '70634', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 47.4958, 36.1256, 1, NULL, NULL, NULL, NULL),
(488, NULL, NULL, '', 'East Beauregard High - LA', '5364 Highway 113', 'DeRidder', 'Louisiana', '70634', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 47.4958, 36.1256, 1, NULL, NULL, NULL, NULL),
(489, NULL, NULL, '', 'Assumption High School - LA', '4880 Highway 308', 'Napoleanville', 'Louisiana', '70390', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', -15.8126, -47.9125, 1, NULL, NULL, NULL, NULL),
(490, NULL, NULL, '', 'Grand Lake High School - LA', '1039 Hwy 384 Grand Lake', 'Lake Charles', 'Louisiana', '70607', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 47.4849, 36.26, 1, NULL, NULL, NULL, NULL),
(491, NULL, NULL, '', 'Midland High School - LA', '735 South Crocker', 'Midland', 'Louisiana', '70559', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 30.1125, -92.4802, 1, NULL, NULL, NULL, NULL),
(492, NULL, NULL, '', 'Lakeview High School - LA', '7305 Louisiana 9', 'Campti', 'Louisiana', '71411', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.6046, 25.2664, 1, NULL, NULL, NULL, NULL),
(493, NULL, NULL, '', 'Ruston High School - LA', '900 Bearcat Drive', 'Ruston', 'Louisiana', '71270', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.9196, 5.23063, 1, NULL, NULL, NULL, NULL),
(494, NULL, NULL, '', 'Rockford Christian High  - IL', '1401 North Bell School Road', 'Rockford', 'Illinois', '61107', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.247, 26.2306, 1, NULL, NULL, NULL, NULL),
(495, NULL, NULL, '', 'Romeoville High School - IL', '100 N Independence', 'Romeoville', 'Illinois', '60446', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.0075, 26.1327, 1, NULL, NULL, NULL, NULL),
(496, NULL, NULL, '', 'Waukegan High School - IL', '2325 Brookside Avenue', 'Waukegan', 'Illinois', '60085', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.3642, -87.8648, 1, NULL, NULL, NULL, NULL),
(497, NULL, NULL, '', 'Lena-Winslow High School - IL', '516 Fremont Street', 'Lena', 'Illinois', '61048', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 43.6544, 12.4266, 1, NULL, NULL, NULL, NULL),
(498, NULL, NULL, '', 'Oswego East High School - IL', '1525 Harvey Road', 'Oswego', 'Illinois', '60543', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.113, 26.2177, 1, NULL, NULL, NULL, NULL),
(499, NULL, NULL, '', 'Piasa Southwestern High - IL', '8226 Rt. 111', 'Piasa', 'Illinois', '62079', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 39.1022, -90.1401, 1, NULL, NULL, NULL, NULL),
(500, NULL, NULL, '', 'Mattoon High School - IL', '2521 Walnut Avenue', 'Mattoon', 'Illinois', '61938', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 39.5163, -88.3628, 1, NULL, NULL, NULL, NULL),
(501, NULL, NULL, '', 'Madison High School - IL', '600 Farrish Street', 'Madison', 'Illinois', '62060', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 38.6791, -90.1448, 1, NULL, NULL, NULL, NULL),
(502, NULL, NULL, '', 'Collinsville High School - IL', '2201 South Morrison Avenue', 'Collinsville', 'Illinois', '62234', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 57.4247, 18.429, 1, NULL, NULL, NULL, NULL),
(503, NULL, NULL, '', 'Clinton High School - IL', '1200 Highway 54 West', 'Clinton', 'Illinois', '61727', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.1611, -88.9605, 1, NULL, NULL, NULL, NULL),
(504, NULL, NULL, '', 'Rockford Jefferson High - IL', '4145 Samuelson Road', 'Rockford', 'Illinois', '61109', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.9935, 36.2304, 1, NULL, NULL, NULL, NULL),
(505, NULL, NULL, '', 'Hillsboro High School - IL', '522 East Tremont Street', 'Hillsboro', 'Illinois', '62049', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.8682, 23.7395, 1, NULL, NULL, NULL, NULL),
(506, NULL, NULL, '', 'Thornton Township High - IL', '522 East Tremont Street', 'Harvey', 'Illinois', '60426', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.0062, 25.7656, 1, NULL, NULL, NULL, NULL),
(507, NULL, NULL, '', 'Danville High School - IL', '202 East Fairchild Street', 'Danville', 'Illinois', '61832', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.6634, 16.3939, 1, NULL, NULL, NULL, NULL),
(508, NULL, NULL, '', 'Decatur Lutheran High - IL', '2001 E Mound Rd', 'Decatur', 'Illinois', '62526', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 18.1948, 42.5534, 1, NULL, NULL, NULL, NULL),
(509, NULL, NULL, '', 'Champaign Central High - IL', '610 W University Ave', 'Champaign', 'Illinois', '61820', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 62.4882, 22.0426, 1, NULL, NULL, NULL, NULL),
(510, NULL, NULL, '', 'Hinsdale Central High - IL', '55th and Grant Streets', 'Hinsdale', 'Illinois', '60521', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.4754, 26.5872, 1, NULL, NULL, NULL, NULL),
(511, NULL, NULL, '', 'Naperville Central High - IL', '440 West Aurora Avenue', 'Naperville', 'Illinois', '60540', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.4758, 26.6681, 1, NULL, NULL, NULL, NULL),
(512, NULL, NULL, '', 'Breese Central Community - IL', '7740 Old US 50', 'Breese', 'Illinois', '62230', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 63.1807, 23.0986, 1, NULL, NULL, NULL, NULL),
(513, NULL, NULL, '', 'Burlington Central High - IL', '44W625 Plato Road', 'Burlington', 'Illinois', '60109', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.0526, -88.5466, 1, NULL, NULL, NULL, NULL),
(514, NULL, NULL, '', 'Limestone Community High - IL', '4201 Airport Road', 'Bartonville', 'Illinois', '61607', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 58.1971, 26.442, 1, NULL, NULL, NULL, NULL),
(515, NULL, NULL, '', 'Wellington-Napoleon High - MO', '800 Missouri 131', 'Wellington', 'Missouri', '64097', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 39.1179, -93.9776, 1, NULL, NULL, NULL, NULL),
(516, NULL, NULL, '', 'StL Sumner High School - MO', '4248 West Cottage Avenue', 'St Louis', 'Missouri', '63113', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 57.9404, 26.751, 1, NULL, NULL, NULL, NULL),
(517, NULL, NULL, '', 'Windsor High School - MO', '6208 Hwy 61-67', 'Imperial', 'Missouri', '63052', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.6991, 35.4318, 1, NULL, NULL, NULL, NULL),
(518, NULL, NULL, '', 'Neelyville High School - MO', '289 Broadway St', 'Neelyville', 'Missouri', '63954', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 19.3039, 41.9147, 1, NULL, NULL, NULL, NULL),
(519, NULL, NULL, '', 'St Joseph Central High - MO', '2602 Edmond St', 'St Joseph', 'Missouri', '64501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.1465, 35.871, 1, NULL, NULL, NULL, NULL),
(522, NULL, NULL, '', 'Union Township High - NJ', '2350 North Third Street', 'Union', 'New Jersey', '07083', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.6843, -74.2531, 1, NULL, NULL, NULL, NULL),
(523, NULL, NULL, '', 'Park Ridge High School - NJ', '2 Park Ave', 'Park Ridge', 'New Jersey', '07656', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 41.0325, -74.0447, 1, NULL, NULL, NULL, NULL),
(527, NULL, NULL, '', 'Bay Port High School - WI', '2710 Lineville Road', 'Green Bay', 'Wisconsin', '54313', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.8783, 6.67332, 1, NULL, NULL, NULL, NULL),
(528, NULL, NULL, '', 'Bloomer High School - WI', '1310 17Th Ave', 'Bloomer', 'Wisconsin', '54724', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 25.747, 42.2066, 1, NULL, NULL, NULL, NULL),
(529, NULL, NULL, '', 'Belleville High School - WI', '635 W Church St', 'Belleville', 'Wisconsin', '53508', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.515, 7.01489, 1, NULL, NULL, NULL, NULL),
(531, NULL, NULL, '', 'Harding Charter Prep - OK', '3333 North Shartel Avenue', 'Oklahoma City', 'Oklahoma', '73118', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 46.6354, 32.6169, 1, NULL, NULL, NULL, NULL),
(532, NULL, NULL, '', 'Booker T Washington HS - Pensacola', '6000 College Parkway', 'Pensacola', 'Florida', '32504', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.039, 27.2252, 1, NULL, NULL, NULL, '2012-02-24 21:50:36'),
(533, NULL, NULL, '', 'Escambia High School - FL', '1310 N 65th avenue', 'Pensacola', 'Florida', '32506', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.9996, 27.2356, 1, NULL, NULL, NULL, NULL),
(534, NULL, NULL, '', 'JM Tate High School - FL', '1771 Tate Road', 'Cantonment', 'Florida', '32533', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 26.4539, 49.9111, 1, NULL, NULL, NULL, NULL),
(535, NULL, NULL, '', 'Pensacola High School - FL', '500 W Maxwell St', 'Pensacola', 'Florida', '32501', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.039, 27.2252, 1, NULL, NULL, NULL, NULL),
(536, NULL, NULL, '', 'Pine Forest High School - FL', '2500 Longleaf Dr', 'Pensacola', 'Florida', '32526', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.4682, -8.17517, 1, NULL, NULL, NULL, NULL),
(537, NULL, NULL, '', 'West Florida High School - FL', '2400 Longleaf Drive', 'Pensacola', 'Florida', '32526', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 42.4682, -8.17517, 1, NULL, NULL, NULL, NULL),
(538, NULL, NULL, '', 'Emsley A. Laney HS - NC', '2700 N College Rd', 'Wilmington', 'North Carolina', '28405', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 48.2508, 32.2084, 1, NULL, NULL, NULL, NULL),
(539, NULL, NULL, '', 'North Hunterdon High - NJ', '1445 State Route 31', 'Annandale', 'New Jersey', '08801', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 49.6485, 30.9693, 1, NULL, NULL, NULL, NULL),
(540, NULL, NULL, '', 'De Paul Catholic - NJ', '1512 Alps Road', 'Wayne', 'New Jersey', '07470', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 44.8081, 4.01847, 1, NULL, NULL, NULL, NULL),
(541, NULL, NULL, '', 'Linden High School - NJ', '121 W St Georges Ave', 'Linden', 'New Jersey', '07036', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', -12.0132, -77.0996, 1, NULL, NULL, NULL, NULL),
(542, NULL, NULL, '', 'North Bergen High School - NJ', '7417 John F Kennedy Boulevard West', 'North Bergen', 'New Jersey', '07047', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.5236, 8.64906, 1, NULL, NULL, NULL, NULL),
(543, NULL, NULL, '', 'Patterson High - Baltimore MD', '100 Kane St', 'Baltimore', 'Maryland', '21224', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 43.5107, 16.3162, 1, NULL, NULL, NULL, NULL),
(544, NULL, NULL, '', 'St Benedict&#39;s Prep - NJ', '520 Dr. Martin Luther King. Jr. Boulevard', 'Newark', 'New Jersey', '07102', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 51.5222, 30.7457, 1, NULL, NULL, NULL, NULL),
(545, NULL, NULL, '', 'St Peter&#39;s Prep - NJ', '144 Grand St', 'Jersey City', 'New Jersey', '07302', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.5832, 30.4857, 1, NULL, NULL, NULL, NULL),
(546, NULL, NULL, '', 'St Anthony High School - NJ', '175 Eighth Street', 'Jersey City', 'New Jersey', '07302', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 50.5832, 30.4857, 1, NULL, NULL, NULL, NULL),
(547, NULL, NULL, '', 'Teaneck High School - NJ', '100 Elizabeth Avenue', 'Teaneck', 'New Jersey', '07666', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 40.8925, -74.0124, 1, NULL, NULL, NULL, NULL),
(548, NULL, NULL, '', 'Next Level Prep - Ontario', 'Not Found', 'Toronto', 'Ontario', '00000', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(549, NULL, NULL, '', 'Cyril High School - OK', '100 West Windle Ave', 'Cyril', 'Oklahoma', '73029', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(550, NULL, NULL, '', 'West Craven High School - NC', '2600 Sts Ferry Rd', 'Vanceboro', 'North Carolina', '28586', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(551, NULL, NULL, '', 'South High School - WY', '1213 West Allison Road', 'Cheyenne', 'Wyoming', '82007', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(552, NULL, NULL, '', 'Oilton High School - OK', '309 East Peterson St', 'Oilton', 'Oklahoma', '74052', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(553, NULL, NULL, '', 'Lake Charles Stars AAU - LA', 'Not Available - AAU', 'Lake Charles', 'Louisiana', '70601', '', NULL, NULL, 'ACTIVE', NULL, NULL, '', '', 0, 0, 1, NULL, NULL, NULL, NULL),
(570, NULL, NULL, NULL, 'Monterey Trail', '8861 Power Inn Road', 'Elk Grove', 'California', '95624', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 38.4244, -121.331, 0, 'tewing', NULL, '2012-02-20', '2012-02-20 15:59:04'),
(568, NULL, NULL, NULL, 'Middletown HS North - NJ', '63 Tindall Road', 'Middletown', 'New Jersey', '07748', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 40.0479, 4.08488, 0, NULL, 'teknicksmike', '2012-02-19', '2012-02-19 23:31:54'),
(569, NULL, NULL, NULL, 'Emery Weiner School', '9825 Stella Link', 'Houston', 'Texas', '77025', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 49.4424, 24.7119, 0, 'ttuckers', NULL, '2012-02-20', '2012-02-20 15:52:16'),
(558, NULL, NULL, NULL, 'Leon HS - Tallahassee - FL', '550 E Tennessee St', 'Tallahassee', 'Florida', '32308', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 48.6967, 26.5825, 1, NULL, NULL, NULL, '2012-02-13 07:21:43'),
(559, NULL, NULL, NULL, 'Atlantic Coast HS - Jksonville', '9735 R G Skinner Parkway', 'Jacksonville', 'Florida', '32256', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.4025, 50.0881, 1, NULL, NULL, NULL, '2012-02-13 07:24:18'),
(560, NULL, NULL, NULL, 'Cocoa HS - Cocoa', '2000 Tiger Trl', 'Cocoa', 'Florida', '32926', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.7698, 49.8291, 1, NULL, NULL, NULL, '2012-02-13 07:25:39'),
(561, NULL, NULL, NULL, 'Cape Coral HS - Cape Coral', '2300 Santa Barbara Blvd', 'Cape Coral', 'Florida', '33991', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.1351, 47.6948, 1, NULL, NULL, NULL, '2012-02-13 07:33:43');
INSERT INTO `tbl_hs_aau_team` (`fldId`, `fldUserName`, `fldSchoolcode`, `fldPassword`, `fldSchoolname`, `fldAddress`, `fldCity`, `fldState`, `fldZipcode`, `fldLogo`, `fldSport`, `fldCoachname`, `fldStatus`, `fldEmail`, `fldAthleteUrl`, `fldCoachPhone`, `fldEnrollment`, `fldLatitude`, `fldLongitude`, `fldAdminApproved`, `fldAddByCoachUsername`, `fldAddByAthleteUsername`, `fldAddDate`, `fldDateLastUpdated`) VALUES
(562, NULL, NULL, NULL, 'East Bay HS - Gibsonton', '7710 Old Big Bend Road', 'Gibsonton', 'Florida', '33534', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.926, 48.875, 1, NULL, NULL, NULL, '2012-02-13 07:35:03'),
(563, NULL, NULL, NULL, 'Lake Wales HS - Lake Wales', '1 Highlander Way', 'Lake Wales', 'Florida', '33853', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.5143, 47.8576, 1, NULL, NULL, NULL, '2012-02-13 07:36:28'),
(564, NULL, NULL, NULL, 'Leonard HS - Greenacres', '4701 10th Avenue North', 'Greenacres', 'Florida', '33463', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.794, 48.9304, 1, NULL, NULL, NULL, '2012-02-13 07:38:08'),
(565, NULL, NULL, NULL, 'Ronald Reagan HS - Doral', '8600 Northwest 107th Avenue', 'Doral', 'Florida', '33178', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 51.6404, 8.7805, 1, NULL, NULL, NULL, '2012-02-13 07:39:42'),
(566, NULL, NULL, NULL, 'Coral Springs HS - Coral Sprng', '7201 W. Sample Rd.', 'Coral Springs', 'Florida', '33065', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-13 07:41:20'),
(567, NULL, NULL, NULL, 'St. John Vianney - Holmdel', '540-A Line Road', 'Holmdel', 'New Jersey', '07733', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.2784, 32.0531, 0, NULL, 'domlombardi58', '2012-02-16', '2012-02-21 18:51:05'),
(571, NULL, NULL, NULL, 'Western Reserve Academy', '115 College Street', 'Hudson', 'Ohio', '44236', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 24.0505, 40.8475, 0, 'jeffry1', NULL, '2012-02-20', '2012-02-20 16:27:12'),
(572, NULL, NULL, NULL, 'Buhach Colony HS', '1800 Buhach Rd.', 'Atwater', 'California', '95301', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 44.9521, 34.1024, 0, 'kswartwood', NULL, '2012-02-20', '2012-02-20 16:28:37'),
(573, NULL, NULL, NULL, 'Plains High School', '1000 10 th St.', 'Plains', 'Texas', '79355', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 49.8397, 24.0297, 0, 'dwilkins', NULL, '2012-02-20', '2012-02-20 17:50:13'),
(578, NULL, NULL, NULL, 'Logan Municipal School District', '301 N. 2nd', 'Logan', 'New Mexico', '88426', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 48.6208, 22.2879, 0, 'Tammy Velasco', NULL, '2012-02-20', '2012-02-20 18:36:36'),
(579, NULL, NULL, NULL, 'Jurupa Hills High School', '10700 Oleander Avenue', 'Fontana', 'California', '92335', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 58.9909, 22.8359, 0, 'edmc06', NULL, '2012-02-20', '2012-02-20 18:43:18'),
(581, NULL, NULL, NULL, 'Bishop McGuinness Catholic High School', '801 NW 50th Street', 'Oklahoma City', 'Oklahoma', '73118', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 46.6354, 32.6169, 0, 'Coach Shawn Clark', NULL, '2012-02-20', '2012-02-20 19:27:40'),
(582, NULL, NULL, NULL, 'Stanton College Preparatory School ', '1149 West 13th Street', 'Jacksonville', 'Florida', '32209', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 49.2453, 27.3843, 0, 'RTiller2', NULL, '2012-02-20', '2012-02-20 19:29:14'),
(583, NULL, NULL, NULL, 'The Webb Schools of Ca.', '1175 Baseline RD', 'Claremont', 'California', '91711', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 34.1707, -117.702, 0, 'Ray Fenton', NULL, '2012-02-20', '2012-02-21 04:44:58'),
(585, NULL, NULL, NULL, 'Lindsay High School - Lindsay', '1849 E Tulare Rd', 'Lindsay', 'California', '93247', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 55.6773, 21.1483, 1, 'coachbob', NULL, '2012-02-20', '2012-02-21 15:25:14'),
(586, NULL, NULL, NULL, 'Montgomery High School', '22825 Highway 105 West', 'Montgomery', 'Texas', '77356', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 30.8808, 37.6706, 0, 'John Bolfing', NULL, '2012-02-21', '2012-02-21 15:21:28'),
(587, NULL, NULL, NULL, 'Elk City High School', '222 West Broadway', 'Elk City', 'Oklahoma', '73644', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 30.4579, 42.5313, 0, 'ElkCity22', NULL, '2012-02-21', '2012-02-21 15:41:40'),
(588, NULL, NULL, NULL, 'Westmoore High School', '12613 South Western', 'Oklahoma City', 'Oklahoma', '73170', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 59.5315, 16.128, 0, '', NULL, '2012-02-21', '2012-02-21 19:01:58'),
(589, NULL, NULL, NULL, 'Washakie County School District No.2', '242 Cedar Street', 'Ten Sleep', 'Wyoming', '82442', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 16.8013, 42.7589, 0, '', NULL, '2012-02-21', '2012-02-21 19:01:55'),
(590, NULL, NULL, NULL, 'Palmetto HS - Palmetto', '1200 17th Street West', 'Palmetto', 'Florida', '34221', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.3914, 50.1845, 1, NULL, NULL, NULL, '2012-02-21 16:28:34'),
(591, NULL, NULL, NULL, 'Smackover High School', '1 Buckaroo Ln\r\n', 'Smackover', 'Arkansas', '71762', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 33.3406, -92.7581, 0, '', NULL, '2012-02-21', '2012-02-21 19:01:52'),
(592, NULL, NULL, NULL, 'Sebring HS - Sebring', '3514 Kenilworth Blvd', 'Sebring', 'Florida', '33870', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 44.8968, -0.327783, 1, NULL, NULL, NULL, '2012-02-21 18:44:17'),
(602, NULL, NULL, NULL, 'Clifton J. Ozen', '3443 Fannett', 'Beaumont', 'Texas', '77705', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 48.8078, 24.541, 0, 'jnelso1', NULL, '2012-02-21', '2012-02-21 19:44:27'),
(594, NULL, NULL, NULL, 'Springstead HS - Spring Hill', '3300 Mariner Boulevard', 'Spring Hill', 'Florida', '34609', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.9776, 26.7148, 1, NULL, NULL, NULL, '2012-02-21 17:29:32'),
(595, NULL, NULL, NULL, 'Victory Christian - Lakeland', '1401 Griffin Rd', 'Lakeland', 'Florida', '33810', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 45.0081, -0.53541, 1, NULL, NULL, NULL, '2012-02-21 17:45:28'),
(596, NULL, NULL, NULL, 'Analy High School', '6950 Analy Ave.\r\n', 'Sebastopol', 'California', '95472', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 44.9521, 34.1024, 0, 'dbourdon', NULL, '2012-02-21', '2012-02-21 17:47:14'),
(597, NULL, NULL, NULL, 'Lakeland Sr HS - Lakeland', '726 Hollingsworth Road', 'Lakeland', 'Florida', '33801', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 49.7759, 13.6949, 0, NULL, 'Andre18', '2012-02-21', '2012-02-21 18:43:25'),
(598, NULL, NULL, NULL, 'Pine Ridge HS - Deltona', '926 Howland Blvd', 'Deltona', 'Florida', '32738', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 28.9075, -81.1748, 0, NULL, 'Dillanfontaine', '2012-02-21', '2012-02-21 18:46:19'),
(599, NULL, NULL, NULL, 'Tenoroc HS - Lakeland', '4905 Saddle Creek Rd.', 'Lakeland', 'Florida', '33801', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 49.7759, 13.6949, 0, 'CoachRobson', NULL, '2012-02-21', '2012-02-21 18:42:05'),
(603, NULL, NULL, NULL, 'Frostproof HS - Frostproof', '1000 North Palm Avenue', 'Frostproof', 'Florida', '33843', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.1884, -6.27975, 1, NULL, NULL, NULL, '2012-02-21 19:30:08'),
(604, NULL, NULL, NULL, 'Pitman High School', '225 Linden Ave.\r\n', 'Pitman', 'New Jersey', '08071', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, -23.4888, -46.4477, 0, 'skahoun', NULL, '2012-02-21', '2012-02-21 19:32:23'),
(605, NULL, NULL, NULL, 'Columbia HS - Lake City', '372 West Duval Street', 'Lake City', 'Florida', '32055', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 49.1074, 26.5082, 0, NULL, 'darius2020', '2012-02-21', '2012-02-21 20:42:42'),
(606, NULL, NULL, NULL, 'North Miami Sr HS - N. Miami', '13110 NE 8 AVENUE', 'North Miami', 'Florida', '33161', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.2599, -5.89343, 1, NULL, NULL, NULL, '2012-02-21 20:41:13'),
(608, NULL, NULL, NULL, 'Hartley-Melvin-Sanborn', '300 N. 8th Ave W.', 'Hartley', 'Iowa', '51346', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 54.9051, 23.9752, 0, 'HMS_Coach', NULL, '2012-02-21', '2012-02-22 01:15:33'),
(609, NULL, NULL, NULL, 'Cardinal Newman HS - W. Palm Beach', '512 Spencer Drive', 'West Palm Beach', 'Florida', '33409', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 0, 'bbeller', NULL, '2012-02-22', '2012-02-24 21:49:23'),
(610, NULL, NULL, NULL, 'Washington HS - Washington OK', '101 E. Kerby', 'Washington', 'Oklahoma', '73093', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 46.6354, 32.6169, 0, 'bbeller10', NULL, '2012-02-22', '2012-02-24 21:11:09'),
(611, NULL, NULL, NULL, 'San Antonio Can High School', '1807 Centennial Blvd.\r\n', 'San Antonio', 'Texas', '78211', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 48.5305, 25.0412, 0, 'aoharatexcan', NULL, '2012-02-22', '2012-02-22 15:55:51'),
(612, NULL, NULL, NULL, 'Eagle''s View Academy', '7788 Ramona Blvd', 'Jacksonville', 'Florida', '32221', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 49.2645, 27.6395, 0, 'evawarriors', NULL, '2012-02-22', '2012-02-22 16:46:40'),
(613, NULL, NULL, NULL, 'Jesuit High School', '1200 Jacob lane', 'Carmichael', 'California', '95608', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 48.4977, 18.0421, 0, 'carmazzid', NULL, '2012-02-22', '2012-02-22 17:15:43'),
(614, NULL, NULL, NULL, 'Mooreland High School', 'P.O. box 75', 'Mooreland', 'Oklahoma', '73852', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 30.0633, 41.8303, 0, 'bgregory20', NULL, '2012-02-22', '2012-02-23 02:30:40'),
(615, NULL, NULL, NULL, 'Marked Tree High School', '406 Sant Francis Street', 'Marked Tree ', 'Arkansas', '72365', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 46.8257, 35.4258, 0, 'barbara', NULL, '2012-02-23', '2012-02-23 16:58:50'),
(616, NULL, NULL, NULL, 'Shaker Heights', '15911 Aldersyde', 'Shaker Heights', 'Ohio', '44120', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 47.1561, -1.46315, 0, 'jarvisgibson', NULL, '2012-02-23', '2012-02-23 17:21:13'),
(617, NULL, NULL, NULL, 'Glades Central HS - Belle Glade', '1001 Southwest Ave E', 'Belle Glade', 'Florida', '33430', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 44.418, -0.205711, 1, NULL, NULL, NULL, '2012-02-24 21:52:10'),
(618, NULL, NULL, NULL, 'Palm Beach Central HS - Wellington', '8499 Forest Hill Boulevard', 'Wellington', 'Florida', '33411', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.4914, -5.97268, 0, NULL, 'Demetrius Anderson', '2012-02-23', '2012-02-24 21:06:31'),
(619, NULL, NULL, NULL, 'Palm Beach Lakes HS - W. Palm Beach', '3505 Shiloh Drive', 'West Palm Beach', 'Florida', '33407', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 0, NULL, 'fred taylor', '2012-02-23', '2012-02-24 21:02:17'),
(620, NULL, NULL, NULL, 'Francis Parker ', '6501 Linda Vista Road', 'San Diego', 'California', '92111', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 50.0526, 38.2935, 0, 'John Morrison', NULL, '2012-02-25', '2012-02-25 22:31:14'),
(621, NULL, NULL, NULL, 'Walsh Jesuit', '4550 Wyoga Lake Road', 'Cuyahoga Falls', 'Ohio', '44224', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 59.3769, 26.5955, 0, NULL, 'Lloyd_warrior', '2012-02-25', '2012-02-26 02:26:32'),
(622, NULL, NULL, NULL, 'Coral Glades HS - Coral Springs', '2700 Sportsplex Drive', 'Coral Springs', 'Florida', '33065', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 0, NULL, 'mazza0416', '2012-02-26', '2012-02-26 19:33:57'),
(623, NULL, NULL, NULL, 'Boyd Anderson HS - Lau. Lakes', '3050 Northwest 41st Street', 'Lauderdale Lakes', 'Florida', '33309', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 0, NULL, 'brutus', '2012-02-26', '2012-02-26 19:02:53'),
(624, NULL, NULL, NULL, 'McArthur HS - Hollywood', '6501 Hollywood Boulevard', 'Hollywood', 'Florida', '33024', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 46.4249, 12.5534, 0, NULL, 'Shad757', '2012-02-26', '2012-02-26 19:05:26'),
(625, NULL, NULL, NULL, 'Cardinal Gibbons HS - Ft. Lauderdale', '2900 NE 47th St', 'Ft. Lauderdale', 'Florida', '33334', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.0075, 49.4009, 0, NULL, 'Jdbrady2013', '2012-02-26', '2012-02-26 19:54:13'),
(626, NULL, NULL, NULL, 'West Broward HS - Pembroke Pines', '500 Northwest 209th Avenue', 'Pembroke Pines', 'Florida', '33029', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 46.4342, 12.9039, 0, NULL, 'Nathaniel Dionte Jones', '2012-02-26', '2012-02-26 19:49:48'),
(627, NULL, NULL, NULL, 'Premier Academy - Pompano Beach', '2301 West Sample Road', 'Pompano Beach', 'Florida', '33073', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 0, NULL, 'willie', '2012-02-26', '2012-02-26 19:55:35'),
(628, NULL, NULL, NULL, 'Archbishop McCarthy - SW Ranch', '5451 South Flamingo Rd', 'Southwest Ranches', 'Florida', '33330', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 57.168, 13.4069, 1, NULL, NULL, NULL, '2012-02-26 22:44:59'),
(629, NULL, NULL, NULL, 'Blanche Ely HS - Pompano Beach', '1201 NW 6th Ave', 'Pompano Beach', 'Florida', '33060', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 36.8022, 34.6276, 1, NULL, NULL, NULL, '2012-02-26 22:46:36'),
(630, NULL, NULL, NULL, 'Calvary Christian - Ft Laudrdl', '2401 Cypress Creek Rd', 'Ft Lauderdale', 'Florida', '33309', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 22:49:19'),
(631, NULL, NULL, NULL, 'Coconut Creek HS - Coconut Crk', '1400 NW 44th St', 'Coconut Creek', 'Florida', '33066', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 22:51:49'),
(632, NULL, NULL, NULL, 'Cooper City HS - Cooper City', '9401 Stirling Rd', 'Cooper City', 'Florida', '33328', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.4769, -5.23972, 1, NULL, NULL, NULL, '2012-02-26 22:53:13'),
(633, NULL, NULL, NULL, 'Coral Springs Charter School', '3205 North University Drive', 'Coral Springs', 'Florida', '33065', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 22:55:57'),
(634, NULL, NULL, NULL, 'Cypress Bay HS - Weston', '18600 Vista Park Blvd', 'Weston', 'Florida', '33332', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 51.8973, 8.39385, 1, NULL, NULL, NULL, '2012-02-26 22:58:39'),
(635, NULL, NULL, NULL, 'Deerfield Beach HS - FL', '910 SW 15th St', 'Deerfield Beach', 'Florida', '33441', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.9492, 49.0565, 1, NULL, NULL, NULL, '2012-02-26 23:00:37'),
(636, NULL, NULL, NULL, 'Dillard HS - Ft Lauderdale', '2501 NW 11th St.', 'Ft. Lauderdale', 'Florida', '33311', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.4707, -5.45026, 1, NULL, NULL, NULL, '2012-02-26 23:03:34'),
(637, NULL, NULL, NULL, 'Everglades HS - Miramar', '17100 SW 48th Court', 'Miramar', 'Florida', '33027', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 49.7243, 13.2732, 1, NULL, NULL, NULL, '2012-02-26 23:05:24'),
(638, NULL, NULL, NULL, 'Flanagan HS - Pembroke Pines', '12800 Taft St', 'Pembroke Pines', 'Florida', '33028', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 46.4201, 13.0263, 1, NULL, NULL, NULL, '2012-02-26 23:06:52'),
(639, NULL, NULL, NULL, 'Hallandale HS - Hallandale', '720 NW 9th Ave', 'Hallandale', 'Florida', '33009', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:11:25'),
(640, NULL, NULL, NULL, 'Highlands Christian HS - FL', '501 NE 48th St', 'Deerfield Beach', 'Florida', '33064', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:13:24'),
(641, NULL, NULL, NULL, 'Miramar HS - Miramar', '3601 SW 89th Ave', 'Miramar', 'Florida', '33025', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 46.4797, 12.8476, 1, NULL, NULL, NULL, '2012-02-26 23:16:11'),
(642, NULL, NULL, NULL, 'Zephyrhills HS - Zephyrhills', '6335 12th Street', 'Zephyrhills', 'Florida', '33542', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.8375, 48.8297, 1, NULL, NULL, NULL, '2012-02-26 23:55:04'),
(643, NULL, NULL, NULL, 'North Broward Prep - Coconut Creek', '7600 Lyons Rd', 'Coconut Creek', 'Florida', '33073', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:43:23'),
(644, NULL, NULL, NULL, 'Northeast HS - Oakland Park', '700 NE 56th St', 'Oakland Park', 'Florida', '33344', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.1926, 49.3552, 1, NULL, NULL, NULL, '2012-02-26 23:22:10'),
(645, NULL, NULL, NULL, 'Nova HS - Davie', '3600 College Ave', 'Davie', 'Florida', '33314', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:23:24'),
(646, NULL, NULL, NULL, 'Wekiva HS - Apopka', '2501 North Hiawassee Road', 'Apopka', 'Florida', '32703', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 42.2719, -7.69687, 1, NULL, NULL, NULL, '2012-02-27 00:06:02'),
(647, NULL, NULL, NULL, 'Plantation HS - Plantation', '6901 NW 16th St', 'Plantation', 'Florida', '33313', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.2509, 49.7013, 1, NULL, NULL, NULL, '2012-02-26 23:28:38'),
(648, NULL, NULL, NULL, 'Pompano Beach HS - FL', '600 NE 13th Ave', 'Pompano Beach', 'Florida', '33060', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 36.8022, 34.6276, 1, NULL, NULL, NULL, '2012-02-26 23:30:57'),
(649, NULL, NULL, NULL, 'South Broward HS - Hollywood', '1901 North Federal Highway', 'Hollywood', 'Florida', '33020', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 4.87892, 100.919, 1, NULL, NULL, NULL, '2012-02-26 23:32:48'),
(650, NULL, NULL, NULL, 'South Plantation HS - FL', '1300 SW 54th Ave', 'Plantation', 'Florida', '33317', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 43.5152, -5.52367, 1, NULL, NULL, NULL, '2012-02-26 23:33:59'),
(651, NULL, NULL, NULL, 'St Thomas Aquinas HS - FL', '2801 SW 12th St', 'Ft Lauderdale', 'Florida', '33312', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.1655, 49.6809, 1, NULL, NULL, NULL, '2012-02-26 23:35:37'),
(652, NULL, NULL, NULL, 'Stoneman Douglas HS - Parkland', '5901 Pine Island Road', 'Parkland', 'Florida', '33076', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 45.8144, 12.6796, 1, NULL, NULL, NULL, '2012-02-26 23:37:24'),
(653, NULL, NULL, NULL, 'Stranahan HS - Ft Lauderdale', '1800 SW 5th Place', 'Ft Lauderdale', 'Florida', '33312', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.1655, 49.6809, 1, NULL, NULL, NULL, '2012-02-26 23:40:12'),
(654, NULL, NULL, NULL, 'Taravella HS - Coral Springs', '10600 Riverside Drive', 'Coral Springs', 'Florida', '33071', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 50.6199, 26.2516, 1, NULL, NULL, NULL, '2012-02-26 23:41:43'),
(655, NULL, NULL, NULL, 'Western HS - Davie', '1200 SW 136th Ave', 'Davie', 'Florida', '33325', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 26.1361, 49.4771, 1, NULL, NULL, NULL, '2012-02-26 23:44:58'),
(656, NULL, NULL, NULL, 'Zion Lutheran HS - Drfld Beach', '959 SE 6th Ave', 'Deerfield Beach', 'Florida', '33442', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, '', 25.9191, 49.011, 1, NULL, NULL, NULL, '2012-02-26 23:47:14'),
(657, NULL, NULL, NULL, 'Coweta High School', 'PO Box 550', 'Coweta', 'Oklahoma', '74429', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 28.7445, 39.1752, 0, 'burch1159', NULL, '2012-02-27', '2012-02-27 18:10:51'),
(658, NULL, NULL, NULL, 'Baldwin High', '291 Mill St. West', 'Baldwin', 'Florida', '32234', NULL, NULL, NULL, 'ACTIVE', NULL, NULL, NULL, NULL, 49.203, 27.8077, 0, 'shields52', NULL, '2012-02-28', '2012-02-28 14:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_team_coach`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_team_coach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolid` int(10) DEFAULT NULL,
  `sportid` int(10) DEFAULT NULL,
  `coachnameid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_team_name`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_team_name` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(255) DEFAULT NULL,
  `fldAddress` text,
  `fldContactInfo` text,
  `fldStatus` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hs_aau_team_other`
--

CREATE TABLE IF NOT EXISTS `tbl_hs_aau_team_other` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldName` varchar(255) DEFAULT NULL,
  `fldCoachName` text,
  `fldCoachPhone` text,
  `fldUserID` varchar(255) NOT NULL,
  `fldStatus` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mail`
--

CREATE TABLE IF NOT EXISTS `tbl_mail` (
  `mail_id` int(80) NOT NULL AUTO_INCREMENT,
  `UserTo` varchar(50) NOT NULL DEFAULT '',
  `UserFrom` varchar(50) NOT NULL DEFAULT '',
  `Subject` varchar(150) NOT NULL DEFAULT '',
  `Message` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT '',
  `SentDate` date DEFAULT NULL,
  `visible` varchar(50) NOT NULL,
  `Usertypeto` varchar(55) NOT NULL,
  `Usertypefrom` varchar(55) NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Dumping data for table `tbl_mail`
--

INSERT INTO `tbl_mail` (`mail_id`, `UserTo`, `UserFrom`, `Subject`, `Message`, `status`, `SentDate`, `visible`, `Usertypeto`, `Usertypefrom`) VALUES
(135, 'barbara', 'san_jac', 'RE: Players', 'Hi Coach Wilburn\r\n\r\nI tried emailing you the other to return your message. I am not surge if you received it? Thanks for contacting us. This is Coach Dominick Lombardi, the CPN administrator, and you have contacted our demo football page. This page was only created as a demonstration for college and high school football coaches as we are in Florida traveling to various Football Recruiting fairs for under-recruited athletes.\r\n\r\nPlease have your athletes register through the basketball registration page. Once you verify your players we would love to have them build their profiles, load game film and help them before we open up to our college programs within the next few weeks. If you have any questions or issues signing up please do not hesitate to contact us using the contact link at the top of the page or me directly at dlombardi@collegeprospectnetwork.com\r\n\r\n---------------------------------------------------------------\r\nI have two OUTSTANDING Jr players on my squad. A 5''9 shooting guard that can shoot the 3 ball as well as put it on the floor and he''s very very quick! I have a another kid that''s 6''0 that plays out of position at the 5 but can play the 2 as well. He has AMAZING hoops! They both play AAU with the Warriors out of West Memphis, Ark.', 'unread', '2012-02-25', 'ACTIVE', 'coach', 'college'),
(130, 'teknickshs', 'san_jac', 'Hey Chris', 'Message from Profile Test', 'unread', '2012-02-20', 'ACTIVE', 'coach', 'college'),
(131, 'teknickshs', 'san_jac', 'Request for Additional Game Tape', 'This is Coach Jacob Harris from San Jacinto College, \r\n\r\nI would like to see some more game tape of Michael Kuczynski.  Please make copies of a couple of game tapes and mail them to:\r\n\r\n----------------------------------------------\r\nSan Jacinto College\r\nAttn: Coach Jacob Harris\r\n8060 Spencer Hwy.\r\nPasadena, Texas 77505\r\n----------------------------------------------\r\n\r\nThank you,\r\n\r\nCoach Jacob Harris\r\nSan Jacinto College', 'unread', '2012-02-20', 'ACTIVE', 'coach', 'college'),
(132, 'teknickshs', 'san_jac', 'Request for Additional Game Tape2', 'This is Coach Jacob Harris from San Jacinto College, \r\n\r\nI would like to see some more game tape of Michael Kuczynski.  Please make copies of a couple of game tapes and mail them to:\r\n\r\n----------------------------------------------\r\nSan Jacinto College\r\nAttn: Coach Jacob Harris\r\n8060 Spencer Hwy.\r\nPasadena, Texas 77505\r\n----------------------------------------------\r\n\r\nThank you,\r\n\r\nCoach Jacob Harris\r\nSan Jacinto College', 'unread', '2012-02-20', 'ACTIVE', 'coach', 'college'),
(133, 'teknickshs', 'san_jac', 'Request for Additional Game Tape', 'This is Coach Jacob Harris from San Jacinto College, \r\n\r\nI would like to see some more game tape of Michael Kuczynski.  Please make copies of a couple of game tapes and mail them to:\r\n\r\n----------------------------------------------\r\nSan Jacinto College\r\nAttn: Coach Jacob Harris\r\n8060 Spencer Hwy.\r\nPasadena, Texas 77505\r\n----------------------------------------------\r\n\r\nThank you,\r\n\r\nCoach Jacob Harris\r\nSan Jacinto College', 'read', '2012-02-20', 'ACTIVE', 'coach', 'college'),
(134, 'san_jac', 'barbara', 'Players', 'I have two OUTSTANDING Jr players on my squad. A 5''9 shooting guard that can shoot the 3 ball as well as put it on the floor and he''s very very quick! I have a another kid that''s 6''0 that plays out of position at the 5 but can play the 2 as well. He has AMAZING hoops! They both play AAU with the Warriors out of West Memphis, Ark.', 'read', '2012-02-23', 'ACTIVE', 'college', 'coach'),
(129, 'teknickshs', 'teknicksmike', 'RE: RE: Subject Changed', '33\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'read', '2012-02-20', 'ACTIVE', 'coach', 'athlete'),
(122, 'teknickshs', 'teknicksmike', 'Subject', 'Message', 'read', '2012-02-19', 'ACTIVE', 'coach', 'athlete'),
(123, 'teknicksmike', 'teknickshs', 'RE: Subject', 'reply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'read', '2012-02-19', 'ACTIVE', 'athlete', 'coach'),
(124, 'teknickshs', 'teknicksmike', 'RE: RE: Subject', 'reply3\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'read', '2012-02-19', 'ACTIVE', 'coach', 'athlete'),
(125, 'teknicksmike', 'teknickshs', 'RE: RE: RE: Subject', '\r\n\r\n---------------------------------------------------------------\r\nreply3\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'unread', '2012-02-20', 'ACTIVE', 'athlete', 'coach'),
(126, 'teknicksmike', 'teknickshs', 'RE: RE: RE: Subject', '\r\n\r\n---------------------------------------------------------------\r\nreply3\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'unread', '2012-02-20', 'ACTIVE', 'athlete', 'coach'),
(127, 'teknicksmike', 'teknickshs', 'RE: RE: RE: Subject', '\r\n\r\n---------------------------------------------------------------\r\nreply3\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'unread', '2012-02-20', 'ACTIVE', 'athlete', 'coach'),
(128, 'teknicksmike', 'teknickshs', 'RE: RE: RE: Subject', 'ESPN has fired the employee responsible for writing an offensive headline about basketball sensation Jeremy Lin and suspended an anchor who used the same ethnic slur, the sports network said Sunday.\r\n\r\n\r\nESPN has fired the employee responsible for writing an offensive headline about basketball sensation Jeremy Lin and suspended an anchor who used the same ethnic slur, the sports network said Sunday.\r\n\r\n---------------------------------------------------------------\r\nreply3\r\n\r\n---------------------------------------------------------------\r\nreply\r\n\r\n---------------------------------------------------------------\r\nMessage', 'read', '2012-02-20', 'ACTIVE', 'athlete', 'coach'),
(136, 'barbara', 'san_jac', 'RE: Players', 'Thank you for the interest and we look forward to working with you and your players finding a good fit.\r\n\r\nSincerely,\r\n\r\nDominick Lombardi\r\n\r\n---------------------------------------------------------------\r\nI have two OUTSTANDING Jr players on my squad. A 5''9 shooting guard that can shoot the 3 ball as well as put it on the floor and he''s very very quick! I have a another kid that''s 6''0 that plays out of position at the 5 but can play the 2 as well. He has AMAZING hoops! They both play AAU with the Warriors out of West Memphis, Ark.', 'unread', '2012-02-25', 'ACTIVE', 'coach', 'college');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_needtype`
--

CREATE TABLE IF NOT EXISTS `tbl_needtype` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldDivision` varchar(255) DEFAULT NULL,
  `fldClass` varchar(255) DEFAULT NULL,
  `fldMaxHeight` varchar(255) DEFAULT NULL,
  `fldMinHeight` varchar(255) DEFAULT NULL,
  `fldMinWeight` varchar(255) NOT NULL,
  `fldMaxWeight` varchar(255) NOT NULL,
  `fldPosition` varchar(255) NOT NULL,
  `fldSchool` varchar(255) DEFAULT NULL,
  `fldCity` varchar(255) DEFAULT NULL,
  `fldState` varchar(255) DEFAULT NULL,
  `fldZipCode` varchar(255) DEFAULT NULL,
  `fldDistance` varchar(255) DEFAULT NULL,
  `fldCollegeCoachId` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tbl_needtype`
--

INSERT INTO `tbl_needtype` (`fldId`, `fldDivision`, `fldClass`, `fldMaxHeight`, `fldMinHeight`, `fldMinWeight`, `fldMaxWeight`, `fldPosition`, `fldSchool`, `fldCity`, `fldState`, `fldZipCode`, `fldDistance`, `fldCollegeCoachId`) VALUES
(32, 'DivisionII', '2014', '', '6-4', '', '', 'Small Forward', '0', '', 'Texas', '', 'select', '74');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_network`
--

CREATE TABLE IF NOT EXISTS `tbl_network` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldSenderid` varchar(255) DEFAULT NULL,
  `fldSenderType` varchar(255) DEFAULT NULL,
  `fldReceiverid` varchar(255) DEFAULT NULL,
  `fldReceiverType` varchar(50) DEFAULT NULL,
  `fldStatus` varchar(255) DEFAULT NULL,
  `fldDateModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_network`
--

INSERT INTO `tbl_network` (`fldId`, `fldSenderid`, `fldSenderType`, `fldReceiverid`, `fldReceiverType`, `fldStatus`, `fldDateModified`) VALUES
(42, '86', 'athlete', '52', 'coach', 'Active', '2012-02-20 14:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_network_message`
--

CREATE TABLE IF NOT EXISTS `tbl_network_message` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldAthletid` varchar(50) NOT NULL,
  `fldCollegeid` varchar(50) DEFAULT NULL,
  `fldCollegename` varchar(255) DEFAULT NULL,
  `fldMessage` varchar(50) DEFAULT NULL,
  `fldStatus` varchar(16) DEFAULT '0',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_opp_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_opp_comments` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldathleteid` int(11) DEFAULT NULL,
  `fldcoachid` int(11) DEFAULT NULL,
  `fldOppComments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_other`
--

CREATE TABLE IF NOT EXISTS `tbl_other` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT COMMENT '21',
  `fldName` varchar(255) DEFAULT NULL,
  `fldAddress` text,
  `fldContactInfo` text,
  `fldUserId` varchar(255) DEFAULT NULL,
  `fldStatus` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page`
--

CREATE TABLE IF NOT EXISTS `tbl_page` (
  `fldPageId` int(11) NOT NULL AUTO_INCREMENT,
  `fldPageTitle` varchar(500) COLLATE latin1_general_cs DEFAULT NULL,
  `fldPageDescraption` text COLLATE latin1_general_cs,
  `fldPageMetaTitle` varchar(500) COLLATE latin1_general_cs DEFAULT NULL,
  `fldPageMetaDescraption` text COLLATE latin1_general_cs,
  `fldPageMetaKeyword` text COLLATE latin1_general_cs,
  `fldPageAddedDate` datetime DEFAULT NULL,
  `fldPageStatus` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`fldPageId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs AUTO_INCREMENT=18 ;

--
-- Dumping data for table `tbl_page`
--

INSERT INTO `tbl_page` (`fldPageId`, `fldPageTitle`, `fldPageDescraption`, `fldPageMetaTitle`, `fldPageMetaDescraption`, `fldPageMetaKeyword`, `fldPageAddedDate`, `fldPageStatus`) VALUES
(4, 'term_conditions', '<h1>Terms and Conditions</h1>\r\n<p>Welcome to CollegeProspectNetwork.com! If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern College Prospect Network&rsquo;s relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>\r\n<p>The term &lsquo;College Prospect Network&rsquo; or &ldquo;CPN&rdquo; or &lsquo;us&rsquo; or &lsquo;we&rsquo; refers to the owner of the website whose registered office is in Houston, Texas. Our company registration number is available upon request. The term &lsquo;you&rsquo; refers to the user or viewer of our website.</p>\r\n<p>The use of this website is subject to the following terms of use:</p>\r\n<ul>\r\n<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>\r\n<li>This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties: recurring billing, login information, profile management and network interactions. </li>\r\n<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>\r\n<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>\r\n<li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>\r\n<li>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.</li>\r\n<li>Unauthorised use of this website may give rise to a claim for damages and/or be a criminal offence.</li>\r\n<li>From time to time, this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>\r\n<li>Your use of this website and any dispute arising out of such use of the website is subject to the laws of the United States of America and Canada.</li>\r\n</ul>', 'College Prospect Network - Terms and Conditions | CPN', 'CollegeProspectNetwork.com Terms and Conditions', 'CollegeProspectNetwork.com Terms and Conditions Document', '2014-12-01 00:00:00', 1),
(5, 'about', '<h1>About Us</h1>\r\n<h2>Our Mission</h2>\r\n<p>College Prospect Network (CPN) was born out of a desire to make it easier for deserving student-athletes all over the country play sports in college. College recruiting budgets are getting tighter and travel is getting more expensive, which is hurting the athletic programs and the athletes who deserve an opportunity.</p>\r\n<p>We believe that hundreds of high school athletes miss out on an opportunity to continue their athletic careers every year because of a lack of exposure. Whether they have the talent and desire to play at a big-time university or could be a quality contributor at a smaller school, our website is designed specifically to make it easy for college programs to find the student-athletes who fit their needs.</p>\r\n<h2>What Makes Us Different</h2>\r\n<p>Most importantly, our site is 100 percent free for the student-athletes and their coaches. There are other sites out there similar to CPN but you will find that they either charge a fee at some point during the process or they allow anyone with an internet connection to join the site. We don&rsquo;t do either because we truly are here to help the high school athletes find the right fit. We want to reward the players who earn the attention, not the ones who can afford to pay a monthly fee in order to have their name promoted.</p>\r\n<p>All of the athletes on our site are thoroughly screened prior to being approved so college coaches and scouts know they are seeing legitimate prospects. (If you would like more information on the screening process, please use the Contact Us page to inquire. You&rsquo;ll understand why that information is not posted here when we explain the process.)</p>\r\n<h2>How to Get Started</h2>\r\n<p>If you&rsquo;re a college coach or employee, we would like you to take a moment to join our free five-day trial. You will have limited access to all of the high school athlete profiles in our database according to your sport. There is no credit card required and no catch. After five days, if you like what you see, you can sign up for a monthly subscription which will grant you full access to the site, which includes:</p>\r\n<ul>\r\n<li>Direct messaging to any athlete, their coaches and other college programs who are registered on the site. </li>\r\n<li>The ability to search our database by criteria as general or as narrow as you like. </li>\r\n<li>The ability to post your &ldquo;Needs&rdquo; and have student-athletes who fit the need find you.</li>\r\n<li>An opportunity to promote your school. </li>\r\n</ul>\r\n<p>High School and AAU Coaches can join simply by creating a profile with some general information about yourself. The CPN staff will simply need to verify your identity and you can start inviting athletes to apply to the site.</p>\r\n<p>Athletes have to apply and pass the confidential screening process in order to be approved. We follow the NCAA recruiting calendar for all athletes so we ask that you don&rsquo;t apply unless you are on your high school team or a comparable AAU team. Also, in concordance with NCAA regulations, you have to wait until June following your sophomore year to apply. Any athletes not meeting these requirements will be disqualified before the screening process begins. Once you are approved, all you have to do is be honest in everything you post on the site and get to work looking for the college program that fits you best.</p>', 'College Prospect Network - About Us | CPN', 'College Prospect Network (CPN) was born out of a desire to make it easier for deserving student-athletes all over the country play sports in college. College recruiting budgets are getting tighter and travel is getting more expensive, which is hurting the athletic programs and the athletes who deserve an opportunity.', 'College Prospect Network, CPN, Athlete Scouting, College Scouting, Scouting tools', '2014-12-01 00:00:00', 1),
(6, 'privacy_policy', '<h1>Privacy Policy</h1>\r\n<!-- START PRIVACY POLICY CODE -->\r\n<div style=&#34;font-family:arial&#34;><strong>What information do we collect?</strong> <br /><br />We collect information from you when you register on our site, place an order, subscribe to our newsletter or fill out a form.  <br /><br />When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address, mailing address, phone number or credit card information. You may, however, visit our site anonymously.<br /><br />Google, as a third party vendor, uses cookies to serve ads on your site. Google&#39;s use of the DART cookie enables it to serve ads to your users based on their visit to your sites and other sites on the Internet. Users may opt out of the use of the DART cookie by visiting the Google ad and content network privacy policy..<br /><br /><strong>What do we use your information for?</strong> <br /><br />Any of the information we collect from you may be used in one of the following ways: <br /><br />; To improve customer service<br />(your information helps us to more effectively respond to your customer service requests and support needs)<br /><br />; To process transactions<br />\r\n<blockquote>Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</blockquote>\r\n<br />; To send periodic emails<br />\r\n<blockquote>The email address you provide for order processing, will only be used  to send you information and updates pertaining to your order.</blockquote>\r\n<br /><br /><strong>How do we protect your information?</strong> <br /><br />We implement a variety of security measures to maintain the safety of your personal information when you place an order<br /> <br />We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to?keep the information confidential.<br /><br />After a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be kept on file for more than 60 days.<br /><br /><strong>Do we use cookies?</strong> <br /><br />Yes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.<br /><br /><strong>Do we disclose any information to outside parties?</strong> <br /><br />We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.<br /><br /><strong>Third party links</strong> <br /><br /> Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.<br /><br /><strong>California Online Privacy Protection Act Compliance</strong><br /><br />Because we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent.<br /><br />As part of the California Online Privacy Protection Act, all users of our site may make any changes to their information at anytime by logging into their control panel and going to the &#39;Edit Profile&#39; page.<br /><br /><strong>Childrens Online Privacy Protection Act Compliance</strong> <br /><br />We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.<br /><br /><strong>Online Privacy Policy Only</strong> <br /><br />This online privacy policy applies only to information collected through our website and not to information collected offline.<br /><br /><strong>Terms and Conditions</strong> <br /><br />Please also visit our Terms and Conditions section establishing the use, disclaimers, and limitations of liability governing the use of our website at <a href=&#34;http://www.collegeprospectnetwork.com&#34;>http://www.collegeprospectnetwork.com</a><br /><br /><strong>Your Consent</strong> <br /><br />By using our site, you consent to our <a style=&#34;text-decoration:none; color:#3C3C3C;&#34; href=&#34;http://www.freeprivacypolicy.com/&#34; target=&#34;_blank&#34;>websites privacy policy</a>.<br /><br /><strong>Changes to our Privacy Policy</strong> <br /><br />If we decide to change our privacy policy, we will post those changes on this page, send an email notifying you of any changes, and/or update the Privacy Policy modification date below. <br /><br />This policy was last modified on 1/12/2012<br /><br /><strong>Contacting Us</strong> <br /><br />If there are any questions regarding this privacy policy you may contact us using the information below. <br /><br />www.CollegeProspectNetwork.com<br />Houston, Texas 77089<br />USA<br />contact@collegeprospectnetwork.com<br /><br /><!-- END PRIVACY POLICY CODE --></div>', 'College Prospect Network - Privacy Policy | CPN', 'CollegeProspectNetwork.com Privacy Policy', 'CollegeProspectNetwork.com Privacy Policy Document', '2014-12-01 00:00:00', 1),
(7, 'contactus', '<h1>Contact Us</h1>\r\n<p>Thanks for your contacting (CPN) College Prospect Network. At CPN we&#39;re committed to our members and value your feedback.</p>\r\n<p><strong>Please fill out the form below and one of our team members will get back to you as soon as possible.</strong></p>', 'College Prospect Network - Contact Us | CPN', 'Please fill out our Contact Form and one of our team members will get back to you as soon as possible.', 'Contact College Prospect Network, Contact CPN, Athlete Scouting, College Scouting, Scouting tools', '2014-12-01 00:00:00', 1),
(11, 'test', '<p>test</p>', '', '', '', '2011-11-11 00:00:00', 1),
(17, 'refund_policy', '<h1>Refund Policy</h1>\r\n<ul>\r\n<li> No refunds for monthly subscription. If subscription is canceled after the payment is debited for the upcoming month, subscription will remain valid until the end of the paid period. </li>\r\n<li> No refunds for yearly and three-year subscriptions if subscription is canceled after half of the duration of the contract has passed. If subscription is canceled prior to half of the duration of the contract, refunds will be handled on a case-by-case basis and based upon the regular subscription price of $14.99. </li>\r\n</ul>', 'College Prospect Network - Ref', 'CollegeProspectNetwork.com Refund Policy', 'CollegeProspectNetwork.com Refund Policy', '2019-12-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position_basketball`
--

CREATE TABLE IF NOT EXISTS `tbl_position_basketball` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Position` varchar(50) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT '100',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_position_basketball`
--

INSERT INTO `tbl_position_basketball` (`ID`, `Position`, `SortOrder`) VALUES
(1, 'Point Guard', 10),
(2, 'Shooting Guard', 20),
(3, 'Small Forward', 30),
(4, 'Power Forward', 40),
(5, 'Center', 50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position_football`
--

CREATE TABLE IF NOT EXISTS `tbl_position_football` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Position` varchar(50) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT '100',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_position_football`
--

INSERT INTO `tbl_position_football` (`ID`, `Position`, `SortOrder`) VALUES
(1, 'Center (C)', 10),
(2, 'Offensive Guard (G)', 20),
(3, 'Offensive Tackle (T)', 30),
(4, 'Quarterback (QB)', 40),
(5, 'Running Back (RB)', 50),
(6, 'Wide Receiver (WR)', 60),
(7, 'Tight End (TE)', 70),
(8, 'Defensive Tackle (DT)', 80),
(9, 'Defensive End (DE)', 90),
(10, 'Middle Linebacker (MLB)', 100),
(11, 'Outside linebacker (OLB)', 110),
(12, 'Cornerback (CB)', 120),
(13, 'Safety (S)', 130),
(16, 'Kicker (K)', 160),
(19, 'Punter (P)', 190),
(20, 'Punt returner (PR)', 200),
(21, 'Kick returner (KR)', 210),
(24, 'Fullback (FB)', 55),
(25, 'Athlete (ATH)', 300);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rating`
--

CREATE TABLE IF NOT EXISTS `tbl_rating` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldAthlete_id` int(11) DEFAULT NULL,
  `fldCoach_id` int(11) DEFAULT NULL,
  `fldLeaderShip` tinyint(3) DEFAULT NULL,
  `fldWork_Ethic` tinyint(3) DEFAULT NULL,
  `fldPrimacy_Go_To_Guy` tinyint(3) DEFAULT NULL,
  `fldMental_Toughness` tinyint(3) DEFAULT NULL,
  `fldComposure` tinyint(3) DEFAULT NULL,
  `fldAwareness` tinyint(3) DEFAULT NULL,
  `fldInstincts` tinyint(3) DEFAULT NULL,
  `fldVision` tinyint(3) DEFAULT NULL,
  `fldConditioning` tinyint(3) DEFAULT NULL,
  `fldPhysical_Toughness` tinyint(3) DEFAULT NULL,
  `fldTenacity` tinyint(3) DEFAULT NULL,
  `fldHustle` tinyint(3) DEFAULT NULL,
  `fldStrength` tinyint(3) DEFAULT NULL,
  `fldStatus` tinyint(3) DEFAULT '1',
  `fldAddDate` date DEFAULT NULL,
  `fldmodifiedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbl_rating`
--

INSERT INTO `tbl_rating` (`fldId`, `fldAthlete_id`, `fldCoach_id`, `fldLeaderShip`, `fldWork_Ethic`, `fldPrimacy_Go_To_Guy`, `fldMental_Toughness`, `fldComposure`, `fldAwareness`, `fldInstincts`, `fldVision`, `fldConditioning`, `fldPhysical_Toughness`, `fldTenacity`, `fldHustle`, `fldStrength`, `fldStatus`, `fldAddDate`, `fldmodifiedDate`) VALUES
(26, 86, 52, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 1, '2012-02-20', '2012-02-20 08:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sportcalender`
--

CREATE TABLE IF NOT EXISTS `tbl_sportcalender` (
  `fldId` int(11) NOT NULL AUTO_INCREMENT,
  `fldTitle` varchar(255) NOT NULL,
  `fldTeam` varchar(255) DEFAULT NULL,
  `fldDate` date DEFAULT '0000-00-00',
  `fldLocation` varchar(255) DEFAULT NULL,
  `fldTime` text,
  `fldSchool` varchar(255) DEFAULT NULL,
  `fldSport` varchar(255) DEFAULT NULL,
  `fldStatus` tinyint(3) DEFAULT '1',
  PRIMARY KEY (`fldId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structu