<?php

class Instances extends SqlToClass {
    var $error;
    var $inst_seq;
    var $inst_id;
    var $inst_active;
    var $inst_type;
    var $inst_version;
    var $inst_name;
    var $inst_created;
    var $inst_num_of_passwd_to_store;
    var $inst_max_pwd_age;

    public function __construct() {
        $this->addTable('instances');
        $this->addTable('workers', 'worker_seq');
        $this->addColumn('instances.inst_seq', 'inst_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('instances.inst_id', 'inst_id', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('instances.worker_seq', 'worker_seq', BZC_INTEGER);
        $this->addColumn('instances.inst_created', 'inst_created', BZC_TIMESTAMP);
        $this->addColumn('instances.inst_adm_port', 'inst_adm_port', BZC_INTEGER);
        $this->addColumn('instances.inst_active', 'inst_active', BZC_BOOLEAN);
        $this->addColumn('instances.inst_name', 'inst_name', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('instances.inst_type', 'inst_type', BZC_STRING);
        $this->addColumn('instances.inst_license', 'inst_license', BZC_STRING);
        $this->addColumn('instances.inst_lang', 'inst_lang', BZC_STRING);
        $this->addColumn('instances.inst_version', 'inst_version', BZC_STRING);
		
        $this->addColumn('workers.worker_hostname', 'worker_hostname', BZC_STRING | BZC_READONLY);
        $this->addColumn('workers.worker_frontend', 'worker_frontend', BZC_STRING | BZC_READONLY);
        $this->addColumn('workers.worker_ip', 'worker_ip', BZC_STRING | BZC_READONLY);
		$this->inst_active = true;
    }
    
    protected function beforeSave($create, $sql) {
        if ($create) {
            if (empty($this->inst_id))
                $this->inst_id = substr(sprintf("%08X%08X", rand(), rand()), 1, 14);
        }
        else {
            // some datamembers cannot be changed. we should manage this here.
            unset($this->inst_id);
            unset($this->inst_created);
        }
        return true;
    }
    protected function afterSave($create, $sql) {
        if ($create) {
            $classname = get_class($this);
            $inst = new $classname;
            $inst->inst_seq = $this->inst_seq;
            $inst->inst_adm_port = 10000 + (4 * $this->inst_seq);

            $this->onCreateInstance($inst, $sql);

            if (!$inst->update($sql))
                die($inst->error);
        }
        return true;
    }

    function getInstanceDir() {
        die('unimplemented');
    }

    public function start() {
        $array = $this->control('start');
        return strpos(implode(' ', $array), 'is started') > 0;
    }

    public function stop() {
        $this->control('stop');
        return true;
    }

    public function status() {
        $array = $this->control('status');
        return strpos(implode(' ', $array), 'is started') > 0;
    }

    public function control($cmd) {
        global $product_code;

        if (!isset($this->inst_seq))
            die("Before calling '{$cmd}', please set the inst_seq parameter");

        $redir = ($cmd == 'start' ? '> /dev/null' : '' );
        $utils = dirname(dirname(__DIR__)).'/utils';
        $output = [];
        //exec("sudo product_code={$product_code} ${utils}/inst-ctl {$cmd} {$this->inst_seq} {$redir} 2>&1 < /dev/null", $output);
        exec("sudo /bin/systemctl $cmd wcf@{$this->inst_seq}", $output);
        return $output;
    }

    public function set_license($license) {
        global  $product_code;

        $utils = dirname(dirname(__DIR__)).'/utils';
        if (!isset($this->inst_seq))
            die("Before calling 'set_license()', please set the inst_seq parameter");
        $output = [];
        exec("sudo product_code={$product_code} ${utils}/inst-ctl license {$this->inst_seq} {$license} 2>&1 < /dev/null", $output);
        return $output;
    }

    public function init_directory($versions_dir = '/home/instances/versions') {
        if (empty($this->inst_version) || empty($this->inst_seq)) {
            die("Before calling create_files(), please set the inst_seq and inst_version paramenters");
            return false;
        }
        $output = array();
        exec("cd {$versions_dir}/{$this->inst_version}/util; sudo ./create_instance.sh {$this->inst_seq}", $output);

        // must find 2 OK in the output.
        $n = 0;
        foreach ($output as $l) {
            if (trim($l) == 'OK')
                ++$n;
        }
        if (!$n) {
            $this->error = implode(': ', $output);
            return false;
        }
        return true;
    }

    public function remove_directory($versions_dir = '/home/instances/versions') {
        if (empty($this->inst_version) || empty($this->inst_seq)) {
            die("Before calling create_files(), please set the inst_seq and inst_version paramenters");
            return false;
        }
        $output = array();
        exec("cd {$versions_dir}/{$this->inst_version}/util; sudo ./delete_instance.sh {$this->inst_seq}", $output);
        if (!empty($output))
            return false;
        // FIXME: parse output for errors.
        return true;
    }

    protected function onCreateInstance($dummy, $dummy2) { die('cannot call base function'); }
}
