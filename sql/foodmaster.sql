-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 12:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodmaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `fooditems`
--

CREATE TABLE `fooditems` (
  `id` int(11) NOT NULL,
  `foodtype` varchar(255) DEFAULT NULL,
  `foodname` varchar(255) DEFAULT NULL,
  `mrp` float DEFAULT NULL,
  `sellingprice` float NOT NULL,
  `totalqty` float NOT NULL,
  `qtyleft` float NOT NULL,
  `image` varchar(2500) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` varchar(20) NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fooditems`
--

INSERT INTO `fooditems` (`id`, `foodtype`, `foodname`, `mrp`, `sellingprice`, `totalqty`, `qtyleft`, `image`, `status`, `created_at`, `update_at`) VALUES
(6, 'Grains', NULL, 12.44, 0, 0, 0, '', 1, '2024-03-18', '2024-03-19 11:06:37'),
(7, 'Protein Foods', NULL, 3, 0, 0, 0, '', 0, '2024-03-18', '2024-03-18 05:50:45'),
(17, 'Fruits', 'apple', 100, 50, 10, 10, '20240319_082633.jpg', 1, '2024-03-19', '2024-03-19 07:26:33'),
(19, 'Vegetables', 'potato', 30, 20, 30, 30, '20240319_081928.jpg', 1, '2024-03-19', '2024-03-19 11:17:57'),
(23, 'Vegetables', 'tomato', 40, 25, 1000, 1000, '20240319_081650.jpg', 1, '2024-03-19', '2024-03-19 11:03:36'),
(24, 'Fruits', 'mango', 100, 90, 1000, 1000, '20240319_082713.jpeg', 1, '2024-03-19', '2024-03-19 07:27:13'),
(25, 'Vegetables', 'cabbage', 50, 40, 100, 100, '20240319_082819.jpg', 1, '2024-03-19', '2024-03-19 07:28:19'),
(26, 'Vegetables', 'brinjal', 30, 27, 1000, 1000, '20240319_103152.png', 1, '2024-03-19', '2024-03-19 09:31:52'),
(27, 'Fruits', 'banana', 70, 65, 1000, 1000, '20240319_103630.jpg', 1, '2024-03-19', '2024-03-19 09:36:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fooditems`
--
ALTER TABLE `fooditems`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fooditems`
--
ALTER TABLE `fooditems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
