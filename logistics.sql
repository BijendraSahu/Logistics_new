-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2018 at 07:44 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logistics`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE `admin_master` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_master`
--

INSERT INTO `admin_master` (`id`, `name`, `username`, `password`, `is_active`) VALUES
(1, 'Palash Goswami', 'admin', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_request`
--

CREATE TABLE `client_request` (
  `id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_type_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_request`
--

INSERT INTO `client_request` (`id`, `location_id`, `material_id`, `material_type_id`, `qty`, `unit_id`, `address`, `is_approved`, `created_by`, `is_active`, `created_time`) VALUES
(1, 1, 1, 1, 100, 1, 'JBP', 0, 3, 1, '2018-06-25 08:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `client_unload`
--

CREATE TABLE `client_unload` (
  `id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_type_id` int(11) DEFAULT NULL,
  `unload_qty` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `unload_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `unloaded_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_unload`
--

INSERT INTO `client_unload` (`id`, `location_id`, `material_id`, `material_type_id`, `unload_qty`, `unit_id`, `vehicle_id`, `unload_by`, `is_active`, `unloaded_time`) VALUES
(1, NULL, 1, 1, 95, 1, 1, 2, 1, '2018-06-22 13:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `name` int(11) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location_master`
--

CREATE TABLE `location_master` (
  `id` int(11) NOT NULL,
  `type` enum('dumping_site','crusher','petrol_pump','site') DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_master`
--

INSERT INTO `location_master` (`id`, `type`, `name`, `is_active`) VALUES
(1, 'dumping_site', 'Crusher', 1),
(2, 'crusher', 'gjig', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manager_request`
--

CREATE TABLE `manager_request` (
  `id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `material_type_id` int(11) DEFAULT NULL,
  `load_qty` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `destination_address` varchar(200) DEFAULT NULL,
  `estimate_deliver_time` timestamp NULL DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `loaded_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager_request`
--

INSERT INTO `manager_request` (`id`, `location_id`, `material_id`, `material_type_id`, `load_qty`, `unit_id`, `destination_address`, `estimate_deliver_time`, `vehicle_id`, `created_by`, `is_active`, `loaded_time`) VALUES
(1, NULL, 1, 1, 100, 1, 'Jablapur', '2018-06-22 15:00:00', 2, 1, 1, '2018-06-22 09:59:08'),
(2, NULL, 1, 1, 100, 1, 'Jablapur', '2018-06-22 15:00:00', 1, 1, 1, '2018-06-22 09:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `location_id`, `name`, `is_active`) VALUES
(1, 1, 'material2', 1),
(2, NULL, 'dsa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `material_type`
--

CREATE TABLE `material_type` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material_type`
--

INSERT INTO `material_type` (`id`, `type`, `material_id`, `is_active`) VALUES
(1, 'test', 2, 1),
(2, 'test2', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `petrol_order`
--

CREATE TABLE `petrol_order` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `qty` float NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1',
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `done_by` int(11) DEFAULT NULL,
  `order_by` int(11) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `petrol_order`
--

INSERT INTO `petrol_order` (`id`, `vehicle_id`, `qty`, `unit_id`, `is_active`, `is_done`, `done_by`, `order_by`, `created_time`) VALUES
(1, 1, 10, 1, 1, 0, NULL, 10, '2018-06-30 13:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit`, `is_active`) VALUES
(1, 'Site1', 1),
(2, 'KG', 1),
(3, 'dsa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` enum('admin','staff','client','supervisor') DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `profile_img` varchar(100) DEFAULT 'images/Male_default.png',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_verified` tinyint(4) NOT NULL DEFAULT '0',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `type`, `name`, `company_name`, `contact`, `password`, `profile_img`, `is_active`, `is_verified`, `created_time`) VALUES
(1, 'admin', 'admin', 'Amit', NULL, '9876543210', '202cb962ac59075b964b07152d234b70', 'admin.png', 1, 0, '2018-06-18 11:54:39'),
(2, 'staff', 'staff', 'Staff Man', NULL, '7894561230', '202cb962ac59075b964b07152d234b70', 'images/Male_default.png', 0, 0, '2018-06-25 08:23:57'),
(3, 'client', 'client', 'client Man', NULL, '7894561231', '202cb962ac59075b964b07152d234b70', 'images/Male_default.png', 1, 0, '2018-06-25 08:24:19'),
(4, 'supervisor', 'dumping_site', 'Supervisor1', NULL, '7894561231', '202cb962ac59075b964b07152d234b70', 'images/Male_default.png', 1, 0, '2018-06-25 08:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `vehicle_no` varchar(20) DEFAULT NULL,
  `is_loaded` tinyint(4) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehicle_no`, `is_loaded`, `is_active`, `created_time`) VALUES
(1, 'MP20NB9957', 0, 1, '2018-06-25 08:28:37'),
(2, 'MP20NB9956', 0, 1, '2018-06-25 08:28:37'),
(3, 'MP20NB9958', 0, 1, '2018-06-29 06:19:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_request`
--
ALTER TABLE `client_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_unload`
--
ALTER TABLE `client_unload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_master`
--
ALTER TABLE `location_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager_request`
--
ALTER TABLE `manager_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_type`
--
ALTER TABLE `material_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petrol_order`
--
ALTER TABLE `petrol_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_master`
--
ALTER TABLE `admin_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_request`
--
ALTER TABLE `client_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_unload`
--
ALTER TABLE `client_unload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_master`
--
ALTER TABLE `location_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manager_request`
--
ALTER TABLE `manager_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_type`
--
ALTER TABLE `material_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `petrol_order`
--
ALTER TABLE `petrol_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
