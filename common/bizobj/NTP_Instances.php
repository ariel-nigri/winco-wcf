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

    public function init_directory() {
        if (empty($this->inst_version) || empty($this->inst_seq)) {
            die("Before calling create_files(), please set the inst_seq and inst_version paramenters");
            return false;
        }
        $output = array();
        exec("cd /home/instances/versions/{$this->inst_version}/util; sudo ./create_instance.sh {$this->inst_seq}", $output);

        // must find 2 OK in the output.
        $n = 0;
        foreach ($output as $l) {
            if (trim($l) == 'OK')
                ++$n;
        }
        if ($n != 2) {
            $this->error = implode(': ', $output);
            return false;
        }
        return true;
    }

    public function remove_directory() {
        if (empty($this->inst_version) || empty($this->inst_seq)) {
            die("Before calling create_files(), please set the inst_seq and inst_version paramenters");
            return false;
        }
        $output = array();
        exec("cd /home/instances/versions/{$this->inst_version}/util; sudo ./delete_instance.sh {$this->inst_seq}", $output);
        if (!empty($output))
            return false;
        // FIXME: parse output for errors.
        return true;
    }
};
