<?php

/*
	This page called by our own script after returning from the subscription button sequence, so the arguments are
	passed by our own code, our own way.
*/

require dirname(__DIR__).'/paypal_config.php';
require dirname(dirname(__DIR__)).'/wcf_paypal.php';

$subscriptionId = @$_REQUEST['subscriptionID'];

$subs = new PaypalSubscription($paypal);

// retrieve the subscription info
if (!$subs->retrieve($subscriptionId))
	// subscription not found. What can it Be?
	$error = "Subscription ID not found in paypal account: ".$subs->error['status'];

// check the status of the subscription
else if ($subs->data->status != 'ACTIVE')
	// Why is it not ACTIVE
	$error = "Subscription is not ACTIVE";

else if (wcf_paypal_subscribe($subs->data, $error)) {
	// all Ok
	echo json_encode(['status' => 'ok']);
	exit;
}

// catch all for what is left.
echo json_encode(['status' => 'error', 'message' => $error]);
