<?php

class NTP_RouterLicenses extends SqlToClass {

    public function __construct() {
        $this->addTable('router_licenses');
        $this->addColumn('router_licenses.rtlic_seq', 'rtlic_seq', BZC_INTEGER | BZC_TABLEKEY);
        $this->addColumn('router_licenses.rtlic_id', 'rtlic_id', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('router_licenses.inst_seq', 'inst_seq', BZC_INTEGER);
        $this->addColumn('router_licenses.rtlic_created', 'rtlic_created', BZC_DATE);
        $this->addColumn('router_licenses.rtlic_allocated', 'rtlic_allocated', BZC_DATE);
        $this->addColumn('router_licenses.rtlic_owner', 'rtlic_owner', BZC_STRING);
		$this->addColumn('router_licenses.rtlic_caps', 'rtlic_caps', BZC_STRING);
		$this->addColumn('router_licenses.rtlic_expires', 'rtlic_expires', BZC_DATE);
    }
};
