<?php

class ServicePanel extends ServicePanelBase {	
	var $title = "Virtual Device Servers";
		
	function init() {
		global $db_conn;

		if (!empty($_REQUEST['instance'])) {
			$this->params['vds_seq'] = $_REQUEST['instance'];

			$device = VirtualDeviceServer::find(getDbConn(), [ 'vds_seq' => $this->params['vds_seq'] ] );
			if (!$device->valid)
				die('invalid params');
	
            foreach ([ 'vds_seq', 'vds_name', 'vds_active', 'vds_maxdevs', 'inst_seq' ] as $prop)
                $this->form->data->{$prop} = $device->{$prop};
		}
		else {
			$this->params['vds_seq'] = null;
			$this->params['vds_active'] = false;
		}
	}

	function onSave() {
		$dbconn = getDbConn();

		$device = new VirtualDeviceServer;
        $device->vds_seq = $this->params['vds_seq'];

		foreach ([ 'vds_name', 'vds_active', 'vds_maxdevs', 'inst_seq' ] as $prop)
			$device->{$prop} = $this->form->data->{$prop};

		if ($device->inst_seq === '')
			$device->inst_seq = SqlNull();

		if ($device->vds_seq)
			$rc = $device->update($dbconn);
		else
            $rc = $device->insert($dbconn);
        print_r($device);
        exit;
		
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
		$config->addControl(new LabelControl('vds_seq', 'VDS ID:'));
		$config->addControl(new EditControl('vds_name', 'Hostname:', "size=\"40\""));
		$config->addControl(new EditControl('inst_seq', 'Instância dedicada:', "size=\"15\""));
		$config->addControl(new EditControl('vds_maxdevs', 'Número máximo de dispositivos:'));
		$config->addControl(new CheckControl('vds_active', 'Instância padrão:'));
		$abaConfig->addControl($config);
		
		$this->form->addControl($abas);	
	}		
}
