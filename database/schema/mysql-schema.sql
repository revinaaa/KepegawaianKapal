/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `bpjs_kesehatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bpjs_kesehatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_rawat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `status_bpjs` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bpjs_kesehatans_no_kartu_unique` (`no_kartu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bpjs_ketenagakerjaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bpjs_ketenagakerjaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_rawat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `status_bpjs` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bpjs_ketenagakerjaans_no_kartu_unique` (`no_kartu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cutis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cutis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_cuti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `alasan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ditolak','proses','diterima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lampiran` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cutis_user_nik_foreign` (`user_nik`),
  CONSTRAINT `cutis_user_nik_foreign` FOREIGN KEY (`user_nik`) REFERENCES `users` (`nik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jabatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `karyawans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karyawans` (
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doh` date DEFAULT NULL,
  `id_jabatan` bigint(20) unsigned DEFAULT NULL,
  `nama_kapal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan_darah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_akun_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_akun_bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_pajak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_istri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_istri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_anak_pertama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_anak_pertama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_anak_kedua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_anak_kedua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_anak_ketiga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_anak_ketiga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kartu_kes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_rawat_kes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar_kes` date DEFAULT NULL,
  `status_bpjs_kes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kartu_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_rawat_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_daftar_kerja` date DEFAULT NULL,
  `status_bpjs_kerja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_keluarga` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`nik`),
  KEY `karyawans_id_jabatan_foreign` (`id_jabatan`),
  KEY `karyawans_user_nik_foreign` (`user_nik`),
  CONSTRAINT `karyawans_id_jabatan_foreign` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `karyawans_user_nik_foreign` FOREIGN KEY (`user_nik`) REFERENCES `users` (`nik`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nik`),
  UNIQUE KEY `users_slug_unique` (`slug`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_100000_create_password_reset_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2023_06_18_000000_create_roles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2023_06_18_010000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2023_06_18_020000_create_jabatans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2023_06_18_030000_create_karyawans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2023_06_18_050000_add_user_id_to_karyawans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_05_28_064409_create_bpjs_kesehatans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_05_28_065252_create_bpjs_ketenagakerjaans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_05_29_074429_add_foto_to_karyawans_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_05_29_144234_create_cutis_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_05_31_073132_add_status_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_05_31_124710_add_slug_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_06_01_143948_add_user_id_to_cutis_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_06_09_090137_create_permission_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_06_16_142707_add_nik_to_users_table',1);
