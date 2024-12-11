-- MySQL dump 10.16  Distrib 10.1.48-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: censo
-- ------------------------------------------------------
-- Server version	10.1.48-MariaDB-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `censo_est`
--

DROP TABLE IF EXISTS `censo_est`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `censo_est` (
  `cest_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `leito` varchar(20) NOT NULL,
  `faa` varchar(10) DEFAULT NULL,
  `data_adm` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `nasc` date DEFAULT NULL,
  `comorbidade` varchar(100) DEFAULT NULL,
  `status_covid` varchar(20) DEFAULT NULL,
  `culturas` varchar(20) DEFAULT NULL,
  `hd_2` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `dieta` varchar(20) DEFAULT NULL,
  `srag` tinyint(1) DEFAULT '0',
  `swab` date DEFAULT NULL,
  `sorologia` date DEFAULT NULL,
  `o2` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cest_id`),
  KEY `os_key` (`o2`),
  CONSTRAINT `o2_key` FOREIGN KEY (`o2`) REFERENCES `no2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `censo_est`
--

LOCK TABLES `censo_est` WRITE;
/*!40000 ALTER TABLE `censo_est` DISABLE KEYS */;
INSERT INTO `censo_est` VALUES (1,'ESTAB-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1);
/*!40000 ALTER TABLE `censo_est` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`admin`@`localhost`*/ /*!50003 TRIGGER `at_datahora_est` BEFORE UPDATE ON `censo_est` FOR EACH ROW UPDATE enf_med SET datahora=now() WHERE id = 2 */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `censo_obs`
--

DROP TABLE IF EXISTS `censo_obs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `censo_obs` (
  `cobs_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `leito` varchar(20) NOT NULL,
  `faa` varchar(10) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `nasc` date DEFAULT NULL,
  `hd` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `dieta` varchar(20) DEFAULT NULL,
  `srag` tinyint(1) DEFAULT '0',
  `swab` date DEFAULT NULL,
  `soro` date DEFAULT NULL,
  `o2` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cobs_id`),
  KEY `os_key` (`o2`),
  CONSTRAINT `os_key` FOREIGN KEY (`o2`) REFERENCES `no2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `censo_obs`
--

LOCK TABLES `censo_obs` WRITE;
/*!40000 ALTER TABLE `censo_obs` DISABLE KEYS */;
INSERT INTO `censo_obs` VALUES (1,'ENF1-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,1);
/*!40000 ALTER TABLE `censo_obs` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`admin`@`localhost`*/ /*!50003 TRIGGER `at_datahora_obs` BEFORE UPDATE ON `censo_obs` FOR EACH ROW UPDATE enf_med SET datahora=now() WHERE id = 1 */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `color_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `exp` varchar(100) NOT NULL,
  `rgb` varchar(10) NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'^INTERNAD.*|^ENF1.*','#ffd84d'),(2,'^TRANS.*','#cb4fde'),(3,'^REAVAL.*','#d18762'),(4,'^NEGATIVO$|^CN$|^COVID-$|ALTA|^ENF2.*','#6987f2'),(5,'^MNR$|EXAMES|^ENF3.*|.*\\?','#48db70'),(6,'^POSITIVO$|^VM$|.EMG$|CROSS|COVID\\+','#ef2525'),(7,'^ESTAB.*','#ffbf75');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enf_med`
--

DROP TABLE IF EXISTS `enf_med`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enf_med` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `datahora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `n_enf` varchar(100) DEFAULT NULL,
  `n_med` varchar(100) DEFAULT NULL,
  `editor` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enf_med`
--

LOCK TABLES `enf_med` WRITE;
/*!40000 ALTER TABLE `enf_med` DISABLE KEYS */;
INSERT INTO `enf_med` VALUES (1,'2021-08-23 13:16:17','Creusa Maria','Jacinto Leite',3),(2,'2021-08-21 18:09:10','Sirlene Silva','Notório Paulo',1);
/*!40000 ALTER TABLE `enf_med` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitations` (
  `invitation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `invitation_key` varchar(255) NOT NULL,
  PRIMARY KEY (`invitation_id`),
  UNIQUE KEY `unique_index` (`email`,`invitation_key`),
  KEY `invited` (`user_id`),
  CONSTRAINT `invited` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitations`
--

LOCK TABLES `invitations` WRITE;
/*!40000 ALTER TABLE `invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `no2`
--

DROP TABLE IF EXISTS `no2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `no2` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `o2` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `o2` (`o2`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `no2`
--

LOCK TABLES `no2` WRITE;
/*!40000 ALTER TABLE `no2` DISABLE KEYS */;
INSERT INTO `no2` VALUES (1,NULL),(2,'AA'),(3,'CN'),(4,'MNR'),(5,'VM');
/*!40000 ALTER TABLE `no2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invited_by` int(10) unsigned DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isadmin` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,0,'admin','$2y$10$LINYtve1F9dD9ROUcvHBtOvvwzAyIaKIgGOFV3WJq20xeQYVWl98u','076c838bd016b22bd1cf0315b952433c','dantavares@gmail.com',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'censo'
--
/*!50003 DROP FUNCTION IF EXISTS `idade` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`censo`@`localhost` FUNCTION `idade`(`dob` DATE) RETURNS varchar(10) CHARSET utf8mb4
    NO SQL
BEGIN
	DECLARE age float;
    
    SET age = TIMESTAMPDIFF(YEAR, dob, CURDATE());
	    
    IF age = 0 THEN
    	SET age = TIMESTAMPDIFF(MONTH, dob, CURDATE());
    	RETURN CONCAT(age, " M");
    ELSE
    	RETURN CONCAT(age, " A");
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-20 10:29:24
