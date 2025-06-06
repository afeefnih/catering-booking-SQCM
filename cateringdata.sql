-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 04:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cateringdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` char(40) NOT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `name`, `email`, `password`, `registration_date`) VALUES
(1, 'Admin', 'adminencem@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2024-01-14 16:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone_no` varchar(30) NOT NULL,
  `Message` varchar(100) NOT NULL,
  `Send_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`user_id`, `first_name`, `last_name`, `email`, `phone_no`, `Message`, `Send_date`) VALUES
(1, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'asda', '2024-01-24 12:25:02'),
(2, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:31:44'),
(3, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:34:29'),
(4, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:34:48'),
(5, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:34:52'),
(6, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:35:28'),
(7, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:36:25'),
(8, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:36:36'),
(9, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:37:11'),
(10, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:37:20'),
(11, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:37:27'),
(12, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:37:39'),
(13, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:37:51'),
(14, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:38:00'),
(15, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:38:06'),
(16, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:38:16'),
(17, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:38:49'),
(18, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:38:54'),
(19, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:39:31'),
(20, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:39:42'),
(21, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:39:46'),
(22, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:02'),
(23, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:08'),
(24, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:22'),
(25, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:32'),
(26, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:40'),
(27, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:50'),
(28, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:55'),
(29, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:40:59'),
(30, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:41:05'),
(31, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:41:11'),
(32, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'izzhensem', '2024-01-24 13:41:17'),
(33, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:43:36'),
(34, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:43:54'),
(35, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:43:57'),
(36, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'izz hensem', '2024-01-24 13:44:44'),
(37, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'Danial', 'izzdanial23@gmail.com', '0132363192', 'sdsd', '2024-06-02 22:49:00'),
(38, 'AHMAD', 'RASHID', 'izzdanial23@gmail.com', '0132363192', 'test', '2024-06-03 17:02:09'),
(39, 'AHMAD', 'RASHID', 'izzdanial23@gmail.com', '0132363192', 'sd', '2024-06-03 17:05:12'),
(40, 'AHMAD', 'RASHID', 'izzdanial23@gmail.com', '0132363192', 'sdsds', '2024-06-03 17:05:17'),
(41, 'AHMAD IZZ DANIAL BIN ABD RASHI', 'ABD RASHID', 'izzdanial23@gmail.com', '0132363192', 'dsdsdsdsd', '2024-06-18 22:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` mediumint(8) UNSIGNED NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `contact_no` varchar(25) NOT NULL,
  `num_pax` int(255) NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(40) NOT NULL,
  `event_time` varchar(10) NOT NULL,
  `event_address` varchar(255) NOT NULL,
  `budget` int(10) NOT NULL,
  `total_budget` varchar(10) NOT NULL,
  `company_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `special_req` varchar(255) NOT NULL,
  `promo_code` varchar(10) NOT NULL,
  `subscribe` varchar(10) NOT NULL,
  `occasion` varchar(255) NOT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `contact_person`, `contact_no`, `num_pax`, `event_date`, `location`, `event_time`, `event_address`, `budget`, `total_budget`, `company_name`, `email`, `special_req`, `promo_code`, `subscribe`, `occasion`, `registration_date`) VALUES
(65, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 500, '2024-07-14', 'Kuala Lumpur', '12:30', 'NO 110, LORONG MERAK 10, TAMAN MERAK, 43200 KUALA LUMPUR, WILAYAH PERSEKUTUAN KUALA LUMPUR', 50, 'RM25000', 'Family Encik Ahmad', 'izzdanial@gmail.com', 'Kambing golek nak garing', '', 'Yes', 'Happy Birthday Event', '2024-01-30 14:16:14'),
(66, 'Imran', '0176811237', 1000, '2024-06-03', 'Selangor', '00:10', 'NO 220\r\nLORONG MERAK 5\r\nTAMAN MERAK', 10, 'RM10000', 'Luqman Hensem', 'izzdanial23@gmail.com', '', '', 'No', 'Happy Birthday Event', '2024-06-03 00:04:52'),
(67, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 10, '2024-06-03', 'Selangor', '15:49', 'fgfgf', 8, '80.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', 'fgfg', '', 'Yes', 'Happy Birthday Event', '2024-06-03 15:47:48'),
(68, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 10, '2024-06-03', 'Selangor', '15:49', 'fgfgf', 8, '80.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', 'fgfg', '', 'Yes', 'Happy Birthday Event', '2024-06-03 15:50:58'),
(69, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 10, '2024-06-03', 'Selangor', '15:49', 'fgfgf', 8, '80.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', 'fgfg', '', 'Yes', 'Happy Birthday Event', '2024-06-03 15:52:07'),
(70, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 10, '2024-06-03', 'Selangor', '15:49', 'fgfgf', 8, '80.00', 'Family Encik Ahmad', 'ahmadizzdanial23@gmail.com', 'fgfg', '', 'Yes', 'Happy Birthday Event', '2024-06-03 15:53:48'),
(71, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imran@gmail.com', '', '', 'No', 'Wedding Event', '2024-06-03 15:58:12'),
(72, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'aizz.rashid@s.unikl.edu.my', '', '', 'No', 'Wedding Event', '2024-06-03 15:58:35'),
(73, 'Mohamad Faris Irsyad bin Mohamad Faiz', '0192077930', 100, '2024-06-10', 'Selangor', '19:00', 'Shah Alam', 500, '50,000.00', '-', 'mfaris.faiz@s.unikl.edu.my', '', '', 'No', 'Wedding Event', '2024-06-03 16:00:12'),
(74, 'Luqman Hakim bin Mad Isa', '01111794254', 100, '2024-06-10', 'Selangor', '19:00', 'Pokok Sena', 500, '50,000.00', '-', 'luqman.mad08@s.unikl.edu.my', '', '', 'No', 'Wedding Event', '2024-06-03 16:01:42'),
(75, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imran.abu01@s.unikl.edu.my', '', '', 'No', 'Wedding Event', '2024-06-03 16:04:52'),
(76, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 10, '2024-06-03', 'Selangor', '16:33', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 2147483647, '45,454,545', 'fdfsdf', 'izzdanial23@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:33:47'),
(77, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:37:38'),
(78, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:38:03'),
(79, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:38:04'),
(80, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:38:04'),
(81, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:38:04'),
(82, 'Imran Hakimi', '01110032552', 100, '2024-06-10', 'Selangor', '19:00', 'Taman Wilayah', 500, '50,000.00', '-', 'imrankimi100@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 16:38:05'),
(83, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 100, '2024-06-03', 'Selangor', '17:09', 'NO 110, LORONG MERAK 5, TAMAN MERAK, 43200 KUALA LUMPUR', 2147483647, '454,545,45', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Wedding Event', '2024-06-03 17:09:49'),
(84, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 12, '2024-06-16', 'Kuala Lumpur', '22:14', 'sdsd', 122, '1,464.00', 'sdsd', 'izzdanial23@gmail.com', '', '122', 'No', 'Happy Birthday Event', '2024-06-16 22:10:00'),
(85, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 12, '2024-06-16', 'Kuala Lumpur', '22:14', 'sdsd', 122, '1,464.00', 'sdsd', 'izzdanial23@gmail.com', '', '122', 'No', 'Happy Birthday Event', '2024-06-16 22:10:02'),
(86, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0176811237', 500, '2024-06-16', 'Kuala Lumpur', '22:24', 'NO 220\r\nLORONG MERAK 5\r\nTAMAN MERAK', 1000, '500,000.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-16 22:18:25'),
(87, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 5000, '2024-06-16', 'Kuala Lumpur', '22:18', 'SriLedang', 1000, '5,000,000.', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-16 22:19:13'),
(88, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 100, '2024-07-01', 'Kuala Lumpur', '12:00', '1-7-2 Sri Ledang, Seksyen 10, Wangsa Maju, WP Kuala Lumpur', 25, '2,500.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-18 23:58:23'),
(89, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 100, '2024-07-01', 'Kuala Lumpur', '12:00', '1-7-2 Sri Ledang, Seksyen 10, Wangsa Maju, WP Kuala Lumpur', 25, '2,500.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-19 00:05:07'),
(90, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 100, '2024-07-01', 'Kuala Lumpur', '12:00', '1-7-2 Sri Ledang, Seksyen 10, Wangsa Maju, WP Kuala Lumpur', 25, '2,500.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-19 00:05:50'),
(91, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 100, '2024-07-01', 'Kuala Lumpur', '12:00', '1-7-2 Sri Ledang, Seksyen 10, Wangsa Maju, WP Kuala Lumpur', 25, '2,500.00', 'Family Encik Ahmad', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-19 00:06:00'),
(92, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 1000, '2024-06-19', 'Selangor', '03:11', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 10, '5,000.00', '1/4', 'izzdanial23@gmail.com', '', 'FOODIES50', 'Yes', 'Happy Birthday Event', '2024-06-19 03:06:01'),
(93, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 5000, '2024-06-28', 'Selangor', '11:00', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 78, '390,000.00', '', 'izzdanial23@gmail.com', 'sdsd', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:00:16'),
(94, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 5000, '2024-06-28', 'Selangor', '11:00', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 78, '390,000.00', '', 'izzdanial23@gmail.com', 'sdsd', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:01:09'),
(95, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:01:46'),
(96, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:02:00'),
(97, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:02:51'),
(98, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:04:28'),
(99, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:04:55'),
(100, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:05:29'),
(101, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:05:50'),
(102, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:07:05'),
(103, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:07:19'),
(104, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:07:28'),
(105, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:07:37'),
(106, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 323323, '2024-06-28', 'Kuala Lumpur', '23:06', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 23, '7,436,429.', '', 'izzdanial23@gmail.com', 'sds', '', 'Yes', 'Happy Birthday Event', '2024-06-28 23:07:44'),
(107, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 1000, '2024-06-28', 'Selangor', '11:17', 'NO 220,\r\nLORONG MERAK 5,\r\nTAMAN MERAK,', 2147483647, '4,545,454,', '', 'izzdanial23@gmail.com', 'asdsd', '', 'Yes', 'Wedding Event', '2024-06-28 23:17:49'),
(108, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:07:46'),
(109, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:10:22'),
(110, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:11:24'),
(111, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:15:19'),
(112, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:16:11'),
(113, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:16:28'),
(114, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:16:46'),
(115, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:17:20'),
(116, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:17:41'),
(117, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:17:57'),
(118, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:18:17'),
(119, 'AHMAD IZZ DANIAL BIN ABD RASHID', '0132363192', 15, '2024-06-29', 'Kuala Lumpur', '06:06', 'NO 220, LORONG MERAK 5, TAMAN MERAK, 53300 KUALA LUMPUR', 30, '450.00', '', 'izzdanial23@gmail.com', '', '', 'Yes', 'Happy Birthday Event', '2024-06-29 00:18:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
