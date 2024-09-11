-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 10:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abc_rest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'manager', 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `auth_system_log`
--

CREATE TABLE `auth_system_log` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `branch` int(10) NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_time` datetime NOT NULL,
  `action` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('Success','Failed') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `log_message` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `auth_system_log`
--

INSERT INTO `auth_system_log` (`id`, `user_id`, `branch`, `ip_address`, `date_time`, `action`, `status`, `log_message`) VALUES
(1, 1, 0, '::1', '2024-08-18 00:50:21', 'login', 'Success', 'user login'),
(2, 1, 0, '::1', '2024-08-20 00:28:05', 'login', 'Success', 'user login'),
(3, 1, 0, '::1', '2024-08-20 00:56:46', 'login', 'Success', 'user login'),
(4, 1, 0, '::1', '2024-08-20 00:59:34', 'login', 'Success', 'user login'),
(5, 1, 0, '::1', '2024-08-20 00:59:51', 'login', 'Success', 'user login'),
(6, 1, 0, '::1', '2024-08-20 01:00:58', 'login', 'Success', 'user login'),
(7, 1, 0, '::1', '2024-08-20 01:18:46', 'login', 'Success', 'user login'),
(8, 1, 0, '::1', '2024-08-20 01:27:31', 'View', 'Success', 'Yes'),
(9, 1, 0, '::1', '2024-08-20 01:27:32', 'Add', 'Success', 'Yes'),
(10, 1, 0, '::1', '2024-08-20 01:27:33', 'View', 'Success', 'Yes'),
(11, 1, 0, '::1', '2024-08-20 01:27:34', 'Delete', 'Success', 'Yes'),
(12, 1, 0, '::1', '2024-08-20 01:28:28', 'Delete', 'Success', 'No'),
(13, 1, 0, '::1', '2024-08-20 01:28:52', 'Delete', 'Success', 'No'),
(14, 1, 0, '::1', '2024-08-20 01:28:53', 'View', 'Success', 'No'),
(15, 1, 0, '::1', '2024-08-20 01:28:54', 'Add', 'Success', 'No'),
(16, 1, 0, '::1', '2024-08-20 01:28:55', 'View', 'Success', 'No'),
(17, 1, 0, '::1', '2024-08-20 01:28:57', 'Delete', 'Success', 'Yes'),
(18, 1, 0, '::1', '2024-08-21 17:04:21', 'login', 'Success', 'user login'),
(19, 1, 0, '::1', '2024-08-21 23:52:35', 'login', 'Success', 'user login'),
(20, 1, 0, '::1', '2024-08-22 01:10:36', 'login', 'Success', 'user login'),
(21, 0, 0, '::1', '2024-08-23 21:56:21', 'login', 'Failed', 'user login'),
(22, 1, 0, '::1', '2024-08-23 21:56:27', 'login', 'Success', 'user login'),
(23, 1, 0, '::1', '2024-08-23 22:12:20', 'login', 'Success', 'user login'),
(24, 1, 0, '::1', '2024-08-23 23:20:13', 'login', 'Success', 'user login'),
(25, 1, 0, '::1', '2024-08-23 23:32:22', 'login', 'Success', 'user login'),
(26, 1, 0, '::1', '2024-08-24 00:00:11', 'login', 'Success', 'user login'),
(27, 1, 0, '::1', '2024-08-24 00:01:27', 'login', 'Success', 'user login'),
(28, 1, 0, '::1', '2024-08-24 15:40:24', 'login', 'Success', 'user login'),
(29, 1, 0, '::1', '2024-08-24 15:45:43', 'login', 'Success', 'user login'),
(30, 1, 0, '::1', '2024-08-24 16:14:31', 'login', 'Success', 'user login'),
(31, 1, 0, '::1', '2024-08-24 16:17:39', 'login', 'Success', 'user login'),
(32, 1, 0, '::1', '2024-08-24 16:17:42', 'login', 'Success', 'user login'),
(33, 1, 0, '::1', '2024-08-24 16:17:44', 'login', 'Success', 'user login'),
(34, 1, 0, '::1', '2024-08-24 16:17:45', 'login', 'Success', 'user login'),
(35, 1, 0, '::1', '2024-08-24 16:17:45', 'login', 'Success', 'user login'),
(36, 1, 0, '::1', '2024-08-24 16:17:46', 'login', 'Success', 'user login'),
(37, 1, 0, '::1', '2024-08-24 16:17:46', 'login', 'Success', 'user login'),
(38, 1, 0, '::1', '2024-08-24 16:17:46', 'login', 'Success', 'user login'),
(39, 1, 0, '::1', '2024-08-24 16:17:46', 'login', 'Success', 'user login'),
(40, 1, 0, '::1', '2024-08-24 16:18:53', 'login', 'Success', 'user login'),
(41, 1, 0, '::1', '2024-08-24 16:20:26', 'View', 'Success', 'Yes'),
(42, 1, 0, '::1', '2024-08-24 16:20:26', 'Add', 'Success', 'Yes'),
(43, 1, 0, '::1', '2024-08-24 16:20:27', 'View', 'Success', 'Yes'),
(44, 1, 0, '::1', '2024-08-24 16:20:27', 'Delete', 'Success', 'Yes'),
(45, 1, 0, '::1', '2024-08-24 16:31:02', 'Register users update', 'Success', 'user update'),
(46, 1, 0, '::1', '2024-08-24 16:37:01', 'Register users update', 'Success', 'user update'),
(47, 1, 0, '::1', '2024-08-24 16:37:31', 'Register users update', 'Success', 'user update'),
(48, 1, 0, '::1', '2024-08-24 16:40:17', 'Register users update', 'Success', 'user update'),
(49, 1, 0, '::1', '2024-08-24 16:40:39', 'Register users update', 'Success', 'user update'),
(50, 1, 0, '::1', '2024-08-24 16:41:24', 'Register users update', 'Success', 'user update'),
(51, 0, 0, '::1', '2024-08-24 16:43:50', 'login', 'Failed', 'user login'),
(52, 1, 0, '::1', '2024-08-24 16:43:55', 'login', 'Success', 'user login'),
(53, 1, 0, '::1', '2024-08-24 16:44:58', 'View', 'Success', 'Yes'),
(54, 1, 0, '::1', '2024-08-24 16:44:58', 'Add', 'Success', 'Yes'),
(55, 1, 0, '::1', '2024-08-24 16:44:59', 'View', 'Success', 'Yes'),
(56, 1, 0, '::1', '2024-08-24 16:44:59', 'Add', 'Success', 'Yes'),
(57, 1, 0, '::1', '2024-08-24 16:45:00', 'View', 'Success', 'Yes'),
(58, 1, 0, '::1', '2024-08-24 16:45:01', 'View', 'Success', 'Yes'),
(59, 1, 0, '::1', '2024-08-24 16:45:01', 'Delete', 'Success', 'Yes'),
(60, 1, 0, '::1', '2024-08-24 16:45:02', 'Delete', 'Success', 'Yes'),
(61, 1, 0, '::1', '2024-08-24 16:45:02', 'Delete', 'Success', 'Yes'),
(62, 1, 0, '::1', '2024-08-24 16:45:03', 'View', 'Success', 'Yes'),
(63, 1, 0, '::1', '2024-08-24 16:45:03', 'Add', 'Success', 'Yes'),
(64, 1, 0, '::1', '2024-08-24 16:45:04', 'View', 'Success', 'Yes'),
(65, 1, 0, '::1', '2024-08-24 16:45:05', 'View', 'Success', 'Yes'),
(66, 1, 0, '::1', '2024-08-24 16:45:06', 'View', 'Success', 'Yes'),
(67, 1, 0, '::1', '2024-08-24 16:45:07', 'Add', 'Success', 'Yes'),
(68, 1, 0, '::1', '2024-08-24 16:45:07', 'Add', 'Success', 'Yes'),
(69, 1, 0, '::1', '2024-08-24 16:45:08', 'View', 'Success', 'Yes'),
(70, 1, 0, '::1', '2024-08-24 16:45:08', 'View', 'Success', 'Yes'),
(71, 1, 0, '::1', '2024-08-24 16:45:08', 'Delete', 'Success', 'Yes'),
(72, 1, 0, '::1', '2024-08-24 16:45:09', 'Delete', 'Success', 'Yes'),
(73, 1, 0, '::1', '2024-08-24 16:45:10', 'View', 'Success', 'Yes'),
(74, 1, 0, '::1', '2024-08-24 16:45:11', 'View', 'Success', 'Yes'),
(75, 1, 0, '::1', '2024-08-24 16:45:11', 'Add', 'Success', 'Yes'),
(76, 1, 0, '::1', '2024-08-24 16:45:12', 'Add', 'Success', 'Yes'),
(77, 1, 0, '::1', '2024-08-24 16:45:13', 'View', 'Success', 'Yes'),
(78, 1, 0, '::1', '2024-08-24 16:45:13', 'View', 'Success', 'Yes'),
(79, 1, 0, '::1', '2024-08-24 16:45:14', 'Delete', 'Success', 'Yes'),
(80, 1, 0, '::1', '2024-08-24 16:45:14', 'Delete', 'Success', 'Yes'),
(81, 0, 0, '::1', '2024-08-24 16:45:23', 'login', 'Failed', 'user login'),
(82, 1, 0, '::1', '2024-08-24 16:45:37', 'login', 'Success', 'user login'),
(83, 1, 0, '::1', '2024-08-24 17:26:52', 'Register users update', 'Success', 'user update'),
(84, 1, 0, '::1', '2024-08-24 17:27:20', 'Register users update', 'Success', 'user update'),
(85, 1, 0, '::1', '2024-08-24 17:29:08', 'Register users update', 'Success', 'user update'),
(86, 1, 0, '::1', '2024-08-24 17:29:40', 'Register users update', 'Success', 'user update'),
(87, 1, 0, '::1', '2024-08-24 18:29:51', 'Register users', 'Success', 'user register'),
(88, 1, 0, '::1', '2024-08-24 18:48:15', 'Register users', 'Success', 'user register'),
(89, 1, 0, '::1', '2024-08-24 19:04:26', 'login', 'Success', 'user login'),
(90, 1, 0, '::1', '2024-08-24 19:16:01', 'Register users update', 'Success', 'user update'),
(91, 1, 0, '::1', '2024-08-24 19:16:12', 'Register users update', 'Success', 'user update'),
(92, 1, 0, '::1', '2024-08-24 19:17:17', 'Register users update', 'Success', 'user update'),
(93, 1, 0, '::1', '2024-08-24 19:31:22', 'login', 'Success', 'user login'),
(94, 1, 0, '::1', '2024-08-24 19:31:34', 'login', 'Success', 'user login'),
(95, 1, 0, '::1', '2024-08-24 19:32:25', 'login', 'Success', 'user login'),
(96, 1, 0, '::1', '2024-08-24 19:33:12', 'Register users', 'Success', 'user register'),
(97, 1, 0, '::1', '2024-08-24 19:33:37', 'Register users update', 'Success', 'user update'),
(98, 1, 0, '::1', '2024-08-24 19:34:06', 'Register users update', 'Success', 'user update'),
(99, 1, 0, '::1', '2024-08-24 19:35:41', 'Register users update', 'Success', 'user update'),
(100, 1, 0, '::1', '2024-08-24 19:35:55', 'Register users update', 'Success', 'user update'),
(101, 1, 0, '::1', '2024-08-24 19:37:36', 'Register users update', 'Success', 'user update'),
(102, 1, 0, '::1', '2024-08-24 19:37:40', 'Register users update', 'Success', 'user update'),
(103, 1, 0, '::1', '2024-08-24 19:37:59', 'Register users update', 'Success', 'user update'),
(104, 1, 0, '::1', '2024-08-24 19:38:08', 'Register users update', 'Success', 'user update'),
(105, 1, 0, '::1', '2024-08-24 19:40:00', 'Register users update', 'Success', 'user update'),
(106, 1, 0, '::1', '2024-08-24 19:40:29', 'Register users', 'Success', 'user register'),
(107, 1, 0, '::1', '2024-08-24 19:44:54', 'Register users update', 'Success', 'user update'),
(108, 1, 0, '::1', '2024-08-24 19:46:57', 'Register users', 'Success', 'user register'),
(109, 1, 0, '::1', '2024-08-24 19:49:06', 'View', 'Success', 'Yes'),
(110, 1, 0, '::1', '2024-08-24 19:49:07', 'View', 'Success', 'Yes'),
(111, 1, 0, '::1', '2024-08-24 19:49:07', 'View', 'Success', 'Yes'),
(112, 1, 0, '::1', '2024-08-24 19:49:07', 'View', 'Success', 'Yes'),
(113, 1, 0, '::1', '2024-08-24 19:49:08', 'View', 'Success', 'Yes'),
(114, 1, 0, '::1', '2024-08-24 19:49:08', 'View', 'Success', 'Yes'),
(115, 1, 0, '::1', '2024-08-24 19:49:09', 'View', 'Success', 'Yes'),
(116, 1, 0, '::1', '2024-08-24 19:49:09', 'Add', 'Success', 'Yes'),
(117, 1, 0, '::1', '2024-08-24 19:49:10', 'Add', 'Success', 'Yes'),
(118, 1, 0, '::1', '2024-08-24 19:49:10', 'Add', 'Success', 'Yes'),
(119, 1, 0, '::1', '2024-08-24 19:49:11', 'Add', 'Success', 'Yes'),
(120, 1, 0, '::1', '2024-08-24 19:49:11', 'Add', 'Success', 'Yes'),
(121, 1, 0, '::1', '2024-08-24 19:49:11', 'Add', 'Success', 'Yes'),
(122, 1, 0, '::1', '2024-08-24 19:49:12', 'Add', 'Success', 'Yes'),
(123, 1, 0, '::1', '2024-08-24 19:50:13', 'login', 'Success', 'user login'),
(124, 1, 0, '::1', '2024-08-24 19:50:30', 'View', 'Success', 'Yes'),
(125, 1, 0, '::1', '2024-08-24 19:50:30', 'View', 'Success', 'Yes'),
(126, 1, 0, '::1', '2024-08-24 19:50:31', 'View', 'Success', 'Yes'),
(127, 1, 0, '::1', '2024-08-24 19:50:31', 'View', 'Success', 'Yes'),
(128, 1, 0, '::1', '2024-08-24 19:50:32', 'View', 'Success', 'Yes'),
(129, 1, 0, '::1', '2024-08-24 19:50:32', 'View', 'Success', 'Yes'),
(130, 1, 0, '::1', '2024-08-24 19:50:33', 'View', 'Success', 'Yes'),
(131, 1, 0, '::1', '2024-08-24 19:50:33', 'Add', 'Success', 'Yes'),
(132, 1, 0, '::1', '2024-08-24 19:50:33', 'Add', 'Success', 'Yes'),
(133, 1, 0, '::1', '2024-08-24 19:50:34', 'Add', 'Success', 'Yes'),
(134, 1, 0, '::1', '2024-08-24 19:50:35', 'Add', 'Success', 'Yes'),
(135, 1, 0, '::1', '2024-08-24 19:50:35', 'Add', 'Success', 'Yes'),
(136, 1, 0, '::1', '2024-08-24 19:50:36', 'Add', 'Success', 'Yes'),
(137, 1, 0, '::1', '2024-08-24 19:50:37', 'Add', 'Success', 'Yes'),
(138, 1, 0, '::1', '2024-08-25 12:04:50', 'login', 'Success', 'user login'),
(139, 1, 0, '::1', '2024-08-25 14:08:49', 'login', 'Success', 'user login'),
(140, 1, 0, '::1', '2024-08-25 14:09:09', 'View', 'Success', 'No'),
(141, 1, 0, '::1', '2024-08-25 14:09:10', 'Add', 'Success', 'No'),
(142, 1, 0, '::1', '2024-08-25 14:09:10', 'View', 'Success', 'No'),
(143, 1, 0, '::1', '2024-08-25 14:09:11', 'Delete', 'Success', 'No'),
(144, 1, 0, '::1', '2024-08-25 15:27:46', 'login', 'Success', 'user login'),
(145, 1, 0, '::1', '2024-08-25 15:27:58', 'View', 'Success', 'Yes'),
(146, 1, 0, '::1', '2024-08-25 15:27:59', 'Add', 'Success', 'Yes'),
(147, 1, 0, '::1', '2024-08-25 15:28:00', 'View', 'Success', 'Yes'),
(148, 1, 0, '::1', '2024-08-25 15:28:01', 'Delete', 'Success', 'Yes'),
(149, 1, 0, '::1', '2024-08-25 15:29:19', 'View', 'Success', 'No'),
(150, 1, 0, '::1', '2024-08-25 15:29:19', 'Add', 'Success', 'No'),
(151, 1, 0, '::1', '2024-08-25 15:29:20', 'View', 'Success', 'No'),
(152, 1, 0, '::1', '2024-08-25 15:29:21', 'Delete', 'Success', 'No'),
(153, 1, 0, '::1', '2024-08-28 23:34:43', 'login', 'Success', 'user login'),
(154, 1, 0, '::1', '2024-09-02 22:34:53', 'login', 'Success', 'user login'),
(155, 1, 0, '::1', '2024-09-03 15:56:22', 'login', 'Success', 'user login'),
(156, 1, 0, '::1', '2024-09-04 15:13:16', 'login', 'Success', 'user login'),
(157, 1, 0, '::1', '2024-09-04 15:15:29', 'View', 'Success', 'No'),
(158, 1, 0, '::1', '2024-09-04 15:15:30', 'Add', 'Success', 'No'),
(159, 1, 0, '::1', '2024-09-04 15:15:32', 'View', 'Success', 'No'),
(160, 1, 0, '::1', '2024-09-04 15:15:33', 'Delete', 'Success', 'No'),
(161, 1, 0, '::1', '2024-09-04 15:17:08', 'View', 'Success', 'No'),
(162, 1, 0, '::1', '2024-09-04 15:17:09', 'Add', 'Success', 'No'),
(163, 1, 0, '::1', '2024-09-04 15:17:10', 'View', 'Success', 'No'),
(164, 1, 0, '::1', '2024-09-04 15:17:10', 'Delete', 'Success', 'No'),
(165, 1, 0, '::1', '2024-09-04 15:17:12', 'Approve_1', 'Success', 'No'),
(166, 1, 0, '::1', '2024-09-04 15:17:13', 'Approve_2', 'Success', 'No'),
(167, 1, 0, '::1', '2024-09-04 15:17:14', 'Approve_3', 'Success', 'No'),
(168, 1, 0, '::1', '2024-09-04 15:17:15', 'Reject', 'Success', 'No'),
(169, 1, 0, '::1', '2024-09-04 15:17:28', 'View', 'Success', 'Yes'),
(170, 1, 0, '::1', '2024-09-04 15:17:29', 'Add', 'Success', 'Yes'),
(171, 1, 0, '::1', '2024-09-04 15:17:30', 'View', 'Success', 'Yes'),
(172, 1, 0, '::1', '2024-09-04 15:17:32', 'Delete', 'Success', 'Yes'),
(173, 1, 0, '::1', '2024-09-04 15:18:01', 'View', 'Success', 'Yes'),
(174, 1, 0, '::1', '2024-09-04 15:18:02', 'Add', 'Success', 'Yes'),
(175, 1, 0, '::1', '2024-09-04 15:41:05', 'View', 'Success', 'Yes'),
(176, 1, 0, '::1', '2024-09-04 15:41:06', 'Delete', 'Success', 'Yes'),
(177, 1, 0, '::1', '2024-09-05 21:31:29', 'login', 'Success', 'user login'),
(178, 1, 0, '::1', '2024-09-05 23:18:09', 'View', 'Success', 'Yes'),
(179, 1, 0, '::1', '2024-09-05 23:18:12', 'Add', 'Success', 'Yes'),
(180, 1, 0, '::1', '2024-09-05 23:18:13', 'View', 'Success', 'Yes'),
(181, 1, 0, '::1', '2024-09-05 23:18:14', 'Delete', 'Success', 'Yes'),
(182, 1, 0, '::1', '2024-09-05 23:18:29', 'View', 'Success', 'No'),
(183, 1, 0, '::1', '2024-09-05 23:18:30', 'Add', 'Success', 'No'),
(184, 1, 0, '::1', '2024-09-05 23:18:31', 'View', 'Success', 'No'),
(185, 1, 0, '::1', '2024-09-05 23:18:31', 'Delete', 'Success', 'No'),
(186, 1, 0, '::1', '2024-09-06 12:14:05', 'login', 'Success', 'user login'),
(187, 1, 0, '::1', '2024-09-06 20:14:10', 'login', 'Success', 'user login'),
(188, 1, 0, '::1', '2024-09-06 22:11:00', 'login', 'Success', 'user login'),
(189, 1, 0, '::1', '2024-09-06 22:11:00', 'login', 'Success', 'user login'),
(190, 1, 0, '::1', '2024-09-09 10:47:48', 'login', 'Success', 'user login'),
(191, 1, 0, '::1', '2024-09-09 21:26:46', 'login', 'Success', 'user login'),
(192, 1, 0, '::1', '2024-09-10 20:51:36', 'login', 'Success', 'user login'),
(193, 1, 0, '::1', '2024-09-10 21:55:53', 'View', 'Success', 'No'),
(194, 1, 0, '::1', '2024-09-10 21:55:53', 'Add', 'Success', 'No'),
(195, 1, 0, '::1', '2024-09-10 21:55:54', 'View', 'Success', 'No'),
(196, 1, 0, '::1', '2024-09-10 21:55:55', 'Delete', 'Success', 'No'),
(197, 1, 0, '::1', '2024-09-10 21:55:55', 'Approve_1', 'Success', 'No'),
(198, 1, 0, '::1', '2024-09-10 21:55:56', 'Approve_2', 'Success', 'No'),
(199, 1, 0, '::1', '2024-09-10 21:55:57', 'Approve_3', 'Success', 'No'),
(200, 1, 0, '::1', '2024-09-10 21:55:57', 'Reject', 'Success', 'No'),
(201, 1, 0, '::1', '2024-09-10 21:56:42', 'View', 'Success', 'No'),
(202, 1, 0, '::1', '2024-09-10 21:56:43', 'Add', 'Success', 'No'),
(203, 1, 0, '::1', '2024-09-10 22:01:52', 'View', 'Success', 'Yes'),
(204, 1, 0, '::1', '2024-09-10 22:01:53', 'Add', 'Success', 'Yes'),
(205, 1, 0, '::1', '2024-09-10 22:01:54', 'View', 'Success', 'Yes'),
(206, 1, 0, '::1', '2024-09-10 22:01:54', 'Delete', 'Success', 'Yes'),
(207, 1, 0, '::1', '2024-09-10 22:01:55', 'Approve_1', 'Success', 'Yes'),
(208, 1, 0, '::1', '2024-09-10 22:01:55', 'Approve_2', 'Success', 'Yes'),
(209, 1, 0, '::1', '2024-09-10 22:01:56', 'Approve_3', 'Success', 'Yes'),
(210, 1, 0, '::1', '2024-09-10 22:01:56', 'Reject', 'Success', 'Yes'),
(211, 1, 0, '::1', '2024-09-10 23:49:50', 'login', 'Success', 'user login'),
(212, 1, 0, '::1', '2024-09-10 23:50:50', 'Register users', 'Success', 'user register'),
(213, 1, 0, '::1', '2024-09-10 23:51:27', 'View', 'Success', 'Yes'),
(214, 1, 0, '::1', '2024-09-10 23:51:28', 'Add', 'Success', 'Yes'),
(215, 1, 0, '::1', '2024-09-10 23:51:28', 'View', 'Success', 'Yes'),
(216, 1, 0, '::1', '2024-09-10 23:51:29', 'Delete', 'Success', 'Yes'),
(217, 1, 0, '::1', '2024-09-10 23:51:30', 'Approve_1', 'Success', 'Yes'),
(218, 1, 0, '::1', '2024-09-10 23:51:30', 'Approve_2', 'Success', 'Yes'),
(219, 1, 0, '::1', '2024-09-10 23:51:31', 'Approve_3', 'Success', 'Yes'),
(220, 1, 0, '::1', '2024-09-10 23:51:32', 'Reject', 'Success', 'Yes'),
(221, 65, 0, '::1', '2024-09-10 23:51:53', 'login', 'Success', 'user login'),
(222, 1, 0, '::1', '2024-09-10 23:52:41', 'login', 'Success', 'user login'),
(223, 1, 0, '::1', '2024-09-10 23:53:33', 'Register users', 'Success', 'user register'),
(224, 1, 0, '::1', '2024-09-10 23:53:47', 'View', 'Success', 'Yes'),
(225, 1, 0, '::1', '2024-09-10 23:53:51', 'Add', 'Success', 'Yes'),
(226, 1, 0, '::1', '2024-09-10 23:53:52', 'View', 'Success', 'No'),
(227, 1, 0, '::1', '2024-09-10 23:53:55', 'View', 'Success', 'Yes'),
(228, 1, 0, '::1', '2024-09-10 23:53:56', 'View', 'Success', 'Yes'),
(229, 1, 0, '::1', '2024-09-10 23:53:56', 'Delete', 'Success', 'Yes'),
(230, 66, 0, '::1', '2024-09-10 23:54:07', 'login', 'Success', 'user login'),
(231, 1, 0, '::1', '2024-09-11 00:01:46', 'login', 'Success', 'user login'),
(232, 1, 0, '::1', '2024-09-11 01:18:10', 'View', 'Success', 'Yes'),
(233, 1, 0, '::1', '2024-09-11 01:18:11', 'Add', 'Success', 'Yes'),
(234, 1, 0, '::1', '2024-09-11 01:18:11', 'View', 'Success', 'Yes'),
(235, 1, 0, '::1', '2024-09-11 01:18:12', 'Delete', 'Success', 'Yes'),
(236, 66, 0, '::1', '2024-09-11 01:18:28', 'login', 'Success', 'user login'),
(237, 66, 0, '::1', '2024-09-11 01:25:24', 'login', 'Success', 'user login'),
(238, 0, 0, '::1', '2024-09-11 01:25:39', 'login', 'Failed', 'user login'),
(239, 0, 0, '::1', '2024-09-11 01:38:39', 'login', 'Failed', 'user login'),
(240, 0, 0, '::1', '2024-09-11 01:39:53', 'login', 'Failed', 'user login'),
(241, 0, 0, '::1', '2024-09-11 01:53:15', 'login', 'Failed', 'user login'),
(242, 0, 0, '::1', '2024-09-11 01:54:45', 'login', 'Failed', 'user login'),
(243, 0, 0, '::1', '2024-09-11 01:55:16', 'login', 'Failed', 'user login'),
(244, 0, 0, '::1', '2024-09-11 01:55:26', 'login', 'Failed', 'user login'),
(245, 66, 0, '::1', '2024-09-11 01:57:28', 'login', 'Success', 'user login'),
(246, 1, 0, '::1', '2024-09-11 01:58:56', 'login', 'Success', 'user login'),
(247, 1, 0, '::1', '2024-09-11 02:02:00', 'login', 'Success', 'user login'),
(248, 65, 0, '::1', '2024-09-11 02:02:10', 'login', 'Success', 'user login'),
(249, 1, 0, '::1', '2024-09-11 11:47:32', 'login', 'Success', 'user login'),
(250, 1, 0, '::1', '2024-09-11 11:57:50', 'login', 'Success', 'user login');

-- --------------------------------------------------------

--
-- Table structure for table `auth_system_modules`
--

CREATE TABLE `auth_system_modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `path` varchar(100) NOT NULL,
  `section` int(3) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` enum('Enabled','Disabled') NOT NULL DEFAULT 'Enabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `auth_system_modules`
--

INSERT INTO `auth_system_modules` (`id`, `name`, `path`, `section`, `order`, `status`) VALUES
(1, 'Dashboard', 'dashboard', 1, 1, 'Enabled'),
(4, 'Title', 'title', 2, 3, 'Enabled'),
(120, 'User groups', 'user-groups', 14, 1, 'Enabled'),
(121, 'System Users', 'SystemUsers', 14, 2, 'Enabled'),
(122, 'System Users Permissions', 'system-user-permissions', 14, 3, 'Enabled'),
(123, 'System Logs', 'system-log', 14, 4, 'Enabled'),
(148, 'Module Groups', 'module-groups', 14, 5, 'Enabled'),
(194, 'Menu Types', 'menu-types', 2, 4, 'Enabled'),
(195, 'Reservation Types', 'reservation-types', 2, 6, 'Enabled'),
(196, 'Tables', 'tables', 2, 7, 'Enabled'),
(197, 'Menu Items', 'menu-items', 2, 8, 'Enabled'),
(198, 'Customer Form', 'customer-form', 23, 1, 'Enabled'),
(199, 'Kitchen', 'kitchen', 24, 1, 'Enabled'),
(200, 'Order Information', 'order-information', 23, 2, 'Enabled');

-- --------------------------------------------------------

--
-- Table structure for table `auth_system_module_sections`
--

CREATE TABLE `auth_system_module_sections` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `auth_system_module_sections`
--

INSERT INTO `auth_system_module_sections` (`id`, `icon`, `title`, `order`, `status`) VALUES
(1, 'fa-sharp fa-solid fa-house', 'Dashboard', 1, 1),
(2, 'fa-solid fa-database', 'Master', 2, 1),
(14, 'fa-solid fa-lock', 'Administration Management', 14, 1),
(23, 'fa fa-user', 'Customer', 15, 1),
(24, 'fa fa-utensils', 'Kitchen', 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_system_permissions`
--

CREATE TABLE `auth_system_permissions` (
  `id` int(11) NOT NULL,
  `group_id` mediumint(11) UNSIGNED NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `view_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `add_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `edit_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `delete_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `approve1_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `approve2_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `approve3_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `reject_access` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `auth_system_permissions`
--

INSERT INTO `auth_system_permissions` (`id`, `group_id`, `section_id`, `module_id`, `view_access`, `add_access`, `edit_access`, `delete_access`, `approve1_access`, `approve2_access`, `approve3_access`, `reject_access`, `created_at`, `updated_at`) VALUES
(21, 1, 1, 1, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(26, 1, 2, 4, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(34, 1, 14, 122, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(145, 1, 14, 120, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(146, 1, 14, 121, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-08-24 01:47:03', NULL),
(147, 1, 14, 123, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(1059, 1, 14, 148, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 01:47:03', NULL),
(1060, 1, 14, 6, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-08-24 10:56:23', '2024-08-24 10:56:23'),
(1061, 24, 1, 1, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:14:58', '2024-08-24 11:14:58'),
(1062, 24, 2, 4, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:14:59', '2024-08-24 11:14:59'),
(1063, 24, 14, 120, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:15:02', '2024-08-24 11:15:02'),
(1064, 24, 14, 121, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:15:05', '2024-08-24 11:15:05'),
(1065, 24, 14, 122, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:15:06', '2024-08-24 11:15:06'),
(1066, 24, 14, 123, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:15:10', '2024-08-24 11:15:10'),
(1067, 24, 14, 148, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-24 11:15:11', '2024-08-24 11:15:11'),
(1068, 24, 14, 6, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-08-24 12:22:47', '2024-08-24 12:22:47'),
(1069, 23, 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:06', '2024-08-24 14:19:06'),
(1070, 23, 2, 4, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:07', '2024-08-24 14:19:07'),
(1071, 23, 14, 120, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:07', '2024-08-24 14:19:07'),
(1072, 23, 14, 121, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:07', '2024-08-24 14:19:07'),
(1073, 23, 14, 122, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:08', '2024-08-24 14:19:08'),
(1074, 23, 14, 123, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:08', '2024-08-24 14:19:08'),
(1075, 23, 14, 148, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:19:09', '2024-08-24 14:19:09'),
(1076, 3, 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:30', '2024-08-24 14:20:30'),
(1077, 3, 2, 4, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:30', '2024-08-24 14:20:30'),
(1078, 3, 14, 120, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:31', '2024-08-24 14:20:31'),
(1079, 3, 14, 121, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:31', '2024-08-24 14:20:31'),
(1080, 3, 14, 122, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:32', '2024-08-24 14:20:32'),
(1081, 3, 14, 123, 'Yes', 'Yes', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:32', '2024-08-24 14:20:32'),
(1082, 3, 14, 148, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No', '2024-08-24 14:20:33', '2024-08-24 14:20:33'),
(1083, 1, 2, 194, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-08-28 18:14:49', '2024-08-28 18:14:49'),
(1084, 1, 2, 195, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-05 18:24:09', '2024-09-05 18:24:09'),
(1085, 1, 2, 196, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-05 20:00:20', '2024-09-05 20:00:20'),
(1086, 1, 2, 197, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-06 08:40:05', '2024-09-06 08:40:05'),
(1087, 1, 23, 198, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-09 05:43:05', '2024-09-09 05:43:05'),
(1088, 1, 24, 199, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-10 15:24:13', '2024-09-10 15:24:13'),
(1089, 26, 24, 199, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-10 18:21:27', '2024-09-10 18:21:27'),
(1090, 25, 23, 198, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-09-10 18:23:47', '2024-09-10 18:23:47'),
(1091, 1, 23, 200, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', '2024-09-10 18:31:29', '2024-09-10 18:31:29'),
(1092, 25, 23, 200, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'No', 'No', 'No', '2024-09-10 19:48:10', '2024-09-10 19:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(250) NOT NULL,
  `created_at` varchar(250) NOT NULL,
  `expiry_date` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `user_id`, `token`, `created_at`, `expiry_date`) VALUES
(1, 1, '7e0ec18a9422396ac715d200bf60ea216158de17e974e575a4be6cae2c9b6e10', '2024-09-11 11:57', '2024-09-11 13:57:50'),
(2, 65, 'beb4c435176b0292f2f39e40881805e52359476621e8efde510f6ab4da23c8a5', '2024-09-11 02:02', '2024-09-11 04:02:10'),
(3, 66, '7fab637dd3d122a7797f26937b8af93f6334567a1a2464291d236d173dcd1b44', '2024-09-11 01:57', '2024-09-11 03:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'Administrator'),
(3, 'Employee', 'Employee'),
(25, 'Customer', 'Customer'),
(26, 'Kitchen', 'Kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_order`
--

CREATE TABLE `tbl_customer_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `customer_number` varchar(50) DEFAULT NULL,
  `table_code` varchar(50) DEFAULT NULL,
  `menu_type` varchar(50) DEFAULT NULL,
  `menu_item` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `extra_note` text DEFAULT NULL,
  `order_status` enum('Pending','Preparing','Order Ready','Done','Canceled') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_order`
--

INSERT INTO `tbl_customer_order` (`id`, `order_id`, `customer_name`, `customer_email`, `customer_number`, `table_code`, `menu_type`, `menu_item`, `quantity`, `extra_note`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 'ORDID1', 'nikila perera', 'nikilabanuka@gmail.com', '0764343952', 'a', 'testsdsdsdsdsdssdsdsdsdsds', 'sdsdsdsd', 1, NULL, 'Canceled', '2024-09-09 18:02:07', NULL),
(2, 'ORDID1', 'nikila perera', 'nikilabanuka@gmail.com', '0764343952', 'a', 'testsdsdsdsdsdssdsdsdsdsds', 'sdsdsdsd', 121, NULL, 'Pending', '2024-09-09 18:02:07', '2024-09-10 14:52:29'),
(4, 'ORDID2', 'sdsdsdsds', 'nikilabanuka@gmail.com', '0779191098', 'a', 'testsdsdsdsdsdssdsdsdsdsds', 'sdsdsdsd', 232, NULL, 'Order Ready', '2024-09-09 18:05:30', '2024-09-10 16:59:32'),
(6, 'ORDERID3', 'nikila perera', 'nikilabanuka@gmail.com', '0764343952', 'a', 'testsdsdsdsdsdssdsdsdsdsds', 'sdsdsdsd', 3, 'asasasasasa', 'Canceled', '2024-09-10 18:10:53', '2024-09-10 14:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_menu_types`
--

CREATE TABLE `tbl_master_menu_types` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_menu_types`
--

INSERT INTO `tbl_master_menu_types` (`id`, `code`, `name`, `status`) VALUES
(1, 'food', 'food', 'Active'),
(3, 'testsdsdsdsdsdssdsdsdsdsds', 'testsdsdsdsdsd', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_reservation_type`
--

CREATE TABLE `tbl_master_reservation_type` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_reservation_type`
--

INSERT INTO `tbl_master_reservation_type` (`id`, `code`, `name`, `status`) VALUES
(1, 'test', 'test', 'Active'),
(2, 'dsdsd', 'ssdsd', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_table`
--

CREATE TABLE `tbl_master_table` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_table`
--

INSERT INTO `tbl_master_table` (`id`, `code`, `name`, `status`) VALUES
(2, 'sdsdsdaaaa', 'sdsdsdsaaaaaa', 'Inactive'),
(3, 'a', 's', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_title`
--

CREATE TABLE `tbl_master_title` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_master_title`
--

INSERT INTO `tbl_master_title` (`id`, `name`) VALUES
(8, 'Deshamanya'),
(1, 'Dr.'),
(10, 'dsdsdssdsds'),
(4, 'Miss.'),
(2, 'Mr.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu_items`
--

CREATE TABLE `tbl_menu_items` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `menu_type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_menu_items`
--

INSERT INTO `tbl_menu_items` (`id`, `code`, `menu_type`, `name`, `remarks`, `status`) VALUES
(2, 'sdsdsdsd', 'testsdsdsdsdsdssdsdsdsdsds', 'testesr', 'erererererererer', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'admin@abc.lk', '$2y$10$zJnUbRxgc7HLwJY6euCE2OVsO13ZYYLPMNtguNXgLaxm5GTkOFbfi', 'admin@abc.lk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1268889823, 1726036070, 1, 'Nikila', 'Perera', 'ADMIN', '+94764343952'),
(57, '::1', 'sdsdsdsds@abc.lk', '$2y$10$6p0qhalIb4a445nkc4PdWerJQZp7vsJvziWkwpr6kSNaY.7Yqes/a', 'nikilabanuka@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724504391, NULL, 1, 'nikila', 'perera', 'asd', '+94764343952'),
(58, '::1', 'sds@abc.lk', '$2y$10$xNEyosSil7mDiPZ23u.YQ.WGAR5Xb.xT28uWLaSEdpEtHWSsgGxy6', 'sdsdsdssd@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724505495, NULL, 1, 'nikila', 'perera', 'sss', '+94764343952'),
(59, '::1', 'aaaaa@abc.lk', '$2y$10$rETZkdxOhet23Blvlo1sv.G7ufYD479XSwSOkVGCiGuKvN/sLGekq', 'sdsdsdsd@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724508192, NULL, 1, 'dsdsds', 'sdsdsdsds', 'adsdsdsd', '+94764343952'),
(60, '::1', 'admadsdsdsdsdsdsin@abc.lk', '$2y$10$nv.8IQXhcunPPFfS5CGi0.5nWxst4JHA82dXp8l4BDThLYdYb5j7G', 'sdsdsdsdsdaka@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724508384, NULL, 1, 'asdsadasdasd', 'dasdasdsadsad', 'sdasdasdas', '+94764343952'),
(61, '::1', 'qqqds@abc.lk', '$2y$10$qURqoMC8XycfokNlL2/TzuNty1/AjdsDYQqLjZdXh0o.m0qJgImQK', 'sdsdsdsdsa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724508560, NULL, 1, 'qq', 'qq', 'aasa', '+94764343952'),
(62, '::1', 'sdsdsdsdsddsds@abc.lk', '$2y$10$S8SMFzqHtJ/NTWtjqid/jusoBbkh7kXvczZC/Ml3kwTE05llFJ.Di', 'sdsdsdsdsd@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724508630, NULL, 1, 'sdsdsds', 'dsdsdsds', 'asdasdasdas', '+94764343952'),
(63, '::1', 'sdsdsdsds@abc.lk', '$2y$10$HTVlpUccLluT4gH93adDK.5BjJIH9CedH.4t.u7DZqBJKHP5oHFCe', 'asda@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724508652, NULL, 1, 'asdsdasdadas', 'dsdsdsdsdsd', 'asdsdsdsd', '+94764343952'),
(64, '::1', 'sdsdsdsds@abc.lk', '$2y$10$8kT1IqyARzrQOvOCj5ao8.sC.wjBL2WU8abUo/cXyd2z6vISqVeWm', 'sdsdsdsdsds@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1724509017, NULL, 1, 'sasasasa', 'sasasasasaqa', 'asdsds', '+94764343952'),
(65, '::1', 'kitchen@abc.lk', '$2y$10$gBDJeUzquisW1BSHooYX9OyPUNHXxZyYuzQ9pJRM39xxxJpmUpsnm', 'kitchen@abc.lk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1725992450, 1726000330, 1, 'kitchen', 'kitchen', 'abc', '+94764343952'),
(66, '::1', 'customer@abc.lk', '$2y$10$gBDJeUzquisW1BSHooYX9OyPUNHXxZyYuzQ9pJRM39xxxJpmUpsnm', 'customer@abc.lk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1725992613, 1726000048, 1, 'customer', 'customer', 'abc', '+94764343952');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 57, 24),
(3, 58, 24),
(5, 59, 23),
(6, 60, 24),
(8, 61, 23),
(11, 62, 23),
(10, 62, 24),
(12, 63, 1),
(14, 64, 3),
(15, 65, 26),
(16, 66, 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_system_log`
--
ALTER TABLE `auth_system_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_system_modules`
--
ALTER TABLE `auth_system_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section` (`section`);

--
-- Indexes for table `auth_system_module_sections`
--
ALTER TABLE `auth_system_module_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_system_permissions`
--
ALTER TABLE `auth_system_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `group_id_2` (`group_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `module_id_2` (`module_id`),
  ADD KEY `view_access` (`view_access`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer_order`
--
ALTER TABLE `tbl_customer_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_menu_types`
--
ALTER TABLE `tbl_master_menu_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_reservation_type`
--
ALTER TABLE `tbl_master_reservation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_table`
--
ALTER TABLE `tbl_master_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_master_title`
--
ALTER TABLE `tbl_master_title`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_2` (`name`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `tbl_menu_items`
--
ALTER TABLE `tbl_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `auth_system_log`
--
ALTER TABLE `auth_system_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `auth_system_modules`
--
ALTER TABLE `auth_system_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `auth_system_module_sections`
--
ALTER TABLE `auth_system_module_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `auth_system_permissions`
--
ALTER TABLE `auth_system_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1093;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6508;

--
-- AUTO_INCREMENT for table `tbl_customer_order`
--
ALTER TABLE `tbl_customer_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_master_menu_types`
--
ALTER TABLE `tbl_master_menu_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_master_reservation_type`
--
ALTER TABLE `tbl_master_reservation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_master_table`
--
ALTER TABLE `tbl_master_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_master_title`
--
ALTER TABLE `tbl_master_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_menu_items`
--
ALTER TABLE `tbl_menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
