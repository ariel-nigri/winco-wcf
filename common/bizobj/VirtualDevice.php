<?php

class VirtualDevice extends SqlToClass {
    // what we need to know about our environment?
    var  $devices_dir        = '/home/devices';
    var  $android_sdk_root   = '/opt/Android/Sdk';
    var  $templates_dir      = '/opt/winco/android-templates';
    var  $platform           = 'android-25';
    var  $emulator           = 'emulator-headless';
    var  $mr                 = null;

    // status definitions for db/activation statuses.
    const   VDS_DBONLY      = 1;        // only on database.
    const   VDS_CREATED     = 2;        // device created and may be booted. Whastapp installed but not running.
    const   VDS_CODESENT    = 3;        // in the process of activating whastapp to a phone number. must have a timeout.
    const   VDS_ACTIVATED   = 4;        // whastapp is activated in this device. (it may be assoiated with a browser or not)
    const   VDS_SUSPENDED   = 5;        // all is fine, but we are in maintenance or something the like.
    
    const   VDS_PROCESSING  = 0x100;    // Same as a lock. It is bitwise-encoded.

    // Whatsapp versions
    const   VDWT_STANDARD    = 'wpp';
    const   VDWT_BUSINESS    = 'w4b';

    static $status_array = array(
        VirtualDevice::VDS_DBONLY      => 'Cadastrado',
        VirtualDevice::VDS_CREATED     => 'Alocado',
        VirtualDevice::VDS_CODESENT    => 'Código enviado',
        VirtualDevice::VDS_ACTIVATED   => 'Ativado',
        VirtualDevice::VDS_SUSPENDED   => 'Suspenso',
        VirtualDevice::VDS_PROCESSING  => 'Processando...'
    );

    //
    // Running statuses (dont go to the DB, and are only valid for activated or connected devices.)
    //
    const   VDRS_BOOTING        = 1001;
    const   VDRS_UP             = 1002;
    const   VDRS_SHUTTING_DOWN  = 1003;
    const   VDRS_DOWN           = 1004;
    
    // database vars
    var     $vd_seq;
    var     $vds_seq;
    var     $inst_seq;
    var     $vd_owner;
    var     $vd_number;
    var     $vd_key;
    var     $vd_status;
    var     $vds_name;
    var     $vds_maxdevs;

    function __construct() {
        $this->addTable('virt_device');
        $this->addTable('virt_device_server', 'vds_seq');
        $this->addColumn('vd_seq',      'vd_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('vds_seq',     'vds_seq', BZC_INTEGER);
        $this->addColumn('virt_device.inst_seq',    'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('vd_owner',    'vd_owner', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('vd_number',   'vd_number', BZC_STRING);
        $this->addColumn('vd_key',      'vd_key', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('vd_status',   'vd_status', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('vd_wtype',    'vd_wtype', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('vd_activated','vd_activated', BZC_TIMESTAMP);

        $this->addColumn('virt_device_server.vds_name', 'vds_name', BZC_STRING | BZC_READONLY);
        $this->addColumn('virt_device_server.vds_maxdevs', 'vds_maxdevs', BZC_INTEGER | BZC_READONLY);
    }

    public function beforeSave($create, $sql) {
        // Make sure vd_number is all numeric.
        if (!empty($this->vd_number)) {
            $c = strlen($this->vd_number);
            $t = $this->vd_number;
            $this->vd_number = '';
            for ($i = 0; $i < $c; $i++) {
                if (ctype_digit($t[$i]))
                    $this->vd_number .= $t[$i];
            }
        }
        if ($create) {
            if (empty($this->vd_number)) {
                $this->error = "inst_seq, vds_seq and vd_number are mandatory";
                return false;
            }
            // initial state is alwas VDS_DBONLY, also we need to create a specific key
            // for activation
            $this->vd_status = self::VDS_DBONLY;
            $this->vd_key = strtoupper(bin2hex(openssl_random_pseudo_bytes(8)));
        }
        else {
            ini_set('display_errors', 'on');
            error_reporting(E_ALL);
            // cannot change activation time.
            $this->vd_activated = null;
            if ($this->vd_status == self::VDS_ACTIVATED) {
                $sh = $this->getShadow($sql);
                if (empty($sh->vd_activated))
                    $this->vd_activated = date('Y-m-d H:i:s');
            }
        }
        return true;
    }

    public function get_running_status() {
        // look for the process.
        // test the adb.
        // how do we know if the android system is ready ? maybe a screenshot?
        return self::VDRS_UP;
    }
}

