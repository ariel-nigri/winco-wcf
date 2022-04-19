<?php

// test string
// https://ariel-dev.talkmanager.net/wsvc/activatereg.php?version=4.4.4&sid=12345&machine=test&user=ariel&64bits=1
// All we must do is to include the version in the instance.
$wcf_base = dirname(dirname(__DIR__));
$curr_ver = trim(file_get_contents("{$wcf_base}/config/current_version_WTM.cfg"));

require "/home/instances/versions/{$curr_ver}/pub/activatereg.php";
