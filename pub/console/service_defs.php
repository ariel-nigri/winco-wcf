<?php

// group definitions
// Define the format and ordering of the service tree.
$group_defs = array();

if ($product_code == "WTM")
	$group_defs['REPORTS'] 	= array('ADMIN', 'INSTANCE', 'WORKER');
else
	$group_defs['REPORTS'] 	= array('ADMIN', 'INSTANCE', 'WORKER', 'USAGE');
	
// service definitions
// virutal services (not real winconnection services)
// real services (they actually exist in the software)
$service_defs = array();
$service_defs['REPORTS'] 					= array('desc' => "Administração", 		'virtual' => true);
$service_defs['WORKER'] 					= array('desc' => "Workers", 			'virtual' => true);
$service_defs['INSTANCE']					= array('desc' => "Inst&acirc;ncias", 	'virtual' => true);
$service_defs['ADMIN'] 						= array('desc' => "Administradores", 	'virtual' => true);
$service_defs['USAGE'] 						= array('desc' => "Uso da internet", 	'virtual' => true);
