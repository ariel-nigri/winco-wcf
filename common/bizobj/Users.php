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

    private     $pwd_changed;
    protected   $usu_pwd_history;
    protected   $usu_passwd_digest;

    const PASSWORD_SEPARATOR = '#';

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
        $this->addColumn('users.usu_status', 'usu_status', BZC_STRING);                                     /** acct blocked, pwd expired, or both*/
	}
        
	static function generatePassword() {
		$sets = array('abcdefghjkmnpqrstuvwxyz', 'ABCDEFGHJKMNPQRSTUVWXYZ', '23456789');

		$all = $pass = null;
		foreach($sets as $set) {
			$pass .= $set[array_rand(str_split($set))];
			$all .= $set;
		}
		$all = str_split($all);
		for($i = 0; $i < 8 - count($sets); $i++)
			$pass .= $all[array_rand($all)];
		
		$pass = str_shuffle($pass);
		return $pass;
	}

    static function comparePassword($pass, $pwd_digest) {
        global $usr_passwd_salt;
        $digest = md5($usr_passwd_salt . $pass);
        return $digest == $pwd_digest;
    }
    
    public function validatePassword($pass) {
        return $this->comparePassword($pass, $this->usu_passwd_digest);
    }

    // This function has 2 call modes:
    // setPassword(pwd), and
    // setPassword(db, pwd)
    // This is because the former is a compatibility layer for older API.
    // that does not limit the number of != historic passwords
    public function setPassword($p1, $p2 = null) {
        global $usr_passwd_salt, $users_num_of_passwd_to_store, $users_pwd_complexity_regex;

        $pass = $p2 ? $p2 : $p1;
        $db = $p2 ? $p1 : null;

        $digest_pass = md5($usr_passwd_salt.$pass);
        // Check password policy
        if (!empty($users_pwd_complexity_regex) && !preg_match($users_pwd_complexity_regex, $pass)) {
            $this->error = 'A senha inválida. A senha deve ter pelo menos 6 caracteres, sendo pelo menos uma letra maiúscula, uma letra minúscula e um número';
            return false;
        }

        if ($db && $this->usu_seq) {
            // Check password history
            $shadow = $this->getShadow($db);

            // Update the history.
            if ($shadow->usu_num_of_passwd_to_store > 0) {
                if (empty($shadow->usu_pwd_history))
                    $this->usu_pwd_history = $shadow->usu_passwd_digest;

                else {
                    $plist = explode(self::PASSWORD_SEPARATOR, $shadow->usu_pwd_history);
                    array_unshift($plist, $shadow->usu_passwd_digest);
                    while(count($plist) > $shadow->usu_num_of_passwd_to_store)
                        array_pop($plist);
                    $this->usu_pwd_history = implode(self::PASSWORD_SEPARATOR, $plist);
                }
            }

            // make sure we're not repeating the password
            if (strpos($shadow->usu_pwd_history, $digest_pass) !== false) {
                $this->error = 'A senha deve ser diferente das últimas '. $shadow->usu_num_of_passwd_to_store .' senhas';
                return false;
            }
        }
        else if (!isset($this->usu_num_of_passwd_to_store) && !empty($users_num_of_passwd_to_store))
            // initialize the history default value
            $this->usu_num_of_passwd_to_store = $users_num_of_passwd_to_store;

        // All is fine. update the local variables to be changed.
        $this->usu_passwd_digest = $digest_pass;
        $this->usu_updated_passwd_at = date("Y-m-d H:i:s");
        $this->pwd_changed = true;
        return true;
    }

    public function isBlocked($db = null) {
        return strchr($this->usu_status, 'B');
    }

    public function block($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if ($shadow->isBlocked($db))
            return true;

        return $this->updateStatus($db, $shadow->usu_status . 'B', AuthEvents::BLOCK_LOGIN_EVENT, $reason);
    }

    public function unblock($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if (!$shadow->isBlocked($db))
            return true;

        return $this->updateStatus($db, str_replace($shadow->usu_status, 'B', ''), AuthEvents::USER_UNBLOCKED_EVENT, $reason);

        /*
        if (@$_POST['action'] == 'unblock') {
            $users = new Users;
            $users->usu_seq = $_POST['seq'];
            $users->select($db_conn);
            $users->setPassword($pass);
            if ($users->update($db_conn)) {
                $GLOBALS['wc_conn']->addToLog("IMFILTER", "ADMIN_UNBLOCK " . $users->usu_email, logAudit);
                $_SESSION['MSG_ALERT'] = "A conta <strong>".$_POST['email']."</strong> foi desbloqueada.";
                header("Location: list_accounts.phtml");
                exit;
            }
        }
        */
    }

    public function expirePassword($db, $reason = '') {
        $shadow = $this->getShadow($db);
        if (strchr($shadow->usu_status, 'X'))
            return true;

        return $this->updateStatus($db, $shadow->status . 'X', AuthEvents::CHANGE_PASSWD_NEXT_LOGIN, $reason);
    }

    protected function afterSave($insert, $sql) {
        if ($this->pwd_changed)
            AuthEvents::registerEvent($sql, AuthEvents::NEW_PWD_EVENT, $this->usu_seq);
        $this->pwd_changed = false;
        return true;
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
}

/*
	private maxAttempt = 0;

	public function addBadLogin($sql) {
				
		if (empty($this->usu_seq)) {
			throw new Exception('O parametro usu_seq não pode ser vazio.');
			// $this->error = 'O parametro usu_seq não pode ser vazio.';
			// return false;
		}

		if ($this->maxAttempt === 0)
			return;

		if ($this->isBlocked($sql)) 
			return self::BLOCK_LOGIN_EVENT;
		
		$total_attemps = $this->checkBadLoginAttempts($sql->con);
		$this->ae_event = self::BAD_LOGIN_EVENT;

		if ($total_attemps >= $this->maxAttempt) {
			$this->ae_event = self::BLOCK_LOGIN_EVENT;
			$this->ae_reason = 'BAD_LOGIN';
			
			$clone = new AuthEvents;
			$clone->usu_seq = $this->usu_seq;
			$clone->clearEvents($sql, self::BAD_LOGIN_EVENT);
		}

		$this->insert($sql);
		return $this->ae_event;
	}
*/