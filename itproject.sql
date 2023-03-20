-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2023 at 06:14 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `profileImg`
--

CREATE TABLE `profileImg` (
  `profileImgId` int(11) NOT NULL,
  `profileImgUserid` int(11) NOT NULL,
  `profileImgFilename` varchar(256) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profileImg`
--

INSERT INTO `profileImg` (`profileImgId`, `profileImgUserid`, `profileImgFilename`, `status`) VALUES
(1, 1, 'user1.jpg', 0),
(2, 2, '', 1),
(3, 3, 'user3.jpg', 0),
(4, 4, '', 1),
(7, 7, 'user7.jpg', 0),
(9, 9, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sensorData`
--

CREATE TABLE `sensorData` (
  `sensorDataId` int(2) NOT NULL,
  `sensorDataDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `sensorDataTemp` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sensorData`
--

INSERT INTO `sensorData` (`sensorDataId`, `sensorDataDate`, `sensorDataTemp`) VALUES
(1, '2023-01-04 20:42:54', 22),
(2, '2023-01-04 20:43:04', 22.1),
(3, '2023-01-19 18:27:03', 21.8),
(4, '2023-01-19 18:27:13', 21.8),
(5, '2023-01-19 18:27:23', 21.8),
(6, '2023-01-19 18:29:29', 22.1),
(7, '2023-01-19 18:29:39', 22.1),
(8, '2023-01-19 18:29:49', 22.1),
(9, '2023-01-19 18:29:59', 22.2),
(10, '2023-01-19 18:30:09', 22.1),
(11, '2023-01-19 18:30:19', 22.1),
(12, '2023-01-19 18:30:29', 22.1),
(13, '2023-01-19 18:30:39', 22.1),
(14, '2023-01-19 18:30:49', 22.1),
(15, '2023-01-19 18:30:59', 22.2),
(16, '2023-01-19 18:31:09', 22.2),
(17, '2023-01-19 18:31:19', 22.2),
(18, '2023-01-19 18:31:29', 22.2),
(19, '2023-01-19 18:31:39', 22.2),
(20, '2023-01-19 18:31:49', 22.2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`) VALUES
(1, 'Jan Kowalski', 'jan@kowalski.pl', 'janek', '$2y$10$58DjfXSDfabQdsVOO4zodOOYgcKOXmSLCirCGpwk7/T6lfhHXW7By'),
(2, 'Wiesław Moczygęba', 'pije@monopolowy.pl', 'wiesio', '$2y$10$RWnZ/WcgsKT4bb7UFkb7EeuF.bhgrc1UlotYjVvDP13avh8HLhwvW'),
(3, 'jan jan', 'jan@jan.pl', 'jan', '$2y$10$WDvBXvq373uToAtAnTeCEumvEt26/n2UCI57Splfg4rT1gzeNMALe'),
(4, 'Stanisław Dobry', 'mail@maikl.com', 'stasiu', '$2y$10$dnbH7K.crvbpWU2EUdfYTOLBKDjtKmZKzb7dKONvBTi7JNKYo/hii'),
(7, 'stasiu s', 'mail@mail.com', 'sstas', '$2y$10$lAvQlNr7OWLI9gratoF4LefyrAf8aWSW3WSPKVzP8e5aWatBdW08C'),
(9, 'john', 'jonh@mail.com', 'john', '$2y$10$DNYpxHekOx25KzDgYd0yC.1Q3esIfp3MFAAfslrrTWJv77yxCCqM6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profileImg`
--
ALTER TABLE `profileImg`
  ADD PRIMARY KEY (`profileImgId`);

--
-- Indexes for table `sensorData`
--
ALTER TABLE `sensorData`
  ADD PRIMARY KEY (`sensorDataId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profileImg`
--
ALTER TABLE `profileImg`
  MODIFY `profileImgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sensorData`
--
ALTER TABLE `sensorData`
  MODIFY `sensorDataId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
