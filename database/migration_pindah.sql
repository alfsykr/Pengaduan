-- ============================================================
-- Migration: Update data_pindah for F-1.03 compliance
-- ============================================================
USE `pengaduan3`;

-- Add new columns to data_pindah
ALTER TABLE `data_pindah`
ADD COLUMN `jenis_permohonan_pindah` ENUM('skp','skpln','sktt') NOT NULL DEFAULT 'skp' AFTER `pengajuan_id`,
ADD COLUMN `klasifikasi_kepindahan` ENUM('dalam_desa','antar_desa','antar_kecamatan','antar_kota','antar_provinsi') DEFAULT NULL AFTER `provinsi_tujuan`,
ADD COLUMN `alasan_pindah_lainnya` VARCHAR(255) DEFAULT NULL AFTER `alasan_pindah`;

-- Modify jenis_kepindahan to match F-1.03
ALTER TABLE `data_pindah`
MODIFY COLUMN `jenis_kepindahan` ENUM('kepala_keluarga','kepala_dan_seluruh','kepala_dan_sebagian','anggota_keluarga','dalam_desa','antar_desa','antar_kecamatan','antar_kota','antar_provinsi') NOT NULL DEFAULT 'kepala_keluarga';

-- Modify alasan_pindah to ENUM for structured options
ALTER TABLE `data_pindah`
MODIFY COLUMN `alasan_pindah` VARCHAR(50) DEFAULT NULL;

-- Create anggota_pindah table (Daftar Keluarga Yang Pindah - form #12)
CREATE TABLE IF NOT EXISTS `anggota_pindah` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data_pindah_id` INT NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `nik` VARCHAR(16) DEFAULT NULL,
  `shdk` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_anggota_pindah` (`data_pindah_id`),
  CONSTRAINT `fk_anggota_pindah` FOREIGN KEY (`data_pindah_id`) REFERENCES `data_pindah` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
