<?php

//@error_reporting(0);


define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');



require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

//Allow Re zipped
if(isset($_POST['re_zipped_ctrl']) && $_POST['re_zipped_ctrl'] !=""){ // Zip download and Plain download
    
	if($_POST['re_zipped_ctrl'] == 1){
		$_POST['re_zipped_ctrl'] = true;
	}else{
		$_POST['re_zipped_ctrl'] = false;
	}	
	$cfg['re_zipped'] = trim($_POST['re_zipped_ctrl']);			  	
	jirafeau_export_cfg_custom($cfg);
	echo 'rezipped_done';
	
	die();
}





//Allow show link
if(isset($_POST['download_link_ctrl']) && $_POST['download_link_ctrl'] !=""){ // Zip download and Plain download
    
	if($_POST['download_link_ctrl'] == 1){
		$_POST['download_link_ctrl'] = true;
	}else{
		$_POST['download_link_ctrl'] = false;
	}	
	$cfg['show_download_link'] = trim($_POST['download_link_ctrl']);			  	
	jirafeau_export_cfg_custom($cfg);
	echo 'download_link_done';
	
	die();
	
}

die();

?>