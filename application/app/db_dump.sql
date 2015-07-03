-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: screecher
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apis`
--

DROP TABLE IF EXISTS `apis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apis`
--

LOCK TABLES `apis` WRITE;
/*!40000 ALTER TABLE `apis` DISABLE KEYS */;
INSERT INTO `apis` VALUES (1,'AppleAPI'),(2,'PepperAPI'),(3,'PineappleAPI'),(4,'OnionAPI');
/*!40000 ALTER TABLE `apis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintainers`
--

DROP TABLE IF EXISTS `maintainers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintainers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(95) DEFAULT NULL,
  `api_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `maintainers_api_fk_idx` (`api_id`),
  CONSTRAINT `maintainers_api_fk` FOREIGN KEY (`api_id`) REFERENCES `apis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintainers`
--

LOCK TABLES `maintainers` WRITE;
/*!40000 ALTER TABLE `maintainers` DISABLE KEYS */;
INSERT INTO `maintainers` VALUES (1,'joe.apples@mailinator.com',1),(2,'apples-are-great@mailinator.com',1),(3,'all-about-them-apples@mailinator.com',1),(4,'peter.peppers@mailinator.com',2),(5,'call-me-capsicum@mailinator.com',2),(6,'pining-for-apples@mailinator.com',3),(7,'onions-and-co@mailinator.com',4),(8,'steve.onion@mailinator.com',4);
/*!40000 ALTER TABLE `maintainers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-29 13:47:20
