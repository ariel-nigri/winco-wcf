<?php

// group definitions
// Define the format and ordering of the service tree.
$group_defs = array();

if ($product_code == "WTM")
	$group_defs['REPORTS'] 	= array('ADMIN', 'INSTANCE', 'WORKER');
else
	$group_defs['REPORTS'] 	= array('ADMIN', 'INSTANCE', 'WORKER', 'LICENSE');
	
// service definitions
// virutal services (not real winconnection services)
// real services (they actually exist in the software)
$service_defs = array();
//$service_defs['CONNECTIONS'] 				= array('desc' => "Conex&otilde;es",	'virtual' => true);
$service_defs['REPORTS'] 					= array('desc' => $product_name,		'virtual' => true);
$service_defs['WORKER'] 					= array('desc' => "Workers", 			'virtual' => true);
$service_defs['INSTANCE']					= array('desc' => "Inst&acirc;ncias", 	'virtual' => true);
$service_defs['ADMIN'] 						= array('desc' => "Administradores", 	'virtual' => true);
if ($console_caps['LICENSES'])
	$service_defs['LICENSE'] 					= array('desc' => "Licen&ccedil;as", 	'virtual' => true);
