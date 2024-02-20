-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 03:29 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vstaff`
--

-- --------------------------------------------------------

--
-- Table structure for table `vstaff_emp_master`
--

CREATE TABLE `vstaff_emp_master` (
  `emp_code` varchar(50) NOT NULL,
  `LOGIN_ID` varchar(50) NOT NULL,
  `NAME` varchar(200) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vstaff_timesheet_integration`
--

CREATE TABLE `vstaff_timesheet_integration` (
  `id` int(11) NOT NULL,
  `emp_code` varchar(255) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `branch` varchar(255) NOT NULL,
  `action` int(2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vstaff_emp_master`
--
ALTER TABLE `vstaff_emp_master`
  ADD PRIMARY KEY (`emp_code`),
  ADD KEY `emp_code` (`emp_code`),
  ADD KEY `LOGIN_ID` (`LOGIN_ID`),
  ADD KEY `NAME` (`NAME`),
  ADD KEY `PASSWORD` (`PASSWORD`),
  ADD KEY `PASSWORD_2` (`PASSWORD`);

--
-- Indexes for table `vstaff_timesheet_integration`
--
ALTER TABLE `vstaff_timesheet_integration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vstaff_timesheet_integration`
--
ALTER TABLE `vstaff_timesheet_integration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
