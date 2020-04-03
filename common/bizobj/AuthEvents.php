<?php
/*

CREATE TABLE auth_events (
	ae_seq INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	usu_seq INTEGER NOT NULL,
	ae_event VARCHAR(2) NOT NULL,
	ae_datetime DATETIME NOT NULL
);

CREATE INDEX ae_event_usu ON auth_events (usu_seq, ae_event);

*/
class AuthEvents extends SqlToClass {
	const GOOD_LOGIN_EVENT		= 'GL';					/** Good login. */
	const BAD_LOGIN_EVENT		= 'BD';					/** Bad Login. */

	const BLOCK_LOGIN_EVENT 	= 'BL';					/** Blocked. It's not possible to sign in. */
	const USER_UNBLOCKED_EVENT	= 'UL';					/** unblock login event. */

	const CHANGE_PASSWD_NEXT_LOGIN = 'PC';				/** Should change password */
	const NEW_PWD_EVENT 		= 'NP';					/** User changed the password */
	
    public function __construct() {
		$this->addTable('auth_events');	

		$this->addColumn('auth_events.ae_seq', 'ae_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('auth_events.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_event', 'ae_event', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_datetime', 'ae_datetime', BZC_DATE | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_reason', 'ae_reason', BZC_STRING);
	}
	
	static function registerEvent($sql, $event, $usu_id, $reason = '') {
		$ae = new AuthEvents;
		$ae->ae_event = $event;
		$ae->insert($sql);
		$ae->usu_seq = $usu_id;
		$ae->ae_reason = $reason;
		return $ae->insert($sql);
	}

	public function countBadLogins(PDO $sql) {
		$count = 0;

		$sth = $sql->prepare("SELECT ae_event as total FROM auth_events WHERE usu_seq = :user ORDER BY ae_seq DESC LIMIT 40");
		$sth->execute([':user' => $this->usu_seq]);
		$array = $sth->fetchAll();
		foreach ($array as $row) {
			switch ($row[0]) {
			case self::BAD_LOGIN_EVENT:
				++$count;
				break;
			case self::USER_UNBLOCKED_EVENT:
			case self::GOOD_LOGIN_EVENT:
				return $count;
			}
		}

		return $count;
	}

	protected function beforeSave($insert) {
		if (!$insert) {
			$this->error = 'Não é permitido alterar eventos de autenticação';
			return false;
		}
		$this->ae_datetime = date('Y-m-d H:i:s');
		return true;
	}
}

/*
if ($_POST["new"]) {
	$nameimput = "new";
	
	$instances = new WTM_Instances;
	$instances->inst_email = $user_mail;
	
	$users = new Users;
	$users->usu_email = $user_mail;
	if ($instances->select($db_conn) || $users->select($db_conn)) {	
		$erromsg = "ERROR: ".$STR_WTM_accounts_msg_user_registered;
		return;			
	}	
	
	$users->usu_name = $user_name;
	$users->usu_language = $user_lang;	
	$users->usu_num_of_passwd_to_store = $num_pwd_to_store;
	$users->usu_max_pwd_age = $password_age;
	// $users->usu_passwd_digest = $pass;
	$users->setPassword($pass);
	
	if ($twofact_type == 'GOOGLE') {					
		do {
			genGoogleAuthenticatorSecret("WincoTalkManager", $secret, $qrCodeUrl);
			
			$checkUser = new Users;
			$checkUser->usu_twofact_type = "GOOGLE";
			$checkUser->usu_twofact_token = $secret;
			if ($checkUser->select($db_conn))
				continue;
			break;
		} while(true);
		
		$users->usu_twofact_type = $twofact_type;
		$users->usu_twofact_token = $secret;
	}
	$db_conn->begin();
	
	if (!$users->insert($db_conn)) {
		$erromsg = "ERROR: ".$STR_WTM_accounts_msg_insert;
		return;
	} else {		
		$usu_inst = new UsersInstances;
		$usu_inst->usu_seq = (int)$users->usu_seq;
		$usu_inst->inst_seq = (int)$_SESSION['INSTANCE_SEQ'];
		$usu_inst->usuinst_privs = $user_privs;
		if (!$usu_inst->insert($db_conn)) {
			$db_conn->rollback();
			$erromsg = "ERROR: ".$STR_WTM_accounts_msg_insert;
			return;
		} else {	
			$db_conn->commit();

			$ae = new AuthEvents;
			$ae->usu_seq = $usu_inst->usu_seq;
			$ae->ae_event = AuthEvents::CHANGE_PASSWD_NEXT_LOGIN;
			$ae->insert($db_conn);

			$msg = str_replace(array("#NOME#", "#ADMIN#", "#USER#", "#PASSW#"), array($users->usu_name, $_SESSION['LOGGED_IN_USER'], $users->usu_email, $pass), $STR_WTM_accounts_send_mail);
			
			if (!empty($secret))
				$msg = str_replace(array("#USAGAUTH1#", "#USAGAUTH2#"), array($STR_WTM_accounts_txt_ga1, ""), $msg);
			else
				$msg = str_replace(array("#USAGAUTH1#", "#USAGAUTH2#"), array("", ""), $msg);			
			
			mail($users->usu_email, $STR_WTM_accounts_mail_title, $msg,	"From: {$STR_WTM_recovery_mail_support} <{$support_email}>\r\nMIME-Version: 1.0\r\nContent-type: text/plain; charset=\"iso-8859-1\"\r\nContent-transfer-encoding: quoted-printable\r\n",
				 "-f  {$support_email}");
			
			$_SESSION['MSG_ALERT'] = "<strong>".$user_mail."</strong>".$STR_WTM_listaccounts_added_ok;
						
			$GLOBALS['wc_conn']->addToLog("IMFILTER", "ADMIN_NEW " . $user_mail, logAudit);

			if ($user_instance_master) $GLOBALS['wc_conn']->addToLog("IMFILTER", "SET_MASTER " . $user_mail, logAudit);
			
			if (!isset($qrCodeUrl))
				header("Location: list_accounts.phtml");
		}
	}	
	
} else if ($_POST["edit"]) {
	$nameimput = "edit";	
	
	if ($_POST['seq'] == "MASTER") {				
		$users = new Users;
		$users->usu_email = $user_mail;
		if (!$users->select($db_conn)) {				
			$users->usu_name = $user_name;
			$users->usu_language = $user_lang;	
			$users->usu_passwd_digest = $inst->inst_passwd_digest;
				
			$db_conn->begin();
			
			if (!$users->insert($db_conn)) {
				$db_conn->rollback();
				$erromsg = "ERROR: ".$STR_WTM_accounts_msg_insert;
				return;
			} else {		
				$usu_inst = new UsersInstances;
				$usu_inst->usu_seq = (int)$users->usu_seq;
				$usu_inst->inst_seq = (int)$_SESSION['INSTANCE_SEQ'];
				$usu_inst->usuinst_privs = "A";
				if (!$usu_inst->insert($db_conn)) {
					$db_conn->rollback();
					$erromsg = "ERROR: ".$STR_WTM_accounts_msg_insert;
					return;
				} else {
					$db_conn->commit();	
				}
			}		
		}	
		$user_seq = (int)$users->usu_seq;
	} else
		$user_seq = (int)$_POST["seq"];
	
	$db_conn->begin();
	
	$users = new Users;
	$users->usu_seq = $user_seq;
	if ($users->select($db_conn)) {
	
		// save old config to log audity
		$old_mail = $users->usu_email;
		$old_name = $users->usu_name;
		$old_lang = $users->usu_language;
		$old_2fact = $users->usu_twofact_type;
		
		// set new params
		$users->usu_email = $user_mail;
		$users->usu_name = $user_name;
		$users->usu_language = $user_lang;
		
		// Rafael
		if (stripos($users->usu_name, "/") !== false){
			$erromsg = "ERROR: $STR_WTM_accounts_msg_wrong_char";
			return;
		}
		
		if (empty($twofact_type)) {
			$users->usu_twofact_type = $users->usu_twofact_token = '';		
		} else {	
			$set2fact = false;
			if ($twofact_type == 'GOOGLE' && empty($checkUser->usu_twofact_type) && empty($users->usu_twofact_token)) {
				$set2fact = true;					
				do {
					genGoogleAuthenticatorSecret("WincoTalkManager", $secret, $qrCodeUrl);
					
					$checkUser = new Users;
					$checkUser->usu_twofact_type = "GOOGLE";
					$checkUser->usu_twofact_token = $secret;
					if ($checkUser->select($db_conn))
						continue;
					break;
				} while(true);						
				$users->usu_twofact_type = $twofact_type;
				$users->usu_twofact_token = $secret;
			}	
		}

		if (!$users->update($db_conn)) {
			print_r($users);
			exit;
			$db_conn->rollback();
			$erromsg = "ERROR: " . $STR_WTM_accounts_msg_update;
			return;
		} else {	
			$usu_inst = new UsersInstances;				
			$usu_inst->usu_seq = $users->usu_seq;
			if ($usu_inst->select($db_conn)){
				// save old config to log audity
				$old_perms = $usu_inst->usuinst_privs;
				$old_master = $usu_inst->usuinst_master;

				$usu_inst->usuinst_privs = $user_privs;
				$usu_inst->usuinst_master = $user_instance_master;
				if (!$usu_inst->update($db_conn)) {
					print_r($usu_inst);
					exit;
					
					$db_conn->rollback();
					$erromsg = "ERROR: " . $STR_WTM_accounts_msg_update;
					return;
				} else {									
					$db_conn->commit();
										
					// log audity									
					if ($old_mail != $user_mail || $old_name != $user_name || $old_lang != $user_lang || $old_perms != $user_privs || $old_2fact != $twofact_type || $old_master != $usu_inst_master) {
						$msg = '';
						if ($old_mail != $user_mail)						
							$msg .= $old_mail . " -> ";				
						
						$msg .= $user_mail . ", " . IMFILTER_MSG_ADD_LOG_BEFORE . $old_name . ', ' . $privs[trim(strtolower($old_perms))] . ', ';
						$msg .= empty($old_lang) ? $STR_WTM_listaccounts_lang_br : $langs[trim(strtolower($old_lang))];
						$msg .= ", TWO_FACTOR=";
						$msg .= empty($old_2fact) ? "n" : "GOOGLE";

						$GLOBALS['wc_conn']->addToLog("IMFILTER", "ADMIN_EDIT " . utf8_encode($msg), logAudit);

						if ($user_instance_master) $GLOBALS['wc_conn']->addToLog("IMFILTER", "SET_MASTER " . $user_mail, logAudit);
						else $GLOBALS['wc_conn']->addToLog("IMFILTER", "UNSET_MASTER " . $user_mail, logAudit);
						
						$_SESSION['MSG_ALERT'] = "<strong>".$user_mail."</strong>".$STR_WTM_listaccounts_edit_ok;
					}
					
					// send mail
					if ($old_2fact != $users->usu_twofact_type) {
						
						$reason = empty($users->usu_twofact_type) ? $STR_WTM_mail_reason1 : $STR_WTM_mail_reason2;
						
						$msg = str_replace(array("#NOME#", "#ADMIN#", "#REASON#"), array($users->usu_name, $_SESSION['LOGGED_IN_USER'], $reason), $STR_WTM_accounts_send_mail2);
										
						mail($users->usu_email, $STR_WTM_accounts_mail_title2, $msg,	"From: {$STR_WTM_recovery_mail_support} <{$support_email}>\r\nMIME-Version: 1.0\r\nContent-type: text/plain; charset=\"iso-8859-1\"\r\nContent-transfer-encoding: quoted-printable\r\n",
							 "-f  {$support_email}");
					}
					
					if (!isset($qrCodeUrl))
						header("Location: list_accounts.phtml");
				}
			}	
		}
	} else {
		$erromsg = "ERROR: ".$STR_WTM_accounts_msg_user_notfound;
		return;				
	}				

}
*/