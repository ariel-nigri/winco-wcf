<?php

class VirtualDeviceServer extends SqlToClass {
    // DB vars
    var     $vds_seq;
    var     $vds_name;
    var     $inst_seq;
    var     $vds_active;
    var     $vds_tunnel;
    var     $vds_key;

    // LOCAL VARS
    var     $avd_dir;
    var     $sdk_dir;

    var     $vds_host;
    var     $vds_port       = 22;
    var     $vds_user       = 'vds-001';
    var     $vds_keyfile;

    function __construct() {
        $this->addTable('virt_device_server');
        $this->addColumn('vds_seq',     'vds_seq', BZC_INTEGER | BZC_TABLEKEY | BZC_READONLY);
        $this->addColumn('vds_name',    'vds_name', BZC_STRING | BZC_NOTNULL);
        $this->addColumn('inst_seq',    'inst_seq', BZC_INTEGER | BZC_NOTNULL);
        $this->addColumn('vds_active',  'vds_active', BZC_BOOLEAN);
        $this->addColumn('vds_maxdevs', 'vds_maxdevs', BZC_INTEGER);
        $this->addColumn('vds_tunnel',  'vds_tunnel', BZC_STRING);
        // $this->addColumn('vds_key',     'vds_key', BZC_STRING);
    }

    function send_file($local, $remote, $recurse = false) {
        $error = [];
        $flags = $recurse ? '-rp' : '-p';
        $result = 0;
        exec("sudo -u {$this->vds_user} scp -q -P {$this->vds_port} {$flags} {$local} {$this->vds_user}@{$this->vds_host}:{$remote} 2>&1", $error, $result);
        if (!$error && !$result)
            return true;
        $this->error = implode(', ', $error);
        return false;
    }

    function remote_exec($cmd) {
        if ($cmd[0] != '/')
            $cmd = '/opt/winco/vds/bin/'.$cmd;
        $res = `sudo -u {$this->vds_user} ssh -p {$this->vds_port} {$this->vds_user}@{$this->vds_host} '$cmd'`;
        if (empty($res))
            $res = "cmd=sudo -u {$this->vds_user} ssh -p {$this->vds_port} {$this->vds_user}@{$this->vds_host} '$cmd'";
        return $res;
    }

    function remote_popen($cmd) {
        // alright: lets register directly into the phone.
        $pipes = [];

        $proc = proc_open("sudo -u {$this->vds_user} ssh -p {$this->vds_port} {$this->vds_user}@{$this->vds_host} '$cmd'", [
                0 => [ 'pipe', 'r' ],
                1 => [ 'pipe', 'w' ],
                2 => [ 'file', '/dev/null', 'w']
            ], $pipes);
        $pipes['proc'] = $proc;

        return $pipes;
    }
    function remote_pclose($pipes) {
        fclose($pipes[0]);
        proc_close($pipes['proc']);
    }

    protected function afterFetch($sql) {
        if (!empty($this->vds_tunnel))
            list($this->vds_host, $this->vds_port) = explode(":", $this->vds_tunnel);

        else {
            $this->vds_host = $this->vds_name;
            $this->vds_port = 22;
        }

        if (strpos($this->vds_host, "@") !== FALSE)
            list($this->vds_user, $this->vds_host) = explode("@", $this->vds_host);
    }

    function retrieveSshKeyFile() {
        $home = getenv("HOME");
        if (empty($home)) {
            $info = posix_getpwuid(posix_getuid());
            $home = $info['dir'];
        }
        $this->vds_keyfile = $home."/.ssh/".$this->vds_name."-id_rsa";
        copy("/home/vds-001/.ssh/id_rsa", $this->vds_keyfile);
        /*
        if (file_put_contents($this->vds_keyfile, $this->vds_key) === FALSE) {
            fprintf(STDERR, "Cannot write to file {$this->vds_keyfile}\n");
            return false;
        }
        */
    
        chmod($this->vds_keyfile, 0600);
        return true;
    }
}
