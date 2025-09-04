-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 02:18 PM
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
-- Database: `eramda_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agency_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `position` varchar(255) NOT NULL,
  `photo` varchar(2080) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `account_status` varchar(255) NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `agency_id`, `user_type`, `email`, `email_verified_at`, `password`, `lastname`, `firstname`, `gender`, `position`, `photo`, `contact_number`, `account_status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'responders', 'barangay@gmail.com', NULL, '$2y$12$QVw0NRvokJKKQeYYfuI3P.IWos05buA0PM8r1XobimH9MuZhcwJ2C', 'macaan', 'casan', 'm', 'Deputy Leader', 'photos/apcfoQ1VnshJEwnlBLMUsMVcrqqmLaMy5pbyhoqM.jpg', '09606294089', 'pending', NULL, '2025-09-02 19:27:45', '2025-09-02 19:27:45', NULL),
(2, 2, 'responders', 'barangay1@gmail.com', NULL, '$2y$12$N1BnpDQWWca0qQiCVFd8UO9X2uSd6EeWjPr3eXsvKcxBYD999k1uO', 'macaan', 'casan', 'm', 'Deputy Leader', 'photos/OpYIeJkSAgp4CNOHfVNDfE3TSlYgdynr0CNVQPtM.jpg', '09606294089', 'pending', NULL, '2025-09-02 19:50:26', '2025-09-02 19:50:26', NULL),
(3, 9, 'Operation Officer', 'bfp@gmail.com', NULL, '$2y$12$eNuEsyVekJWCuWTAo5u4g.5YMqj2DogVLLZRleJsmhwkvqSVLtWS6', 'macaan', 'casan', 'm', 'Deputy Leader', 'photos/EyzppUDPfRktf0j6ulbxDdrjIxDZTiiXUs9ocxdl.jpg', '09606294089', 'pending', NULL, '2025-09-02 20:10:18', '2025-09-02 20:10:18', NULL),
(4, 9, 'responders', 'bfp1@gmail.com', NULL, '$2y$12$5XtU2NcA66xzDTD14S2dt.mYFUVvx1UzY9NcljkrrCpwPRsc/ECVK', 'laundicho', 'Paulbert', 'm', 'Team Leader', 'photos/NI3c0B9amvCu3f8QGnl4z1ZvBLVz9eVp3yKy21d2.jpg', '09606294089', 'pending', NULL, '2025-09-03 02:23:00', '2025-09-03 02:23:00', NULL),
(5, 9, 'responders', 'bfp2@gmail.com', NULL, '$2y$12$o7/.PHYoTuGJonAf.O.gYejH9aRM/mCDFtANpV92kAFWXZz6qzDxy', 'aballe', 'juvy', 'm', 'Team Leader', 'photos/uQGOhi7IaDVwpWkQuJ4Mj5sQlpOyjqUBQM49aAVI.jpg', '09606294089', 'pending', NULL, '2025-09-03 02:23:35', '2025-09-03 02:23:35', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_agency_id_foreign` (`agency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
