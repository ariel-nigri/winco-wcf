<?php

define("CHECK_PASS", "XXX_check_123");

class ServicePanel extends ServicePanelBase {	
	
	var $instparams = array('inst_seq', 'inst_id', 'worker_seq', 'inst_email', 'inst_passwd', 'inst_created', 'inst_adm_port', 'inst_msn_port', 'inst_pol_port', 'inst_active',
							'inst_name', 'inst_cnpj', 'inst_phone', 'inst_type', 'inst_license', 'inst_nusers', 'inst_passwd_digest', 'inst_lang', 'type', 'license', 'nusers',
							'inst_num_of_passwd_to_store', 'inst_max_pwd_age');
	
	var $lang = array("br" => "Português", "us" => "Inglês");
	
	var $planos = array(	
						'St' => 'Standard',
						'Pr' => 'Professional',
						'En' => 'Enterprise',
						'Fr' => 'Free',
						'CUSTOM' => ' - Personalizado - '
					);
	
	var $capabilities = array(	
								'St' => 'WTMGC=N,WTMHIST=12,WTMAD=N,WTMAR=10',
								'Pr' => 'WTMGC=Y,WTMHIST=24,WTMAD=N,WTMAR=60',
								'En' => 'WTMGC=Y,WTMHIST=65,WTMAD=Y,WTMAR=1000',
								'Fr' => 'WTMGC=N,WTMHIST=6,WTMAD=N,WTMAR=0',
								'CUSTOM' => 'WTMGC=,WTMHIST=,WTMAD=,WTMAR='
							);
					
	function init() {
		//if (empty($_REQUEST['instance'])) {
		//	header('Location: svc_config.php?service=WTM_NEW_INSTANCE');
		//	exit;
		//}
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			$this->readParamsFromServer();
			$this->copyParamsFrom($this->instparams);
			
			// save current email
			if (!isset($_REQUEST['update_lic']))
				$this->session->email = $this->params['inst_email'];
		}
		
		// list workers
		if (!isset($_REQUEST['update_lic'])) {
			global $db_conn;
			
			$this->session->workers[] = " - worker default - ";
			
			$workers = new Workers;
			if ($workers->select($db_conn)) {			
				while ($workers->fetch())   
					$this->session->workers[$workers->worker_seq] = $workers->worker_hostname;
			}
		}
	}	
		
	function readParamsFromServer() {
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			global $db_conn;
			$instance = new WTM_Instances;
			unset($instance->inst_active);
			$instance->inst_seq = $_REQUEST['instance'];
			if ($instance->select($db_conn)) {			
				$instance->fetch(); 
				if (isset($_REQUEST['update_lic'])) {
					$this->params['type'] = $instance->inst_type;
					$this->params['license'] = $instance->inst_license;
					$this->params['nusers'] = $instance->inst_nusers;
					$this->params['inst_name'] = $instance->inst_name;
					$this->params['inst_seq'] = $instance->inst_seq;					
					
					$aux_cap = array_flip($this->capabilities);
					if ($this->params['type'] == "P") {
						$this->params['type'] = 'En';
						$this->form->data->personalizado = $this->capabilities['En'];
					} else if ($this->params['type'] == "F") {
						$this->params['type'] = 'Fr';
						$this->form->data->personalizado = $this->capabilities['Fr'];
					} else if (!array_key_exists($this->params['type'], $aux_cap)) {
						$this->form->data->personalizado = $this->params['type'];
						$this->params['type'] = 'CUSTOM';
					} else {						
						$this->form->data->personalizado = $this->params['type'];
						$this->params['type'] = $aux_cap[$this->params['type']];
					}
				} else {
					$this->params['inst_seq'] = $instance->inst_seq;
					// $this->params['inst_email'] = $instance->inst_email;
					// $this->params['inst_passwd'] = $instance->inst_passwd;
					// $this->params['inst_passwd_digest'] = $instance->inst_passwd_digest;
					$this->params['inst_active'] = $instance->inst_active;
					$this->params['inst_name'] = $instance->inst_name;
					$this->params['inst_cnpj'] = $instance->inst_cnpj;
					$this->params['inst_phone'] = $instance->inst_phone;
					$this->params['inst_max_pwd_age'] = $instance->inst_max_pwd_age;
					$this->params['inst_num_of_passwd_to_store'] = $instance->inst_num_of_passwd_to_store;

					$this->form->data->password = $this->form->data->password_again = CHECK_PASS;
				}
			}	
		} 
	}
		
	function saveParamsToServer(&$error) {
		global $base_domain;
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
						
			if (isset($_REQUEST['update_lic'])) {
				
				if ($this->form->data->type == "CUSTOM")
					$new_type = $this->form->data->personalizado;
				else
					$new_type = $this->capabilities[$this->form->data->type];
				
				$c = curl_init('https://'.$base_domain.'/wsvc/updateinstance.wsvc'); 
				curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($c, CURLOPT_POST, 1);
				curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($c, CURLOPT_POSTFIELDS,
					array(
						'license' => $this->form->data->license,
						'nusers' => $this->form->data->nusers,	
						"type" => $new_type,
						"index" => $this->params['inst_seq'],
						'internal_cmd' => 1
					)
				);			
				
				$resp = curl_exec($c);	
				if (strstr($resp, "ERROR:")) {
					$error = $resp;
					return false;
				} else 	if (strstr($resp, "OK")) {	
					return true;
				} else {
					$error = "Erro atualizando instância: " . $resp;
					return false;
				}
				
			}
			else {
				global $db_conn;
				$db_conn->begin();
				
				// $instance = new WTM_Instances;
				// unset($instance->inst_active);
				// $instance->inst_email = $this->params['inst_email'];
				// if ($instance->select($db_conn) && $this->params['inst_email'] != $this->session->email) {	
				// 	$db_conn->rollback();
				// 	$error = "E-mail já cadastrado.";
				// 	return false;
				// }
				
				// $user = new Users;
				// $user->usu_email = $this->params['inst_email'];
				// if ($user->select($db_conn)) {	
				// 	$db_conn->rollback();
				// 	$error = "E-mail já cadastrado.";
				// 	return false;
				// }			
				$instance = new WTM_Instances;
				$instance->inst_active = $this->params['inst_active'];
				$instance->inst_seq = $this->params['inst_seq'];
				// $instance->inst_email = $this->params['inst_email'];
				$instance->inst_name = $this->params['inst_name'];
				$instance->inst_cnpj = $this->params['inst_cnpj'];
				$instance->inst_phone = $this->params['inst_phone'];
				$instance->inst_num_of_passwd_to_store = $this->params['inst_num_of_passwd_to_store'];
				$instance->inst_max_pwd_age = $this->params['inst_max_pwd_age'];

				// if ($this->form->data->password != CHECK_PASS && $this->form->data->password_again != CHECK_PASS) {
				// 	$instance->inst_passwd_digest = $this->form->data->password;
				// 	$instance->setPassword($instance->inst_passwd_digest);
				// }
				
				if (!$instance->update($db_conn)) {
					$db_conn->rollback();
					$error = "Erro atualizando instância.";
					return false;
				}				
				if (isset($this->form->data->startstop)) {
					$cmd = $this->params['inst_active'] ? "start" : "stop";

					$c = curl_init('https://'.$base_domain.'/wsvc/instanceControl.wsvc'); 
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
						$db_conn->rollback();
						$error = $resp;
						return false;
					} 
				}
				
				$db_conn->commit();	
				
				return true;
			}
		} else {
			if ($this->form->data->type == "CUSTOM")
				$new_type = $this->form->data->personalizado;
			else
				$new_type = $this->capabilities[$this->form->data->type];
					
			$c = curl_init('https://'.$base_domain.'/wsvc/createnewinstance.wsvc'); 
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_POST, 1);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($c, CURLOPT_POSTFIELDS,
				array(
					'license' => $this->form->data->license,
					'name' => $this->form->data->name,
					'cnpj' => $this->form->data->cnpj,	
					'email' => $this->form->data->email,
					'password' => $this->form->data->password,
					'nusers' => $this->form->data->nusers,	
					"type" => $new_type,
					"lang" => $this->form->data->lang,
					"worker_seq" => $this->form->data->worker_seq,
					"phone" => $this->form->data->phone,
					'internal_cmd' => 1
				)
			);			
			
			$resp = curl_exec($c);	
			if (strstr($resp, "ERROR:")) {
				$error = $resp;
				return false;
			} else 	if (strstr($resp, "OK")) {	
				return true;
			} else {
				$error = "Erro criando instância: " . $resp;
				return false;
			}
		}
		
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
		$abaConfig 	= $abas->addPage(new MvcContainer($this->form, 'pageConfig', '', 'div'));
		
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			if (isset($_REQUEST['update_lic'])) {
				$this->title = "Licenciamento";
				
				$info = new MvcBoxedContainer($this->form, 'info', 'Informações da instância');
				$info->addControl(new LabelControl('sequencia', 'Instância: ' . $this->params['inst_seq']));
				$info->addControl(new LabelControl('nome', 'Nome: ' . $this->params['inst_name']));
				$abaConfig->addControl($info);
				
				$abaConfig->addControl(new RawControl('br1', '<br />'));
				
				$config = new MvcBoxedContainer($this->form, 'config', 'Licença');				
				$config->addControl(new SelectControl("type", 'Tipo de licenciamento:', $this->planos));
				$config->addControl(new EditControl('personalizado', 'Recursos', "size=\"50\""), CTLPOS_NOBREAK);
				$config->addControl(new LinkControl("link", '(?)', ""));		
				$config->addControl(new EditControl('license', 'Licença:', "size=\"50\""));
				$config->addControl(new EditControl('nusers', 'Número de usuários:', "size=\"50\""));	
				$abaConfig->addControl($config);
			} else {				
				$this->title = "Alterar instância (#" . $this->params['inst_seq'].')';
				
				$box_active = new MvcBoxedContainer($this->form, 'box_active', 'Situação da instância');
				$box_active->addControl(new CheckControl("inst_active", "Ativa"), CTLPOS_LABELRIGHT | CTLPOS_NOBREAK);
				$box_active->addControl(new LabelControl('advise', '<span style="color:red;">ATENÇÃO: instância inativa NÃO é monitorada e nem reiniciada em caso de falhas</span>'));		
				$box_active->addControl(new CheckControl('startstop', "teste"), CTLPOS_LABELRIGHT);
				$abaConfig->addControl($box_active);	
				
				$abaConfig->addControl(new RawControl('br1', '<br />'));
				
				$box_register = new MvcBoxedContainer($this->form, 'box_register', 'Cadastro do contratante');
				$box_register->addControl(new EditControl('inst_name', 'Nome:', "size=\"40\""));
				$box_register->addControl(new EditControl('inst_cnpj', 'CPF/CNPJ:', "size=\"40\""), CTLPOS_NOBREAK);
				$box_register->addControl(new LabelControl('obs_cnpj', '* digite apenas números'));
				$box_register->addControl(new EditControl('inst_phone', 'Telefone:', "size=\"40\""));
				$abaConfig->addControl($box_register);				
				
				$abaConfig->addControl(new RawControl('br2', '<br />'));

				$security = new MvcBoxedContainer($this->form, 'security', 'Política de Senha');
				$security->addControl(new EditControl("inst_num_of_passwd_to_store", "Salvar as ultimas N senhas:"));
				$security->addControl(new EditControl("inst_max_pwd_age", "Validade da senha (em dias):"));
				$security->addControl(new RawControl('lbl1', '<div>*As alterações dos valores acima não alterará os valores dos administradores já existentes</span>'));
				$abaConfig->addControl($security);
					
				
				// $box_admin = new MvcBoxedContainer($this->form, 'box_admin', 'Credenciais do administrador principal');
				// $box_admin->addControl(new EditControl('inst_email', 'E-mail:', "size=\"40\""));
				// $box_admin->addControl(new PasswordControl('password', 'Senha:', "size=\"40\""));
				// $box_admin->addControl(new PasswordControl('password_again', 'Confirmação de senha:', "size=\"40\""));					
				// $abaConfig->addControl($box_admin);	
			}
		} else {
			$this->title = "Nova instância";
			
			$box_register = new MvcBoxedContainer($this->form, 'box_register', 'Cadastro do contratante');
			$box_register->addControl(new EditControl('name', 'Nome:', "size=\"40\""));
			$box_register->addControl(new EditControl('phone', 'Telefone:', "size=\"20\""), CTLPOS_NOBREAK);
			$box_register->addControl(new EditControl('cnpj', 'CPF/CNPJ:', "size=\"40\""), CTLPOS_NOBREAK);
			$box_register->addControl(new LabelControl('obs_cnpj', '* digite apenas números'));
			$abaConfig->addControl($box_register);
			
			$abaConfig->addControl(new RawControl('br1', '<br />'));
			
			$box_admin = new MvcBoxedContainer($this->form, 'box_admin', 'Credenciais do usuário administrador');
			$box_admin->addControl(new EditControl('email', 'E-mail:', "size=\"40\""));
			$box_admin->addControl(new PasswordControl('password', 'Senha:', "size=\"20\""), CTLPOS_NOBREAK);
			$box_admin->addControl(new PasswordControl('password_again', 'Confirmação de senha:', "size=\"20\""));
			$abaConfig->addControl($box_admin);
			
			$abaConfig->addControl(new RawControl('br2', '<br />'));
			
			$box_lic = new MvcBoxedContainer($this->form, 'box_lic', 'Licenciamento');
			$box_lic->addControl(new SelectControl("type", 'Tipo:', $this->planos), CTLPOS_NOBREAK);
			$box_lic->addControl(new EditControl('personalizado', '', "size=\"50\""), CTLPOS_NOBREAK);
			$box_lic->addControl(new LinkControl("link", '(?)', ""));		
			$box_lic->addControl(new EditControl('nusers', 'Nº de usuários:', "size=\"5\""), CTLPOS_NOBREAK);
			$box_lic->addControl(new EditControl('license', 'Licença:', "size=\"50\""));
			$abaConfig->addControl($box_lic);
			
			$abaConfig->addControl(new RawControl('br3', '<br />'));
			
			$box_ohter = new MvcBoxedContainer($this->form, 'box_ohter', 'Preferências');
			$box_ohter->addControl(new SelectControl("lang", 'Idioma:', $this->lang), CTLPOS_NOBREAK);
			$box_ohter->addControl(new SelectControl("worker_seq", '&nbsp;&nbsp;Worker:', $this->session->workers));
			$abaConfig->addControl($box_ohter);

			$abaConfig->addControl(new RawControl('br4', '<br />'));

			$security = new MvcBoxedContainer($this->form, 'security', 'Política de Senha');
			$security->addControl(new EditControl("inst_num_of_passwd_to_store", "Salvar as ultimas N senhas:"));
			$security->addControl(new EditControl("inst_max_pwd_age", "Validade da senha (em dias):"));
			$abaConfig->addControl($security);
		}				
		
		$this->form->addControl($abas);	
		
		$this->form->addJsOnReady("startJs()");
	}		
	
	function link() {
		$msg = "
				<strong>WTMGC</strong> - Controle do uso do Skype por grupo (Y|N)
				
				<strong>WTMHIST</strong> - Tamanho do Histórico de Mensagens (nº de meses)
				
				<strong>WTMAD</strong> - Faz Uso de Active Directory (Y|N)
				
				<strong>WTMAR</strong> - Limite Mensal de Horas de Gravação de Mensagens de Áudio por Estação (nº de horas)
				
				<strong>NETWORKS</strong> - Redes controladas. Pode ter mais de uma separada por '|'. Default é Skype (EIKON|SKYPE)
				
			";
		
		$msg = str_replace("\r", "", $msg);
		$msg = str_replace("\n", "<br>", $msg);
		$msg = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $msg);
		$this->form->setError($msg, "Recursos", "750px", "310px", "40%");
	}	
	
	function checkEmptyValues() {
		$ret = true;	
		
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			if (isset($_REQUEST['update_lic'])) {
				if ($this->form->data->type != 'WTMGC=N,WTMHIST=6,WTMAD=N,WTMAR=0' /* free */ && !$this->form->data->license)
					return false;
				if ($this->form->data->type == "CUSTOM" && !$this->form->data->personalizado)
					return false;
				if (!$this->form->data->nusers)
					return false;
			} else {
				if (!$this->form->data->inst_name)
					return false;
				if (!$this->form->data->inst_cnpj)
					return false;
				if (!$this->form->data->inst_phone)
					return false;
				// if (!$this->form->data->inst_email)
				// 	return false;
				// if (!$this->form->data->password)
				// 	return false;
				// if (!$this->form->data->password_again)
				// 	return false;
			}
		} else {		
			if ($this->form->data->type != 'WTMGC=N,WTMHIST=6,WTMAD=N,WTMAR=0' /* free */ && !$this->form->data->license)
				return false;
			if ($this->form->data->type == "CUSTOM" && !$this->form->data->personalizado)
				return false;
			if (!$this->form->data->name)
				return false;
			if (!$this->form->data->cnpj)
				return false;
			if (!$this->form->data->phone)
				return false;
			if (!$this->form->data->email)
				return false;
			if (!$this->form->data->password)
				return false;
			if (!$this->form->data->password_again)
				return false;
			if (!$this->form->data->nusers)
				return false;
		}
				
		return $ret;
	}	
	
	function onSave() {		
		if (!$this->checkEmptyValues()) {
			$this->form->setError("Preencha todos os campos.");
			return false;
		}		
		
		if (!isset($_REQUEST['instance']) && !filter_var($this->form->data->email, FILTER_VALIDATE_EMAIL)) {
			$this->form->setError("E-mail inválido.");
			return false;
		}
		
		if (!isset($_REQUEST['update_lic'])) {		
			if ($this->form->data->password != $this->form->data->password_again) {
				$this->form->setError("As senhas são diferentes.");
				return false;
			}
		}
		
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "")
			$this->copyParamsTo($this->instparams);
			
		if (!$this->saveParamsToServer($error)) {			
			$this->form->setError($error);
			return false;
		}		
		return true;
	}		
}

?>