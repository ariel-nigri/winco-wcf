<?php

define('logDebug', 'D');
define('logInfo',  'I');
define('logWarn',  'W');
define('logError', 'W');

class PaymentLog {
	var $payment_log = '/tmp/payment_log';

	function log($type, $msg) {
		file_put_contents($this->payment_log, $type.'|'.$msg."\n", FILE_APPEND | LOCK_EX);
	}
}
