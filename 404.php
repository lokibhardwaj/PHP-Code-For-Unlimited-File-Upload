<?php
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');
require (JIRAFEAU_ROOT . 'lib/template/header.php');
?>

<div id="cancel_container" class="cancel_container">
    <div id="upload_cncl" class="upload_cncl">
	    <span class="cancel_image"></span>
	    <span class="cancel_txt" >Whoops! </span>
	    <!--span class="cancel_txt_below">Sorry, but the page you are trying to view does not exist.</span-->
	    <!--span class="cancel_txt_below">We're sorry, The web address you entered is not a functioning page on our site.</span-->
	    <span class="cancel_txt_below">Page not Found! Click <a href="<?php echo $cfg['web_root'];?>" style="text-decoration:underline"> here </a> to get home</span>
		
    </div>	
</div> 

<?php require (JIRAFEAU_ROOT . 'lib/template/footer.php'); ?>