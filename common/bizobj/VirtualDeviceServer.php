<?php

class VirtualDeviceServer extends SqlToClass {
    // DB vars
    var     $vds_seq;
    var     $vds_name;
    var     $inst_seq;
    var     $vds_active;
    var     $vds_tunnel;
    var     $vds_key;

    var     $vds_remoteuser = 'android';
    var     $vds_remotehost;
    var     $vds_remoteport =  22;

    // LOCAL VARS
    var     $avd_dir;
    var     $sdk_dir;

    function __construct() {
        $this->addTable('virt_device_server');
        $this->addColumn('vds_seq',     'vds_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('vds_name',    'vds_name', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('inst_seq',    'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('vds_active',  'vds_active', BZC_BOOLEAN);
        $this->addColumn('vds_maxdevs', 'vds_maxdevs', BZC_INTEGER);
        $this->addColumn('vds_tunnel',  'vds_tunnel', BZC_STRING);
        $this->addColumn('vds_key',     'vds_key', BZC_STRING);
    }

    function send_file($local, $remote) {
        if (empty($this->vds_remotehost))
            $this->vds_remotehost = $this->vds_name;

        exec("sudo -u{$this->vds_remoteuser} scp -P {$this->vds_remoteport} {$local} {$this->vds_remotehost}:{$remote}", $this->error);
    }

    function remote_exec($cmd) {
        if (empty($this->vds_remotehost))
            $this->vds_remotehost = $this->vds_name;

        exec("sudo -u{$this->vds_remoteuser} ssh -p {$this->vds_remoteport} {$this->vds_remotehost} '/opt/winco/vds/bin/$cmd'");
    }
}
