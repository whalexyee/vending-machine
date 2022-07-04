-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2022 at 11:11 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.29-to-be-removed-in-future-macOS

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_06_21_081650_create_products_table', 1),
(6, '2022_06_22_001325_create_roles_table', 1),
(7, '2022_06_23_054238_add_soft_delete_to_users_table', 1),
(8, '2022_06_23_203856_create_user_product_purchases_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 3, 'authtoken', '3711c253fadfeec2817d3d563e91b9ba4823d8bb104b2713a8c1b2dc67c6f34f', '[\"*\"]', '2022-06-27 04:48:55', '2022-06-23 13:25:00', '2022-06-27 04:48:55'),
(4, 'App\\Models\\User', 4, 'authtoken', 'e44a4876c722c7c2a2fd0e03072a4e4abb2d22fc3a596d7b812faeba52d21134', '[\"*\"]', '2022-06-27 08:12:11', '2022-06-23 13:27:00', '2022-06-27 08:12:11'),
(5, 'App\\Models\\User', 5, 'authtoken', 'b7ee4534ec15384a757007c8c8d87563ba22f6f1a83c1b31a5eff5c365af9656', '[\"*\"]', '2022-06-27 08:06:54', '2022-06-24 21:31:15', '2022-06-27 08:06:54'),
(6, 'App\\Models\\User', 6, 'authtoken', '4886d6439955180a4e854ebc2a7e2e5ffb296bd14caedb58f239ffd15f0c53e2', '[\"*\"]', NULL, '2022-06-27 04:45:14', '2022-06-27 04:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `amount_available` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `cost`, `amount_available`, `seller_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Coca Cola', 'coca-cola', 105, 3, 4, '', '2022-06-24 21:29:57', '2022-06-27 08:03:08'),
(2, 'Fanta', 'fanta', 80, 5, 5, '', '2022-06-24 21:32:40', '2022-06-24 21:32:40'),
(4, 'gucci', 'gucci', 20, 3, 4, '', '2022-06-26 05:06:03', '2022-06-26 05:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Buyer', NULL, NULL),
(2, 'Seller', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `deposit`, `role_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'olawale', NULL, 350, 1, NULL, '$2y$10$1G/mnHn1AzI8RfQg1EtlUely7XaRZ/7nFH188/ZiERdtKVR6slG6C', NULL, '2022-06-23 13:25:00', '2022-06-27 04:48:55', NULL),
(4, 'gbemisola', 'gbem@yopmail.com', 0, 2, NULL, '$2y$10$kSmu6uzcv4BEll5qe.Jnu.9yRhzdSLBkiOBLwVR01S0kIFiJ0k28O', NULL, '2022-06-23 13:27:00', '2022-06-27 04:43:08', NULL),
(5, 'frank', NULL, 0, 2, NULL, '$2y$10$5A4sIgO5pxqeWRDLpWaSOehQ3rWTteA46eq8KH2SPvmOkC8gArCiS', NULL, '2022-06-24 21:31:15', '2022-06-24 21:31:15', NULL),
(6, 'tobedeleted', NULL, 0, 2, NULL, '$2y$10$H1YELbCe/ND47922AeOUY.jE1BeWb2hgW.jYi5lgns0ClUZZKTKK.', NULL, '2022-06-27 04:45:14', '2022-06-27 04:46:16', '2022-06-27 04:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_product_purchases`
--

CREATE TABLE `user_product_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_product_purchases`
--

INSERT INTO `user_product_purchases` (`id`, `user_id`, `product_id`, `price`, `amount`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 180.00, 2, '2022-06-25 18:21:02', '2022-06-25 18:21:02'),
(2, 3, 1, 180.00, 2, '2022-06-25 18:23:10', '2022-06-25 18:23:10'),
(3, 3, 1, 180.00, 2, '2022-06-25 18:24:05', '2022-06-25 18:24:05'),
(4, 3, 1, 180.00, 2, '2022-06-25 18:25:25', '2022-06-25 18:25:25'),
(5, 3, 1, 180.00, 2, '2022-06-25 18:28:16', '2022-06-25 18:28:16'),
(6, 3, 1, 180.00, 2, '2022-06-25 18:32:18', '2022-06-25 18:32:18'),
(7, 3, 1, 180.00, 2, '2022-06-25 18:32:30', '2022-06-25 18:32:30'),
(8, 3, 1, 450.00, 5, '2022-06-25 18:44:23', '2022-06-25 18:44:23'),
(9, 3, 1, 180.00, 2, '2022-06-26 04:37:51', '2022-06-26 04:37:51'),
(10, 3, 1, 90.00, 1, '2022-06-26 04:45:24', '2022-06-26 04:45:24'),
(11, 3, 1, 90.00, 1, '2022-06-26 04:46:17', '2022-06-26 04:46:17'),
(12, 3, 1, 90.00, 1, '2022-06-26 04:49:22', '2022-06-26 04:49:22'),
(13, 3, 1, 90.00, 1, '2022-06-27 04:48:55', '2022-06-27 04:48:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_product_purchases`
--
ALTER TABLE `user_product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_product_purchases`
--
ALTER TABLE `user_product_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
