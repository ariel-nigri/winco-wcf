<?php

require "../config/install_params.php";

$prodversion = trim(file_get_contents("../config/current_version_{$product_code}.cfg"));

// avoid caching
header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
header("Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");

// send to the current login
header("Location: /{$prodversion}/admin/");
