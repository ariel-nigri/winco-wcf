<?php

class ImportLog extends SqlToClass {
    var $implog_seq;
    var $implog_network;
    var $implog_dataset_name;

    public function __construct() {
        $this->addTable('import_log');
        
        $this->addColumn('import_log.implog_seq', 'implog_seq', BZC_INTEGER | BZC_TABLEKEY);
        $this->addColumn('import_log.inst_seq', 'inst_seq', BZC_INTEGER);
        $this->addColumn('import_log.implog_import_date', 'implog_import_date', BZC_STRING);
        $this->addColumn('import_log.implog_dataset_name', 'implog_dataset_name', BZC_STRING);
        $this->addColumn('import_log.implog_imported_chats', 'implog_imported_chats', BZC_INTEGER);
        $this->addColumn('import_log.implog_imported_messages', 'implog_imported_messages', BZC_INTEGER);
        $this->addColumn('import_log.implog_network', 'implog_network', BZC_STRING);

        $this->setOrder('-implog_dataset_name', '-implog_import_date');
    }

    public static function getNetworkName($network) {
        $networks = array(
            'EIKON' => 'Eikon Messenger',
            'SfB' => 'Skype For Business'
        );
		$n = strtok($network, ':');
		$netname = isset($networks[$n]) ? $networks[$n] : $n;
		$loc = strtok('');
		if ($loc)
			$netname .= " ({$loc})";
		return $netname;
    }
}
