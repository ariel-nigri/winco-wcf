<?php

$open_page = true;

require "config.php";

$_SESSION = array();

header("Location: https://{$base_domain}".dirname($_SERVER['REQUEST_URI']).'/');
