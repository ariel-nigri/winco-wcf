<?php

require "/etc/winco/cloudvpn_paypal.php";

ini_set('include_path', __DIR__.'/bizobj');

spl_autoload_register(function($class) {
	@include_once "{$class}.php";
});

$paypal = new RestApi(PAYPAL_API_ENDPOINT, PAYPAL_API_KEY, PAYPAL_API_SECRET);