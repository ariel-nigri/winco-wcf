<?php

class InstancesStatus extends SqlToClass {
    public function __construct() {
        $this->addTable('instances_status');
		$this->addColumn('instances_status.inststatus_seq', 'inststatus_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('instances_status.inst_seq', 'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('instances_status.inst_status', 'inst_status', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('instances_status.inst_last_change', 'inst_last_change', BZC_DATE | BZC_NOTNULL);
    }
}
