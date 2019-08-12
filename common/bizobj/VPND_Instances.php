<?php

require_once "Instances.php";

class VPND_Instances extends Instances {
    var $inst_expiration;

    public function __construct() {
        parent::__construct();

        $this->addColumn('instances.inst_service_port', 'inst_service_port', BZC_INTEGER);
        $this->addColumn('instances.inst_expiration', 'inst_expiration', BZC_DATE);
    }

    // This function is called after a new instance is created in the database. At this time we can
    // fill info that is pertinent to the database.
    function onCreateInstance($instance, $sql) {
        $instance->inst_service_port = $instance->inst_adm_port + 1;
        return true; // this means that we have changed something. otherwise we should return false.
    }

    public function start() {
        if (!isset($this->inst_seq))
            die("Before starting an instance, please set the inst_seq paramenter");
        system("nohup sudo /etc/init.d/vpnd-{$this->inst_seq} start > /dev/null 2>&1 < /dev/null");
    }
    public function stop() {
        if (!isset($this->inst_seq))
            die("Before starting an instance, please set the inst_seq paramenter");
        system("nohup sudo /etc/init.d/vpnd-{$this->inst_seq} stop > /dev/null 2>&1 < /dev/null");
    }

    public function init_directory() {
        if (empty($this->inst_version) || empty($this->inst_seq)) {
            die("Before calling create_files(), please set the inst_seq and inst_version paramenters");
            return false;
        }
        $output = array();
        exec("cd /home/instances/versions/{$this->inst_version}/util; sudo ./create_instance.sh {$this->inst_seq}", $output);
        // FIXME: parse outptu for errors.
        return true;
    }
}
