<?php

// Create or update an admin and then, ALWAYS create a new Instance.
function wcf_create_or_update(&$inst_id, $inst_caps, $inst_name, $inst_lang, $user_email, $user_name, $inst_expiration, &$error, $pwd = null)
{
    global $instance_classname;

    $dbconn = getDbConn();

    if (empty($inst_id)) {
        if (empty($inst_name) || empty($user_email) || empty($user_name)) {
            $error = 'Missing user and instance info';
            return false;
        }

        $dbconn->begin();
        $instance = wcf_dbcreate_instance($inst_caps, $inst_name, $inst_lang, $user_email, $user_name, $inst_expiration, $error, $pwd);

        if ($instance) {
            if (!$dbconn->commit()) {
                $instance = null;
                $error = $dbconn->errormessage();
            }
            else {
                $inst_id = $instance->inst_id;

                // materialize the instance and start it
                $instance->init_directory();
                $instance->start();
            }
        }
        else
            $dbconn->rollback();

        return $instance != null;
    }
    else {
        // get the instance of
        $instance = $instance_classname::find(getDbConn(), ['inst_id' => $inst_id]);
        if (!$instance->valid) {
            $error = "Cannot find instance {$inst_id} to apply license";
            return false;
        }
        if ($instance->inst_type != $inst_caps) {
            //
            // must change the capabilities for instance
            //
            $instance->inst_type = $inst_caps;
            if (!$instance->update($dbconn)) {
                $error = 'Cannot update Instance: '.$instance->error;
                return false;
            }
            $instance->stop();
            $instance->start();
        }
    }
    // apply the new caps and 

    return true;
}

// renew, same everything.
//lic_period has the license new  ending day in the format:   yyyy-mm-dd
function wcf_extend_license($inst_id, $inst_expiration, &$error)
{
    $db = getDbConn();
    $instance = VPND_Instances::find($db, ['inst_id' => $inst_id, 'inst_active' => null]);
    if (!$instance->valid) {
        $error = 'Invalid instance';
        return false;
    }
    $instance->inst_expiration = $inst_expiration;
    $instance->inst_active = true;
    if (!$instance->update($db)) {
        $error = 'Cannot update Instance: '.$instance->error;
        return false;
    }

    // No need to restart instance on 'renew', but we must start it if it is stopped
    if (!$instance->status())
	    $instance->start();
    return true;
}

// renew, same everything.
//lic_period has the license new  ending day in the format:   yyyy-mm-dd
function wcf_extend_license2($inst_id, $lic_period, &$resp)
{
    $db = getDbConn();
    Sql::$date_format = 'iso';
    $instance = VPND_Instances::find($db, ['inst_id' => $inst_id, 'inst_active' => null]);
    if (!$instance->valid) {
        $resp = 'Invalid instance';
        return false;
    }

    $tm = strtotime($instance->inst_expiration);
    $now = time();
    if ($tm < $now)
        $tm = $now;
    $instance->inst_expiration = date('Ymd', $tm + round($lic_period * 86400));
    $instance->inst_active = true;
    if (!$instance->update($db)) {
        $resp = 'Cannot update Instance: '.$instance->error;
        return false;
    }

    // No need to restart instance on 'renew', but we must start it if it is stopped
    if (!$instance->status())
	    $instance->start();

    $resp = $instance->inst_expiration;
    return true;
}

// change caps, dont change expiration
function wcf_change_caps($inst_id, $inst_caps, &$inst_expiration, &$error)
{
    $db = getDbConn();

    $instance = VPND_Instances::find($db, ['inst_id' => $inst_id]);
    if (!$instance->valid) {
        $error = 'Invalid instance';
        return false;
    }
	$inst_expiration = substr($instance->inst_expiration, 6, 4).substr($instance->inst_expiration, 3, 2).substr($instance->inst_expiration, 0, 2);
    if ($instance->inst_type != $inst_caps) {
        //
        // must change the capabilities for instance
        //
		$instance->inst_expiration = null; // do not update this.
        $instance->inst_type = $inst_caps;
        if (!$instance->update($db)) {
            $error = 'Cannot update Instance: '.$instance->error;
            return false;
        }
        $instance->stop();
        $instance->start();
    }
    return true;
}

// Retrieve information about the instance of a user.
function wcf_list_info($usu_email, &$info, &$error)
{
    global $instance_classname;

    $db = getDbConn();
 
    $user = Users::find($db, ['usu_email' => $usu_email]);
    if (!$user->valid) {
        $error = "User not foud.";
        return false;
    }

    $info['user'] = [
        'usu_email'     			=> $user->usu_email,
        'usu_name'      			=> $user->usu_name,
        'usu_language'  			=> $user->usu_language,
		'usu_updated_passwd_at'	    => $user->usu_updated_passwd_at,
		'usu_passwd_digest'         => md5($user->usu_seq.$user->usu_updated_passwd_at),
        'usu_caps'      			=> $user->usu_caps
    ];

    $usu_inst = UsersInstances::find($db, ['usu_seq' => $user->usu_seq]);
    if (!$usu_inst->valid) {
        $error = "Email not associated to any instance";
        return true;
    }

    $perms = array();
    while ($usu_inst->fetch())
        $perms[$usu_inst->inst_seq] = $usu_inst->usuinst_privs;
    
    $instances = new $instance_classname;
    $instances->inst_seq = SqlExpr("IN", "(".implode(',', array_keys($perms)).")");
    $instances->inst_active = null;
    if (!$instances->select($db)) {
        $error = "Cannot retrieve instance information. Please contact support";
        return false;
    }

    while ($instances->fetch()) {
        $info['instances'][] = [
            'inst_id'       => $instances->inst_id,
            'usuinst_privs' => $perms[$instances->inst_seq],
            'inst_type'     => $instances->inst_type,
            'inst_name'     => $instances->inst_name,
            'inst_expiration' => str_replace('-', '', $instances->inst_expiration)
        ];
    }
    return true;
}

function wcf_set_password($usu_email, $password, &$error)
{
	$db = getDbConn();
	$user = Users::find($db, ['usu_email' => $usu_email]);
	if (!$user->valid) {
		$error = "User not foud.";
		return false;
	}
	if (!$user->setPassword($db, $password)) {
		$error = 'Error setting password';
		return false;
	}
	if (!$user->update($db)) {
		$error = 'Cannot update password: '.$user->error;
		return false;
   }
	return true;
}

/* PRIVATE STUFF */
function wcf_dbcreate_instance($inst_caps, $inst_name, $inst_lang, $user_email, $user_name, $inst_expiration, &$error, $pwd = null)
{
    global $instance_classname, $product_code, $default_license, $my_worker_names;

    $dbconn = getDbConn();
    $ret = null;
    do {
        // create a new user
        $user = Users::find($dbconn, ['usu_email' => $user_email]);
        if (!$user->valid) {
            $user = new Users;
            $user->usu_email = $user_email;
            $user->usu_language = $inst_lang;
            $user->usu_name = $user_name;
            if (empty($pwd))
                $pwd = Users::generatePassword();
            $user->setPassword($pwd);
            if (!$user->insert($dbconn)) {
                $error = 'Cannot create administrator';
                break;
            }
        }
        // get our own worker_seq;
        $worker = Workers::find($dbconn, ['worker_frontend' => $my_worker_names, 'worker_active' => true]);
        if (!$worker->valid) {
            $error = 'Either this worker is not registered or is not active';
            break;
        }

        // Find instances for thet user or create a new one. If there is an instance that is not trial, then there is something wrong.
        $instance = new $instance_classname;
        $instance->inst_name = $inst_name;
        $instance->inst_lang = $inst_lang;
        $instance->inst_type = $inst_caps;
        $instance->inst_license = $default_license;
        $instance->inst_expiration = substr($inst_expiration, 0, 4).'-'.substr($inst_expiration, 4, 2).'-'.substr($inst_expiration, 6, 2);
        $instance->worker_seq = $worker->worker_seq;
        $instance->inst_version = trim(file_get_contents(__DIR__."/../config/current_version_{$product_code}.cfg"));
        if (!$instance->insert($dbconn)) {
            $error = 'Cannot create or start the new instance: '.$instance->error;
            break;
        }

        // usuinst
        $usu_inst = new UsersInstances;
        $usu_inst->inst_seq = $instance->inst_seq;
        $usu_inst->usu_seq = $user->usu_seq;
        $usu_inst->usuinst_privs = 'A';
        if (!$usu_inst->insert($dbconn)) {
            $error = 'Error inserting usu_inst'.$usu_inst->error;
            break;
        }
        $ret = $instance;
    } while (false);

    return $ret;
}
