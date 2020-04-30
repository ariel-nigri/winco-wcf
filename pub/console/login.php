<?php

$open_page = true;

require "config.php";
require "../../common/wcf_login.php";

$username = $pass = '';


if (!empty($_POST)) {
	do {
		@$username = $_POST['username'];
		@$pass = $_POST['pass'];
		if (empty($username) || empty($pass)) {
			$erromsg = "Por favor entre com usuário e senha";
			break;
		}

		$ret = wcf_login_support($username, $pass, null);
		if ($ret['result'] == 'OK') {
			// load perms and all env info into _SESSION
			$_SESSION['LOGGED_USER'] = array(
				'usu_seq'   => $ret['user']->usu_seq,
				'usu_email' => $ret['user']->usu_email,
				'usu_name'  => $ret['user']->usu_name,
			);

			if ($ret['pwd_status'] != 'OK')
				$_SESSSION['LOGGED_USER']['notices'][] = $ret['pwd_status'];

			header('Location: .');
			break;
		}
		switch ($ret['result']) {

		case 'LOGIN_INVALID':
			switch ($ret['pwd_status']) {

			case 'USER_BLOCKED':
				$erromsg = "The account is blocked";
				break;

			case 'EXPIRED':
				$erromsg = "The password is expired";
				break;

			default:
				$erromsg = "Invalid username or password";
			}
			break;

		case 'BAD_PARAMS':
		case 'LOGIN_ERROR':
			$erromsg = "Undefined system error, contatct support";
			break;

		case 'CHANGE_PASSWORD':
			$change_password = true;
			break;
		}
	} while (false);
}
