<?php

require "gauth/functions.php";
require "bizobj/Users.php";

class ServicePanel extends ServicePanelBase {	
	
	var $adminparams = array('usu_seq', 'usu_name', 'usu_email', 'usu_twofact_type', 'usu_language',
		'usu_caps', 'usu_num_of_passwd_to_store', 'usu_updated_passwd_at', 'usu_max_pwd_age');
	
	var $privs = array("" => "Usuário padrão", "ADMIN" => "Administrador");
	var $lang = array("br" => "Português", "us" => "Inglês");
	var $twofact = array("" => 'Desativada', "GOGLE" => "Google Authenticator");

	var $title = "Administrador";
	
	function init() {
		global $db_conn, $product_code;
		unset($_SESSION['temp_usu_twofact_token']);
		$classname = $product_code.'_Instances';

		if (!empty($_REQUEST['instance'])) {
			if (!$this->readParamsFromServer())
				return false;
		}
		else {
			$this->params = array(
				'usu_seq' => null,
				'usu_language' => 'br',
				'blocked' => false,
				'usu_num_of_passwd_to_store' => 0,
				'usu_max_pwd_age' => 0,
				'usu_updated_passwd_at' => 'never'
			);
			foreach ($this->adminparams as $p) {
				if (!isset($this->params[$p]))
					$this->params[$p] = '';
			}
		}

		$this->params['usu_caps_special'] =  isset($this->privs[$this->params['usu_caps']]) ? false: true;
		$this->copyParamsFrom($this->adminparams);
		$this->form->data->usuinst_privs = '';
		
		//
		// List all instances where the user is
		//  get instance details
		if (!empty($this->params['inst_seq'])) {
			$instances = new $classname;
			$instances->inst_seq = $this->params['inst_seq'];

			if ($instances->select($db_conn)) {			
				$this->session->instname = $instances->inst_name;
			}
		}
	}	
		
	function readParamsFromServer() {
		global $db_conn;

		$users = new Users;
		$users->usu_seq = (int)$_REQUEST['instance'];
		if ($users->select($db_conn)) {
			foreach ($this->adminparams as $p)
				$this->params[$p] = $users->{$p};
			$this->params['blocked'] = $users->isBlocked($db_conn);
			return true;
		} else
			$this->form->setError("Erro lendo informações do administrador.");
		return false;
	}
		
	function saveParamsToServer(&$error) {
		global $db_conn;
		
		$user = new Users;
		$user->usu_name = $this->params['usu_name'];
		$user->usu_language = $this->params['usu_language'];	
		$user->usu_email = $this->params['usu_email'];
		$user->usu_twofact_type = $this->params['usu_twofact_type'];
		$user->usu_num_of_passwd_to_store = $this->params['usu_num_of_passwd_to_store'];
		$user->usu_max_pwd_age = $this->params['usu_max_pwd_age'];

		if (isset($_SESSION['temp_usu_twofact_token']) && $user->usu_twofact_type) {
			$user->usu_twofact_token = $_SESSION['temp_usu_twofact_token'];
			unset($_SESSION['temp_usu_twofact_token']);
		} else {
			$user->usu_twofact_token = "NULL";
		}

		$user->usu_caps = $this->params['usu_caps'];

		if (!empty($this->params['usu_seq']))
			$user->usu_seq = $this->params['usu_seq'];

		if (!empty($this->form->data->password)) {
			if (!$user->setPassword($db_conn, $this->form->data->password)) {
				$error = $user->error;
				return false;
			}
		}
		
		if (!empty($this->params['usu_seq'])) {
			if (!$user->update($db_conn)) {
				$error = "Erro 1 atualizando administrador.";
				return false;
			}
		}
		else {
			if (!$user->insert($db_conn)) {
				$error = "Erro 1 criando administrador.";
				return false;
			}		
		}

		return true;
	}

	function gauth_generate_code() {
		global $product_name;
		$secret = "";
		$qr_code_url = "";
		genGoogleAuthenticatorSecretAndUrl("{$product_name}: {$this->form->data->usu_email}", $secret, $qr_code_url);
		$_SESSION['temp_usu_twofact_token'] = $secret;
		echo "
		<div style=\"
			position:absolute;
			top:0;
			left:0;
			right:0;
			bottom:0;
			background-color:rgba(0, 0, 0, 0.5);
			display:flex;
			flex-direction:column;
			align-items:center;
			justify-content:center;
		\" id=\"gauth_qrcode_container\">
			<div style=\"
				position:absolute;
				padding:100px;
				background-color:white;
				border-radius:15px;
			\" id=\"gauth_qrcode_box\">
				<a href=\"#\" onclick=\"javascript:gauth_close_qrcode()\" style=\"
					position:absolute;
					right:15px;
					top:15px;
					font-size:30px;
					font-weight:bold;
					text-decoration:none;
				\">X</a>
				<div style=\"font-size:20px;font-weight:bold;width:200px;text-align:center;margin-bottom:25px;\">Leia o qrcode abaixo usando o seu aplicativo Google Authenticator</div>
				<img src=\"$qr_code_url\"\>
			</div>
		</div>
		";
	}
	
	function beforeShow() {			
		global $db_conn;

		$mainLayout =  "| 50% | 50% |
						-------------
						|           |
						|    2,1    |
						|___________|
						|_1,1_|_1,1_|";					
		$this->form->setLayoutManager(new TableLayout($mainLayout));
		
		$abas = new PageControl('pagecontrol1', '');
		$config = $abas->addPage(new MvcContainer($this->form, 'pageConfig', 'Informações', 'div'));

		if (empty($this->params['usu_seq']))
			$this->title = "Novo administrador";
		else
			$this->title = "Alterar administrador";

		$config->addControl(new EditControl('usu_name', 'Nome:', "size=\"40\""));
		$config->addControl(new EditControl('usu_email', 'E-mail:', "size=\"40\""));
		$config->addControl(new PasswordControl('password', 'Senha:', 'size="40" placeholder="Nova senha"'));
		$config->addControl(new PasswordControl('password_again', 'Confirmação de senha:', 'size="40"  placeholder="Repetir senha"'));
		$config->addControl(new SelectControl("usu_language", 'Idioma:', $this->lang));
		$config->addControl(new SelectControl("usu_twofact_type", 'Autenticação com 2 fatores:', $this->twofact), CTLPOS_NOBREAK);
		$config->addControl(new ButtonControl("gauth_generate_code", 'Gerar código', 'style="display:none;"'));

		if (!empty($this->params['usu_caps_special'])) {
			$config->addControl(new EditControl("usu_caps", 'Permissões especiais'), CTLPOS_NOBREAK);
			$config->addControl(new ButtonControl('perm_switch', 'Padrão...'));
		}
		else {
			$config->addControl(new SelectControl("usu_caps", 'Permissões:', $this->privs), CTLPOS_NOBREAK);
			$config->addControl(new ButtonControl('perm_switch', 'especiais...'));
		}

		if ($this->params['blocked']) {
			$config->addControl(new RawControl('raw1', '<p style="margin-top: 15px"'));
			$config->addControl(new LabelControl('reason', 'Bloqueado por:', $this->params['reason'], "style='margin-top: 15px'"));
			$config->addControl(new ButtonControl('unblock_user', 'Desbloquear'));
		}

		if (!empty($this->params['usu_seq'])) {
			$info 	= $abas->addPage(new MvcContainer($this->form, 'pageInstances', 'Instâncias', 'div'));

			$usuinst = UsersInstances::find($db_conn, array("usu_seq" => $this->params['usu_seq']));
			$admins = new TableControl("admins", "", $usuinst);
			$admins->addColumn("inst_seq", "ID", 20);
			$admins->addColumn("usu_name", "Nome", 80);
			$admins->addColumn("usu_email", "Email", 100);
			$admins->addColumn("usuinst_privs", "Permissões", 100);

			$info->addControl($admins, CTLPOS_COLSPAN);

			$info->addControl(new LabelControl('xyz', '<br /><br />Para adicionar ou excluir este usuários de instâncias, edite a instância.'));
		}
		$box = new MvcBoxedContainer($this->form, 'pwd policy', 'Política de senha deste usuário');
		$box->addControl(new EditControl('usu_num_of_passwd_to_store', 'Número de senhas anteriores para guardar:', "size=\"10\""));
		$box->addControl(new EditControl('usu_max_pwd_age', 'Número de dias de validade da senha:', "size=\"10\""));
		$box->addControl(new LabelControl('usu_updated_passwd_at', 'Última atualização de senha:'));
		$config->addControl($box); 
		$this->form->addControl($abas);
	}		
	
	function unblock_user() {
		$ae = new AuthEvents;
		$ae->usu_seq = $this->params['usu_seq'];
		$ae->ae_event = AuthEvents::BLOCK_LOGIN_EVENT;
		$ae->select($GLOBALS['db_conn']);
		if ($ae->ae_reason == 'EXPIRED')
			$is_expired = true;
		else
			$is_expired = false;
		while ($ae->fetch()) {
			$clone = $ae->getShadow($GLOBALS['db_conn']);
			$clone->delete($GLOBALS['db_conn']);
		}
		if ($is_expired) {
			//If we are unblocking because of password expiration, 
			//we set the usu_updated_passwd_at for the max_pwd_age plus 1 to allow user to log and change passwd.
			$user = new Users;
			$user->usu_seq = $this->params['usu_seq'];
			$user->select($GLOBALS['db_conn']);
			$pwdage = $user->usu_max_pwd_age + 1;
			$dt = new DateTime();
			$dayinterval = "P${pwdage}D";
			$dt->sub(new DateInterval($dayinterval));
			$user->usu_updated_passwd_at = $dt->format('Y-m-d');
			$user->update($GLOBALS['db_conn']);
		}

		$this->readParamsFromServer();
	}

	function perm_switch() {
		$this->params['usu_caps_special'] = !$this->params['usu_caps_special'];
	}
	
	function onSave() {
		global $db_conn;

		if (empty($this->form->data->usu_email) || (empty($this->form->data->password) && empty($this->params['usu_seq']))
				|| empty($this->form->data->usu_email) || empty($this->form->data->usu_language)) {
			$this->form->setError("Preencha todos os campos.");
			return false;
		}
		
		if (!filter_var($this->form->data->usu_email, FILTER_VALIDATE_EMAIL)) {
			$this->form->setError("E-mail inválido.");
			return false;
		}
		
		if ($this->form->data->usu_email != $this->params['usu_email']) {
			$user = Users::find($db_conn, array('usu_email' => $this->form->data->usu_email));
			if ($user->valid && $user->usu_seq != $this->params['usu_seq']) {
				$this->form->setError("Erro 2: E-mail já cadastrado.");
				return false;
			}
		}

		if ($this->form->data->password != $this->form->data->password_again) {
			$this->form->setError("As senhas são diferentes.");
			return false;
		}
		
		$this->copyParamsTo($this->adminparams);
		if (!$this->saveParamsToServer($error)) {			
			$this->form->setError($error);
			return false;
		}		
		return true;
	}		
}
