<?php

require_once dirname(__DIR__)."/config/install_params.php";

$wcf_db_conn = $wcf_db_conn_pdo = null;

$wcf_search_dirs = ['bizobj', 'mvc3/db'];

spl_autoload_register(function($class_name) {
    global $wcf_search_dirs;

	foreach ($wcf_search_dirs as $dir) {
		if (file_exists(__DIR__."/$dir/{$class_name}.php")) {
            require_once(__DIR__."/$dir/{$class_name}.php");
            return;
        }
    }

    if (file_exists("{$GLOBALS['bizobj_extra']}/{$class_name}.php"))
        require_once("{$GLOBALS['bizobj_extra']}/{$class_name}.php");
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
