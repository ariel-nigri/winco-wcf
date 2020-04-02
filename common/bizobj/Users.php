<?php

/**
 * Users Model 
 * 
 * @property int $usu_seq
 * @property string $usu_email
 * @property string $usu_language
 * @property string $usu_twofact_type
 * @property string $usu_twofact_token
 * @property int $usu_num_of_passwd_to_store Remember X last used passwords to remember
 * @property int $usu_max_pwd_age 
 */
class Users extends SqlToClass {
    var $usu_seq;
    var $usu_email;
    var $usu_name;
    var $usu_language;
    var $usu_twofact_type;
    var $usu_twofact_token;
    var $usu_updated_passwd_at;
    var $usu_num_of_passwd_to_store;
    var $usu_caps;

    private $usu_pwd_history;
    private $usu_passwd_digest;

    const PASSWORD_SEPARATOR = '#';

    static function comparePassword($pass, $pwd_digest) {
        global $usr_passwd_salt;
        $digest = md5($usr_passwd_salt . $pass);
        return $digest == $pwd_digest;
    }
    
    public function __construct() {
        global $usr_passwd_salt;
        if (empty($usr_passwd_salt))
            die('ERROR: Global $usr_passwd_salt not defined');

        $this->addTable('users');
        $this->addColumn('users.usu_seq', 'usu_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('users.usu_email', 'usu_email', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('users.usu_name', 'usu_name', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('users.usu_passwd_digest', 'usu_passwd_digest', BZC_STRING | BZC_NOTNULL);         /** Current user password */
        $this->addColumn('users.usu_language', 'usu_language', BZC_STRING);
		$this->addColumn('users.usu_twofact_type', 'usu_twofact_type', BZC_STRING);
        $this->addColumn('users.usu_twofact_token', 'usu_twofact_token', BZC_STRING);
        $this->addColumn('users.usu_updated_passwd_at', 'usu_updated_passwd_at', BZC_TIMESTAMP);
        $this->addColumn('users.usu_max_pwd_age', 'usu_max_pwd_age', BZC_INTEGER);                          /** Number of days that password should be changed. */
        $this->addColumn('users.usu_num_of_passwd_to_store', 'usu_num_of_passwd_to_store', BZC_INTEGER);    /** Remember X last used passwords to remember */
        $this->addColumn('users.usu_pwd_history', 'usu_pwd_history', BZC_STRING);                           /** Last X used password will be saved here.   */
        $this->addColumn('users.usu_caps', 'usu_caps', BZC_STRING);
        // $this->addColumn('users.usu_status', 'usu_status', BZC_STRING);                                     /** acct blocked, pwd expired, or both*/
	}
        
    public function validatePassword($pass) {
        return $this->comparePassword($pass, $this->usu_passwd_digest);
    }

    public function setPassword($pass) {
        global $usr_passwd_salt, $users_num_of_passwd_to_store;

        $digest_pass = md5($usr_passwd_salt.$pass);

        if (!$this->checkPasswordPolicy($pass, $digest_pass))
            return false;

        if (!isset($this->usu_num_of_passwd_to_store))
            $this->usu_num_of_passwd_to_store = $users_num_of_passwd_to_store;

        if ($this->usu_num_of_passwd_to_store > 0) {
            if (empty(!this->usu_pwd_history))
                $this->usu_pwd_history = $this->usu_passwd_digest;
            else {
                $plist = explode(self::PASSWORD_SEPARATOR, $this->usu_pwd_history);
                array_unshift($plist, $this->usu_passwd_digest);
                while(count($plist) > $this->usu_num_of_passwd_to_store)
                    array_pop($plist);
                $this->usu_pwd_history = implode(self::PASSWORD_SEPARATOR, $plist);
            }
        }
        $this->usu_passwd_digest = $digest_pass;
        $this->usu_updated_passwd_at = date("Y-m-d H:i:s");
        return true;
    }

    public function isBlocked($db = null) {
        return strchr($this->usu_status, 'B');
    }

    public function block($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if ($shadow->isBlocked($db))
            return true;

        return $this->updateStatus($shadow->usu_status . 'B', AuthEvents::BLOCK_LOGIN_EVENT, $this->usu_seq, $reason);
    }

    public function unblock($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if (!$shadow->isBlocked($db))
            return true;

        return $this->updateStatus(str_replace($shadow->status, 'B', ''), AuthEvents::USER_UNBLOCKED_EVENT, $this->usu_seq, $reason);
    }

    public function expirePassword($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if (strchr($shadow->usu_status, 'X'))
            return true;

        return $this->updateStatus($shadow->status . 'X', AuthEvents::CHANGE_PASSWD_NEXT_LOGIN, $this->usu_seq, $reason);
    }

    private function updateStatus($db, $newstatus, $auth_event, $reason) {
        $usu2 = new Users;
        $usu2->usu_seq = $this->usu_seq;
        $usu2->usu_status = $newstatus;
        if ($usu2->update($db)) {
            AuthEvents::registerEvent($db, $auth_event, $usu2->usu_seq, $reason);
            return true;
        }
        return false;
    }

    public function checkPasswordPolicy($pass, $digest_pass) {
        global $users_pwd_complexity_regex;

        if (!preg_match($users_pwd_complexity_regex, $pass)) {
            $this->error = 'A senha inválida. A senha deve ter pelo menos 6 caracteres, sendo pelo menos uma letra maiúscula, uma letra minúscula e um número';
            return false;
        }

        if (strstr($digest_pass, $this->usu_pwd_history) !== false) {
            $this->error = 'A senha deve ser diferente das últimas '. $this->usu_num_of_passwd_to_store .' senhas';
            return false;
        }

        return true;
    }

    protected function beforeSave($insert, $sql) {
        if ($insert)
            return true;

        $ret = false;
        do {
            //there are compliance rules to check...
            if (!$this->valid) {
                $this->error = 'É preciso chamar select antes de chamar update.';
                break;
            }

            $ret = true;
        } while (false);

        if ($ret) {
            // If changed password, then save this event.
            $ae = new AuthEvents;
            $ae->usu_seq = $this->usu_seq;
            $ae->clearEvents($sql);
        }
        return $ret;
    }
}