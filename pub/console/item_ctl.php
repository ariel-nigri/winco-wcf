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
}
else if ($svc == "ADMIN") {
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
}
else if ($svc == "INSTANCE") {
	$dbconn = getDbConn();
	if ($id != 'NONE') {
		$inst = $instance_classname::find($dbconn, array('inst_seq' => $id, 'inst_active' => null));
		if (!$inst || !$inst->valid)
			die("Instancia {$id} inexistente");
		if ($my_worker_hostname != $inst->worker_hostname)
			die("$my_worker_hostname != $inst->worker_hostname");
	}
	
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
		$result->error = "Comando não implementado";
		break;
	case 'SHOW_DISABLED':
		$_SESSION['view_disabled_instances'] = true;
		$result->error = 'Mostrando desativados';
		$result->status = true;
		break;
	case 'HIDE_DISABLED':
		$_SESSION['view_disabled_instances'] = false;
		$result->error = 'Escondendo desativados';
		$result->status = true;
		break;
	case 'DEL':
		if (strpos($inst->inst_type, 'TRIAL=Y') === false) {
			$result->error = "Somente instancias do tipo TRIAL podem ser excluídas";
			break;
		}

		// excluir usuario.
		$dbconn->begin();
		$usuinst = UsersInstances::find($dbconn, ['inst_seq' => $inst->inst_seq]);
		if ($usuinst->valid) {
			$ui = new UsersInstances;
			do {
				$del_users[] = $usuinst->usu_seq;
				$ui->usuinst_seq = $usuinst->usuinst_seq;
				$ui->delete($dbconn);
			} while ($usuinst->fetch());
	
			foreach ($del_users as $useq) {
				$usuinst = UsersInstances::find($dbconn, ['usu_seq' => $useq]);
				if (!$usuinst->valid) {
					$user = new Users;
					$user->usu_seq = $useq;
					if ($user->select($dbconn) && strpos($user->usu_caps, 'ADMIN') === false)
						$user->delete($dbconn);
				}
			}
		}

		// excluir
		// apagar diretorio.
		if ($inst->remove_directory() && $inst->delete($dbconn) && $dbconn->commit()) {
			$result->status = true;
			$result->error = "Instância excluída";
		}
		else {
			$result->error = $inst->error ? $inst->error : "Erro excluindo instância";
			$dbconn->rollback();
		}
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

}

else if ($svc == "LICENSE") {
	if ($cmd == "DEL") {
		$license = new NTP_RouterLicenses;
		$license->rtlic_seq = $id;
		$db_conn = getDbConn();
		if ($license->delete($db_conn)) {
			$result->status = true;
		}
		else {
			$result->error = "Erro excluindo {$svc}";
		}
	}
}

echo json_encode($result);
