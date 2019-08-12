<?php

require "../../common/config_master.php";

function cmp($a, $b) {   
    if ($a == $b)
		return 0;
    return ($a < $b) ? -1 : 1;
}

$result = array();

// if ($product_code == "WTM") {
// 	$instances = new WTM_Instances;
// 	unset($instances->inst_active);
// 	$instances->inst_seq = $_GET['inst_id'];
// 	if ($instances->select($db_conn)) {			
// 		while ($instances->fetch())
// 			$result[] = array($instances->inst_name . " <strong>(principal)</strong>", $instances->inst_email, "Acesso total", $instances->inst_lang == "us" ? "Ingl&ecirc;s" : "Portugu&ecirc;s");
// 	}			
// }
		
$users = new UsersInstances;
$users->inst_seq = $_GET['inst_id'];
if ($users->select($db_conn)) {				
	while($users->fetch()) {		
		switch (strtolower($users->usuinst_privs)) {										
			case 'a':
				$privs = "Acesso total";
				break;
			case 'c':
				$privs = "Configura&ccedil;&atilde;o";
				break;
			case 'v':
				$privs = "Visualiza&ccedil;&atilde;o";
				break;
		}		
		$result[] = array($users->usu_name, $users->usu_email, $privs, $users->usu_language == "us" ? "Ingl&ecirc;s" : "Portugu&ecirc;s", $users->usuinst_master);
	}	
}	

usort($result, "cmp");
