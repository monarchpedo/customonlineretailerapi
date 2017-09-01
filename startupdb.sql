-- MySQL dump 10.13  Distrib 5.7.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: startupdb
-- ------------------------------------------------------
-- Server version	5.7.19-log

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
-- Current Database: `startupdb`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `startupdb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `startupdb`;

--
-- Table structure for table `cartdata`
--

DROP TABLE IF EXISTS `cartdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cartdata` (
  `cartId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the cartdata',
  `userId` varchar(45) NOT NULL,
  `orderId` varchar(45) NOT NULL,
  `productId` int(11) NOT NULL,
  `merchantId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`cartId`),
  KEY `userId_index_cartdata` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the payment history of cartdata';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cartdata`
--

LOCK TABLES `cartdata` WRITE;
/*!40000 ALTER TABLE `cartdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `cartdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loginhistory`
--

DROP TABLE IF EXISTS `loginhistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginhistory` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is used to store the login history of user data',
  `userId` int(11) NOT NULL,
  `logoutDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId_index_loginhistory` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the login history of user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loginhistory`
--

LOCK TABLES `loginhistory` WRITE;
/*!40000 ALTER TABLE `loginhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `loginhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchantdata`
--

DROP TABLE IF EXISTS `merchantdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchantdata` (
  `merchantId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the merchantdata',
  `userId` int(11) NOT NULL,
  `merchantName` varchar(45) NOT NULL,
  `merchantDescription` varchar(45) DEFAULT '',
  `Latitude` varchar(45) NOT NULL,
  `Longitude` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL,
  `locality` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL,
  `pincode` varchar(45) NOT NULL,
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`merchantId`),
  KEY `userId_index_merchanttable` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the payment history of merchantdata';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchantdata`
--

LOCK TABLES `merchantdata` WRITE;
/*!40000 ALTER TABLE `merchantdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `merchantdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merchantorderdata`
--

DROP TABLE IF EXISTS `merchantorderdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merchantorderdata` (
  `merchantOrderId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the merchantorderdata',
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `merchantId` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `totalPrice` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `orderedDate` datetime NOT NULL,
  `delieveredDate` datetime DEFAULT NULL,
  PRIMARY KEY (`merchantOrderId`),
  KEY `userId_index_orderdata` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the orderdetail for merchantorderdata';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merchantorderdata`
--

LOCK TABLES `merchantorderdata` WRITE;
/*!40000 ALTER TABLE `merchantorderdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `merchantorderdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offerdata`
--

DROP TABLE IF EXISTS `offerdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offerdata` (
  `offerId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the merchantdata',
  `userId` int(11) NOT NULL,
  `merchantName` varchar(45) NOT NULL,
  `offerDescription` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `Latitude` varchar(45) NOT NULL,
  `Longitude` varchar(45) NOT NULL,
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`offerId`),
  KEY `userId_index_offertable` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the offer of merchant to customer';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offerdata`
--

LOCK TABLES `offerdata` WRITE;
/*!40000 ALTER TABLE `offerdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `offerdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `old_user_data`
--

DROP TABLE IF EXISTS `old_user_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `old_user_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is used to store the old information data of user so that avoid violation',
  `userId` int(11) NOT NULL,
  `email` varchar(45) DEFAULT '',
  `mobileNumber` varchar(45) DEFAULT '',
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId_index_olduserdata` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the payment history of old user data';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `old_user_data`
--

LOCK TABLES `old_user_data` WRITE;
/*!40000 ALTER TABLE `old_user_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `old_user_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderdata`
--

DROP TABLE IF EXISTS `orderdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderdata` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the orderdata',
  `userId` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `totalPrice` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `orderedDate` datetime NOT NULL,
  `delieveredDate` datetime NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `userId_index_orderdata` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the order of user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderdata`
--

LOCK TABLES `orderdata` WRITE;
/*!40000 ALTER TABLE `orderdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `orderdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentdata`
--

DROP TABLE IF EXISTS `paymentdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paymentdata` (
  `payId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the paymentdata',
  `userId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `merchantId` int(11) NOT NULL,
  `totalPrice` int(11) DEFAULT NULL,
  `paidDate` datetime NOT NULL,
  PRIMARY KEY (`payId`),
  KEY `userId_index_paymenttable` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the payment history of paymentdata';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentdata`
--

LOCK TABLES `paymentdata` WRITE;
/*!40000 ALTER TABLE `paymentdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `paymentdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productdata`
--

DROP TABLE IF EXISTS `productdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productdata` (
  `productId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the productdata',
  `productName` varchar(45) NOT NULL,
  `productDescription` varchar(45) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `merchantId` int(11) NOT NULL,
  `addedDate` datetime NOT NULL,
  PRIMARY KEY (`productId`),
  KEY `userId_index_producttable` (`merchantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is used to store the payment history of productdata';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productdata`
--

LOCK TABLES `productdata` WRITE;
/*!40000 ALTER TABLE `productdata` DISABLE KEYS */;
/*!40000 ALTER TABLE `productdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdetail`
--

DROP TABLE IF EXISTS `userdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdetail` (
  `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'it is auto increment to stored the userdetail ',
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `mobileNumber` varchar(45) NOT NULL,
  `createdDate` datetime NOT NULL,
  `modifiedDate` datetime NOT NULL,
  `userType` varchar(1) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `mobileNumber_UNIQUE` (`mobileNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='It is used to store the userdetail for userdetail';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdetail`
--

LOCK TABLES `userdetail` WRITE;
/*!40000 ALTER TABLE `userdetail` DISABLE KEYS */;
INSERT INTO `userdetail` VALUES (1,'raja bose','rbosemonarch@gmail.com','raja','8130523363','2017-08-16 18:32:42','2017-08-16 18:32:42','M'),(2,'raja bose','rbosemonarch1@gmail.com','raja','8130523364','2017-08-16 18:46:32','2017-08-16 18:46:32','M'),(3,'raja bose','rbosemonarch2@gmail.com','raja','8130523365','2017-08-16 18:47:44','2017-08-16 18:47:44','M');
/*!40000 ALTER TABLE `userdetail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-01 14:58:26
