-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sp_panleukopania.gejala
CREATE TABLE IF NOT EXISTS `gejala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `bobot` float DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `kode` (`kode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.gejala: ~8 rows (approximately)
INSERT INTO `gejala` (`id`, `kode`, `nama`, `deskripsi`, `bobot`, `created_at`, `created_by`, `update_at`, `update_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(152, 'G01', 'Muntah', '-', 1, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(153, 'G02', 'Diare', '-', 0.9, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(154, 'G03', 'Dehidrasi', '-', 0.8, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(155, 'G04', 'Lesu', '-', 0.3, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(156, 'G05', 'Lemas', '-', 0.4, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(157, 'G06', 'Anemia', '-', 0.7, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(158, 'G07', 'Anoreksia/Tidak Nafsu Makan', '-', 0.5, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(159, 'G08', 'Radang Telinga', '-', 0.6, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(160, 'G09', 'Keluar Cacing Saat BAB', '-', 0.2, NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(161, 'G10', 'Hipersalivasi/Air Liru Keluar Terus Menerus', '-', 0.1, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- Dumping structure for table sp_panleukopania.hasil_diagnosa
CREATE TABLE IF NOT EXISTS `hasil_diagnosa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `jenis_kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `himpunan_id` int DEFAULT NULL,
  `no_hp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `probabilitas` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `himpunan_id` (`himpunan_id`),
  CONSTRAINT `hasil_diagnosa_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.hasil_diagnosa: ~1 rows (approximately)
INSERT INTO `hasil_diagnosa` (`id`, `user_id`, `nama`, `alamat`, `jenis_kelamin`, `umur`, `himpunan_id`, `no_hp`, `probabilitas`, `created_at`, `created_by`, `update_at`, `update_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(33, 14, 'Coba Aja', 'tidak ada', 'L', 20, 20, NULL, 0.01672424, '2025-07-03 12:21:58', 14, '2025-07-03 12:21:58', 14, 0, NULL, NULL),
	(34, 14, 'Budi Raharjo II', 'gas', 'L', 20, 5, NULL, 0.907, '2025-07-04 15:37:33', 14, '2025-07-04 15:37:33', 14, 0, NULL, NULL);

-- Dumping structure for table sp_panleukopania.hasil_diagnosa_detail
CREATE TABLE IF NOT EXISTS `hasil_diagnosa_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hasil_id` int NOT NULL,
  `gejala_id` int NOT NULL,
  `nilai` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `gejala_id` (`gejala_id`) USING BTREE,
  KEY `riwayat_id` (`hasil_id`) USING BTREE,
  CONSTRAINT `hasil_diagnosa_detail_ibfk_1` FOREIGN KEY (`hasil_id`) REFERENCES `hasil_diagnosa` (`id`),
  CONSTRAINT `hasil_diagnosa_detail_ibfk_2` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.hasil_diagnosa_detail: ~5 rows (approximately)
INSERT INTO `hasil_diagnosa_detail` (`id`, `hasil_id`, `gejala_id`, `nilai`, `created_at`, `updated_at`) VALUES
	(78, 33, 153, NULL, '2025-07-03 19:21:58', '2025-07-03 19:21:58'),
	(79, 33, 154, NULL, '2025-07-03 19:21:58', '2025-07-03 19:21:58'),
	(80, 33, 155, NULL, '2025-07-03 19:21:58', '2025-07-03 19:21:58'),
	(81, 33, 156, NULL, '2025-07-03 19:21:58', '2025-07-03 19:21:58'),
	(82, 33, 158, NULL, '2025-07-03 19:21:58', '2025-07-03 19:21:58'),
	(83, 34, 152, NULL, '2025-07-04 22:37:33', '2025-07-04 22:37:33'),
	(84, 34, 153, NULL, '2025-07-04 22:37:33', '2025-07-04 22:37:33'),
	(85, 34, 154, NULL, '2025-07-04 22:37:33', '2025-07-04 22:37:33');

-- Dumping structure for table sp_panleukopania.himpunan
CREATE TABLE IF NOT EXISTS `himpunan` (
  `id` int NOT NULL,
  `variabel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `batas_bawah` decimal(3,2) DEFAULT NULL,
  `batas_atas` decimal(3,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.himpunan: ~5 rows (approximately)
INSERT INTO `himpunan` (`id`, `variabel`, `batas_bawah`, `batas_atas`, `created_at`, `update_at`) VALUES
	(1, 'Tidak Terjangkit', 0.00, 0.20, '2025-07-03 18:29:47', '2025-07-03 18:29:47'),
	(2, 'Mungkin Terjangkit', 0.21, 0.40, '2025-07-03 18:29:47', '2025-07-03 18:29:47'),
	(3, 'Terjangkit', 0.41, 0.60, '2025-07-03 18:29:47', '2025-07-03 18:29:47'),
	(4, 'Terjangkit Parah', 0.61, 0.80, '2025-07-03 18:29:47', '2025-07-03 18:29:47'),
	(5, 'Terjangkit Sangat Parah', 0.81, 1.00, '2025-07-03 18:29:47', '2025-07-03 18:29:47');

-- Dumping structure for table sp_panleukopania.penyakit
CREATE TABLE IF NOT EXISTS `penyakit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `kode` (`kode`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.penyakit: ~2 rows (approximately)
INSERT INTO `penyakit` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `created_by`, `update_at`, `update_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(20, 'P01', 'Positif Panleukopania', '-', NULL, NULL, NULL, NULL, 0, NULL, NULL),
	(21, 'P02', 'Suspek Panleukopania', '-', NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- Dumping structure for table sp_panleukopania.rules
CREATE TABLE IF NOT EXISTS `rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `penyakit_id` int NOT NULL,
  `gejala_id` int NOT NULL,
  `nilai` decimal(5,4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `penyakit_id` (`penyakit_id`,`gejala_id`) USING BTREE,
  KEY `gejala_id` (`gejala_id`) USING BTREE,
  CONSTRAINT `rules_ibfk_1` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id`),
  CONSTRAINT `rules_ibfk_2` FOREIGN KEY (`gejala_id`) REFERENCES `gejala` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.rules: ~20 rows (approximately)
INSERT INTO `rules` (`id`, `penyakit_id`, `gejala_id`, `nilai`, `created_at`, `created_by`, `update_at`, `update_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(109, 20, 152, 1.0000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(110, 20, 153, 0.9000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(111, 20, 154, 0.8000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(112, 20, 155, 0.3000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(113, 20, 156, 0.4000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(114, 20, 157, 0.7000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(115, 20, 158, 0.5000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(116, 20, 159, 0.6000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(117, 20, 160, 0.2000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(118, 20, 161, 0.1000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(119, 21, 152, 1.0000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(120, 21, 153, 0.9000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(121, 21, 154, 0.8000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(122, 21, 155, 0.3000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(123, 21, 156, 0.4000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(124, 21, 157, 0.7000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(125, 21, 158, 0.5000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(126, 21, 159, 0.6000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(127, 21, 160, 0.2000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL),
	(128, 21, 161, 0.1000, '2025-07-03 00:34:52', NULL, NULL, NULL, 0, NULL, NULL);

-- Dumping structure for table sp_panleukopania.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sp_panleukopania.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `alamat`, `role`, `username`, `email`, `password`, `created_at`, `created_by`, `update_at`, `update_by`, `deleted`, `deleted_at`, `deleted_by`) VALUES
	(10, 'Admin Sistem', 'Jl. Pusat No. 1', 'admin', 'admin', 'admin@mail.com', '$2y$10$A8ZUTrNR.7mLKpdT1Q0McuqZucmeOdb6tzxT9.JWptElJYACTSPKm', '2025-06-10 21:57:46', NULL, NULL, NULL, 0, NULL, NULL),
	(11, 'Dewi Lestari', 'Jl. Melati No. 2', 'user', 'dewi', 'dewi@email.com', '$2y$10$WkX9V3Z0E/OLdKYQcbiFDuZ5s7M6iIQrQkTQ31KZPEF6Tw47YBqjS', '2025-06-10 21:57:46', NULL, NULL, NULL, 0, NULL, NULL),
	(12, 'Budi Santoso', 'Jl. Mawar No. 5', 'user', 'budi', 'budi@email.com', '$2y$10$U5W.7YzA2FE3vB7CmT4cpeBDUT5avm3Uv6ZJBS9H.7j3ThjQoWhuC', '2025-06-10 21:57:46', NULL, NULL, NULL, 0, NULL, NULL),
	(13, 'Siti Aminah', 'Jl. Anggrek No. 7', 'user', 'siti', 'siti@email.com', '$2y$10$A8ZUTrNR.7mLKpdT1Q0McuqZucmeOdb6tzxT9.JWptElJYACTSPKm', '2025-06-10 21:57:46', NULL, NULL, NULL, 0, NULL, NULL),
	(14, 'budi', 'Jl. Anggrek No. 7', 'user', 'budis', 'budi@mail.com', '$2y$10$A8ZUTrNR.7mLKpdT1Q0McuqZucmeOdb6tzxT9.JWptElJYACTSPKm', '2025-06-10 14:58:54', NULL, NULL, NULL, 0, NULL, NULL),
	(15, 'budisia', NULL, 'user', '', 'mail@mail.com', '$2y$10$uk7oeEM2jJEHBD7QejX4ium5D8wDbJLsLHJT6p3EQCC/xp9c01WZm', '2025-07-03 05:11:56', NULL, NULL, NULL, 0, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
