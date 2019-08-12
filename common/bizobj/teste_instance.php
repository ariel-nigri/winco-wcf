<?
	require "../config_master.php";

	$instances = new WTM_Instances;

	$instances->select($db_conn);

	$line = 0;
	while($instances->fetch()) {
		echo ++$line, ": ", $instances->inst_email, ", ",  $instances->inst_passwd, "\n";
	}
?>
