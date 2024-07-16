<?php

require 'paypal_config.php';

$hook_api = new PaypalWebhookRegistry($paypal);

$resp = null;
switch (@$argv[1]) {
	case 'list':
		$resp = $hook_api->list();
		break;
	case 'register':
		// 'https://webhooks-devel.winco.com.br/paypal_webhook.php' 'BILLING.SUBSCRIPTION'
		$resp = $hook_api->register(@$argv[2], @$argv[3]);
		break;
	case 'delete':
		$resp = $hook_api->delete(@$argv[2]);
		break;
	default:
		echo "usage: {$argv[0]} [list|register|delete]\n\n";
		exit(1);
}

if ($resp)
	echo json_encode($resp, JSON_PRETTY_PRINT),"\n";
else
	echo "=== ERROR ===\n".json_encode($paypal->error, JSON_PRETTY_PRINT),"\n";
