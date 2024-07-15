<?php

set_include_path('bizobj');

require "RestApi.php";
require "PaypalWebhook.php";
require "PaypalSubscription.php";
require "/etc/winco/cloudvpn_paypal.php";

$api = new RestApi(PAYPAL_API_ENDPOINT, PAYPAL_API_KEY, PAYPAL_API_SECRET);
$wh  = new PaypalWebhook;

/*
 * testing the webhook
 */
if (in_array('webhook', $argv)) {
    $wh->data = json_decode(file_get_contents(__DIR__.'/objects/subscription_event.json'));
    if ($wh->validateSignature($api, 'WEB0123433', _getheaders()))
        echo "Validated OK!\n";
    else
        echo "{$wh->error}\n";
}

/*
 * Subscription management
 */
if (in_array('subscription', $argv)) {
    $subscriptionID = $argv[2];
    $sbs = new PaypalSubscription($api);
    if ($sbs->retrieve($subscriptionID))
        print_r($sbs->data);
    else
        echo "Error: {$sbs->error}\n";
    /*
    $resp = $api->call('GET', "/v1/billing/subscriptions/{$subscriptionID}");
    echo json_encode($resp, JSON_PRETTY_PRINT);// print_r($resp);
    /*$resp = $api->call('GET', "/v1/billing/subscriptions/{$subscriptionID}/transactions", 
        [ 'start_time' => '2024-03-01T00:00:00Z', 'end_time' => '2024-04-30T00:00:00Z' ]);
    echo json_encode($resp, JSON_PRETTY_PRINT);// print_r($resp);*/

}
/*
 * Subscription management
 */
if (in_array('transactions', $argv)) {
    $subscriptionID = $argv[2];

    $sbs = new PaypalSubscription($api);
    if ($sbs->list_transactions($subscriptionID))
        print_r($sbs->data);
    else
        print_r($sbs->error);
}
/*
 * Cancel subscription
 */
if (in_array('cancel', $argv)) {
    $subscriptionID = $argv[2];
    $sbs = new PaypalSubscription($api);
    $resp = $sbs->cancel($subscriptionID, $argv[3]);
    print_r($resp);
}

/*
 * Subscription management
 */
if (in_array('plan', $argv)) {
    $plan_id = PAYPAL_PLAN_ID;
    $resp = $api->call('GET', "/v1/billing/plans/{$plan_id}");
    print_r($resp);
}

/*
 * Mock generating functions
 */
function _getheaders() {
	$text = 
<<<EOF
{
    "HTTP_PAYPAL_AUTH_ALGO": "SHA256withRSA",
    "HTTP_PAYPAL_CERT_URL": "https://api.paypal.com/v1/notifications/certs/CERT-360caa42-fca2a594-ad47cb8d",
    "HTTP_PAYPAL_AUTH_VERSION": "v2",
    "HTTP_PAYPAL_TRANSMISSION_SIG": "enWlWys2DbGfEEiIvCJCIvW7ggKrc7EXEzuplVrhHhWkY1A1TEQNJLFZHyCxe0Mv/8aNrMwtIkJ3F0uOptnJn7TxfcXWg3otBmpQtRUJ5CfvpFQP1cUBkgxv4DPYkidYtMVsLx5xyCzgOmVpQBVHH0aexw6uPsIwweBCGFSdtfNewdBCPLatdEajBM6H4JnjRleBH2m9bYHVfvUZxu9c0OueF6rrJPIp4K2C13UFA3MwhhWHA/pysimngAY64QGv+4g5W09k4oyoxbvdT6iOzpzFwqzjJY5STOfOjIgVTxgSrhh6sJXFjNLCG0BjAPcLHDaObrPDM1yJG0amVDkhqg==",
    "HTTP_PAYPAL_TRANSMISSION_TIME": "2024-04-19T18:59:40Z",
    "HTTP_PAYPAL_TRANSMISSION_ID": "f9e28350-fe7e-11ee-b9bf-3956aff1a72d",
}
EOF;
	return json_decode($text, true);
}
