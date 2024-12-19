<?php

$open_page = true;

require "config.php";

$_SESSION = array();
session_destroy();

header("Location: .");
