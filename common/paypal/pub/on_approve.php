<?php

/*
	This page called by our own script after returning from the subscription button sequence, so the arguments are
	passed by our own code, our own way.
*/

require dirname(dirname(__DIR__)).'/paypal/paypal_config.php';
require dirname(dirname(__DIR__)).'/wcf_paypal.php';
require "subscription_utils.php";

$cmd = @$_GET['cmd'];

if ($cmd == 'subscribe') {
	try {
		// We are not logged in. Get the Id from the params, then
		// check with paypal.
		$subscriptionId = @$_REQUEST['subscriptionID'];
		if (empty($subscriptionId))
			throw new Exception('Bad params');

		$subs = new PaypalSubscription($paypal);

		// retrieve the subscription info
		if (!$subs->retrieve($subscriptionId))
			// subscription not found. What can it Be?
			throw new Exception("Subscription ID not found in paypal account: ".$subs->error['status']);

		// check the status of the subscription
		if ($subs->data->status != 'ACTIVE')
			// Why is it not ACTIVE
			throw new Exception("Subscription is not ACTIVE");

		if (!wcf_paypal_subscribe($subs->data, $error))
			throw new Exception($error);

		echo json_encode(['status' => 'ok']);
		exit;
	}
	catch (Exception $e) {
		$error = $e->getMessage();
	}
	// something went wrong
	echo json_encode(['status' => 'error', 'message' => $error]);
	exit;
}

//
// At this point we are changing some old subscription, so first this is to
// retreive subscription info.
//
if (empty($_SESSION['USER']['EMAIL']))
	throw new Exception('not logged in');

$inst = VPND_Instances::find(getDbConn(), [ 'instid' => $_SESSION['user_id'] ]);
if (!$inst || !$inst->valid)
	throw new Exception('Cannot find instance');

$prov = strtok($inst->inst_payprovider, ':');
if ($prov != 'PAYPAL')
	throw new Exception('Invalid provider');

//	$inst->inst_payplan
//	$inst->inst_paysbs_id

if ($cmd = 'changerequest') {
	$quantity = @$_REQUEST['quantity'];
	if (empty($subsId) || empty($planId) || empty($quantity))
		die('bad params');

	$new_users = $_REQUEST['new_users'];

	$subs = new PaypalSubscription($paypal);
	$setup_fee = calc_prorata($subs, $new_users);
	$resp = $subs->revise($inst->inst_paysbs_id, [ 'quantity' => 10, 'setup_fee' => $setup_fee ]);

	if (!$resp || !$resp->ok) {
		die('cannot change subscription');
	}

	// get the hateos link.
	if ($resp->hateos->approve) {
		// redirect to the approve link
		header('Location: '.$resp->hateos->approve);
		exit;
	}
	else {
		// no need to approve, just update the subscription
		if (wcf_paypal_change($subs->data, $planId, $quantity, $error)) {
			// all Ok
			echo json_encode(['status' => 'ok']);
			exit;
		}
		else {
			// something went wrong
			echo json_encode(['status' => 'error', 'message' => $error]);
			exit;
		}
	}
}
/*
else if ($cmd = 'changeconfirm') {
	// get the subscription id.
	// change in the database.
}
*/
else if ($cmd = 'cancel') {
	// change the subscription
	// We must be looged, so we 
	session_start();
	if (empty($_SESSION['user_id']))
		die('not logged in');

	$inst = VPND_Instances::find(getDbConn(), [ 'instid' => $_SESSION['user_id'] ]);
	if (!$inst || !$inst->valid)
		die('bad instance');

	// cancel the subscription
	$subscriptionId = @$_REQUEST['subscriptionID'];

	if (empty($subscriptionId))
		die('bad params');

	$subs = new PaypalSubscription($paypal);

	// retrieve the subscription info
	if (!$subs->cancel($subscriptionId, $_POST['reason']))
		die('cannot cancel subscription');

	else if (wcf_paypal_cancel($subs->data, $error)) {
		// all Ok
		echo json_encode(['status' => 'ok']);
		exit;
	}
}
