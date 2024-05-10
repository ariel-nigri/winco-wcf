<?php

// include program definitions.
ini_set("include_path", dirname(dirname(__DIR__))."/common");

require "wcf.php";
$wcf_search_dirs[] = 'mvc';

if (defined("CFM_BASE_DOMAIN"))
	session_set_cookie_params(0, '/', CFM_BASE_DOMAIN, true, true);
else
	session_set_cookie_params(0, '/');

session_name("CFM_CONSOLE");
session_start();

if (empty($open_page)) {
	if (empty($_SESSION['LOGGED_USER'])) {
		header('Location: login.phtml');
		exit;
	}

	/*
	* two factor auth
	*/
	if (isset($_SESSION['TWO_FACTOR_VALID']) && $_SESSION['TWO_FACTOR_VALID'] == false) {
		if (!strstr($_SERVER['PATH_INFO'], "login_two_factor.phtml")) {
			header("Location: ../admin/login_two_factor.phtml");
			exit;
		}
	}
}

// Appliction logging. Apache will log this header's value to the apache log.
if (!empty($_SESSION['LOGGED_USER']['usu_email']))
	header('X-Logged-User: '.$_SESSION['LOGGED_USER']['usu_email']);

// Language settings
if (empty($_SESSION['LANGUAGE'])) {
	if (defined("CFM_DEFAULT_LANGUAGE"))
		$_SESSION['LANGUAGE'] = CFM_DEFAULT_LANGUAGE;
	else
		$_SESSION['LANGUAGE'] = "br";
}

require "istr/{$_SESSION['LANGUAGE']}/language.php";
require "istr/{$_SESSION['LANGUAGE']}/admin.php";

$template_file = "template.phtml";
