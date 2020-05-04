<?php

require "config.php";

$inst = new Instances;
$inst->inst_seq = $_GET['inst_seq'];
if (!$inst->select(getDbConn()))
    die('invalid instance');

$ver = $inst->inst_version;
if (empty($ver))
    $ver = file_get_contents(__DIR__ ."/../../config/current_version_{$product_code}.cfg");

$action = "https://{$inst->worker_frontend}/{$ver}/admin/login.php";
$my_url = 'https://'.$_SERVER['HTTP_HOST'].strtok($_SERVER['REQUEST_URI'],'?')."?inst_seq=".htmlspecialchars($_GET['inst_seq']);

?>
<html>
<body>
<h1>Login as administrator</h1>
<?php if (!empty($_GET['error'])): ?>
    <h2>Error <?=htmlspecialchars($_GET['error']);?></h2>
<?endif;?>
<form action="<?=$action;?>" method="post">
    <input type="hidden" name="inst_seq" value="<?=htmlspecialchars($_GET['inst_seq']);?>" />
    <input type="hidden" name="return_url" value="<?=$my_url;?>" />
    Username: <input type="text" name="username" /><br />
    Password: <input type="password" name="pass" /><br />
    <input type="submit" value="Logar" />
</form>
</body>
</html>
