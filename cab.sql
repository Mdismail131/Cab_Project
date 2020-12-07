-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2020 at 03:36 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cab`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE `tbl_location` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `distance` varchar(100) NOT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_location`
--

INSERT INTO `tbl_location` (`id`, `name`, `distance`, `is_available`) VALUES
(1, 'Charbagh', '0', 1),
(2, 'Indira Nagar', '10', 1),
(3, 'BBD', '30', 1),
(4, 'Barabanki', '60', 1),
(5, 'Faizabad', '100', 1),
(6, 'Basti', '150', 1),
(10, 'Gorakhpur', '210', 1),
(12, 'Delhi', '500', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ride`
--

CREATE TABLE `tbl_ride` (
  `ride_id` int(11) NOT NULL,
  `ride_date` date NOT NULL,
  `from_loc` varchar(30) NOT NULL,
  `to_loc` varchar(30) NOT NULL,
  `total_distance` varchar(10) NOT NULL,
  `cab_type` varchar(200) NOT NULL,
  `luggage` varchar(10) NOT NULL,
  `total_fare` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `customer_user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ride`
--

INSERT INTO `tbl_ride` (`ride_id`, `ride_date`, `from_loc`, `to_loc`, `total_distance`, `cab_type`, `luggage`, `total_fare`, `status`, `customer_user_id`) VALUES
(51, '2020-12-03', 'Barabanki', 'Basti', '90', 'CedMicro', '0', '1091', 2, '15'),
(52, '2020-12-03', 'Faizabad', 'BBD', '70', 'CedMicro', '0', '887', 0, '15'),
(53, '2020-12-03', 'Gorakhpur', 'Faizabad', '110', 'CedSUV', '0', '1925', 2, '15'),
(54, '2020-12-03', 'BBD', 'Faizabad', '70', 'CedMicro', '0', '887', 0, '15'),
(55, '2020-12-04', 'Indira Nagar', 'Gorakhpur', '200', 'CedMini', '0', '2495', 0, '15'),
(56, '2020-12-04', 'Barabanki', 'Charbagh', '60', 'CedMicro', '0', '785', 0, '15'),
(57, '2020-12-04', 'Charbagh', 'BBD', '30', 'CedMini', '0', '655', 0, '15'),
(60, '2020-12-04', 'Gorakhpur', 'Barabanki', '150', 'CedSUV', '0', '2753', 1, '7'),
(61, '2020-12-04', 'Delhi', 'Barabanki', '440', 'CedSUV', '0', '5705', 1, '15'),
(62, '2020-12-04', 'Gorakhpur', 'Basti', '60', 'CedMini', '0', '945', 0, '15'),
(63, '2020-12-05', 'Basti', 'Charbagh', '150', 'CedMicro', '0', '1703', 0, '15'),
(64, '2020-12-05', 'Delhi', 'Basti', '350', 'CedRoyal', '0', '4320', 1, '15'),
(65, '2020-12-05', 'Barabanki', 'Basti', '90', 'CedMini', '0', '1331', 1, '16'),
(66, '2020-12-05', 'Gorakhpur', 'Barabanki', '150', 'CedMicro', '0', '1703', 1, '16'),
(67, '2020-12-05', 'Indira Nagar', 'Gorakhpur', '200', 'CedRoyal', '0', '2895', 1, '16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_signup` datetime NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `is_block` tinyint(1) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `name`, `date_of_signup`, `mobile`, `is_block`, `password`, `isAdmin`) VALUES
(1, 'admin', 'Ismail', '2020-11-26 11:34:36', '9161220126', 1, '5f4dcc3b5aa765d61d8327deb882cf99', 1),
(15, 'ismail', 'ismail', '2020-12-03 12:38:09', '9876543210', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0),
(16, 'tufail', 'tufail', '2020-12-04 09:06:07', '123', 1, '2be90151ef5eabf7bbe74300008d9a71', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_location`
--
ALTER TABLE `tbl_location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_ride`
--
ALTER TABLE `tbl_ride`
  ADD PRIMARY KEY (`ride_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_location`
--
ALTER TABLE `tbl_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_ride`
--
ALTER TABLE `tbl_ride`
  MODIFY `ride_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
