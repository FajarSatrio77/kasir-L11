-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 04:20 PM
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
-- Database: `db_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id`, `transaksi_id`, `produk_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 6, 3, 1, '2025-05-17 00:30:31', '2025-05-17 00:30:31'),
(2, 7, 3, 1, '2025-05-17 00:36:06', '2025-05-17 00:36:06'),
(3, 9, 3, 1, '2025-05-17 00:37:44', '2025-05-17 00:37:44'),
(4, 10, 3, 1, '2025-05-17 00:38:30', '2025-05-17 00:38:30'),
(5, 10, 7, 1, '2025-05-17 00:47:13', '2025-05-17 00:47:13'),
(6, 10, 6, 1, '2025-05-17 00:47:24', '2025-05-17 00:47:24'),
(7, 11, 7, 1, '2025-05-17 00:48:07', '2025-05-17 00:48:07'),
(8, 11, 8, 1, '2025-05-17 00:48:16', '2025-05-17 00:48:16'),
(9, 11, 5, 1, '2025-05-17 00:48:26', '2025-05-17 00:48:26'),
(10, 12, 5, 1, '2025-05-17 00:53:52', '2025-05-17 00:53:52'),
(11, 12, 7, 1, '2025-05-17 00:54:02', '2025-05-17 00:54:02'),
(12, 12, 8, 1, '2025-05-17 00:54:09', '2025-05-17 00:54:09'),
(13, 12, 6, 1, '2025-05-17 00:56:50', '2025-05-17 00:56:50'),
(14, 13, 6, 1, '2025-05-17 00:57:18', '2025-05-17 00:57:18'),
(15, 13, 7, 1, '2025-05-17 00:57:25', '2025-05-17 00:57:25'),
(16, 13, 8, 1, '2025-05-17 00:57:33', '2025-05-17 00:57:33'),
(17, 13, 5, 1, '2025-05-17 00:57:38', '2025-05-17 00:57:38'),
(21, 16, 8, 1, '2025-05-17 01:08:02', '2025-05-17 01:08:02'),
(22, 16, 7, 1, '2025-05-17 01:08:08', '2025-05-17 01:08:08'),
(23, 16, 5, 1, '2025-05-17 01:08:11', '2025-05-17 01:08:11'),
(24, 17, 5, 1, '2025-05-17 01:11:15', '2025-05-17 01:11:15'),
(25, 17, 7, 1, '2025-05-17 01:15:02', '2025-05-17 01:15:02'),
(27, 18, 8, 1, '2025-05-17 01:20:55', '2025-05-17 01:20:55'),
(29, 18, 7, 1, '2025-05-17 01:21:18', '2025-05-17 01:21:18'),
(30, 19, 5, 1, '2025-05-17 01:22:29', '2025-05-17 01:22:29'),
(31, 19, 7, 1, '2025-05-17 01:22:33', '2025-05-17 01:22:33'),
(33, 24, 7, 1, '2025-05-17 04:14:35', '2025-05-17 04:14:35'),
(37, 26, 5, 1, '2025-05-17 04:40:28', '2025-05-17 04:40:28'),
(39, 28, 3, 1, '2025-05-17 06:55:40', '2025-05-17 06:55:40'),
(40, 28, 7, 1, '2025-05-17 06:56:01', '2025-05-17 06:56:01'),
(41, 29, 3, 1, '2025-05-17 06:57:17', '2025-05-17 06:57:17'),
(42, 29, 7, 1, '2025-05-17 06:57:32', '2025-05-17 06:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '0001_01_01_000000_create_users_table', 1),
(14, '0001_01_01_000001_create_cache_table', 1),
(15, '0001_01_01_000002_create_jobs_table', 1),
(16, '2025_05_14_135929_create_produks_table', 1),
(17, '2025_05_14_154331_create_produks_table', 1),
(18, '2025_05_14_154457_add_columns_to_produks_table', 1),
(19, '2025_05_17_052027_create_transaksis_table', 2),
(20, '2025_05_17_052053_create_detail_transaksis_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `stok` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `kode`, `name`, `harga`, `stok`, `created_at`, `updated_at`) VALUES
(3, '123321', 'kemonceng', 10000, 8, '2025-05-14 09:47:02', '2025-05-17 06:57:17'),
(5, '3454354', 'kursi', 20000, 49, '2025-05-17 00:45:45', '2025-05-17 04:40:28'),
(6, '25346346', 'laptop', 10000000, 5, '2025-05-17 00:46:04', '2025-05-17 00:47:48'),
(7, '3635723', 'gelas', 10000, 51, '2025-05-17 00:46:27', '2025-05-17 06:57:32'),
(8, '2534784', 'piring', 15000, 60, '2025-05-17 00:46:44', '2025-05-17 04:20:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BZe4va6Tm7DMOrNB47u4oGIfEFtvkL0GwtDR00WF', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib0wwQjRBcG9kWVFNSExiNkNjWFhoN0puT1VFd04xbGxtSGZMeGhlYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NDc0ODc2MjA7fX0=', 1747490303),
('URqWIJFeYJGI0dbIekdlHfnjXljfSOaMr0rvEL28', 4, '192.168.0.101', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZG5KaFRzb2RXOUVZMlNLNEpLTGM4UVN0bGg2OFJWRjJla1M2T2VwUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xOTIuMTY4LjAuMTEwOjgwMDAvbGFwb3JhbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQ3NDkwMDgxO319', 1747490282);

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksis`
--

INSERT INTO `transaksis` (`id`, `kode`, `total`, `status`, `created_at`, `updated_at`) VALUES
(3, 'INV/20250517062342', 0, 'pending', '2025-05-16 23:23:42', '2025-05-16 23:23:42'),
(4, 'INV/20250517072725', 0, 'pending', '2025-05-17 00:27:25', '2025-05-17 00:27:25'),
(5, 'INV/20250517072902', 0, 'pending', '2025-05-17 00:29:02', '2025-05-17 00:29:02'),
(6, 'INV/20250517073027', 0, 'pending', '2025-05-17 00:30:27', '2025-05-17 00:30:27'),
(7, 'INV/20250517073603', 0, 'pending', '2025-05-17 00:36:03', '2025-05-17 00:36:03'),
(8, 'INV/20250517073719', 0, 'pending', '2025-05-17 00:37:19', '2025-05-17 00:37:19'),
(9, 'INV/20250517073741', 0, 'pending', '2025-05-17 00:37:41', '2025-05-17 00:37:41'),
(10, 'INV/20250517073827', 0, 'pending', '2025-05-17 00:38:27', '2025-05-17 00:38:27'),
(11, 'INV/20250517074756', 0, 'pending', '2025-05-17 00:47:56', '2025-05-17 00:47:56'),
(12, 'INV/20250517075349', 0, 'pending', '2025-05-17 00:53:49', '2025-05-17 00:53:49'),
(13, 'INV/20250517075709', 0, 'pending', '2025-05-17 00:57:09', '2025-05-17 00:57:09'),
(15, 'INV/20250517080242', 0, 'pending', '2025-05-17 01:02:42', '2025-05-17 01:02:42'),
(16, 'INV/20250517080755', 0, 'pending', '2025-05-17 01:07:55', '2025-05-17 01:07:55'),
(17, 'INV/20250517081109', 0, 'pending', '2025-05-17 01:11:09', '2025-05-17 01:11:09'),
(18, 'INV/20250517082050', 0, 'pending', '2025-05-17 01:20:50', '2025-05-17 01:20:50'),
(19, 'INV/20250517082215', 30000, 'selesai', '2025-05-17 01:22:15', '2025-05-17 01:22:46'),
(20, 'INV/20250517082912', 0, 'pending', '2025-05-17 01:29:12', '2025-05-17 01:29:12'),
(21, 'INV/20250517083053', 0, 'pending', '2025-05-17 01:30:53', '2025-05-17 01:30:53'),
(22, 'INV/20250517083212', 0, 'pending', '2025-05-17 01:32:12', '2025-05-17 01:32:12'),
(24, 'INV/20250517111353', 0, 'pending', '2025-05-17 04:13:53', '2025-05-17 04:13:53'),
(26, 'INV/20250517114017', 20000, 'selesai', '2025-05-17 04:40:17', '2025-05-17 04:41:07'),
(27, 'INV/20250517135313', 0, 'pending', '2025-05-17 06:53:13', '2025-05-17 06:53:13'),
(28, 'INV/20250517135525', 0, 'pending', '2025-05-17 06:55:25', '2025-05-17 06:55:25'),
(29, 'INV/20250517135705', 20000, 'selesai', '2025-05-17 06:57:05', '2025-05-17 06:57:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `peran` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `peran`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@kasir.com', NULL, '$2y$12$ks3EGwKOzOSBN9dQI5QqgOLwg.wBaBDBgNcP/ASoEXkVfo70vaxMG', 'admin', NULL, '2025-05-14 08:54:17', '2025-05-14 08:54:17'),
(4, 'kasir', 'kasir@kasir.com', NULL, '$2y$12$x1CfRXPbvcZYf6KO1k3IV.29l6SESStgRNDH2oFq3nl/Z/RzGll6u', 'kasir', NULL, '2025-05-17 04:57:57', '2025-05-17 04:57:57');

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
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksis_produk_id_foreign` (`produk_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
