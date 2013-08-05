-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2013 at 01:40 PM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dodge`
--

-- --------------------------------------------------------

--
-- Table structure for table `code_number`
--

CREATE TABLE IF NOT EXISTS `code_number` (
  `id` int(11) NOT NULL DEFAULT '1',
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code_number`
--

INSERT INTO `code_number` (`id`, `number`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `code_submissions`
--

CREATE TABLE IF NOT EXISTS `code_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `sub_time` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `question` text NOT NULL,
  `code_num` int(11) NOT NULL,
  `result` enum('runtime error','accepted','compilation error','wrong answer') NOT NULL,
  `language` enum('C','C++') NOT NULL DEFAULT 'C',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=226 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `name` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `difficulty` enum('A','B','C') NOT NULL DEFAULT 'A',
  `statement` text NOT NULL,
  `test cases` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`name`, `id`, `difficulty`, `statement`, `test cases`) VALUES
('Bhaag Milkha Bhaag', 44, 'B', '', 13),
('square', 45, 'A', '', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `college` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `passwd`, `email`, `college`) VALUES
(1, 'vinit', 'v', 'vinit', 'daiict'),
(17, 'admin', 'don', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
