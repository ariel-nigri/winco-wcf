<?php

class PaypalWebhookRegistry {
	var $api;
	var	$events = [
		'BILLING.PLAN.CREATED',
		'BILLING.PLAN.UPDATED',
		'BILLING.PLAN.ACTIVATED',
		'BILLING.PLAN.PRICING-CHANGE.ACTIVATED',
		'BILLING.PLAN.DEACTIVATED',
		'BILLING.SUBSCRIPTION.CREATED',
		'BILLING.SUBSCRIPTION.ACTIVATED',
		'BILLING.SUBSCRIPTION.UPDATED',
		'BILLING.SUBSCRIPTION.EXPIRED',
		'BILLING.SUBSCRIPTION.CANCELLED',
		'BILLING.SUBSCRIPTION.SUSPENDED',
		'BILLING.SUBSCRIPTION.PAYMENT.FAILED',
		'PAYMENT.SALE.COMPLETED',
		'PAYMENT.SALE.REFUNDED',
		'PAYMENT.SALE.REVERSED'];

	function __construct($api) {
		$this->api = $api;
	}

	function list() {
		return $this->api->call('GET', '/v1/notifications/webhooks');
	}
	function register($url, $events) {
		$evt_types = [];
		if (is_array($events)) {
			foreach ($events as $evt)
				$evt_types[] = [ 'name' => $evt ];
		}
		else {
			foreach ($this->events as $evt) {
				if (strpos($evt, $events) === 0)
					$evt_types[] = [ 'name' => $evt ];
			}
		}
		return $this->api->call('POST', '/v1/notifications/webhooks', [ 'url' => $url, 'event_types' => $evt_types ]);
	}
	function delete($webhook_id) {
		return $this->api->call('DELETE', "/v1/notifications/webhooks/{$webhook_id}");
	}
}