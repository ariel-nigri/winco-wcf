<?php

require_once __DIR__.'/wcf.php';
require_once __DIR__.'/wcf_config.php';

function wcf_paypal_subscribe($subs, &$error)
{
	$inst_id = $subs->custom_id ?? '';
	$expiration = date("Ymd", strtotime($subs->billing_info->next_billing_time) + (7 * 86400));
	$name = $subs->subscriber->name->given_name .' '.$subs->subscriber->name->surname;

	$retried  = 0;
	$vpnd 	  = null;
	$inst_new = false;

	while (true) {
		$inst_new = false;
		$dbconn = getDbConn();

		$dbconn->begin();
		if (empty($inst_id)) {
			// search by subscription ID. If found, then we have nothing to do here.
			$vpnd = VPND_Instances::find($dbconn, [ 'inst_paysbs_id' => $subs->id ]);
			if ($vpnd && $vpnd->valid)
				// the instance was already created by another thread or process
				return true;

			$inst_new = true;
			$vpnd = wcf_dbcreate_instance("USERS={$subs->quantity}", $name, 'us', $subs->subscriber->email_address, $name, $expiration, $error);
			if (!$vpnd)
				return false;
		}
		else {
			$vpnd = VPND_Instances::find(getDbConn(), [ 'inst_id' => $inst_id, 'inst_active' => null]);
			if (!$vpnd->valid) {
				$error = "The instance ID doesnt exist in the cluster.";
				return false;
			}

			if ($vpnd->inst_paysbs_id == $subs->id)
				// the instance was already updated by another thread or process
				return true;

			$vpnd->inst_expiration	= $expiration;
			$vpnd->inst_active		= true;
			$vpnd->inst_type		= "USERS={$subs->quantity}";
		}
		$vpnd->inst_payprovider = 'PAYPAL';
		$vpnd->inst_paysbs_id	= $subs->id;
		$vpnd->inst_payplan		= $subs->plan_id;
		$vpnd->inst_users		= $subs->quantity;

		if (!$vpnd->update($dbconn)) {
			$error = "Error updating instance {$vpnd->error}";
			return false;
		}

		if ($dbconn->commit())
			break;

		// an error in commit can happen if another thread was creating a record at the same time with a duplicate value
		if ($retried++ > 1)
			return false;
	}

	if ($inst_new) {
		// materialize the instance and start it is a new one
		$vpnd->init_directory();
		$vpnd->start();
	}
	else {
		$vpnd->stop();
		$vpnd->start();
	}
	return true;
}
