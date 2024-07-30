-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 09:06 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 8.0.11

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exepense_details`
--

INSERT INTO `exepense_details` (`id`, `user_id`, `expense_master_id`, `date`, `travelling_from`, `travelling_to`, `orvernight_at`, `days_total`, `days_approved`, `day_city_name`, `day_pupose`, `status`, `remark`, `approval_stage`, `is_admin_commented`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-04-17', 'kolkata', 'Delhi', NULL, '2150.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-04-21 08:12:03', '2023-04-24 06:14:32'),
(2, 1, 1, '2023-04-18', 'kolkata', 'Delhi', NULL, '100.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-04-21 08:36:49', '2023-04-21 08:36:50'),
(3, 1, 1, '2023-04-19', 'kolkata', 'mumbai', NULL, '100.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-04-21 08:38:28', '2023-04-21 08:38:35'),
(4, 1, 1, '2023-04-20', 'kolkata', 'Delhi', NULL, '450.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-04-21 08:55:04', '2023-04-21 08:55:17'),
(5, 1, 1, '2023-04-21', 'kolkata', 'Delhi', NULL, '3800.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-04-21 09:08:59', '2023-04-21 09:11:19'),
(6, 1, 2, '2023-01-01', 'kolkata', 'Delhi', NULL, '2015.50', '1965.50', NULL, NULL, 'S', 'srfgds', 'ADAS', 'N', '2023-04-24 07:57:42', '2023-06-28 00:58:05'),
(7, 12, 3, '2023-05-22', 'kolkata', 'Delhi', 'banaras', '3600.00', '3200.00', 'city name kolkata', 'purpose testing', 'A', NULL, 'ACH', 'N', '2023-05-23 00:10:17', '2023-07-13 08:15:14'),
(8, 12, 4, '2023-06-01', 'kolkata', 'Delhi', NULL, '1415.00', '0.00', NULL, NULL, 'D', NULL, 'NA', 'N', '2023-06-29 01:27:00', '2023-06-29 05:40:30'),
(9, 12, 5, '2023-07-01', 'kolkata', 'Delhi', 'banaras', '1700.00', '1550.00', NULL, NULL, 'A', NULL, 'ACHY', 'N', '2023-07-14 00:06:52', '2023-07-14 00:40:49'),
(10, 16, 6, '2023-07-24', 'kolkata', 'Delhi', NULL, '600.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', 'N', '2023-07-24 06:21:11', '2023-07-24 08:29:01'),
(11, 16, 7, '2023-07-17', 'kolkata', 'Delhi', NULL, '550.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', 'N', '2023-07-24 08:29:55', '2023-07-24 08:42:46'),
(12, 17, 8, '2023-07-24', 'howrah', 'srinagar', 'banaras', '550.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', 'N', '2023-07-26 23:52:09', '2023-07-27 00:54:53'),
(13, 17, 9, '2023-07-17', 'kolkata', 'Delhi', NULL, '2600.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', 'N', '2023-07-27 01:49:40', '2023-07-27 02:37:21'),
(14, 17, 10, '2023-07-10', 'kolkata', 'Delhi', NULL, '2700.00', '0.00', NULL, NULL, 'S', 'this is reject message', 'ADH', 'N', '2023-07-29 04:32:13', '2023-07-29 05:54:22'),
(15, 18, 11, '2023-07-17', 'kolkata', 'Delhi', NULL, '5250.00', '4950.00', NULL, NULL, 'A', 'on hold', 'ACHY', 'N', '2023-08-07 23:41:17', '2023-08-08 01:31:41'),
(16, 16, 12, '2023-08-02', 'kolkata', 'Chandigarh', 'Test', '550.00', '510.00', 'city name kolkata', 'purpose testing', 'S', 'rejected', 'ADH', 'Y', '2023-08-10 23:51:02', '2023-08-18 07:34:28'),
(17, 16, 13, '2023-08-07', 'Chennai', 'srinagar', NULL, '3900.00', '0.00', NULL, NULL, 'S', 'rejected 1234', 'ADAS', 'N', '2023-08-14 05:31:37', '2023-08-23 08:04:48'),
(18, 16, 12, '2023-08-01', 'Howrah', 'Delhi', 'abcd', '3810.00', '3710.00', NULL, NULL, 'S', 'rejected', 'ADH', 'Y', '2023-08-17 00:32:32', '2023-08-18 07:36:03'),
(19, 19, 14, '2023-08-14', 'srinagar', 'mumbai', 'abcd', '11940.00', '11590.00', NULL, NULL, 'R', 'zfsdg', 'ADAS', 'Y', '2023-08-21 05:16:07', '2023-08-21 06:39:02'),
(20, 20, 15, '2023-08-14', 'kolkata', 'Delhi', NULL, '9830.00', '9830.00', NULL, NULL, 'S', 'xdvsxdfg', 'ADAS', 'Y', '2023-08-22 03:03:06', '2023-08-22 05:22:49'),
(21, 20, 16, '2023-08-21', 'howrah', 'mumbai', NULL, '850.00', '0.00', NULL, NULL, 'A', NULL, 'ACH', 'Y', '2023-08-22 04:58:16', '2023-08-24 08:13:54'),
(22, 16, 13, '2023-08-08', 'sdf', 'sdfsd', NULL, '2100.00', '0.00', NULL, NULL, 'S', 'rejected 1234', 'ADAS', 'N', '2023-08-23 08:01:52', '2023-08-23 08:04:48'),
(23, 16, 17, '2023-04-03', 'kolkata', 'Delhi', NULL, '550.00', '0.00', NULL, NULL, 'A', NULL, 'ACH', 'Y', '2023-08-24 08:07:11', '2023-08-24 08:13:44');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense_items`
--

INSERT INTO `expense_items` (`id`, `expense_detail_id`, `type`, `basefare`, `gst_amount`, `total`, `gst_no`, `remark`, `hotel_name`, `hotel_city`, `approved_gst_amount`, `approved_amount`, `comment`, `item_false_id`, `taxi_option`, `misce_option`, `created_at`, `updated_at`) VALUES
(1, 1, 'L', '100.00', NULL, '100.00', NULL, NULL, 'laundry washer', 'kolkata', '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 08:12:03', '2023-04-21 08:12:03'),
(2, 1, 'B', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 08:12:20', '2023-04-21 08:12:20'),
(3, 2, 'L', '100.00', NULL, '100.00', NULL, NULL, 'laundry washer', 'kolkata', '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 08:36:49', '2023-04-21 08:36:49'),
(4, 3, 'L', '100.00', NULL, '100.00', NULL, NULL, 'laundry washer', 'kolkata', '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 08:38:28', '2023-04-21 08:38:35'),
(5, 4, 'R', '400.00', '50.00', '450.00', 'fghfg', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-04-21 08:55:04', '2023-04-21 08:55:17'),
(6, 5, 'R', '500.00', '50.00', '550.00', 'gst1', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-04-21 09:08:59', '2023-04-21 09:09:01'),
(7, 5, 'T', '500.00', '50.00', '550.00', 'taxi gst 1', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, 'O', NULL, '2023-04-21 09:09:12', '2023-04-21 09:10:33'),
(8, 5, 'H', '400.00', '100.00', '500.00', 'gfhf', NULL, 'hotel Name', 'delhi', '0.00', '0.00', NULL, 1, NULL, NULL, '2023-04-21 09:09:31', '2023-04-21 09:10:37'),
(9, 5, 'H', '400.00', '100.00', '500.00', 'gfhf', NULL, 'hotel Name', 'delhi', '0.00', '0.00', NULL, 2, NULL, NULL, '2023-04-21 09:09:52', '2023-04-21 09:10:37'),
(10, 5, 'B', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 09:10:03', '2023-04-21 09:10:39'),
(11, 5, 'D', '250.00', '0.00', '250.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 09:10:11', '2023-04-21 09:10:53'),
(12, 5, 'P', '150.00', NULL, '150.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 09:10:24', '2023-04-21 09:10:58'),
(13, 5, 'LU', '150.00', '0.00', '150.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-04-21 09:10:47', '2023-04-21 09:10:49'),
(14, 5, 'M', '500.00', '150.00', '650.00', 'abcd', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-04-21 09:11:13', '2023-04-21 09:11:19'),
(15, 1, 'R', '500.00', '50.00', '550.00', 'GRHH', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-04-24 03:03:42', '2023-04-24 03:03:42'),
(16, 1, 'M', '500.00', NULL, '500.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-04-24 06:05:11', '2023-04-24 06:14:31'),
(17, 1, 'M', '500.00', NULL, '500.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, 2, NULL, 'O', '2023-04-24 06:05:20', '2023-04-24 06:14:31'),
(18, 6, 'R', '400.00', '50.00', '450.00', 'FGHFG', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-04-24 07:57:43', '2023-06-16 07:52:39'),
(19, 6, 'R', '400.00', '50.50', '450.50', 'HG76', NULL, NULL, NULL, '0.00', '0.00', NULL, 2, NULL, NULL, '2023-04-24 07:58:06', '2023-06-16 07:52:39'),
(20, 6, 'T', '565.00', '50.00', '615.00', 'DJFH32', NULL, NULL, NULL, '0.00', '565.00', 'dfgdf', 1, 'O', NULL, '2023-04-24 07:58:26', '2023-06-28 00:58:05'),
(21, 7, 'R', '500.00', '50.00', '550.00', 'HG76', NULL, NULL, NULL, '0.00', '500.00', 'invalid gst', 1, NULL, NULL, '2023-05-23 00:10:17', '2023-05-23 00:21:56'),
(22, 7, 'T', '250.00', '50.00', '300.00', 'DJFH32', NULL, NULL, NULL, '30.00', '280.00', 'ok', 1, 'I', NULL, '2023-05-23 00:10:46', '2023-05-23 00:22:08'),
(23, 7, 'H', '800.00', '100.00', '900.00', '423HGYS', NULL, 'hotel Name', 'delhi', '50.00', '850.00', 'ok hotel', 1, NULL, NULL, '2023-05-23 00:11:34', '2023-05-23 00:22:36'),
(24, 7, 'L', '100.00', '50.00', '150.00', 'LAUNDRY GST', NULL, 'laundry washer', 'kolkata', '30.00', '130.00', 'ok laundry', NULL, NULL, NULL, '2023-05-23 00:14:08', '2023-05-23 00:22:54'),
(25, 7, 'B', '250.00', '0.00', '250.00', NULL, NULL, NULL, NULL, '0.00', '150.00', 'abc', NULL, NULL, NULL, '2023-05-23 00:14:34', '2023-05-23 00:29:18'),
(26, 7, 'LU', '150.00', '0.00', '150.00', NULL, NULL, NULL, NULL, '0.00', '130.00', 'iyho', NULL, NULL, NULL, '2023-05-23 00:14:50', '2023-05-23 00:28:27'),
(27, 7, 'D', '250.00', '0.00', '250.00', NULL, 'Dinner Remark', NULL, NULL, '0.00', '200.00', 'jh', NULL, NULL, NULL, '2023-05-23 00:15:01', '2023-05-23 00:27:03'),
(28, 7, 'P', '100.00', '50.00', '150.00', 'PHONE GST', NULL, NULL, NULL, '20.00', '120.00', 'ok phone', NULL, NULL, NULL, '2023-05-23 00:15:31', '2023-05-23 00:26:40'),
(29, 7, 'LC', '200.00', '50.00', '250.00', 'LOCAL GST', NULL, 'local name', 'delhi', '40.00', '240.00', 'ok local', NULL, NULL, NULL, '2023-05-23 00:15:55', '2023-05-23 00:23:20'),
(30, 7, 'M', '500.00', '150.00', '650.00', 'ABCD', NULL, NULL, NULL, '100.00', '600.00', 'ok\r\nmicse', 1, NULL, 'O', '2023-05-23 00:16:11', '2023-05-23 00:23:59'),
(31, 6, 'T', '500.00', NULL, '500.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 2, 'I', NULL, '2023-06-16 08:19:24', '2023-06-16 08:19:24'),
(32, 8, 'R', '500.00', '20.00', '520.00', 'FGHFG', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-06-29 01:27:00', '2023-06-29 01:27:00'),
(33, 8, 'M', '500.00', NULL, '500.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-06-29 01:27:24', '2023-06-29 05:40:30'),
(51, 8, 'M', '200.00', NULL, '200.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 5, NULL, 'O', '2023-06-29 05:40:06', '2023-06-29 05:40:30'),
(52, 8, 'M', '45.00', NULL, '45.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 6, NULL, 'O', '2023-06-29 05:40:21', '2023-06-29 05:40:30'),
(53, 8, 'M', '150.00', NULL, '150.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 7, NULL, 'O', '2023-06-29 05:40:30', '2023-06-29 05:40:30'),
(54, 9, 'R', '500.00', '100.00', '600.00', 'RAILGST', NULL, NULL, NULL, '50.00', '550.00', 'edrte', 1, NULL, NULL, '2023-07-14 00:06:52', '2023-07-14 00:11:58'),
(55, 9, 'T', '300.00', '50.00', '350.00', 'TAXI GST 1', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, 'O', NULL, '2023-07-14 00:07:04', '2023-07-14 00:07:04'),
(56, 9, 'B', '100.00', '0.00', '100.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-07-14 00:07:15', '2023-07-14 00:07:15'),
(57, 9, 'LU', '150.00', '0.00', '150.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-07-14 00:07:24', '2023-07-14 00:07:24'),
(58, 9, 'D', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '400.00', '400.00', 'sfrwef', NULL, NULL, NULL, '2023-07-14 00:07:32', '2023-07-14 00:10:00'),
(59, 10, 'R', '500.00', '100.00', '600.00', 'FGHFG', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-24 06:21:11', '2023-07-24 06:21:11'),
(60, 11, 'R', '400.00', '150.00', '550.00', 'HG76', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-24 08:29:55', '2023-07-24 08:29:55'),
(61, 12, 'R', '500.00', '50.00', '550.00', 'FGHFG', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-26 23:52:09', '2023-07-26 23:52:09'),
(62, 13, 'R', '2500.00', '100.00', '2600.00', 'RAILGST', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-27 01:49:40', '2023-07-27 01:49:40'),
(63, 14, 'R', '2500.00', '200.00', '2700.00', 'RAILGST', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-29 04:32:13', '2023-07-29 04:32:13'),
(64, 15, 'R', '2000.00', '300.00', '2300.00', 'FGHFG', NULL, NULL, NULL, '150.00', '2150.00', 'fghfd', 1, NULL, NULL, '2023-08-07 23:41:17', '2023-08-08 00:56:47'),
(65, 15, 'T', '650.00', NULL, '650.00', '', NULL, NULL, NULL, '0.00', '0.00', 'xfdhdfgh', 1, 'I', NULL, '2023-08-07 23:41:44', '2023-08-07 23:50:04'),
(66, 15, 'H', '2000.00', '300.00', '2300.00', '423HGY', NULL, 'hotel Name', 'delhi', '150.00', '2150.00', 'dhfthf', 1, NULL, NULL, '2023-08-07 23:42:41', '2023-08-07 23:48:40'),
(67, 16, 'R', '500.00', '50.00', '550.00', 'HG76', NULL, NULL, NULL, '10.00', '510.00', 'test comment', 1, NULL, NULL, '2023-08-10 23:51:02', '2023-08-18 07:34:09'),
(68, 17, 'R', '500.00', '100.00', '600.00', 'FGHFG', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-14 05:31:37', '2023-08-23 08:04:48'),
(69, 17, 'T', '500.00', '100.00', '600.00', 'TAXI GST 1', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, 'O', NULL, '2023-08-14 05:31:50', '2023-08-23 08:04:48'),
(70, 17, 'H', '400.00', '100.00', '500.00', 'GFHF', NULL, 'hotel Name', 'delhi', '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-14 06:01:24', '2023-08-23 08:04:48'),
(71, 17, 'L', '100.00', '50.00', '150.00', 'LAUNDRY GST', NULL, 'laundry washer', 'kolkata', '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:01:38', '2023-08-23 08:04:48'),
(72, 17, 'B', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:01:46', '2023-08-23 08:04:48'),
(73, 17, 'LU', '250.00', '0.00', '250.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:01:56', '2023-08-23 08:04:48'),
(74, 17, 'D', '250.00', '0.00', '250.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:02:03', '2023-08-23 08:04:48'),
(75, 17, 'P', '100.00', '50.00', '150.00', 'PHONE GST', NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:04:00', '2023-08-23 08:04:48'),
(76, 17, 'LC', '200.00', '50.00', '250.00', 'LOCAL GST', NULL, 'local name', 'delhi', '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-14 06:04:47', '2023-08-23 08:04:48'),
(77, 17, 'M', '500.00', '150.00', '650.00', 'ABCD', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-08-14 06:04:58', '2023-08-23 08:04:48'),
(78, 18, 'R', '500.00', '50.00', '550.00', 'FGHFG', NULL, NULL, NULL, '40.00', '540.00', 'dsgd', 1, NULL, NULL, '2023-08-17 00:32:32', '2023-08-17 00:48:41'),
(79, 18, 'T', '500.00', '50.00', '550.00', 'DJFH32', NULL, NULL, NULL, '40.00', '540.00', 'aefwef', 1, 'O', NULL, '2023-08-17 00:32:45', '2023-08-17 00:48:49'),
(80, 18, 'H', '400.00', '100.00', '500.00', '423HGY', NULL, 'hotel Name', 'delhi', '90.00', '490.00', 'hryhrth', 1, NULL, NULL, '2023-08-17 00:41:05', '2023-08-17 00:49:00'),
(81, 18, 'L', '100.00', '50.00', '150.00', 'LAUNDRY GST', NULL, 'laundry washer', 'kolkata', '40.00', '140.00', 'fjfgyjh', NULL, NULL, NULL, '2023-08-17 00:41:18', '2023-08-17 00:49:14'),
(82, 18, 'B', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '490.00', '490.00', 'ddhfgh', NULL, NULL, NULL, '2023-08-17 00:41:24', '2023-08-17 00:49:23'),
(83, 18, 'LU', '150.00', '0.00', '150.00', NULL, NULL, NULL, NULL, '140.00', '140.00', 'dfghdhdh', NULL, NULL, NULL, '2023-08-17 00:41:31', '2023-08-17 00:49:35'),
(84, 18, 'D', '500.00', '0.00', '500.00', NULL, NULL, NULL, NULL, '490.00', '490.00', 'dfgdfgd', NULL, NULL, NULL, '2023-08-17 00:41:38', '2023-08-17 00:49:45'),
(85, 18, 'P', '100.00', '50.00', '150.00', 'PHONE GST', NULL, NULL, NULL, '40.00', '140.00', 'dfhdh', NULL, NULL, NULL, '2023-08-17 00:41:47', '2023-08-18 07:14:52'),
(86, 18, 'LC', '200.00', '60.00', '260.00', 'LOCAL GST', NULL, 'local name', 'delhi', '40.00', '240.00', 'dsfgdh', NULL, NULL, NULL, '2023-08-17 00:42:02', '2023-08-18 07:36:02'),
(87, 18, 'M', '500.00', NULL, '500.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'F', '2023-08-17 00:42:29', '2023-08-17 00:55:04'),
(88, 19, 'R', '4500.00', '230.00', '4730.00', 'HG76', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-21 05:16:07', '2023-08-21 05:59:06'),
(89, 19, 'T', '350.00', '30.00', '380.00', 'DJFH32', NULL, NULL, NULL, '10.00', '360.00', 'standard', 1, 'O', NULL, '2023-08-21 05:16:30', '2023-08-21 06:38:38'),
(90, 19, 'H', '4500.00', '200.00', '4700.00', '423HGY', NULL, 'hotel Name', 'delhi', '100.00', '4600.00', 'standard', 1, NULL, NULL, '2023-08-21 05:16:59', '2023-08-21 06:25:47'),
(91, 19, 'LU', '580.00', '0.00', '580.00', NULL, NULL, NULL, NULL, '350.00', '350.00', 'dsfvds', NULL, NULL, NULL, '2023-08-21 05:17:15', '2023-08-21 05:58:01'),
(92, 19, 'D', '300.00', '0.00', '300.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-21 05:17:33', '2023-08-21 05:17:33'),
(94, 19, 'M', '1150.00', '100.00', '1250.00', 'ABCD', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-08-21 05:32:44', '2023-08-21 05:35:48'),
(102, 20, 'R', '4500.00', '200.00', '4700.00', 'RAILGST', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-22 03:03:06', '2023-08-22 03:03:40'),
(103, 20, 'T', '650.00', '30.00', '680.00', 'TAXI GST 1', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, 'O', NULL, '2023-08-22 03:04:00', '2023-08-22 03:04:00'),
(104, 20, 'H', '2500.00', '200.00', '2700.00', '423HGY', NULL, 'hotel Name', 'delhi', '200.00', '2700.00', 'gkjj', 1, NULL, NULL, '2023-08-22 03:04:21', '2023-08-22 05:22:49'),
(105, 20, 'LU', '400.00', '0.00', '400.00', NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, NULL, NULL, NULL, '2023-08-22 03:04:35', '2023-08-22 03:04:48'),
(106, 20, 'D', '350.00', '0.00', '350.00', NULL, NULL, NULL, NULL, '350.00', '350.00', 'jhfjhj', NULL, NULL, NULL, '2023-08-22 03:04:56', '2023-08-22 03:07:35'),
(107, 20, 'M', '1000.00', NULL, '1000.00', '', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, 'O', '2023-08-22 03:05:16', '2023-08-22 04:50:44'),
(108, 21, 'R', '500.00', '50.00', '550.00', 'HG76', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-22 04:58:16', '2023-08-22 04:58:16'),
(109, 21, 'T', '250.00', '50.00', '300.00', 'DJFH32', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, 'O', NULL, '2023-08-22 04:58:26', '2023-08-22 04:58:26'),
(110, 22, 'R', '2000.00', '100.00', '2100.00', 'RAILGST', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-23 08:01:52', '2023-08-23 08:04:48'),
(111, 23, 'R', '500.00', '50.00', '550.00', 'HG76', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-08-24 08:07:11', '2023-08-24 08:07:23');

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

--
-- Dumping data for table `expense_item_docs`
--

INSERT INTO `expense_item_docs` (`id`, `expense_item_id`, `doc_name`, `file_type`, `created_at`, `updated_at`) VALUES
(1, 1, '1682084523-3602.png', 'image', '2023-04-21 08:12:03', '2023-04-21 08:12:03'),
(2, 2, '1682084540-4120.png', 'image', '2023-04-21 08:12:21', '2023-04-21 08:12:21'),
(3, 3, '1682086009-1819.png', 'image', '2023-04-21 08:36:50', '2023-04-21 08:36:50'),
(4, 4, '1682086108-9144.png', 'image', '2023-04-21 08:38:28', '2023-04-21 08:38:28'),
(5, 5, '1682087104-9173.png', 'image', '2023-04-21 08:55:05', '2023-04-21 08:55:05'),
(6, 6, '1682087939-6608.png', 'image', '2023-04-21 09:08:59', '2023-04-21 09:08:59'),
(7, 7, '1682087952-6836.png', 'image', '2023-04-21 09:09:12', '2023-04-21 09:09:12'),
(8, 8, '1682087971-4755.png', 'image', '2023-04-21 09:09:31', '2023-04-21 09:09:31'),
(9, 9, '1682087992-1903.png', 'image', '2023-04-21 09:09:52', '2023-04-21 09:09:52'),
(10, 10, '1682088003-4137.png', 'image', '2023-04-21 09:10:03', '2023-04-21 09:10:03'),
(11, 11, '1682088011-2335.png', 'image', '2023-04-21 09:10:11', '2023-04-21 09:10:11'),
(12, 12, '1682088024-2450.png', 'image', '2023-04-21 09:10:24', '2023-04-21 09:10:24'),
(13, 13, '1682088047-5885.png', 'image', '2023-04-21 09:10:47', '2023-04-21 09:10:47'),
(14, 14, '1682088073-4731.png', 'image', '2023-04-21 09:11:13', '2023-04-21 09:11:13'),
(15, 15, '1682325222-2048.png', 'image', '2023-04-24 03:03:44', '2023-04-24 03:03:44'),
(16, 16, '1682336111-8801.png', 'image', '2023-04-24 06:05:12', '2023-04-24 06:05:12'),
(17, 17, '1682336671-8870.png', 'image', '2023-04-24 06:14:32', '2023-04-24 06:14:32'),
(18, 18, '1682342863-4047.png', 'image', '2023-04-24 07:57:44', '2023-04-24 07:57:44'),
(19, 19, '1682342886-9073.png', 'image', '2023-04-24 07:58:06', '2023-04-24 07:58:06'),
(20, 20, '1682342906-7130.png', 'image', '2023-04-24 07:58:26', '2023-04-24 07:58:26'),
(21, 21, '1684820417-4603.png', 'image', '2023-05-23 00:10:18', '2023-05-23 00:10:18'),
(22, 22, '1684820446-8354.png', 'image', '2023-05-23 00:10:46', '2023-05-23 00:10:46'),
(23, 23, '1684820494-3365.png', 'image', '2023-05-23 00:11:34', '2023-05-23 00:11:34'),
(24, 24, '1684820648-5990.png', 'image', '2023-05-23 00:14:09', '2023-05-23 00:14:09'),
(25, 25, '1684820674-3536.png', 'image', '2023-05-23 00:14:34', '2023-05-23 00:14:34'),
(26, 26, '1684820690-1157.png', 'image', '2023-05-23 00:14:51', '2023-05-23 00:14:51'),
(27, 27, '1684820701-7849.png', 'image', '2023-05-23 00:15:01', '2023-05-23 00:15:01'),
(28, 28, '1684820731-9846.png', 'image', '2023-05-23 00:15:31', '2023-05-23 00:15:31'),
(29, 29, '1684820755-4969.png', 'image', '2023-05-23 00:15:55', '2023-05-23 00:15:55'),
(30, 30, '1684820771-1268.png', 'image', '2023-05-23 00:16:11', '2023-05-23 00:16:11'),
(31, 31, '1686923364-4340.png', 'image', '2023-06-16 08:19:26', '2023-06-16 08:19:26'),
(32, 32, '1688021820-9575.png', 'image', '2023-06-29 01:27:01', '2023-06-29 01:27:01'),
(33, 33, '1688021844-1260.png', 'image', '2023-06-29 01:27:24', '2023-06-29 01:27:24'),
(51, 51, '1688037006-4448.png', 'image', '2023-06-29 05:40:06', '2023-06-29 05:40:06'),
(52, 52, '1688037021-5575.png', 'image', '2023-06-29 05:40:21', '2023-06-29 05:40:21'),
(53, 53, '1688037030-5885.png', 'image', '2023-06-29 05:40:30', '2023-06-29 05:40:30'),
(54, 54, '1689313012-4520.png', 'image', '2023-07-14 00:06:52', '2023-07-14 00:06:52'),
(55, 55, '1689313024-8809.png', 'image', '2023-07-14 00:07:04', '2023-07-14 00:07:04'),
(56, 56, '1689313035-5383.png', 'image', '2023-07-14 00:07:15', '2023-07-14 00:07:15'),
(57, 57, '1689313044-9315.png', 'image', '2023-07-14 00:07:24', '2023-07-14 00:07:24'),
(58, 58, '1689313052-8908.png', 'image', '2023-07-14 00:07:32', '2023-07-14 00:07:32'),
(59, 59, '1690199471-8740.png', 'image', '2023-07-24 06:21:13', '2023-07-24 06:21:13'),
(60, 60, '1690207195-9749.png', 'image', '2023-07-24 08:29:56', '2023-07-24 08:29:56'),
(61, 61, '1690435329-1728.png', 'image', '2023-07-26 23:52:10', '2023-07-26 23:52:10'),
(62, 62, '1690442380-9630.png', 'image', '2023-07-27 01:49:41', '2023-07-27 01:49:41'),
(63, 63, '1690624934-2109.png', 'image', '2023-07-29 04:32:15', '2023-07-29 04:32:15'),
(64, 64, '1691471477-9009.png', 'image', '2023-08-07 23:41:19', '2023-08-07 23:41:19'),
(65, 65, '1691471504-4212.png', 'image', '2023-08-07 23:41:44', '2023-08-07 23:41:44'),
(66, 66, '1691471561-7413.png', 'image', '2023-08-07 23:42:41', '2023-08-07 23:42:41'),
(67, 67, '1691731262-4941.jpg', 'image', '2023-08-10 23:51:03', '2023-08-10 23:51:03'),
(68, 68, '1692010897-2307.png', 'image', '2023-08-14 05:31:38', '2023-08-14 05:31:38'),
(69, 69, '1692010910-6751.png', 'image', '2023-08-14 05:31:50', '2023-08-14 05:31:50'),
(70, 70, '1692012684-2862.png', 'image', '2023-08-14 06:01:24', '2023-08-14 06:01:24'),
(71, 71, '1692012698-7742.png', 'image', '2023-08-14 06:01:38', '2023-08-14 06:01:38'),
(72, 72, '1692012706-6412.png', 'image', '2023-08-14 06:01:46', '2023-08-14 06:01:46'),
(73, 73, '1692012716-7516.png', 'image', '2023-08-14 06:01:56', '2023-08-14 06:01:56'),
(74, 74, '1692012723-9860.png', 'image', '2023-08-14 06:02:03', '2023-08-14 06:02:03'),
(75, 75, '1692012840-3128.png', 'image', '2023-08-14 06:04:00', '2023-08-14 06:04:00'),
(76, 76, '1692012887-9612.png', 'image', '2023-08-14 06:04:47', '2023-08-14 06:04:47'),
(77, 77, '1692012898-6552.png', 'image', '2023-08-14 06:04:58', '2023-08-14 06:04:58'),
(78, 78, '1692252153-9379.png', 'image', '2023-08-17 00:32:35', '2023-08-17 00:32:35'),
(79, 79, '1692252165-5740.png', 'image', '2023-08-17 00:32:45', '2023-08-17 00:32:45'),
(80, 80, '1692252665-8097.png', 'image', '2023-08-17 00:41:05', '2023-08-17 00:41:05'),
(81, 81, '1692252678-2101.png', 'image', '2023-08-17 00:41:18', '2023-08-17 00:41:18'),
(82, 82, '1692252684-6085.png', 'image', '2023-08-17 00:41:24', '2023-08-17 00:41:24'),
(83, 83, '1692252691-9260.png', 'image', '2023-08-17 00:41:31', '2023-08-17 00:41:31'),
(84, 84, '1692252698-5114.png', 'image', '2023-08-17 00:41:39', '2023-08-17 00:41:39'),
(85, 85, '1692252707-3337.png', 'image', '2023-08-17 00:41:47', '2023-08-17 00:41:47'),
(86, 86, '1692252722-3995.png', 'image', '2023-08-17 00:42:02', '2023-08-17 00:42:02'),
(87, 87, '1692252749-7258.png', 'image', '2023-08-17 00:42:29', '2023-08-17 00:42:29'),
(88, 88, '1692614767-2974.png', 'image', '2023-08-21 05:16:08', '2023-08-21 05:16:08'),
(89, 89, '1692614790-5757.png', 'image', '2023-08-21 05:16:30', '2023-08-21 05:16:30'),
(90, 90, '1692614819-5632.png', 'image', '2023-08-21 05:16:59', '2023-08-21 05:16:59'),
(91, 91, '1692614835-2824.png', 'image', '2023-08-21 05:17:15', '2023-08-21 05:17:15'),
(92, 92, '1692614853-6763.png', 'image', '2023-08-21 05:17:33', '2023-08-21 05:17:33'),
(93, 93, '1692614881-1057.png', 'image', '2023-08-21 05:18:01', '2023-08-21 05:18:01'),
(94, 94, '1692615764-6627.png', 'image', '2023-08-21 05:32:44', '2023-08-21 05:32:44'),
(102, 102, '1692693187-5525.png', 'image', '2023-08-22 03:03:09', '2023-08-22 03:03:09'),
(103, 103, '1692693240-4066.png', 'image', '2023-08-22 03:04:00', '2023-08-22 03:04:00'),
(104, 104, '1692693261-7634.png', 'image', '2023-08-22 03:04:21', '2023-08-22 03:04:21'),
(105, 105, '1692693275-6590.png', 'image', '2023-08-22 03:04:35', '2023-08-22 03:04:35'),
(106, 106, '1692693296-6939.png', 'image', '2023-08-22 03:04:56', '2023-08-22 03:04:56'),
(107, 107, '1692693316-4698.png', 'image', '2023-08-22 03:05:16', '2023-08-22 03:05:16'),
(108, 108, '1692700096-6998.png', 'image', '2023-08-22 04:58:18', '2023-08-22 04:58:18'),
(109, 109, '1692700106-4987.png', 'image', '2023-08-22 04:58:26', '2023-08-22 04:58:26'),
(110, 110, '1692797512-3883.png', 'image', '2023-08-23 08:01:54', '2023-08-23 08:01:54'),
(111, 111, '1692884231-4358.png', 'image', '2023-08-24 08:07:13', '2023-08-24 08:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `expense_master`
--

CREATE TABLE `expense_master` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expense_unique_code` varchar(255) DEFAULT NULL,
  `type` enum('WE') DEFAULT NULL COMMENT '''WE''= weekly expense',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense_master`
--

INSERT INTO `expense_master` (`id`, `user_id`, `expense_unique_code`, `type`, `start_date`, `end_date`, `claimed_total`, `approved_total`, `status`, `approval_stage`, `rejected_by`, `is_editable`, `created_at`, `updated_at`) VALUES
(1, 1, 'WE1-1682084523', 'WE', '2023-04-17', '2023-04-21', '6600.00', '0.00', 'D', 'NA', NULL, NULL, '2023-04-21 08:12:03', '2023-04-24 06:14:33'),
(2, 1, 'WE1-1686922854', 'WE', '2023-01-01', '2023-01-01', '2015.50', '1965.50', 'S', 'ADAS', 'ADAS', NULL, '2023-04-24 07:57:42', '2023-06-28 00:58:05'),
(3, 12, 'WE1-1684820854', 'WE', '2023-05-22', '2023-05-23', '3600.00', '3200.00', 'A', 'ACH', NULL, NULL, '2023-05-23 00:10:17', '2023-07-13 08:15:14'),
(4, 12, NULL, 'WE', '2023-06-01', '2023-06-04', '1415.00', '0.00', 'D', 'NA', NULL, NULL, '2023-06-29 01:27:00', '2023-06-29 05:40:30'),
(5, 12, 'WE12-1689313102', 'WE', '2023-07-01', '2023-07-02', '1700.00', '1550.00', 'A', 'ACHY', NULL, NULL, '2023-07-14 00:06:52', '2023-07-14 00:40:49'),
(6, 16, 'WE16-1690199478', 'WE', '2023-07-24', '2023-07-24', '600.00', '0.00', 'A', 'ACHY', NULL, NULL, '2023-07-24 06:21:11', '2023-07-24 08:29:01'),
(7, 16, 'WE16-1690207199', 'WE', '2023-07-17', '2023-07-23', '550.00', '0.00', 'A', 'ACHY', NULL, NULL, '2023-07-24 08:29:55', '2023-07-24 08:42:46'),
(8, 17, 'WE17-1690435337', 'WE', '2023-07-24', '2023-07-27', '550.00', '0.00', 'A', 'ACHY', NULL, NULL, '2023-07-26 23:52:09', '2023-07-27 00:54:53'),
(9, 17, 'WE17-1690442446', 'WE', '2023-07-17', '2023-07-23', '2600.00', '0.00', 'A', 'ACHY', NULL, NULL, '2023-07-27 01:49:40', '2023-07-27 02:37:21'),
(10, 17, 'WE17-1690624939', 'WE', '2023-07-10', '2023-07-16', '2700.00', '0.00', 'S', 'ADH', 'ACHY', NULL, '2023-07-29 04:32:13', '2023-07-29 05:54:22'),
(11, 18, 'WE18-1691471666', 'WE', '2023-07-17', '2023-07-23', '5250.00', '4950.00', 'A', 'ACHY', 'ACHY', 'N', '2023-08-07 23:41:17', '2023-08-08 01:31:41'),
(12, 16, 'WE16-1691731269', 'WE', '2023-08-01', '2023-08-06', '4360.00', '4220.00', 'S', 'ADH', 'ADH', 'Y', '2023-08-10 23:51:02', '2023-08-18 07:36:03'),
(13, 16, 'WE16-1692010913', 'WE', '2023-08-07', '2023-08-13', '6000.00', '0.00', 'S', 'ADAS', 'ADAS', 'Y', '2023-08-14 05:31:36', '2023-08-23 08:04:48'),
(14, 19, 'WE19-1692614893', 'WE', '2023-08-14', '2023-08-20', '11940.00', '11590.00', 'R', 'ADAS', 'ADAS', 'Y', '2023-08-21 05:16:07', '2023-08-21 06:39:02'),
(15, 20, 'WE20-1692693348', 'WE', '2023-08-14', '2023-08-20', '9830.00', '9830.00', 'S', 'ADAS', 'ADAS', 'Y', '2023-08-22 03:03:05', '2023-08-22 05:22:49'),
(16, 20, 'WE20-1692700112', 'WE', '2023-08-21', '2023-08-22', '850.00', '0.00', 'A', 'ACH', NULL, 'Y', '2023-08-22 04:58:16', '2023-08-24 08:13:54'),
(17, 16, 'WE16-1692884242', 'WE', '2023-04-03', '2023-04-09', '550.00', '0.00', 'A', 'ACH', NULL, 'Y', '2023-08-24 08:07:11', '2023-08-24 08:13:44');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `memos`
--

INSERT INTO `memos` (`id`, `expense_master_id`, `signature`, `remark`, `transaction_id`, `transaction_receipt`, `transaction_remark`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark Memo Remark ', 'TTETTE23232', '1682755124-6678.png', 'Receipt  Remark', 'C', '2023-04-26 07:26:17', '2023-04-29 02:28:44'),
(4, 3, NULL, 'sefsdf', 'TODAYTRANS001', '1689312158-7042.png', 'testing remark', 'C', '2023-07-13 08:54:59', '2023-07-13 23:52:40'),
(5, 5, NULL, 'test remark', 'TODAYTRANS001', '1689315048-1362.png', 'drgd', NULL, '2023-07-14 00:32:09', '2023-07-14 00:40:49'),
(6, 6, NULL, 'test remark', 'TODAYTRANS001', '1690207141-3715.png', 'sftgefg', 'C', '2023-07-24 06:26:45', '2023-07-24 08:29:01'),
(7, 7, NULL, 'sdfgsdfgds', 'TODAYTRANS001', '1690207966-6539.png', 'testing remark', 'C', '2023-07-24 08:34:56', '2023-07-24 08:42:46'),
(8, 8, NULL, 'this is remark', 'TODAYTRANS001', '1690439093-9463.png', 'testing remark', 'C', '2023-07-27 00:17:58', '2023-07-27 00:54:53'),
(9, 9, NULL, 'test', 'TODAYTRANS001', '1690445240-2163.png', 'testing remark', 'C', '2023-07-27 01:56:02', '2023-07-27 02:37:21'),
(10, 10, NULL, 'this s remark', NULL, NULL, NULL, 'R', '2023-07-29 04:38:24', '2023-07-29 05:24:38'),
(11, 11, NULL, 'this is remark', 'TODAYTRANS001', '1691478100-5876.png', 'testing remark', 'C', '2023-08-08 01:15:49', '2023-08-08 01:31:41'),
(12, 12, NULL, 'this is generate memeo', NULL, NULL, NULL, 'R', '2023-08-11 02:02:14', '2023-08-11 02:23:08');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_request`
--

INSERT INTO `password_request` (`id`, `name`, `user_type`, `user_id`, `status`, `request_type`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Employee One', NULL, 1, 'N', 'NP', NULL, '2023-04-19 07:22:18', '2023-04-19 07:22:18'),
(2, 'Employee One', NULL, 1, 'N', 'FP', NULL, '2023-04-20 07:20:12', '2023-04-20 07:20:12'),
(3, 'Employee One', NULL, 1, 'N', 'FP', NULL, '2023-04-20 07:21:00', '2023-04-20 07:21:00'),
(4, 'Employee One', NULL, 1, 'A', 'NP', '8ogGcHb3', '2023-04-20 07:21:40', '2023-06-16 06:51:08'),
(5, 'ANUJ DEWANI', NULL, 8, 'N', 'NP', NULL, '2023-08-16 23:30:50', '2023-08-16 23:30:50');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `file_name`, `for_user`, `created_at`, `updated_at`) VALUES
(1, '1680252293-2047.pdf', 'E', '2023-03-31 03:14:53', '2023-03-31 03:14:53'),
(2, '1680253631-2368.pdf', 'E', '2023-03-31 03:37:12', '2023-03-31 03:37:12'),
(3, '1680253632-5400.pdf', 'E', '2023-03-31 03:37:12', '2023-03-31 03:37:12'),
(6, '1680257244-8547.pdf', 'HR', '2023-03-31 04:37:24', '2023-03-31 04:37:24'),
(7, '1680257244-2772.pdf', 'HR', '2023-03-31 04:37:24', '2023-03-31 04:37:24'),
(8, '1680257244-6595.pdf', 'HR', '2023-03-31 04:37:24', '2023-03-31 04:37:24'),
(9, '1680257244-5711.pdf', 'HR', '2023-03-31 04:37:24', '2023-03-31 04:37:24'),
(10, '1680257418-1444.pdf', 'ACA', '2023-03-31 04:40:18', '2023-03-31 04:40:18'),
(11, '1680257418-9775.pdf', 'ACA', '2023-03-31 04:40:18', '2023-03-31 04:40:18'),
(12, '1680257419-3479.pdf', 'ACA', '2023-03-31 04:40:19', '2023-03-31 04:40:19'),
(13, '1680257436-1794.pdf', 'ACH', '2023-03-31 04:40:36', '2023-03-31 04:40:36'),
(14, '1680257436-9804.pdf', 'ACH', '2023-03-31 04:40:36', '2023-03-31 04:40:36'),
(15, '1680257448-9314.pdf', 'AHY', '2023-03-31 04:40:48', '2023-03-31 04:40:48'),
(16, '1680257448-8327.pdf', 'AHY', '2023-03-31 04:40:48', '2023-03-31 04:40:48'),
(18, '1683965079-2576.pdf', 'AHY', '2023-05-13 02:34:39', '2023-05-13 02:34:39'),
(19, '1683969239-8023.pdf', 'E', '2023-05-13 03:44:00', '2023-05-13 03:44:00'),
(20, 'testpdf', 'E', '2023-05-22 08:52:01', '2023-05-22 08:52:01'),
(21, 'TESTING.pdf', 'E', '2023-05-22 08:53:30', '2023-05-22 08:53:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`id`, `user_id`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, 'sdfgdfsgdfsgd', '2023-03-31 06:20:09', '2023-03-31 06:20:09'),
(2, 1, 'dfgdfg', '2023-03-31 06:20:26', '2023-03-31 06:20:26'),
(3, 3, 'sfgsdf', '2023-03-31 06:20:58', '2023-03-31 06:20:58'),
(4, 1, 'fdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o  fdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o fdsfd b sdpoh sdf psdhf s dspodsfdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o fdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o ; vpsov  ods[hs [o fdsfd b sdpoh sdf psdhf s dfdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o spods; vpsov  ods[hs [o fdsfd b sdpoh sdf psdhf s dspods; vpsov  ods[hs [o fdsfd fdsfd b sdpoh sdf psdhf s dspods;f s dspods; v', '2023-05-13 05:37:25', '2023-05-13 05:37:25');

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
  `user_type` enum('E','AA','A','HR','ACA','ACH','AHY') DEFAULT NULL COMMENT '''E''=>Employee,\r\n''AA''=>Admin Assistance,\r\n''A''=>Admin,\r\n''HR''=>HR,\r\n''ACA''=>Acc Asst,\r\n''ACH''=>Acc Head,\r\n''AHY''=>Acc Hyd',
  `status` enum('A','I') DEFAULT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `pro_email`, `slug`, `empID`, `designation`, `department`, `division`, `password`, `user_type`, `status`, `signature_image`, `created_at`, `updated_at`) VALUES
(1, 'Employee One', '1234567890', NULL, NULL, 'employee1', 'TECHNICAL LEAD', 'INFORMATION TECHNOLOGY', 'HHC - CORPORATE', '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'E', 'A', NULL, '2023-03-21 14:33:05', '2023-03-21 14:33:05'),
(2, 'Admin Assistant', '1234567890', NULL, NULL, 'adminassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AA', 'A', NULL, '2023-03-22 07:40:03', '2023-03-22 07:40:03'),
(3, 'Admin', '12121212121', NULL, NULL, 'admin', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'A', 'A', '1684994069-2884.png', '2023-03-22 07:40:03', '2023-05-25 05:54:29'),
(4, 'HR', '112121212', NULL, NULL, 'hr', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'HR', 'A', NULL, '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(5, 'Account Assistant', NULL, NULL, NULL, 'accountassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACA', 'A', NULL, '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(6, 'Account Head', '565656', NULL, NULL, 'accounthead', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACH', 'A', NULL, '2023-03-22 14:10:54', '2023-03-22 14:10:54'),
(7, 'Account Hyd', NULL, NULL, NULL, 'accounthyd', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AHY', 'A', NULL, '2023-03-22 14:10:54', '2023-03-22 14:10:54'),
(8, 'ANUJ DEWANI', '7744066526', '', NULL, '110631', 'NATIONAL SALES MANAGER', 'SALES', 'HHC - MAIN', '$2y$10$lK.zpXA/pkfE97jggMkmH.K3foQ/OuS7TwLzQ6p6zGyHudnGs8ZMC', 'E', 'A', NULL, '2023-03-30 06:19:54', '2023-08-17 05:13:20'),
(9, 'GAUTAM CHANDRA GHOSH', '7738160238', '', NULL, '50251', 'VICE PRESIDENT', 'MARKETING', 'HHC-ULTRA', '$2y$10$4LfJgRN9fSVbAD25BEwTHumhtgX.hIn9.RxHVb6/N2DOwVbBX56Ti', 'AHY', 'A', NULL, '2023-03-30 06:28:56', '2023-08-24 13:44:23'),
(10, 'PRANAY PRABHAKAR PATIL', '8390822259', '', NULL, '50202', 'OFFICER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$sYidt2XwqIn4PSRauoSbyeV7KlIoFfV7igAMimyQH7YsyE6a9s3dO', 'AA', 'A', NULL, '2023-06-27 12:04:18', '2023-08-24 13:37:48'),
(11, 'RAVINDRA BABA KOKATE', '9860081917', 'ravindra.k@heterohealthcare.com', NULL, '10327', 'ASSISTANT MANAGER', 'ACCOUNTS', 'HHC - MUM - CORPORATE', '$2y$10$xeoiNRs47dIlzWFNcjCPlOkDgmxWpacuaD03ZjHqPJeu27urBdEha', 'ACH', 'A', NULL, '2023-06-27 12:20:36', '2023-08-24 13:43:23'),
(12, 'K M V PRASAD REDDY', '9948686111', NULL, NULL, '106892', 'SENIOR VICE PRESIDENT', 'SALES', 'HHC - ONCOLOGY', '$2y$10$k.tqER3c3uCTlmXZD.oyPuPp3mCXj5iorWlNbQVBuh860eQET0cZa', 'E', 'A', NULL, '2023-06-29 06:55:45', '2023-07-14 04:51:00'),
(13, 'SAMEER D DESHPANDE', '9869737985', 'sameer@heterohealthcare.com', NULL, '20113', 'SENIOR MANAGER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$58XaPytxssdcxmuxdBAWZe99coguLn3FLG/XZYfy3EiMiU6JW.P9m', 'A', 'A', NULL, '2023-07-13 13:53:55', '2023-08-24 13:33:18'),
(14, 'MANOJ B PATIL', '9322032091', 'manoj@heterohealthcare.com', NULL, '10183', 'GENERAL MANAGER', 'PERSONEL & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$W3nOeffM.uyBzEKF34xl9ukdVJbKCV9k242wUa3MxsqrqjXexghQG', 'HR', 'A', NULL, '2023-07-14 05:40:39', '2023-08-24 13:42:10'),
(15, 'NISHAD ANIL PATIL', '8806777006', '', NULL, '50184', 'OFFICER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$qrKY.B/tVv4A1LrOjiz9mOqeCiybLt2DOO3xnCDtsxlSVjhkc/Eum', 'ACA', 'A', NULL, '2023-07-14 05:42:22', '2023-08-24 13:42:48'),
(16, 'VILAS S PAWALE', '9373203439', 'vilaspawale@yahoo.co.in', NULL, '206225', 'SALES MANAGER', 'SALES', 'HHC - MAIN', '$2y$10$TthHVPndYdH.bs677mSyIurhnv8/bIX1hQWfNCEn5Gs0THCjSvgOW', 'E', 'A', NULL, '2023-07-24 11:50:14', '2023-08-24 13:36:21'),
(17, 'PRADEEP KUMAR', '7840041778', NULL, NULL, '111319', 'DEPUTY DIVISIONAL MANAGER', 'SALES', 'HHC-AURA', '$2y$10$/TSgB8OXEu9oiIUnrYduy.1cXLTOE31plukbWu7b5r2R9UIiq0KjW', 'E', 'A', NULL, '2023-07-27 05:20:42', '2023-08-07 13:32:03'),
(18, 'DATTATRAYA S DHARURKAR', '2402452896', NULL, NULL, '301695', 'DEPUTY GENERAL MANAGER', 'SALES', 'HHC - KRIS', '$2y$10$Uc6vCNjOttfTKueeVQz.DOiHezuTsV.tk0IFga.6ILkiR.Q8I8w9u', 'E', 'A', NULL, '2023-08-08 05:08:29', '2023-08-08 05:08:29'),
(19, 'NANDLAL S YADAV', '9320426800', 'nandlal.s@heterohealthcare.com', NULL, '103576', 'DIVISIONAL MANAGER', 'SALES', 'HHC - MAIN', '$2y$10$KwCytoeZPJ4WXWzQxY1hdO5ZYdEi25amTW3VV6SDhe.wOXLnxRVoO', 'E', 'A', NULL, '2023-08-21 10:44:48', '2023-08-21 10:44:48'),
(20, 'YAGNA BHASKAR SARMA M', '9573754326', '', NULL, '303693', 'SALES MANAGER', 'SALES', 'HHC - KRIS', '$2y$10$nmIUciL2Jq7RZgkQqE5I3eE/0.CxZj7pi6mdClDW5LgiAodyXMaVO', 'E', 'A', NULL, '2023-08-22 06:20:44', '2023-08-22 06:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `users_old`
--

CREATE TABLE `users_old` (
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
-- Dumping data for table `users_old`
--

INSERT INTO `users_old` (`id`, `name`, `mobile`, `slug`, `empID`, `designation`, `department`, `division`, `password`, `user_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Employee One', '1234567890', NULL, 'employee1', 'TECHNICAL LEAD', 'INFORMATION TECHNOLOGY', 'HHC - CORPORATE', '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'E', NULL, '2023-03-21 14:33:05', '2023-03-21 14:33:05');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_guide`
--

INSERT INTO `user_guide` (`id`, `file_name`, `for_user`, `created_at`, `updated_at`) VALUES
(3, '1683971988-8164.pdf', 'HR', '2023-05-13 04:29:48', '2023-05-13 04:29:48'),
(4, '1683972670-4350.pdf', 'E', '2023-05-13 04:41:10', '2023-05-13 04:41:10'),
(6, '1683972683-1771.pdf', 'ACA', '2023-05-13 04:41:23', '2023-05-13 04:41:23');

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
-- Indexes for table `users_old`
--
ALTER TABLE `users_old`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `expense_item_docs`
--
ALTER TABLE `expense_item_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `expense_master`
--
ALTER TABLE `expense_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `memos`
--
ALTER TABLE `memos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `password_request`
--
ALTER TABLE `password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users_old`
--
ALTER TABLE `users_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_guide`
--
ALTER TABLE `user_guide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
