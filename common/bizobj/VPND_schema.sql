-- CREATE DATABASE connectas;
-- USE connectas;

--
-- Table structure for table `auth_events`
--
DROP TABLE IF EXISTS `auth_events`;
CREATE TABLE `auth_events` (
  `ae_seq` int NOT NULL AUTO_INCREMENT,
  `usu_seq` int NOT NULL,
  `ae_event` varchar(2) NOT NULL,
  `ae_datetime` datetime NOT NULL,
  `ae_reason` text,
  PRIMARY KEY (`ae_seq`)
);

--
-- Table structure for table `expiring_instances`
--
DROP TABLE IF EXISTS `expiring_instances`;
CREATE TABLE `expiring_instances` (
  `inst_seq` int NOT NULL AUTO_INCREMENT,
  `exp_warn_date` date NOT NULL,
  `exp_warn_count` int NOT NULL,
  PRIMARY KEY (`inst_seq`)
);

--
-- Table structure for table `instances`
--
DROP TABLE IF EXISTS `instances`;
CREATE TABLE `instances` (
  `inst_seq` int NOT NULL AUTO_INCREMENT,
  `inst_id` varchar(14) NOT NULL,
  `worker_seq` int NOT NULL,
  `inst_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `inst_adm_port` int DEFAULT NULL,
  `inst_service_port` int DEFAULT NULL,
  `inst_active` tinyint(1) DEFAULT '0',
  `inst_type` varchar(100) DEFAULT NULL,
  `inst_license` varchar(35) DEFAULT NULL,
  `inst_nusers` int DEFAULT '5',
  `inst_passwd_digest` varchar(100) DEFAULT NULL,
  `inst_lang` varchar(5) DEFAULT NULL,
  `inst_name` varchar(100) DEFAULT NULL,
  `inst_version` varchar(20) DEFAULT NULL,
  `inst_expiration` date DEFAULT NULL,
  `inst_payprovider` varchar(200) DEFAULT NULL,
  `inst_payplan` varchar(100) DEFAULT NULL,
  `inst_paysbs_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`inst_seq`),
  UNIQUE KEY `inst_id` (`inst_id`),
  UNIQUE KEY `inst_paysbs_id` (`inst_paysbs_id`)
)
AUTO_INCREMENT=1000;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `usu_seq` int NOT NULL AUTO_INCREMENT,
  `usu_email` varchar(256) NOT NULL,
  `usu_name` varchar(256) NOT NULL,
  `usu_passwd_digest` varchar(100) NOT NULL,
  `usu_language` varchar(20) DEFAULT NULL,
  `usu_twofact_type` varchar(100) DEFAULT NULL,
  `usu_twofact_token` varchar(100) DEFAULT NULL,
  `usu_updated_passwd_at` timestamp NULL DEFAULT NULL,
  `usu_pwd_history` varchar(200) DEFAULT NULL,
  `usu_num_of_passwd_to_store` int DEFAULT '0',
  `usu_max_pwd_age` int DEFAULT '0',
  `usu_caps` varchar(200) DEFAULT NULL,
  `usu_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`usu_seq`),
  UNIQUE KEY `usu_email` (`usu_email`)
);

--
-- Table structure for table `users_instances`
--
DROP TABLE IF EXISTS `users_instances`;
CREATE TABLE `users_instances` (
  `usuinst_seq` int NOT NULL AUTO_INCREMENT,
  `usu_seq` int NOT NULL,
  `inst_seq` int NOT NULL,
  `usuinst_privs` varchar(20) DEFAULT NULL,
  `usuinst_privs_groups` varchar(100) DEFAULT NULL,
  `usuinst_master` int DEFAULT '0',
  `usuinst_status` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`usuinst_seq`),
  UNIQUE KEY `usuinst_unique` (`usu_seq`,`inst_seq`)
);

--
-- Table structure for table `workers`
--
DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers` (
  `worker_seq` int NOT NULL AUTO_INCREMENT,
  `worker_hostname` varchar(256) NOT NULL,
  `worker_frontend` varchar(256) NOT NULL,
  `worker_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `worker_last_boot` timestamp NULL DEFAULT NULL,
  `worker_ip` varchar(16) DEFAULT NULL,
  `worker_old_ip` varchar(16) DEFAULT NULL,
  `worker_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`worker_seq`),
  UNIQUE KEY `worker_hostname` (`worker_hostname`)
);

-- CREATE USER 'connectas' IDENTIFIED BY 'devel';
-- GRANT SELECT, INSERT, DELETE, UPDATE ON connectas.* TO 'connectas';

-- FLUSH privileges;
