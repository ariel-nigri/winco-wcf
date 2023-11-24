<?php

class ServicePanel extends ServicePanelBase {
	var $inst_params = array('worker_seq', 'inst_active', 'inst_version', 'inst_type', 'inst_license', 'inst_lang', 'inst_name',
		'inst_cnpj', 'inst_nusers', 'inst_num_of_passwd_to_store', 'inst_max_pwd_age', 'inst_expiration');
	var $inst_stat	 = array('inst_id', 'inst_created', 'inst_adm_port');

	var $lang = array('br' => 'Português', 'us' => 'Inglês');
	var $title;
	var $last_error;
	var $instance_class;
	var $do_stop;
	var $do_start;
	var $show_nusers;
	var $ch_license = false;

	function __construct() {
		global $product_code;
		$this->instance_class = $product_code. '_Instances';
		$this->show_nusers = !empty($GLOBALS['console_caps']['N_USERS']);
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
			$this->params['inst_license'] 	= $GLOBALS['default_license'];
			$this->params['inst_type'] 		= '';
			$this->params['inst_cnpj']		= '';
			$this->params['inst_nusers']	= 5;
			$this->params['inst_num_of_passwd_to_store']	= 0;
			$this->params['inst_max_pwd_age']	= 0;
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

		if ($this->show_nusers)
			$this->params['inst_nusers'] = $instance->inst_nusers;
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
		$this->params['inst_num_of_passwd_to_store']	= $instance->inst_num_of_passwd_to_store;
		$this->params['inst_max_pwd_age']	= $instance->inst_max_pwd_age;
		$this->params['inst_name'] = $instance->inst_name;
		$this->params['inst_expiration'] = $instance->inst_expiration;
		@$this->params['inst_cnpj'] = $instance->inst_cnpj;
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
		$instance->inst_cnpj = $this->params['inst_cnpj'];
		$instance->inst_num_of_passwd_to_store = $this->params['inst_num_of_passwd_to_store']; 
		$instance->inst_max_pwd_age = $this->params['inst_max_pwd_age'];
		$instance->inst_expiration = $this->params['inst_expiration'];

		if ($this->show_nusers)
			$instance->inst_nusers = $this->params['inst_nusers'];

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

		if ($this->ch_license)
			$instance->set_license($instance->inst_license);

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
		if (!empty($GLOBALS['console_caps']['INST_CNPJ']))
			$config->addControl(new EditControl("inst_cnpj", 'CNPJ:'));
		$config->addControl(new SelectControl("inst_lang", 'Idioma:', $this->lang));
		$config->addControl(new SelectControl("worker_seq", 'Worker:', $this->session->workers));
		$config->addControl(new SelectControl('inst_version', 'Versão do backend:', $versions /*, "size=\"40\"" */));
		$config->addControl(new EditControl('inst_type', 'Tipo ou Capabilites:', "size=\"40\""));
		$config->addControl(new RawControl('inst_expiration2', 'Expiração: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
			"<input type=\"date\" name=\"inst_expiration\" value=\"{$this->form->data->inst_expiration}\"></input>"));
		$config->addControl(new EditControl('inst_license', 'Licença:', "size=\"40\""));
		if ($this->show_nusers)
			$config->addControl(new EditControl('inst_nusers', 'Número de usuários:', "size=\"10\""));
		$config->addControl(new RawControl('xx1', '<br />'));
		$abaConfig->addControl($config);

		// Criamos o box de tornar ativa a instancia.
		$box_active = new MvcBoxedContainer($this->form, 'box_active', 'Inicialização da instância');
		$box_active->addControl(new CheckControl("inst_active", "Ativa"), CTLPOS_LABELRIGHT | CTLPOS_NOBREAK);
		$box_active->addControl(new LabelControl('advise', '<span style="color:red;">ATENÇÃO: instância inativa NÃO é monitorada e nem reiniciada em caso de falhas</span>'));
		$box_active->addControl(new CheckControl('startstop', "teste"), CTLPOS_LABELRIGHT);

		$abaConfig->addControl($box_active);

		$abaData 	= $abas->addPage(new MvcContainer($this->form, 'pageData', 'Parâmetros', 'div'));

		$box = new MvcBoxedContainer($this->form, 'pwd_policy', 'Política de senha para administradores desta instância');
		$box->addControl(new EditControl('inst_num_of_passwd_to_store', 'Número de senhas para guardar:', "size=\"10\""));
		$box->addControl(new EditControl('inst_max_pwd_age', 'Número de dias de validade da senha:', "size=\"10\""));
		$abaData->addControl($box); 

		if (!empty($this->params['inst_seq'])) {
			$this->title = "Alterar instância (#" . $this->params['inst_seq'].')';

			// show instance status info (port and ID)
			$stat = new MvcBoxedContainer($this->form, 'stat', 'Parâmetro da instância');
			$stat->addControl(new LabelControl('inst_id', 'Nome da instância:'));
			$stat->addControl(new LabelControl('inst_created', 'Data da criação:'));
			$stat->addControl(new LabelControl('inst_adm_port', 'Porta de administração:'));
			$config->addControl(new RawControl('xx2', '<br />'));

			$abaData->addControl($stat);
		}
        else
			$this->title = "Registrar nova instância";

		if (!empty($this->params['inst_seq'])) {
            $abaAdmins = $abas->addPage(new MvcContainer($this->form, 'pageAdmins', 'Administradores', 'div'));

            $usuinst = UsersInstances::find($db_conn, array("inst_seq" => $this->params['inst_seq']));
            $usuinst->del = false;

            $admins = new TableControl("admins", "Administradores", $usuinst);
            $admins->addColumn("usu_seq", "ID", 20);
            $admins->addColumn("usu_name", "Nome", 80);
            $admins->addColumn("usu_email", "Email", 100);
			$admins->addColumn("usuinst_privs", "Permissões", 100);
			if (!empty($GLOBALS['has_usu_master']))
				$admins->addColumn("usuinst_master", "Master", 50);

			$admins->addStaticColumn("del", "Delete", '[remove]');
			$admins->addEvent('del', 'del_admin', 'usuinst_seq');

			if (!empty($GLOBALS['has_usu_master'])) {
            	$admins->addStaticColumn("master", "", '[change master]');
				$admins->addEvent('master', 'change_master', 'usuinst_seq');
			}

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

	function change_master() {
		global $db_conn;

		$usuinst = new UsersInstances;
		$usuinst->usuinst_seq = $this->form->data->admins;
		if (!$usuinst->select($db_conn))
			die('Invalid users id');

		$usuinst->usuinst_master =  (int) (!$usuinst->usuinst_master);
		if (!$usuinst->update($db_conn))
			die($usuinst->error);
	}

	function checkEmptyValues() {
		return true;
	}	
	
	function onSave() {
		global $db_conn;

		if (!$this->checkEmptyValues()) {
			$this->form->setError($this->last_error);
			return false;
		}

		if (trim($this->params['inst_license']) != trim($this->form->data->inst_license))
			$this->ch_license = $this->do_stop = $this->do_start = true;

		if (trim($this->params['inst_version']) != trim($this->form->data->inst_version))
			true;

		if ($this->show_nusers) {
			if (trim($this->params['inst_nusers']) != trim($this->form->data->inst_nusers))
				$this->do_stop = $this->do_start = true;
		}
		
		if (!empty($this->params['inst_seq']) &&
			( $this->form->data->inst_num_of_passwd_to_store > $this->params['inst_num_of_passwd_to_store']
			||$this->form->data->inst_max_pwd_age < $this->params['inst_max_pwd_age']) )
			$must_check_users = true;
		else
			$must_check_users = false;

		$this->copyParamsTo($this->inst_params);

        if (empty($this->params['inst_license']))
            $this->params['inst_license'] = $GLOBALS['default_license'];

		if (!$this->saveParamsToServer()) {
			$this->form->setError($this->last_error);
			return false;
		}

		if ($must_check_users) {
			$uinst = UsersInstances::find($db_conn, [ 'inst_seq' => $this->params['inst_seq']] );
			while ($uinst->fetch()) {
				$user = new Users;
				if ($this->params['inst_max_pwd_age'] &&
						(!$uinst->usu_max_pwd_age || ($uinst->usu_max_pwd_age > $this->params['inst_max_pwd_age']) )) {
					$user->usu_max_pwd_age = $this->params['inst_max_pwd_age'];
					$user->usu_seq = $uinst->usu_seq;
				}

				if ($uinst->usu_num_of_passwd_to_store < $this->params['inst_num_of_passwd_to_store']) {
					$user->usu_num_of_passwd_to_store = $this->params['inst_num_of_passwd_to_store'];
					$user->usu_seq = $uinst->usu_seq;
				}

				if ($user->usu_seq)
					$user->update($db_conn);
			}
		}	
		return true;
	}
}
