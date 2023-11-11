<?php

require "config.php";
require "service_panel_base.php";

class ServiceForm extends MvcForm {
	var $servicePanel;
	var $realEvent;
	var $errors = array();	

	function ServiceForm() {
		parent::__construct();
			
		$this->data = new stdclass;
		$this->addControl(new HiddenControl("sess_entry"));
		$this->addControl(new HiddenControl("service"));
		$this->addControl(new HiddenControl("instance"));
	}
	
	function importServiceForm() {
		include "svc_forms/".$this->data->service.".php";
		if (!class_exists('ServiceForm')) {
			$this->setError(SRV_CONFIG_MSG_FILE_TREAT . ' ' . $this->data->service. ' ' . SRV_CONFIG_MSG_FILE_NOT_EXIST);
			return;
		}
		$this->servicePanel = new ServicePanel;
		$this->servicePanel->setForm($this);
	}
	
	function obj_event() {
		$this->servicePanel->{$this->realEvent}();
	}

	function beforeEvent(&$evt) {
		// criamos  o objeto de config se ja soubermos qual e o servico.
		if ($evt != 'init') {
			$this->importServiceForm();

			// feito isso, vamos ver se eh um evento do service form.
			if (method_exists($this->servicePanel, $evt)) {
				$this->realEvent = $evt;
				$evt = "obj_event";
			}
		}
	}

	function init() {
		// nova sessao com certeza. este valor eh usado para salvar os parametros atuais do servidor.
		$this->data->sess_entry = uniqid("FORM");
		
		// lemos os dados do winconnection.
		if (!isset($_REQUEST['service']))
			$this->setError(SRV_CONFIG_MSG_BAD_PARAM);
			
		$this->data->service = $_REQUEST['service'];
		if (isset($_REQUEST['instance']))
			$this->data->instance = $_REQUEST['instance'];

		// agora ja sabemos qual eh o servico e portanto precisamos criar o obj. de config e inicializar.
		$this->importServiceForm();
		$this->servicePanel->init();
	}
	
	function beforeShow() {
		$this->servicePanel->beforeShow();		
			
		$savestr = (empty($this->data->instance)) ? BT_MSG_CREATE : BT_MSG_SAVE;		
		$btt = "<input id=\"salvar\" class=\"button\" type=\"button\" style=\"width: 83px;\" onclick=\"javascript:form1do_action('salvar')\" name=\"salvar\" value=\"".$savestr."\">&nbsp;&nbsp;";
		$btt .= "<input id=\"close\" class=\"button\" type=\"button\" style=\"width: 83px;\" onclick=\"javascript:form1do_action('close')\" name=\"close\" value=\"".BT_MSG_CANCEL."\">";	
		
		$this->addControl(new RawControl("final_buttons", $btt));		
		$this->addControl(new RawControl("null", ''));
	}
	
	function close() {
		$instance = @$this->servicePanel->params['INSTANCE'];
		if (!isset($instance))
			$instance = $this->data->instance;	
		if (!empty($_REQUEST['return_service']))
			echo '<html><body><script language="javaScript">location.href="status.phtml?service='.$_REQUEST['return_service'].'&instance='.urlencode($instance).'";</script></body></html>';		
		else
			echo '<html><body><script language="javaScript">location.href="status.phtml?service='.$this->data->service.'&instance='.urlencode($instance).'";</script></body></html>';			
		exit;
	}
	
	function salvar() {
		if ($this->servicePanel->onSave())
			$this->close();
	}
	
	function setError($err, $title = "Por favor reveja as configurações", $width = '', $height = '', $left = '') {
		$GLOBALS['modal_error'] = $err;
		$GLOBALS['modal_error_title'] = $title;
		$GLOBALS['modal_width'] = $width;
		$GLOBALS['modal_height'] = $height;
		$GLOBALS['modal_left'] = $left;
	}
}

$db_conn = getDbConn();
Sql::$date_format = 'iso';

$form = new ServiceForm;
$form->handle($_REQUEST);
$service_name = $form->data->service;

include "template.phtml";
