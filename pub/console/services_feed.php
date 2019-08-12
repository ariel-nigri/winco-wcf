<?php

require "config.php";
require "service_defs.php";

$prt_group = array();
	
foreach ($group_defs as $idgroup => $svc_list) {
    foreach ($svc_list as $idsvc => $svc_name) {
       if (!empty($service_defs[$svc_name]['virtual'])) {				
			$prt_group[] = array(
									'group' 		=> $service_defs[$idgroup]['desc'],
									'service' 		=> $svc_name,
									'instance' 		=> "",
									'name'			=> $service_defs[$svc_name]['desc'],
									'label' 		=> $service_defs[$svc_name]['desc'],
									'status' 		=> 'RUNNING',
									'idgroup'		=> $idgroup
								);
		} 	
	}
}

echo "([{running:",json_encode($prt_group),"}])";
