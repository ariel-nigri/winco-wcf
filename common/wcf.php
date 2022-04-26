<?php

require_once dirname(__DIR__)."/config/install_params.php";

$awd_sdk        = '/opt/amazon/aws.phar';
$wcf_db_conn    = $wcf_db_conn_pdo = null;

$wcf_search_dirs = ['bizobj', 'mvc3/db'];

spl_autoload_register(function($class_name) {
    global $wcf_search_dirs;

	foreach ($wcf_search_dirs as $dir) {
		if (file_exists(__DIR__."/$dir/{$class_name}.php")) {
            require_once(__DIR__."/$dir/{$class_name}.php");
            return;
        }
    }
    if (!empty($GLOBALS['bizobj_extra']))
        if (file_exists("{$GLOBALS['bizobj_extra']}/{$class_name}.php"))
            require_once("{$GLOBALS['bizobj_extra']}/{$class_name}.php");
});

/**
 * Returns the current connection to the Wcf database. It opens it if necessary.
 * 
 * @return Sql
 */
function getDbConn() {
    require_once 'mvc3/db/db-pdo.php';

    global $db_dsn, $db_user, $db_passwd, $wcf_db_conn_pdo, $wcf_db_conn;

    if (empty($wcf_db_conn)) {
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

/**
 * Returns an AMX handle for use with the amazon AWS api.
 * 
 * @return Aws\S3\S3Client;
 */
function getAwsS3Client($params = null) {
    // the variables bellow are global to make sure that they are exported correctly from the config file.
    // do not remove unused ones.
    global $aws_key, $aws_secret, $aws_bucket;

    require_once "/opt/amazon/aws.phar";
    require_once dirname(__DIR__)."/config/s3_config.php";

    if (!$params) {
        $params = [
            'credentials' => [
                'key' 		=> $aws_key,
                'secret' 	=> $aws_secret
            ],
            'region' 	=> 'sa-east-1',
            'version'	=> '2006-03-01'
        ];
    }
    return new Aws\S3\S3Client($params);
}
