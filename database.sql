-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: tax_service
-- ------------------------------------------------------
-- Server version	8.0.33-0ubuntu0.20.04.2

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
-- Table structure for table `tax_bands`
--

DROP TABLE IF EXISTS `tax_bands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_bands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `band_name` varchar(50) NOT NULL,
  `lower_limit` decimal(10,2) NOT NULL,
  `upper_limit` decimal(10,2) DEFAULT NULL,
  `tax_rate` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_bands`
--

LOCK TABLES `tax_bands` WRITE;
/*!40000 ALTER TABLE `tax_bands` DISABLE KEYS */;
INSERT INTO `tax_bands` VALUES (1,'A',0.00,5000.00,0.00),(2,'B',5000.00,20000.00,20.00),(3,'C',20000.00,NULL,40.00);
/*!40000 ALTER TABLE `tax_bands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tax_calculations`
--

DROP TABLE IF EXISTS `tax_calculations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tax_calculations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `gross_annual_salary` decimal(10,2) NOT NULL,
  `gross_monthly_salary` decimal(10,2) NOT NULL,
  `net_annual_salary` decimal(10,2) NOT NULL,
  `net_monthly_salary` decimal(10,2) NOT NULL,
  `annual_tax_paid` decimal(10,2) NOT NULL,
  `monthly_tax_paid` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tax_calculations`
--

LOCK TABLES `tax_calculations` WRITE;
/*!40000 ALTER TABLE `tax_calculations` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_calculations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-15 22:35:42
