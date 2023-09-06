<?php

class ExpiringInstances extends SqlToClass {
	var $inst_seq;
	var $exp_warn_count;
	var $exp_warn_date;

	function __construct() {
		$this->addTable('expiring_instances');
		$this->addColumn('inst_seq', 		'inst_seq', BZC_INTEGER | BZC_NOTNULL | BZC_TABLEKEY);
		$this->addColumn('exp_warn_date', 	'exp_warn_date', BZC_DATE | BZC_NOTNULL);
		$this->addColumn('exp_warn_count', 	'exp_warn_count', BZC_INTEGER | BZC_NOTNULL);
	}
}
