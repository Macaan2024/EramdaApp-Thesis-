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
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agencyNames` varchar(255) NOT NULL,
  `agencyTypes` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `activeStatus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `agencyNames`, `agencyTypes`, `region`, `province`, `city`, `barangay`, `address`, `zipcode`, `email`, `longitude`, `latitude`, `activeStatus`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'City Disaster Risk Reduction and Management Office (CDRRMO)', 'CDRRMO', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Pala-o', 'City Hall Complex, Buhanginan Hill', '9200', 'cdrrmo.iligan@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(2, 'Barangay Disaster Risk Reduction and Management Committee (BDRRMC) – Abuno', 'BDRRRMC', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Abuno', 'Barangay Hall, Abuno', '9200', 'bdrrmc.abuno@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(3, 'Barangay Disaster Risk Reduction and Management Committee (BDRRMC) – Acmac-Mariano Badelles Sr.', 'BDRRMC', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Acmac-Mariano Badelles Sr.', 'Barangay Hall, Acmac', '9200', 'bdrrmc.acmac@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(4, 'Barangay Disaster Risk Reduction and Management Committee (BDRRMC) – Bagong Silang', 'BDRRMC', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Bagong Silang', 'Barangay Hall, Bagong Silang', '9200', 'bdrrmc.bagongsilang@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(5, 'Bureau of Fire Protection (BFP) – Main Station', 'BFP', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Poblacion', 'Benito Labao St., Poblacion', '9200', 'bfp.main@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(6, 'Bureau of Fire Protection (BFP) – Dalipuga Sub-Station', 'BFP', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Dalipuga', 'Dalipuga, Iligan City', '9200', 'bfp.dalipuga@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(7, 'Bureau of Fire Protection (BFP) – Sta. Filomena Sub-Station', 'BFP', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Sta. Filomena', 'Sta. Filomena, Iligan City', '9200', 'bfp.stafilomena@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(8, 'Bureau of Fire Protection (BFP) – Saray Sub-Station', 'BFP', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Saray', 'Saray, Iligan City', '9200', 'bfp.saray@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(9, 'Bureau of Fire Protection (BFP) – Buru-un Sub-Station', 'BFP', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Buru-un', 'Buru-un, Iligan City', '9200', 'bfp.buruun@example.com', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(10, 'Adventist Medical Center – Iligan City', 'HOSPITALS', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'San Miguel', 'Andres Bonifacio Avenue, San Miguel', '9200', 'adventist@iligan.gov.ph', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(11, 'Iligan Medical Center Hospital', 'HOSPITALS', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Pala-o', 'San Miguel Village, Pala-o', '9200', 'imch@iligan.gov.ph', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(12, 'Gregorio T. Lluch Memorial Hospital', 'HOSPITALS', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Poblacion', 'Quezon Avenue Extension, Poblacion', '9200', 'gtlmh@iligan.gov.ph', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(13, 'Mercy Community Hospital', 'HOSPITALS', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Camague', 'Sister of Mercy Road, Camague', '9200', 'mercy@iligan.gov.ph', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL),
(14, 'Dr. Uy Hospital, Inc.', 'HOSPITALS', 'Region X - Northern Mindanao', 'Lanao del Norte', 'Iligan City', 'Poblacion', 'Roxas Avenue, Poblacion', '9200', 'dr.uy@iligan.gov.ph', NULL, NULL, 'active', '2025-09-03 03:11:13', '2025-09-03 03:11:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agencies_agencynames_unique` (`agencyNames`),
  ADD UNIQUE KEY `agencies_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
