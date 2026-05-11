-- ============================================================
-- Dukcapil Mandiri - Desa Digital
-- Layanan Kependudukan Digital
-- Database Schema for MySQL 8.0
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Use existing database
USE `pengaduan3`;

-- ============================================================
-- TABLE: users
-- Authentication and user profile data
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `nik` VARCHAR(16) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `alamat` TEXT DEFAULT NULL,
  `tempat_lahir` VARCHAR(100) DEFAULT NULL,
  `tanggal_lahir` DATE DEFAULT NULL,
  `jenis_kelamin` ENUM('L','P') DEFAULT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_users_nik` (`nik`),
  UNIQUE KEY `uk_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: pengajuan
-- Main submission table
-- ============================================================
CREATE TABLE IF NOT EXISTS `pengajuan_layanan` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `no_registrasi` VARCHAR(30) NOT NULL,
  `jenis_layanan` ENUM('kk','ktp','pindah') NOT NULL,
  `alasan_permohonan` TEXT DEFAULT NULL,
  `metode_pengambilan` ENUM('ambil_sendiri','dikirim') DEFAULT 'ambil_sendiri',
  `status` ENUM('draft','pending','diproses','disetujui','ditolak') NOT NULL DEFAULT 'draft',
  `catatan_admin` TEXT DEFAULT NULL,
  `tanggal_pengajuan` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_diproses` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pengajuan_noreg` (`no_registrasi`),
  KEY `idx_pengajuan_user` (`user_id`),
  KEY `idx_pengajuan_status` (`status`),
  KEY `idx_pengajuan_jenis` (`jenis_layanan`),
  CONSTRAINT `fk_pengajuan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: data_keluarga
-- Family card data (for KK submissions)
-- ============================================================
CREATE TABLE IF NOT EXISTS `data_keluarga` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengajuan_id` INT NOT NULL,
  `no_kk` VARCHAR(16) DEFAULT NULL,
  `nama_kepala_keluarga` VARCHAR(100) NOT NULL,
  `alamat_kk` TEXT DEFAULT NULL,
  `rt` VARCHAR(5) DEFAULT NULL,
  `rw` VARCHAR(5) DEFAULT NULL,
  `kelurahan` VARCHAR(100) DEFAULT NULL,
  `kecamatan` VARCHAR(100) DEFAULT NULL,
  `kota` VARCHAR(100) DEFAULT NULL,
  `provinsi` VARCHAR(100) DEFAULT NULL,
  `kode_pos` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_keluarga_pengajuan` (`pengajuan_id`),
  CONSTRAINT `fk_keluarga_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: anggota_keluarga
-- Family members (linked to data_keluarga)
-- ============================================================
CREATE TABLE IF NOT EXISTS `anggota_keluarga` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data_keluarga_id` INT NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `nik` VARCHAR(16) DEFAULT NULL,
  `jenis_kelamin` ENUM('L','P') NOT NULL,
  `tempat_lahir` VARCHAR(100) DEFAULT NULL,
  `tanggal_lahir` DATE DEFAULT NULL,
  `agama` VARCHAR(20) DEFAULT NULL,
  `pendidikan` VARCHAR(50) DEFAULT NULL,
  `pekerjaan` VARCHAR(50) DEFAULT NULL,
  `status_perkawinan` VARCHAR(30) DEFAULT NULL,
  `hubungan_keluarga` VARCHAR(30) NOT NULL,
  `kewarganegaraan` VARCHAR(5) NOT NULL DEFAULT 'WNI',
  PRIMARY KEY (`id`),
  KEY `idx_anggota_keluarga` (`data_keluarga_id`),
  CONSTRAINT `fk_anggota_keluarga` FOREIGN KEY (`data_keluarga_id`) REFERENCES `data_keluarga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: data_pindah
-- Moving/relocation data (for pindah submissions)
-- ============================================================
CREATE TABLE IF NOT EXISTS `data_pindah` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengajuan_id` INT NOT NULL,
  `alamat_asal` TEXT NOT NULL,
  `rt_asal` VARCHAR(5) DEFAULT NULL,
  `rw_asal` VARCHAR(5) DEFAULT NULL,
  `kelurahan_asal` VARCHAR(100) DEFAULT NULL,
  `kecamatan_asal` VARCHAR(100) DEFAULT NULL,
  `kota_asal` VARCHAR(100) DEFAULT NULL,
  `provinsi_asal` VARCHAR(100) DEFAULT NULL,
  `alamat_tujuan` TEXT NOT NULL,
  `rt_tujuan` VARCHAR(5) DEFAULT NULL,
  `rw_tujuan` VARCHAR(5) DEFAULT NULL,
  `kelurahan_tujuan` VARCHAR(100) DEFAULT NULL,
  `kecamatan_tujuan` VARCHAR(100) DEFAULT NULL,
  `kota_tujuan` VARCHAR(100) DEFAULT NULL,
  `provinsi_tujuan` VARCHAR(100) DEFAULT NULL,
  `alasan_pindah` TEXT DEFAULT NULL,
  `jenis_kepindahan` ENUM('dalam_desa','antar_desa','antar_kecamatan','antar_kota','antar_provinsi') NOT NULL,
  `jumlah_keluarga_pindah` INT DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_pindah_pengajuan` (`pengajuan_id`),
  CONSTRAINT `fk_pindah_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: dokumen
-- Uploaded supporting documents
-- ============================================================
CREATE TABLE IF NOT EXISTS `dokumen` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengajuan_id` INT NOT NULL,
  `jenis_dokumen` VARCHAR(100) NOT NULL,
  `nama_file` VARCHAR(255) NOT NULL,
  `nama_asli` VARCHAR(255) NOT NULL,
  `ukuran_file` INT NOT NULL DEFAULT 0,
  `tipe_file` VARCHAR(50) NOT NULL,
  `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_dokumen_pengajuan` (`pengajuan_id`),
  CONSTRAINT `fk_dokumen_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA
-- ============================================================

-- Default admin user (password: admin123)
INSERT INTO `users` (`nama_lengkap`, `nik`, `email`, `no_hp`, `password`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `role`) VALUES
('Administrator', '0000000000000001', 'admin@dukcapil.go.id', '081200000000', '$2y$10$BxYmS8fuRzDTnoPv6ZTQ7OKjzxfs4ed0/179GNN.J.8IGkW5hTHkK', 'Kantor Desa', 'Jakarta', '1990-01-01', 'L', 'admin');

-- Demo user (password: user123)
INSERT INTO `users` (`nama_lengkap`, `nik`, `email`, `no_hp`, `password`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `role`) VALUES
('Ahmad Fauzi', '3201234567890001', 'ahmad.fauzi@email.com', '081298765432', '$2y$10$/8B/LtvFGqUXsjeFB3vxPeOyxSryb5nMGcEBXkbBSgahOVhx0MefUy', 'Jl. Melati No. 45, Desa Sukamaju', 'Jakarta', '1992-08-12', 'L', 'user');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
