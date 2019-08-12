<?php

require_once dirname(__DIR__)."/config/install_params.php";

$wcf_db_conn = $wcf_db_conn_pdo = null;

spl_autoload_register(function($class_name) {
	$dirs = array ('bizobj', 'mvc3/db', 'mvc', 'mvc3/form');

	foreach ($dirs as $dir) {
		if (file_exists(__DIR__."/$dir/$class_name.php")) {
            require_once(__DIR__."/$dir/$class_name.php");
            break;
        }
	}
});

function getDbConn() {
    require_once 'mvc3/db/db-pdo.php';

    global $db_dsn, $db_user, $db_passwd, $wcf_db_conn_pdo, $wcf_db_conn;

    if (empty($db_conn)) {
        try {
            $wcf_db_conn_pdo = new PDO($db_dsn, $db_user, $db_passwd);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        
        $wcf_db_conn = new Sql($wcf_db_conn_pdo);
    }
    return $wcf_db_conn;
}
