<?php


function wcf_create_or_update(&$inst_id, $inst_caps, $inst_name, $inst_lang, $user_email, $user_name, $inst_expiration, &$error)
{
    global $instance_classname, $product_code, $default_license;

    $dbconn = getDbConn();

    if (empty($inst_id)) {
        if (empty($inst_name) || empty($user_email) || empty($user_name)) {
            $error = 'Missing user and instance info';
            return false;
        }

        $ok = false;
        $dbconn->begin();
        do {
            // create a new user
            $user = Users::find($dbconn, ['usu_email' => $user_email]);
            if (!$user->valid) {
                $user = new Users;
                $user->usu_email = $user_email;
                $user->usu_language = $inst_lang;
                $user->usu_name = $user_name;
                $user->setPassword(uniqid());
                if (!$user->insert($dbconn)) {
                    $error = 'Cannot create administrator';
                    break;
                }
            }

            // create a new instance
            $instance = new $instance_classname;
            $instance->inst_name = $inst_name;
            $instance->inst_lang = $inst_lang;
            $instance->inst_type = $inst_caps;
            $instance->inst_license = $default_license;
			$instance->inst_expiration = substr($inst_expiration, 0, 4).'-'.substr($inst_expiration, 4, 2).'-'.substr($inst_expiration, 6, 2);
            $instance->worker_seq = 1;
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
            $ok = true;
        } while (false);
        if ($ok) {
            $dbconn->commit();
            $inst_id = $instance->inst_id;
            // materialize the instance and start it

            $instance->init_directory();
            $instance->start();
        }
        else
            $dbconn->rollback();

        return $ok;
    }
    else {
        // get the instance of
        $instance = $instance_classname::find(getDbConn(), ['inst_id' => $inst_id]);
        if (!$instance->valid) {
            $error = "Cannot find instance {$inst_seq} to apply license";
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
function wcf_extend_license($inst_id, $lic_period, $new_lic, &$inst_caps, &$error)
{

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
		$instance->inst_expiration = NULL; // do not update this.
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
        'usu_email'     => $user->usu_email,
        'usu_name'      => $user->usu_name,
        'usu_language'  => $user->usu_language,
        'usu_caps'      => $user->usu_caps
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
    if (!$instances->select($db)) {
        $error = "Cannot retrieve instance information. Please contact support";
        return false;
    }

    while ($instances->fetch()) {
        $info['instances'][] = [
            'inst_id'       => $instances->inst_id,
            'usuinst_perms' => $perms[$instances->inst_seq],
            'inst_type'     => $instances->inst_type,
            'inst_name'     => $instances->inst_name,
            'inst_expiration' => $instances->inst_expiration
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
	if (!$user->setPassword($password)) {
		$error = 'Error setting password';
		break;
	}
	if (!$user->update($db)) {
		$error = 'Cannot update password: '.$user->error;
		return false;
   }
	return true;
}