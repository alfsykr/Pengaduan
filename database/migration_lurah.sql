-- Migration to add 'lurah' role to users table
ALTER TABLE `users` MODIFY COLUMN `role` ENUM('user', 'admin', 'lurah') NOT NULL DEFAULT 'user';
