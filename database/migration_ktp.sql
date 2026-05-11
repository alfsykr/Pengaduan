-- Migration: Add jenis_permohonan_ktp to pengajuan_layanan
USE `pengaduan3`;

ALTER TABLE `pengajuan_layanan`
ADD COLUMN `jenis_permohonan_ktp` VARCHAR(50) DEFAULT NULL AFTER `jenis_layanan`;
