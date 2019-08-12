USE mysql;

/*
	DROP USER 'wcm'@'%';
	DROP TABLE wtm01.instances;
	DROP DATABASE wtm01;
*/

-- CREATE DATABASE wtm02;

USE wtm02;

CREATE USER 'wcm02'@'localhost' IDENTIFIED BY 'QAULN/mBW';
CREATE USER 'wcm02'@'%' IDENTIFIED BY 'QAULN/mBW';

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
    inst_seq      INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    inst_id       VARCHAR(14) NOT NULL UNIQUE,
    worker_seq    INT NOT NULL REFERENCES workers,
    inst_email    VARCHAR(256) NOT NULL UNIQUE,
    inst_passwd   VARCHAR(16),
    inst_created  TIMESTAMP DEFAULT NOW(),
    inst_adm_port INT,
    inst_msn_port INT,
    inst_pol_port INT,
    inst_active   BOOLEAN DEFAULT 0,
    inst_name     VARCHAR(256),
    inst_cnpj     VARCHAR(20) NOT NULL,
    inst_phone    VARCHAR(30),
    inst_type     VARCHAR(1),
    inst_license  VARCHAR(35),
    inst_nusers   INT DEFAULT 5,
    inst_passwd_digest VARCHAR(100),
    inst_lang     VARCHAR(5)
) TYPE=innodb;

CREATE TABLE users (
    usu_seq             INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usu_email           VARCHAR(256) NOT NULL UNIQUE,
    usu_name            VARCHAR(256) NOT NULL,
    usu_passwd_digest   VARCHAR(100) NOT NULL,
    usu_language        VARCHAR(20),
	usu_twofact_type	VARCHAR(100),
	usu_twofact_token	VARCHAR(100)
);

CREATE TABLE users_instances (
    usu_seq             INT NOT NULL REFERENCES users,
    inst_seq            INT NOT NULL REFERENCES instances,
    usuinst_privs        VARCHAR(20),
	usuinst_privs_groups VARCHAR(100), 
);

CREATE TABLE instances_status (
  inststatus_seq 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  inst_seq 			INT NOT NULL REFERENCES instances,
  inst_status 		VARCHAR(16) NOT NULL,
  inst_last_change 	TIMESTAMP NOT NULL
);

CREATE TABLE instances_history (
  insthist_seq 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  inst_seq 			INT NOT NULL REFERENCES instances,
  inst_status 		VARCHAR(16) NOT NULL,
  inst_last_change 	TIMESTAMP NOT NULL
);

CREATE TABLE auth_events (
	ae_seq          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ae_user         VARCHAR(256) NOT NULL,
	ae_event        VARCHAR(2) NOT NULL,
	ae_datetime     DATETIME NOT NULL
);


GRANT SELECT, INSERT, DELETE, UPDATE ON wtm02.* TO 'wcm02'@'%';
GRANT SELECT, INSERT, DELETE, UPDATE ON wtm02.* TO 'wcm02'@'localhost';

flush privileges;
