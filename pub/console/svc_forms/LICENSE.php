<?php

class ServicePanel extends ServicePanelBase {	
	
	var $licparams = array('rtlic_seq', 'rtlic_id', 'inst_seq', 'rtlic_owner', 'rtlic_caps');
	
	var $title = "Licença";
		
	function init() {
		$this->readParamsFromServer();
		$this->copyParamsFrom($this->licparams);
	}		
		
	function readParamsFromServer() {
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			global $db_conn;
			$license = new NTP_RouterLicenses;
			$license->rtlic_seq = $_REQUEST['instance'];
			if ($license->select($db_conn)) {			
				$this->params['rtlic_seq'] = $license->rtlic_seq;
				$this->params['rtlic_id'] = $license->rtlic_id;
				$this->params['inst_seq'] = $license->inst_seq;
				$this->params['rtlic_owner'] = $license->rtlic_owner;
				$this->params['rtlic_caps'] = $license->rtlic_caps;
			}
		}
	}
		
	function saveParamsToServer(&$error) {
		global $db_conn;
		$db_conn->begin();
		
		$license = new NTP_RouterLicenses;
		$license->rtlic_seq = $this->params['rtlic_seq'];
		if (empty($license->rtlic_seq))
			$license->rtlic_id = $this->params['rtlic_id'];
		$license->rtlic_owner = $this->params['rtlic_owner'];
		$license->rtlic_caps = $this->params['rtlic_caps'];
		
		if (isset($_REQUEST['instance']) && $_REQUEST['instance'] != "") {
			if (!empty($license->inst_seq))
				$license->rtlic_allocated = date("Y-m-d H:i:s");
			if (!$license->update($db_conn)) {
				$db_conn->rollback();
				$error = "Erro atualizando licença: " . $db_conn->errormessage();
				return false;
			}	
		} else {
			$license->rtlic_created = date("Y-m-d H:i:s");
			if ($license->inst_seq != 0)
				$license->rtlic_allocated = date("Y-m-d H:i:s");
			if (!$license->insert($db_conn)) {
				$db_conn->rollback();
				$error = "Erro criando licença: " . $db_conn->errormessage();
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
		$abaConfig 	= $abas->addPage(new MvcContainer($this->form, 'pageConfig', 'Informações gerais', 'div'));
		
		if (!empty($this->params['rtlic_seq'])) {
			$info = new MvcBoxedContainer($this->form, 'info', 'Informações da licença');
			$info->addControl(new LabelControl('rtlic_id', 'Licença:'));
			//$info->addControl(new LabelControl('rtlic_caps', 'Capabilities:'));
			$info->addControl(new EditControl('rtlic_caps', 'Capabilities:', "size=\"40\""), CTLPOS_NOBREAK);
			$info->addControl(new LinkControl("link", '(?)', ""));
			$abaConfig->addControl($info);	
			
			$abaConfig->addControl(new RawControl('br1', '<br />'));
			
			$owner = new MvcBoxedContainer($this->form, 'owner', 'Informações do dono');
			$owner->addControl(new LabelControl('inst_seq', 'Instância:'));
			$owner->addControl(new EditControl('rtlic_owner', 'Pertence a:', 'size="40" '));
			$abaConfig->addControl($owner);
		} else {
			$this->title = "Nova licença";
			$new = new MvcBoxedContainer($this->form, 'config', '');
			$new->addControl(new TextAreaControl('rtlic_id', 'Licença(s):', 'cols="60" rows="10"'));
			//$new->addcontrol(new UploadControl('lic_from_file', 'do arquivo...'));
			$new->addControl(new EditControl('rtlic_caps', 'Capabilities:', "size=\"40\""), CTLPOS_NOBREAK);
			$new->addControl(new LinkControl("link", '(?)', ""));	
			$new->addControl(new EditControl('rtlic_owner', 'Pertence a:', 'size="40" '));
			$abaConfig->addControl($new);
		}				
		
		$this->form->addControl($abas);	
	}		
	
	function link() {
		$msg = "
				<strong>NP_DEFAULT_RULE</strong> - Utilizar regra padrão para dispositivos não controlados (Y|N)
				
				<strong>USERS</strong> - Número de usuários
			";
		
		$msg = str_replace("\r", "", $msg);
		$msg = str_replace("\n", "<br>", $msg);
		$msg = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $msg);
		$this->form->setError($msg, "Capabilities", "730px", "200px", "40%");
	}	
	
	function checkEmptyValues() {
		if (empty($this->params['rtlic_seq']) && !$this->form->data->rtlic_id)
			return false;

		if (!$this->form->data->rtlic_caps)
			return false;
			
		return true;
	}	
	
	function importLicenses() {
		global $db_conn;
		$licenses = explode("\n", $this->form->data->rtlic_id);

		$db_conn->begin();

		foreach ($licenses as $l) {
			$lic = trim($l);
			if (empty($lic))
				continue;
			
			$license = new NTP_RouterLicenses;
			$license->rtlic_seq = null;
			$license->inst_seq = 0;
			$license->rtlic_id = $lic;
			$license->rtlic_owner = $this->form->data->rtlic_owner;
			$license->rtlic_caps = $this->form->data->rtlic_caps;
			$license->rtlic_created = date("Y-m-d H:i:s");
			if (!$license->insert($db_conn)) {
				$error = "Erro criando licença: " . $db_conn->errormessage();
				$db_conn->rollback();
				$this->form->setError($error);
				return false;
			}
		}
		$db_conn->commit();
		return true;
	}
	
	function onSave() {		
		if (!$this->checkEmptyValues()) {
			$this->form->setError("Preencha todos os campos.");
			return false;
		}
		
		if (empty($this->params['rtlic_seq']))
			return $this->importLicenses();
		
		$this->copyParamsTo($this->licparams);
		if (!$this->saveParamsToServer($error)) {			
			$this->form->setError($error);
			return false;
		}		
		return true;
	}		
}
