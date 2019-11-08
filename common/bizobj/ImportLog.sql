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

