-- ============================================================
-- Migration: Add Citizen Complaint (Pengaduan Warga) Table
-- ============================================================
USE `pengaduan3`;

CREATE TABLE IF NOT EXISTS `pengaduan_warga` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `no_pengaduan` VARCHAR(30) NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `kategori` ENUM('Keamanan','Infrastruktur','Kebersihan','Sosial','Kesehatan','Lainnya') NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `lokasi` TEXT NOT NULL,
  `latitude` DECIMAL(10,8) DEFAULT NULL,
  `longitude` DECIMAL(11,8) DEFAULT NULL,
  `status` ENUM('proses','selesai','ditolak') NOT NULL DEFAULT 'proses',
  `catatan_admin` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pengaduan_nopengaduan` (`no_pengaduan`),
  KEY `idx_pengaduan_warga_user` (`user_id`),
  CONSTRAINT `fk_pengaduan_warga_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `foto_pengaduan_warga` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengaduan_id` INT NOT NULL,
  `nama_file` VARCHAR(255) NOT NULL,
  `nama_asli` VARCHAR(255) NOT NULL,
  `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_foto_pengaduan_warga` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduan_warga` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
