<?php
/*
	Arquivo chamado exclusivamente pelo javascript para completar operacoes sobre os itens (tais como
	excluir, enviar uma mensagem.
*/

require "config.php";

if (empty($_REQUEST['service']) || empty($_REQUEST['id']) || empty($_REQUEST['cmd']))
	die('parametros invalidos. passe servico, id e comando');

$svc = $_REQUEST['service'];
$cmd = $_REQUEST['cmd'];
$id = $_REQUEST['id'];

$result = new stdclass;
$result->status = false;
$result->error = 'Unknown error';

if ($svc == "WORKER") {
	if ($cmd == "DEL") {
		$db_conn->begin();
		$worker = new Workers;
		$worker->worker_seq = $id;
		if ($worker->delete($db_conn)) {			
			$db_conn->commit();
			$result->status = true;
		} else {
			$db_conn->rollback();	
			$result->error = "Erro excluindo {$svc}";
		}	
	}
} else if ($svc == "ADMIN") {
	if ($cmd == "DEL") {
		$users = new Users;
		$users->usu_seq = $id;
		$db_conn = getDbConn();
		if ($users->delete($db_conn)) {
			$result->error = 'Usuário excluído com sucesso';
			$result->status = true;
		}
		else
			$result->error = "Erro excluindo usuário. Verifique se tem alguma instância associada";
	}
} else if ($svc == "INSTANCE") {
	$inst = $instance_classname::find(getDbConn(), array('inst_seq' => $id));
	if (!$inst)
		die("Instancia inexistente");
	if ($my_worker_hostname != $inst->worker_hostname)
		die('wrong worker');

	switch ($cmd) {
	case 'START':
		$inst->start();
		$result->status = true;
		$result->error = "Commando executado";
		break;
	case 'STOP':
		$inst->stop();
		$result->status = true;
		$result->error = "Commando executado";
		break;
	case 'RESTART':
		$inst->stop();
		$inst->start();
		$result->status = true;
		$result->error = "Commando executado";
		break;
	case 'STATUS':
		$result->error = "Comando nÃ£o implementado";
		break;
	default:
		$result->error = "Unknown command";
	}
	/*
	$c = curl_init('https://'.$base_domain.'/wsvc/instanceControl.wsvc'); 
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($c, CURLOPT_POSTFIELDS,
		array(
			'cmd' => $cmd,
			'id' => $id,
			'internal_cmd' => 1
		)
	);		
	
	$result = curl_exec($c);
	echo $result;
	exit;
	*/
} else if ($svc == "LICENSE") {
	if ($cmd == "DEL") {
		$db_conn->begin();
		$license = new NTP_RouterLicenses;
		$license->rtlic_seq = $id;
		if ($license->delete($db_conn)) {			
			$db_conn->commit();
			$result->status = true;
		} else {
			$db_conn->rollback();	
			$result->error = "Erro excluindo {$svc}";
		}	
	}
}

echo "(",json_encode($result),")";
