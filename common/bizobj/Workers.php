<?php

class Workers extends SqlToClass {
    public function __construct() {
        $this->addTable('workers');
        $this->addColumn('workers.worker_seq', 'worker_seq', BZC_INTEGER | BZC_TABLEKEY);
        $this->addColumn('workers.worker_hostname', 'worker_hostname', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('workers.worker_frontend', 'worker_frontend', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('workers.worker_created', 'worker_created', BZC_TIMESTAMP);
        $this->addColumn('workers.worker_last_boot', 'worker_last_boot', BZC_TIMESTAMP);
        $this->addColumn('workers.worker_ip', 'worker_ip', BZC_STRING);
        $this->addColumn('workers.worker_active', 'worker_active', BZC_BOOLEAN);
	}
};
