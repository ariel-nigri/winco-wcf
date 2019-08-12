<?php

/*
	$import_log = new EikonImportLog;
	$import_log->inst_seq = $inst_seq;
	$import_log->implog_import_date = time();
	$import_log->implog_dataset_name = $data_set;
	$import_log->implog_imported_chats = $nchats;
	$import_log->implog_imported_messages = $nmessages;
*/

require_once 'ImportLog.php';

class EikonImportLog extends ImportLog {

	public function insert(&$sql) {
		$this->implog_import_date = date('Y-m-d H:i:s', $this->implog_import_date);
		$this->implog_network = 'EIKON';
		
		return parent::insert($sql);
	}

	public function afterFetch($sql) {

		$dt = new DateTime($this->implog_import_date);
		$this->implog_import_date = $dt->format('U');

	}
}

/*
require_once "class/class-sqltoclass.php";

	class EikonImportLog extends SqlToClass {
	public function __construct() {
		$this->addTable('eikon_import_log');
		$this->addColumn('eikon_import_log.implog_seq', 'implog_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('eikon_import_log.inst_seq', 'inst_seq', BZC_INTEGER);
		$this->addColumn('eikon_import_log.implog_import_date', 'implog_import_date', BZC_TIMESTAMP);
        $this->addColumn('eikon_import_log.implog_dataset_name', 'implog_dataset_name', BZC_STRING);
        $this->addColumn('eikon_import_log.implog_imported_chats', 'implog_imported_chats', BZC_INTEGER);
        $this->addColumn('eikon_import_log.implog_imported_messages', 'implog_imported_messages', BZC_INTEGER);
		$this->setOrder('-implog_dataset_name', '-implog_import_date');
	}
};
*/
?>
