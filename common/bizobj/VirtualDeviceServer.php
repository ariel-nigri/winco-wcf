<?php

class VirtualDeviceServer extends SqlToClass {
    // DB vars
    var     $vds_seq;
    var     $vds_name;
    var     $inst_seq;
    var     $vds_active;

    // LOCAL VARS
    var     $avd_dir;
    var     $sdk_dir;

    function __construct() {
        $this->addTable('virt_device_server');
        $this->addColumn('vds_seq',     'vds_seq', 'vds_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('vds_name',    'vds_name', 'vds_name', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('inst_seq',    'inst_seq', 'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('vds_active',  'vds_active', 'vds_active', BZC_BOOLEAN);
        $this->addColumn('vds_maxdevs', 'vds_maxdevs', 'vd_s_max', BZC_INTEGER);
    }

    public function list_devices($sql) {
        // list the devices in the db and match them to the directories
        return [];
    }

    public function create_device($inst_seq, $phone_number) {
        // insert into db but do not create the files.
    }

    public function activate() {
        
    }
}
