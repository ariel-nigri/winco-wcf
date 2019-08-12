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
    var $usu_passwd_digest;
    var $usu_language;
    var $usu_twofact_type;
    var $usu_twofact_token;
    var $usu_updated_passwd_at;
    var $usu_num_of_passwd_to_store;
    var $usu_pwd_history;
    var $usu_caps;

    const PASSWORD_SEPARATOR = '#';

    private $password_length = null;        /** Minimum length of password */
    private $complexity_regex = null;       /** REGEX for test the password complexity requirements */
    private $password_plain = null;         /** Receives the plain password when the setPassword (@see setPassword) is called. */

    private $errors = array(
        'PASSWORD_HISTORY_ERROR' => "A senha deve ser diferente das últimas {usu_num_of_passwd_to_store} senhas utilizadas.",
        'CALL_FETCH_BEFORE_SAVE' => 'É preciso chamar fetch antes de chamar save.',
    );
    // private $max_password_age = null;
    // private $password_history = null;

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
	}
        
    public function validatePassword($pass) {
        return $this->comparePassword($pass, $this->usu_passwd_digest);
    }

    public function setPassword($pass) {
        global $usr_passwd_salt;

        if ($this->usu_num_of_passwd_to_store > 0)
            $this->usu_pwd_history = (empty($this->usu_pwd_history) ? $this->usu_passwd_digest : $this->usu_passwd_digest.self::PASSWORD_SEPARATOR.$this->usu_pwd_history);
        $this->usu_passwd_digest = md5($usr_passwd_salt.$pass);
        $this->usu_updated_passwd_at = date("Y-m-d H:i:s");
        $this->password_plain = $pass;
        return true;
    }

    protected function beforeSave($insert, $sql) {
        
        if ($insert)
            return true;

        $ret = true;
        do {
            if (!$this->complexity_regex && !$this->usu_pwd_history && !$this->password_length)
                break;

            if (!$this->password_plain)
                break;
            
            $ret = false;
            //there are compliance rules to check...
            if (!$this->valid) {
                $this->error = $this->error['CALL_FETCH_BEFORE_SAVE'];
                break;
            }

            if ($this->complexity_regex)
                if (!preg_match($this->complexity_regex, $this->password_plain))
                    break;

            if ($this->password_length)
                if (strlen($this->password_plain) < $this->password_length)
                    break;
            
            $clone = $this->getShadow($sql);
            if ($clone->usu_passwd_digest == $this->usu_passwd_digest) {
                $this->error = 'PASSWORD_HISTORY_ERROR:'.str_replace('{usu_num_of_passwd_to_store}', $this->usu_num_of_passwd_to_store, $this->errors['PASSWORD_HISTORY_ERROR']);
                break;
            }

            if ($this->usu_num_of_passwd_to_store > 0) {
                $passwords = explode(self::PASSWORD_SEPARATOR, $this->usu_pwd_history);
                //Checking if the new password is equal than last 5 passwords
                foreach ($passwords as $pwd) {
                    if ($pwd == $this->usu_passwd_digest) {
                        $this->error = 'PASSWORD_HISTORY_ERROR:'.str_replace('{usu_num_of_passwd_to_store}', $this->usu_num_of_passwd_to_store, $this->errors['PASSWORD_HISTORY_ERROR']);
                        $ret = false;
                        break 2;
                    }
                }
                $passwords = array_slice($passwords, 0, $this->usu_num_of_passwd_to_store);
            
                $this->usu_pwd_history = implode(self::PASSWORD_SEPARATOR, $passwords);
            }
            $ret = true;
        } while (false);
        if ($ret) {
            $ae = new AuthEvents;
            $ae->usu_seq = $this->usu_seq;
            $ae->clearEvents($sql);
        }
        return $ret;
    }
};