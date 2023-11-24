-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 06:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keptdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `username` varchar(31) NOT NULL,
  `email` varchar(127) DEFAULT NULL,
  `password` varchar(63) DEFAULT NULL,
  `name` varchar(127) DEFAULT NULL,
  `nickname` varchar(31) DEFAULT NULL,
  `new` tinyint(1) DEFAULT NULL,
  `premium` tinyint(1) DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'icon.png',
  `needs` int(11) DEFAULT NULL,
  `wants` int(11) DEFAULT NULL,
  `saving` int(11) DEFAULT NULL,
  `changed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `date`, `username`, `email`, `password`, `name`, `nickname`, `new`, `premium`, `online`, `bio`, `picture`, `needs`, `wants`, `saving`, `changed`) VALUES
(1, '2023-10-18', 'arrowonskin', 'iqbalalwi32@gmail.com', '$2y$10$ijBCFhR3b8GHLT77xgPcO.3FZGUsNLcni6J32h1VfDJ.Q7sESM7Vi', 'Iqbal Alwi', 'Bal', 0, 0, 0, 'Ngasal', '652f9340439c8.jpg', 70, 20, 10, 0),
(2, '2023-10-25', 'test iqabl', 'ibalalwi6@gmail.com', '$2y$10$SEBabQd8mCQJSJkDkmxVkOhYUGb/.1knUyMMcIHmrMeDkH0GxptSS', 'Test Iqbal', 'test', 0, 0, 0, NULL, 'icon.png', 50, 30, 20, 0),
(5, '2023-10-26', 'andreasmlbngaol', 'lgandre45@gmail.com', '$2y$10$hHY3yoCxNNz/D2Iq6HdBueMToB4.zNHbM567U2U1wTOTyA/Z32YHi', 'Andreas M Lbn Gaol', 'Dre', 0, 0, 0, NULL, 'icon.png', 70, 20, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flow`
--

CREATE TABLE `flow` (
  `id` int(11) NOT NULL,
  `class` varchar(31) DEFAULT NULL,
  `category` varchar(31) DEFAULT NULL,
  `username` varchar(31) NOT NULL,
  `name` varchar(63) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flow`
--

INSERT INTO `flow` (`id`, `class`, `category`, `username`, `name`) VALUES
(1, 'income', 'routine', 'routine', 'Pendapatan Rutin'),
(2, 'income', 'additional', 'additional', 'Pendapatan Tambahan'),
(3, 'spending', 'needs', 'transportation', 'Transportasi'),
(4, 'spending', 'needs', 'food', 'Makanan/Minuman Utama'),
(5, 'spending', 'needs', 'daily', 'Kebutuhan Rumah Tangga'),
(6, 'spending', 'needs', 'charity', 'Amal/Donasi'),
(7, 'spending', 'wants', 'snack', 'Jajanan/Cemilan'),
(8, 'spending', 'wants', 'recreation', 'Rekreasi/Hiburan'),
(9, 'spending', 'wants', 'shopping', 'Belanja Keinginan'),
(10, 'spending', 'wants', 'hobby', 'Hobi'),
(11, 'spending', 'priority', 'place', 'Kos/Rumah'),
(12, 'spending', 'priority', 'bill', 'Cicilan/Utang'),
(13, 'spending', 'priority', 'health', 'Kesehatan'),
(14, 'spending', 'priority', 'education', 'Pendidikan'),
(15, 'spending', 'wants', 'other', 'Lainnya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `flow`
--
ALTER TABLE `flow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `flow`
--
ALTER TABLE `flow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
