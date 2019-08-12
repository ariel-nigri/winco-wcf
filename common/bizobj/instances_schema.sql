-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: wtm01
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `instances`
--

DROP TABLE IF EXISTS `instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances` (
  `inst_seq` int(11) NOT NULL AUTO_INCREMENT,
  `inst_id` varchar(14) NOT NULL,
  `worker_seq` int(11) NOT NULL,
  `inst_email` varchar(256) NOT NULL,
  `inst_passwd` varchar(16) DEFAULT NULL,
  `inst_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `inst_adm_port` int(11) DEFAULT NULL,
  `inst_msn_port` int(11) DEFAULT NULL,
  `inst_pol_port` int(11) DEFAULT NULL,
  `inst_active` tinyint(1) DEFAULT '0',
  `inst_name` varchar(256) DEFAULT NULL,
  `inst_cnpj` varchar(20) NOT NULL,
  `inst_phone` varchar(30) DEFAULT NULL,
  `inst_type` varchar(200) DEFAULT NULL,
  `inst_license` varchar(35) DEFAULT NULL,
  `inst_nusers` int(11) DEFAULT '5',
  `inst_passwd_digest` varchar(100) DEFAULT NULL,
  `inst_lang` varchar(5) DEFAULT 'br',
  PRIMARY KEY (`inst_seq`),
  UNIQUE KEY `inst_id` (`inst_id`),
  UNIQUE KEY `inst_email` (`inst_email`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `usu_seq` int(11) NOT NULL AUTO_INCREMENT,
  `usu_email` varchar(256) NOT NULL,
  `usu_name` varchar(256) NOT NULL,
  `usu_passwd_digest` varchar(100) NOT NULL,
  `usu_language` varchar(20) DEFAULT NULL,
  `usu_twofact_type` varchar(100) DEFAULT NULL,
  `usu_twofact_token`varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usu_seq`),
  UNIQUE KEY `usu_email` (`usu_email`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `users_instances`
--

DROP TABLE IF EXISTS `users_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_instances` (
  `usuinst_seq` int(11) NOT NULL AUTO_INCREMENT,
  `usu_seq` int(11) NOT NULL,
  `inst_seq` int(11) NOT NULL,
  `usuinst_privs` varchar(20) DEFAULT NULL,
  `usuinst_privs_groups` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`usuinst_seq`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `workers`
--

DROP TABLE IF EXISTS `workers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workers` (
  `worker_seq` int(11) NOT NULL AUTO_INCREMENT,
  `worker_hostname` varchar(256) NOT NULL,
  `worker_frontend` varchar(256) NOT NULL,
  `worker_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `worker_last_boot` timestamp NULL DEFAULT NULL,
  `worker_ip` varchar(16) DEFAULT NULL,
  `worker_old_ip` varchar(16) DEFAULT NULL,
  `worker_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`worker_seq`),
  UNIQUE KEY `worker_hostname` (`worker_hostname`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `instances_status`
--

DROP TABLE IF EXISTS `instances_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances_status` (
  `inststatus_seq` int(11) NOT NULL AUTO_INCREMENT,
  `inst_seq` int(11) NOT NULL,
  `inst_status` varchar(16) NOT NULL,
  `inst_last_change` timestamp NOT NULL,
  PRIMARY KEY (`inststatus_seq`),
  UNIQUE KEY `inst_seq` (`inst_seq`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `instances_history`
--

DROP TABLE IF EXISTS `instances_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances_history` (
  `insthist_seq` int(11) NOT NULL AUTO_INCREMENT,
  `inst_seq` int(11) NOT NULL,
  `inst_status` varchar(16) NOT NULL,
  `inst_last_change` timestamp NOT NULL,
  PRIMARY KEY (`insthist_seq`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-29  9:44:20
