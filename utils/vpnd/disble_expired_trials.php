#!/bin/php
<?php
ini_set("include_path", dirname(dirname(__DIR__))."/common");
$product_code = 'VPND';
require "wcf.php";

$wcf_search_dirs[] = 'mvc';

$db_conn = getDbConn();

//
// Find expired  trial instances
//
$max_expiration_date = new DateTime();
$max_expiration_date->modify('-2 day');			//We give 2 grace days
$instances = $instance_classname::find($db_conn, array(
    'inst_active' =>  1,
    'inst_expiration' => SqlExpr('<', $max_expiration_date->format('Y-m-d')),
	 'inst_type' => SqlExpr('like', '%TRIAL=Y%')
));
if (!$instances->valid) {
    echo "Nenhuma trial expirada\r\n";  //*** usar slog()
    exit;
}

while ($instances->fetch()) {
    //echo  $instances->inst_seq . ' -- ' . $instances->inst_expiration . "\r\n";
	 $sh = $instances->getShadow($db_conn);
	 //
	 //Stop instance
	 //
	 $sh->stop();
	 
	 //
	 // Disable instance
	 //
	 $sh->inst_active = 0;
	 unset ($sh->inst_expiration); 
	 if (!$sh->update($db_conn)) {
			echo 'Erro desativando instancia ' .  $sh->inst_seq . ':  ' . $sh->error .  "\r\n";
	 }
	 
	 
	 echo 'Instância ' . $instances->inst_seq . " desativada\r\n";
	 
}
 
