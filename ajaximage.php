<?php

@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

$path = "uploads/";

	$valid_formats = array("jpg", "png");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				 {
					list($width, $height, $type, $attr) = getimagesize($_FILES["photoimg"]['tmp_name']);
					  					  
					  if($width <191 && $height <91)
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{ 							    
								 $cfg['logo'] = $cfg['web_root'].'uploads/'.$actual_image_name;
								 jirafeau_export_cfg_custom($cfg);									 
								 echo "<img src='uploads/".$actual_image_name."'  class='preview'/>";
								}
							else
								echo '<div class="img_error">Upload failed!</div>';
						}
				        else
				        echo '<div class="img_error">Image file max size 190x90px</div>';			
				}
				else
				echo '<div class="img_error">Upload only JPG or PNG</div>';		
				
				
			exit;
		}
?>