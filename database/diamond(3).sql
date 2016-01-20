-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2015 at 10:39 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diamond`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `phoneno` varchar(12) DEFAULT NULL,
  `companyname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `name`, `address`, `phoneno`, `companyname`) VALUES
(1, 'Abhi', NULL, NULL, NULL),
(2, 'Ronak', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

DROP TABLE IF EXISTS `process`;
CREATE TABLE `process` (
  `process_id` int(11) NOT NULL,
  `purchase_id` int(20) NOT NULL,
  `process_type` varchar(50) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `weight` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `process_type`
--

DROP TABLE IF EXISTS `process_type`;
CREATE TABLE `process_type` (
  `process_type_id` int(11) NOT NULL,
  `process_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `process_type`
--

INSERT INTO `process_type` (`process_type_id`, `process_type`) VALUES
(1, 'rough'),
(2, 'laser'),
(3, 'ghatt'),
(4, 'sign'),
(5, 'polish');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `pid` int(11) NOT NULL,
  `pcid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `pdate` date DEFAULT NULL,
  `no_of_days` varchar(20) NOT NULL,
  `duedate` date DEFAULT NULL,
  `rate` float(10,2) DEFAULT NULL,
  `weight` float(10,2) DEFAULT NULL,
  `weighttype` enum('carat','cent') DEFAULT NULL,
  `type` enum('palcha','rough','taiyar','direct') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`pid`, `pcid`, `name`, `amount`, `pdate`, `no_of_days`, `duedate`, `rate`, `weight`, `weighttype`, `type`) VALUES
(1, 1, 'a', 4780.00, '2015-12-01', '90', '2016-02-29', 478.00, 10.00, 'carat', 'palcha'),
(2, 2, 'r', 5615.00, '2015-12-02', '45', '2016-01-16', 1123.00, 5.00, 'carat', 'palcha'),
(3, 1, 'abc', NULL, '2015-12-30', '90', NULL, 125.00, 10.00, 'carat', 'palcha');

-- --------------------------------------------------------

--
-- Table structure for table `selling`
--

DROP TABLE IF EXISTS `selling`;
CREATE TABLE `selling` (
  `sid` int(11) NOT NULL,
  `scid` int(11) DEFAULT NULL,
  `seid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `pdate` date DEFAULT NULL,
  `rate` float(10,2) DEFAULT NULL,
  `weight` float(10,2) DEFAULT NULL,
  `weighttype` enum('carat','cent') DEFAULT NULL,
  `type` enum('palcha','rough','taiyar','direct') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `weight` float(10,2) NOT NULL,
  `purchase_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_new`
--

DROP TABLE IF EXISTS `stock_new`;
CREATE TABLE `stock_new` (
  `stock_id` int(11) NOT NULL,
  `purchase_id` int(20) NOT NULL,
  `pcid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `pdate` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `rate` float(10,2) DEFAULT NULL,
  `weight` float(10,2) DEFAULT NULL,
  `weighttype` enum('carat','cent') DEFAULT NULL,
  `type` enum('palcha','rough','taiyar','direct') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_new`
--

INSERT INTO `stock_new` (`stock_id`, `purchase_id`, `pcid`, `name`, `amount`, `pdate`, `duedate`, `rate`, `weight`, `weighttype`, `type`) VALUES
(1, 0, 1, 'a', 0.00, '2015-12-01', '0000-00-00', 478.00, 10.00, 'carat', 'palcha'),
(2, 0, 2, 'r', 0.00, '2015-12-02', '2016-01-16', 1123.00, 5.00, 'carat', 'palcha'),
(3, 0, 2, 'r', 0.00, '2015-12-02', '2016-01-16', 1123.00, 5.00, 'carat', 'palcha'),
(4, 0, 1, 'abc', 0.00, '2015-12-30', '2016-03-29', 125.00, 10.00, 'carat', 'palcha'),
(5, 0, 1, 'abc', 0.00, '2015-12-30', '2016-03-29', 125.00, 10.00, 'carat', 'palcha'),
(6, 0, 1, 'abc', 0.00, '2015-12-30', '2016-03-29', 125.00, 10.00, 'carat', 'palcha');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `cid` (`cid`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`process_id`);

--
-- Indexes for table `process_type`
--
ALTER TABLE `process_type`
  ADD PRIMARY KEY (`process_type_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `selling`
--
ALTER TABLE `selling`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_new`
--
ALTER TABLE `stock_new`
  ADD PRIMARY KEY (`stock_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_type`
--
ALTER TABLE `process_type`
  MODIFY `process_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `selling`
--
ALTER TABLE `selling`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_new`
--
ALTER TABLE `stock_new`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
