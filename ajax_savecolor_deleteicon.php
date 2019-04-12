<?php

@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');



if(isset($_POST['ids']) && $_POST['ids']=='delete_logo'){   //Delete logo from admin side
	$cfg['logo'] = "";
	jirafeau_export_cfg_custom($cfg);
    echo "delete_logo";	
}
elseif(isset($_POST['ids']) && $_POST['ids']=='delete_retina'){  //Delete logo retina from admin side
	$cfg['logo_resolation'] = "";
	jirafeau_export_cfg_custom($cfg);
	echo "delete_retina";
}
elseif(isset($_POST['ids']) && $_POST['ids']=='delete_favicon'){  //Delete favicon from admin side
	$cfg['favicon'] = "";
	jirafeau_export_cfg_custom($cfg);
	echo "delete_favicon";
}
elseif(isset($_POST['ids']) && $_POST['ids']=='delete_touchicon'){  //Delete touchicon from admin side
	$cfg['touchicon'] = "";
	jirafeau_export_cfg_custom($cfg);
	echo "delete_touchicon";
}

elseif(isset($_POST['color_action']) && $_POST['color_action']=='Save'){  //Design tab(update main color and background color) 
	
	if(!empty($_POST['main_color'])){
	    $cfg['main_color'] = $_POST['main_color'];
	   }
	    if(!empty($_POST['main_color_light'])){	   
         $cfg['main_color_light'] =  $_POST['main_color_light'];
        }
		
		if(!empty($_POST['bg_gradient_color1'])){
	    $cfg['bg_gradient_color1'] = $_POST['bg_gradient_color1'];
	   }
	    if(!empty($_POST['bg_gradient_color2'])){	   
         $cfg['bg_gradient_color2'] =  $_POST['bg_gradient_color2'];
        }
		
	  jirafeau_export_cfg_custom($cfg);
	  //echo "savedone";
	  echo $cfg['web_root'];
	  
}
elseif(isset($_POST['ad_typekit_chk']) && $_POST['ad_typekit_chk'] !=""){  //Enable disable Typekit fontreplacement  
	 $cfg['typekit_fontreplacement'] =  $_POST['ad_typekit_chk'];
	  jirafeau_export_cfg_custom($cfg);
	  //echo "typekit dd";
	  echo s42_remove_ending_slash($cfg['web_root']);
		
}
elseif(isset($_POST['typekit_action']) && $_POST['typekit_action'] !=""){ //TypeKit update 
	
		
	   if(!empty($_POST['typekit_code'])){
		   
		  $typekit_code =  $_POST['typekit_code'];
		  $typekit_code = str_replace("sf_@_#","<script",$typekit_code);
		  $typekit_code = str_replace("ss_@_#","</script>",$typekit_code);
		  $typekit_code = str_replace("st_@_#","<script>",$typekit_code);
		  $typekit_code = str_replace("ss_@_#","</script>",$typekit_code);
		   /*
		   var str = $('#typekiteCode').val().replace('<script','sf_@_#');
				str = str.replace('</script>','ss_@_#');
				str = str.replace('<script>','st_@_#');
				str = str.replace('</script>','ss_@_#');
				*/
	    $cfg['typekit_code'] = $typekit_code;
	   }
	   if(!empty($_POST['typekit_normal'])){	   
         $cfg['typekit_normal'] =  $_POST['typekit_normal'];
        }
		
		if(!empty($_POST['typekit_bold'])){	   
         $cfg['typekit_bold'] =  $_POST['typekit_bold'];
        }
		if(!empty($_POST['typekit_optional'])){	   
         $cfg['typekit_optional'] =  $_POST['typekit_optional'];
        }
	 jirafeau_export_cfg_custom($cfg);
	 echo "typekit_done";
	 
}
elseif(isset($_POST['ad_shr_chkVal']) && $_POST['ad_shr_chkVal'] !=""){  //Enable disable Sharing Email service 
	 $cfg['sharing_enable'] =  $_POST['ad_shr_chkVal'];
	  jirafeau_export_cfg_custom($cfg);
	  echo "sharing";
		
}
elseif(isset($_POST['share_action']) && $_POST['share_action'] !=""){ //Sharing Email service data update
	
		
	   if(!empty($_POST['sender_email'])){
	    $cfg['sender_email'] = $_POST['sender_email'];
	   }
		if(!empty($_POST['sender_name'])){	   
         $cfg['sender_name'] =  $_POST['sender_name'];
        }
	 jirafeau_export_cfg_custom($cfg);
	  echo "sharing_done";
}
elseif(isset($_POST['setting_action']) && $_POST['setting_action'] !=""){ // Files limit into config files

	   if(!empty($_POST['file_limit'])){
	    $cfg['temp1'] = $_POST['file_limit'];
	   }		
	   jirafeau_export_cfg_custom($cfg);
	   echo "setting_done";
}
elseif(isset($_POST['ad_http_chkVal']) && $_POST['ad_http_chkVal'] !=""){ // Enable disable https and www prefix
	   
	    $cfg['temp2'] = $_POST['ad_http_chkVal'];
	    $cfg['temp3'] = $_POST['ad_domain_chkval'];
		
		if($_POST['ad_http_chkVal'] == 1 && $_POST['ad_domain_chkval'] ==1 ){
			//echo both 1
			
			$parsedUrl = parse_url($cfg['web_root']);
			//parse_str($parsedUrl['query'], $parsedQuery);
			if(!empty($parsedUrl['path'])){				
				$url = 'https://www.'.str_replace('www.','',$_SERVER['HTTP_HOST']).$parsedUrl['path'];
			}else{
				$url = 'https://www.'.str_replace('www.','',$_SERVER['HTTP_HOST']).'/';
			}
			
			$content = '<IfModule mod_rewrite.c>
            		  RewriteEngine on
					  ErrorDocument 404 '.$cfg['web_root'].'404.php
						  # Set "protossl" to "s" if we were accessed via https://.  This is used later
						  # if you enable "www." stripping or enforcement, in order to ensure that
						  # you don\'t bounce between http and https.
						  
						  #RewriteCond %{HTTPS} on
                          #RewriteRule (.*) http://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
						  
						  RewriteCond %{HTTPS} off
                          RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
						  
						  
						  RewriteRule ^ - [E=protossl]
						  RewriteCond %{HTTPS} on
						  RewriteRule ^ - [E=protossl:s]
						# To redirect all users to access the site WITH the \'www.\' prefix,
						  # (http://example.com/... will be redirected to http://www.example.com/...)
						  # uncomment the following:
						   RewriteCond %{HTTP_HOST} .
						   RewriteCond %{HTTP_HOST} !^www\. [NC]
						   RewriteRule ^ http%{ENV:protossl}://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
						  #
						  # To redirect all users to access the site WITHOUT the \'www.\' prefix,
						  # (http://www.example.com/... will be redirected to http://example.com/...)
						  # uncomment the following:
						  # RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
						  # RewriteRule ^ http%{ENV:protossl}://%1%{REQUEST_URI} [L,R=301]
						 </IfModule>
                      ';
			
			
			
			
			
		}
		elseif($_POST['ad_http_chkVal'] == 1 && $_POST['ad_domain_chkval'] ==0 ){
			//echo "http 1 and domain 0";
			
			$parsedUrl = parse_url($cfg['web_root']);
			//parse_str($parsedUrl['query'], $parsedQuery);
			$host = str_replace('www.', '',$_SERVER['HTTP_HOST'] );
			if(!empty($parsedUrl['path'])){				
				$url = 'https://'.$host.$parsedUrl['path'];
			}else{
				$url = 'https://'.$host.'/';
			}
			
			
		  $content = '<IfModule mod_rewrite.c>
            		  RewriteEngine on
					  ErrorDocument 404 '.$cfg['web_root'].'404.php
						  # Set "protossl" to "s" if we were accessed via https://.  This is used later
						  # if you enable "www." stripping or enforcement, in order to ensure that
						  # you don\'t bounce between http and https.
						  
						  #RewriteCond %{HTTPS} on
                          #RewriteRule (.*) http://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
						  
						  RewriteCond %{HTTPS} off
                          RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
						  
						  
						  RewriteRule ^ - [E=protossl]
						  RewriteCond %{HTTPS} on
						  RewriteRule ^ - [E=protossl:s]
						# To redirect all users to access the site WITH the \'www.\' prefix,
						  # (http://example.com/... will be redirected to http://www.example.com/...)
						  # uncomment the following:
						  # RewriteCond %{HTTP_HOST} .
						  # RewriteCond %{HTTP_HOST} !^www\. [NC]
						  # RewriteRule ^ http%{ENV:protossl}://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
						  #
						  # To redirect all users to access the site WITHOUT the \'www.\' prefix,
						  # (http://www.example.com/... will be redirected to http://example.com/...)
						  # uncomment the following:
						  RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
						  RewriteRule ^ http%{ENV:protossl}://%1%{REQUEST_URI} [L,R=301]
						 </IfModule>
                      ';
			
		}
		elseif($_POST['ad_http_chkVal'] == 0 && $_POST['ad_domain_chkval'] ==1 ){
			//echo "http 0 and domain 1";
			
			
			
			$parsedUrl = parse_url($cfg['web_root']);
			//parse_str($parsedUrl['query'], $parsedQuery);
			$host = str_replace('www.', '',$_SERVER['HTTP_HOST'] );		
			if(!empty($parsedUrl['path'])){
				
				$url = 'http://www.'.$host.$parsedUrl['path'];
			}else{
				$url = 'http://www.'.$host.'/';
			}
			$content = '<IfModule mod_rewrite.c>
            		  RewriteEngine on
					  ErrorDocument 404 '.$cfg['web_root'].'404.php
						  # Set "protossl" to "s" if we were accessed via https://.  This is used later
						  # if you enable "www." stripping or enforcement, in order to ensure that
						  # you don\'t bounce between http and https.
						  RewriteCond %{HTTPS} on
                          RewriteRule (.*) http://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
						  
						  #RewriteCond %{HTTPS} off
                          #RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
						  
						  RewriteRule ^ - [E=protossl]
						  RewriteCond %{HTTPS} on
						  RewriteRule ^ - [E=protossl:s]
						# To redirect all users to access the site WITH the \'www.\' prefix,
						  # (http://example.com/... will be redirected to http://www.example.com/...)
						  # uncomment the following:
						   RewriteCond %{HTTP_HOST} .
						   RewriteCond %{HTTP_HOST} !^www\. [NC]
						   RewriteRule ^ http%{ENV:protossl}://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
						  #
						  # To redirect all users to access the site WITHOUT the \'www.\' prefix,
						  # (http://www.example.com/... will be redirected to http://example.com/...)
						  # uncomment the following:
						  # RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
						  # RewriteRule ^ http%{ENV:protossl}://%1%{REQUEST_URI} [L,R=301]
						 </IfModule>
                      ';
		}
		elseif($_POST['ad_http_chkVal'] == 0 && $_POST['ad_domain_chkval'] ==0 ){
			//echo "http 0 and domain 0";
			
			$parsedUrl = parse_url($cfg['web_root']);
			//parse_str($parsedUrl['query'], $parsedQuery);
			$host = str_replace('www.', '',$_SERVER['HTTP_HOST'] );
			if(!empty($parsedUrl['path'])){				
				$url = 'http://'.$host.$parsedUrl['path'];
			}else{
				$url = 'http://'.$host.'/';
			}
			$url = str_replace('www.', '', $url );
			
			/*$url = $cfg['web_root']; // example http url ##
			$url = str_replace('https://', 'http://', $url );
			
			$url = str_replace('https://www.', 'http://', $url );
			$url = str_replace('http://www.', 'http://', $url );
			*/
			
			
		  $content = '<IfModule mod_rewrite.c>
            		  RewriteEngine on
					  ErrorDocument 404 '.$cfg['web_root'].'404.php
						  # Set "protossl" to "s" if we were accessed via https://.  This is used later
						  # if you enable "www." stripping or enforcement, in order to ensure that
						  # you don\'t bounce between http and https.
						  RewriteCond %{HTTPS} on
                          RewriteRule (.*) http://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
						  
						  #RewriteCond %{HTTPS} off
                          #RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R,L]
						  
						  RewriteRule ^ - [E=protossl]
						  RewriteCond %{HTTPS} on
						  RewriteRule ^ - [E=protossl:s]
						# To redirect all users to access the site WITH the \'www.\' prefix,
						  # (http://example.com/... will be redirected to http://www.example.com/...)
						  # uncomment the following:
						  # RewriteCond %{HTTP_HOST} .
						  # RewriteCond %{HTTP_HOST} !^www\. [NC]
						  # RewriteRule ^ http%{ENV:protossl}://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
						  #
						  # To redirect all users to access the site WITHOUT the \'www.\' prefix,
						  # (http://www.example.com/... will be redirected to http://example.com/...)
						  # uncomment the following:
						   RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
						   RewriteRule ^ http%{ENV:protossl}://%1%{REQUEST_URI} [L,R=301]
						 </IfModule>
                      ';
			
			
			
			
		}else{
			$url = $cfg['web_root'];
			$content ="";
			
		}
		
		
		
	   $cfg['web_root'] = $url;	 
	   
	   /****Update image url***/	   
	    $web_rootUrl = s42_remove_ending_slash($cfg['web_root']);
		
	   //logo
	    $iconPathlogo = (parse_url($cfg['logo'], PHP_URL_PATH));
	    $cfg['logo'] = $web_rootUrl.$iconPathlogo;
		
	    //logo_resolation  		
		$iconPathlogo_resolation = (parse_url($cfg['logo_resolation'], PHP_URL_PATH));		
	    $cfg['logo_resolation'] = $web_rootUrl.$iconPathlogo_resolation;
			
			
		//favicon  		
		//$iconPathfavicon = (parse_url($cfg['favicon'], PHP_URL_PATH));		
	    //$cfg['favicon'] = $web_rootUrl.$iconPathfavicon;	
		
       //touchicon  		
		$iconPathtouchicon = (parse_url($cfg['touchicon'], PHP_URL_PATH));		
	    $cfg['touchicon'] = $web_rootUrl.$iconPathtouchicon;
			
	   /****Update image url***/
	   
	   
	   jirafeau_export_cfg_custom($cfg);
	   
	   
	    $f = fopen(".htaccess", "r+");		
		// Truncate .htaccess to be sure it's empty
		ftruncate($f, 0);
		fwrite($f, $content);
		fclose($f);
	   
	  echo $url;//$cfg['web_root']; //Return via ajax
	  
	
}
elseif(isset($_POST['ad_security_chkVal']) && $_POST['ad_security_chkVal'] !=""){  //Security password disable,enable service 
	 $cfg['security_enable'] =  $_POST['ad_security_chkVal'];
	  jirafeau_export_cfg_custom($cfg);
	  echo "security";
		
}
elseif(isset($_POST['security_action']) && $_POST['security_action'] !=""){ //Security user password data update
 $arr = array();
 
	   if(!empty($_POST['sec_user'])){
	    $cfg['sec_user'] = $_POST['sec_user'];
		$arr['sec_user'] = $_POST['sec_user']; //return
	   }
		if(!empty($_POST['sec_pwd'])){	   
         $cfg['sec_pwd'] = md5($_POST['sec_pwd']);
		 $arr['sec_pwd'] =  $_POST['sec_pwd']; //return
        }
	 jirafeau_export_cfg_custom($cfg);

		echo json_encode($arr);
}

?>