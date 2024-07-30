-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 04:41 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a_heterohealthcarw`
--

-- --------------------------------------------------------

--
-- Table structure for table `exepense_details`
--

CREATE TABLE `exepense_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expense_master_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `travelling_from` varchar(255) DEFAULT NULL,
  `travelling_to` varchar(255) DEFAULT NULL,
  `orvernight_at` varchar(255) DEFAULT NULL,
  `days_total` decimal(10,2) DEFAULT NULL,
  `day_city_name` varchar(255) DEFAULT NULL,
  `day_pupose` text DEFAULT NULL,
  `status` enum('R','A','D') DEFAULT 'D' COMMENT 'R-rejected, A-pproved,\r\nD-Draft',
  `remark` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_items`
--

CREATE TABLE `expense_items` (
  `id` int(11) NOT NULL,
  `expense_detail_id` int(11) DEFAULT NULL,
  `type` enum('R','T','H','L','B','LU','D','P','LC','M') DEFAULT NULL COMMENT 'R-rail,T-taxi,H-hotel, L-laundry,B-breakfast,LU-lunch,D-dinner, P-phone, LC-local convenyance, M-miscellanous',
  `basefare` decimal(10,2) DEFAULT 0.00,
  `gst_amount` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `gst_no` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `hotel_name` text DEFAULT NULL,
  `hotel_city` varchar(255) DEFAULT NULL,
  `approved_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_item_docs`
--

CREATE TABLE `expense_item_docs` (
  `id` int(11) NOT NULL,
  `expense_item_id` int(11) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expense_master`
--

CREATE TABLE `expense_master` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('WE') DEFAULT NULL COMMENT '''WE''= weekly expense',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `claimed_total` decimal(10,2) DEFAULT 0.00,
  `approved_total` decimal(10,2) DEFAULT 0.00,
  `status` enum('D','S','R','A') NOT NULL DEFAULT 'D' COMMENT 'D-draft, S-submitted, R- rejected, A- approved',
  `approval_stage` enum('ADAS','HR','ACAS','ACH','ACHY','ADH') NOT NULL DEFAULT 'ADAS' COMMENT 'ADAS-admin asst, HR- hr, ACAS-acct asst, ACH-acct head, ACHY-acct hyd, ADH-admin head',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `empID` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('E','AA','A','HR','ACA','ACH','AHY') DEFAULT NULL COMMENT '''E''=>Employee,\r\n''AA''=>Admin Assistance,\r\n''A''=>Admin,\r\n''HR''=>HR,\r\n''ACA''=>Acc Asst,\r\n''ACH''=>Acc Head,\r\n''AHY''=>Acc Hyd',
  `status` enum('A','I') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `slug`, `empID`, `designation`, `department`, `division`, `password`, `user_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Employee One', '1234567890', NULL, 'employee1', 'TECHNICAL LEAD', 'INFORMATION TECHNOLOGY', 'HHC - CORPORATE', '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'E', 'A', '2023-03-21 14:33:05', '2023-03-21 14:33:05'),
(2, 'Admin Assistant', '1234567890', NULL, 'adminassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AA', 'A', '2023-03-22 07:40:03', '2023-03-22 07:40:03'),
(3, 'Admin', '12121212121', NULL, 'admin', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'A', 'A', '2023-03-22 07:40:03', '2023-03-22 07:40:03'),
(4, 'HR', '112121212', NULL, 'hr', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'HR', 'A', '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(5, 'Account Assistant', NULL, NULL, 'accountassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACA', 'A', '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(6, 'Account Head', '565656', NULL, 'accounthead', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACH', 'A', '2023-03-22 14:10:54', '2023-03-22 14:10:54'),
(7, 'Account Hyd', NULL, NULL, 'accounthyd', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AHY', 'A', '2023-03-22 14:10:54', '2023-03-22 14:10:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exepense_details`
--
ALTER TABLE `exepense_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_items`
--
ALTER TABLE `expense_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_item_docs`
--
ALTER TABLE `expense_item_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_master`
--
ALTER TABLE `expense_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exepense_details`
--
ALTER TABLE `exepense_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_item_docs`
--
ALTER TABLE `expense_item_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_master`
--
ALTER TABLE `expense_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
