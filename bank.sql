-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: bank
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

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
-- Table structure for table `accounts`
--

create database if not EXISTS bank;
use bank;

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `balance` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `transaction_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (5,1,10.00,'2026-03-27 07:14:47',0),(6,2,0.00,'2026-03-27 12:18:04',0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type` enum('Credit','Debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (5,2,3500.00,'Credit','Salary Deposit','2026-03-22 12:18:46'),(6,2,150.00,'Debit','ATM Withdrawal - Downtown Branch','2026-03-24 12:18:46'),(7,2,85.50,'Debit','Grocery Store - FreshMart','2026-03-26 12:18:46'),(8,2,1200.00,'Credit','Freelance Payment - Web Design Project','2026-03-27 00:18:46'),(9,2,45.00,'Debit','Coffee Shop - Morning Brew','2026-03-27 10:20:22'),(10,2,12.99,'Debit','Streaming Service - Monthly Subscription','2026-03-27 06:20:22'),(11,2,250.00,'Debit','Electric Bill - March','2026-03-23 12:20:22'),(12,2,89.99,'Debit','Online Shopping - Electronics','2026-03-25 12:20:22'),(13,2,35.00,'Debit','Gas Station - Shell','2026-03-26 12:20:22'),(14,2,78.50,'Debit','Restaurant - Dinner with friends','2026-03-26 18:20:22'),(15,2,500.00,'Credit','Transfer from Savings Account','2026-03-21 12:20:22'),(16,2,75.00,'Credit','Cashback Reward - Credit Card','2026-03-25 12:20:22'),(17,2,1200.00,'Debit','Rent Payment - March','2026-03-17 12:20:22'),(18,2,65.00,'Debit','Internet Service Provider','2026-03-19 12:20:22'),(19,2,55.00,'Debit','Mobile Phone Bill','2026-03-20 12:20:22'),(20,2,45.00,'Debit','Ride Share - Airport Trip','2026-03-22 12:20:22'),(21,2,15.00,'Debit','Public Transit - Monthly Pass Reload','2026-03-24 12:20:22'),(22,2,60.00,'Debit','Movie Theater - IMAX Tickets','2026-03-18 12:20:22'),(23,2,120.00,'Debit','Gym Membership - Monthly','2026-03-16 12:20:22'),(24,2,200.00,'Debit','Bookstore - Technical Books','2026-03-13 12:20:22'),(25,2,150.00,'Debit','Pharmacy - Prescription','2026-03-14 12:20:22'),(26,2,80.00,'Debit','Dental Checkup - Co-pay','2026-03-12 12:20:22'),(27,2,3000.00,'Credit','Tax Refund - IRS','2026-03-07 12:20:22'),(28,2,500.00,'Debit','Charity Donation - United Way','2026-03-11 12:20:22'),(29,2,850.00,'Debit','Flight Booking - AirFrance AF0234','2026-03-02 12:41:51'),(30,2,420.00,'Debit','Hotel Reservation - Paris 4 nights','2026-03-03 12:41:51'),(31,2,1200.00,'Debit','Travel Insurance - Annual Premium','2026-02-25 12:41:51'),(32,2,95.00,'Debit','Currency Exchange - EUR 800','2026-03-05 12:41:51'),(33,2,65.00,'Debit','Luggage - Carry-on upgrade','2026-03-06 12:41:51'),(34,2,45.00,'Debit','Travel Adapter & SIM Card','2026-03-07 12:41:51'),(35,2,78.00,'Debit','Bistro Le Petit - Dinner Paris','2026-03-19 12:41:51'),(36,2,24.50,'Debit','Museum Entry - Louvre','2026-03-19 12:41:51'),(37,2,35.00,'Debit','Metro Day Pass - Paris','2026-03-20 12:41:51'),(38,2,120.00,'Debit','Souvenirs - Montmartre Art','2026-03-21 12:41:51'),(39,2,55.00,'Debit','Café de Flore - Breakfast','2026-03-21 12:41:51'),(40,2,1000.00,'Debit','Stock Purchase - VOO ETF','2026-02-27 12:41:51'),(41,2,250.00,'Debit','Crypto Purchase - BTC fractional','2026-02-28 12:41:51'),(42,2,45.75,'Credit','Dividend Payment - Q1 2026','2026-03-15 12:41:51'),(43,2,320.00,'Debit','Spring Garden Supplies - Nursery','2026-03-09 12:41:51'),(44,2,180.00,'Debit','Patio Furniture - Outdoor set','2026-03-10 12:41:51'),(45,2,95.00,'Debit','BBQ Grill - Home Depot','2026-03-11 12:41:51'),(46,2,299.00,'Debit','Online Course - AWS Certification','2026-03-08 12:41:51'),(47,2,150.00,'Debit','Conference Ticket - Tech Summit 2026','2026-03-04 12:41:51'),(48,2,200.00,'Debit','Vet Checkup - Annual Vaccines','2026-03-01 12:41:51'),(49,2,55.00,'Debit','Pet Supplies - Chewy.com','2026-03-23 12:41:51'),(50,2,175.00,'Debit','Car Repair - Brake Replacement','2026-02-26 12:41:51'),(51,2,60.00,'Credit','Sold item - Facebook Marketplace','2026-03-18 12:41:51'),(52,2,25.00,'Debit','Parking Ticket - City of Metropolis','2026-03-16 12:41:51'),(53,2,4200.00,'Credit','Bi-weekly Salary Deposit - Employer','2026-03-12 17:02:03'),(54,2,350.00,'Credit','Side Gig - Photography Session','2026-03-21 17:02:03'),(55,2,125.00,'Credit','Tax Refund - State Return','2026-03-06 17:02:03'),(56,2,500.00,'Credit','Birthday Gift - Transfer from Mom','2026-02-27 17:02:03'),(57,2,1450.00,'Debit','Rent Payment - April 2026','2026-03-13 17:02:03'),(58,2,95.00,'Debit','Electric Bill - Utility Company','2026-03-07 17:02:03'),(59,2,45.00,'Debit','Water/Sewer - City Services','2026-03-09 17:02:03'),(60,2,85.00,'Debit','Internet/Cable Bundle - Comcast','2026-03-15 17:02:03'),(61,2,156.00,'Debit','Grocery Run - Whole Foods Market','2026-03-14 17:02:03'),(62,2,89.50,'Debit','Restaurant - Sushi Palace Dinner','2026-03-19 17:02:03'),(63,2,24.00,'Debit','Coffee Shop - Starbucks x4','2026-03-17 17:02:03'),(64,2,65.00,'Debit','Pizza Delivery - Dominoes Weekend','2026-03-24 17:02:03'),(65,2,42.00,'Debit','Lunch - Sweetgreen Salad','2026-03-26 17:02:03'),(66,2,8.50,'Debit','Breakfast Bagel - Local Deli','2026-03-27 06:02:03'),(67,2,58.00,'Debit','Gas Station - Shell Fuel','2026-03-16 17:02:03'),(68,2,32.50,'Debit','Uber - Airport Drop-off','2026-03-25 17:02:03'),(69,2,15.00,'Debit','Parking Garage - Downtown','2026-03-23 17:02:03'),(70,2,240.00,'Debit','Car Insurance - Monthly Premium','2026-03-10 17:02:03'),(71,2,45.00,'Debit','Car Wash & Detailing','2026-03-01 17:02:03'),(72,2,129.00,'Debit','Amazon Purchase - Electronics','2026-03-18 17:02:03'),(73,2,85.00,'Debit','Clothing - Uniqlo','2026-03-08 17:02:03'),(74,2,250.00,'Debit','Target - Home Essentials & Groceries','2026-03-20 17:02:03'),(75,2,65.00,'Debit','Haircut & Styling - Salon','2026-03-03 17:02:03'),(76,2,50.00,'Debit','CVS Pharmacy - Prescription','2026-03-22 17:02:03'),(77,2,75.00,'Debit','Gym Membership - Monthly','2026-03-24 17:02:03'),(78,2,120.00,'Debit','Dentist - Cleaning Co-pay','2026-03-04 17:02:03'),(79,2,15.99,'Debit','Netflix Subscription - Monthly','2026-03-15 17:02:03'),(80,2,9.99,'Debit','Spotify Premium','2026-03-27 07:02:03'),(81,2,180.00,'Debit','Concert Tickets - Ticketmaster','2026-03-05 17:02:03'),(82,2,60.00,'Debit','Steam Games Purchase','2026-03-11 17:02:03'),(83,2,500.00,'Debit','Transfer to Savings Account','2026-03-20 17:02:03'),(84,2,200.00,'Debit','Investment Account - ETF Purchase','2026-02-28 17:02:03'),(85,2,75.00,'Debit','Pet Supplies - Chewy.com','2026-03-02 17:02:03'),(86,2,40.00,'Debit','ATM Withdrawal - Cash','2026-02-26 17:02:03');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`a`@`localhost`*/ /*!50003 TRIGGER `trg_after_insert_transaction` AFTER INSERT ON `transactions` FOR EACH ROW BEGIN
    INSERT INTO user_transaction_totals (user_id, total_amount, transaction_count)
    VALUES (NEW.user_id, NEW.amount, 1)
    ON DUPLICATE KEY UPDATE
        total_amount = total_amount + NEW.amount,
        transaction_count = transaction_count + 1,
        last_updated = CURRENT_TIMESTAMP;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`a`@`localhost`*/ /*!50003 TRIGGER `trg_after_update_transaction` AFTER UPDATE ON `transactions` FOR EACH ROW BEGIN
    
    IF OLD.user_id != NEW.user_id THEN
        
        UPDATE user_transaction_totals
        SET total_amount = total_amount - OLD.amount,
            transaction_count = transaction_count - 1,
            last_updated = CURRENT_TIMESTAMP
        WHERE user_id = OLD.user_id;
        
        
        INSERT INTO user_transaction_totals (user_id, total_amount, transaction_count)
        VALUES (NEW.user_id, NEW.amount, 1)
        ON DUPLICATE KEY UPDATE
            total_amount = total_amount + NEW.amount,
            transaction_count = transaction_count + 1,
            last_updated = CURRENT_TIMESTAMP;
    
    
    ELSEIF OLD.amount != NEW.amount THEN
        UPDATE user_transaction_totals
        SET total_amount = total_amount - OLD.amount + NEW.amount,
            last_updated = CURRENT_TIMESTAMP
        WHERE user_id = NEW.user_id;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`a`@`localhost`*/ /*!50003 TRIGGER `trg_after_delete_transaction` AFTER DELETE ON `transactions` FOR EACH ROW BEGIN
    UPDATE user_transaction_totals
    SET total_amount = total_amount - OLD.amount,
        transaction_count = transaction_count - 1,
        last_updated = CURRENT_TIMESTAMP
    WHERE user_id = OLD.user_id;
    
    
    DELETE FROM user_transaction_totals 
    WHERE user_id = OLD.user_id 
      AND total_amount = 0 
      AND transaction_count = 0;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user_transaction_totals`
--

DROP TABLE IF EXISTS `user_transaction_totals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_transaction_totals` (
  `user_id` int NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `transaction_count` int NOT NULL DEFAULT '0',
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_transaction_totals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_transaction_totals`
--

LOCK TABLES `user_transaction_totals` WRITE;
/*!40000 ALTER TABLE `user_transaction_totals` DISABLE KEYS */;
INSERT INTO `user_transaction_totals` VALUES (2,15322.73,58,'2026-03-27 17:02:03');
/*!40000 ALTER TABLE `user_transaction_totals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin1','$2y$10$UU7btalIZnfkMMWEMCqKWe7t3OEbMwT6fWTXu7/BmFDS/l.Iiw9b6','admin','2026-03-27 07:14:47'),(2,'user123','$2y$10$imFi3MipGqH/qGmq3E2noOfpWv40Xcw/nJTlT0qJKDZX3rGOZGo7C','user','2026-03-27 12:18:04');
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

-- Dump completed on 2026-03-27 18:19:36
