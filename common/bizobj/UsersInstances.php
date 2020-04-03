<?php

/**
 * Undocumented class
 * 
 * @property integer $usu_max_pwd_age Number of days that password should be changed
 * @property integer $usu_num_of_passwd_to_store Remember X last used passwords to remember
 * @property string $usu_pwd_history Last X used password will be saved here. 
 */
class UsersInstances extends SqlToClass {
    public function __construct() {
        $this->addTable('users_instances');
        $this->addTable('users', 'usu_seq');
		$this->addColumn('users_instances.usuinst_seq', 'usuinst_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('users_instances.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('users_instances.inst_seq', 'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('users_instances.usuinst_privs', 'usuinst_privs', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('users_instances.usuinst_privs_groups', 'usuinst_privs_groups', BZC_STRING);
        
    	if ($GLOBALS['product_code'] == 'WTM')
	    	$this->addColumn('users_instances.usuinst_master', 'usuinst_master', BZC_INTEGER);

        $this->addColumn('users.usu_seq', 'usu_seq', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_email', 'usu_email', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_name', 'usu_name', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_passwd_digest', 'usu_passwd_digest', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_language', 'usu_language', BZC_STRING | BZC_READONLY);
		$this->addColumn('users.usu_twofact_type', 'usu_twofact_type', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_twofact_token', 'usu_twofact_token', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_updated_passwd_at', 'usu_updated_passwd_at', BZC_TIMESTAMP | BZC_READONLY);
        $this->addColumn('users.usu_max_pwd_age', 'usu_max_pwd_age', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_num_of_passwd_to_store', 'usu_num_of_passwd_to_store', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_pwd_history', 'usu_pwd_history', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_status', 'usu_status', BZC_STRING);                                     /** acct blocked, pwd expired, or both*/
    }

    public static function getUsersByInstance($sql) {
        $resp_array = array();
        $qr = $sql->exec("SELECT * FROM users_instances");
        if (!empty($qr)) {
            while($qr->fetch())
                $resp_array[$qr->value('usu_seq')][] = $qr->value('inst_seq');
        }
        return $resp_array;
    }

    public function isBlocked() {
        $c = strchr($this->usu_status, 'B');
        return !empty($c);
    }
}
