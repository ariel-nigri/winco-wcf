<?php

class EikonInstances extends SqlToClass {
	public function __construct() {
		$this->addTable('eikon_instances');
		$this->addColumn('eikon_instances.inst_seq', 'inst_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('eikon_instances.eikon_active', 'eikon_active', BZC_BOOLEAN);
		$this->addColumn('eikon_instances.eikon_server', 'eikon_server', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('eikon_instances.eikon_user', 'eikon_user', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('eikon_instances.eikon_passwd', 'eikon_passwd', BZC_STRING | BZC_NOTNULL);       
		$this->addColumn('eikon_instances.eikon_company_id', 'eikon_company_id', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('eikon_instances.eikon_location', 'eikon_location', BZC_STRING);
		$this->eikon_active = true;
	}
}
