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
    const   VDS_ACTIVATING  = 3;        // in the process of activating whastapp to a phone number. must have a timeout.
    const   VDS_ACTIVATED   = 4;        // whastapp is activated in this device. (it may be assoiated with a browser or not)
    const   VDS_ASSOCIATING = 5;        // the device is being associated to a browser (must have a timeout)

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
    var     $vd_s_index;
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
        $this->addColumn('vd_s_index',  'vd_s_index', BZC_INTEGER);
        $this->addColumn('vd_owner',    'vd_owner', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('vd_number',   'vd_number', BZC_STRING);
        $this->addColumn('vd_key',      'vd_key', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('vd_status',   'vd_status', BZC_INTEGER | BZC_NOTNULL);

        $this->addColumn('virt_device_server.vds_name', 'vds_name', BZC_STRING | BZC_READONLY);
        $this->addColumn('virt_device_server.vds_maxdevs', 'vds_maxdevs', BZC_INTEGER | BZC_READONLY);
    }

    public function get_console_port() {
        return $this->vd_s_index * 2 + 5554;
    }

    public function beforeSave($create) {
        // Make sure vd_number is all numeric.
        if (!empty($this->vd_number)) {
            $c = strlen($this->vd_number);
            $t = $this->vd_number;
            $this->vd_number = '';
            for ($i = 0; $i < $c; $i++) {
                if (ctype_digit($t{$i}))
                    $this->vd_number .= $t{$i};
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
        return true;
    }

    public function update($db) {
        $this->error = "Update cannot be called directory for this object";
        return false;
    }

    public function init_dev($db) {
        global  $my_worker_hostname;

        $db->begin();
        $shadow = $this->getShadow($db, true);
        try {
            if ($shadow->vd_status != self::VDS_DBONLY && file_exists($ini_file))
                throw new Exception("This device has already been created");

            if (empty($shadow->vds_name)) {
                // find our own vds_seq.
                $vds = VirtualDeviceServer::find($db, [ 'vds_name' => $my_worker_hostname, 'vds_active' => true ] );
                if (!$vds->valid)
                    throw new Exception("Could not find ourselves as a registered and active Virtual Device Server");

                // update shadow. strange but usefull...
                $this->vds_seq = $shadow->vds_seq = $vds->vds_seq;
                $shadow->vds_name = $vds->vds_name;
                $shadow->vds_maxdevs = $vds->vds_maxdevs;
            }
            else if (!empty($shadow->vds_name) != $my_worker_hostname)
                throw new Exception("Can only create devices in the same VDS ({$shadow->vds_name}, {$my_worker_hostname})");
            
            // get a free slot
            $s_index = $this->find_s_index($shadow->vds_maxdevs);
            if ($s_index < 0)
                throw new Exception("No more free slots for devices at this Virtual Devices Server");

            // Create the device's  INI files and directories
            $ini_file = "{$this->devices_dir}/{$this->vd_number}.ini";
            $devdir = "{$this->devices_dir}/{$s_index}.avd";
            $ini =  "avd.ini.encoding=UTF-8\n".
                    "path={$devdir}\n".
                    "target={$this->platform}\n";

            $config =<<<"EOF"
AvdId={$this->vd_number}
PlayStore.enabled=false
abi.type=x86
avd.ini.encoding=UTF-8
hw.cpu.arch=x86
hw.gpu.enabled=yes
hw.gpu.mode=swiftshader_indirect
hw.lcd.height=480
hw.lcd.width=320
hw.lcd.density=160
hw.mainKeys=no
hw.keyboard=yes
hw.ramSize=1024
hw.sdCard=yes
hw.camera.back=webcam{$s_index}
image.sysdir.1=system-images/{$this->platform}/default/x86/
tag.display=
tag.id=default
EOF;
            @mkdir("{$devdir}");

            if (!file_put_contents($ini_file, $ini) || !file_put_contents("{$devdir}/config.ini", $config))
                throw new Exception("Cannot create configuration files");

            // Creates sparse disks for userdata and sdcard
            foreach (['sdcard-qemu.img', 'userdata-qemu.img'] as $disk) {
                $output = array();
                $disk = "{$devdir}/userdata-qemu.img";
                exec("dd if=/dev/zero of={$disk} bs=4096 count=1 seek=499999 2>&1", $output, $err);

                if ($err == 0)
                    exec("mkfs -t ext4 -F {$disk} 2>&1", $output, $err);
                if ($err != 0)
                    throw new Exception("error creating disk {$disk}: ".implode(", ", $output));
            }

            // update the database with the info
            $this->vd_s_index = $s_index;
            $this->vd_status = self::VDS_CREATED;
            if (!SqlToClass::update($db))
                throw new Exception('update error: '.$this->error);
            $db->commit();

            // done! now we can boot
            return true;
        }
        catch(Exception $e) {
            $this->error = $e->getMessage();
            $db->rollback();
            return false;
        }
    }

    public function associate($qrcode_file) {
        // check status, server and these things.

        // associate this qrcode to the VirtualDevice
        $mr = new MonkeyRunner($this->android_sdk_root, $this->get_console_port(), true);
        if (!$mr->connect()) {
            $this->error = "cannot connect to Virtual device";
            return false;
        }

        $automator = new DeviceAutomator($mr, new DeviceScreenParser);
        return $automator->associate($qrcode_file);
    }

    public function get_running_status() {
        // look for the process.
        // test the adb.
        // how do we know if the android system is ready ? maybe a screenshot?
        return self::VDRS_UP;
    }

    public function boot($show_console = false) {
        if ($show_console)
            // use the regular emulator, not the headless.
            $this->emulator = 'emulator';

        $port = $this->get_console_port();
        // make sure the video device is loaded (and all before us)
        for ($i = 0; $i <= $this->vd_s_index; $i++) {
            if (!file_exists("/dev/video{$i}")) {
                $cmdline = dirname(dirname(__DIR__))."/bin/cuse_video --name=video{$i}";
                exec($cmdline);
            }
        }

        // emulator-headless usually hangs on shutdown, so we've created this monitor to kill it after the last message is issued to the console.
        $kill_when_done = 'while read x; do [ "$x" = "deleteSnapshot: for default_boot" ] && kill -2 $(ps --ppid $$ --no-headers -o pid); done';

        // Construct the cmdline.
        $cmdline = "{$this->android_sdk_root}/emulator/{$this->emulator} -avd {$this->vd_number} -no-audio -no-snapshot-save -port {$port}";

        // call everything with the right environment.
        exec("cd {$this->devices_dir}/{$this->vd_s_index}.avd; nohup sh -c 'ANDROID_SDK_ROOT={$this->android_sdk_root} ANDROID_AVD_HOME={$this->devices_dir} ${cmdline} 2>&1 | ${kill_when_done}' > /dev/null 2>&1 &");
    }

    public function shutdown() {
        $port = $this->get_console_port();

        exec("{$this->android_sdk_root}/platform-tools/adb -s emulator-{$port} shell 'su 0 svc power shutdown'", $output);
    }

    public function screenshot() {
        if (!$this->mr) {
            $this->mr = new MonkeyRunner($this->android_sdk_root, $this->get_console_port(), true);

            if (!$this->mr->connect())
                return false;
        }
        $this->mr->screenshot('/tmp/snapshot.png');
        return $this->mr;
    }

    public function activate_whatsapp() {
        
    }

    public function activated_web_whastapp() {

    }
    private function find_s_index($max_index) {
        for ($i = 0; $i < $max_index; $i++) {
            if (!file_exists("{$this->devices_dir}/{$i}.ini") && !file_exists("{$this->devices_dir}/{$i}.avd"))
                return $i;
        }
        return -1;
    }
}

