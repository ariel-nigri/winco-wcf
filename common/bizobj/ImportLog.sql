CREATE TABLE import_log (
    implog_seq               INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    inst_seq                 INTEGER NOT NULL,
    implog_import_date       TIMESTAMP NOT NULL,
    implog_dataset_name      VARCHAR(100) NOT NULL,
    implog_imported_chats    INTEGER NOT NULL,
    implog_imported_messages INTEGER NOT NULL,
    implog_network           VARCHAR(50) NOT NULL,
    FOREIGN KEY (inst_seq) REFERENCES instances (inst_seq)
) ENGINE=InnoDB;

CREATE INDEX il_inst_seq_idx ON import_log (inst_seq);

INSERT INTO import_log (inst_seq, implog_import_date, implog_dataset_name, implog_imported_chats, implog_imported_messages, implog_network) (SELECT inst_seq, from_unixtime(implog_import_date), implog_dataset_name, implog_imported_chats, implog_imported_messages, 'EIKON' FROM eikon_import_log);
