--
-- Worker
--
CREATE TABLE workers (
    worker_seq               INTEGER AUTO_INCREMENT PRIMARY KEY,
    worker_hostname          VARCHAR(256) NOT NULL,
    worker_frontend          VARCHAR(256) NOT NULL,
    worker_created           TIMESTAMP NOT NULL DEFAULT current_timestamp,
    worker_last_boot         TIMESTAMP,
    worker_ip                VARCHAR(16) NOT NULL,
    worker_active            BOOLEAN NOT NULL default 0
);

--
-- Name: instances; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE instances (
    inst_seq                    INTEGER auto_increment PRIMARY KEY,
    inst_id                     VARCHAR(14) NOT NULL,
    worker_seq                  INTEGER NOT NULL REFERENCES worker,
    inst_created                TIMESTAMP NOT NULL DEFAULT current_timestamp,
    inst_adm_port               INTEGER NOT NULL,
    inst_active                 boolean DEFAULT 0,
    inst_type                   VARCHAR(200),
    inst_license                VARCHAR(35),
    inst_nusers                 INTEGER DEFAULT 5,
    inst_lang                   VARCHAR(5),
    inst_name                   VARCHAR(200) NOT NULL,
    inst_version                VARCHAR(200),
    inst_num_of_passwd_to_store INTEGER,
    inst_max_pwd_age            INTEGER,
    inst_pol_port               INTEGER,
    inst_cnpj                   VARCHAR(200),
    inst_phone                  VARCHAR(200)
);

--
-- Name: users; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE users (
    usu_seq                    INTEGER AUTO_INCREMENT PRIMARY KEY,
    usu_email                  VARCHAR(256) NOT NULL,
    usu_name                   VARCHAR(256) NOT NULL,
    usu_passwd_digest          VARCHAR(100) NOT NULL,
    usu_language               VARCHAR(20),
    usu_twofact_type           VARCHAR(100),
    usu_twofact_token          VARCHAR(100),
    usu_updated_passwd_at      TIMESTAMP NOT NULL DEFAULT current_timestamp,
    usu_num_of_passwd_to_store INTEGER,
    usu_max_pwd_age            INTEGER,
    usu_pwd_history            VARCHAR(1000),
    usu_caps                   VARCHAR(200)
);
--
-- Name: users_instances; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE users_instances (
    usuinst_seq          INTEGER AUTO_INCREMENT PRIMARY KEY,
    usu_seq              INTEGER NOT NULL REFERENCES users,
    inst_seq             INTEGER NOT NULL REFERENCES instances,
    usuinst_privs        VARCHAR(20),
    usuinst_privs_groups VARCHAR(100)
);
--
-- Name: auth_events;
--
CREATE TABLE auth_events(
    ae_seq         INTEGER AUTO_INCREMENT PRIMARY KEY,
    usu_seq        INTEGER NOT NULL REFERENCES users,
    ae_event       VARCHAR(2) NOT NULL,
    ae_datetime    DATETIME NOT NULL,
    ae_reason      VARCHAR(100)
);
--
-- Name: virt_device_server; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE virt_device_server (
    vds_seq       INTEGER AUTO_INCREMENT PRIMARY KEY,
    vds_name      VARCHAR(200) NOT NULL UNIQUE,
    inst_seq      INTEGER REFERENCES instances,
    vds_active    BOOLEAN NOT NULL DEFAULT 0,
    vds_maxdevs   INTEGER NOT NULL DEFAULT 0
);
--
-- Name: virt_device; Type: TABLE; Schema: public; Owner: wtm; Tablespace: 
--
CREATE TABLE virt_device (
    vd_seq        INTEGER AUTO_INCREMENT PRIMARY KEY,
    vds_seq       INTEGER NOT NULL REFERENCES virt_device_server,
    inst_seq      INTEGER NOT NULL REFERENCES instances,
    vd_owner      VARCHAR(200) NOT NULL,
    vd_number     VARCHAR(100) NOT NULL UNIQUE,
    vd_key        VARCHAR(100) NOT NULL,
    vd_status     INTEGER NOT NULL DEFAULT 1,
    vd_wtype      VARCHAR(20) NOT NULL,
    vd_activated  TIMESTAMP NULL
);

--
-- Name: import_log (for Eikon and s4b)
--
CREATE TABLE import_log (
    implog_seq               INTEGER AUTO_INCREMENT PRIMARY KEY,
    inst_seq                 INTEGER NOT NULL REFERENCES instances,
    implog_import_date       TIMESTAMP NOT NULL,
    implog_dataset_name      VARCHAR(100) NOT NULL,
    implog_imported_chats    INTEGER NOT NULL,
    implog_imported_messages INTEGER NOT NULL,
    implog_network           VARCHAR(50) NOT NULL
);

CREATE INDEX il_inst_seq_idx ON import_log (inst_seq);

--
-- Name eikon_instances (for Eikon import configuration per instance)
--
CREATE TABLE eikon_instances (
    inst_seq                INTEGER PRIMARY KEY REFERENCES instances,
    eikon_active            BOOLEAN DEFAULT 0,
    eikon_server            VARCHAR(256),
    eikon_user              VARCHAR(256),
    eikon_passwd            VARCHAR(256),
    eikon_company_id        VARCHAR(256)
);
