<?php

/** PRIVATE STUFF. Starting with the crypto related routines**/
$autologin_cypher = MCRYPT_3DES;

function autologin_genid()
{
	global $autologin_cypher;
	return base64_encode(mcrypt_create_iv(mcrypt_get_iv_size($autologin_cypher, MCRYPT_MODE_CFB)));
}

function autologin_genkey()
{
	global $autologin_cypher;
	return base64_encode(mcrypt_create_iv(mcrypt_get_key_size($autologin_cypher, MCRYPT_MODE_CFB)));
}

function autologin_encode($info, $user_agent, $uniqid, $key)
{
	global $autologin_cypher;
	$info['user_agent'] = $user_agent;
	$data = serialize($info);
	return base64_encode(
			mcrypt_encrypt($autologin_cypher, base64_decode($key), $data, MCRYPT_MODE_CFB, 
			base64_decode($uniqid))
	);
}

function autologin_decode($text, $user_agent, $uniqid, $key)
{
	global $autologin_cypher;
	
	$decrypted = mcrypt_decrypt($autologin_cypher, base64_decode($key), base64_decode($text), MCRYPT_MODE_CFB,
		base64_decode($uniqid));
	$info = unserialize($decrypted);
	if ($info && $info['user_agent'] == $user_agent)
		return $info;
	return false;
}

/* DB RELATED PRIVATE FUNCTIONS */
function autologin_db_start($db_name)
{
	try {
		$db_conn = new PDO("sqlite:$db_name");
	} catch (Exception  $e) {
		// we try creating the path for the db, up to two levels (company/program)
		$dir2 = dirname($db_name);
		$dir1 = dirname($dir2);
		if ($dir1 && $dir2) {
			mkdir($dir1);
			mkdir($dir2);
			$db_conn = new PDO("sqlite:$db_name");
		}
	}
	if ($db_conn)
		$db_conn->exec('CREATE TABLE IF NOT EXISTS login_info(li_id varchar(100) PRIMARY KEY, li_text text, li_timestamp integer)');
	
	return $db_conn;
}

function autologin_store_db($db, $login_info, $user_agent, $id)
{
	$key = autologin_genkey();
	$text = autologin_encode($login_info, $user_agent, $id, $key);
	$now = time();

	$db->exec("INSERT OR REPLACE INTO login_info(li_id, li_text, li_timestamp) VALUES('$id', '$text', $now)");
	return "$id:$key";
}

/****************************************************/
/*************************** PUBLIC STUFF ***********/
/****************************************************/
function autologin_retrieve($db_name, $token, $user_agent, &$newtoken)
{
	$db = autologin_db_start($db_name);
	if (!$db)
		return false;

	$id = strtok($token, ':');
	$key = strtok('');
	$last_tm = time() - (15 * 86400); // 15 days max without login.
	$rows = $db->query("SELECT * FROM login_info WHERE li_id = '$id' AND li_timestamp > $last_tm");
	
	if ($rows) {
		foreach($rows as $row) {
			$text = $row['li_text'];
			break;
		}
	}

	if (!$text)
		return false;

	$info = autologin_decode($text, $user_agent, $id, $key);
	if (!$info)
		return false;
		
	$newtoken = autologin_store_db($db, $info, $user_agent, $id);
	return $info;
}

function autologin_delete($db_name, $token)
{
	$db = autologin_db_start($db_name);
	$id = strtok($token);
	$last_tm = time() - (15 * 86400); // 15 days max without login.
	if ($db)
		$db->exec("DELETE FROM login_info WHERE li_id = '$id' OR li_timestamp < $last_tm");
}

function autologin_store($db_name, $login_info, $user_agent)
{
	$id = autologin_genid();
	$db = autologin_db_start($db_name);
	return autologin_store_db($db, $login_info, $user_agent, $id);
}

/************************************************************
Usage of the functions in this file.

if ($_COOKIE['AUTOID']) {
	$newcookie = '';
	$login_info = autologin_retrieve('al_admin.db', $_COOKIE['AUTOID'], $_SERVER['USER_AGENT'], $newcookie);
	if ($login_info && login_succeeded($login_info))
		SetCookie('AUTOID', $newcookie);
	} else {
		autologin_delete('al_admin.db', $_COOKIE['AUTOID']);
	}
}

if ($login_ok && $_POST['save_login_info']) {
	$newcookie = autologin_store('al_admin.db', $login_info);
	SetCookie('AUTOID', $newcookie);
}
*/
