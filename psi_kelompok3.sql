-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: psi_kelompok3
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensi`
--

DROP TABLE IF EXISTS `absensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `absensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `status` enum('hadir','izin','sakit','alpha') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absensi_siswa_id_foreign` (`siswa_id`),
  KEY `absensi_user_id_foreign` (`user_id`),
  CONSTRAINT `absensi_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `absensi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensi`
--

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (1,13,'2025-09-18','16:01:28','sakit',NULL,NULL,'2025-09-18 09:01:28','2025-09-18 09:44:33'),(2,12,'2025-09-20','19:24:32','hadir',NULL,NULL,'2025-09-20 12:24:32','2025-09-20 12:24:32'),(3,7,'2025-09-20','19:25:38','hadir',NULL,NULL,'2025-09-20 12:25:38','2025-09-20 12:25:38'),(4,1,'2025-09-20','19:25:51','hadir',NULL,NULL,'2025-09-20 12:25:51','2025-09-20 12:25:51'),(5,4,'2025-09-20','19:25:57','hadir',NULL,NULL,'2025-09-20 12:25:57','2025-09-20 12:25:57'),(6,10,'2025-09-20','19:26:04','hadir',NULL,NULL,'2025-09-20 12:26:04','2025-09-20 12:26:04'),(7,5,'2025-09-20','19:26:11','hadir',NULL,NULL,'2025-09-20 12:26:11','2025-09-20 12:26:11'),(8,2,'2025-09-20','19:26:15','alpha',NULL,NULL,'2025-09-20 12:26:15','2025-09-20 12:26:15'),(9,13,'2025-09-20','19:26:22','hadir',NULL,NULL,'2025-09-20 12:26:22','2025-09-20 12:26:22'),(10,6,'2025-09-20','19:26:27','hadir',NULL,NULL,'2025-09-20 12:26:27','2025-09-20 12:26:27'),(11,3,'2025-09-20','19:26:30','hadir',NULL,NULL,'2025-09-20 12:26:30','2025-09-20 12:26:30'),(12,11,'2025-09-20','19:26:35','hadir',NULL,NULL,'2025-09-20 12:26:35','2025-09-20 12:26:35'),(13,9,'2025-09-20','19:26:41','hadir',NULL,NULL,'2025-09-20 12:26:41','2025-09-20 12:26:41'),(14,14,'2025-09-20','19:26:47','hadir',NULL,NULL,'2025-09-20 12:26:47','2025-09-20 12:26:47'),(15,8,'2025-09-20','19:26:53','hadir',NULL,NULL,'2025-09-20 12:26:53','2025-09-20 12:26:53'),(16,1,'2025-09-21','19:58:21','hadir',NULL,NULL,'2025-09-21 12:58:21','2025-09-21 12:58:21'),(17,2,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(18,3,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(19,4,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(20,5,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(21,6,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(22,7,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(23,8,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(24,9,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(25,10,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(26,11,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(27,12,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(28,13,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(29,14,'2025-09-21','09:00:00','alpha','Otomatis Alpha karena tidak absen sampai jam 9',NULL,'2025-09-21 13:11:00','2025-09-21 13:11:00'),(30,1,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(31,2,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(32,3,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(33,4,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(34,5,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(35,6,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(36,7,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(37,8,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(38,9,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(39,10,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(40,11,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(41,12,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(42,13,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14'),(43,14,'2025-09-25','09:00:00','alpha','Ditandai alpha oleh sistem',NULL,'2025-09-25 00:59:14','2025-09-25 00:59:14');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `barang_id` int NOT NULL AUTO_INCREMENT,
  `kantin_id` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga_barang` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`barang_id`),
  KEY `kantin_id` (`kantin_id`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (9,7,'Sate Taichan',12000.00,'2025-10-02 22:51:59','2025-10-02 23:03:00'),(11,7,'Kimchi',23000.00,'2025-10-03 01:10:17','2025-10-03 01:10:17'),(12,7,'Nasi Goreng',15000.00,'2025-10-03 01:11:05','2025-10-03 01:11:05'),(13,7,'Sate Tahu',3000.00,'2025-10-03 01:11:21','2025-10-03 01:11:21');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru`
--

DROP TABLE IF EXISTS `guru`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guru` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru`
--

LOCK TABLES `guru` WRITE;
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` VALUES (9,'Guru','123','0876','guru@gmail.com','Patik','aktif','2025-09-20 13:09:27','2025-09-20 13:09:27');
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kantin`
--

DROP TABLE IF EXISTS `kantin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kantin` (
  `kantin_id` int NOT NULL AUTO_INCREMENT,
  `nama_kantin` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kantin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kantin`
--

LOCK TABLES `kantin` WRITE;
/*!40000 ALTER TABLE `kantin` DISABLE KEYS */;
INSERT INTO `kantin` VALUES (5,'Kantin Utamaa','2025-10-01 08:20:52','2025-10-02 21:12:40'),(6,'Kantin Cobaa','2025-10-02 21:20:05','2025-10-02 21:25:37'),(7,'Kantin Utama','2025-10-02 21:25:52','2025-10-02 21:25:52');
/*!40000 ALTER TABLE `kantin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'VII A','2025-08-22 20:59:50','2025-09-01 09:17:24'),(2,'VII B','2025-08-22 20:59:50','2025-08-22 20:59:50'),(3,'VIII A','2025-08-22 20:59:50','2025-08-22 20:59:50');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_08_11_000000_create_absensi_tables',1),(4,'2025_08_11_045217_create_sessions_table',2),(5,'2025_08_11_072822_create_absensis_table',3),(6,'2025_08_21_042922_create_personal_access_tokens_table',3),(7,'2025_08_23_000000_create_guru_table',4),(8,'2025_08_23_100000_create_rombel_siswa_table',5),(9,'2025_08_23_110000_drop_kelas_tahun_from_siswa_table',5),(10,'2025_08_23_111000_drop_tahun_from_kelas_table',5),(11,'2025_08_23_112000_drop_wali_kelas_from_kelas_table',6),(12,'2025_08_28_032103_create_reports_table',7),(13,'2025_09_02_024636_add_two_factor_columns_to_users_table',8),(14,'2025_10_06_153540_add_timestamps_to_saldo_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stateid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reports_message_id_unique` (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'121572963','6287842949212','tes','pending',NULL,NULL,'2025-09-21 12:56:43','2025-09-21 12:56:43'),(2,'122385941','6287842949212','p','pending',NULL,NULL,'2025-09-25 13:08:58','2025-09-25 13:08:58');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rombel_siswa`
--

DROP TABLE IF EXISTS `rombel_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rombel_siswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `nomor_absen` int DEFAULT NULL,
  `kelas_id` bigint unsigned NOT NULL,
  `tahun_ajaran_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombel_siswa_siswa_id_foreign` (`siswa_id`),
  KEY `rombel_siswa_kelas_id_foreign` (`kelas_id`),
  KEY `rombel_siswa_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  CONSTRAINT `rombel_siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rombel_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rombel_siswa_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rombel_siswa`
--

LOCK TABLES `rombel_siswa` WRITE;
/*!40000 ALTER TABLE `rombel_siswa` DISABLE KEYS */;
INSERT INTO `rombel_siswa` VALUES (1,4,1,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(2,1,2,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(3,5,3,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(4,12,4,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(5,3,5,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(6,10,6,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(7,6,7,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(8,13,8,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(9,14,9,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(10,11,10,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(11,2,11,3,3,'2025-09-18 09:13:47','2025-09-18 09:22:13'),(12,9,1,2,3,'2025-09-18 09:13:47','2025-09-18 09:16:34'),(13,7,2,2,3,'2025-09-18 09:13:47','2025-09-18 09:16:34'),(14,8,3,2,3,'2025-09-18 09:13:47','2025-09-18 09:16:34');
/*!40000 ALTER TABLE `rombel_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saldo`
--

DROP TABLE IF EXISTS `saldo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saldo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `saldo` decimal(12,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  CONSTRAINT `saldo_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saldo`
--

LOCK TABLES `saldo` WRITE;
/*!40000 ALTER TABLE `saldo` DISABLE KEYS */;
INSERT INTO `saldo` VALUES (1,1,120000.00,NULL,NULL),(2,2,175000.00,NULL,NULL),(3,3,100000.00,NULL,NULL);
/*!40000 ALTER TABLE `saldo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('OmMfyx22GwbZ9C7Ibs34jCfzfNWxOuOf765dyw8w',9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoicG94aE0yaENjazhZT2Z5QWVtb281RFpSdDQ1Qlg1ajJVcndhZGxBUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQtcGF5bWVudCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7czo3OiJzaWRlYmFyIjtzOjc6InBheW1lbnQiO30=',1759823991);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp_ortu` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','lulus','keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `siswa_nis_unique` (`nis`),
  UNIQUE KEY `siswa_rfid_unique` (`rfid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` VALUES (1,'Andi Pratama','10001','6287842949212','4a6bd4c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(2,'Raka Putra','10002','6287842949213','1a8990c9','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(3,'Dimas Arya','10003','6287842949214','cafc3cc8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(4,'Aldi Saputra','10004','6287842949215','5aa8f1c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(5,'Bayu Kurnia','10005','6287842949216','8aea4dc8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(6,'Fajar Hidayat','10006','6287842949217','fa96bec8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(7,'Reza Maulana','10007','6287842949218','5ab150c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(8,'Sinta Dewi','10008','6287842949219','ba974ec8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(9,'Rani Amelia','10009','6287842949220','3a211c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(10,'Dina Safira','10010','6287842949221','9afa67c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(11,'Putri Ayu','10011','6287842949222','2679f63','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(12,'Citra Lestari','10012','6287842949223','252f73','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(13,'Lila Kartika','10013','6287842949224','3a4314c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07'),(14,'Nia Rahma','10014','6287842949225','aa3eb6c8','aktif','2025-09-14 03:28:07','2025-09-14 03:28:07');
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_ajaran`
--

DROP TABLE IF EXISTS `tahun_ajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tahun_ajaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_ajaran`
--

LOCK TABLES `tahun_ajaran` WRITE;
/*!40000 ALTER TABLE `tahun_ajaran` DISABLE KEYS */;
INSERT INTO `tahun_ajaran` VALUES (3,'2025/2026',0,'2025-08-22 21:42:36','2025-09-20 13:07:48');
/*!40000 ALTER TABLE `tahun_ajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topup`
--

DROP TABLE IF EXISTS `topup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `topup` (
  `topup_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topup_id`),
  KEY `siswa_id` (`siswa_id`),
  CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topup`
--

LOCK TABLES `topup` WRITE;
/*!40000 ALTER TABLE `topup` DISABLE KEYS */;
INSERT INTO `topup` VALUES (1,1,20000.00,'2025-10-07 05:58:29','2025-10-07 06:09:36'),(2,2,100000.00,'2025-10-07 06:42:38','2025-10-07 06:42:38'),(3,1,50000.00,'2025-10-07 06:43:13','2025-10-07 06:43:13');
/*!40000 ALTER TABLE `topup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi` (
  `transaksi_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `kantin_id` int NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaksi_id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `kantin_id` (`kantin_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi_item`
--

DROP TABLE IF EXISTS `transaksi_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaksi_id` bigint unsigned NOT NULL,
  `barang_id` int NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `transaksi_item_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`) ON DELETE CASCADE,
  CONSTRAINT `transaksi_item_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi_item`
--

LOCK TABLES `transaksi_item` WRITE;
/*!40000 ALTER TABLE `transaksi_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` enum('superadmin','admin','guru','pemilik_kantin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kantin_id` int DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_users_kantin` (`kantin_id`),
  CONSTRAINT `fk_users_kantin` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (9,'Super Extonnnn','superadmin@gmail.com','$2y$12$G27HK1OzEuQwFzTlSKSBQuyI4hLMbiOA1SJmYX2Pw5TeZbWCt7if2',NULL,NULL,NULL,'superadmin',NULL,'pDZHus2mwMWZZysBTqtNluDWKOikLC0ZxtjoiJRfdGeqa7rt8NamTfn0s4Rd','2025-09-20 13:08:27','2025-10-07 07:55:56'),(10,'Admin','admin@gmail.com','$2y$12$aZnHgkgrWKmtR1k8oPTyruM3/Km3PffDTKqU8uDfrwwG6Mtbssm42',NULL,NULL,NULL,'admin',NULL,NULL,'2025-09-20 13:08:55','2025-09-20 13:08:55'),(11,'Guru','guru@gmail.com','$2y$12$eDE/jkXaB5XyU1zW9r5rfuq2xdy18jBHlJVrs6Ybmlz3Uto/.n6RK',NULL,NULL,NULL,'guru',NULL,NULL,'2025-09-20 13:09:27','2025-09-20 13:11:54'),(12,'kantinutama','kantinutama@gmail.com','$2y$12$IHY/r/tD.oOtQsCWkNRbjOYhoUlnBGGho4BFXH22q3ETY0HXosu7e',NULL,NULL,NULL,'pemilik_kantin',7,NULL,'2025-10-02 22:45:44','2025-10-02 22:45:44'),(13,'kantinkedua','kantinkedua@gmail.com','$2y$12$MYxwUkYb7zKIFSCKfLphkOVMjerSHVUqXr6ga.Q4bJwmKtZc2eEne',NULL,NULL,NULL,'pemilik_kantin',6,NULL,'2025-10-03 00:51:10','2025-10-03 00:51:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-07 15:02:35
