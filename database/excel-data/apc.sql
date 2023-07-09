-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 21, 2023 at 03:18 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apc`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `political_party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `election_id` bigint(20) UNSIGNED DEFAULT NULL,
  `election` varchar(191) DEFAULT NULL,
  `zone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `deputy_name` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT 'presidential' COMMENT 'presidential, governoship, senatorial, house_of_rep, house_of_assembly',
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'LGA', 'lga'),
(2, 'Wards', 'ward'),
(3, 'Polling Units', 'polling_unit'),
(4, 'Senatorial zones', 'senatorial_zones'),
(6, 'Constituency', 'constituency');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `election_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code_number` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `full_details` text DEFAULT NULL,
  `year` varchar(191) DEFAULT NULL,
  `total_registered_voters` float DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'STATUS==\r\n0 => NOT STARTED\r\n1 => ON GOING\r\n2 => ENDED',
  `has_zones` tinyint(4) DEFAULT 1,
  `category_id` tinyint(4) DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `election_type_id`, `user_id`, `state_id`, `code_number`, `description`, `full_details`, `year`, `total_registered_voters`, `start_date`, `status`, `has_zones`, `category_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(65086, 1, 26, 4, '63f2253ae38e5', NULL, '2023 Katsina State Presidential Election', '2023', 4000000, '2023-02-25 00:00:00', 0, 0, 3, '2023-02-19 11:33:46', '2023-02-19 15:24:59', '2023-02-19 15:24:59'),
(65087, 1, 19, 4, '63f2feba4f223', NULL, '2023 Katsina State Presidential Election', '2023', 200000, '2023-02-24 00:00:00', 0, 0, 3, '2023-02-20 03:01:46', '2023-02-20 03:02:16', '2023-02-20 03:02:16'),
(65088, 1, 19, 4, '63f2fecfb4da0', NULL, '2023 Katsina State Presidential Election', '2023', 200000, '2023-02-24 00:00:00', 0, 0, 3, '2023-02-20 03:02:07', '2023-02-20 03:02:07', NULL),
(65089, 4, 19, 4, '63f301e2682cd', NULL, '2023 Katsina State House of Representatives Election', '2023', 150000, '2023-02-22 00:00:00', 0, 1, 3, '2023-02-20 03:15:14', '2023-02-20 03:15:14', NULL),
(65090, 1, 20, 4, '63f318a4163c0', NULL, '2023 Katsina State Presidential Election', '2023', 3900000, '2023-02-25 00:00:00', 0, 0, 3, '2023-02-20 04:52:20', '2023-02-20 04:52:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `election_types`
--

CREATE TABLE `election_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `election_types`
--

INSERT INTO `election_types` (`id`, `name`, `slug`) VALUES
(1, 'Presidential Election', 'presidential_election'),
(2, 'Governorship Election', 'governorship_election'),
(3, 'Senatorial Election', 'senatorial_election'),
(4, 'House of Representatives Election', 'house_of_rep_election'),
(5, 'House of Assembly Election', 'house_of_assembly_election');

-- --------------------------------------------------------

--
-- Table structure for table `lgas`
--

CREATE TABLE `lgas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lgas`
--

INSERT INTO `lgas` (`id`, `name`, `state`) VALUES
(1, 'Bakori', 'Katsina'),
(2, 'Batagarawa', 'Katsina'),
(3, 'Batsari', 'Katsina'),
(4, 'Baure', 'Katsina'),
(5, 'Bindawa', 'Katsina'),
(6, 'Charanchi', 'Katsina'),
(7, 'Dan Musa', 'Katsina'),
(8, 'Dandume', 'Katsina'),
(9, 'Danja', 'Katsina'),
(10, 'Daura', 'Katsina'),
(11, 'Dutsi', 'Katsina'),
(12, 'Dutsin-Ma', 'Katsina'),
(13, 'Faskari', 'Katsina'),
(14, 'Funtua', 'Katsina'),
(15, 'Ingawa', 'Katsina'),
(16, 'Jibia', 'Katsina'),
(17, 'Kafur', 'Katsina'),
(18, 'Kaita', 'Katsina'),
(19, 'Kankara', 'Katsina'),
(20, 'Kankia', 'Katsina'),
(21, 'Katsina', 'Katsina'),
(22, 'Kurfi', 'Katsina'),
(23, 'Kusada', 'Katsina'),
(24, 'Mai\'Adua', 'Katsina'),
(25, 'Malumfashi', 'Katsina'),
(26, 'Mani', 'Katsina'),
(27, 'Mashi', 'Katsina'),
(28, 'Matazu', 'Katsina'),
(29, 'Musawa', 'Katsina'),
(30, 'Rimi', 'Katsina'),
(31, 'Sabuwa', 'Katsina'),
(32, 'Safana', 'Katsina'),
(33, 'Sandamu', 'Katsina'),
(34, 'Zango', 'Katsina');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `type` varchar(50) DEFAULT 'post' COMMENT 'post, election_result',
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code_number` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `user_id`, `state_id`, `name`, `code_number`, `description`, `status`, `created_at`, `updated_at`) VALUES
(6, 20, 4, 'All Progressive Congress', '62f8f602680ef', 'Gsjhdh', 1, '2022-08-14 13:17:54', '2022-08-14 13:17:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(119) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `status`, `created_at`, `updated_at`) VALUES
(4, 'umeohia.chidi@gmail.com', '62f8de775102a_16604770471660477047_i8wlgQic9HmL19lvU0qHgGAXY7JKBVsQJr0mNR7wb4dq6YYYACKFYjTwU8f0aWASfT23Cr_62f8de7751036', 1, '2022-08-14 11:37:27', '2022-08-14 11:37:27'),
(5, 'yelsunais2014@gmail.com', '6386459551273_16697440211669744021_jOkEP3ctg7ZK2siXXxjeCqWZGuu8X9uXZnDO41RERi9KjI6O9gLtcJn3s8HAQjJq4PwZFx_638645955127d', 1, '2022-11-29 17:47:01', '2022-11-29 17:47:01'),
(6, 'umeohia.chidi@gmail.com', '63a01c6ebaeee_16714374221671437422_Oyg65nLUavowGyXVizlcN6y0tVuj8FWnlZMBIBVgB7Ls6hcGb3px3F7cNo3hLJtB0Bd4wH_63a01c6ebaefc', 1, '2022-12-19 08:10:22', '2022-12-19 08:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `political_parties`
--

CREATE TABLE `political_parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `short_name` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `motto` varchar(191) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `political_parties`
--

INSERT INTO `political_parties` (`id`, `user_id`, `name`, `short_name`, `logo`, `motto`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 19, 'Accord', 'A', '1660477920_65Gk0qUNWuG0bbSUd5ggCgofQeo4xRafniYu6VBK_62f8e1e025d43.png', '-', 0, '2022-08-14 11:52:02', '2022-08-14 11:52:02', NULL),
(6, 19, 'Action Alliance', 'AA', '1660477986_Jhyj7H0wt7jYnfU7uFoYLWKo5k0nxl06e2s7LhXo_62f8e222b7be0.png', '-', 0, '2022-08-14 11:53:06', '2022-08-14 11:53:06', NULL),
(7, 19, 'Action Democratic Party', 'ADP', '1660478074_jx683XXX71MpL2aVzJx7LJikjxH8O5NiDotTgimM_62f8e27ad737f.png', '-', 0, '2022-08-14 11:54:34', '2022-08-14 11:54:34', NULL),
(8, 19, 'Action Peoples Party', 'APP', '1660478782_VIiecUYDamNWgXyVPF1or6Erk9Ar4J8IjvFwzjJw_62f8e53e8b44e.png', '-', 0, '2022-08-14 12:06:25', '2022-08-14 12:06:25', NULL),
(9, 19, 'African Action Congress', 'AAC', '1660478889_3bzuSRhPYqeBd02hGfD6rPvLnkIIujqPzGl9FsBz_62f8e5a939c78.png', '-', 0, '2022-08-14 12:08:09', '2022-08-14 12:08:09', NULL),
(10, 19, 'African Democratic Congress', 'ADC', '1660478979_ZkywJUTLOwg3Bg42deg37zc2zNgCk4oJG8CP44ic_62f8e603616e3.png', '-', 0, '2022-08-14 12:09:39', '2022-08-14 12:09:39', NULL),
(11, 19, 'All Progressives Congress', 'APC', '1660479079_9a4hYNIMHhjzY8g6XqClPM5MXSyUprdzFCrgyfPv_62f8e6673bead.png', '-', 0, '2022-08-14 12:11:19', '2022-08-14 12:11:19', NULL),
(12, 19, 'All Progressives Grand Alliance', 'APGA', '1660479161_PGkvIBj185BzGQciqBS7wMDBYb2hhTndjAn5ExJ8_62f8e6b9ae17b.png', '-', 0, '2022-08-14 12:12:41', '2022-08-14 12:12:41', NULL),
(13, 19, 'Allied Peoples Movement', 'APM', '1660479247_624WIWHuXxUXIRMe5mtA3XjwYVNA5nGmGc2gxxk5_62f8e70f44069.png', '-', 0, '2022-08-14 12:14:07', '2022-08-14 12:14:07', NULL),
(14, 19, 'Boot Party', 'BP', '1660479349_N5UtO1MQ9vZe3pOLoLOhMIZnrnZmgQ9wkdn7skLy_62f8e775d9579.png', '-', 0, '2022-08-14 12:15:49', '2022-08-14 12:15:49', NULL),
(15, 19, 'Labour Party', 'LP', '1660479403_mngHACaFDBOE4gGu7VwzrsIT7oLDSvj7nc7T2QJp_62f8e7abe7161.png', '-', 0, '2022-08-14 12:16:43', '2022-08-14 12:16:43', NULL),
(16, 19, 'National Rescue Movement', 'NRM', '1660479465_kzehNIry15QPwSFaHHF67e4qx1DfWfwdnhcJkKig_62f8e7e954b75.png', '-', 0, '2022-08-14 12:17:45', '2022-08-14 12:17:45', NULL),
(17, 19, 'New Nigeria Peoples Party', 'NNPP', '1660479527_L7KWC91QkS8hxtCxMTiSg476gx0PWfMfL6UJPTNO_62f8e8274d096.png', '-', 0, '2022-08-14 12:18:47', '2022-08-14 12:18:47', NULL),
(18, 19, 'Peoples Democratic Party', 'PDP', '1660479600_rmjZoESC0Qx73c35turu6AD5XwzQlPbeY9BV0FFW_62f8e870aa1c5.png', '-', 0, '2022-08-14 12:20:00', '2022-08-14 12:20:00', NULL),
(19, 19, 'Peoples Redemption Party', 'PRP', '1660479680_LbqjHEyNLCDDCpB6k6LdYOahhHAsO2BPPO1FkRDo_62f8e8c098cd1.png', '-', 0, '2022-08-14 12:21:20', '2022-08-14 12:21:20', NULL),
(20, 19, 'Social Democratic Party', 'SDP', '1660479733_MD1D6G4nM0c6bUzyZkWtGZ9hFFdDDY2PpFRkHA48_62f8e8f5f1870.png', '-', 0, '2022-08-14 12:22:14', '2022-08-14 12:22:14', NULL),
(21, 19, 'Young Progressive Party', 'YPP', '1660479800_CLRwFpPLO4M3wgKBCOGv3iH9Do72HIGP6rJI1nYk_62f8e93828db4.png', '-', 0, '2022-08-14 12:23:20', '2022-08-14 12:23:20', NULL),
(22, 19, 'Zenith Labour Party', 'ZLP', '1660479865_sE2qtrZ8gUZnomuLt6QsJRLwm6a5hkWgRKJVwKHX_62f8e9791a874.png', '-', 0, '2022-08-14 12:24:25', '2022-08-14 12:24:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `polling_units`
--

CREATE TABLE `polling_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ward_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lga_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assignedBy_` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `polling_units`
--

INSERT INTO `polling_units` (`id`, `ward_id`, `lga_id`, `assignedBy_`, `user_id`, `name`, `state`, `latitude`, `longitude`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1000000, 2000001, 85, 19, 19, 'Polling Unit One', 'Katsina State', '6.4752111', '3.3286866', '63f2ff8386acf', '2023-02-20 03:05:07', '2023-02-20 03:05:07', NULL),
(1000001, 2000001, 85, 19, 19, 'Polling Unit Two', 'Katsina State', '6.4752111', '3.3286866', '63f2ff948ecd3', '2023-02-20 03:05:24', '2023-02-20 03:05:24', NULL),
(1000002, 2000002, 85, 19, 19, 'Polling Unit Three', 'Katsina State', '6.4752111', '3.3286866', '63f2ff9eaf232', '2023-02-20 03:05:34', '2023-02-20 03:05:34', NULL),
(1000003, 2000002, 85, 19, 19, 'Polling Unit Four', 'Katsina State', '6.4752111', '3.3286866', '63f2ffa9bca1e', '2023-02-20 03:05:45', '2023-02-20 03:05:45', NULL),
(1000004, 2000003, 95, 19, 19, 'Polling Unit Five', 'Katsina State', '6.4752111', '3.3286866', '63f2ffb2d304d', '2023-02-20 03:05:54', '2023-02-20 03:05:54', NULL),
(1000005, 2000003, 95, 19, 19, 'Polling Unit Six', 'Katsina State', '6.4752111', '3.3286866', '63f2ffc506a59', '2023-02-20 03:06:13', '2023-02-20 03:06:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `polling_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `election_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(191) DEFAULT 'post',
  `code_number` varchar(191) DEFAULT NULL,
  `docs` longtext DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `title` text DEFAULT NULL,
  `ip_info` longtext DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_id`, `polling_unit_id`, `election_id`, `type`, `code_number`, `docs`, `content`, `title`, `ip_info`, `ip_address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(42, 25, NULL, 1000005, 65089, 'post', '63f309e116824_1676872161', '[]', 'Ggg', NULL, '{\"state\":\"Lagos\",\"ip_address\":\"197.210.52.56\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Festac Town\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.2829899999999998527755451505072414875030517578125,\"latitude\":6.469699999999999562305674771778285503387451171875,\"currency\":\"\",\"country\":\"Nigeria\"}', '197.210.52.56', '2023-02-20 03:49:21', '2023-02-20 03:49:21', NULL),
(43, 20, 42, NULL, NULL, 'comment', '63f31a8439dfa_1676876420', '[]', 'okay', NULL, '{\"state\":\"Kaduna\",\"ip_address\":\"105.112.226.191\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Makera\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.41026000000000006906475391588173806667327880859375,\"latitude\":10.471399999999999153033058973960578441619873046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '105.112.226.191', '2023-02-20 05:00:20', '2023-02-20 05:00:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`) VALUES
(1, 'Super Admin', 'super_admin'),
(2, 'User', 'basic_user'),
(3, 'LGA Admin', 'lga_admin'),
(5, 'Ward Admin', 'ward_admin'),
(6, 'Zonal Admin', 'zonal_admin');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(28, 'Abia State'),
(26, 'Adamawa State'),
(15, 'Akwa Ibom State'),
(10, 'Anambra State'),
(7, 'Bauchi State'),
(36, 'Bayelsa State'),
(9, 'Benue State'),
(11, 'Borno State'),
(27, 'Cross River State'),
(12, 'Delta State'),
(34, 'Ebonyi State'),
(24, 'Edo State'),
(29, 'Ekiti State'),
(22, 'Enugu State'),
(37, 'FCT'),
(31, 'Gombe State'),
(13, 'Imo State'),
(8, 'Jigawa State'),
(3, 'Kaduna State'),
(1, 'Kano State'),
(4, 'Katsina State'),
(23, 'Kebbi State'),
(20, 'Kogi State'),
(30, 'Kwara State'),
(2, 'Lagos State'),
(35, 'Nasarawa State'),
(14, 'Niger State'),
(16, 'Ogun State'),
(18, 'Ondo State'),
(19, 'Osun State'),
(5, 'Oyo State'),
(25, 'Plateau State'),
(6, 'Rivers State'),
(17, 'Sokoto State'),
(33, 'Taraba State'),
(32, 'Yobe State'),
(21, 'Zamfara State');

-- --------------------------------------------------------

--
-- Table structure for table `temp_stats`
--

CREATE TABLE `temp_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `election_id` bigint(20) UNSIGNED DEFAULT NULL,
  `polling_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `political_party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `polling_unit` varchar(191) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `party_name` varchar(191) DEFAULT NULL,
  `total_votes` float DEFAULT NULL,
  `invalid_votes` float DEFAULT NULL,
  `valid_votes` float DEFAULT NULL,
  `party_total_votes` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lga_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT 600,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `code_number` varchar(191) DEFAULT NULL,
  `remember_token` varchar(191) DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `ip_info` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `email_is_confirmed` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lga_id`, `role_id`, `name`, `email`, `phone_number`, `password`, `code_number`, `remember_token`, `ip_address`, `ip_info`, `status`, `email_is_confirmed`, `created_at`, `updated_at`) VALUES
(19, NULL, 1, 'Chidiebere Umeohia', 'umeohia.chidi@gmail.com', '08106928318', '$2y$10$3uGKNNwf7aZvvYCixBGifO7sguU6wLJ/HiPF5Xfb9S8Yv6apFAlwm', '62f8dba7238a0', 'DEsOU5txdiM2T9gIBGNqhtVsHZ25gAXSKjP0MGvqKp3yfFBwHs46epEIWcPD', '102.89.40.143', '{\"state\":\"Lagos\",\"ip_address\":\"102.89.40.143\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.390299999999999869260136620141565799713134765625,\"latitude\":6.4474000000000000198951966012828052043914794921875,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2022-08-14 11:25:27', '2022-08-14 11:25:27'),
(20, NULL, 1, 'Yusha\'u El-sunais Sani', 'yelsunais2014@gmail.com', '07050700903', '$2y$10$vtprAYu3i/LT6AE4QprtquCAIpFHpvMC6o5SRoGgZyefa9.7r.e/i', '62f8f5fee2917', 'e9qPGbTKoRwsGKP9RGSG98YMZoPCQOjJyd1RHFfz7wl4Ujwg3Ox4v5mFkYSa', '105.112.125.88', '{\"state\":\"Federal Capital Territory\",\"ip_address\":\"105.112.125.88\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Abuja\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.49509999999999987352339303470216691493988037109375,\"latitude\":9.057900000000000062527760746888816356658935546875,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2022-08-14 13:17:54', '2022-08-14 13:17:54'),
(25, 419, 500, 'Isiyaku Isya', 'isyakuisya@gmail.com', '07031857635', '$2y$10$PsbDyMHdzMOhvNc.47WzBOqugyXTm6PkN4kgPx5VHEMWrrawX0tVu', '63c90b43d09b2', '2UETALXl5vemcb9ip5NwHZ0yF2iomyrEkfROmekDTV4hhzvcL8Hcwrz4F80g', '105.112.224.116', '{\"state\":\"Nassarawa\",\"ip_address\":\"105.112.224.116\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Dekina\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.04380000000000006110667527536861598491668701171875,\"latitude\":7.68966999999999956116880639456212520599365234375,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-01-19 07:20:04', '2023-01-19 07:20:04'),
(26, 419, 1, 'Huzaifa Yakubu', 'huzex87@gmail.com', '08039254849', '$2y$10$BiPaa8BMlUnP0KKDIxyjAuA1UG9ZhvkndoO9ARj6sHrUDHjUN42eK', '63f220cdd6b20', 'zwQJ7jyuKTJDfG672z5Of1uNazZvPFeViTw7rgY4EKsZnmXAy4qEo3XJv8Cw', '105.112.228.227', '{\"state\":\"Lagos\",\"ip_address\":\"105.112.228.227\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Ikoyi)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.425170000000000047890580390230752527713775634765625,\"latitude\":6.46529000000000042547299017314799129962921142578125,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-19 11:14:54', '2023-02-19 11:14:54'),
(27, 411, 1, 'Mansur', 'siratech1200@gmail.com', '08140556954', '$2y$10$yZm25oTmOHaRbTdUEP/2veZXWEvPYRr1dgLhkD6ZN464.IwesadY.', '63f22f01b83f0', 'fdAXDzYJDhFkrb4okSa1iAG3VPJFw1FAFdn9Kq4REPbiJPVLkdkg5YZ5RdpD', '197.210.77.111', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.77.111\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Ajegunle\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.33115000000000005542233338928781449794769287109375,\"latitude\":6.45197000000000020492052499321289360523223876953125,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-19 12:15:29', '2023-02-19 12:15:29'),
(28, 85, 2, 'Jabu', 'ahmadmusay89@gmail.com', '08135609993', '$2y$10$PGpV9I3C2ptmlOqprpbO2O9fw.x/PU/AFvGXUZsAAEwgvJfc8hPJO', '63f265ddc877b', 'CXDBuJ8gcPyP7iPbSHIubouBE1wSO2JmX3hBtSuRooYeEGqMq5vHC8jVZN2C', '102.91.46.186', '{\"state\":\"Lagos\",\"ip_address\":\"102.91.46.186\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-19 16:09:34', '2023-02-19 16:09:34'),
(29, 452, 2, 'Sp360 User', 'sp360app@gmail.com', '08120242735', '$2y$10$ANcSNdMvIDmCbP6piNMZ9.nQA5B.cuhZiDiWGcYprNWIA/FsihbVa', '63f2fc792090e', NULL, '102.88.63.232', '{\"state\":\"Lagos\",\"ip_address\":\"102.88.63.232\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-20 02:52:09', '2023-02-20 02:52:09'),
(31, 349, 2, 'Hauwau Kabir', 'hauwaukabirnabature@gmail.com', '08141352148', '$2y$10$QpVhFh/Gf5aE2CZU.Ou0SuSAKc/VnoNxOMEvOv4k0/3sKmmeXOwcW', '63f319f606025', NULL, '105.112.226.191', '{\"state\":\"Kaduna\",\"ip_address\":\"105.112.226.191\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Makera\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.41026000000000006906475391588173806667327880859375,\"latitude\":10.471399999999999153033058973960578441619873046875,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-20 04:57:58', '2023-02-20 04:57:58'),
(32, NULL, 2, 'Siratech', 'haumantech@gmail.com', '8140556954', '$2y$10$t1LqV8W1uwaGGr8hcm55kuLA7dbvt161FB7GtY5C9FCNdpJRHRog.', '63f332523820c', 'DYLVKM1six27CqvO7tI9ax03E0NgOHTzwhDz7MFijiMr0mpEjJTcGYikl75w', '197.210.140.26', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.140.26\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.379210000000000047037929107318632304668426513671875,\"latitude\":6.52437999999999984623855198151431977748870849609375,\"currency\":\"\",\"country\":\"Nigeria\"}', 1, 0, '2023-02-20 06:41:54', '2023-02-20 06:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(191) DEFAULT NULL,
  `ip_info` text DEFAULT NULL,
  `device_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `ip_address`, `ip_info`, `device_details`, `created_at`, `updated_at`) VALUES
(39, 19, '127.0.0.1', '', '', '2023-01-24 07:17:53', '2023-01-24 07:17:53'),
(40, 19, '127.0.0.1', '', '', '2023-01-24 07:54:55', '2023-01-24 07:54:55'),
(41, 19, '127.0.0.1', '', '', '2023-01-31 16:14:33', '2023-01-31 16:14:33'),
(42, 19, '127.0.0.1', '', '', '2023-02-03 12:47:54', '2023-02-03 12:47:54'),
(43, 19, '127.0.0.1', '', '', '2023-02-03 16:16:59', '2023-02-03 16:16:59'),
(44, 19, '127.0.0.1', '', '', '2023-02-03 16:31:02', '2023-02-03 16:31:02'),
(45, 19, '127.0.0.1', '', '', '2023-02-07 16:17:59', '2023-02-07 16:17:59'),
(46, 19, '127.0.0.1', '', '', '2023-02-09 03:08:57', '2023-02-09 03:08:57'),
(47, 19, '127.0.0.1', '', '', '2023-02-09 05:56:53', '2023-02-09 05:56:53'),
(48, 19, '127.0.0.1', '', '', '2023-02-09 05:59:07', '2023-02-09 05:59:07'),
(49, 19, '102.88.34.65', '{\"state\":\"Lagos\",\"ip_address\":\"102.88.34.65\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Ikoyi\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.435840000000000227231566896080039441585540771484375,\"latitude\":6.45253999999999994230392985627986490726470947265625,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:04:39', '2023-02-19 11:04:39'),
(50, 19, '102.88.35.15', '{\"state\":\"Lagos\",\"ip_address\":\"102.88.35.15\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:08:10', '2023-02-19 11:08:10'),
(51, 26, '105.112.117.4', '{\"state\":\"Kano\",\"ip_address\":\"105.112.117.4\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Takai\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":9.1088000000000004519051799434237182140350341796875,\"latitude\":11.5756999999999994344079823349602520465850830078125,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:21:55', '2023-02-19 11:21:55'),
(52, 26, '105.112.117.4', '{\"state\":\"Kano\",\"ip_address\":\"105.112.117.4\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Takai\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":9.1088000000000004519051799434237182140350341796875,\"latitude\":11.5756999999999994344079823349602520465850830078125,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:32:31', '2023-02-19 11:32:31'),
(53, 26, '105.112.117.4', '{\"state\":\"Kano\",\"ip_address\":\"105.112.117.4\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Takai\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":9.1088000000000004519051799434237182140350341796875,\"latitude\":11.5756999999999994344079823349602520465850830078125,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:38:41', '2023-02-19 11:38:41'),
(54, 26, '105.112.117.4', '{\"state\":\"Kano\",\"ip_address\":\"105.112.117.4\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Takai\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":9.1088000000000004519051799434237182140350341796875,\"latitude\":11.5756999999999994344079823349602520465850830078125,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 11:40:44', '2023-02-19 11:40:44'),
(55, 26, '102.91.52.195', '{\"state\":\"Kaduna\",\"ip_address\":\"102.91.52.195\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Makera\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.41026000000000006906475391588173806667327880859375,\"latitude\":10.471399999999999153033058973960578441619873046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 13:38:59', '2023-02-19 13:38:59'),
(56, 27, '197.210.71.21', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.71.21\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Ikoyi)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.426530000000000075743855632026679813861846923828125,\"latitude\":6.44367999999999963023356031044386327266693115234375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 14:38:45', '2023-02-19 14:38:45'),
(57, 19, '102.89.32.63', '{\"state\":\"Lagos\",\"ip_address\":\"102.89.32.63\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 15:24:26', '2023-02-19 15:24:26'),
(58, 19, '102.89.33.205', '{\"state\":\"Lagos\",\"ip_address\":\"102.89.33.205\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Ikoyi\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.435840000000000227231566896080039441585540771484375,\"latitude\":6.45253999999999994230392985627986490726470947265625,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 15:25:48', '2023-02-19 15:25:48'),
(59, 28, '197.210.77.29', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.77.29\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Ikoyi)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.426530000000000075743855632026679813861846923828125,\"latitude\":6.44367999999999963023356031044386327266693115234375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-19 16:11:33', '2023-02-19 16:11:33'),
(60, 25, '197.210.53.247', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.53.247\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Ikoyi)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.426530000000000075743855632026679813861846923828125,\"latitude\":6.44367999999999963023356031044386327266693115234375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 03:38:07', '2023-02-20 03:38:07'),
(61, 20, '105.112.226.191', '{\"state\":\"Kaduna\",\"ip_address\":\"105.112.226.191\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Makera\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.41026000000000006906475391588173806667327880859375,\"latitude\":10.471399999999999153033058973960578441619873046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 05:01:20', '2023-02-20 05:01:20'),
(62, 27, '197.210.140.26', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.140.26\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.379210000000000047037929107318632304668426513671875,\"latitude\":6.52437999999999984623855198151431977748870849609375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 06:35:50', '2023-02-20 06:35:50'),
(63, 32, '197.210.140.26', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.140.26\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.379210000000000047037929107318632304668426513671875,\"latitude\":6.52437999999999984623855198151431977748870849609375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 06:43:23', '2023-02-20 06:43:23'),
(64, 32, '197.210.140.26', '{\"state\":\"Lagos\",\"ip_address\":\"197.210.140.26\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.379210000000000047037929107318632304668426513671875,\"latitude\":6.52437999999999984623855198151431977748870849609375,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 06:44:48', '2023-02-20 06:44:48'),
(65, 19, '102.88.62.231', '{\"state\":\"Lagos\",\"ip_address\":\"102.88.62.231\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 18:22:11', '2023-02-20 18:22:11'),
(66, 19, '102.88.62.125', '{\"state\":\"Lagos\",\"ip_address\":\"102.88.62.125\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Lagos (Victoria Island Annex)\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":3.4293800000000000949285094975493848323822021484375,\"latitude\":6.43466999999999966775021675857715308666229248046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 19:17:18', '2023-02-20 19:17:18'),
(67, 25, '105.112.226.21', '{\"state\":\"Kaduna\",\"ip_address\":\"105.112.226.21\",\"country_code\":\"NG\",\"continent\":\"Africa\",\"city\":\"Makera\",\"timezone\":\"Africa\\/Lagos\",\"longitude\":7.41026000000000006906475391588173806667327880859375,\"latitude\":10.471399999999999153033058973960578441619873046875,\"currency\":\"\",\"country\":\"Nigeria\"}', '', '2023-02-20 19:23:40', '2023-02-20 19:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `election_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `election` varchar(191) DEFAULT NULL,
  `zone` varchar(191) DEFAULT NULL,
  `polling_unit` varchar(191) DEFAULT NULL,
  `political_party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total` float UNSIGNED DEFAULT NULL,
  `invalid_votes` float UNSIGNED DEFAULT 0,
  `polling_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ward_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lga_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` int(8) NOT NULL,
  `lga_id` int(7) DEFAULT NULL,
  `user_id` int(20) DEFAULT NULL,
  `assignedBy_` int(20) DEFAULT NULL,
  `name` varchar(21) DEFAULT NULL,
  `state` varchar(7) DEFAULT NULL,
  `code` varchar(150) NOT NULL,
  `created_at` varchar(250) NOT NULL,
  `updated_at` varchar(250) NOT NULL,
  `deleted_at` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `lga_id`, `user_id`, `assignedBy_`, `name`, `state`, `code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2000001, 1, 0, 0, 'BAKORI A', 'Katsina', '', '', '', ''),
(2000002, 1, 0, 0, 'BAKORI B', 'Katsina', '', '', '', ''),
(2000003, 1, 0, 0, 'BARDE/KWANTAKWARAN', 'Katsina', '', '', '', ''),
(2000004, 1, 0, 0, 'DAWAN MUSA', 'Katsina', '', '', '', ''),
(2000005, 1, 0, 0, 'GUGA', 'Katsina', '', '', '', ''),
(2000006, 1, 0, 0, 'JARGABA', 'Katsina', '', '', '', ''),
(2000007, 1, 0, 0, 'KABOMO', 'Katsina', '', '', '', ''),
(2000008, 1, 0, 0, 'KAKUMI', 'Katsina', '', '', '', ''),
(2000009, 1, 0, 0, 'KANDARAWA', 'Katsina', '', '', '', ''),
(2000010, 1, 0, 0, 'KURAMI/YANKWANI', 'Katsina', '', '', '', ''),
(2000011, 1, 0, 0, 'TSIGA', 'Katsina', '', '', '', ''),
(2000012, 2, 0, 0, 'AJIWA', 'Katsina', '', '', '', ''),
(2000013, 2, 0, 0, 'BAKIYAWA', 'Katsina', '', '', '', ''),
(2000014, 2, 0, 0, 'BARAWA', 'Katsina', '', '', '', ''),
(2000015, 2, 0, 0, 'BATAGARAWA A', 'Katsina', '', '', '', ''),
(2000016, 2, 0, 0, 'BATAGARAWA B', 'Katsina', '', '', '', ''),
(2000017, 2, 0, 0, 'DANDAGORO', 'Katsina', '', '', '', ''),
(2000018, 2, 0, 0, 'JINO', 'Katsina', '', '', '', ''),
(2000019, 2, 0, 0, 'KAYAUKI', 'Katsina', '', '', '', ''),
(2000020, 2, 0, 0, 'TSANNI', 'Katsina', '', '', '', ''),
(2000021, 2, 0, 0, 'YARGAMJI', 'Katsina', '', '', '', ''),
(2000022, 3, 0, 0, 'ABADAU/KAGARA', 'Katsina', '', '', '', ''),
(2000023, 3, 0, 0, 'BATSARI', 'Katsina', '', '', '', ''),
(2000024, 3, 0, 0, 'DAN. ALH/YANGAIYA', 'Katsina', '', '', '', ''),
(2000025, 3, 0, 0, 'DARINI/MAGAJI/ABU', 'Katsina', '', '', '', ''),
(2000026, 3, 0, 0, 'KANDAWA', 'Katsina', '', '', '', ''),
(2000027, 3, 0, 0, 'KARARE', 'Katsina', '', '', '', ''),
(2000028, 3, 0, 0, 'MADOGARA', 'Katsina', '', '', '', ''),
(2000029, 3, 0, 0, 'MANAWA', 'Katsina', '', '', '', ''),
(2000030, 3, 0, 0, 'RUMA', 'Katsina', '', '', '', ''),
(2000031, 3, 0, 0, 'WAGINI', 'Katsina', '', '', '', ''),
(2000032, 3, 0, 0, 'YAUYAU/MALLAMAWA', 'Katsina', '', '', '', ''),
(2000033, 4, 0, 0, 'AGALA', 'Katsina', '', '', '', ''),
(2000034, 4, 0, 0, 'BABBAN MUTUM', 'Katsina', '', '', '', ''),
(2000035, 4, 0, 0, 'BAURE', 'Katsina', '', '', '', ''),
(2000036, 4, 0, 0, 'GARKI', 'Katsina', '', '', '', ''),
(2000037, 4, 0, 0, 'HUI', 'Katsina', '', '', '', ''),
(2000038, 4, 0, 0, 'KAGARA/FASKI', 'Katsina', '', '', '', ''),
(2000039, 4, 0, 0, 'MAI BARA', 'Katsina', '', '', '', ''),
(2000040, 4, 0, 0, 'MUDURI', 'Katsina', '', '', '', ''),
(2000041, 4, 0, 0, 'TARAMNAWA/BARE', 'Katsina', '', '', '', ''),
(2000042, 4, 0, 0, 'UNGUWAR RAI', 'Katsina', '', '', '', ''),
(2000043, 4, 0, 0, 'YANDUNA', 'Katsina', '', '', '', ''),
(2000044, 4, 0, 0, 'YANMAULU', 'Katsina', '', '', '', ''),
(2000045, 5, 0, 0, 'BAURE', 'Katsina', '', '', '', ''),
(2000046, 5, 0, 0, 'BINDAWA', 'Katsina', '', '', '', ''),
(2000047, 5, 0, 0, 'DORO', 'Katsina', '', '', '', ''),
(2000048, 5, 0, 0, 'FARU/DALLAJI', 'Katsina', '', '', '', ''),
(2000049, 5, 0, 0, 'GAIWA', 'Katsina', '', '', '', ''),
(2000050, 5, 0, 0, 'GIREMAWA', 'Katsina', '', '', '', ''),
(2000051, 5, 0, 0, 'JIBAWA/R,BADE', 'Katsina', '', '', '', ''),
(2000052, 5, 0, 0, 'KAMRI', 'Katsina', '', '', '', ''),
(2000053, 5, 0, 0, 'SHIBDAWA', 'Katsina', '', '', '', ''),
(2000054, 5, 0, 0, 'TAMA/DAYE', 'Katsina', '', '', '', ''),
(2000055, 5, 0, 0, 'YANGORA', 'Katsina', '', '', '', ''),
(2000056, 6, 0, 0, 'BANYE', 'Katsina', '', '', '', ''),
(2000057, 6, 0, 0, 'CHARANCHI', 'Katsina', '', '', '', ''),
(2000058, 6, 0, 0, 'DOKA', 'Katsina', '', '', '', ''),
(2000059, 6, 0, 0, 'GANUWA', 'Katsina', '', '', '', ''),
(2000060, 6, 0, 0, 'KODA', 'Katsina', '', '', '', ''),
(2000061, 6, 0, 0, 'KURAYE', 'Katsina', '', '', '', ''),
(2000062, 6, 0, 0, 'MAJEN WAYYA', 'Katsina', '', '', '', ''),
(2000063, 6, 0, 0, 'RADDA', 'Katsina', '', '', '', ''),
(2000064, 6, 0, 0, 'SAFANA', 'Katsina', '', '', '', ''),
(2000065, 6, 0, 0, 'TSAKATSA', 'Katsina', '', '', '', ''),
(2000066, 7, 0, 0, 'DANDUME A', 'Katsina', '', '', '', ''),
(2000067, 7, 0, 0, 'DANDUME B', 'Katsina', '', '', '', ''),
(2000068, 7, 0, 0, 'DANTANKARI', 'Katsina', '', '', '', ''),
(2000069, 7, 0, 0, 'MAGAJI WANDO A', 'Katsina', '', '', '', ''),
(2000070, 7, 0, 0, 'MAGAJI WANDO B', 'Katsina', '', '', '', ''),
(2000071, 7, 0, 0, 'MAHUTA A', 'Katsina', '', '', '', ''),
(2000072, 7, 0, 0, 'MAHUTA B', 'Katsina', '', '', '', ''),
(2000073, 7, 0, 0, 'MAHUTA C', 'Katsina', '', '', '', ''),
(2000074, 7, 0, 0, 'NASARAWA', 'Katsina', '', '', '', ''),
(2000075, 7, 0, 0, 'TUMBURKAI A', 'Katsina', '', '', '', ''),
(2000076, 7, 0, 0, 'TUMBURKAI B', 'Katsina', '', '', '', ''),
(2000077, 8, 0, 0, 'DABAI', 'Katsina', '', '', '', ''),
(2000078, 8, 0, 0, 'DANJA A', 'Katsina', '', '', '', ''),
(2000079, 8, 0, 0, 'DANJA B', 'Katsina', '', '', '', ''),
(2000080, 8, 0, 0, 'JIBA', 'Katsina', '', '', '', ''),
(2000081, 8, 0, 0, 'KAHUTU A', 'Katsina', '', '', '', ''),
(2000082, 8, 0, 0, 'KAHUTU B', 'Katsina', '', '', '', ''),
(2000083, 8, 0, 0, 'TANDAMA', 'Katsina', '', '', '', ''),
(2000084, 8, 0, 0, 'TSANGAMAWA', 'Katsina', '', '', '', ''),
(2000085, 8, 0, 0, 'YAKAJI A', 'Katsina', '', '', '', ''),
(2000086, 8, 0, 0, 'YAKAJI B', 'Katsina', '', '', '', ''),
(2000087, 9, 0, 0, 'DAN ALI', 'Katsina', '', '', '', ''),
(2000088, 9, 0, 0, 'DAN ALKIMA', 'Katsina', '', '', '', ''),
(2000089, 9, 0, 0, 'DANDIRE A', 'Katsina', '', '', '', ''),
(2000090, 9, 0, 0, 'DANDIRE B', 'Katsina', '', '', '', ''),
(2000091, 9, 0, 0, 'DANMUSA A', 'Katsina', '', '', '', ''),
(2000092, 9, 0, 0, 'DANMUSA B', 'Katsina', '', '', '', ''),
(2000093, 9, 0, 0, 'MAIDABINO A', 'Katsina', '', '', '', ''),
(2000094, 9, 0, 0, 'MAIDABINO B', 'Katsina', '', '', '', ''),
(2000095, 9, 0, 0, 'MARA', 'Katsina', '', '', '', ''),
(2000096, 9, 0, 0, 'YAN-TUMAKI A', 'Katsina', '', '', '', ''),
(2000097, 9, 0, 0, 'YAN-TUMAKI B', 'Katsina', '', '', '', ''),
(2000098, 10, 0, 0, 'KUSUGU', 'Katsina', '', '', '', ''),
(2000099, 10, 0, 0, 'MADOBI A', 'Katsina', '', '', '', ''),
(2000100, 10, 0, 0, 'MADOBI B', 'Katsina', '', '', '', ''),
(2000101, 10, 0, 0, 'MAZOJI A', 'Katsina', '', '', '', ''),
(2000102, 10, 0, 0, 'MAZOJI B', 'Katsina', '', '', '', ''),
(2000103, 10, 0, 0, 'SABON GARI', 'Katsina', '', '', '', ''),
(2000104, 10, 0, 0, 'SARKIN YARA A', 'Katsina', '', '', '', ''),
(2000105, 10, 0, 0, 'SARKIN YARA B', 'Katsina', '', '', '', ''),
(2000106, 10, 0, 0, 'TUDUN WADA', 'Katsina', '', '', '', ''),
(2000107, 10, 0, 0, 'UBAN DAWAKI A', 'Katsina', '', '', '', ''),
(2000108, 10, 0, 0, 'UBAN DAWAKI B', 'Katsina', '', '', '', ''),
(2000109, 11, 0, 0, 'DAN AUNAI', 'Katsina', '', '', '', ''),
(2000110, 11, 0, 0, 'DUTSI A', 'Katsina', '', '', '', ''),
(2000111, 11, 0, 0, 'DUTSI B', 'Katsina', '', '', '', ''),
(2000112, 11, 0, 0, 'KAYAWA', 'Katsina', '', '', '', ''),
(2000113, 11, 0, 0, 'RUWANKAYA A', 'Katsina', '', '', '', ''),
(2000114, 11, 0, 0, 'RUWANKAYA B', 'Katsina', '', '', '', ''),
(2000115, 11, 0, 0, 'SIRIKA A', 'Katsina', '', '', '', ''),
(2000116, 11, 0, 0, 'SIRIKA B', 'Katsina', '', '', '', ''),
(2000117, 11, 0, 0, 'YAMEL A', 'Katsina', '', '', '', ''),
(2000118, 11, 0, 0, 'YAMEL B', 'Katsina', '', '', '', ''),
(2000119, 12, 0, 0, 'BAGAGADI', 'Katsina', '', '', '', ''),
(2000120, 12, 0, 0, 'DABAWA', 'Katsina', '', '', '', ''),
(2000121, 12, 0, 0, 'DUTIN-MA A', 'Katsina', '', '', '', ''),
(2000122, 12, 0, 0, 'DUTIN-MA B', 'Katsina', '', '', '', ''),
(2000123, 12, 0, 0, 'KAROFI A', 'Katsina', '', '', '', ''),
(2000124, 12, 0, 0, 'KAROFI B', 'Katsina', '', '', '', ''),
(2000125, 12, 0, 0, 'KUKI A', 'Katsina', '', '', '', ''),
(2000126, 12, 0, 0, 'KUKI B', 'Katsina', '', '', '', ''),
(2000127, 12, 0, 0, 'KUTAWA', 'Katsina', '', '', '', ''),
(2000128, 12, 0, 0, 'MAKERA', 'Katsina', '', '', '', ''),
(2000129, 12, 0, 0, 'SHEMA', 'Katsina', '', '', '', ''),
(2000130, 13, 0, 0, 'DAUDAWA', 'Katsina', '', '', '', ''),
(2000131, 13, 0, 0, 'FASKARI', 'Katsina', '', '', '', ''),
(2000132, 13, 0, 0, 'MAIGORA', 'Katsina', '', '', '', ''),
(2000133, 13, 0, 0, 'MAIRUWA', 'Katsina', '', '', '', ''),
(2000134, 13, 0, 0, 'RUWAN GODIYA', 'Katsina', '', '', '', ''),
(2000135, 13, 0, 0, 'SABONLAYI/GALADIMA', 'Katsina', '', '', '', ''),
(2000136, 13, 0, 0, 'SHEME', 'Katsina', '', '', '', ''),
(2000137, 13, 0, 0, 'TAFOKI', 'Katsina', '', '', '', ''),
(2000138, 13, 0, 0, 'YANKARA', 'Katsina', '', '', '', ''),
(2000139, 13, 0, 0, 'YARMALAMAI', 'Katsina', '', '', '', ''),
(2000140, 14, 0, 0, 'DANDUTSE', 'Katsina', '', '', '', ''),
(2000141, 14, 0, 0, 'DUKKE', 'Katsina', '', '', '', ''),
(2000142, 14, 0, 0, 'GOYA', 'Katsina', '', '', '', ''),
(2000143, 14, 0, 0, 'MAI GAMJI', 'Katsina', '', '', '', ''),
(2000144, 14, 0, 0, 'MAKERA', 'Katsina', '', '', '', ''),
(2000145, 14, 0, 0, 'MASKA', 'Katsina', '', '', '', ''),
(2000146, 14, 0, 0, 'SABON GARI', 'Katsina', '', '', '', ''),
(2000147, 14, 0, 0, 'TUDUN IYA', 'Katsina', '', '', '', ''),
(2000148, 14, 0, 0, 'UNG IBRAHIM', 'Katsina', '', '', '', ''),
(2000149, 14, 0, 0, 'UNG MUSA', 'Katsina', '', '', '', ''),
(2000150, 14, 0, 0, 'UNGUWAR RABIU', 'Katsina', '', '', '', ''),
(2000151, 15, 0, 0, 'AGAYAWA', 'Katsina', '', '', '', ''),
(2000152, 15, 0, 0, 'BARERUWA/RURUMA', 'Katsina', '', '', '', ''),
(2000153, 15, 0, 0, 'BIDORE/YAYA', 'Katsina', '', '', '', ''),
(2000154, 15, 0, 0, 'DARA', 'Katsina', '', '', '', ''),
(2000155, 15, 0, 0, 'DAUNAKA/B.KWARI', 'Katsina', '', '', '', ''),
(2000156, 15, 0, 0, 'DUGUL', 'Katsina', '', '', '', ''),
(2000157, 15, 0, 0, 'INGAWA', 'Katsina', '', '', '', ''),
(2000158, 15, 0, 0, 'JOBE/KANDAWA', 'Katsina', '', '', '', ''),
(2000159, 15, 0, 0, 'KURFEJI/YANKAURA', 'Katsina', '', '', '', ''),
(2000160, 15, 0, 0, 'MANOMAWA/KAFI', 'Katsina', '', '', '', ''),
(2000161, 15, 0, 0, 'YANDOMA', 'Katsina', '', '', '', ''),
(2000162, 16, 0, 0, 'BUGAJE', 'Katsina', '', '', '', ''),
(2000163, 16, 0, 0, 'FARFARU', 'Katsina', '', '', '', ''),
(2000164, 16, 0, 0, 'FARU', 'Katsina', '', '', '', ''),
(2000165, 16, 0, 0, 'G/4/MALLAMAWA', 'Katsina', '', '', '', ''),
(2000166, 16, 0, 0, 'GANGARA', 'Katsina', '', '', '', ''),
(2000167, 16, 0, 0, 'JIBIA A', 'Katsina', '', '', '', ''),
(2000168, 16, 0, 0, 'JIBIA B', 'Katsina', '', '', '', ''),
(2000169, 16, 0, 0, 'KUSA', 'Katsina', '', '', '', ''),
(2000170, 16, 0, 0, 'MAZANYA/MAGAMA', 'Katsina', '', '', '', ''),
(2000171, 16, 0, 0, 'RIKO', 'Katsina', '', '', '', ''),
(2000172, 16, 0, 0, 'YANGAIYA', 'Katsina', '', '', '', ''),
(2000173, 17, 0, 0, 'DANTUTTURE', 'Katsina', '', '', '', ''),
(2000174, 17, 0, 0, 'DUTSIN KURA/KANYA', 'Katsina', '', '', '', ''),
(2000175, 17, 0, 0, 'GAMZAGO', 'Katsina', '', '', '', ''),
(2000176, 17, 0, 0, 'GOZAKI', 'Katsina', '', '', '', ''),
(2000177, 17, 0, 0, 'KAFUR', 'Katsina', '', '', '', ''),
(2000178, 17, 0, 0, 'MAHUTA', 'Katsina', '', '', '', ''),
(2000179, 17, 0, 0, 'MASARI', 'Katsina', '', '', '', ''),
(2000180, 17, 0, 0, 'SABUWAR KASA', 'Katsina', '', '', '', ''),
(2000181, 17, 0, 0, 'YARI BORI', 'Katsina', '', '', '', ''),
(2000182, 17, 0, 0, 'YARTALATA/RIGOJI', 'Katsina', '', '', '', ''),
(2000183, 18, 0, 0, 'ABDALLAWA', 'Katsina', '', '', '', ''),
(2000184, 18, 0, 0, 'BAAWA', 'Katsina', '', '', '', ''),
(2000185, 18, 0, 0, 'DANKABA', 'Katsina', '', '', '', ''),
(2000186, 18, 0, 0, 'DANKAMA', 'Katsina', '', '', '', ''),
(2000187, 18, 0, 0, 'GAFIYA', 'Katsina', '', '', '', ''),
(2000188, 18, 0, 0, 'GIRKA', 'Katsina', '', '', '', ''),
(2000189, 18, 0, 0, 'KAITA', 'Katsina', '', '', '', ''),
(2000190, 18, 0, 0, 'MATSAI', 'Katsina', '', '', '', ''),
(2000191, 18, 0, 0, 'YANDAKI', 'Katsina', '', '', '', ''),
(2000192, 18, 0, 0, 'YANHOHO', 'Katsina', '', '', '', ''),
(2000193, 19, 0, 0, 'BURDUGAU', 'Katsina', '', '', '', ''),
(2000194, 19, 0, 0, 'DAN MURABU ', 'Katsina', '', '', '', ''),
(2000195, 19, 0, 0, 'DAN\'MAIDAKI', 'Katsina', '', '', '', ''),
(2000196, 19, 0, 0, 'GARAGI', 'Katsina', '', '', '', ''),
(2000197, 19, 0, 0, 'GATAKAWA S/GARI/MABAI', 'Katsina', '', '', '', ''),
(2000198, 19, 0, 0, 'HURYA', 'Katsina', '', '', '', ''),
(2000199, 19, 0, 0, 'KANKARA A&B', 'Katsina', '', '', '', ''),
(2000200, 19, 0, 0, 'KUKASHEKA', 'Katsina', '', '', '', ''),
(2000201, 19, 0, 0, 'PAUWA A&B', 'Katsina', '', '', '', ''),
(2000202, 19, 0, 0, 'WAWAR KAZA', 'Katsina', '', '', '', ''),
(2000203, 19, 0, 0, 'ZANGO/ZABARO', 'Katsina', '', '', '', ''),
(2000204, 20, 0, 0, 'GACHI', 'Katsina', '', '', '', ''),
(2000205, 20, 0, 0, 'GALADIMA \'A\'', 'Katsina', '', '', '', ''),
(2000206, 20, 0, 0, 'GALADIMA \'B\'', 'Katsina', '', '', '', ''),
(2000207, 20, 0, 0, 'KAFIN DANGI/FAKUWA', 'Katsina', '', '', '', ''),
(2000208, 20, 0, 0, 'KAFINSOLI', 'Katsina', '', '', '', ''),
(2000209, 20, 0, 0, 'KUNDURU/GYAZA', 'Katsina', '', '', '', ''),
(2000210, 20, 0, 0, 'MAGAM/TSA', 'Katsina', '', '', '', ''),
(2000211, 20, 0, 0, 'RIMAYE', 'Katsina', '', '', '', ''),
(2000212, 20, 0, 0, 'SUKUNTUNI', 'Katsina', '', '', '', ''),
(2000213, 20, 0, 0, 'TAFASHIYA/NASARAWA', 'Katsina', '', '', '', ''),
(2000214, 21, 0, 0, 'KANGIWA', 'Katsina', '', '', '', ''),
(2000215, 21, 0, 0, 'SHINKAFI \'A', 'Katsina', '', '', '', ''),
(2000216, 21, 0, 0, 'SHINKAFI \'B\'', 'Katsina', '', '', '', ''),
(2000217, 21, 0, 0, 'WAKILI KUDU III', 'Katsina', '', '', '', ''),
(2000218, 21, 0, 0, 'WAKILIN AREWA (A)', 'Katsina', '', '', '', ''),
(2000219, 21, 0, 0, 'WAKILIN AREWA (B)', 'Katsina', '', '', '', ''),
(2000220, 21, 0, 0, 'WAKILIN GABAS 1', 'Katsina', '', '', '', ''),
(2000221, 21, 0, 0, 'WAKILIN GABAS II', 'Katsina', '', '', '', ''),
(2000222, 21, 0, 0, 'WAKILIN KUDU 1', 'Katsina', '', '', '', ''),
(2000223, 21, 0, 0, 'WAKILIN KUDU II', 'Katsina', '', '', '', ''),
(2000224, 21, 0, 0, 'WAKILIN YAMMA 1', 'Katsina', '', '', '', ''),
(2000225, 21, 0, 0, 'WAKILIN YAMMA II', 'Katsina', '', '', '', ''),
(2000226, 22, 0, 0, 'BARKIYYA', 'Katsina', '', '', '', ''),
(2000227, 22, 0, 0, 'BIRCHI', 'Katsina', '', '', '', ''),
(2000228, 22, 0, 0, 'KURFI \'A\'', 'Katsina', '', '', '', ''),
(2000229, 22, 0, 0, 'KURFI \'B\'', 'Katsina', '', '', '', ''),
(2000230, 22, 0, 0, 'RAWAYAU \'A\'', 'Katsina', '', '', '', ''),
(2000231, 22, 0, 0, 'RAWAYAU \'B\'', 'Katsina', '', '', '', ''),
(2000232, 22, 0, 0, 'TSAURI \'A\'', 'Katsina', '', '', '', ''),
(2000233, 22, 0, 0, 'TSAURI \'B\'', 'Katsina', '', '', '', ''),
(2000234, 22, 0, 0, 'WURMA \'A\'', 'Katsina', '', '', '', ''),
(2000235, 22, 0, 0, 'WURMA \'B\'', 'Katsina', '', '', '', ''),
(2000236, 23, 0, 0, 'BAURANYA \'A\'', 'Katsina', '', '', '', ''),
(2000237, 23, 0, 0, 'BAURANYA \'B\'', 'Katsina', '', '', '', ''),
(2000238, 23, 0, 0, 'BOKO', 'Katsina', '', '', '', ''),
(2000239, 23, 0, 0, 'DUDUNNI', 'Katsina', '', '', '', ''),
(2000240, 23, 0, 0, 'KAIKAI', 'Katsina', '', '', '', ''),
(2000241, 23, 0, 0, 'KOFA', 'Katsina', '', '', '', ''),
(2000242, 23, 0, 0, 'KUSADA', 'Katsina', '', '', '', ''),
(2000243, 23, 0, 0, 'MAWASHI', 'Katsina', '', '', '', ''),
(2000244, 23, 0, 0, 'YASHE \'A', 'Katsina', '', '', '', ''),
(2000245, 23, 0, 0, 'YASHE \'B\'', 'Katsina', '', '', '', ''),
(2000246, 24, 0, 0, 'BUMBUM \'A\'', 'Katsina', '', '', '', ''),
(2000247, 24, 0, 0, 'BUMBUM \'B\'', 'Katsina', '', '', '', ''),
(2000248, 24, 0, 0, 'DANYASHE', 'Katsina', '', '', '', ''),
(2000249, 24, 0, 0, 'KOZA', 'Katsina', '', '', '', ''),
(2000250, 24, 0, 0, 'MAI KONI \'A\'', 'Katsina', '', '', '', ''),
(2000251, 24, 0, 0, 'MAI KONI \'B\'', 'Katsina', '', '', '', ''),
(2000252, 24, 0, 0, 'MAI\'ADUA \'A\'', 'Katsina', '', '', '', ''),
(2000253, 24, 0, 0, 'MAI\'ADUA \'C', 'Katsina', '', '', '', ''),
(2000254, 24, 0, 0, 'MAI\'ADUA\'B\'', 'Katsina', '', '', '', ''),
(2000255, 24, 0, 0, 'NATSALLE', 'Katsina', '', '', '', ''),
(2000256, 25, 0, 0, 'BORIN DAWA', 'Katsina', '', '', '', ''),
(2000257, 25, 0, 0, 'DANSARAI', 'Katsina', '', '', '', ''),
(2000258, 25, 0, 0, 'DAYI', 'Katsina', '', '', '', ''),
(2000259, 25, 0, 0, 'GORAR DANSAKA', 'Katsina', '', '', '', ''),
(2000260, 25, 0, 0, 'KARFI', 'Katsina', '', '', '', ''),
(2000261, 25, 0, 0, 'MAKAURACHI', 'Katsina', '', '', '', ''),
(2000262, 25, 0, 0, 'MALUM FASHI \'A\'', 'Katsina', '', '', '', ''),
(2000263, 25, 0, 0, 'MALUM FASHI \'B\'', 'Katsina', '', '', '', ''),
(2000264, 25, 0, 0, 'NA-ALMA', 'Katsina', '', '', '', ''),
(2000265, 25, 0, 0, 'RAWAN SANYI', 'Katsina', '', '', '', ''),
(2000266, 25, 0, 0, 'YABA', 'Katsina', '', '', '', ''),
(2000267, 25, 0, 0, 'YARMAMA', 'Katsina', '', '', '', ''),
(2000268, 26, 0, 0, 'BAGIWA', 'Katsina', '', '', '', ''),
(2000269, 26, 0, 0, 'BUJAWA/GEWAYAU', 'Katsina', '', '', '', ''),
(2000270, 26, 0, 0, 'DUWAN/MAKAU', 'Katsina', '', '', '', ''),
(2000271, 26, 0, 0, 'HAMCHETA', 'Katsina', '', '', '', ''),
(2000272, 26, 0, 0, 'JANI', 'Katsina', '', '', '', ''),
(2000273, 26, 0, 0, 'KWATTA', 'Katsina', '', '', '', ''),
(2000274, 26, 0, 0, 'MACHIKA', 'Katsina', '', '', '', ''),
(2000275, 26, 0, 0, 'MAGAMI', 'Katsina', '', '', '', ''),
(2000276, 26, 0, 0, 'MANI', 'Katsina', '', '', '', ''),
(2000277, 26, 0, 0, 'MUDURU', 'Katsina', '', '', '', ''),
(2000278, 26, 0, 0, 'TSAGEM/TAKUSHEYI', 'Katsina', '', '', '', ''),
(2000279, 27, 0, 0, 'BAMBLE', 'Katsina', '', '', '', ''),
(2000280, 27, 0, 0, 'DOGURU \'A\'', 'Katsina', '', '', '', ''),
(2000281, 27, 0, 0, 'DOGURU \'B\'', 'Katsina', '', '', '', ''),
(2000282, 27, 0, 0, 'GALLU', 'Katsina', '', '', '', ''),
(2000283, 27, 0, 0, 'JIGAWA', 'Katsina', '', '', '', ''),
(2000284, 27, 0, 0, 'KARAU', 'Katsina', '', '', '', ''),
(2000285, 27, 0, 0, 'MASHI', 'Katsina', '', '', '', ''),
(2000286, 27, 0, 0, 'S/RIJIYA', 'Katsina', '', '', '', ''),
(2000287, 27, 0, 0, 'SONKAYA', 'Katsina', '', '', '', ''),
(2000288, 27, 0, 0, 'TAMILO \'A\'', 'Katsina', '', '', '', ''),
(2000289, 27, 0, 0, 'TAMILO \'B\'', 'Katsina', '', '', '', ''),
(2000290, 28, 0, 0, 'DISSI', 'Katsina', '', '', '', ''),
(2000291, 28, 0, 0, 'GWARJO', 'Katsina', '', '', '', ''),
(2000292, 28, 0, 0, 'KARADUWA', 'Katsina', '', '', '', ''),
(2000293, 28, 0, 0, 'KOGARI', 'Katsina', '', '', '', ''),
(2000294, 28, 0, 0, 'MATAZU \'A', 'Katsina', '', '', '', ''),
(2000295, 28, 0, 0, 'MATAZU \'B\'', 'Katsina', '', '', '', ''),
(2000296, 28, 0, 0, 'MAZOJI \'A\'', 'Katsina', '', '', '', ''),
(2000297, 28, 0, 0, 'MAZOJI \'B\'', 'Katsina', '', '', '', ''),
(2000298, 28, 0, 0, 'RINJIN IDI', 'Katsina', '', '', '', ''),
(2000299, 28, 0, 0, 'SAYAYA', 'Katsina', '', '', '', ''),
(2000300, 29, 0, 0, 'DANGANI', 'Katsina', '', '', '', ''),
(2000301, 29, 0, 0, '8NKU/KARACHI', 'Katsina', '', '', '', ''),
(2000302, 29, 0, 0, 'GARU', 'Katsina', '', '', '', ''),
(2000303, 29, 0, 0, 'GINGIN', 'Katsina', '', '', '', ''),
(2000304, 29, 0, 0, 'JIKAMSHI', 'Katsina', '', '', '', ''),
(2000305, 29, 0, 0, 'KIRA', 'Katsina', '', '', '', ''),
(2000306, 29, 0, 0, 'KURKUJAN \'A\'', 'Katsina', '', '', '', ''),
(2000307, 29, 0, 0, 'KURKUJAN \'B\'', 'Katsina', '', '', '', ''),
(2000308, 29, 0, 0, 'MUSAWA', 'Katsina', '', '', '', ''),
(2000309, 29, 0, 0, 'TUGE', 'Katsina', '', '', '', ''),
(2000310, 29, 0, 0, 'YARADAU/TABANNI', 'Katsina', '', '', '', ''),
(2000311, 30, 0, 0, 'ABUKUR', 'Katsina', '', '', '', ''),
(2000312, 30, 0, 0, 'FARDAMI', 'Katsina', '', '', '', ''),
(2000313, 30, 0, 0, 'KADANDANI', 'Katsina', '', '', '', ''),
(2000314, 30, 0, 0, 'MAJENGOBIR', 'Katsina', '', '', '', ''),
(2000315, 30, 0, 0, 'MAKURDA', 'Katsina', '', '', '', ''),
(2000316, 30, 0, 0, 'MASABO/KURABAU', 'Katsina', '', '', '', ''),
(2000317, 30, 0, 0, 'REMAWA/IYATAWA', 'Katsina', '', '', '', ''),
(2000318, 30, 0, 0, 'RIMI', 'Katsina', '', '', '', ''),
(2000319, 30, 0, 0, 'SABON GARIN/ALARAIN', 'Katsina', '', '', '', ''),
(2000320, 30, 0, 0, 'TSAGERO', 'Katsina', '', '', '', ''),
(2000321, 31, 0, 0, 'DAMARI', 'Katsina', '', '', '', ''),
(2000322, 31, 0, 0, 'DUGUN MU\'AZU', 'Katsina', '', '', '', ''),
(2000323, 31, 0, 0, 'GAMJI', 'Katsina', '', '', '', ''),
(2000324, 31, 0, 0, 'GAZARI', 'Katsina', '', '', '', ''),
(2000325, 31, 0, 0, 'MACHIKA', 'Katsina', '', '', '', ''),
(2000326, 31, 0, 0, 'MAIBAKKO', 'Katsina', '', '', '', ''),
(2000327, 31, 0, 0, 'RAFIN IWA', 'Katsina', '', '', '', ''),
(2000328, 31, 0, 0, 'SABUWA \'A\'', 'Katsina', '', '', '', ''),
(2000329, 31, 0, 0, 'SABUWA\'B\'', 'Katsina', '', '', '', ''),
(2000330, 31, 0, 0, 'SAYAU', 'Katsina', '', '', '', ''),
(2000331, 32, 0, 0, 'BABBAN DUHU \'A\'', 'Katsina', '', '', '', ''),
(2000332, 32, 0, 0, 'BABBAN DUHU \'B\'', 'Katsina', '', '', '', ''),
(2000333, 32, 0, 0, 'BAURE \'A\'', 'Katsina', '', '', '', ''),
(2000334, 32, 0, 0, 'BAURE \'B\'', 'Katsina', '', '', '', ''),
(2000335, 32, 0, 0, 'RUNKA \'A\'', 'Katsina', '', '', '', ''),
(2000336, 32, 0, 0, 'RUNKA \'B\'', 'Katsina', '', '', '', ''),
(2000337, 32, 0, 0, 'SAFANA', 'Katsina', '', '', '', ''),
(2000338, 32, 0, 0, 'TSASKIYA', 'Katsina', '', '', '', ''),
(2000339, 32, 0, 0, 'ZAKKA \'A\'', 'Katsina', '', '', '', ''),
(2000340, 32, 0, 0, 'ZAKKA \'B\'', 'Katsina', '', '', '', ''),
(2000341, 33, 0, 0, 'DANEJI \'A\'', 'Katsina', '', '', '', ''),
(2000342, 33, 0, 0, 'DANEJI \'B\'', 'Katsina', '', '', '', ''),
(2000343, 33, 0, 0, 'FAGO \'A\'', 'Katsina', '', '', '', ''),
(2000344, 33, 0, 0, 'FAGO \'B\'', 'Katsina', '', '', '', ''),
(2000345, 33, 0, 0, 'KAGARE', 'Katsina', '', '', '', ''),
(2000346, 33, 0, 0, 'KARKARKU', 'Katsina', '', '', '', ''),
(2000347, 33, 0, 0, 'KATSAYAL', 'Katsina', '', '', '', ''),
(2000348, 33, 0, 0, 'KWASARAWA', 'Katsina', '', '', '', ''),
(2000349, 33, 0, 0, 'RADE \'A\'', 'Katsina', '', '', '', ''),
(2000350, 33, 0, 0, 'RADE \'B\'', 'Katsina', '', '', '', ''),
(2000351, 33, 0, 0, 'SANDAMU', 'Katsina', '', '', '', ''),
(2000352, 34, 0, 0, 'DARGAGE', 'Katsina', '', '', '', ''),
(2000353, 34, 0, 0, 'GARNI', 'Katsina', '', '', '', ''),
(2000354, 34, 0, 0, 'GWAMBA', 'Katsina', '', '', '', ''),
(2000355, 34, 0, 0, 'KAN DA', 'Katsina', '', '', '', ''),
(2000356, 34, 0, 0, 'KAWARIN KUDI', 'Katsina', '', '', '', ''),
(2000357, 34, 0, 0, 'KAWARIN MALAWAMAI', 'Katsina', '', '', '', ''),
(2000358, 34, 0, 0, 'ROGOGO/CIDARI', 'Katsina', '', '', '', ''),
(2000359, 34, 0, 0, 'SARA', 'Katsina', '', '', '', ''),
(2000360, 34, 0, 0, 'YARDAJE', 'Katsina', '', '', '', ''),
(2000361, 34, 0, 0, 'ZANGO', 'Katsina', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT 'senatorial' COMMENT 'senatorial, constituency, etc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `user_id`, `name`, `state`, `type`, `created_at`, `updated_at`) VALUES
(3000015, 19, 'West Zone', 'Katsina State', 'senatorial', '2023-02-20 03:07:06', '2023-02-20 03:07:06'),
(3000016, 19, 'East Zone', 'Katsina State', 'senatorial', '2023-02-20 03:07:23', '2023-02-20 03:07:23'),
(3000017, 19, 'West Constituency', 'Katsina State', 'constituency', '2023-02-20 03:08:49', '2023-02-20 03:08:49'),
(3000018, 19, 'East Constituency', 'Katsina State', 'constituency', '2023-02-20 03:09:05', '2023-02-20 03:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `zone_contents`
--

CREATE TABLE `zone_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ward` varchar(191) DEFAULT NULL,
  `polling_unit` varchar(191) DEFAULT NULL,
  `polling_unit_id` bigint(20) DEFAULT NULL,
  `lga` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT 'senatorial' COMMENT 'senatorial, constituency',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zone_contents`
--

INSERT INTO `zone_contents` (`id`, `ward`, `polling_unit`, `polling_unit_id`, `lga`, `state`, `user_id`, `zone_id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(51, 'Ward One', 'Polling Unit One', 1000000, 'Bakori', NULL, NULL, 3000015, NULL, 'senatorial', '2023-02-20 03:07:06', '2023-02-20 03:07:06'),
(52, 'Ward One', 'Polling Unit Two', 1000001, 'Bakori', NULL, NULL, 3000015, NULL, 'senatorial', '2023-02-20 03:07:06', '2023-02-20 03:07:06'),
(53, 'Ward Two', 'Polling Unit Three', 1000002, 'Bakori', NULL, NULL, 3000015, NULL, 'senatorial', '2023-02-20 03:07:06', '2023-02-20 03:07:06'),
(54, 'Ward Two', 'Polling Unit Four', 1000003, 'Bakori', NULL, NULL, 3000015, NULL, 'senatorial', '2023-02-20 03:07:06', '2023-02-20 03:07:06'),
(55, 'Ward Three', 'Polling Unit Five', 1000004, 'Batagarawa', NULL, NULL, 3000016, NULL, 'senatorial', '2023-02-20 03:07:23', '2023-02-20 03:07:23'),
(56, 'Ward Three', 'Polling Unit Six', 1000005, 'Batagarawa', NULL, NULL, 3000016, NULL, 'senatorial', '2023-02-20 03:07:23', '2023-02-20 03:07:23'),
(57, 'Ward One', 'Polling Unit One', 1000000, 'Bakori', NULL, NULL, 3000017, NULL, 'senatorial', '2023-02-20 03:08:49', '2023-02-20 03:08:49'),
(58, 'Ward One', 'Polling Unit Two', 1000001, 'Bakori', NULL, NULL, 3000017, NULL, 'senatorial', '2023-02-20 03:08:49', '2023-02-20 03:08:49'),
(59, 'Ward Two', 'Polling Unit Three', 1000002, 'Bakori', NULL, NULL, 3000017, NULL, 'senatorial', '2023-02-20 03:08:49', '2023-02-20 03:08:49'),
(60, 'Ward Two', 'Polling Unit Four', 1000003, 'Bakori', NULL, NULL, 3000017, NULL, 'senatorial', '2023-02-20 03:08:49', '2023-02-20 03:08:49'),
(61, 'Ward Three', 'Polling Unit Five', 1000004, 'Batagarawa', NULL, NULL, 3000018, NULL, 'senatorial', '2023-02-20 03:09:05', '2023-02-20 03:09:05'),
(62, 'Ward Three', 'Polling Unit Six', 1000005, 'Batagarawa', NULL, NULL, 3000018, NULL, 'senatorial', '2023-02-20 03:09:05', '2023-02-20 03:09:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `political_party_id` (`political_party_id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `name` (`name`),
  ADD KEY `type` (`type`),
  ADD KEY `status` (`status`),
  ADD KEY `deputy_name` (`deputy_name`),
  ADD KEY `election` (`election`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_number` (`code_number`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `election_type_id` (`election_type_id`),
  ADD KEY `year` (`year`),
  ADD KEY `total_registered_voters` (`total_registered_voters`),
  ADD KEY `status` (`status`),
  ADD KEY `has_zones` (`has_zones`),
  ADD KEY `full_details` (`full_details`(768));

--
-- Indexes for table `election_types`
--
ALTER TABLE `election_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lgas`
--
ALTER TABLE `lgas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `state` (`state`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `content` (`content`(768)),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_number` (`code_number`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `political_parties`
--
ALTER TABLE `political_parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polling_units`
--
ALTER TABLE `polling_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `ward_id` (`ward_id`),
  ADD KEY `name` (`name`),
  ADD KEY `lga_id` (`lga_id`),
  ADD KEY `state` (`state`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `latitude` (`latitude`),
  ADD KEY `longitude` (`longitude`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_number` (`code_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `polling_unit_id` (`polling_unit_id`),
  ADD KEY `content` (`content`(768)),
  ADD KEY `type` (`type`),
  ADD KEY `title` (`title`(768)),
  ADD KEY `docs` (`docs`(768)),
  ADD KEY `election_id` (`election_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `temp_stats`
--
ALTER TABLE `temp_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `polling_unit_id` (`polling_unit_id`),
  ADD KEY `political_party_id` (`political_party_id`),
  ADD KEY `polling_unit` (`polling_unit`),
  ADD KEY `latitude` (`latitude`),
  ADD KEY `longitude` (`longitude`),
  ADD KEY `party_name` (`party_name`),
  ADD KEY `total_votes` (`total_votes`),
  ADD KEY `invalid_votes` (`invalid_votes`),
  ADD KEY `valid_votes` (`valid_votes`),
  ADD KEY `party_total_votes` (`party_total_votes`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_number` (`code_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `state` (`state`),
  ADD KEY `political_party_id` (`political_party_id`),
  ADD KEY `total` (`total`),
  ADD KEY `invalid_votes` (`invalid_votes`),
  ADD KEY `polling_unit_id` (`polling_unit_id`),
  ADD KEY `ward_id` (`ward_id`),
  ADD KEY `lga_id` (`lga_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `election` (`election`),
  ADD KEY `zone` (`zone`),
  ADD KEY `polling_unit` (`polling_unit`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `state` (`state`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `zone_contents`
--
ALTER TABLE `zone_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state` (`state`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `ward` (`ward`) USING BTREE,
  ADD KEY `polling_unit` (`polling_unit`) USING BTREE,
  ADD KEY `lga` (`lga`) USING BTREE,
  ADD KEY `polling_unit_id` (`polling_unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6709860;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65091;

--
-- AUTO_INCREMENT for table `election_types`
--
ALTER TABLE `election_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lgas`
--
ALTER TABLE `lgas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=777;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1092;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `political_parties`
--
ALTER TABLE `political_parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `polling_units`
--
ALTER TABLE `polling_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000006;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=764;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `temp_stats`
--
ALTER TABLE `temp_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39349;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3000019;

--
-- AUTO_INCREMENT for table `zone_contents`
--
ALTER TABLE `zone_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
