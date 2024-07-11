<?php

function consolidate_monthly() {
	$me = strtok(gethostname(), '.');
	$thismonth = date('Y-m');

	$days = glob("/var/vpnd/{$me}/usage-{$thismonth}-*/daily.json");
	$usage = [];
	foreach ($days as $day) {
		$daily = json_decode(file_get_contents($day), true);
		foreach ($daily as $inst => $data) {
			if (!isset($usage[$inst]))
				$usage[$inst] = ['local1' => $data['local1'][0]];
			else 
				$usage[$inst]['local1'] += $data['local1'][0];
		}
	}
	return $usage;
}

function generate_usage_feed() {
	$response = [];
	$me = strtok(gethostname(), '.');
	$today = date('Y-m-d');
	$usage = json_decode(file_get_contents("/var/vpnd/{$me}/usage-current.json"), true);
	$daily = json_decode(file_get_contents("/var/vpnd/{$me}/usage-{$today}/daily.json"), true);

	// consolidate daily into $usage
	foreach ($daily as $inst => $data) {
		if (!isset($usage[$inst]))
			$usage[$inst] = ['local1' => [0, 0, 0, 0, $data['local1'][0]]];
		else {
			$usage[$inst]['local1'][] = $data['local1'][0];
		}
	}
	// consolidate monthly into $usage
	$montly = consolidate_monthly();
	foreach ($montly as $inst => $data) {
		if (!isset($usage[$inst]))
			$usage[$inst] = ['local1' => [0, 0, 0, 0, 0, $data['local1']]];
		else {
			$usage[$inst]['local1'][] = $data['local1'];
		}
	}
	foreach ($usage as $inst => $data) {
		$daily = $data['local1'][4] ?? 0;
		$monthly = $data['local1'][5] ?? 0;
		$response[] = [ "{$inst}", "{$data['local1'][2]}", "{$daily}", "{$monthly}", "{$data['local1'][0]}" ];
	}
	return $response;
}
