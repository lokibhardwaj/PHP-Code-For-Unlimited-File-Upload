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

require (JIRAFEAU_ROOT . 'lib/lang.php');
require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');

/* 
 Get parameter from mail url and force download files
*/
if (isset ($_GET['mail']) && $_GET['mail']==1)
{
	if(isset($_GET['h']) && !empty($_GET['h'])){
	  //echo "<pre>";
      //print_r($cfg['generate_number']);    
	 
	  $file_code = $cfg['generate_number'][$_GET['h']];
	  if(!empty($file_code)){
		  $_POST['h'] = $file_code;
		  $_POST['d'] = 1;
	  }else{
		 header ('Location: ' . $cfg['web_root']);
        exit;
	  }
	 
	}
	else{
		header ('Location: ' . $cfg['web_root']);
       exit;
	}
}


/* 
 Get parameter from mail url and delete files
*/
if (isset ($_GET['del']) && $_GET['del']==1)
{
	if(isset($_GET['h']) && !empty($_GET['h'])){
	  //echo "<pre>";
      //print_r($cfg['generate_number']);    
	 
	  $file_code = $cfg['generate_number'][$_GET['h']];
	  if(!empty($file_code)){
		  $_POST['h'] = $file_code;
		  $_POST['del'] = 1;
	  }else{
		 header ('Location: ' . $cfg['web_root']);
        exit;
	  }
	 
	}
	else{
		header ('Location: ' . $cfg['web_root']);
       exit;
	}
}
//Plain download from email
if (isset ($_GET['plain']) &&  $_GET['plain'] ==1)
{

	 if(isset($_GET['h']) && !empty($_GET['h'])){
		  $_POST['h'] = $_GET['h'];
		  $_POST['d'] = 1;
	 }else{
       header('Location: ' . $cfg['web_root']);
	   exit;
	 }
    
}
if (isset ($_GET['singleZip']) &&  $_GET['singleZip'] ==1)
{
	/*
	 if(isset($_GET['h']) && !empty($_GET['h'])){
		  $_POST['h'] = $_GET['h'];
		  $_POST['d'] = 1;
	 }else{
       header('Location: ' . $cfg['web_root']);
	   exit;
	 }
    */
}




if (!isset ($_POST['h']) || empty ($_POST['h']))
{
    header ('Location: ' . $cfg['web_root']);
    exit;
}





/* Operations may take a long time.
 * Be sure PHP's safe mode is off.
 */
@set_time_limit(0);
/* Remove errors. */
@error_reporting(0);


$link_name1 = $_POST['h'];
$link_nameArr = explode('@',$link_name1);
$link_name = $link_nameArr[0];

if (!preg_match ('/[0-9a-zA-Z_-]+$/', $link_name))
{
    require (JIRAFEAU_ROOT.'lib/template/header.php');
   	
	echo t('<div class="error">	
		<fieldset id="" class="file_not_found"><legend>  </legend>
		      <div class="error_conttent">
			 <span class="exp_img"></span>
             <p class="access_error">Link expired!</p>
		     <p class="link-expire">Sorry, the requested file is not found</p> </div>
          </fieldset></div>');
	 
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}

$link = jirafeau_get_link ($link_name);
if (count ($link) == 0)
{
    /* Try alias. */
    $alias = jirafeau_get_alias (md5 ($link_name));
    if (count ($alias) > 0)
        $link = jirafeau_get_link ($alias["destination"]);
}
if (count ($link) == 0)
{
    require (JIRAFEAU_ROOT.'lib/template/header.php');    
	 echo t('<div class="error">	
		<fieldset id="" class="file_not_found"><legend>  </legend>
		      <div class="error_conttent">
			  <span class="exp_img"></span>
             <p class="access_error">Link expired!</p>
		     <p class="link-expire">Sorry, the requested file is not found</p> </div>
         </fieldset></div>');
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}

$delete_code = '';
if (isset ($_POST['d']) && !empty ($_POST['d']) &&  $_POST['d'] != '1')
    $delete_code = $_POST['d'];

$crypt_key = '';
if (isset ($_GET['k']) && !empty ($_GET['k']))
    $crypt_key = $_GET['k'];

$do_download = false;
if (isset ($_POST['d']) && $_POST['d'] == '1')
    $do_download = true;

$do_preview = false;
if (isset ($_POST['p']) && !empty ($_POST['p']))
    $do_preview = true;

$p = s2p ($link['md5']);
if (!file_exists (VAR_FILES . $p . $link['md5']))
{
    jirafeau_delete_link ($link_name);
    require (JIRAFEAU_ROOT.'lib/template/header.php');
    
	
	echo t('<div class="error">	
		<fieldset id="" class="file_not_found"><legend>  </legend>
		      <div class="error_conttent">
		     <p class="access_error">Sorry, the requested file is not found</p> </div>
         </fieldset></div>');
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}


/**
Delete fiels after share by SENDER from their EMAIL
*/
if (isset($_POST['del']) && $_POST['del']==1)
{
	$delete_code = $_POST['h'];
	$delete_codeArr = explode('@',$delete_code);
	foreach($delete_codeArr as $dlt){
		$link_name = $dlt;
        jirafeau_delete_link ($link_name);
	}  
	 require (JIRAFEAU_ROOT.'lib/template/header.php');
    //echo t('File(s) has been deleted.ssss'); 
	?>
	<script type="text/javascript">

		(function () {
			var timeLeft = 3,
				cinterval;

			var timeDec = function (){
				timeLeft--;
				document.getElementById('lblCount').innerHTML = timeLeft;
				if(timeLeft === 0){
					window.location = "<?php echo $cfg['web_root'];?>";
				}
			};

			cinterval = setInterval(timeDec, 1000);
		})();

</script>
	<!--DELET FILES done-->	   
	<div id="del_done" class="upload_done" style="display:block;">
		<div  class="upload_done_download_page">
			<span class="done_del_image"></span>
			<span class="done_txt">File(s) deleted.</span>
			<div id="dvCountDown_done_del" class="dvCountDown_done" >
			   <span class="del_set">You will be redirected after <span id = "lblCount"></span> seconds.</span> <span class="del_set_1">if not click <a  href="<?php if(isset($cfg['web_root'])){ echo $cfg['web_root']; }?>" class="if_not_redirect_after_delete">here</a></span>
			</div>
		</div>	
	</div>
<?php	
    
	 require (JIRAFEAU_ROOT.'lib/template/footer.php');
	 exit;
}

/**
Delete fiels after upload
*/
if (!empty ($delete_code))
{
	$delete_code = $_POST['h'];
	$delete_codeArr = explode('@',$delete_code);
	foreach($delete_codeArr as $dlt){
		$link_name = $dlt;
        jirafeau_delete_link ($link_name);
	}  
    echo t('File(s) has been deleted.');   
    exit;
}


//Link Expired
if ($link['time'] != JIRAFEAU_INFINITY && time () > $link['time'])
{
    jirafeau_delete_link ($link_name);
    require (JIRAFEAU_ROOT.'lib/template/header.php');
    echo '<div class="error">	
		<fieldset id="" class="link-expired"><legend>  </legend>
		  <div class="error_content">
		   <span class="exp_img"></span>
		   <p class="access_error">'.t('Link expired!').'</p>
		   <p class="link-expire">'.t('Your link has been expired since').'</p>';
		   $date = new DateTime();
			 $date->setTimestamp($link['time']);		
			echo  t('<p class="link-expire2">'.$date->format('D M d  Y ').'</p> </div>');
		 echo t('</fieldset></div>');	
	
    require (JIRAFEAU_ROOT . 'lib/template/footer.php');
    exit;
}


if (empty ($crypt_key) && $link['crypted'])
{
    require (JIRAFEAU_ROOT.'lib/template/header.php');   
	
	echo '<div class="error">	
		<fieldset id="" class="file_not_found"><legend>  </legend>
		      <div class="error_conttent">
		     <p class="access_error">'.t('Sorry, the requested file is not found').'</p> </div>
     </fieldset></div>';
	 
    require (JIRAFEAU_ROOT.'lib/template/footer.php');
    exit;
}


//download_page pass protected fiels
$password_challenged = false;
if (!empty ($link['key']))
{
    if (!isset ($_POST['key']))
    {
        require (JIRAFEAU_ROOT.'lib/template/header.php');
        echo '<div class="download_page">' .
             '<form action = "';
        echo $cfg['web_root'] . '/f.php';
        echo '" ' .
             'method = "post" id = "submit_post">'; ?>
             <input type = "hidden" name = "jirafeau" value = "<?php echo JIRAFEAU_VERSION ?>"/><?php
			 if(!isset($_POST['clipBoardUrl'])){
				if(isset($_GET['h']) && $_GET['h'] !=""){
				 $_POST['clipBoardUrl'] =  $cfg['web_root'].'f.php?h='.$_GET['h'];
			    } elseif(isset($_POST['h']) && $_POST['h'] !="") {
			     $_POST['clipBoardUrl'] =  $cfg['web_root'].'f.php?h='.$_POST['h'];					 
				}else{
					 $_POST['clipBoardUrl'] =  "";
				}
			 }
			 
			  //Zip and plain download
			if($cfg['downloadMode'] =="zipFiles"){
			 echo '<textarea  id="clip-board" class="clip-board-txt-dn-page" name="" readonly="readonly" style="left:-2000px;position:absolute;" >'.$_POST['clipBoardUrl'].'&amp;mail=1</textarea>';
			}

        echo '<fieldset>' .
             '<legend>' . t('Password protection') .
             '</legend><div class="dwn-file-list">';
		
		  echo  '<p class="download-title">  Download </p>';
            echo '<div class="file_list_wrapper">';
			 $zipEstimate = "";
			 $files_counter= 0;
			foreach($link_nameArr as $links_dn){
				$link_dn = jirafeau_get_link ($links_dn);
				if (!empty($link_dn)) {
					$zipEstimate +=  $link_dn['file_size'];
				
					echo '<div class="fileList pwd_list">';				 
					echo  '<span class="f_name">'.$link_dn['file_name'].'</span> <span class="download-icon">   <a class="dn-icon-pwd" id="'.$links_dn.'" href="javascript:void(0);"> </a> </span>   ';
					echo  '<span class="f_size">'.formatSizeUnits($link_dn['file_size']).' </span>'; 
					//echo  '<span class="download-icon"><a class="dn-icon" href="'.$cfg['web_root'] . '/f.php?h='.$links_dn.'&amp;d=1"><img src="'.$cfg['web_root'].'media/'.$cfg['style'].'/download.svg"/></a></span>'; 
				 if(isset($_POST['clipBoardUrl'])){
					  //Zip and plain download
					if($cfg['downloadMode'] =="zipFiles"){
							 
						 echo '<div class="clipBoardUrl_list">				 
							   <textarea  id="clip-board" class="clip-board-txt-dn-page" name="" readonly="readonly">'.$_POST['clipBoardUrl'].'&amp;mail=1 </textarea>
							<span class="download-icon clip-icon"><a  href="javascript:void(0);" class="copyButton1 download-icon" id="copyButton1" data-clipboard-target="#clip-board" >'.t('').'</a>
							<span class="text-copied" style="display:none;">Copied!</span>
							</span>
							</div>';
					}
				 }
				 
				 
				 echo '</div>';
				 
				$files_counter++; 
				}
			}
			 
          echo '</div>';//file_list_wrapper
		  
		  
		  
		  echo '<div class="pwd-protection">'.
		       '<span class="pwd-fiels">Give the password of this file:</span>'.
			   '<input type = "password" name = "key" id="pwd-keys" placeholder="Password"/>'.
			   '<span id="pwd-keys-error" class="error"> </span>'.
			   '<input type = "hidden"  id="site-name" value="'.$cfg['web_root'].'/f.php"/>'.
		       '</div>';
			   
			  
				
				
			   
		  echo '<div class="dn_txt">Durch die Nutzung unsere Dienste, akzeptieren Sie unsere </div>';
		  echo '<div class="terms-And-Conditin"><a href="' . $cfg['web_root'] . '/tos.php' . '"><span class="terms-sv">Terms</span>/<span class="conditions-sv">Conditions</span></a> </div>';
		  
		  if ($link['onetime'] == 'O')
			{
				//echo '<div class="self_destruct">' .
                 //t('Warning, this file will self-destruct after being read') .
                 //'</div>';
			}

        ?>
		 <input type="hidden" name="h" value="<?php echo $_POST['h'];?>"/>	
		  <input type="hidden" name="d" value="1"/>
		
		 <?php
	     //Zip and plain download
	   if($cfg['downloadMode'] =="zipFiles"){ ?>
		<div class="dn_submit ff"><input type="submit" id = "submit_download"  value="<?php echo t('Download all'); ?>"
        onclick="document.getElementById('submit_post').action='
			<?php
					echo $cfg['web_root'] . '/f.php';
					if (!empty($crypt_key))
						echo '&amp;k=' . urlencode($crypt_key);
			?>';
        document.getElementById('submit_download').submit ();"/><?php
       
        echo '</div>';
	   }
		echo '</div></fieldset></form>
		<form id="single_download_form_pwd" action="'.$cfg['web_root'].'/f.php" method="post">
		  <input type="hidden" id="single_download_pwd"  name="h" value=""/>
		  <input type="hidden" name="d" value="1"/>		  
		  <input type = "password" name = "key" id="pwd-keys-copy" placeholder="Password" style="display:none;"/>		  
		</form>		
		</div>';
        require (JIRAFEAU_ROOT.'lib/template/footer.php');
        exit;
    }
    else
    {
        if ($link['key'] == md5 ($_POST['key']))
            $password_challenged = true;
	else
        {
            require (JIRAFEAU_ROOT.'lib/template/header.php');
            echo '<div class="error"><fieldset id="" class="access_denied"><legend>  </legend><div class="error_conttent"><p class="access_error">' . t('Access Denied') .
            '</p><p class="wrong-password">Wrong Password</p></div></fieldset></div>';
            require (JIRAFEAU_ROOT.'lib/template/footer.php');
            exit;
        }
    }
}


//download page_below  Show all Download list

if (!$password_challenged && !$do_download && !$do_preview)
{
	
        require (JIRAFEAU_ROOT.'lib/template/header.php');
        echo '<div class="download_page download_page_below">' .
		      
             '<form action = "';
        echo $cfg['web_root'] . '/f.php';
        echo '" ' .
             'method = "post" id = "submit_post" class="form_download">'; ?>
             <input type = "hidden" name = "jirafeau" value = "<?php echo JIRAFEAU_VERSION ?>"/>
			 <?php
			 if(!isset($_POST['clipBoardUrl'])) {
			   if(isset($_GET['h']) && $_GET['h'] !=""){
			     $_POST['clipBoardUrl'] =  $cfg['web_root'].'f.php?h='.$_GET['h'];
			   } elseif(isset($_POST['h']) && $_POST['h'] !="") {
			     $_POST['clipBoardUrl'] =  $cfg['web_root'].'f.php?h='.$_POST['h'];				 
			   } else {
			     $_POST['clipBoardUrl'] =  "";
			   }
			 }
			 //Zip and plain download
			if($cfg['downloadMode'] =="zipFiles"){
			 echo '<textarea  id="clip-board" class="clip-board-txt-dn-page" name="" readonly="readonly" style="left:-2000px;position:absolute;" >'.$_POST['clipBoardUrl'].'&amp;mail=1</textarea>';
			}
			 
        echo '<fieldset class="dwn_fieldset"><legend>' . htmlspecialchars($link['file_name']) . '</legend><div class="dwn-file-list">';
            echo  '<p class="download-title">  Download </p>';
            echo '<div class="file_list_wrapper">';
			
			 $zipEstimate = "";
			 $files_counter= 1;
			foreach($link_nameArr as $links_dn){
				$link_dn = jirafeau_get_link ($links_dn);
				if (!empty($link_dn)) {
					$zipEstimate +=  $link_dn['file_size'];
				
					echo '<div class="fileList">';				 
					echo  '<span class="f_name">'.$link_dn['file_name'].'</span> <span class="download-icon"><a id="'.$links_dn.'" class="dn-icon" href="javascript:void(0);"></a></span>   ';
					echo  '<span class="f_size">'.formatSizeUnits($link_dn['file_size']).' </span>'; 
					//echo  '<span class="download-icon"><a class="dn-icon" href="'.$cfg['web_root'] . '/f.php?h='.$links_dn.'&amp;d=1"><img src="'.$cfg['web_root'].'media/'.$cfg['style'].'/download.svg"/></a></span>';
				 
					if(isset($_POST['clipBoardUrl'])){
						
						 //Zip and plain download
						if($cfg['downloadMode'] =="zipFiles"){
							echo '<div class="clipBoardUrl_list">				 
						   <textarea  id="clip-board" class="clip-board-txt-dn-page" name="" readonly="readonly">'.$_POST['clipBoardUrl'].'&amp;mail=1 </textarea>
							<span class="download-icon clip-icon"><a  href="javascript:void(0);" class="copyButton1 download-icon" id="copyButton1" data-clipboard-target="#clip-board" >'.t('').'</a>
							<span class="text-copied" style="display:none;">Copied!</span>
							</span>
							</div>';
      					}
					}
							
					echo '</div>';
					$files_counter++; 
				}
			}
			 
          echo '</div>';//file_list_wrapper
		  
		  echo '<div class="dn_txt">Durch die Nutzung unsere Dienste, akzeptieren Sie unsere </div>';
		  echo '<div class="terms-And-Conditin"><a href="' . $cfg['web_root'] . '/tos.php' . '"><span class="terms-sv">Terms</span>/<span class="conditions-sv">Conditions</span></a> </div>';
		  
        if ($link['onetime'] == 'O')
        {
            //echo '<div class="self_destruct">' .
                 //t('Warning, this file will self-destruct after being read') .
                 //'</div>';
        }
	
        ?>
		  <input type="hidden" name="h" value="<?php echo $_POST['h'];?>"/>	
		  <input type="hidden" name="d" value="1"/>
		 
    			
	   <?php
	     //Zip and plain download
	   if($cfg['downloadMode'] =="zipFiles"){ ?>
		 
        <div class="dn_submit tt"><input type="submit" id = "submit_download"  value="<?php echo t('Download all'); ?>"
        onclick="document.getElementById('submit_post').action='
		<?php
				echo $cfg['web_root'] . '/f.php?h=' . $_POST['h'] . '&amp;d=1';
				if (!empty($crypt_key))
					echo '&amp;k=' . urlencode($crypt_key);
		?>';
				document.getElementById('submit_post').submit ();"/><?php

        
        echo '</div>';
	   }
		
        echo '</div></fieldset></form>
		<form id="single_download_form" action="'.$cfg['web_root'].'/f.php" method="post">
		  <input type="hidden" id="single_download"  name="h" value=""/>
		  <input type="hidden" name="d" value="1"/>		  
		</form>
		</div>';
        require (JIRAFEAU_ROOT.'lib/template/footer.php');
        exit;
}


/*

* Get h paramter from url
* Find file using h paramter
*/


//header ('HTTP/1.0 200 OK');
//header ('Content-Length: ' . $link['file_size']);
if (!jirafeau_is_viewable ($link['mime_type']) || !$cfg['preview'] || $do_download)
{
	
	$link_name_temp  = $_POST['h'];			
	if (strpos($link_name_temp,'@') !== false) {   
	   $is_single = false;
	}else{
		$is_single = true;
	}
	
	$allow_zip_format = array('rar','zip','gz','tar');
	$file_ext = pathinfo($link['file_name'], PATHINFO_EXTENSION);

	if((in_array($file_ext, $allow_zip_format)) && $is_single == true  && $cfg['re_zipped'] == false){		
		/**	 
		 * force to download as a same if zip or single
		*/
			
		  header ('HTTP/1.0 200 OK');
		  header("Content-Description: File Transfer");
		  
		  header("Content-type: application/octet-stream");
		  header("Content-Type: application/force-download");// some browsers need this
		  header ('Content-Length: ' . $link['file_size']);
		  header ('Content-Disposition: attachment; filename="' . $link['file_name'] . '"');	  
		  header ('Content-MD5: ' . hex_to_base64($link['md5']));
	}	 
	else
	{	
	
		if($cfg['downloadMode'] == "plainFiles"){
			
		/**	 
		 * force to download in plain mode
		*/
			
		  header ('HTTP/1.0 200 OK');
		  header("Content-Description: File Transfer");
		  
		  header("Content-type: application/octet-stream");
		  header("Content-Type: application/force-download");// some browsers need this
		  header ('Content-Length: ' . $link['file_size']);
		  header ('Content-Disposition: attachment; filename="' . $link['file_name'] . '"');	  
		  header ('Content-MD5: ' . hex_to_base64($link['md5']));
			
			
		}else{
		
		
		/**
		 * gets download file name and file path
		 * force to download in zip format.
		*/
			
			$link_name_temp  = $_POST['h'];
			
			if (strpos($link_name_temp,'@') !== false) {
			   $timeSet = time();			
			   $archive_file_name='s42transfer_'.$timeSet.'.zip';
			  
			 }else{			
				  $file_name = $link['file_name'];
				  $extension_pos = strrpos($file_name, '.'); //find position of the last dot, so where the extension starts
				  $fileNameBeforeExt = substr($file_name, 0, $extension_pos);
				  $fileNameBeforeExt = preg_replace('/\s+/', '', $fileNameBeforeExt);			
				  $archive_file_name = $fileNameBeforeExt.'.zip';
			 }
			
			
			$zip = new ZipArchive();
				//create the file and throw the error if unsuccessful
				if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
					exit("cannot open <$archive_file_name>\n");
				}
				
				$link_name_new  =$_POST['h'];
				$link_name_new_1 = explode('@',$link_name_new);
				foreach($link_name_new_1 as $links){
					 $link_1 = jirafeau_get_link ($links);
					 if (!empty($link_1)) {
					
						$p_path = s2p ($link_1['md5']);
						$file_path = VAR_FILES . $p_path;
					
						//add each files of $file_name array to archive			
						$zip->addFile($file_path.$link_1['md5'],$link_1['file_name']);
					}				
				}
				
				$zip->close();
				
				
				
				$zipped_size = filesize($archive_file_name);
				header("Content-Description: File Transfer");
				header("Content-type: application/zip"); 
				header("Content-type: application/octet-stream");
				header("Content-Type: application/force-download");// some browsers need this
				header("Content-Disposition: attachment; filename=$archive_file_name");
				header("Content-Transfer-Encoding: binary");
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header("Content-Length:". " $zipped_size");
				///ob_clean();
				//flush();
				//readfile("$archive_file_name");
				ob_end_flush();
				@readfile($cfg['web_root'].'/'.$archive_file_name);

				unlink($archive_file_name); // Now delete the temp file (some servers need this option)
				unlink($cfg['web_root'].'/'.$archive_file_name); // Now delete the temp file (some servers need this option)
				unlink(JIRAFEAU_ROOT.$archive_file_name); // Now delete the temp file (some servers need this option)
			
			
				
			//Delete files after download if onetime  download

				foreach($link_name_new_1 as $links){
				 $link_1 = jirafeau_get_link ($links);
					if ($link_1['onetime'] == 'O'){
					   jirafeau_delete_link ($link_name);
					 }
				 }
			  exit;
			  
		}
	}	
   
}
else
{
   header ('Content-Disposition: filename="' . $link['file_name'] . '"');
   header ('Content-Type: ' . $link['mime_type']);
   header ('Content-MD5: ' . hex_to_base64($link['md5']));
}

/* Read encrypted file. */
if ($link['crypted'])
{
    /* Init module */
    $m = mcrypt_module_open('rijndael-256', '', 'ofb', '');
    /* Extract key and iv. */
    $md5_key = md5 ($crypt_key);
    $iv = jirafeau_crypt_create_iv ($md5_key, mcrypt_enc_get_iv_size($m));
    /* Init module. */
    mcrypt_generic_init ($m, $md5_key, $iv);
    /* Decrypt file. */
    $r = fopen (VAR_FILES . $p . $link['md5'], 'r');
    while (!feof ($r))
    {
        $dec = mdecrypt_generic($m, fread ($r, 1024));
        print $dec;
        ob_flush();
    }
    fclose ($r);
    /* Cleanup. */
    mcrypt_generic_deinit($m);
    mcrypt_module_close($m);
}
/* Read file. */
else
{
    $r = fopen (VAR_FILES . $p . $link['md5'], 'r');
    while (!feof ($r))
    {
        print fread ($r, 1024);
        ob_flush();
    }
    fclose ($r);
}

if ($link['onetime'] == 'O')
    jirafeau_delete_link ($link_name);
exit;

?>
