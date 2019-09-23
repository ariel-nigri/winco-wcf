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
    public function validatePassword($pass) {
        global $usr_passwd_salt;

		  if (!empty($this->inst_passwd) && $this->inst_passwd == $pass)
            return true;
        $digest = md5($usr_passwd_salt.$pass);
        return $digest == $this->inst_passwd_digest;
    }
    public function setPassword($pass) {
        global $usr_passwd_salt;

        $this->inst_passwd_digest = md5($usr_passwd_salt.$pass);
        $this->inst_passwd = ''; // cannot be null or will not update!
    }
};
