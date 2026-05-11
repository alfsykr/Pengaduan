-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 13, 2025 at 03:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengaduan3`
--
CREATE DATABASE IF NOT EXISTS `pengaduan3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `pengaduan3`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `username`, `password`, `role`) VALUES
(1, 'Pak ruslan', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int NOT NULL,
  `tracking_code` varchar(20) NOT NULL,
  `status` enum('pending','proses','ditolak','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pending',
  `tanggal_pengaduan` date NOT NULL DEFAULT (curdate()),
  `nama_pengirim` varchar(100) NOT NULL,
  `no_telp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prioritas` enum('rendah','menengah','tinggi') NOT NULL,
  `subjek` varchar(255) NOT NULL,
  `isi_laporan` text NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `tracking_code`, `status`, `tanggal_pengaduan`, `nama_pengirim`, `no_telp`, `prioritas`, `subjek`, `isi_laporan`, `foto`) VALUES
(33, 'WMP4XKZ1JD', 'selesai', '2025-05-13', 'rioooo', '089721218932', 'menengah', 'asd', 'asd', '6822b4d5e71c9.jpg'),
(34, '7NZTB6JV4I', 'ditolak', '2025-05-13', 'asd', 'asd', 'menengah', 'asd', 'asd', '6822b98759405.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_pengaduan`
--

CREATE TABLE `pesan_pengaduan` (
  `id_pesan` int NOT NULL,
  `id_pengaduan` int NOT NULL,
  `pengirim_role` enum('masyarakat','admin') NOT NULL,
  `pengirim_id` int DEFAULT NULL,
  `tanggal_pesan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isi_pesan` text NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesan_pengaduan`
--

INSERT INTO `pesan_pengaduan` (`id_pesan`, `id_pengaduan`, `pengirim_role`, `pengirim_id`, `tanggal_pesan`, `isi_pesan`, `foto`) VALUES
(41, 33, 'admin', 1, '2025-05-13 03:10:18', 'test', ''),
(42, 33, 'admin', 1, '2025-05-13 03:10:21', 'asd', '6822b823004ff.jpg'),
(43, 33, 'masyarakat', NULL, '2025-05-13 03:14:04', 'ok test masuk', ''),
(44, 33, 'masyarakat', NULL, '2025-05-13 03:15:14', 'testtesttesttesttesttesttest', 'WhatsApp Image 2025-04-26 at 22.05.51_568c1d69.jpg'),
(45, 33, 'admin', 1, '2025-05-13 03:15:35', 'okokok', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD UNIQUE KEY `tracking_code` (`tracking_code`);

--
-- Indexes for table `pesan_pengaduan`
--
ALTER TABLE `pesan_pengaduan`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `pesan_pengaduan_ibfk_2` (`pengirim_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pesan_pengaduan`
--
ALTER TABLE `pesan_pengaduan`
  MODIFY `id_pesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesan_pengaduan`
--
ALTER TABLE `pesan_pengaduan`
  ADD CONSTRAINT `pesan_pengaduan_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_pengaduan_ibfk_2` FOREIGN KEY (`pengirim_id`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
