-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table kkjsalesorder.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.dashboard
CREATE TABLE IF NOT EXISTS `dashboard` (
  `MAINKEY` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DOCENTRY` int DEFAULT NULL,
  `KODESALES` int DEFAULT NULL,
  `NAMASALES` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KEY` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KEY2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KEY3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KEY4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TYPE` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TARGET` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CAPAI` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PERSENTASE` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TARGETSPR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CAPAISPR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SUMTARGETSPR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SUMCAPAISPR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SUMPERSENTASE` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `TAHUN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BULAN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`MAINKEY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.dashboard2
CREATE TABLE IF NOT EXISTS `dashboard2` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `PROFITCENTER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KEYPROFITCENTER` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VALUE` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `TAHUN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BULAN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.ocrd_local
CREATE TABLE IF NOT EXISTS `ocrd_local` (
  `CardCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CardName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `City` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `State` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Type1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Type2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreateDate` date DEFAULT NULL,
  `LastOdrDate` date DEFAULT NULL,
  `Termin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Limit` double DEFAULT NULL,
  `ActBal` double DEFAULT NULL,
  `DlvBal` double DEFAULT NULL,
  `OdrBal` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL DEFAULT '1',
  `NIK` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`CardCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.oitm_local
CREATE TABLE IF NOT EXISTS `oitm_local` (
  `ItemCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ItemName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FrgnName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Segment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Series` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ProfitCenter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Satuan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TotalStock` double DEFAULT NULL,
  `HET` double DEFAULT NULL,
  `StatusHKN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StatusFG` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KetHKN` text COLLATE utf8mb4_unicode_ci,
  `KetFG` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KetStock` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ItemCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.ordr_local
CREATE TABLE IF NOT EXISTS `ordr_local` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `OdrRefNum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OdrNum` int NOT NULL,
  `OdrCrdCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OdrSlpCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OdrDocDate` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_synced` tinyint(1) NOT NULL DEFAULT '0',
  `is_checked` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ordr_local_odrcrdcode_foreign` (`OdrCrdCode`),
  CONSTRAINT `ordr_local_odrcrdcode_foreign` FOREIGN KEY (`OdrCrdCode`) REFERENCES `ocrd_local` (`CardCode`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.oslp_local
CREATE TABLE IF NOT EXISTS `oslp_local` (
  `SlpCode` int NOT NULL,
  `SlpName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FirstOdrDate` date DEFAULT NULL,
  `LastOdrDate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SlpCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.oslp_reg
CREATE TABLE IF NOT EXISTS `oslp_reg` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `RegUserId` int NOT NULL,
  `RegSlpCode` int NOT NULL,
  `Alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oslp_reg_reguserid_unique` (`RegUserId`),
  UNIQUE KEY `oslp_reg_regslpcode_unique` (`RegSlpCode`),
  UNIQUE KEY `oslp_reg_alias_unique` (`Alias`),
  CONSTRAINT `oslp_reg_regslpcode_foreign` FOREIGN KEY (`RegSlpCode`) REFERENCES `oslp_local` (`SlpCode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.permission_user
CREATE TABLE IF NOT EXISTS `permission_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_user_id_foreign` (`user_id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.rdr1_local
CREATE TABLE IF NOT EXISTS `rdr1_local` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `OdrId` int NOT NULL,
  `RdrItemCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RdrItemQuantity` double NOT NULL,
  `RdrItemSatuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RdrItemPrice` double NOT NULL,
  `RdrItemProfitCenter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RdrItemKetHKN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RdrItemKetFG` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `RdrItemDisc` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('manager','supervisor','salesman','developer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table kkjsalesorder.user_devices
CREATE TABLE IF NOT EXISTS `user_devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_active` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_devices_user_id_device_id_unique` (`user_id`,`device_id`),
  KEY `user_devices_user_id_index` (`user_id`),
  KEY `user_devices_device_id_index` (`device_id`),
  CONSTRAINT `user_devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
