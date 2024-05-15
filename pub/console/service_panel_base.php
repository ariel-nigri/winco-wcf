<?php

class ServicePanelBase {
	var $params;
	var $form;	/** @var MvcForm */ 	

	function setForm($form) {
		$this->form = $form;		
		if (!isset($_SESSION[$this->form->data->sess_entry]))
			$_SESSION[$this->form->data->sess_entry] = array('params' => array(), 'session' => new stdclass);
		$this->params = &$_SESSION[$this->form->data->sess_entry]['params'];
		$this->session = &$_SESSION[$this->form->data->sess_entry]['session'];
	}
	
	function copyParamsFrom($params) {
		foreach($params as $param)
			$this->form->data->{$param} = @$this->params[$param];
	}
	
	function copyParamsTo($params) {
		foreach($params as $param) {
			if (isset($this->form->data->{$param}))
				$this->params[$param] = trim($this->form->data->{$param});
		}
	}
}
