-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: pilot_db
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `as_failed_jobs`
--

DROP TABLE IF EXISTS `as_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_failed_jobs`
--

LOCK TABLES `as_failed_jobs` WRITE;
/*!40000 ALTER TABLE `as_failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_info_companies`
--

DROP TABLE IF EXISTS `as_info_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_info_companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_info_companies_user_id_unique` (`user_id`),
  CONSTRAINT `as_info_companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_info_companies`
--

LOCK TABLES `as_info_companies` WRITE;
/*!40000 ALTER TABLE `as_info_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_info_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_info_users`
--

DROP TABLE IF EXISTS `as_info_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_info_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` tinyint NOT NULL DEFAULT '1',
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_flight_time` int NOT NULL DEFAULT '0' COMMENT 'Общее время полета Role 23',
  `salary_min` int NOT NULL DEFAULT '0' COMMENT 'Заработная плата (минимальная в день/в месяц)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `salarie_type_id` bigint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_info_users_user_id_unique` (`user_id`),
  KEY `as_info_users_salarie_type_id_foreign` (`salarie_type_id`),
  CONSTRAINT `as_info_users_salarie_type_id_foreign` FOREIGN KEY (`salarie_type_id`) REFERENCES `as_list_salaries` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_info_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_info_users`
--

LOCK TABLES `as_info_users` WRITE;
/*!40000 ALTER TABLE `as_info_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_info_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_list_contracts`
--

DROP TABLE IF EXISTS `as_list_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_list_contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_list_contracts`
--

LOCK TABLES `as_list_contracts` WRITE;
/*!40000 ALTER TABLE `as_list_contracts` DISABLE KEYS */;
INSERT INTO `as_list_contracts` VALUES (1,'Freelance',NULL,NULL),(2,'Ferry',NULL,NULL),(3,'Full time',NULL,NULL);
/*!40000 ALTER TABLE `as_list_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_list_licenses`
--

DROP TABLE IF EXISTS `as_list_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_list_licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_list_licenses`
--

LOCK TABLES `as_list_licenses` WRITE;
/*!40000 ALTER TABLE `as_list_licenses` DISABLE KEYS */;
INSERT INTO `as_list_licenses` VALUES (1,'FAA',NULL,NULL),(2,'EASA',NULL,NULL),(3,'Other ICAO',NULL,NULL);
/*!40000 ALTER TABLE `as_list_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_list_planes`
--

DROP TABLE IF EXISTS `as_list_planes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_list_planes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_list_planes`
--

LOCK TABLES `as_list_planes` WRITE;
/*!40000 ALTER TABLE `as_list_planes` DISABLE KEYS */;
INSERT INTO `as_list_planes` VALUES (1,'Falcon',NULL,NULL),(2,'B-737',NULL,NULL),(3,'A-320',NULL,NULL);
/*!40000 ALTER TABLE `as_list_planes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_list_positions`
--

DROP TABLE IF EXISTS `as_list_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_list_positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_list_positions`
--

LOCK TABLES `as_list_positions` WRITE;
/*!40000 ALTER TABLE `as_list_positions` DISABLE KEYS */;
INSERT INTO `as_list_positions` VALUES (1,'Captain',2,NULL,NULL),(2,'FO',2,NULL,NULL),(3,'Senior Flight Attendants',3,NULL,NULL),(4,'Flight Attendants',3,NULL,NULL),(5,'Aircraft Mechanic',4,NULL,NULL),(6,'Aviation Technician',4,NULL,NULL),(7,'Avionics Technician',4,NULL,NULL),(8,'Other',4,NULL,NULL);
/*!40000 ALTER TABLE `as_list_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_list_salaries`
--

DROP TABLE IF EXISTS `as_list_salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_list_salaries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_list_salaries`
--

LOCK TABLES `as_list_salaries` WRITE;
/*!40000 ALTER TABLE `as_list_salaries` DISABLE KEYS */;
INSERT INTO `as_list_salaries` VALUES (1,'day',NULL,NULL),(2,'month',NULL,NULL);
/*!40000 ALTER TABLE `as_list_salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_migrations`
--

DROP TABLE IF EXISTS `as_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_migrations`
--

LOCK TABLES `as_migrations` WRITE;
/*!40000 ALTER TABLE `as_migrations` DISABLE KEYS */;
INSERT INTO `as_migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_08_13_123935_create_permission_tables',1),(6,'2022_08_22_134620_create_providers_table',1),(7,'2024_01_17_160303_create_list_planes_table',1),(8,'2024_01_17_160841_create_list_contracts_table',1),(9,'2024_01_17_161143_create_list_licenses_table',1),(10,'2024_01_17_161346_create_list_positions_table',1),(11,'2024_01_18_103938_create_info_companies_table',1),(12,'2024_01_18_122516_create_info_users_table',1),(13,'2024_01_18_154244_create_user_working_days_table',1),(14,'2024_01_19_123553_create_user_planes_table',1),(15,'2024_01_19_125546_create_user_licenses_table',1),(16,'2024_01_19_130738_create_user_contracts_table',1),(17,'2024_01_19_131426_create_user_positions_table',1),(18,'2024_01_29_122012_create_list_salaries_table',1),(19,'2024_01_29_123102_update_info_users',1),(20,'2024_01_29_153756_create_orders_table',1),(21,'2024_01_30_081558_create_order_working_days_table',1),(22,'2024_01_30_082306_create_order_licenses_table',1),(23,'2024_01_30_095118_create_order_responds_table',1);
/*!40000 ALTER TABLE `as_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_model_has_permissions`
--

DROP TABLE IF EXISTS `as_model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `as_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `as_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_model_has_permissions`
--

LOCK TABLES `as_model_has_permissions` WRITE;
/*!40000 ALTER TABLE `as_model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_model_has_roles`
--

DROP TABLE IF EXISTS `as_model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `as_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `as_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_model_has_roles`
--

LOCK TABLES `as_model_has_roles` WRITE;
/*!40000 ALTER TABLE `as_model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_order_licenses`
--

DROP TABLE IF EXISTS `as_order_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_order_licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `license_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_order_licenses_order_id_index` (`order_id`),
  KEY `as_order_licenses_license_id_index` (`license_id`),
  CONSTRAINT `as_order_licenses_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `as_list_licenses` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_order_licenses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `as_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_order_licenses`
--

LOCK TABLES `as_order_licenses` WRITE;
/*!40000 ALTER TABLE `as_order_licenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_order_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_order_responds`
--

DROP TABLE IF EXISTS `as_order_responds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_order_responds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status_approved` tinyint NOT NULL DEFAULT '3' COMMENT '1 = approved, 2 = rejected, 3 = pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_order_responds_order_id_index` (`order_id`),
  KEY `as_order_responds_user_id_index` (`user_id`),
  CONSTRAINT `as_order_responds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `as_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_order_responds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_order_responds`
--

LOCK TABLES `as_order_responds` WRITE;
/*!40000 ALTER TABLE `as_order_responds` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_order_responds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_order_working_days`
--

DROP TABLE IF EXISTS `as_order_working_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_order_working_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `day` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_order_working_days_order_id_index` (`order_id`),
  CONSTRAINT `as_order_working_days_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `as_orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_order_working_days`
--

LOCK TABLES `as_order_working_days` WRITE;
/*!40000 ALTER TABLE `as_order_working_days` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_order_working_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_orders`
--

DROP TABLE IF EXISTS `as_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `contract_id` bigint unsigned NOT NULL,
  `plane_id` bigint unsigned NOT NULL,
  `comment` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_flight_time` int NOT NULL DEFAULT '0' COMMENT 'Общее время полета Role 23',
  `salary_min` int NOT NULL DEFAULT '0' COMMENT 'Заработная плата',
  `salarie_type_id` bigint unsigned NOT NULL DEFAULT '1',
  `departure` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `arrival` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_orders_salarie_type_id_foreign` (`salarie_type_id`),
  KEY `as_orders_company_id_index` (`company_id`),
  KEY `as_orders_position_id_index` (`position_id`),
  KEY `as_orders_contract_id_index` (`contract_id`),
  KEY `as_orders_plane_id_index` (`plane_id`),
  CONSTRAINT `as_orders_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `as_info_companies` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_orders_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `as_list_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_orders_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `as_list_planes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_orders_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `as_list_positions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_orders_salarie_type_id_foreign` FOREIGN KEY (`salarie_type_id`) REFERENCES `as_list_salaries` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_orders`
--

LOCK TABLES `as_orders` WRITE;
/*!40000 ALTER TABLE `as_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_password_resets`
--

DROP TABLE IF EXISTS `as_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `as_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_password_resets`
--

LOCK TABLES `as_password_resets` WRITE;
/*!40000 ALTER TABLE `as_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_permissions`
--

DROP TABLE IF EXISTS `as_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_permissions`
--

LOCK TABLES `as_permissions` WRITE;
/*!40000 ALTER TABLE `as_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_personal_access_tokens`
--

DROP TABLE IF EXISTS `as_personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_personal_access_tokens_token_unique` (`token`),
  KEY `as_personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_personal_access_tokens`
--

LOCK TABLES `as_personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `as_personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_providers`
--

DROP TABLE IF EXISTS `as_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_providers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_providers_user_id_foreign` (`user_id`),
  CONSTRAINT `as_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_providers`
--

LOCK TABLES `as_providers` WRITE;
/*!40000 ALTER TABLE `as_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_role_has_permissions`
--

DROP TABLE IF EXISTS `as_role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `as_role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `as_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `as_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `as_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `as_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_role_has_permissions`
--

LOCK TABLES `as_role_has_permissions` WRITE;
/*!40000 ALTER TABLE `as_role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_roles`
--

DROP TABLE IF EXISTS `as_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_roles`
--

LOCK TABLES `as_roles` WRITE;
/*!40000 ALTER TABLE `as_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user_contracts`
--

DROP TABLE IF EXISTS `as_user_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user_contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `contract_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_user_contracts_user_id_index` (`user_id`),
  KEY `as_user_contracts_contract_id_index` (`contract_id`),
  CONSTRAINT `as_user_contracts_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `as_list_contracts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_user_contracts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user_contracts`
--

LOCK TABLES `as_user_contracts` WRITE;
/*!40000 ALTER TABLE `as_user_contracts` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_user_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user_licenses`
--

DROP TABLE IF EXISTS `as_user_licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user_licenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `license_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_user_licenses_user_id_index` (`user_id`),
  KEY `as_user_licenses_license_id_index` (`license_id`),
  CONSTRAINT `as_user_licenses_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `as_list_licenses` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_user_licenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user_licenses`
--

LOCK TABLES `as_user_licenses` WRITE;
/*!40000 ALTER TABLE `as_user_licenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_user_licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user_planes`
--

DROP TABLE IF EXISTS `as_user_planes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user_planes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `plane_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_user_planes_user_id_index` (`user_id`),
  KEY `as_user_planes_plane_id_index` (`plane_id`),
  CONSTRAINT `as_user_planes_plane_id_foreign` FOREIGN KEY (`plane_id`) REFERENCES `as_list_planes` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_user_planes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user_planes`
--

LOCK TABLES `as_user_planes` WRITE;
/*!40000 ALTER TABLE `as_user_planes` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_user_planes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user_positions`
--

DROP TABLE IF EXISTS `as_user_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user_positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `position_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_user_positions_user_id_index` (`user_id`),
  KEY `as_user_positions_position_id_index` (`position_id`),
  CONSTRAINT `as_user_positions_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `as_list_positions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `as_user_positions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user_positions`
--

LOCK TABLES `as_user_positions` WRITE;
/*!40000 ALTER TABLE `as_user_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_user_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_user_working_days`
--

DROP TABLE IF EXISTS `as_user_working_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_user_working_days` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `day` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `as_user_working_days_user_id_index` (`user_id`),
  CONSTRAINT `as_user_working_days_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `as_users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_user_working_days`
--

LOCK TABLES `as_user_working_days` WRITE;
/*!40000 ALTER TABLE `as_user_working_days` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_user_working_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `as_users`
--

DROP TABLE IF EXISTS `as_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `as_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_subscription` tinyint NOT NULL DEFAULT '1' COMMENT 'подписка 1 - inactive, 2 - active',
  `role_id` tinyint NOT NULL DEFAULT '1',
  `push_token` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `as_users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `as_users`
--

LOCK TABLES `as_users` WRITE;
/*!40000 ALTER TABLE `as_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `as_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-04  0:40:38
