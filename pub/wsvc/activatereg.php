<?php

// All we must do is to include the version in the instance.
$wcf_base = dirname(dirname(__DIR__));
$curr_ver = trim(file_get_contents("{$wcf_base}/current_version_WTM.cfg"));

require "/home/instances/versions/{$curr_ver}/pub/activatereg.php";
