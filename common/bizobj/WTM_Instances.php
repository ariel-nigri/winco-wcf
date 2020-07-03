<?php
require_once "Instances.php";

class WTM_Instances extends Instances {
    public function __construct() {
        parent::__construct();
		
        global $usr_passwd_salt;
        if (empty($usr_passwd_salt))
            die('ERROR: Global $usr_passwd_salt not defined');

        $this->addColumn('instances.inst_pol_port', 'inst_pol_port', BZC_INTEGER);
        $this->addColumn('instances.inst_cnpj', 'inst_cnpj', BZC_STRING);
        $this->addColumn('instances.inst_phone', 'inst_phone', BZC_STRING);
        $this->addColumn('instances.inst_nusers', 'inst_nusers', BZC_INTEGER);

        $this->addColumn('instances.inst_num_of_passwd_to_store', 'inst_num_of_passwd_to_store', BZC_INTEGER);
        $this->addColumn('instances.inst_max_pwd_age', 'inst_max_pwd_age', BZC_INTEGER);

	}
    // This function is called after a new instance is created in the database. At this time we can
    // fill info that is pertinent to the database.
    function onCreateInstance($instance, $sql) {
        if (empty($this->inst_nusers))
            // if there was no nusers set, set it now.
            $instance->inst_nusers = 10;
        $instance->inst_pol_port = $instance->inst_adm_port - 1;
        return true; // this means that we have changed something. otherwise we should return false.
    }
};
