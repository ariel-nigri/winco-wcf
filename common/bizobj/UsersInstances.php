<?php

/**
 * Object-relational mapping class for users_instances table. Any property not defined here
 * must be checked in the users table and Users.php source file.
 * 
 * @property integer $usuinst_seq           Primary key. Mainly for delete/update
 * @property integer $usuinst_privs         Access privileges for this user in this instance. 'A' meas ALL.
 * @property string  $usuinst_status        Status of this user in respect to this instance
 * @property integer $inst_seq              Foreign key from instances table
 * @property integer $usu_seq               Foreign key from users table
 * @property string  $usu_status            Status of the user (global status)
 * @property integer $usu_max_pwd_age       Number of days before the password must be changed
 * @property integer $usu_updated_passwd_at Last time this users's password was changed
 */
class UsersInstances extends SqlToClass {
    const ST_INVITED   = 'I';
    const ST_BLOCKED   = 'B';
    const ST_VALID     = 'V';
    const ST_DECLINED  = 'D';
    const ST_ALREADY   = 'Z'; // used only as a return of 'invite'
    const ST_ERROR     = 'E'; // used only as a return of 'invite'
    const ST_UNAVAIL   = 'U'; // used only as a return of 'invite'

    var $usuinst_seq;
    var $usuinst_privs;
    var $usuinst_status;
    var $inst_seq;
    var $usu_seq;
    var $usu_name;
    var $usu_email;
    var $usu_status;
    var $usu_max_pwd_age;
    var $usu_updated_passwd_at;

    protected $usu_passwd_digest;

    public function __construct() {
        $this->addTable('users_instances');
        $this->addTable('users', 'usu_seq');
		$this->addColumn('users_instances.usuinst_seq', 'usuinst_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('users_instances.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('users_instances.inst_seq', 'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('users_instances.usuinst_privs', 'usuinst_privs', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('users_instances.usuinst_privs_groups', 'usuinst_privs_groups', BZC_STRING);
        $this->addColumn('users_instances.usuinst_status', 'usuinst_status', BZC_STRING);
        
    	if ($GLOBALS['product_code'] == 'WTM')
	    	$this->addColumn('users_instances.usuinst_master', 'usuinst_master', BZC_INTEGER);

        $this->addColumn('users.usu_seq', 'usu_seq', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_email', 'usu_email', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_name', 'usu_name', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_language', 'usu_language', BZC_STRING | BZC_READONLY);
		$this->addColumn('users.usu_twofact_type', 'usu_twofact_type', BZC_STRING | BZC_READONLY);
		$this->addColumn('users.usu_passwd_digest', 'usu_passwd_digest', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_twofact_token', 'usu_twofact_token', BZC_STRING | BZC_READONLY);
        $this->addColumn('users.usu_updated_passwd_at', 'usu_updated_passwd_at', BZC_TIMESTAMP | BZC_READONLY);
        $this->addColumn('users.usu_max_pwd_age', 'usu_max_pwd_age', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_num_of_passwd_to_store', 'usu_num_of_passwd_to_store', BZC_INTEGER | BZC_READONLY);
        $this->addColumn('users.usu_status', 'usu_status', BZC_STRING | BZC_READONLY);                                                     /** acct blocked, pwd expired, or both*/
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

    public function validatePassword($pass) {
        return Users::comparePassword($pass, $this->usu_passwd_digest);
    }

    public function isBlocked($db = null) {
        // the user may be blocked locally or globally.
        if ($this->usuinst_status == self::ST_BLOCKED)
            return true;

        $user = new Users;
        $user->usu_seq                  = $this->usu_seq;
        $user->usu_status               = $this->usu_status;
        $user->usu_max_pwd_age          = $this->usu_max_pwd_age;
        $user->usu_updated_passwd_at    = $this->usu_updated_passwd_at;
        return $user->isBlocked($db);
    }

    public function isExpired($db) {
        return strchr($this->usu_status, Users::ST_EXPIRED_PASS);
    }

    public function invite($db, $inst_seq, $usu_email, $usuinst_privs = '', $usu_lang = 'br') {
        $this->clear();
        $ret = self::ST_ERROR;
        try {
            $user = Users::find($db, [ 'usu_email' => $usu_email ]);
            if ($user->valid)
                // for now we cannot duplicate e-mails.
                return self::ST_UNAVAIL;

            if ($user->valid) {
                if ($user->isBlocked()) {
                    $ret = self::ST_BLOCKED;
                    throw new Exception("This use is blocked and cannot be added to your instance");
                }

                // make sure it is not a duplicate user for us.
                $test = self::find($db, [ 'inst_seq' => $inst_seq, 'usu_seq' => $user->usu_seq ]);
                if ($test->valid) {
                    $ret = self::ST_ALREADY;
                    throw new Exception("This user is already registerred to you instance");
                }
            }
            else {
                // create a new user that is invited, in the invited mode.
                $user->usu_email    = $usu_email;
                $user->usu_name     = ucwords(strtr(strtok($usu_email, '@'), '.', ' '));
                $user->usu_language = $usu_lang;
                $user->usu_twofact_type = 'GOGLE';
                $user->usu_status   = Users::ST_INVITED;
                if (!$user->insert($db))
                    throw new Exception("Cannot invite user: ".$user->error);
            }

            // All ready for the user's insertion to our instance
            $this->usu_seq  = $user->usu_seq;
            $this->inst_seq = $inst_seq;
            $this->usuinst_privs = $usuinst_privs;
            $this->usuinst_status = self::ST_INVITED;
            if (!$this->insert($db))
                throw new Exception("Error associating user to our instance: ".$this->error);

            // we will fill the fields upon exit
            $this->usu_email = $user->usu_email;
            $this->usu_name  = $user->usu_name;
        }

        catch(Exception $e) {
            $this->error = $e->getMessage();
            return $ret;
        }

        // NOTE: do not forget to send an invite message to the user.
        return self::ST_INVITED;
    }

    public function accept($db, $usu_name = null, $usu_language = null) {
        $shadow = $this->getShadow($db);
        $user = new Users;
        $user->usu_seq                  = $shadow->usu_seq;
        $user->usu_status               = $shadow->usu_status;
        $user->usu_max_pwd_age          = $shadow->usu_max_pwd_age;
        $user->usu_updated_passwd_at    = $shadow->usu_updated_passwd_at;

        if ($user->isBlocked($db) || $shadow->usu_status != self::ST_INVITED) {
            $this->error = "This user cannot be accepted at this time";
            return false;
        }

        if ($shadow->usu_status == self::ST_INVITED) {
            // accept the user now.
            $user->usu_status   = Users::ST_VALID;
            $user->usu_name     = $usu_name;
            $user->usu_language = $usu_language;
            if ($user->update($db)) {
                $this->error = $user->error;
                return false;
            }
        }
        $this->usuinst_status = self::ST_VALID;
        return $this->update($db);
    }

    public function decline($db) {
        $shadow = $this->getShadow($db);
        if ($shadow->usu_status == Users::ST_INVITED) {
            $user = new Users;
            $user->usu_seq    = $this->usu_seq;
            $user->usu_status = Users::ST_DECLINED;
        }
        $this->usuinst_status = self::ST_DECLINED;
        return $this->update($db);
    }

    public function block($db) {
        $this->usuinst_status = self::ST_BLOCKED;
        return $this->update($db);
    }

    public function unblock($db) {
        $this->usuinst_status = self::ST_VALID;
        return $this->update($db);
    }
}
