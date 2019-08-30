<?php

class ServicePanel extends ServicePanelBase {	
	
	var $inst_params = array('worker_seq', 'inst_active', 'inst_version', 'inst_type', 'inst_license', 'inst_lang', 'inst_name');
	var $inst_stat	 = array('inst_id', 'inst_created', 'inst_adm_port');

	var $lang = array('br' => 'Português', 'us' => 'Inglês');
	var $title;
	var $last_error;
	var $instance_class;
	var $do_stop;
	var $do_start;

	function __construct() {
		global $product_code;
		$this->instance_class = $product_code. '_Instances';
	}

	function init() {
		global $db_conn, $product_code;

		// Query the list of workers and leave it in the form session.
		$workers = new Workers;
		if ($workers->select($db_conn)) {
			while ($workers->fetch())   
				$this->session->workers[$workers->worker_seq] = $workers->worker_hostname;
		}

		if (!empty($_REQUEST['instance'])) {
			//
			// Editing an existing instance
			//
			$this->readParamsFromServer();
			$this->copyParamsFrom($this->inst_stat);
		}
		else {
			// New instance. Defaults go here.
			$this->params['worker_seq']		= key($this->session->workers);
			$this->params['inst_lang'] 		= 'br';
			$this->params['inst_active'] 	= true;
			$this->params['inst_name'] 		= '';
			$this->params['inst_license'] 	= '';
			$this->params['inst_type'] 		= '';
			$this->params['inst_version'] 	= file_get_contents("{__DIR__}/../../../config/current_version_{$product_code}.cfg");
		}
		$this->copyParamsFrom($this->inst_params);
	}	
		
	function readParamsFromServer() {
		global $db_conn;

		$instance = new $this->instance_class;
		$instance->inst_seq = $_REQUEST['instance'];
		unset($instance->inst_active);

		if (!$instance->select($db_conn))
			die('invalid parameters');

		$this->params['inst_seq'] = $instance->inst_seq;
		$this->params['inst_id'] = $instance->inst_id;
		$this->params['worker_seq'] = $instance->worker_seq;
		$this->params['inst_created'] = $instance->inst_created;
		$this->params['inst_adm_port'] = $instance->inst_adm_port;
		$this->params['inst_active'] = $instance->inst_active;	
		$this->params['inst_version'] = $instance->inst_version;
		$this->params['inst_type'] = $instance->inst_type;
		$this->params['inst_license'] = $instance->inst_license;
		$this->params['inst_lang'] = $instance->inst_lang;
		$this->params['inst_name'] = $instance->inst_name;
	}
		
	function saveParamsToServer() {
		global $db_conn;
		
		$instance = new $this->instance_class;
		$instance->worker_seq = $this->params['worker_seq'];
		$instance->inst_name = $this->params['inst_name'];
		$instance->inst_lang = $this->params['inst_lang'];
		$instance->inst_type = $this->params['inst_type'];
		$instance->inst_license = $this->params['inst_license'];
		$instance->inst_active = $this->params['inst_active'];
		$instance->inst_version = $this->params['inst_version'];

		if (!empty($this->params['inst_seq'])) {
			$instance->inst_seq = $this->params['inst_seq'];
			if (!$instance->update($db_conn)) {
				$this->last_error = $instance->error;
				return false;
			}
		}
		else {
			if (!$instance->insert($db_conn)) {
				$this->last_error = $instance->error;
				return false;
			}

			// materialize at worker. Notice that since inst_seq is the primary key
			//if (!$this->instance_control('activate'))
			//	return false;
			if (!$instance->init_directory()) {
				$this->last_error = 'Cannot initialize instance files';
				return false;
			}
		}

		$should_start = $this->do_start;

		if ($this->do_stop) {
			$should_start = ($should_start && $instance->status());
			$instance->stop();
			$msg = "Instancia foi parada";
		}

		if ($should_start) {
			$msg = "Instancia foi Iniciada";

			if (!$instance->start())
				$msg= "Erro iniciando instância";
		}
		if (!empty($msg))
			$this->form->setError($msg);
		return true;
	}

	function instance_control($worker, $cmd, $params = null) {
		$c = curl_init('https://'.$this->session->workers[$this->params['worker_seq']].'/wsvc/instanceControl.wsvc'); 
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($c, CURLOPT_POSTFIELDS,
			array(
				'cmd' => $cmd,
				'id' => $this->params['inst_seq'],
				'internal_cmd' => 1
			)
		);			
		
		$resp = curl_exec($c);	
		if (!strstr($resp, " OK")) {
			$this->last_error = $resp;
			return false;
		}
		return true;
	}
	
	function beforeShow() {
		global $db_conn;
		
		exec("ls /home/instances/versions", $output);
		if (empty($this->form->data->inst_version))
			$this->form->data->inst_version = '-';
		$output[] = $this->form->data->inst_version;

		foreach ($output as $o)
			$versions[trim($o)] = $o;

		$mainLayout =  "| 50% | 50% |
						-------------
						|           |
						|    2,1    |
						|___________|
						|_1,1_|_1,1_|";					
		$this->form->setLayoutManager(new TableLayout($mainLayout));
		
		$abas = new PageControl('pagecontrol1', '');		
		$abaConfig 	= $abas->addPage(new MvcContainer($this->form, 'pageConfig', 'Instância', 'div'));

		$config = new MvcBoxedContainer($this->form, 'config', 'Cadastro do contratante');
		$config->addControl(new EditControl('inst_name', 'Nome da instância:', "size=\"40\""));
		$config->addControl(new SelectControl("lang", 'Idioma:', $this->lang));
		$config->addControl(new SelectControl("worker_seq", 'Worker:', $this->session->workers));
		$config->addControl(new SelectControl('inst_version', 'Versão do backend:', $versions /*, "size=\"40\"" */));
		$config->addControl(new EditControl('inst_type', 'Tipo ou Capabilites:', "size=\"40\""));
		$config->addControl(new EditControl('inst_license', 'Licença:', "size=\"40\""));
		$config->addControl(new RawControl('xx1', '<br />'));
		$abaConfig->addControl($config);

		if (!empty($this->params['inst_seq'])) {
			$this->title = "Alterar instância (#" . $this->params['inst_seq'].')';

			// show instance status info (port and ID)
			$stat = new MvcBoxedContainer($this->form, 'stat', 'Parâmetro da instância');
			$stat->addControl(new LabelControl('inst_id', 'Nome da instância:'));
			$stat->addControl(new LabelControl('inst_created', 'Data da criação:'));
			$stat->addControl(new LabelControl('inst_adm_port', 'Porta de administração:'));
			$config->addControl(new RawControl('xx2', '<br />'));

			$abaConfig->addControl($stat);
		}
        else
			$this->title = "Registrar nova instância";

		// Criamos o box de tornar ativa a instancia.
		$box_active = new MvcBoxedContainer($this->form, 'box_active', 'Inicialização da instância');
		$box_active->addControl(new CheckControl("inst_active", "Ativa"), CTLPOS_LABELRIGHT | CTLPOS_NOBREAK);
		$box_active->addControl(new LabelControl('advise', '<span style="color:red;">ATENÇÃO: instância inativa NÃO é monitorada e nem reiniciada em caso de falhas</span>'));
		$box_active->addControl(new CheckControl('startstop', "teste"), CTLPOS_LABELRIGHT);

		$abaConfig->addControl($box_active);

		if (!empty($this->params['inst_seq'])) {
            $abaAdmins = $abas->addPage(new MvcContainer($this->form, 'pageAdmins', 'Administradores', 'div'));

            $usuinst = UsersInstances::find($db_conn, array("inst_seq" => $this->params['inst_seq']));
            $usuinst->del = false;

            $admins = new TableControl("admins", "Administradores", $usuinst);
            $admins->addColumn("usu_seq", "ID", 20);
            $admins->addColumn("usu_name", "Nome", 80);
            $admins->addColumn("usu_email", "Email", 100);
            $admins->addColumn("usuinst_privs", "Permissões", 100);
            $admins->addStaticColumn("del", "Delete", '[remove]');
            $admins->addEvent('del', 'del_admin', 'usuinst_seq');

            $abaAdmins->addControl($admins);

            $abaAdmins->addControl(new EditControl("new_admin", "Novo admin (e-mail)"), CTLPOS_NOBREAK);
            $abaAdmins->addControl(new ButtonControl("add_admin", "Adicionar"));
        }
		$this->form->addControl($abas);
		$this->form->addJsOnReady("startJs()");
	}		
	
	function add_admin() {
		global $db_conn;

		if (!empty($this->form->data->new_admin)) {
			$usu = Users::find($db_conn, array('usu_email' => $this->form->data->new_admin));
			if (!$usu->valid) {
				$this->form->setError('Usuário não encontrado');
				return;
			}
			$usuinst = new UsersInstances;
			$usuinst->inst_seq = $this->params['inst_seq'];
			$usuinst->usu_seq = $usu->usu_seq;
			$usuinst->usuinst_privs = 'A';
			if (!$usuinst->insert($db_conn)) {
				$this->form->setError($usuinst->error);
				return;
			}
			$this->form->data->new_admin = '';
		}
	}

	function del_admin() {
		global $db_conn;

		$usuinst = new UsersInstances;
		$usuinst->usuinst_seq = $this->form->data->admins;
		if (!$usuinst->delete($db_conn))
			die('Invalid users id');
	}

	function checkEmptyValues() {
		return true;
	}	
	
	function onSave() {
		if (!$this->checkEmptyValues()) {
			$this->form->setError($this->last_error);
			return false;
		}

		if (trim($this->params['inst_version']) != trim($this->form->data->inst_version))
			$this->do_stop = $this->do_start = true;

		$this->copyParamsTo($this->inst_params);
        if (empty($this->params['inst_license']))
            $this->params['inst_license'] = $GLOBALS['default_license'];

		if (!$this->saveParamsToServer()) {		
			$this->form->setError($this->last_error);
			return false;
		}
		return true;
	}		
}
