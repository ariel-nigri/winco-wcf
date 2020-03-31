<?php

class InstancesHistory extends SqlToClass {
    public function __construct() {
        $this->addTable('instances_history');
		$this->addColumn('instances_history.insthist_seq', 'insthist_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('instances_history.inst_seq', 'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('instances_history.inst_status', 'inst_status', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('instances_history.inst_last_change', 'inst_last_change', BZC_DATE | BZC_NOTNULL);
    }
}
