USE mysql;

/*
	DROP USER 'netp01'@'%';
	DROP TABLE netp01.instances;
	DROP DATABASE netp01;
*/

-- CREATE DATABASE netp01;

USE vpnd;

CREATE USER 'vpnd'@'localhost' IDENTIFIED BY 'teste';
CREATE USER 'vpnd'@'%' IDENTIFIED BY 'teste';

-- SENHA DE PRODUCAO 7Ixllkaf98

CREATE TABLE workers (
	worker_seq		 INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	worker_hostname	 VARCHAR(256) NOT NULL UNIQUE,
    worker_frontend  VARCHAR(256) NOT NULL,
    worker_created   TIMESTAMP DEFAULT NOW(),
    worker_last_boot TIMESTAMP,
	worker_ip		 VARCHAR(16),
	worker_old_ip	 VARCHAR(16),
    worker_active	 BOOLEAN DEFAULT 0
);


CREATE TABLE instances (
    inst_seq       	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    inst_id        	VARCHAR(14) NOT NULL UNIQUE,
    worker_seq     	INT NOT NULL REFERENCES workers,
    inst_created   	TIMESTAMP DEFAULT NOW(),
    inst_adm_port  	INT,
    inst_service_port INT,
    inst_active    	BOOLEAN DEFAULT 0,
    inst_type      	VARCHAR(1) DEFAULT 'A',
    inst_license   	VARCHAR(35),
    inst_nusers    	INT DEFAULT 5,
    inst_passwd_digest VARCHAR(100),
    inst_lang      	VARCHAR(5),
	inst_name       VARCHAR(100),
    inst_payprovider VARCHAR(200),  -- The payment provider. can be PAYPAL or SISVENDAS.
//    inst_payplan    VARCHAR(100),   -- The payment plan chosen in the provider. useful to know how much is being charged.
    inst_paysbs_id  VARCHAR(100) UNIQUE,    -- The payment subscription. Only valid when in a monthly subscription, otherwise is null.
);
ALTER TABLE instances AUTO_INCREMENT = 1000;

CREATE TABLE users (
    usu_seq             INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usu_email           VARCHAR(256) NOT NULL UNIQUE,
    usu_name            VARCHAR(256) NOT NULL,
    usu_passwd_digest   VARCHAR(100) NOT NULL,
    usu_language        VARCHAR(20),
	usu_twofact_type    VARCHAR(100),
	usu_twofact_token   VARCHAR(100),
	usu_updated_passwd_at TIMESTAMP
);

CREATE TABLE users_instances (
	usuinst_seq         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usu_seq             INT NOT NULL REFERENCES users,
    inst_seq            INT NOT NULL REFERENCES instances,
    usuinst_privs        VARCHAR(20),
	usuinst_privs_groups VARCHAR(100)
);

GRANT SELECT, INSERT, DELETE, UPDATE ON vpnd.* TO 'vpnd'@'%';
GRANT SELECT, INSERT, DELETE, UPDATE ON vpnd.* TO 'vpnd'@'localhost';

flush privileges;
