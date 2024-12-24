<?php

require "config.php";

// actions
if (empty($_SESSION['view_disabled_instances'])) {
	$show_disabled 		= 'SHOW_DISABLED';
	$show_disabled_str	= 'Mostrar inativas';
}
else {
	$show_disabled 		= 'HIDE_DISABLED';
	$show_disabled_str	= 'Esconder inativas';
}

$instance_actions = "[
	{ cmd: 'START', 			label: 'Iniciar', 					item: true},
	{ cmd: 'STOP', 				label: 'Parar', 					item: true},
	{ cmd: 'RESTART', 			label: 'Reiniciar',					item: true},
	{ cmd: 'STATUS', 			label: 'Ver status',				item: true},
	{ cmd: 'SUPPORT_INST',		label: 'Login de suporte', 			item: true},
	{ cmd: '{$show_disabled}',	label: '{$show_disabled_str}',		item: false}
]";

$instance_register = "[
	{ cmd: 'NEW', 				label: 'Criar instância',			item: false},
	{ cmd: 'EDIT', 				label: 'Ver / Alterar cadastro',	item: true},
	{ cmd: 'DEL',				label: 'Excluir instância',			item: true}
]";

$vds_ops = "[
	{ cmd: 'LOST_MEDIA_REPORT',	label: 'Relatório de mídias para baixar', item: true }
]";

$admin_actions = $worker_register = "[
	{ cmd: 'NEW',				label: 'Cadastrar novo',		item: false},
	{ cmd: 'EDIT',				label: 'Ver / Alterar',			item: true},
	{ cmd: 'DEL',				label: 'Excluir',				item: true}
]";

function list_workers($refresh) {
	global $workername, $my_worker_names, $our_worker_seqs, $filtersList, $string_workers;

	$db_conn = getDbConn();
	$workers = new Workers;
	if ($workers->select($db_conn)) {			
		while ($workers->fetch()) {
			$workername[$workers->worker_seq] = $workers->worker_hostname;
			if (in_array($workers->worker_hostname, $my_worker_names))
				$our_worker_seqs[] = $workers->worker_seq;
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

	exec("ps aux | grep {$binname} | grep -v grep | awk '{ print \$13\" \"\$2}'", $procs);
	foreach ($procs as $proc) {
		$dir=strtok($proc, ' ');
		$pid=strtok(" \n");
		$arr=explode('/', $dir);
		$inst_status[$arr[3]]['status'] = "PID {$pid}";
	}	
}

$response = array();
$workername = array();
$our_worker_seqs = [];
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
		$instances->inst_active = empty($_SESSION['view_disabled_instances']) ? true: null;
		if ($instances->select(getDbConn())) {
			while ($instances->fetch()) {
				$lang = $instances->inst_lang == "us" ? "Ingl&ecirc;s" : "Portugu&ecirc;s";
				$act =  $instances->inst_active ? "Sim" : "N&atilde;o";
				$response[] = array($instances->inst_seq, $instances->inst_id, $instances->inst_created,
									utf8_encode($instances->inst_name),
									$instances->inst_license, $instances->inst_type, $instances->inst_version,
									strtok($workername[$instances->worker_seq], '.'), $instances->inst_adm_port, $lang, $act,
									!empty($inst_status[$instances->inst_seq]['status']) ? $inst_status[$instances->inst_seq]['status'] : 
									( in_array($instances->worker_seq, $our_worker_seqs) ? 'off' : '-'),
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
		{ label:'Versão', width: 60 },
		{ label:'Worker', width: 70 },
		{ label:'Admin port', width: 80 },
		{ label:'Idioma do servidor', width: 110 },
		{ label:'Ativa', width: 45 },
		{ label:'Status', width: 70, sync: true },
		{ label:'Status time', width: 120 }],  
			defcols: [0, 1, 3, 5, 6, 7, 9, 10, 11], actions: {$instance_actions}, register: {$instance_register}, filters: [{
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
			defcols: [1, 2, 3, 4], register: {$worker_register}, ";
		break;
	case 'ADMIN':
		$inst_users = UsersInstances::getUsersByInstance(getDbConn());
		$admins = new Users;
		$privs = 'admin';
		if ($admins->select(getDbConn())) {
			while ($admins->fetch()) {
				$lang = 'Português';
				switch ($admins->usu_language) {
				case 'us':
					$lang = 'Ingl&ecirc;s';
					break;
				case 'it':
					$lang = 'Italiano';
					break;
				case 'fr':
					$lang = 'Franc&ecirc;s';
					break;
				case 'de':
					$lang = 'Alem&atilde;o';
					break;
				case 'es':
					$lang = 'Espanhol';
					break;
				}
				$usu_name = $admins->usu_name;
				$inst = '';
				if (!empty($inst_users[$admins->usu_seq]))
					$inst = implode(', ', $inst_users[$admins->usu_seq]);
				$response[] = array($admins->usu_seq, utf8_encode($usu_name), $admins->usu_email, empty($admins->usu_caps) ? '-' : $admins->usu_caps, $lang, $inst);
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
	case 'USAGE':
		// list network usage by vpn instances
		require "usage_feed.php";
		$response = generate_usage_feed();
		$list_format = 	"title:'Uso da internet', label: 'Uso da internet', format: [
			{ label:'ID', width: 40, id: true },
			{ label:'2 min', width: 150, type: 'quantity' },
			{ label:'Dia', width: 150, type: 'quantity' },
			{ label:'Mês', width: 150, type: 'quantity' },
			{ label:'Desde o boot', width: 150, type: 'quantity' }],
				defcols: [0, 1, 2, 3, 4], actions: [], register: [], ";
		break;
}

echo "({",$list_format,"data: \r\n", json_encode($response),"})";