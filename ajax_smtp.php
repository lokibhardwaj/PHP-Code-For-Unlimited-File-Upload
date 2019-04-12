<?php


@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');


/*
*  * PREVENT Abuse
*   */
if (!isset($_POST) || count($_POST) == 0) {
	        die("No POST data found...");
}

if (!validateToken()) {
	        die("CSRF detected...");
}


if(isset($_POST['smtp_host']) && !empty($_POST['smtp_host'])){ // Zip download and Plain download
		$smtp_host = htmlspecialchars(trim($_POST['smtp_host']));
	    $cfg['smtp_host'] = $smtp_host;
 	
	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_host'];
	   
}

if(isset($_POST['smtp_user']) && !empty($_POST['smtp_user'])){ // Zip download and Plain download
		$smtp_user = htmlspecialchars(trim($_POST['smtp_user']));
	    $cfg['smtp_user'] = $smtp_user;
 	
	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_user'];
	   
}
if(isset($_POST['smtp_pass']) && !empty($_POST['smtp_pass'])){ // Zip download and Plain download
		$smtp_pass = htmlspecialchars(trim($_POST['smtp_pass']));
	    $cfg['smtp_pass'] = $smtp_pass;
 	
	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_tls'];
	   
}
if(isset($_POST['smtp_port']) && !empty($_POST['smtp_port'])){ // Zip download and Plain download
		$smtp_port = htmlspecialchars(trim($_POST['smtp_port']));
	    $cfg['smtp_port'] = $smtp_port;
 	
	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_port'];
	   
}
if(isset($_POST['smtp_auth']) && is_numeric($_POST['smtp_auth'])){ // Zip download and Plain download
	   $cfg['smtp_auth'] = true;
 	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_auth'];
}else{
		$cfg['smtp_auth'] = false;
 	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_auth'];
}

if(isset($_POST['smtp_tls']) && is_numeric($_POST['smtp_tls'])){ // Zip download and Plain download
	   $cfg['smtp_tls'] = true;
 	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_tls'];
}else{
		$cfg['smtp_tls'] = false;
 	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['smtp_tls'];
}


?>
