<?php
/*
 *  s42transfer, your web file repository
 *  Copyright (C) 2017
 *  s42transfer <admin@s42.io>
 * 
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

/* Check session. */
session_set_cookie_params(0);
session_start();


check_errors ($cfg);
if (has_error ())
{
    show_errors ();
    require (JIRAFEAU_ROOT . 'lib/template/footer.php');
    exit;
}

require (JIRAFEAU_ROOT . 'lib/template/header.php');

/* Check if user is allowed to upload. */
if (!jirafeau_challenge_upload_ip ($cfg, get_ip_address($cfg)))
{
    echo '<div class="error"><p>' . t('Access denied') . '</p></div>';
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}





/* Ask password if upload password is set. */
if (jirafeau_has_upload_password ($cfg))
{
	session_set_cookie_params(0);
    session_start();

    /* Unlog if asked. */
    if (isset ($_POST['action']) && (strcmp ($_POST['action'], 'logout') == 0))
        session_unset ();

    /* Auth. */
    if (isset ($_POST['upload_password']))
    {
        if (jirafeau_challenge_upload_password ($cfg, $_POST['upload_password']))
        {
            $_SESSION['upload_auth'] = true;
            $_SESSION['user_upload_password'] = $_POST['upload_password'];
        }
        else
        {
            $_SESSION['admin_auth'] = false;
            echo '<div class="error"><p>' . t('Wrong password.') . '</p></div>';
            require (JIRAFEAU_ROOT.'lib/template/footer.php');
            exit;
        }
    }

    /* Show auth page. */
    if (!isset ($_SESSION['upload_auth']) || $_SESSION['upload_auth'] != true)
    {
	?>
        <form action = "<?php echo basename(__FILE__); ?>" method = "post">
        <fieldset>
            <table>
            <tr>
                <td class = "label"><label for = "enter_password">
                <?php echo t('Upload password') . ':';?></label>
                </td>
                <td class = "field"><input type = "password"
                name = "upload_password" id = "upload_password"
                size = "40" />
                </td>
            </tr>
            <tr class = "nav">
                <td></td>
                <td class = "nav next">
                <input type = "submit" name = "key" value =
                "<?php echo t('Login'); ?>" />
                </td>
            </tr>
            </table>
        </fieldset>
        </form>
        <?php
        require (JIRAFEAU_ROOT.'lib/template/footer.php');
        exit;
    }
}

?>

<div id="upload_finished" style="display:none;">
    <div id="upload_finished_download_page">        
		<p class="upload-complete">
			  <?php echo t('Upload complete!') ?> 
			  <!--a id="upload_link_email" href=""><img id="upload_image_email"/></a-->
		</p>
		  <p id="upload_link"></p>
    </div>	
</div>


<!--DELET FILES done-->
<div id="del_done" class="upload_done" style="display:none;">
    <div  class="upload_done_download_page">
	    <span class="done_del_image"></span>
	    <span class="done_txt">File(s) deleted.</span>
		<div id="dvCountDown_done_del" class="dvCountDown_done" >
           <span class="del_set">You will be redirected after <span id = "lblCount"></span> seconds.</span> <span class="del_set_1">if not click <a  href="<?php if(isset($cfg['web_root'])){ echo $cfg['web_root']; }?>" class="if_not_redirect_after_delete">here</a></span>
        </div>
    </div>	
</div>




<!--Uploading done-->
<div id="upload_done" class="upload_done" style="display:none;">
    <div id="upload_done_download_page" class="upload_done_download_page">
    <!--<span class="done_image"></span>-->
<div id="cont-count-done" data-pct="100">
<svg id="svg-count-done" width="200" height="200" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
  <circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
  <circle id="bar-count-done" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
</svg>
</div>

	    <span class="done_txt count_done_txt">Done!</span>
		<div id="dvCountDown_done" >
           You will redirect in <span id = "lblCount_done"></span>sec. if not click <a  href="javascript:void(0);" class="if_not_redirect">here</a>
        </div>
    </div>	
</div>

<!--Uploading cancel-->
<div id="cancel_container" class="cancel_container" style="display:none;">
    <div id="upload_cncl" class="upload_cncl">
	    <span class="cancel_image"></span>
	    <span class="cancel_txt">Upload Error!</span>
	    <span class="cancel_txt_below">Something went wrong</span>
		
    </div>	
</div>


<!--Uploading progress-->
<div id="uploading">
     <p class="upload_bar">
    
		 <div id="cont" data-pct="0">
		  <svg id="svg" width="200" height="200" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
			<circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
			<circle id="bar" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
		  </svg>
		  
			   <div id="uploaded_speed"></div>
		  </div>
	<div class="timing-container">
		<div class="uploading"> <?php echo t ('Uploading...'); ?></div>
		<div id="uploaded_percentage" style="display:none;"></div>    
		<div id="uploaded_percentage_tot" style="display:none;"></div>    
		<div id="uploaded_size_cal" style=""><span id="up_left_size"></span> of <span id="up_tot_size"></span></div>    
		<div id="uploaded_time"></div>
	</div> 
    </p>
	
	  <p id="current_upload_wrapper" class="current_upload_wrapper">
	   
			<div id="current_upload" class="current_uploads"> 
				<div id="current_p_bar" class="current_p_bar"> <span id="current_p_status">&nbsp;</span></div>
				<div id="current_file_name" class="current_file_name"></div>
				<div id="current_file_size" class="current_file_size"></div>	
			</div>
			
			<div class="uplaoding-ht">
				<div id="files_remaing" class="files_remaing">
					<span id="left_files" class="left_files"></span>
					<span id="expander_files" class="expand_icon down_icon" style="display:none;" >&#x203A;</span>
					<span id="done_files" class="done_files"></span>
					
				</div>			
		    </div><!--uplaoding-ht-->	
			
			
		  <div class="expand_wrappper" >
            <div id="current_upload" class="current_upload"> </div>		  
		  </div><!--expand_wrappper-->
		
		<div class="upload_cancel"><a class="upload_cancel_btn" href="javascript:void(0);">Cancel</a> </div>
	 </p><!--current_upload_wrapper-->
</div>

<!--@END Uploading progress-->

<div id="error_pop" class="error"></div>

<?php
if(isset($_COOKIE['remember_me_pwd']) && $_COOKIE['remember_me_pwd'] !=""){
	//print_r($_COOKIE);
	$_SESSION['login_auth'] = $_COOKIE['remember_me']; 

}
?>



<!-- LOGIN SCREEEN-->
<?php 

if(($cfg['security_enable'] ==true) && (!isset($_SESSION['login_auth']))) 
{
	?>

	

<div id="upload-login">


     <fieldset id="" class="logins-wrapper access_denied">
	   <div class="login error_conttent">
	      <p class="access_error">Restricted Area</p>
	      <p class="wrong-password">Enter username and password</p>
	  
	  <form name="login-form" id="login-form" class="login-form" method="post" action="">  
	   <p class="security-box set-top">   
         <span class="upload-sec-block">	          	 
		     <input type="text" id="user" name="user" value="<?php  if(isset($_COOKIE['remember_me'])){echo $_COOKIE['remember_me']; }?>" class="e_txt sec-user" placeholder="<?php echo t('Username'); ?>" /> 
		 </span>
       </p>	
       <p class="security-box">   
         <span class="upload-sec-block">	          	 
		     <input type="password" class="e_txt sec-pwd pwdtxt" id="password" name="password" value="<?php  if(isset($_COOKIE['remember_me_pwd'])){echo $_COOKIE['remember_me_pwd']; }?>"  placeholder="<?php echo t('Password'); ?>" /> 
		 </span>
       </p>	
       <p class="security-box remember-me-block">   
         <span class="upload-sec-block">	          	 
		     <input type="checkbox" name="remember-me" id="remember-me" class="remember-me" value="1"/>		   
			 <label for="remember-me">Remember me</label>
			 
		 </span>
       </p>	   

	  
		<div class="submit_login">		
				<input type="submit" name="key" value="Login"/> 
		</div>
		</form>
		 
       </div><!--login error_conttent-->		 

	</fieldset>   
</div>
<?php }?>
<!-- END LOGIN SCREEEN-->



<!-- LOGIN SCREEEN-->
<div id="upload-login-error" style="display:none;">
     <fieldset id="" class="access_denied">
	   <div class="login error_conttent">
	      <p class="access_error">Access Denied</p>
	      <p class="wrong-password">Wrong Password</p>
       </div><!--login error_conttent-->		 

	</fieldset>   
</div>
<!-- END LOGIN SCREEEN ERROR-->




<?php

if(($cfg['security_enable'] ==false) && (!isset($_SESSION['login_auth']))) 
{
	$display = 'block';
}else{
	$display = 'none';
}

if(isset($_SESSION['login_auth']) && $_SESSION['login_auth']==true) 
{
	$display = 'block';
}
?>


<?php 

 
	  
//print_r($_SESSION);
if(isset($_COOKIE)){
	
//print_r($_COOKIE);
//print_r($_SESSION);
}

?>	
	

<!--Upload screen-->
<div id="upload" style="display:<?php echo $display;?>">
<fieldset id="bgImg" class="bgImg-first">
    <legend>
    <?php echo t('Select a file'); ?> 
    </legend>
   
	  <p id="text-box" class="text-box">
	  <span class="upload">Upload files</span>
	  <span class="drag">Click or drag and drop your files</span>
	 
	 		  <?php	
                // find server 	Windows	or Mac	  
				$user_agent = getenv("HTTP_USER_AGENT");
				if(strpos($user_agent, "Win") !== FALSE)
				$os = "Windows";
				elseif(strpos($user_agent, "Mac") !== FALSE)
				$os = "Mac";
				
				 // find server user browser	  
				if (isset($_SERVER['HTTP_USER_AGENT'])) {
					$agent = $_SERVER['HTTP_USER_AGENT'];
					
				}
				
				if($os === "Windows")
				  { 
			       //echo "Windows";
			        if (stripos( $agent, 'Chrome') !== false)
					{
						echo "Google Chrome";
						?>
						<input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>' )"  multiple="multiple"/>
						<?php
					}
					elseif (stripos( $agent, 'Safari') !== false)
					{
					  // echo "Safari";
					   ?>
					   <input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>' )"  />
					   <?php
					}
					elseif (stripos( $agent, 'Opera') !== false)
					{
					  // echo "Opera";
					   ?>
					   <input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>' )"  />
					   <?php
					}
					else{
						// echo "Other";
						?>
						<input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>' )"  multiple="multiple"/>
					  <?php
						
					}
														  
				  }					
				  elseif($os === "Mac")
				  {
					//echo $os = "Mac"
					?>					
					<input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>')" multiple="multiple"/>
		
				    <?php	
				  }	
                 else
				  {
					//echo $os = "other"
					?>					
					<input type="file" id="file_select" class="file_select_before"  onchange="control_selected_file_size(<?php echo $cfg['maximal_upload_size'] ?>, '<?php echo t ('File is too big') . ', ' . t ('File size is limited to') . " " . $cfg['maximal_upload_size'] . " MB"; ?>')" multiple="multiple"/>
		
				    <?php	
				  }					  
				?>	
				
				
				
			  </p>
	       <div id="file-list-container">		   
				
					<div id="total_to_upload" class="total_to_uploads" style="display:none;">
						<span id="total_to_upload_left" class="left_files_uploads"></span>
						<span id="expander_total_upload" class="expand_icons_total down_icon">&#x203A;</span>
						<span id="total_to_upload_size" class="done_files"></span>						
					</div>	
					
				<div id="file_list" class="file_list_wrapper"><div class="fileList"></div>	    </div>
			   
				<div class="add_file_wrapper" id="add_file_wrapper" style="display:none;">		
				   <input type="file" id="file_select_1" class="file_select"  size="30" multiple="multiple" />		  
				   <input type="hidden" id="txt_file_select_1" class="file_select_count" value="" />
				</div>
           </div><!--file-list-containe-->
		   
    <div id="options">
        <table id="option_table">
        <tr>
           <td>
		    <input type="checkbox" id="one_time_download" /> 
			<label for="one_time_download"><?php echo t('One time download'); ?></label>
			
		   </td>
        </tr>
        <tr>
        <td><input type="checkbox" id="pwdChk" class="pwdChk"/> <label for="pwdChk"> <?php echo t('Password'); ?></label></td>
        <td><input type="password" name="key" id="input_key" disabled="disabled" placeholder="Password"/></td>
        </tr>
        <tr>
        <td><label for="select_time"><?php echo t('Time limit'); ?></label></td>
        <td><select name="time" id="select_time">
        <?php if ($cfg['availabilities']['none']) { ?>
        <option value="none"><?php echo t('Never'); ?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['year']) { ?>
        <option value = "year"><?php echo t('One year');?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['month']) { ?>
        <option value = "month"><?php echo t('1 month');?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['week']) { ?>
        <option value = "week"><?php echo t('1 week'); ?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['day']) { ?>
        <option value = "day"><?php echo t('1 day'); ?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['hour']) { ?>
        <option value = "hour"><?php echo t('1 hour'); ?></option>
        <?php } ?>
        <?php if ($cfg['availabilities']['minute']) { ?>
        <option value = "minute"><?php echo t('1 minute'); ?></option>
        <?php } ?>
        </select></td>
        </tr>

        <?php
        if ($cfg['maximal_upload_size'] > 0)
        {
			echo '<p class="config">' . t ('File size is limited to');
			echo " " . $cfg['maximal_upload_size'] . " MB</p>";
        }
        ?>

		<p id="max_file_size" class="config"></p>
    
        </table>
	<p>
    <?php
    if (jirafeau_has_upload_password ($cfg) && $_SESSION['upload_auth'])
    {
    ?>
    <input type="hidden" id="upload_password" name="upload_password" value="<?php echo $_SESSION['user_upload_password'] ?>"/>
    <?php
    }
    else
    {
    ?>
    <input type="hidden" id="upload_password" name="upload_password" value=""/>
    <?php
    }
    ?>
	<input type="hidden" id="web_root"  value="<?php echo $cfg['web_root']; ?>"/> 
	<input type="hidden" id="jirafeau_get_max_upload_size_bytes"  value="<?php echo jirafeau_get_max_upload_size_bytes (); ?>"/>
	<input type="hidden" id="all_select_fiels"  value=""/>
	<input type="hidden" id="total_Upload_Size"  value=""/>
	<input type="hidden" id="txt_file_select"  value=""/>
	<input type="hidden" id="all_txt_file_select"  value=""/>
	<input type="hidden" id="files_limit"  value="<?php if(isset($cfg['temp1']) && $cfg['temp1'] !=""){echo $cfg['temp1'];}?>"/>
	
	<div class="files_limit" id="files_limit_error"></div>
    <input type="submit" id="send" value="<?php echo t('Upload'); ?>"
    onclick="
        document.getElementById('upload').style.display = 'none';
        document.getElementById('uploading').style.display = '';
        
    "/>
	<!--upload($("#web_root").val(),$("#jirafeau_get_max_upload_size_bytes").val());-->
    </p>
    </div> </fieldset>

    <?php
    if (jirafeau_has_upload_password ($cfg))
    {
    ?>
    <form action = "<?php echo basename(__FILE__); ?>" method = "post">
        <input type = "hidden" name = "action" value = "logout"/>
        <input type = "submit" value = "<?php echo t('Logout'); ?>" />
    </form>
    <?php
    }
    ?>

</div>

<!--@ END Upload-->

<script type="text/javascript" lang="Javascript">
    document.getElementById('error_pop').style.display = 'none';
    document.getElementById('uploading').style.display = 'none';
    document.getElementById('upload_finished').style.display = 'none';
    document.getElementById('options').style.display = 'none';
    document.getElementById('send').style.display = 'none';
    if (!check_html5_file_api ())
        document.getElementById('max_file_size').innerHTML = '<?php
             echo t('You browser may not support HTML5 so the maximum file size is ') . jirafeau_get_max_upload_size ();
             ?>';
</script>
<?php require (JIRAFEAU_ROOT . 'lib/template/footer.php'); ?>
