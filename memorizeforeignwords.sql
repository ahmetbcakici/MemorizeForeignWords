-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2019 at 04:54 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memorizeforeignwords`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_words`
--

CREATE TABLE `active_words` (
  `id` int(11) NOT NULL,
  `wordinnative` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `wordinforeign` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `active_words`
--

INSERT INTO `active_words` (`id`, `wordinnative`, `wordinforeign`) VALUES
(83, 'yükselmek', 'rise'),
(84, 'değmek', 'worth');

-- --------------------------------------------------------

--
-- Table structure for table `all_words`
--

CREATE TABLE `all_words` (
  `id` int(11) NOT NULL,
  `wordinnative` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `wordinforeign` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repeating`
--

CREATE TABLE `repeating` (
  `id` int(11) NOT NULL,
  `operation` tinyint(1) NOT NULL,
  `counter` tinyint(4) NOT NULL,
  `word_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_words`
--
ALTER TABLE `active_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_words`
--
ALTER TABLE `all_words`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repeating`
--
ALTER TABLE `repeating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `word_id` (`word_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_words`
--
ALTER TABLE `active_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `all_words`
--
ALTER TABLE `all_words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `repeating`
--
ALTER TABLE `repeating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `repeating`
--
ALTER TABLE `repeating`
  ADD CONSTRAINT `repeating_ibfk_1` FOREIGN KEY (`word_id`) REFERENCES `active_words` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
