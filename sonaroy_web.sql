-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2025 at 07:33 AM
-- Server version: 8.0.42-0ubuntu0.24.04.2
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sonaroy_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `nationality` int DEFAULT NULL,
  `birth_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_nane` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `religion` int DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `class` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `admission_group` int DEFAULT NULL,
  `pre_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_class` int DEFAULT NULL,
  `pre_gpa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_board` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_roll` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_group` int DEFAULT NULL,
  `ssc_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_gpa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_transcript` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssc_testimonial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_country` int DEFAULT NULL,
  `pre_states` int DEFAULT NULL,
  `pre_city` int DEFAULT NULL,
  `per_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_country` int DEFAULT NULL,
  `per_states` int DEFAULT NULL,
  `per_city` int DEFAULT NULL,
  `loc_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loc_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loc_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loc_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loc_postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `admission_merits_id` int DEFAULT NULL,
  `mark` double NOT NULL DEFAULT '0',
  `tex_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_img` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_marks`
--

CREATE TABLE `admission_marks` (
  `id` bigint UNSIGNED NOT NULL,
  `admission_subjects_id` int DEFAULT NULL,
  `admissions_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mark` double NOT NULL DEFAULT '0',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_merits`
--

CREATE TABLE `admission_merits` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_subjects`
--

CREATE TABLE `admission_subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `total_mark` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admission_subjects`
--

INSERT INTO `admission_subjects` (`id`, `uuid`, `name`, `code`, `slug`, `photo`, `total_mark`, `class_id`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '0d4acba2-9df4-4f89-bea8-2edd1c57468c', 'Bangla', '111', 'bangla', NULL, 100, 11, 0, 1, 1, '2025-07-20 01:00:58', '2025-07-20 01:00:58'),
(2, 'a4941a56-951e-4d24-a1d8-9c7824c3f412', 'English', '112', 'english', NULL, 100, 11, 1, 1, 1, '2025-07-20 01:01:21', '2025-07-20 01:01:21');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `uuid`, `name`, `description`, `short_description`, `parent_id`, `order`, `photo`, `slug`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'c07e9f3e-79a6-4921-8799-54f61f7eb44e', 'PURCHASE ORDER', '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">PURCHASE ORDER</span></font><br>', NULL, 0, 6, '7-1699693415.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-11 03:03:35'),
(2, '2c9f53d3-dbec-41e6-b60f-9ac70c5e988e', 'ADMINISTRATIVE ORDER', '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">ADMINISTRATIVE ORDER</span></font><br>', NULL, 0, 5, '6-1699693395.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-11 03:03:15'),
(3, '2bd242d5-8d90-436d-8443-c88de12ef8f6', 'NAME AND AGE CORRECTION', '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">NAME AND AGE CORRECTION</span></font><br>', NULL, 0, 4, '5-1699693369.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-11 03:02:49'),
(4, '5eb5d89a-b42c-488a-a3ed-62e9a41ea3f8', 'HSC CORNER', '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">HSC CORNER</span></font><br>', NULL, 0, 2, '3-1699693318.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-11 03:01:58'),
(5, '8cd2913f-2e12-468e-bd1d-e16177209460', 'SSC CORNER', 'SSC CORNER', NULL, 0, 3, '4-1699693341.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-11 03:02:21'),
(6, '9c3cc781-259e-4013-b159-04287af279db', 'আমাদের সম্পর্কে', '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">About Us</span></font><br>', NULL, 0, 0, '1-1699693064.webp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-18 02:24:37'),
(8, '6febbb62-78a3-4454-bb77-8c244573d1e4', 'NATIONAL INTEGRITY STRATEGY', '<p>NATIONAL INTEGRITY STRATEGY<br></p>', NULL, 0, 1, '2-1699693290.webp', NULL, 1, 1, '2023-11-10 23:34:10', '2023-11-11 03:01:30'),
(9, '5e12a172-1f94-4df3-aa48-a36abd3f6d2f', 'RIGHT TO INFORMATION', '<p>RIGHT TO INFORMATION<br></p>', NULL, 0, 7, '8-1699693455.webp', NULL, 1, 1, '2023-11-10 23:43:35', '2023-11-11 03:04:15'),
(12, 'eb027251-f9f4-4a62-a1d2-8a558a8b5ee8', 'SERVICE PROCESS SIMPLIFICATION', '<p>SERVICE PROCESS SIMPLIFICATION<br></p>', NULL, 0, 8, '9-1699693474.webp', NULL, 1, 1, '2023-11-10 23:52:18', '2023-11-11 03:04:34'),
(14, '69fb14f0-1d02-4a33-abed-cf86475e7f18', 'Others', '<p>others</p>', NULL, 0, 9, '11-1699693535.webp', NULL, 1, 1, '2023-11-11 02:10:45', '2023-11-11 03:05:35'),
(15, '8f96f99a-6c56-45be-ba88-85b656650a68', 'Golden Jubilee of Independence', '<h4>Golden Jubilee of Independence</h4><p><br></p>', NULL, 0, 0, 'Dropped Image-1753091217.webp', NULL, 1, 1, '2025-07-21 03:46:57', '2025-07-21 03:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `categories_translations`
--

CREATE TABLE `categories_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories_translations`
--

INSERT INTO `categories_translations` (`lang_code`, `categories_id`, `name`, `short_description`, `description`) VALUES
('en_US', 6, 'About Us', NULL, '<font color=\"#202124\" face=\"dejavu sans mono, monospace\"><span style=\"font-size: 11px; white-space-collapse: preserve;\">About Us</span></font><br>');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int UNSIGNED NOT NULL,
  `country_id` int UNSIGNED DEFAULT NULL,
  `record_id` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `country_id`, `record_id`, `order`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Syedpur', 1, 1, NULL, 0, 0, '1', '2023-11-13 01:21:06', '2023-12-05 03:38:39'),
(2, 'Domar', 1, 1, NULL, 0, 0, '1', '2023-11-14 05:13:09', '2023-12-05 03:38:39'),
(3, 'Dimla', 1, 1, NULL, 0, 0, '1', '2023-11-14 05:13:28', '2023-12-05 03:38:39'),
(4, 'Jaldhaka', 1, 1, NULL, 0, 0, '1', '2023-11-14 23:53:18', '2023-12-05 03:38:39'),
(5, 'Kishorganj', 1, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(6, 'Nilphamari Sadar', 1, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(7, 'Nawabganj', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(8, 'Birganj', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(9, 'Ghoraghat', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(10, 'Birampur', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(11, 'Parbatipur', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(12, 'Bochaganj', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(13, 'Kaharol', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(14, 'Fulbari', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(15, 'Dinajpur Sadar', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(16, 'Hakimpur', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(17, 'Khansama', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(18, 'Birol', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(19, 'Chirirbandar', 2, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(20, 'Brahmanbaria Sadar', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(21, 'Kasba', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(22, 'Nasirnagar', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(23, 'Sarail', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(24, 'Ashuganj', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(25, 'Akhaura', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(26, 'Nabinagar', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(27, 'Bancharampur', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(28, 'Bijoynagar', 3, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(29, 'Rangamati Sadar', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(30, 'Kaptai', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(31, 'Kawkhali', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(32, 'Baghaichari', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(33, 'Barkal', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(34, 'Langadu', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(35, 'Rajasthali', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(36, 'Belaichari', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(37, 'Juraichari', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(38, 'Naniarchar', 4, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(39, 'Noakhali Sadar', 5, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(40, 'Companiganj', 5, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(41, 'Begumganj', 5, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(42, 'Hatia', 5, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(43, 'Subarnachar', 5, 1, NULL, 0, 0, '1', '2023-12-05 02:29:08', '2023-12-05 03:38:39'),
(44, 'Kabirhat', 5, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(45, 'Senbug', 5, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(46, 'Chatkhil', 5, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(47, 'Sonaimori', 5, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(48, 'Haimchar', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(49, 'Kachua', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(50, 'Shahrasti', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(51, 'Chandpur Sadar', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(52, 'Matlab South', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(53, 'Hajiganj', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(54, 'Matlab North', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(55, 'Faridgonj', 6, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(56, 'Lakshmipur Sadar', 7, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(57, 'Kamalnagar', 7, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(58, 'Raipur', 7, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(59, 'Ramgati', 7, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(60, 'Ramganj', 7, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(61, 'Rangunia', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(62, 'Sitakunda', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(63, 'Mirsharai', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(64, 'Patiya', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(65, 'Sandwip', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(66, 'Banshkhali', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(67, 'Boalkhali', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(68, 'Anwara', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(69, 'Chandanaish', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(70, 'Satkania', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(71, 'Lohagara', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(72, 'Hathazari', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(73, 'Fatikchhari', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(74, 'Raozan', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(75, 'Karnafuli', 8, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(76, 'Coxsbazar Sadar', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(77, 'Chakaria', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(78, 'Kutubdia', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(79, 'Ukhiya', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(80, 'Moheshkhali', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(81, 'Pekua', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(82, 'Ramu', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(83, 'Teknaf', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(84, 'Khagrachhari Sadar', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(85, 'Dighinala', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(86, 'Panchari', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(87, 'Laxmichhari', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(88, 'Mohalchari', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(89, 'Manikchari', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(90, 'Ramgarh', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(91, 'Matiranga', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(92, 'Guimara', 10, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(93, 'Bandarban Sadar', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(94, 'Alikadam', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(95, 'Naikhongchhari', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(96, 'Rowangchhari', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(97, 'Lama', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(98, 'Ruma', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(99, 'Thanchi', 11, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(100, 'Belkuchi', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(101, 'Chauhali', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(102, 'Kamarkhand', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(103, 'Kazipur', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(104, 'Raigonj', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(105, 'Shahjadpur', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(106, 'Sirajganj Sadar', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(107, 'Tarash', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(108, 'Ullapara', 12, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(109, 'Sujanagar', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(110, 'Ishurdi', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(111, 'Bhangura', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(112, 'Pabna Sadar', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(113, 'Bera', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(114, 'Atghoria', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(115, 'Chatmohar', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(116, 'Santhia', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(117, 'Faridpur', 13, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(118, 'Kahaloo', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(119, 'Bogra Sadar', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(120, 'Shariakandi', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(121, 'Shajahanpur', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(122, 'Dupchanchia', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(123, 'Adamdighi', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(124, 'Nondigram', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(125, 'Sonatala', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(126, 'Dhunot', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(127, 'Gabtali', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(128, 'Sherpur', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(129, 'Shibganj', 14, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(130, 'Paba', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(131, 'Durgapur', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(132, 'Mohonpur', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(133, 'Charghat', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(134, 'Puthia', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(135, 'Bagha', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(136, 'Godagari', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(137, 'Tanore', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(138, 'Bagmara', 15, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(139, 'Natore Sadar', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(140, 'Singra', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(141, 'Baraigram', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(142, 'Bagatipara', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(143, 'Lalpur', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(144, 'Gurudaspur', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(145, 'Naldanga', 16, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(146, 'Akkelpur', 17, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(147, 'Kalai', 17, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(148, 'Khetlal', 17, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(149, 'Panchbibi', 17, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(150, 'Joypurhat Sadar', 17, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(151, 'Chapainawabganj Sadar', 18, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(152, 'Gomostapur', 18, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(153, 'Nachol', 18, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(154, 'Bholahat', 18, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(155, 'Shibganj', 18, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(156, 'Mohadevpur', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(157, 'Badalgachi', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(158, 'Patnitala', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(159, 'Dhamoirhat', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(160, 'Niamatpur', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(161, 'Manda', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(162, 'Atrai', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(163, 'Raninagar', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(164, 'Naogaon Sadar', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(165, 'Porsha', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(166, 'Sapahar', 19, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(167, 'Manirampur', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(168, 'Abhaynagar', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(169, 'Bagherpara', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(170, 'Chougachha', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(171, 'Jhikargacha', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(172, 'Keshabpur', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(173, 'Jessore Sadar', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(174, 'Sharsha', 20, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(175, 'Assasuni', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(176, 'Debhata', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(177, 'Kalaroa', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(178, 'Satkhira Sadar', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(179, 'Shyamnagar', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(180, 'Tala', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(181, 'Kaliganj', 21, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(182, 'Mujibnagar', 22, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(183, 'Meherpur Sadar', 22, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(184, 'Gangni', 22, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(185, 'Narail Sadar', 23, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(186, 'Lohagara', 23, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(187, 'Kalia', 23, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(188, 'Chuadanga Sadar', 24, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(189, 'Alamdanga', 24, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(190, 'Damurhuda', 24, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(191, 'Jibannagar', 24, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(192, 'Kushtia Sadar', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(193, 'Kumarkhali', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(194, 'Khoksa', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(195, 'Mirpur', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(196, 'Daulatpur', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(197, 'Bheramara', 25, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(198, 'Shalikha', 26, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(199, 'Sreepur', 26, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(200, 'Magura Sadar', 26, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(201, 'Mohammadpur', 26, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(202, 'Paikgasa', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(203, 'Fultola', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(204, 'Digholia', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(205, 'Rupsha', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(206, 'Terokhada', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(207, 'Dumuria', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(208, 'Botiaghata', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(209, 'Dakop', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(210, 'Koyra', 27, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(211, 'Fakirhat', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(212, 'Bagerhat Sadar', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(213, 'Mollahat', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(214, 'Sarankhola', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(215, 'Rampal', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(216, 'Morrelganj', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(217, 'Kachua', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(218, 'Mongla', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(219, 'Chitalmari', 28, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(220, 'Jhenaidah Sadar', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(221, 'Shailkupa', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(222, 'Harinakundu', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(223, 'Kaliganj', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(224, 'Kotchandpur', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(225, 'Moheshpur', 29, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(226, 'Jhalakathi Sadar', 30, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(227, 'Kathalia', 30, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(228, 'Nalchity', 30, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(229, 'Rajapur', 30, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(230, 'Bauphal', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(231, 'Patuakhali Sadar', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(232, 'Dumki', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(233, 'Dashmina', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(234, 'Kalapara', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(235, 'Mirzaganj', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(236, 'Galachipa', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(237, 'Rangabali', 31, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(238, 'Pirojpur Sadar', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(239, 'Nazirpur', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(240, 'Kawkhali', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(241, 'Zianagar', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(242, 'Bhandaria', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(243, 'Mathbaria', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(244, 'Nesarabad', 32, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(245, 'Barisal Sadar', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(246, 'Bakerganj', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(247, 'Babuganj', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(248, 'Wazirpur', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(249, 'Banaripara', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(250, 'Gournadi', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(251, 'Agailjhara', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(252, 'Mehendiganj', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(253, 'Muladi', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(254, 'Hizla', 33, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(255, 'Bhola Sadar', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(256, 'Borhan Sddin', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(257, 'Charfesson', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(258, 'Doulatkhan', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(259, 'Monpura', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(260, 'Tazumuddin', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(261, 'Lalmohan', 34, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(262, 'Amtali', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(263, 'Barguna Sadar', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(264, 'Betagi', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(265, 'Bamna', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(266, 'Pathorghata', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(267, 'Taltali', 35, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(268, 'Balaganj', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(269, 'Beanibazar', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(270, 'Bishwanath', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(271, 'Companiganj', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(272, 'Fenchuganj', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(273, 'Golapganj', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(274, 'Gowainghat', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(275, 'Jaintiapur', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(276, 'Kanaighat', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(277, 'Sylhet Sadar', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(278, 'Zakiganj', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(279, 'Dakshinsurma', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(280, 'Osmaninagar', 36, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(281, 'Barlekha', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(282, 'Kamolganj', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(283, 'Kulaura', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(284, 'Moulvibazar Sadar', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(285, 'Rajnagar', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(286, 'Sreemangal', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(287, 'Juri', 37, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(288, 'Nabiganj', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(289, 'Bahubal', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(290, 'Ajmiriganj', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(291, 'Baniachong', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(292, 'Lakhai', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(293, 'Chunarughat', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(294, 'Habiganj Sadar', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(295, 'Madhabpur', 38, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(296, 'Sunamganj Sadar', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(297, 'South Sunamganj', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(298, 'Bishwambarpur', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(299, 'Chhatak', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(300, 'Jagannathpur', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(301, 'Dowarabazar', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(302, 'Tahirpur', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(303, 'Dharmapasha', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(304, 'Jamalganj', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(305, 'Shalla', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(306, 'Derai', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(307, 'Belabo', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(308, 'Monohardi', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(309, 'Narsingdi Sadar', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(310, 'Palash', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(311, 'Raipura', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(312, 'Shibpur', 40, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(313, 'Kaliganj', 41, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(314, 'Kaliakair', 41, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(315, 'Kapasia', 41, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(316, 'Gazipur Sadar', 41, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(317, 'Sreepur', 41, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(318, 'Shariatpur Sadar', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(319, 'Naria', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(320, 'Zajira', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(321, 'Gosairhat', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(322, 'Bhedarganj', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(323, 'Damudya', 42, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(324, 'Araihazar', 43, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(325, 'Bandar', 43, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(326, 'Narayanganj Sadar', 43, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(327, 'Rupganj', 43, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(328, 'Sonargaon', 43, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(329, 'Basail', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(330, 'Bhuapur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(331, 'Delduar', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(332, 'Ghatail', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(333, 'Gopalpur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(334, 'Madhupur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(335, 'Mirzapur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(336, 'Nagarpur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(337, 'Sakhipur', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(338, 'Tangail Sadar', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(339, 'Kalihati', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(340, 'Dhanbari', 44, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(341, 'Itna', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(342, 'Katiadi', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(343, 'Bhairab', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(344, 'Tarail', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(345, 'Hossainpur', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(346, 'Pakundia', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(347, 'Kuliarchar', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(348, 'Kishoreganj Sadar', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(349, 'Karimgonj', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(350, 'Bajitpur', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(351, 'Austagram', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(352, 'Mithamoin', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(353, 'Nikli', 45, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(354, 'Harirampur', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(355, 'Saturia', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(356, 'Manikganj Sadar', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(357, 'Gior', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(358, 'Shibaloy', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(359, 'Doulatpur', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(360, 'Singiar', 46, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(361, 'Savar', 47, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(362, 'Dhamrai', 47, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(363, 'Keraniganj', 47, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(364, 'Nawabganj', 47, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(365, 'Dohar', 47, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(366, 'Munshiganj Sadar', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(367, 'Sreenagar', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(368, 'Sirajdikhan', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(369, 'Louhajanj', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(370, 'Gajaria', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(371, 'Tongibari', 48, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(372, 'Rajbari Sadar', 49, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(373, 'Goalanda', 49, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(374, 'Pangsa', 49, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(375, 'Baliakandi', 49, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(376, 'Kalukhali', 49, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(377, 'Madaripur Sadar', 50, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(378, 'Shibchar', 50, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(379, 'Kalkini', 50, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(380, 'Rajoir', 50, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(381, 'Gopalganj Sadar', 51, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(382, 'Kashiani', 51, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(383, 'Tungipara', 51, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(384, 'Kotalipara', 51, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(385, 'Muksudpur', 51, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(386, 'Faridpur Sadar', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(387, 'Alfadanga', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(388, 'Boalmari', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(389, 'Sadarpur', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(390, 'Nagarkanda', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(391, 'Bhanga', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(392, 'Charbhadrasan', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(393, 'Madhukhali', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(394, 'Saltha', 52, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(395, 'Panchagarh Sadar', 53, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(396, 'Debiganj', 53, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(397, 'Boda', 53, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(398, 'Atwari', 53, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(399, 'Tetulia', 53, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(400, 'Chhagalnaiya', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(401, 'Feni Sadar', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(402, 'Sonagazi', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(403, 'Fulgazi', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(404, 'Parshuram', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(405, 'Daganbhuiyan', 54, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(406, 'Lalmonirhat Sadar', 55, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(407, 'Kaliganj', 55, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(408, 'Hatibandha', 55, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(409, 'Patgram', 55, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(410, 'Aditmari', 55, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(411, 'Debidwar', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(412, 'Barura', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(413, 'Brahmanpara', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(414, 'Chandina', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(415, 'Chauddagram', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(416, 'Daudkandi', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(417, 'Homna', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(418, 'Laksam', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(419, 'Muradnagar', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(420, 'Nangalkot', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(421, 'Comilla Sadar', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(422, 'Meghna', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(423, 'Monohargonj', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(424, 'Sadarsouth', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(425, 'Titas', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(426, 'Burichang', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(427, 'Lalmai', 56, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(428, 'Sadullapur', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(429, 'Gaibandha Sadar', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(430, 'Palashbari', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(431, 'Saghata', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(432, 'Gobindaganj', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(433, 'Sundarganj', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(434, 'Phulchari', 57, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(435, 'Thakurgaon Sadar', 58, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(436, 'Pirganj', 58, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(437, 'Ranisankail', 58, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(438, 'Haripur', 58, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(439, 'Baliadangi', 58, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(440, 'Rangpur Sadar', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(441, 'Gangachara', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(442, 'Taragonj', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(443, 'Badargonj', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(444, 'Mithapukur', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(445, 'Pirgonj', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(446, 'Kaunia', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(447, 'Pirgacha', 59, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(448, 'Kurigram Sadar', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(449, 'Nageshwari', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(450, 'Bhurungamari', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(451, 'Phulbari', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(452, 'Rajarhat', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(453, 'Ulipur', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(454, 'Chilmari', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(455, 'Rowmari', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(456, 'Charrajibpur', 60, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(457, 'Sherpur Sadar', 61, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(458, 'Nalitabari', 61, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(459, 'Sreebordi', 61, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(460, 'Nokla', 61, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(461, 'Jhenaigati', 61, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(462, 'Fulbaria', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(463, 'Trishal', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(464, 'Bhaluka', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(465, 'Muktagacha', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(466, 'Mymensingh Sadar', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(467, 'Dhobaura', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(468, 'Phulpur', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(469, 'Haluaghat', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(470, 'Gouripur', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(471, 'Gafargaon', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(472, 'Iswarganj', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(473, 'Nandail', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(474, 'Tarakanda', 62, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(475, 'Jamalpur Sadar', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(476, 'Melandah', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(477, 'Islampur', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(478, 'Dewangonj', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(479, 'Sarishabari', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(480, 'Madarganj', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(481, 'Bokshiganj', 63, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(482, 'Barhatta', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(483, 'Durgapur', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(484, 'Kendua', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(485, 'Atpara', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(486, 'Madan', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(487, 'Khaliajuri', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(488, 'Kalmakanda', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(489, 'Mohongonj', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(490, 'Purbadhala', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(491, 'Netrokona Sadar', 64, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(492, 'Eidgaon', 9, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(493, 'Madhyanagar', 39, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39'),
(494, 'Dasar', 50, 1, NULL, 0, 0, '1', '2023-12-05 03:28:23', '2023-12-05 03:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `cities_translations`
--

CREATE TABLE `cities_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cities_id` int NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_forms`
--

CREATE TABLE `contact_forms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_forms`
--

INSERT INTO `contact_forms` (`id`, `name`, `email`, `phone`, `address`, `subject`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kamrul Islam', 'kamrul@gmail.com', '01738256825', 'Dhanmondi', 'Your site detail', 'Here are some of the most useful online tools that will help you know every single detail of any website', '1', '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(2, 'Farhan Tanvir', 'farhan@gmail.com', '017', 'gulshn', 'Website Checker', 'The Website Checker analyzes your website to see how well equipped it is for success online, and gives you tips on how you can improve it.', '1', '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(3, 'Grade 10', 'kamrul@gmail.com', '01738256825', NULL, 'SQL file upload', 'xfgesfv', 'unread', '2023-10-29 03:50:41', '2023-10-29 03:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_replies`
--

CREATE TABLE `contact_form_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_form_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_form_replies`
--

INSERT INTO `contact_form_replies` (`id`, `message`, `contact_form_id`, `created_at`, `updated_at`) VALUES
(1, 'Here are some of the most useful online tools that will help you know every single detail of any website', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(2, 'The Website Checker analyzes your website to see how well equipped it is for success online, and gives you tips on how you can improve it.', 2, '2023-08-30 01:04:10', '2023-08-30 01:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `nationality`, `order`, `is_default`, `status`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', 'Bangladeshi', 0, 1, '1', 'BD', '2023-11-13 01:17:45', '2023-12-05 03:38:39'),
(2, 'India', 'Inidan', 1, 0, '1', 'IND', '2023-11-14 23:50:39', '2023-11-14 23:50:39');

-- --------------------------------------------------------

--
-- Table structure for table `countries_translations`
--

CREATE TABLE `countries_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `countries_id` int NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dashboards`
--

CREATE TABLE `dashboards` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_widgets`
--

CREATE TABLE `dashboard_widgets` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dashboard_widgets`
--

INSERT INTO `dashboard_widgets` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'widget_total_themes', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(2, 'widget_total_users', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(3, 'widget_total_pages', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(4, 'widget_total_plugins', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(5, 'widget_analytics_general', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(6, 'widget_analytics_page', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(7, 'widget_analytics_browser', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(8, 'widget_posts_recent', '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(9, 'widget_analytics_referrer', '2023-08-30 01:04:10', '2023-08-30 01:04:42');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_widget_settings`
--

CREATE TABLE `dashboard_widget_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int UNSIGNED NOT NULL,
  `widget_id` int UNSIGNED NOT NULL,
  `order` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs_translations`
--

CREATE TABLE `faqs_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faqs_id` int NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories_translations`
--

CREATE TABLE `faq_categories_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq_categories_id` int NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamrul_dashboards`
--

CREATE TABLE `kamrul_dashboards` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `key_facilities`
--

CREATE TABLE `key_facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `key_facilities`
--

INSERT INTO `key_facilities` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '4f8256be-75ac-4770-a8bf-b05be4862b77', 'Wifi Coverage', 'wifi-coverage', NULL, NULL, 1, 1, '2023-10-22 23:03:59', '2023-10-22 23:03:59'),
(2, 'bdce6a9d-dd39-43b2-9687-3bfab3000e72', 'Cleaning & Staff Support', 'cleaning-staff-support', NULL, NULL, 1, 1, '2023-10-22 23:04:07', '2023-10-22 23:04:07'),
(3, 'd7ae0844-978c-4bff-8b6f-7582468e9525', 'Free Parking', 'free-parking', NULL, NULL, 1, 1, '2023-10-22 23:04:14', '2023-10-22 23:04:14'),
(4, '795169c3-6bb5-43f5-870d-74cd567e3b00', 'Seating Chair', 'seating-chair', NULL, NULL, 1, 1, '2023-10-22 23:04:22', '2023-10-22 23:04:22'),
(5, '44e18f29-f6f6-44d2-beb3-678a537969ef', 'Stair for stage', 'stair-for-stage', NULL, NULL, 1, 1, '2023-10-22 23:04:30', '2023-10-22 23:04:30');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `lang_id` int UNSIGNED NOT NULL,
  `lang_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_locale` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_flag` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_is_default` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `lang_order` int NOT NULL DEFAULT '0',
  `lang_is_rtl` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`lang_id`, `lang_name`, `lang_locale`, `lang_code`, `lang_flag`, `lang_is_default`, `lang_order`, `lang_is_rtl`) VALUES
(3, 'English', 'en', 'en_US', 'us', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `language_meta`
--

CREATE TABLE `language_meta` (
  `lang_meta_id` int UNSIGNED NOT NULL,
  `lang_meta_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lang_meta_origin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int UNSIGNED NOT NULL,
  `reference_type` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_meta`
--

INSERT INTO `language_meta` (`lang_meta_id`, `lang_meta_code`, `lang_meta_origin`, `reference_id`, `reference_type`) VALUES
(8, 'en_US', 'a6a18722be2a97e7b59ff05218150891', 1, 'Modules\\Menus\\Http\\Models\\Menus'),
(9, 'en_US', '0f28938a0b516f63be6db2a8241adeef', 3, 'Modules\\Menus\\Http\\Models\\Menus'),
(10, 'en_US', '2e4b76d97fc5c38ec30d6f4bfa34375b', 8, 'Modules\\Menus\\Http\\Models\\Menus'),
(11, 'en_US', 'b27016757ddeab241dd81ca67a4463e4', 1, 'Modules\\Menus\\Http\\Models\\MenusLocation'),
(12, 'en_US', 'e533b6701b0a2901e6cffac6dc8aee89', 3, 'Modules\\Menus\\Http\\Models\\MenusLocation'),
(13, 'en_US', '6430af9b85d52fe7fe67f287d9434168', 4, 'Modules\\Menus\\Http\\Models\\MenusLocation'),
(14, 'en_US', '8b205e04ec4f106d16a090f68724b520', 1, 'Modules\\SimpleSlider\\Http\\Models\\SimpleSlider');

-- --------------------------------------------------------

--
-- Table structure for table `menuses`
--

CREATE TABLE `menuses` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menuses`
--

INSERT INTO `menuses` (`id`, `uuid`, `name`, `slug`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'ac909456-b449-4242-8dfa-bf302c72aa13', 'Main Menu', 'main-menu', 1, 1, '2023-08-30 01:04:10', '2025-07-23 05:32:55'),
(3, '006dd152-12de-4a3a-a193-3f49d90e73e4', 'Footer menu', 'footer-menu', 1, 1, '2023-08-30 01:04:10', '2023-09-19 02:39:18'),
(8, NULL, 'Main Menu Right', 'main-menu-right', 1, 1, '2023-09-11 01:01:50', '2023-11-13 04:57:01'),
(9, NULL, 'Main Menu', 'main-menu-1', 1, 1, '2023-11-18 22:43:16', '2023-11-18 23:19:14'),
(10, NULL, 'Footer menu', 'footer-menu-1', 1, 1, '2023-11-18 22:44:29', '2023-11-18 22:44:47'),
(11, NULL, 'Main Menu Right', 'main-menu-right-1', 1, 1, '2023-11-18 22:45:22', '2023-11-18 22:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `menus_locations`
--

CREATE TABLE `menus_locations` (
  `id` bigint UNSIGNED NOT NULL,
  `menus_id` int UNSIGNED NOT NULL,
  `location` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_locations`
--

INSERT INTO `menus_locations` (`id`, `menus_id`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 'main-menu', '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(3, 3, 'footer-menu', '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(4, 8, 'header-menu', '2023-09-11 01:05:02', '2023-09-11 01:05:02'),
(5, 10, 'footer-menu', '2023-11-18 22:44:47', '2023-11-18 22:44:47'),
(7, 9, 'main-menu', '2023-11-18 22:48:09', '2023-11-18 22:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus_nodes`
--

CREATE TABLE `menus_nodes` (
  `id` bigint UNSIGNED NOT NULL,
  `menus_id` bigint UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sort` int NOT NULL DEFAULT '0',
  `depth` int NOT NULL DEFAULT '0',
  `reference_id` int UNSIGNED DEFAULT NULL,
  `reference_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_font` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_class` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` enum('_self','_blank') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `has_child` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_nodes`
--

INSERT INTO `menus_nodes` (`id`, `menus_id`, `parent_id`, `sort`, `depth`, `reference_id`, `reference_type`, `url`, `icon_font`, `position`, `title`, `css_class`, `target`, `has_child`, `created_at`, `updated_at`) VALUES
(10, 1, 0, 0, 0, 3, 'Modules\\Post\\Http\\Models\\Page', '/about', '', 1, 'About', '', '_self', 0, '2023-09-19 02:36:44', '2023-11-09 03:43:15'),
(14, 1, 0, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 5, 'Contact Us', '', '_self', 0, '2023-09-19 02:36:44', '2025-07-23 05:18:20'),
(15, 3, 0, 0, 0, 3, 'Modules\\Post\\Http\\Models\\Page', '/about', '', 0, 'About Us', '', '_self', 0, '2023-09-19 02:37:36', '2023-09-19 02:39:18'),
(16, 3, 0, 0, 0, 13, 'Modules\\Post\\Http\\Models\\Page', '/blog', '', 1, 'Blog', '', '_self', 0, '2023-09-19 02:37:36', '2023-09-19 02:39:18'),
(17, 3, 0, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 3, 'Contac', '', '_self', 0, '2023-09-19 02:37:36', '2023-09-19 02:39:18'),
(23, 8, 0, 0, 0, 12, 'Modules\\Post\\Http\\Models\\Page', '/gallery', '', 2, 'Gallery', '', '_self', 0, '2023-09-19 02:38:59', '2023-11-13 04:57:02'),
(24, 8, 0, 0, 0, 13, 'Modules\\Post\\Http\\Models\\Page', '/blog', '', 3, 'Blog', '', '_self', 0, '2023-09-19 02:38:59', '2023-11-13 04:57:02'),
(25, 3, 0, 0, 0, 14, 'Modules\\Post\\Http\\Models\\Page', '/terms-and-conditions', NULL, 2, 'Terms And Conditions', NULL, '_self', 0, '2023-09-19 02:39:18', '2023-09-19 02:39:18'),
(26, 1, 37, 0, 0, 12, 'Modules\\Post\\Http\\Models\\Page', '/gallery', '', 0, 'Gallery', '', '_self', 0, '2023-10-30 00:31:54', '2023-11-13 03:31:48'),
(31, 1, 37, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 1, 'Contact Us', '', '_self', 0, '2023-11-09 03:35:36', '2025-07-23 05:32:55'),
(32, 1, 38, 0, 0, 3, 'Modules\\Post\\Http\\Models\\Page', '/about', '', 1, 'About', '', '_self', 0, '2023-11-09 03:35:36', '2025-07-23 05:32:55'),
(33, 1, 38, 0, 0, 13, 'Modules\\Post\\Http\\Models\\Page', '/blog', '', 3, 'Blog', '', '_self', 0, '2023-11-09 03:35:36', '2025-07-23 05:32:55'),
(34, 1, 0, 0, 0, 1, 'Modules\\Post\\Http\\Models\\Page', '', '', 0, 'Homepage', 'home', '_self', 0, '2023-11-09 03:43:15', '2023-11-09 04:36:56'),
(35, 1, 38, 0, 0, 10, 'Modules\\Post\\Http\\Models\\Page', '/news', '', 2, 'News', '', '_self', 0, '2023-11-12 02:54:21', '2025-07-23 05:32:55'),
(36, 1, 0, 0, 0, 0, NULL, '#', '', 2, 'বোর্ড সম্পর্কিত', '', '_self', 1, '2023-11-13 03:31:48', '2025-07-23 05:18:20'),
(37, 1, 0, 0, 0, 0, NULL, '#', '', 3, 'Drop down', '', '_self', 1, '2023-11-13 03:31:48', '2023-11-14 21:02:10'),
(38, 1, 0, 0, 0, 0, NULL, '#', '', 4, 'Admission', '', '_self', 1, '2023-11-14 21:02:10', '2025-07-23 05:18:20'),
(39, 1, 38, 0, 0, 16, 'Modules\\Post\\Http\\Models\\Page', '/admission-form', '', 0, 'Admission Form', '', '_self', 0, '2023-11-14 21:02:10', '2025-07-23 05:15:56'),
(40, 9, 0, 0, 0, 3, 'Modules\\Post\\Http\\Models\\Page', '/about', '', 1, 'About', '', '_self', 0, '2023-11-18 22:43:42', '2023-11-18 23:19:14'),
(41, 9, 0, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 2, 'Contact Us', '', '_self', 0, '2023-11-18 22:43:43', '2023-11-18 23:19:14'),
(42, 9, 0, 0, 0, 16, 'Modules\\Post\\Http\\Models\\Page', '/admission-form', '', 3, 'Admission Form', '', '_self', 0, '2023-11-18 22:43:43', '2023-11-18 23:19:14'),
(43, 9, 0, 0, 0, 0, NULL, '#', '', 4, 'Drop Down', '', '_self', 1, '2023-11-18 22:43:43', '2023-11-18 23:19:14'),
(44, 9, 43, 0, 0, 13, 'Modules\\Post\\Http\\Models\\Page', '/blog', '', 0, 'Blog', '', '_self', 0, '2023-11-18 22:44:02', '2023-11-18 22:44:05'),
(45, 9, 43, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 1, 'Contact Us', '', '_self', 0, '2023-11-18 22:44:02', '2023-11-18 22:44:05'),
(47, 9, 43, 0, 0, 14, 'Modules\\Post\\Http\\Models\\Page', '/terms-and-conditions', '', 3, 'Terms And Conditions', '', '_self', 0, '2023-11-18 22:44:02', '2023-11-18 22:44:05'),
(49, 10, 0, 0, 0, 3, 'Modules\\Post\\Http\\Models\\Page', '/about', '', 0, 'About', '', '_self', 0, '2023-11-18 22:44:41', '2023-11-18 22:44:47'),
(50, 10, 0, 0, 0, 2, 'Modules\\Post\\Http\\Models\\Page', '/contact-us', '', 1, 'Contact Us', '', '_self', 0, '2023-11-18 22:44:41', '2023-11-18 22:44:47'),
(51, 10, 0, 0, 0, 12, 'Modules\\Post\\Http\\Models\\Page', '/gallery', '', 2, 'Gallery', '', '_self', 0, '2023-11-18 22:44:41', '2023-11-18 22:44:47'),
(53, 11, 0, 0, 0, 14, 'Modules\\Post\\Http\\Models\\Page', '/terms-and-conditions', NULL, 1, 'Terms And Conditions', NULL, '_self', 0, '2023-11-18 22:45:39', '2023-11-18 22:45:39'),
(56, 9, 0, 0, 0, 1, 'Modules\\Post\\Http\\Models\\Page', '', NULL, 0, 'Homepage', 'home', '_self', 0, '2023-11-18 23:19:14', '2023-11-18 23:19:14'),
(57, 1, 36, 0, 0, 17, 'Modules\\Post\\Http\\Models\\Page', '/itihas', '', 0, 'ইতিহাস', '', '_self', 0, '2025-07-23 05:18:20', '2025-07-23 05:27:58'),
(58, 1, 36, 0, 0, 18, 'Modules\\Post\\Http\\Models\\Page', '/ceyarmzan-mhodyer-jeebnee', '', 1, 'চেয়ারম্যান মহোদয়ের জীবনী', '', '_self', 0, '2025-07-23 05:27:58', '2025-07-23 05:32:55');

-- --------------------------------------------------------

--
-- Table structure for table `meta_boxes`
--

CREATE TABLE `meta_boxes` (
  `id` bigint UNSIGNED NOT NULL,
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int UNSIGNED NOT NULL,
  `reference_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_boxes`
--

INSERT INTO `meta_boxes` (`id`, `meta_key`, `meta_value`, `reference_id`, `reference_type`, `created_at`, `updated_at`) VALUES
(3, 'seo_meta', '[{\"seo_description\":\"Contact Us\"}]', 2, 'Modules\\Post\\Http\\Models\\Page', '2023-09-09 00:39:49', '2023-09-09 00:39:49'),
(16, 'dsc_addition', '[{\"dsc_capacity\":\"501\",\"dsc_seats\":\"301\",\"dsc_hourly_rent\":\"6350\",\"dsc_currency\":\"BDT\",\"dsc_boards\":\"3\",\"dsc_inch\":\"80\"}]', 15, 'Modules\\Post\\Http\\Models\\Post', '2023-09-09 05:31:55', '2023-10-24 22:13:16'),
(17, 'dsc_addition', '[{\"dsc_capacity\":\"450\",\"dsc_seats\":\"250\",\"dsc_hourly_rent\":\"5500\",\"dsc_currency\":\"BDT\",\"dsc_boards\":\"3\",\"dsc_inch\":\"80\"}]', 16, 'Modules\\Post\\Http\\Models\\Post', '2023-09-09 23:51:37', '2023-09-09 23:52:26'),
(18, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 17, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 00:46:51', '2023-09-10 00:46:51'),
(19, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 18, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 01:04:46', '2023-09-10 01:04:46'),
(20, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 19, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 01:08:19', '2023-09-10 01:08:19'),
(21, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 20, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 01:09:41', '2023-09-10 01:09:41'),
(22, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 21, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:05:41', '2023-09-10 03:05:41'),
(23, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 22, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:08:20', '2023-09-10 03:08:20'),
(24, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 23, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:23:53', '2023-09-10 03:23:53'),
(25, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 24, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:24:23', '2023-09-10 03:24:23'),
(26, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 25, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:25:16', '2023-09-10 03:25:16'),
(27, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 26, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 03:25:39', '2023-09-10 03:25:39'),
(28, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 27, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:09:41', '2023-09-10 04:09:41'),
(29, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 28, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:11:10', '2023-09-10 04:11:10'),
(30, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 29, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:11:55', '2023-09-10 04:11:55'),
(31, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 30, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:12:41', '2023-09-10 04:12:41'),
(32, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 31, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:13:30', '2023-09-10 04:13:30'),
(33, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 32, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 04:13:50', '2023-09-10 04:13:50'),
(34, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 33, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 05:46:40', '2023-09-10 05:46:40'),
(35, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 34, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 23:30:51', '2023-09-10 23:30:51'),
(36, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 35, 'Modules\\Post\\Http\\Models\\Post', '2023-09-10 23:31:41', '2023-09-10 23:31:41'),
(37, 'venuefacility', '[[\"1\",\"2\",\"3\",\"4\"]]', 15, 'Modules\\Post\\Http\\Models\\Post', '2023-10-22 03:26:21', '2023-10-29 23:00:42'),
(38, 'keyfacility', '[[\"1\",\"3\",\"4\",\"5\"]]', 15, 'Modules\\Post\\Http\\Models\\Post', '2023-10-22 23:18:30', '2023-10-24 22:12:52'),
(39, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 36, 'Modules\\Post\\Http\\Models\\Post', '2023-10-29 23:12:55', '2023-10-29 23:12:55'),
(40, 'venuefacility', '[[\"2\",\"3\"]]', 32, 'Modules\\Post\\Http\\Models\\Post', '2023-10-29 23:24:25', '2023-10-29 23:24:25'),
(41, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 37, 'Modules\\Post\\Http\\Models\\Post', '2023-10-29 23:40:52', '2023-10-29 23:40:52'),
(42, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 38, 'Modules\\Post\\Http\\Models\\Post', '2023-10-29 23:42:33', '2023-10-29 23:42:33'),
(43, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 39, 'Modules\\Post\\Http\\Models\\Post', '2023-10-29 23:43:41', '2023-10-29 23:43:41'),
(44, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 40, 'Modules\\Post\\Http\\Models\\Post', '2023-10-30 00:01:35', '2023-10-30 00:01:35'),
(45, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 41, 'Modules\\Post\\Http\\Models\\Post', '2023-10-30 00:03:28', '2023-10-30 00:03:28'),
(46, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 42, 'Modules\\Post\\Http\\Models\\Post', '2023-10-30 00:04:21', '2023-10-30 00:04:21'),
(47, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 43, 'Modules\\Post\\Http\\Models\\Post', '2023-10-30 01:20:31', '2023-10-30 01:20:31'),
(48, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 44, 'Modules\\Post\\Http\\Models\\Post', '2023-10-31 00:42:34', '2023-10-31 00:42:34'),
(49, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 45, 'Modules\\Post\\Http\\Models\\Post', '2023-11-10 22:54:10', '2023-11-10 22:54:10'),
(50, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 46, 'Modules\\Post\\Http\\Models\\Post', '2023-11-10 22:56:15', '2023-11-10 22:56:15'),
(51, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 47, 'Modules\\Post\\Http\\Models\\Post', '2023-11-10 22:56:33', '2023-11-10 22:56:33'),
(52, 'dsc_addition', '[{\"dsc_capacity\":null,\"dsc_seats\":null,\"dsc_hourly_rent\":null,\"dsc_currency\":null,\"dsc_boards\":null,\"dsc_inch\":null}]', 48, 'Modules\\Post\\Http\\Models\\Post', '2023-11-10 23:01:51', '2023-11-10 23:01:51'),
(53, 'layout', '[\"post-right-sidebar\"]', 28, 'Modules\\Post\\Http\\Models\\Post', '2023-11-11 05:38:00', '2023-11-11 05:48:42'),
(54, 'layout', '[\"post-right-sidebar\"]', 15, 'Modules\\Post\\Http\\Models\\Post', '2023-11-12 01:23:43', '2023-11-12 01:23:43'),
(55, 'layout', '[\"post-right-sidebar\"]', 50, 'Modules\\Post\\Http\\Models\\Post', '2023-11-12 02:25:13', '2023-11-12 02:28:25'),
(56, 'layout', '[null]', 48, 'Modules\\Post\\Http\\Models\\Post', '2023-11-12 22:46:05', '2023-11-12 22:46:05'),
(57, 'layout', '[null]', 47, 'Modules\\Post\\Http\\Models\\Post', '2023-11-12 23:21:08', '2023-11-12 23:21:08'),
(58, 'layout', '[null]', 51, 'Modules\\Post\\Http\\Models\\Post', '2023-11-12 23:25:34', '2023-11-12 23:25:34'),
(59, 'layout', '[null]', 21, 'Modules\\Post\\Http\\Models\\Post', '2023-11-18 02:26:32', '2023-11-18 02:26:32'),
(60, 'layout', '[null]', 52, 'Modules\\Post\\Http\\Models\\Post', '2023-12-04 02:48:26', '2023-12-04 02:48:26'),
(61, 'layout', '[null]', 53, 'Modules\\Post\\Http\\Models\\Post', '2025-07-21 03:49:47', '2025-07-21 03:49:47'),
(62, 'layout', '[null]', 33, 'Modules\\Post\\Http\\Models\\Post', '2025-07-21 03:57:01', '2025-07-21 03:57:01'),
(63, 'layout', '[null]', 54, 'Modules\\Post\\Http\\Models\\Post', '2025-07-23 04:12:07', '2025-07-23 04:12:07'),
(64, 'layout', '[null]', 55, 'Modules\\Post\\Http\\Models\\Post', '2025-07-23 04:14:13', '2025-07-23 04:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_01_01_008642_create_role_table', 1),
(6, '2022_02_02_101949_create_dashboards_table', 1),
(7, '2022_02_03_052231_create_plugins_table', 1),
(8, '2022_02_03_065349_create_systems_table', 1),
(9, '2022_02_03_065802_create_currencies_table', 1),
(10, '2022_02_13_092231_create_settings_table', 1),
(11, '2022_02_19_110953_add_paid_to_users_table', 1),
(12, '2022_02_19_528967_create_kamruldashboard_table', 1),
(13, '2022_02_24_000002_create_permissions_table', 1),
(14, '2022_03_01_094948_create_role_permissions_table', 1),
(15, '2022_03_09_734729_create_posttype_table', 1),
(16, '2022_03_15_049188_create_category_table', 1),
(17, '2022_03_15_949251_create_post_table', 1),
(18, '2022_03_15_954947_create_post_categories_table', 1),
(19, '2022_07_26_502330_create_pagetemplate_table', 1),
(20, '2022_07_26_512136_create_page_table', 1),
(21, '2022_07_27_648463_create_themeicon_table', 1),
(22, '2022_09_19_848740_create_menus_table', 1),
(23, '2022_10_03_009188_create_post_gallery_table', 1),
(24, '2022_10_03_014947_create_post_gallery_parameter_table', 1),
(25, '2022_10_04_881489_create_shortcodes_table', 1),
(26, '2022_10_13_983938_create_contactform_table', 1),
(27, '2022_11_01_071621_create_setting_data_table', 1),
(28, '2022_11_05_074227_create_slug_table', 1),
(29, '2022_11_22_084227_create_meta_box_table', 1),
(30, '2022_11_22_433327_create_newsletter_table', 1),
(31, '2023_01_23_452841_create_dashboard_widget_tables', 1),
(32, '2023_02_04_488918_create_widget_table', 1),
(33, '2023_02_15_977883_create_language_table', 1),
(34, '2023_02_19_408370_create_translation_table', 1),
(35, '2023_02_25_089131_create_fix_priority_load_for_language_advanced_table', 1),
(36, '2023_02_25_299138_create_page_translations_table', 1),
(37, '2023_03_20_1001238_create_categories_translations_table', 1),
(38, '2023_03_20_100138_create_posts_translations_table', 1),
(39, '2023_04_06_100094_create_location_translations_table', 1),
(40, '2023_04_06_100610_create_country_table', 1),
(41, '2023_04_06_138413_create_state_table', 1),
(42, '2023_04_06_879243_create_city_table', 1),
(43, '2023_06_10_127062_create_faq_table', 1),
(44, '2023_06_10_133387_create_faqcategory_table', 1),
(45, '2023_08_01_710541_create_simpleslider_table', 1),
(46, '2023_10_22_465934_create_vanufacility_table', 2),
(47, '2023_10_22_536036_create_venuefacility_table', 3),
(48, '2023_10_23_106127_create_keyfacility_table', 4),
(49, '2023_11_14_853481_create_option_table', 5),
(51, '2023_11_14_149844_create_optionclass_table', 6),
(52, '2023_11_14_146971_create_optionyear_table', 7),
(53, '2023_11_14_514192_create_optiongroup_table', 8),
(54, '2023_11_14_403231_create_optionsection_table', 9),
(56, '2023_11_14_605026_create_optionreligion_table', 11),
(57, '2023_11_14_714113_create_optiongender_table', 11),
(62, '2023_12_06_250344_create_optionsubject_table', 16),
(63, '2023_11_14_526825_create_admission_table', 17),
(64, '2023_11_28_269145_create_admissionsubject_table', 17),
(65, '2023_11_28_602219_create_admissionmark_table', 17),
(66, '2023_11_30_402692_create_admissionmerit_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int NOT NULL DEFAULT '0',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Subscribed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `option_classes`
--

CREATE TABLE `option_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_classes`
--

INSERT INTO `option_classes` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'bc5ae84c-c367-467b-b11a-f997768d7306', 'One', 'one', NULL, NULL, 0, 1, 1, '2023-11-14 00:06:55', '2025-07-20 00:41:22'),
(2, 'cf518c66-2c78-4f17-b9e1-743f5ba0b08a', 'Two', 'two', NULL, NULL, 1, 1, 1, '2023-11-14 00:07:09', '2025-07-20 00:41:22'),
(3, '272d9ddc-d66c-4773-9fed-5e406acd8732', 'Three', 'three', NULL, NULL, 2, 1, 1, '2023-11-14 00:07:25', '2025-07-20 00:41:22'),
(4, 'fa798b18-e9f1-45fb-9300-1808ed907eb1', 'Four', 'four', NULL, NULL, 3, 1, 1, '2023-11-26 00:59:56', '2025-07-20 00:41:22'),
(5, '7ad04f64-8173-4ee4-98e2-6ae6b942cdcc', 'Five', 'five', NULL, NULL, 4, 1, 1, '2023-11-26 01:00:11', '2025-07-20 00:41:22'),
(6, '133f693e-9ead-409c-8bb3-84bed2a7ee83', 'Six', 'six', NULL, NULL, 5, 1, 1, '2023-11-26 01:00:25', '2025-07-20 00:41:22'),
(7, 'e4d9e29b-c8e1-4a8d-9525-89acd547005e', 'Seven', 'seven', NULL, NULL, 6, 1, 1, '2023-11-26 01:00:35', '2025-07-20 00:41:22'),
(8, '834e360c-9fd9-460d-b199-e5be33917791', 'Eight', 'eight', NULL, NULL, 7, 1, 1, '2023-11-26 01:00:48', '2025-07-20 00:41:22'),
(9, 'aa231c67-1f44-490b-8336-b434ec218bb7', 'Nine', 'nine', NULL, NULL, 8, 1, 1, '2023-11-26 01:01:02', '2025-07-20 00:41:22'),
(10, 'd588ac63-7576-4fb2-8fb2-dd5a0a95fbcd', 'Ten', 'ten', NULL, NULL, 9, 1, 1, '2023-11-26 01:01:15', '2025-07-20 00:41:22'),
(11, '7ec31243-9f22-4fb0-aefe-fa8d34dd7af1', 'Eleven', 'eleven', NULL, NULL, 10, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(12, 'd184f47a-f607-4f4b-9ac2-f1cd7561a471', 'Twelve', 'twelve', NULL, NULL, 11, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `option_genders`
--

CREATE TABLE `option_genders` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_genders`
--

INSERT INTO `option_genders` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '4f55995f-91b3-4e95-b894-bb36969bb9ef', 'None', 'none', NULL, NULL, 0, 1, 1, '2023-11-14 03:46:39', '2025-07-20 00:41:22'),
(2, '8f75bde6-991f-49a9-b395-c479c21fd804', 'Science', 'science', NULL, NULL, 1, 1, 1, '2023-11-14 03:46:47', '2025-07-20 00:41:22'),
(3, '735e6620-e3cf-470b-b0f3-419ea798a76f', 'Humanities', 'humanities', NULL, NULL, 2, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(4, '4e976db8-5e60-461d-aa65-2d8fa087bcec', 'Commerce', 'commerce', NULL, NULL, 3, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `option_groups`
--

CREATE TABLE `option_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_groups`
--

INSERT INTO `option_groups` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '198ddd01-d378-48e2-88a2-aaed9468e584', 'None', NULL, NULL, NULL, 0, 1, 1, '2023-11-14 00:09:53', '2023-11-14 00:10:10'),
(2, '01d9878e-aaad-4972-a72a-74ef0a1bdae6', 'Science', 'science', NULL, NULL, 1, 1, 1, '2023-11-14 00:10:20', '2023-11-14 00:10:20'),
(3, '86992a67-5a29-4a84-aa79-dcdbabc07728', 'Humanities', 'humanities', NULL, NULL, 2, 1, 1, '2023-11-14 00:22:07', '2023-11-14 00:22:07'),
(4, '87e6541b-ed7f-4856-9562-c1da86916052', 'Commerce', 'commerce', NULL, NULL, 3, 1, 1, '2023-11-14 00:22:33', '2023-11-14 00:22:33');

-- --------------------------------------------------------

--
-- Table structure for table `option_religions`
--

CREATE TABLE `option_religions` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_religions`
--

INSERT INTO `option_religions` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'b22674ba-495f-4d1b-8bc8-7c183b0320b9', 'Islam', 'islam', NULL, NULL, 0, 1, 1, '2023-11-14 03:46:58', '2025-07-20 00:41:22'),
(2, '80975fee-2297-48bf-a98b-b7bee75c8b37', 'Hinduism', 'hinduism', NULL, NULL, 1, 1, 1, '2023-11-14 03:47:05', '2025-07-20 00:41:22'),
(3, 'a46e658a-a7de-4296-8803-0c7115f85cb6', 'Buddhism', 'buddhism', NULL, NULL, 2, 1, 1, '2023-11-14 03:47:13', '2025-07-20 00:41:22'),
(4, 'a3afde78-ac8a-42e9-9003-2b59e1999540', 'Christianity', 'christianity', NULL, NULL, 3, 1, 1, '2023-11-14 03:47:23', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `option_sections`
--

CREATE TABLE `option_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_sections`
--

INSERT INTO `option_sections` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'da029fa5-3a0b-4b39-bdec-b2d7a43157b2', 'A', 'a', NULL, NULL, 0, 1, 1, '2023-11-14 00:11:28', '2025-07-20 00:41:22'),
(2, 'fbb0b877-c8e0-4764-b122-ce912e4d0364', 'B', 'b', NULL, NULL, 1, 1, 1, '2023-11-14 00:11:35', '2025-07-20 00:41:22'),
(3, '891da015-5496-436e-baae-e2ecc2b19ba8', 'C', 'c', NULL, NULL, 2, 1, 1, '2023-11-14 00:11:44', '2025-07-20 00:41:22'),
(4, '636bec0e-a10b-4633-ae0e-819b32f97415', 'D', 'd', NULL, NULL, 3, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `option_subjects`
--

CREATE TABLE `option_subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` text COLLATE utf8mb4_unicode_ci,
  `total_mark` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_subjects`
--

INSERT INTO `option_subjects` (`id`, `uuid`, `name`, `code`, `slug`, `photo`, `total_mark`, `class_id`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '9755c38c-d1b6-4d38-8292-05f7015a4002', 'Bangla', '101', 'bangla', NULL, 100, 1, 0, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(2, '7c701841-9051-47bc-aa44-ab1aba01c74e', 'English', '102', 'english', NULL, 100, 1, 1, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(3, 'f2cfca8b-9519-479b-a3b5-adfbeb8f5936', 'Mathematics', '103', 'mathematics', NULL, 100, 1, 2, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(4, 'a0bc1ff2-4e52-4c0c-aaee-7b7b2a7e7664', 'Science', '104', 'science', NULL, 100, 1, 3, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22'),
(5, '9c09aecf-b96a-4070-81d7-cbc200086a1a', 'Social Studies', '105', 'social-studies', NULL, 100, 1, 4, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `option_years`
--

CREATE TABLE `option_years` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_years`
--

INSERT INTO `option_years` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `order`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '783aef22-5460-4fda-9662-d0d35fe0c4af', '2022', '2022', NULL, NULL, 0, 1, 1, '2023-11-14 00:08:28', '2025-07-20 00:41:22'),
(2, '9977a8a0-a08c-44af-829e-703cf609db08', '2023', '2023', NULL, NULL, 1, 1, 1, '2023-11-14 00:08:40', '2025-07-20 00:41:22'),
(3, '41788a81-1e5a-48a0-b5ad-7bd9a73ca148', '2024', '2024', NULL, NULL, 2, 1, 1, '2023-11-14 00:08:51', '2025-07-20 00:41:22'),
(4, '5dc36eed-97a2-4879-bded-90eca2c21394', '2025', '2025', NULL, NULL, 3, 1, 1, '2025-07-20 00:41:22', '2025-07-20 00:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_templates_id` bigint UNSIGNED DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `uuid`, `name`, `description`, `short_description`, `photo`, `slug`, `page_templates_id`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'a309a4a1-fb0f-4a90-aa59-ba92a395c2cd', 'Homepage', '[marquee-box contain=\"In this example, I added a block containing CSS rules\"][/marquee-box][notice-board title=\"Notice Board\" post_types_id=\"2\" number_of_slide=\"10\" button_label1=\"All\" button_url1=\"notice-boards\"][/notice-board][homepage-box title=\"Home\" number_of_slide=\"5\"][/homepage-box][youtube-video title=\"You video\"]https://www.youtube.com/watch?v=2hvQSJFB1Rs[/youtube-video][google-map title=\"কোলাজ লোকেশন\"]Sonaroy Sangalshi College[/google-map]', 'Homepage', NULL, 'homepage', 3, 1, 1, '2023-08-30 01:04:11', '2025-07-27 01:28:50'),
(2, '1dc628d3-c3eb-485a-ac1e-0c52393a1670', 'Contact Us', '[contact-form title=\"DDDD\" description=\"AAAA\"][/contact-form][google-map title=\"কোলাজ লোকেশন \" title_class=\"map_contact\"]Sonaroy Sangalshi College[/google-map]<p> </p>', 'Contact Us addaca dcadc', NULL, 'contact-us', 2, 1, 1, '2023-08-30 01:04:11', '2025-07-27 01:29:00'),
(3, '34efab39-b65d-4dad-916a-f248480aba23', 'About', '<p>About</p>', 'About', NULL, 'about', 1, 1, 1, '2023-09-19 02:31:30', '2023-09-19 03:14:54'),
(10, '789fda50-9999-42f7-83a9-5cedea2ea9fe', 'News', '[all-news-event title=\"News\" post_types_id=\"10\" number_of_slide=\"10\"][/all-news-event]', 'News', NULL, 'news', 2, 1, 1, '2023-09-19 02:33:59', '2023-11-12 23:40:18'),
(11, '73b7b754-cd60-4183-952d-489eb332387e', 'Events', '[all-news-event title=\"Events\" post_types_id=\"11\" number_of_slide=\"10\"][/all-news-event]', 'Events', NULL, 'events', 2, 1, 1, '2023-09-19 02:34:14', '2023-10-31 00:40:08'),
(12, '9c1af40d-3977-4770-b3b2-1a6113b473dc', 'Gallery', '[photo-gallery title=\"Photo Gallery\" post_types_id=\"6\" number_of_slide=\"20\"][/photo-gallery]<p> </p>', 'Gallery', NULL, 'gallery', 2, 1, 1, '2023-09-19 02:34:29', '2023-12-04 02:43:58'),
(13, '29f10695-220b-400e-b65c-92df77c87e1f', 'Blog', '[all-news-event title=\"All Blog\" post_types_id=\"12\" number_of_slide=\"10\"][/all-news-event]', 'Blog', NULL, 'blog', 2, 1, 1, '2023-09-19 02:34:41', '2023-10-31 05:17:40'),
(14, 'ec3ce580-82e2-4faf-97cf-eeb767183a3a', 'Terms And Conditions', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet</p>', 'Terms And Conditions', NULL, 'terms-and-conditions', 4, 1, 1, '2023-09-19 02:35:09', '2023-11-12 02:35:30'),
(15, 'cf50661c-14df-4a34-99f5-96ba05555546', 'Notice Board', '[all-notice-board title=\"Notice Board\" post_types_id=\"2\" number_of_slide=\"10\"][/all-notice-board]', 'Notice Board', NULL, 'notice-boards', 1, 1, 1, '2023-11-12 06:05:29', '2023-11-12 23:40:28'),
(16, '830e217b-82b4-41a3-b7fd-584440ecef7a', 'Admission Form', '[admission-form][/admission-form]', 'Admission Form', NULL, 'admission-form', 1, 1, 1, '2023-11-14 02:30:24', '2023-11-14 02:30:24'),
(17, '54ab44c2-5e8b-4a1f-afaf-0d4ada990d2f', 'ইতিহাস', '<h3>মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা বোর্ড, দিনাজপুরের ইতিহাস</h3><div><div style=\"text-align:justify;\"><div style=\"text-align:justify;\">মানসম্মত, যুগোপযোগী শিক্ষা বিস্তারের লক্ষ্যে রংপুর বিভাগের রংপুর, কুড়িগ্রাম, লালমনিরহাট, গাইবান্ধা, নীলফামারী, দিনাজপুর, ঠাকুরগাঁও ও পঞ্চগড় জেলাসমূহের স্থানীয় অধিক্ষেত্রভুক্ত এলাকায় মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষার সংগঠন, নিয়ন্ত্রণ, তত্ত্বাবধান এবং উন্নয়নের উদ্দেশ্যে ২০০৬ সালের ২২ অক্টোবর প্রজ্ঞাপন জারির মাধ্যমে মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা বোর্ড, দিনাজপুর স্থাপিত হয়। ২০০৯ খ্রিষ্টাব্দে প্রথম এসএসসি ও এইচএসসি পরীক্ষা গ্রহণের মধ্য দিয়ে বোর্ডের কার্যক্রম চলমান রয়েছে। শিক্ষাবোর্ডের কার্যক্রম, অর্ডিন্যান্স অনুযায়ী গঠিত বোর্ডের বিভিন্ন কমিটি এবং অভ্যন্তরীণ প্রশাসনিক কার্যক্রম চেয়ারম্যান মহোদয়ের তত্ত্বাবধানে পরিচালিত হয়। </div><div style=\"text-align:justify;\"> </div><div style=\"text-align:justify;\">শুরুতে কর্মচারীগণ দিনহাজিরা ভিত্তিতে কাজ শুরু করলেও পরবর্তীতে তাদেরকে চাকরিতে নিয়োগ/নিয়মিতকরণের মাধ্যমে স্থায়ীকরণ করা হয়েছে এবং পরবর্তীতে শূন্য পদের বিপরীতে পদোন্নতি প্রদান করা হয়েছে। বর্তমানে বিভিন্ন পদে স্থায়ী নিয়োগপ্রাপ্ত ১০০ জন কর্মচারী এবং ১৮ জন কর্মকর্তা অত্র শিক্ষা বোর্ডে কর্মরত রয়েছেন। ইতোমধ্যে কম্পিউটার কেন্দ্রের জন্য ১০জন কর্মকর্তা-কর্মচারীর পদ সৃষ্টি হয়েছে। ফলে জনবল নিয়োগের প্রক্রিয়া চলমান রয়েছে।</div><div style=\"text-align:justify;\"> </div><div style=\"text-align:justify;\">প্রতিষ্ঠালগ্ন থেকে ফেব্রুয়ারি ২০১৮ পর্যন্ত অত্র শিক্ষা বোর্ডের কার্যক্রম বিভিন্ন ভাড়া বাড়িতে পরিচালিত হয়ে আসছিল। বর্তমানে শিক্ষা বোর্ডের নিজস্ব ভবনে (উত্তর গোবিন্দপুর, সদর, দিনাজপুর) কার্যক্রম পরিচালিত হচ্ছে। শিক্ষা বোর্ডের নিজস্ব ক্যাম্পাস প্রতিষ্ঠার লক্ষ্যে ৩ একর জমি অধিগ্রহণ করা হয় এবং ২০১৩ খ্রিস্টাব্দ থেকে প্রশাসনিক ভবন নির্মাণসহ শিক্ষা বোর্ডের প্রয়োজনীয় অবকাঠামো নির্মাণের কাজ ২০১৯ খ্রিস্টাব্দে সুসম্পন্ন হয়েছে। ২২ অক্টোবর ২০১৩ খ্রি. তারিখে ৮তলা প্রশাসনিক ভবনের ভিত্তি প্রস্তর স্থাপন হয় এবং ১৫/০৪/২০১৮ খ্রি. তারিখে ৮তলা প্রশাসনিক ভবনের শুভ উদ্বোধন হয়। প্রকল্পের কাজ ১০০% (শতভাগ) বাস্তবায়নের ফলে নিজস্ব ক্যাম্পাসে শিক্ষা বোর্ডে যাবতীয় কার্যক্রম সুষ্ঠুভাবে বাস্তবায়ন করা সম্ভবপর হয়েছে। মানসম্পন্ন শিক্ষা, প্রশিক্ষণ এবং মানব উন্নয়ন কার্যক্রমের জন্য গুরুত্বপূর্ণ ভূমিকা পালন করছে। প্রশাসনিক কার্যক্রম, পরীক্ষা সংক্রান্ত কার্যক্রম ও ফলাফল প্রকাশসহ এ সম্পর্কিত সরকারের নির্দেশনাসমূহ বাস্তবায়ন সমন্বিত নতুন ক্যাম্পাসে সম্ভব হয়েছে।</div><div style=\"text-align:justify;\"> </div><div style=\"text-align:justify;\">শিক্ষা বোর্ডের ভৌত অবকাঠামো নির্মাণ, কর্মকর্তা-কর্মচারীদের বেতন ভাতাদি পরিশোধ, উন্নয়ন কার্যক্রম পরিচালনাসহ সকল ব্যয় শিক্ষা বোর্ডের নিজস্ব তহবিল থেকে নির্বাহ করা হচ্ছে।</div><div style=\"text-align:justify;\">মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা বোর্ড, দিনাজপুর (মাধ্যমিক ও উচ্চ মাধ্যমিক স্তরের বেসরকারি শিক্ষা প্রতিষ্ঠানের গভার্ণিং বডি ও ম্যানেজিং কমিটি) প্রবিধানমালা, ২০০৯ প্রণয়নের ফলে প্রতিষ্ঠানসমূহে নিয়ম শৃঙ্খলা প্রতিষ্ঠা, কলেজ/বিদ্যালয় ব্যবস্থাপনায় উন্নয়ন ও শিক্ষা প্রতিষ্ঠান পরিচালনায় সরকারের নিয়ন্ত্রণ ব্যবস্থা শক্তিশালী হয়েছে। কর্মচারী চাকরি প্রবিধানমালা (খসড়া) প্রণয়ন করে অনুমোদনের জন্য শিক্ষা মন্ত্রণালয়ে প্রেরণ করা হয়েছে। অনুমোদন হলে নিয়োগ সংক্রান্ত যাবতীয় কার্যক্রম আরও সুচারুরূপে পরিচালনা করা সম্ভবপর হবে।</div><div style=\"text-align:justify;\">দিনাজপুর শিক্ষা বোর্ডের অধীনে নিম্নমাধ্যমিক বিদ্যালয়-৬৩৪টি, মাধ্যমিক বিদ্যালয়- ২৭৬৩টি, স্কুল এন্ড কলেজ-২২৭টি ও কলেজ-৪৫৬টি সহ মোট শিক্ষা প্রতিষ্ঠানের সংখ্যা ৪০৮০ টি।</div></div></div>', 'মানসম্মত, যুগোপযোগী শিক্ষা বিস্তারের লক্ষ্যে রংপুর বিভাগের রংপুর, কুড়িগ্রাম, লালমনিরহাট, গাইবান্ধা, নীলফামারী, দিনাজপুর, ঠাকুরগাঁও ও পঞ্চগড় জেলাসমূহের স্থানীয় অধিক্ষেত্রভুক্ত এলাকায় মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষার সংগঠন, নিয়ন্ত্রণ, তত্ত্বাবধান এবং উন্নয়নের উদ্দেশ্যে ২০০৬ সালের ২২ অক্টোবর প্রজ্ঞাপন জারির মাধ্যমে মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা', NULL, 'itihas', 4, 1, 1, '2025-07-23 05:18:02', '2025-07-23 05:27:13'),
(18, 'e1977662-681f-44fe-80cb-81c8939e929a', 'চেয়ারম্যান মহোদয়ের জীবনী', '<p style=\"text-align:justify;\"><strong>মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা বোর্ড, দিনাজপুরের চেয়ারম্যান মহোদয়ের জীবনী</strong></p><p style=\"text-align:justify;\"> </p><p style=\"text-align:justify;\">প্রফেসর মহাঃ তৌহিদুল ইসলাম ইংরেজি ভাষা ও সাহিত্যের শিক্ষক, শিক্ষক-প্রশিক্ষক এবং শিক্ষা প্রশাসনে নিয়োজিত বিসিএস (সাধারণ শিক্ষা) ক্যাডারের একজন কর্মকর্তা। </p><p style=\"text-align:justify;\">প্রফেসর মহাঃ তৌহিদুল ইসলাম ১৯৬৭ খ্রিস্টাব্দে চাঁপাইনবাবগঞ্জ জেলার গোমস্তাপুর উপজেলার অন্তর্গত বেগম নগর গ্রামে জন্মগ্রহণ করেন। তাঁর পিতা- মহাঃ মহসীন আলী, মাতা- মরহুম বেগম বদরুন নেসা। গ্রামেই তাঁর শিক্ষাজীবন শুরু হয়। তিনি গোমস্তাপুর কিউ.এ.এম পাইলট উচ্চ বিদ্যালয় হতে ১৯৮২ খ্রিস্টাব্দে এসএসসি পরীক্ষায় উত্তীর্ণ হয়ে চাঁপাইনবাবগঞ্জ জেলার রহনপুর ইউসুফ আলী কলেজে ভর্তি হন। এই কলেজ হতে ১৯৮৪ খ্রিস্টাব্দে তিনি এইচএসসি পরীক্ষায় উত্তীর্ণ হন। পরবর্তীতে তিনি উচ্চ শিক্ষার জন্য রাজশাহী বিশ্ববিদ্যালয়ে ভর্তি হয়ে ইংরেজি ভাষা ও সাহিত্যে ১৯৮৭ খ্রিস্টাব্দে স্নাতক (সম্মান) ও ১৯৮৮ খ্রিস্টাব্দে স্নাতকোত্তর ডিগ্রি অর্জন করেন। শিক্ষাজীবনে তিনি সকল পরীক্ষায় কৃতিত্বের সাথে বৃত্তি লাভ করেন। </p><p style=\"text-align:justify;\">চতুর্দশ বিসিএস পরীক্ষার মাধ্যমে প্রফেসর মহাঃ তৌহিদুল ইসলাম ১৯৯৩ খ্রিস্টাব্দে শিক্ষকতা শুরু করেন। বিভিন্ন শিক্ষা প্রতিষ্ঠানে তিনি বিসিএস (সাধারণ শিক্ষা) ক্যাডারের বিভিন্ন পদে কর্মরত ছিলেন। তাঁর উল্লেখযোগ্য কর্মস্থল সমূহের মধ্যে রয়েছে নবাবগঞ্জ সরকারি কলেজ, চাঁপাইনবাবগঞ্জ; রাজশাহী সরকারি কলেজ, রাজশাহী; আদিনা ফজলুল হক সরকারি কলেজ, চাঁপাইনবাবগঞ্জ; পাবনা এডওয়ার্ড কলেজ, পাবনা এবং রাজশাহী সরকারি মহিলা কলেজ, রাজশাহী। ইংলিশ ল্যাংগুয়েজ টিচিং ইমপ্রুভমেন্ট প্রজেক্ট শীর্ষক প্রকল্পে তিনি রাজশাহী টিচার্স ট্রেনিং কলেজ, রাজশাহীতে শিক্ষক-প্রশিক্ষক হিসেবে ও ফরেইন ল্যাংগুয়েজ ট্রেনিং সেন্টার, রাজশাহী সরকারি কলেজ, রাজশাহীতে কো-অর্ডিনেটর হিসেবে দায়িত্ব পালন করেন।</p><p style=\"text-align:justify;\">বুনিয়াদি প্রশিক্ষণ ছাড়াও প্রফেসর মহাঃ তৌহিদুল ইসলাম দেশে ও বিদেশে বিভিন্ন প্রশিক্ষণ গ্রহণ করেন। যুক্তরাজ্যের কলেজ অব সেন্ট মার্ক এন্ড সেন্ট জন হতে তিনি ১৯৯৯ খ্রিস্টাব্দে কমিউনিকেটিভ ল্যাংগুয়েজ টিচিং (সিএলটি) বিষয়ক প্রশিক্ষণ গ্রহণ করেন। ২০১০ খ্রিস্টাব্দে এংলিয়া রাসকিন ইউনিভার্সিটি, ক্যামব্রিজ, যুক্তরাজ্য হতে টি ও টি কোর্স সম্পন্ন করেন। ২০১৯ খ্রিস্টাব্দে নায়েম, ঢাকা থেকে এসএসসিইএম প্রশিক্ষণ সম্পন্ন করেন।  এছাড়াও তিনি বিভিন্ন সময় ইংল্যান্ড, ফ্রান্স, মালয়েশিয়া, চীন প্রভৃতি দেশ ভ্রমণ করেন।</p><p style=\"text-align:justify;\">তিনি ২০২২ খ্রিস্টাব্দে সৌদি আরবে পবিত্র হজ্জ্বব্রত পালন করেন।</p><p style=\"text-align:justify;\">প্রফেসর মহাঃ তৌহিদুল ইসলাম ২৭ জানুয়ারি ২০২৫ তারিখ হতে মাধ্যমিক ও উচ্চ মাধ্যমিক শিক্ষা বোর্ড, দিনাজপুরে চেয়ারম্যান হিসেবে কর্মরত। </p>', 'প্রফেসর মহাঃ তৌহিদুল ইসলাম ইংরেজি ভাষা ও সাহিত্যের শিক্ষক, শিক্ষক-প্রশিক্ষক এবং শিক্ষা প্রশাসনে নিয়োজিত বিসিএস (সাধারণ শিক্ষা) ক্যাডারের একজন কর্মকর্তা।', NULL, 'ceyarmzan-mhodyer-jeebnee', 4, 1, 1, '2025-07-23 05:27:46', '2025-07-23 05:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `pages_translations`
--

CREATE TABLE `pages_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_templates`
--

CREATE TABLE `page_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_templates`
--

INSERT INTO `page_templates` (`id`, `uuid`, `slug`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '50e1f846-35b1-4617-9080-7b728cc190bf', 'default', 'Default', 'Default', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(2, '4db58c7e-a1ae-4d9a-be5f-7d272e1d445e', 'page', 'Page', 'Page', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(3, 'b5f43096-05e7-4b18-bb94-e8ae4c6a629e', 'homepage', 'Homepage', 'Homepage', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(4, 'd7cbe66c-836f-45f0-8f76-c40a2626bb7d', 'right-sidebar', 'Right sidebar', 'Right sidebar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(5, '41735bac-3c1e-4591-a211-f77e062e0dd2', 'full-width', 'Full width', 'Full width', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'analytics_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(2, 'analytics_index', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(3, 'analytics_referrer', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(4, 'analytics_browser', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(5, 'analytics_page', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:42'),
(6, 'captcha_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:45'),
(7, 'captcha_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:45'),
(8, 'captcha_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:45'),
(9, 'captcha_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:45'),
(10, 'contactform_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(11, 'contactform_list_all', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(12, 'contactform_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(13, 'contactform_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(14, 'contactform_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(15, 'contactform_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:47'),
(16, 'faq_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(17, 'faq_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(18, 'faq_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(19, 'faq_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(20, 'faqcategory_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(21, 'faqcategory_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(22, 'faqcategory_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(23, 'faqcategory_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:48'),
(24, 'kamruldashboard_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(25, 'manage_plugins_index', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(26, 'manage_plugins', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(27, 'role_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(28, 'role_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(29, 'role_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(30, 'role_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(31, 'role_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(32, 'role_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(33, 'role_import', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(34, 'user_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(35, 'user_index', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(36, 'user_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(37, 'user_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(38, 'user_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(39, 'user_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(40, 'user_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(41, 'user_import', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(42, 'password_update', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(43, 'permission_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(44, 'permission_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(45, 'permission_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(46, 'permission_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(47, 'permission_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(48, 'permission_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(49, 'systems_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(50, 'backup_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(51, 'backup_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(52, 'backup_restore', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(53, 'backup_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(54, 'settings_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(55, 'settings_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(56, 'settings_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(57, 'settings_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(58, 'settings_sub_add', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(65, 'language_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(66, 'language_list_own', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(67, 'language_list_all', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(68, 'language_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(69, 'language_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(70, 'language_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(71, 'language_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(72, 'language_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(73, 'language_import', 1, '2023-08-30 01:04:10', '2023-08-30 01:04:54'),
(74, 'city_access', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(75, 'city_list_own', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(76, 'city_create', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(77, 'city_edit', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(78, 'city_destroy', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(79, 'state_access', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(80, 'state_list_own', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(81, 'state_create', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(82, 'state_edit', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(83, 'state_destroy', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(84, 'country_access', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(85, 'country_list_own', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(86, 'country_create', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(87, 'country_edit', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(88, 'country_destroy', 1, '2023-08-30 01:04:10', '2023-12-05 03:38:39'),
(89, 'menus_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(90, 'menus_list_own', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(91, 'menus_list_all', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(92, 'menus_create', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(93, 'menus_edit', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(94, 'menus_pdf', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(95, 'menus_show', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(96, 'menus_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(97, 'menus_import', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:03'),
(98, 'newsletter_access', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:06'),
(99, 'newsletter_list_own', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:06'),
(100, 'newsletter_list_all', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:06'),
(101, 'newsletter_destroy', 1, '2023-08-30 01:04:10', '2023-08-30 01:05:06'),
(102, 'post_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(103, 'post_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(104, 'post_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(105, 'post_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(106, 'pagetemplate_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(107, 'pagetemplate_list_own', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(108, 'pagetemplate_list_all', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(109, 'pagetemplate_show', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(110, 'pagetemplate_pdf', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(111, 'page_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(112, 'page_index', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(113, 'page_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(114, 'page_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(115, 'page_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(116, 'posttype_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(117, 'posttype_list_own', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(118, 'posttype_list_all', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(119, 'posttype_show', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(120, 'posttype_pdf', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(121, 'category_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(122, 'category_list_own', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(123, 'category_list_all', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(124, 'category_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(125, 'category_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(126, 'category_show', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(127, 'category_pdf', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(128, 'category_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(129, 'category_import', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(130, 'simple-slider_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(131, 'simple-slider_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(132, 'simple-slider_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(133, 'simple-slider_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(134, 'simple-slideritem_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(135, 'simple-slideritem_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(136, 'simple-slideritem_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(137, 'simple-slideritem_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:19'),
(138, 'sociallogin_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:26'),
(139, 'theme_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(140, 'theme_index', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(141, 'theme_setting_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(142, 'theme_general', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(143, 'theme_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(144, 'theme_show', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(145, 'theme_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:32'),
(146, 'themeicon_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(147, 'themeicon_list_own', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(148, 'themeicon_list_all', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(149, 'themeicon_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(150, 'themeicon_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(151, 'themeicon_pdf', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(152, 'themeicon_show', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(153, 'themeicon_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(154, 'themeicon_import', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(155, 'translation_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(156, 'translation_locales_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(157, 'translation_theme_translations', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(158, 'translation_admin_translations', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(159, 'translation_create', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(160, 'translation_edit', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(161, 'translation_destroy', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(162, 'translation_index', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:38'),
(163, 'widget_access', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:41'),
(327, 'vanufacility_access', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(328, 'vanufacility_list_own', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(329, 'vanufacility_list_all', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(330, 'vanufacility_create', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(331, 'vanufacility_edit', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(332, 'vanufacility_pdf', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(333, 'vanufacility_show', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(334, 'vanufacility_destroy', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(335, 'vanufacility_import', 1, '2023-10-22 02:38:59', '2023-10-22 02:38:59'),
(336, 'venuefacility_access', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(337, 'venuefacility_list_own', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(338, 'venuefacility_list_all', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(339, 'venuefacility_create', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(340, 'venuefacility_edit', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(341, 'venuefacility_pdf', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(342, 'venuefacility_show', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(343, 'venuefacility_destroy', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(344, 'venuefacility_import', 1, '2023-10-22 03:00:18', '2023-10-22 23:02:10'),
(354, 'keyfacility_access', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(355, 'keyfacility_list_own', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(356, 'keyfacility_list_all', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(357, 'keyfacility_create', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(358, 'keyfacility_edit', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(359, 'keyfacility_show', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(360, 'keyfacility_pdf', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(361, 'keyfacility_destroy', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(362, 'keyfacility_import', 1, '2023-10-22 23:02:10', '2023-10-22 23:02:10'),
(363, 'analytics_general', 0, '2023-11-01 22:08:15', '2023-11-01 22:08:15'),
(364, 'option_access', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(365, 'option_list_own', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(366, 'option_list_all', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(367, 'option_create', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(368, 'option_edit', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(369, 'option_pdf', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(370, 'option_show', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(371, 'option_destroy', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(372, 'option_import', 1, '2023-11-13 22:36:33', '2025-07-20 00:41:21'),
(382, 'optionclass_access', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(383, 'optionclass_list_own', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(384, 'optionclass_list_all', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(385, 'optionclass_create', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(386, 'optionclass_edit', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(387, 'optionclass_show', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(388, 'optionclass_pdf', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(389, 'optionclass_destroy', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(390, 'optionclass_import', 1, '2023-11-14 00:01:58', '2025-07-20 00:41:21'),
(400, 'optionyear_access', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(401, 'optionyear_list_own', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(402, 'optionyear_list_all', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(403, 'optionyear_create', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(404, 'optionyear_edit', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(405, 'optionyear_show', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(406, 'optionyear_pdf', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(407, 'optionyear_destroy', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(408, 'optionyear_import', 1, '2023-11-14 00:08:09', '2025-07-20 00:41:22'),
(427, 'optiongroup_access', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(428, 'optiongroup_list_own', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(429, 'optiongroup_list_all', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(430, 'optiongroup_create', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(431, 'optiongroup_edit', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(432, 'optiongroup_show', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(433, 'optiongroup_pdf', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(434, 'optiongroup_destroy', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(435, 'optiongroup_import', 1, '2023-11-14 00:09:38', '2025-07-20 00:41:21'),
(463, 'optionsection_access', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(464, 'optionsection_list_own', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(465, 'optionsection_list_all', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(466, 'optionsection_create', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(467, 'optionsection_edit', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(468, 'optionsection_show', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(469, 'optionsection_pdf', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(470, 'optionsection_destroy', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(471, 'optionsection_import', 1, '2023-11-14 00:11:17', '2025-07-20 00:41:21'),
(499, 'admission_access', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(500, 'admission_list_own', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(501, 'admission_list_all', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(502, 'admission_create', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(503, 'admission_edit', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(504, 'admission_pdf', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(505, 'admission_show', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(506, 'admission_destroy', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(507, 'admission_import', 1, '2023-11-14 00:34:05', '2025-07-20 00:59:49'),
(517, 'optiongender_access', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(518, 'optiongender_list_own', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(519, 'optiongender_list_all', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(520, 'optiongender_create', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(521, 'optiongender_edit', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(522, 'optiongender_show', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(523, 'optiongender_pdf', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(524, 'optiongender_destroy', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(525, 'optiongender_import', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(526, 'optionreligion_access', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(527, 'optionreligion_list_own', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(528, 'optionreligion_list_all', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(529, 'optionreligion_create', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(530, 'optionreligion_edit', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(531, 'optionreligion_show', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(532, 'optionreligion_pdf', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(533, 'optionreligion_destroy', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(534, 'optionreligion_import', 1, '2023-11-14 03:45:39', '2025-07-20 00:41:21'),
(572, 'admissionsubject_access', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(573, 'admissionsubject_list_own', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(574, 'admissionsubject_list_all', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(575, 'admissionsubject_create', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(576, 'admissionsubject_edit', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(577, 'admissionsubject_show', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(578, 'admissionsubject_pdf', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(579, 'admissionsubject_destroy', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(580, 'admissionsubject_import', 1, '2023-11-28 04:28:56', '2025-07-20 00:59:49'),
(590, 'admissionmark_access', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(591, 'admissionmark_list_own', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(592, 'admissionmark_list_all', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(593, 'admissionmark_create', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(594, 'admissionmark_edit', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(595, 'admissionmark_show', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(596, 'admissionmark_pdf', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(597, 'admissionmark_destroy', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(598, 'admissionmark_import', 1, '2023-11-28 06:01:42', '2025-07-20 00:59:49'),
(609, 'admissionmerit_access', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(610, 'admissionmerit_list_own', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(611, 'admissionmerit_list_all', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(612, 'admissionmerit_create', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(613, 'admissionmerit_edit', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(614, 'admissionmerit_show', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(615, 'admissionmerit_pdf', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(616, 'admissionmerit_destroy', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(617, 'admissionmerit_import', 1, '2023-11-29 23:28:09', '2025-07-20 00:59:49'),
(762, 'optionsubject_access', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(763, 'optionsubject_list_own', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(764, 'optionsubject_list_all', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(765, 'optionsubject_create', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(766, 'optionsubject_edit', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(767, 'optionsubject_show', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(768, 'optionsubject_pdf', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(769, 'optionsubject_destroy', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21'),
(770, 'optionsubject_import', 1, '2025-07-20 00:41:21', '2025-07-20 00:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_set` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `check_design` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_line` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `set_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `post_types_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `uuid`, `name`, `header_title`, `icon_set`, `check_design`, `tag_line`, `start_date`, `set_time`, `slug`, `description`, `short_description`, `document_file`, `photo`, `status`, `post_types_id`, `user_id`, `designation`, `created_at`, `updated_at`) VALUES
(1, '03a60e35-b395-4c80-a4ac-6439fac7ab48', 'Education', NULL, 'education-1693892946.webp', NULL, NULL, '2023-01-01', NULL, 'education', '<p>This section covers classes from Playgroup to Kindergarten 2. Students of this section are in their first stage of learning where they begin their preschool and early learning. Children being very young at this stage have impressionable minds that need a caring environment. Starting with training to hold a pencil through games, songs, storytelling and a lot of innovativeness, they end up being capable and confident pupils who can clearly express themselves both in speech and in writing.</p>', 'Education', NULL, NULL, 1, 9, 1, NULL, '2023-08-30 01:04:11', '2023-09-04 23:49:06'),
(2, 'df224d30-80d2-4d7b-9c1c-e33e3d32b407', 'Supershop', NULL, 'supershop-1693894232.webp', NULL, NULL, '2023-01-01', NULL, 'supershop', '<p>As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher\'s feedback and life-long educational impact.</p>', NULL, NULL, NULL, 1, 9, 1, NULL, '2023-08-30 01:04:11', '2023-09-05 00:10:32'),
(3, '041e8f5e-9912-4196-bc05-60e33d8001e7', 'Health & Fitness', NULL, 'health-1693894308.webp', NULL, NULL, '2023-01-01', NULL, 'health-fitness', '<p>As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher\'s feedback and life-long educational impact.</p>', NULL, NULL, NULL, 1, 9, 1, NULL, '2023-08-30 01:04:11', '2023-09-05 00:11:48'),
(4, '58a51b5f-92c9-4db8-bd7a-c196c178d867', 'Accomodation', NULL, 'accomodation-1693894791.webp', NULL, NULL, '2023-01-01', NULL, 'accomodation', '<p>As a School we cover a broad range of topics in our teaching. Because all of our teaching staff are involved in world-class teaching, all students receive an up-to-date curriculum of international standard. We are a dynamic and friendly School and actively encourage student involvement with biological study. Our teaching laboratories are among the best equipped of any institution in Bangladesh. We provide interactive microscopy, computing, and image analysis which in turn enable peer-to-peer learning of student findings, teacher\'s feedback and life-long educational impact.</p>', NULL, NULL, NULL, 1, 9, 1, NULL, '2023-08-30 01:04:11', '2023-09-05 00:19:51'),
(5, '4dabd9d5-1345-4cdd-bb81-b3a065a8f1ce', 'Food', NULL, 'food-1693894914.webp', NULL, NULL, '2023-09-05', NULL, 'food', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:21:54', '2023-09-05 00:21:54'),
(6, '1c3ec47f-57af-4ce8-8fe1-673343ae9f7b', 'Sports', NULL, 'sports-1693895002.webp', NULL, NULL, '2023-09-05', NULL, 'sports', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:23:22', '2023-09-05 00:23:22'),
(7, '417be230-6b8d-49bf-a04b-f24d4a8e21e6', 'Recreation', NULL, 'recreation-1693895032.webp', NULL, NULL, '2023-09-05', NULL, 'recreation', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:23:52', '2023-09-05 00:23:52'),
(8, '959076d0-dc43-4bac-878a-943f62021f66', 'Safety & Security', NULL, 'safety-1693895058.webp', NULL, NULL, '2023-09-05', NULL, 'safety-security', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:24:18', '2023-09-05 00:24:18'),
(9, '9a9450b2-b908-463e-9a0f-69fa3c0c203b', 'Bank & ATM', NULL, 'bank-1693895082.webp', NULL, NULL, '2023-09-05', NULL, 'bank-atm', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:24:42', '2023-09-05 00:24:42'),
(10, '0f2fd856-3345-40c8-a7ca-ee33244acf39', 'Transport', NULL, 'transport-1693895119.webp', NULL, NULL, '2023-09-05', NULL, 'transport', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:25:18', '2023-09-05 00:25:19'),
(11, '28507f22-760c-4753-8617-7778efe8bf39', 'Religious Center', NULL, 'religious-1693895147.webp', NULL, NULL, '2023-09-05', NULL, 'religious-center', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:25:47', '2023-09-05 00:25:47'),
(12, '5bc59c5a-5fa4-4a9c-937a-a08d1338b06e', 'Entrepreneurship', NULL, 'entreprenuership-1693895165.webp', NULL, NULL, '2023-09-05', NULL, 'entrepreneurship', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:26:05', '2023-09-05 00:26:05'),
(13, '61e446dd-36d8-4df9-88f5-becd69c17c07', 'Event Management', NULL, 'event-1693895199.webp', NULL, NULL, '2023-09-05', NULL, 'event-management', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:26:39', '2023-09-05 00:26:39'),
(14, '0e4dc63f-fbd9-46c2-a2fb-5e932656f792', 'Jogging Track', NULL, 'jogging-1693895228.webp', NULL, NULL, '2023-09-05', NULL, 'jogging-track', NULL, NULL, NULL, NULL, 1, 9, 1, NULL, '2023-09-05 00:27:08', '2023-09-05 00:27:08'),
(15, '89e42aaf-5399-41d2-8be7-676f1a38de0b', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-09', NULL, 'international-conference-hall', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'main-venue-1694321670.webp', 1, 1, 1, NULL, '2023-09-09 04:44:45', '2023-12-04 02:37:52'),
(16, 'c28c458e-8af9-4628-861f-eeac5998ce71', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-2', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'venue-2-1694325097.webp', 1, 1, 1, NULL, '2023-09-09 23:51:37', '2023-12-04 02:37:52'),
(17, '686f6f15-7295-4d44-a7be-4b3f754acc08', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-3', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'main-venue-1694328411.webp', 1, 1, 1, NULL, '2023-09-10 00:46:51', '2023-12-04 02:37:52'),
(18, '83707724-d96a-4c30-ba85-f7d86735dbe5', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-5', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'venue-2-1694329487.webp', 1, 1, 1, NULL, '2023-09-10 01:04:46', '2023-12-04 02:37:52'),
(19, 'd32a429f-180b-412c-a183-8f429c49d3ab', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-7', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'features-1694329699.webp', 1, 1, 1, NULL, '2023-09-10 01:08:19', '2023-12-04 02:37:52'),
(21, '02b5b5b5-3b88-4317-a8e2-7e142ae8546a', 'আন্তর্জাতিক সম্মেলন হল', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'experienced-team', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'team-1694336859.webp', 1, 8, 1, NULL, '2023-09-10 03:05:41', '2023-11-18 02:26:51'),
(22, 'e2c6a394-9c13-4e66-941a-030a6438d3e3', '360 Support', NULL, NULL, NULL, NULL, '2023-09-10', NULL, '360-support', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'support-1694336901.webp', 1, 8, 1, NULL, '2023-09-10 03:08:20', '2023-09-10 03:08:21'),
(23, '1fc35e3b-a5fa-45fe-8a90-44a3941aad6d', 'Highest Security', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'highest-security', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'security-1694337833.webp', 1, 8, 1, NULL, '2023-09-10 03:23:53', '2023-09-10 03:23:53'),
(24, 'f6023c06-ec29-4752-bd25-3ae11e614da4', 'Quality Construction', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'quality-construction', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'construction-1694337863.webp', 1, 8, 1, NULL, '2023-09-10 03:24:23', '2023-09-10 03:24:23'),
(25, '5fa761de-b919-4f62-b15e-89fee5a13f01', 'Excellent Service', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'excellent-service', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'service-1694337916.webp', 1, 8, 1, NULL, '2023-09-10 03:25:16', '2023-09-10 03:25:16'),
(26, 'c633cbbc-bf63-499b-a857-c222a1f7fad8', 'Green environment', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'green-environment', NULL, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, 'environment-1694337939.webp', 1, 8, 1, NULL, '2023-09-10 03:25:39', '2023-09-10 03:25:39'),
(27, '5e869d1c-3ce6-4c40-abd5-a0a85fb06f0b', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-11', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'about-us-1694340582.webp', 1, 3, 1, NULL, '2023-09-10 04:09:41', '2023-09-10 04:09:42'),
(28, 'a38500ec-6fa2-440b-a6d5-a4609e417c71', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-13', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'venue-2-1694340670.webp', 1, 3, 1, NULL, '2023-09-10 04:11:10', '2023-09-10 04:11:11'),
(29, 'd835c58b-5f91-44a5-ad2a-6ecec4c57f3b', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-15', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'main-venue-1694340715.webp', 1, 3, 1, NULL, '2023-09-10 04:11:55', '2023-09-10 04:11:55'),
(30, 'aeb9a309-b83c-49fb-8345-9dc7c7eaacbd', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-17', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'main-venue-1694340761.webp', 1, 3, 1, NULL, '2023-09-10 04:12:41', '2023-09-10 04:12:41'),
(31, '783d208b-1bbb-475e-9395-029f2f063c61', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-19', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'venue-2-1694340811.webp', 1, 3, 1, NULL, '2023-09-10 04:13:30', '2023-09-10 04:13:31'),
(32, 'f258c3cb-2c92-4cb5-abbf-b31b6f9f4994', 'International Conference Hall', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'international-conference-hall-21', '<p>The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School &amp; College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,</p>', 'The Daffodil Smart City is developing gradually in hundred fifty acres of calm, serene, lush green environment. It has all the services and facilities that a modern city may have., which includes, Daffodil School & College, Daffodil University. It has all the services and facilities that a modern city may have., which includes,', NULL, 'main-venue-1694340830.webp', 1, 3, 1, NULL, '2023-09-10 04:13:49', '2023-09-10 04:13:50'),
(33, '558c9062-6538-47f5-b56d-63091839c485', 'News Title 1', NULL, NULL, NULL, NULL, '2023-09-10', NULL, 'news-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', NULL, 'news-events-1694346400.webp', 1, 10, 1, NULL, '2023-09-10 05:46:40', '2023-09-10 05:46:40'),
(34, '692387b0-234b-4f7c-a35b-5e1561c921bc', 'News Title 2', NULL, NULL, NULL, NULL, '2023-09-06', '3:00 PM - 5:00 PM', 'news-title-2', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.', NULL, 'news-events-1694410251.webp', 1, 10, 1, NULL, '2023-09-10 23:30:51', '2023-09-10 23:30:51'),
(35, 'b1a8df08-6a27-4db8-be2b-7101d5df19bb', 'News Title 4', NULL, NULL, NULL, NULL, '2023-09-11', '3:00 PM - 6:00 PM', 'news-title-4', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.', NULL, 'news-events-1694410301.webp', 1, 10, 1, NULL, '2023-09-10 23:31:41', '2023-09-10 23:31:41'),
(37, '27452f94-d2db-4d85-a556-84a65ede4df6', 'Education', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'education-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit ame</p>', NULL, NULL, 'dsc-0-1698644452.webp', 1, 5, 1, NULL, '2023-10-29 23:40:52', '2023-10-29 23:41:10'),
(38, 'ba8c3d74-5c79-4325-8885-db84e6958e8b', 'Jogging Track', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'jogging-track-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit ame</p>', NULL, NULL, 'venue-2-1698644553.webp', 1, 5, 1, NULL, '2023-10-29 23:42:33', '2023-10-29 23:42:33'),
(39, '504e7994-ea68-4f30-953b-00554cf76a7a', 'Education', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'education-3', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no</p>', NULL, NULL, 'bird-eye-1698644621.webp', 1, 5, 1, NULL, '2023-10-29 23:43:41', '2023-10-29 23:43:53'),
(40, 'afb5136d-54db-4a5a-ac80-dbf8e1989e3c', 'Main Gate - DSC', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'main-gate-dsc', NULL, NULL, NULL, '4-1698645695.webp', 1, 6, 1, NULL, '2023-10-30 00:01:35', '2023-10-30 00:01:35'),
(41, '6ddba66e-27fb-415b-841e-7c3af13cc59b', 'Main Gate - cafe', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'main-gate-cafe', NULL, NULL, NULL, '8-1698645808.webp', 1, 6, 1, NULL, '2023-10-30 00:03:28', '2023-10-30 00:03:28'),
(42, '45bcbb0c-85ed-4699-b056-0e6fab1d1e2f', 'DSC photo', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'dsc-photo', NULL, NULL, NULL, '12-1698645861.webp', 1, 6, 1, NULL, '2023-10-30 00:04:21', '2023-10-30 00:04:21'),
(43, 'b04d4edb-63a6-4d16-b7d8-92b5dcea0bf9', 'News Title 5', NULL, NULL, NULL, NULL, '2023-10-30', NULL, 'news-title-5', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem quis nemo accusamus totam neque ipsa laborum optio! Quidem illum expedita, explicabo beatae impedit laborum repellat voluptates saepe rem tenetur cum adipisci atque animi minima cupiditate iure reprehenderit qui ipsam magnam enim? Officia enim saepe nisi exercitationem? Impedit eos aperiam odio. Magnam voluptatem doloremque soluta voluptatibus perferendis. Inventore atque</p>', 'News Title 5', NULL, '13-1698650431.webp', 1, 10, 1, NULL, '2023-10-30 01:20:31', '2023-10-30 01:20:31'),
(44, 'c2dc5bb9-b471-4500-8817-68ba8bf82409', 'Event Title 1', NULL, NULL, NULL, NULL, '2023-10-31', NULL, 'event-title-1', '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', 'Event Title 1', NULL, '13-1698734554.webp', 1, 11, 1, NULL, '2023-10-31 00:42:34', '2023-10-31 00:42:34'),
(45, '2f6cc008-224c-4822-ad3d-adbf54b49b8b', 'Request for Expression of Interest for hiring Service under SPFMS', NULL, NULL, NULL, NULL, '2023-11-11', NULL, 'request-for-expression-of-interest-for-hiring-service-under-spfms', '<p>Request for Expression of Interest for hiring Service under SPFMS</p>', NULL, NULL, NULL, 1, 2, 1, NULL, '2023-11-10 22:54:10', '2023-11-10 22:54:10'),
(46, '96f2387e-8315-4cd0-b08a-6158b9e36335', 'EoI-National for hiring Service under SPFMS', NULL, NULL, NULL, NULL, '2023-11-11', NULL, 'eoi-national-for-hiring-service-under-spfms', '<p>EoI-National for hiring Service under SPFMS</p>', NULL, NULL, NULL, 1, 2, 1, NULL, '2023-11-10 22:56:15', '2023-11-10 22:56:15'),
(47, '84922d26-fd8c-4572-9b97-936c9560fe0d', 'বিভিন্ন ধরণের যানবাহনের মূল্য পুনর্নির্ধারণ সম্পর্কিত', NULL, NULL, NULL, NULL, '2023-11-11', NULL, 'bivinn-dhrner-zanbahner-muulz-punrnirdharn-smprkit', '<p>বিভিন্ন ধরণের যানবাহনের মূল্য পুনর্নির্ধারণ সম্পর্কিত</p>', NULL, '1-1699852868.png', NULL, 1, 2, 1, NULL, '2023-11-10 22:56:33', '2023-11-12 23:21:08'),
(48, '4f0db37d-119a-415f-a66a-b6e892fa7f07', 'Request for Expression of Interest for hiring Service under SPFMS Request for Expression of Interest for hiring Service under SPFMS', NULL, NULL, NULL, NULL, '2023-11-11', NULL, 'request-for-expression-of-interest-for-hiring-service-under-spfms-request-for-expression-of-interest-for-hiring-service-under-spfms', '<ul><li><a>Request for Expression of Interest for hiring Service under <span style=\"background-color:hsl(240,75%,60%);color:hsl(0,0%,100%);\"><span>SPFMS </span></span>Request for Expression of Interest for hiring Service under SPFMS Request for Expression of Interest for hiring Service under SPFMSRequest for Expression of Interest for hiring Service under SPFMS</a></li></ul>', NULL, '5-1699852851.jpg', '8-1699850803.webp', 1, 2, 1, NULL, '2023-11-10 23:01:51', '2023-11-12 23:20:51'),
(49, 'eb4b7214-e950-49b5-beec-9c09982c9de6', '২০২০ সালের জেএসসি পরীক্ষার মূলসনদ বিতরণ প্রসঙ্গে', NULL, NULL, NULL, NULL, '2023-11-11', NULL, '2020-saler-jeessi-preekshar-muulsnd-bitrn-prsngoe', '<p>২০২০ সালের জেএসসি পরীক্ষার মূলসনদ বিতরণ প্রসঙ্গে</p>', '২০২০ সালের জেএসসি পরীক্ষার মূলসনদ বিতরণ প্রসঙ্গে', NULL, NULL, 1, 3, 1, NULL, '2023-11-11 03:07:37', '2023-11-11 03:07:37'),
(50, '266e38dc-0c0a-48c4-9726-7f9d59d23f14', 'Ro achieve the desired layout where the image', NULL, NULL, NULL, NULL, '2023-11-12', NULL, 'ro-achieve-the-desired-layout-where-the-image', '<p>The .details_main class is set to a flex container with display: flex. It uses flex-wrap: wrap to allow items to wrap onto multiple lines. .details_img is given a width of 50%, and .details_text is given a width of 45%, leaving some space for margins and gutters. The @media query is used to make the layout stack vertically on screens with a width of 768 pixels or less. This is useful for responsive design on smaller screens. This CSS code provides a responsive layout that adjusts based on the screen width. Adjust the percentage values as needed to achieve the desired visual balance between the image and text.</p>', 'The .details_main class is set to a flex container with display: flex. It uses flex-wrap: wrap to allow items to wrap onto multiple lines.', NULL, NULL, 1, 3, 1, NULL, '2023-11-12 02:25:13', '2023-11-12 02:25:13'),
(51, '1a27af54-e7a0-4ebb-bbd7-63e5a98c2f21', 'In this example, I added a block containing CSS rules', NULL, NULL, NULL, NULL, '2023-11-13', NULL, 'in-this-example-i-added-a-block-containing-css-rules', '<p>In this example, I added a block containing CSS rules. The .btn class defines the default styles for the button, and the .btn:hover selector specifies the styles to apply when the button is hovered. The transition property adds a smooth transition effect to the background color change. You can adjust the styles according to your design preferences.</p>', NULL, '3-1699853135.png', '11-1699853134.webp', 1, 2, 1, NULL, '2023-11-12 23:25:34', '2023-11-12 23:25:35'),
(52, '3167132e-d7d4-4bd7-9055-b5d1c93f6f11', 'new photo', NULL, NULL, NULL, NULL, '2023-12-04', NULL, 'new-photo', NULL, NULL, NULL, '1-1701679706.webp', 1, 6, 1, NULL, '2023-12-04 02:48:26', '2023-12-04 02:48:26'),
(53, 'd56449a6-e996-439f-aff8-dc09aa9b1ea1', 'Activities', NULL, NULL, NULL, NULL, '2025-07-21', NULL, 'activities', '<p><span>Bangladesh an autonomous organization, mainly responsible for holding three public examinations, and Higher Secondary School Certificate</span></p>', 'Bangladesh an autonomous organization, mainly responsible for holding three public examinations, and Higher Secondary School Certificate', 'Dropped Image-1753091436.png', 'Dropped Image-1753091419.webp', 1, 1, 1, NULL, '2025-07-21 03:49:47', '2025-07-21 03:50:36'),
(54, 'd1cbf67b-8d6e-4c51-81b7-79b459a179c1', 'কামরুল ইসলাম', NULL, NULL, NULL, NULL, '2025-07-23', NULL, 'kamrul-islam', '<p>কামরুল ইসলাম</p>', NULL, NULL, '20240217_150351-1753265527.webp', 1, 4, 1, 'প্রধান', '2025-07-23 04:12:07', '2025-07-23 04:12:10'),
(55, 'e7233b47-5497-4547-84f0-ca7297481120', 'রাজিব', NULL, NULL, NULL, NULL, '2025-07-23', NULL, 'rajib', '<p><span class=\"HwtZe jCAhz ChMk0b ryNqvb\" jscontroller=\"BiTO4b\" jsname=\"W297wb\" jsaction=\"click:PDNqTc,GFf3ac,qlVvte;contextmenu:Nqw7Te,QP7LD; mouseout:Nqw7Te; mouseover:PDNqTc,c2aHje\" lang=\"bn\">রাজিব</span></p>', NULL, NULL, 'drivingLicense-1753265653.webp', 1, 4, 1, 'উপাধ্যক্ষগণ', '2025-07-23 04:14:13', '2025-07-23 04:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `posts_translations`
--

CREATE TABLE `posts_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posts_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts_translations`
--

INSERT INTO `posts_translations` (`lang_code`, `posts_id`, `name`, `short_description`, `description`, `content`) VALUES
('en_US', 21, 'International Conference Hall', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`id`, `category_id`, `post_id`, `created_at`, `updated_at`) VALUES
(5, 1, 17, NULL, NULL),
(6, 1, 18, NULL, NULL),
(7, 1, 15, NULL, NULL),
(8, 2, 16, NULL, NULL),
(9, 3, 19, NULL, NULL),
(11, 6, 32, NULL, NULL),
(12, 2, 31, NULL, NULL),
(13, 6, 30, NULL, NULL),
(14, 4, 29, NULL, NULL),
(15, 4, 28, NULL, NULL),
(16, 8, 27, NULL, NULL),
(17, 3, 49, NULL, NULL),
(18, 8, 49, NULL, NULL),
(19, 8, 50, NULL, NULL),
(31, 6, 52, NULL, NULL),
(32, 6, 51, NULL, NULL),
(34, 15, 53, NULL, NULL),
(37, 14, 33, NULL, NULL),
(38, 6, 44, NULL, NULL),
(39, 6, 43, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_galleries`
--

CREATE TABLE `post_galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_galleries`
--

INSERT INTO `post_galleries` (`id`, `name`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'diss.png', 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(5, 'DSC-Logo-1693392053.webp', 1, '2023-08-30 04:40:53', '2023-08-30 04:40:53'),
(6, 'dsc-0-1693393961.webp', 1, '2023-08-30 05:12:41', '2023-08-30 05:12:41'),
(7, 'dsc-1-1693393986.webp', 1, '2023-08-30 05:13:06', '2023-08-30 05:13:06'),
(8, 'dsc-2-1693393999.webp', 1, '2023-08-30 05:13:19', '2023-08-30 05:13:19'),
(11, 'why-dsc-1693822120.webp', 1, '2023-09-04 04:08:40', '2023-09-04 04:08:40'),
(13, 'features-1693892674.webp', 1, '2023-09-04 23:44:34', '2023-09-04 23:44:34'),
(14, 'main-venue-1694256802.webp', 1, '2023-09-09 04:53:22', '2023-09-09 04:53:22'),
(15, 'main-venue-1694256805.webp', 1, '2023-09-09 04:53:25', '2023-09-09 04:53:25'),
(16, 'activity-1694256814.webp', 1, '2023-09-09 04:53:34', '2023-09-09 04:53:34'),
(18, 'main-venue-1694259888.webp', 1, '2023-09-09 05:44:48', '2023-09-09 05:44:48'),
(20, 'main-venue-1694259919.webp', 1, '2023-09-09 05:45:19', '2023-09-09 05:45:19'),
(21, 'main-venue-1694259922.webp', 1, '2023-09-09 05:45:22', '2023-09-09 05:45:22'),
(22, 'activity-1694259930.webp', 1, '2023-09-09 05:45:30', '2023-09-09 05:45:30'),
(23, 'venue-2-1694325139.webp', 1, '2023-09-09 23:52:19', '2023-09-09 23:52:19'),
(24, 'venue-2-1694325141.webp', 1, '2023-09-09 23:52:21', '2023-09-09 23:52:21'),
(25, 'main-venue-1694325143.webp', 1, '2023-09-09 23:52:23', '2023-09-09 23:52:23'),
(26, 'bird-eye-1694330183.webp', 1, '2023-09-10 01:16:23', '2023-09-10 01:16:23'),
(27, 'news-events-1694346395.webp', 1, '2023-09-10 05:46:35', '2023-09-10 05:46:35'),
(29, 'AIR FREIGHT-1698640378.webp', 1, '2023-10-29 22:32:58', '2023-10-29 22:32:58'),
(30, 'venue-2-1698640379.webp', 1, '2023-10-29 22:33:00', '2023-10-29 22:33:00'),
(31, '3-1698645674.webp', 1, '2023-10-30 00:01:14', '2023-10-30 00:01:14'),
(32, '5-1698645674.webp', 1, '2023-10-30 00:01:14', '2023-10-30 00:01:14'),
(33, '4-1698645674.webp', 1, '2023-10-30 00:01:14', '2023-10-30 00:01:14'),
(34, '11-1698645674.webp', 1, '2023-10-30 00:01:14', '2023-10-30 00:01:14'),
(35, '12-1698645674.webp', 1, '2023-10-30 00:01:14', '2023-10-30 00:01:14'),
(36, '2-1698645710.webp', 1, '2023-10-30 00:01:50', '2023-10-30 00:01:50'),
(37, '1-1698645710.webp', 1, '2023-10-30 00:01:50', '2023-10-30 00:01:50'),
(38, '8-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(39, '6-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(40, '7-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(41, '9-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(42, '10-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(43, '16-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(44, '17-1698645805.webp', 1, '2023-10-30 00:03:25', '2023-10-30 00:03:25'),
(45, '3-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(46, '2-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(47, '1-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(48, '11-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(49, '12-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(50, '4-1698645845.webp', 1, '2023-10-30 00:04:05', '2023-10-30 00:04:05'),
(51, '13-1698645846.webp', 1, '2023-10-30 00:04:06', '2023-10-30 00:04:06'),
(52, '14-1698645846.webp', 1, '2023-10-30 00:04:06', '2023-10-30 00:04:06'),
(53, '14-1698733050.webp', 1, '2023-10-31 00:17:30', '2023-10-31 00:17:30'),
(54, '15-1698733050.webp', 1, '2023-10-31 00:17:30', '2023-10-31 00:17:30'),
(55, '17-1698733052.webp', 1, '2023-10-31 00:17:32', '2023-10-31 00:17:32'),
(56, '7-1698734578.webp', 1, '2023-10-31 00:42:58', '2023-10-31 00:42:58'),
(57, '17-1698734578.webp', 1, '2023-10-31 00:42:58', '2023-10-31 00:42:58'),
(58, '5-1698734578.webp', 1, '2023-10-31 00:42:58', '2023-10-31 00:42:58'),
(64, 'DSC-Logo-1700295641.webp', 1, '2023-11-18 02:20:41', '2023-11-18 02:20:41'),
(65, 'DSC-Logo-1700295645.webp', 1, '2023-11-18 02:20:45', '2023-11-18 02:20:45'),
(67, '13-1-1700295688.webp', 1, '2023-11-18 02:21:28', '2023-11-18 02:21:28'),
(68, '15-1701679683.webp', 1, '2023-12-04 02:48:03', '2023-12-04 02:48:03'),
(69, '14-1701679683.webp', 1, '2023-12-04 02:48:03', '2023-12-04 02:48:03'),
(70, '16-1701679683.webp', 1, '2023-12-04 02:48:03', '2023-12-04 02:48:03'),
(72, 'favicon-1752993855.webp', 1, '2025-07-20 00:44:15', '2025-07-20 00:44:15'),
(73, 'favicon-1752993868.webp', 1, '2025-07-20 00:44:28', '2025-07-20 00:44:28'),
(74, 'favicon-1752993871.webp', 1, '2025-07-20 00:44:31', '2025-07-20 00:44:31'),
(76, 'sa1-1753004585.webp', 1, '2025-07-20 03:43:05', '2025-07-20 03:43:05');

-- --------------------------------------------------------

--
-- Table structure for table `post_gallery_parameters`
--

CREATE TABLE `post_gallery_parameters` (
  `id` bigint UNSIGNED NOT NULL,
  `post_gallery_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_gallery_parameters`
--

INSERT INTO `post_gallery_parameters` (`id`, `post_gallery_id`, `post_id`, `created_at`, `updated_at`) VALUES
(1, 18, 15, NULL, NULL),
(3, 20, 15, NULL, NULL),
(4, 21, 15, NULL, NULL),
(5, 22, 15, NULL, NULL),
(6, 23, 16, NULL, NULL),
(7, 24, 16, NULL, NULL),
(8, 25, 16, NULL, NULL),
(9, 27, 33, NULL, NULL),
(11, 29, 35, NULL, NULL),
(12, 30, 35, NULL, NULL),
(13, 32, 40, NULL, NULL),
(14, 31, 40, NULL, NULL),
(15, 33, 40, NULL, NULL),
(16, 34, 40, NULL, NULL),
(17, 35, 40, NULL, NULL),
(18, 36, 40, NULL, NULL),
(19, 37, 40, NULL, NULL),
(20, 38, 41, NULL, NULL),
(21, 39, 41, NULL, NULL),
(22, 40, 41, NULL, NULL),
(23, 41, 41, NULL, NULL),
(24, 42, 41, NULL, NULL),
(25, 43, 41, NULL, NULL),
(26, 44, 41, NULL, NULL),
(27, 45, 42, NULL, NULL),
(28, 46, 42, NULL, NULL),
(29, 47, 42, NULL, NULL),
(30, 48, 42, NULL, NULL),
(31, 49, 42, NULL, NULL),
(32, 50, 42, NULL, NULL),
(33, 51, 42, NULL, NULL),
(34, 52, 42, NULL, NULL),
(35, 54, 33, NULL, NULL),
(36, 53, 33, NULL, NULL),
(37, 55, 33, NULL, NULL),
(38, 56, 44, NULL, NULL),
(39, 57, 44, NULL, NULL),
(40, 58, 44, NULL, NULL),
(41, 68, 52, NULL, NULL),
(42, 70, 52, NULL, NULL),
(43, 69, 52, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_types`
--

CREATE TABLE `post_types` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_types`
--

INSERT INTO `post_types` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'f3f37104-5ce4-420f-882d-8f434de6a6fa', 'None', 'none', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(2, 'f636f230-cc98-4596-9962-392556ee9406', 'Notice Board', 'Notice Board', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-10 21:54:09'),
(3, '18da7adb-899c-48bb-b155-847701c5b629', 'Home Page Box Info', 'Home Page Box Info', NULL, 1, 1, '2023-08-30 01:04:11', '2023-11-10 23:19:43'),
(4, 'c4fdebb6-f787-4d6a-a07a-6b953ba4c974', 'Management', 'Management', NULL, 1, 1, '2023-08-30 01:04:11', '2025-07-23 04:08:56'),
(5, 'f52a2a57-ff59-41fe-80fe-68f720d58865', 'Our Facilities', 'Our Facilities', NULL, 1, 1, '2023-08-30 01:04:11', '2023-10-30 00:06:06'),
(6, '883aa5b9-be60-427a-b881-a7d260952289', 'Photo Gallery', 'Photo Gallery', NULL, 1, 1, '2023-08-30 01:04:11', '2023-10-29 23:29:51'),
(7, '68110d1f-ff0c-424e-a6ce-8649e444defe', 'Training', 'Training', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(8, 'ac7f28f1-0d51-4897-a909-efe9f92612c7', 'DIS Different', 'DIS Different', NULL, 1, 1, '2023-08-30 01:04:11', '2023-09-10 03:03:47'),
(9, '1621c063-6d07-4aa5-a057-e533772f36f1', 'Our Features', 'Our Features', NULL, 1, 1, '2023-08-30 01:04:11', '2023-09-04 23:29:29'),
(10, 'fd01a0c9-3a7c-473a-83df-42b572d9056e', 'News', '<p>News<br></p>', NULL, 1, 1, '2023-09-10 04:26:11', '2023-09-10 04:26:21'),
(11, '9f2789be-c643-4ded-abb1-4f12e04908a6', 'Events', '<p>Events<br></p>', NULL, 1, 1, '2023-09-10 04:26:35', '2023-09-10 04:26:35'),
(12, '954f1fb9-544f-4b44-9775-f531c0ee166f', 'Blog', '<p>Blog<br></p>', NULL, 1, 1, '2023-10-31 02:11:47', '2023-10-31 02:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int NOT NULL DEFAULT '1',
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `uuid`, `name`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, '8804ee3b-84fe-4645-ae09-8488a791369e', 'Admin', 1, 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(2, '5ef82bb4-4c4f-42e3-b1c1-b0bead042b0f', 'User', 1, 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(3, '78ca82ad-3521-45b9-8138-7f665f3cbefb', 'Register', 1, 1, '2023-08-30 01:04:10', '2023-08-30 01:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `permission_id`, `role_id`) VALUES
(138, 1, 1),
(139, 2, 1),
(140, 3, 1),
(141, 4, 1),
(142, 5, 1),
(143, 89, 1),
(144, 92, 1),
(145, 93, 1),
(146, 96, 1),
(147, 102, 1),
(148, 103, 1),
(149, 104, 1),
(150, 105, 1),
(151, 111, 1),
(152, 112, 1),
(153, 113, 1),
(154, 114, 1),
(155, 115, 1),
(156, 121, 1),
(157, 124, 1),
(158, 125, 1),
(159, 128, 1),
(160, 139, 1),
(161, 141, 1),
(162, 142, 1),
(163, 363, 1),
(164, 364, 1),
(165, 367, 1),
(166, 368, 1),
(167, 371, 1),
(168, 382, 1),
(169, 385, 1),
(170, 386, 1),
(171, 389, 1),
(172, 400, 1),
(173, 403, 1),
(174, 404, 1),
(175, 407, 1),
(176, 427, 1),
(177, 430, 1),
(178, 431, 1),
(179, 434, 1),
(180, 463, 1),
(181, 466, 1),
(182, 467, 1),
(183, 470, 1),
(184, 499, 1),
(185, 502, 1),
(186, 503, 1),
(187, 505, 1),
(188, 506, 1),
(189, 517, 1),
(190, 520, 1),
(191, 521, 1),
(192, 524, 1),
(193, 526, 1),
(194, 529, 1),
(195, 530, 1),
(196, 533, 1),
(197, 572, 1),
(198, 575, 1),
(199, 576, 1),
(200, 579, 1),
(201, 590, 1),
(202, 593, 1),
(203, 594, 1),
(204, 597, 1),
(205, 609, 1),
(206, 612, 1),
(207, 613, 1),
(208, 616, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `settings_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `key`, `slug`, `description`, `settings_data`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Site Setting', 'site_setting', 'site-setting', 'Here you can manage the title, logo, favicon and all general settings', '{\"site_name\":{\"value\":\"Apps name\",\"type\":\"text\",\"extra\":\"\",\"tool_tip\":\"Site Name\"},\"site_favicon\":{\"value\":\"..\\/..\\/vendor\\/kamruldashboard\\/images\\/125.png\",\"type\":\"file\",\"extra\":\"\",\"tool_tip\":\"Favicon\"},\"site_logo\":{\"value\":\"..\\/..\\/vendor\\/kamruldashboard\\/images\\/124.png\",\"type\":\"file\",\"extra\":\"\",\"tool_tip\":\"Site logo\"},\"footer\":{\"value\":\"<p>Copyright \\u00a9 KamrulDshboard &amp; Developed by <a href=\\\"#\\\" target=\\\"_blank\\\">Daffodil International School<\\/a> 2021<\\/p>\\r\\n<p>Distributed by <a href=\\\"\\\" target=\\\"_blank\\\">Kamrul<\\/a><\\/p>\",\"type\":\"textarea\",\"extra\":\"\",\"tool_tip\":\"Footer\"},\"registration_enable\":{\"value\":\"1\",\"type\":\"checkbox\",\"extra\":\"\",\"tool_tip\":\"Registration Enable\"},\"registration_user_role\":{\"value\":\"1\",\"type\":\"checkbox\",\"extra\":\"\",\"tool_tip\":\"Registration User Role\"}}', '../../vendor/kamruldashboard/images/123.jpg', '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(2, 'Email Settings', 'email_settings', 'email-settings', 'Contains all the settings related to emails', '{\"mail_driver\":{\"value\":\"smtp\",\"type\":\"select\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Driver\"},\"mail_host\":{\"value\":\"mail.admin.com\",\"type\":\"text\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Mail Host\"},\"mail_port\":{\"value\":\"25\",\"type\":\"text\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Mail Port no\"},\"mail_username\":{\"value\":\"admin@admin.com\",\"type\":\"text\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Mail Username\"},\"mail_password\":{\"value\":\"123456\",\"type\":\"password\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Password\"},\"mail_encryption\":{\"value\":0,\"type\":\"text\",\"extra\":{\"total_options\":\"8\",\"options\":{\"smtp\":\"SMTP\",\"mail\":\"Mail\",\"sparkpost\":\"Sparkpost\",\"sendmail\":\"Sendmail\",\"mailgun\":\"Mailgun\",\"mandrill\":\"Mandrill\",\"ses\":\"SES\",\"log\":\"Log\"}},\"tool_tip\":\"Mail Encryption\"}}', NULL, '2023-08-30 01:04:10', '2023-08-30 01:04:52'),
(3, 'Google Analytics', 'google_analytics', 'google-analytics', 'Config Credentials for Google Analytics', '{\"google_analytics\":{\"value\":\"\",\"type\":\"text\",\"extra\":\"\",\"tool_tip\":\"Tracking ID\"},\"analytics_view_id\":{\"value\":\"\",\"type\":\"text\",\"extra\":\"\",\"tool_tip\":\"Google Analytics View ID\"},\"analytics_service_account_credentials\":{\"type\":\"textarea\",\"value\":\"\",\"extra\":[],\"tool_tip\":\"Analytics Service Account Credentials\"}}', NULL, '2023-08-30 01:04:10', '2023-08-30 01:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `setting_data`
--

CREATE TABLE `setting_data` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_data`
--

INSERT INTO `setting_data` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'activated_plugins', '[\"language-advanced\"]', NULL, '2025-07-21 00:05:17'),
(2, 'theme-SchoolTheme-action_title_text', 'Freshers\' Orientation Program for the Session: 2022 - 23', '2023-08-30 01:04:10', '2025-07-21 00:05:17'),
(3, 'theme', 'SonaroyTheme', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(4, 'theme-SonaroyTheme-site_title', 'SONAROY SONGOLSHI COLLEGE', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(5, 'theme-SonaroyTheme-site_description', 'SONAROY SONGOLSHI COLLEGE', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(6, 'theme-SonaroyTheme-copyright', 'Copyright©2023', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(7, 'theme-SonaroyTheme-address', 'সোনারয় সোঙ্গোলশি', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(8, 'theme-SonaroyTheme-site_email', 'info@site.com', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(9, 'theme-SonaroyTheme-site_phone', '+88 01738256825', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(10, 'theme-SonaroyTheme-designed_by', 'Designed by Kamrul | All rights reserved.', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(11, 'theme-SonaroyTheme-social_1_name', 'Facebook', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(12, 'theme-SonaroyTheme-social_1_icon', 'ri-facebook-fill', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(13, 'theme-SonaroyTheme-social_1_url', 'https://facebook.com', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(14, 'theme-SonaroyTheme-social_1_color', '#3B5999', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(15, 'theme-SonaroyTheme-social_2_name', 'Twitter', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(16, 'theme-SonaroyTheme-social_2_icon', 'ri-twitter-fill', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(17, 'theme-SonaroyTheme-social_2_url', 'https://twitter.com', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(18, 'theme-SonaroyTheme-social_2_color', '#55ACF9', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(19, 'theme-SonaroyTheme-social_3_name', '', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(20, 'theme-SonaroyTheme-social_3_icon', 'fa-brands fa-instagram', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(21, 'theme-SonaroyTheme-social_3_url', 'https://linkedin.com', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(22, 'theme-SonaroyTheme-social_3_color', '#0A66C2', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(23, 'theme-SonaroyTheme-social_4_name', 'Youtube', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(24, 'theme-SonaroyTheme-social_4_icon', 'ri-youtube-fill', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(25, 'theme-SonaroyTheme-social_4_url', 'https://youtube.com', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(26, 'theme-SonaroyTheme-social_4_color', '#EF1111', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(27, 'theme-SonaroyTheme-social_5_name', 'Whatsapp', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(28, 'theme-SonaroyTheme-social_5_icon', 'ri-whatsapp-line', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(29, 'theme-SonaroyTheme-social_5_url', 'https://web.whatsapp.com/', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(30, 'theme-SonaroyTheme-social_5_color', '#EF1111', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(31, 'theme-SonaroyTheme-homepage_id', '1', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(32, 'theme-SonaroyTheme-favicon', '73', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(33, 'theme-SonaroyTheme-logo', '74', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(34, 'theme-SonaroyTheme-seo_og_image', '72', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(35, 'theme-SonaroyTheme-primary_color', '#4188E5', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(36, 'theme-SonaroyTheme-secondary_color', '#FFB703', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(37, 'theme-SonaroyTheme-background_color', '#edf6fa', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(38, 'theme-SonaroyTheme-danger_color', '#e3363e', '2023-08-30 01:04:11', '2025-07-21 00:05:17'),
(76, 'theme-SonaroyTheme-show_site_name', '0', NULL, '2025-07-21 00:05:17'),
(77, 'theme-SonaroyTheme-seo_title', 'SONAROY SONGOLSHI COLLEGE', NULL, '2025-07-21 00:05:17'),
(78, 'theme-SonaroyTheme-seo_description', 'SONAROY SONGOLSHI COLLEGE', NULL, '2025-07-21 00:05:17'),
(79, 'theme-SonaroyTheme-preloader_enabled', 'no', NULL, '2025-07-21 00:05:17'),
(80, 'theme-SonaroyTheme-site_email2', '', NULL, '2025-07-21 00:05:17'),
(81, 'theme-SonaroyTheme-site_phone2', '', NULL, '2025-07-21 00:05:17'),
(82, 'theme-SonaroyTheme-working_hours', '', NULL, '2025-07-21 00:05:17'),
(83, 'theme-SonaroyTheme-logo_color', '76', NULL, '2025-07-21 00:05:17'),
(84, 'theme-SonaroyTheme-footer_logo', '5', NULL, '2025-07-21 00:05:17'),
(85, 'theme-SonaroyTheme-social_6_name', '', NULL, '2025-07-21 00:05:17'),
(86, 'theme-SonaroyTheme-social_6_icon', '', NULL, '2025-07-21 00:05:17'),
(87, 'theme-SonaroyTheme-social_6_url', '', NULL, '2025-07-21 00:05:17'),
(88, 'theme-SonaroyTheme-number_of_post', '10', NULL, '2025-07-21 00:05:17'),
(89, 'theme-SonaroyTheme-blog_single_layout', '', NULL, '2025-07-21 00:05:17'),
(90, 'theme-SonaroyTheme-blog_layout', 'big', NULL, '2025-07-21 00:05:17'),
(91, 'theme-SonaroyTheme-site_page_id', NULL, NULL, '2023-11-20 00:00:02'),
(92, 'rich_editor', 'ckeditor', NULL, '2025-07-21 00:05:17'),
(93, 'theme-SonaroyTheme-address_google', '', NULL, '2025-07-21 00:05:17'),
(94, 'theme-SonaroyTheme-action_space_text', '2054', NULL, '2025-07-21 00:05:17'),
(95, 'theme-SonaroyTheme-action_menu_text', '2078', NULL, '2025-07-21 00:05:17'),
(96, 'theme-SonaroyTheme-action_seats_text', '1045', NULL, '2025-07-21 00:05:17'),
(97, 'theme-SonaroyTheme-action_venue_title_text', 'Would You Like To Reserve This Venue?', NULL, '2025-07-21 00:05:17'),
(98, 'theme-SonaroyTheme-action_venue_massage_text', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', NULL, '2025-07-21 00:05:17'),
(99, 'theme-SonaroyTheme-action_venue_contact_us_text', 'contact-us', NULL, '2025-07-21 00:05:17'),
(100, 'theme-SonaroyTheme-contact_info_boxes', '[[{\"key\":\"name\",\"value\":\"kamrul islam\"},{\"key\":\"contact\",\"value\":null},{\"key\":\"designation\",\"value\":\"Officer\"},{\"key\":\"address\",\"value\":\"Daffodil tower\"},{\"key\":\"phone\",\"value\":\"01738256825\"},{\"key\":\"email\",\"value\":\"a@gmail.com\"}],[{\"key\":\"name\",\"value\":\"kamrul islam 3\"},{\"key\":\"contact\",\"value\":null},{\"key\":\"designation\",\"value\":\"Sr. Officer\"},{\"key\":\"address\",\"value\":\"Daffodil tower\"},{\"key\":\"phone\",\"value\":\"017382568259\"},{\"key\":\"email\",\"value\":\"b@gmail.com\"}]]', NULL, '2025-07-21 00:05:17'),
(102, 'Modules_ContactForm_notice_status', '1', NULL, '2025-07-21 00:05:17'),
(103, 'language_hide_default', '1', NULL, '2025-07-21 00:05:17'),
(104, 'language_display', 'name', NULL, '2025-07-21 00:05:17'),
(105, 'language_switcher_display', 'list', NULL, '2025-07-21 00:05:17'),
(106, 'language_hide_languages', '[]', NULL, '2025-07-21 00:05:17'),
(107, 'language_auto_detect_user_language', '0', NULL, '2025-07-21 00:05:17'),
(108, 'language_show_default_item_if_current_version_not_existed', '1', NULL, '2025-07-21 00:05:17'),
(109, 'theme-SonaroyTheme-bn_BD-site_title', 'খানসামা পাইলট বালিকা উচ্চ বিদ্যালয়', NULL, '2025-07-21 00:05:17'),
(110, 'theme-SonaroyTheme-bn_BD-show_site_name', '0', NULL, '2025-07-21 00:05:17'),
(111, 'theme-SonaroyTheme-bn_BD-seo_title', '', NULL, '2025-07-21 00:05:17'),
(112, 'theme-SonaroyTheme-bn_BD-seo_description', '', NULL, '2025-07-21 00:05:17'),
(113, 'theme-SonaroyTheme-bn_BD-seo_og_image', '', NULL, '2025-07-21 00:05:17'),
(114, 'theme-SonaroyTheme-bn_BD-copyright', '© 2022 Apphostbd Technologies. All right reserved.', NULL, '2025-07-21 00:05:17'),
(115, 'theme-SonaroyTheme-bn_BD-designed_by', 'Designed by Kamrul | All rights reserved.', NULL, '2025-07-21 00:05:17'),
(116, 'theme-SonaroyTheme-bn_BD-preloader_enabled', 'no', NULL, '2025-07-21 00:05:17'),
(117, 'theme-SonaroyTheme-bn_BD-primary_color', '#edf6fa', NULL, '2025-07-21 00:05:17'),
(118, 'theme-SonaroyTheme-bn_BD-secondary_color', '#2d3d8b', NULL, '2025-07-21 00:05:17'),
(119, 'theme-SonaroyTheme-bn_BD-background_color', '#edf6fa', NULL, '2025-07-21 00:05:17'),
(120, 'theme-SonaroyTheme-bn_BD-danger_color', '#e3363e', NULL, '2025-07-21 00:05:17'),
(121, 'theme-SonaroyTheme-bn_BD-site_description', '', NULL, '2025-07-21 00:05:17'),
(122, 'theme-SonaroyTheme-bn_BD-address', 'খানসামা, দিনাজপুর', NULL, '2025-07-21 00:05:17'),
(123, 'theme-SonaroyTheme-bn_BD-address_google', '', NULL, '2025-07-21 00:05:17'),
(124, 'theme-SonaroyTheme-bn_BD-site_email', '', NULL, '2025-07-21 00:05:17'),
(125, 'theme-SonaroyTheme-bn_BD-site_email2', '', NULL, '2025-07-21 00:05:17'),
(126, 'theme-SonaroyTheme-bn_BD-site_phone', '', NULL, '2025-07-21 00:05:17'),
(127, 'theme-SonaroyTheme-bn_BD-site_phone2', '', NULL, '2025-07-21 00:05:17'),
(128, 'theme-SonaroyTheme-bn_BD-working_hours', '', NULL, '2025-07-21 00:05:17'),
(129, 'theme-SonaroyTheme-bn_BD-favicon', '64', NULL, '2025-07-21 00:05:17'),
(130, 'theme-SonaroyTheme-bn_BD-logo', '65', NULL, '2025-07-21 00:05:17'),
(131, 'theme-SonaroyTheme-bn_BD-logo_color', '67', NULL, '2025-07-21 00:05:17'),
(132, 'theme-SonaroyTheme-bn_BD-social_1_name', '', NULL, '2025-07-21 00:05:17'),
(133, 'theme-SonaroyTheme-bn_BD-social_1_icon', '', NULL, '2025-07-21 00:05:17'),
(134, 'theme-SonaroyTheme-bn_BD-social_1_url', '', NULL, '2025-07-21 00:05:17'),
(135, 'theme-SonaroyTheme-bn_BD-social_2_name', '', NULL, '2025-07-21 00:05:17'),
(136, 'theme-SonaroyTheme-bn_BD-social_2_icon', '', NULL, '2025-07-21 00:05:17'),
(137, 'theme-SonaroyTheme-bn_BD-social_2_url', '', NULL, '2025-07-21 00:05:17'),
(138, 'theme-SonaroyTheme-bn_BD-social_3_name', '', NULL, '2025-07-21 00:05:17'),
(139, 'theme-SonaroyTheme-bn_BD-social_3_icon', '', NULL, '2025-07-21 00:05:17'),
(140, 'theme-SonaroyTheme-bn_BD-social_3_url', '', NULL, '2025-07-21 00:05:17'),
(141, 'theme-SonaroyTheme-bn_BD-social_4_name', '', NULL, '2025-07-21 00:05:17'),
(142, 'theme-SonaroyTheme-bn_BD-social_4_icon', '', NULL, '2025-07-21 00:05:17'),
(143, 'theme-SonaroyTheme-bn_BD-social_4_url', '', NULL, '2025-07-21 00:05:17'),
(144, 'theme-SonaroyTheme-bn_BD-social_5_name', '', NULL, '2025-07-21 00:05:17'),
(145, 'theme-SonaroyTheme-bn_BD-social_5_icon', '', NULL, '2025-07-21 00:05:17'),
(146, 'theme-SonaroyTheme-bn_BD-social_5_url', '', NULL, '2025-07-21 00:05:17'),
(147, 'theme-SonaroyTheme-bn_BD-social_6_name', '', NULL, '2025-07-21 00:05:17'),
(148, 'theme-SonaroyTheme-bn_BD-social_6_icon', '', NULL, '2025-07-21 00:05:17'),
(149, 'theme-SonaroyTheme-bn_BD-social_6_url', '', NULL, '2025-07-21 00:05:17'),
(150, 'theme-SonaroyTheme-bn_BD-action_space_text', '20Ac', NULL, '2025-07-21 00:05:17'),
(151, 'theme-SonaroyTheme-bn_BD-action_menu_text', '50+', NULL, '2025-07-21 00:05:17'),
(152, 'theme-SonaroyTheme-bn_BD-action_seats_text', '10K', NULL, '2025-07-21 00:05:17'),
(153, 'theme-SonaroyTheme-bn_BD-action_venue_title_text', '', NULL, '2025-07-21 00:05:17'),
(154, 'theme-SonaroyTheme-bn_BD-action_venue_massage_text', '', NULL, '2025-07-21 00:05:17'),
(155, 'theme-SonaroyTheme-bn_BD-action_venue_contact_us_text', '', NULL, '2025-07-21 00:05:17'),
(156, 'theme-SonaroyTheme-bn_BD-contact_info_boxes', '[[{\"key\":\"name\",\"value\":null},{\"key\":\"contact\",\"value\":null},{\"key\":\"designation\",\"value\":null},{\"key\":\"address\",\"value\":null},{\"key\":\"phone\",\"value\":null},{\"key\":\"email\",\"value\":null}]]', NULL, '2025-07-21 00:05:17'),
(157, 'theme-SonaroyTheme-bn_BD-homepage_id', '1', NULL, '2025-07-21 00:05:17'),
(158, 'theme-SonaroyTheme-bn_BD-number_of_post', '10', NULL, '2025-07-21 00:05:17'),
(159, 'theme-SonaroyTheme-bn_BD-blog_single_layout', '', NULL, '2025-07-21 00:05:17'),
(160, 'theme-SonaroyTheme-bn_BD-blog_layout', 'big', NULL, '2025-07-21 00:05:17'),
(161, 'theme-SonaroyTheme-bn_BD-site_page_id', NULL, NULL, '2023-11-20 00:00:01'),
(163, 'admin_email', '[]', NULL, '2025-07-21 00:05:17'),
(164, 'time_zone', 'UTC', NULL, '2025-07-21 00:05:17'),
(165, 'locale_direction', 'ltr', NULL, '2025-07-21 00:05:17'),
(166, 'enable_send_error_reporting_via_email', '0', NULL, '2025-07-21 00:05:17'),
(167, 'admin_title', 'DIS', NULL, '2025-07-21 00:05:17'),
(168, 'enable_cache', '0', NULL, '2025-07-21 00:05:17'),
(169, 'cache_time', '10', NULL, '2025-07-21 00:05:17'),
(170, 'cache_admin_menu_enable', '0', NULL, '2025-07-21 00:05:17'),
(171, 'blacklist_keywords', '', NULL, '2025-07-21 00:05:17'),
(172, 'blacklist_email_domains', '', NULL, '2025-07-21 00:05:17'),
(173, 'enable_math_captcha_for_contact_form', '0', NULL, '2025-07-21 00:05:17'),
(174, 'google_analytics', '', NULL, '2025-07-21 00:05:17'),
(175, 'analytics_property_id', '', NULL, '2025-07-21 00:05:17'),
(176, 'analytics_service_account_credentials', '', NULL, '2025-07-21 00:05:17'),
(177, 'newsletter_mailchimp_api_key', '', NULL, '2025-07-21 00:05:17'),
(178, 'newsletter_mailchimp_list_id', '', NULL, '2025-07-21 00:05:17'),
(179, 'newsletter_sendgrid_api_key', '', NULL, '2025-07-21 00:05:17'),
(180, 'newsletter_sendgrid_list_id', '', NULL, '2025-07-21 00:05:17'),
(181, 'enable_captcha', '0', NULL, '2025-07-21 00:05:17'),
(182, 'captcha_type', 'v2', NULL, '2025-07-21 00:05:17'),
(183, 'captcha_hide_badge', '0', NULL, '2025-07-21 00:05:17'),
(184, 'captcha_site_key', 'no-captcha-site-key', NULL, '2025-07-21 00:05:17'),
(185, 'captcha_secret', 'no-captcha-secret', NULL, '2025-07-21 00:05:17'),
(186, 'principal_name', 'মাহবুবুর রহমান', NULL, '2025-07-21 00:05:17'),
(187, 'simple_slider_using_assets', '1', NULL, '2025-07-21 00:05:17'),
(188, 'locale', 'en', NULL, '2025-07-21 00:05:17'),
(189, 'default_admin_theme', 'default', NULL, '2025-07-21 00:05:17'),
(190, 'admin_locale_direction', 'ltr', NULL, '2025-07-21 00:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `simple_sliders`
--

CREATE TABLE `simple_sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `simple_sliders`
--

INSERT INTO `simple_sliders` (`id`, `name`, `key`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Simple Slider 1', 'simple-slider-1', NULL, '1', '2023-11-08 23:31:08', '2023-11-08 23:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `simple_slider_items`
--

CREATE TABLE `simple_slider_items` (
  `id` bigint UNSIGNED NOT NULL,
  `simple_slider_id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slugs`
--

CREATE TABLE `slugs` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int UNSIGNED NOT NULL,
  `reference_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slugs`
--

INSERT INTO `slugs` (`id`, `key`, `reference_id`, `reference_type`, `prefix`, `created_at`, `updated_at`) VALUES
(1, 'purchase-order', 1, 'Modules\\Post\\Http\\Models\\Category', '', '2023-08-30 01:04:11', '2023-11-10 23:33:28'),
(2, 'administrative-order', 2, 'Modules\\Post\\Http\\Models\\Category', '', '2023-08-30 01:04:11', '2023-11-10 23:32:51'),
(3, 'name-and-age-correction', 3, 'Modules\\Post\\Http\\Models\\Category', '', '2023-08-30 01:04:11', '2023-11-10 23:32:26'),
(4, 'hsc-corner', 4, 'Modules\\Post\\Http\\Models\\Category', '', '2023-08-30 01:04:11', '2023-11-10 23:32:03'),
(41, 'homepage', 1, 'Modules\\Post\\Http\\Models\\Page', '', '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(42, 'contact-us', 2, 'Modules\\Post\\Http\\Models\\Page', '', '2023-08-30 01:04:11', '2023-08-30 01:05:09'),
(91, 'education', 1, 'Modules\\Post\\Http\\Models\\Post', '', '2023-08-30 01:04:11', '2023-09-04 23:49:06'),
(92, 'supershop', 2, 'Modules\\Post\\Http\\Models\\Post', '', '2023-08-30 01:04:11', '2023-09-05 00:10:32'),
(93, 'health-fitness', 3, 'Modules\\Post\\Http\\Models\\Post', '', '2023-08-30 01:04:11', '2023-09-05 00:11:48'),
(94, 'accomodation', 4, 'Modules\\Post\\Http\\Models\\Post', '', '2023-08-30 01:04:11', '2023-09-05 00:19:51'),
(95, 'food', 5, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:21:54', '2023-09-05 00:21:54'),
(96, 'sports', 6, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:23:22', '2023-09-05 00:23:22'),
(97, 'recreation', 7, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:23:52', '2023-09-05 00:23:52'),
(98, 'safety-security', 8, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:24:18', '2023-09-05 00:24:18'),
(99, 'bank-atm', 9, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:24:42', '2023-09-05 00:24:42'),
(100, 'transport', 10, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:25:18', '2023-09-05 00:25:18'),
(101, 'religious-center', 11, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:25:47', '2023-09-05 00:25:47'),
(102, 'entrepreneurship', 12, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:26:05', '2023-09-05 00:26:05'),
(103, 'event-management', 13, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:26:39', '2023-09-05 00:26:39'),
(104, 'jogging-track', 14, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-05 00:27:08', '2023-09-05 00:27:08'),
(105, 'international-conference-hall', 15, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-09 04:44:45', '2023-09-09 04:44:45'),
(106, 'international-conference-hall-1', 15, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-09 04:44:45', '2023-09-09 04:44:45'),
(107, 'international-conference-hall-2', 16, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-09 23:51:37', '2023-09-09 23:51:37'),
(108, 'ha', 16, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-09 23:51:37', '2023-09-09 23:51:37'),
(109, 'international-conference-hall-3', 17, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 00:46:51', '2023-09-10 00:46:51'),
(110, 'international-conference-hall-4', 17, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 00:46:51', '2023-09-10 00:46:51'),
(111, 'international-conference-hall-5', 18, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 01:04:46', '2023-09-10 01:04:46'),
(112, 'international-conference-hall-6', 18, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 01:04:46', '2023-09-10 01:04:46'),
(113, 'international-conference-hall-7', 19, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 01:08:19', '2023-09-10 01:08:19'),
(114, 'international-conference-hall-8', 19, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 01:08:19', '2023-09-10 01:08:19'),
(116, 'international-conference-hall-10', 20, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 01:09:41', '2023-09-10 01:09:41'),
(117, 'experienced-team', 21, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:05:41', '2023-09-10 03:07:39'),
(118, 'green-environment-1', 21, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:05:41', '2023-09-10 03:05:41'),
(119, '360-support', 22, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:08:20', '2023-09-10 03:08:20'),
(120, '360-support-1', 22, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:08:21', '2023-09-10 03:08:21'),
(121, 'highest-security', 23, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:23:53', '2023-09-10 03:23:53'),
(122, 'highest-security-1', 23, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:23:53', '2023-09-10 03:23:53'),
(123, 'quality-construction', 24, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:24:23', '2023-09-10 03:24:23'),
(124, 'quality-construction-1', 24, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:24:23', '2023-09-10 03:24:23'),
(125, 'excellent-service', 25, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:25:16', '2023-09-10 03:25:16'),
(126, 'excellent-service-1', 25, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:25:16', '2023-09-10 03:25:16'),
(127, 'green-environment', 26, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:25:39', '2023-09-10 03:25:39'),
(128, 'green-environment-2', 26, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 03:25:39', '2023-09-10 03:25:39'),
(129, 'international-conference-hall-11', 27, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:09:41', '2023-09-10 04:09:41'),
(130, 'international-conference-hall-12', 27, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:09:41', '2023-09-10 04:09:41'),
(131, 'international-conference-hall-13', 28, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:11:10', '2023-09-10 04:11:10'),
(132, 'international-conference-hall-14', 28, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:11:10', '2023-09-10 04:11:10'),
(133, 'international-conference-hall-15', 29, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:11:55', '2023-09-10 04:11:55'),
(134, 'international-conference-hall-16', 29, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:11:55', '2023-09-10 04:11:55'),
(135, 'international-conference-hall-17', 30, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:12:41', '2023-09-10 04:12:41'),
(136, 'international-conference-hall-18', 30, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:12:41', '2023-09-10 04:12:41'),
(137, 'international-conference-hall-19', 31, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:13:30', '2023-09-10 04:13:30'),
(138, 'international-conference-hall-20', 31, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:13:30', '2023-09-10 04:13:30'),
(139, 'international-conference-hall-21', 32, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:13:50', '2023-09-10 04:13:50'),
(140, 'international-conference-hall-22', 32, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 04:13:50', '2023-09-10 04:13:50'),
(141, 'news-title-1', 33, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 05:46:40', '2023-09-10 05:46:40'),
(142, 'news-title-1-1', 33, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 05:46:40', '2023-09-10 05:46:40'),
(143, 'news-title-2', 34, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 23:30:51', '2023-09-10 23:30:51'),
(144, 'news-title-2-1', 34, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 23:30:51', '2023-09-10 23:30:51'),
(145, 'news-title-4', 35, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 23:31:41', '2023-09-10 23:31:41'),
(146, 'n', 35, 'Modules\\Post\\Http\\Models\\Post', '', '2023-09-10 23:31:41', '2023-09-10 23:31:41'),
(147, 'about', 3, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:31:30', '2023-09-19 02:31:30'),
(154, 'news', 10, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:33:59', '2023-09-19 02:33:59'),
(155, 'events', 11, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:34:14', '2023-09-19 02:34:14'),
(156, 'gallery', 12, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:34:29', '2023-09-19 02:34:29'),
(157, 'blog', 13, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:34:41', '2023-09-19 02:34:41'),
(158, 'terms-and-conditions', 14, 'Modules\\Post\\Http\\Models\\Page', '', '2023-09-19 02:35:09', '2023-09-19 02:35:09'),
(160, 'sfvbdsfv-1', 36, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:12:55', '2023-10-29 23:12:55'),
(161, 'education-1', 37, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:40:52', '2023-10-29 23:40:52'),
(162, 'education-2', 37, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:40:52', '2023-10-29 23:40:52'),
(163, 'jogging-track-1', 38, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:42:33', '2023-10-29 23:42:33'),
(164, 'jogging-track-2', 38, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:42:33', '2023-10-29 23:42:33'),
(165, 'education-3', 39, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:43:41', '2023-10-29 23:43:41'),
(166, 'education-4', 39, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-29 23:43:41', '2023-10-29 23:43:41'),
(167, 'main-gate-dsc', 40, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:01:35', '2023-10-30 00:01:35'),
(168, 'main-gate-dsc-1', 40, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:01:35', '2023-10-30 00:01:35'),
(169, 'main-gate-cafe', 41, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:03:28', '2023-10-30 00:03:28'),
(170, 'main-gate-dsc-2', 41, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:03:28', '2023-10-30 00:03:28'),
(171, 'dsc-photo', 42, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:04:21', '2023-10-30 00:04:21'),
(172, 'dsc-photo-1', 42, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 00:04:21', '2023-10-30 00:04:21'),
(173, 'news-title-5', 43, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 01:20:31', '2023-10-30 01:20:31'),
(174, 'news-title-5-1', 43, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-30 01:20:31', '2023-10-30 01:20:31'),
(175, 'event-title-1', 44, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-31 00:42:34', '2023-10-31 00:42:34'),
(176, 'event-title-5', 44, 'Modules\\Post\\Http\\Models\\Post', '', '2023-10-31 00:42:34', '2023-10-31 00:42:34'),
(177, 'request-for-expression-of-interest-for-hiring-service-under-spfms', 45, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:54:10', '2023-11-10 22:54:10'),
(178, 'notice-board', 45, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:54:10', '2023-11-10 22:54:10'),
(179, 'eoi-national-for-hiring-service-under-spfms', 46, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:56:15', '2023-11-10 22:56:15'),
(180, 'eoi-national-for-hiring-service-under-spfms-1', 46, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:56:15', '2023-11-10 22:56:15'),
(181, 'bivinn-dhrner-zanbahner-muulz-punrnirdharn-smprkit', 47, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:56:33', '2023-11-10 22:56:33'),
(182, 'bivinn-dhrner-zanbahner-muulz-punrnirdharn-smprkit-1', 47, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 22:56:33', '2023-11-10 22:56:33'),
(183, 'request-for-expression-of-interest-for-hiring-service-under-spfms-request-for-expression-of-interest-for-hiring-service-under-spfms', 48, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 23:01:51', '2023-11-10 23:01:51'),
(184, 'request-for-expression-of-interest-for-hiring-service-under-spfms-request-for-expression-of-interest-for-hiring-service-under-spfms-1', 48, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-10 23:01:51', '2023-11-10 23:01:51'),
(185, 'about-us', 6, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-10 23:26:51', '2023-11-10 23:27:10'),
(186, 'ssc-corner', 5, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-10 23:31:17', '2023-11-10 23:31:17'),
(187, 'national-integrity-strategy', 8, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-10 23:34:10', '2023-11-10 23:42:31'),
(189, 'right-to-information', 9, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-10 23:43:35', '2023-11-10 23:43:35'),
(193, 'service-process-simplification', 12, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-10 23:52:18', '2023-11-10 23:52:18'),
(195, 'others', 14, 'Modules\\Post\\Http\\Models\\Category', '', '2023-11-11 02:10:45', '2023-11-11 03:05:10'),
(196, '2020-saler-jeessi-preekshar-muulsnd-bitrn-prsngoe', 49, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-11 03:07:37', '2023-11-11 03:07:37'),
(197, '2020-saler-jeessi-preekshar-muulsnd-bitrn-prsngoe-1', 49, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-11 03:07:37', '2023-11-11 03:07:37'),
(198, 'ro-achieve-the-desired-layout-where-the-image', 50, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-12 02:25:13', '2023-11-12 02:25:13'),
(199, 'ro-achieve-the-desired-layout-where-the-image-1', 50, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-12 02:25:13', '2023-11-12 02:25:13'),
(200, 'notice-boards', 15, 'Modules\\Post\\Http\\Models\\Page', '', '2023-11-12 06:05:30', '2023-11-12 06:05:47'),
(201, 'in-this-example-i-added-a-block-containing-css-rules', 51, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-12 23:25:34', '2023-11-12 23:25:34'),
(202, 'in-this-example-i-added-a-block-containing-css-rules-1', 51, 'Modules\\Post\\Http\\Models\\Post', '', '2023-11-12 23:25:34', '2023-11-12 23:25:34'),
(203, 'admission-form', 16, 'Modules\\Post\\Http\\Models\\Page', '', '2023-11-14 02:30:24', '2023-11-14 02:30:24'),
(204, 'new-photo', 52, 'Modules\\Post\\Http\\Models\\Post', '', '2023-12-04 02:48:26', '2023-12-04 02:48:26'),
(205, 'new-photo-1', 52, 'Modules\\Post\\Http\\Models\\Post', '', '2023-12-04 02:48:26', '2023-12-04 02:48:26'),
(206, 'golden-jubilee-of-independence', 15, 'Modules\\Post\\Http\\Models\\Category', '', '2025-07-21 03:46:57', '2025-07-21 03:46:57'),
(207, 'activities', 53, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-21 03:49:47', '2025-07-21 03:49:47'),
(208, 'activities-1', 53, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-21 03:49:47', '2025-07-21 03:49:47'),
(209, 'kamrul-islam', 54, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-23 04:12:07', '2025-07-23 04:12:07'),
(210, 'prfesr-mha-touhidul-islam', 54, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-23 04:12:07', '2025-07-23 04:12:07'),
(211, 'rajib', 55, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-23 04:14:13', '2025-07-23 04:14:13'),
(212, 'rajib-1', 55, 'Modules\\Post\\Http\\Models\\Post', '', '2025-07-23 04:14:13', '2025-07-23 04:14:13'),
(213, 'itihas', 17, 'Modules\\Post\\Http\\Models\\Page', '', '2025-07-23 05:18:02', '2025-07-23 05:18:02'),
(214, 'ceyarmzan-mhodyer-jeebnee', 18, 'Modules\\Post\\Http\\Models\\Page', '', '2025-07-23 05:27:46', '2025-07-23 05:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int UNSIGNED DEFAULT NULL,
  `order` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `status` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `abbreviation`, `country_id`, `order`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nilphamari', 'NIL', 1, 2, 0, '1', '2023-11-13 01:20:37', '2023-12-05 03:38:39'),
(2, 'Dinajpur', 'DIN', 1, 3, 0, '1', '2023-11-14 05:12:41', '2023-12-05 03:38:39'),
(3, 'Brahmanbaria', 'BRA', 1, 4, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(4, 'Rangamati', 'RAN', 1, 5, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(5, 'Noakhali', 'NOA', 1, 6, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(6, 'Chandpur', 'CHA', 1, 7, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(7, 'Lakshmipur', 'LAK', 1, 8, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(8, 'Chattogram', 'CHA', 1, 9, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(9, 'Coxsbazar', 'COX', 1, 10, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(10, 'Khagrachhari', 'KHA', 1, 11, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(11, 'Bandarban', 'BAN', 1, 12, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(12, 'Sirajganj', 'SIR', 1, 13, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(13, 'Pabna', 'PAB', 1, 14, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(14, 'Bogura', 'BOG', 1, 15, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(15, 'Rajshahi', 'RAJ', 1, 16, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(16, 'Natore', 'NAT', 1, 17, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(17, 'Joypurhat', 'JOY', 1, 18, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(18, 'Chapainawabganj', 'CHA', 1, 19, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(19, 'Naogaon', 'NAO', 1, 20, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(20, 'Jashore', 'JAS', 1, 21, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(21, 'Satkhira', 'SAT', 1, 22, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(22, 'Meherpur', 'MEH', 1, 23, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(23, 'Narail', 'NAR', 1, 24, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(24, 'Chuadanga', 'CHU', 1, 25, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(25, 'Kushtia', 'KUS', 1, 26, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(26, 'Magura', 'MAG', 1, 27, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(27, 'Khulna', 'KHU', 1, 28, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(28, 'Bagerhat', 'BAG', 1, 29, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(29, 'Jhenaidah', 'JHE', 1, 30, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(30, 'Jhalakathi', 'JHA', 1, 31, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(31, 'Patuakhali', 'PAT', 1, 32, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(32, 'Pirojpur', 'PIR', 1, 33, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(33, 'Barisal', 'BAR', 1, 34, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(34, 'Bhola', 'BHO', 1, 35, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(35, 'Barguna', 'BAR', 1, 36, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(36, 'Sylhet', 'SYL', 1, 37, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(37, 'Moulvibazar', 'MOU', 1, 38, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(38, 'Habiganj', 'HAB', 1, 39, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(39, 'Sunamganj', 'SUN', 1, 40, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(40, 'Narsingdi', 'NAR', 1, 41, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(41, 'Gazipur', 'GAZ', 1, 42, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(42, 'Shariatpur', 'SHA', 1, 43, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(43, 'Narayanganj', 'NAR', 1, 44, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(44, 'Tangail', 'TAN', 1, 45, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(45, 'Kishoreganj', 'KIS', 1, 46, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(46, 'Manikganj', 'MAN', 1, 47, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(47, 'Dhaka', 'DHA', 1, 48, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(48, 'Munshiganj', 'MUN', 1, 49, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(49, 'Rajbari', 'RAJ', 1, 50, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(50, 'Madaripur', 'MAD', 1, 51, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(51, 'Gopalganj', 'GOP', 1, 52, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(52, 'Faridpur', 'FAR', 1, 53, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(53, 'Panchagarh', 'PAN', 1, 54, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(54, 'Feni', 'FEN', 1, 55, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(55, 'Lalmonirhat', 'LAL', 1, 56, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(56, 'Comilla', 'COM', 1, 57, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(57, 'Gaibandha', 'GAI', 1, 58, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(58, 'Thakurgaon', 'THA', 1, 59, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(59, 'Rangpur', 'RAN', 1, 60, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(60, 'Kurigram', 'KUR', 1, 61, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(61, 'Sherpur', 'SHE', 1, 62, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(62, 'Mymensingh', 'MYM', 1, 63, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(63, 'Jamalpur', 'JAM', 1, 64, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39'),
(64, 'Netrokona', 'NET', 1, 65, 0, '1', '2023-12-04 05:55:22', '2023-12-05 03:38:39');

-- --------------------------------------------------------

--
-- Table structure for table `states_translations`
--

CREATE TABLE `states_translations` (
  `lang_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `states_id` int NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abbreviation` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`id`, `key`, `value`) VALUES
(1, 'db_version', '2.6'),
(2, 'Analytics_version', '1.0'),
(3, 'Analytics_type', 'plugin'),
(4, 'Captcha_version', '1.0'),
(5, 'Captcha_type', 'plugin'),
(6, 'ContactForm_version', '1.0'),
(7, 'ContactForm_type', 'plugin'),
(8, 'Faq_version', '1.0'),
(9, 'Faq_type', 'plugin'),
(10, 'KamrulDashboard_version', '1.3'),
(11, 'KamrulDashboard_type', 'plugin'),
(12, 'Language_version', '1.0'),
(13, 'Language_type', 'plugin'),
(14, 'LanguageAdvanced_version', '1.0'),
(15, 'LanguageAdvanced_type', 'plugin'),
(16, 'Location_version', '1.0'),
(17, 'Location_type', 'plugin'),
(18, 'Menus_version', '1.0'),
(19, 'Menus_type', 'plugin'),
(20, 'Newsletter_version', '1.0'),
(21, 'Newsletter_type', 'plugin'),
(22, 'Post_version', '1.3'),
(23, 'Post_type', 'plugin'),
(24, 'SeoHelper_version', '1.0'),
(25, 'SeoHelper_type', 'plugin'),
(26, 'Shortcodes_version', '1.0'),
(27, 'Shortcodes_type', 'plugin'),
(28, 'SimpleSlider_version', '1.0'),
(29, 'SimpleSlider_type', 'plugin'),
(30, 'Sitemap_version', '1.0'),
(31, 'Sitemap_type', 'plugin'),
(32, 'SocialLogin_version', '1.0'),
(33, 'SocialLogin_type', 'plugin'),
(34, 'Table_version', '1.0'),
(35, 'Table_type', 'plugin'),
(36, 'Theme_version', '1.0'),
(37, 'Theme_type', 'plugin'),
(38, 'ThemeIcon_version', '1.0'),
(39, 'ThemeIcon_type', 'plugin'),
(40, 'Translation_version', '1.0'),
(41, 'Translation_type', 'plugin'),
(42, 'Widget_version', '1.0'),
(43, 'Widget_type', 'plugin'),
(48, 'Option_version', '1.6'),
(49, 'Option_type', 'plugin'),
(50, 'Admission_version', '1.3'),
(51, 'Admission_type', 'plugin');

-- --------------------------------------------------------

--
-- Table structure for table `theme_icons`
--

CREATE TABLE `theme_icons` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_icons`
--

INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '344fb7d9-2ca3-46fe-8075-15c87c795c6b', 'icon-type', 'icon-type', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2, '904321c5-ae32-4e54-b4bc-418958b5df62', 'icon-box1', 'icon-box1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(3, '3380b3dd-2a1f-4aeb-89db-9a05115e5fb3', 'icon-archive1', 'icon-archive1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(4, '0ce51697-c81c-4e12-8855-c8a3c9a5b5ef', 'icon-envelope2', 'icon-envelope2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(5, '28a9c4a9-b8a4-4eba-a4a2-4a0299e562f9', 'icon-email', 'icon-email', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(6, 'cc80ea7d-f108-4fc2-9dc8-fcc98dfec826', 'icon-files', 'icon-files', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(7, '42b5c120-9ca2-4e0d-8175-8af253c8ce06', 'icon-printer2', 'icon-printer2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(8, 'ed31682d-5cdf-4544-91a2-dcd448e9b1d5', 'icon-folder-add', 'icon-folder-add', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(9, '147c2f38-b295-4bf5-8536-49b2397bc720', 'icon-folder-settings', 'icon-folder-settings', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(10, 'e0f8b8ae-adfe-475b-af6d-092ea4a6ee80', 'icon-folder-check', 'icon-folder-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(11, 'adaf13cd-7a38-4a24-b579-7d6f5b8df31a', 'icon-wifi-low', 'icon-wifi-low', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(12, 'a979e045-cb0f-4261-82db-4228efcddf81', 'icon-wifi-mid', 'icon-wifi-mid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(13, 'e21c3d12-67d2-4482-9f39-3dbef80db107', 'icon-wifi-full', 'icon-wifi-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(14, '533f3231-3210-46b7-b244-3e0b97762d68', 'icon-connection-empty', 'icon-connection-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(15, '7dccc521-f745-4740-94d3-f9562f2f9945', 'icon-battery-full1', 'icon-battery-full1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(16, 'e05c5342-0f20-4bb4-8ca7-a2ec2722acbb', 'icon-settings', 'icon-settings', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(17, 'db4103cf-5418-4400-a878-dd91f7e04d94', 'icon-arrow-left1', 'icon-arrow-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(18, '2b47a741-6798-4a48-84dd-6149efd6f4dd', 'icon-arrow-up1', 'icon-arrow-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(19, 'e140e430-5d13-44cf-b912-a4c7ad3d2ca3', 'icon-arrow-down1', 'icon-arrow-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(20, '5d3a36a5-2953-4c06-9d6b-0fd274586cf9', 'icon-arrow-right1', 'icon-arrow-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(21, 'c079aeff-ae22-47cc-b10f-ca2fdf524f15', 'icon-reload', 'icon-reload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(22, '77001843-7916-46a9-882d-3e7a6242e50f', 'icon-download1', 'icon-download1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(23, 'b1cf94cf-90b6-4245-9e11-ed9c0d174afe', 'icon-tag1', 'icon-tag1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(24, '520e9d70-e479-4f16-a7f7-7b5953077d3e', 'icon-trashcan', 'icon-trashcan', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(25, 'f399b9da-d1bc-48c0-9101-6a42648b4a9c', 'icon-search1', 'icon-search1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(26, '8a369b28-1d1f-4a6c-95b2-d36ae809dcfa', 'icon-zoom-in', 'icon-zoom-in', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(27, '28a19a09-3299-49cc-8308-6e06277898ca', 'icon-zoom-out', 'icon-zoom-out', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(28, '79e5228b-b4af-4102-b64e-faf98e9d219c', 'icon-chat', 'icon-chat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(29, '8f772d3c-7563-4c0c-b5f2-1bb86d88f2e7', 'icon-clock2', 'icon-clock2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(30, '27b7b674-41ae-466a-bc72-46b86a080efd', 'icon-printer', 'icon-printer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(31, '301ca818-bcf0-47f7-afd4-5ef5d4c4de6d', 'icon-home1', 'icon-home1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(32, 'e2f89976-2cf0-4b77-868a-1b45aeec3f80', 'icon-flag2', 'icon-flag2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(33, 'b57939d5-e59b-4204-a05a-7f0ba916c03b', 'icon-meter', 'icon-meter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(34, 'a5e82923-e3e9-4711-b929-d4474d6785cb', 'icon-switch', 'icon-switch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(35, '5d8fea18-f1ac-436b-b960-2ae979519bbe', 'icon-forbidden', 'icon-forbidden', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(36, 'a9362542-a73e-4ea9-b73c-0cea23134066', 'icon-phone-landscape', 'icon-phone-landscape', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(37, 'e655afbe-dd91-4ac8-b1c7-3667a46dab58', 'icon-tablet1', 'icon-tablet1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(38, '4220ed57-9285-40ba-b186-24fbc9725cb8', 'icon-tablet-landscape', 'icon-tablet-landscape', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(39, 'f401dc47-5a41-4d7d-8094-9f87edb29257', 'icon-laptop1', 'icon-laptop1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(40, '71b10757-63bb-4d60-8bb4-3adbb52b0eb1', 'icon-camera1', 'icon-camera1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(41, 'fefb748f-739e-4fba-b6e2-d1f99f778d98', 'icon-microwave-oven', 'icon-microwave-oven', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(42, 'f0d806a1-0ea5-4f83-b6bd-fff9074b83b5', 'icon-credit-cards', 'icon-credit-cards', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(43, 'dd8930e5-1536-4c2f-8489-26e635caebfc', 'icon-map-marker1', 'icon-map-marker1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(44, '7103bfbd-7708-4101-a1e7-b68f77580e87', 'icon-map2', 'icon-map2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(45, 'f7ceb027-bd1f-4997-b476-a46304ac8269', 'icon-support', 'icon-support', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(46, '0816a070-b5a7-4235-9962-507fd04032d5', 'icon-newspaper2', 'icon-newspaper2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(47, '821b92ba-8829-4e0a-b5da-a3896d9f76b4', 'icon-barbell', 'icon-barbell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(48, '8e69dc69-c4aa-466c-8291-bbeb8f1ceab4', 'icon-stopwatch1', 'icon-stopwatch1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(49, 'e9bd9476-a24b-45f9-abda-5e9cad30d852', 'icon-atom1', 'icon-atom1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(50, '57342101-2956-4372-ae13-520432e5ceae', 'icon-image2', 'icon-image2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(51, 'cca0d3ca-3885-4052-a79c-738697ea52ed', 'icon-cube1', 'icon-cube1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(52, 'b91cb46e-2ffc-48b7-a6a1-f8e7f75d1f71', 'icon-bars1', 'icon-bars1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(53, 'af2ccbfc-98ab-41c9-b1e4-e4afeb8712ed', 'icon-chart', 'icon-chart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(54, 'fc7f272e-9f2d-4577-8106-468c02adabd6', 'icon-pencil', 'icon-pencil', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(55, 'a485b702-9a61-4a60-a7eb-b5d38c8bf02e', 'icon-measure', 'icon-measure', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(56, 'e4fd49b9-af87-4dd0-9dbe-8a1e6ef9fe2d', 'icon-eyedropper', 'icon-eyedropper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(57, 'a0eb294a-4caa-4638-a7f3-28743cc778a0', 'icon-file-settings', 'icon-file-settings', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(58, '0e0623c6-f745-4f91-812f-8630c5c702f4', 'icon-file-signature', 'icon-file-signature', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(59, 'a227b12d-9de3-4ed8-89aa-4a683634beb1', 'icon-file2', 'icon-file2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(60, 'a94eed7b-2311-46d9-b41c-60d316fb8988', 'icon-align-left1', 'icon-align-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(61, '6eabbc1b-b053-46bd-85d2-6e105b7a7728', 'icon-align-right1', 'icon-align-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(62, 'd2883ce3-8c2d-45ab-8ac5-b5eba1259c51', 'icon-align-center1', 'icon-align-center1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(63, '2c266512-b0c2-4952-adce-2c566925fbde', 'icon-align-justify1', 'icon-align-justify1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(64, 'a877a9a2-7afe-42e8-b791-94e9f7747c45', 'icon-file-broken', 'icon-file-broken', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(65, 'ea07b360-b360-4542-9493-3095e387a723', 'icon-browser', 'icon-browser', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(66, '1ad886b4-830e-4035-a225-c2c9add2de72', 'icon-windows1', 'icon-windows1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(67, 'f14a0e3b-f990-4794-9a36-3a015477651c', 'icon-window', 'icon-window', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(68, 'c282a25c-1e37-4c16-b79a-ce1b4361b2c0', 'icon-folder2', 'icon-folder2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(69, '3957b4cd-4f56-4751-9ef6-c8a09b1ba1e9', 'icon-connection-25', 'icon-connection-25', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(70, '40b9ad95-50cf-4501-b853-c8a2687c45ff', 'icon-connection-50', 'icon-connection-50', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(71, '4e3ae001-0925-4f44-bd2a-b8157598b6e8', 'icon-connection-75', 'icon-connection-75', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(72, 'e77efdb8-cbdc-4975-aad5-fee0b1a48c8f', 'icon-connection-full', 'icon-connection-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(73, 'fa27a453-10c3-432f-9ae9-ef72fed3a759', 'icon-list1', 'icon-list1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(74, '527500d0-5b1a-4052-83b8-6cfa1a7101d5', 'icon-grid', 'icon-grid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(75, '31472368-39ff-4040-959b-0a086a682003', 'icon-stack3', 'icon-stack3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(76, '1412684f-d885-4842-8537-e5a904d97757', 'icon-battery-charging', 'icon-battery-charging', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(77, 'da85bcf2-f45d-409a-8fc0-224150566cf1', 'icon-battery-empty1', 'icon-battery-empty1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(78, '889aff00-5073-4e50-b795-88619823606c', 'icon-battery-25', 'icon-battery-25', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(79, '2577a4a7-960b-46a7-80d3-62a2e1a9d420', 'icon-battery-50', 'icon-battery-50', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(80, '102ba261-f8b2-40b8-ba7f-2290f8f9f44b', 'icon-battery-75', 'icon-battery-75', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(81, 'a146e27c-eba4-4d70-b8e5-037ed548605d', 'icon-refresh', 'icon-refresh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(82, '35312832-f224-406b-9646-af8b1665ad49', 'icon-volume', 'icon-volume', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(83, '9474822f-2ab0-4fa9-a0e8-dcf4d208e219', 'icon-volume-increase', 'icon-volume-increase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(84, '47f8706a-617a-4640-938c-726d2afb5bd4', 'icon-volume-decrease', 'icon-volume-decrease', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(85, '757a649b-bc9e-410f-82fd-2ecde9fde588', 'icon-mute', 'icon-mute', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(86, '015895a8-5460-4195-94a1-763ac84400d6', 'icon-microphone1', 'icon-microphone1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(87, '55023972-0159-4ca6-ab49-18a29718aabf', 'icon-microphone-off', 'icon-microphone-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(88, '5aa730b8-8493-4206-aea0-a7a718dfc9b9', 'icon-book1', 'icon-book1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(89, 'e20fa8c6-5137-4de0-b3ce-14219ebd83d7', 'icon-checkmark', 'icon-checkmark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(90, '61b17b53-0f0c-4d34-94a9-2f3a121dcd67', 'icon-checkbox-checked', 'icon-checkbox-checked', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(91, '0386151e-effa-48d8-bfb6-662cedc376f8', 'icon-checkbox', 'icon-checkbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(92, 'c8b1d58a-774a-4b95-9180-f3a1037627fd', 'icon-paperclip1', 'icon-paperclip1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(93, '4b3afc76-02d3-4a7d-bcbe-984fbeef5be7', 'icon-chat-1', 'icon-chat-1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(94, 'df0c9370-cd4d-4085-9d18-7aab8045176e', 'icon-chat-2', 'icon-chat-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(95, 'a6d2878d-03f4-4e64-af1d-d5a6772762ea', 'icon-chat-3', 'icon-chat-3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(96, '21d3454e-d52c-4d77-85b8-02644dea21c4', 'icon-comment2', 'icon-comment2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(97, 'efc06bf3-cecc-40ea-845e-27b99bfa9d49', 'icon-calendar2', 'icon-calendar2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(98, '9bd2e17e-053a-4914-b094-9657b76c1e72', 'icon-bookmark2', 'icon-bookmark2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(99, 'de796952-512b-4d99-90d8-21d75a26aafd', 'icon-email2', 'icon-email2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(100, '12edb3fa-0d8d-49c4-a28b-ae454656fc62', 'icon-heart2', 'icon-heart2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(101, '04960838-0952-4ecc-aa3d-3a2eca17842c', 'icon-enter', 'icon-enter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(102, 'f8ab2bd3-2db4-49a7-a85f-f8820556e2cd', 'icon-cloud1', 'icon-cloud1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(103, '8a1cabe5-b0c8-449e-8f52-25e0a158ac50', 'icon-book2', 'icon-book2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(104, '096d1270-1eaa-4f7d-a824-888bab1e9db6', 'icon-star2', 'icon-star2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(105, '978c25cb-d776-403e-8424-5138a7b9e113', 'icon-lock1', 'icon-lock1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(106, '716f81f2-5fec-4096-9fcd-f6cf9b455f63', 'icon-unlocked', 'icon-unlocked', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(107, 'e88abac8-1561-4cc6-8ebb-1ee09430a37e', 'icon-unlocked2', 'icon-unlocked2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(108, '9b982d59-410e-40da-a303-29ad72a6af34', 'icon-users1', 'icon-users1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(109, '0f2f72a7-f8fb-42a7-8974-36ab21bd28a7', 'icon-user2', 'icon-user2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(110, 'fd94a065-9ed4-47b5-8bf4-f14fec7022a8', 'icon-users2', 'icon-users2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(111, 'e632914f-fdbf-4c1d-8ced-4241559bbda7', 'icon-user21', 'icon-user21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(112, 'bf3a2422-a8db-4708-9f79-16f2c7f469c8', 'icon-bullhorn1', 'icon-bullhorn1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(113, 'a4d3cc12-67b1-47f4-9ca5-4f9c9883822a', 'icon-share1', 'icon-share1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(114, '6a5e00a6-d6aa-4950-aef7-9a91d9dfc4eb', 'icon-screen', 'icon-screen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(115, '9df86963-9304-4a4f-b7a6-c8d91323f4a0', 'icon-phone1', 'icon-phone1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(116, '522f935a-2744-4eaf-ad58-12067e12be6b', 'icon-phone-portrait', 'icon-phone-portrait', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(117, '9ae038ca-ceda-4dbe-a3a5-4ff35afbf860', 'icon-calculator1', 'icon-calculator1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(118, 'a41a4587-e80c-49b5-bca5-c778c9dd0670', 'icon-bag', 'icon-bag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(119, '4ca7c6cb-e112-488a-aab9-40348a7bc1c5', 'icon-diamond', 'icon-diamond', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(120, '8a650831-3a1c-40b3-8c33-147ce153a4d7', 'icon-drink', 'icon-drink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(121, 'e306f515-e5f2-4a34-b2c8-1b0d0bee1532', 'icon-shorts', 'icon-shorts', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(122, 'c6fe71a9-55e8-4f84-858c-a7d7251f1707', 'icon-vcard', 'icon-vcard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(123, 'f62eba8e-5df1-41ca-989b-1a5e83cd8244', 'icon-sun2', 'icon-sun2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(124, 'bcb831c2-12e8-4ea8-89db-1f44835610ed', 'icon-bill', 'icon-bill', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(125, 'f7b1eb9a-bd1f-44bf-a3c3-123a946a130b', 'icon-coffee1', 'icon-coffee1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(126, '7e04f581-441d-456e-a3b8-6a819f616369', 'icon-tv2', 'icon-tv2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(127, '5f11d63f-f662-4949-b362-2b304f01ec32', 'icon-newspaper3', 'icon-newspaper3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(128, '63cf797b-6615-4e9f-895a-d5b5cc15e8ae', 'icon-stack', 'icon-stack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(129, '40ecdbbe-a42a-4729-b388-7be8e1ec4618', 'icon-syringe1', 'icon-syringe1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(130, 'b703d8f0-0b88-472d-bd1e-2f07efeed7e0', 'icon-health', 'icon-health', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(131, 'c2d92b52-537f-4e0d-9c38-a66b84e50413', 'icon-bolt1', 'icon-bolt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(132, '5d882aa0-94b3-4685-9b1c-45a585ef520a', 'icon-pill', 'icon-pill', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(133, '7bdcd2d2-c514-478e-b986-1b206e947824', 'icon-bones', 'icon-bones', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(134, '8d263a5a-f4a8-45c8-bcb0-dad4119947e1', 'icon-lab', 'icon-lab', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(135, '400347ff-e482-43ba-a59e-4903710ef909', 'icon-clipboard2', 'icon-clipboard2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(136, '745fd741-64bc-4bf7-811a-b1ff6ac2de5b', 'icon-mug', 'icon-mug', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(137, '337c7ae5-aade-4663-bea9-fba23573dfa4', 'icon-bucket', 'icon-bucket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(138, 'bed4a77b-ca21-4840-b6ce-4173a19c7cca', 'icon-select', 'icon-select', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(139, '6cca5094-ea7b-4b0d-ba05-de148df71dc7', 'icon-graph', 'icon-graph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(140, '7b08198f-f2b8-4ae1-90b8-285306a4422a', 'icon-crop1', 'icon-crop1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(141, 'a6ebd318-200f-44f7-a330-0c265c338853', 'icon-heart21', 'icon-heart21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(142, '8296275e-73a6-4de1-816c-d75a3e5f94f4', 'icon-cloud2', 'icon-cloud2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(143, 'ddba2659-0cab-4ad2-81ba-7de28e92a772', 'icon-star21', 'icon-star21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(144, '9e61586e-25ef-4614-9af2-226d71771634', 'icon-pen1', 'icon-pen1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(145, '1d47ae2b-d1cd-4158-9e55-f2058bbcc0fd', 'icon-diamond2', 'icon-diamond2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(146, 'b9859b56-fb24-458c-9241-c993384f9bba', 'icon-display', 'icon-display', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(147, '44a4e1e1-bedf-416f-874f-6d66c01d2e67', 'icon-paperplane', 'icon-paperplane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(148, '485132ac-88b7-4820-beca-4e1e45c87493', 'icon-params', 'icon-params', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(149, '55129b85-6016-4a80-9d8d-782dfa4279fb', 'icon-banknote', 'icon-banknote', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(150, '355d8e2f-f7ad-4fde-af30-5e336fedf405', 'icon-vynil', 'icon-vynil', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(151, '3c259f72-2443-4209-a5ab-61853e5682c0', 'icon-truck1', 'icon-truck1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(152, '5c0e551c-c508-4916-bed4-2bd35c616376', 'icon-world', 'icon-world', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(153, 'fb1cd8b8-029b-44b8-b9aa-c14edd78c3e2', 'icon-tv1', 'icon-tv1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(154, '4c0e9aba-45ef-46a1-a7b1-0f9bce652920', 'icon-sound', 'icon-sound', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(155, '71837215-74da-4c33-97b5-5a29f2f374c0', 'icon-video1', 'icon-video1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(156, 'ddd003b9-b5c0-4cb8-80c4-15d375529c6c', 'icon-trash1', 'icon-trash1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(157, '6bec9417-fa4a-4a07-b77a-a680bb20c7bd', 'icon-user3', 'icon-user3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(158, '52d0f51c-e79e-47b6-9b3b-b73c76df6d4f', 'icon-key1', 'icon-key1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(159, 'ddf8a969-0152-436b-a0be-daf1ad974db8', 'icon-search2', 'icon-search2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(160, 'a02ce234-56bf-4e0b-8e58-1b54af6dedb4', 'icon-settings2', 'icon-settings2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(161, 'd795956e-87d9-4a00-a61b-c47eeb089574', 'icon-camera2', 'icon-camera2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(162, '9970e9c9-f74f-4793-ab55-5f2be1857171', 'icon-tag2', 'icon-tag2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(163, '0b0a470d-8b84-4b7b-be76-fc80a85e2eff', 'icon-lock2', 'icon-lock2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(164, '6c748ce4-0827-4317-87b3-8715632ae555', 'icon-bulb', 'icon-bulb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(165, '419c41b7-adee-4ab4-9799-aa8d5cf0b43c', 'icon-location', 'icon-location', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(166, '5b5a27a5-78e2-4aff-9a61-2277fe0f65dc', 'icon-eye2', 'icon-eye2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(167, '6700b505-5777-44c2-9a10-7259e058ce19', 'icon-bubble', 'icon-bubble', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(168, 'fb5662e8-e16c-42b2-b585-98e16cacf9d5', 'icon-stack2', 'icon-stack2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(169, '071c080f-b5a9-4a0c-9eb8-047b231d5d41', 'icon-cup', 'icon-cup', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(170, '78fe54a0-74f7-4f01-8f95-d4a07c5d1208', 'icon-phone2', 'icon-phone2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(171, '8708d930-128c-4521-a2ff-434399b8d050', 'icon-news', 'icon-news', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(172, '1b42f388-34ef-4dc2-abfb-e61b50bffbfa', 'icon-mail', 'icon-mail', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(173, 'c8b3bbae-b67a-498d-9e30-dd480fe58cf3', 'icon-like', 'icon-like', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(174, 'dfa23961-b170-46a0-9ab6-b15ac8e9006f', 'icon-photo', 'icon-photo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(175, 'd4738977-6e64-4d5d-a0b1-dbc655e3f248', 'icon-note', 'icon-note', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(176, 'b2e2aa49-f1f0-4483-8c65-68a0d4b049dd', 'icon-clock21', 'icon-clock21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(177, '3ea8c2af-05a9-4509-b5d7-0b2c4869f049', 'icon-data', 'icon-data', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(178, 'd8279028-5e06-4107-8d7b-fa4f52ce07de', 'icon-music1', 'icon-music1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(179, '98930c30-4092-43f1-9078-f114629612f2', 'icon-megaphone', 'icon-megaphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(180, 'd92383d1-37f4-42c2-b072-2baa0a25d9c4', 'icon-study', 'icon-study', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(181, 'a99462b4-61c3-4392-b168-25610ca23152', 'icon-lab2', 'icon-lab2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(182, '49202ff5-4740-4ffa-a3db-60d809e57074', 'icon-food', 'icon-food', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(183, '44bfbed4-b65a-472d-a4b7-a8191af68387', 'icon-t-shirt', 'icon-t-shirt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(184, '72432e7e-4dbc-4ba6-b832-61a886486f21', 'icon-fire1', 'icon-fire1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(185, 'e9f982f8-8061-4cc1-bf6f-8b3983100c41', 'icon-clip', 'icon-clip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(186, '24b02557-ea97-4087-a6fc-68f9dcec028b', 'icon-shop', 'icon-shop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(187, '1098fcb2-3aad-4044-9ce9-7656c0c5bd53', 'icon-calendar21', 'icon-calendar21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(188, 'd212d007-9111-4082-aa1d-f4a4a1e9c78f', 'icon-wallet1', 'icon-wallet1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(189, '924d8a84-1d09-454b-86d4-dd749a77aed4', 'icon-glass', 'icon-glass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(190, '5f0be9c2-4ed6-4e78-a3a3-b223296a2b85', 'icon-music2', 'icon-music2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(191, '443908bb-9d87-424b-baf8-be87c95c09f3', 'icon-search3', 'icon-search3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(192, 'b0e266ec-6331-4b70-a1e6-319b471a6189', 'icon-envelope21', 'icon-envelope21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(193, 'b421db23-af9f-4640-9203-18029c223996', 'icon-heart3', 'icon-heart3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(194, '261fd2a1-3cb6-440d-bd8c-9907ae179539', 'icon-star3', 'icon-star3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(195, '820c7a3b-4aaf-4896-a7c4-9d43fe9d9ef1', 'icon-star-empty', 'icon-star-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(196, '63ba1494-70dc-4793-84a5-dfc5a189fa91', 'icon-user4', 'icon-user4', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(197, 'cabb9e37-6da9-4b5f-b11e-3cd103d93946', 'icon-film1', 'icon-film1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(198, 'f717e3de-b5ce-4326-8c39-bb9e1603e86a', 'icon-th-large1', 'icon-th-large1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(199, '4267106c-f4de-4f73-9dd0-fbb542049cb3', 'icon-th1', 'icon-th1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(200, '7337dada-1132-4ca8-a302-585bab10fe71', 'icon-th-list1', 'icon-th-list1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(201, 'a31d7f1a-9ca6-4509-958d-86dcadf04a21', 'icon-ok', 'icon-ok', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(202, '0a303efc-8bc3-41db-bd50-79973eb12841', 'icon-remove', 'icon-remove', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(203, '36b35900-51d7-477d-a02a-662192be9cc5', 'icon-zoom-in2', 'icon-zoom-in2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(204, 'f109c5ec-db54-4f97-8053-7f831b7b8a9d', 'icon-zoom-out2', 'icon-zoom-out2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(205, 'b856cd70-6572-42e9-95a4-2114f0938e1e', 'icon-off', 'icon-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(206, 'f3ac9c94-dcc3-489d-9df5-23830e4cd48b', 'icon-signal1', 'icon-signal1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(207, '37b9e9b1-3c4e-4638-9f55-1da673f626d3', 'icon-cog1', 'icon-cog1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(208, '2ef28237-9403-46ad-b287-da7c8043da1f', 'icon-trash2', 'icon-trash2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(209, '5e2b286e-6ca9-402f-9bd1-11801211acc8', 'icon-home2', 'icon-home2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(210, 'd86a2bb6-1cf0-45b5-b0cb-937d37526a32', 'icon-file21', 'icon-file21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(211, '9ecdc062-a702-4805-896d-cface2ac6124', 'icon-time', 'icon-time', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(212, 'ca7bd01d-f194-467d-841b-0683726e04d3', 'icon-road1', 'icon-road1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(213, '57e17cfa-dc64-4779-8a3a-2f8dd09ce6c2', 'icon-download-alt', 'icon-download-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(214, 'b45d59ae-a886-406d-a5dc-a3d4f1ff7ddd', 'icon-download2', 'icon-download2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(215, 'f36846b0-6a8d-44e6-ad1a-08406df4ce30', 'icon-upload1', 'icon-upload1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(216, 'bedfed77-f545-4fa1-8b6b-ea8117a785e7', 'icon-inbox1', 'icon-inbox1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(217, '1e94a474-6702-4278-a545-d0849e37bfac', 'icon-play-circle2', 'icon-play-circle2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(218, '3412de01-3d41-4aaa-aa73-450891a65049', 'icon-repeat', 'icon-repeat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(219, 'b5c316bc-e5bd-433e-8978-3c0f1c08712f', 'icon-refresh2', 'icon-refresh2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(220, '79fe55d5-3eb7-4c13-8a9a-168bcb3c1066', 'icon-list-alt2', 'icon-list-alt2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(221, '1650d03a-1896-4de1-940c-f34b2e0c8779', 'icon-lock3', 'icon-lock3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(222, '176340b9-77c8-447a-b33b-54212eeba5bc', 'icon-flag21', 'icon-flag21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(223, '4e4b64da-15e8-4d45-9808-a7f8d6f101f4', 'icon-headphones1', 'icon-headphones1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(224, '2087f586-45fc-44e1-be65-08454c4e9c14', 'icon-volume-off1', 'icon-volume-off1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(225, 'a0d1205c-0828-4464-b27d-92c02ee592ed', 'icon-volume-down1', 'icon-volume-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(226, 'fd1abaff-2b0f-427a-9a49-d78d5a9ebe65', 'icon-volume-up1', 'icon-volume-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(227, 'f970d8aa-942c-414d-b5a4-4649817ce477', 'icon-qrcode1', 'icon-qrcode1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(228, '744704dd-506e-4191-ad3a-e2f2031da575', 'icon-barcode1', 'icon-barcode1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(229, '8fe93faf-0cba-490a-a28e-b45572fdafbf', 'icon-tag3', 'icon-tag3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(230, '30a2ed5f-795e-48f7-af8a-f34e4544473c', 'icon-tags1', 'icon-tags1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(231, 'f8e69484-f45a-4e63-8f81-6e114562f979', 'icon-book3', 'icon-book3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(232, '0fcb71d1-392b-4893-b858-cd9d3052ce9d', 'icon-bookmark21', 'icon-bookmark21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(233, '2e76f4fa-055a-471c-8e07-acf3ae55bc9c', 'icon-print2', 'icon-print2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(234, '1808b773-cb93-4b39-b827-41d263f2d90a', 'icon-camera3', 'icon-camera3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(235, 'baa7fd15-bf74-428c-9468-51c95900c912', 'icon-font1', 'icon-font1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(236, '6b0ae8b7-ce21-4dbe-868b-7fd9524f27b8', 'icon-bold1', 'icon-bold1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(237, 'fd17f85b-2a9b-4c3c-9cb1-6b419781c671', 'icon-italic1', 'icon-italic1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(238, '1d7a8c76-4b74-40ad-9297-c63b8ff7d920', 'icon-text-height1', 'icon-text-height1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(239, '1e7e43bf-6b61-4f28-b064-a4b44d4e7d43', 'icon-text-width1', 'icon-text-width1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(240, '7cb67413-5fc0-4674-ac6c-00d4e9557438', 'icon-align-left2', 'icon-align-left2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(241, 'e543a49a-e2f5-4620-9ccb-1799f69ee95f', 'icon-align-center2', 'icon-align-center2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(242, '36457f7f-b3cc-4249-8cea-9410cac7d714', 'icon-align-right2', 'icon-align-right2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(243, 'bfa65fee-509d-4cb7-8c95-e71ec955a79d', 'icon-align-justify2', 'icon-align-justify2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(244, 'f3a75722-c5fc-4e6f-9a8d-083e7e92bb4f', 'icon-list2', 'icon-list2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(245, '82760eb1-3666-4ff1-8567-83a60a4ecf62', 'icon-indent-left', 'icon-indent-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(246, '9f48c544-2c32-4225-ba7e-73ca35646f97', 'icon-indent-right', 'icon-indent-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(247, 'c64189d8-b57a-42ab-a4e7-835e3a8235b8', 'icon-facetime-video', 'icon-facetime-video', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(248, 'e700bb85-419c-468d-b8d7-d29ecd96a0d4', 'icon-picture', 'icon-picture', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(249, '02fb5d53-9a57-4b22-938e-13411824a3a2', 'icon-pencil2', 'icon-pencil2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(250, 'a9459212-4151-4f3a-84da-b67b4266637b', 'icon-map-marker2', 'icon-map-marker2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(251, '42a230f3-2a35-4611-9c01-e85b9317df79', 'icon-adjust1', 'icon-adjust1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(252, '4e8dbed4-0489-4397-b302-2f5bc68dcb15', 'icon-tint1', 'icon-tint1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(253, '9521a194-aa39-4b9e-b342-7f879a668d8a', 'icon-edit2', 'icon-edit2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(254, '47d5f32b-6a68-430f-a609-033cf51c330a', 'icon-share2', 'icon-share2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(255, 'd370b311-6c08-4207-8a6d-dcc70757d1c5', 'icon-check1', 'icon-check1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(256, 'f8b17083-25f1-4475-87c4-931a1387d62f', 'icon-move', 'icon-move', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(257, 'a87f75d6-1553-4fc1-af3f-8dee1c26acb8', 'icon-step-backward1', 'icon-step-backward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(258, '3f94a98d-7921-452f-bd7b-d5c453b7bef2', 'icon-fast-backward1', 'icon-fast-backward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(259, '42d07a5c-23ab-49ff-8763-e49e064ecdd1', 'icon-backward1', 'icon-backward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(260, '1e07f9f7-2045-4f1c-9b68-bccbef2d5166', 'icon-play1', 'icon-play1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(261, 'da55c325-25f8-49ae-846d-8051c7ba79f1', 'icon-pause1', 'icon-pause1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(262, '2e9180b5-a25c-4e79-a6c8-7e42d15e079f', 'icon-stop1', 'icon-stop1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(263, 'e1e2eb85-1dca-41f1-a898-cdaa51306d8d', 'icon-forward1', 'icon-forward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(264, 'a8b60dc6-cd82-4caa-b1b9-141a72a7e7f4', 'icon-fast-forward1', 'icon-fast-forward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(265, '91645a25-e454-48fa-b19a-fc0c11832311', 'icon-step-forward1', 'icon-step-forward1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(266, 'ab5b6278-1182-4f3f-817b-1bae267538b9', 'icon-eject1', 'icon-eject1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(267, 'f9f676c5-034b-4978-8271-025f1d165b2d', 'icon-chevron-left1', 'icon-chevron-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(268, '04c0e638-cda2-4a8d-803a-47667ae32e16', 'icon-chevron-right1', 'icon-chevron-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(269, 'e9a7befd-7b38-4439-9825-f2c68b3d7811', 'icon-plus-sign', 'icon-plus-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(270, 'fdf554e3-5aa5-41df-8879-3594ac7a9726', 'icon-minus-sign', 'icon-minus-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(271, '71372b0f-b5d5-4016-9584-3259545c47d8', 'icon-remove-sign', 'icon-remove-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(272, 'd85022af-9b19-4a4c-bdaa-545b5a020e85', 'icon-ok-sign', 'icon-ok-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(273, '2a7e9a76-ca6a-46a7-bf00-4aaee18b889d', 'icon-question-sign', 'icon-question-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(274, 'cd92a79f-6e3f-4006-a379-cfa6a9958ed8', 'icon-info-sign', 'icon-info-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(275, '77dea8aa-f908-40d0-981a-d0bb6643c281', 'icon-screenshot', 'icon-screenshot', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(276, '42c6fc99-53d3-4368-ae2f-4ef3a5850c84', 'icon-remove-circle', 'icon-remove-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(277, 'a78c5ff9-6340-4fa4-bbd2-400601f448c9', 'icon-ok-circle', 'icon-ok-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(278, '3a33a8bf-eed2-464b-bd42-f186a69ba1c7', 'icon-ban-circle', 'icon-ban-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(279, '417a69ea-774c-49d6-a661-07a392372490', 'icon-arrow-left2', 'icon-arrow-left2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(280, '9e8f9325-ed15-4c53-bb79-a93cd16646dd', 'icon-arrow-right2', 'icon-arrow-right2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(281, '74681900-afde-4d1d-ae73-4c656a431dde', 'icon-arrow-up2', 'icon-arrow-up2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(282, 'c8290c6e-3274-4801-b643-9ecc44e443d5', 'icon-arrow-down2', 'icon-arrow-down2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(283, 'd7961f4c-f5e5-4dd6-bab8-82d0d78472a1', 'icon-share-alt1', 'icon-share-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(284, '2bd136ad-ae5d-42e1-9a75-b508d8ce8394', 'icon-resize-full', 'icon-resize-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(285, '46b9c8ea-e76d-471c-b0da-b93cb45f08c4', 'icon-resize-small', 'icon-resize-small', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(286, 'aaa1adc3-d9df-4132-b174-8da896141de8', 'icon-plus1', 'icon-plus1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(287, '3cdcf5f8-7b75-4abe-a3b3-e68f88f8330f', 'icon-minus1', 'icon-minus1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(288, 'a63c7b3a-a030-49fd-813a-cc49dec55c3b', 'icon-asterisk1', 'icon-asterisk1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(289, '53a55541-16d0-45a2-b415-7445714d6b1b', 'icon-exclamation-sign', 'icon-exclamation-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(290, '0e4f5971-1a31-49be-ac51-3c07ce64cf59', 'icon-gift1', 'icon-gift1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(291, 'da21b6db-914c-448e-b308-3e1a0daaba40', 'icon-leaf1', 'icon-leaf1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(292, '17b58b88-86dd-4929-ae39-2e714b38c91b', 'icon-fire2', 'icon-fire2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(293, '52b7c2a8-0257-461f-b2e6-102add1b5dba', 'icon-eye-open', 'icon-eye-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(294, '05e27c88-9bd6-48c4-9bb2-322d6b7baddf', 'icon-eye-close', 'icon-eye-close', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(295, 'ed7d9afd-a50f-4ec6-8886-fcbd0cec2037', 'icon-warning-sign', 'icon-warning-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(296, 'd7298f3f-f698-42b6-82e8-d3975e3a5ef5', 'icon-plane1', 'icon-plane1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(297, 'a7188a37-27e0-4938-b276-425b08095523', 'icon-calendar3', 'icon-calendar3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(298, 'ed394386-7061-4af1-a2db-c318e37b9dba', 'icon-random1', 'icon-random1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(299, '2d9ee461-f0b3-4c65-9f8a-1296d53f886c', 'icon-comment21', 'icon-comment21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(300, 'a82c303e-cade-4fce-b763-e542bbeb2cc2', 'icon-magnet1', 'icon-magnet1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(301, 'c96e48b3-ab62-4ca4-9d60-da467b0810d2', 'icon-chevron-up1', 'icon-chevron-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(302, 'daa8e7a2-9a69-4eea-a52f-c75d60676fa3', 'icon-chevron-down1', 'icon-chevron-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(303, '50865617-7020-436c-ad0f-653ff64f4b8f', 'icon-retweet1', 'icon-retweet1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(304, '23f9187b-dd78-4ccc-b45c-abc6ef59a1ed', 'icon-shopping-cart', 'icon-shopping-cart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(305, '7b12a70a-f725-4638-87e7-8909c5842c34', 'icon-folder-close', 'icon-folder-close', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(306, '31925f65-bb13-4afe-befd-75fe54c244c2', 'icon-folder-open2', 'icon-folder-open2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(307, '98a2cbd1-5395-4202-b1ff-c57c46b58685', 'icon-resize-vertical', 'icon-resize-vertical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(308, '3b3c6113-5cc6-453d-aca4-07cba7894a02', 'icon-resize-horizontal', 'icon-resize-horizontal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(309, 'bb4c9334-e5a9-4587-9ac9-177c80f49b77', 'icon-bar-chart', 'icon-bar-chart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(310, '555501ea-d8ef-498e-96d3-bf897e0cdc15', 'icon-twitter-sign', 'icon-twitter-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(311, 'd66995a7-ae1b-46ba-8a08-4be220b2ac76', 'icon-facebook-sign', 'icon-facebook-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(312, '612392e9-21c3-4815-8961-1227bc8c7d32', 'icon-camera-retro1', 'icon-camera-retro1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(313, 'a924e121-eb1c-440f-8b30-88b329b712e9', 'icon-key2', 'icon-key2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(314, '8cf9b9f5-12d9-4bf2-8262-d0d73379bbbd', 'icon-cogs1', 'icon-cogs1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(315, '4315de8b-df44-4860-ac9c-7a856cfe8511', 'icon-comments2', 'icon-comments2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(316, '605457dc-abdf-447b-bf2a-a7c2020c361b', 'icon-thumbs-up2', 'icon-thumbs-up2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(317, 'a9cf930b-34b4-470e-977b-c445589fddd7', 'icon-thumbs-down2', 'icon-thumbs-down2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(318, '9b676e63-13c4-4eb0-aab8-3e05eb958e20', 'icon-star-half2', 'icon-star-half2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(319, '33aaa889-c522-4fbe-a533-8fcb25dd5af1', 'icon-heart-empty', 'icon-heart-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(320, '85246a4c-2d78-40b1-b10a-f0453ae2ff02', 'icon-signout', 'icon-signout', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(321, '7fb85a40-398b-4465-bdfe-c2c4bc4aea1c', 'icon-linkedin-sign', 'icon-linkedin-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(322, '9f8d4c75-93e2-4259-8ddc-a7980e20ee3b', 'icon-pushpin', 'icon-pushpin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(323, '3fcddd21-bc14-47c4-8d71-166096558295', 'icon-external-link', 'icon-external-link', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(324, 'bd67d62d-b370-4b5a-8e3d-6fa8eb64cde8', 'icon-signin', 'icon-signin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(325, '59f00b82-109d-4e97-9ee3-36e996568ecf', 'icon-trophy1', 'icon-trophy1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(326, '3085cc47-271d-42af-a424-638eb41f375b', 'icon-github-sign', 'icon-github-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(327, 'a9db6bda-fedd-4937-b85e-4debc5987f66', 'icon-upload-alt', 'icon-upload-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(328, '9cdc2216-ed08-49d4-8f31-e8d00e52858e', 'icon-lemon2', 'icon-lemon2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(329, 'dac061cc-e117-4752-92f7-b41523391477', 'icon-phone3', 'icon-phone3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(330, 'daa093b4-aed4-46d5-805d-f0941989b5d5', 'icon-check-empty', 'icon-check-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(331, 'c54c3f64-fee2-4b68-b814-33a9cbaca300', 'icon-bookmark-empty', 'icon-bookmark-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(332, '4d6b9c08-de80-46bb-a985-cdf2d436e664', 'icon-phone-sign', 'icon-phone-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(333, '5728c639-87c4-4d5a-88e8-f1ad0730ec16', 'icon-twitter2', 'icon-twitter2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(334, '6513a6df-14ca-44c8-afe2-e9e1523e4217', 'icon-facebook2', 'icon-facebook2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(335, 'fa0aa680-890b-47f2-9beb-75f45dd7452a', 'icon-github2', 'icon-github2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(336, '0e37e556-e4ef-4cbb-9f99-386ee739fc02', 'icon-unlock1', 'icon-unlock1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(337, '56980930-c239-4e73-8386-3676ab93a8b4', 'icon-credit', 'icon-credit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(338, 'd899c4eb-986e-42a0-ad93-8e521bd56ad6', 'icon-rss2', 'icon-rss2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(339, '6042d0c1-511c-4047-8684-8a378c10ee5b', 'icon-hdd2', 'icon-hdd2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(340, 'aa2489f1-c8d0-4d5f-a28f-a36cc2e731b8', 'icon-bullhorn2', 'icon-bullhorn2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(341, '743ad9e3-8773-4dfe-b7c3-3a18849da0cb', 'icon-bell2', 'icon-bell2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(342, '60c62b1c-46d4-4591-ab3e-eda694ee97e9', 'icon-certificate1', 'icon-certificate1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(343, 'c872969f-1e3d-4756-b553-0f92c2a80776', 'icon-hand-right', 'icon-hand-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(344, '7a76b8f0-b3cc-4119-a2cf-75591797230e', 'icon-hand-left', 'icon-hand-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(345, '5896a59d-a61d-4ddc-bca4-c719c10c76a2', 'icon-hand-up', 'icon-hand-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(346, 'a81a2620-4f61-4323-b6dd-fef5f20c6652', 'icon-hand-down', 'icon-hand-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(347, '564e3ac1-c136-4c41-9fc2-49c366c2772b', 'icon-circle-arrow-left', 'icon-circle-arrow-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(348, 'f434aa4e-aefb-4054-9842-9ec161c180b0', 'icon-circle-arrow-right', 'icon-circle-arrow-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(349, '7fb3da0f-2ca4-4297-aa55-f6225345e62a', 'icon-circle-arrow-up', 'icon-circle-arrow-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(350, '223bcfec-b42c-4477-910d-b0211f36d18d', 'icon-circle-arrow-down', 'icon-circle-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(351, '20056123-249f-4c0d-bc41-10a1011722ce', 'icon-globe1', 'icon-globe1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(352, '9a2b4faf-103c-4dea-a708-bf758d30c88f', 'icon-wrench1', 'icon-wrench1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(353, '75109300-105c-4fd2-92ab-5beb37da02b7', 'icon-tasks1', 'icon-tasks1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(354, 'ecfc3b3e-71f5-4e1d-a4c0-06d998a00041', 'icon-filter1', 'icon-filter1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(355, '520418bb-6dea-4a37-8b93-c1f4ea9229a5', 'icon-briefcase1', 'icon-briefcase1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(356, 'b37da011-0640-415e-9009-d24dc1854656', 'icon-fullscreen', 'icon-fullscreen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(357, 'e9954eb7-d2bb-436c-b0ca-0c34dc59657f', 'icon-group', 'icon-group', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(358, 'cfde2a1a-4c4f-4308-8b34-070b759753e6', 'icon-link1', 'icon-link1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(359, '0104d886-e157-45d8-a7f0-8e9d0a9afe5d', 'icon-cloud3', 'icon-cloud3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(360, '41247b22-4a8b-4caa-b239-2d6d5edc956e', 'icon-beaker', 'icon-beaker', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(361, '894a8380-1d7c-438d-8e33-5a8758a745e0', 'icon-cut1', 'icon-cut1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(362, '832278a3-6c45-4c22-a716-9f7bb9619c2e', 'icon-copy2', 'icon-copy2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(363, '7c68b911-e68a-4734-b141-4f14d99d5feb', 'icon-paper-clip', 'icon-paper-clip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(364, 'e80b5f1a-c0f4-4853-b549-2bc1bc0f604d', 'icon-save2', 'icon-save2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(365, 'a36d7dae-856b-4cc4-9293-6da2bdb63bd2', 'icon-sign-blank', 'icon-sign-blank', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(366, 'ece61b8a-6313-4120-ad0d-da5acdb0c754', 'icon-reorder', 'icon-reorder', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(367, '297f8d1b-6e1d-4e6e-8bde-9ac36b2d47e9', 'icon-list-ul1', 'icon-list-ul1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(368, '74774ee8-b303-4955-84f3-d0356fe4930d', 'icon-list-ol1', 'icon-list-ol1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(369, '53e0e076-32b3-4f91-b07e-eeeff74254f7', 'icon-strikethrough1', 'icon-strikethrough1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(370, '354fc4ee-194c-4530-b9ad-6e4e8304a064', 'icon-underline1', 'icon-underline1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(371, 'd68cdf68-a0d0-433f-ae37-5a49b52e3ad5', 'icon-table1', 'icon-table1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(372, 'af5588bd-3f1e-489f-84e6-cd7ba431b645', 'icon-magic1', 'icon-magic1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(373, '306a62ae-f06d-4117-b81f-983252601eb7', 'icon-truck2', 'icon-truck2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(374, 'be653bd9-4c21-4758-bd16-7c1477875f3a', 'icon-pinterest2', 'icon-pinterest2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(375, '425cdb6a-3103-4c57-88fc-77b984a8315a', 'icon-pinterest-sign', 'icon-pinterest-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(376, '37407b4b-e80f-44ae-b89b-e699b8d5b068', 'icon-google-plus-sign', 'icon-google-plus-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(377, 'a8466864-a7d6-48c7-ab47-28d5bdb6170b', 'icon-google-plus1', 'icon-google-plus1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(378, '5972767b-73a1-4aa6-a147-3c280814ab80', 'icon-money', 'icon-money', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(379, '34357fa5-f1e9-45ed-8238-453466854a36', 'icon-caret-down1', 'icon-caret-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(380, 'ed5e024e-5025-4a9e-9a61-cef98157df1c', 'icon-caret-up1', 'icon-caret-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(381, 'c1794fea-d7ae-4b92-aad8-83e6f8a4412a', 'icon-caret-left1', 'icon-caret-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(382, '699b7b4e-7a0f-4f98-a855-1dfeccc2cfbd', 'icon-caret-right1', 'icon-caret-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(383, '1c82c6ad-77b0-440a-aa70-834328bbba71', 'icon-columns1', 'icon-columns1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(384, '94b213c2-b041-40da-8c11-35005a671c3d', 'icon-sort1', 'icon-sort1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(385, '5055beed-47c9-45e2-8db7-cccb5e932f1f', 'icon-sort-down1', 'icon-sort-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(386, '5237211a-6dbe-4348-94fe-96a862f523fc', 'icon-sort-up1', 'icon-sort-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(387, '39b05ac9-922d-4e84-8c13-5ed434b10cc0', 'icon-envelope-alt', 'icon-envelope-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(388, '9d5bc61d-c919-4a46-a75c-317a81f5b334', 'icon-linkedin2', 'icon-linkedin2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(389, '9e725eb9-d6d7-4a6b-9b85-90bc01f0c067', 'icon-undo1', 'icon-undo1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(390, '8f52e4a6-904d-42ba-b12e-e923a279f81c', 'icon-legal', 'icon-legal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(391, 'e7e0e8f0-70e7-4a1c-9d0e-1e02a33f9725', 'icon-dashboard', 'icon-dashboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(392, 'b0fe7d62-8bf1-4f57-a3b3-d5c8378083c4', 'icon-comment-alt2', 'icon-comment-alt2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(393, 'd0624905-d199-4e2c-a681-f9e18a4da0e4', 'icon-comments-alt', 'icon-comments-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(394, 'beb5e8de-9da2-4030-ae2d-1b5eae804179', 'icon-bolt2', 'icon-bolt2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(395, '42f70bb7-513a-4527-b116-0cfe48f73c91', 'icon-sitemap1', 'icon-sitemap1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(396, '7f95815f-100f-4e9e-905f-f09de6254443', 'icon-umbrella1', 'icon-umbrella1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(397, 'a8aad44f-0379-45a1-8f1f-016c1ecddf02', 'icon-paste1', 'icon-paste1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(398, 'c25b7258-571e-4d9c-a49b-138ced49d88c', 'icon-lightbulb2', 'icon-lightbulb2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(399, 'd4610358-694e-4b22-a795-12a8b070eda0', 'icon-exchange', 'icon-exchange', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(400, '726f824a-d424-4df0-bfdf-8f5164383b6b', 'icon-cloud-download', 'icon-cloud-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(401, '6ca801c5-1d4a-433c-ad66-4ad2ea6674d4', 'icon-cloud-upload', 'icon-cloud-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(402, '300f0dee-084a-41fd-804e-b11a373ff4f9', 'icon-user-md1', 'icon-user-md1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(403, '218e500f-880b-4bae-baa9-56e1c48b3a55', 'icon-stethoscope1', 'icon-stethoscope1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(404, '0fca9448-2999-49d8-a244-89d76c5dbee8', 'icon-suitcase1', 'icon-suitcase1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(405, 'afeed264-0bcd-4203-a47d-afa737bf8d19', 'icon-bell-alt', 'icon-bell-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(406, '98d75713-7efd-4f22-8c0a-a36135362a0d', 'icon-coffee2', 'icon-coffee2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(407, '89336b11-50da-4d5f-97a4-e143e4a02d3e', 'icon-food2', 'icon-food2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(408, '5fb1dd3e-f182-4f10-97b2-d6d142727d8a', 'icon-file-alt2', 'icon-file-alt2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(409, '4b042e82-71bc-46c8-a203-8ad67e040d15', 'icon-building2', 'icon-building2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(410, 'bb9fd8cd-8d9d-498c-8fbb-0032601625a1', 'icon-hospital2', 'icon-hospital2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(411, '24283058-f077-4571-8284-ea7c43634275', 'icon-ambulance1', 'icon-ambulance1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(412, 'b6445448-112f-49c5-8aa9-6497d48e5765', 'icon-medkit1', 'icon-medkit1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(413, '9e617073-e934-47b1-97ae-dc7da9e370b5', 'icon-fighter-jet1', 'icon-fighter-jet1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(414, '24895616-e1e5-4c66-a6c5-d6cc7276ab2f', 'icon-beer1', 'icon-beer1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(415, '8ce49327-2e9e-4945-8aa9-084c1ad5f70e', 'icon-h-sign', 'icon-h-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(416, '8a2bdfcb-7dc9-4414-b7c4-609343a5f792', 'icon-plus-sign2', 'icon-plus-sign2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(417, '613c6d25-6c55-4fb3-b511-e2e7d3a04d1d', 'icon-double-angle-left', 'icon-double-angle-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(418, '615d9ed1-51c5-4320-8aa0-a8d9a2729a99', 'icon-double-angle-right', 'icon-double-angle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(419, 'b8207cf0-5137-4e4c-8bfd-352a759d50a7', 'icon-double-angle-up', 'icon-double-angle-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(420, '4bac3753-9e6f-48b2-b5e7-214ceee78c40', 'icon-double-angle-down', 'icon-double-angle-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(421, '73583d4f-2fce-496b-85be-aa997cecfd4f', 'icon-angle-left', 'icon-angle-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(422, '6ffca46a-b40c-4b73-b3db-267e3b9fa4f7', 'icon-angle-right', 'icon-angle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(423, '4cbd87f0-c13c-47a3-add4-2e7bbfb82a3f', 'icon-angle-up', 'icon-angle-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(424, '447df2ea-a634-484d-9f40-9f1f9e65d429', 'icon-angle-down', 'icon-angle-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(425, '170752f2-1290-458d-9c2e-8b022befe83e', 'icon-desktop1', 'icon-desktop1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(426, '755a6d34-43a5-43d7-98f3-a3683361ab44', 'icon-laptop2', 'icon-laptop2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(427, '1cf5cbec-0ec8-4cfa-9307-f3c01954f56c', 'icon-tablet2', 'icon-tablet2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(428, '76786e58-8b31-402c-9c60-59c4a698aa25', 'icon-mobile1', 'icon-mobile1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(429, '0a2093d3-f334-4bb3-ab5f-9729df912f47', 'icon-circle-blank', 'icon-circle-blank', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(430, '75984944-6a71-470b-9e66-49073ece2893', 'icon-quote-left1', 'icon-quote-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(431, '714d55f6-da5d-4c84-ac38-c8956e8fa5d0', 'icon-quote-right1', 'icon-quote-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(432, '0335c116-a3e7-4efd-bd01-449de176e22d', 'icon-spinner1', 'icon-spinner1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(433, '67385e66-9a50-46f0-b8a4-32aa55f2a1ba', 'icon-circle2', 'icon-circle2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(434, '7680c662-a406-4a53-871a-c23224a3c913', 'icon-reply1', 'icon-reply1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(435, 'f4ff5e51-0c0f-4347-9ced-8a102b7509f0', 'icon-github-alt1', 'icon-github-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(436, '04fc06d7-d559-4b3f-85b9-2d7be30a47da', 'icon-folder-close-alt', 'icon-folder-close-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(437, '2128d20b-4d38-46bc-afaf-7bc04620c34f', 'icon-folder-open-alt', 'icon-folder-open-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(438, '0f5e5e64-0799-4465-afcb-f123730555e4', 'icon-expand-alt', 'icon-expand-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(439, '1e05c74f-64d2-4f9b-a0ab-1ebfd69874f0', 'icon-collapse-alt', 'icon-collapse-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(440, '98004394-effd-46d3-ada4-5d9778fb961d', 'icon-smile2', 'icon-smile2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(441, 'a9f962bf-29c8-4ae1-8a67-4e170f06d7c2', 'icon-frown2', 'icon-frown2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(442, 'e1033d12-cef0-4241-81cc-7e9b040f1784', 'icon-meh2', 'icon-meh2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(443, '1e2f57f7-7d94-4ecb-a50e-db26106a221c', 'icon-gamepad1', 'icon-gamepad1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(444, '4ad4b41f-5a54-41ac-9772-13203849201a', 'icon-keyboard2', 'icon-keyboard2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(445, '93079ade-dee6-4f06-a773-c0e69d33a858', 'icon-flag-alt', 'icon-flag-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(446, 'f985b25c-ce49-477c-90bc-5767b10a006f', 'icon-flag-checkered1', 'icon-flag-checkered1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(447, 'ebfba4b7-aa1b-466b-aa7f-44c119ee1f1b', 'icon-terminal1', 'icon-terminal1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(448, 'b0f6ed4c-fd41-44e8-8c07-4af920573dc9', 'icon-code1', 'icon-code1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(449, '06bac981-72c2-423e-98e9-725b65e0c9a1', 'icon-reply-all1', 'icon-reply-all1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(450, '3b811678-33a4-4cf8-8484-5d98cb1b1d9a', 'icon-star-half-full', 'icon-star-half-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(451, 'd56a297e-2d6d-453c-a08a-f8fa585918b4', 'icon-location-arrow1', 'icon-location-arrow1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(452, '60aaa3fa-fc8f-4f58-8da0-2574fbfcec89', 'icon-crop2', 'icon-crop2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(453, '70f78865-7ae1-430a-900e-1cd89015f804', 'icon-code-fork', 'icon-code-fork', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(454, 'cfc1c1c7-8d6a-4f5a-8153-38897fc46678', 'icon-unlink1', 'icon-unlink1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(455, 'c109fa6c-558e-44d3-9169-7214abc0a7a2', 'icon-question1', 'icon-question1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(456, '7a9e3133-a459-4bf9-b6a3-5a09f4a53832', 'icon-info1', 'icon-info1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(457, '75cba935-70ff-4b24-aa73-8885ee29ff49', 'icon-exclamation1', 'icon-exclamation1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(458, 'ba005815-7995-4698-9892-c774e1df6555', 'icon-superscript1', 'icon-superscript1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(459, 'eca9b597-a421-4a0d-ae54-90856feac130', 'icon-subscript1', 'icon-subscript1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(460, '0f1baa28-3ed8-4f45-a3a3-fbfcbeb61531', 'icon-eraser1', 'icon-eraser1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(461, 'ad01868e-28c2-4256-8c76-70a06d82ca61', 'icon-puzzle', 'icon-puzzle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(462, '52431d69-9850-4de0-ab56-985a782388f0', 'icon-microphone2', 'icon-microphone2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(463, '7db8c2c0-11e3-4261-b42f-bda9b33a6c04', 'icon-microphone-off2', 'icon-microphone-off2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(464, 'e3d226e2-eec2-41c9-b878-e808da058f48', 'icon-shield', 'icon-shield', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(465, 'cebff221-2266-4fc3-a751-22724822aa8b', 'icon-calendar-empty', 'icon-calendar-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(466, '45ab0fa6-902e-4907-8a23-3029b513a826', 'icon-fire-extinguisher1', 'icon-fire-extinguisher1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(467, '2a5e9017-5080-4816-8e83-19cfefef120f', 'icon-rocket1', 'icon-rocket1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(468, '81264146-ec4d-47af-b35e-a8d6f084cd78', 'icon-maxcdn1', 'icon-maxcdn1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(469, '33ff09dd-2c30-4f24-8e5e-a88b4013df30', 'icon-chevron-sign-left', 'icon-chevron-sign-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(470, '1a7a5029-8581-4ccc-b540-32665a0ea15f', 'icon-chevron-sign-right', 'icon-chevron-sign-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(471, 'e8eb34f9-999f-4789-9223-4216a2eb05d2', 'icon-chevron-sign-up', 'icon-chevron-sign-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(472, 'ba428722-6b54-44c4-83ff-feef3f860c46', 'icon-chevron-sign-down', 'icon-chevron-sign-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(473, '76f445c5-1cdb-4152-abd2-b443d00b6ff5', 'icon-html52', 'icon-html52', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(474, 'a8b7b8fb-4791-4e53-bfbd-66c534742ad7', 'icon-css31', 'icon-css31', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(475, '33da5b8d-00c4-487f-aeb1-f873d0ea6e49', 'icon-anchor1', 'icon-anchor1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(476, '4a16d63f-7ef7-4188-bafd-b1280ff2c6b6', 'icon-unlock-alt1', 'icon-unlock-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(477, '2c8ea93a-5a3e-47ca-8ef3-d17cfc92e51b', 'icon-bullseye1', 'icon-bullseye1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(478, '2d7ac68d-ecea-4f3a-b2e5-03a516e2485d', 'icon-ellipsis-horizontal', 'icon-ellipsis-horizontal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(479, '2c32792c-ba27-4f1f-89b3-630bb10afdef', 'icon-ellipsis-vertical', 'icon-ellipsis-vertical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(480, '9ab3924e-3918-46a4-ae5c-f44ec8737921', 'icon-rss-sign', 'icon-rss-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(481, '4521c451-536d-4882-9111-cb7358c9de7c', 'icon-play-sign', 'icon-play-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(482, '92c042c2-e320-4f82-8ce0-5c759d1563cd', 'icon-ticket', 'icon-ticket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(483, '277bf330-2a02-4b2f-a1cf-b2701ac7c285', 'icon-minus-sign-alt', 'icon-minus-sign-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(484, '59935545-35a4-4687-beaf-aee00549d87f', 'icon-check-minus', 'icon-check-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(485, '84f7640c-56ce-4e8a-bf01-6b5ede1fc97e', 'icon-level-up', 'icon-level-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(486, '37034349-2001-407e-8dca-4f96c2ee70d9', 'icon-level-down', 'icon-level-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(487, '5d12c420-3b28-40e4-948d-04008f5f71e9', 'icon-check-sign', 'icon-check-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(488, '4d87316f-4b88-485b-adc3-c94a682b8ccd', 'icon-edit-sign', 'icon-edit-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(489, 'cceb8671-f81d-47e9-805f-e0adee6ba316', 'icon-external-link-sign', 'icon-external-link-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(490, 'ebc20eb8-5d73-4777-8a55-5336c3d7d2d0', 'icon-share-sign', 'icon-share-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(491, '57c62917-fc02-45fd-b945-7ab55452bcfd', 'icon-compass2', 'icon-compass2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(492, '2965b370-4715-49d3-8ef4-3e11dadbff0a', 'icon-collapse', 'icon-collapse', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(493, '1e6ea596-3439-425c-b012-90739bf0b164', 'icon-collapse-top', 'icon-collapse-top', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(494, '16438183-b92d-4959-a26f-1e9b67d6ea3c', 'icon-expand1', 'icon-expand1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(495, '20067a18-2f8a-48a6-bb02-9510350425b7', 'icon-euro', 'icon-euro', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(496, 'a4169e14-f523-48d2-9310-4617ec2956e2', 'icon-gbp', 'icon-gbp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(497, 'bc5ae3e6-f55c-4cc2-9acd-dff55a74e517', 'icon-dollar', 'icon-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(498, '2402aefa-7bd0-452f-a1e3-4250ac1dd998', 'icon-rupee', 'icon-rupee', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(499, '5f2f3f30-00c4-4f55-b0de-3a14537a5e71', 'icon-yen', 'icon-yen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(500, '778a617d-305c-4162-a35c-7a25917728f6', 'icon-renminbi', 'icon-renminbi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(501, 'cebed8c9-4e06-4260-8744-59c0de5849d1', 'icon-won', 'icon-won', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(502, '59971b35-d9fc-4971-9a2e-90b359461671', 'icon-bitcoin2', 'icon-bitcoin2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(503, '5bc3e8d7-c9b9-42d1-9dea-6e40c7695dda', 'icon-file3', 'icon-file3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(504, '35bb8e50-0c17-41c5-802c-5d0f90109013', 'icon-file-text', 'icon-file-text', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(505, '822bd920-0168-4e68-ae88-ac423534d321', 'icon-sort-by-alphabet', 'icon-sort-by-alphabet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(506, '1814ee9c-eb36-4027-9e62-cd4a49a758c4', 'icon-sort-by-alphabet-alt', 'icon-sort-by-alphabet-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(507, '8112f507-ae6f-48db-842d-f84804f43970', 'icon-sort-by-attributes', 'icon-sort-by-attributes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(508, 'a2836023-22a7-4732-8587-935d86171a12', 'icon-sort-by-attributes-alt', 'icon-sort-by-attributes-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(509, 'b25ba883-9101-4ab4-b6a5-741bb21f6ef5', 'icon-sort-by-order', 'icon-sort-by-order', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(510, '51745963-6652-44c3-a2ef-c9ce1cb6eebd', 'icon-sort-by-order-alt', 'icon-sort-by-order-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(511, '0d2f4409-167a-453b-b18d-a0c3ab9747c4', 'icon-thumbs-up21', 'icon-thumbs-up21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(512, 'a2c19923-8e0c-4919-8a63-360241b4e5c5', 'icon-thumbs-down21', 'icon-thumbs-down21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(513, 'a00a69f7-f73b-49d1-a440-e2bdd79bfcbb', 'icon-youtube-sign', 'icon-youtube-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(514, '1a6f690b-ff1f-4c6e-8e08-9b02b5e6817a', 'icon-youtube2', 'icon-youtube2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(515, 'f87e2658-82fe-4417-b5ba-a2d7c91022fe', 'icon-xing2', 'icon-xing2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(516, 'fe43ca2b-0ce9-441a-8a44-07869aad40b7', 'icon-xing-sign', 'icon-xing-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(517, 'c4ab6b45-d1e0-417e-9407-a0e03eb46c0e', 'icon-youtube-play', 'icon-youtube-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(518, '384d9f43-4c3f-405e-9114-5e478e177cde', 'icon-dropbox2', 'icon-dropbox2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(519, '18335572-6849-4d66-86e8-039bfbca6e77', 'icon-stackexchange', 'icon-stackexchange', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(520, '1fb6b3d7-2318-487d-9a26-33d3560877f6', 'icon-instagram2', 'icon-instagram2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(521, '6ef9c525-753b-4dee-b824-e2b4bcd68bad', 'icon-flickr2', 'icon-flickr2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(522, 'd0d24044-2e07-439f-81ef-ea11cc85b166', 'icon-adn1', 'icon-adn1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(523, '00d11c73-f264-4a90-9b39-cb8bcd581843', 'icon-bitbucket2', 'icon-bitbucket2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(524, '54a12033-9856-4fd2-aef2-f777e96eea0b', 'icon-bitbucket-sign', 'icon-bitbucket-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(525, '65fc0525-ac13-45b8-807f-c1abd774f814', 'icon-tumblr2', 'icon-tumblr2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(526, '65fef4ba-2f80-4e52-ac92-5dfcedb7e06c', 'icon-tumblr-sign', 'icon-tumblr-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(527, 'a29d1382-8c86-4798-a4e2-ab7eda7802fa', 'icon-long-arrow-down', 'icon-long-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(528, 'f31e276d-afc2-4925-88d6-9b2456c196e3', 'icon-long-arrow-up', 'icon-long-arrow-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(529, '13fc1015-3218-45b5-8a87-c2c45a6273fc', 'icon-long-arrow-left', 'icon-long-arrow-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(530, 'c2eb31eb-c22d-49ce-b766-3bc8db49592d', 'icon-long-arrow-right', 'icon-long-arrow-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(531, 'e0d671e1-b96e-41a1-9c6e-80d27027df92', 'icon-apple1', 'icon-apple1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(532, '59f175d4-8800-4d73-a58c-c905527b4b02', 'icon-windows3', 'icon-windows3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(533, '4c52fa60-cc15-42d2-aa04-2f7c8593d913', 'icon-android2', 'icon-android2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(534, '45c39c70-6b80-4a76-a6cb-20572e263732', 'icon-linux1', 'icon-linux1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(535, 'eb8547c1-b1b9-46df-ad6c-4c1288b58f8b', 'icon-dribbble2', 'icon-dribbble2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(536, 'ee865005-4cfe-4470-b120-7031848d5e49', 'icon-skype2', 'icon-skype2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(537, 'e84bf29a-145c-4ef9-87d9-8c63a99f5f2a', 'icon-foursquare2', 'icon-foursquare2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(538, 'cdf61c6f-0ee9-4093-91b7-75c68988abdb', 'icon-trello1', 'icon-trello1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(539, '732287bb-d185-449e-8bc5-fc9e19dfef3a', 'icon-female1', 'icon-female1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(540, 'f13dac30-5431-49f4-b9f5-a35b628c1181', 'icon-male1', 'icon-male1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(541, '0516694b-37a1-4c08-8e91-327c38b6aaeb', 'icon-gittip', 'icon-gittip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(542, 'c83c5ea3-e91d-4872-b408-c9dcbacd4959', 'icon-sun21', 'icon-sun21', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(543, '9952566e-8557-4698-b15a-40c4de623d59', 'icon-moon2', 'icon-moon2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(544, '1ec6d15a-8dd5-4c5a-8ff4-bf14fdd84ef4', 'icon-archive2', 'icon-archive2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(545, 'dde645dc-9117-4e0f-8abf-54f511e693f9', 'icon-bug1', 'icon-bug1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(546, '1836b371-514c-4285-b218-4d16368a8cbb', 'icon-renren1', 'icon-renren1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(547, 'b4983507-1877-4417-9ffd-400fe6369faf', 'icon-weibo2', 'icon-weibo2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(548, '7976d6dc-7d86-49f3-853a-0782e3488eec', 'icon-vk2', 'icon-vk2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(549, 'f068ab10-7d63-477c-a400-dac129c6cfb6', 'icon-duckduckgo', 'icon-duckduckgo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(550, '97a3c8c9-6250-4087-967c-5c76e955344c', 'icon-aim', 'icon-aim', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(551, 'ccfeca86-eda8-4b54-861a-faf896fc862b', 'icon-delicious1', 'icon-delicious1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(552, 'c4df18f1-0fd8-4989-8f6a-4649e569b2a5', 'icon-paypal1', 'icon-paypal1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(553, '44a813be-a8eb-4f4f-966b-9296b604655b', 'icon-flattr', 'icon-flattr', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(554, '39af0d1d-7287-4a6c-8ded-457b6102dbc8', 'icon-android1', 'icon-android1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(555, '2aa59e8d-e667-48ad-b7ea-22687e5f7d87', 'icon-eventful', 'icon-eventful', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(556, 'e7c87e43-9366-450c-bbb8-b6dcb7754d75', 'icon-smashmag', 'icon-smashmag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(557, '24d0a71f-6f12-4d7c-a775-30666f84e49c', 'icon-gplus', 'icon-gplus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(558, '84ad0201-7bce-42d5-8c6e-811a946d2f15', 'icon-wikipedia', 'icon-wikipedia', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(559, 'd0284527-2e6b-4c13-9f22-87c5362e95ec', 'icon-lanyrd', 'icon-lanyrd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(560, '04dd5f6d-69f2-4aac-80c9-f9c652aa1f02', 'icon-calendar-1', 'icon-calendar-1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(561, 'cadecd9c-4c54-495b-b79f-edf4fa04e96b', 'icon-stumbleupon1', 'icon-stumbleupon1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(562, '24653b27-ee6e-4eef-991e-def536350b69', 'icon-fivehundredpx', 'icon-fivehundredpx', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(563, 'eb759079-87f3-45aa-b51d-98922885011b', 'icon-pinterest1', 'icon-pinterest1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(564, '80625f09-c7f2-4c3a-8a91-c7ca0b94f251', 'icon-bitcoin1', 'icon-bitcoin1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(565, '78230c9f-da4b-4997-84fc-804b4128490c', 'icon-w3c', 'icon-w3c', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(566, '6fe22f49-fbe3-4b0f-83ff-7a6d911e2c39', 'icon-foursquare1', 'icon-foursquare1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(567, 'b9f4af9f-4dfb-4a44-a4a7-e061a6a18776', 'icon-html51', 'icon-html51', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(568, '5df74c54-b4d1-460e-b06a-d4382c391c9a', 'icon-ie', 'icon-ie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(569, 'e1b6028e-0b63-4da2-b7c6-136096747c4e', 'icon-call', 'icon-call', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(570, '83c1cff2-a647-4275-8cf6-03730f5aaa1d', 'icon-grooveshark', 'icon-grooveshark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(571, 'f114a9aa-9052-4fb7-ba95-59da8eae9214', 'icon-ninetyninedesigns', 'icon-ninetyninedesigns', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(572, 'c7913ffa-93b7-41c2-baef-1eee7a222142', 'icon-forrst', 'icon-forrst', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(573, '009e483e-3e1c-436f-be0c-e26f4c6b9ada', 'icon-digg1', 'icon-digg1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(574, '6191032b-e559-46b3-92ed-17f560b98afe', 'icon-spotify1', 'icon-spotify1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(575, '3ec31ede-89da-4912-b961-a0ade42d7850', 'icon-reddit1', 'icon-reddit1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(576, 'ffcb6a37-1dac-4f8a-a000-e86f3d41a87e', 'icon-guest', 'icon-guest', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(577, '5cd0f101-a98b-4317-86f4-b0e6d0324290', 'icon-gowalla', 'icon-gowalla', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(578, '763f79b8-797c-462e-b0c1-7bd63e78b74b', 'icon-appstore', 'icon-appstore', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(579, 'd7162d42-f03b-43fd-962d-3c30792054d3', 'icon-blogger1', 'icon-blogger1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(580, '86e6b192-d234-4d01-b9e4-2787057b2848', 'icon-cc', 'icon-cc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(581, '4a7231e7-d334-4d75-8982-4f5c25d74695', 'icon-dribbble1', 'icon-dribbble1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(582, '99024e4f-1961-40ca-8fcd-b36f46347b68', 'icon-evernote', 'icon-evernote', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(583, '54b0defc-462f-4ddf-a9c9-57d91a3573bc', 'icon-flickr1', 'icon-flickr1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(584, '335c06c1-3ac1-4b60-b8fd-f25cb7abb482', 'icon-google1', 'icon-google1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(585, 'cc652900-cc60-448b-8a0d-020e2d23cf26', 'icon-viadeo1', 'icon-viadeo1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(586, '9adfa48c-798e-4854-8170-54ffcf4aac29', 'icon-instapaper', 'icon-instapaper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(587, 'abb2d0e0-ad65-413b-b590-3aea2426607a', 'icon-weibo1', 'icon-weibo1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(588, 'd97ef926-7582-4050-818e-e762ccba6ef5', 'icon-klout', 'icon-klout', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(589, '16221e54-40ca-4167-9fb1-21d7584bc2ab', 'icon-linkedin1', 'icon-linkedin1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(590, 'ffd81870-bf37-4c00-92b4-bfa3867d522b', 'icon-meetup1', 'icon-meetup1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(591, 'a3d71e3c-7237-40b9-b2f9-525ef3ecef6a', 'icon-vk1', 'icon-vk1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(592, 'bac7f1ee-abb8-452c-882e-39ac69035565', 'icon-plancast', 'icon-plancast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(593, '4f9ce21d-0670-4703-be7b-dcc749d46bae', 'icon-disqus', 'icon-disqus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(594, '73c3b29a-ef2f-4ecd-abe9-c59c789040c5', 'icon-rss1', 'icon-rss1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(595, 'b50e4875-8f43-4c6a-a4f0-a82c349bdef1', 'icon-skype1', 'icon-skype1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(596, '88819b9a-9bb1-4922-a684-e24860492256', 'icon-twitter1', 'icon-twitter1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(597, 'a5e57205-c48b-4e67-a2d0-4fde4465697c', 'icon-youtube1', 'icon-youtube1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(598, 'd7656009-03a9-4678-9d64-4c547432fa59', 'icon-vimeo1', 'icon-vimeo1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(599, '77b48cb5-15a2-4fb4-8e0f-6e7e8adb7dc3', 'icon-windows2', 'icon-windows2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(600, '7ad4725b-69b3-48c6-a77e-7737b042db80', 'icon-xing1', 'icon-xing1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(601, '9e3d25d5-0f7f-474c-8835-805d9ccbacc5', 'icon-yahoo1', 'icon-yahoo1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(602, 'dceb024c-8101-4cf6-bb62-e2d1cedef371', 'icon-chrome1', 'icon-chrome1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(603, '262fefb4-d199-4504-b39c-f619adabc4d8', 'icon-email3', 'icon-email3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(604, 'fde3d487-97a2-43fc-94c0-709d19057b1a', 'icon-macstore', 'icon-macstore', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(605, 'ae8300f2-2b33-4cb5-883e-2321eddffef8', 'icon-myspace', 'icon-myspace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(606, '06942c3c-867e-4a7c-810a-8d7c64156273', 'icon-podcast1', 'icon-podcast1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(607, '702b4e9a-28a2-4c4b-ab66-b182cce635b3', 'icon-amazon1', 'icon-amazon1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(608, '764bb85f-870d-4daf-bbb1-2a6647aa3353', 'icon-steam1', 'icon-steam1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(609, 'a5916f0e-2bbb-40ca-96e6-62982a73fa27', 'icon-cloudapp', 'icon-cloudapp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(610, '64f6bc6e-4ccd-472b-997d-fb76b6018521', 'icon-dropbox1', 'icon-dropbox1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(611, 'd0c8cda2-bfc8-49c1-8dd4-dcd75a828d98', 'icon-ebay1', 'icon-ebay1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(612, 'f9793b3c-9167-4c8b-ba67-d56a653e769d', 'icon-facebook', 'icon-facebook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(613, 'ab9d9f4d-4f74-4a63-a485-cb37af199fbb', 'icon-github1', 'icon-github1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(614, '4892a281-edd5-4b6a-a2cf-27b8b2a7bee0', 'icon-github-circled', 'icon-github-circled', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(615, '6c50c824-54c1-44aa-80b1-216384ec3fc5', 'icon-googleplay', 'icon-googleplay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(616, '22af1fb3-491e-4f22-ad84-277186f4ef3f', 'icon-itunes1', 'icon-itunes1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(617, '6c4f8d00-1bcb-46f2-af54-f2271c8a80eb', 'icon-plurk', 'icon-plurk', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(618, '8d3128fc-a036-4a75-aed9-24243f86aef6', 'icon-songkick', 'icon-songkick', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(619, '8bc7c9f0-5e62-40c7-9e8d-6a5dbaac821c', 'icon-lastfm1', 'icon-lastfm1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(620, '0c93bb0d-ebdd-4846-bf24-c9bd58de4dad', 'icon-gmail', 'icon-gmail', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(621, '0517dc15-1c36-4dfe-8b62-6198f7ac3edc', 'icon-pinboard', 'icon-pinboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(622, 'de89a1e3-cf57-469c-9f94-65e8059123d1', 'icon-openid1', 'icon-openid1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(623, 'ff204556-1c24-4362-b3bd-5bfeb55e7dc1', 'icon-quora1', 'icon-quora1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(624, '8e43de3e-6b79-402f-ad8d-9dd725d47b3f', 'icon-soundcloud1', 'icon-soundcloud1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(625, 'd804d80c-840e-4229-9cf3-3e89e727f0db', 'icon-tumblr1', 'icon-tumblr1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(626, '525235f5-6295-4f09-9c4e-a8dd2c0027cb', 'icon-eventasaurus', 'icon-eventasaurus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(627, '0d5f079e-4cc4-4fca-a70b-53efe0e8c039', 'icon-wordpress1', 'icon-wordpress1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(628, '0322eaae-6b86-455c-b390-c763e19479c7', 'icon-yelp1', 'icon-yelp1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(629, '7997322e-7d26-441b-9d2d-90a46bafb1d3', 'icon-intensedebate', 'icon-intensedebate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(630, '6093b310-1299-498a-86a5-4656794ba61f', 'icon-eventbrite', 'icon-eventbrite', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(631, 'ab1778b8-6f8a-4770-894a-5d2eca6578ba', 'icon-scribd1', 'icon-scribd1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(632, 'ad4fefd6-adfe-4ab2-bf16-f078bb860223', 'icon-posterous', 'icon-posterous', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(633, '6ebfd4ff-3c95-4996-8bb9-a3126b0ace2d', 'icon-stripe1', 'icon-stripe1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(634, '7dd754ef-33bd-456c-8f55-93c460b4a6e2', 'icon-opentable', 'icon-opentable', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(635, '5eb6f17f-67f1-4982-818f-d63de0b49735', 'icon-cart', 'icon-cart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(636, '59f7eb77-22d2-404a-96eb-d3603901bbad', 'icon-print1', 'icon-print1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(637, 'fdeb689f-f19f-4362-a89c-968a0ded6770', 'icon-angellist1', 'icon-angellist1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(638, '4e4753d5-2d1d-40c7-82df-64aa07071b64', 'icon-instagram1', 'icon-instagram1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(639, 'e5a787e1-2c9a-431e-b81f-93a250fd3a26', 'icon-dwolla', 'icon-dwolla', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(640, '12c722d0-a7f9-45fb-86a7-0dfdc538bffa', 'icon-appnet', 'icon-appnet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(641, '1b88bd61-b52a-4649-8e7f-f638e48f7eac', 'icon-statusnet', 'icon-statusnet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(642, '87e5dd98-c86c-4cbf-b37d-c840813e93a9', 'icon-acrobat', 'icon-acrobat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(643, '1c9985be-4f7c-4211-9ea6-7d00184aec98', 'icon-drupal1', 'icon-drupal1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(644, 'a32684be-7516-42e7-87cd-806f68ea3720', 'icon-buffer', 'icon-buffer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(645, 'cb8104aa-304c-42fb-8957-084254a2604e', 'icon-pocket', 'icon-pocket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(646, 'c48fd27b-0a5f-452f-82fc-2d14902ce2f3', 'icon-bitbucket1', 'icon-bitbucket1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(647, '6e4bbe5d-11ee-47cc-b420-91882759d568', 'icon-lego', 'icon-lego', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(648, '110a1e99-ebff-4484-9815-0f0ca157e21a', 'icon-login', 'icon-login', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(649, 'a652436b-ea02-401e-854d-554568638606', 'icon-stackoverflow', 'icon-stackoverflow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(650, '23470093-6af8-4f44-91d7-04a5e29115db', 'icon-hackernews', 'icon-hackernews', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(651, '5cb4b844-b4e0-4b79-bf76-47937e330853', 'icon-lkdto', 'icon-lkdto', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(652, '81d549ad-7508-4b40-aa69-9026231ae146', 'icon-ad', 'icon-ad', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(653, 'e0ee13ea-be28-4cda-b708-9819b643a93f', 'icon-address-book', 'icon-address-book', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(654, '1cf5cebf-61fe-4285-8294-8d02497fc5af', 'icon-address-card', 'icon-address-card', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(655, 'fde77972-4bc0-4982-bf15-2d896f1e9997', 'icon-adjust', 'icon-adjust', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(656, 'b17bfdc3-7684-49a4-8ba9-f3103ca5a52a', 'icon-air-freshener', 'icon-air-freshener', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(657, '056503a1-e8bb-49ce-a4b5-c8d1c80582d7', 'icon-align-center', 'icon-align-center', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(658, '0b5a926b-18cb-4e60-a434-f28b91a51c5f', 'icon-align-justify', 'icon-align-justify', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(659, '7c24ba81-9501-41b8-9b2f-8b44a6e67466', 'icon-align-left', 'icon-align-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(660, 'fd3c7ee1-822d-4d21-8002-f910e66f3e16', 'icon-align-right', 'icon-align-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(661, 'fdf4a0d6-01fd-4ab6-a0b7-e4bc2cb1b965', 'icon-allergies', 'icon-allergies', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(662, '241952b8-44d3-48b9-a72d-37e75394f31a', 'icon-ambulance', 'icon-ambulance', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(663, 'c7ea0240-ae3f-462c-96b1-975e0f27051d', 'icon-american-sign-language-interpreting', 'icon-american-sign-language-interpreting', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(664, 'eef694e8-6eef-49d1-b484-24b7b73b14d1', 'icon-anchor', 'icon-anchor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(665, 'f4da165c-83c9-4c12-aada-8aef00890658', 'icon-angle-double-down', 'icon-angle-double-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(666, '6947cd21-f6c5-42d6-b003-985d597991ee', 'icon-angle-double-left', 'icon-angle-double-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(667, '073b9a91-09e7-4caa-8901-53b6bd225866', 'icon-angle-double-right', 'icon-angle-double-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(668, '9038f507-306a-4a23-afcb-2e5ccf7e3e7b', 'icon-angle-double-up', 'icon-angle-double-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(669, '02c2a631-b34d-4581-81c5-ad3f1ec337e1', 'icon-angle-down1', 'icon-angle-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(670, 'c52f0c30-62df-4af8-b4de-6bd32c67efbb', 'icon-angle-left1', 'icon-angle-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(671, '4baa2cf7-29e1-4ddf-aaa8-48bc0671c99a', 'icon-angle-right1', 'icon-angle-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(672, '152f8266-626a-4e15-920c-caa54fcd4d28', 'icon-angle-up1', 'icon-angle-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(673, '6ad9cd57-0d7c-4323-80bd-92b8866d9d96', 'icon-angry', 'icon-angry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(674, '8129cf01-8a14-4dde-88d6-bd0508479dc4', 'icon-ankh', 'icon-ankh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(675, '0db85a39-2835-48ef-a5ff-d7199fe38553', 'icon-apple-alt', 'icon-apple-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(676, 'fea97021-7bd2-424f-900a-d592a0f50db8', 'icon-archive', 'icon-archive', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(677, 'e5397ce1-e6a8-4c37-8324-c58a7436f722', 'icon-archway', 'icon-archway', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(678, '1bb6b2f0-d3c1-4f53-885e-6061917f0035', 'icon-arrow-alt-circle-down', 'icon-arrow-alt-circle-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(679, '4c103b23-9835-4a98-becb-ef650380f35b', 'icon-arrow-alt-circle-left', 'icon-arrow-alt-circle-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(680, '503be1e1-97d2-40f0-99bb-ce51eb40ed7b', 'icon-arrow-alt-circle-right', 'icon-arrow-alt-circle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(681, 'e0cb59c4-793c-440e-9fc3-a31016c844d5', 'icon-arrow-alt-circle-up', 'icon-arrow-alt-circle-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(682, '34fb9139-5622-42ce-92f8-1038a2e86ca5', 'icon-arrow-circle-down', 'icon-arrow-circle-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(683, '446cd965-ea0b-49c3-98e4-4dbcf04d848b', 'icon-arrow-circle-left', 'icon-arrow-circle-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(684, '866e684b-867f-4574-83a4-bbfd4670b942', 'icon-arrow-circle-right', 'icon-arrow-circle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(685, 'c33f5524-fae4-4e8b-ba66-46fbaf82ad62', 'icon-arrow-circle-up', 'icon-arrow-circle-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(686, '13136e3a-2e6b-41cb-8506-3ccf9bbd42d8', 'icon-arrow-down', 'icon-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(687, 'cda963f7-51cd-439e-872e-9a9b2d97dedd', 'icon-arrow-left', 'icon-arrow-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(688, 'd32ebad7-da16-486a-a3f6-0308467f6330', 'icon-arrow-right', 'icon-arrow-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(689, '404185fd-da33-467b-b226-ca263c11a46a', 'icon-arrow-up', 'icon-arrow-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(690, '83573a4d-ee59-4114-a70d-bd830c336f03', 'icon-arrows-alt-h', 'icon-arrows-alt-h', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(691, 'fa1dcd4c-6c5f-406d-ae36-9e46d2ea7762', 'icon-arrows-alt-v', 'icon-arrows-alt-v', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(692, '7bd79ecc-197c-4b5d-abb2-daba73740539', 'icon-arrows-alt', 'icon-arrows-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(693, '433a13e0-3b3a-4bdf-86e2-507c06f0672f', 'icon-assistive-listening-systems', 'icon-assistive-listening-systems', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(694, '8412f680-e241-4446-814a-bc83d694f453', 'icon-asterisk', 'icon-asterisk', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(695, '17a9d623-f371-4555-8f6a-9342c167a5b8', 'icon-at', 'icon-at', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(696, '961d394d-e384-4360-893d-5030e9028dd8', 'icon-atlas', 'icon-atlas', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(697, '76b2ac35-685d-408f-8455-3009fdab2d56', 'icon-atom', 'icon-atom', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(698, '5b691347-ad63-407b-987a-2e22fcc6830d', 'icon-audio-description', 'icon-audio-description', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(699, '46caa98c-8520-4c5a-bc33-320442211763', 'icon-award', 'icon-award', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(700, 'ce52e20e-6f4a-4535-9454-73435d0503d9', 'icon-backspace', 'icon-backspace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(701, 'c70ab3b8-ad45-402c-85fa-7e2a2fcf49b1', 'icon-backward', 'icon-backward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(702, 'b1c54fd9-0dfc-46b8-81da-412a595609c5', 'icon-balance-scale', 'icon-balance-scale', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(703, '4ce59670-a57e-420a-8484-dd80d7061428', 'icon-ban', 'icon-ban', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(704, '4b462271-515a-49c3-a661-948f13af4eee', 'icon-band-aid', 'icon-band-aid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(705, 'f36166d0-09dd-4427-8fde-402161e4362c', 'icon-barcode', 'icon-barcode', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(706, '3d9d0ae0-625b-456b-a115-f8495309695d', 'icon-bars', 'icon-bars', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(707, '236f7c74-ce52-4387-8a73-c01bbef2b5f9', 'icon-baseball-ball', 'icon-baseball-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(708, '55ee4e7c-d8e6-4292-800e-87d40f0139ad', 'icon-basketball-ball', 'icon-basketball-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(709, '1382963d-d10f-49d7-a3a0-3ff9d74ce91b', 'icon-bath', 'icon-bath', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(710, 'a6fa1361-5244-444b-80c5-3b5ea28d7075', 'icon-battery-empty', 'icon-battery-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(711, 'a660e3ca-1e54-4030-a5ab-8f9667c8115c', 'icon-battery-full', 'icon-battery-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(712, '5b0bfc93-0486-41d1-a0bb-1cd0d8114078', 'icon-battery-half', 'icon-battery-half', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(713, '1cd542af-6fb0-4ddc-aade-6df1e047c52d', 'icon-battery-quarter', 'icon-battery-quarter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(714, '5e500f00-b76f-4a5e-97ba-6c546d86810c', 'icon-battery-three-quarters', 'icon-battery-three-quarters', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(715, 'a09e238d-4f6f-4eb1-b7f3-bb5bc587831e', 'icon-bed', 'icon-bed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(716, 'b54c0f03-831e-4b2b-8b65-d4f15b363d33', 'icon-beer', 'icon-beer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(717, '3271ea6a-6942-4c7e-a211-93e20e299add', 'icon-bell-slash', 'icon-bell-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(718, '53d72956-17ef-4756-bfb6-875f215657f1', 'icon-bell', 'icon-bell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(719, 'f113f667-16d5-4321-8d45-aee182f30922', 'icon-bezier-curve', 'icon-bezier-curve', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(720, '27add966-c5aa-4e65-b505-fcc55bfa048f', 'icon-bible', 'icon-bible', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(721, '8def9a9a-ca63-493d-a1e4-6f11a7511ab2', 'icon-bicycle', 'icon-bicycle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(722, '2ee69e9a-df59-4773-8e6d-27d58d213bea', 'icon-binoculars', 'icon-binoculars', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(723, 'fc842144-358b-4dc5-b02a-dc86d79460c9', 'icon-birthday-cake', 'icon-birthday-cake', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(724, 'a1571d10-913a-4499-b56c-ccf0c51944cc', 'icon-blender', 'icon-blender', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(725, '0d1dacf3-095c-4286-9f75-9cc22782ccbb', 'icon-blind', 'icon-blind', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(726, 'e45a52dc-2614-4447-84b2-6cf224f76ada', 'icon-bold', 'icon-bold', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(727, '8cda017a-05d9-48bb-9307-e40e2f1963de', 'icon-bolt', 'icon-bolt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(728, '9e45fce5-159b-4180-a53b-e366ede43dcf', 'icon-bomb', 'icon-bomb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(729, 'f6ce0ecf-308c-46a6-9cfe-db72164bbbb0', 'icon-bone', 'icon-bone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(730, 'a358fa60-522a-48df-a7cc-b4a07b50b4e8', 'icon-bong', 'icon-bong', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(731, 'd42c09db-7b04-48f7-a308-8faf462b435f', 'icon-book-open', 'icon-book-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(732, '63a57acc-0f38-4dd1-a8e3-6094286257bd', 'icon-book-reader', 'icon-book-reader', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(733, '31817ad5-5c81-4912-a798-6ac671108b39', 'icon-book', 'icon-book', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(734, 'f73769ed-d254-45be-b9f1-7f62b7865c78', 'icon-bookmark', 'icon-bookmark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(735, '73a88575-8495-43f2-92c5-3b6adc72814d', 'icon-bowling-ball', 'icon-bowling-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(736, '4ddde5a9-8276-4bd4-a788-0f95556eb85a', 'icon-box-open', 'icon-box-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(737, '921a6806-543d-4de9-99c4-431fc114c8f3', 'icon-box', 'icon-box', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(738, '44b11e20-7214-47f9-bde4-6ce1355aaa00', 'icon-boxes', 'icon-boxes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(739, '880f8b4a-5d6a-4d03-b8eb-b3e2f9fff966', 'icon-braille', 'icon-braille', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(740, 'a36e7a91-66dd-4ab9-b4d6-ece85e58fd9d', 'icon-brain', 'icon-brain', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(741, 'e9b59045-1db5-4aed-b9c0-b3db6bf15e91', 'icon-briefcase-medical', 'icon-briefcase-medical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(742, 'f036c01b-9305-448f-b25d-1ae1f77c8dc5', 'icon-briefcase', 'icon-briefcase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(743, '99cb4d59-14d5-4db9-936f-35c6f99f61bf', 'icon-broadcast-tower', 'icon-broadcast-tower', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(744, '98078377-16bd-42d2-b4f8-6bf1f459f7fb', 'icon-broom', 'icon-broom', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(745, '8d929c82-1b3b-4b12-8202-5772ce4a2aad', 'icon-brush', 'icon-brush', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(746, '010ae286-5eb5-4f29-8ec7-5b86427de5c6', 'icon-bug', 'icon-bug', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(747, '50cfa027-9f6d-4216-a0d8-0b44d7101fa9', 'icon-building', 'icon-building', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(748, '5ed5d19c-9c17-480e-8461-c085381ccfe4', 'icon-bullhorn', 'icon-bullhorn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(749, 'a8e73b6d-29f8-41b0-a6d0-e681352de10d', 'icon-bullseye', 'icon-bullseye', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(750, 'd52085c4-1ce9-4223-bdb3-1510a3f71fd7', 'icon-burn', 'icon-burn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(751, 'a4b02879-178e-439b-bc01-df3ba5a83307', 'icon-bus-alt', 'icon-bus-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(752, '9423533d-79cc-4611-b672-80b3a64573ca', 'icon-bus', 'icon-bus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(753, 'cbf70999-5df4-45e6-be16-70778434416f', 'icon-business-time', 'icon-business-time', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(754, 'bfaaa485-e1c9-41af-838d-a366bba8cdcc', 'icon-calculator', 'icon-calculator', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(755, '49f31fb1-1f91-4617-b60e-0aa889f246f8', 'icon-calendar-alt', 'icon-calendar-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(756, '14a5504f-bf0c-438e-b9c4-80732f6e0d7a', 'icon-calendar-check', 'icon-calendar-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(757, '0a852815-09a9-485f-8d91-27fdfd9293f0', 'icon-calendar-minus', 'icon-calendar-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(758, 'ef209bc5-28cc-42db-bf91-837550bfc6bf', 'icon-calendar-plus', 'icon-calendar-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(759, 'b18703e3-c563-428d-8da8-e3ea4d49999c', 'icon-calendar-times', 'icon-calendar-times', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(760, 'a9d566bb-e465-4a17-b9f7-d95526e84da6', 'icon-calendar', 'icon-calendar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(761, 'b46d9b13-90f8-4a11-9b50-d126a9e54938', 'icon-camera-retro', 'icon-camera-retro', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(762, '1248be45-e548-41ac-ab9a-2d22a1de0e6f', 'icon-camera', 'icon-camera', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(763, '64f1e332-e4e2-4734-b59b-b6c0f245c6c5', 'icon-cannabis', 'icon-cannabis', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(764, 'bf78e70b-3e25-493c-98b6-c4f8c66bfe98', 'icon-capsules', 'icon-capsules', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(765, '809a2ac3-dc15-45a0-9a47-22a65e580fa2', 'icon-car-alt', 'icon-car-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(766, '83760723-c831-4870-9efc-1fbdd9cd9969', 'icon-car-battery', 'icon-car-battery', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(767, 'f6a0a177-85d8-43ba-bba3-59519179682b', 'icon-car-crash', 'icon-car-crash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(768, '2032c14c-177a-404a-b3e8-a4150f3e0526', 'icon-car-side', 'icon-car-side', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(769, '7c539d7d-fe37-4a23-8a92-fdcd9c1b76ce', 'icon-car', 'icon-car', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(770, 'abee399b-68c0-444a-a887-50687bac9aae', 'icon-caret-down', 'icon-caret-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(771, '22f56cea-1ef1-4f50-b36a-6112deca5c37', 'icon-caret-left', 'icon-caret-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(772, '0f8ab519-a400-4323-af23-28ffd39f3111', 'icon-caret-right', 'icon-caret-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(773, 'b1d7c825-9792-45eb-b268-34031e8e79f0', 'icon-caret-square-down', 'icon-caret-square-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(774, '24c0a841-77ee-48c6-85e8-1904b5eeb4c2', 'icon-caret-square-left', 'icon-caret-square-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(775, '6c2ecc98-81be-44d6-82b4-f59e67a27e31', 'icon-caret-square-right', 'icon-caret-square-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(776, 'dde58cc9-fee5-418a-ad82-85fd20b8dc79', 'icon-caret-square-up', 'icon-caret-square-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(777, '5c941681-ef5c-427b-8f23-674d89d3ac74', 'icon-caret-up', 'icon-caret-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(778, 'b1906a68-74b1-4340-8221-da50f27b2e28', 'icon-cart-arrow-down', 'icon-cart-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(779, '85120713-bea6-4a01-8ebd-c6058b75e808', 'icon-cart-plus', 'icon-cart-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(780, 'b7e1d3eb-f57e-4f4c-8dc9-5f9938a23fc9', 'icon-certificate', 'icon-certificate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(781, '60f3fd7b-20e8-44a5-800b-6dd583697508', 'icon-chalkboard-teacher', 'icon-chalkboard-teacher', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(782, 'de9804f5-cb40-4728-b7dc-f50bf99c3deb', 'icon-chalkboard', 'icon-chalkboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(783, 'a8dfb277-ce85-4aa4-859c-724951b160f4', 'icon-charging-station', 'icon-charging-station', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(784, '95967eaf-9284-441f-bae9-ff51fed8579a', 'icon-chart-area', 'icon-chart-area', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(785, 'e5e51e17-900e-4f36-8a95-b6b994d84d11', 'icon-chart-bar', 'icon-chart-bar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(786, 'af338b40-9a7b-48fd-84d9-d1177eecb482', 'icon-chart-line', 'icon-chart-line', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(787, 'aff621b7-de9b-4d4f-8b8c-404739fa5017', 'icon-chart-pie', 'icon-chart-pie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(788, '72a93a47-767e-43ae-9da9-15ab507f33b4', 'icon-check-circle', 'icon-check-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(789, 'c92917d3-7b22-4d2c-a18f-472ab80f366d', 'icon-check-double', 'icon-check-double', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(790, '6c927a54-f9e1-4438-802a-a4acf7fa4975', 'icon-check-square', 'icon-check-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(791, '7a0d1d40-6dba-4379-9a0f-66e67bdf4294', 'icon-check', 'icon-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(792, 'bf904815-c316-4c1f-bddf-56ff810b0e18', 'icon-chess-bishop', 'icon-chess-bishop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(793, 'a8536989-9275-4a2f-8051-cae4e4e825b5', 'icon-chess-board', 'icon-chess-board', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(794, 'dae703e7-6484-412b-bb02-76c0c41974ef', 'icon-chess-king', 'icon-chess-king', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(795, 'def3496e-9f54-4049-a083-cdeb7b000e01', 'icon-chess-knight', 'icon-chess-knight', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(796, '567cc6dd-d0fa-40ab-9e93-b0591bb942e5', 'icon-chess-pawn', 'icon-chess-pawn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(797, 'efbd05b5-aa1e-4bdf-bdc5-cc19b36a90bb', 'icon-chess-queen', 'icon-chess-queen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(798, 'da37c4ae-0b6d-4275-8c67-9bf18b07313b', 'icon-chess-rook', 'icon-chess-rook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(799, 'bef2113c-aa23-40a8-8007-5181d490a58b', 'icon-chess', 'icon-chess', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(800, 'b1161ca0-8412-4abb-b020-a124d5eacd0b', 'icon-chevron-circle-down', 'icon-chevron-circle-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(801, '4227948f-5864-4fed-ae8e-78846baf1c7a', 'icon-chevron-circle-left', 'icon-chevron-circle-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(802, '0e541330-6d1e-4a24-ba31-83ad88dd7a3a', 'icon-chevron-circle-right', 'icon-chevron-circle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(803, '977f4575-93dc-4314-9949-8e01812c182a', 'icon-chevron-circle-up', 'icon-chevron-circle-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(804, 'e2126533-12fb-4956-b698-293544a88d74', 'icon-chevron-down', 'icon-chevron-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(805, 'b2d68abb-50d2-4d5c-b22c-34dbbf9118b0', 'icon-chevron-left', 'icon-chevron-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(806, 'dc8d7bf3-3196-4585-ae73-ecd761d5595a', 'icon-chevron-right', 'icon-chevron-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(807, '7d51eb35-d24b-4828-91ee-7fb93ba48e08', 'icon-chevron-up', 'icon-chevron-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(808, '12df7031-bdef-4748-963d-21e0ba54b849', 'icon-child', 'icon-child', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(809, '861de27c-7556-4e31-a040-9dcb09e4bd85', 'icon-church', 'icon-church', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(810, '3b6a5ad1-9d61-49e8-a66f-c0c7750bf011', 'icon-circle-notch', 'icon-circle-notch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(811, '88bc16bc-a987-48ee-9f6e-d65fe21f5178', 'icon-circle', 'icon-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(812, '3aa9758e-4f7a-4d24-bfda-9df5644d81fe', 'icon-city', 'icon-city', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(813, '08d62a7b-8ccd-4006-a5ee-86ddacf75d37', 'icon-clipboard-check', 'icon-clipboard-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(814, '2d17fbd6-d902-4423-af06-8e8fdff76ddc', 'icon-clipboard-list', 'icon-clipboard-list', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(815, 'cd04881d-5939-438b-8eca-71c1111adc90', 'icon-clipboard', 'icon-clipboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(816, 'ca9e5945-b861-4902-aff7-9e36b0438fe8', 'icon-clock', 'icon-clock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(817, '64cd3603-3629-4719-8fa4-3f3648cd3759', 'icon-clone', 'icon-clone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(818, '52773069-8ae9-48ff-8c5d-f216fb9aba3e', 'icon-closed-captioning', 'icon-closed-captioning', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(819, '499546f2-956d-45ca-ac0b-5c4aba70455e', 'icon-cloud-download-alt', 'icon-cloud-download-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(820, '55040c17-164e-4782-981b-9d229095bcde', 'icon-cloud-upload-alt', 'icon-cloud-upload-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(821, '721feadc-7624-46d2-8dbd-5db5736a1982', 'icon-cloud', 'icon-cloud', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(822, 'df885b96-3a3f-4c66-a3ec-381e1148ac8a', 'icon-cocktail', 'icon-cocktail', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(823, '0d4486d3-23b9-47f5-9b9c-d7920abbe1ff', 'icon-code-branch', 'icon-code-branch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(824, '4f740e9e-bfc7-404d-b2aa-1b6335e07b58', 'icon-code', 'icon-code', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(825, '5eb8f60c-b54d-477f-8be2-def3aa3627ce', 'icon-coffee', 'icon-coffee', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(826, 'ce77aa6c-58bd-478d-8dbc-b9bf1916c6db', 'icon-cog', 'icon-cog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(827, '2984808e-f45a-4b99-b4e0-81de2a479fec', 'icon-cogs', 'icon-cogs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(828, 'b6d1d56a-5f40-40a5-8e64-8532b15b973a', 'icon-coins', 'icon-coins', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(829, '0710d9e5-8ed8-44fe-a820-fc3f71c7ded4', 'icon-columns', 'icon-columns', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(830, 'e0718779-e8a9-4f1b-969a-305d1209f85f', 'icon-comment-alt', 'icon-comment-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(831, '4544b569-0226-4699-bdc3-4811f7bd49db', 'icon-comment-dollar', 'icon-comment-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(832, '500a050d-bcc0-4b48-aff2-e8d3c48dadc6', 'icon-comment-dots', 'icon-comment-dots', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(833, 'c31cbd2f-ce3e-4c8f-8892-60a0ac63e59f', 'icon-comment-slash', 'icon-comment-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(834, '2b6df118-3764-4968-a451-6ec2aed83c88', 'icon-comment', 'icon-comment', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(835, '03225c31-f79f-4082-9e43-459c60310331', 'icon-comments-dollar', 'icon-comments-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(836, 'c9408d86-3663-49ad-9780-225229456563', 'icon-comments', 'icon-comments', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(837, '67cef122-8638-4a59-aa95-5b8279231980', 'icon-compact-disc', 'icon-compact-disc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(838, 'c03b4250-56d7-4fb8-9681-b15751252bec', 'icon-compass', 'icon-compass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(839, 'c0b18852-138a-49de-8cbe-1ee79e8be15c', 'icon-compress', 'icon-compress', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(840, '8b4c679d-acb7-4bc6-8108-9384577a68d2', 'icon-concierge-bell', 'icon-concierge-bell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(841, '31571009-c54a-4a62-8969-16e6a3b14d5e', 'icon-cookie-bite', 'icon-cookie-bite', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(842, 'bbcf623d-281b-447b-a45c-ec8bded6b43e', 'icon-cookie', 'icon-cookie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(843, '896ea688-4129-4cb8-a064-06b2ab877978', 'icon-copy', 'icon-copy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(844, '8049f978-ddc1-4e28-bed6-b3b02688a863', 'icon-copyright', 'icon-copyright', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(845, 'ea102276-a73f-4798-8c33-f0a1d062a072', 'icon-couch', 'icon-couch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(846, '7c0bb332-55ce-41d9-b63c-502cac06ad74', 'icon-credit-card', 'icon-credit-card', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(847, '68befc1b-686f-4fd5-a8fd-25e68554351f', 'icon-crop-alt', 'icon-crop-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(848, '686deb4e-3ed0-4006-870f-af2e13c9394f', 'icon-crop', 'icon-crop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(849, 'b51d46fe-3e28-4705-828f-86e0bfc447f6', 'icon-cross', 'icon-cross', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(850, '96b7f0f1-722c-4792-b1a2-b76b7c7aa412', 'icon-crosshairs', 'icon-crosshairs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(851, '1155a676-edf1-491d-a267-090de28b84d3', 'icon-crow', 'icon-crow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(852, '4be73f8d-a45e-4e5d-b7e6-07b653543612', 'icon-crown', 'icon-crown', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(853, '0b392ede-fbc8-4982-8182-6a2b55cf2a11', 'icon-cube', 'icon-cube', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(854, '19fd0d92-9c32-430b-b35c-6d31b56a536c', 'icon-cubes', 'icon-cubes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(855, 'f377ccf5-8460-4a1b-9b47-59eba1fb19cc', 'icon-cut', 'icon-cut', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(856, '2963cbd6-2d14-48c2-bfc8-11b94a9a0899', 'icon-database', 'icon-database', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(857, '46a1bbab-c366-4938-bf42-c0464a9c66b6', 'icon-deaf', 'icon-deaf', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(858, '0f74117b-fa57-4805-9e0a-509cc8e4158f', 'icon-desktop', 'icon-desktop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(859, '22da9d0a-8946-4f63-8cdf-fe9846d32ddf', 'icon-dharmachakra', 'icon-dharmachakra', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(860, 'e5f33066-c118-49f5-883e-b0dfa94ff374', 'icon-diagnoses', 'icon-diagnoses', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(861, '4d911692-afec-4bdb-81b8-bf2834f6b5d9', 'icon-dice-five', 'icon-dice-five', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(862, 'e4a330c5-4c53-49f7-ac8d-aad344f4e1da', 'icon-dice-four', 'icon-dice-four', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(863, 'a6bddced-c227-49cc-a1b0-ec0235cbc575', 'icon-dice-one', 'icon-dice-one', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(864, '51d9d4f0-7fc1-4bc3-b45f-06e7fcf25f57', 'icon-dice-six', 'icon-dice-six', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(865, '37287ce2-a61f-41e6-b266-9f71945115a2', 'icon-dice-three', 'icon-dice-three', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(866, '734390c4-5d1b-4c37-bf01-7ea87bcb199c', 'icon-dice-two', 'icon-dice-two', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(867, 'f74b5471-ac31-4c31-af07-e6cfff8c4e59', 'icon-dice', 'icon-dice', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(868, '92fa0edb-ff27-4f11-98fc-be249899ae30', 'icon-digital-tachograph', 'icon-digital-tachograph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(869, 'f70cbaff-db3c-438f-9baa-b4dd51837832', 'icon-directions', 'icon-directions', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(870, 'bc845f76-6d2d-4b9b-9f8e-d07f6cd73deb', 'icon-divide', 'icon-divide', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(871, '6e089e19-a942-4c55-9ede-ba31f5ae0ae5', 'icon-dizzy', 'icon-dizzy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(872, '7c5123f7-2706-4a1d-adbc-e3ab025d2a16', 'icon-dna', 'icon-dna', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(873, '68d47e38-84d0-4255-863a-039c873b0e5e', 'icon-dollar-sign', 'icon-dollar-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(874, '3f91c74a-c9bf-4345-a652-513703b5019b', 'icon-dolly-flatbed', 'icon-dolly-flatbed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(875, '4b5a3f80-b3d7-4f70-a248-a0071e9bb225', 'icon-dolly', 'icon-dolly', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(876, '796ca663-5c71-46e1-ac38-da683d421ffe', 'icon-donate', 'icon-donate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(877, 'a60baabf-3be6-41be-a81c-3a2ebdb52cff', 'icon-door-closed', 'icon-door-closed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(878, '61fea806-f276-446c-ae07-2b0acaf6838e', 'icon-door-open', 'icon-door-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(879, '1e9fe0a1-9dea-4b26-a463-03f7849c04ea', 'icon-dot-circle', 'icon-dot-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(880, 'da21b1f8-f264-4326-8b62-1b3ab92e7bfb', 'icon-dove', 'icon-dove', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(881, '6f41cfa0-8d28-4121-91fa-066f23e862fd', 'icon-download', 'icon-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(882, '4fc32bcf-baca-4fad-990b-da7ad30ae413', 'icon-drafting-compass', 'icon-drafting-compass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(883, 'dfcb6c77-5be1-4c25-b841-0cd7eb3f6889', 'icon-draw-polygon', 'icon-draw-polygon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(884, '3d4aaab0-ca6e-43e2-914e-f135903cd5ae', 'icon-drum-steelpan', 'icon-drum-steelpan', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(885, '16136723-721a-4bf8-8e76-16ac6652e77f', 'icon-drum', 'icon-drum', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(886, 'c1c5f94b-e04a-4d4e-a1b2-080a54987cd1', 'icon-dumbbell', 'icon-dumbbell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(887, '9147b8b1-9748-4724-ab2b-6e6003a09c34', 'icon-edit', 'icon-edit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(888, '2248f008-685c-4bb4-b01d-78fab294de6d', 'icon-eject', 'icon-eject', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(889, '0527264e-9a7b-4718-a9b4-06f50caa7c13', 'icon-ellipsis-h', 'icon-ellipsis-h', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(890, 'c83bdf00-5f4b-4ec2-8c42-23bcbef7d853', 'icon-ellipsis-v', 'icon-ellipsis-v', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(891, 'e0996cb8-b112-4617-87dd-f7a69f96bce0', 'icon-envelope-open-text', 'icon-envelope-open-text', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(892, '275de691-899e-44ab-bcaa-c62706deffac', 'icon-envelope-open', 'icon-envelope-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(893, 'c39be317-7f9f-4afa-8a4a-0aa22d622a28', 'icon-envelope-square', 'icon-envelope-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(894, '94f56743-b730-43f5-83ae-f087afe25c9b', 'icon-envelope', 'icon-envelope', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(895, '119d8b3c-7073-43b8-8b64-83a949eb3a7b', 'icon-equals', 'icon-equals', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(896, '5238196b-4eb8-48b4-93b6-901a7ab11093', 'icon-eraser', 'icon-eraser', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(897, '49e0584c-c3a2-4ca1-8a4e-0897790d44b9', 'icon-euro-sign', 'icon-euro-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(898, '2d334e83-591a-4187-9a1b-4c58856d16bb', 'icon-exchange-alt', 'icon-exchange-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(899, '661d8f38-4805-4090-a7ca-d95da3b4fa11', 'icon-exclamation-circle', 'icon-exclamation-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(900, '41f02f2c-9037-44c9-92a6-30fa76f9c340', 'icon-exclamation-triangle', 'icon-exclamation-triangle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(901, '52aafae4-af9c-406f-90b8-3fdaf7681bdc', 'icon-exclamation', 'icon-exclamation', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(902, 'd14495f2-ee90-4c05-b29e-6492739d2ff9', 'icon-expand-arrows-alt', 'icon-expand-arrows-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(903, '5f2c2c5b-9451-4ebf-8897-e872917a0f36', 'icon-expand', 'icon-expand', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(904, 'c111885e-be43-4768-ba56-d411f28f2b3b', 'icon-external-link-alt', 'icon-external-link-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(905, 'ffdd8ce6-48c1-4ba5-9e13-86227a7b28a2', 'icon-external-link-square-alt', 'icon-external-link-square-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(906, '98faf7bd-785c-4cf6-8859-3619db1c94bd', 'icon-eye-dropper', 'icon-eye-dropper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(907, 'ecdbb9e5-af5b-45a8-b9da-1050c0add000', 'icon-eye-slash', 'icon-eye-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(908, 'de29ded3-2a56-456c-915d-d32503ab02a2', 'icon-eye', 'icon-eye', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(909, '22bcd88a-9dbf-41ba-b5eb-7c65a32cd052', 'icon-fast-backward', 'icon-fast-backward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(910, 'da29dd6a-fcf9-4321-a6b7-cc399452852d', 'icon-fast-forward', 'icon-fast-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(911, 'e71a5aa8-238e-4209-84ce-0dbb497b58b4', 'icon-fax', 'icon-fax', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(912, '6daee3d8-4047-469e-8885-888b53d35c26', 'icon-feather-alt', 'icon-feather-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(913, '8d3317b1-6207-4a3e-94a1-864c54218ee7', 'icon-feather', 'icon-feather', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(914, '386dff7f-77b4-4ae3-ac32-6a9e813165b3', 'icon-female', 'icon-female', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(915, '67a70c1e-d5fa-42bb-89e1-a452b941bf14', 'icon-fighter-jet', 'icon-fighter-jet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(916, '5c37e452-b277-46ec-819d-4ac5d387be87', 'icon-file-alt', 'icon-file-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(917, '138ed1eb-8d71-442f-a58a-23b94da141b1', 'icon-file-archive', 'icon-file-archive', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(918, 'c7ccfa62-cfd8-4198-b3b8-559c9ce293f2', 'icon-file-audio', 'icon-file-audio', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(919, 'd9e964a5-2dfe-4ba9-910e-94d890360a7a', 'icon-file-code', 'icon-file-code', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(920, 'e7a13c38-a1d4-4099-bc68-382200392ef0', 'icon-file-contract', 'icon-file-contract', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(921, '9d30e9a6-fe3f-4059-91ae-16db9ed0149b', 'icon-file-download', 'icon-file-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(922, '6e81bb95-d9be-4396-930a-b2cbe4ded807', 'icon-file-excel', 'icon-file-excel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(923, 'be34088e-2f74-4941-9e00-1d3113324469', 'icon-file-export', 'icon-file-export', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(924, '49a94a15-d31d-400a-9232-31173ca23ff6', 'icon-file-image', 'icon-file-image', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(925, 'a45dbedc-848a-4272-b310-979888e63af1', 'icon-file-import', 'icon-file-import', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(926, '9ea8162f-f16b-441e-818d-3b18c26813e0', 'icon-file-invoice-dollar', 'icon-file-invoice-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(927, 'afb6e3e5-9317-4359-a77e-2d5578b2106e', 'icon-file-invoice', 'icon-file-invoice', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(928, '57cc28a5-4ad9-4f3c-987f-4c024636b484', 'icon-file-medical-alt', 'icon-file-medical-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(929, '3f8fd685-5ffa-47c8-82f9-3c340f2043c4', 'icon-file-medical', 'icon-file-medical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(930, '939402d8-01d6-4643-bc4c-09b94adeca1c', 'icon-file-pdf', 'icon-file-pdf', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(931, '06706e94-dca5-46e8-8a2c-fd5fb7f66039', 'icon-file-powerpoint', 'icon-file-powerpoint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(932, 'ebcb3762-a598-43e1-aa5b-9fdba0835df4', 'icon-file-prescription', 'icon-file-prescription', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(933, 'bba05db6-41fc-4d66-b92e-e084db6acdbe', 'icon-file-signature', 'icon-file-signature', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(934, 'a8e8b98c-948c-4ea3-ab51-ee5d9b5a90e4', 'icon-file-upload', 'icon-file-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(935, 'be93da14-140e-4339-849c-59ec43bfed5b', 'icon-file-video', 'icon-file-video', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(936, 'fa872106-5824-46ab-9058-40d7f9462769', 'icon-file-word', 'icon-file-word', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(937, '8c40b168-1733-45c9-8a98-30b730c33974', 'icon-file', 'icon-file', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(938, 'ade7d3b5-29e3-4909-b4e8-d83c116abbfc', 'icon-fill-drip', 'icon-fill-drip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(939, 'cd833fa9-73a7-445c-8253-f598f1ff9d13', 'icon-fill', 'icon-fill', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(940, '5a3b4643-680d-4c7b-8195-0bae672c3f84', 'icon-film', 'icon-film', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(941, 'f8e133f4-b580-4648-9b2b-1d3291d2945a', 'icon-filter', 'icon-filter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(942, 'af1e6b14-67a4-4829-995b-26677ffe4fd6', 'icon-fingerprint', 'icon-fingerprint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(943, 'c730229d-5322-4ea6-8d44-dd78619e0865', 'icon-fire-extinguisher', 'icon-fire-extinguisher', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(944, 'b9a459d0-5fc5-4a11-998d-0ff19a0c09da', 'icon-fire', 'icon-fire', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(945, '4a7d403d-083f-4766-b1ef-34b84f85e202', 'icon-first-aid', 'icon-first-aid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(946, 'be2fe05c-59f4-4908-85a1-3da6265baa54', 'icon-fish', 'icon-fish', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(947, 'ea471a23-277b-4f94-9ee2-28aab9cea15e', 'icon-flag-checkered', 'icon-flag-checkered', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(948, '858aa586-c026-4ce9-92cd-c9c4bed91676', 'icon-flag', 'icon-flag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(949, '238a4719-3e2e-44fc-bd0b-b43a404b43d4', 'icon-flask', 'icon-flask', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(950, 'fdf2acd7-8d39-4b08-b705-ab22ada95cd9', 'icon-flushed', 'icon-flushed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(951, 'c438344a-68eb-469e-a21c-010c17e92e67', 'icon-folder-minus', 'icon-folder-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(952, '0a7f3dcf-87c1-4f79-994c-84d479ea6b5f', 'icon-folder-open', 'icon-folder-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(953, 'a1125296-71b6-42b9-a55f-d31caf1844a6', 'icon-folder-plus', 'icon-folder-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(954, '49811d83-e339-4ccb-a56b-7132bb492fa9', 'icon-folder', 'icon-folder', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(955, '1557019d-a4ed-4193-9f78-d352743384c1', 'icon-font-awesome-logo-full', 'icon-font-awesome-logo-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(956, '0d171b93-8936-4610-9747-1b0e7f1d62bf', 'icon-font', 'icon-font', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(957, 'ca3c765b-295d-40f7-b2b6-b8d17daaea5e', 'icon-football-ball', 'icon-football-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(958, '6618668e-eba1-4b42-82e4-2054498d3979', 'icon-forward', 'icon-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(959, 'a6b95c3c-999e-4034-ac99-d786bd400501', 'icon-frog', 'icon-frog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(960, '8bd4dcf4-41c6-4b91-813b-aeb852ed4472', 'icon-frown-open', 'icon-frown-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(961, 'f8f48092-f1f0-40e0-a3a9-781249cc2c52', 'icon-frown', 'icon-frown', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(962, '8842a0ba-1f5f-4f97-9d97-41343d4cca89', 'icon-funnel-dollar', 'icon-funnel-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(963, '4a996ffd-78e0-48eb-9b69-dde0cc10e007', 'icon-futbol', 'icon-futbol', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(964, 'cd5aa4f3-87ce-42d4-a2de-d1acc13fbba8', 'icon-gamepad', 'icon-gamepad', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(965, 'b5683a76-0d0f-4340-8f0d-af178ef1884f', 'icon-gas-pump', 'icon-gas-pump', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(966, 'fd783ef0-fa36-47bb-8151-3171248ab993', 'icon-gavel', 'icon-gavel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(967, '7805972d-85cf-4090-a9da-30a45839e3f1', 'icon-gem', 'icon-gem', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(968, '1115acf9-54e3-4dbc-930e-71d44a0e5061', 'icon-genderless', 'icon-genderless', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(969, 'ce6592cd-761b-4dd9-bd80-02ddd9e7afa4', 'icon-gift', 'icon-gift', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(970, 'bee314ca-8fb0-4af2-877b-e2f28d79f30b', 'icon-glass-martini-alt', 'icon-glass-martini-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(971, '59b6f38a-07c9-4df9-af4d-9673fe093a6e', 'icon-glass-martini', 'icon-glass-martini', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(972, 'dc6e5893-ac8c-43ab-97d6-cf202621c7af', 'icon-glasses', 'icon-glasses', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(973, '861e1af7-213a-42f8-bcec-4460b297ab4f', 'icon-globe-africa', 'icon-globe-africa', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(974, 'f2709ee7-dc7c-40fc-bbdb-3ea8b66234d5', 'icon-globe-americas', 'icon-globe-americas', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(975, '40f7720c-0d43-4716-b22a-8b63e6379079', 'icon-globe-asia', 'icon-globe-asia', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(976, '06d8a343-64a0-4c47-9b42-adcb5d44102c', 'icon-globe', 'icon-globe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(977, '7dd58d49-e5a6-438a-87de-e2f4ed6e95b9', 'icon-golf-ball', 'icon-golf-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(978, '504dd3f3-7416-4942-9d15-1aa83d8b68ba', 'icon-gopuram', 'icon-gopuram', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(979, 'd63a336c-cfe4-4791-af46-9a880074c17b', 'icon-graduation-cap', 'icon-graduation-cap', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(980, 'ffe8be24-f7b3-4a98-b826-5ae32638237d', 'icon-greater-than-equal', 'icon-greater-than-equal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(981, 'f4139f66-e090-43ee-8273-c0f9d4f94c8d', 'icon-greater-than', 'icon-greater-than', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(982, '1e51a622-694b-4677-b2d4-7709bd09fbec', 'icon-grimace', 'icon-grimace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(983, 'ae3db74c-685c-487f-9493-d4bbd072d05b', 'icon-grin-alt', 'icon-grin-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(984, 'dbc285f6-4db7-46d0-a840-fed2e7ede25e', 'icon-grin-beam-sweat', 'icon-grin-beam-sweat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(985, '961ed357-608a-4303-8c23-d777787ac401', 'icon-grin-beam', 'icon-grin-beam', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(986, 'c0027dab-284d-4f00-bf53-2e83db4d5bd8', 'icon-grin-hearts', 'icon-grin-hearts', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(987, '4e49b739-3686-4a21-9f57-35842cb44583', 'icon-grin-squint-tears', 'icon-grin-squint-tears', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(988, 'd0b286f5-4577-48fb-b48b-dffbc7f3cf5f', 'icon-grin-squint', 'icon-grin-squint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(989, '3711edd8-8513-4d1f-8896-685ed24ecf73', 'icon-grin-stars', 'icon-grin-stars', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(990, 'd30bbf54-9917-421e-bf9c-0b65635e5de8', 'icon-grin-tears', 'icon-grin-tears', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(991, '91ecde8b-f4bb-49da-a42c-e11c5c4be50e', 'icon-grin-tongue-squint', 'icon-grin-tongue-squint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(992, 'c2a0fca9-1d76-4aeb-8b32-89f122ce26b2', 'icon-grin-tongue-wink', 'icon-grin-tongue-wink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(993, '395e0f07-a064-4923-8952-81726c73c7ed', 'icon-grin-tongue', 'icon-grin-tongue', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(994, '043cdcaf-6d65-4bd9-8d10-cc0bd2b093c0', 'icon-grin-wink', 'icon-grin-wink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(995, 'f4e818ed-b14c-408a-bbd2-077f8f6b87e2', 'icon-grin', 'icon-grin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(996, '2b3ba704-16f2-49f1-9f52-b66163023b22', 'icon-grip-horizontal', 'icon-grip-horizontal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(997, '985f4856-39f3-4d91-81aa-ab11258c4215', 'icon-grip-vertical', 'icon-grip-vertical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(998, '0e81fad3-81f4-4fb1-844e-5d78e2d82478', 'icon-h-square', 'icon-h-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(999, '88704e28-71a1-45ea-be69-a2313c7f61ff', 'icon-hamsa', 'icon-hamsa', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1000, 'cddbd415-cf17-495b-a887-1129d9b93715', 'icon-hand-holding-heart', 'icon-hand-holding-heart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1001, '1bc46cfc-0cf9-4f5a-a225-2254fd9eeb81', 'icon-hand-holding-usd', 'icon-hand-holding-usd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1002, 'b31bd6f5-959d-475c-b7f9-153b51de3ce1', 'icon-hand-holding', 'icon-hand-holding', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1003, '7f374d8c-ed8c-42a0-84cc-a6359213f84b', 'icon-hand-lizard', 'icon-hand-lizard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1004, 'a871af5d-cb38-4783-a825-7939aca81014', 'icon-hand-paper', 'icon-hand-paper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1005, 'eb54b9f3-2acd-43e3-9ea6-1199c0f56d4c', 'icon-hand-peace', 'icon-hand-peace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1006, '119a8a6b-2869-47de-8d14-25039ade582d', 'icon-hand-point-down', 'icon-hand-point-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1007, '46f0aebf-353b-478e-bcd2-d20f3e635d8f', 'icon-hand-point-left', 'icon-hand-point-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1008, 'eea79074-e4b1-44cd-90c7-3de18cade2af', 'icon-hand-point-right', 'icon-hand-point-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1009, '5bbc97ce-71e5-4501-bc3a-b7025854cae2', 'icon-hand-point-up', 'icon-hand-point-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1010, 'e34ebb2b-0524-4c84-9f3a-85dd8f8f88ec', 'icon-hand-pointer', 'icon-hand-pointer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1011, '627999ae-18f6-4fd1-b88f-cf04f3e627ac', 'icon-hand-rock', 'icon-hand-rock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1012, '40ab8fd8-d1f9-492c-9211-1974dfe11acd', 'icon-hand-scissors', 'icon-hand-scissors', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1013, '6dbd41d8-d8b5-40c9-b157-ff254769c711', 'icon-hand-spock', 'icon-hand-spock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1014, '0419399b-ee23-4153-94cd-579f5243a80e', 'icon-hands-helping', 'icon-hands-helping', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1015, 'ec8b59fa-37ab-42bc-8aca-e368e03de0d5', 'icon-hands', 'icon-hands', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1016, 'cb686fff-f5bf-41c3-8505-3833d5ae8a18', 'icon-handshake', 'icon-handshake', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1017, '2a77cce1-190a-4ef7-a942-cd432bba4fec', 'icon-hashtag', 'icon-hashtag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1018, '6c17d06c-b5eb-4238-a0d6-283900c9c85c', 'icon-haykal', 'icon-haykal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1019, '5fae3ac1-af58-476e-949d-636ba3602315', 'icon-hdd', 'icon-hdd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1020, '33d8696d-3865-4e6c-93ca-80d9b3445f4a', 'icon-heading', 'icon-heading', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1021, 'd1719d08-4e7c-4e5e-9e99-fc162040d178', 'icon-headphones-alt', 'icon-headphones-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1022, '9c81cc58-f505-4c8f-afae-2ebf860fc301', 'icon-headphones', 'icon-headphones', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1023, 'b74aa76d-c601-4e1c-b465-8ad9b7399b09', 'icon-headset', 'icon-headset', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1024, '2442130b-110e-4b15-a065-05535729e11d', 'icon-heart', 'icon-heart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1025, '945d7c1e-516c-472b-9051-f758e3e807b9', 'icon-heartbeat', 'icon-heartbeat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1026, '1cd95f71-bdfe-4153-b6bd-de6b5c09324b', 'icon-helicopter', 'icon-helicopter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1027, 'cf0e2255-6869-4bce-9b97-c812a7c56cec', 'icon-highlighter', 'icon-highlighter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1028, '5f8ab6fa-6f98-4e01-9ad0-aaf84d71c196', 'icon-history', 'icon-history', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1029, '25767b10-fad7-4368-863b-942fa8959c03', 'icon-hockey-puck', 'icon-hockey-puck', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1030, '03d09feb-e293-438d-8eee-0d01439ef0e4', 'icon-home', 'icon-home', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1031, '8e4a7c31-4974-418e-96d7-a610f86a5397', 'icon-hospital-alt', 'icon-hospital-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1032, 'bc745e3c-504a-4ed7-97e8-396e3fcb8440', 'icon-hospital-symbol', 'icon-hospital-symbol', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1033, 'eee0379a-ea96-4045-9eb7-532e83b080a5', 'icon-hospital', 'icon-hospital', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1034, '460be45d-994f-4e88-805b-a488e21d59b5', 'icon-hot-tub', 'icon-hot-tub', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1035, '4acc3cc4-ae20-4a7b-adda-d30f7413a4d8', 'icon-hotel', 'icon-hotel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1036, '37c520ce-531a-4df9-928f-d865f8d1daca', 'icon-hourglass-end', 'icon-hourglass-end', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1037, 'd1a12e6a-3269-4847-9c6c-80f34222c210', 'icon-hourglass-half', 'icon-hourglass-half', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1038, '09558ac8-77d7-47f1-8d88-7e10a2ed6858', 'icon-hourglass-start', 'icon-hourglass-start', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1039, 'cfc2db03-85d6-4e2d-a1d4-f8174b3ae3c2', 'icon-hourglass', 'icon-hourglass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1040, 'f19b5351-e64f-4d3b-9c49-0f7f9dad30c4', 'icon-i-cursor', 'icon-i-cursor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1041, '6fc853ce-7643-4c9d-b08a-74c8339eef60', 'icon-id-badge', 'icon-id-badge', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1042, '7550a198-2c42-4e10-bd28-3380c63d0769', 'icon-id-card-alt', 'icon-id-card-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1043, '5a1adaba-ea04-4b14-929e-21704d6c17e2', 'icon-id-card', 'icon-id-card', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1044, '54dc029e-eccb-4a44-91dc-087e4346a21f', 'icon-image', 'icon-image', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1045, '129e191b-4807-445e-a55b-4ce4facc5537', 'icon-images', 'icon-images', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1046, 'fea34571-854b-4f7b-a177-01a9c4a5a33a', 'icon-inbox', 'icon-inbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1047, 'deda1efe-128f-4317-8dac-820989269b32', 'icon-indent', 'icon-indent', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1048, 'bb18e384-8e1e-450e-b8a8-47af72c24af4', 'icon-industry', 'icon-industry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1049, '8d9a0462-6b74-4044-8fdb-4af50c4ed050', 'icon-infinity', 'icon-infinity', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1050, 'd4c7d2f6-7e65-45d3-bf40-cc8fdd6c85f2', 'icon-info-circle', 'icon-info-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1051, '4253205e-0074-4062-9bd7-05c348d339d9', 'icon-info', 'icon-info', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1052, '2ef4ca6b-e4ff-4287-9b5d-c82ea5d3bf8b', 'icon-italic', 'icon-italic', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1053, 'd105f3e2-bcb9-4be4-a65c-5f40d5b149e0', 'icon-jedi', 'icon-jedi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1054, 'b8afc5eb-c4fc-4a7c-9fe1-29b100b40f66', 'icon-joint', 'icon-joint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1055, '82564f69-79d6-4f29-89fe-92b31e67bb4c', 'icon-journal-whills', 'icon-journal-whills', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1056, 'f3053b55-e728-47e8-a12c-dada9a5f8e27', 'icon-kaaba', 'icon-kaaba', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1057, '2877becf-5210-474b-a9e3-4bea470e22c8', 'icon-key', 'icon-key', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1058, '044551db-1e4e-4f04-9392-b41b3a56dbbb', 'icon-keyboard', 'icon-keyboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1059, '37627504-3eb4-436a-a3cb-f904255a9627', 'icon-khanda', 'icon-khanda', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1060, '426c5f59-fa6e-4a3f-9b23-88379ab818dd', 'icon-kiss-beam', 'icon-kiss-beam', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1061, 'da3d41d9-7a97-4f07-ba49-51691a50ecca', 'icon-kiss-wink-heart', 'icon-kiss-wink-heart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1062, 'b373b153-c3d2-40e0-b6de-252790642870', 'icon-kiss', 'icon-kiss', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1063, '1258ea1c-1a85-4f2f-8482-df089705e222', 'icon-kiwi-bird', 'icon-kiwi-bird', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1064, 'aa91d563-a2e7-49f9-97c3-1e81f3d79da0', 'icon-landmark', 'icon-landmark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1065, 'ed3d0144-5f42-4feb-8c4c-fdd82e604534', 'icon-language', 'icon-language', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1066, 'c9aa9cea-b6ed-420c-9691-bc8f2625442b', 'icon-laptop-code', 'icon-laptop-code', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1067, 'e7a9f0dd-9c3f-490a-a383-8a1f62d53ed8', 'icon-laptop', 'icon-laptop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1068, 'ecc5402c-ddb1-4bd3-9c68-072b37c30772', 'icon-laugh-beam', 'icon-laugh-beam', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1069, '972fd929-b934-44cd-bd47-4e109da04e33', 'icon-laugh-squint', 'icon-laugh-squint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1070, 'd4446a50-2ca3-4d3f-bc3e-58a6ffac7372', 'icon-laugh-wink', 'icon-laugh-wink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1071, '32835d48-e7de-4784-aa9c-04b3dd9cb7af', 'icon-laugh', 'icon-laugh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1072, 'b7c10ceb-082f-420d-bdd5-77659157b4e0', 'icon-layer-group', 'icon-layer-group', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1073, '1492817b-faf1-48d0-b132-8d3c1053191d', 'icon-leaf', 'icon-leaf', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1074, '0565d193-4ef6-464e-836e-ce6c581a99fd', 'icon-lemon', 'icon-lemon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1075, '4045284b-bf01-4900-a36e-e7cdfc387765', 'icon-less-than-equal', 'icon-less-than-equal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1076, '6fe3217b-bd99-4ad6-9175-f84701a991d9', 'icon-less-than', 'icon-less-than', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1077, '44e82519-f80f-4a05-9f8a-3e09d3f058ae', 'icon-level-down-alt', 'icon-level-down-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1078, '29dd2c0a-500e-45b7-8fcc-e43f660a64f7', 'icon-level-up-alt', 'icon-level-up-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1079, '5f5d1236-906d-4154-8f65-48f4c3cd2739', 'icon-life-ring', 'icon-life-ring', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1080, 'de33860d-e0ac-43ab-b0bb-c2e6fcc3622f', 'icon-lightbulb', 'icon-lightbulb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1081, 'd1560008-6814-49eb-a344-7fd48247e8c4', 'icon-link', 'icon-link', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1082, '31ffd097-f9c1-4d00-9708-b6485a822ee8', 'icon-lira-sign', 'icon-lira-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1083, '19de9ce0-3bbf-4489-9bd8-497cb77f8feb', 'icon-list-alt', 'icon-list-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1084, '6e9af682-7319-438a-b582-9383b3158d84', 'icon-list-ol', 'icon-list-ol', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1085, '6a578c16-1693-4d0a-b28b-aa38317d62b2', 'icon-list-ul', 'icon-list-ul', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1086, '79037a28-63de-4f8e-a7d6-81ccccb428c8', 'icon-list', 'icon-list', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1087, 'be14f655-4424-41de-8902-991e5a243a97', 'icon-location-arrow', 'icon-location-arrow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1088, '0b32b2aa-590d-4b47-b078-36ea347bdd0f', 'icon-lock-open', 'icon-lock-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1089, '068f67f2-40d1-47b1-887b-016deb4e8f46', 'icon-lock', 'icon-lock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1090, 'cf3fe48b-88f5-4678-a832-61366500120e', 'icon-long-arrow-alt-down', 'icon-long-arrow-alt-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1091, '757c5c14-8ae5-434b-879f-2225ef125a4a', 'icon-long-arrow-alt-left', 'icon-long-arrow-alt-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1092, '038ed474-57ef-4256-af58-f142211ef08d', 'icon-long-arrow-alt-right', 'icon-long-arrow-alt-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1093, '0c066a2f-ad5d-44cd-8286-f2be51a442a8', 'icon-long-arrow-alt-up', 'icon-long-arrow-alt-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1094, '1f9d66cd-0bd8-45c5-be8b-3a9d3a6ef2ae', 'icon-low-vision', 'icon-low-vision', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1095, '30089360-59e8-4253-b5f3-b3d13317dc9f', 'icon-luggage-cart', 'icon-luggage-cart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1096, '1f67221a-d350-49d3-afa1-946bb1248c74', 'icon-magic', 'icon-magic', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1097, '7ffef7d5-87fb-4218-a21b-a126ebe7f93f', 'icon-magnet', 'icon-magnet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1098, '50f67646-c577-430e-9007-9cc915331422', 'icon-mail-bulk', 'icon-mail-bulk', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1099, '1dc3bbdc-4bd3-41c1-b9da-bbd530f16bed', 'icon-male', 'icon-male', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1100, 'f7923a5a-fb23-4024-8ee4-99e28b37d43a', 'icon-map-marked-alt', 'icon-map-marked-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1101, '7d568b1f-ec35-41bd-97ab-790a074a1a36', 'icon-map-marked', 'icon-map-marked', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1102, 'e6cddd6b-37a5-49fb-9a7e-b562eaeea18e', 'icon-map-marker-alt', 'icon-map-marker-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1103, '94085766-91db-45e7-8400-54840a528c3b', 'icon-map-marker', 'icon-map-marker', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1104, 'c8e05466-2057-4f26-a00b-c1c7ec0c5589', 'icon-map-pin', 'icon-map-pin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1105, '38dea239-f621-40f0-912e-f972d2bb1fd8', 'icon-map-signs', 'icon-map-signs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1106, '0f5ac96a-520b-48e4-950b-22a2616c138c', 'icon-map', 'icon-map', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1107, 'd537d9fb-1750-419c-96d3-3f034b7737e5', 'icon-marker', 'icon-marker', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1108, '234acb8b-d91d-475f-aded-a425d78f1085', 'icon-mars-double', 'icon-mars-double', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1109, '0a885bee-6820-4c86-a856-4df5bb7442e6', 'icon-mars-stroke-h', 'icon-mars-stroke-h', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1110, '5b552fb2-ec63-49c5-b3b1-d99f023ab667', 'icon-mars-stroke-v', 'icon-mars-stroke-v', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1111, '74271c93-17ae-41c8-b772-5f6dcfc10ce0', 'icon-mars-stroke', 'icon-mars-stroke', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1112, 'eb671075-da23-4a5e-8467-46d4125a9a2f', 'icon-mars', 'icon-mars', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1113, '41318ca6-ecb5-468f-905d-bbcadc3c0191', 'icon-medal', 'icon-medal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1114, '1ac69b0d-6add-4d2d-bf8b-3cc0c81544a4', 'icon-medkit', 'icon-medkit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1115, '428b60d0-876c-4e05-add6-fde694a991e8', 'icon-meh-blank', 'icon-meh-blank', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1116, '36ddc3b7-259e-4706-a153-2a7d108e0525', 'icon-meh-rolling-eyes', 'icon-meh-rolling-eyes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1117, 'd9cb4b87-18fe-49e8-b2c5-5e1c77c2aa9c', 'icon-meh', 'icon-meh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1118, '75471210-f0f2-428f-8400-b824d3ed07e8', 'icon-memory', 'icon-memory', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1119, '81fb9a6a-482d-495a-9e9e-bf4793bf9188', 'icon-menorah', 'icon-menorah', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1120, '4dd95b96-8ac6-49ac-ae05-914b04d71769', 'icon-mercury', 'icon-mercury', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1121, '94f41fbd-4132-4796-a2db-31c7bec56cab', 'icon-microchip', 'icon-microchip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1122, '5b4e1ec2-1bd2-4a8d-b678-5173d926a215', 'icon-microphone-alt-slash', 'icon-microphone-alt-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1123, 'e64ebef5-f626-4976-8280-66c66eb1ba94', 'icon-microphone-alt', 'icon-microphone-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1124, 'a05f91a7-af6b-4009-a6da-17f3243acd9e', 'icon-microphone-slash', 'icon-microphone-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1125, '7102d225-5117-470b-b0ca-2012d89e048b', 'icon-microphone', 'icon-microphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1126, 'f8783490-4cb6-4404-a906-a6a1eb9d6f48', 'icon-microscope', 'icon-microscope', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1127, '40f2b00b-5286-45d5-945c-facecaf7b1a6', 'icon-minus-circle', 'icon-minus-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1128, '53619443-1795-47eb-8054-3ea70f1a5016', 'icon-minus-square', 'icon-minus-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1129, '21e78ca9-cd33-4060-80cd-08dc90921ad3', 'icon-minus', 'icon-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1130, '6d0247df-c545-4aaf-8951-883741672822', 'icon-mobile-alt', 'icon-mobile-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1131, 'a333f5c8-82a5-4b78-9ea6-a23324b6a153', 'icon-mobile', 'icon-mobile', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1132, 'd114b2e9-d1b5-489e-9e78-00528cb3726a', 'icon-money-bill-alt', 'icon-money-bill-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1133, '9dc07090-e690-4897-afb9-4617f6254831', 'icon-money-bill-wave-alt', 'icon-money-bill-wave-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1134, '74770f19-122d-434e-98da-862d74067d4a', 'icon-money-bill-wave', 'icon-money-bill-wave', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1135, 'd1b1b6da-ac3f-48cb-a70a-3a4ab40c0537', 'icon-money-bill', 'icon-money-bill', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1136, '10f6b2ad-1caf-40d0-b716-510f152c6acb', 'icon-money-check-alt', 'icon-money-check-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1137, '4c3499b4-5385-4518-9e6d-a6e0de6444e2', 'icon-money-check', 'icon-money-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1138, '865593b5-f0b3-42a7-a547-27e470b2e9ff', 'icon-monument', 'icon-monument', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1139, '499c6c64-640c-4c5d-9a80-b5ed2e2e577c', 'icon-moon', 'icon-moon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1140, '8e1a13ec-fa35-40e8-9227-4e21746dc6c2', 'icon-mortar-pestle', 'icon-mortar-pestle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1141, 'a95c7555-7dd5-47f8-9beb-559720e35808', 'icon-mosque', 'icon-mosque', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1142, '11a3c788-b081-4e84-a4a8-e5a20dfd97d2', 'icon-motorcycle', 'icon-motorcycle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1143, '44a1039b-293e-401d-a7dc-5921d7fcf9d2', 'icon-mouse-pointer', 'icon-mouse-pointer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1144, '23905ffe-11fb-4ae6-a3bf-42ab644cf2e4', 'icon-music', 'icon-music', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1145, '107dafba-cd3d-419a-a4c0-5cfaa5e244fb', 'icon-neuter', 'icon-neuter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1146, '88efd096-27bb-4e1f-bff7-dabac0f3e0e4', 'icon-newspaper', 'icon-newspaper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1147, '8c4c1eb5-29b3-490f-a303-5ae4711e6e3e', 'icon-not-equal', 'icon-not-equal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1148, '7341bf45-8be0-4a4b-abe3-b349116f3853', 'icon-notes-medical', 'icon-notes-medical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1149, 'cd291bf8-7512-4ff5-8cf1-49ecf6204a23', 'icon-object-group', 'icon-object-group', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1150, '71a13f67-f653-4f62-b196-fc8e17848a4b', 'icon-object-ungroup', 'icon-object-ungroup', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1151, '1f617957-9e1e-4d60-ab73-6cba03a14e21', 'icon-oil-can', 'icon-oil-can', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1152, '05233ec5-4ce6-4eb8-9a64-9881019cafdd', 'icon-om', 'icon-om', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1153, '3d0a0c8c-f290-4b79-9d6c-cc4ee0d4b184', 'icon-outdent', 'icon-outdent', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1154, '9be18449-455c-44d2-bfb5-fa9976fc8361', 'icon-paint-brush', 'icon-paint-brush', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1155, '764ae7b6-d255-40c1-ac2d-4d120ac39255', 'icon-paint-roller', 'icon-paint-roller', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1156, '5374b40c-ff8b-4981-a6bb-c5d917e484fb', 'icon-palette', 'icon-palette', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1157, '94485615-6123-4cc8-a5f5-894d32a13cb9', 'icon-pallet', 'icon-pallet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1158, '9056cfd0-6084-4257-8379-61a4bc6d4c14', 'icon-paper-plane', 'icon-paper-plane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1159, '16f1cbf4-cc19-43dc-ae75-be4df8cf9f98', 'icon-paperclip', 'icon-paperclip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1160, 'fbc17f62-d16c-43bf-8bfc-bb967fc2f20f', 'icon-parachute-box', 'icon-parachute-box', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1161, '16ce3463-e5fc-4477-9916-b915a7d82c18', 'icon-paragraph', 'icon-paragraph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1162, '79636e7d-a46b-4003-97d7-da0e8ba24407', 'icon-parking', 'icon-parking', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1163, '161a691f-9763-4e38-9993-c4b61d200ac5', 'icon-passport', 'icon-passport', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1164, 'aced7788-d887-4f1d-a8be-7501ad41bb53', 'icon-pastafarianism', 'icon-pastafarianism', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1165, '309534b2-f336-4547-96a3-c53006b2e026', 'icon-paste', 'icon-paste', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1166, 'e178b9a0-2139-4536-b663-6b535314da77', 'icon-pause-circle', 'icon-pause-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1167, 'abcb51a2-6a64-4441-9289-894a7781c8fe', 'icon-pause', 'icon-pause', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1168, '531f5f22-9c9e-4a21-ba97-3ff988059025', 'icon-paw', 'icon-paw', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1169, '65eb5e2c-da51-4986-8e99-a38ce78c7b34', 'icon-peace', 'icon-peace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1170, 'bb4d93a4-3d45-4eeb-902c-2ae19be92d45', 'icon-pen-alt', 'icon-pen-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1171, 'ede33c7d-dbdd-460c-bff3-e444fdb9e79b', 'icon-pen-fancy', 'icon-pen-fancy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1172, '1e3e92f7-8036-44bb-9c50-da90e58cfd34', 'icon-pen-nib', 'icon-pen-nib', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1173, 'ec19459f-8312-4954-ac9a-6a642dbd7a3d', 'icon-pen-square', 'icon-pen-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1174, '71248cfb-d674-43d2-a547-1c2d6cea70c3', 'icon-pen', 'icon-pen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1175, 'cc8fb128-2e3e-458f-a9a2-c8b7d9596c88', 'icon-pencil-alt', 'icon-pencil-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1176, 'de8f9b83-cae6-403a-b75c-f136de67a20b', 'icon-pencil-ruler', 'icon-pencil-ruler', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1177, '09cf76d5-2825-4ef1-830a-d21ada471e4b', 'icon-people-carry', 'icon-people-carry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1178, '5274506e-610b-4726-bbc6-416ae05a8eb1', 'icon-percent', 'icon-percent', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1179, '26f0253c-9fa3-4a08-bb73-db8b91cbfbbe', 'icon-percentage', 'icon-percentage', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1180, '41b1b6ce-12e9-4e6e-a360-ec70d036deee', 'icon-phone-slash', 'icon-phone-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1181, '93619001-267b-4e71-82bd-51cd57f08a99', 'icon-phone-square', 'icon-phone-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1182, 'a1497495-21fa-4711-a6ce-14a0ba527bcf', 'icon-phone-volume', 'icon-phone-volume', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1183, 'bb967a17-eba6-430f-b4d8-0a56c896c6b4', 'icon-phone', 'icon-phone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1184, '71b66657-b76c-4709-b076-d44ded34da70', 'icon-piggy-bank', 'icon-piggy-bank', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1185, '9d4e82a1-fd1c-4f6d-aef7-ba7fce5af69a', 'icon-pills', 'icon-pills', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1186, '0510d12b-823c-4a26-8757-9c544e5af035', 'icon-place-of-worship', 'icon-place-of-worship', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1187, '88d35448-7c51-4105-bb9d-b88b8a8efe0b', 'icon-plane-arrival', 'icon-plane-arrival', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1188, 'd5e11c89-f531-4bcf-964e-16071822e406', 'icon-plane-departure', 'icon-plane-departure', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1189, '0c032476-8e47-45d8-8d00-0d9f0b9e7b14', 'icon-plane', 'icon-plane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1190, 'b881cd49-d45e-4726-b24c-76f882cdc1b0', 'icon-play-circle', 'icon-play-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1191, 'f82e29c6-bd9e-46f5-b56e-57de97c67363', 'icon-play', 'icon-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1192, '8ee3712f-079a-48c2-8285-f5632064883f', 'icon-plug', 'icon-plug', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1193, 'fb7b4f62-bc36-4b33-9b3a-4a78fa2f846b', 'icon-plus-circle', 'icon-plus-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1194, '50aa438f-a2b9-4053-8060-1db6641ed3fb', 'icon-plus-square', 'icon-plus-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1195, 'f7f65db6-151d-480c-b8ed-3cce5e7b196d', 'icon-plus', 'icon-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1196, 'f3b00e24-cdb0-43d6-8544-31d8ab46b8aa', 'icon-podcast', 'icon-podcast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1197, '72a59fc8-fec6-4c9e-a967-2325a9ef3b62', 'icon-poll-h', 'icon-poll-h', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1198, '7553c735-8a56-4273-bf5d-81205eaa7c2a', 'icon-poll', 'icon-poll', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1199, '02a09bc9-315b-4443-948b-59ffee4c2d2e', 'icon-poo', 'icon-poo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1200, '0b141cf9-0598-4319-b083-719925d711bc', 'icon-poop', 'icon-poop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1201, '8b9a979c-2e24-47f5-a812-d2cf3625d167', 'icon-portrait', 'icon-portrait', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1202, '6e32f86e-0972-4ef5-a051-c6df950bda5c', 'icon-pound-sign', 'icon-pound-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1203, 'e703c0a2-88ad-48ac-81e4-34f91eee4b7f', 'icon-power-off', 'icon-power-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1204, 'bd07dc36-37be-425c-847f-6cccd3ce1f94', 'icon-pray', 'icon-pray', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1205, 'f69453ba-80a3-462c-8053-e98aa9705dae', 'icon-praying-hands', 'icon-praying-hands', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1206, '178a0207-05b4-40c0-9d2b-a3220626aaec', 'icon-prescription-bottle-alt', 'icon-prescription-bottle-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1207, 'f86e51e6-49c9-40a5-be21-f801c8307dd2', 'icon-prescription-bottle', 'icon-prescription-bottle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1208, 'af7e21e0-6ec4-4ae1-8186-3102cdd93a47', 'icon-prescription', 'icon-prescription', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1209, '57b6de67-f17a-4761-9564-42a3d8953b99', 'icon-print', 'icon-print', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1210, '402d6c71-fd30-4e74-87d0-988109cedbf0', 'icon-procedures', 'icon-procedures', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1211, '7a3e7af1-d535-4793-87e8-c27d62e161bc', 'icon-project-diagram', 'icon-project-diagram', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1212, 'd99b0030-7699-4c6d-8b17-a14666b3d2ec', 'icon-puzzle-piece', 'icon-puzzle-piece', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1213, '2c66b843-5078-4b80-95d8-6aaefea693d7', 'icon-qrcode', 'icon-qrcode', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1214, '9c451261-b034-45cc-90f2-7200ca384f4b', 'icon-question-circle', 'icon-question-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1215, 'e706c1da-e14e-4c29-8d57-500e4c949507', 'icon-question', 'icon-question', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1216, '2ecac731-310d-4368-8d98-0627b4c1f0bd', 'icon-quidditch', 'icon-quidditch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1217, '8e5e62cb-0bea-4f9f-abde-2beae647cc5b', 'icon-quote-left', 'icon-quote-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1218, '975b98c6-c07f-45bf-8e09-848cb374c232', 'icon-quote-right', 'icon-quote-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1219, '6a40d69a-226c-412c-a5cc-6d45d43bc302', 'icon-quran', 'icon-quran', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1220, 'fcbd234c-0e7c-4bf4-8e9c-b310d24f98fc', 'icon-random', 'icon-random', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1221, '52d73b81-7ac6-4c9c-92eb-cb01cb7fbdfd', 'icon-receipt', 'icon-receipt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1222, '8a3772fa-5e18-47c1-8d35-3ff2fa57a3bf', 'icon-recycle', 'icon-recycle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1223, '18fec327-ba31-4431-823f-4105d0d0de06', 'icon-redo-alt', 'icon-redo-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1224, '6174f855-096a-46d5-943f-f19472ef2234', 'icon-redo', 'icon-redo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1225, 'cb7ced1f-21ed-4c48-bdd3-30221b5e7595', 'icon-registered', 'icon-registered', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1226, 'd637b01b-1c4a-4fda-abd2-16edc572c174', 'icon-reply-all', 'icon-reply-all', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1227, '6760d52f-38f9-4ae0-ab7d-b1a68f4c15db', 'icon-reply', 'icon-reply', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1228, 'd834a4f0-2ed7-440f-94b8-7e5005606ea7', 'icon-retweet', 'icon-retweet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1229, '7dd20dad-a38d-443b-bda6-35d962cf6378', 'icon-ribbon', 'icon-ribbon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1230, '57afda83-5c7a-42ab-8559-98e663a9005e', 'icon-road', 'icon-road', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1231, '5dd4089b-c83c-477b-ade5-936d2da99a04', 'icon-robot', 'icon-robot', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1232, 'd07d2b9d-e2ec-4483-b66c-f8421891453f', 'icon-rocket', 'icon-rocket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1233, 'd5661fb9-5b3b-478d-ac2a-64db77277965', 'icon-route', 'icon-route', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1234, '0283c632-d9b3-4dac-a032-c3b2f3d3753f', 'icon-rss-square', 'icon-rss-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1235, 'debef5ea-8653-4e39-bd9b-f966b9584d1f', 'icon-rss', 'icon-rss', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1236, 'b48550dd-1dc6-4def-a681-95a8224c15a2', 'icon-ruble-sign', 'icon-ruble-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1237, '5503494c-cbd1-4623-b708-ef9169e44ad6', 'icon-ruler-combined', 'icon-ruler-combined', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1238, '2a27c357-27fd-45dc-a386-fb2fe4c49ce9', 'icon-ruler-horizontal', 'icon-ruler-horizontal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1239, 'cfe08bf8-87a8-4d15-86f0-bf70590de442', 'icon-ruler-vertical', 'icon-ruler-vertical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1240, 'c44acca9-b725-43ff-adef-c17fc590f2e3', 'icon-ruler', 'icon-ruler', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1241, '087855c3-c125-431c-a23b-b2a2e25cc96b', 'icon-rupee-sign', 'icon-rupee-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1242, 'f379c934-99a8-47bd-8950-68f0e04ca931', 'icon-sad-cry', 'icon-sad-cry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1243, 'cd938d01-c0b5-498a-97fd-e8dab4bfa999', 'icon-sad-tear', 'icon-sad-tear', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1244, '0331aa16-de3f-4973-8182-067ce6f462d7', 'icon-save', 'icon-save', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1245, '38bb90a8-01b5-4c9a-b00c-c943b7331d6d', 'icon-school', 'icon-school', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1246, '0339ccf1-1618-4fdb-bf0f-dad59204b466', 'icon-screwdriver', 'icon-screwdriver', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1247, 'c088ff6c-e33d-4a99-9e62-5af94d2c0df5', 'icon-search-dollar', 'icon-search-dollar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1248, '95e49402-b93b-446a-b25f-df98d8922224', 'icon-search-location', 'icon-search-location', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1249, '4bc5d000-0e04-48a9-9cfc-a13e8df8f2da', 'icon-search-minus', 'icon-search-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1250, '736e98ac-4512-436f-99dd-09307eeca69f', 'icon-search-plus', 'icon-search-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1251, '37cf67ef-7c12-4427-8fe1-f989d057702e', 'icon-search', 'icon-search', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1252, 'e81cfaaf-d8c1-46e1-95a7-e2777ec6d75e', 'icon-seedling', 'icon-seedling', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1253, '0d79f744-7bd9-4842-a75a-ed877f4ff302', 'icon-server', 'icon-server', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1254, 'ae1d4a1a-30cc-4f20-abb1-26daa0d73753', 'icon-shapes', 'icon-shapes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1255, '8896f2db-afe1-4ab9-8343-a669f9c63f0d', 'icon-share-alt-square', 'icon-share-alt-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1256, '9db60940-e3ea-475e-9e4b-4ab18a88e269', 'icon-share-alt', 'icon-share-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1257, '6fbb548e-9c63-4ba0-bbc8-0fcf1127d6b8', 'icon-share-square', 'icon-share-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1258, 'db4e8c1f-0290-47c5-b9bf-bc67cc766f30', 'icon-share', 'icon-share', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1259, 'd76ee79d-6503-422e-bd17-ef0a7d93725e', 'icon-shekel-sign', 'icon-shekel-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1260, 'b41d62b6-ef83-4042-88cc-8f854abdb683', 'icon-shield-alt', 'icon-shield-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1261, '42de36b5-34af-4fd6-b735-b5bf480c54d0', 'icon-ship', 'icon-ship', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1262, 'b5682260-8409-4c9b-85a2-c136413c380c', 'icon-shipping-fast', 'icon-shipping-fast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1263, '2007b860-2a7c-43d6-ab80-2686bd6c8462', 'icon-shoe-prints', 'icon-shoe-prints', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1264, 'eccd1a73-be8f-43d5-8604-1848166860e6', 'icon-shopping-bag', 'icon-shopping-bag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1265, '7c2cff6d-9482-4a48-92f3-edd892f9941d', 'icon-shopping-basket', 'icon-shopping-basket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1266, 'a9af1f8d-33c9-4a4e-ade7-4555a5258fca', 'icon-shopping-cart1', 'icon-shopping-cart1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1267, '377f70c3-ee22-4bbb-9c6a-9e2e4721ec26', 'icon-shower', 'icon-shower', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1268, 'b511b8d3-0e61-4471-83f2-4c0a45a0b1e5', 'icon-shuttle-van', 'icon-shuttle-van', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1269, 'd9f0e17d-fc02-4d39-bd42-93d414e002ab', 'icon-sign-in-alt', 'icon-sign-in-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1270, 'fc17998a-99c5-4daf-8e18-4d8b4aa8e23b', 'icon-sign-language', 'icon-sign-language', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1271, '3c651dc2-9b7a-42ee-afa0-7798d26f6a3c', 'icon-sign-out-alt', 'icon-sign-out-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1272, '48cd8901-d12d-45d0-aba1-5673de17379e', 'icon-sign', 'icon-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1273, '798852a7-361d-4770-b366-cce055a1ea81', 'icon-signal', 'icon-signal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1274, '2dd41bf5-2123-477f-ad11-b0ca5dc4e4e0', 'icon-signature', 'icon-signature', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1275, 'd4b1bc10-86ed-4122-9226-345e33566433', 'icon-sitemap', 'icon-sitemap', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1276, '59ddf215-df9c-43c1-af74-c44e4311b722', 'icon-skull', 'icon-skull', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1277, 'efee9ade-4cf3-4ddd-ad26-407bef31863e', 'icon-sliders-h', 'icon-sliders-h', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1278, 'ae9213e4-5907-4292-b0ad-20e5db659c7a', 'icon-smile-beam', 'icon-smile-beam', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1279, '5d5764a8-1c7d-4c7c-92a8-6515d722cadc', 'icon-smile-wink', 'icon-smile-wink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1280, '45027568-eff6-4b23-91ab-07aa8222db22', 'icon-smile', 'icon-smile', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1281, '5b4c89d0-fcbd-47c8-8d27-ae25683768af', 'icon-smoking-ban', 'icon-smoking-ban', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1282, '8e0e9c78-482d-4888-b886-bd89345ab6f4', 'icon-smoking', 'icon-smoking', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1283, 'af7e3618-b1d6-4339-9e43-ca90e608313e', 'icon-snowflake', 'icon-snowflake', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1284, 'f6543ddf-25a8-41d8-96bb-e003932ae280', 'icon-socks', 'icon-socks', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1285, 'f7b25e43-6433-4171-9b34-becb53b2f464', 'icon-solar-panel', 'icon-solar-panel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1286, '4159e212-5e4e-46aa-9ede-18517541d957', 'icon-sort-alpha-down', 'icon-sort-alpha-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1287, '01424999-1e92-4024-9ddc-deda34c44cf9', 'icon-sort-alpha-up', 'icon-sort-alpha-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1288, '65776ec4-d4c2-403a-af18-1d281ab7e2f5', 'icon-sort-amount-down', 'icon-sort-amount-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1289, 'a5a35e73-c9de-48a8-91cb-eda95b70b5d2', 'icon-sort-amount-up', 'icon-sort-amount-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1290, 'd97d2f77-fc77-4911-99cb-ae35453d7d47', 'icon-sort-down', 'icon-sort-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1291, '46d894f9-6543-471f-bf8a-f6eaa8903a0f', 'icon-sort-numeric-down', 'icon-sort-numeric-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1292, '001b8156-0646-49fe-ba0e-a152036f9c82', 'icon-sort-numeric-up', 'icon-sort-numeric-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1293, '49ae3f49-c9c2-42ad-ba48-eca0281bf1ae', 'icon-sort-up', 'icon-sort-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1294, '1d94ad86-5904-485c-9259-4b120ef29688', 'icon-sort', 'icon-sort', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1295, '12ededc3-1779-4000-a724-3191af9e9b08', 'icon-spa', 'icon-spa', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1296, 'fca0c763-8045-48f9-a126-4f05956fb7d7', 'icon-space-shuttle', 'icon-space-shuttle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1297, '025a2ca3-daac-42e3-af86-45a2cf67cd08', 'icon-spinner', 'icon-spinner', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1298, '73409dbf-687d-4077-99dd-834dd3c96406', 'icon-splotch', 'icon-splotch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1299, '5d852d69-2582-4238-bc86-573ad8bb2de4', 'icon-spray-can', 'icon-spray-can', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1300, '21f5ff72-d912-4e14-8487-16be6bbaa3eb', 'icon-square-full', 'icon-square-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1301, '919c191b-b051-4753-9108-82e6eab988c9', 'icon-square-root-alt', 'icon-square-root-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1302, '54ee8378-4a94-4f51-857f-a2d3fa94c3f2', 'icon-square', 'icon-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1303, '1fd7a07b-f108-4a3a-b605-bf8d67be8618', 'icon-stamp', 'icon-stamp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1304, 'ffebf63f-7fc7-4b10-87fb-feddf6ce1aea', 'icon-star-and-crescent', 'icon-star-and-crescent', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1305, '084b0688-a222-43a7-a70e-95e61b26c4f6', 'icon-star-half-alt', 'icon-star-half-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1306, '590008b7-7648-4489-84f3-e443d27b85d9', 'icon-star-half', 'icon-star-half', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1307, '5a70e388-7503-47ba-b14b-90ed12964f88', 'icon-star-of-david', 'icon-star-of-david', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1308, '98af62a7-8a66-4fb9-92e3-90190a97fe61', 'icon-star-of-life', 'icon-star-of-life', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1309, 'e4b00a2c-15bb-4af8-a5da-5b3fb81ce3a6', 'icon-star', 'icon-star', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1310, '1136844a-2d52-4ce2-a284-1fa8e3e7eb89', 'icon-step-backward', 'icon-step-backward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1311, '8dd7d99e-e65e-47bf-9538-6280d61268df', 'icon-step-forward', 'icon-step-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1312, 'c41af4d0-863b-4221-ab5b-6244daabf80b', 'icon-stethoscope', 'icon-stethoscope', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1313, '85e5788c-3fd1-4990-88d4-80d12a43e617', 'icon-sticky-note', 'icon-sticky-note', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1314, '68e24c3c-2165-4a56-89f1-865f43c58481', 'icon-stop-circle', 'icon-stop-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1315, '058b6a2f-9acd-4a2f-90aa-b38cacc4d4ac', 'icon-stop', 'icon-stop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1316, '7b556901-1b97-4112-9ce5-b028f4f77170', 'icon-stopwatch', 'icon-stopwatch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1317, 'ed7ffebf-04fa-48f4-8c20-0f9fabd886a8', 'icon-store-alt', 'icon-store-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1318, 'a56f6a04-ee5e-4aa5-96f6-aa6641b2fb76', 'icon-store', 'icon-store', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1319, '82374b9a-28be-42a3-9d73-de5cdbbdd33d', 'icon-stream', 'icon-stream', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1320, '1def1b69-0625-4eaf-97ef-446600b606da', 'icon-street-view', 'icon-street-view', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1321, '9e4439e0-4f97-4d11-b4ff-f4cebc47da11', 'icon-strikethrough', 'icon-strikethrough', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1322, 'ce3ec8df-d566-496d-8bea-d36c591a7829', 'icon-stroopwafel', 'icon-stroopwafel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1323, 'b55ba2a6-0321-4a6d-a791-99391de9232a', 'icon-subscript', 'icon-subscript', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1324, '77fcdcfb-06e1-45ed-92de-9ab81589f379', 'icon-subway', 'icon-subway', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1325, '11fb3f7b-96f4-45e1-944b-2e94de405bc3', 'icon-suitcase-rolling', 'icon-suitcase-rolling', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1326, 'cdbcddae-b0d0-4350-b669-1ddb2440ff5b', 'icon-suitcase', 'icon-suitcase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1327, 'ad00a09c-a0c0-40c9-a616-87412e468b34', 'icon-sun', 'icon-sun', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1328, '8d5fc82b-29b3-43e7-b4c3-1d1d136f26d6', 'icon-superscript', 'icon-superscript', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1329, '2f496252-8e55-4b1d-b92e-7dbc33f631b7', 'icon-surprise', 'icon-surprise', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1330, '7d9b5cef-c5a3-4e72-a027-197ee5c0834d', 'icon-swatchbook', 'icon-swatchbook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1331, '3a52afc7-080f-422a-8335-ddf4d6e28c0c', 'icon-swimmer', 'icon-swimmer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1332, '485502e7-cde1-4f3a-89e5-83df46a4829c', 'icon-swimming-pool', 'icon-swimming-pool', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1333, '5cb6296a-b519-4b7b-b2e4-c8513a44f8d8', 'icon-synagogue', 'icon-synagogue', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1334, '62759a93-4a05-417a-a702-17e97ff15061', 'icon-sync-alt', 'icon-sync-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1335, 'af159462-5a4c-4ef6-9b1f-b2f0046c756b', 'icon-sync', 'icon-sync', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1336, 'e2225c31-66f3-4de3-a29b-295511b120e0', 'icon-syringe', 'icon-syringe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1337, 'ee8e8324-2fcd-40cd-8c14-4f6416f5e0d3', 'icon-table-tennis', 'icon-table-tennis', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1338, '46dadfd1-0670-411b-806b-55901fab96c2', 'icon-table', 'icon-table', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1339, '6cabd296-ed6e-4156-b407-d411972d5280', 'icon-tablet-alt', 'icon-tablet-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1340, '98160a8b-fe99-4ef9-bc58-859803a3a381', 'icon-tablet', 'icon-tablet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1341, '0379b545-9b27-4fe8-8205-97703c278e32', 'icon-tablets', 'icon-tablets', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1342, '7ea5c50c-a4a3-4103-a909-c380e055f32b', 'icon-tachometer-alt', 'icon-tachometer-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1343, '6db5052c-1ab9-4750-b834-0a8523f5bf52', 'icon-tag', 'icon-tag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1344, '95d58bbf-66a1-4dcc-a102-95e10499c0da', 'icon-tags', 'icon-tags', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1345, '656ce16a-85b1-444c-90ad-75a68d8f1bc5', 'icon-tape', 'icon-tape', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1346, 'd92ebf26-4f5e-480a-9bb8-deae814b1201', 'icon-tasks', 'icon-tasks', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1347, '9a1d162d-bfaf-474c-8fc2-84955fa6859a', 'icon-taxi', 'icon-taxi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1348, '09c83742-b8f7-46f2-a050-5a2b46cb6843', 'icon-teeth-open', 'icon-teeth-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1349, 'da498413-303d-46a0-9711-6e8fb917e31a', 'icon-teeth', 'icon-teeth', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1350, '19db2336-9e88-46d9-8c1a-3575f6cb32bf', 'icon-terminal', 'icon-terminal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1351, '277840b8-e365-43f7-b33d-05d93ae45945', 'icon-text-height', 'icon-text-height', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1352, '59487559-130c-4b97-b782-4d3826feb314', 'icon-text-width', 'icon-text-width', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1353, '4a76a5f7-f490-44f0-8bdc-4c6cf3bb5418', 'icon-th-large', 'icon-th-large', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1354, '5a505372-785c-4756-8a92-fbf87d2de33c', 'icon-th-list', 'icon-th-list', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1355, 'bca7d8d5-cbb9-447e-ad31-ddbb3e4ef94d', 'icon-th', 'icon-th', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1356, '6993d262-0288-4c74-87b5-63a8d9a9423a', 'icon-theater-masks', 'icon-theater-masks', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1357, '17033553-e4b0-4645-b01d-7a5aecb061d5', 'icon-thermometer-empty', 'icon-thermometer-empty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1358, 'd88e3325-4384-4266-9c36-f641d96f2bcb', 'icon-thermometer-full', 'icon-thermometer-full', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1359, 'fe29bd71-b7d1-41df-8a42-2f4fe0f6b08c', 'icon-thermometer-half', 'icon-thermometer-half', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1360, '2453abd9-16f6-49f7-aabf-fbd6992eb8cb', 'icon-thermometer-quarter', 'icon-thermometer-quarter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1361, '0819ef19-2444-42b1-8bc8-a6ee75da8243', 'icon-thermometer-three-quarters', 'icon-thermometer-three-quarters', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1362, 'aed1e4c3-2496-4dbd-bbec-70d3c07c09e4', 'icon-thermometer', 'icon-thermometer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1363, 'a5327a2d-e996-41a7-bb14-9a606f3e3c1d', 'icon-thumbs-down', 'icon-thumbs-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1364, '1f703396-6812-408c-b44c-728e3ce545c6', 'icon-thumbs-up', 'icon-thumbs-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1365, 'b31d38a4-3303-4edd-b308-333f2170d641', 'icon-thumbtack', 'icon-thumbtack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1366, '724889f3-da2e-4278-9306-005f5646c6f1', 'icon-ticket-alt', 'icon-ticket-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1367, '6eef55da-7e2d-4557-8e76-afc9677c36f9', 'icon-times-circle', 'icon-times-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1368, '412b81c7-30df-4ac9-95ef-9d0d0a9a3233', 'icon-times', 'icon-times', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1369, 'a99df1a0-3229-444c-9f7e-7fa6a71ef663', 'icon-tint-slash', 'icon-tint-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1370, '67790589-7064-4953-83c5-429a38903b0b', 'icon-tint', 'icon-tint', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1371, '60e7b1f4-613c-4754-be20-c5b8ac060e47', 'icon-tired', 'icon-tired', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1372, 'dfb43ab5-7a22-4fd4-bedb-4763c6236428', 'icon-toggle-off', 'icon-toggle-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1373, '34ae2d16-49eb-4da6-91af-bf81cbe9268b', 'icon-toggle-on', 'icon-toggle-on', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1374, '67a67ba2-8e41-422e-86c3-227b9a34c5d8', 'icon-toolbox', 'icon-toolbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1375, 'f6afb6bf-4ce8-4487-9cb1-e9232b53c1a5', 'icon-tooth', 'icon-tooth', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1376, '5b345492-5f89-4e25-a7cc-50ecd8f41bad', 'icon-torah', 'icon-torah', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1377, 'd1a5a4ff-6b6f-4dbb-9cb3-79b06f91f132', 'icon-torii-gate', 'icon-torii-gate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1378, '93c35ecd-298b-4ff4-a9db-f167fe4aa262', 'icon-trademark', 'icon-trademark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1379, '7d2b0378-90ac-4b37-8d4b-2cddffc42906', 'icon-traffic-light', 'icon-traffic-light', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1380, '292a250a-e1df-48f8-a5a2-ba2102c2595d', 'icon-train', 'icon-train', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1381, '6e20e853-bc1d-4a2b-af33-f76b1038685d', 'icon-transgender-alt', 'icon-transgender-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1382, '10a46f20-cf93-49a9-b405-0bf27ff84d2e', 'icon-transgender', 'icon-transgender', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1383, 'caf0065e-2d79-4090-944f-e65966c15e23', 'icon-trash-alt', 'icon-trash-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1384, '60fc99aa-fa1c-4902-9161-59debaecaf03', 'icon-trash', 'icon-trash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1385, '808be5e1-7700-4af9-9d5a-68a85dbd875f', 'icon-tree', 'icon-tree', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1386, 'dc6cff6d-a56e-4cd0-97b5-d0d668ce27f5', 'icon-trophy', 'icon-trophy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1387, '59c488ed-ac53-4127-92a1-740c5afa695f', 'icon-truck-loading', 'icon-truck-loading', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1388, '9fb0cc46-4bff-407a-96d4-ec1ff53c4c77', 'icon-truck-monster', 'icon-truck-monster', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1389, '280e32b2-0120-45c0-87b7-2cc6175aa41b', 'icon-truck-moving', 'icon-truck-moving', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1390, 'cf3924b0-87de-4599-9d1b-b43266b19505', 'icon-truck-pickup', 'icon-truck-pickup', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1391, '1e2fdbfa-42f6-4ce9-be97-d48d4e9518d0', 'icon-truck', 'icon-truck', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1392, 'd81fa81f-4c0a-48f5-abe0-f04a76ab4867', 'icon-tshirt', 'icon-tshirt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1393, '8a6e61e8-14b4-4ea5-a3bb-306d4328ddaa', 'icon-tty', 'icon-tty', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1394, 'b03bd43d-c46c-439a-b1aa-40c5ef6f2d08', 'icon-tv', 'icon-tv', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1395, '331aeded-3b26-4437-8131-abc0d68461fe', 'icon-umbrella-beach', 'icon-umbrella-beach', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1396, '32b0b89e-cb94-4a45-9d81-7c1717a54466', 'icon-umbrella', 'icon-umbrella', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1397, 'ef6889fd-6530-4b0e-bf68-0c59eb8b1dfa', 'icon-underline', 'icon-underline', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1398, '2497b1e4-5270-40c9-ab91-87a776a2d1e9', 'icon-undo-alt', 'icon-undo-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1399, '05581c97-3420-4fec-8ad0-2b0ea6097592', 'icon-undo', 'icon-undo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1400, '8db88f0e-d544-4c9a-92f5-d07d03058b57', 'icon-universal-access', 'icon-universal-access', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1401, 'b25acd60-9949-4845-816a-457401dd772a', 'icon-university', 'icon-university', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1402, '0c69fd1a-ecc0-452b-9fa8-26441a2085f7', 'icon-unlink', 'icon-unlink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1403, '1a6e1688-0849-4bb2-9db6-c00883540c31', 'icon-unlock-alt', 'icon-unlock-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1404, '6aa96bfd-b956-4069-9b60-173e45e66475', 'icon-unlock', 'icon-unlock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1405, 'b46a1bef-b0d4-46d1-9409-0ae4e6734399', 'icon-upload', 'icon-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1406, '75b534c5-9153-4014-ad5a-9731480306c4', 'icon-user-alt-slash', 'icon-user-alt-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1407, 'afc62e32-8ff9-4705-9651-c450bbf710ee', 'icon-user-alt', 'icon-user-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1408, '76421c83-64c9-430d-addf-a320eea255b0', 'icon-user-astronaut', 'icon-user-astronaut', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1409, 'b7730dfc-950d-48ed-8894-d0e09f71cc12', 'icon-user-check', 'icon-user-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1410, '7d027b91-82cb-4066-a5a6-742b3bfe7037', 'icon-user-circle', 'icon-user-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1411, 'c0b3a2e2-da01-44bf-99c2-51ac44307bf7', 'icon-user-clock', 'icon-user-clock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1412, '29d68fd1-bc45-4824-a30a-e30beb22cb02', 'icon-user-cog', 'icon-user-cog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1413, '0a4fb28d-a8bf-40fa-a0da-8252221da494', 'icon-user-edit', 'icon-user-edit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1414, '85739403-b2b6-4e57-b34a-083bf00dc53b', 'icon-user-friends', 'icon-user-friends', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1415, '8b56f003-2b75-46b7-bbd5-c14755adcfa6', 'icon-user-graduate', 'icon-user-graduate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1416, '252955cd-a63d-4434-9367-dd0d54815708', 'icon-user-lock', 'icon-user-lock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1417, '2881996a-af76-41e1-8c63-c5f18f0d5cee', 'icon-user-md', 'icon-user-md', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1418, 'ba4b3c88-6bd0-4774-bccb-6e865c2e1b80', 'icon-user-minus', 'icon-user-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1419, 'eac75527-0476-4acc-9e0d-a8348af8d338', 'icon-user-ninja', 'icon-user-ninja', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1420, '2971904f-3b7d-4af5-9898-9b417120a457', 'icon-user-plus', 'icon-user-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1421, 'e98bd898-55cf-4e48-a683-0d45d5371777', 'icon-user-secret', 'icon-user-secret', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1422, 'b007c3a2-f63c-421c-9df3-1bf6f2f31bef', 'icon-user-shield', 'icon-user-shield', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1423, '64978634-a87f-49b3-b9a1-9a05a9f8ce83', 'icon-user-slash', 'icon-user-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1424, '2546d01d-8df3-484a-8fae-dbba2b627c4d', 'icon-user-tag', 'icon-user-tag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1425, 'e099420c-8206-4c5d-8ab1-a5ddaa9e2aeb', 'icon-user-tie', 'icon-user-tie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1426, 'd902feb7-e780-44b7-8457-2bc9c2d57622', 'icon-user-times', 'icon-user-times', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1427, 'fedcb053-749f-4603-8696-52d76ccb369f', 'icon-user', 'icon-user', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1428, 'a309e532-656b-43d6-8da2-adaaebc1b66d', 'icon-users-cog', 'icon-users-cog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1429, '6cfdb141-84fe-4eec-bf1a-6beb8246bd6a', 'icon-users', 'icon-users', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1430, 'c8f98045-89e8-472a-b000-f4c580eb625c', 'icon-utensil-spoon', 'icon-utensil-spoon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1431, '35b5d6f7-e185-4743-980b-4fa7240e864e', 'icon-utensils', 'icon-utensils', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1432, 'bd9c6b8b-102e-4734-ac8f-996d699c8484', 'icon-vector-square', 'icon-vector-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1433, 'c2777d9d-422a-46c2-b80a-77f558e8613f', 'icon-venus-double', 'icon-venus-double', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1434, 'c1540a9c-cc0b-41d2-ab74-68ad39d89c73', 'icon-venus-mars', 'icon-venus-mars', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1435, 'fb50148c-2be4-4be3-8466-9ac5b9006c56', 'icon-venus', 'icon-venus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1436, '773cf6d0-6982-4457-b80a-2511f2324d1d', 'icon-vial', 'icon-vial', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1437, '298b631d-5d0e-4592-aafc-324d44002596', 'icon-vials', 'icon-vials', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1438, '4e968634-ad3a-42f6-b480-8a7297a79065', 'icon-video-slash', 'icon-video-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1439, '76d2209a-6667-4a7f-8ae8-50c46f4b1f38', 'icon-video', 'icon-video', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1440, '9a161c51-0c6f-4c9c-8dcd-398c390c27d0', 'icon-vihara', 'icon-vihara', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1441, '2a1680a1-ee61-4ca9-b4e2-90eeda0f0961', 'icon-volleyball-ball', 'icon-volleyball-ball', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1442, 'd498200e-e5f7-4566-807c-3525bdcfa4d6', 'icon-volume-down', 'icon-volume-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1443, '9c38e00b-4b12-4cc8-83ab-1e29ced3b6a6', 'icon-volume-off', 'icon-volume-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1444, 'd1533baa-018a-469d-99a2-f13432813bbd', 'icon-volume-up', 'icon-volume-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1445, '45fe7daf-12dd-4a17-9a1d-b70b4adee9c3', 'icon-walking', 'icon-walking', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1446, '9597074b-1caf-4c53-9783-02f9af182139', 'icon-wallet', 'icon-wallet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1447, 'd1fa0b9c-69ef-4eec-9c2b-54a809127630', 'icon-warehouse', 'icon-warehouse', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1448, 'f3e663a1-096d-4dd7-ba24-d2199cc94e9d', 'icon-weight-hanging', 'icon-weight-hanging', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1449, 'cc4415dd-2538-4537-8119-3ec911f7792c', 'icon-weight', 'icon-weight', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1450, '002a9aaa-93d0-46cf-88db-1d7b15c08aed', 'icon-wheelchair', 'icon-wheelchair', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1451, '6a6b3719-4fdd-48ee-ad0d-10a600c0c5a4', 'icon-wifi', 'icon-wifi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1452, '9bc60992-cebf-4469-b85a-1f9b6ac25cf1', 'icon-window-close', 'icon-window-close', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1453, 'b86c2060-6638-4f82-9a79-41931b632183', 'icon-window-maximize', 'icon-window-maximize', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1454, '66897f0f-7141-4832-8e38-6a64e7d7fb4c', 'icon-window-minimize', 'icon-window-minimize', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1455, '32d10463-b3cf-4052-b08a-d58c7e1f272d', 'icon-window-restore', 'icon-window-restore', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1456, '54fea733-bdec-4ece-a74c-dff5d3050392', 'icon-wine-glass-alt', 'icon-wine-glass-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1457, '0aa887f6-bb0c-4ff3-b01e-161bd8eed0ab', 'icon-wine-glass', 'icon-wine-glass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1458, '5d5d12cd-81cb-429a-8040-b1e79fd00727', 'icon-won-sign', 'icon-won-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1459, '1f86c9bd-4f6a-47b1-9c7f-64658577b00c', 'icon-wrench', 'icon-wrench', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1460, '5c949d43-a40c-4f29-8162-26982d03c61d', 'icon-x-ray', 'icon-x-ray', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1461, 'd3f05b5f-3186-4636-b66c-f0d5ac5ce9ff', 'icon-yen-sign', 'icon-yen-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1462, 'a06f3b8a-2512-469e-aa50-7bca3627d35a', 'icon-yin-yang', 'icon-yin-yang', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1463, '9bff61a4-0eec-4184-9c33-1d5f7a3ba81d', 'icon-address-book1', 'icon-address-book1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1464, 'd1e0d93d-a9fe-4821-9ca6-2d295a52249c', 'icon-address-card1', 'icon-address-card1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1465, '5bb6107f-cd97-4d30-97bf-692b46db0bb0', 'icon-angry1', 'icon-angry1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1466, 'db3c01a8-ff69-4e21-8c66-58f722304c1a', 'icon-arrow-alt-circle-down1', 'icon-arrow-alt-circle-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1467, '1e01953f-5955-4a0d-82de-00894df9d269', 'icon-arrow-alt-circle-left1', 'icon-arrow-alt-circle-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1468, '63faa47f-ab09-4cde-ba8a-e82efb2b8adc', 'icon-arrow-alt-circle-right1', 'icon-arrow-alt-circle-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1469, 'dde0db3e-4676-4076-b20c-cf30c77038af', 'icon-arrow-alt-circle-up1', 'icon-arrow-alt-circle-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1470, 'daf05299-45c4-4742-870e-489cf1c15f79', 'icon-bell-slash1', 'icon-bell-slash1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1471, '8218cb59-7985-42f4-81f1-476632608815', 'icon-bell1', 'icon-bell1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1472, '3eb97d38-7e2b-4d9d-a6e1-04f8cd77733d', 'icon-bookmark1', 'icon-bookmark1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1473, 'e9a14796-df51-4041-b865-90d6f0a15e69', 'icon-building1', 'icon-building1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1474, '2f9870bd-105b-45a7-8113-9ecda3689e73', 'icon-calendar-alt1', 'icon-calendar-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1475, '195ba56a-7f02-4807-b1cb-e8b7c9763b1e', 'icon-calendar-check1', 'icon-calendar-check1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1476, 'eb49da3b-8b7d-45bf-8116-a85d02ca0450', 'icon-calendar-minus1', 'icon-calendar-minus1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1477, 'b758552f-cfb6-4194-aba9-a8caa8eced45', 'icon-calendar-plus1', 'icon-calendar-plus1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1478, '5a29bfbd-f725-49ed-ad40-b02e09af6c64', 'icon-calendar-times1', 'icon-calendar-times1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1479, '4c7acae2-1b65-45a5-b498-00ab80bc9d4e', 'icon-calendar1', 'icon-calendar1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1480, '01beec12-06be-4b61-85f2-8750fabbcecf', 'icon-caret-square-down1', 'icon-caret-square-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1481, '66ac823c-1151-4ef5-a18b-72b586a08b49', 'icon-caret-square-left1', 'icon-caret-square-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1482, 'ef16a13c-a7a9-4999-9f77-97a5e975da66', 'icon-caret-square-right1', 'icon-caret-square-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1483, 'ca796a10-76e9-4995-a3fb-bc7334dda455', 'icon-caret-square-up1', 'icon-caret-square-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1484, 'db8798d4-00d9-4cff-8482-6a0e90e10344', 'icon-chart-bar1', 'icon-chart-bar1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1485, '56db0663-4fb1-43d3-9565-1928ff27edfd', 'icon-check-circle1', 'icon-check-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1486, '7e09112c-5651-47df-8881-a76f0cc75de2', 'icon-check-square1', 'icon-check-square1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1487, 'bb58ec0f-4b3d-4abe-afbd-778be4882b86', 'icon-circle1', 'icon-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1488, '7e0e266c-2f30-4822-bcd5-cffdfd22944b', 'icon-clipboard1', 'icon-clipboard1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1489, '2f93d8f5-7495-4e75-843b-21221d5adea6', 'icon-clock1', 'icon-clock1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1490, 'cc9a7b49-69ea-4e95-988d-68afeaafdf65', 'icon-clone1', 'icon-clone1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1491, 'd027e2ca-69bd-4d65-a8d8-f396f947be2e', 'icon-closed-captioning1', 'icon-closed-captioning1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1492, '93f58d1a-e026-47ba-a588-e631522aed15', 'icon-comment-alt1', 'icon-comment-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1493, '751f1ca4-fbea-462b-afb9-e22bec00db90', 'icon-comment-dots1', 'icon-comment-dots1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1494, '80cca0ca-a244-4e7e-b3b2-4ef3fd9628b2', 'icon-comment1', 'icon-comment1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1495, 'e278ca5e-8ac6-4494-ae4e-3e108237af52', 'icon-comments1', 'icon-comments1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1496, 'b18f3c0e-0247-494e-b06f-a9261db3a755', 'icon-compass1', 'icon-compass1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1497, '94dad44a-4426-48d4-af4c-30ab03f099ca', 'icon-copy1', 'icon-copy1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1498, 'f6a98483-72b0-4416-a59a-a61e6ba95087', 'icon-copyright1', 'icon-copyright1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1499, 'cfb48392-0bdd-4943-be88-bfbe1551870b', 'icon-credit-card1', 'icon-credit-card1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1500, '3fe99527-93fa-4bf9-9aa8-27a5ade35fca', 'icon-dizzy1', 'icon-dizzy1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1501, 'e430996b-4335-49d7-a6c5-f310cb1f7677', 'icon-dot-circle1', 'icon-dot-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1502, 'ebb93b61-d94e-46c6-a428-781b2cd197a2', 'icon-edit1', 'icon-edit1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1503, '8ed45b9c-06b6-4ee8-9500-439541a6d059', 'icon-envelope-open1', 'icon-envelope-open1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1504, '423f6de8-dda9-4557-af8e-3a64c86f305d', 'icon-envelope1', 'icon-envelope1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1505, '0ad3f90c-6133-44a3-ad05-d868c66717e3', 'icon-eye-slash1', 'icon-eye-slash1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1506, '5ff23d0f-b9a7-4cb5-9c3e-547dccb1eba9', 'icon-eye1', 'icon-eye1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1507, '9251d5fb-324f-49d1-bd9f-5466f189fd9d', 'icon-file-alt1', 'icon-file-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1508, '53642b65-fe5a-4a2d-895b-b895b43e74b1', 'icon-file-archive1', 'icon-file-archive1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1509, '09e8d8a3-6077-4143-a006-24820bb68bbf', 'icon-file-audio1', 'icon-file-audio1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1510, '96766fc9-7ebc-4b32-8099-755bc6fce730', 'icon-file-code1', 'icon-file-code1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1511, 'a7f03990-dcd9-45ce-9dc7-45e7ee1ff225', 'icon-file-excel1', 'icon-file-excel1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1512, '7f44e3ba-c548-46d0-92a0-55c39b820c2c', 'icon-file-image1', 'icon-file-image1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1513, '1a6a2297-29b9-42db-a5bc-14f52faf96c5', 'icon-file-pdf1', 'icon-file-pdf1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1514, '5d4bb5ef-e5e8-483e-a3d5-3299432f107f', 'icon-file-powerpoint1', 'icon-file-powerpoint1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1515, '968d1b03-65dd-4809-a279-a8237ef585e0', 'icon-file-video1', 'icon-file-video1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1516, '44ac0541-4572-477d-9470-088967f4eb68', 'icon-file-word1', 'icon-file-word1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1517, 'f3c190dd-9105-481d-9dc1-38fa8c62cf3f', 'icon-file1', 'icon-file1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1518, '04acb08d-6b4b-42ba-8497-b77764575d33', 'icon-flag1', 'icon-flag1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1519, '4320dc01-6c8a-4119-9ddc-809113f0e865', 'icon-flushed1', 'icon-flushed1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1520, 'a47d3fe2-a981-42e0-b5f9-19edba56c7df', 'icon-folder-open1', 'icon-folder-open1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1521, 'a97e1fb3-3648-47bf-848c-a6b197f551ca', 'icon-folder1', 'icon-folder1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1522, '5b54a49b-0859-469f-ab23-ad7f16d8ba95', 'icon-font-awesome-logo-full1', 'icon-font-awesome-logo-full1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1523, '90307683-faf4-4e8f-b00f-013082198702', 'icon-frown-open1', 'icon-frown-open1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1524, '042c5e5a-8049-4544-b0d5-2760c5d2e894', 'icon-frown1', 'icon-frown1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1525, 'b2822ae3-d2cd-4d18-85c6-169d47c427e5', 'icon-futbol1', 'icon-futbol1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1526, 'e49b26a6-3c51-41a6-8605-cdb31c2f23f8', 'icon-gem1', 'icon-gem1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1527, 'ada75ff9-3e40-4791-92e9-34b0d11b863e', 'icon-grimace1', 'icon-grimace1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1528, 'b3ce2788-efe8-4c98-bc54-d0c7417ca445', 'icon-grin-alt1', 'icon-grin-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1529, 'baa5c2d4-88b5-4b5a-9133-bdd38b9c81ee', 'icon-grin-beam-sweat1', 'icon-grin-beam-sweat1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1530, '06859f8c-4f59-40ce-b731-adf47a3986c9', 'icon-grin-beam1', 'icon-grin-beam1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1531, 'b12f42b3-5f58-4d6c-b7cf-6f89db0293fe', 'icon-grin-hearts1', 'icon-grin-hearts1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1532, '692abcd0-9624-459c-9707-1300fdbff769', 'icon-grin-squint-tears1', 'icon-grin-squint-tears1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1533, 'c9cfd67e-b26e-48d2-b33d-ae3d99d60458', 'icon-grin-squint1', 'icon-grin-squint1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1534, '53a0c37d-ad19-4c41-bb0c-d3f91e7446d4', 'icon-grin-stars1', 'icon-grin-stars1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1535, '18f809a1-4e80-41e9-b34f-45b3ad54dfe9', 'icon-grin-tears1', 'icon-grin-tears1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1536, '9b2ded59-802b-494e-b9cc-7c82a2e572e8', 'icon-grin-tongue-squint1', 'icon-grin-tongue-squint1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1537, 'fcf7dc12-86d1-4d9c-b05e-479b5c39a669', 'icon-grin-tongue-wink1', 'icon-grin-tongue-wink1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1538, 'e07db1bf-af87-426a-ae3e-8001171b9954', 'icon-grin-tongue1', 'icon-grin-tongue1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1539, 'cdb859fb-7f9f-4579-a9d4-74cf9a005930', 'icon-grin-wink1', 'icon-grin-wink1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1540, '865707ae-59a4-487f-9089-f6e7d03aca21', 'icon-grin1', 'icon-grin1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1541, '1f94e4b0-0f42-448d-9621-1d8b06d50c8b', 'icon-hand-lizard1', 'icon-hand-lizard1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1542, '4515090a-5310-41a0-af99-005d65f37978', 'icon-hand-paper1', 'icon-hand-paper1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1543, 'c5f34a95-5e8d-4f67-b588-c2d3a76ef838', 'icon-hand-peace1', 'icon-hand-peace1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1544, '6e08d2b5-997b-4991-bc99-4f8249bd76e4', 'icon-hand-point-down1', 'icon-hand-point-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1545, 'fc6688d8-9a73-4b78-95e3-e859c4709bf2', 'icon-hand-point-left1', 'icon-hand-point-left1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1546, 'ebb09355-4966-4647-b35d-3b66f8c5460e', 'icon-hand-point-right1', 'icon-hand-point-right1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1547, 'a0a8a670-2142-4045-985d-387c269c064e', 'icon-hand-point-up1', 'icon-hand-point-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1548, '54a94109-a825-48ea-a7ca-26d871050e36', 'icon-hand-pointer1', 'icon-hand-pointer1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1549, '880d9a94-faa4-4c24-90af-f46241d7355e', 'icon-hand-rock1', 'icon-hand-rock1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1550, 'a4e41bdb-0bb8-42ab-b584-cd2a586fd156', 'icon-hand-scissors1', 'icon-hand-scissors1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1551, '4d97105b-a4ec-4919-ae23-27df201ee886', 'icon-hand-spock1', 'icon-hand-spock1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1552, 'a6c3a0fa-86b8-4f4e-aff7-19d60a1653a7', 'icon-handshake1', 'icon-handshake1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1553, '26077d5a-3efe-4a7c-b312-5c8e1bb50919', 'icon-hdd1', 'icon-hdd1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1554, 'e26a3046-426b-4cb9-8847-af26e77af609', 'icon-heart1', 'icon-heart1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1555, '48642991-a94e-4b78-92f2-d8868aa13970', 'icon-hospital1', 'icon-hospital1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1556, '81435ab8-68c7-4e2c-9b8c-f9c1f53ddb6d', 'icon-hourglass1', 'icon-hourglass1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1557, '970fa80b-c26b-473d-b502-e1061ff0c53f', 'icon-id-badge1', 'icon-id-badge1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1558, '61d557f9-0e3a-4a1a-ba79-e0f21cb2c69b', 'icon-id-card1', 'icon-id-card1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1559, 'c70599b7-d46d-4a97-8dc2-f0a04210d74b', 'icon-image1', 'icon-image1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1560, '98fc2eb9-8f52-4002-a43d-d8887d33a1ad', 'icon-images1', 'icon-images1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1561, '97dd4b0b-ea17-4805-8751-e6c311fddc07', 'icon-keyboard1', 'icon-keyboard1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1562, '233f0705-b0a1-4fe5-a1bd-69bcbba64737', 'icon-kiss-beam1', 'icon-kiss-beam1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1563, 'ccf877eb-7455-4145-ad8d-0c1fa7e9ae1b', 'icon-kiss-wink-heart1', 'icon-kiss-wink-heart1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1564, 'c99ae029-dfdf-418e-9ab0-6380b542e817', 'icon-kiss1', 'icon-kiss1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1565, '81843d7e-5301-4f11-8a45-9ba862595ae2', 'icon-laugh-beam1', 'icon-laugh-beam1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1566, 'e4d7673f-26c0-4561-be13-8c31043abb48', 'icon-laugh-squint1', 'icon-laugh-squint1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1567, 'e17c32f8-1dc5-4646-9f4c-da8781b29145', 'icon-laugh-wink1', 'icon-laugh-wink1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1568, 'e50cae7c-9ae1-4b29-a5fe-db428ce68259', 'icon-laugh1', 'icon-laugh1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1569, 'af4a5f73-5877-4c1a-9c25-e2f811e41fff', 'icon-lemon1', 'icon-lemon1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1570, '3b1e9fc7-8567-4ec7-9e4c-b706603db476', 'icon-life-ring1', 'icon-life-ring1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1571, 'f0c4002e-41d6-442c-bccb-3e24be5dc389', 'icon-lightbulb1', 'icon-lightbulb1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1572, '37b950b9-8115-44be-8715-e96b7ea7cea3', 'icon-list-alt1', 'icon-list-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1573, 'cc24e87a-e7aa-4607-ac26-6785037de67f', 'icon-map1', 'icon-map1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1574, '6b0fdc8d-1bf3-4e38-a79a-7df538e97242', 'icon-meh-blank1', 'icon-meh-blank1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1575, 'dcb60bfe-4e3d-4ad3-95e3-c4383458fe44', 'icon-meh-rolling-eyes1', 'icon-meh-rolling-eyes1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1576, '5e115546-b908-4894-9cbf-fd549fbdd45a', 'icon-meh1', 'icon-meh1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1577, '5e9c86ac-9ef6-4ad6-93a6-55e389b5a53d', 'icon-minus-square1', 'icon-minus-square1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1578, '3af166e7-3c11-4109-9e04-c63224594f57', 'icon-money-bill-alt1', 'icon-money-bill-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1579, '507fb05f-7e06-42de-87c6-00eee1a8bada', 'icon-moon1', 'icon-moon1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1580, '048fe83c-457a-4aa2-9f4d-6377b7fa541e', 'icon-newspaper1', 'icon-newspaper1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1581, 'be0c17fc-05e8-4056-aa29-171d09c837d4', 'icon-object-group1', 'icon-object-group1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1582, 'd4714fe5-246c-449c-bdc1-0726d3499be7', 'icon-object-ungroup1', 'icon-object-ungroup1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1583, 'ad8bf0c4-f7ff-4357-adf8-24a79ab3afcb', 'icon-paper-plane1', 'icon-paper-plane1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1584, '706f4d0d-fcfb-4fa1-b6da-8970df1a22b1', 'icon-pause-circle1', 'icon-pause-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1585, 'e99f4eb2-0a8f-47dc-9a58-7eeec88ebfa7', 'icon-play-circle1', 'icon-play-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1586, 'fb87682f-f7dd-4031-b0e3-4b2399cb8ad5', 'icon-plus-square1', 'icon-plus-square1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1587, '7464be71-03c6-471d-87a0-e321d9484dd9', 'icon-question-circle1', 'icon-question-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1588, 'c06de5de-0233-4ea7-9b1c-f1925e9716e3', 'icon-registered1', 'icon-registered1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1589, 'addb5c3e-cb9a-44c7-94a9-2788618513da', 'icon-sad-cry1', 'icon-sad-cry1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1590, '3c2f73be-2e71-4dac-8481-95aed9e140bb', 'icon-sad-tear1', 'icon-sad-tear1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1591, 'c5bc817f-18a1-4b46-84de-53205893f813', 'icon-save1', 'icon-save1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1592, '3606c4b2-dd0e-41eb-a49f-d9027631db4e', 'icon-share-square1', 'icon-share-square1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1593, '0692e915-c152-4cab-b2bf-31240ccb0bec', 'icon-smile-beam1', 'icon-smile-beam1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1594, 'c91927db-b40c-41d2-9173-69ce4584c77a', 'icon-smile-wink1', 'icon-smile-wink1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1595, '926667b7-76a9-409b-9898-f12a4d66ee2b', 'icon-smile1', 'icon-smile1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1596, '648f6253-6eb4-4ca0-b1c1-e7afa14f4991', 'icon-snowflake1', 'icon-snowflake1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1597, 'ce2cb42a-70f0-435d-b260-0b5c6ca3febc', 'icon-square1', 'icon-square1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1598, '693ec0f7-8d14-4fd5-9826-8a1dd6958098', 'icon-star-half1', 'icon-star-half1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1599, 'ad106e2a-aa92-41ca-badb-82dec32e08ac', 'icon-star1', 'icon-star1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1600, '6c4a97a6-e5a7-4be8-9109-4d96e3e83445', 'icon-sticky-note1', 'icon-sticky-note1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1601, '8ca36c25-590d-48cd-b599-7db596b99ac7', 'icon-stop-circle1', 'icon-stop-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1602, '2e66522f-8123-429e-86aa-e0be4887903c', 'icon-sun1', 'icon-sun1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1603, 'b01ad75b-1bd9-45d1-b029-45fb30c8328b', 'icon-surprise1', 'icon-surprise1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1604, '07199b0c-dbaf-4f6a-a352-a69b383e616b', 'icon-thumbs-down1', 'icon-thumbs-down1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1605, '6a098d79-f1cd-4d71-baf9-e9b482997bcb', 'icon-thumbs-up1', 'icon-thumbs-up1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1606, '9cc202d3-b560-430a-bd1d-8a46c6279309', 'icon-times-circle1', 'icon-times-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1607, '4275844a-d173-4b67-b218-079821b1131a', 'icon-tired1', 'icon-tired1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1608, '869fbbff-88e2-4976-8952-7a36fc4080e2', 'icon-trash-alt1', 'icon-trash-alt1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1609, '5477487f-307e-4505-b1be-e8bbeb64aedb', 'icon-user-circle1', 'icon-user-circle1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1610, 'c33cb57d-658a-4951-a35e-136aef9a801e', 'icon-user1', 'icon-user1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1611, '03ca728d-0845-4754-bb1c-d077fae0eed5', 'icon-window-close1', 'icon-window-close1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1612, 'f16192c7-65ec-43d6-84a4-ea7e79d5edd5', 'icon-window-maximize1', 'icon-window-maximize1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1613, '1000cf53-2400-4d22-a24c-7450173adca1', 'icon-window-minimize1', 'icon-window-minimize1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1614, '316591ba-81d3-41ff-aec4-ca98e8529578', 'icon-window-restore1', 'icon-window-restore1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1615, 'c9e8e390-f57a-42b5-9bd7-cb1baf63ec93', 'icon-px', 'icon-px', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1616, '451f5ccd-9d10-4a94-9b7c-4e13914dcb0c', 'icon-accessible-icon', 'icon-accessible-icon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1617, '8c4fa25c-a90c-45c0-ad94-7ba6ff1467fd', 'icon-accusoft', 'icon-accusoft', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1618, 'aca96e8b-477f-4512-ba49-abe2359581c0', 'icon-adn', 'icon-adn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1619, 'aab00898-9473-4bb5-93a8-8807a090cabc', 'icon-adversal', 'icon-adversal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1620, 'e998f37f-0d10-4b7d-abaf-8a823d4fcc88', 'icon-affiliatetheme', 'icon-affiliatetheme', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1621, '7c460dbb-b9c4-4a5c-89e9-a86102e722f2', 'icon-algolia', 'icon-algolia', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1622, '1c021b54-798f-4529-909e-9be48ad510ab', 'icon-alipay', 'icon-alipay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1623, '116beee2-f94d-44c1-90f4-ecc47f4b5a8b', 'icon-amazon-pay', 'icon-amazon-pay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1624, 'eaaee54e-343c-44bd-b8a7-1f279cc23927', 'icon-amazon', 'icon-amazon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1625, '8a530c4e-04af-4776-9b91-a6850d3b33a3', 'icon-amilia', 'icon-amilia', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1626, 'cb58e13b-fd3d-4ae6-8b2b-204cb03885e4', 'icon-android', 'icon-android', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1627, '4549a8ea-50b8-40ab-9bba-3bece2effeb7', 'icon-angellist', 'icon-angellist', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1628, 'c1217cb2-d859-4ebc-b546-e83f9c70ea8e', 'icon-angrycreative', 'icon-angrycreative', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1629, '9d28adc7-33d8-4784-a918-a0596939d418', 'icon-angular', 'icon-angular', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1630, 'd4c41deb-e6ca-45ed-9da8-07122d97199d', 'icon-app-store-ios', 'icon-app-store-ios', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1631, '38a99717-a52e-469e-aeca-e5e813bedb4a', 'icon-app-store', 'icon-app-store', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1632, 'b1a69d8e-9e14-48d5-8ce1-4d415a4be368', 'icon-apper', 'icon-apper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1633, 'b600675a-c1aa-4ecf-9292-3e60eb431319', 'icon-apple-pay', 'icon-apple-pay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1634, 'c224ebd9-a8e7-4227-93bf-9cb207cfd187', 'icon-apple', 'icon-apple', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1635, '7b83ecca-e8d8-4417-9cc1-4292d41d926f', 'icon-asymmetrik', 'icon-asymmetrik', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1636, '11780f59-7869-4653-b156-b77e71561197', 'icon-audible', 'icon-audible', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1637, 'fa95d050-e7ae-4394-867a-7cbaa5dcce34', 'icon-autoprefixer', 'icon-autoprefixer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1638, '423fdf16-dfbe-41ca-a299-a95e9263ece7', 'icon-avianex', 'icon-avianex', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1639, '0ba31169-fa4f-42c2-aa59-f23f2946c626', 'icon-aviato', 'icon-aviato', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1640, '14435836-60d3-4498-8aba-9273e8becb72', 'icon-aws', 'icon-aws', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1641, '3164c96f-1aba-42d8-af0c-f9021224cc26', 'icon-bandcamp', 'icon-bandcamp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1642, '3a867734-b8ca-4a1c-9018-2ddfc03cc32f', 'icon-behance-square', 'icon-behance-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1643, '4517dd2f-b6b0-4be9-8bed-342c6e76ef31', 'icon-behance', 'icon-behance', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1644, '57d8083f-aebf-49fa-a68b-3a05a344ac5b', 'icon-bimobject', 'icon-bimobject', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1645, '90bfb98f-d579-421d-8a32-d0f812b3ce96', 'icon-bitbucket', 'icon-bitbucket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1646, 'bfa4288a-34b7-431d-84e3-9c71f40d5f85', 'icon-bitcoin', 'icon-bitcoin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1647, 'cd18a440-4623-47c1-a740-a28aba19c2c4', 'icon-bity', 'icon-bity', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1648, 'e7fe9459-61d6-4652-b57a-360aab8d11ee', 'icon-black-tie', 'icon-black-tie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1649, '9bdd3903-698a-4b05-b941-b77b8b20720a', 'icon-blackberry', 'icon-blackberry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1650, '1c41fbb0-3982-4bcf-8c74-f6e215bb7f27', 'icon-blogger-b', 'icon-blogger-b', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1651, 'e09a6f9f-8804-4461-b1ae-bc7bffec9b39', 'icon-blogger', 'icon-blogger', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1652, '96dae66a-4fe4-40bf-a1e2-d2f20a624904', 'icon-bluetooth-b', 'icon-bluetooth-b', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1653, 'b10af5ec-b3b3-4b8e-b703-2e42ed935492', 'icon-bluetooth', 'icon-bluetooth', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1654, 'b49b10b9-fbc3-4a7d-96b8-1ddb9d636514', 'icon-btc', 'icon-btc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1655, '88890f12-e8a1-4798-8c68-4fcc73fa08ef', 'icon-buromobelexperte', 'icon-buromobelexperte', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1656, 'd378cf01-dae7-4442-b6c2-cd7b9abdcff1', 'icon-buysellads', 'icon-buysellads', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1657, '087566af-5198-4340-bc22-884539cf06d6', 'icon-cc-amazon-pay', 'icon-cc-amazon-pay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1658, '9da8464a-5da8-4624-88bb-20f8409caaf3', 'icon-cc-amex', 'icon-cc-amex', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1659, '735fc954-1117-4b62-a7ab-ed5d4f940a55', 'icon-cc-apple-pay', 'icon-cc-apple-pay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1660, 'f958e000-394f-4f0b-86ea-d15ef9f2fc24', 'icon-cc-diners-club', 'icon-cc-diners-club', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1661, '413aee28-b37d-4b8d-af58-b15ba01a926b', 'icon-cc-discover', 'icon-cc-discover', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1662, 'c8b0ffd9-4ce9-4826-9644-145bc5180ec8', 'icon-cc-jcb', 'icon-cc-jcb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1663, '55b98bb5-f316-4346-b1aa-922d67e42895', 'icon-cc-mastercard', 'icon-cc-mastercard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1664, 'f197b9bf-e82a-4038-8502-59ad4b73697e', 'icon-cc-paypal', 'icon-cc-paypal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1665, '0ab7f7b9-7654-4207-b4c6-fd7fc6019451', 'icon-cc-stripe', 'icon-cc-stripe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1666, '5d7ab481-9362-4059-82bf-0c64883226e4', 'icon-cc-visa', 'icon-cc-visa', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1667, '8ac00c73-a9e5-4114-abf4-bd6c535e1326', 'icon-centercode', 'icon-centercode', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1668, 'b760cab5-a65d-4d44-bf57-51cfa3ba6ab4', 'icon-chrome', 'icon-chrome', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1669, '0e9dd831-c92f-45da-9df3-502c31b4d15c', 'icon-cloudscale', 'icon-cloudscale', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1670, '4833284e-ae85-41d8-9782-8b3d6e9b70df', 'icon-cloudsmith', 'icon-cloudsmith', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1671, '04787021-238e-4315-9790-a6fd273f5a19', 'icon-cloudversify', 'icon-cloudversify', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1672, '505a7932-60f1-447b-8240-f18e2278d701', 'icon-codepen', 'icon-codepen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1673, '9991361a-7668-4304-b403-987713e27cbb', 'icon-codiepie', 'icon-codiepie', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1674, '693123ae-e2f2-4192-84e3-3f2bc3255ca8', 'icon-connectdevelop', 'icon-connectdevelop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1675, 'f55e055b-b823-4af3-b738-f166f19fbccd', 'icon-contao', 'icon-contao', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1676, '6ab06d29-ea80-47bd-8024-1bc6e2723fb0', 'icon-cpanel', 'icon-cpanel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1677, '5fb5ef15-4191-4b83-85bc-6da25afe305a', 'icon-creative-commons-by', 'icon-creative-commons-by', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1678, 'fd92d412-92d2-4330-8141-a09060d85e4e', 'icon-creative-commons-nc-eu', 'icon-creative-commons-nc-eu', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1679, '8e7c7805-4680-4cbb-8168-47f672f411ca', 'icon-creative-commons-nc-jp', 'icon-creative-commons-nc-jp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1680, '7bc25923-0995-4e02-931a-08406c7860cb', 'icon-creative-commons-nc', 'icon-creative-commons-nc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1681, '31f56c88-306d-403b-b49a-d4d5efbb8b2b', 'icon-creative-commons-nd', 'icon-creative-commons-nd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1682, '304b2bd7-3935-4733-94ec-7b81b00a14be', 'icon-creative-commons-pd-alt', 'icon-creative-commons-pd-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1683, '91d844b1-7683-46d8-a178-495d4c324f24', 'icon-creative-commons-pd', 'icon-creative-commons-pd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1684, '2bb3f68b-ab15-4cc0-a412-bcd28c17877e', 'icon-creative-commons-remix', 'icon-creative-commons-remix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1685, '19276197-2e92-47b5-b9e6-fa77be0c5e25', 'icon-creative-commons-sa', 'icon-creative-commons-sa', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1686, '8c716103-a550-460a-8895-a9d285065121', 'icon-creative-commons-sampling-plus', 'icon-creative-commons-sampling-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1687, '3cc16c59-3cc1-4879-8fb4-e9cf6a88cd9c', 'icon-creative-commons-sampling', 'icon-creative-commons-sampling', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1688, '809d4c39-fe78-427e-bb89-46f9df54644e', 'icon-creative-commons-share', 'icon-creative-commons-share', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1689, 'fa3e1b56-3931-46e0-a79d-7e82da70e3e9', 'icon-creative-commons', 'icon-creative-commons', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1690, '823a790e-7fbd-4fc0-9e54-795c69162d20', 'icon-css3-alt', 'icon-css3-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1691, '9ca919eb-94db-40e0-a6a1-b5d8aac6091c', 'icon-css3', 'icon-css3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1692, '417168fa-6fc3-4069-8259-b6143597ab96', 'icon-cuttlefish', 'icon-cuttlefish', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1693, '4b655aa5-b86e-4e7c-a421-250e6e8e3563', 'icon-d-and-d', 'icon-d-and-d', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1694, '56d1c2cd-2e67-4636-8def-fcc7ad1c2f73', 'icon-dashcube', 'icon-dashcube', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1695, '91a499c8-afef-4332-9bb7-1f7de84eea44', 'icon-delicious', 'icon-delicious', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1696, 'b9ded848-5368-4674-852d-b3186c3efca7', 'icon-deploydog', 'icon-deploydog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1697, '5a7a0a6e-e5f7-440a-9369-68293c2f7c70', 'icon-deskpro', 'icon-deskpro', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1698, 'bc66dd1d-ad2e-4590-8a45-783aacc1db78', 'icon-deviantart', 'icon-deviantart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1699, 'a06e3e53-5ec5-466b-a904-c3dbe8ca44ed', 'icon-digg', 'icon-digg', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1700, '2ead3795-e87c-408b-adf7-ea6047ffaa84', 'icon-digital-ocean', 'icon-digital-ocean', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1701, '12f3d46d-c39a-4da4-99c8-1c551401cc84', 'icon-discord', 'icon-discord', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1702, '63aa6656-b71b-4f49-9811-888b87fc9809', 'icon-discourse', 'icon-discourse', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1703, '75c43256-4aaa-499f-9b88-7e7d65414819', 'icon-dochub', 'icon-dochub', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1704, '0bf5e9a2-8768-403f-ba23-aee20016f9ff', 'icon-docker', 'icon-docker', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1705, '29c951a0-e46a-4875-a012-0248ddb88b12', 'icon-draft2digital', 'icon-draft2digital', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1706, 'f729d8b0-7e64-4902-92cc-d6a39b31a46f', 'icon-dribbble-square', 'icon-dribbble-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1707, 'bb3eda12-363f-4fca-b079-059740c095bb', 'icon-dribbble', 'icon-dribbble', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1708, 'd15d45cc-ae5e-49ce-9564-1e31ded192c6', 'icon-dropbox', 'icon-dropbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1709, 'fc8fb808-aa3f-4f9d-aa07-4656470f1d14', 'icon-drupal', 'icon-drupal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1710, 'd1bdd43c-725d-4ede-9509-4c20a485d10e', 'icon-dyalog', 'icon-dyalog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1711, 'bca02955-2b73-48bf-a0cc-e9a1bf3dd50a', 'icon-earlybirds', 'icon-earlybirds', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1712, '7435ed1a-6fb3-4804-be60-a1e086d2d32d', 'icon-ebay', 'icon-ebay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1713, '224dd95a-9e40-43fe-a3fa-f9a54565510a', 'icon-edge', 'icon-edge', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1714, 'aeb3c951-b17e-49ff-ae55-1ecf3e3cdf97', 'icon-elementor', 'icon-elementor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1715, '77178046-4126-4b8d-a436-8a0187a2c523', 'icon-ello', 'icon-ello', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1716, '0b7d78dc-4333-49d2-a015-68b98f9c72a1', 'icon-ember', 'icon-ember', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1717, '51e1ffa6-a014-487c-9dd8-7727a871811d', 'icon-empire', 'icon-empire', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1718, '656af6c2-4157-4ea9-a924-a1ee1fca5d77', 'icon-envira', 'icon-envira', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1719, '0c09fb4b-2af1-4c65-9bde-a31778e449a1', 'icon-erlang', 'icon-erlang', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1720, 'bd86e431-11ad-4d23-aaff-b27f1fd19d62', 'icon-ethereum', 'icon-ethereum', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1721, 'e4f9660a-dcad-4b07-b6cb-6598885996f9', 'icon-etsy', 'icon-etsy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1722, 'd7a4de2e-7c83-4a2d-a5d7-d779b1a065d0', 'icon-expeditedssl', 'icon-expeditedssl', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1723, 'dae7b952-429b-468e-91db-307a1fc20b10', 'icon-facebook-f', 'icon-facebook-f', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1724, 'a1ab7bb7-42b5-448b-a986-bfee00ea0fb0', 'icon-facebook-messenger', 'icon-facebook-messenger', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1725, 'f94c9d9b-a212-4f11-977b-1cf70632bb61', 'icon-facebook-square', 'icon-facebook-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1726, '65460391-055f-4da6-92aa-5f91c8a8d985', 'icon-facebook1', 'icon-facebook1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1727, '098b4624-c580-4b88-86bf-6a40d7bcc76e', 'icon-firefox', 'icon-firefox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1728, '06d60048-868b-452c-84e7-9db151e43f6a', 'icon-first-order-alt', 'icon-first-order-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1729, '420eca9f-c78f-40af-a94c-fcec93206ec7', 'icon-first-order', 'icon-first-order', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1730, 'cadc0a51-dfef-46df-b889-0f0554bfd7e3', 'icon-firstdraft', 'icon-firstdraft', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1731, 'dfdf7b08-700b-4d2f-8315-5303a73daca1', 'icon-flickr', 'icon-flickr', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1732, '4f093f3d-a813-4ceb-9b95-27430675877f', 'icon-flipboard', 'icon-flipboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1733, '256a8905-48e4-4421-822e-8004c4fe0bf7', 'icon-fly', 'icon-fly', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1734, 'b80e6cee-3150-43c7-ad89-c5ec3012f316', 'icon-font-awesome-alt', 'icon-font-awesome-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1735, '22eea18c-5677-44bb-b8ca-af9ae8b3d5f3', 'icon-font-awesome-flag', 'icon-font-awesome-flag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1736, 'e76acca6-2f0a-43dd-b28e-339dfe6cd579', 'icon-font-awesome-logo-full2', 'icon-font-awesome-logo-full2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1737, '70a7383d-dfb6-4451-8d25-9a05502680b5', 'icon-font-awesome', 'icon-font-awesome', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1738, '200598b2-aad8-45c5-8494-489adfc05a0f', 'icon-fonticons-fi', 'icon-fonticons-fi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1739, 'af72daf0-22ad-40ae-88b7-2168be6dd34a', 'icon-fonticons', 'icon-fonticons', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1740, '21faff77-d49b-4599-82b9-e9daab4c81f2', 'icon-fort-awesome-alt', 'icon-fort-awesome-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1741, '019d7d70-6564-48cc-b256-3d7576576449', 'icon-fort-awesome', 'icon-fort-awesome', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1742, '12118003-9f68-4dd7-817c-62983e5ed7ea', 'icon-forumbee', 'icon-forumbee', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1743, 'dc719a88-9eeb-4627-bbff-cdfdf120b3f4', 'icon-foursquare', 'icon-foursquare', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1744, '5cb97f4a-fcaf-43e9-b7f5-680ea5b194cf', 'icon-free-code-camp', 'icon-free-code-camp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1745, 'ac809462-e719-444f-86ce-b114128a63c5', 'icon-freebsd', 'icon-freebsd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1746, 'cbf3ea55-72b5-4622-93fc-fe2a57c8c88f', 'icon-fulcrum', 'icon-fulcrum', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1747, '59af7151-2d79-49f7-ae5c-68b4a548cad4', 'icon-galactic-republic', 'icon-galactic-republic', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1748, '453d1f7e-389e-4613-8178-bd78b1488e93', 'icon-galactic-senate', 'icon-galactic-senate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1749, '56b88ea9-7d9c-4ac7-a7cf-59fc6a2bbd59', 'icon-get-pocket', 'icon-get-pocket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1750, '050e2e24-4f1d-4f96-8aa4-e090a6b1cb65', 'icon-gg-circle', 'icon-gg-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1751, '26171912-02f6-40ef-9509-b794a4f71c1b', 'icon-gg', 'icon-gg', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1752, '94771be5-8ec6-4152-b0c4-f55cb69fe7bf', 'icon-git-square', 'icon-git-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1753, 'd095aaad-0feb-4ad5-9f06-b05bc5dbb0f8', 'icon-git', 'icon-git', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1754, 'b74d10a4-9551-4eca-8dc7-834e82ae4b7c', 'icon-github-alt', 'icon-github-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1755, 'b2cce872-7d36-46fc-a68c-ec6b817170c5', 'icon-github-square', 'icon-github-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1756, 'a4d1460e-5721-4ec5-84c9-982de0540bba', 'icon-github', 'icon-github', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1757, '0edc808c-f7a3-4e97-b0da-a9c593ec9c35', 'icon-gitkraken', 'icon-gitkraken', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1758, 'ee78a02d-3930-4a09-b272-0af897b1d3e4', 'icon-gitlab', 'icon-gitlab', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1759, '834c313f-6188-43fd-bafd-f4894389717d', 'icon-gitter', 'icon-gitter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1760, 'eb3d1f1c-c6a0-49d2-a6bb-6f9c21552025', 'icon-glide-g', 'icon-glide-g', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1761, 'f6698072-885a-4757-9d17-5b0d22bb221e', 'icon-glide', 'icon-glide', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1762, '3fc62126-c629-4081-b970-75aff1377852', 'icon-gofore', 'icon-gofore', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1763, 'bf4f2b98-ed73-4beb-8ef1-7926a0989e8e', 'icon-goodreads-g', 'icon-goodreads-g', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1764, '673064c0-3313-4fe6-80bc-8939db2adfbf', 'icon-goodreads', 'icon-goodreads', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1765, 'a8b04688-17aa-4c13-b9b0-18052a9307e6', 'icon-google-drive', 'icon-google-drive', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1766, '73357fa8-e6c4-401b-bf9b-39bf900776fa', 'icon-google-play', 'icon-google-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1767, 'e5d665e8-72f0-4050-a7fc-1d98ed4030bf', 'icon-google-plus-g', 'icon-google-plus-g', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1768, '7f8365bc-c9d5-4ba1-9904-d609f10e42cb', 'icon-google-plus-square', 'icon-google-plus-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1769, 'cc342cfb-4aba-4f94-8299-0318985b1bb5', 'icon-google-plus', 'icon-google-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1770, '83712637-4a8c-477d-a0c3-4ee6c2470afc', 'icon-google-wallet', 'icon-google-wallet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1771, '9acb6447-3ea9-4a31-9ad1-e114934720e3', 'icon-google', 'icon-google', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1772, 'b4a02e11-de0f-4b7c-876a-c770d9975b4a', 'icon-gratipay', 'icon-gratipay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1773, '79f10f24-4f8f-4b8b-af0a-0a28786e3ba1', 'icon-grav', 'icon-grav', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1774, 'fd2cd1d7-5154-4017-ace8-b56f6c6f2765', 'icon-gripfire', 'icon-gripfire', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1775, '595c1e9e-ae50-44d1-bfa8-8fd634a5ed86', 'icon-grunt', 'icon-grunt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1776, 'b9313971-d856-483c-a509-1f69f079c9af', 'icon-gulp', 'icon-gulp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1777, '1a76dd57-a0a4-479b-b348-b0aaa602deb6', 'icon-hacker-news-square', 'icon-hacker-news-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1778, '70b1e7ce-e9d6-4bf9-893f-6a22b71ead9e', 'icon-hacker-news', 'icon-hacker-news', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1779, 'd12cea5d-3cec-4489-99d7-09a48b6a7513', 'icon-hackerrank', 'icon-hackerrank', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1780, 'daa3298b-13b3-482e-b226-c15a42c90c54', 'icon-hips', 'icon-hips', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1781, 'b72f7327-82ed-44aa-8b30-938b72344931', 'icon-hire-a-helper', 'icon-hire-a-helper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1782, '1efd534d-21f2-4f5a-b7c0-3fe878afc53b', 'icon-hooli', 'icon-hooli', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1783, '3dd7a243-d6af-4c21-9d0a-c78fce85e045', 'icon-hornbill', 'icon-hornbill', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1784, 'd96d777f-99c3-4eec-abfb-700eec8fcee9', 'icon-hotjar', 'icon-hotjar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1785, '2f9263db-d4c1-4da2-959a-26a8ea3e288f', 'icon-houzz', 'icon-houzz', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1786, '289a8ac8-5b95-453c-8922-11c43c15d05d', 'icon-html5', 'icon-html5', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1787, '7d5b5108-11d4-44c1-b358-f801f2773502', 'icon-hubspot', 'icon-hubspot', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1788, '71477953-5611-4ff4-b83f-b428d9950eee', 'icon-imdb', 'icon-imdb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1789, '023c97e2-05c1-4616-b652-01b093d73d99', 'icon-instagram', 'icon-instagram', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1790, '35eb2376-ed20-4871-ba43-305358d2a839', 'icon-internet-explorer', 'icon-internet-explorer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1791, 'd3b855a1-d328-4c95-8244-fd6baff74a45', 'icon-ioxhost', 'icon-ioxhost', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1792, '59dd21f2-59cb-4127-8e5e-69635983b08e', 'icon-itunes-note', 'icon-itunes-note', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1793, 'e817d42a-b2d7-4f23-b8a9-75741f525267', 'icon-itunes', 'icon-itunes', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1794, 'eb3a1850-0b7a-40b6-a166-0df168298c11', 'icon-java', 'icon-java', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1795, 'e32ffd5f-be87-4948-a385-03fe68e5cf36', 'icon-jedi-order', 'icon-jedi-order', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1796, 'a4131c45-b482-4ac4-9197-d30e56376de5', 'icon-jenkins', 'icon-jenkins', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1797, '13f00063-7a04-42e9-add3-a89fcf66bead', 'icon-joget', 'icon-joget', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1798, '79dbd169-d562-48d1-99ba-e8524a80824a', 'icon-joomla', 'icon-joomla', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1799, 'f781cf24-628d-4905-883f-97cd3eb6340a', 'icon-js-square', 'icon-js-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1800, '34e8b9f4-ff5c-4abd-9286-2046f109cc20', 'icon-js', 'icon-js', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1801, '2deef17e-cd9f-46d0-b0b9-a654149471c4', 'icon-jsfiddle', 'icon-jsfiddle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1802, '5f78ae33-1420-45c0-bc3f-238b12348714', 'icon-kaggle', 'icon-kaggle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1803, 'e0da2c04-f048-4ff9-8fd6-e93773c3c411', 'icon-keybase', 'icon-keybase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1804, '94ab5b71-3664-491d-9d15-68d93bb7b0ae', 'icon-keycdn', 'icon-keycdn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1805, 'e6eea266-f7d1-40c0-8c65-c9e7b4c32932', 'icon-kickstarter-k', 'icon-kickstarter-k', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1806, 'fdfad7db-407e-4299-a44d-2d8c3da7f4ec', 'icon-kickstarter', 'icon-kickstarter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1807, '43b3ec61-6f87-41bd-9375-71e77cd2a092', 'icon-korvue', 'icon-korvue', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1808, '05a77cd7-fd23-49d8-8ca3-2a737d3d5412', 'icon-laravel', 'icon-laravel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1809, '82bcfa21-9a91-4257-bc75-79b3637af624', 'icon-lastfm-square', 'icon-lastfm-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1810, '145b121b-3715-44f5-b398-a69fe54c2f55', 'icon-lastfm', 'icon-lastfm', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1811, '0d04336b-9dd8-4464-9b5f-67c9cf0d9743', 'icon-leanpub', 'icon-leanpub', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1812, '3b3db3b7-d510-42bb-abf0-6033d0e6f419', 'icon-less', 'icon-less', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1813, '11a5475d-b81d-487b-a204-c83c77e28067', 'icon-line', 'icon-line', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1814, '4178acf0-b487-43a0-9cc8-e068ecad68c9', 'icon-linkedin-in', 'icon-linkedin-in', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1815, '49483b8c-5f4b-4bbe-8112-e14f9f91891c', 'icon-linkedin', 'icon-linkedin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1816, '52895ca5-91c8-4d92-b3f7-e3664a8fe2a3', 'icon-linode', 'icon-linode', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1817, '1b509768-0d82-4c29-b3b0-59072b7db137', 'icon-linux', 'icon-linux', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1818, '9b3848b5-c6b0-49e2-9eaa-92988d49afb7', 'icon-lyft', 'icon-lyft', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1819, '7c36d1b0-146b-4084-90af-26e05d3944c0', 'icon-magento', 'icon-magento', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1820, '6404203c-ec65-4ed6-af22-45647fbfaae6', 'icon-mailchimp', 'icon-mailchimp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1821, '99e4bb97-5024-46c0-bb5b-96ef1a1a4f8b', 'icon-mandalorian', 'icon-mandalorian', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1822, '0b38f284-0b87-4e0d-b129-3961fd971d61', 'icon-markdown', 'icon-markdown', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1823, 'fec3721d-2b7c-42ec-aff2-ad9c25d713ba', 'icon-mastodon', 'icon-mastodon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1824, '1b32978a-21d5-4b8f-876c-7a75eefdbcc0', 'icon-maxcdn', 'icon-maxcdn', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1825, '9b95e955-2472-480c-86f2-e534a78712fb', 'icon-medapps', 'icon-medapps', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1826, 'c509cbcf-608e-48a9-b994-9139d46c0922', 'icon-medium-m', 'icon-medium-m', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1827, 'f76645f3-4079-437f-a2af-7f5199ef2264', 'icon-medium', 'icon-medium', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1828, '6729ad0d-6fba-4659-9e0d-e2ede1c440dc', 'icon-medrt', 'icon-medrt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1829, '09da524e-a9f5-4162-bd06-e2d5de827940', 'icon-meetup', 'icon-meetup', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1830, 'b8035e41-322a-4cc9-ba29-6ca39f8a0738', 'icon-megaport', 'icon-megaport', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1831, '0704197a-f873-4195-bd0f-21dc706ae01e', 'icon-microsoft', 'icon-microsoft', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1832, 'a3fe272f-ead3-40d4-a14c-e9c9a80e648c', 'icon-mix', 'icon-mix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1833, 'c84db128-9d0a-45a1-af20-eb12f9c55341', 'icon-mixcloud', 'icon-mixcloud', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1834, 'eadb4495-6edb-4e76-a280-7659f48f9057', 'icon-mizuni', 'icon-mizuni', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1835, '7b419716-d769-4fe2-a2cc-e713716004c4', 'icon-modx', 'icon-modx', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1836, '3d4885b4-d34a-4901-93d6-ced6fee39c76', 'icon-monero', 'icon-monero', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1837, '505550ce-d17b-4f1f-9a67-3cd3d1dbadf5', 'icon-napster', 'icon-napster', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1838, 'cf39939d-3c45-44fb-a296-7a7c61238c53', 'icon-neos', 'icon-neos', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1839, 'c0ca83a9-6577-4ad5-93f5-ba28ec9bbd2f', 'icon-nimblr', 'icon-nimblr', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1840, 'fa99741c-6958-420a-b3f8-bedb41baac50', 'icon-nintendo-switch', 'icon-nintendo-switch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1841, '3d95e314-de1e-415a-aaa6-1f6f39f1a790', 'icon-node-js', 'icon-node-js', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1842, '6664b764-7ec8-4eff-9e26-ce6276c89963', 'icon-node', 'icon-node', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1843, 'a9b7eefc-2381-4cc1-a34f-1a759aad73a0', 'icon-npm', 'icon-npm', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1844, '8bfec160-091a-4bcc-b378-2f2e31f9b9d7', 'icon-ns8', 'icon-ns8', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1845, '35ab2c08-7af0-41ec-bdd0-2841cc322040', 'icon-nutritionix', 'icon-nutritionix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1846, '17ea72fa-333c-4df6-aa08-c2281c4c8a50', 'icon-odnoklassniki-square', 'icon-odnoklassniki-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1847, 'ba351d51-e037-4d79-b4fc-cc4624cfda68', 'icon-odnoklassniki', 'icon-odnoklassniki', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1848, '83ef04ff-fe2e-44b0-b168-e407d0c3129a', 'icon-old-republic', 'icon-old-republic', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1849, '10051c43-2473-4f0c-9d0e-6af2f57d40e1', 'icon-opencart', 'icon-opencart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1850, 'b391b7db-aacb-43ce-b873-c114a1cf8271', 'icon-openid', 'icon-openid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1851, 'd44a4507-c734-4661-aaea-f445c1dcbae5', 'icon-opera', 'icon-opera', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1852, '91bbf735-4f05-43e4-a509-e3ca21b4016a', 'icon-optin-monster', 'icon-optin-monster', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1853, '49727462-52f2-4b59-98dd-bb65a49ad28a', 'icon-osi', 'icon-osi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1854, 'fcdc98d5-c44e-4a3e-ae02-4210b18afdbf', 'icon-page4', 'icon-page4', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1855, '999c4aee-0b09-4470-83dc-a84dad325664', 'icon-pagelines', 'icon-pagelines', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1856, '540dcaf2-11f0-4afb-b4d3-b04d0a170c7e', 'icon-palfed', 'icon-palfed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1857, 'cd21744c-54c4-4e97-87e6-894d0b62d61b', 'icon-patreon', 'icon-patreon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1858, '73f8d910-b5f6-459e-8f0b-4151695ffc76', 'icon-paypal', 'icon-paypal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1859, 'd9ffd353-bd32-49a8-be6f-52129cbe03f5', 'icon-periscope', 'icon-periscope', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1860, '804aef33-4c16-4e14-bba8-6f09f0dc9731', 'icon-phabricator', 'icon-phabricator', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1861, 'a8117b6f-c81d-4930-a51c-dc1a5fd670af', 'icon-phoenix-framework', 'icon-phoenix-framework', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1862, 'b1104221-03aa-42f3-b4bc-20408301ee0e', 'icon-phoenix-squadron', 'icon-phoenix-squadron', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1863, '22d23558-34a4-4243-bd9d-f2da13d25db2', 'icon-php', 'icon-php', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1864, 'e5352173-c7c4-4b7f-abbb-b2bdb21e9429', 'icon-pied-piper-alt', 'icon-pied-piper-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1865, '95ffb4ef-15c4-4e71-abe0-068bb79e121a', 'icon-pied-piper-hat', 'icon-pied-piper-hat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1866, '8d2698cc-815e-43fb-bc34-2b06113fb60f', 'icon-pied-piper-pp', 'icon-pied-piper-pp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1867, '50e43423-006e-452f-ac52-8d682a8a10b1', 'icon-pied-piper', 'icon-pied-piper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1868, '240c76fe-15a6-445c-97ee-cb32454267d2', 'icon-pinterest-p', 'icon-pinterest-p', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1869, 'ad8dcbf3-f89e-4d1f-a7ba-2b2e9e866167', 'icon-pinterest-square', 'icon-pinterest-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1870, 'b9869c34-6846-4d5b-b179-2e6c05599003', 'icon-pinterest', 'icon-pinterest', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1871, '54beea1e-0de0-4642-8f5a-8b34eec36ef1', 'icon-playstation', 'icon-playstation', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1872, 'b6b824ad-e149-4861-8f8e-ac95dfb28499', 'icon-product-hunt', 'icon-product-hunt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1873, 'c7bfc13f-ed1c-41b9-bfe0-7db6ba00e9ac', 'icon-pushed', 'icon-pushed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1874, '4225aff0-2d50-4e02-9728-9686594042c6', 'icon-python', 'icon-python', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1875, '89132a3b-2bee-4464-bab1-739aaa775c12', 'icon-qq', 'icon-qq', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1876, '1c09e6f5-b3fe-4c1f-b5d7-b3201a02f250', 'icon-quinscape', 'icon-quinscape', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1877, '03cdd18e-dd7d-4793-9df7-2374cded0c6c', 'icon-quora', 'icon-quora', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1878, 'd56b7c3b-abb9-4705-b95c-4c4444c35505', 'icon-r-project', 'icon-r-project', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1879, '3ede0a8f-1314-40a9-a853-cea00fdb4997', 'icon-ravelry', 'icon-ravelry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1880, '0ae7c5d8-b838-4a8f-9fe9-024c23b63e75', 'icon-react', 'icon-react', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1881, 'd71ae417-8bf6-4557-9675-d937ce1e1814', 'icon-readme', 'icon-readme', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1882, 'ce0e9912-d332-40ab-8def-2c732c06ee0e', 'icon-rebel', 'icon-rebel', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1883, 'c195ff91-7dfe-4046-bad3-a7f4cfc4870f', 'icon-red-river', 'icon-red-river', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1884, 'd615c410-231d-46ee-838a-6bf0630893d7', 'icon-reddit-alien', 'icon-reddit-alien', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1885, '41ae53a9-9d5e-45e4-9a29-18c2d662dd8c', 'icon-reddit-square', 'icon-reddit-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1886, '57be072f-91f3-47ba-82c2-cd5b77d3c6c6', 'icon-reddit', 'icon-reddit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1887, '7f980f5a-b8cc-490a-a9b4-d958144c4f3b', 'icon-rendact', 'icon-rendact', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1888, '8a7ab3c4-74eb-4017-bdd2-fa0879cb0fb2', 'icon-renren', 'icon-renren', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1889, '1971aad9-29c7-4049-ab60-12cdbf468679', 'icon-replyd', 'icon-replyd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1890, '3714eba6-eed4-4629-bd04-e885e4544bc8', 'icon-researchgate', 'icon-researchgate', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1891, '59fe2f3e-66c4-4f66-b4d9-3c2423ba3f6a', 'icon-resolving', 'icon-resolving', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1892, '60833dff-d71f-4937-94d5-8aeb31102fdf', 'icon-rev', 'icon-rev', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1893, '04321fc6-8936-4fbb-984c-4d9e36abb29f', 'icon-rocketchat', 'icon-rocketchat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1894, 'f4c62ab4-4988-4a30-8c6e-1eb65645c88e', 'icon-rockrms', 'icon-rockrms', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1895, '0e81226c-fbd1-4853-99a6-3d3beb6d54a2', 'icon-safari', 'icon-safari', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1896, '36b845e2-965e-4765-8f5a-93c3d670e94b', 'icon-sass', 'icon-sass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1897, 'd6eed64f-3035-4c52-acb8-bd39a3784307', 'icon-schlix', 'icon-schlix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1898, '5be88517-b3f6-412a-8382-f8dcf96d90d4', 'icon-scribd', 'icon-scribd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1899, '5fbf1982-0c64-4a65-9d74-27162227682d', 'icon-searchengin', 'icon-searchengin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1900, '5646a6ff-a972-4b42-91d3-0343c56eb5e2', 'icon-sellcast', 'icon-sellcast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1901, 'a0ba7d23-0c1e-4b95-8ef7-ebc1ddb43e90', 'icon-sellsy', 'icon-sellsy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1902, '5c94ed96-65a3-4435-a930-8027991b3444', 'icon-servicestack', 'icon-servicestack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1903, '396ee592-3df8-4060-b544-d3b56e353c9d', 'icon-shirtsinbulk', 'icon-shirtsinbulk', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1904, 'd5b8d15a-d73b-4589-b78b-18d356a4bfbd', 'icon-shopware', 'icon-shopware', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1905, 'c587413f-7727-4e64-83e0-2860b1845740', 'icon-simplybuilt', 'icon-simplybuilt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1906, 'fb9a4222-0891-4dd6-9b19-5ed0e57df9a1', 'icon-sistrix', 'icon-sistrix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1907, 'bc062eb5-47cf-4623-8114-792992a4e452', 'icon-sith', 'icon-sith', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1908, '8fa15434-bc5d-4bf9-a50f-618811b89c77', 'icon-skyatlas', 'icon-skyatlas', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1909, '471b4670-e751-46ea-b5e6-c5582e7dd1c1', 'icon-skype', 'icon-skype', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1910, 'eb99ab4d-533e-423d-b5b1-3ed717ca774c', 'icon-slack-hash', 'icon-slack-hash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1911, '3aed48ca-9e80-452a-ae8f-b54ef1f6b3c4', 'icon-slack', 'icon-slack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1912, '43685f3b-8b55-41d8-8f46-f15d0013b9e6', 'icon-slideshare', 'icon-slideshare', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1913, '37bf3822-1e26-434f-a9d0-e9d896814dae', 'icon-snapchat-ghost', 'icon-snapchat-ghost', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1914, 'e2164b6a-0493-4234-8d5e-06b13a9a6bfc', 'icon-snapchat-square', 'icon-snapchat-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1915, '02986288-cd51-459a-9278-f85dee650f07', 'icon-snapchat', 'icon-snapchat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1916, '26c5c09d-6f7f-47b5-985c-993935a2543f', 'icon-soundcloud', 'icon-soundcloud', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1917, '2ed437cf-eb1d-4902-aa60-a761e9760746', 'icon-speakap', 'icon-speakap', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1918, 'd58d97c4-f4c8-4111-8627-c2adc08f4614', 'icon-spotify', 'icon-spotify', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1919, '67163423-85ca-4196-af6b-1721adf4dc81', 'icon-squarespace', 'icon-squarespace', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1920, '8fcb5d7a-eef8-495b-ba34-c15ebed6e60c', 'icon-stack-exchange', 'icon-stack-exchange', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1921, 'c32f7db6-3069-4312-b6d8-93868fc3d7ce', 'icon-stack-overflow', 'icon-stack-overflow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1922, 'b8f52af8-4c42-49b3-bfa4-1d25a7b90b4b', 'icon-staylinked', 'icon-staylinked', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1923, 'f751ae4b-0628-4c0f-96ff-54b853cf9941', 'icon-steam-square', 'icon-steam-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1924, 'f71cfc21-9e10-46fc-af22-7eeeb163c40f', 'icon-steam-symbol', 'icon-steam-symbol', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1925, '8d58c453-718b-431b-a340-9eed2cd7e788', 'icon-steam', 'icon-steam', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1926, '7e2528d5-b036-4711-bea7-c97143c52741', 'icon-sticker-mule', 'icon-sticker-mule', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1927, '361ceba3-b1c6-42c4-82fd-022c28359693', 'icon-strava', 'icon-strava', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1928, '2dc5a7fc-06a3-4667-b0da-6e351f7f498a', 'icon-stripe-s', 'icon-stripe-s', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1929, 'c74057ca-b46f-4892-8e9f-965937a2bd37', 'icon-stripe', 'icon-stripe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1930, '90475b1f-2e2c-4034-8158-6cd60ea86bb4', 'icon-studiovinari', 'icon-studiovinari', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1931, '59f7c925-9e25-467b-97c7-b2d820362a47', 'icon-stumbleupon-circle', 'icon-stumbleupon-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1932, 'f87e5fce-f01e-49c0-8efe-6cfff77b2212', 'icon-stumbleupon', 'icon-stumbleupon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1933, '34c156c8-86f0-457e-8799-c1dbe8b33d2e', 'icon-superpowers', 'icon-superpowers', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1934, '19c315d1-6e56-4e30-be20-2eee36d54075', 'icon-supple', 'icon-supple', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1935, '40c8d8a9-65e3-4efc-a2da-b43ec1e5dbd1', 'icon-teamspeak', 'icon-teamspeak', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1936, '71484691-9646-4e08-a407-931604700fe7', 'icon-telegram-plane', 'icon-telegram-plane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1937, 'c2152e77-232c-4c89-be4e-44a7086852ab', 'icon-telegram', 'icon-telegram', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1938, 'b8210d18-0130-49e8-b834-7cb701bc55f0', 'icon-tencent-weibo', 'icon-tencent-weibo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1939, 'a095337a-ac20-4599-a438-deacc22f7b39', 'icon-the-red-yeti', 'icon-the-red-yeti', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1940, 'fc79c8f0-abfd-4c42-b3b2-f1a736a19be4', 'icon-themeco', 'icon-themeco', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1941, 'f4534ccf-7cd4-4596-98d0-0d0cb20c0e15', 'icon-themeisle', 'icon-themeisle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1942, '7ec7de6a-d823-46df-ab4f-2391952751a0', 'icon-trade-federation', 'icon-trade-federation', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1943, '7bb69b81-14fd-4f6b-a8be-39691a19077f', 'icon-trello', 'icon-trello', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1944, 'cad07cbd-dffd-4a6d-922f-53944ed9cc89', 'icon-tripadvisor', 'icon-tripadvisor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1945, 'b02a6629-2f7f-4ada-a24e-962c8553ac3c', 'icon-tumblr-square', 'icon-tumblr-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1946, '51c16c7f-ab35-495a-9b92-04e0b7cf7ad6', 'icon-tumblr', 'icon-tumblr', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1947, '5419bad6-f535-473c-a226-150ae4297b16', 'icon-twitch', 'icon-twitch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1948, 'a25b8b0d-d44e-4286-a24e-288db1144e60', 'icon-twitter-square', 'icon-twitter-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1949, 'edc90287-630f-4b90-801e-af3cbc560dec', 'icon-twitter', 'icon-twitter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1950, '2397523b-0ea3-41d2-92ce-37fa9b8895ac', 'icon-typo3', 'icon-typo3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1951, '3cc636df-95f6-47c7-871a-9470ce581323', 'icon-uber', 'icon-uber', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1952, '7af32a69-5914-4c50-a1b3-47f1bbab425d', 'icon-uikit', 'icon-uikit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1953, '81349909-b6c4-4a27-bec7-698d8c2432c7', 'icon-uniregistry', 'icon-uniregistry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1954, '4daff741-f525-4b4a-a4a9-e23582b0e1a0', 'icon-untappd', 'icon-untappd', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1955, '3a5e70b6-fa65-4056-b6f7-cb0ab16016bb', 'icon-usb', 'icon-usb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1956, '011ab8a4-99dd-4e3e-ae2f-b775a732f3ec', 'icon-ussunnah', 'icon-ussunnah', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1957, 'b7206209-c060-484f-a1ee-69fa2a48d701', 'icon-vaadin', 'icon-vaadin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1958, '6dbd6f67-5e33-4298-bcaf-a690e38106a4', 'icon-viacoin', 'icon-viacoin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1959, '065583dd-4b30-4d4a-a1e9-ff3aea83ca7b', 'icon-viadeo-square', 'icon-viadeo-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1960, '6d3802ca-29e9-4045-ac14-8bba0a0c1da1', 'icon-viadeo', 'icon-viadeo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1961, '8c540644-03ec-4057-928d-125b66b6c09d', 'icon-viber', 'icon-viber', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1962, '737c60e9-8556-47c1-9f3d-02c10dfec433', 'icon-vimeo-square', 'icon-vimeo-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1963, '02ea9763-8f0a-4f93-8dc1-3c631144558f', 'icon-vimeo-v', 'icon-vimeo-v', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1964, '665823be-9158-4ff9-9fb9-e755680f4401', 'icon-vimeo', 'icon-vimeo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1965, 'a66ea7c3-830c-49a6-8336-56c88f7a4ee3', 'icon-vine', 'icon-vine', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1966, '91b6b196-380e-4d28-92bd-0e11d5a27f35', 'icon-vk', 'icon-vk', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1967, '72a89375-c825-4479-98e1-ca3ed07f47b5', 'icon-vnv', 'icon-vnv', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1968, '657ccff6-c804-4d74-895f-50108d6789f6', 'icon-vuejs', 'icon-vuejs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1969, 'e8179b73-2f0f-4f4f-966d-9201dde895bd', 'icon-weebly', 'icon-weebly', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1970, '3ba5d35c-5804-4e45-8e8d-4f2e455e1cb2', 'icon-weibo', 'icon-weibo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1971, 'e2631e63-8681-43b1-8e8d-7fc9f444a900', 'icon-weixin', 'icon-weixin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1972, '71390e71-2d0d-4d0d-b338-c6d741ec6218', 'icon-whatsapp-square', 'icon-whatsapp-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1973, '88261a38-501e-4beb-871b-29ce58ee3e32', 'icon-whatsapp', 'icon-whatsapp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1974, '5cd88282-8148-407f-93b7-b1fcd952c8db', 'icon-whmcs', 'icon-whmcs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1975, '958b7a26-7734-4fa4-8948-b3df48f253ff', 'icon-wikipedia-w', 'icon-wikipedia-w', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1976, 'b66ac4d0-dc78-4f62-af96-f07e4a3d3a60', 'icon-windows', 'icon-windows', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1977, '80bd3bac-709e-4486-b6d3-829836cbc303', 'icon-wix', 'icon-wix', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1978, '5fbb1df9-0729-4251-8149-d1ae0a9f01b7', 'icon-wolf-pack-battalion', 'icon-wolf-pack-battalion', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1979, '55267a3f-297c-45b0-945d-09a4e4f94602', 'icon-wordpress-simple', 'icon-wordpress-simple', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1980, '4bface96-3a2e-4cfd-957e-5d54bf09e25b', 'icon-wordpress', 'icon-wordpress', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1981, '0afa293c-ad86-4b74-a0bb-5c8d1b5e3b89', 'icon-wpbeginner', 'icon-wpbeginner', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1982, '06a5e295-8483-455a-9414-a51ba60d874b', 'icon-wpexplorer', 'icon-wpexplorer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1983, '09acd613-d878-47c9-98b4-f5f5f225cc43', 'icon-wpforms', 'icon-wpforms', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1984, '0092cd2a-6221-4ee4-85af-f779f40a7b17', 'icon-xbox', 'icon-xbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1985, 'b1b1b3ce-23d9-49ab-b47d-04b6727f3d90', 'icon-xing-square', 'icon-xing-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1986, 'f0bd6a5a-1d3c-4325-bc40-9c1c8e8b45ee', 'icon-xing', 'icon-xing', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1987, 'cf60c53d-f3e1-44d4-8156-5e7ca007885e', 'icon-y-combinator', 'icon-y-combinator', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1988, 'ba12fa2a-32e5-4bee-b491-197364b1415b', 'icon-yahoo', 'icon-yahoo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1989, '65f3dad4-1bf3-4a5f-920f-fca4487c820b', 'icon-yandex-international', 'icon-yandex-international', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1990, '2b75b480-e339-496b-8492-a7faf80cfaf6', 'icon-yandex', 'icon-yandex', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1991, 'a697753b-083d-4878-a87a-3ad192e391b8', 'icon-yelp', 'icon-yelp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1992, '8f3ee59d-ec75-4980-aa56-d0d1d53b5ba3', 'icon-yoast', 'icon-yoast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1993, '3f050216-7edf-444f-994b-4d5643abd839', 'icon-youtube-square', 'icon-youtube-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1994, 'e9cee54a-1c71-4a56-b8d3-9b8f7c2090e0', 'icon-youtube', 'icon-youtube', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1995, '00227fb1-23d9-4903-b9c9-b7a3e9998834', 'icon-zhihu', 'icon-zhihu', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1996, '301e032e-aa8f-48fc-8e36-ca367dde26cf', 'icon-line-open', 'icon-line-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1997, 'b2d93277-60b0-4031-b7d7-b0a3feccbd46', 'icon-line-bag', 'icon-line-bag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1998, 'eed720ca-1f93-41e8-abcd-f82df240b523', 'icon-line-grid-2', 'icon-line-grid-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(1999, '29705391-5605-49e8-a930-cd092b89bb92', 'icon-line-content-left', 'icon-line-content-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2000, 'ca0f6408-d35b-47d2-bc2f-cfebd39b16d4', 'icon-line-content-right', 'icon-line-content-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2001, 'f817aee5-de72-4b3b-a735-37063c420b1b', 'icon-line-esc', 'icon-line-esc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2002, '5032028e-581d-49a8-9c84-2e46bd17b78e', 'icon-line-alt', 'icon-line-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2003, 'da4fdb71-e99e-4652-baee-5720861d4893', 'icon-line-marquee-plus', 'icon-line-marquee-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2004, '6a2c8cf8-865d-4418-b6bc-bc20cf101612', 'icon-line-marquee-minus', 'icon-line-marquee-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2005, '5eabdcfe-5d7e-4428-8e39-0e50a267c6bf', 'icon-line-marquee', 'icon-line-marquee', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2006, '9ff3161a-d7bc-4775-aa2b-d3780cf2aa49', 'icon-line-square-check', 'icon-line-square-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2007, '3c4ea42a-e9fe-47e3-9a51-079d8af23890', 'icon-line-paragraph', 'icon-line-paragraph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2008, '67b75c7a-a18c-4e1f-96c1-95e455403d64', 'icon-line-ribbon', 'icon-line-ribbon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2009, '3fc3327a-c15c-4f6c-9281-3db3538f0435', 'icon-line-location-2', 'icon-line-location-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2010, '5f44857f-557f-4d86-b847-14162872a26f', 'icon-line-circle-check', 'icon-line-circle-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2011, '46ad5d77-51d2-4298-bad7-b578e1c816d4', 'icon-line-circle-cross1', 'icon-line-circle-cross1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2012, '59b2554a-95e0-4117-a681-62769e40f23a', 'icon-line-reply', 'icon-line-reply', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2013, '0d7f6f13-eafd-47b2-a71f-bbf5aa900d72', 'icon-line-paper-stack', 'icon-line-paper-stack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2014, '62077ea0-0d6a-4543-9440-7754f2946fbf', 'icon-line-stack-2', 'icon-line-stack-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2015, '82bd5e87-d776-4a38-8002-c36df7dc3ad2', 'icon-line-stack', 'icon-line-stack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2016, '136e7037-1857-439c-b36a-ef0a0a039d41', 'icon-line-activity', 'icon-line-activity', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2017, '9c74065d-da01-43cc-8554-c19832292bad', 'icon-line-air-play', 'icon-line-air-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2018, 'cbd4c58f-8150-47f8-aa06-5871a7b78a8d', 'icon-line-alert-circle', 'icon-line-alert-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2019, '7e43cb40-bd0f-46d9-a0be-982dbd560258', 'icon-line-alert-octagon', 'icon-line-alert-octagon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2020, 'f8ce367f-0c84-40ca-9c75-d504eed3df4f', 'icon-line-alert-triangle', 'icon-line-alert-triangle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2021, '4c007452-98eb-428f-900c-165c9954ad13', 'icon-line-align-center', 'icon-line-align-center', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2022, '8c6147a9-6ed3-4151-bffb-fe98edefb9bf', 'icon-line-align-justify', 'icon-line-align-justify', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2023, 'c17c35e1-ad46-4b2e-8946-3980eac01e9f', 'icon-line-align-left', 'icon-line-align-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2024, '452c66e6-e7c5-4cec-a886-492968d99535', 'icon-line-align-right', 'icon-line-align-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2025, 'd2a6d50a-15df-4f58-9893-096607edf85a', 'icon-line-anchor', 'icon-line-anchor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2026, 'd47790c4-fd02-4988-a873-665a4e67ea73', 'icon-line-aperture', 'icon-line-aperture', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2027, '83053b64-48fc-4300-b686-5b023876b233', 'icon-line-archive', 'icon-line-archive', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2028, '96daa0f9-7238-475d-b110-7d52ba76eff9', 'icon-line-arrow-down', 'icon-line-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2029, 'bc73e444-0c69-46da-b008-ce84514c87c7', 'icon-line-arrow-down-circle', 'icon-line-arrow-down-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2030, '9b7f1048-0fa9-4313-9c83-71fece810675', 'icon-line-arrow-down-left', 'icon-line-arrow-down-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2031, '41e4c662-3ce5-49f5-bfd9-4ce6cb605091', 'icon-line-arrow-down-right', 'icon-line-arrow-down-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2032, 'bd9bd424-f8aa-40f0-9dad-4889b65b0ca0', 'icon-line-arrow-left', 'icon-line-arrow-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2033, 'b3396074-5c54-4d2c-8f88-b1caa5fda4f4', 'icon-line-arrow-left-circle', 'icon-line-arrow-left-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2034, '1931bdcf-d578-4c5b-80e6-74ec9b86efe1', 'icon-line-arrow-right', 'icon-line-arrow-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2035, 'cc87ea88-6c4d-481a-af01-d4033ea53a1c', 'icon-line-arrow-right-circle', 'icon-line-arrow-right-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2036, 'd582ff9a-65e0-46f1-a83a-ae1c07fb1ffe', 'icon-line-arrow-up', 'icon-line-arrow-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2037, 'e8367946-aaf9-42f7-a00a-e18aed238ed6', 'icon-line-arrow-up-circle', 'icon-line-arrow-up-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2038, '1ac07958-1740-4951-a272-9624d63cc59f', 'icon-line-arrow-up-left', 'icon-line-arrow-up-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2039, '0e388204-dd3a-4f3f-bc05-6bf30b094045', 'icon-line-arrow-up-right', 'icon-line-arrow-up-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2040, 'ebbe09ec-0c17-4010-bd60-fb8fae15b7be', 'icon-line-at-sign', 'icon-line-at-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2041, '06b67624-f32c-42ae-91b8-75fd0d41a518', 'icon-line-award', 'icon-line-award', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2042, '42093324-1017-47a7-add2-66864bedbca8', 'icon-line-bar-graph', 'icon-line-bar-graph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2043, '00e953d2-2aab-4c32-80e5-23a6c3264232', 'icon-line-bar-graph-2', 'icon-line-bar-graph-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2044, '70266d3d-cc62-463b-a831-ff2c4e6c5b9d', 'icon-line-battery', 'icon-line-battery', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2045, 'd17539a8-c609-4b2f-807f-5198012a61be', 'icon-line-battery-charging', 'icon-line-battery-charging', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2046, 'e76da9fb-5197-4be6-bd9d-7923938a206f', 'icon-line-bell', 'icon-line-bell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2047, 'ddffa43f-4181-4858-a5dc-5ada06774f32', 'icon-line-bell-off', 'icon-line-bell-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2048, 'a4d415e5-3766-4b66-9b02-aeeb8bcc30c8', 'icon-line-bluetooth', 'icon-line-bluetooth', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2049, '084b2d06-47a0-4ab1-ae04-98edeecdc770', 'icon-line-bold', 'icon-line-bold', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2050, '2d678767-a80c-465e-b4be-44ae45c117bf', 'icon-line-book', 'icon-line-book', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2051, 'b97400d7-47f9-40a4-bc15-8bd54052417d', 'icon-line-book-open', 'icon-line-book-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2052, '7c452f76-5abb-484f-aa1e-ddd82f78907b', 'icon-line-bookmark', 'icon-line-bookmark', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2053, '40500428-e82e-4f82-8bf3-85f95bd579d8', 'icon-line-box', 'icon-line-box', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2054, '23be50ba-ee9f-4994-bdf4-1e5ba2d958b4', 'icon-line-briefcase', 'icon-line-briefcase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2055, 'a5c8fcec-c262-4669-9516-f6909921c642', 'icon-line-calendar', 'icon-line-calendar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2056, '11f7af62-ad42-4420-9d36-66f2a2a5cf48', 'icon-line-camera', 'icon-line-camera', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2057, '6d63e7b4-5883-45f8-afc5-1ef97efe0877', 'icon-line-camera-off', 'icon-line-camera-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2058, 'b17d657f-c7fb-43fc-8e08-45cd8e6260b2', 'icon-line-cast', 'icon-line-cast', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2059, '02072cea-e5cc-4af4-9a1f-fdb67abc00af', 'icon-line-check', 'icon-line-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2060, '6194f50f-d072-411b-a1ba-2b41b5b2854a', 'icon-line-check-circle', 'icon-line-check-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2061, 'fbbcb944-94f8-4319-af83-d1cfbb9f8c4c', 'icon-line-check-square', 'icon-line-check-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2062, 'dc6bd4ce-b9d9-407a-b080-cca5e9992b6e', 'icon-line-chevron-down', 'icon-line-chevron-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2063, 'b0025e0e-4212-408b-9418-f81d98eb31d3', 'icon-line-chevron-left', 'icon-line-chevron-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2064, '4d7a9db0-cd9e-40e0-9847-d2cb77dff1f0', 'icon-line-chevron-right', 'icon-line-chevron-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2065, '9e0bb958-45bd-45f7-8e28-ac4f1a4d3776', 'icon-line-chevron-up', 'icon-line-chevron-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2066, 'b6b3f676-e6aa-49ad-a64f-b4d4bba289eb', 'icon-line-chevrons-down', 'icon-line-chevrons-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2067, 'b6ee530b-6b3f-4c5d-8f8c-72ce3c2208f2', 'icon-line-chevrons-left', 'icon-line-chevrons-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2068, 'b51d2de7-5b2b-40ca-ae14-e24b8e4d320a', 'icon-line-chevrons-right', 'icon-line-chevrons-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2069, 'f115b4df-19a8-471b-ad77-c5928f38fe7d', 'icon-line-chevrons-up', 'icon-line-chevrons-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2070, '5b367a8a-cd0d-4e0c-8940-f56c824545d6', 'icon-line-chrome', 'icon-line-chrome', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2071, 'de69a6a5-c0db-41cc-9ad2-f81c7a0d09aa', 'icon-line-record', 'icon-line-record', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2072, '568a688d-143e-47f8-8a0d-3740529af97c', 'icon-line-stop', 'icon-line-stop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2073, 'ae367427-7931-4bf1-a463-acf1a08de819', 'icon-line-clipboard', 'icon-line-clipboard', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2074, '1e10b931-02ab-40ca-be3b-d2e46f6c269b', 'icon-line-clock', 'icon-line-clock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2075, '89b860fd-299f-4f54-a311-73d8111264e8', 'icon-line-cloud', 'icon-line-cloud', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2076, '13576da3-b33c-48be-ad02-be59e0ef9034', 'icon-line-cloud-drizzle', 'icon-line-cloud-drizzle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2077, '39265ac6-0d0d-4b49-80fa-003bdcb7998d', 'icon-line-cloud-lightning', 'icon-line-cloud-lightning', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2078, '37531095-2551-4957-b5e7-ba0bcacc99b3', 'icon-line-cloud-off', 'icon-line-cloud-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2079, '1c1fcde7-ed56-49e4-a36b-eeac762b8afb', 'icon-line-cloud-rain', 'icon-line-cloud-rain', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2080, '55d2966d-0190-4535-8bf2-9c1388fbe462', 'icon-line-cloud-snow', 'icon-line-cloud-snow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2081, '1a1f9651-ead3-4cfc-ae23-a1b500ac55bd', 'icon-line-code', 'icon-line-code', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2082, '81055917-89c7-404b-bd10-091213992ec4', 'icon-line-codepen', 'icon-line-codepen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2083, '2bc7c3a5-3eb5-460b-8884-3fb8281c9b4f', 'icon-line-codesandbox', 'icon-line-codesandbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2084, 'de9a5ff1-ac20-42d7-afae-7ab495adf56a', 'icon-line-coffee', 'icon-line-coffee', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2085, '47dba7f0-3c54-4abe-a6b6-8edf3325f684', 'icon-line-columns', 'icon-line-columns', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2086, '923199e5-f367-4250-9f1e-43790c051f33', 'icon-line-command', 'icon-line-command', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2087, 'ed230dc6-523e-4279-9311-b2d07d43e963', 'icon-line-compass', 'icon-line-compass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2088, '02684ee7-2551-4d71-b3d2-6ca93d2a088f', 'icon-line-copy', 'icon-line-copy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2089, '1c88fc9b-aa20-46b7-8148-e186ce759289', 'icon-line-corner-down-left', 'icon-line-corner-down-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2090, '27376da1-f431-4a19-afe1-3d7cdb258f1c', 'icon-line-corner-down-right', 'icon-line-corner-down-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2091, 'dfafec74-94c6-4e68-b93a-31ea9a19192d', 'icon-line-corner-left-down', 'icon-line-corner-left-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2092, '195d3ecb-829a-4af4-a88b-22bbadc89fdd', 'icon-line-corner-left-up', 'icon-line-corner-left-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2093, '1f27da54-37ea-4f54-883b-3b6447d6d4e1', 'icon-line-corner-right-down', 'icon-line-corner-right-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2094, 'c7301bc8-a3d9-4b63-a70c-d8eab45c8030', 'icon-line-corner-right-up', 'icon-line-corner-right-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2095, '88d21b6c-6a00-417f-94fa-8edff61e986f', 'icon-line-corner-up-left', 'icon-line-corner-up-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2096, '551dfe38-ea28-4a1b-a7eb-9c5adb0e12ae', 'icon-line-corner-up-right', 'icon-line-corner-up-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2097, '70a8f0b2-a8c5-4353-9e77-7075d17c774a', 'icon-line-cpu', 'icon-line-cpu', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2098, '9cccd6ae-e71b-4e38-8e8e-70823665e4e5', 'icon-line-credit-card', 'icon-line-credit-card', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2099, '2916ae82-947e-40b6-a2f3-37ed9ae127e7', 'icon-line-crop', 'icon-line-crop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2100, '127cfdc4-a96f-48d1-9db7-31535a9ae31a', 'icon-line-crosshair', 'icon-line-crosshair', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2101, 'f066cd0b-cade-4550-9e24-83e36b4892f2', 'icon-line-database', 'icon-line-database', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2102, 'f9a24fd0-7a2c-4d71-9b2e-bb343716f924', 'icon-line-delete', 'icon-line-delete', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2103, 'c596f3fc-71a4-44a3-a648-e8dae16d1563', 'icon-line-disc', 'icon-line-disc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2104, 'f9613881-7097-46b7-9c8b-bd8b89d367a1', 'icon-line-dollar-sign', 'icon-line-dollar-sign', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2105, 'eca27f39-c006-42d6-b6ca-57c8c6cf012c', 'icon-line-download', 'icon-line-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2106, 'aa87deb3-6139-441f-856e-e81e3a9738a3', 'icon-line-cloud-download', 'icon-line-cloud-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2107, 'c5d71e25-b4cc-4fbb-af89-e511bdf08c38', 'icon-line-droplet', 'icon-line-droplet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2108, '5962e7e5-e065-4440-96da-66a31fcba0f7', 'icon-line-edit', 'icon-line-edit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2109, '0719adb9-0186-440e-be2d-e9832fe90b67', 'icon-line-edit-2', 'icon-line-edit-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2110, 'a6f13f16-0d8f-46bd-8e2c-02fd3415bc52', 'icon-line-edit-3', 'icon-line-edit-3', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2111, 'cba07435-3a3a-44a1-afd3-c4a68d525ace', 'icon-line-external-link', 'icon-line-external-link', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2112, '090b97ff-64c8-4816-b4ca-563315b51e62', 'icon-line-eye', 'icon-line-eye', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2113, '4f9da2b3-9e08-4a24-9084-064317392752', 'icon-line-eye-off', 'icon-line-eye-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2114, 'f6295a56-b5ed-497d-9a76-50d4cba8e61b', 'icon-line-facebook', 'icon-line-facebook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2115, '0a7795bd-5466-4949-9de8-39df1fd1a21f', 'icon-line-fast-forward', 'icon-line-fast-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2116, '534c26af-f894-4777-a34a-eb8f19d11703', 'icon-line-feather', 'icon-line-feather', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2117, '2beeaa46-45f2-4b28-8bef-8ea6d7cf0145', 'icon-line-figma', 'icon-line-figma', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2118, '292142eb-7a25-4a68-8e72-2f1aad0a443d', 'icon-line-file', 'icon-line-file', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2119, 'd9f69292-6b93-4367-a06b-20faeddb0376', 'icon-line-file-subtract', 'icon-line-file-subtract', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2120, '25cf569a-b804-4f68-ab71-801178222e04', 'icon-line-file-add', 'icon-line-file-add', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2121, 'c772216e-440e-4770-a341-06c2f8ac97c7', 'icon-line-paper', 'icon-line-paper', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2122, 'f4d3cac6-fe89-474e-aa3f-c98733cbdfec', 'icon-line-film', 'icon-line-film', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2123, 'a5e8cda7-4817-4489-83a1-82fd0f7fc2cc', 'icon-line-filter', 'icon-line-filter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2124, 'fe82a102-a51d-42fe-9844-479a0787cd12', 'icon-line-flag', 'icon-line-flag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2125, 'cb9d6ac1-83fe-4d3c-8514-09144e1d95c6', 'icon-line-folder', 'icon-line-folder', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2126, 'ac2dd9b2-461c-4d5d-95e7-02508e1d661e', 'icon-line-folder-minus', 'icon-line-folder-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2127, '56fbdc0a-d0fe-42a7-9e94-2347ec2dec27', 'icon-line-folder-plus', 'icon-line-folder-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(2128, 'a6d9a0fa-6330-4e80-80b2-c0b041126b5f', 'icon-line-framer', 'icon-line-framer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2129, 'bf43e1f8-6d28-4e9c-abc6-63f7452c9331', 'icon-line-frown', 'icon-line-frown', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2130, 'd5a290f6-ea1d-4da2-b12a-22a39e4116f9', 'icon-line-gift', 'icon-line-gift', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2131, '62280d0f-b725-45f8-b98f-ae0921102ded', 'icon-line-git-branch', 'icon-line-git-branch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2132, '3a1f92a9-fdf2-403f-831b-1167f6d67c3e', 'icon-line-git-commit', 'icon-line-git-commit', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2133, 'aaec616e-cc3a-455e-8631-699d3cf87721', 'icon-line-git-merge', 'icon-line-git-merge', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2134, 'efa99642-c09b-4e37-8058-45662b222440', 'icon-line-git-pull-request', 'icon-line-git-pull-request', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2135, '155edcef-1b01-4f7e-a159-917a5a1f1900', 'icon-line-github', 'icon-line-github', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2136, 'c1a29f9f-f7f9-4c75-bd33-5474e4ae924a', 'icon-line-gitlab', 'icon-line-gitlab', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2137, 'd0bd2043-6a2b-4154-8cdc-3f03144222ba', 'icon-line-globe', 'icon-line-globe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2138, '4d1cd9d4-b1be-408c-a4d5-49de8ddabcfd', 'icon-line-grid', 'icon-line-grid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2139, 'f8e1bb0e-76b3-4951-943f-41adc86206da', 'icon-line-hard-drive', 'icon-line-hard-drive', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2140, '64217810-b814-4282-849f-3d54aaf90743', 'icon-line-hash', 'icon-line-hash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2141, 'b775917d-93fe-4e6e-a1cc-c242b633dec5', 'icon-line-headphones', 'icon-line-headphones', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2142, '94b13284-7846-4084-af7b-4af6bf3d49af', 'icon-line-heart', 'icon-line-heart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2143, 'f973c51f-3264-4582-b2f9-98f0b3616a65', 'icon-line-help-circle', 'icon-line-help-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2144, 'db54b78e-a799-4a57-9727-87e712cba9ce', 'icon-line-hexagon', 'icon-line-hexagon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2145, '43a1df83-6aab-4f12-baa3-142f1ab1a99a', 'icon-line-home', 'icon-line-home', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2146, 'cb601d2d-2c1b-4c2d-b975-fae6bbe4c560', 'icon-line-image', 'icon-line-image', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2147, '2c0f788b-5d02-44da-9f5e-1b9405ac544d', 'icon-line-inbox', 'icon-line-inbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2148, 'a86b60bb-2ea1-4246-82db-12a5aa0ecd7d', 'icon-line-info', 'icon-line-info', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2149, '8e4f4607-48ef-4519-b676-e8bd9eb30c8a', 'icon-line-instagram', 'icon-line-instagram', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2150, '579fd59d-9d25-4afb-8c5c-e5c9dc952ba7', 'icon-line-italic', 'icon-line-italic', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2151, 'c1659511-e105-4819-9f9d-55847d092316', 'icon-line-key', 'icon-line-key', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2152, '7d8b2237-4a88-4455-84e4-117c39dfa773', 'icon-line-layers', 'icon-line-layers', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2153, '78a6797c-25df-41a8-973a-fc86097fb3a6', 'icon-line-layout', 'icon-line-layout', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2154, '1356d3d3-7dd4-42ec-8eca-705413a4bbf5', 'icon-line-help', 'icon-line-help', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2155, '07f0528e-adf7-440e-b88d-9fb648e24d16', 'icon-line-link', 'icon-line-link', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2156, 'bd46cf4a-1264-4005-a650-6caa6c7ea9bb', 'icon-line-link-2', 'icon-line-link-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2157, '93679a50-bacb-4d09-aaf4-ce76f85db6de', 'icon-line-linkedin', 'icon-line-linkedin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2158, '0057de4b-8cad-4365-9f3d-42317fe32fc6', 'icon-line-list', 'icon-line-list', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2159, '7a120f04-2eb2-4020-8ec4-0f247e7dd0cf', 'icon-line-loader', 'icon-line-loader', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2160, '0ab207e7-cc37-4426-bafd-7f6d07b8a6cb', 'icon-line-lock', 'icon-line-lock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2161, '418bdbbe-1392-4a50-a889-ac34511d3f2a', 'icon-line-log-in', 'icon-line-log-in', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2162, '8c973551-ff3f-4a8a-8105-68a21d165ddc', 'icon-line-log-out', 'icon-line-log-out', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2163, '6a12185f-5a76-4a0a-bb2b-8e8bf13c2dad', 'icon-line-mail', 'icon-line-mail', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2164, '1c5fddab-557d-44e0-a656-835048b5f1ba', 'icon-line-map', 'icon-line-map', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2165, '3f00512e-d323-4901-804f-c1145ae7fe5d', 'icon-line-map-pin', 'icon-line-map-pin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2166, '682ec811-00be-430e-b939-4f0f520a3369', 'icon-line-expand', 'icon-line-expand', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2167, 'a362d8ba-28cd-4dcb-b8f6-62df1941f847', 'icon-line-maximize', 'icon-line-maximize', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2168, '37c0a8db-3ae9-4f90-85be-a02ba77a7a60', 'icon-line-meh', 'icon-line-meh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2169, '096d9640-8224-4ac4-8c43-b39d194a8f67', 'icon-line-menu', 'icon-line-menu', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2170, '8a468948-9a38-4b83-b9cf-46f7d9d79d7d', 'icon-line-message-circle', 'icon-line-message-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2171, '02d9d542-96af-4bc8-bb3a-8b5fb592fe9b', 'icon-line-speech-bubble', 'icon-line-speech-bubble', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2172, 'f36ff2ac-7851-4e4e-9adc-3447e27237b5', 'icon-line-microphone', 'icon-line-microphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2173, 'f717ee3d-2a13-4b6f-aa0d-a91355ac6bec', 'icon-line-microphone-off', 'icon-line-microphone-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2174, '51298ba3-e6f1-4076-a7c5-416b1dd423f7', 'icon-line-contract', 'icon-line-contract', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2175, '69649623-4c6f-4d92-803c-b0dc2afeacec', 'icon-line-minimize', 'icon-line-minimize', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2176, '69b0e6cf-d609-40c2-bb40-492ede160d44', 'icon-line-minus', 'icon-line-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2177, '72f4e58c-2e73-4f76-81e4-f1de3f34df62', 'icon-line-circle-minus', 'icon-line-circle-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2178, 'dda02174-3e9f-4716-ac39-ff62225711fb', 'icon-line-square-minus', 'icon-line-square-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2179, '925704de-4ae8-41e1-b7ed-c76128d32887', 'icon-line-monitor', 'icon-line-monitor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2180, '893e996f-4c2b-4b71-ad57-0c4badf58a05', 'icon-line-moon', 'icon-line-moon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2181, '1c3d565a-7206-4949-92ac-f0d4c79ff9de', 'icon-line-more-horizontal', 'icon-line-more-horizontal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2182, '0dd69d98-c979-43c0-92f1-1db8c8542f69', 'icon-line-ellipsis', 'icon-line-ellipsis', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2183, 'f11659d7-f9d7-4caa-a2f8-9a1d2c2cbb4e', 'icon-line-more-vertical', 'icon-line-more-vertical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2184, 'b9dd50fa-1bf5-48f7-a870-621c95dbdab5', 'icon-line-mouse-pointer', 'icon-line-mouse-pointer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2185, '61bbe7c1-895b-4f12-93d5-3ce18f1c42f4', 'icon-line-move', 'icon-line-move', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2186, '48cf0325-e52d-4a17-90db-343d8931e125', 'icon-line-music', 'icon-line-music', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2187, 'e77b8556-42f0-4d8b-b1c2-938a11f9aab1', 'icon-line-location', 'icon-line-location', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2188, '478191d2-2d5b-47e7-a22e-34419ebfb8e7', 'icon-line-navigation', 'icon-line-navigation', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2189, '0ddcfc88-33c6-4bc9-be34-3319ae81e989', 'icon-line-octagon', 'icon-line-octagon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2190, '97ae3a7e-ba11-4bdb-8fe9-8439a23cfd81', 'icon-line-package', 'icon-line-package', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2191, '2262606d-980d-4cee-a72d-5b21e91641f0', 'icon-line-paper-clip', 'icon-line-paper-clip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2192, '8c564c68-9a4b-4641-9eec-6b4af2da5eb9', 'icon-line-pause', 'icon-line-pause', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2193, '2c794476-7725-45e4-a695-38a95264cff1', 'icon-line-pause-circle', 'icon-line-pause-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2194, '1320298a-ab10-44a5-b063-3a499931cdcd', 'icon-line-pen-tool', 'icon-line-pen-tool', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2195, 'cce04215-1f6c-41bb-a6ab-65ad5a339761', 'icon-line-percent', 'icon-line-percent', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2196, '56f55123-d128-4961-8cec-5db7e27418eb', 'icon-line-phone', 'icon-line-phone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2197, 'de99afb8-e643-4253-8de3-cf83c2ac71ec', 'icon-line-phone-call', 'icon-line-phone-call', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2198, '7018de7c-49ea-4f5b-b6b6-652493462704', 'icon-line-phone-forwarded', 'icon-line-phone-forwarded', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2199, '42066f04-82c1-4ab7-9334-f9842c514b2e', 'icon-line-phone-incoming', 'icon-line-phone-incoming', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2200, '5eba6521-75b1-4cf7-b520-0874fdaaafb0', 'icon-line-phone-missed', 'icon-line-phone-missed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2201, '982f092f-99b9-4bb6-943d-a16fe6b2b8f3', 'icon-line-phone-off', 'icon-line-phone-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2202, '74adeb24-69e9-424c-b25b-01014c2a7682', 'icon-line-phone-outgoing', 'icon-line-phone-outgoing', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2203, '4d6a13c6-e427-4ec8-849a-6454b0966af4', 'icon-line-pie-graph', 'icon-line-pie-graph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2204, 'e8fbb678-01a5-4d24-a2a5-c5afb2100455', 'icon-line-play', 'icon-line-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2205, 'e6624c46-bcca-43b1-9289-22ab8c7e9b7e', 'icon-line-play-circle', 'icon-line-play-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2206, 'b73eaedd-c2c4-486d-a2c2-8f246e1a6780', 'icon-line-plus', 'icon-line-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2207, '9b217444-e8e0-4895-a2a8-3c5948713272', 'icon-line-circle-plus', 'icon-line-circle-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2208, '4e2fd318-5a4b-4bce-a41c-b72c30589f5d', 'icon-line-square-plus', 'icon-line-square-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2209, 'aee44b65-aa0f-41bf-9e04-e1e0486f58fe', 'icon-line-pocket', 'icon-line-pocket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2210, '1d33804f-2765-40f0-b98d-b5ec7b9d03b6', 'icon-line-power', 'icon-line-power', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2211, '9601e808-3db6-4798-8b7a-31eb4fd8c4bc', 'icon-line-printer', 'icon-line-printer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2212, '261fce31-c65f-4810-b654-f1e3a4d91649', 'icon-line-signal', 'icon-line-signal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2213, 'a2328067-edb3-48bf-af3e-14859ca86739', 'icon-line-refresh-ccw', 'icon-line-refresh-ccw', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2214, '3c5d07e4-3f32-4df8-b626-52d46ec3d736', 'icon-line-refresh-cw', 'icon-line-refresh-cw', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2215, 'b789dc2c-d85d-4e4f-b25f-a7474dc5219b', 'icon-line-repeat', 'icon-line-repeat', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2216, '25dfe10a-8b85-475a-bda2-ee31cfa63b69', 'icon-line-rewind', 'icon-line-rewind', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2217, '078b786f-2f93-4ca3-b7fd-f31de4d7def5', 'icon-line-reload', 'icon-line-reload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2218, '30b87005-298b-4b5f-9a7c-2900d2e3546e', 'icon-line-rotate-cw', 'icon-line-rotate-cw', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2219, '00eb29df-a9a4-4d26-92ed-2584c5da0990', 'icon-line-rss', 'icon-line-rss', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2220, '937924dc-0f85-43a3-b242-f93e0d0bbec3', 'icon-line-save', 'icon-line-save', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2221, '360b8274-bc17-40d2-ae95-860faa932514', 'icon-line-scissors', 'icon-line-scissors', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2222, '52b2da41-7caf-4c0d-9292-4ea87251d440', 'icon-line-search', 'icon-line-search', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2223, 'e1d02d86-bdad-4b9d-969c-fd313b28ee88', 'icon-line-send', 'icon-line-send', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2224, 'a2774580-d70f-4726-b505-d45c859fd26d', 'icon-line-server', 'icon-line-server', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2225, 'bc510946-b3b6-42cf-9765-acaad08b1324', 'icon-line-cog', 'icon-line-cog', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2226, '4bd210d6-bfca-4409-9f94-64181445b29f', 'icon-line-outbox', 'icon-line-outbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2227, 'bff0abd3-f1ab-4ea3-83b6-50589b1103cb', 'icon-line-share', 'icon-line-share', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2228, 'e973594c-ab1c-49b8-8f84-49126f42866f', 'icon-line-shield', 'icon-line-shield', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2229, 'c4a78d57-025f-42d6-a90f-f8f67a38fc0e', 'icon-line-shield-off', 'icon-line-shield-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2230, '9332ca75-02f2-45d2-a4f8-5fc51a733e7a', 'icon-line-shopping-bag', 'icon-line-shopping-bag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2231, '37a47439-0cea-4891-8a7b-24586fa1f509', 'icon-line-shopping-cart', 'icon-line-shopping-cart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2232, '964196eb-8818-46d5-938d-6c9dea8b02fa', 'icon-line-shuffle', 'icon-line-shuffle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2233, 'd2f49e40-b40c-4341-b628-3cc9b9080c7c', 'icon-line-sidebar', 'icon-line-sidebar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2234, '57402a32-5147-4795-9807-3284b25977dd', 'icon-line-skip-back', 'icon-line-skip-back', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2235, '3175b9dc-085b-4384-a401-3e110b85e187', 'icon-line-skip-forward', 'icon-line-skip-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2236, '6d1eba45-6b8a-4d63-bb21-586d985107a1', 'icon-line-slack', 'icon-line-slack', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2237, '3cb41264-96fd-460d-b586-3eb7b09794f8', 'icon-line-ban', 'icon-line-ban', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2238, '712eea0d-bc5c-4aec-990b-13bc55135a14', 'icon-line-sliders', 'icon-line-sliders', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2239, '6e9318fc-322d-4381-91f8-c7afb3964c8a', 'icon-line-smartphone', 'icon-line-smartphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2240, 'ea9f0580-2ca1-4a80-bbc9-03dc9eba4c52', 'icon-line-smile', 'icon-line-smile', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2241, '487ca169-0f1c-426b-91e1-866d7e9de4a8', 'icon-line-speaker', 'icon-line-speaker', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2242, '3c21e739-5f09-4ef5-9035-d6bba8e3d987', 'icon-line-square', 'icon-line-square', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2243, '79dc572c-b5ea-42c0-9954-b9d2db0aeb3f', 'icon-line-star', 'icon-line-star', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2244, '9805d4cd-7d6b-4999-93a0-ddd34284428a', 'icon-line-stop-circle', 'icon-line-stop-circle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2245, '0b8371c9-ad01-4d79-b278-a9bfd4b6890d', 'icon-line-sun', 'icon-line-sun', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2246, 'dd4bf588-f6d0-4d3b-8aef-fd16aeb11f59', 'icon-line-sunrise', 'icon-line-sunrise', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2247, '0fb24932-edb9-4fbe-b7e3-627b5a7c8170', 'icon-line-sunset', 'icon-line-sunset', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2248, '2d1c0b8c-208c-4658-b432-4311ed8b5d67', 'icon-line-tablet', 'icon-line-tablet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2249, '8d350003-2817-4972-9436-d4bda478a1fa', 'icon-line-tag', 'icon-line-tag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2250, '406b0068-f409-4f21-842b-a7e1fe6fb8bc', 'icon-line-target', 'icon-line-target', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2251, 'b99b4711-0e34-4eec-b872-ddc12d809157', 'icon-line-terminal', 'icon-line-terminal', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2252, '326a0bbb-acac-435c-9b97-d63392c55a6c', 'icon-line-thermometer', 'icon-line-thermometer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2253, '544dae57-4eae-405d-bd79-162ca95ac60b', 'icon-line-thumbs-down', 'icon-line-thumbs-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2254, '09bc6c61-4ded-4370-a7b5-09053957ebfa', 'icon-line-thumbs-up', 'icon-line-thumbs-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2255, 'a5597557-0123-4752-8eb9-8069917b57e8', 'icon-line-toggle', 'icon-line-toggle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2256, 'f16857b1-576b-4c05-9efa-b634ce485788', 'icon-line-toggle-right', 'icon-line-toggle-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2257, '1609bc36-950c-43b0-9bf0-66736f3ef548', 'icon-line-tool', 'icon-line-tool', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2258, '232a9629-b160-4990-a89d-d34150378b45', 'icon-line-trash', 'icon-line-trash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2259, 'cba65e55-f678-4dc4-94ab-742f201c3f12', 'icon-line-trash-2', 'icon-line-trash-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2260, 'fe511aa9-ed3f-406a-830e-08b34e1bf9b8', 'icon-line-trello', 'icon-line-trello', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2261, 'b94d8865-2e35-4164-a414-9d8e52d71993', 'icon-line-trending-down', 'icon-line-trending-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2262, 'edfb61c6-f877-4061-b5b0-e39b2a8dbd97', 'icon-line-trending-up', 'icon-line-trending-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2263, '49da8453-6a37-4d02-a443-f75602752c5d', 'icon-line-triangle', 'icon-line-triangle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2264, '0b35fada-9700-4f77-bac3-fa600397c32e', 'icon-line-truck', 'icon-line-truck', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2265, '6d773d48-c1ea-44c5-a427-523a8531c094', 'icon-line-tv', 'icon-line-tv', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2266, '410ee9ff-27a0-4e3f-9e13-0fcf1ef0bbdb', 'icon-line-twitch', 'icon-line-twitch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2267, '00a4b4ea-8e45-467b-907d-de42d8a986e4', 'icon-line-twitter', 'icon-line-twitter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2268, 'b6a94ede-9b63-4a1e-84d4-79083cdebe2a', 'icon-line-type', 'icon-line-type', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2269, 'bd1e1af1-16d7-435d-9071-8b102ae2e724', 'icon-line-umbrella', 'icon-line-umbrella', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2270, '035e03c5-fbb1-4b09-803d-b1974f15653b', 'icon-line-underline', 'icon-line-underline', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2271, '5609b63a-3a89-4639-b295-d34d8c5cba99', 'icon-line-unlock', 'icon-line-unlock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2272, '3f8cc143-04d3-4bf3-b522-9bed41b2c8ee', 'icon-line-upload', 'icon-line-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2273, 'b606fe74-89a6-4e2e-991a-ab7237f6f8d4', 'icon-line-cloud-upload', 'icon-line-cloud-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2274, '9d81b5cd-2711-4aba-83d4-86f7e7015a40', 'icon-line-head', 'icon-line-head', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2275, 'b4c7ba47-19f8-42fc-9325-71861f369565', 'icon-line-user-check', 'icon-line-user-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2276, '63ce7cfa-f210-4134-bee9-1b710f9bde62', 'icon-line-user-minus', 'icon-line-user-minus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2277, '15509ee3-1d2f-45de-bfca-fe9811fd26f8', 'icon-line-user-plus', 'icon-line-user-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2278, 'eeada29e-2b3b-475b-8117-d87a376b93bf', 'icon-line-user-cross', 'icon-line-user-cross', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2279, '65a111ec-ca92-459f-88a8-5d02147d63fa', 'icon-line-users', 'icon-line-users', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2280, '01756d80-bdbe-4a1d-8621-f82ac1a69c97', 'icon-line-video', 'icon-line-video', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2281, '2276c9a5-002f-4c5b-9c41-db0f4d9e6a7d', 'icon-line-video-off', 'icon-line-video-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2282, '4e2ec16c-1558-4e3f-b7e9-2db29a7b95d1', 'icon-line-voicemail', 'icon-line-voicemail', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2283, 'dcb603fd-2ddc-4bac-97fd-b155c5be9bd1', 'icon-line-volume-off', 'icon-line-volume-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2284, '9df3d0ca-32fd-4b67-a8fc-81382dc58db5', 'icon-line-volume-1', 'icon-line-volume-1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2285, '0004cc95-a44f-45ba-abf1-0d929f99789f', 'icon-line-volume', 'icon-line-volume', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2286, '0a498ce7-03ab-4dc7-89ab-7bc94d07b846', 'icon-line-mute', 'icon-line-mute', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2287, '21b712bc-2dcf-4302-9a08-fcb9cdfc237c', 'icon-line-watch', 'icon-line-watch', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2288, '35572d23-ee11-4ffe-99bf-db51b5c9fe60', 'icon-line-wifi', 'icon-line-wifi', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2289, 'c9279042-0785-4081-b95a-b38a11f4fc14', 'icon-line-wifi-off', 'icon-line-wifi-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2290, '3f62f2e6-45bd-448b-8e9b-613fda53b20c', 'icon-line-wind', 'icon-line-wind', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2291, '8e469f00-23d9-4766-a716-1f39986df182', 'icon-line-cross', 'icon-line-cross', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2292, '792a67ba-04a5-4362-9842-4d1dbf99b21d', 'icon-line-circle-cross', 'icon-line-circle-cross', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2293, 'e79d48a3-b304-4d98-9606-c60101b05752', 'icon-line-cross-octagon', 'icon-line-cross-octagon', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2294, 'a913379c-6b83-458c-9a26-63411953303c', 'icon-line-square-cross', 'icon-line-square-cross', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2295, 'caca8824-0274-4d42-944c-144b5c264863', 'icon-line-youtube', 'icon-line-youtube', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2296, '462902f3-4abe-4320-b27b-a70ec98137fd', 'icon-line-zap', 'icon-line-zap', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2297, '87c7b8c0-7722-46f4-bcc7-18ec481f8ac6', 'icon-line-zap-off', 'icon-line-zap-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2298, '791619f6-7f01-4cde-9612-2a63ddbf58e6', 'icon-line-zoom-in', 'icon-line-zoom-in', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2299, '6eea88b3-4ce6-4bce-b083-9f5e5b9e5511', 'icon-line-zoom-out', 'icon-line-zoom-out', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2300, '32f49c33-9c24-4fa6-8a80-63b9fd0fc625', 'icon-line2-user-female', 'icon-line2-user-female', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2301, '7ee09017-c502-41ba-a5a4-509023bf43f0', 'icon-line2-user-follow', 'icon-line2-user-follow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2302, '6331bf8b-1657-430c-b0da-a47fa095af6b', 'icon-line2-user-following', 'icon-line2-user-following', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2303, '70e0a148-b514-4031-9ad3-6f105ead95a2', 'icon-line2-user-unfollow', 'icon-line2-user-unfollow', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2304, '9ae9c573-0629-4308-9639-fd75795a4a44', 'icon-line2-trophy', 'icon-line2-trophy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2305, 'ba252506-4305-4d6b-a9fe-abbf45354d70', 'icon-line2-screen-smartphone', 'icon-line2-screen-smartphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2306, '9a0e2184-5725-461b-8584-115e6f8da2f7', 'icon-line2-screen-desktop', 'icon-line2-screen-desktop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2307, 'cffd4f45-5157-497f-9a5a-e56ea50f2fe9', 'icon-line2-plane', 'icon-line2-plane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2308, '3d5c84f3-3938-45e3-8be3-3435855b2bd6', 'icon-line2-notebook', 'icon-line2-notebook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2309, 'b8dc2f4e-3fa6-4e4f-8547-98686ee9f00a', 'icon-line2-moustache', 'icon-line2-moustache', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2310, 'c68b56d3-8506-4e67-9a2f-8c1bc3b87bcd', 'icon-line2-mouse', 'icon-line2-mouse', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2311, 'bcc3f805-02d1-4bbc-9c28-823f6bc3460e', 'icon-line2-magnet', 'icon-line2-magnet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2312, '0dc830a7-cb48-4407-bfb0-b0aad64d0812', 'icon-line2-energy', 'icon-line2-energy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2313, '0de37a74-5ff7-4b08-ab95-871238362f46', 'icon-line2-emoticon-smile', 'icon-line2-emoticon-smile', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2314, '4fe457e9-470e-4763-a136-6c2d5dd2aa46', 'icon-line2-disc', 'icon-line2-disc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2315, '5ec01db0-fef6-49c2-aecc-8236512c8784', 'icon-line2-cursor-move', 'icon-line2-cursor-move', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2316, 'f9e24f12-30ec-4488-be22-e934e51f1636', 'icon-line2-crop', 'icon-line2-crop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2317, 'f62b577a-65e6-47cb-82c0-227baad6bc36', 'icon-line2-credit-card', 'icon-line2-credit-card', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2318, '391fc103-af19-49f0-9916-8b81a86eaf35', 'icon-line2-chemistry', 'icon-line2-chemistry', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2319, 'd2a64b91-af73-4d99-925e-4112695d37b2', 'icon-line2-user', 'icon-line2-user', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2320, '9462f0b0-1590-4860-b7a1-2c1517619228', 'icon-line2-speedometer', 'icon-line2-speedometer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2321, 'bfe8650d-0c56-4e03-ba3a-effbbcd11619', 'icon-line2-social-youtube', 'icon-line2-social-youtube', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2322, '261509b4-dc73-4c4b-a5f8-577b2b6b9247', 'icon-line2-social-twitter', 'icon-line2-social-twitter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2323, 'bd3ac372-d4a2-47d6-887b-bd1148f68ae3', 'icon-line2-social-tumblr', 'icon-line2-social-tumblr', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2324, '50f56d9b-2efa-4b3a-be2f-ab7bf13a838f', 'icon-line2-social-facebook', 'icon-line2-social-facebook', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2325, '9adb996d-38ab-4e37-999a-fd9b77b76ffd', 'icon-line2-social-dropbox', 'icon-line2-social-dropbox', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2326, 'ef6a6efb-0742-47a8-a9aa-faa3f0c85c6b', 'icon-line2-social-dribbble', 'icon-line2-social-dribbble', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2327, '9826df34-53fd-403b-af26-34ad1b594985', 'icon-line2-shield', 'icon-line2-shield', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2328, 'b3ee7031-be73-459b-ada4-8f53a23c81a6', 'icon-line2-screen-tablet', 'icon-line2-screen-tablet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2329, '2e3350c8-5779-435b-bf66-ce0536451926', 'icon-line2-magic-wand', 'icon-line2-magic-wand', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2330, '193ebd9b-3561-4a1a-b4ef-c02416da5279', 'icon-line2-hourglass', 'icon-line2-hourglass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2331, '9908eb94-a205-4f3c-ac90-2f1cb5aa508b', 'icon-line2-graduation', 'icon-line2-graduation', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2332, 'fb143225-ed97-40ab-85bd-f59378703356', 'icon-line2-ghost', 'icon-line2-ghost', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2333, '5178f873-0af0-4f7a-9552-a5d8bb0a8231', 'icon-line2-game-controller', 'icon-line2-game-controller', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2334, '0090fce7-023c-469d-9464-f58fb77e0e4d', 'icon-line2-fire', 'icon-line2-fire', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2335, 'f76cc4b6-cd77-47f4-a0c0-e82c9c54eae4', 'icon-line2-eyeglasses', 'icon-line2-eyeglasses', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2336, 'bc12fe7c-8293-4f2b-8d58-60eb2db8d5a8', 'icon-line2-envelope-open', 'icon-line2-envelope-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2337, 'b72b2e03-2f7a-4df1-a351-b5b8dceffd59', 'icon-line2-envelope-letter', 'icon-line2-envelope-letter', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2338, '5e7fdc21-f32f-4d1d-b36e-a8e6463edc88', 'icon-line2-bell', 'icon-line2-bell', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2339, '61964ea0-530b-477a-afb5-58ddb7243052', 'icon-line2-badge', 'icon-line2-badge', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2340, 'adb21ed8-15b6-44c4-919c-48c95a160da2', 'icon-line2-anchor', 'icon-line2-anchor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2341, '8e89ba12-68f4-44f7-ac90-35d5ba1d7547', 'icon-line2-wallet', 'icon-line2-wallet', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2342, 'b84681bd-3f73-4839-8b15-39251a914699', 'icon-line2-vector', 'icon-line2-vector', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2343, '2329190a-c65c-4771-97f8-bfc440557538', 'icon-line2-speech', 'icon-line2-speech', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2344, 'c043ee12-1915-46b7-acf3-b1b5428cb2bb', 'icon-line2-puzzle', 'icon-line2-puzzle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2345, '697d564a-72bc-4d35-8631-551a0c34d31b', 'icon-line2-printer', 'icon-line2-printer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2346, '8c9ffc27-1d35-4504-9e58-3766949493f6', 'icon-line2-present', 'icon-line2-present', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2347, '235e9358-7c9c-4951-91c8-410a75162735', 'icon-line2-playlist', 'icon-line2-playlist', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2348, '2ad5a542-39c5-403b-9014-561082f1649d', 'icon-line2-pin', 'icon-line2-pin', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2349, '407fec74-f9f8-4f2f-a196-72206e77a6ca', 'icon-line2-picture', 'icon-line2-picture', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2350, 'dd26dd32-e898-4533-8ccc-ff263d4ed5b0', 'icon-line2-map', 'icon-line2-map', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2351, '9b1f7c5f-05b8-4ed2-abf1-e6c382a373b0', 'icon-line2-layers', 'icon-line2-layers', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2352, '25282494-c8e2-43ba-9407-3a68d287cdb0', 'icon-line2-handbag', 'icon-line2-handbag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2353, '3bb62afb-f5a0-481c-8f84-8b6e088907d0', 'icon-line2-globe-alt', 'icon-line2-globe-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2354, '374f7261-584e-4c7e-a066-3e5f0b8b3d29', 'icon-line2-globe', 'icon-line2-globe', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2355, '4b93eedf-e07d-4c42-8a9d-7f57f542dc70', 'icon-line2-frame', 'icon-line2-frame', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2356, '7a50c827-3911-433b-9424-7c2d7eb067a2', 'icon-line2-folder-alt', 'icon-line2-folder-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2357, '64396bd8-bd04-4aeb-ad3c-2855561a3d62', 'icon-line2-film', 'icon-line2-film', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2358, '511d8971-0f82-4ed4-8975-e27b69224a41', 'icon-line2-feed', 'icon-line2-feed', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2359, '23645dae-336f-40c5-b45f-881ae1847833', 'icon-line2-earphones-alt', 'icon-line2-earphones-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2360, '970b806c-eff9-4fa1-9113-bd0b6986aa4b', 'icon-line2-earphones', 'icon-line2-earphones', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2361, '00f98a5a-09d5-47b1-834a-5df78c716dc3', 'icon-line2-drop', 'icon-line2-drop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2362, 'dfbda0d5-675a-4e5b-9143-dbd6f404481f', 'icon-line2-drawer', 'icon-line2-drawer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2363, 'ce188bbf-3dbd-4840-ba21-8a3d1f6b0e04', 'icon-line2-docs', 'icon-line2-docs', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2364, '9f25701a-d80e-4b93-ad8c-9e6cc3be0945', 'icon-line2-directions', 'icon-line2-directions', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2365, 'c95fd6ef-cf74-4642-8d3c-a844fdebe150', 'icon-line2-direction', 'icon-line2-direction', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2366, '549aac9b-42d4-4f2e-969d-11fbd855ecbb', 'icon-line2-diamond', 'icon-line2-diamond', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2367, '58f1fd33-8628-449b-b458-086a8bfc69e0', 'icon-line2-cup', 'icon-line2-cup', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2368, 'cd563154-9367-4d0b-902d-39c0b2e4bbf8', 'icon-line2-compass', 'icon-line2-compass', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2369, 'b58b8fbf-66ce-4849-9fab-79c09d7fb3cd', 'icon-line2-call-out', 'icon-line2-call-out', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2370, 'c5763f95-9d61-4fd0-a91a-32640d511402', 'icon-line2-call-in', 'icon-line2-call-in', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2371, '723217e6-3e3b-4406-bf3b-46bc5d6ca843', 'icon-line2-call-end', 'icon-line2-call-end', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2372, '2d4d6df3-cb6a-43a9-a20c-1d37b5d37efc', 'icon-line2-calculator', 'icon-line2-calculator', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2373, 'c1aa0770-d1ad-4515-9176-885d183dfbd9', 'icon-line2-bubbles', 'icon-line2-bubbles', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2374, 'e30d425d-b4fa-4443-bdab-ca0163a8d3a2', 'icon-line2-briefcase', 'icon-line2-briefcase', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2375, 'd5d32085-8712-4d8e-a937-ae888acfc211', 'icon-line2-book-open', 'icon-line2-book-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2376, 'c2c70a2f-da74-4230-a747-17e4d66f21db', 'icon-line2-basket-loaded', 'icon-line2-basket-loaded', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2377, 'd7ba3f9e-2bde-448c-afff-c8d6b30a1bd4', 'icon-line2-basket', 'icon-line2-basket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2378, 'a63cade2-25bd-4fdd-8354-f0ce39810785', 'icon-line2-bag', 'icon-line2-bag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2379, 'ad56c240-cb0f-46bf-a667-431b60daaadb', 'icon-line2-action-undo', 'icon-line2-action-undo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2380, '80cb25e0-f21f-4f7e-afaa-5288894a8c27', 'icon-line2-action-redo', 'icon-line2-action-redo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2381, 'aaab5a63-0aec-4a3d-b449-b627c5289353', 'icon-line2-wrench', 'icon-line2-wrench', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2382, '60f77b34-4916-4578-8f7d-3e1de4db62ee', 'icon-line2-umbrella', 'icon-line2-umbrella', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2383, '35f5eaee-85f9-4d45-aada-123630d15a2b', 'icon-line2-trash', 'icon-line2-trash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2384, '804cb35a-8815-443b-8744-ab627a45b955', 'icon-line2-tag', 'icon-line2-tag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2385, 'fca6fd90-d123-45c3-9aa0-80c10f88a9bd', 'icon-line2-support', 'icon-line2-support', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2386, '941400ec-c305-4996-9ec2-8aed57631522', 'icon-line2-size-fullscreen', 'icon-line2-size-fullscreen', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2387, '0bc9d76d-f704-42c2-9794-dc2775405e0d', 'icon-line2-size-actual', 'icon-line2-size-actual', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2388, '7f0be0fa-7a3e-406d-b249-c5a20b6e7daf', 'icon-line2-shuffle', 'icon-line2-shuffle', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2389, '1825776f-189f-411e-847e-ac4fc4d15690', 'icon-line2-share-alt', 'icon-line2-share-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2390, 'd7e2c6d1-7230-41b0-89f5-015c6ac73767', 'icon-line2-share', 'icon-line2-share', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2391, '1a7b2581-e738-455b-8c06-94281a63d880', 'icon-line2-rocket', 'icon-line2-rocket', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2392, '7099c565-442e-4f6c-b06b-7d825b9af0a1', 'icon-line2-question', 'icon-line2-question', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2393, '76a9bc96-e247-4877-a181-bfcd8278d62f', 'icon-line2-pie-chart', 'icon-line2-pie-chart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2394, '5f1ff084-b70f-4aec-aee2-7301e91f3986', 'icon-line2-pencil', 'icon-line2-pencil', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2395, '7e76f434-2615-4ac8-a463-5944c93141f7', 'icon-line2-note', 'icon-line2-note', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2396, '98db3a74-32ea-44a6-93aa-ea530d3ffed1', 'icon-line2-music-tone-alt', 'icon-line2-music-tone-alt', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2397, 'e89949ad-1b5b-4387-aff3-1a37766c68ff', 'icon-line2-music-tone', 'icon-line2-music-tone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2398, '62ad6b4c-6148-48d6-a487-eb6f49a9f89d', 'icon-line2-microphone', 'icon-line2-microphone', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2399, '3d4f5217-9351-4356-be24-954819488e87', 'icon-line2-loop', 'icon-line2-loop', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2400, '1f2ab43b-dc65-4504-bb7a-2264633394ae', 'icon-line2-logout', 'icon-line2-logout', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2401, 'e356a87c-cc4b-464c-89bb-2bc7c73d821a', 'icon-line2-login', 'icon-line2-login', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2402, 'f900520d-cf67-4233-9cf2-71a167a77374', 'icon-line2-list', 'icon-line2-list', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2403, 'e66d579f-7c0d-4adc-916a-5e04523a288a', 'icon-line2-like', 'icon-line2-like', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2404, '01165548-fd41-4275-81b0-8a60ebb377a4', 'icon-line2-home', 'icon-line2-home', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2405, '79400783-248f-4bb9-aeb9-00bec5961955', 'icon-line2-grid', 'icon-line2-grid', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2406, '67744464-2ddd-4e59-a37a-29d2166d26c7', 'icon-line2-graph', 'icon-line2-graph', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2407, '39368fe0-6ee6-4cd5-87c6-ddcad6c67606', 'icon-line2-equalizer', 'icon-line2-equalizer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2408, 'a5ae312f-20eb-4914-8e13-59ab70594103', 'icon-line2-dislike', 'icon-line2-dislike', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2409, 'e2e25cf4-e03a-4967-a771-926d60053b9f', 'icon-line2-cursor', 'icon-line2-cursor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2410, 'ae88acfc-66cc-4a83-91ac-f3ae35a1eb7b', 'icon-line2-control-start', 'icon-line2-control-start', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2411, 'b1cc6cad-a216-40d0-aef2-6bc40aa05d68', 'icon-line2-control-rewind', 'icon-line2-control-rewind', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2412, 'ade6f5d4-05b4-4cd0-b8ac-604adad96f25', 'icon-line2-control-play', 'icon-line2-control-play', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2413, '7b4df5be-9552-4f6a-81a2-59e7c70f05ac', 'icon-line2-control-pause', 'icon-line2-control-pause', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2414, '86915e24-701b-4567-aa30-280c42d73eab', 'icon-line2-control-forward', 'icon-line2-control-forward', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2415, '3e13600f-78d6-47b9-985a-45c372226119', 'icon-line2-control-end', 'icon-line2-control-end', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2416, '00c404b7-afc3-4837-90a1-6c4f4df154d3', 'icon-line2-calendar', 'icon-line2-calendar', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2417, 'a0284e4a-4fa6-4ed2-8e79-22573a6182f9', 'icon-line2-bulb', 'icon-line2-bulb', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2418, '7f47c772-0b31-4dae-b0ed-b135dd0c5358', 'icon-line2-bar-chart', 'icon-line2-bar-chart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2419, 'b593a4ba-6590-49d2-9f4b-d409b553a1bc', 'icon-line2-arrow-up', 'icon-line2-arrow-up', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2420, 'b7f17e50-6a8f-4b58-92d8-e7eee08765bd', 'icon-line2-arrow-right', 'icon-line2-arrow-right', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2421, '6278b41e-9b78-4588-be37-db1262191b2b', 'icon-line2-arrow-left', 'icon-line2-arrow-left', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2422, '3efe2508-3df2-4724-ab70-a2b34e5c1cb1', 'icon-line2-arrow-down', 'icon-line2-arrow-down', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2423, 'bf91a499-314b-46c2-98ab-71738183ecbc', 'icon-line2-ban', 'icon-line2-ban', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2424, '5befc1be-46c5-4ea1-8763-b3cb04ea92ed', 'icon-line2-bubble', 'icon-line2-bubble', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2425, '75da50e9-6406-459c-a642-69968edf1296', 'icon-line2-camcorder', 'icon-line2-camcorder', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2426, 'fc772ff9-26b1-4b4f-8784-f7075eebec9a', 'icon-line2-camera', 'icon-line2-camera', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2427, '5de4aa01-4a97-4c82-b283-b1bfdf3c4deb', 'icon-line2-check', 'icon-line2-check', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2428, '67215eee-f4d7-4e91-9cac-bdd7dae2a977', 'icon-line2-clock', 'icon-line2-clock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2429, '1422a8f9-a82c-48d1-a3d6-c8e4b62a6c9d', 'icon-line2-close', 'icon-line2-close', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2430, '23a0f205-9ba3-46f3-aac9-caafbf3fc8f5', 'icon-line2-cloud-download', 'icon-line2-cloud-download', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2431, 'd2cb9d3b-708a-4e01-ab8f-ac8c6422facc', 'icon-line2-cloud-upload', 'icon-line2-cloud-upload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2432, 'cd37405c-f023-40f9-a79a-85d0343a5bd1', 'icon-line2-doc', 'icon-line2-doc', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2433, '7273779b-7c4c-442f-9c22-bfb463a469eb', 'icon-line2-envelope', 'icon-line2-envelope', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2434, 'ce427b2b-c7ce-428e-89bd-fea500185306', 'icon-line2-eye', 'icon-line2-eye', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2435, '2a061adc-e63a-4bec-8a14-7bffb35a55c1', 'icon-line2-flag', 'icon-line2-flag', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2436, 'a1d4b577-7bad-4f94-b8e9-eb4edb9408ac', 'icon-line2-folder', 'icon-line2-folder', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2437, 'ab7fe065-54a3-4560-8b7a-26de4a64edee', 'icon-line2-heart', 'icon-line2-heart', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2438, 'c726d824-7478-4f58-8bd9-c3498c026e36', 'icon-line2-info', 'icon-line2-info', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2439, '139c0546-f011-4463-8070-99cdf8bb1314', 'icon-line2-key', 'icon-line2-key', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2440, 'da8e9052-d02a-46af-a658-167fc45e54f3', 'icon-line2-link', 'icon-line2-link', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2441, '19c5ade0-392d-4f57-8517-29eac3be7d44', 'icon-line2-lock', 'icon-line2-lock', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2442, '2a3cd06f-2891-4b1b-b000-b529683e406e', 'icon-line2-lock-open', 'icon-line2-lock-open', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2443, '7a12bfc8-4013-4bca-9afd-dd9321ce1cdd', 'icon-line2-magnifier', 'icon-line2-magnifier', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2444, 'a78a984a-59cf-44ab-8cfb-21964090d3ee', 'icon-line2-magnifier-add', 'icon-line2-magnifier-add', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2445, 'e82934ae-a685-474f-82ff-a7e65755a41a', 'icon-line2-magnifier-remove', 'icon-line2-magnifier-remove', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2446, '9c4d82c9-ef9c-4678-8e71-9ada1c732b24', 'icon-line2-paper-clip', 'icon-line2-paper-clip', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2447, '1af97a7d-ffda-48da-8bc3-d90291da6d63', 'icon-line2-paper-plane', 'icon-line2-paper-plane', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2448, '1b52e04b-a571-4228-ae65-b8a01c696caa', 'icon-line2-plus', 'icon-line2-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2449, '8d6e2f8b-4b57-4532-8678-bca0dfac29dd', 'icon-line2-pointer', 'icon-line2-pointer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2450, 'f0ed9ada-53d2-44a1-81fa-88791271b4b9', 'icon-line2-power', 'icon-line2-power', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2451, '70880610-5186-49ed-aaa6-dce3da153743', 'icon-line2-refresh', 'icon-line2-refresh', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2452, '4f913ea1-8972-4465-9dfd-54d5ff36072b', 'icon-line2-reload', 'icon-line2-reload', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2453, 'b7bb73e2-742a-414b-a480-26656d6e7cfa', 'icon-line2-settings', 'icon-line2-settings', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2454, '859aebf1-dc9d-4135-9229-a8eb696cd4be', 'icon-line2-star', 'icon-line2-star', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2455, '21de0101-2bd2-4b6b-b769-9d1e5cfee9c6', 'icon-line2-symbol-female', 'icon-line2-symbol-female', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2456, 'fb941362-9b8a-440a-8f12-4438fb6d5d38', 'icon-line2-symbol-male', 'icon-line2-symbol-male', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2457, 'f44fc242-5668-4fb4-a2e9-699407fd366f', 'icon-line2-target', 'icon-line2-target', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2458, '5b977fbd-4f84-4e14-a4d0-3714aecd3811', 'icon-line2-volume-1', 'icon-line2-volume-1', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2459, '4a64084d-e9d6-48a7-9a9a-74f107029f54', 'icon-line2-volume-2', 'icon-line2-volume-2', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2460, '5fc0c634-ae54-4730-8e87-74854deb1ee6', 'icon-line2-volume-off', 'icon-line2-volume-off', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2461, '0ba67780-3af8-4dfa-bcad-19b48e600006', 'icon-line2-users', 'icon-line2-users', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2462, 'b7f3e3b1-6d34-4292-9c43-3c2deaf30171', 'icon-deezer', 'icon-deezer', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2463, '0392333c-c9f2-4e9c-bd11-2075e29cc15c', 'icon-edge-legacy', 'icon-edge-legacy', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');
INSERT INTO `theme_icons` (`id`, `uuid`, `name`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(2464, '99957709-8f00-4f5f-9dd2-1cfc9a06b85a', 'icon-google-pay', 'icon-google-pay', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2465, 'cfe8cc99-08a5-4b80-a319-028d79bfc628', 'icon-google-plus', 'icon-google-plus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2466, 'e532077e-fa7c-4496-9252-130aa5d837e5', 'icon-rust', 'icon-rust', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2467, '4b670020-b4e2-47a7-9ee0-bc6dfdb0849f', 'icon-tiktok', 'icon-tiktok', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2468, 'cf494912-d03b-4ad5-810c-9a6ac880b520', 'icon-tripadvisor', 'icon-tripadvisor', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2469, '424e0a02-0346-4ad7-a563-8b3ad7925a01', 'icon-unsplash', 'icon-unsplash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2470, '03c7ec4f-90db-4e8c-947e-ee04d8326885', 'icon-yahoo', 'icon-yahoo', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2471, '39b5c2bd-ab65-4f1a-8e3f-ed2e0f4412b5', 'icon-box-tissue', 'icon-box-tissue', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2472, 'd0c5ce3a-5f43-4c26-accd-7830456cdbf8', 'icon-hand-holding-medical', 'icon-hand-holding-medical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2473, 'f5445f11-a530-4537-8444-d156c7b2f01d', 'icon-hand-holding-water', 'icon-hand-holding-water', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2474, '9f01fe25-b294-40be-b62c-73ac63877acf', 'icon-hand-sparkles', 'icon-hand-sparkles', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2475, '69caf38f-ef68-486c-9bee-c55537f55543', 'icon-hands-wash', 'icon-hands-wash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2476, 'a37746d0-2740-4d76-8a04-bc578eed15de', 'icon-handshake-alt-slash', 'icon-handshake-alt-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2477, 'd63813c5-8950-47c1-b8d1-621296b97099', 'icon-handshake-slash', 'icon-handshake-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2478, '088bca79-50da-4b00-9324-24866ad8afe7', 'icon-head-side-cough-slash', 'icon-head-side-cough-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2479, '81e09d90-09ab-4bed-b399-9827ca5a895e', 'icon-head-side-cough', 'icon-head-side-cough', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2480, '95ffb35e-2524-461b-90e1-547fe21b2d81', 'icon-head-side-mask', 'icon-head-side-mask', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2481, 'c383e624-6364-4593-b236-6fd0ef9a5ae3', 'icon-head-side-virus', 'icon-head-side-virus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2482, 'df131d74-4395-4cd3-81f8-f1b47f9f7a15', 'icon-house-user', 'icon-house-user', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2483, '9a239a1d-c806-4ad4-a591-5b103975014e', 'icon-laptop-house', 'icon-laptop-house', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2484, 'ca8b763d-5a94-423c-adbb-ada042ff9169', 'icon-lungs-virus', 'icon-lungs-virus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2485, '4388de72-9dca-4a3f-972b-dd399e79110c', 'icon-people-arrows', 'icon-people-arrows', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2486, 'ae623b83-5c2b-4f81-8b40-dea3caee9e99', 'icon-plane-slash', 'icon-plane-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2487, '094ee7f7-3ffd-479a-a4f8-f56cf8fb0992', 'icon-pump-medical', 'icon-pump-medical', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2488, '1ed92a88-f666-482e-9a50-b4bb5176df0d', 'icon-pump-soap', 'icon-pump-soap', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2489, 'd547f52c-6a69-4645-940e-a80d8db772c4', 'icon-shield-virus', 'icon-shield-virus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2490, 'bc1fe1af-98a2-475f-9d2b-06f0d9748712', 'icon-sink', 'icon-sink', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2491, '442de571-41c6-4a1a-8be1-e353f1ff9bda', 'icon-socks', 'icon-socks', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2492, 'b1068f32-0c5c-42cc-91b8-43ee627b427e', 'icon-stopwatch-20', 'icon-stopwatch-20', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2493, '13b941ff-c646-4fb5-b603-59799c9f0c30', 'icon-store-alt-slash', 'icon-store-alt-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2494, 'eda19416-6788-4a32-afcc-21a92990566e', 'icon-store-slash', 'icon-store-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2495, '4c721332-2cea-4f96-b8f3-0ef6efc34e0e', 'icon-toilet-paper-slash', 'icon-toilet-paper-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2496, '0dc9fc33-1dc8-42ae-9b2b-e5dc2cffbd8d', 'icon-users-slash', 'icon-users-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2497, 'baaa323e-3148-4f4d-aace-6fc6cbad8c43', 'icon-virus-slash', 'icon-virus-slash', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2498, '8f4ca84c-d23e-41fe-8e71-07a9d3cc01f2', 'icon-virus', 'icon-virus', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2499, '65f8cfd8-67ad-4836-b877-50df940e0daa', 'icon-viruses', 'icon-viruses', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2500, 'f0b4539b-4620-46c6-952e-74c4ebcd74a9', 'icon-bandcamp', 'icon-bandcamp', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2501, 'ab217262-40e1-412e-beb2-c4f0f5759d61', 'icon-bacteria', 'icon-bacteria', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35'),
(2502, 'b454a8b3-e200-4a9d-afc7-dd8894bf67c2', 'icon-bacterium', 'icon-bacterium', NULL, 1, 1, '2023-08-30 01:04:11', '2023-08-30 01:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint UNSIGNED NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `locale` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '1',
  `allow_login` int NOT NULL DEFAULT '1',
  `business_id` int NOT NULL DEFAULT '1',
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `role_id`, `is_admin`, `allow_login`, `business_id`, `photo`, `status`) VALUES
(1, 'kamrul islam', 'kamrul@gmail.com', '2023-08-30 01:04:52', '$2y$10$M2Yoc5bfSKMISK3e5EqI5uMscX/sS/3N/4KI1X95nzpij4M5cOt1K', '1cxwAsAqSN6KFTChFBK0NuTjV0uPhBAYr3RpQhAvJOn6usodKeyx1Uu7g47K', '2023-08-30 01:04:10', '2023-08-30 01:04:52', 'kamrul', 1, 1, 1, 1, NULL, 1),
(2, 'Admin', 'admin@gmail.com', '2023-08-30 01:04:52', '$2y$10$M2Yoc5bfSKMISK3e5EqI5uMscX/sS/3N/4KI1X95nzpij4M5cOt1K', 'XwhFHl0TeS', '2023-08-30 01:04:10', '2023-11-01 22:03:51', 'admin', 1, 0, 1, 1, NULL, 1),
(3, 'sujon', 'sujon@daffodilvarsity.edu.bd', NULL, '$2y$10$8TtGIIWL7TlT5QLHJE.K.O6uVbTjz2Lt3aPdIFPh65lqcDsuF.Hhe', NULL, '2023-11-01 22:04:58', '2023-11-01 22:04:58', 'sujon', 1, 1, 1, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `venue_facilities`
--

CREATE TABLE `venue_facilities` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `photo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venue_facilities`
--

INSERT INTO `venue_facilities` (`id`, `uuid`, `name`, `slug`, `description`, `photo`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '912ec693-1f65-4755-af0b-8e6e8f38ddfe', 'Ground Floor, Academic Building 1, DSC', NULL, NULL, 'building-1697965249.webp', 1, 1, '2023-10-22 03:00:49', '2023-10-22 03:46:38'),
(2, 'ee4f992c-715b-491f-8330-7100cc99a5ee', 'IT Support, & Sound System', 'it-support-sound-system', NULL, 'it-support-1697965260.webp', 1, 1, '2023-10-22 03:01:00', '2023-10-22 03:01:00'),
(3, '57c710a0-6b53-4585-b5cc-c6649fbc8569', 'International Conference Hall Foot', 'international-conference-hall-foot', NULL, 'food-menu-1698052670.webp', 1, 1, '2023-10-23 03:17:50', '2023-10-23 03:17:50'),
(4, '2788526f-bdb6-4c6f-ae0b-9e3dcd38ea5c', 'Ground Floor, Academic Building 1, DSC', 'ground-floor-academic-building-1-dsc', NULL, 'food-1698642032.webp', 1, 1, '2023-10-29 23:00:32', '2023-10-29 23:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint UNSIGNED NOT NULL,
  `widget_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_id` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `widget_id`, `sidebar_id`, `theme`, `position`, `data`, `created_at`, `updated_at`) VALUES
(31, 'CustomMenuWidget', 'footer_sidebar', 'SonaroyTheme', 1, '{\"id\":\"CustomMenuWidget\",\"name\":\"Custom Menu\",\"menu_id\":\"footer-menu\"}', '2023-11-13 05:01:47', '2023-11-20 00:00:00'),
(47, 'SitebarMenuWidget', 'product_sidebar', 'SonaroyTheme-bn_BD', 0, '{\"id\":\"SitebarMenuWidget\",\"name\":\"Sitebar Menu\",\"menu_id\":\"main-menu-right-1\"}', '2023-11-18 22:48:32', '2023-11-20 00:00:00'),
(48, 'SitebarMenuWidget', 'product_sidebar', 'SonaroyTheme-bn_BD', 1, '{\"id\":\"SitebarMenuWidget\",\"name\":\"Important Links\",\"menu_id\":\"main-menu-right-1\"}', '2023-11-18 22:48:33', '2023-11-20 00:00:00'),
(50, 'CustomMenuWidget', 'footer_sidebar', 'SonaroyTheme-bn_BD', 0, '{\"id\":\"CustomMenuWidget\",\"name\":\"Custom Menu\",\"menu_id\":\"main-menu-right-1\"}', '2023-11-18 22:48:57', '2023-11-20 00:00:00'),
(76, 'SidebarPhotoWidget', 'product_sidebar', 'SonaroyTheme', 0, '{\"id\":\"SidebarPhotoWidget\",\"name\":\"Sidebar Photo\",\"post_type_id\":\"4\"}', '2025-07-23 04:25:53', '2025-07-23 04:25:53'),
(77, 'SitebarMenuWidget', 'product_sidebar', 'SonaroyTheme', 1, '{\"id\":\"SitebarMenuWidget\",\"name\":\"Important Links\",\"menu_id\":\"main-menu-right\"}', '2025-07-23 04:25:53', '2025-07-23 04:25:53'),
(78, 'SitebarMenuWidget', 'product_sidebar', 'SonaroyTheme', 2, '{\"id\":\"SitebarMenuWidget\",\"name\":\"Sitebar Menu\",\"menu_id\":\"main-menu-right\"}', '2025-07-23 04:25:53', '2025-07-23 04:25:53'),
(79, 'SiteInfoWidget', 'product_sidebar', 'SonaroyTheme', 3, '{\"id\":\"SiteInfoWidget\",\"name\":\"Collage information\"}', '2025-07-23 04:25:53', '2025-07-23 04:25:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission_marks`
--
ALTER TABLE `admission_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_marks_user_id_foreign` (`user_id`);

--
-- Indexes for table `admission_merits`
--
ALTER TABLE `admission_merits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_merits_user_id_foreign` (`user_id`);

--
-- Indexes for table `admission_subjects`
--
ALTER TABLE `admission_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_subjects_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories_translations`
--
ALTER TABLE `categories_translations`
  ADD PRIMARY KEY (`lang_code`,`categories_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities_translations`
--
ALTER TABLE `cities_translations`
  ADD PRIMARY KEY (`lang_code`,`cities_id`);

--
-- Indexes for table `contact_forms`
--
ALTER TABLE `contact_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_form_replies_contact_form_id_foreign` (`contact_form_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries_translations`
--
ALTER TABLE `countries_translations`
  ADD PRIMARY KEY (`lang_code`,`countries_id`);

--
-- Indexes for table `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_widget_settings`
--
ALTER TABLE `dashboard_widget_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dashboard_widget_settings_user_id_index` (`user_id`),
  ADD KEY `dashboard_widget_settings_widget_id_index` (`widget_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs_translations`
--
ALTER TABLE `faqs_translations`
  ADD PRIMARY KEY (`lang_code`,`faqs_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_categories_translations`
--
ALTER TABLE `faq_categories_translations`
  ADD PRIMARY KEY (`lang_code`,`faq_categories_id`);

--
-- Indexes for table `kamrul_dashboards`
--
ALTER TABLE `kamrul_dashboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `key_facilities`
--
ALTER TABLE `key_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_facilities_user_id_foreign` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_id`);

--
-- Indexes for table `language_meta`
--
ALTER TABLE `language_meta`
  ADD PRIMARY KEY (`lang_meta_id`),
  ADD KEY `language_meta_reference_id_index` (`reference_id`);

--
-- Indexes for table `menuses`
--
ALTER TABLE `menuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menuses_user_id_foreign` (`user_id`);

--
-- Indexes for table `menus_locations`
--
ALTER TABLE `menus_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus_nodes`
--
ALTER TABLE `menus_nodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_nodes_menus_id_foreign` (`menus_id`),
  ADD KEY `menus_nodes_parent_id_index` (`parent_id`);

--
-- Indexes for table `meta_boxes`
--
ALTER TABLE `meta_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_classes`
--
ALTER TABLE `option_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_classes_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_genders`
--
ALTER TABLE `option_genders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_genders_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_groups`
--
ALTER TABLE `option_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_groups_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_religions`
--
ALTER TABLE `option_religions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_religions_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_sections`
--
ALTER TABLE `option_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_sections_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_subjects`
--
ALTER TABLE `option_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_subjects_user_id_foreign` (`user_id`);

--
-- Indexes for table `option_years`
--
ALTER TABLE `option_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_years_user_id_foreign` (`user_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_page_templates_id_foreign` (`page_templates_id`),
  ADD KEY `pages_user_id_foreign` (`user_id`);

--
-- Indexes for table `pages_translations`
--
ALTER TABLE `pages_translations`
  ADD PRIMARY KEY (`lang_code`,`pages_id`);

--
-- Indexes for table `page_templates`
--
ALTER TABLE `page_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_templates_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_post_types_id_foreign` (`post_types_id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `posts_translations`
--
ALTER TABLE `posts_translations`
  ADD PRIMARY KEY (`lang_code`,`posts_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_categories_category_id_index` (`category_id`),
  ADD KEY `post_categories_post_id_index` (`post_id`);

--
-- Indexes for table `post_galleries`
--
ALTER TABLE `post_galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_galleries_user_id_foreign` (`user_id`);

--
-- Indexes for table `post_gallery_parameters`
--
ALTER TABLE `post_gallery_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_gallery_parameters_post_gallery_id_index` (`post_gallery_id`),
  ADD KEY `post_gallery_parameters_post_id_index` (`post_id`);

--
-- Indexes for table `post_types`
--
ALTER TABLE `post_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_types_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permissions_role_id_foreign` (`role_id`),
  ADD KEY `role_permissions_permission_id_index` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD UNIQUE KEY `settings_slug_unique` (`slug`);

--
-- Indexes for table `setting_data`
--
ALTER TABLE `setting_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_data_key_unique` (`key`);

--
-- Indexes for table `simple_sliders`
--
ALTER TABLE `simple_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `simple_slider_items`
--
ALTER TABLE `simple_slider_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slugs`
--
ALTER TABLE `slugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states_translations`
--
ALTER TABLE `states_translations`
  ADD PRIMARY KEY (`lang_code`,`states_id`);

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_icons`
--
ALTER TABLE `theme_icons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_icons_user_id_foreign` (`user_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venue_facilities_user_id_foreign` (`user_id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_marks`
--
ALTER TABLE `admission_marks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_merits`
--
ALTER TABLE `admission_merits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_subjects`
--
ALTER TABLE `admission_subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=495;

--
-- AUTO_INCREMENT for table `contact_forms`
--
ALTER TABLE `contact_forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dashboards`
--
ALTER TABLE `dashboards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dashboard_widget_settings`
--
ALTER TABLE `dashboard_widget_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamrul_dashboards`
--
ALTER TABLE `kamrul_dashboards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `key_facilities`
--
ALTER TABLE `key_facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `lang_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `language_meta`
--
ALTER TABLE `language_meta`
  MODIFY `lang_meta_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `menuses`
--
ALTER TABLE `menuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus_locations`
--
ALTER TABLE `menus_locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menus_nodes`
--
ALTER TABLE `menus_nodes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `meta_boxes`
--
ALTER TABLE `meta_boxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `option_classes`
--
ALTER TABLE `option_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `option_genders`
--
ALTER TABLE `option_genders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `option_groups`
--
ALTER TABLE `option_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `option_religions`
--
ALTER TABLE `option_religions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `option_sections`
--
ALTER TABLE `option_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `option_subjects`
--
ALTER TABLE `option_subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `option_years`
--
ALTER TABLE `option_years`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `page_templates`
--
ALTER TABLE `page_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=844;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `post_galleries`
--
ALTER TABLE `post_galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `post_gallery_parameters`
--
ALTER TABLE `post_gallery_parameters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `post_types`
--
ALTER TABLE `post_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `setting_data`
--
ALTER TABLE `setting_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `simple_sliders`
--
ALTER TABLE `simple_sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `simple_slider_items`
--
ALTER TABLE `simple_slider_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slugs`
--
ALTER TABLE `slugs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `theme_icons`
--
ALTER TABLE `theme_icons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2503;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission_marks`
--
ALTER TABLE `admission_marks`
  ADD CONSTRAINT `admission_marks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `admission_merits`
--
ALTER TABLE `admission_merits`
  ADD CONSTRAINT `admission_merits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `admission_subjects`
--
ALTER TABLE `admission_subjects`
  ADD CONSTRAINT `admission_subjects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_form_replies`
--
ALTER TABLE `contact_form_replies`
  ADD CONSTRAINT `contact_form_replies_contact_form_id_foreign` FOREIGN KEY (`contact_form_id`) REFERENCES `contact_forms` (`id`);

--
-- Constraints for table `key_facilities`
--
ALTER TABLE `key_facilities`
  ADD CONSTRAINT `key_facilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `menuses`
--
ALTER TABLE `menuses`
  ADD CONSTRAINT `menuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `menus_nodes`
--
ALTER TABLE `menus_nodes`
  ADD CONSTRAINT `menus_nodes_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `menuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_classes`
--
ALTER TABLE `option_classes`
  ADD CONSTRAINT `option_classes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_genders`
--
ALTER TABLE `option_genders`
  ADD CONSTRAINT `option_genders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_groups`
--
ALTER TABLE `option_groups`
  ADD CONSTRAINT `option_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_religions`
--
ALTER TABLE `option_religions`
  ADD CONSTRAINT `option_religions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_sections`
--
ALTER TABLE `option_sections`
  ADD CONSTRAINT `option_sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_subjects`
--
ALTER TABLE `option_subjects`
  ADD CONSTRAINT `option_subjects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `option_years`
--
ALTER TABLE `option_years`
  ADD CONSTRAINT `option_years_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_page_templates_id_foreign` FOREIGN KEY (`page_templates_id`) REFERENCES `page_templates` (`id`),
  ADD CONSTRAINT `pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `page_templates`
--
ALTER TABLE `page_templates`
  ADD CONSTRAINT `page_templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_post_types_id_foreign` FOREIGN KEY (`post_types_id`) REFERENCES `post_types` (`id`),
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_galleries`
--
ALTER TABLE `post_galleries`
  ADD CONSTRAINT `post_galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_gallery_parameters`
--
ALTER TABLE `post_gallery_parameters`
  ADD CONSTRAINT `post_gallery_parameters_post_gallery_id_foreign` FOREIGN KEY (`post_gallery_id`) REFERENCES `post_galleries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_gallery_parameters_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_types`
--
ALTER TABLE `post_types`
  ADD CONSTRAINT `post_types_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `theme_icons`
--
ALTER TABLE `theme_icons`
  ADD CONSTRAINT `theme_icons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `venue_facilities`
--
ALTER TABLE `venue_facilities`
  ADD CONSTRAINT `venue_facilities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
