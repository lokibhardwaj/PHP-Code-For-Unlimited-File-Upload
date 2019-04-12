<?php


//@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/config.local.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

/* Check session. */
session_start();

if(isset($_POST['password']) && $_POST['password'] !="" ){
	
	
	$pwd = md5($_POST['password']);
	if($pwd == $cfg['sec_pwd'] && $_POST['user'] == $cfg['sec_user']){
		
		//set rember me
			if(isset($_POST['remember-me'])  && $_POST['remember-me']==1) {
			  $onday = time() + 86400;
			  setcookie('remember_me', $_POST['user'], $onday);
			  setcookie('remember_me_pwd', md5($_POST['password']), $onday);
			  setcookie('remember', '1', $onday);
			}else{
				if(isset($_COOKIE['remember_me'])) {
				$past = time() - 100;
				setcookie('remember_me', " ", $past);
				setcookie('remember_me_pwd', " ", $past);
				setcookie('remember', ' ', $past);
			   }
			}
		
		echo "1";
		$_SESSION['login_auth'] = true;
	}else{
		echo "2";
	}
	
}else{
	echo '0';
}



	die();

?>