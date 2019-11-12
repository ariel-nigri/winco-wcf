<?php

class ServicePanel extends ServicePanelBase {	
	var $title = "Dispositivo Android";
		
	function init() {
		global $db_conn;

		if (!empty($_REQUEST['instance'])) {
			$this->params['vd_seq'] = $_REQUEST['instance'];

			$device = VirtualDevice::find($db_conn, [ 'vd_seq' => $this->params['vd_seq'] ] );
			if (!$device->valid)
				die('invalid params');
	
			foreach ([ 'vd_seq', 'vds_seq', 'vd_owner', 'vd_number', 'vd_key', 'vd_status', 'vds_seq', 'vds_name', 'inst_seq', 'vd_wtype' ] as $prop)
				$this->form->data->{$prop} = $device->{$prop};
		}
		else {
			$this->params['vd_seq'] = null;
			$this->params['status'] = VirtualDevice::VDS_DBONLY;
		}

		$this->params['vds_list'][''] = '<Não alocado>';
		$vds = VirtualDeviceServer::find(getDbConn(), [ 'vds_active' => true ]);
		if ($vds->valid) {
			while ($vds->fetch())
				$this->params['vds_list'][$vds->vds_seq] = $vds->vds_name;
		}
	}

	function onSave() {
		if (empty($this->form->data->vd_number) || empty($this->form->data->vd_owner)) {
			$this->form->setError("Preencha todos os campos.");
			return false;
		}

		$device = new VirtualDevice;
		$device->vd_seq = $this->params['vd_seq'];

		foreach ([ 'vd_owner', 'vd_number', 'vd_status', 'inst_seq', 'vds_seq', 'vd_wtype' ] as $prop)
			$device->{$prop} = $this->form->data->{$prop};

		if ($device->inst_seq === '')
			$device->inst_seq = SqlNull();

		if ($device->vds_seq === '')
			$device->vds_seq = SqlNull();

		$dbconn = getDbConn();
		if ($device->vd_seq)
			$rc = $device->update($dbconn);
		else
			$rc = $device->insert($dbconn);
		
		if (!$rc)
			$this->form->setError($device->error);

		return $rc;
	}		

	function beforeShow() {
		$this->form->addControl(new HiddenControl('vds_name'));

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
		$config->addControl(new SelectControl('vds_seq', 'VDS:', $this->params['vds_list']));
		$config->addControl(new EditControl('inst_seq', 'Instância:', "size=\"40\""));
		$config->addControl(new EditControl('vd_owner', 'Usuário:', "size=\"40\""));
		$config->addControl(new EditControl('vd_number', 'Número:', "size=\"40\""));
		$config->addControl(new SelectControl('vd_wtype', 'Vers. Whatsapp:', [ 'wpp' => 'wpp', 'w4b' => 'w4b' ]));
		$config->addControl(new SelectControl('vd_status', 'Status:', VirtualDevice::$status_array));
		$config->addControl(new LabelControl('vd_key', 'Chave:', "size=\"40\""));
		$abaConfig->addControl($config);
		
		$this->form->addControl($abas);	
	}		
}
