<?php
/*
 *  s42transfer, your web file repository
 *  Copyright (C) 2017  s42transfer <admin@s52.io>
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

/*
 * This file permits to easyly script file sending, receiving, deleting, ...
 * If you don't want this feature, you can simply delete this file from your
 * web directory.
 */

define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/config.local.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

 global $script_langages;
 $script_langages = array ('bash' => 'Bash');

/* Operations may take a long time.
 * Be sure PHP's safe mode is off.
 */
@set_time_limit(0);
/* Remove errors. */
@error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] == "GET" && count ($_GET) == 0)
{
    require (JIRAFEAU_ROOT . 'lib/template/header.php');
    check_errors ($cfg);
    if (has_error ())
    {
        show_errors ();
        require (JIRAFEAU_ROOT . 'lib/template/footer.php');
        exit;
    }
    ?>
    <div class="info">
    <h2>Scripting interface</h2>
    <p>This interface permits to script your uploads and downloads.</p>
    <p>See <a href="https://gitlab.com/mojo42/Jirafeau/blob/master/script.php">source code</a> of this interface to get available calls :)</p>
    </div>
    <br />
    <?php
    require (JIRAFEAU_ROOT . 'lib/template/footer.php');
    exit;
}

/* Lets use interface now. */
header('Content-Type: text; charset=utf-8');

check_errors ($cfg);
if (has_error ())
{
    echo 'Error';
    exit;
}

/* Upload file */
if (isset ($_FILES['file']) && is_writable (VAR_FILES)
    && is_writable (VAR_LINKS))
{
    if (!jirafeau_challenge_upload_ip ($cfg, get_ip_address($cfg)))
    {
        echo 'Error';
        exit;
    }

    if (jirafeau_has_upload_password ($cfg) &&
         (!isset ($_POST['upload_password']) ||
          !jirafeau_challenge_upload_password ($cfg, $_POST['upload_password'])))
    {
        echo 'Error';
        exit;
    }

    $key = '';
    if (isset ($_POST['key']))
        $key = $_POST['key'];

    $time = time ();
    if (!isset ($_POST['time']) || !$cfg['availabilities'][$_POST['time']])
    {
        echo 'Error';
        exit;
    }
    else
        switch ($_POST['time'])
        {
            case 'minute':
                $time += JIRAFEAU_MINUTE;
                break;
            case 'hour':
                $time += JIRAFEAU_HOUR;
                break;
            case 'day':
                $time += JIRAFEAU_DAY;
                break;
            case 'week':
                $time += JIRAFEAU_WEEK;
                break;
            case 'month':
                $time += JIRAFEAU_MONTH;
                break;
            case 'year':
                $time += JIRAFEAU_YEAR;
                break;
           default:
                $time = JIRAFEAU_INFINITY;
                break;
        }

    // Check file size
    if ($cfg['maximal_upload_size'] > 0 &&
        $_FILES['file']['size'] > $cfg['maximal_upload_size'] * 1024 * 1024)
    {
        echo 'Error';
        exit;
    }

    $res = jirafeau_upload ($_FILES['file'],
                            isset ($_POST['one_time_download']),
                            $key, $time, get_ip_address($cfg),
                            $cfg['enable_crypt'], $cfg['link_name_length']);
    
    if (empty($res) || $res['error']['has_error'])
    {
        echo 'Error';
        exit;
    }
    /* Print direct link. */
    echo $res['link'];
    /* Print delete link. */
    echo NL;
    echo $res['delete_link'];
    /* Print decrypt key. */
    echo NL;
    echo urlencode($res['crypt_key']);
}
elseif (isset ($_GET['h']))
{
    $link_name = $_GET['h'];
    $key = '';
    if (isset ($_POST['key']))
        $key = $_POST['key'];
    $d = '';
    if (isset ($_GET['d']))
        $d = $_GET['d'];
    
    if (!preg_match ('/[0-9a-zA-Z_-]+$/', $link_name))
    {
        echo 'Error';
        exit;
    }
    
    $link = jirafeau_get_link ($link_name);
    if (count ($link) == 0)
    {
        echo 'Error';
        exit;
    }
    if (strlen ($d) > 0 && $d == $link['link_code'])
    {
        jirafeau_delete_link ($link_name);
        echo "Ok";
        exit;
    }
    if ($link['time'] != JIRAFEAU_INFINITY && time () > $link['time'])
    {
        jirafeau_delete_link ($link_name);
        echo 'Error';
        exit;
    }
    if (strlen ($link['key']) > 0 && md5 ($key) != $link['key'])
    {
        echo 'Error';
        exit;
    }
    $p = s2p ($link['md5']);
    if (!file_exists (VAR_FILES . $p . $link['md5']))
    {
        echo 'Error';
        exit;
    }

    /* Read file. */
    header ('Content-Length: ' . $link['file_size']);
    header ('Content-Type: ' . $link['mime_type']);
    header ('Content-Disposition: attachment; filename="' .
            $link['file_name'] . '"');

    $r = fopen (VAR_FILES . $p . $link['md5'], 'r');
    while (!feof ($r))
    {
        print fread ($r, 1024);
        ob_flush();
    }
    fclose ($r);

    if ($link['onetime'] == 'O')
        jirafeau_delete_link ($link_name);
    exit;
}
elseif (isset ($_GET['get_capacity']))
{
    echo min (jirafeau_ini_to_bytes (ini_get ('post_max_size')),
              jirafeau_ini_to_bytes (ini_get ('upload_max_filesize')));
}
elseif (isset ($_GET['get_maximal_upload_size']))
{
    echo $cfg['maximal_upload_size'];
}
elseif (isset ($_GET['get_version']))
{
    echo JIRAFEAU_VERSION;
}
elseif (isset ($_GET['lang']))
{
    $l=$_GET['lang'];
    if ($l == "bash")
    {
?>
#!/bin/bash

# This script has been auto-generated by Jirafeau but you can still edit 
# options below.

# Config
proxy='' # ex: proxy='proxysever.test.com:3128' or set JIRAFEAU_PROXY global variable
url='<?php echo $cfg['web_root'] . 'script.php'; ?>' # or set JIRAFEAU_URL ex: url='http://mysite/jirafeau/script.php'
time='none' # minute, hour, day, week, month, year or none. Or set JIRAFEAU_TIME.
one_time='' # ex: one_time="1" or set JIRAFEAU_ONE_TIME.
curl='' # curl path to download or set JIRAFEAU_CURL_PATH.
# End of config

if [ -n "$JIRAFEAU_PROXY" ]; then
    proxy="$JIRAFEAU_PROXY"
fi

if [ -n "$JIRAFEAU_URL" ]; then
    url="$JIRAFEAU_URL"
fi

if [ -z "$url" ]; then
    echo "Please set url in script parameters or export JIRAFEAU_URL"
fi

if [ -n "$JIRAFEAU_TIME" ]; then
    time="$JIRAFEAU_TIME"
fi

if [ -n "$JIRAFEAU_ONE_TIME" ]; then
    one_time='1'
fi

if [ -z "$curl" ]; then
    curl="$JIRAFEAU_CURL_PATH"
fi

if [ -z "$curl" ] && [ -e "/usr/bin/curl" ]; then
    curl="/usr/bin/curl"
fi

if [ -z "$curl" ] && [ -e "/bin/curl.exe" ]; then
    curl="/bin/curl.exe"
fi

if [ -z "$curl" ]; then
    echo "Please set your curl binary path (by editing this script or export JIRAFEAU_CURL_PATH global variable)."
    exit
fi

if [ -z "$2" ]; then
    echo "man:"
    echo "    $0 send PATH [PASSWORD]"
    echo "    $0 get URL [PASSWORD]"
    echo "    $0 delete URL"
    echo ""
    echo "Global variables to export:"
    echo "    JIRAFEAU_PROXY : example: proxysever.test.com:3128"
    echo "    JIRAFEAU_URL : example: http://mysite/jirafeau/script.php"
    echo "    JIRAFEAU_TIME : minute, hour, day, week, year, month or none"
    echo "    JIRAFEAU_ONE_TIME : set anything or set empty"
    echo "    JIRAFEAU_CURL : path to your curl binary"

    exit 0
fi

if [ -n "$proxy" ]; then
    proxy="-x $proxy"
fi

options=''
if [ -n "$one_time" ]; then
    options="$options -F one_time_download=1"
fi

password=''
if [ -n "$3" ]; then
    password="$3"
    options="$options -F key=$password"
fi

if [ "$1" == "send" ]; then
    if [ ! -f "$2" ]; then
        echo "File \"$2\" does not exists."
        exit
    fi

    # Ret result
    res=$($curl -X POST --http1.0 $proxy $options \
                  -F "time=$time" \
                  -F "file=@$2" \
                  $url)

    if [[ "$res" == "Error" ]]; then
        echo "Error while uploading."
        exit
    fi

    # Not using head or tail to minimise command dependencies
    code=$(cnt=0; echo "$res" | while read l; do
        if [[ "$cnt" == "0" ]]; then
            echo "$l"
        fi
        cnt=$(( cnt + 1 ))
        done)
    del_code=$(cnt=0; echo "$res" | while read l; do
        if [[ "$cnt" == "1" ]]; then
            echo "$l"
        fi
        cnt=$(( cnt + 1 ))
        done)
    echo "${url}?h=$code"
    echo "${url}?h=$code&d=$del_code"
elif [ "$1" == "get" ]; then
    if [ -z "$password" ]; then
        $curl $proxy -OJ "$2"
    else
        $curl $proxy -OJ -X POST -F key=$password "$2"
    fi
elif [ "$1" == "delete" ]; then
    $curl $proxy "$2"
fi
<?php
    }
    else
    {
        echo 'Error';
        exit;
    }
}
/* Create alias. */
elseif (isset ($_GET['alias_create']))
{
    $ip = get_ip_address($cfg);
    if (!jirafeau_challenge_upload_ip ($cfg, $ip))
    {
        echo 'Error';
        exit;
    }

    if (jirafeau_has_upload_password ($cfg) &&
         (!isset ($_POST['upload_password']) ||
          !jirafeau_challenge_upload_password ($cfg, $_POST['upload_password'])))
    {
        echo 'Error';
        exit;
    }

    if (!isset ($_POST['alias']) ||
        !isset ($_POST['destination']) ||
        !isset ($_POST['password']))
    {
        echo 'Error';
        exit;
    }

    echo jirafeau_alias_create ($_POST['alias'],
                                $_POST['destination'],
                                $_POST['password'],
                                $ip);
}
/* Get alias. */
elseif (isset ($_GET['alias_get']))
{
    if (!isset ($_POST['alias']))
    {
        echo 'Error';
        exit;
    }

    echo jirafeau_alias_get ($_POST['alias']);
}
/* Update alias. */
elseif (isset ($_GET['alias_update']))
{
    if (!isset ($_POST['alias']) ||
        !isset ($_POST['destination']) ||
        !isset ($_POST['password']))
    {
        echo 'Error';
        exit;
    }

    $new_password = '';
    if (isset ($_POST['new_password']))
        $new_password = $_POST['new_password'];

    echo jirafeau_alias_update ($_POST['alias'],
                                $_POST['destination'],
                                $_POST['password'],
                                $new_password,
                                get_ip_address($cfg));
}
/* Delete alias. */
elseif (isset ($_GET['alias_delete']))
{
    if (!isset ($_POST['alias']) ||
        !isset ($_POST['password']))
    {
        echo 'Error';
        exit;
    }

    echo jirafeau_alias_delete ($_POST['alias'],
                                $_POST['password']);
}
/* Initialize an asynchronous upload. */
elseif (isset ($_GET['init_async']))
{
    if (!jirafeau_challenge_upload_ip ($cfg, get_ip_address($cfg)))
    {
        echo 'Error';
        exit;
    }

    if (jirafeau_has_upload_password ($cfg) &&
         (!isset ($_POST['upload_password']) ||
          !jirafeau_challenge_upload_password ($cfg, $_POST['upload_password'])))
    {
        echo 'Error';
        exit;
    }

    if (!isset ($_POST['filename']))
    {
        echo 'Error';
        exit;
    }

    $type = '';
    if (isset ($_POST['type']))
        $type = $_POST['type'];
    
    $key = '';
    if (isset ($_POST['key']))
        $key = $_POST['key'];

    $time = time ();
    if (!isset ($_POST['time']) || !$cfg['availabilities'][$_POST['time']])
    {
        echo 'Error';
        exit;
    }
    else
        switch ($_POST['time'])
        {
            case 'minute':
                $time += JIRAFEAU_MINUTE;
                break;
            case 'hour':
                $time += JIRAFEAU_HOUR;
                break;
            case 'day':
                $time += JIRAFEAU_DAY;
                break;
            case 'week':
                $time += JIRAFEAU_WEEK;
                break;
            case 'month':
                $time += JIRAFEAU_MONTH;
                break;
            case 'year':
                $time += JIRAFEAU_YEAR;
                break;
            default:
                $time = JIRAFEAU_INFINITY;
                break;
        }
    echo jirafeau_async_init ($_POST['filename'],
                              $type,
                              isset ($_POST['one_time_download']),
                              $key,
                              $time,
                              get_ip_address($cfg));
}
/* Continue an asynchronous upload. */
elseif (isset ($_GET['push_async']))
{
    if ((!isset ($_POST['ref']))
        || (!isset ($_FILES['data']))
        || (!isset ($_POST['code'])))
        echo 'Error';
    else
    {
        echo jirafeau_async_push ($_POST['ref'],
                                  $_FILES['data'],
                                  $_POST['code'],
                                  $cfg['maximal_upload_size']);
    }
}
/* Finalize an asynchronous upload. 
Fetch file sing reference 
Show download link, Direct download link, Delete file links ,Share files links

*/

elseif (isset ($_GET['end_async']))
{
	$temp = array();
	//print_r($_POST);
    if (!isset ($_POST['ref'])){
        echo 'Error';
	}
    else{
		$ref_listArr  = explode(",",$_POST['ref_list']);
		foreach($ref_listArr as $r_list){
			//echo jirafeau_async_end ($_POST['ref'], $_POST['code'], $cfg['enable_crypt'], $cfg['link_name_length'],$_POST['ref_list']);
		    $temp[] = jirafeau_async_end ($r_list, $_POST['code'], $cfg['enable_crypt'], $cfg['link_name_length']);
			
		}
		 //print_r($temp);
		foreach($temp as $r_link){
			//echo $r_link;
			$dnld_dlt_Val = explode(" ",$r_link);
			$dnld_link[] =$dnld_dlt_Val[0];
			$dnld_dlt_link[] =$dnld_dlt_Val[1];
			$dnld_crypt[] =$dnld_dlt_Val[0];
						
		  }
		   $dnld_link_1 = implode("@",$dnld_link);
		   $dnld_dlt_link_1 = implode("@",$dnld_dlt_link);
		   $dnld_crypt_1 = implode("@",$dnld_crypt);
		
		   if(!empty($dnld_link_1)){
			
			 $dwnload = $cfg['web_root'].'f.php?h='.$dnld_link_1; 
			 $dwnload_url = get_tiny_url($dwnload);
			 
			 $direct_Dwnload = $cfg['web_root'].'f.php?h='.$dnld_link_1.'&d=1'; 
			 $direct_Dwnload_url = get_tiny_url($direct_Dwnload);
			 
			 
			 //Generate Random nbr to store url to Clip Board
			 $nbr1 = mt_rand(5, 15);
			 $nbr1  =  $nbr1.time();
			 $cfg['generate_number'][$nbr1] = $dnld_link_1;
			 $generate_number1  = $nbr1;			
			 $clipBoardUrl =  $cfg['web_root'].'f.php?h='.$generate_number1.'&amp;mail=1'; 			 
			 $clipBoardUrl_1 =  $cfg['web_root'].'f.php?h='.$generate_number1;			 
			 jirafeau_export_cfg_custom($cfg);
			  //@END Generate Random nbr to store url to Clip Board
			 
			 //For plain
			  if(isset($cfg['downloadMode'])&& $cfg['downloadMode']=="plainFiles"){ 
			     $plain_checked =  'checked="checked"';
			   }else{
				 $plain_checked =  '';  
			   }
			   
			  //For zip
			  if(isset($cfg['downloadMode'])&& $cfg['downloadMode']=="zipFiles"){ 
			     $zip_checked =  'checked="checked"';
			   }else{
				 $zip_checked =  '';  
			   } 
			 

			  echo '<div class="send-links-ht"><div class="download_links"> ';
			    
			 if(isset($cfg['allow_downloadMode'])&& $cfg['allow_downloadMode']=="zipAndPlain"){ 	
				
				echo '<span class="zipUnzipContainer">
				      
					  <input class="downloadMode" type="radio" name="downloadMode" id="plainFiles" value="plainFiles" '.$plain_checked.'/>
					  <label for="plainFiles">Plain download</label>
					 			  
					   <input class="downloadMode" type="radio" name="downloadMode" id="zipFiles" value="zipFiles" '.$zip_checked.'/>
				       <label for="zipFiles">Zip download</label>		
				    </span>';
			    }
				 
				  //22 March 2016  $_GET['end_async']
				  
				  if($cfg['show_download_link'] ==true){
					 echo '<form class="frm_download_page dnPage" action="'.$cfg['web_root'].'f.php" method="post" target="_blank">
						   <input type="hidden" name="h" value="'.$dnld_link_1.'"/>				  
						   <input type="hidden" name="clipBoardUrl" value="'.$clipBoardUrl_1.'"/>				  
						   <span class="download_link">
						   <input type="submit" class="download_btn" name="direct_download" value="'.t('Download page').'"/>
						   </span>
						   </form>';
				    }
				 
				 
				 //echo '<span class="download_link"><a href="'.$cfg['web_root'].'f.php?h='.$dnld_link_1.'&amp;d=1">Direktlink</a></span>';
				 //echo '<span class="download_link"><a href="'. $dwnload.'&amp;d=1">'.t('Direct download').'</a></span>';
				 
				 //22 March 2016 $_GET['end_async']
				 
				if($cfg['downloadMode'] == "zipFiles"){
					$cl_Name = "";
				}else{
					$cl_Name = "hide_this";
				}
				
				 if($cfg['show_download_link'] ==true){
				 echo '<form class="frm_direct_download '.$cl_Name.'" action="'.$cfg['web_root'].'f.php" method="post">
				       <input type="hidden" name="h" value="'.$dnld_link_1.'"/>
					   <input type="hidden" name="d" value="1"/>
					  <input type="hidden" name="clipBoardUrl" value="'.$clipBoardUrl_1.'"/>
					   <span class="download_link">
					   <input type="submit" class="download_btn" name="direct_download" value="'.t('Direct download').'"/>
					 
					   </span>
					   </form>';
					   
				 }
					   
					   
				
				 // Copy to clipboard
			 	 //29 March 2016 $_GET['end_async'] 
			    $user_agent = getenv("HTTP_USER_AGENT");
				if(strpos($user_agent, "Win") !== FALSE)
				$os = "Windows";
				elseif(strpos($user_agent, "Mac") !== FALSE)
				$os = "Mac";
				if (isset($_SERVER['HTTP_USER_AGENT'])) {
					$agent = $_SERVER['HTTP_USER_AGENT'];
					
				}
				 
				if($os === "Mac"){
					if(stripos( $agent, 'Safari') !== false){
					 echo '<span class="download_link clip-board-container '.$cl_Name.'">	 				   
					   <a  href="javascript:void(0);" data-clipboard-action="copy" aria-label="" class="btn-aysMacSafari" id="copyButton-safari" data-clipboard-target="#copyTarget">'.t('Copy Link to Clipboard <div class="text-copied-upload" style="display:none;">Copied!</div>').'</a>
					   <textarea  id="copyTarget" class="clip-board-txt" name="" readonly="readonly">'.$clipBoardUrl.'</textarea>					 
					   </span> ';
					}else{
						 echo '<span class="download_link clip-board-container '.$cl_Name.'">	 				   
					   <a  href="javascript:void(0);" data-clipboard-action="copy" aria-label="" class="btn-aysMacEls" id="copyButton" data-clipboard-target="#copyTarget">'.t('Copy Link to Clipboard <div class="text-copied-upload" style="display:none;">Copied!</div>').'</a>
					   <textarea  id="copyTarget" class="clip-board-txt" name="" readonly="readonly">'.$clipBoardUrl.'</textarea>					 
					   </span> ';	
						
					}
				 }else{
				 echo '<span class="download_link clip-board-container '.$cl_Name.'">	 				   
					   <a  href="javascript:void(0);" data-clipboard-action="copy" aria-label="" class="btn-aysWinEls" id="copyButton" data-clipboard-target="#copyTarget">'.t('Copy Link to Clipboard <div class="text-copied-upload" style="display:none;">Copied!</div>').'</a>
					   <textarea  id="copyTarget" class="clip-board-txt" name="" readonly="readonly">'.$clipBoardUrl.'</textarea>					 
					   </span> ';	
				 }					   
				//@END Copy to clipboard 
				
				//IMage  preview
				$counter = 1;
				 foreach($dnld_link as $view_link){	
				   $allowed = array('png', 'jpg', 'gif','bmp','jepg');
						$v_link = jirafeau_get_link ($view_link);
						$extensions = explode('.',$v_link['file_name']);
						$extension = $extensions[1];
						if(in_array(strtolower($extension), $allowed)){
							$h = $cfg['web_root'].'f.php?h='.$view_link.'';
							 $p= '&amp;p=1';
							 if($counter ==1){
						      //echo '<span class="download_link"><a target="_blank" href="'.$h.$p.'"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>'; 
							 }else{
								//echo '<span class="download_link"><a target="_blank" href="'.$h.$p.'"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>'; 
							 }
							 
							 //Insert Form with post method to preview single image
							  echo '<form class="'.$view_link.'" action="'.$cfg['web_root'].'f.php" method="post" target="_blank">
									   <input type="hidden" name="h" value="'.$view_link.'"/>
									   <input type="hidden" name="p" value="1"/>								   
									   
									   <span class="download_link pre_link" id="'.$view_link.'"><a class=""  href="javascript:void(0);"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>
									   </form>';
							 
								
						 }
					$counter++;	
					 }
			 echo "</div>";
		     }
			 
			//Send Links
			  $h = $cfg['web_root'].'sendlink.php?h='.$dnld_link_1.'';
			  $s= '&amp;s=1';
			  
			 $sharlink = $cfg['web_root'].'sendlink.php?h='.$dnld_link_1.'&s=1';
			 $sharlink_url = get_tiny_url($sharlink);
			 
			if(isset($cfg['sharing_enable']) && $cfg['sharing_enable'] ==1){
			     //echo '<div class="send_links"><a  target="_blank" href="'.$h.$s.'" >Share your file(s)</a></div>';
				  echo '<form id="share_form" action="'.$cfg['web_root'].'sendlink.php" method="post">
				       <input type="hidden" name="h" value="'.$dnld_link_1.'"/>
					   <input type="hidden" name="generate_number" value="'.$nbr1.'"/>
					   <input type="hidden" name="s" value="1"/>					  
					    <div class="send_links"><a class="share-link" href="javascript:void(0);" >Share your file(s)</a></div>
					   </form>';
			  }
			echo '</div>';
			 
			  
			 
			 //Validity 
			 echo '<div id="validity">';
			  echo '<p>'.t('This file is valid until the following date').':</p>';
			    echo '<p id="date"></p>';
			echo '</div>';
			 
			 //Delete Link 
			if(!empty($dnld_dlt_link_1)){
			 echo '<div class="delete_links">';
				//echo '<div id="dvCountDown" style="display: none">
					//You will be redirected after <span id="lblCount"></span> seconds. if not click <a class="if_not_redirect_af_del"  href="'.$cfg['web_root'].'" >here</a>
					//</div>';			 
			   echo '<span id="del_message"></span>';
			  //$h = $cfg['web_root'].'f.php?h='.$dnld_link_1.'';
			  $h = 'h='.$dnld_link_1.'';
			  $d= '&amp;d='.$dnld_dlt_link_1;
			  echo '<input type="hidden" id="file-code" value="'.$h.$d.'"/>';
				echo '<a class="del_files" id="'.$h.$d.'" href="javascript:void(0);">Delete Files</a>';
			 echo "</div>";	
		     }
		 
	}
}

/* Finalize an Classic upload end. */
/* Finalize an Classic upload end. */
/* Finalize an Classic upload end. */
/* Finalize an Classic upload end. */
elseif (isset ($_GET['end_classic']))
{
	
	//print_r($_POST);
    if (!isset ($_POST['link_list'])){
        echo 'Error';
	}
    else{
		$link_listArr  = explode(",",$_POST['link_list']);
		$link_del_listArr  = explode(",",$_POST['link_del_list']);
		
		$link_list_all = implode("@",$link_listArr);
		$link_del_list_all = implode("@",$link_del_listArr);
		
		   if(!empty($link_list_all)){	
		   
		   
		    //Generate Random nbr to store url to Clip Board
			 $nbr1 = mt_rand(5, 15);
			 $nbr1  =  $nbr1.time();
			 $cfg['generate_number'][$nbr1] = $link_list_all;
			 $generate_number1  = $nbr1;			
			 $clipBoardUrl =  $cfg['web_root'].'f.php?h='.$generate_number1.'&amp;mail=1'; 			 
			 $clipBoardUrl_1 =  $cfg['web_root'].'f.php?h='.$generate_number1;			 
			 jirafeau_export_cfg_custom($cfg);
			  //@END Generate Random nbr to store url to Clip Board
			 
		   

             $dwnload = $cfg['web_root'].'f.php?h='.$link_list_all; 
			// $dwnload_url = get_tiny_url($dwnload);
			 
			 $direct_Dwnload = $cfg['web_root'].'f.php?h='.$link_list_all.'&amp;d=1'; 
			 //$direct_Dwnload_url = get_tiny_url($direct_Dwnload);		   

			 echo '<div class="send-links-ht"><div class="download_links">'; 
			// echo '<span class="download_link"><a target="_blank" href="'.$dwnload.'"> '.t('Download page').'</a></span>';
			
			//22 March 2016
				 echo '<form action="'.$cfg['web_root'].'f.php" method="post" target="_blank">
				       <input type="hidden" name="h" value="'.$link_list_all.'"/>
                        <input type="hidden" name="clipBoardUrl" value="'.$clipBoardUrl_1.'"/>					   
					   <span class="download_link">
					   <input type="submit" class="download_btn" name="direct_download" value="'.t('Download page').'"/>
					   </span>
					   </form>';			

			 //echo '<span class="download_link"><a href="'.$direct_Dwnload.'">'.t('Direct download').'</a></span>';
			 
			  //22 March 2016
				 echo '<form action="'.$cfg['web_root'].'f.php" method="post">
				       <input type="hidden" name="h" value="'.$link_list_all.'"/>
					   <input type="hidden" name="d" value="1"/>
					  <input type="hidden" name="clipBoardUrl" value="'.$clipBoardUrl_1.'"/>
					   <span class="download_link">
					   <input type="submit" class="download_btn" name="direct_download" value="'.t('Direct download').'"/>
					   </span>
					   </form>';
					   
					   
			  // Copy to clipboard
			 	 //29 March 2016 $_GET['classic'] 

					
				 echo '<span class="download_link clip-board-container">'.	 				   
					   '<a  href="javascript:void(0);" class="btn-classic" data-clipboard-action="copy" aria-label="" data-clipboard-text="'.$clipBoardUrl.'" id="copyButton-safari" data-clipboard-target="#copyTarget">'.t('Copy Link to Clipboard <div class="text-copied-upload" style="display:none;">Copied!</div>').'</a>'.
					   
					   '<textarea  id="copyTarget" class="clip-board-txt" name="" >'.$clipBoardUrl.'</textarea>'.
					   '</span> ';


	
				//@END Copy to clipboard
			 
				
			//View Link	 Image
			 $counter = 1;
			 foreach($link_listArr as $view_link){	
			  $allowed = array('png', 'jpg', 'gif','bmp','jepg');
			  
			  $v_link = jirafeau_get_link ($view_link);
			  $extensions = explode('.',$v_link['file_name']);
			  $extension = $extensions[1];
			  if(in_array(strtolower($extension), $allowed)){
				$h = $cfg['web_root'].'f.php?h='.$view_link.'';
				$p= '&amp;p=1';
				
				
				
				 if($counter ==1){
				    //echo '<span class="download_link"><a target="_blank" href="'.$h.$p.'"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>'; 
				 }else{
				  //echo '<span class="download_link"><a target="_blank" href="'.$h.$p.'"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>'; 
				 }
				 
				  echo '<form class="'.$view_link.'" action="'.$cfg['web_root'].'f.php" method="post" target="_blank">
									   <input type="hidden" name="h" value="'.$view_link.'"/>
									   <input type="hidden" name="p" value="1"/>								   
									   
									   <span class="download_link pre_link" id="'.$view_link.'"><a class=""  href="javascript:void(0);"><span class="prr_img">Preview</span> <span class="img_preview">'.$v_link['file_name'].'</span></a></span>
									   </form>';
								
			    }
			   $counter++;	
			  }
			  echo "</div>";
		     }
			 
			//Send Links to friends
			  $h = $cfg['web_root'].'sendlink.php?h='.$link_list_all.'';
			  $s= '&amp;s=1';
			  
			  $sharlink = $cfg['web_root'].'sendlink.php?h='.$link_list_all.'&s=1';
			  $sharlink_url = get_tiny_url($sharlink);
			  
			 if(isset($cfg['sharing_enable']) && $cfg['sharing_enable'] ==1){
			     //echo '<div class="send_links"><a  target="_blank" href="'.$h.$s.'" >Share your file(s)</a></div>';
				 
				 echo '<form id="share_form" action="'.$cfg['web_root'].'sendlink.php" method="post">
				       <input type="hidden" name="h" value="'.$link_list_all.'"/>
					   <input type="hidden" name="generate_number" value="'.$nbr1.'"/>
					   <input type="hidden" name="s" value="1"/>					  
					    <div class="send_links"><a class="share-link" href="javascript:void(0);" >Share your file(s)</a></div>
					   </form>';
			  }
			 
			echo '</div>';
			 
			  
			 
			 //Validity 
			 echo '<div id="validity">';
			    echo '<p>'.t('This file is valid until the following date').':</p>';
			    echo '<p id="date"></p>';
			 echo '</div>';
			 
			 //Delete Link 
			if(!empty($link_del_list_all)){
			 echo '<div class="delete_links">';
				//echo '<div id="dvCountDown" style="display: none">
					//You will be redirected after <span id="lblCount"></span> seconds.
					//</div>';			 
			   echo '<span id="del_message"></span>';
			  //$h = $cfg['web_root'].'f.php?h='.$dnld_link_1.'';
			  $h = 'h='.$link_list_all.'';
			  $d= '&amp;d='.$link_del_list_all;
			  echo '<input type="hidden" id="file-code" value="'.$h.$d.'"/>';
				echo '<a class="del_files" id="'.$h.$d.'" href="javascript:void(0);">Delete Files</a>';
			 echo "</div>";	
		     }
		 
	}
	
}
else
    echo 'Error';
exit;
?>
