-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2021 at 10:29 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutorial`
--

-- --------------------------------------------------------

--
-- Table structure for table `mis_production`
--

CREATE TABLE `mis_production` (
  `sr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `financial_year` varchar(15) NOT NULL,
  `financial_quarter` int(11) NOT NULL,
  `product_name` varchar(500) NOT NULL,
  `production_unit` varchar(200) NOT NULL,
  `total_production` int(11) NOT NULL,
  `uploded_on` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mis_production`
--

INSERT INTO `mis_production` (`sr_id`, `user_id`, `financial_year`, `financial_quarter`, `product_name`, `production_unit`, `total_production`, `uploded_on`) VALUES
(33, 75, '2008-2009', 2, 'Ghee', '1', 1, '2021-08-11 06:04:50 PM'),
(34, 75, '2009-2010', 3, 'Biscuit', '1', 12, '2021-08-11 06:05:05 PM'),
(35, 75, '2011-2012', 3, 'Sunflower Oil', '2', 12, '2021-08-15 08:27:39 PM'),
(36, 75, '2008-2009', 3, 'Soap', '2', 12, '2021-08-15 08:43:37 PM'),
(37, 75, '2019-2020', 3, 'Cashew Nuts', '2', 12, '2021-08-18 12:00:40 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mis_production`
--
ALTER TABLE `mis_production`
  ADD PRIMARY KEY (`sr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mis_production`
--
ALTER TABLE `mis_production`
  MODIFY `sr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16867279;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
