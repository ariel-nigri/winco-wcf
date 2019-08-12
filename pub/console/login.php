<?php

$open_page = true;

require "config.php";

$username = $pass = '';
if (!empty($_POST)) {
    do {
        @$username = $_POST['username'];
        @$pass = $_POST['pass'];
        if (empty($username) || empty($pass)) {
            $erromsg = "Por favor entre com usuário e senha";
            break;
        }

        // connect to DB
        $db_conn = getDbConn();

        // Check the user's password
        $usr = new Users;
        $usr->usu_email = $username;
        if (!$usr->select($db_conn) || !$usr->validatePassword($pass) || !strstr($usr->usu_caps, 'ADMIN')) {
            $erromsg = "Invalid username or password";
            break;
        }

        // load perms and all env info into _SESSION
        $_SESSION['LOGGED_USER'] = array(
            'usu_seq'   => $usr->usu_seq,
            'usu_email' => $usr->usu_email,
            'usu_name'  => $usr->usu_name
        );

        // check for permissions.
        /*
        // login the user.
        if (!wcf_login($username, $pass)) {
            $erromsg = "Usuário ou senha inválida";
            break;
        }
        */
        header('Location: .');

    } while (false);
}

/*


$lang_dir = "lang-br";

$common = dirname(__FILE__);
$base_dir = strtok($_SERVER['REQUEST_URI'],'/');

ini_set("include_path", ".".PATH_SEPARATOR.$common);

require "$lang_dir/language.php";
require "wc/interface.php";
require "autologin.php";
require "wnc_session.php";
require "config_master.php";

@date_default_timezone_set(date_default_timezone_get());

// default access endpoint (non-cloud)
$wc_host = '127.0.0.1';
$wc_port = $default_adm_port;

// Check autologin stuff
// DB location, new_cooke, state
$data_dir = __DIR__;
if ($_SERVER["SERVER_SOFTWARE"] == 'PHPHOST') {
    // running with user privileges.
    if (!empty($_ENV['LOCALAPPDATA']))
        $data_dir = $_ENV['LOCALAPPDATA'];
    else if (!empty($_ENV['APPDATA']))
        $data_dir = $_ENV['APPDATA'];
    else if (!empty($_ENV['TEMP']))
        $data_dir = $_ENV['TEMP'];
} else {
    // running with system privileges.
    if (!empty($_ENV['ALLUSERSPROFILE']))
        $data_dir = $_ENV['ALLUSERSPROFILE'];
    else if (!empty($_ENV['TEMP']))
        $data_dir = $_ENV['TEMP'];
}

$autologin_db = $data_dir."/Winco/admin_al_{$product_code}.db";
$autologin_cookie_name = $product_code.'_AUTOID';
$autologin_new_cookie = '';
$autologin_in_progress = false;

//
// Retrieve login info if needed from autologin DB, or from command line
//
$username = $pass = '';
if (!empty($_POST['username']) || isset($_POST['pass'])) {
    // user passed it in the command line.
    $username = $_POST['username'];
    $pass = $_POST['pass'];
} else if (!empty($_COOKIE[$autologin_cookie_name])) {
    // trying the autologin cookie.
    $autologin_in_progress = true;
    $login_info = autologin_retrieve($autologin_db, $_COOKIE[$autologin_cookie_name], $_SERVER['HTTP_USER_AGENT'], $autologin_new_cookie);
    if ($login_info) {
        $username = $login_info['username'];
        $pass = $login_info['pass'];
    }
}

if(!$_COOKIE["LOGGED_IN_CONSOLE"]) {
    do {
            wnc_session_start();
            $login_result = "LOGIN_INVALID";
            $pass_ok = false;
            if(isset($_POST['username']) && isset($_POST['pass'])) {
                $user = new UsersInstances;
                $user->usu_email = $username;
                if(!$user->select($db_conn)) {
                    $erromsg = "Incorrect username";
                    break;
                }

                if ($product_code == "WTM")
                    $_SESSION['TALK_MANAGER'] = true;
                else
                    $_SESSION['NTP_CONSOLE'] = true;
                    
                    $pass_ok = Users::comparePassword($pass, $user->usu_passwd_digest);
                    if(!$pass_ok) {
                         $erromsg = "Incorrect password"; 
                         break;
                    }
                    require_once dirname(__FILE__) . "/../config/console_params_NTP.php";
                    $cap = getConsoleCapabilities($user->usu_cap);
                    if(!$cap)
                       $login_result = "LOGIN_DENIED";
                    else {
                            if($user->usu_twofact_type) {
                                $_SESSION['TWO_FACTOR_TYPE'] = $user->usu_twofact_type;
                                $_SESSION['TWO_FACTOR_TOKEN'] = $user->usu_twofact_token;
                                $_SESSION['TWO_FACTOR_VALID'] = false;
                            }
                            else {
                                $_SESSION["LOGGED_IN_USER"] = $username;
                                setcookie("LOGGED_IN_CONSOLE", true, time() + (30 * 86400));
                                $login_result = "OK";
                            }
                        } 
            }
            else
                return; //primeira entrada
        } while(false);
}
else
    $login_result = "OK";

switch ($login_result) {
case "OK":
    if (!empty($_POST['continue_connected'])) {
        // criando cookie de login
        $login_info = array('username' => $username, 'pass' => $pass);
        $autologin_new_cookie = autologin_store($autologin_db, $login_info, $_SERVER['HTTP_USER_AGENT']);
    }

    if (!empty($autologin_new_cookie))
        setcookie($autologin_cookie_name, $autologin_new_cookie, time() + (30 * 86400)); // sets the cookie for 1 year.

    $worker = new Workers;
    if($worker->select($db_conn))
        header("Location: https://".$worker->worker_frontend."/{$base_dir}/main.phtml");
    exit;
case "NOT_RUNNING":
    die(
    "<html>
    <head>
        <title>Erro - Administrador {$product_name}</title>
        <meta http-equiv=\"refresh\" content=\"15\" />
    <head>
    <body>
        <h2>O serviço {$product_name} não está em execução</h2>
        Por favor inicie o serviço. (tentando novamente a cada 15 segundos...)
    </body>
    </html>
    ");
    break;
case "ACCESS_DENIED";
    die("Access Denied.");
    break;
case "LOGIN_DENIED":
    $erromsg = "Usuário não tem privilegios de administrador";
    break;
default: // LOGIN_INVALID
    if(empty($erromsg))
        $erromsg = "Login invalido";
}


if ($autologin_in_progress) {
    autologin_delete($autologin_db, $_COOKIE[$autologin_cookie_name]);
    setcookie($autologin_cookie_name, '', time() - 100000); // cleans the browser cookie
    $erromsg = ''; // we clean the error message if the user never supplied credentials.
}

/*

   do {
        $login_result = "LOGIN_INVALID";
        $pass_ok = false;
        if(isset($_POST['username']) && isset($_POST['pass'])) {
            $user = new UsersInstances;
            $user->usu_email = $username;
            wnc_session_start();

            if(!$user->select($db_conn)) {
                $erromsg = "Incorrect username";
                break;
            }

            if ($product_code == "WTM") {
                $instance = new WTM_Instances;
                $_SESSION['TALK_MANAGER'] = true;
            }
            else
                $instance = new Instances;

            if($instance->select($db_conn)) {
                $pass_ok = Users::comparePassword($pass, $user->usu_passwd_digest);
                if(!$pass_ok) {
                     $erromsg = "Incorrect password"; 
                     break;
                }
                require_once dirname(__FILE__) . "/../config/console_params_NTP.php";
                $cap = getConsoleCapabilities($user->usu_cap);
                if(!$cap)
                   $login_result = "LOGIN_DENIED";
                else {
                        $_SESSION["LOGGED_IN_USER"] = $username;
                        $_SESSION["MASTER_USER"] = $user->usuinst_master;
                        $_SESSION['INSTANCE_DIR'] = "/home/instances/" . $instance->inst_seq . "/var/winco";
                        $_SESSION['INSTANCE_SEQ'] = $instance->inst_seq;
                        $_SESSION['INSTANCE_NAME'] = $instance->inst_name;
                        if($user->usu_twofact_type) {
                            $_SESSION['TWO_FACTOR_TYPE'] = $user->usu_twofact_type;
                            $_SESSION['TWO_FACTOR_TOKEN'] = $user->usu_twofact_token;
                            $_SESSION['TWO_FACTOR_VALID'] = false;
                        }
                        else {
                            $_SESSION['LOGGED_IN_CONSOLE'] = true;
                            $login_result = "OK";
                        }
                    } 
            }
            else
                $erromsg = "Invalid instance";
        }
        else
            return; //primeira entrada
    } while(false);
 */

