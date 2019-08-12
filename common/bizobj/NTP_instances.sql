USE mysql;

/*
	DROP USER 'netp01'@'%';
	DROP TABLE netp01.instances;
	DROP DATABASE netp01;
*/

-- CREATE DATABASE netp01;

USE netp01;

CREATE USER 'netp01'@'localhost' IDENTIFIED BY 'Vp2WvDseoPYzUTsh';
CREATE USER 'netp01'@'%' IDENTIFIED BY 'Vp2WvDseoPYzUTsh';

CREATE TABLE workers (
	worker_seq		 INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	worker_hostname	 VARCHAR(256) NOT NULL UNIQUE,
    worker_frontend  VARCHAR(256) NOT NULL,
    worker_created   TIMESTAMP DEFAULT NOW(),
    worker_last_boot TIMESTAMP,
	worker_ip		 VARCHAR(16),
	worker_old_ip	 VARCHAR(16),
    worker_active	 BOOLEAN DEFAULT 0
) TYPE=innodb;

CREATE TABLE instances (
    inst_seq       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    inst_id        VARCHAR(14) NOT NULL UNIQUE,
    worker_seq     INT NOT NULL REFERENCES workers,
    inst_created   TIMESTAMP DEFAULT NOW(),
    inst_adm_port  INT,
    inst_sync_port INT,
    inst_active    BOOLEAN DEFAULT 0,
    inst_type      VARCHAR(1) DEFAULT 'A',
    inst_license   VARCHAR(35),
    inst_nusers    INT DEFAULT 5,
    inst_passwd_digest VARCHAR(100),
    inst_lang      VARCHAR(5)
) TYPE=innodb;

CREATE TABLE router_licenses (
    rtlic_seq         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    rtlic_id          VARCHAR(14) NOT NULL UNIQUE,
    inst_seq          INT DEFAULT 0 REFERENCES instances,
    rtlic_created     TIMESTAMP DEFAULT NOW(),
    rtlic_allocated   TIMESTAMP DEFAULT 0
) TYPE=innodb;

GRANT SELECT, INSERT, DELETE, UPDATE ON netp01.* TO 'netp01'@'%';
GRANT SELECT, INSERT, DELETE, UPDATE ON netp01.* TO 'netp01'@'localhost';

flush privileges;
