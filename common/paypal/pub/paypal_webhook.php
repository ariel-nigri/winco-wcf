<?php

require dirname(dirname(__DIR__)).'/paypal/paypal_config.php';
require dirname(dirname(__DIR__)).'/wcf_paypal.php';

$wh  	= new PaypalWebhook;
$log 	= new PaymentLog;

if (!$wh->readEvent() || !$wh->validateSignature($paypal, PAYPAL_WEBHOOK_ID)) {
	$log->log(logError, "Webhook recevied doesn't match the signature. Error {$wh->error}");
	header('HTTP/1.1 400 Invalid data');
	exit;
}

unset($wh->data->links);
unset($wh->data->resource->links);
$log->log(logDebug, json_encode($wh->data));

// process the webhook information
switch ($wh->data->event_type) {
	case 'BILLING.SUBSCRIPTION.ACTIVATED':
		// start the subscription
		if (wcf_paypal_subscribe($wh->data->resource, $error))
			$log->log(logInfo, "instance was instance was created successufly");
		else {
			$log->log(logWarn, "Error {$error} creating a VPN instance");
			header('HTTP/1.1 503 Gateway error');
		}
		break;
	case 'PAYMENT.SALE.COMPLETED':
		// new payment made on a subscription. get the the subscription and copy the new expiring date.
		$log->log(logInfo, "Payment received for subscription");
		break;
	case 'BILLING.SUBSCRIPTION.CREATED':
	case 'BILLING.SUBSCRIPTION.UPDATED':
	case 'BILLING.SUBSCRIPTION.EXPIRED':
	case 'BILLING.SUBSCRIPTION.CANCELLED':
	case 'BILLING.SUBSCRIPTION.SUSPENDED':
	case 'BILLING.SUBSCRIPTION.PAYMENT.FAILED':
		break;
}
