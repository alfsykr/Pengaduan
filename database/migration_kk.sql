-- Migration: Add jenis_permohonan_kk and sub_jenis_kk
USE `pengaduan3`;

ALTER TABLE `data_keluarga`
ADD COLUMN `jenis_permohonan_kk` VARCHAR(30) NOT NULL DEFAULT 'baru' AFTER `pengajuan_id`,
ADD COLUMN `sub_jenis_kk` VARCHAR(50) DEFAULT NULL AFTER `jenis_permohonan_kk`;
