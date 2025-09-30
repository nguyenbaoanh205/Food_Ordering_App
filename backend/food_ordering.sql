-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2025 at 07:25 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_ordering`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `restaurant_id`, `item_name`, `description`, `price`, `is_available`, `created_at`, `updated_at`, `category_id`, `image_url`) VALUES
(1, 3, 'dolores', 'Facilis dolorem nam et molestias repellendus.', '11.58', 1, '2025-09-30 11:31:43', '2025-09-30 11:31:43', NULL, NULL),
(2, 1, 'cumque', 'At est qui at asperiores nisi ut.', '10.06', 1, '2025-09-30 11:31:43', '2025-09-30 11:31:43', NULL, NULL),
(3, 4, 'nesciunt', 'Exercitationem itaque necessitatibus voluptatem dolore et.', '89.87', 0, '2025-09-30 11:31:43', '2025-09-30 11:31:43', NULL, NULL),
(4, 4, 'fugit', 'Ex sint inventore ducimus quae asperiores ea.', '13.15', 0, '2025-09-30 11:31:43', '2025-09-30 11:31:43', NULL, NULL),
(5, 9, 'cupiditate', 'Animi sit quia omnis ratione doloribus architecto.', '60.38', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(6, 10, 'et', 'Quia laborum error sunt perferendis itaque qui.', '74.45', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(7, 7, 'quasi', 'Vel aperiam sed quo laudantium non exercitationem sit.', '9.76', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(8, 1, 'rerum', 'Possimus tenetur maiores non debitis nisi.', '16.58', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(9, 1, 'nihil', 'Eveniet porro possimus explicabo.', '93.26', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(10, 2, 'sed', 'Rerum dolorem cupiditate non atque incidunt possimus et.', '49.08', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(11, 8, 'eos', 'Consequatur cupiditate qui odit praesentium dolores eaque praesentium.', '70.96', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(12, 10, 'vitae', 'Et sint sed deserunt ut.', '42.43', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(13, 1, 'est', 'Beatae voluptatem explicabo exercitationem mollitia ea officia earum deserunt.', '8.25', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(14, 6, 'odit', 'Enim temporibus aut repellendus.', '84.71', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(15, 9, 'repudiandae', 'Saepe error et a enim et.', '41.73', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(16, 7, 'consequatur', 'Possimus impedit quo voluptatibus cupiditate quam praesentium eos odit.', '51.62', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(17, 9, 'nihil', 'Autem neque expedita voluptatem.', '76.46', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(18, 10, 'et', 'Hic fuga eveniet rerum architecto pariatur quos.', '57.45', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(19, 6, 'non', 'Quia aspernatur nobis dolores.', '60.58', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(20, 6, 'magnam', 'Quam magni sunt tenetur reprehenderit voluptate hic.', '43.06', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(21, 8, 'vel', 'Velit id est et.', '26.94', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(22, 7, 'sed', 'Officia autem dignissimos sit facilis aliquam rerum non.', '82.04', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(23, 8, 'earum', 'Qui ea cum doloremque sed iure id.', '32.05', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(24, 8, 'doloribus', 'Ratione sunt aliquid quia cum maxime.', '49.25', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(25, 2, 'natus', 'Architecto voluptas provident ratione mollitia non officiis.', '31.92', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(26, 4, 'iure', 'Illum nihil qui consequatur omnis fugit.', '82.18', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(27, 6, 'blanditiis', 'Enim unde ratione unde deserunt delectus sit.', '96.25', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(28, 9, 'saepe', 'Qui iste vel modi nesciunt quisquam consequatur.', '13.69', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(29, 7, 'dolorum', 'Quasi qui dolorum nisi labore ab soluta.', '44.48', 0, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL),
(30, 10, 'aspernatur', 'Numquam aut aut quis molestiae consequuntur dolores.', '71.69', 1, '2025-09-30 11:31:44', '2025-09-30 11:31:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_27_071624_create_personal_access_tokens_table', 1),
(5, '2025_09_27_073747_create_restaurants_table', 1),
(6, '2025_09_27_073751_create_menu_table', 1),
(7, '2025_09_27_073755_create_orders_table', 1),
(8, '2025_09_27_073807_create_order_details_table', 1),
(9, '2025_09_27_073812_create_reviews_table', 1),
(10, '2025_09_27_073820_create_order_history_table', 1),
(11, '2025_09_27_073827_create_payment_methods_table', 1),
(12, '2025_09_30_190712_create_categories_table', 2),
(13, '2025_09_30_191228_update_menu_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `restaurant_id`, `order_date`, `total_amount`, `status`, `delivery_address`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-09-30 18:31:44', '104.53', 'Pending', '882 Hagenes Bypass\nWest Luciusview, RI 52317', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(2, 8, 10, '2025-09-30 18:31:44', '468.03', 'Pending', '996 Zemlak Extension Suite 782\nWest Ida, CO 49428', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(3, 8, 4, '2025-09-30 18:31:44', '23.75', 'Completed', '415 Ewell Crossing\nSouth Rolandochester, OK 45756-8272', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(4, 5, 8, '2025-09-30 18:31:44', '170.62', 'Pending', '7657 Ayana Forks Suite 788\nEast Alvertaland, CA 97890-5321', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(5, 7, 1, '2025-09-30 18:31:44', '54.19', 'Cancelled', '53791 Carroll Rapids\nIsabellemouth, VT 64197-5331', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(6, 4, 5, '2025-09-30 18:31:44', '382.06', 'Pending', '395 Wunsch Lane Suite 223\nEast Candidomouth, OH 52779', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(7, 1, 4, '2025-09-30 18:31:44', '98.50', 'Pending', '39412 Kerluke Parkway Suite 511\nPort Damaris, VA 09331-8560', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(8, 5, 7, '2025-09-30 18:31:44', '74.50', 'Cancelled', '10740 Ahmad Branch Apt. 567\nNorth Elliotburgh, UT 96297-0022', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(9, 5, 3, '2025-09-30 18:31:44', '409.71', 'Cancelled', '5157 Trevion Tunnel Suite 624\nEast Guadalupe, NV 06360-3041', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(10, 8, 1, '2025-09-30 18:31:44', '96.80', 'Cancelled', '67109 Rocio Village Apt. 881\nMeaganborough, MO 94821-3305', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(11, 5, 8, '2025-09-30 18:31:44', '97.42', 'Completed', '510 Oma Cove Apt. 913\nLake Sabryna, FL 63709', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(12, 2, 8, '2025-09-30 18:31:44', '37.02', 'Pending', '79764 Cali Common Suite 801\nNorth Daniellachester, OH 26132', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(13, 1, 10, '2025-09-30 18:31:44', '135.55', 'Completed', '4081 Heber Throughway Suite 003\nNorth Dylan, AK 62550-5888', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(14, 2, 2, '2025-09-30 18:31:44', '229.46', 'Completed', '6011 Vito Harbors\nVeronicaville, KS 60439', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(15, 8, 5, '2025-09-30 18:31:44', '224.70', 'Pending', '35164 Wehner Streets Suite 868\nGutkowskifort, KY 82872', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(16, 4, 7, '2025-09-30 18:31:44', '128.69', 'Pending', '9815 Gleichner Circles Apt. 450\nCarolyneton, WA 40644-7404', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(17, 6, 2, '2025-09-30 18:31:44', '17.73', 'Completed', '1377 Tremblay Hollow\nEast Bertrand, ME 80545-8016', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(18, 10, 2, '2025-09-30 18:31:44', '266.08', 'Pending', '40147 Clotilde Ports Suite 015\nPort Manuelburgh, VA 97100', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(19, 5, 2, '2025-09-30 18:31:44', '421.97', 'Cancelled', '44651 Winona Drives\nO\'Konfort, UT 28101-7657', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(20, 7, 5, '2025-09-30 18:31:44', '77.24', 'Completed', '1679 Heller Villages Suite 518\nJennyferland, CO 55664', '2025-09-30 11:31:44', '2025-09-30 11:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `menu_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `menu_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 12, 8, 3, '80.08', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(2, 20, 12, 4, '85.73', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(3, 11, 6, 4, '51.58', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(4, 15, 9, 4, '55.49', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(5, 1, 3, 1, '61.65', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(6, 3, 14, 5, '17.83', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(7, 6, 12, 4, '60.03', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(8, 4, 23, 5, '9.63', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(9, 13, 11, 5, '12.73', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(10, 15, 1, 1, '90.34', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(11, 5, 14, 3, '59.78', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(12, 15, 24, 5, '55.08', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(13, 5, 20, 1, '91.75', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(14, 19, 1, 1, '72.22', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(15, 7, 16, 4, '64.25', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(16, 6, 26, 2, '39.26', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(17, 13, 14, 3, '25.36', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(18, 15, 8, 3, '31.24', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(19, 8, 7, 2, '67.51', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(20, 16, 12, 2, '17.13', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(21, 2, 15, 4, '38.69', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(22, 19, 25, 3, '95.08', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(23, 11, 22, 2, '56.45', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(24, 2, 17, 4, '33.00', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(25, 8, 26, 3, '86.74', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(26, 6, 7, 3, '16.35', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(27, 17, 24, 2, '99.23', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(28, 8, 13, 1, '29.32', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(29, 2, 11, 4, '15.69', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(30, 18, 6, 4, '35.00', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(31, 17, 25, 1, '79.90', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(32, 16, 13, 4, '11.83', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(33, 14, 26, 4, '40.52', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(34, 20, 29, 2, '80.54', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(35, 18, 16, 1, '43.48', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(36, 15, 6, 1, '28.40', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(37, 13, 30, 1, '41.87', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(38, 2, 12, 1, '37.17', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(39, 14, 6, 1, '94.26', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(40, 9, 18, 5, '72.51', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(41, 10, 20, 2, '26.73', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(42, 2, 15, 1, '27.87', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(43, 12, 29, 2, '95.53', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(44, 15, 2, 1, '55.68', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(45, 19, 9, 5, '15.63', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(46, 18, 1, 3, '12.74', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(47, 6, 3, 4, '54.84', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(48, 1, 24, 1, '10.49', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(49, 6, 7, 4, '6.28', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(50, 6, 2, 3, '16.75', '2025-09-30 11:31:44', '2025-09-30 11:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `order_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 20, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(2, 19, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(3, 6, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(4, 1, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(5, 2, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(6, 8, 'Completed', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(7, 9, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(8, 20, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(9, 8, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(10, 2, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(11, 6, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(12, 2, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(13, 13, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(14, 1, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(15, 15, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(16, 20, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(17, 2, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(18, 20, 'Cancelled', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(19, 4, 'Completed', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(20, 3, 'Pending', '2025-09-30 11:31:45', '2025-09-30 11:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `user_id`, `payment_type`, `provider`, `account_number`, `created_at`, `updated_at`) VALUES
(1, 3, 'PayPal', 'blanditiis', '931707867', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(2, 10, 'Bank Transfer', 'adipisci', '336012114764', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(3, 6, 'Credit Card', 'et', '87643075984', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(4, 1, 'PayPal', 'nesciunt', NULL, '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(5, 5, 'PayPal', 'rem', NULL, '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(6, 4, 'Bank Transfer', 'est', NULL, '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(7, 6, 'Bank Transfer', 'rerum', '54112', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(8, 9, 'Credit Card', 'impedit', '397139594777', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(9, 9, 'Credit Card', 'non', '124072419722', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(10, 2, 'Credit Card', 'dolor', NULL, '2025-09-30 11:31:45', '2025-09-30 11:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` double DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `opening_hours` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `phone`, `rating`, `description`, `opening_hours`, `created_at`, `updated_at`) VALUES
(1, 'Bradtke and Sons', '1257 Alexzander Brooks Apt. 946\nPort Zoeton, OK 79207-3015', '2492849157', 1.88, 'Quae distinctio placeat ut et distinctio itaque. Porro et qui aut harum ut sit. Ut et exercitationem aut. Expedita laudantium corporis quia quidem praesentium et non est.', '08:18:36 - 09:20:34', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(2, 'Murphy-Torphy', '351 Beatty Meadows\nWolffhaven, LA 91924', '0745659694', 2.09, 'Qui necessitatibus odit laborum et optio dolor quo. Molestias nulla et id architecto officia. A animi ut impedit quae ea qui autem. Ut ex blanditiis tempora impedit sed labore exercitationem sunt.', '22:21:43 - 08:43:24', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(3, 'Nienow-Ortiz', '50972 Blick Rue\nPort Madgebury, AZ 29862', '0859899446', 4.28, 'Ipsam quia animi voluptatem natus optio accusantium consequatur. Et tenetur deserunt et quae eum. Consequatur aspernatur ut eos doloribus officiis.', '20:40:50 - 23:10:31', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(4, 'Weissnat Group', '86450 Jess Canyon Apt. 290\nWest Bradleyville, VT 19768-4827', '3298513386', 2.29, 'Vel dolorem eos qui adipisci voluptatem est praesentium. Odio omnis enim eaque perferendis. Illo illo sint ratione autem et omnis. Est aspernatur labore deleniti dolores.', '22:32:50 - 11:07:12', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(5, 'O\'Hara and Sons', '724 Kaylie Shores\nEast Tess, CA 01804', '4394333186', 4.61, 'Magni rerum iusto laboriosam assumenda sed necessitatibus inventore. Eum necessitatibus temporibus culpa.', '05:30:59 - 09:55:40', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(6, 'Hilpert, Torp and Weimann', '702 Konopelski Stream Suite 889\nNorth Sister, KY 74371', '6457714801', 4.99, 'Iste autem molestias facilis et voluptas consequuntur quia. Adipisci aspernatur aut nulla quia illo quidem. Et voluptatem minima eaque assumenda. Similique aut distinctio placeat nihil doloremque eaque facilis.', '08:27:39 - 06:04:16', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(7, 'Stracke and Sons', '36012 Elwyn Shoals Apt. 969\nNew Sheridan, NC 08449-5170', '5439460136', 4.94, 'Adipisci dolor odit enim voluptatum hic. Unde sint et corrupti fuga. Ipsum doloribus nulla rerum id temporibus. Rem accusamus vitae corporis doloribus ipsam aliquid.', '03:23:39 - 15:35:07', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(8, 'Deckow, Mann and Volkman', '70038 Fadel Curve\nJakubowskichester, MT 76212-9832', '6686322748', 3.8, 'Aut maiores repudiandae reiciendis officiis in. Voluptatibus adipisci laboriosam eos dolorem autem. Ut animi non deleniti amet molestiae asperiores culpa.', '07:08:57 - 16:36:22', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(9, 'Frami Inc', '5746 Otilia Points Suite 946\nAnkundingbury, VT 17825-0982', '2781420256', 2.16, 'Consequuntur vitae mollitia doloribus laudantium ipsum. Non et amet sunt esse possimus sit. Molestiae esse assumenda eos impedit in eaque. Iure inventore dolorem accusamus eius.', '11:24:45 - 14:14:57', '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(10, 'Harris Group', '61454 Tromp Expressway Suite 332\nSouth Celine, NE 36303-0089', '9022095810', 4.83, 'Repudiandae vero consequatur rerum molestiae corporis explicabo. Et enim id perspiciatis quasi enim beatae. Est cupiditate cum magni repellat voluptas dolorem iusto.', '21:40:58 - 23:56:57', '2025-09-30 11:31:43', '2025-09-30 11:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `rating` double NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `restaurant_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 8, 2, 4.6, 'Voluptas perspiciatis voluptatem animi odit voluptas aut.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(2, 6, 3, 3.4, 'Quae corporis rerum natus modi nostrum adipisci.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(3, 8, 4, 4.7, 'Ut adipisci odit ut quidem.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(4, 10, 4, 2, 'Reiciendis quae eum sunt labore blanditiis natus ut.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(5, 6, 8, 4.1, 'Ad itaque blanditiis est occaecati.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(6, 8, 10, 1.7, 'Atque adipisci perspiciatis aut ut tenetur.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(7, 6, 8, 3.1, 'Tempora atque qui rerum voluptatem impedit.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(8, 10, 7, 3.9, 'Tenetur recusandae aut ut nihil dolore voluptatem.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(9, 9, 2, 1.4, 'Veritatis culpa enim quas placeat.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(10, 9, 7, 2.3, 'Ab qui nulla porro soluta accusamus.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(11, 7, 1, 3.8, 'Non porro quam quae recusandae.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(12, 7, 5, 3.7, 'Similique consequuntur corrupti id numquam ullam et et.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(13, 7, 2, 3.6, 'At dolorem commodi qui dignissimos quam et.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(14, 5, 6, 4.8, 'Itaque eveniet praesentium eos.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(15, 9, 1, 2.5, 'Harum et fugit est est.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(16, 4, 7, 1.4, 'Quasi aut numquam labore corporis enim optio maiores.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(17, 5, 8, 1.5, 'Vel quia aut sed.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(18, 6, 9, 4, 'Aut ratione consequatur est amet suscipit et.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(19, 10, 10, 3.7, 'Illo beatae aperiam est vitae.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(20, 6, 7, 5, 'Non impedit voluptatum dolor et accusamus.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(21, 7, 7, 3.9, 'Mollitia voluptate qui animi sunt sed praesentium.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(22, 6, 3, 2.3, 'Impedit placeat sunt et aut rem necessitatibus.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(23, 9, 2, 3, 'Dolor in quod iure.', '2025-09-30 11:31:44', '2025-09-30 11:31:44'),
(24, 8, 4, 2.5, 'Est et deserunt illum et numquam sit.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(25, 6, 5, 4.7, 'Facilis minima harum praesentium illo omnis ducimus voluptas.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(26, 5, 2, 3, 'Odio consequatur eos iusto tempora ratione enim commodi nam.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(27, 1, 9, 3.6, 'Eius rerum non quos voluptates repellendus.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(28, 9, 9, 3.8, 'Voluptatem officiis explicabo perspiciatis consequatur delectus libero dolores.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(29, 8, 9, 1.8, 'Ut inventore blanditiis ipsa quod corrupti.', '2025-09-30 11:31:45', '2025-09-30 11:31:45'),
(30, 1, 3, 4.2, 'Est voluptas tenetur omnis quia non et esse amet.', '2025-09-30 11:31:45', '2025-09-30 11:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Danika Abernathy', 'wayne09@example.net', '2025-09-30 11:31:40', '$2y$12$kL75U2GHrdqUIV6wa3qtJu434ghZw7We99Yqmt.Yaef7Uol0F12O6', NULL, '2025-09-30 11:31:40', '2025-09-30 11:31:40'),
(2, 'Catalina Von', 'schamberger.tate@example.net', '2025-09-30 11:31:40', '$2y$12$TpsIaVoDSuIWqFyIGu56nu5jCJZtwlO82m3Jk61OGu1XAffCYufB.', NULL, '2025-09-30 11:31:40', '2025-09-30 11:31:40'),
(3, 'Miss Alverta Paucek', 'lenora.barrows@example.org', '2025-09-30 11:31:40', '$2y$12$izMeCnhruN1b6q6BVCq1QOpUYVaP7L9.AhnOq9GKRaSbL5dMev3wC', NULL, '2025-09-30 11:31:40', '2025-09-30 11:31:40'),
(4, 'Aubrey Mayer Sr.', 'luettgen.melissa@example.org', '2025-09-30 11:31:41', '$2y$12$NlFgeDgRVsK9bQi4nPtmqOKHUuxjS.CKB9U4yGu/WDe41K9pKWb8q', NULL, '2025-09-30 11:31:41', '2025-09-30 11:31:41'),
(5, 'Mrs. Carolyne O\'Keefe', 'fermin54@example.com', '2025-09-30 11:31:41', '$2y$12$t/d.cpn4buoVRj/dSAJxOOmafmP/QfqaF2BKAJv.TpCVxdMnPJyv6', NULL, '2025-09-30 11:31:41', '2025-09-30 11:31:41'),
(6, 'Maurine Dickinson', 'olson.art@example.org', '2025-09-30 11:31:42', '$2y$12$96qYRqvopLzq1OCy0DcDMuma/LfHSp9mZiJ0Xb05K4uiMwSxEgaJK', NULL, '2025-09-30 11:31:42', '2025-09-30 11:31:42'),
(7, 'Carlos Little', 'weldon65@example.com', '2025-09-30 11:31:42', '$2y$12$xQqc/TZCnZVQt/fx9kwDOuyo0kfREvK1eTse47ou4VS5bzG3nyrlq', NULL, '2025-09-30 11:31:42', '2025-09-30 11:31:42'),
(8, 'Prof. Liza Hessel Jr.', 'aabernathy@example.com', '2025-09-30 11:31:43', '$2y$12$DYVU.brNW9V1Jky58aRkluWTSuewnV5AibKg3A6mWmLBgYeMWH8Qq', NULL, '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(9, 'Miracle Ratke', 'lourdes15@example.net', '2025-09-30 11:31:43', '$2y$12$vwmGICUFhvfFq8.HtnxzneowRyU4xhOW3Gqzr1iMS4P.2ynIwT72m', NULL, '2025-09-30 11:31:43', '2025-09-30 11:31:43'),
(10, 'Floyd Hamill', 'kling.abbie@example.com', '2025-09-30 11:31:43', '$2y$12$5UJdJbh1cHEkoghRWv61L.15jf8e1aDqxSFpX5X4eoPXCHWZghgea', NULL, '2025-09-30 11:31:43', '2025-09-30 11:31:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_restaurant_id_foreign` (`restaurant_id`),
  ADD KEY `menu_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_restaurant_id_foreign` (`restaurant_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_history_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_restaurant_id_foreign` (`restaurant_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menu_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_restaurant_id_foreign` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
