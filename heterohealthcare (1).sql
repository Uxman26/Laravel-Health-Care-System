-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 06:00 PM
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
-- Database: `heterohealthcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `phone_1` varchar(255) DEFAULT NULL,
  `email_1` varchar(255) DEFAULT NULL,
  `phone_2` varchar(255) DEFAULT NULL,
  `email_2` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `phone_1`, `email_1`, `phone_2`, `email_2`, `created_at`, `updated_at`) VALUES
(1, '+91 -9876543211', 'karthik.kolipaka@heterohealthcare.com', '+91 -9876543210', 'karthik2.koli2paka@heterohealthcare.com', '2023-03-31 06:09:28', '2023-05-22 08:42:03');

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
  `days_approved` decimal(10,2) DEFAULT 0.00,
  `day_city_name` varchar(255) DEFAULT NULL,
  `day_pupose` text DEFAULT NULL,
  `status` enum('R','A','D','S','H') DEFAULT 'D' COMMENT 'R-rejected, A-pproved,\r\nD-Draft,S-submitted,H- onhold',
  `remark` text DEFAULT NULL,
  `approval_stage` enum('NA','ADAS','HR','ACAS','ACH','ACHY','ADH') NOT NULL DEFAULT 'NA' COMMENT 'NA-non approval,ADAS-admin asst, HR- hr, ACAS-acct asst, ACH-acct head, ACHY-acct hyd, ADH-admin head',
  `is_admin_commented` enum('Y','N') NOT NULL DEFAULT 'N',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `approved_gst_amount` decimal(10,2) DEFAULT 0.00,
  `approved_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `comment` text DEFAULT NULL,
  `item_false_id` int(11) DEFAULT NULL,
  `taxi_option` enum('O','I','1','2','3') DEFAULT NULL COMMENT 'O-organization,I-Individuals',
  `misce_option` enum('F','O') DEFAULT NULL COMMENT 'F-Food,O-Others',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_master`
--

CREATE TABLE `expense_master` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expense_unique_code` varchar(255) DEFAULT NULL,
  `type` enum('WE','Leave','Holiday') DEFAULT NULL COMMENT '''WE''= weekly expense',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `claimed_total` decimal(10,2) DEFAULT 0.00,
  `approved_total` decimal(10,2) DEFAULT 0.00,
  `status` enum('D','S','R','A','H') NOT NULL DEFAULT 'D' COMMENT 'D-draft, S-submitted, R- rejected, A- approved, H-Onhold',
  `approval_stage` enum('NA','ADAS','HR','ACAS','ACH','ACHY','ADH') NOT NULL DEFAULT 'NA' COMMENT 'NA-non approval,ADAS-admin asst, HR- hr, ACAS-acct asst, ACH-acct head, ACHY-acct hyd, ADH-admin head',
  `rejected_by` enum('NA','ADAS','HR','ACAS','ACH','ACHY','ADH') DEFAULT NULL,
  `is_editable` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memos`
--

CREATE TABLE `memos` (
  `id` bigint(20) NOT NULL,
  `expense_master_id` int(11) DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `remark` longtext DEFAULT NULL,
  `transaction_id` text DEFAULT NULL,
  `transaction_receipt` text DEFAULT NULL,
  `transaction_remark` longtext DEFAULT NULL,
  `status` enum('I','C','H','R') DEFAULT NULL COMMENT 'I=Initiated,\r\nC=Completed, H- Onhold, R - rejected',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_request`
--

CREATE TABLE `password_request` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_type` enum('E','AA','A','HR','ACA','ACH','AHY') DEFAULT NULL COMMENT '''E''=>Employee, ''AA''=>Admin Assistance, ''A''=>Admin, ''HR''=>HR, ''ACA''=>Acc Asst, ''ACH''=>Acc Head, ''AHY''=>Acc Hyd',
  `user_id` int(11) DEFAULT NULL,
  `status` enum('A','R','N') DEFAULT 'N' COMMENT 'A-accept,R-reject,N-new',
  `request_type` enum('FP','NP') DEFAULT NULL COMMENT 'FP-forgetpassword, NP-normal passord',
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `for_user` enum('E','AA','A','HR','ACA','ACH','AHY') DEFAULT NULL COMMENT '''E''=>Employee, ''AA''=>Admin Assistance, ''A''=>Admin, ''HR''=>HR, ''ACA''=>Acc Asst, ''ACH''=>Acc Head, ''AHY''=>Acc Hyd	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `file_name`, `for_user`, `created_at`, `updated_at`) VALUES
(2, 'Employee user manual.pdf', 'E', '2024-02-24 06:39:33', '2024-02-24 06:39:33'),
(3, 'Mumbai HR.pdf', 'HR', '2024-02-25 22:54:21', '2024-02-25 22:54:21'),
(4, 'Accounts assistant.pdf', 'ACA', '2024-02-25 22:54:55', '2024-02-25 22:54:55'),
(5, 'Accounts head.pdf', 'ACH', '2024-02-25 22:55:29', '2024-02-25 22:55:29'),
(6, 'Accounts HYD.pdf', 'AHY', '2024-02-25 22:55:56', '2024-02-25 22:55:56'),
(7, 'Admin assistant.pdf', 'AA', '2024-02-26 00:50:18', '2024-02-26 00:50:18'),
(8, 'Admin head.pdf', 'A', '2024-02-26 00:50:46', '2024-02-26 00:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `pro_email` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `empID` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('E','AA','A','HR','ACA','ACH','AHY','DIR') DEFAULT NULL COMMENT '''E''=>Employee,\r\n''AA''=>Admin Assistance,\r\n''A''=>Admin,\r\n''HR''=>HR,\r\n''ACA''=>Acc Asst,\r\n''ACH''=>Acc Head,\r\n''AHY''=>Acc Hyd',
  `status` enum('A','I') DEFAULT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `pro_email`, `slug`, `empID`, `designation`, `department`, `division`, `password`, `user_type`, `status`, `signature_image`, `created_at`, `updated_at`) VALUES
(1, 'PRANAY PRABHAKAR PATIL', NULL, NULL, NULL, '50202', NULL, NULL, NULL, '$2y$10$xNy5DOmc/ONaXbOxA/mpS.JiqKFX8.FO/voSNxt56wniGpT/NJ6iC', 'E', 'A', NULL, '2024-04-05 07:26:21', '2024-04-23 07:46:18'),
(2, 'SAMEER D DESHPANDE', '9869737985', 'sameer@heterohealthcare.com', NULL, '20113', 'SENIOR MANAGER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$HeJIetvm6B9QRDHDPMvqJurGzSc77Mxhukv1GTZw/f6Ph614yTAAy', 'A', 'A', '1712303238-1550.png', '2024-04-05 07:27:16', '2024-04-05 09:31:44'),
(3, 'MANOJ B PATIL', '9322032091', 'manoj@heterohealthcare.com', NULL, '10183', 'GENERAL MANAGER', 'PERSONEL & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$DXjAicCkgWeuYWLsZufB4uJfDH8W8D0Gg/jgIb8jIyZAZduonYAJW', 'HR', 'A', NULL, '2024-04-05 07:27:58', '2024-04-05 08:51:45'),
(4, 'NISHAD ANIL PATIL', '8806777006', '', NULL, '50184', 'OFFICER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$scpsMzujk8T0I.Mx.JhM3erSNqMSBJvxUEOvCcaO0YQqZ453ozcUO', 'ACA', 'A', NULL, '2024-04-05 07:28:46', '2024-04-05 07:28:46'),
(5, 'MUGDHA DILIP MAYEKAR', '7887556772', '', NULL, '50136', 'SENIOR OFFICER', 'ACCOUNTS', 'HHC - MUM - CORPORATE', '$2y$10$dH7HgVFZEJ29VD6D0g/ane3p9MMLyhj8NCDWYYeMWuyDfXJ6xGv6y', 'ACA', 'A', NULL, '2024-04-05 07:29:12', '2024-04-05 07:42:58'),
(6, 'RAVINDRA BABA KOKATE', '9860081917', 'ravindra.k@heterohealthcare.com', NULL, '10327', 'ASSISTANT MANAGER', 'ACCOUNTS', 'HHC - MUM - CORPORATE', '$2y$10$6env61UVj8Xdk5O97eSQheYhhAeGyU2xPp3qPB5j69Ot1ft/.ULri', 'ACH', 'A', NULL, '2024-04-05 07:29:37', '2024-04-05 07:44:00'),
(7, 'BHANU PRASAD GONTHINA', '9849126023', 'gonthinabp@gmail.com', NULL, '106954', 'SENIOR ZONAL BUSINESS MANAGER', 'SALES', 'HHC - ONCOLOGY', '$2y$10$6cZKVNQbsx2ahzwzL2sk4O9FA.nFaXeRkoQ9cunrj68ssPJKe3yMG', 'E', 'A', NULL, '2024-04-05 07:32:39', '2024-04-05 09:24:06'),
(8, 'K M V PRASAD REDDY', NULL, NULL, NULL, '106892', NULL, NULL, NULL, '$2y$10$h.4LMwjngUwOTXdbDjT28OUNI8QG1TMe8clhkSt5vWde.W1x40LMO', 'E', 'A', NULL, '2024-04-05 07:49:49', '2024-05-17 15:35:32'),
(9, 'GAUTAM CHANDRA GHOSH', '7738160238', '', NULL, '50251', 'VICE PRESIDENT', 'MARKETING', 'HHC-ULTRA', '$2y$10$uz7TX6s133e4j6lu68lmRuYBw6JMeDHpzmefS8atKrSzWcJvTC3oy', 'AHY', 'A', NULL, '2024-04-05 07:51:04', '2024-04-05 09:21:22'),
(24, 'Sandeep Shastri', NULL, NULL, NULL, '10179', NULL, NULL, NULL, '$2y$10$SbXIxrELLmlNWRLBrkqKFubzCZlryv7HTfGOstiLtWXJ5roAVzndy', 'E', 'A', NULL, '2024-05-17 17:49:57', '2024-05-17 15:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_guide`
--

CREATE TABLE `user_guide` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `for_user` enum('E','AA','A','HR','ACA','ACH','AHY') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `memos`
--
ALTER TABLE `memos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_request`
--
ALTER TABLE `password_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_guide`
--
ALTER TABLE `user_guide`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `memos`
--
ALTER TABLE `memos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_request`
--
ALTER TABLE `password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_guide`
--
ALTER TABLE `user_guide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
