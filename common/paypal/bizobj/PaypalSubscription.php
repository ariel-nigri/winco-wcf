<?php

class PaypalSubscription {
	var		$data;
	var		$error;

	private $api;

	function __construct(RestApi $api) {
		$this->api = $api;
	}

	function retrieve($sbs_id) {
		$this->data = $this->api->call('GET', "/v1/billing/subscriptions/{$sbs_id}");
		if (!$this->data)
			$this->error = $this->api->error;
		return !empty($this->data);
	}

	function list_transactions($sbs_id, $start_time = null, $end_time = null) {
		if (!$end_time)
			$end_time = date('Y-m-d\T23:59:59\Z');
		if (!$start_time)
			$start_time = date('Y-m-d\T23:59:59\Z', time() - (180 * 86400));
		/*
			QUERY PARAMETERS
			start_time
			required
			string [ 20 .. 64 ] characters ^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|
			The start time of the range of transactions to list.

			end_time
			required
			string [ 20 .. 64 ] characters ^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|
			The end time of the range of transactions to list.
		*/

		$this->data = $this->api->call('GET', "/v1/billing/subscriptions/{$sbs_id}/transactions", [ 'start_time' => $start_time, 'end_time' => $end_time ]);
		if (!$this->data)
			$this->error = $this->api->error;
		return !empty($this->data);
	}
	function revise($sbs_id, $plan_id, $users, $return_url) {
		$body = [
			'plan_id' =>  $plan_id,
			'quantity' => $users,
			'application_context' => [
				'return_url' => $return_url,
				'cancel_url' => $return_url
			]
		];

		$this->data = $this->api->call('POST', "/v1/billing/subscriptions/{$sbs_id}/revise", $body);
		if (!$this->data)
			$this->error = $this->api->error;
		return !empty($this->data);
	}

	function cancel($sbs_id, $reason) {
		// change the subscription
		$body = (object) [ 'reason' => $reason ];
		if ($this->api->call('POST', "/v1/billing/subscriptions/{$sbs_id}/cancel", $body) != null)
			return true; // no response, only a 204
		$this->error = $this->api->error;
		return false;
	}
}
