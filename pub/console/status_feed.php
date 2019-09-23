<?php

require "config.php";

// actions
$instance_actions = "[
	{ cmd: 'START', 			label: 'Iniciar', 					item: true},
	{ cmd: 'STOP', 				label: 'Parar', 					item: true},
	{ cmd: 'RESTART', 			label: 'Reiniciar',					item: true},
	{ cmd: 'STATUS', 			label: 'Ver status',				item: true},
	{ cmd: 'SUPPORT_INST',		label: 'Login de suporte', 			item: true}
]";

$instance_register = "[
	{ cmd: 'NEW', 				label: 'Criar instância',			item: false},
	{ cmd: 'EDIT', 				label: 'Ver / Alterar cadastro',	item: true},
	{ cmd: 'DEL',				label: 'Excluir instância',			item: true}
]";

$admin_actions = $worker_actions = $license_actions = "[
	{ cmd: 'NEW',				label: 'Cadastrar novo',		item: false},
	{ cmd: 'EDIT',				label: 'Ver / Alterar',			item: true},
	{ cmd: 'DEL',				label: 'Excluir',				item: true},
]";

function list_workers($refresh) {
	global $workername, $filtersList, $string_workers;
	
	$db_conn = getDbConn();
	$workers = new Workers;
	if ($workers->select($db_conn)) {			
		while ($workers->fetch()) {
			$workername[$workers->worker_seq] = $workers->worker_hostname;
			$filtersList['worker'][] = $workers->worker_hostname;
		}
	} 

	sort($filtersList['worker']);  
		
	if ($refresh == 0) {
		$ret = json_encode($filtersList);
		$tok = strtok($ret, ':');
		$string_workers = strtok('}');
	} else
		$string_workers = '[]';
}

function get_inst_status(&$inst_status) {
	global $binname;

	$inst_status = $procs = array();

	exec("ps aux | grep {$binname} | grep -v grep | awk '{ print \$15\" \"$2}'", $procs);
	foreach ($procs as $proc)
		$inst_status[strtok($proc, ' ')]['status'] = "PID ".strtok('');
}

$response = array();
$workername = array();
$filtersList['worker'] = array();
$string_workers = array();

switch ($_REQUEST['service']) {	
	case 'INSTANCE':
		// list workers
		list_workers($_REQUEST['refresh']);

		// get inst status		
		$inst_status = array();
		get_inst_status($inst_status);
		
		// list instances
		$instances = new Instances;
		unset($instances->inst_active);
		if ($instances->select(getDbConn())) {
			while ($instances->fetch()) {
				$lang = $instances->inst_lang == "us" ? "Ingl&ecirc;s" : "Portugu&ecirc;s";
				$act =  $instances->inst_active ? "Sim" : "N&atilde;o";
				$response[] = array($instances->inst_seq, $instances->inst_id, $instances->inst_created,
									$instances->inst_name,
									$instances->inst_license, $instances->inst_type,
									$workername[$instances->worker_seq], $instances->inst_adm_port, $lang, $act,
									!empty($inst_status[$instances->inst_seq]['status']) ? $inst_status[$instances->inst_seq]['status'] : 'off',
									!empty($inst_status[$instances->inst_seq]['last_change']) ? $inst_status[$instances->inst_seq]['last_change'] : 'unknown');
			}
		}

		$list_format = 	"title:'Inst&acirc;ncias', label: 'Inst&acirc;ncias', format: [
		{ label:'Inst&acirc;ncia', id: true, width: 60 },
		{ label:'ID', width: 120 },
		{ label:'Criação', width: 90 },
		{ label:'Registrado para', width: 200 },
		{ label:'Licença', width: 250 },
		{ label:'Recursos', width: 150 },
		{ label:'Worker', width: 230 },
		{ label:'Admin port', width: 80 },
		{ label:'Idioma do servidor', width: 110 },
		{ label:'Ativa', width: 45 },
		{ label:'Status', width: 70, sync: true },
		{ label:'Status time', width: 120 }],  
			defcols: [0, 1, 3, 5, 8, 9, 10], actions: {$instance_actions}, register: {$instance_register}, filters: [{
                    multi: true,
                    name: 'Workers',
                    choices: ".$string_workers."}], ";
		break;
	case 'WORKER':
		$workers = new Workers;
		if ($workers->select(getDbConn())) {			
			while ($workers->fetch())   
				$response[] = array($workers->worker_seq, $workers->worker_hostname, $workers->worker_frontend, $workers->worker_ip, $workers->worker_active ? "Sim" : "N&atilde;o", $workers->worker_created, $workers->worker_last_boot);
		}			

		$list_format = 	"title:'Workers', label: 'Workers', format: [
		{ label:'ID', id: true, width: 50 },
		{ label:'Hostname', width: 250 },
		{ label:'FrontEnd', width: 250 },		
		{ label:'IP', width: 130 },
		{ label:'Ativo', width: 60 },
		{ label:'Criação', width: 120 },
		{ label:'Último boot', width: 120 }], 
			defcols: [1, 2, 3, 4], register: {$worker_actions}, ";
		break;
	case 'ADMIN':
		$inst_users = UsersInstances::getUsersByInstance(getDbConn());
		$admins = new Users;
		$privs = 'admin';
		if ($admins->select(getDbConn())) {
			while ($admins->fetch()) {
				$lang = $admins->usu_language == "us" ? "Ingl&ecirc;s" : "Portugu&ecirc;s";
				$usu_name = $admins->usu_name;
				$inst = '';
				if (!empty($inst_users[$admins->usu_seq]))
					$inst = implode(', ', $inst_users[$admins->usu_seq]);
				$response[] = array($admins->usu_seq, $usu_name, $admins->usu_email, empty($admins->usu_caps) ? '-' : $admins->usu_caps, $lang, $inst);
			}
		}

		$list_format = 	"title:'Administradores', label: 'Administradores', format: [
		{ label:'ID', id: true, width: 60 },
		{ label:'Nome', width: 250 },
		{ label:'E-mail', width: 250 },				
		{ label:'Permiss&otilde;es', width: 100 },
		{ label:'Idioma do portal', width: 110 },
		{ label:'Inst&acirc;ncia', width: 70 }], 
			defcols: [1, 2, 3, 4, 5], register: $admin_actions, ";
		break;
	case 'LICENSE':
		$instname = array();
		$instances = new Instances;
		if ($instances->select(getDbConn())) {
			while ($instances->fetch()) 
				$instname[$instances->inst_seq] = $instances->inst_name;
		}
		
		$licenses = new NTP_RouterLicenses;
		if ($licenses->select(getDbConn())) {			
			while ($licenses->fetch())
				$response[] = array($licenses->rtlic_seq, $licenses->rtlic_id, $licenses->rtlic_caps, $licenses->rtlic_owner,
									$licenses->inst_seq, $licenses->inst_seq == 0 ? "" : utf8_encode(@$instname[$licenses->inst_seq]),
									$licenses->rtlic_created, $licenses->rtlic_allocated);
		}

		$list_format = 	"title:'Licen&ccedil;as', label: 'Licen&ccedil;as', format: [
		{ label:'ID', id: true, width: 60 },
		{ label:'Licença', width: 250 },
		{ label:'Capabilities', width: 250 },
		{ label:'Dono', width: 250 },
		{ label:'Instância', width: 70 },
		{ label:'Nome instância', width: 250 },
		{ label:'Criação', width: 130 },
		{ label:'Alocação', width: 130 }], 
			defcols: [1, 2, 3, 4, 5, 6], register: $license_actions, ";
		break;
	case 'CONNECTIONS':
		// list workers
		$workers = new Workers;
		if ($workers->select($db_conn)) {			
			while ($workers->fetch())
				$worker[$workers->worker_ip] = $workers->worker_hostname;
		} 
		
		// list instances
		$instance_name = $instance_id = array();
		if ($product_code == "NTP")
			$instances = new NTP_Instances;
		else if ($product_code == "WTM")
			$instances = new WTM_Instances;
				
		if ($instances->select($db_conn)) {			
			while ($instances->fetch()) {
				if ($product_code == "NTP") {
					$instance_name[$instances->inst_sync_port] = $instances->inst_name;	
					$instance_id[$instances->inst_sync_port] = $instances->inst_seq;
				} else if ($product_code == "WTM") {
					$instance_name[$instances->inst_pol_port] = $instances->inst_name;	
					$instance_id[$instances->inst_pol_port] = $instances->inst_seq;
				}
			}
		}	
		
		if ($wc_conn->exec("@HTTP:LIST_CONNECTIONS", $send_params, $connections)) {
			if (isset($connections['CONNECTIONS'])) {
				foreach ($connections['CONNECTIONS'] as $conn) {
					if ($conn['SVC_NAME'] == "https://" . $conn['IP_TO'])
						$response[] = array($conn['ID'], $conn['IP_FROM'], $_SERVER['HOSTNAME'], $worker[$conn['IP_TO']], $instance_id[$conn['PORT_TO']], utf8_encode($instance_name[$conn['PORT_TO']]), @date('H:i:s', $conn['START_TIME']));
				}
			}
		}
		
		$list_format = 	"title:'Conex&otilde;es', label: 'Conex&otilde;es', format: [
		{ label:'ID', width: 60 },
		{ label:'IP', width: 130 },
		{ label:'FrontEnd', width: 250 },
		{ label:'Worker', width: 250 },				
		{ label:'Instância', width: 80 },
		{ label:'Nome da instância', width: 300 },
		{ label:'Hora inicial', width: 80 }], 
			defcols: [1, 2, 3, 4, 5, 6], ";	
		break;
	case 'DEVICES':
		// list workers
		$devices = new VirtualDevice;
		if ($devices->select(getDbConn())) {			
			while ($devices->fetch())
				$response[] = array("{$devices->vd_seq}", "{$devices->inst_seq}", "{$devices->vd_s_index}",
					$devices->vd_owner,  $devices->vd_key, $devices->vd_number, "{$devices->vd_status}");
		} 
		
		$list_format = 	"title:'Dispositivos', label: 'Dispositivos', format: [
		{ label:'ID', width: 40, id: true },
		{ label:'Inst.', width: 60 },
		{ label:'Índice', width: 60 },
		{ label:'Owner', width: 150 },				
		{ label:'Chave', width: 150 },
		{ label:'Número', width: 150 },
		{ label:'Status', width: 60 }], 
			defcols: [0, 1, 2, 3, 4, 5, 6], ";	
		break;
}

echo "({",$list_format,"data: \r\n", json_encode($response),"})";