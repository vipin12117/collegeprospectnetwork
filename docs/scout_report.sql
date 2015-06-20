-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2015 at 04:26 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collegework`
--

-- --------------------------------------------------------

--
-- Table structure for table `scout_report`
--

CREATE TABLE IF NOT EXISTS `scout_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `primary_position` varchar(255) NOT NULL,
  `secondary_position` varchar(255) NOT NULL,
  `high_school` varchar(255) NOT NULL,
  `primary_aau_team` varchar(255) NOT NULL,
  `secondary_aau_team` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `reach` varchar(255) NOT NULL,
  `wingspan_id` int(11) NOT NULL,
  `lane_agility` varchar(255) NOT NULL,
  `60_seconds_of_threes` varchar(255) NOT NULL,
  `strengths` varchar(255) NOT NULL,
  `weakness` varchar(255) NOT NULL,
  `ncca_elite_high_major_score` varchar(255) NOT NULL,
  `ncca_high_major_score` varchar(255) NOT NULL,
  `ncca_mid_major_score` varchar(255) NOT NULL,
  `ncca_low_major_score` varchar(255) NOT NULL,
  `ncca_division_II_score` varchar(255) NOT NULL,
  `ncca_division_III_score` varchar(255) NOT NULL,
  `junior_college _division_I_score` varchar(255) NOT NULL,
  `junior_college _division_II_score` varchar(255) NOT NULL,
  `junior_college _division_III_score` varchar(255) NOT NULL,
  `naia_division_I_score` varchar(255) NOT NULL,
  `naia_division_II_score` varchar(255) NOT NULL,
  `naia_division_III_score` varchar(255) NOT NULL,
  `nccaa_score` varchar(255) NOT NULL,
  `club_level_score` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `father_firstname` varchar(255) NOT NULL,
  `father_lastname` varchar(255) NOT NULL,
  `father_phone` varchar(255) NOT NULL,
  `mother_firstname` varchar(255) NOT NULL,
  `mother_lastname` varchar(255) NOT NULL,
  `mother_phone` varchar(255) NOT NULL,
  `jersey_number` varchar(255) NOT NULL,
  `best_game` varchar(255) NOT NULL,
  `other_game` varchar(255) NOT NULL,
  `gpa` varchar(255) NOT NULL,
  `sat_score` varchar(255) NOT NULL,
  `act_score` varchar(255) NOT NULL,
  `high_school_coach_name` varchar(255) NOT NULL,
  `high_school_coach_phone` varchar(255) NOT NULL,
  `high_school_coach_email` varchar(255) NOT NULL,
  `primary_aau_coach_name` varchar(255) NOT NULL,
  `primary_aau_coach_phone` varchar(255) NOT NULL,
  `primary_aau_coach_email` varchar(255) NOT NULL,
  `secondary_aau_coach_name` varchar(255) NOT NULL,
  `secondary_aau_coach_phone` varchar(255) NOT NULL,
  `secondary_aau_coach_email` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `colleges_shown_interest` varchar(255) NOT NULL,
  `colleges_offered_scholarship` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `scout_report`
--

INSERT INTO `scout_report` (`id`, `picture`, `firstname`, `lastname`, `class`, `primary_position`, `secondary_position`, `high_school`, `primary_aau_team`, `secondary_aau_team`, `description`, `height`, `weight`, `reach`, `wingspan_id`, `lane_agility`, `60_seconds_of_threes`, `strengths`, `weakness`, `ncca_elite_high_major_score`, `ncca_high_major_score`, `ncca_mid_major_score`, `ncca_low_major_score`, `ncca_division_II_score`, `ncca_division_III_score`, `junior_college _division_I_score`, `junior_college _division_II_score`, `junior_college _division_III_score`, `naia_division_I_score`, `naia_division_II_score`, `naia_division_III_score`, `nccaa_score`, `club_level_score`, `street_address`, `city`, `state`, `zip_code`, `phone_number`, `father_firstname`, `father_lastname`, `father_phone`, `mother_firstname`, `mother_lastname`, `mother_phone`, `jersey_number`, `best_game`, `other_game`, `gpa`, `sat_score`, `act_score`, `high_school_coach_name`, `high_school_coach_phone`, `high_school_coach_email`, `primary_aau_coach_name`, `primary_aau_coach_phone`, `primary_aau_coach_email`, `secondary_aau_coach_name`, `secondary_aau_coach_phone`, `secondary_aau_coach_email`, `twitter`, `facebook`, `email`, `colleges_shown_interest`, `colleges_offered_scholarship`) VALUES
(2, '', 'parm', 'sharma', '2015', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
