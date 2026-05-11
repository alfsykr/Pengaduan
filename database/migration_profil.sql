-- Migration: Extend users table for complete profile data
USE `pengaduan3`;

ALTER TABLE `users`
ADD COLUMN `agama` VARCHAR(20) DEFAULT NULL AFTER `jenis_kelamin`,
ADD COLUMN `status_perkawinan` VARCHAR(30) DEFAULT NULL AFTER `agama`,
ADD COLUMN `pekerjaan` VARCHAR(100) DEFAULT NULL AFTER `status_perkawinan`,
ADD COLUMN `pendidikan` VARCHAR(50) DEFAULT NULL AFTER `pekerjaan`,
ADD COLUMN `kewarganegaraan` VARCHAR(5) DEFAULT 'WNI' AFTER `pendidikan`,
ADD COLUMN `alamat_kk` TEXT DEFAULT NULL AFTER `alamat`,
ADD COLUMN `rt` VARCHAR(5) DEFAULT NULL AFTER `alamat_kk`,
ADD COLUMN `rw` VARCHAR(5) DEFAULT NULL AFTER `rt`,
ADD COLUMN `kelurahan` VARCHAR(100) DEFAULT NULL AFTER `rw`,
ADD COLUMN `kecamatan` VARCHAR(100) DEFAULT NULL AFTER `kelurahan`,
ADD COLUMN `kota` VARCHAR(100) DEFAULT NULL AFTER `kecamatan`,
ADD COLUMN `provinsi` VARCHAR(100) DEFAULT NULL AFTER `kota`,
ADD COLUMN `kode_pos` VARCHAR(10) DEFAULT NULL AFTER `provinsi`,
ADD COLUMN `alamat_domisili` TEXT DEFAULT NULL AFTER `kode_pos`,
ADD COLUMN `no_kk` VARCHAR(16) DEFAULT NULL AFTER `alamat_domisili`,
ADD COLUMN `nama_kepala_keluarga` VARCHAR(100) DEFAULT NULL AFTER `no_kk`;
