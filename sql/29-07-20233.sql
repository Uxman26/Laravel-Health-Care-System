-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2023 at 03:06 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exepense_details`
--

INSERT INTO `exepense_details` (`id`, `user_id`, `expense_master_id`, `date`, `travelling_from`, `travelling_to`, `orvernight_at`, `days_total`, `days_approved`, `day_city_name`, `day_pupose`, `status`, `remark`, `approval_stage`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-04-17', 'kolkata', 'Delhi', NULL, '2150.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-04-21 08:12:03', '2023-04-24 06:14:32'),
(2, 1, 1, '2023-04-18', 'kolkata', 'Delhi', NULL, '100.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-04-21 08:36:49', '2023-04-21 08:36:50'),
(3, 1, 1, '2023-04-19', 'kolkata', 'mumbai', NULL, '100.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-04-21 08:38:28', '2023-04-21 08:38:35'),
(4, 1, 1, '2023-04-20', 'kolkata', 'Delhi', NULL, '450.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-04-21 08:55:04', '2023-04-21 08:55:17'),
(5, 1, 1, '2023-04-21', 'kolkata', 'Delhi', NULL, '3800.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-04-21 09:08:59', '2023-04-21 09:11:19'),
(6, 1, 2, '2023-01-01', 'kolkata', 'Delhi', NULL, '2015.50', '1965.50', NULL, NULL, 'S', 'srfgds', 'ADAS', '2023-04-24 07:57:42', '2023-06-28 00:58:05'),
(7, 12, 3, '2023-05-22', 'kolkata', 'Delhi', 'banaras', '3600.00', '3200.00', 'city name kolkata', 'purpose testing', 'A', NULL, 'ACH', '2023-05-23 00:10:17', '2023-07-13 08:15:14'),
(8, 12, 4, '2023-06-01', 'kolkata', 'Delhi', NULL, '1415.00', '0.00', NULL, NULL, 'D', NULL, 'NA', '2023-06-29 01:27:00', '2023-06-29 05:40:30'),
(9, 12, 5, '2023-07-01', 'kolkata', 'Delhi', 'banaras', '1700.00', '1550.00', NULL, NULL, 'A', NULL, 'ACHY', '2023-07-14 00:06:52', '2023-07-14 00:40:49'),
(10, 16, 6, '2023-07-24', 'kolkata', 'Delhi', NULL, '600.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', '2023-07-24 06:21:11', '2023-07-24 08:29:01'),
(11, 16, 7, '2023-07-17', 'kolkata', 'Delhi', NULL, '550.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', '2023-07-24 08:29:55', '2023-07-24 08:42:46'),
(12, 17, 8, '2023-07-24', 'howrah', 'srinagar', 'banaras', '550.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', '2023-07-26 23:52:09', '2023-07-27 00:54:53'),
(13, 17, 9, '2023-07-17', 'kolkata', 'Delhi', NULL, '2600.00', '0.00', NULL, NULL, 'A', NULL, 'ACHY', '2023-07-27 01:49:40', '2023-07-27 02:37:21'),
(14, 17, 10, '2023-07-10', 'kolkata', 'Delhi', NULL, '2700.00', '0.00', NULL, NULL, 'S', 'this is reject message', 'ADH', '2023-07-29 04:32:13', '2023-07-29 05:54:22');

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
(63, 14, 'R', '2500.00', '200.00', '2700.00', 'RAILGST', NULL, NULL, NULL, '0.00', '0.00', NULL, 1, NULL, NULL, '2023-07-29 04:32:13', '2023-07-29 04:32:13');

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
(63, 63, '1690624934-2109.png', 'image', '2023-07-29 04:32:15', '2023-07-29 04:32:15');

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
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense_master`
--

INSERT INTO `expense_master` (`id`, `user_id`, `expense_unique_code`, `type`, `start_date`, `end_date`, `claimed_total`, `approved_total`, `status`, `approval_stage`, `rejected_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'WE1-1682084523', 'WE', '2023-04-17', '2023-04-21', '6600.00', '0.00', 'D', 'NA', NULL, '2023-04-21 08:12:03', '2023-04-24 06:14:33'),
(2, 1, 'WE1-1686922854', 'WE', '2023-01-01', '2023-01-01', '2015.50', '1965.50', 'S', 'ADAS', 'ADAS', '2023-04-24 07:57:42', '2023-06-28 00:58:05'),
(3, 12, 'WE1-1684820854', 'WE', '2023-05-22', '2023-05-23', '3600.00', '3200.00', 'A', 'ACH', NULL, '2023-05-23 00:10:17', '2023-07-13 08:15:14'),
(4, 12, NULL, 'WE', '2023-06-01', '2023-06-04', '1415.00', '0.00', 'D', 'NA', NULL, '2023-06-29 01:27:00', '2023-06-29 05:40:30'),
(5, 12, 'WE12-1689313102', 'WE', '2023-07-01', '2023-07-02', '1700.00', '1550.00', 'A', 'ACHY', NULL, '2023-07-14 00:06:52', '2023-07-14 00:40:49'),
(6, 16, 'WE16-1690199478', 'WE', '2023-07-24', '2023-07-24', '600.00', '0.00', 'A', 'ACHY', NULL, '2023-07-24 06:21:11', '2023-07-24 08:29:01'),
(7, 16, 'WE16-1690207199', 'WE', '2023-07-17', '2023-07-23', '550.00', '0.00', 'A', 'ACHY', NULL, '2023-07-24 08:29:55', '2023-07-24 08:42:46'),
(8, 17, 'WE17-1690435337', 'WE', '2023-07-24', '2023-07-27', '550.00', '0.00', 'A', 'ACHY', NULL, '2023-07-26 23:52:09', '2023-07-27 00:54:53'),
(9, 17, 'WE17-1690442446', 'WE', '2023-07-17', '2023-07-23', '2600.00', '0.00', 'A', 'ACHY', NULL, '2023-07-27 01:49:40', '2023-07-27 02:37:21'),
(10, 17, 'WE17-1690624939', 'WE', '2023-07-10', '2023-07-16', '2700.00', '0.00', 'S', 'ADH', 'ACHY', '2023-07-29 04:32:13', '2023-07-29 05:54:22');

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
(10, 10, NULL, 'this s remark', NULL, NULL, NULL, 'R', '2023-07-29 04:38:24', '2023-07-29 05:24:38');

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
(4, 'Employee One', NULL, 1, 'A', 'NP', '8ogGcHb3', '2023-04-20 07:21:40', '2023-06-16 06:51:08');

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

INSERT INTO `users` (`id`, `name`, `mobile`, `slug`, `empID`, `designation`, `department`, `division`, `password`, `user_type`, `status`, `signature_image`, `created_at`, `updated_at`) VALUES
(1, 'Employee One', '1234567890', NULL, 'employee1', 'TECHNICAL LEAD', 'INFORMATION TECHNOLOGY', 'HHC - CORPORATE', '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'E', 'A', NULL, '2023-03-21 14:33:05', '2023-03-21 14:33:05'),
(2, 'Admin Assistant', '1234567890', NULL, 'adminassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AA', 'A', NULL, '2023-03-22 07:40:03', '2023-03-22 07:40:03'),
(3, 'Admin', '12121212121', NULL, 'admin', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'A', 'A', '1684994069-2884.png', '2023-03-22 07:40:03', '2023-05-25 05:54:29'),
(4, 'HR', '112121212', NULL, 'hr', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'HR', 'A', NULL, '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(5, 'Account Assistant', NULL, NULL, 'accountassistant', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACA', 'A', NULL, '2023-03-22 14:07:34', '2023-03-22 14:07:34'),
(6, 'Account Head', '565656', NULL, 'accounthead', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'ACH', 'A', NULL, '2023-03-22 14:10:54', '2023-03-22 14:10:54'),
(7, 'Account Hyd', NULL, NULL, 'accounthyd', NULL, NULL, NULL, '$2y$10$AHvPbsdIGsOfDJW/7j8Ide8Yp0tyn27sFiZC4hWMjx6MqDuQdaPJG', 'AHY', 'A', NULL, '2023-03-22 14:10:54', '2023-03-22 14:10:54'),
(8, 'ANUJ DEWANI', '7744066526', NULL, '110631', 'NATIONAL SALES MANAGER', 'SALES', 'HHC - MAIN', '$2y$10$HqYnk..l00UR3a6zlmsVweSMMwW8VBoqy.OSKAm/OPGfVZQM9c7WS', 'E', 'A', NULL, '2023-03-30 06:19:54', '2023-06-16 11:26:42'),
(9, 'GAUTAM CHANDRA GHOSH', '7738160238', NULL, '50251', 'VICE PRESIDENT', 'MARKETING', 'HHC-ULTRA', '$2y$10$DnN99W6kG3loPJ1KW3ZAXeZGFq0aPoX4IzXSIo9IMNJC0i6iGx3Ou', 'AHY', 'A', NULL, '2023-03-30 06:28:56', '2023-07-29 07:49:10'),
(10, 'PRANAY PRABHAKAR PATIL', '8390822259', NULL, '50202', 'OFFICER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$ySUaKNSYFnkc1EtY7qsXFec2yTRsyqF4OZdvhNJUB1TMc5o.tgTdO', 'AA', 'A', NULL, '2023-06-27 12:04:18', '2023-07-29 11:23:45'),
(11, 'RAVINDRA BABA KOKATE', '9860081917', NULL, '10327', 'ASSISTANT MANAGER', 'ACCOUNTS', 'HHC - MUM - CORPORATE', '$2y$10$7qrI.jpdq78VbVUzDzeOIeIzrGw49ZaXM8vUAlXwLHQT7HYbJqlCu', 'ACH', 'A', NULL, '2023-06-27 12:20:36', '2023-07-29 10:07:17'),
(12, 'K M V PRASAD REDDY', '9948686111', NULL, '106892', 'SENIOR VICE PRESIDENT', 'SALES', 'HHC - ONCOLOGY', '$2y$10$k.tqER3c3uCTlmXZD.oyPuPp3mCXj5iorWlNbQVBuh860eQET0cZa', 'E', 'A', NULL, '2023-06-29 06:55:45', '2023-07-14 04:51:00'),
(13, 'SAMEER D DESHPANDE', '9869737985', NULL, '20113', 'SENIOR MANAGER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$ipLJG.RTIjjAZSkdupYtDu2jNAa.HTsLe/oZuQ3Pf6PKjUwGG/KAC', 'A', 'A', NULL, '2023-07-13 13:53:55', '2023-07-29 11:24:33'),
(14, 'MANOJ B PATIL', '9322032091', NULL, '10183', 'GENERAL MANAGER', 'PERSONEL & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$lpCrapXEI6R2D5ZaryRMwuRjAipqCEHbf6cP3gh7//nUH4b2TUlEe', 'HR', 'A', NULL, '2023-07-14 05:40:39', '2023-07-29 10:06:14'),
(15, 'NISHAD ANIL PATIL', '8806777006', NULL, '50184', 'OFFICER', 'SALES & ADMIN', 'HHC - MUM - CORPORATE', '$2y$10$rxeEZUyLJoBYyclXvjuOWurum6.1b7olKruoRgP2TkvtrpVXMMoA6', 'ACA', 'A', NULL, '2023-07-14 05:42:22', '2023-07-29 10:06:53'),
(16, 'VILAS S PAWALE', '9373203439', NULL, '206225', 'SALES MANAGER', 'SALES', 'HHC - MAIN', '$2y$10$dD6WAZ0CLWAffnADx0/8PudhsixF1ROWMvwohIGbJGm1LXLo52M.q', 'E', 'A', NULL, '2023-07-24 11:50:14', '2023-07-24 14:11:27'),
(17, 'PRADEEP KUMAR', '7840041778', NULL, '111319', 'DEPUTY DIVISIONAL MANAGER', 'SALES', 'HHC-AURA', '$2y$10$7vKLlnROGx/LGtALKpFUruwfzSqG/8bT4hxel2DwBfGnpTLGZhpxK', 'E', 'A', NULL, '2023-07-27 05:20:42', '2023-07-29 11:00:39');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `expense_items`
--
ALTER TABLE `expense_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `expense_item_docs`
--
ALTER TABLE `expense_item_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `expense_master`
--
ALTER TABLE `expense_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `memos`
--
ALTER TABLE `memos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `password_request`
--
ALTER TABLE `password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
