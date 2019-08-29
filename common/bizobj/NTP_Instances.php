<?php

require_once "Instances.php";

class NTP_Instances extends Instances {
    public function __construct() {
        parent::__construct();

        $this->addColumn('instances.inst_sync_port', 'inst_sync_port', BZC_INTEGER);
    }
    // This function is called after a new instance is created in the database. At this time we can
    // fill info that is pertinent to the database.
    function onCreateInstance($instance, $sql) {
        $instance->inst_sync_port = $instance->inst_adm_port + 1;
        return true; // this means that we have changed something. otherwise we should return false.
    }

    public function start() {
        if (!isset($this->inst_seq))
            die("Before starting an instance, please set the inst_seq paramenter");
        exec("nohup sudo /etc/init.d/ntp-{$this->inst_seq} start > /dev/null 2>&1 < /dev/null", $output);
        return true;
    }
    public function stop() {
        if (!isset($this->inst_seq))
            die("Before starting an instance, please set the inst_seq paramenter");
        system("nohup sudo /etc/init.d/ntp-{$this->inst_seq} stop > /dev/null 2>&1 < /dev/null");
    }
};
