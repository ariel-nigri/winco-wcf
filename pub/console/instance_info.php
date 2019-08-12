<?

require "../../common/config_master.php";

if ($_GET['inst_id']) {
	$inst_id = $_GET['inst_id'];
} else if ($_GET['user_id']) {
	if (strstr($_GET['user_id'], "master:")) {
		$id = explode(":", $_GET['user_id']);
		$inst_id = $id[1];
	} else {
		$user = new UsersInstances;
		$user->usu_seq = (int)$_GET['user_id'];
		if ($user->select($db_conn))	
			$inst_id = $user->inst_seq;
	}
}

$lic_type = array(	
					'F' => 'Free',
					'P' => 'Entreprise',
					'WTMGC=N,WTMHIST=12,WTMAD=N,WTMAR=10' => 'Standard',
					'WTMGC=Y,WTMHIST=24,WTMAD=N,WTMAR=60' => 'Professional',
					'WTMGC=Y,WTMHIST=65,WTMAD=Y,WTMAR=1000' => 'Entreprise',
					'WTMGC=N,WTMHIST=6,WTMAD=N,WTMAR=0' => 'Free',
					'CUSTOM' => ' - Personalizado - '
				);


$classname = $product_code.'_Instances';
$instance = new $classname;
unset($instance->inst_active);
$instance->inst_seq = $inst_id;
if ($instance->select($db_conn))		
	$instance->fetch();	
			
$workers = new Workers;
$workers->worker_seq = $instance->worker_seq;
if ($workers->select($db_conn))			
	$workers->fetch();

$status = new InstancesStatus;
$status->inst_seq = $inst_id;
if ($status->select($db_conn))			
	$status->fetch();

if (array_key_exists($instance->inst_type, $lic_type))
	$inst_type = $lic_type[$instance->inst_type];
else
	$inst_type = "Personalizado";
	
?>