-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for Win64 (AMD64)
--
-- Host: 192.168.0.220    Database: lunibo
-- ------------------------------------------------------
-- Server version	10.5.15-MariaDB-0+deb11u1

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
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`customerID`),
  UNIQUE KEY `customers_customerID_uindex` (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Jane','jane.doe@gmail.com','0676 812 82 53'),(2,'Barbara Goble','BarbaraDGoble@cuvox.de','0676 740 57 42'),(3,'Michael Frei','MichaelFrei@cuvox.de','0660 894 15 72'),(4,'Marcel Gruenwald','MarcelGruenewald@einrot.com','0650 780 13 13'),(5,'Doreen Roth','DoreenRoth@cuvox.de','0650 432 89 56'),(6,'Peter Theissen','PeterTheissen@cuvox.de','0664 748 32 64');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `free_tables`
--

DROP TABLE IF EXISTS `free_tables`;
/*!50001 DROP VIEW IF EXISTS `free_tables`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `free_tables` (
  `tableID` tinyint NOT NULL,
  `maxPeople` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `itemGroup` varchar(15) DEFAULT NULL,
  `price` float NOT NULL,
  `kcal` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT 0,
  PRIMARY KEY (`itemID`),
  UNIQUE KEY `menu_itemID_uindex` (`itemID`),
  UNIQUE KEY `menu_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Esterhàzy-Rostbraten','mit Wurzelgemüse und Kapern in Rahmsauce, dazu servieren wir breite Nudeln','food',14.99,631,0),(2,'Kaiserschnitzel','in Kapern-Zitronensauce, dazu servieren wir Reis','food',14.99,722,0),(4,'Coca Cola','0.35l','drink',2.99,533,0),(5,'Helles vom Fass','0,50l ','drink',4.19,221,0),(6,'Tafelspitzcocktail','mit Kernöl und Zwiebel','food',16.22,920,0),(8,'Dunkles','0.50l','drink',4.15,533,0),(9,'Radler','0.30l','drink',3.33,123,0),(12,'Alt-Wiener Backfleisch','verfeinert mit Kren und in der Pfanne goldbraun gebacken, dazu servieren wir Bratkartoffeln','food',12.22,335,0),(13,'Almdudler','0.35l','drink',2.19,219,0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `resID` int(11) NOT NULL AUTO_INCREMENT,
  `reservationDatetime` datetime NOT NULL,
  `numOfPeople` int(11) NOT NULL,
  `tableID` int(11) DEFAULT NULL,
  `customerID` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`resID`),
  UNIQUE KEY `reservations_resID_uindex` (`resID`),
  KEY `reservations_tables_tableID_fk` (`tableID`),
  KEY `reservations_customers_customerID_fk` (`customerID`),
  CONSTRAINT `reservations_customers_customerID_fk` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reservations_tables_tableID_fk` FOREIGN KEY (`tableID`) REFERENCES `tables` (`tableID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (3,'2022-06-25 19:06:26',2,2,4,0),(4,'2022-06-25 20:07:12',4,7,2,0),(5,'2022-06-25 16:07:47',2,4,3,0),(6,'2022-03-28 16:07:59',4,6,1,0),(7,'2022-02-03 12:40:00',3,7,5,0),(8,'2022-05-25 16:07:51',6,12,6,0);
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `tableID` int(11) NOT NULL AUTO_INCREMENT,
  `maxPeople` int(11) NOT NULL,
  PRIMARY KEY (`tableID`),
  UNIQUE KEY `Tables_tableID_uindex` (`tableID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,2),(2,2),(3,2),(4,2),(5,4),(6,4),(7,4),(8,4),(9,4),(10,6),(11,6),(12,6),(13,6),(14,8),(15,8),(16,8),(17,10),(18,10);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `users_email_uindex` (`email`),
  UNIQUE KEY `users_userID_uindex` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'bogdan','caleta ivkovic','bogdan.caleta@gmail.com','5f4dcc3b5aa765d61d8327deb882cf99',0),(2,'nikola','panic','n.panic@gmx.at','5f4dcc3b5aa765d61d8327deb882cf99',0),(3,'lukas','zankel','zankel.l88@htlwienwest.at','5f4dcc3b5aa765d61d8327deb882cf99',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `free_tables`
--

/*!50001 DROP TABLE IF EXISTS `free_tables`*/;
/*!50001 DROP VIEW IF EXISTS `free_tables`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`pi`@`192.168.%.%` SQL SECURITY DEFINER */
/*!50001 VIEW `free_tables` AS select `tables`.`tableID` AS `tableID`,`tables`.`maxPeople` AS `maxPeople` from `tables` where !(`tables`.`tableID` in (select `reservations`.`tableID` from `reservations` where `reservations`.`deleted` = 0 and `reservations`.`reservationDatetime` < current_timestamp())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-27 13:44:33
