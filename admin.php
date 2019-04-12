<?php
/*
 *  s42transfer, your web file repository
 *  Copyright (C) 2017  s42transfer <admin@s42.io> 
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
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
 
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

/* Check if installation is OK. */
if (file_exists (JIRAFEAU_ROOT . 'install.php')
    && !file_exists (JIRAFEAU_ROOT . 'lib/config.local.php'))
{
    header('Location: install.php'); 
    exit;
}

/* If called from CLI, no password or graphical interface */
if (php_sapi_name() == "cli") {
    if ((count($argv)>1) && $argv[1]=="clean_expired") {
        $total = jirafeau_admin_clean();
        echo "$total expired files deleted.\n";
    } elseif ((count($argv)>1) && $argv[1]=="clean_async") {
        $total = jirafeau_admin_clean_async();
        echo "$total old unfinished transfers deleted.\n";
    } else {
        die("No command found. Should be admin.php <clean_expired|clean_async>.\n");
    }
} else {

if(isset($_GET['action']) && $_GET['action']=="tabs1-typekit" ){
	ob_start();
	clearstatcache();
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Content-Type: application/xml; charset=utf-8");
	
	
	header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");
		
	header('Location: admin.php#tabs1-typekit'); 
	ob_end_flush();
}

/* Disable admin interface if we have a empty admin password. */
if (empty($cfg['admin_password']) && empty($cfg['admin_http_auth_user']))
{
    require (JIRAFEAU_ROOT . 'lib/template/header_admin.php');
	echo '<div class="error"><div id="cancel_container" class="cancel_container" style="display:block;">
    <div id="upload_cncl" class="upload_cncl">
	    <span class="cancel_image"></span>
	    <span class="cancel_txt">'.t('Sorry, the admin interface is not enabled.') . '</span>
	    
		
    </div>	
</div></div>';
    
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}




/* Check session. */
session_start();

/* Unlog if asked. */
if (isset ($_POST['action']) && (strcmp ($_POST['action'], 'logout') == 0))
    $_SESSION['admin_auth'] = false;

/* Check classic admin password authentification. */
if (isset ($_POST['admin_password']) && empty($cfg['admin_http_auth_user']))
{
    if (strcmp ($cfg['admin_password'], md5($_POST['admin_password'])) == 0){
        $_SESSION['admin_auth'] = true;
	    header('Location: admin.php'); 
	}
	
    else
    {
        $_SESSION['admin_auth'] = false;
        require (JIRAFEAU_ROOT . 'lib/template/header_admin.php');
        echo '<div class="error"><div id="cancel_container" class="cancel_container" style="display:block;">
    <div id="upload_cncl" class="upload_cncl">
	    <span class="cancel_image"></span>
	    <span class="cancel_txt">'.t("Wrong password!") . '</span>
	    <span class="cancel_txt_below"><a href="'. rtrim($cfg["web_root"], "/") . '/admin.php">Try again</a></span>
		
    </div>	
</div></div>';
        require (JIRAFEAU_ROOT.'lib/template/footer.php');
        exit;
    }
}





/* Ask for classic admin password authentification. */
elseif ((!isset ($_SESSION['admin_auth']) || $_SESSION['admin_auth'] != true)
        && empty($cfg['admin_http_auth_user']))
{
    require (JIRAFEAU_ROOT . 'lib/template/header_admin.php'); ?>
	
	

	
	<div id="sendLinks_wrapper" class="admin_wrapper">
		<p class="send-links"> Admin Login </p>
		<form action = "<?php echo basename(__FILE__); ?>" method = "post">
		  <div class="send_txt login_txt"><input type = "password"  name = "admin_password" id = "admin_password"   placeholder="Password" /></div>
			<div class="submit_send">		
				<input type = "submit" name = "key" value ="<?php echo t('Login'); ?>" /> 
			 </div>		
		</form>
     </div>	
    <?php
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}





/* Check authenticated user if HTTP authentification is enable. */
elseif ((!isset ($_SESSION['admin_auth']) || $_SESSION['admin_auth'] != true)
        && !empty($cfg['admin_http_auth_user']))
{
    if ($cfg['admin_http_auth_user'] == $_SERVER['PHP_AUTH_USER'])
        $_SESSION['admin_auth'] = true;
}

/* Be sure that no one can access further without admin_auth. */
if (!isset ($_SESSION['admin_auth']) || $_SESSION['admin_auth'] != true)
{
         $_SESSION['admin_auth'] = false;
        require (JIRAFEAU_ROOT . 'lib/template/header_admin.php');
        echo '<div class="error"><p>'.
         t('Sorry, you are not authenticated on admin interface.') .
         '</p></div>';
        require (JIRAFEAU_ROOT.'lib/template/footer.php');
        exit;
}

/* Operations may take a long time.
 * Be sure PHP's safe mode is off.
 */
@set_time_limit(0);
/* Remove errors. */
@error_reporting(0);

/* Show admin interface if not downloading a file. */
//if (!(isset ($_POST['action']) && strcmp ($_POST['action'], 'download') == 0))
//{
        require (JIRAFEAU_ROOT . 'lib/template/header_admin.php');  
		
if(isset($_POST['action_list_bottom']) && !empty($_POST['action_list_bottom'])){
	$_POST['action_list']=$_POST['action_list_bottom'];
}
if(!isset($_POST['action_list_bottom']) && !isset($_POST['action_list'])){
	$_POST['action_list'] = '';
	$_POST['action_list_bottom'] ='';
}
		?>
		

  
		<div id="tab-container" class="tab-container admin_interface">
			  <ul class='etabs'>
				<li class='tab'><a href="#tabs1-gen">General</a></li>
				<li class='tab'><a href="#tabs1-design"> Design</a></li>
				<li class='tab'><a id="kit-type" href="#tabs1-typekit">Typekit</a></li>
				<li class='tab'><a href="#tabs1-shar">Sharing</a></li>
				<li class='tab'><a href="#tabs1-settings">Settings</a></li>
				
				<input type="hidden" class="site_url" value="<?php echo $cfg['web_root']?>"/>
			  </ul>
			  
			  <div class="logout">
				 <form action = "<?php echo basename(__FILE__); ?>" method = "post">
					<input type = "hidden" name = "action" value = "logout" />
					<input type = "submit" value = "<?php echo t('Logout'); ?>"  title="<?php echo t('Logout'); ?>"/>
				</form>
			  </div>
				  
				  
				  <div id="tabs1-gen" class="tab_content">
					<h2>General</h2>
					<div class="ad_gen_wp">
						<div class="ad_gen_left">

							<form action = "<?php echo basename(__FILE__); ?>" method = "post">	
								<span class="edit_label">Edit</span>
								<input type = "hidden" name = "action" value = "list"/>
									<select name="action_list" id="">
										<option value="100000"> Show All Files</option>
										<option value="30" <?php if($_POST['action_list']==30){ print 'selected="selected"'; }?>> 30</option>
                                        <option value="60" <?php if($_POST['action_list']==60){ print 'selected="selected"'; }?>> 60</option>											
										<option value="90" <?php if($_POST['action_list']==90){ print 'selected="selected"'; }?>> 90</option>										
																			
																			
									</select>
								<input type = "submit" value = "<?php echo t('Ok'); ?>" title="<?php echo t('Submit'); ?>" />
							</form>
						</div>
						
						<div class="ad_gen_right">
							 <form action = "<?php echo basename(__FILE__); ?>" method = "post">	
								<span class="search_label">Search</span>
								<input type = "hidden" name = "action" value = "search_by_name"/>
								<div class="search-container">
									<input type = "text" name = "name" id = "name"/>
									<select name="action" id="">
										<option value="search_by_name"> Filename</option>									
										<option value="search_by_file_hash"> File hash</option>
										<option value="search_link"> Link</option>
									</select>
								</div>
								<input type = "submit" value = "<?php echo t('Search'); ?>"  title="<?php echo t('Search'); ?>"/>
							</form>
						</div>
					</div>	
					
					 <?php if (isset ($_POST['action']))
						  {							
							if (strcmp ($_POST['action'], 'clean') == 0)
							{
								$total = jirafeau_admin_clean ();
								echo '<div class="message">' . NL;
								echo '<p>';
								echo t('Number of cleaned files') . ' : ' . $total;
								echo '</p></div>';
							}
							elseif (strcmp ($_POST['action'], 'clean_async') == 0)
							{
								$total = jirafeau_admin_clean_async ();
								echo '<div class="message">' . NL;
								echo '<p>';
								echo t('Number of cleaned files') . ' : ' . $total;
								echo '</p></div>';
							}
							elseif (strcmp ($_POST['action'], 'list') == 0)
							{
								//print $_POST['action_list'];
								jirafeau_admin_list_custom ("", "", "","",$_POST['action_list']);
								$_POST['action_list_bottom']=$_POST['action_list'];
							}						
							elseif (strcmp ($_POST['action'], 'search_by_name') == 0)
							{
								
								jirafeau_admin_list_custom ($_POST['name'], "", "",$_POST['action']);
							}
							elseif (strcmp ($_POST['action'], 'search_by_file_hash') == 0)
							{
								jirafeau_admin_list_custom ("", $_POST['name'], "",$_POST['action']);
							}
							elseif (strcmp ($_POST['action'], 'search_link') == 0)
							{
								jirafeau_admin_list_custom ("", "", $_POST['name'],$_POST['action']);
							}
							elseif (strcmp ($_POST['action'], 'delete_link') == 0)
							{
								jirafeau_delete_link ($_POST['link']);
								echo '<div class="message">' . NL;
								echo '<p>' . t('Link deleted') . '</p></div>';
								jirafeau_admin_list_custom ("", "", "","");
							}
							elseif (strcmp ($_POST['action'], 'delete_file') == 0)
							{
								$count = jirafeau_delete_file ($_POST['md5']);
								echo '<div class="message">' . NL;
								echo '<p>' . t('Deleted links') . ' : ' . $count . '</p></div>';
								jirafeau_admin_list_custom ("", "", "","");
							}
							elseif (strcmp ($_POST['action'], 'download') == 0)
							{
								$l = jirafeau_get_link ($_POST['link']);
								if (!count ($l))
									return;
								$p = s2p ($l['md5']);
								header ('Content-Length: ' . $l['file_size']);
								header ('Content-Type: ' . $l['mime_type']);
								header ('Content-Disposition: attachment; filename="' .
										$l['file_name'] . '"');
								if (file_exists(VAR_FILES . $p . $l['md5']))
									readfile (VAR_FILES . $p . $l['md5']);
								exit;
							}
						}
						
						if (isset ($_GET['action']))
						  {							
							if (strcmp ($_GET['action'], 'clean') == 0)
							{
								$total = jirafeau_admin_clean ();
								echo '<div class="message">' . NL;
								echo '<p>';
								echo t('Number of cleaned files') . ' : ' . $total;
								echo '</p></div>';
							}
							elseif (strcmp ($_GET['action'], 'clean_async') == 0)
							{
								$total = jirafeau_admin_clean_async ();
								echo '<div class="message">' . NL;
								echo '<p>';
								echo t('Number of cleaned files') . ' : ' . $total;
								echo '</p></div>';
							}
							elseif (strcmp ($_GET['action'], 'list') == 0)
							{
								
								jirafeau_admin_list_custom ("", "", "","");
							}
							elseif (strcmp ($_GET['action'], 'search_by_name') == 0)
							{
								if(!isset($_GET['name'])){
									$_GET['name']="";
								}
								if(!isset($_GET['order_by'])){
									$_GET['order_by']="desc";
								}
								jirafeau_admin_list_custom ($_GET['name'], "", "",$_GET['action'],"",$_GET['order_by']);
							}
							elseif (strcmp ($_GET['action'], 'search_by_file_hash') == 0)
							{
								if(!isset($_GET['name'])){
									$_GET['name']="";
								}
								if(!isset($_GET['order_by'])){
									$_GET['order_by']="desc";
								}
								jirafeau_admin_list_custom ("", $_GET['name'], "",$_GET['action'],"",$_GET['order_by']);
							}
							elseif (strcmp ($_GET['action'], 'search_link') == 0)
							{
								if(!isset($_GET['name'])){
									$_GET['name']="";
								}
								if(!isset($_GET['order_by'])){
									$_GET['order_by']="desc";
								}
								jirafeau_admin_list_custom ("", "", $_GET['name'],$_GET['action'],"",$_GET['order_by']);
							}
							elseif (strcmp ($_GET['action'], 'delete_link') == 0)
							{
								jirafeau_delete_link ($_GET['link']);
								echo '<div class="message">' . NL;
								echo '<p>' . t('Link deleted') . '</p></div>';
								
								jirafeau_admin_list_custom ("", "", "","");
							}
							elseif (strcmp ($_GET['action'], 'delete_file') == 0)
							{
								$count = jirafeau_delete_file ($_POST['md5']);
								echo '<div class="message">' . NL;
								echo '<p>' . t('Deleted links') . ' : ' . $count . '</p></div>';
								jirafeau_admin_list_custom ("", "", "","");
							}
							elseif (strcmp ($_GET['action'], 'download') == 0)
							{
								$l = jirafeau_get_link ($_GET['link']);
								if (!count ($l))
									return;
								$p = s2p ($l['md5']);
								header ('Content-Length: ' . $l['file_size']);
								header ('Content-Type: ' . $l['mime_type']);
								header ('Content-Disposition: attachment; filename="' .
										$l['file_name'] . '"');
								if (file_exists(VAR_FILES . $p . $l['md5']))
									readfile (VAR_FILES . $p . $l['md5']);
								exit;
							}
							
							// ORDER BY Submit
							elseif (strcmp ($_GET['action'], 'order_by_val') == 0)
							{
								
								if(!isset($_GET['order_by'])){
									$_GET['order_by']="desc";
								}
								jirafeau_admin_list_custom ("", "", "",$_GET['action'],"",$_GET['order_by']);
							}
							
							
						}
						if(!isset($_POST['action']) && !isset($_GET['action'])){
						  //echo "BOTH NOT SET";
							jirafeau_admin_list_custom ("", "", "","");
						}
                      ?>
					 <div class="ad_gen_bottom_right">

							<form action = "<?php echo basename(__FILE__); ?>" method = "post">	
								<input type = "hidden" name = "action" value = "list"/>
									<select name="action_list_bottom" id="" onchange="this.form.submit()">
										<option value="100000"> Show All Files</option>
										<option value="30" <?php if($_POST['action_list_bottom']==30){ print 'selected="selected"'; }?>> 30</option>
                                        <option value="60" <?php if($_POST['action_list_bottom']==60){ print 'selected="selected"'; }?>> 60</option>											
										<option value="90" <?php if($_POST['action_list_bottom']==90){ print 'selected="selected"'; }?>> 90</option>										
																			
																			
									</select>
							</form>
						</div>
				  </div>
				  
				  
				  
				  <div id="tabs1-design" class="tab_content">
				   
					
					<form id="design_colors_form" action="admin.php#tabs1-design" method="post">
					  <div class="color_wrapper">
					   <h1>Colors</h1>
					    <!--main-color-->
					     <div class="main-color">
						    <h2>Main Colors</h2>
							<div class="m_color_row">
							     <span class="m_color">Dark</span>
								  <input type='text' class="mainColor" name="main_color" value="<?php if(isset($_POST['main_color'])){echo $_POST['main_color'];}else{ echo $cfg['main_color'];}?>" />
							 </div>
							 <div class="m_color_row">
							     <span class="m_color">Light</span>
								  <input type='text' class="lightColor" name="main_color_light" value="<?php if(isset($_POST['main_color_light'])){echo $_POST['main_color_light'];}else{ echo $cfg['main_color_light'];}?>" />
							 </div>
						   </div><!--main-color-->
						   
						   <!--background-color-->
						   <div class="background-color">
						    <h2>Background Gradient</h2>
							<div class="m_color_row">
							     <span class="m_color">Color 1</span>
								  <input type='text' class="bg_gradient_color1" name="bg_gradient_color1" value="<?php if(isset($_POST['bg_gradient_color1'])){echo $_POST['bg_gradient_color1'];}else{ echo $cfg['bg_gradient_color1'];}?>" />
							 </div>
							 <div class="m_color_row">
							     <span class="m_color">Color 2</span>
								  <input type='text' class="bg_gradient_color2" name="bg_gradient_color2" value="<?php if(isset($_POST['bg_gradient_color2'])){echo $_POST['bg_gradient_color2'];}else{ echo $cfg['bg_gradient_color2'];}?>" />
							 </div>
						   </div><!--background-color-->
						</div><!--color_wrapper-->
					  <div class="design_setting_btn"><input type="submit" name="color_action" value="Save"/> <div id="color_done" class="color_done"></div> </div>
					 </form>

					<!-- Logo Change-->		
					   <div class="color_wrapper logo_container">
                            <div class="middle_heading"><h1 class="main_middle_headings">Logo</h1></div>					   
						 <div class="main-color">
						    <div class="logo_heading"><h1>Logo</h1> <p>PNG or JPG, Max size: 190x90px</p></div>
						      <div id='preview'>
							   <?php if(isset($cfg['logo']) && $cfg['logo'] !=""){
								   echo '<img class="preview" src="'.$cfg['logo'].'" alt="logo" title="logo" />';
							   }?>
							  </div>
							  <div class="logo_upload">
							   <div id='preview_error'></div>
							    <form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
							        <span class="change_logo">Change</span>
							        <span class="delete_icon" id="delete_logo">Delete</span>	                                    									
								    <input type="file" name="photoimg" id="photoimg" />
								</form>
							  </div>
								
						  </div><!--main-color (Logo chnage)-->
						  
						  <!-- Logo Retina Resolution -->
						   <div class="background-color logo_retina">
						    <div class="logo_heading"><h1>Logo Retina Resolution</h1> <p>PNG or JPG, Max size: 380x180px</p></div>
						      <div id='preview_retina'>
							   <?php if(isset($cfg['logo_resolation']) && $cfg['logo_resolation'] !=""){
								   echo '<img class="preview_retina" src="'.$cfg['logo_resolation'].'" alt="logo retina" title="logo" />';
							   }?>
							  </div>
							  <div class="logo_retina_upload">
							  <div id='preview_retina_error'></div>
							    <form id="logo_retinaform" method="post" enctype="multipart/form-data" action='ajaximage_retina.php'>
							        <span class="change_logo_retina">Change</span>
							        <span class="delete_icon" id="delete_retina">Delete</span>	                                    									
								    <input type="file" name="photoimg_retina" id="photoimg_retina" />
								</form>
							  </div>
								
						  </div><!--background-color ()LOGO Retina Resolution-->


						</div><!--logo_container-->
						   
						   
						 
					<!-- Favicon and touchIcon-->							
					   <div class="color_wrapper fav_container">	
                          <div class="middle_heading"><h1 class="main_middle_headings">Favicon &amp; Touchicon</h1></div>						   
						 <div class="main-color fav">
						    <div class="fav_heading"><h1>Favicon</h1> <p>Recommended Size: 64x64px</p></div>
						      <div id='preview_favicon'>
							   <?php if(isset($cfg['favicon']) && $cfg['favicon'] !=""){
								   echo '<img class="preview_favicon" src="'.$cfg['favicon'].'" alt="favicon" title="favicon" />';
							   }?>
							  </div>
							  <div class="favicon_upload">
							  <div id='preview_favicon_error'></div>
							    <form id="favicon_form" method="post" enctype="multipart/form-data" action='ajaximage_favicon.php'>
							        <span class="change_favicon">Change</span>
							        <span class="delete_icon" id="delete_favicon">Delete</span>	                                    									
								    <input type="file" name="photoimg_favicon" id="photoimg_favicon" />
								</form>
							  </div>
								
						  </div><!--main-color (Favicon chnage)-->
						  
						  <!-- Logo Retina Resolution -->
						   <div class="background-color touchicon">
						    <div class="logo_heading"><h1>Touchicon</h1> <p>Recommended Size: 144x144px</p></div>
						      <div id='preview_touchicon'>
							   <?php if(isset($cfg['touchicon']) && $cfg['touchicon'] !="" ){
								   echo '<img class="preview_touchicon" src="'.$cfg['touchicon'].'" alt="Touchicon retina" title="Touchicon" />';
							   }?>
							  </div>
							  <div class="touchicon_upload">
							   <div id='preview_touchicon_error'></div>
							    <form id="touchicon_form" method="post" enctype="multipart/form-data" action='ajaximage_touchicon.php'>
							        <span class="change_touchicon">Change</span>
							        <span class="delete_icon" id="delete_touchicon">Delete</span>	                                    									
								    <input type="file" name="photoimg_touchicon" id="photoimg_touchicon" />
								</form>
							  </div>
								
						  </div><!--background-color (touchicon)-->


						</div><!--fav_container-->
						   
					  
					 
					 
					 
				  </div><!--tabs1-design-->
				  
				  
				  <div id="tabs1-typekit" class="tab_content">
				  <!--typekit content -->
					<h2>Typekit Fonts</h2>
					<div class="ad_Typekit">
					<form id="typekit_form" action="admin.php#tabs1-typekit"  method="post" autocomplete="off">
						 <div class="ad_shar_chk">
						   <input id="ad_typekit_chk" class="ad_typekit_chk" name="typekit_fontreplacement" value="1" type="checkbox" <?php if( $cfg['typekit_fontreplacement']==1){ echo 'checked="checked"';}?>/>
                           <label for="ad_typekit_chk"> Enable Font Replacement</label>
					      </div>
						<div id="typekite_feilds" class="typekite_feilds">  
						 
							  <div class="ad_typekit_left">
								<p class="ad_tpye_head"><h1>Typekit Code</h1> <span class="ad_typelit_msg">Enter Here Your Typekit Code</span></p>
								<p class="ad_tpye_content">
								
								<textarea name="typekit_code"  id="typekiteCode" class="typekiteCode" <?php if( $cfg['typekit_fontreplacement']==0){ echo 'disabled="disabled"';}?>><?php echo htmlentities($cfg['typekit_code']); ?></textarea>  </p>
								<p class="ad_type_lorem"></p>
							  </div>
							  <div class="ad_typekit_right">
								<p class="ad_tpye_head"> Type Name and Allocation</p>
								 <p class="ad_type_txt">
									<label for="ad_type_normal"> Normal Text</label>
									<input id="ad_type_normal" class="ad_type_normal" name="typekit_normal" type="text" value="<?php echo $cfg['typekit_normal']?>" <?php if( $cfg['typekit_fontreplacement']==0){ echo 'disabled="disabled"';}?>/>                          
								 </p>
								 <p class="ad_type_txt">
									<label for="ad_type_bold"> Bold Text</label>
									<input id="ad_type_bold" class="ad_type_bold" name="typekit_bold" type="text" value="<?php echo $cfg['typekit_bold']?>" <?php if( $cfg['typekit_fontreplacement']==false){ echo 'disabled="disabled"';}?>/>                          
								 </p>
								 <p class="ad_type_txt">
									<label for="ad_type_optional"> Optional Light</label>
									<input id="ad_type_optional" class="ad_type_optional" name="typekit_optional" type="text" value="<?php echo $cfg['typekit_optional']?>" <?php if( $cfg['typekit_fontreplacement']==false){ echo 'disabled="disabled"';}?>/>                          
								 </p>
							  </div>							  
						  </div><!--typekite_feilds-->
						  <div class="setting_btn"><input type="submit" name="typekit_action" id="typekit_action" value="Save"/> <div id="typekit_done" class="typekit_done"></div> </div>
						  </form>
					</div><!--ad_Typekit-->
					
					
				  </div><!--tabs1-typekit-->
				  
				   <div id="tabs1-shar" class="tab_content">
				    <!--sharing content -->
					<h2>Sharing - Email Service</h2>
					   <div class="ad_email_sharing">
					   <form id="ad_sharing_form" action="admin.php#tabs1-shar" method="post">
					       <div class="ad_shar_chk">
						  
						   <input id="ad_shr_chk" class="ad_shr_chk" value="1" name="sharing_enable" type="checkbox" <?php if( $cfg['sharing_enable']==true){ echo 'checked="checked"';}?>/>
                           <label for="ad_shr_chk"> Enable E-Mail Service</label>
					      </div>
						  
						  <div id="ad_shar_detail" class="ad_shar_detail">
							   <p>Main Settings</p>
							   <div class="ad_stng"> <span class="ad_txt">E-Mail</span>  <input type="text" name="sender_email" value="<?php echo $cfg['sender_email']?>" <?php if( $cfg['sharing_enable']==false){ echo 'disabled="disabled"';}?>/></div>
							   <div class="ad_stng"> <span class="ad_txt">Sender Name</span>  <input type="text" name="sender_name" value="<?php echo $cfg['sender_name']?>" <?php if( $cfg['sharing_enable']==false){ echo 'disabled="disabled"';}?>/> </div>
							   <div class="setting_btn"><input type="submit" name="share_action" value="Save"/> <div id="sharing_done" class="typekit_done"></div> </div>
					      </div>
						</form> 
						
					   </div>
					   
				  </div><!--tabs1-shar-->
				  
				  <div id="tabs1-settings" class="tab_content">
				  
				  <!--security-wrapper-->
				   <div class="color_wrapper security-wrapper">
					 <h1>Security</h1>
					 
					 <div class="main-color">
						<form id="ad_security_form" action="admin.php#tabs1-settings" method="post" novalidate="novalidate">
					       <div class="ad_shar_chk">						  
						    <input type="checkbox" id="ad_security_chk" class="ad_shr_chk" value="1" name="security_enable" <?php if(isset($cfg['security_enable'])&& $cfg['security_enable']==1){ echo 'checked="checked"';}?>/>
                            <label for="ad_security_chk"> Enable password protection</label>
					      </div>
						  
						  <div id="ad_security_detail" class="ad_security_detail">
							   <p>Main Settings</p>
							   <div class="ad_stng sec-fields">
  							     <span class="ad_txt">User name</span> 
								 <input type="text" id="sec_user" name="sec_user" maxlength="20" class="e_txt sec-user"  value="<?php if(isset($cfg['sec_user']) && $cfg['sec_user']!="") {echo $cfg['sec_user'];}else{}?>" <?php if(isset($cfg['security_enable'])&& $cfg['security_enable']==false){ echo 'disabled="disabled"';}?>/>
							   </div>
							   <div class="ad_stng sec-fields">
							      <span class="ad_txt">Password</span> 
							      <input type="password" id="sec_pwd" name="sec_pwd" maxlength="20" class="e_txt sec-pwd" value="" <?php if(isset($cfg['security_enable'])&& $cfg['security_enable']==false){ echo 'disabled="disabled"';}?>/>
							   </div>
							   <div class="setting_btn">
							    <input type="submit" id="security_action" name="security_action" value="Save" <?php if(isset($cfg['security_enable'])&& $cfg['security_enable']==false){ echo 'disabled="disabled"';}?>/> 
								<div id="security_done" class="security_done"></div>
							   </div>
					      </div>
						</form>
					 </div>
					 
					   <div class="background-color">					  
						<div class="ad_setting_fiels http_check ssl-top">
                           <p>Domain Configuration</p>						
							<form id="http_form" action="admin.php" method="post" >
							 <div class="ad_shar_chk_ssl">
							 
							   <input id="ad_http_chk" class="ad_typekit_chk ssl_verify" name="http_replacement" value="1" type="checkbox" <?php if( $cfg['temp2']==1){ echo 'checked="checked"';}?>/>
							   <label for="ad_http_chk"> Enable SSL (https)</label>
							   
							  
							  </div>
							  <div id="http_setting_done" class="setting_done"></div>
							</form>
						   
						</div> 
						
						
						
						<div class="ad_setting_fiels http_check">
                           					
							<form id="domain_form" action="admin.php" method="post" >
							 <div class="ad_shar_chk_ssl">
							   <input id="ad_domain_chk" class="ad_typekit_chk ssl_verify" name="domain_prefix" value="1" type="checkbox" <?php if( $cfg['temp3']==1){ echo 'checked="checked"';}?>/>
							   <label for="ad_domain_chk"> Enable www prefix with domain name </label>
							  </div>
							  
							  <div class="ad_shar_chk_ssl">
							   <p><span class="descrip_title"><b>Caution:</b></span> <span class="descrip"> Only enable the above options if your domain support ssl and www perfix. </span><span class="descrip_1">(Reinstall the setup or edit .htaccess, lib/config.local.php files if setup get crashed after enabling SSL or WWW prefix.)</span></p>
							   </div>
							  <div id="domain_setting_done" class="setting_done"></div>
							</form>
						   
						</div>
					 </div><!--background-color-->
					 
					 
					 
				   </div><!--security-wrapper-->
				   
				  
				  
				  
				      <!--settings content -->
			 <div class="color_wrapper">
				<div class="inner_wrapper_full">
				   <h1>General</h1>
					 <div class="main-color">
						   <div class="ad_setting_fiels">
							   <form id="ad_settings_form" action="admin.php#tabs1-settings" method="post">
								  
								  <div id="ad_settings_detail" class="ad_shar_detail">
									   <p>Upload Files Limit</p>							   
									   <div class="ad_sttng"> <span class="ad_txt">Files limit</span>  <input type="number" name="file_limit" value="<?php if( isset($cfg['temp1']) &&  $cfg['temp1'] !=""){ echo $cfg['temp1'];}?>"/> </div>
									   <div class="settings_btn"><input type="submit" name="setting_action" value="Save"/> <div id="setting_done" class="setting_done"></div> </div>
								  </div>
								</form> 
							
						   </div>
					 </div>
					 
					 
					 
					 <div class="background-color downLoadOpt">
					 
						    <p>Download options</p>
							<div class="m_color_row downLoadOpt_inner">
							<span class="zipUnzipContainer">
				      
							  <input class="adminDownloadMode" type="radio" name="allow_downloadMode" id="plainFiles" value="plain" <?php if(isset($cfg['allow_downloadMode'])&& $cfg['allow_downloadMode']=="plain"){ echo 'checked="checked"';}?>/>
							  <label for="plainFiles">Plain download</label>
										  
							   <input class="adminDownloadMode" type="radio" name="allow_downloadMode" id="zipFiles" value="zip"  <?php if(isset($cfg['allow_downloadMode'])&& $cfg['allow_downloadMode']=="zip"){ echo 'checked="checked"';}?>/>
							   <label for="zipFiles">Zip download</label>

                                <input class="adminDownloadMode" type="radio" name="allow_downloadMode" id="zipAndPlain" value="zipAndPlain"  <?php if(isset($cfg['allow_downloadMode'])&& $cfg['allow_downloadMode']=="zipAndPlain"){ echo 'checked="checked"';}?> />
							    <label for="zipAndPlain">Both (Zip and plain download)</label>							   
							</span>
							    
							 </div>
							 <div id="adminDownloadMode_done" class="setting_done"></div> 
					  </div>
				</div>					
				
				
				
				<!-- Re zipped and show hide link-->
				<div class="inner_wrapper_full">
					<div class="main-color">
						<div class="background-color rezipped">					 
						<p>Show download link</p>
						<div class="m_color_row re_zipped_inner">
							<span class="zipUnzipContainer">				  
							  <input class="download_link_ctrl" type="radio" name="download_link_ctrl" id="dnld_y" value="1" <?php if(isset($cfg['show_download_link'])&& $cfg['show_download_link']==true){ echo 'checked="checked"';}?>/>
							  <label for="dnld_y">Yes</label>
										  
							   <input class="download_link_ctrl" type="radio" name="download_link_ctrl" id="dnld_n" value="0"  <?php if(isset($cfg['show_download_link'])&& $cfg['show_download_link']==false){ echo 'checked="checked"';}?>/>
							   <label for="dnld_n">No</label>													   
							</span>
							
						 </div>
						 <div id="download_link_done" class="setting_done"></div> 
					 </div>		
					 </div><!--main-color-->
					 
					<div class="background-color rezipped">					 
						<p></p>
						<div class="m_color_row re_zipped_inner zip_ctrl">
							<!--span class="zipUnzipContainer">				  
							  <input class="re_zipped_ctrl" type="radio" name="re_zipped_ctrl" id="re_zipp_y" value="1" <?php if(isset($cfg['re_zipped'])&& $cfg['re_zipped']==true){ echo 'checked="checked"';}?>/>
							  <label for="re_zipp_y">Yes</label>
										  
							   <input class="re_zipped_ctrl" type="radio" name="re_zipped_ctrl" id="re_zipp_n" value="0"  <?php if(isset($cfg['re_zipped'])&& $cfg['re_zipped']==false){ echo 'checked="checked"';}?>/>
							   <label for="re_zipp_n">No</label>													   
							</span-->
							<input id="re_zipped_chk" class="ad_typekit_chk re_zipped_ctrl" name="re_zipped_ctrl" value="1" type="checkbox" <?php if( $cfg['re_zipped']==false){ echo 'checked="checked"';}?>/>
                            <label for="re_zipped_chk"> Don’t zip already zipped files</label>
							
						 </div>
						 <div id="admin_rezipped_done" class="setting_done"></div> 
					 </div>		
				</div><!--inner_wrapper_full-->
				<div class="spacer_top_bottom"></div>
			</div> <!-- color_wrapper-->	

				     <!--settings content -->
				 <div class="color_wrapper">
				   <h1>SMTP</h1>
					 <div class="main-color">
						   <div class="ad_setting_fiels">
							   <form id="ad_smtp_settings_form" action="admin.php#tabs1-settings" method="post">
								  <?php echo getFormToken();?>
								  <div id="ad_settings_detail" class="ad_shar_detail">
									   <p>Server Settings</p>							   
									   <div class="ad_sttng"> <span class="ad_txt">SMTP Host</span>  <input type="text" name="smtp_host" value="<?php if( isset($cfg['smtp_host']) &&  $cfg['smtp_host'] !=""){ echo $cfg['smtp_host'];}?>"/> </div>


									   <div class="ad_sttng"> <span class="ad_txt">SMTP Username</span>  <input type="text" name="smtp_user" value="<?php if( isset($cfg['smtp_user']) &&  $cfg['smtp_user'] !=""){ echo $cfg['smtp_user'];}?>"/> </div>

									   <div class="ad_sttng"> <span class="ad_txt">SMTP Password</span>  <input type="password" name="smtp_pass" value=""/> </div>

									   <div class="ad_sttng"> <span class="ad_txt">SMTP Port</span>  <input type="number" name="smtp_port" value="<?php if( isset($cfg['smtp_port']) &&  $cfg['smtp_port'] !=""){ echo $cfg['smtp_port'];}?>"/> </div>

									   <div class="ad_sttng"> <span class="ad_txt">SMTP Auth</span>  <input id="ad_smtp_auth_chk" class="ad_smtp_auth_chk" name="smtp_auth" value="1" type="checkbox" <?php if( $cfg['smtp_auth']==1){ echo 'checked="checked"';}?>/> </div>

									   <div class="ad_sttng"> <span class="ad_txt">SMTP use TLS</span>  <input id="ad_smtp_tls_chk" class="ad_smtp_tls_chk" name="smtp_tls" value="1" type="checkbox" <?php if( $cfg['smtp_tls']==1){ echo 'checked="checked"';}?>/> </div>

									   <div class="settings_btn"><input type="submit" name="smtp_action" value="Save"/> <div id="smtp_settings_done" class="setting_done"></div> </div>
								  </div>
								</form> 
							
						   </div>
					 </div>	 
                   
				</div> <!-- color_wrapper-->
					   
					   
				  </div><!--tabs1-Settings-->
				  
				  
       </div>
    
		
		<?php
		
//}


/* Check for actions */
if (isset ($_POST['actionu']))
{
	
	
    if (strcmp ($_POST['action'], 'clean') == 0)
    {
        $total = jirafeau_admin_clean ();
        echo '<div class="message">' . NL;
        echo '<p>';
        echo t('Number of cleaned files') . ' : ' . $total;
        echo '</p></div>';
    }
    elseif (strcmp ($_POST['action'], 'clean_async') == 0)
    {
        $total = jirafeau_admin_clean_async ();
        echo '<div class="message">' . NL;
        echo '<p>';
        echo t('Number of cleaned files') . ' : ' . $total;
        echo '</p></div>';
    }
    elseif (strcmp ($_POST['action'], 'list') == 0)
    {
		
        jirafeau_admin_list ("", "", "");
    }
	elseif (strcmp ($_POST['action_bottom'], 'list') == 0)
    {
		
        jirafeau_admin_list ("", "", "");
    }
    elseif (strcmp ($_POST['action'], 'search_by_name') == 0)
    {
        jirafeau_admin_list ($_POST['name'], "", "");
    }
    elseif (strcmp ($_POST['action'], 'search_by_file_hash') == 0)
    {
        jirafeau_admin_list ("", $_POST['hash'], "");
    }
    elseif (strcmp ($_POST['action'], 'search_link') == 0)
    {
        jirafeau_admin_list ("", "", $_POST['link']);
    }
    elseif (strcmp ($_POST['action'], 'delete_link') == 0)
    {
        jirafeau_delete_link ($_POST['link']);
        echo '<div class="message">' . NL;
        echo '<p>' . t('Link deleted') . '</p></div>';
    }
    elseif (strcmp ($_POST['action'], 'delete_file') == 0)
    {
        $count = jirafeau_delete_file ($_POST['md5']);
        echo '<div class="message">' . NL;
        echo '<p>' . t('Deleted links') . ' : ' . $count . '</p></div>';
    }
    elseif (strcmp ($_POST['action'], 'download') == 0)
    {
        $l = jirafeau_get_link ($_POST['link']);
        if (!count ($l))
            return;
        $p = s2p ($l['md5']);
        header ('Content-Length: ' . $l['file_size']);
        header ('Content-Type: ' . $l['mime_type']);
        header ('Content-Disposition: attachment; filename="' .
                $l['file_name'] . '"');
        if (file_exists(VAR_FILES . $p . $l['md5']))
            readfile (VAR_FILES . $p . $l['md5']);
        exit;
    }
	
}

require (JIRAFEAU_ROOT.'lib/template/footer_admin.php');
}
?>
