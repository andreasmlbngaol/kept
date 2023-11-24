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
-- Database: `keepdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `andreasmlbngaol_keep`
--

CREATE TABLE `andreasmlbngaol_keep` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `class` varchar(31) DEFAULT NULL,
  `category` varchar(31) DEFAULT NULL,
  `username` varchar(31) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `detail` varchar(256) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `andreasmlbngaol_keep`
--

INSERT INTO `andreasmlbngaol_keep` (`id`, `date`, `class`, `category`, `username`, `name`, `detail`, `value`) VALUES
(1, '2023-10-26', 'income', 'routine', 'routine', 'Pendapatan Rutin', 'Rutin', 3000000),
(2, '2023-10-26', 'income', 'additional', 'additional', 'Pendapatan Tambahan', 'Tes', 100000),
(3, '2023-10-26', 'spending', 'wants', 'snack', 'Jajanan/Cemilan', 'Jajan', 100000),
(4, '2023-10-26', 'spending', 'wants', 'recreation', 'Rekreasi/Hiburan', 'Jalan-jalan', 50000),
(5, '2023-10-26', 'spending', 'wants', 'other', 'Lainnya', 'Gak tau kemana', 30000),
(6, '2023-10-26', 'spending', 'wants', 'shopping', 'Belanja Keinginan', 'Uniqlo', 200000),
(7, '2023-10-26', 'spending', 'wants', 'hobby', 'Hobi', 'Tes', 50000),
(8, '2023-10-26', 'spending', 'needs', 'transportation', 'Transportasi', 'PP', 18000),
(9, '2023-10-26', 'spending', 'needs', 'food', 'Makanan/Minuman Utama', 'Mam siang', 40000),
(10, '2023-10-26', 'spending', 'needs', 'daily', 'Kebutuhan Rumah Tangga', 'Shampoo', 50000),
(11, '2023-10-26', 'spending', 'needs', 'charity', 'Amal/Donasi', 'Orang kikir', 5000),
(12, '2023-10-26', 'income', 'additional', 'additional', 'Pendapatan Tambahan', 'Tes', 2800000),
(13, '2023-10-26', 'spending', 'priority', 'place', 'Kos/Rumah', 'Kos', 1000000),
(14, '2023-10-26', 'spending', 'priority', 'bill', 'Cicilan/Utang', 'Paylater', 400000),
(15, '2023-10-26', 'spending', 'priority', 'health', 'Kesehatan', 'Tes aja', 300000),
(16, '2023-10-26', 'spending', 'priority', 'education', 'Pendidikan', 'Tes lagi', 200000),
(17, '2023-10-26', 'spending', 'needs', 'charity', 'Amal/Donasi', 'Dermawan', 350000);

-- --------------------------------------------------------

--
-- Table structure for table `arrowonskin_keep`
--

CREATE TABLE `arrowonskin_keep` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `class` varchar(31) DEFAULT NULL,
  `category` varchar(31) DEFAULT NULL,
  `username` varchar(31) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `detail` varchar(256) DEFAULT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arrowonskin_keep`
--

INSERT INTO `arrowonskin_keep` (`id`, `date`, `class`, `category`, `username`, `name`, `detail`, `value`) VALUES
(6, '2023-10-26', 'income', 'additional', 'additional', 'Pendapatan Tambahan', 'Ngepet', 1000000),
(10, '2023-10-26', 'spending', 'needs', 'transportation', 'Transportasi', 'Roket', 5000),
(12, '2023-11-02', 'spending', 'needs', 'daily', 'Kebutuhan Rumah Tangga', 'Sabun', 20000),
(13, '2023-11-19', 'income', 'additional', 'additional', 'Pendapatan Tambahan', 'ya', 50000),
(14, '2023-11-23', 'spending', 'needs', 'transportation', 'Transportasi', 'transport', 15000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `andreasmlbngaol_keep`
--
ALTER TABLE `andreasmlbngaol_keep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrowonskin_keep`
--
ALTER TABLE `arrowonskin_keep`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `andreasmlbngaol_keep`
--
ALTER TABLE `andreasmlbngaol_keep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `arrowonskin_keep`
--
ALTER TABLE `arrowonskin_keep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
