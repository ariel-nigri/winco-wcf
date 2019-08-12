<?php

class ServicePanel extends ServicePanelBase {	
	
	var $workerparams = array('worker_seq', 'worker_hostname', 'worker_frontend', 'worker_created', 'worker_last_boot', 'worker_ip', 'worker_old_ip', 'worker_active');
	
	var $title = "Worker";
		
	function init() {
		if (!empty($_REQUEST['instance'])) {
			$this->readParamsFromServer();
			$this->copyParamsFrom($this->workerparams);
		}
	}		
		
	function readParamsFromServer() {
		global $db_conn;

		$worker = new Workers;
		$worker->worker_seq = $_REQUEST['instance'];

		if (!$worker->select($db_conn))
			die('invalid parameter');

		$this->params['worker_seq'] = $worker->worker_seq;
		$this->params['worker_hostname'] = $worker->worker_hostname;
		$this->params['worker_frontend'] = $worker->worker_frontend;
		$this->params['worker_created'] = $worker->worker_created;
		$this->params['worker_last_boot'] = $worker->worker_last_boot;
		$this->params['worker_ip'] = $worker->worker_ip;
		$this->params['worker_old_ip'] = $worker->worker_old_ip;
		$this->params['worker_active'] = $worker->worker_active;				
	}
		
	function saveParamsToServer(&$error) {
		global $db_conn;
		$db_conn->begin();
		
		$worker = new Workers;
		$worker->worker_seq = $this->params['worker_seq'];
		$worker->worker_hostname = $this->params['worker_hostname'];
		$worker->worker_frontend = $this->params['worker_frontend'];
		$worker->worker_ip = $this->params['worker_ip'];
		$worker->worker_active = $this->params['worker_active'];
				
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			if (!$worker->update($db_conn)) {
				$db_conn->rollback();
				$error = "Erro atualizando worker: {$worker->error}";
				return false;
			}	
		} else {
			$worker->worker_created = date("Y-m-d H:i:s");;
			if (!$worker->insert($db_conn)) {
				$db_conn->rollback();
				$error = "Erro criando worker.";
				return false;
			}		
		}
		
		$db_conn->commit();
		return true;
	}	
	
	function beforeShow() {			
		$mainLayout =  "| 50% | 50% |
						-------------
						|           |
						|    2,1    |
						|___________|
						|_1,1_|_1,1_|";					
		$this->form->setLayoutManager(new TableLayout($mainLayout));
		
		$abas = new PageControl('pagecontrol1', '');		
		$abaConfig 	= $abas->addPage(new MvcContainer($this->form, 'pageConfig', 'Geral', 'div'));

		$config = new MvcBoxedContainer($this->form, 'config', '');
		$config->addControl(new CheckControl("worker_active", "Ativo"), CTLPOS_LABELRIGHT);
		$config->addControl(new RawControl('br', '<br />'));
		$config->addControl(new EditControl('worker_hostname', 'Hostname:', "size=\"40\""));
		$config->addControl(new EditControl('worker_frontend', 'FrontEnd:', "size=\"40\""));
		$config->addControl(new EditControl('worker_ip', 'IP:', "size=\"40\""));
		$abaConfig->addControl($config);		
		
		$this->form->addControl($abas);	
	}		
	
	function checkEmptyValues() {
		$ret = true;		
		
		if (!$this->form->data->worker_hostname)
			$ret = false;
		if (!$this->form->data->worker_frontend)
			$ret = false;
		if (!$this->form->data->worker_ip)
			$ret = false;
				
		return $ret;
	}	
	
	function onSave() {		
		if (!$this->checkEmptyValues()) {
			$this->form->setError("Preencha todos os campos.");
			return false;
		}
		
		$this->copyParamsTo($this->workerparams);
		if (!$this->saveParamsToServer($error)) {
			$this->form->setError($error);
			return false;
		}
		return true;
	}		
}
