<?php

class Instances extends SqlToClass {
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
    
    function beforeSave($create) {
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
    function afterSave($create, $sql) {
        if ($create) {
            $classname = get_class($this);
            $inst = new $classname;
            $inst->inst_seq = $this->inst_seq;
            $inst->inst_adm_port = 10000 + (4 * $this->inst_seq);

            if (method_exists($this, 'onCreateInstance'))
                $this->onCreateInstance($inst, $sql);

            $inst->update($sql);
        }
        return true;
    }

    function getInstanceDir() {
        die('unimplemented');
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
}
