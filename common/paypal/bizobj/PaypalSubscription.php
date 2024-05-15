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

	function update($sbs_id, $what) {
		//
	}
}
//v1/billing/subscriptions/{id}