<?php

require_once __DIR__.'/wcf.php';

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
 
function wcf_login($username, $password) {
	$ret = array('result' => 'BAD_PARAMS');

	if (empty($username) || empty($password))
		return $ret;
	
	global $adm_passwd_salt, $instance_classname;
	
	// so we have to check in the users table...
	do {
		$ret['result'] = 'LOGIN_INVALID';
		$usu_inst = new UsersInstances;
		$usu_inst->usu_email = $username;
		if (!$usu_inst->select(getDbConn())
				|| !Users::comparePassword($password, $usu_inst->usu_passwd_digest))
			break;

		/*
		$ae->usu_seq = $usu_inst->usu_seq;
		if ($ae->isBlocked($db_conn)) {
			$ret['result'] = 'LOGIN_BLOCKED';
			break;
		}
		*/

		$instance = new $instance_classname;
		$instance->inst_seq = $usu_inst->inst_seq;			
		if (!$instance->select(getDbConn())) {
			$ret['result'] = 'LOGIN_ERROR';
			break;
		}

		$ret['result'] 		= 'OK';
		$ret['inst_user']	= $instance->inst_id;
		$ret['inst_pass'] 	= substr(md5($adm_passwd_salt.$instance->inst_id), 0, 32);
		$ret['type']		= 'user';
		$ret['privs']		= $usu_inst->usuinst_privs;
		$ret['lang'] 		= $usu_inst->usu_language;
		$ret['user']		= $usu_inst;
		$ret['instance']	= $instance;
	} while(false);
	return $ret;
}

function wcf_login_support($username, $password, $inst_seq, $privs = 'A') {
	$ret = array('result' => 'BAD_PARAMS');

	if (empty($username) || empty($password))
		return $ret;
	
	global $adm_passwd_salt, $instance_classname;
	
	// so we have to check in the users table...
	do {
		$ret['result'] = 'LOGIN_INVALID';

        // connect to DB
        $db_conn = getDbConn();

        // Check the user's password
        $usr = new Users;
        $usr->usu_email = $username;
		if (!$usr->select($db_conn) || !$usr->validatePassword($password) || !strstr($usr->usu_caps, 'ADMIN'))
			break;

		/*
		$ae->usu_seq = $usu_inst->usu_seq;
		if ($ae->isBlocked($db_conn)) {
			$ret['result'] = 'LOGIN_BLOCKED';
			break;
		}
		*/

		$instance = new $instance_classname;
		$instance->inst_seq = $inst_seq;			
		if (!$instance->select($db_conn)) {
			$ret['result'] = 'LOGIN_ERROR';
			break;
		}

		$ret['result'] 		= 'OK';
		$ret['inst_user']	= $instance->inst_id;
		$ret['inst_pass'] 	= substr(md5($adm_passwd_salt.$instance->inst_id), 0, 32);
		$ret['type']		= 'support';
		$ret['privs']		= $privs;
		$ret['lang'] 		= $usr->usu_language;
		$ret['user']		= $usr;
		$ret['instance'] 	= $instance;
	} while(false);
	return $ret;
}
