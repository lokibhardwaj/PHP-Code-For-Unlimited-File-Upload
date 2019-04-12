<?php

@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

/*
Change favicon from admin
*/
$path = "uploads/";

	$valid_formats = array("icon", "Icon","ico");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg_favicon']['name'];
			$size = $_FILES['photoimg_favicon']['size'];
			
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				 {
					list($width, $height, $type, $attr) = getimagesize($_FILES["photoimg_favicon"]['tmp_name']);
					  					  
					  if($width <65 && $height <65)
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg_favicon']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{ 							    
								 $cfg['favicon'] = $cfg['web_root'].'uploads/'.$actual_image_name;
								 jirafeau_export_cfg_custom($cfg);									 
								 echo "<img src='uploads/".$actual_image_name."'  class='preview_favicon'/>";
								}
							else
								echo '<div class="img_error">Upload failed!</div>';
						}
				        else
				        echo '<div class="img_error">Upload favicon (recommended size: 64x64px, allowed file extension: .ico)</div>';					
				}
				else
				echo '<div class="img_error">Upload favicon (recommended size: 64x64px, allowed file extension: .ico)</div>';	
				
				
			exit;
		}
?>