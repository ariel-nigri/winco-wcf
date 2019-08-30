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
}
