-- ============================================================
-- Migration: Add Kelahiran and Kematian Services (F-2.01)
-- ============================================================
USE `pengaduan3`;

-- Modify jenis_layanan ENUM in pengajuan_layanan
ALTER TABLE `pengajuan_layanan`
MODIFY COLUMN `jenis_layanan` ENUM('kk','ktp','pindah','kelahiran','kematian') NOT NULL;

-- Create table for data_kelahiran
CREATE TABLE IF NOT EXISTS `data_kelahiran` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengajuan_id` INT NOT NULL,
  
  -- Saksi
  `nik_saksi` VARCHAR(16) DEFAULT NULL,
  `nama_saksi` VARCHAR(100) DEFAULT NULL,
  
  -- Orang Tua
  `nik_ayah` VARCHAR(16) DEFAULT NULL,
  `nama_ayah` VARCHAR(100) DEFAULT NULL,
  `nik_ibu` VARCHAR(16) DEFAULT NULL,
  `nama_ibu` VARCHAR(100) DEFAULT NULL,
  
  -- Bayi / Kelahiran
  `nik_bayi` VARCHAR(16) DEFAULT NULL,
  `nama_bayi` VARCHAR(100) DEFAULT NULL,
  `jenis_kelamin` ENUM('L','P') DEFAULT NULL,
  `tempat_dilahirkan` ENUM('RS_RB','Puskesmas','Polindes','Rumah','Lainnya') DEFAULT NULL,
  `tempat_kelahiran` VARCHAR(100) DEFAULT NULL,
  `tanggal_lahir` DATE DEFAULT NULL,
  `pukul` VARCHAR(10) DEFAULT NULL,
  `jenis_kelahiran` ENUM('Tunggal','Kembar 2','Kembar 3','Kembar 4','Lainnya') DEFAULT NULL,
  `kelahiran_ke` INT DEFAULT 1,
  `penolong_kelahiran` ENUM('Dokter','Bidan/Perawat','Dukun','Lainnya') DEFAULT NULL,
  `berat_bayi` DECIMAL(5,2) DEFAULT NULL, -- Kg
  `panjang_bayi` INT DEFAULT NULL, -- Cm
  
  PRIMARY KEY (`id`),
  KEY `idx_kelahiran_pengajuan` (`pengajuan_id`),
  CONSTRAINT `fk_kelahiran_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create table for data_kematian
CREATE TABLE IF NOT EXISTS `data_kematian` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pengajuan_id` INT NOT NULL,
  
  -- Saksi I & II
  `nik_saksi_1` VARCHAR(16) DEFAULT NULL,
  `nama_saksi_1` VARCHAR(100) DEFAULT NULL,
  `nik_saksi_2` VARCHAR(16) DEFAULT NULL,
  `nama_saksi_2` VARCHAR(100) DEFAULT NULL,
  
  -- Orang Tua
  `nik_ayah` VARCHAR(16) DEFAULT NULL,
  `nama_ayah` VARCHAR(100) DEFAULT NULL,
  `nik_ibu` VARCHAR(16) DEFAULT NULL,
  `nama_ibu` VARCHAR(100) DEFAULT NULL,
  
  -- Jenazah / Kematian
  `nik_jenazah` VARCHAR(16) DEFAULT NULL,
  `nama_jenazah` VARCHAR(100) DEFAULT NULL,
  `tanggal_kematian` DATE DEFAULT NULL,
  `pukul` VARCHAR(10) DEFAULT NULL,
  `sebab_kematian` ENUM('Sakit biasa/tua','Wabah Penyakit','Kecelakaan','Kriminalitas','Bunuh Diri','Lainnya') DEFAULT NULL,
  `tempat_kematian` VARCHAR(100) DEFAULT NULL,
  `yang_menerangkan` ENUM('Dokter','Tenaga Kesehatan','Kepolisian','Lainnya') DEFAULT NULL,
  
  PRIMARY KEY (`id`),
  KEY `idx_kematian_pengajuan` (`pengajuan_id`),
  CONSTRAINT `fk_kematian_pengajuan` FOREIGN KEY (`pengajuan_id`) REFERENCES `pengajuan_layanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
