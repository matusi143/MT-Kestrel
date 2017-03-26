-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2017 at 08:49 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kestrel`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `ID` int(11) NOT NULL,
  `DEPT_LOCATION` tinyint(3) UNSIGNED NOT NULL,
  `DEPT_NUM` smallint(5) UNSIGNED NOT NULL,
  `DEPT_NAME` varchar(40) NOT NULL,
  `TAX1` decimal(5,4) NOT NULL,
  `TAX2` decimal(5,4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` tinyint(3) UNSIGNED NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `USERNAME` varchar(30) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REMOTE_ADDR` varchar(45) NOT NULL,
  `X_FORWARD` varchar(45) NOT NULL,
  `ATTEMPTED_ACTION` varchar(256) NOT NULL,
  `BROWSER` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loss`
--

CREATE TABLE `loss` (
  `UPC` varchar(13) NOT NULL,
  `TXN_TIME` timestamp NOT NULL,
  `QTY_DELTA` int(11) NOT NULL,
  `CLERK` varchar(50) NOT NULL,
  `LOCATION` tinyint(4) NOT NULL,
  `RETAIL_LOSS` decimal(7,2) NOT NULL,
  `NOTE` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `USERNAME` varchar(30) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `ROLE` varchar(8) NOT NULL,
  `MODULES` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `UPC` varchar(15) NOT NULL,
  `NAME` varchar(28) NOT NULL,
  `DESC` varchar(128) NOT NULL,
  `PRICE` decimal(7,2) NOT NULL,
  `LOCATION` tinyint(3) UNSIGNED NOT NULL,
  `QTY` smallint(6) NOT NULL,
  `ACTIVE` varchar(1) NOT NULL,
  `DEPT` tinyint(3) UNSIGNED NOT NULL,
  `TAXABLE` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `txn`
--

CREATE TABLE `txn` (
  `UPC` varchar(13) NOT NULL,
  `TYPE` varchar(6) NOT NULL,
  `COST` decimal(5,2) NOT NULL,
  `QTY` smallint(6) NOT NULL,
  `TXN_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CLERK` varchar(50) NOT NULL,
  `LOCATION` tinyint(3) UNSIGNED NOT NULL,
  `WHSLER` varchar(50) NOT NULL,
  `PRICE` decimal(5,2) NOT NULL,
  `TAXABLE` varchar(3) NOT NULL,
  `DEPT` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `dept_location` (`DEPT_LOCATION`),
  ADD KEY `dept_num` (`DEPT_NUM`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD KEY `USERNAME` (`USERNAME`),
  ADD KEY `TIME` (`TIME`);

--
-- Indexes for table `loss`
--
ALTER TABLE `loss`
  ADD KEY `UPC` (`UPC`),
  ADD KEY `TXN_TIME` (`TXN_TIME`),
  ADD KEY `LOCATION` (`LOCATION`),
  ADD KEY `TXN_TIME_2` (`TXN_TIME`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`USERNAME`),
  ADD UNIQUE KEY `EMAIL_UNIQUE` (`EMAIL`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD KEY `PRD_UPC` (`UPC`),
  ADD KEY `LOCATION` (`LOCATION`);

--
-- Indexes for table `txn`
--
ALTER TABLE `txn`
  ADD KEY `TXN_UPC` (`UPC`),
  ADD KEY `TRX_TYPE` (`TYPE`),
  ADD KEY `TRX_TIMESTAMP` (`TXN_TIME`),
  ADD KEY `TRX_LOCATION` (`LOCATION`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
