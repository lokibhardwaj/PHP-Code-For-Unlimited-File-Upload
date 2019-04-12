<?php


@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

if(isset($_POST['downloadMode']) && $_POST['downloadMode'] !=""){ // Zip download and Plain download

	   if(!empty($_POST['downloadMode'])){
	    $cfg['downloadMode'] = trim($_POST['downloadMode']);
	   }		
	   jirafeau_export_cfg_custom($cfg);
	   echo $cfg['downloadMode'];
	   die();
}

//Allow zip, plain and both download in admin
if(isset($_POST['adminDownloadMode']) && $_POST['adminDownloadMode'] !=""){ // Zip download and Plain download

	   if(!empty($_POST['adminDownloadMode'])){
		   if("plain" == trim($_POST['adminDownloadMode'])){
			  $cfg['downloadMode'] = "plainFiles";
		   }
		   if("zip" == trim($_POST['adminDownloadMode']) || "zipAndPlain" == trim($_POST['adminDownloadMode'])){
			  $cfg['downloadMode'] = "zipFiles";
		   }
		   
	     $cfg['allow_downloadMode'] = trim($_POST['adminDownloadMode']);
		
	   }		
	   jirafeau_export_cfg_custom($cfg);
	   echo 'allow_downloadMode_done';
	   die();
}


?>