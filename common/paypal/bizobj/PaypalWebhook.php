<?php

class PaypalWebhook {
	public	$error;
	public  $data;

	function readEvent() {
		$this->data = json_decode(file_get_contents('php://input'));
		return $this->data != null;
	}
	function validateSignature($api, $webhook_id, $headers = null) {
		if (!$headers)
			$headers = $_SERVER;
		$post_data = [
			"webhook_id" => $webhook_id,
			"transmission_id" => $headers['HTTP_PAYPAL_TRANSMISSION_ID'],
			"transmission_time" => $headers['HTTP_PAYPAL_TRANSMISSION_TIME'],
			"cert_url" => $headers['HTTP_PAYPAL_CERT_URL'],
			"auth_algo" => $headers['HTTP_PAYPAL_AUTH_ALGO'],
			"transmission_sig" => $headers['HTTP_PAYPAL_TRANSMISSION_SIG'],
			"webhook_event" => $this->data
		];
		$res = $api->call('POST', '/v1/notifications/verify-webhook-signature', $post_data);
		if (isset($res->verification_status)) {
			if ($res->verification_status == 'SUCCESS')
				return true;
			else
				$this->error = "Webhook verification returned {$res->verification_status}";
		}
		else {
			if (isset($res->error))
				$this->error = $res->error.' '.@$res->error_description;
			else if (isset($res->message))
				$this->error = $res->message;
			else
				$this->error = $api->error ? : 'GENERIC ERROR';
		}
		return false;
	}
}
