<?php

require_once __DIR__.'/wcf.php';

define('MAX_PWD_ATTEMPTS', 5);

/*
	array(
		'result'   =>
		'inst_user' =>
		'inst_pass'   =>
		'type'
		'lang'     =>
		'privs'    =>
		'instance' => instance object params.
	);
	
 */

// To be used by regular users.
function wcf_login($username, $password, $filter = [])
{
	global $instance_classname;

	// Create the return array, with the current error
	$ret = array('result' => 'BAD_PARAMS', 'pwd_status' => 'OK');

	if (empty($username) || empty($password))
		return $ret;
	
	// so we have to check in the users_intances table...
	$usu_inst = new UsersInstances;
	$usu_inst->usu_email = $username;
	if (!$usu_inst->select(getDbConn()))
		// user doesnt exist. we should use IPS for brute force protection, but still not.
		$ret['result'] = 'LOGIN_INVALID';
	else {
		// User exists. Lets check password and retrieve all the login INFO
		$ret['type']	= 'user';
		$ret['privs']	= $usu_inst->usuinst_privs;

		// Retrieve instance info if necessary
		$ret['instance'] = $instance_classname::find(getDbConn(), [ 'inst_seq' => $usu_inst->inst_seq ]);
		if (!$ret['instance']->valid)
			$ret['result'] = 'LOGIN_ERROR';
		else {
			if (!empty($filter['inst_version']) && $filter['inst_version'] != $ret['instance']->inst_version)
				$ret['result'] = 'FILTER_FAILED';
			else
				aux_checkCredentials($usu_inst, $password, $ret);
		}
	}
	return $ret;
}

// To be used by SYSTEM administrators.
function wcf_login_support($username, $password, $inst_seq, $privs = 'A')
{
	global $instance_classname;

	// Create the return array, with the current error
	$ret = array('result' => 'BAD_PARAMS', 'pwd_status' => 'OK');

	if (empty($username) || empty($password))
		return $ret;

	// Retrieve the user's object and make sure he has ADMIN privileges.
	$usr = new Users;
	$usr->usu_email = $username;
	if (!$usr->select(getDbConn()) || !strstr($usr->usu_caps, 'ADMIN'))
		$ret['result'] = 'LOGIN_INVALID';
	else {
		// User is ADMIN. Lets check password and retrieve all the login INFO
		// return the fact that this is a support login with differnt access permissions.
		$ret['type']	= 'support';
		$ret['privs']	= $privs;

		// Retrieve instance info if necessary
		$ret['instance'] = ( $inst_seq ? $instance_classname::find(getDbConn(), [ 'inst_seq' => $inst_seq ]) : null );
		if ($ret['instance'] && !$ret['instance']->valid)
			$ret['result'] = 'LOGIN_ERROR';
		else
			aux_checkCredentials($usr, $password, $ret);
	}
	return $ret;
}

/*
 * This is the main function to check access credentials.
 */
function aux_checkCredentials($usu_inst, $password, &$ret)
{
	global $adm_passwd_salt;

	$ret['result'] = 'LOGIN_INVALID';
	$ret['pwd_status'] = 'OK';

	do {
		// we need this for the log
		@$url = dirname($_SERVER['HTTP_HOST'].@$_SERVER['REQUEST_URI']);

		// check if the users is blocked.
		if ($usu_inst->isBlocked(getDbConn())) {
			$ret['pwd_status'] = 'USER_BLOCKED';
			AuthEvents::registerEvent(getDbConn(), AuthEvents::BAD_LOGIN_EVENT, $usu_inst->usu_seq, "URL={$url}, USER IS BLOCKED");
			break;
		}

		// check that the password is correct
		if (!$usu_inst->validatePassword($password)) {
			// bad password. Lets log it and count the number of mistakes.
			AuthEvents::registerEvent(getDbConn(), AuthEvents::BAD_LOGIN_EVENT, $usu_inst->usu_seq, "URL={$url}, BAD PASSWORD");

			$nerr = AuthEvents::countBadLogins(getDbConn(), $usu_inst->usu_seq);
			if ($nerr >= MAX_PWD_ATTEMPTS) {
				// That's it, we must block the user.
				Users::find(getDbConn(), [ 'usu_inst' => $usu_inst->usu_seq ])
					->block(getDbConn(), "{$nerr} INVALID LOGIN ATTEMPTS");
			}
			break;
		}

		$pwd_timet = strtotime($usu_inst->usu_updated_passwd_at);

		// check if the user needs to change the password right now.
		if ($usu_inst->isExpired(getDbConn())) {
			// passowrd expired is only valid for 48 hours, but this is checked by the isBlocked call.
			$ret['pwd_status'] = 'CHANGE_NOW';
		}
		else {
			// check for password expiration status: can be, OK, CHANGE_SOON, CHANGE_NOW or EXPIRED.
			$delta = 8; // number of days until the password expired. 8 means, 'do not report anything.
			if ($usu_inst->usu_max_pwd_age) {
				// delta is the number of days until password expiration.
				$delta = intval(($pwd_timet + ($usu_inst->usu_max_pwd_age * 86400) - time()) / 86400);
				if ($delta <= -3) {
					$ret['pwd_status'] = 'EXPIRED';

					AuthEvents::registerEvent(getDbConn(), AuthEvents::BAD_LOGIN_EVENT, $usu_inst->usu_seq, "URL={$url}, PASSWORD IS EXPIRED");
					// That's it, we must block the user.
					$usu = new Users;
					$usu->usu_seq = $usu_inst->usu_seq;
					$usu->block(getDbConn(), "PASSWORD IS EXPIRED");
					break;
				}
			}
			// Last step: does the user have to change the password imediately, or be notified of a coming expiration?
			if ($delta <= 7) {
				$ret['pwd_status']	= "EXPIRATION: {$delta}";

				if ($delta <= 0)
					$ret['pwd_status']	= 'CHANGE_NOW';
			}
		}

		// Login succeeded.
		$ret['result'] 		= ($ret['pwd_status'] == 'CHANGE_NOW' ? 'CHANGE_PASSWORD' : 'OK');
		$ret['lang'] 		= $usu_inst->usu_language;
		$ret['user']		= $usu_inst;

		AuthEvents::registerEvent(getDbConn(), AuthEvents::GOOD_LOGIN_EVENT, $usu_inst->usu_seq, "URL={$url}, LOGGED into instance ".($ret['instance'] ? $ret['instance']->inst_seq : 'CONSOLE'));

		// Retrieve instance info if necessary
		if ($ret['instance']) {
			$ret['inst_user']	= $ret['instance']->inst_id;
			$ret['inst_pass'] 	= substr(md5($adm_passwd_salt.$ret['instance']->inst_id), 0, 32);
		}
	} while (false);
}
