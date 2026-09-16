/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.4.3-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: fortunes_collection
-- ------------------------------------------------------
-- Server version	11.4.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `fortunes_collection`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `fortunes_collection` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `fortunes_collection`;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `apartment` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `lga` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Nigeria',
  `postal_code` varchar(255) DEFAULT NULL,
  `delivery_instructions` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`),
  KEY `addresses_session_id_index` (`session_id`),
  CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES
(1,1,NULL,'Korede Adeleke','korede@example.com','+2348023456789','Plot 12, PTI Road','Executive Suite','Effurun','Delta','Uvwie','Nigeria','330102','Gate security call upon arrival.',1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'superadmin',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES
(1,'Fortunes Director','admin@fortunes.ng','$2y$12$Imrk25nik4W12M0hHh2/puILs6fAluxyU0fVG.R.oMRF5kEFIRcQi','superadmin',NULL,'2026-09-15 14:32:33','2026-09-15 14:32:33');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `entity_type` varchar(255) DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_admin_user_id_foreign` (`admin_user_id`),
  CONSTRAINT `audit_logs_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
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
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'TOPS','tops','Heavyweight washed tees, tanks, tailored shirting, and luxury tactical vests.',NULL,1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'BOTTOMS','bottoms','Heavy baggy cargo denims, architectural trousers, and lounge track pants.',NULL,2,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,'OUTERWEAR','outerwear','Racing track jackets, bonded bombers, and structured haute kimonos.',NULL,3,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(4,'ACCESSORIES','accessories','Solid brass and leather monogram belts, silk scarves, and headwear.',NULL,4,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `season` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `collections_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES
(1,'GENESIS ARCHIVE','genesis-archive','ARCHIVE 2026','High-octane African haute couture silhouette','Raw textures, industrial gold accents, and vintage wash treatment.',NULL,1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'EFFURUN NOCTURNE','effurun-nocturne','SERIES 02','Nightlife, asphalt, and uncompromising street elegance','Deep obsidian tones with bespoke metallic hardware.',NULL,1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,'CYBER SAHARA','cyber-sahara','HAUTE SUMMER','Desert khaki meets utilitarian racing gear','High thermal adaptability and double-layered cotton silhouettes.',NULL,1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `contact_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES
(1,1,'Korede Adeleke','korede@example.com','+2348023456789','Private Atelier Consultation for Traditional Wedding','Good day Fortunes team. I would like to schedule a private fitting session at the PTI Road Maison for a bespoke 3-piece Kaftan ensemble.','unread','Follow up via WhatsApp to schedule atelier appointment.','2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_usages`
--

DROP TABLE IF EXISTS `coupon_usages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  KEY `coupon_usages_order_id_foreign` (`order_id`),
  KEY `coupon_usages_user_id_foreign` (`user_id`),
  CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_usages`
--

LOCK TABLES `coupon_usages` WRITE;
/*!40000 ALTER TABLE `coupon_usages` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'percentage',
  `value` decimal(12,2) NOT NULL,
  `min_spend` decimal(12,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(12,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES
(1,'FORTUNES10','percentage',10.00,100000.00,50000.00,500,14,NULL,NULL,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'EFFURUN2026','fixed',30000.00,200000.00,NULL,100,8,NULL,NULL,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `homepage_sections`
--

DROP TABLE IF EXISTS `homepage_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homepage_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content`)),
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_sections`
--

LOCK TABLES `homepage_sections` WRITE;
/*!40000 ALTER TABLE `homepage_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `homepage_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned DEFAULT NULL,
  `stock_count` int(11) NOT NULL DEFAULT 0,
  `low_stock_threshold` int(11) NOT NULL DEFAULT 5,
  `reserved_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_product_id_foreign` (`product_id`),
  KEY `inventory_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inventory_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES
(1,1,1,8,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,1,2,12,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,1,3,6,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(4,1,4,4,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(5,2,5,10,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(6,2,6,15,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(7,2,7,8,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(8,2,8,5,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(9,3,9,0,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(10,3,10,0,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(11,4,11,14,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(12,4,12,20,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(13,4,13,12,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(14,5,14,5,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(15,5,15,7,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(16,5,16,3,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(17,6,17,9,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(18,6,18,16,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(19,6,19,11,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(20,6,20,6,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(21,7,21,4,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(22,7,22,8,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(23,7,23,7,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(24,8,24,5,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(25,8,25,3,5,0,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_01_01_000001_create_admin_users_table',1),
(5,'2026_01_01_000002_create_categories_and_collections_tables',1),
(6,'2026_01_01_000003_create_products_and_variants_tables',1),
(7,'2026_01_01_000004_create_product_images_and_inventory_tables',1),
(8,'2026_01_01_000005_create_addresses_table',1),
(9,'2026_01_01_000006_create_orders_and_order_items_tables',1),
(10,'2026_01_01_000007_create_payments_table',1),
(11,'2026_01_01_000008_create_wishlists_table',1),
(12,'2026_01_01_000009_create_reviews_and_testimonials_tables',1),
(13,'2026_01_01_000010_create_coupons_and_usages_tables',1),
(14,'2026_01_01_000011_create_site_settings_and_cms_tables',1),
(15,'2026_01_01_000012_create_ecommerce_suite_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'subscribed',
  `source` varchar(255) NOT NULL DEFAULT 'storefront',
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `newsletter_subscribers` VALUES
(1,'vip.client@fortunes.ng','VIP Client Services','subscribed','footer','2026-09-15 14:32:35','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(2,'atelier.member@fortunes.ng','Effurun Atelier Patron','subscribed','checkout','2026-09-15 14:32:35','2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_histories`
--

DROP TABLE IF EXISTS `order_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `notified_customer` tinyint(1) NOT NULL DEFAULT 0,
  `action_by` varchar(255) NOT NULL DEFAULT 'system',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_histories_order_id_foreign` (`order_id`),
  CONSTRAINT `order_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_histories`
--

LOCK TABLES `order_histories` WRITE;
/*!40000 ALTER TABLE `order_histories` DISABLE KEYS */;
INSERT INTO `order_histories` VALUES
(1,1,'pending','Order initiated at checkout.',1,'customer','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(2,1,'paid','Paystack webhook verified payment of ₦378,000.',1,'gateway','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(3,2,'processing','Garment inspection complete at PTI Road Atelier. Packed in signature Fortunes gold dust bag.',1,'admin','2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `order_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `product_variant_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `variant_details` varchar(255) DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_product_variant_id_foreign` (`product_variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(1,1,1,1,'FORTUNES HEAVY BAGGY CARPENTER DENIM','FC-DEN-001-S30-MIN','Size: S (30) / Color: Mineral Wash Grey',299500.00,1,299500.00,'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1000&auto=format&fit=crop','2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,2,2,NULL,'FORTUNES EFFURUN ARCHIVE VINTAGE WASHED SHIRT','FC-TEE-002','Size: M / Color: Earthy Terra Brown',205000.00,1,205000.00,'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1000&auto=format&fit=crop','2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `shipping_address_id` bigint(20) unsigned DEFAULT NULL,
  `shipping_method` varchar(255) NOT NULL DEFAULT 'effurun_vip',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `currency` varchar(3) NOT NULL DEFAULT 'NGN',
  `subtotal` decimal(12,2) NOT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(12,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'paystack',
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `tracking_number` varchar(255) DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `customer_notes` text DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_shipping_address_id_foreign` (`shipping_address_id`),
  KEY `orders_customer_email_index` (`customer_email`),
  KEY `orders_status_index` (`status`),
  KEY `orders_payment_status_index` (`payment_status`),
  CONSTRAINT `orders_shipping_address_id_foreign` FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(1,'FC-2026-89421',1,'Korede Adeleke','korede@example.com','+2348023456789',1,'effurun_vip','paid','NGN',504500.00,50000.00,3500.00,0.00,458000.00,'FORTUNES10','paystack','paid','FC-TRK-774910','Maison Effurun Dedicated Courier','Customer requested gold wax seal on exterior envelope.',NULL,'2026-09-15 09:32:34',NULL,NULL,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(2,'FC-2026-90142',NULL,'Folake Balogun','folake.b@outlook.com','+2348149876543',NULL,'delta_express','processing','NGN',205000.00,0.00,4500.00,0.00,209500.00,NULL,'paystack','paid',NULL,NULL,'Preparing for dispatch to Warri / Effurun enclave.',NULL,'2026-09-15 12:32:34',NULL,NULL,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT 'paystack',
  `reference` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'NGN',
  `channel` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `gateway_response` varchar(255) DEFAULT NULL,
  `raw_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_payload`)),
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_reference_unique` (`reference`),
  KEY `payments_order_id_foreign` (`order_id`),
  KEY `payments_transaction_id_index` (`transaction_id`),
  KEY `payments_status_index` (`status`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(1,1,'paystack','PSTK_LIVE_REF_aa5eab13b228','TRX_88492014',458000.00,'NGN','card','successful','Approved',NULL,'2026-09-15 09:32:34','2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES
(1,1,'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES HEAVY BAGGY CARPENTER DENIM',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,1,'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES HEAVY BAGGY CARPENTER DENIM - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,2,'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES EFFURUN ARCHIVE VINTAGE WASHED SHIRT',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(4,2,'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES EFFURUN ARCHIVE VINTAGE WASHED SHIRT - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(5,3,'https://images.unsplash.com/photo-1624222247344-550fb60583dc?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES PURE LEATHER MONOGRAM BELT',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(6,3,'https://images.unsplash.com/photo-1624222247344-550fb60583dc?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES PURE LEATHER MONOGRAM BELT - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(7,4,'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES ARCHIVE CENTER GOLD LOGO TANK / GREY',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(8,4,'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES ARCHIVE CENTER GOLD LOGO TANK / GREY - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(9,5,'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES CYBER SAHARA RACING SUIT / OBSIDIAN GOLD',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(10,5,'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES CYBER SAHARA RACING SUIT / OBSIDIAN GOLD - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(11,6,'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES NIGERIA IS REAL HAUTE OVERSIZED HOODIE',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(12,6,'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES NIGERIA IS REAL HAUTE OVERSIZED HOODIE - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(13,7,'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES TACTICAL CARGO COMBAT TROUSERS',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(14,7,'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES TACTICAL CARGO COMBAT TROUSERS - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(15,8,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000&auto=format&fit=crop',1,'FORTUNES GOLD EMBROIDERED MAISON KIMONO',1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(16,8,'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000&auto=format&fit=crop',0,'FORTUNES GOLD EMBROIDERED MAISON KIMONO - Detail',2,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_tags`
--

DROP TABLE IF EXISTS `product_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_tags_product_id_tag_id_unique` (`product_id`,`tag_id`),
  KEY `product_tags_tag_id_foreign` (`tag_id`),
  CONSTRAINT `product_tags_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_tags`
--

LOCK TABLES `product_tags` WRITE;
/*!40000 ALTER TABLE `product_tags` DISABLE KEYS */;
INSERT INTO `product_tags` VALUES
(1,1,1,NULL,NULL),
(2,1,2,NULL,NULL),
(3,1,3,NULL,NULL),
(4,1,4,NULL,NULL),
(5,2,2,NULL,NULL),
(6,2,5,NULL,NULL);
/*!40000 ALTER TABLE `product_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `color_hex` varchar(255) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `price_override` decimal(12,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_variants_sku_unique` (`sku`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES
(1,1,'S (30)','Mineral Wash Grey','#3D3D3D','FC-DEN-001-S30-MIN',NULL,8,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,1,'M (32)','Mineral Wash Grey','#3D3D3D','FC-DEN-001-M32-MIN',NULL,12,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,1,'L (34)','Mineral Wash Grey','#3D3D3D','FC-DEN-001-L34-MIN',NULL,6,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(4,1,'XL (36)','Mineral Wash Grey','#3D3D3D','FC-DEN-001-XL3-MIN',NULL,4,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(5,2,'S','Earthy Terra Brown','#4A3326','FC-TEE-002-S-EAR',NULL,10,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(6,2,'M','Earthy Terra Brown','#4A3326','FC-TEE-002-M-EAR',NULL,15,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(7,2,'L','Earthy Terra Brown','#4A3326','FC-TEE-002-L-EAR',NULL,8,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(8,2,'XL','Earthy Terra Brown','#4A3326','FC-TEE-002-XL-EAR',NULL,5,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(9,3,'85cm (30-32)','Espresso Brown','#2B1B17','FC-ACC-003-85C-ESP',NULL,0,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(10,3,'95cm (34-36)','Espresso Brown','#2B1B17','FC-ACC-003-95C-ESP',NULL,0,0,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(11,4,'S','Heather Platinum Grey','#B0B0B0','FC-TNK-004-S-HEA',NULL,14,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(12,4,'M','Heather Platinum Grey','#B0B0B0','FC-TNK-004-M-HEA',NULL,20,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(13,4,'L','Heather Platinum Grey','#B0B0B0','FC-TNK-004-L-HEA',NULL,12,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(14,5,'M','Obsidian Black / Gold','#0A0A0A','FC-OUT-005-M-OBS',NULL,5,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(15,5,'L','Obsidian Black / Gold','#0A0A0A','FC-OUT-005-L-OBS',NULL,7,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(16,5,'XL','Obsidian Black / Gold','#0A0A0A','FC-OUT-005-XL-OBS',NULL,3,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(17,6,'S','Deep Royal Navy','#111C24','FC-HOD-006-S-DEE',NULL,9,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(18,6,'M','Deep Royal Navy','#111C24','FC-HOD-006-M-DEE',NULL,16,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(19,6,'L','Deep Royal Navy','#111C24','FC-HOD-006-L-DEE',NULL,11,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(20,6,'XL','Deep Royal Navy','#111C24','FC-HOD-006-XL-DEE',NULL,6,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(21,7,'S','Tactical Cyber Olive','#4D543B','FC-CRG-007-S-TAC',NULL,4,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(22,7,'M','Tactical Cyber Olive','#4D543B','FC-CRG-007-M-TAC',NULL,8,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(23,7,'L','Tactical Cyber Olive','#4D543B','FC-CRG-007-L-TAC',NULL,7,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(24,8,'One Size','Raw Dover Ivory / Gold','#F4EFE6','FC-KIM-008-ONE-RAW',NULL,5,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(25,8,'One Size','Obsidian Black / Gold','#0A0A0A','FC-KIM-008-ONE-OBS',NULL,3,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `details` text DEFAULT NULL,
  `care_instructions` text DEFAULT NULL,
  `size_guide` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `compare_at_price` decimal(12,2) DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `collection_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 1,
  `is_bestseller` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `featured_image` varchar(255) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_collection_id_foreign` (`collection_id`),
  KEY `products_is_featured_index` (`is_featured`),
  KEY `products_is_new_index` (`is_new`),
  KEY `products_is_bestseller_index` (`is_bestseller`),
  KEY `products_status_index` (`status`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,'FORTUNES HEAVY BAGGY CARPENTER DENIM','fortunes-heavy-baggy-carpenter-denim','FC-DEN-001','BOTTOMS / ARCHIVE','16oz heavyweight Japanese selvedge denim with vintage mineral stone wash, double knee panels, and imperial gold hardware.','Constructed from 16oz heavyweight rigid cotton denim sourced from Okayama and artisan-finished in Effurun. Features articulated double-knee construction, custom antique gold rivets, hammer loop, and an exaggerated wide-leg flare tailored for modern luxury proportions.\n\nPre-shrunk with an artisanal stone wash resulting in unique marble whiskering on every piece.','• 100% 16oz Heavyweight Cotton Denim\n• Custom Fortunes stamped gold brass buttons\n• Relaxed oversized carpenter fit with floor sweep\n• 7-pocket architectural utility styling\n• Hand-finished in Effurun, Nigeria','Dry clean recommended or machine wash cold inside out. Hang dry in shade to preserve indigo wash.','Model is 6\'2\" (188cm) wearing size 32 (M). Fits intentionally oversized.',299500.00,340000.00,2,1,1,1,1,'active','https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(2,'FORTUNES EFFURUN ARCHIVE VINTAGE WASHED SHIRT','fortunes-effurun-archive-vintage-washed-shirt','FC-TEE-002','TOPS / CLOTHING','300 GSM custom-knit combed cotton tee with distressed edge trims, sun-faded pigment dye, and gold leaf typography.','Our signature boxy silhouette t-shirt cut from high-density 300 GSM combed cotton. Treated with a sun-cured vintage dye process giving each garment a lived-in patina. Features tonal micro-distressing around collar and cuffs with subtle gold foil typographic branding across the lower hem.','• 300 GSM Luxury Combed Cotton\n• Drop shoulder boxy streetwear cut\n• Pigment dye with subtle distressed ribbing\n• Imperial gold embroidered nape insignia\n• Made in Maison Fortunes Effurun','Hand wash cold or gentle machine cycle. Do not bleach. Iron on reverse.','Model is 6\'1\" wearing size L. Boxy relaxed fit.',205000.00,225000.00,1,2,1,1,1,'active','https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(3,'FORTUNES PURE LEATHER MONOGRAM BELT','fortunes-pure-leather-monogram-belt','FC-ACC-003','ACCESSORIES / LEATHER GOODS','Full-grain Italian calfskin leather belt with handcrafted solid brass Fortunes insignia in burnished antique gold.','Crafted from 4mm thick vegetable-tanned full-grain leather that burnishes beautifully with age. Finished with hand-beveled wax-sealed edges and a heavy cast brass monogram buckle plated in 18k antique gold.','• 100% Full-grain Tuscan calfskin leather\n• 18k Antique gold plated solid brass buckle\n• 38mm width fits standard denim and trousers\n• Hand-embossed serial numbering on reverse\n• Includes luxury presentation box and velvet dustbag','Condition with natural beeswax leather cream annually.','Standard adjustable sizing from 30\" to 38\" waist.',188000.00,NULL,4,1,1,0,1,'active','https://images.unsplash.com/photo-1624222247344-550fb60583dc?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(4,'FORTUNES ARCHIVE CENTER GOLD LOGO TANK / GREY','fortunes-archive-center-gold-logo-tank-grey','FC-TNK-004','TOPS / BASICS','Ribbed 280 GSM luxury combed cotton athletic tank with metallic gold 3D chest badge and dropped armholes.','Elevated everyday luxury. Engineered from a proprietary 2x2 ribbed heavy stretch-cotton blend that holds its architectural shape wash after wash. Embellished with the Fortunes signature oval gold crest on the center chest.','• 95% Combed Organic Cotton, 5% Elastane\n• Micro-ribbed bound neckline and armholes\n• 3D metallic liquid-gold silicone chest emblem\n• Lengthened scalloped hem for layering\n• Milled and tailored in Nigeria','Machine wash cold with like colors. Do not tumble dry.','True to size for a fitted look; size up for oversized draping.',139685.00,155000.00,1,2,1,1,0,'active','https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(5,'FORTUNES CYBER SAHARA RACING SUIT / OBSIDIAN GOLD','fortunes-cyber-sahara-racing-suit-obsidian-gold','FC-OUT-005','OUTERWEAR / LIMITED','Double-knit technical racing zip jacket and track trouser ensemble with golden piped seams and embroidered Maison heraldry.','A masterclass in luxury sportswear. Cut from technical scuba cotton with high-sheen satin side tape and heavy two-way gold metal RiRi zippers. Designed for high speed, evening allure, and international grand touring.','• 420 GSM Double-knit bonded interlock cotton\n• Two-way custom gold-dipped zippers with pull cords\n• Ergonomic raglan sleeve construction with gold piping\n• Hidden zipped storm pockets\n• Limited run of 100 numbered pieces worldwide','Specialist dry clean only.','Athletic tailored cut. Size up for relaxed streetwear drape.',380000.00,420000.00,3,3,1,1,1,'active','https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(6,'FORTUNES NIGERIA IS REAL HAUTE OVERSIZED HOODIE','fortunes-nigeria-is-real-haute-oversized-hoodie','FC-HOD-006','TOPS / STATEMENTS','480 GSM French Terry hoodie with drop shoulders, double-layer crossover hood, and high-density gold screen typography.','Our bold statement piece celebrating contemporary African creative resurgence. Dense 480 GSM diagonal loopback French Terry that holds an imposing, sculptural silhouette. No drawstrings for a clean, minimalist neckline.','• 480 GSM Organic Cotton French Terry\n• Heavy 2x2 ribbed cuffs and hem\n• High-density gold puff print statement on back\n• Clean seamless front kangaroo pocket\n• Preshrunk for lifetime structural retention','Machine wash cold inside-out. Air dry only.','Intentionally oversized. Order true to size for signature drape.',265000.00,295000.00,1,1,0,1,1,'active','https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(7,'FORTUNES TACTICAL CARGO COMBAT TROUSERS','fortunes-tactical-cargo-combat-trousers','FC-CRG-007','BOTTOMS / UTILITY','Heavyweight ripstop trousers with modular zip-off pockets, adjustable ankle bungee toggles, and gold D-ring clips.','Military-inspired tactical design recalibrated for high luxury. Engineered from durable cotton ripstop with water-resistant coating. Features 8 anatomical utility compartments and custom gold anodized aluminum clip fasteners.','• 100% High-tensile Cotton Ripstop\n• Anodized gold aircraft-grade hardware\n• Bungee cinching at hem for tapered or flared styling\n• Articulated knees for effortless mobility\n• Made in Effurun','Machine wash cold. Do not tumble dry.','Elasticated waistband with internal drawcord. Size M fits waist 31-33.',245000.00,NULL,2,3,0,0,0,'active','https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL),
(8,'FORTUNES GOLD EMBROIDERED MAISON KIMONO','fortunes-gold-embroidered-maison-kimono','FC-KIM-008','OUTERWEAR / HAUTE','Structured raw linen and silk kimono coat featuring artisanal gold bullion embroidery depicting Nigerian architectural heritage.','The pinnacle of the Fortunes Atelier. A fusion of traditional African drapery and Japanese ceremonial tailoring. Each piece requires 28 hours of precision gold thread needlework by master artisans in our Effurun atelier.','• 60% Raw Slub Linen, 40% Mulberry Silk\n• Intricate gold metallic bullion embroidery\n• Open front with self-fabric wrap sash\n• Dual internal jet pockets\n• Hand-finished limited production','Specialist museum-grade dry clean only.','Free size (O/S) designed to drape elegantly on sizes S through XXL.',340000.00,390000.00,3,1,1,1,0,'active','https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000&auto=format&fit=crop',0,'2026-09-15 14:32:34','2026-09-15 14:32:34',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_requests`
--

DROP TABLE IF EXISTS `refund_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `admin_response` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refund_requests_order_id_foreign` (`order_id`),
  KEY `refund_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `refund_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refund_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_requests`
--

LOCK TABLES `refund_requests` WRITE;
/*!40000 ALTER TABLE `refund_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `title` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `is_verified_purchase` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES
(1,1,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,1,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(3,2,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(4,2,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(5,3,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(6,3,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(7,4,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(8,4,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(9,5,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(10,5,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(11,6,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(12,6,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(13,7,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(14,7,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(15,8,1,'Korede Adeleke','korede@example.com',5,'Unbelievable quality and presence','The weight and gold hardware on this piece completely rival Milanese fashion houses. Proud to see Fortunes elevating Nigerian luxury.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(16,8,NULL,'Chioma N.',NULL,5,'Couture perfection','Arrived in Lekki within 4 hours in the bespoke gold magnetic presentation box. The fit is phenomenal.',1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_methods`
--

DROP TABLE IF EXISTS `shipping_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipping_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost_per_kg` decimal(12,2) NOT NULL DEFAULT 0.00,
  `free_shipping_min_amount` decimal(12,2) DEFAULT NULL,
  `estimated_delivery_days` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipping_methods_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_methods`
--

LOCK TABLES `shipping_methods` WRITE;
/*!40000 ALTER TABLE `shipping_methods` DISABLE KEYS */;
INSERT INTO `shipping_methods` VALUES
(1,'Effurun White-Glove VIP Courier','effurun_vip','Direct hand-delivery within PTI Road, Effurun & Warri metropolis.',0.00,0.00,0.00,'Same Day (2 - 4 hours)',1,1,'2026-09-15 14:32:35','2026-09-15 14:32:35'),
(2,'Delta State Priority Dispatch','delta_express','Dedicated insured logistics across Asaba, Sapele, Ughelli & Delta State.',4500.00,500.00,150000.00,'24 Hours',1,2,'2026-09-15 14:32:35','2026-09-15 14:32:35'),
(3,'Lagos & Abuja Executive Express','lagos_abuja_express','Overnight priority courier to Lagos Island, Victoria Island, Ikoyi & Abuja FCT.',7500.00,1000.00,300000.00,'1 - 2 Business Days',1,3,'2026-09-15 14:32:35','2026-09-15 14:32:35'),
(4,'DHL Worldwide Express (International)','dhl_intl','Global door-to-door courier tracking across United Kingdom, US, Canada & Europe.',42000.00,5000.00,1000000.00,'3 - 5 Business Days',1,4,'2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `shipping_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`),
  KEY `site_settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES
(1,'announcement_ticker','MADE IN NIGERIA FOR THE WORLD ⬝ MAISON FORTUNES EFFURUN OPEN ⬝ COMPLIMENTARY EFFURUN SAME-DAY DISPATCH ⬝ ARCHIVE 2026','header','2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'hero_title','FORTUNES COLLECTION','hero','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(3,'hero_subtitle','WHERE PASSION MEETS FASHION','hero','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(4,'maison_address','PLOT 12, PTI ROAD, EFFURUN, DELTA STATE','maison','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(5,'maison_status','CURRENT STATUS: ARCHIVE 03 PRODUCTION','maison','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(6,'customer_service_phone','+234 1 888 3490','general','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(7,'customer_service_email','concierge@fortunes.ng','general','2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES
(1,'Bespoke Tailoring','bespoke-tailoring','style','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(2,'Archive 2026','archive-2026','collection','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(3,'Raw Silk','raw-silk','material','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(4,'Limited Edition','limited-edition','badge','2026-09-15 14:32:35','2026-09-15 14:32:35'),
(5,'Delta Heritage','delta-heritage','featured','2026-09-15 14:32:35','2026-09-15 14:32:35');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author_name` varchar(255) NOT NULL,
  `author_title` varchar(255) DEFAULT NULL,
  `quote` text NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES
(1,'Burna B.','Artist & Global Cultural Icon','Fortunes Collection is redefining what African luxury looks like on the world stage. Uncompromising swagger and craft.','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',5,1,1,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'Genevieve E.','Haute Couture Collector, London / Effurun','The tailoring in their Effurun Maison is second to none. The gold accents feel royal without being loud. Pure elegance.','https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400&auto=format&fit=crop',5,2,1,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Korede Adeleke','korede@example.com','+2348023456789','customer','2026-09-15 14:32:34','$2y$12$8X4iYURAwM5RBjVjzYOtB.klspcGt8gb92XWQ/Fzur0TJrsdaxDe2',NULL,'2026-09-15 14:32:34','2026-09-15 14:32:34'),
(2,'Fortunes Director','admin@fortunes.ng','+2348000000000','admin','2026-09-15 14:32:34','$2y$12$ZJTv5/CCojWroa2G5/fuNe4MOuEfSTbIyDDetsny47VCFjjGBQjEu',NULL,'2026-09-15 14:32:34','2026-09-15 14:32:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist_items`
--

DROP TABLE IF EXISTS `wishlist_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wishlist_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlist_items_wishlist_id_product_id_unique` (`wishlist_id`,`product_id`),
  KEY `wishlist_items_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_items_wishlist_id_foreign` FOREIGN KEY (`wishlist_id`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_items`
--

LOCK TABLES `wishlist_items` WRITE;
/*!40000 ALTER TABLE `wishlist_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_session_id_index` (`session_id`),
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-09-14 23:48:34
