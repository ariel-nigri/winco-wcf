<?php

class RestApi {
	public 	$error;
	public	$code;

	private $key;
	private $secret;
	private $auth;
	private $endpoint;

	function __construct($endpoint, $key, $secret) {
		$this->key 	  	= $key;
		$this->secret	= $secret;
		$this->endpoint = $endpoint;
	}

	function call($method, $uri, $params = []) {
		if (! ($token = $this->getAccessToken()) )
			return false;
		$hdrlist[] = "Authorization: Bearer {$token}";

		if ($method == 'GET'&& !empty($params))
			$qp = '?'.http_build_query($params);
		else
			$qp = '';

		$c = curl_init($this->endpoint . $uri. $qp);

		// Handle the method.
		if ($method != 'GET' && $method != 'POST')
			curl_setopt($c, CURLOPT_CUSTOMREQUEST, $method);

		if ($method != 'GET') {
			$hdrlist[] = 'Content-Type: application/json';
			curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($params));
		}
		curl_setopt($c, CURLOPT_HTTPHEADER, $hdrlist);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

		// to debug
		// curl_setopt($c, CURLOPT_HEADER, 1);
		// curl_setopt($c, CURLINFO_HEADER_OUT, true);
		// die(curl_getinfo($c, CURLINFO_HEADER_OUT));

		$resp = curl_exec($c);
		$obj  = json_decode($resp);
		$this->code = curl_getinfo($c, CURLINFO_HTTP_CODE);

		if (!$obj) {
			if ($resp)
				$obj = [ 'status' => $this->code, 'body' => $resp, 'message' => 'Invalid JSON message' ];
			else
				$obj = [ 'status' => $this->code, 'message' => 'Empty response' ];
		}
		if ($this->code >= 200 && $this->code < 300)
			return $obj;

		$this->error = $obj;
		return false;
	}

	private function getAccessToken() {
		/* this->auth = [ 'scope' , 'accesso_token', 'token_type', 'app_id', 'expires_in', 'nonce', 'timeout']; */
		$now = time();
		if (!$this->auth || $this->auth->timeout < time()) {
			// check the cache first
			$sid = substr($this->key, 0, 16);
			if (session_status() === PHP_SESSION_NONE) {
				session_name('PHPCLISESSION');
				session_id($sid);
				session_start();
			}
			$this->auth = @$_SESSION['wncpp_authtoken'];
			if (!$this->auth || $this->auth->timeout < time()) {
				$c = curl_init("{$this->endpoint}/v1/oauth2/token");
				curl_setopt($c, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
				curl_setopt($c, CURLOPT_USERPWD, "{$this->key}:{$this->secret}");
				curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
				$this->auth = json_decode(curl_exec($c));
				if ($this->auth && $this->auth->access_token)
					$this->auth->timeout = $now + $this->auth->expires_in - 30;
				else {
					$this->error = json_encode($this->auth);
					$this->auth = null;
				}
			}
			@$_SESSION['wncpp_authtoken'] = $this->auth;
			if (session_id() == $sid)
				session_write_close();
		}
		return $this->auth->access_token;
	}
}
