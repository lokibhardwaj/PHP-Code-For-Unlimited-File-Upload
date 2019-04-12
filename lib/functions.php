<?php
/*
 *  Jirafeau, your web file repository
 *   Copyright (C) 2017  s42transfer <admin@s42.io>
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

/**
 * Transform a string in a path by seperating each letters by a '/'.
 * @return path finishing with a '/'
 */
 
if(isset($cfg['web_root']) && $cfg['web_root'] !=""){
require_once (JIRAFEAU_ROOT . 'lib/config.local.php'); 	
}
function
s2p ($s)
{
    $p = '';
    for ($i = 0; $i < strlen ($s); $i++)
        $p .= $s{$i} . '/';
    return $p;
}

/**
 * Convert base 16 to base 64
 * @returns A string based on 64 characters (0-9, a-z, A-Z, "-" and "_")
 */
function
base_16_to_64 ($num)
{
    $m = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
    $hex2bin = array ('0000',  # 0
                      '0001',  # 1
                      '0010',  # 2
                      '0011',  # 3
                      '0100',  # 4
                      '0101',  # 5
                      '0110',  # 6
                      '0111',  # 7
                      '1000',  # 8
                      '1001',  # 9
                      '1010',  # a
                      '1011',  # b
                      '1100',  # c
                      '1101',  # d
                      '1110',  # e
                      '1111'); # f
    $o = '';    
    $b = '';
    $i = 0;
    # Convert long hex string to bin.
    $size = strlen ($num);
    for ($i = 0; $i < $size; $i++)
        $b .= $hex2bin{hexdec ($num{$i})};
    # Convert long bin to base 64.
    $size *= 4;
    for ($i = $size - 6; $i >= 0; $i -= 6)
        $o = $m{bindec (substr ($b, $i, 6))} . $o;
    # Some few bits remaining ?
    if ($i < 0 && $i > -6)
        $o = $m{bindec (substr ($b, 0, $i + 6))} . $o;
    return $o;
}

/**
  * Generate a random code.
  * @param $l code length
  * @return  random code.
  */
function
jirafeau_gen_random ($l)
{
    if ($l <= 0)
        return 42;

    $code="";
    for ($i = 0; $i < $l; $i++)
        $code .= dechex (rand (0, 15));

    return $code;
}

function
is_ssl() {
    if ( isset($_SERVER['HTTPS']) ) {
        if ( 'on' == strtolower($_SERVER['HTTPS']) ||
             '1' == $_SERVER['HTTPS'] )
            return true;
    } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            return true;
    }
    return false;
}

function
jirafeau_human_size ($octets)
{
    $u = array ('B', 'KB', 'MB', 'GB', 'TB');
    $o = max ($octets, 0);
    $p = min (floor (($o ? log ($o) : 0) / log (1024)), count ($u) - 1);
    $o /= pow (1024, $p);
    return round ($o, 1) . $u[$p];
} 

function
jirafeau_clean_rm_link ($link)
{
    $p = s2p ("$link");
    if (file_exists (VAR_LINKS . $p . $link))
        unlink (VAR_LINKS . $p . $link);
    $parse = VAR_LINKS . $p;
    $scan = array();
    while (file_exists ($parse)
           && ($scan = scandir ($parse))
           && count ($scan) == 2 // '.' and '..' folders => empty.
           && basename ($parse) != basename (VAR_LINKS)) 
    {
        rmdir ($parse);
        $parse = substr ($parse, 0, strlen($parse) - strlen(basename ($parse)) - 1);
    }
}

function
jirafeau_clean_rm_file ($md5)
{
    $p = s2p ("$md5");
    $f = VAR_FILES . $p . $md5;
    if (file_exists ($f) && is_file ($f))
        unlink ($f);
    if (file_exists ($f . '_count') && is_file ($f . '_count'))
        unlink ($f . '_count');
    $parse = VAR_FILES . $p;
    $scan = array();
    while (file_exists ($parse)
           && ($scan = scandir ($parse))
           && count ($scan) == 2 // '.' and '..' folders => empty.
           && basename ($parse) != basename (VAR_FILES)) 
    {
        rmdir ($parse);
        $parse = substr ($parse, 0, strlen($parse) - strlen(basename ($parse)) - 1);
    }
}

/**
 * transforms a php.ini string representing a value in an integer
 * @param $value the value from php.ini
 * @returns an integer for this value
 */
function
jirafeau_ini_to_bytes ($value)
{
    $modifier = substr ($value, -1);
    $bytes = substr ($value, 0, -1);
    switch (strtoupper ($modifier))
    {
    case 'P':
        $bytes *= 1024;
    case 'T':
        $bytes *= 1024;
    case 'G':
        $bytes *= 1024;
    case 'M':
        $bytes *= 1024;
    case 'K':
        $bytes *= 1024;
    }
    return $bytes;
}

/**
 * gets the maximum upload size according to php.ini
 * @returns the maximum upload size in bytes
 */
function
jirafeau_get_max_upload_size_bytes ()
{
    //return min (jirafeau_ini_to_bytes (ini_get ('post_max_size')),
        // jirafeau_ini_to_bytes (ini_get ('upload_max_filesize')));
			   
	  $maxSize = 3145728;		   
		return $maxSize;
		
}

/**
 * gets the maximum upload size according to php.ini
 * @returns the maximum upload size string
 */
function
jirafeau_get_max_upload_size ()
{
    return jirafeau_human_size(
            min (jirafeau_ini_to_bytes (ini_get ('post_max_size')),
                 jirafeau_ini_to_bytes (ini_get ('upload_max_filesize'))));
}

/**
 * gets a string explaining the error
 * @param $code the error code
 * @returns a string explaining the error
 */
function
jirafeau_upload_errstr ($code)
{
    switch ($code)
    {
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        return t('Your file exceeds the maximum authorized file size. ');

    case UPLOAD_ERR_PARTIAL:
    case UPLOAD_ERR_NO_FILE:
        return
            t('Your file was not uploaded correctly. You may succeed in retrying. ');

    case UPLOAD_ERR_NO_TMP_DIR:
    case UPLOAD_ERR_CANT_WRITE:
    case UPLOAD_ERR_EXTENSION:
        return t('Internal error. You may not succeed in retrying. ');
    }
    return t('Unknown error. ');
}

/** Remove link and it's file
 * @param $link the link's name (hash)
 */

function
jirafeau_delete_link ($link)
{
    $l = jirafeau_get_link ($link);
    if (!count ($l))
        return;

    jirafeau_clean_rm_link ($link);

    $md5 = $l['md5'];
    $p = s2p ("$md5");

    $counter = 1;
    if (file_exists (VAR_FILES . $p . $md5. '_count'))
    {
        $content = file (VAR_FILES . $p . $md5. '_count');
        $counter = trim ($content[0]);
    }
    $counter--;

    if ($counter >= 1)
    {
        $handle = fopen (VAR_FILES . $p . $md5. '_count', 'w');
        fwrite ($handle, $counter);
        fclose ($handle);
    }

    if ($counter == 0)
        jirafeau_clean_rm_file ($md5);
}

/**
 * Delete a file and it's links.
 */
function
jirafeau_delete_file ($md5)
{
    $count = 0;
    /* Get all links files. */
    $stack = array (VAR_LINKS);
    while (($d = array_shift ($stack)) && $d != NULL)
    {
        $dir = scandir ($d);

        foreach ($dir as $node)
        {
            if (strcmp ($node, '.') == 0 || strcmp ($node, '..') == 0 ||
                preg_match ('/\.tmp/i', "$node"))
                continue;
            
            if (is_dir ($d . $node))
            {
                /* Push new found directory. */
                $stack[] = $d . $node . '/';
            }
            elseif (is_file ($d . $node))
            {
                /* Read link informations. */
                $l = jirafeau_get_link (basename ($node));
                if (!count ($l))
                    continue;
                if ($l['md5'] == $md5)
                {
                    $count++;
                    jirafeau_delete_link ($node);
                }   
            }
        }
    }
    jirafeau_clean_rm_file ($md5);
    return $count;
}

/**
 * handles an uploaded file
 * @param $file the file struct given by $_FILE[]
 * @param $one_time_download is the file a one time download ?
 * @param $key if not empty, protect the file with this key
 * @param $time the time of validity of the file
 * @param $ip uploader's ip
 * @param $crypt boolean asking to crypt or not
 * @param $link_name_length size of the link name
 * @returns an array containing some information
 *   'error' => information on possible errors
 *   'link' => the link name of the uploaded file
 *   'delete_link' => the link code to delete file
 */
function
jirafeau_upload ($file, $one_time_download, $key, $time, $ip, $crypt, $link_name_length)
{
    if (empty ($file['tmp_name']) || !is_uploaded_file ($file['tmp_name']))
    {
        return (array(
                 'error' =>
                   array ('has_error' => true,
                          'why' => jirafeau_upload_errstr ($file['error'])),
                 'link' => '',
                 'delete_link' => ''));
    }

    /* array representing no error */
    $noerr = array ('has_error' => false, 'why' => '');

    /* Crypt file if option is enabled. */
    $crypted = false;
    $crypt_key = '';
    if ($crypt == true && !(extension_loaded('mcrypt') == true))
        error_log ("PHP extension mcrypt not loaded, won't encrypt in Jirafeau");
    if ($crypt == true && extension_loaded('mcrypt') == true)
    {
        $crypt_key = jirafeau_encrypt_file ($file['tmp_name'], $file['tmp_name']);
        if (strlen($crypt_key) > 0)
            $crypted = true;
    }

    /* file informations */
    $md5 = md5_file ($file['tmp_name']);
    $name = str_replace (NL, '', trim ($file['name']));
    $mime_type = $file['type'];
    $size = $file['size'];

    /* does file already exist ? */
    $rc = false;
    $p = s2p ("$md5");
    if (file_exists (VAR_FILES . $p .  $md5))
    {
        $rc = unlink ($file['tmp_name']);
    }
    elseif ((file_exists (VAR_FILES . $p) || @mkdir (VAR_FILES . $p, 0755, true))
            && move_uploaded_file ($file['tmp_name'], VAR_FILES . $p . $md5))
    {
        $rc = true;
    }
    if (!$rc)
    {
        return (array(
                 'error' =>
                   array ('has_error' => true,
                          'why' => t('Internal error during file creation.')),
                 'link' =>'',
                 'delete_link' => ''));
    }

    /* Increment or create count file. */
    $counter = 0;
    if (file_exists (VAR_FILES . $p . $md5 . '_count'))
    {
        $content = file (VAR_FILES . $p . $md5. '_count');
        $counter = trim ($content[0]);
    }
    $counter++;
    $handle = fopen (VAR_FILES . $p . $md5. '_count', 'w');
    fwrite ($handle, $counter);
    fclose ($handle);

    /* Create delete code. */
    $delete_link_code = jirafeau_gen_random (5);

    /* md5 password or empty. */
    $password = '';
    if (!empty ($key))
        $password = md5 ($key);

    /* create link file */
    $link_tmp_name =  VAR_LINKS . $md5 . rand (0, 10000) . '.tmp';
    $handle = fopen ($link_tmp_name, 'w');
    fwrite ($handle,
            $name . NL. $mime_type . NL. $size . NL. $password . NL. $time .
            NL . $md5. NL . ($one_time_download ? 'O' : 'R') . NL . date ('U') .
            NL . $ip . NL. $delete_link_code . NL . ($crypted ? 'C' : 'O'));
    fclose ($handle);
    $md5_link = substr(base_16_to_64 (md5_file ($link_tmp_name)), 0, $link_name_length);
    $l = s2p ("$md5_link");
    if (!@mkdir (VAR_LINKS . $l, 0755, true) ||
        !rename ($link_tmp_name,  VAR_LINKS . $l . $md5_link))
    {
        if (file_exists ($link_tmp_name))
            unlink ($link_tmp_name);
        
        $counter--;
        if ($counter >= 1)
        {
            $handle = fopen (VAR_FILES . $p . $md5. '_count', 'w');
            fwrite ($handle, $counter);
            fclose ($handle);
        }
        else
        {
            jirafeau_clean_rm_file ($md5_link);
        }
        return array(
                 'error' =>
                   array ('has_error' => true,
                          'why' => t('Internal error during file creation. ')),
                 'link' =>'',
                 'delete_link' => '');
    }
   return array ( 'error' => $noerr,
                  'link' => $md5_link,
                  'delete_link' => $delete_link_code,
                  'crypt_key' => $crypt_key);
}

/**
 * Tells if a mime-type is viewable in a browser
 * @param $mime the mime type
 * @returns a boolean telling if a mime type is viewable
 */
function
jirafeau_is_viewable ($mime)
{
    if (!empty ($mime))
    {
        /* Actually, verify if mime-type is an image or a text. */
        $viewable = array ('image', 'text', 'video', 'audio');
        $decomposed = explode ('/', $mime);
        return in_array ($decomposed[0], $viewable);
    }
    return false;
}

// Error handling functions.
//! Global array that contains all registered errors.
$error_list = array ();

/**
 * Adds an error to the list of errors.
 * @param $title the error's title
 * @param $description is a human-friendly description of the problem.
 */
function
add_error ($title, $description)
{
    global $error_list;
    $error_list[] = '<p>' . $title. '<br />' . $description. '</p>';
}

/**
 * Informs whether any error has been registered yet.
 * @return true if there are errors.
 */
function
has_error ()
{
    global $error_list;
    return !empty ($error_list);
}

/**
 * Displays all the errors.
 */
function
show_errors ()
{
    if (has_error ())
    {
        global $error_list;
        echo '<div class="error">';
        foreach ($error_list as $error)
        {
            echo $error;
        }
        echo '</div>';
    }
}

function check_errors ($cfg)
{
    if (file_exists (JIRAFEAU_ROOT . 'install.php')
        && !($cfg['installation_done'] === true))
    {
        header('Location: install.php'); 
        exit;
    }

    /* check if the destination dirs are writable */
    $writable = is_writable (VAR_FILES) && is_writable (VAR_LINKS);

    /* Checking for errors. */
    if (!is_writable (VAR_FILES))
        add_error (t('The file directory is not writable!'), VAR_FILES);

    if (!is_writable (VAR_LINKS))
        add_error (t('The link directory is not writable!'), VAR_LINKS);
    
    if (!is_writable (VAR_ASYNC))
        add_error (t('The async directory is not writable!'), VAR_ASYNC);
}

/**
 * Read link informations
 * @return array containing informations.
 */
function
jirafeau_get_link ($hash)
{
    $out = array ();
    $link = VAR_LINKS . s2p ("$hash") . $hash;

    if (!file_exists ($link))
        return $out;
    
    $c = file ($link);
    $out['file_name'] = trim ($c[0]);
    $out['mime_type'] = trim ($c[1]);
    $out['file_size'] = trim ($c[2]);
    $out['key'] = trim ($c[3], NL);
    $out['time'] = trim ($c[4]);
    $out['md5'] = trim ($c[5]);
    $out['onetime'] = trim ($c[6]);
    $out['upload_date'] = trim ($c[7]);
    $out['ip'] = trim ($c[8]);
    $out['link_code'] = trim ($c[9]);
    $out['crypted'] = trim ($c[10]) == 'C';
    $out['hash_code'] = $hash;
    
    return $out;
}

/**
 * List files in admin interface.
 */
function
jirafeau_admin_list ($name, $file_hash, $link_hash)
{
	
    echo '<fieldset><legend>';
    if (!empty ($name))
        echo t('Filename') . ": $name ";
    if (!empty ($file_hash))
        echo t('file') . ": $file_hash ";
    if (!empty ($link_hash))
        echo t('link') . ": $link_hash ";
    if (empty ($name) && empty ($file_hash) && empty ($link_hash))
        echo t('List all files');
    echo '</legend>';
    echo '<table>';
    echo '<tr>';
    echo '<td>' . t('Filename') . '</td>';
    echo '<td>' . t('Type') . '</td>';
    echo '<td>' . t('Size') . '</td>';
    echo '<td>' . t('Expire') . '</td>';
    echo '<td>' . t('Onetime') . '</td>';
    echo '<td>' . t('Upload date') . '</td>';
    echo '<td>' . t('Origin') . '</td>';
    echo '<td>' . t('Action') . '</td>';
    echo '</tr>';

    /* Get all links files. */
    $stack = array (VAR_LINKS);
    while (($d = array_shift ($stack)) && $d != NULL)
    {
        $dir = scandir ($d);
        foreach ($dir as $node)
        {
            if (strcmp ($node, '.') == 0 || strcmp ($node, '..') == 0 ||
                preg_match ('/\.tmp/i', "$node"))
                continue;
            if (is_dir ($d . $node))
            {
                /* Push new found directory. */
                $stack[] = $d . $node . '/';
            }
            elseif (is_file ($d . $node))
            {
                /* Read link informations. */
                $l = jirafeau_get_link ($node);
                if (!count ($l))
                    continue;

                /* Filter. */
                if (!empty ($name) && !preg_match ("/$name/i", htmlspecialchars($l['file_name'])))
                    continue;
                if (!empty ($file_hash) && $file_hash != $l['md5'])
                    continue;
                if (!empty ($link_hash) && $link_hash != $node)
                    continue;
                /* Print link informations. */
                echo '<tr>';
                echo '<td>' .
                '<form action = "admin.php" method = "post">' .
                '<input type = "hidden" name = "action" value = "download"/>' .
                '<input type = "hidden" name = "link" value = "' . $node . '"/>' .
                '<input type = "submit" value = "' . htmlspecialchars($l['file_name']) . '" />' .
                '</form>';
                echo '</td>';
                echo '<td>' . $l['mime_type'] . '</td>';
                echo '<td>' . jirafeau_human_size ($l['file_size']) . '</td>';
                echo '<td>' . ($l['time'] == -1 ? '' : strftime ('%c', $l['time'])) .
                     '</td>';
                echo '<td>';
                if ($l['onetime'] == 'O')
                    echo 'Y';
                else
                    echo 'N';
                echo '</td>';
                echo '<td>' . strftime ('%c', $l['upload_date']) . '</td>';
                echo '<td>' . $l['ip'] . '</td>';
                echo '<td>' .
                '<form action = "admin.php" method = "post">' .
                '<input type = "hidden" name = "action" value = "delete_link"/>' .
                '<input type = "hidden" name = "link" value = "' . $node . '"/>' .
                '<input type = "submit" value = "' . t('Del link') . '" />' .
                '</form>' .
                '<form action = "admin.php" method = "post">' .
                '<input type = "hidden" name = "action" value = "delete_file"/>' .
                '<input type = "hidden" name = "md5" value = "' . $l['md5'] . '"/>' .
                '<input type = "submit" value = "' . t('Del file and links') . '" />' .
                '</form>' .
                '</td>';
                echo '</tr>';
            }
        }
    }
    echo '</table></fieldset>';
}






function
jirafeau_admin_list_custom ($name, $file_hash, $link_hash,$action, $action_list=null, $order_by=null  )
{
	global $cfg;
	//echo '$order_by:-'.$order_by;
	if($order_by ==null){
		$order_by = 'desc';
	 }
   elseif($order_by =='desc'){
	 $order_by = 'asc';
	}
	elseif($order_by =='asc'){
	 $order_by = 'desc';
	}

    /* Get all links files. */
    $stack = array (VAR_LINKS);
	
	$all_list = array(); 
    while (($d = array_shift ($stack)) && $d != NULL)
    {
        $dir = scandir ($d);
        foreach ($dir as $node)
        {
            if (strcmp ($node, '.') == 0 || strcmp ($node, '..') == 0 ||
                preg_match ('/\.tmp/i', "$node"))
                continue;
            if (is_dir ($d . $node))
            {
                /* Push new found directory. */
                $stack[] = $d . $node . '/';
            }
            elseif (is_file ($d . $node))
            {
                /* Read link informations. */
                $l = jirafeau_get_link ($node);
                if (!count ($l))
                    continue;

                /* Filter. */
                if (!empty ($name) && !preg_match ("/$name/i", htmlspecialchars($l['file_name'])))
                    continue;
                if (!empty ($file_hash) && $file_hash != $l['md5'])
                    continue;
                if (!empty ($link_hash) && $link_hash != $node)
                    continue;
                /* Print link informations. */              
                $all_list[]= $node;             
                
            }
        }
    }
   
// General Tab

   //print_r($all_list); //Pagination
	       $adjacents = 3;			   
		    $total_pages = count( $all_list );			
		   $targetpage = "admin.php"; 	//your file name  (the name of this file)
		   $limit = 10; 	//how many items to show per page
			if(isset($_GET['page']))
			{
				$_GET['page'] = $_GET['page'];
			}else{
				$_GET['page'] = 0;
			}
			$page = $_GET['page'];
			if($page){ 
				$start = ($page - 1) * $limit; 			//first item to display on this page
			}
			else{
				$start = 0;
			}
			$offset = $start;
			if( $offset < 0 ) $offset = 0;

			if($action_list !=null){

				$all_lists = array_slice( $all_list, 0, $action_list );
			}else{	

				 $all_lists = array_slice( $all_list, $offset, $limit );
			}


?>
	 <div class="ad_list_wrapper" id="ad_list_wrapper" style="border: 1px solid;">
	 
		  <div class="ad_single_cover" style="background:#ccc; margin-bottom:10px;">
		  
		      <div class="ad_file_name"> Filename  </div>			  
		      <div class="ad_file_type">Type </div>
			  
		      <div class="ad_file_size">
			   <form action = "admin.php" method = "get">
                   <input type = "hidden" name = "action" value = "order_by_val"/>				  
                   <input type = "hidden" name = "order_by" value ="<?php echo $order_by;?>"/>				  
                   <input type = "submit" class="style_none size_bn_<?php echo $order_by;?>" value = "Size"  title="<?php echo t('Size'); ?> "/>
				</form>	
			  </div>
			   
			   
		      <div class="ad_file_exp">Expiration</div>			  
		      <div class="ad_file_once">Once</div>
			  <div class="ad_file_date">Date</div>
		      <div class="ad_file_ip">IP</div>
			  <div class="ad_file_action">Action	  </div>		  
		  </div>
	 
  <?php 
	 if(!empty($all_lists)){ 
	   for($i = 0; $i< count($all_lists); $i++){
		  $file_ds[] =  jirafeau_get_link ($all_lists[$i]);
	   }
	   foreach ($file_ds as $key => $row) {
            $size[$key] = $row["file_size"];
        }
	   array_multisort($size, SORT_DESC, $file_ds);
	  
	   if ($order_by == 'asc') {
            array_multisort($size, SORT_ASC, $file_ds);
			
        } elseif ($order_by == 'desc') {
           array_multisort($size, SORT_DESC, $file_ds);
        }		
		else {
           array_multisort($size, SORT_DESC, $file_ds);
        }
	   
	 
	   foreach($file_ds as $file_d){
		  //$file_d =  jirafeau_get_link ($all_list[$i]);
		   //echo $file_d['file_name']."    ";.
		  ?>
		  <div class="ad_single_cover" style="background:#ccc; margin-bottom:10px;">
		  <a title="<?php echo t('Download'); ?>" target="_blank" href="<?php echo $cfg['web_root'].'f.php?h='.$file_d['hash_code'];?>">
		      <div class="ad_file_name"> 
			<?php echo  htmlspecialchars($file_d['file_name'])?>
			  </div>
			</a> 
		      <div class="ad_file_type"><?php echo $file_d['mime_type']?> </div>
		      <div class="ad_file_size"> <?php echo jirafeau_human_size($file_d['file_size']);?></div>
			 
			  <?php //$date = new DateTime();
			       //$date->setTimestamp($file_d['time']);
                   //echo $date->format('D M d H:i:s Y');				   
			   ?>
		       <div class="ad_file_exp"><?php echo date("D M d H:i:s Y", $file_d['time']); ?></div>
			  <?php
			   if($file_d['onetime'] == 'O')
                    $once = 'Once';
                else
                    $once = 'NO';
				?>
				
		      <div class="ad_file_once"><?php echo $once;?></div>
			  
			  <?php //$date1 = new DateTime();
			       //$date1->setTimestamp($file_d['upload_date']);
				   //echo $date1->format('D M d H:i:s Y');	
			   ?>
		     
		      <div class="ad_file_date"><?php echo date("D M d H:i:s Y", $file_d['upload_date']); ?></div>
		      <div class="ad_file_ip"><?php echo $file_d['ip'];?></div>
			  
		       <div class="ad_file_action">
			    <div class="ad_file_act_sh">
					<form action = "admin.php" method = "post">
							<input type = "hidden" name = "action" value = "delete_link"/>
							<input type = "hidden" name = "link" value = "<?php echo $file_d['hash_code']; ?>"/>
							<input type = "submit" value = "<?php echo t('Del link')?>" title="<?php echo t('Delete link'); ?>" />
					</form>
				</div>
				<div class="ad_file_act_del">
					 <form action = "admin.php" method = "post">
						 <input type = "hidden" name = "action" value = "delete_file"/>
						 <input type = "hidden" name = "md5" value = "<?php echo $file_d['md5']?>"/>
						 <input type = "submit" value = "<?php echo t('Del file and links')?>" title="<?php echo t('Delete file and links'); ?>" />
					</form>
			    </div>
			  </div>
		  
		  </div>
		 
		  <?php
	     }//foreach close
	   }//Not empty
	   else{
		   echo '<div class="not_record">No record found!</div>';
	   }
	   ?>
	   
	  </div><?php //ad_list_wrapper?>
	  
	 
	  <!--- Pagination-->
	  <?php
	  /* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;				//next page is page + 1
		$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;	
					
		$pagination = "";
			if($lastpage > 1)
			{	
				$pagination .= "<div class=\"pagination\">";
				//previous button
				/*if ($page > 1) 
					$pagination.= "<a href=\"admin.php?page=$prev\">Â« previous</a>";
				else
					$pagination.= "<span class=\"disabled\">Â« previous</span>";	
				*/
				//pages	
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"admin.php?page=$counter\">$counter</a>";					
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"admin.php?page=$counter\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"admin.php?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"admin.php?page=$lastpage\">$lastpage</a>";		
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"admin.php?page=1\">1</a>";
						$pagination.= "<a href=\"admin.php?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"admin.php?page=$counter\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"admin.php?page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"admin.php?page=$lastpage\">$lastpage</a>";		
					}
					//close to end; only hide early pages
					else
					{
						$pagination.= "<a href=\"admin.php?page=1\">1</a>";
						$pagination.= "<a href=\"admin.php?page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"admin.php?page=$counter\">$counter</a>";					
						}
					}
				}
				
				//next button
				/*if ($page < $counter - 1) 
					$pagination.= "<a href=\"admin.php?page=$next\">next Â»</a>";
				else
					$pagination.= "<span class=\"disabled\">next Â»</span>";*/
				$pagination.= "</div>\n";		
			}
			if($action_list ==null){				
			   echo $pagination;
			}
			
	  ?>
	  <!---New Pagination-->
	  
  <?php 
	
}


/***
* Save settings in config file 
*/
function
jirafeau_quoted1 ($str)
{
    //return QUOTE . str_replace (QUOTE, "\'", $str) . QUOTE;
    return "'$str'";
	
}
function
jirafeau_export_cfg_custom ($cfg)
{
	
	
    $handle = fopen ($cfg['JIRAFEAU_CFG1'], 'w');
    fwrite ($handle, '<?php' . NL);
    fwrite ($handle,
            '/* ' .
            t ('This file was generated by the install process. ' .
               'You can edit it. Please see config.original.php to understand the ' .
               'configuration items.') . ' */' . NL);
    foreach ($cfg as $key => $item)
    {
        fwrite ($handle, '$cfg[' . jirafeau_quoted1 ($key) . '] = ');
        if (is_bool ($item))
            fwrite ($handle, ($item ? 'true' : 'false'));
        else if (is_string ($item))
            fwrite ($handle, jirafeau_quoted1 ($item));
        else if (is_int ($item))
            fwrite ($handle, $item);
        else if (is_array ($item))
            fwrite ($handle, str_replace(array("\n", "\r"), "",
                                         var_export ($item, true)));
        else
            fwrite ($handle, 'null');
        fwrite ($handle, ';'.NL);
    }
    /* No newline at the end of the file to be able to send headers. */
    fwrite ($handle, '?>');
    fclose ($handle);
}




/**
 * Clean expired files.
 * @return number of cleaned files.
 */
function
jirafeau_admin_clean ()
{
    $count = 0;
    /* Get all links files. */
    $stack = array (VAR_LINKS);
    while (($d = array_shift ($stack)) && $d != NULL)
    {
        $dir = scandir ($d);

        foreach ($dir as $node)
        {
            if (strcmp ($node, '.') == 0 || strcmp ($node, '..') == 0 ||
                preg_match ('/\.tmp/i', "$node"))
                continue;
            
            if (is_dir ($d . $node))
            {
                /* Push new found directory. */
                $stack[] = $d . $node . '/';
            }
            elseif (is_file ($d . $node))
            {
                /* Read link informations. */
                $l = jirafeau_get_link (basename ($node));
                if (!count ($l))
                    continue;
                $p = s2p ($l['md5']);
                if ($l['time'] > 0 && $l['time'] < time () || // expired
                    !file_exists (VAR_FILES . $p . $l['md5']) || // invalid
                    !file_exists (VAR_FILES . $p . $l['md5'] . '_count')) // invalid
                {
                    jirafeau_delete_link ($node);
                    $count++;
                }
            }
        }
    }
    return $count;
}


/**
 * Clean old async transferts.
 * @return number of cleaned files.
 */
function
jirafeau_admin_clean_async ()
{
    $count = 0;
    /* Get all links files. */
    $stack = array (VAR_ASYNC);
    while (($d = array_shift ($stack)) && $d != NULL)
    {
        $dir = scandir ($d);

        foreach ($dir as $node)
        {
            if (strcmp ($node, '.') == 0 || strcmp ($node, '..') == 0 ||
                preg_match ('/\.tmp/i', "$node"))
                continue;
            
            if (is_dir ($d . $node))
            {
                /* Push new found directory. */
                $stack[] = $d . $node . '/';
            }
            elseif (is_file ($d . $node))
            {
                /* Read async informations. */
                $a = jirafeau_get_async_ref (basename ($node));
                if (!count ($a))
                    continue;
                /* Delete transferts older than 1 hour. */
                if (date ('U') - $a['last_edited'] > 3600)
                {
                    jirafeau_async_delete (basename ($node));
                    $count++;
                }
            }
        }
    }
    return $count;
}
/**
 * Read async transfert informations
 * @return array containing informations.
 */
function
jirafeau_get_async_ref ($ref)
{
    $out = array ();
    $refinfos = VAR_ASYNC . s2p ("$ref") . "$ref";

    if (!file_exists ($refinfos))
        return $out;
    
    $c = file ($refinfos);
    $out['file_name'] = trim ($c[0]);
    $out['mime_type'] = trim ($c[1]);
    $out['key'] = trim ($c[2], NL);
    $out['time'] = trim ($c[3]);
    $out['onetime'] = trim ($c[4]);
    $out['ip'] = trim ($c[5]);
    $out['last_edited'] = trim ($c[6]);
    $out['next_code'] = trim ($c[7]);
    return $out;
}

/**
 * Delete async transfert informations
 */
function
jirafeau_async_delete ($ref)
{
    $p = s2p ("$ref");
    if (file_exists (VAR_ASYNC . $p . $ref))
        unlink (VAR_ASYNC . $p . $ref);
    if (file_exists (VAR_ASYNC . $p . $ref . '_data'))
        unlink (VAR_ASYNC . $p . $ref . '_data');
    $parse = VAR_ASYNC . $p;
    $scan = array();
    while (file_exists ($parse)
           && ($scan = scandir ($parse))
           && count ($scan) == 2 // '.' and '..' folders => empty.
           && basename ($parse) != basename (VAR_ASYNC)) 
    {
        rmdir ($parse);
        $parse = substr ($parse, 0, strlen($parse) - strlen(basename ($parse)) - 1);
    }
}

/**
  * Init a new asynchronous upload.
  * @param $finename Name of the file to send
  * @param $one_time One time upload parameter
  * @param $key eventual password (or blank)
  * @param $time time limit
  * @param $ip ip address of the client
  * @return a string containing a temporary reference followed by a code or the string 'Error'
  */
function
jirafeau_async_init ($filename, $type, $one_time, $key, $time, $ip)
{
    $res = 'Error';

    /* Create temporary folder. */
    $ref;
    $p;
    $code = jirafeau_gen_random (4);
    do
    {
        $ref = jirafeau_gen_random (32);
        $p = VAR_ASYNC . s2p ($ref);
    } while (file_exists ($p));
    @mkdir ($p, 0755, true);
    if (!file_exists ($p))
    {
        echo 'Error';
        return;
    }
    
    /* md5 password or empty */
    $password = '';
    if (!empty ($key))
        $password = md5 ($key);

    /* Store informations. */
    $p .= $ref;
    $handle = fopen ($p, 'w');
    fwrite ($handle,
            str_replace (NL, '', trim ($filename)) . NL .
            str_replace (NL, '', trim ($type)) . NL . $password . NL .
            $time . NL . ($one_time ? 'O' : 'R') . NL . $ip . NL .
            date ('U') . NL . $code . NL);
    fclose ($handle);

    return $ref . NL . $code ;
}

/**
  * Append a piece of file on the asynchronous upload.
  * @param $ref asynchronous upload reference
  * @param $file piece of data
  * @param $code client code for this operation
  * @param $max_file_size maximum allowed file size
  * @return a string containing a next code to use or the string "Error"
  */
function
jirafeau_async_push ($ref, $data, $code, $max_file_size)
{
    /* Get async infos. */
    $a = jirafeau_get_async_ref ($ref);
    
    /* Check some errors. */
    if (count ($a) == 0
        || $a['next_code'] != "$code"
        || empty ($data['tmp_name'])
        || !is_uploaded_file ($data['tmp_name']))
        return 'Error';
    
    $p = s2p ($ref);

    /* File path. */
    $r_path = $data['tmp_name'];
    $w_path = VAR_ASYNC . $p . $ref . '_data';

    /* Check that file size is not above upload limit. */
    if ($max_file_size > 0 &&
        filesize ($r_path) + filesize ($w_path) > $max_file_size * 1024 * 1024)
    {
        jirafeau_async_delete ($ref);
        return 'Error';
    }

    /* Concatenate data. */
    $r = fopen ($r_path, 'r');
    $w = fopen ($w_path, 'a');
    while (!feof ($r))
    {
        if (fwrite ($w, fread ($r, 1024)) === false)
        {
            fclose ($r);
            fclose ($w);
            jirafeau_async_delete ($ref);
            return 'Error';
        }
    }
    fclose ($r);
    fclose ($w);
    unlink ($r_path);
    
    /* Update async file. */
    $code = jirafeau_gen_random (4);
    $handle = fopen (VAR_ASYNC . $p . $ref, 'w');
    fwrite ($handle,
            $a['file_name'] . NL. $a['mime_type'] . NL. $a['key'] . NL .
            $a['time'] . NL . $a['onetime'] . NL . $a['ip'] . NL .
            date ('U') . NL . $code . NL);
    fclose ($handle);
    return $code;
}

/**
  * Finalyze an asynchronous upload.
  * @param $ref asynchronous upload reference
  * @param $code client code for this operation
  * @param $crypt boolean asking to crypt or not
  * @param $link_name_length link name length
  * @return a string containing the download reference followed by a delete code or the string 'Error'
  */
function
jirafeau_async_end ($ref, $code, $crypt, $link_name_length)
{
    /* Get async infos. */
    $a = jirafeau_get_async_ref ($ref);
    if (count ($a) == 0)
        return "Error";
    
    /* Generate link infos. */
    $p = VAR_ASYNC . s2p ($ref) . $ref . "_data";
    if (!file_exists($p))
        return 'Error';

    $crypted = false;
    $crypt_key = '';
    if ($crypt == true && extension_loaded('mcrypt') == true)
    {
        $crypt_key = jirafeau_encrypt_file ($p, $p);
        if (strlen($crypt_key) > 0)
            $crypted = true;
    }

    $md5 = md5_file ($p);
    $size = filesize($p);
    $np = s2p ($md5);
    $delete_link_code = jirafeau_gen_random (5);
    
    /* File already exist ? */ 
    if (!file_exists (VAR_FILES . $np))
        @mkdir (VAR_FILES . $np, 0755, true);
    if (!file_exists (VAR_FILES . $np . $md5))
        rename ($p, VAR_FILES . $np . $md5);
    
    /* Increment or create count file. */
    $counter = 0;
    if (file_exists (VAR_FILES . $np . $md5 . '_count'))
    {
        $content = file (VAR_FILES . $np . $md5. '_count');
        $counter = trim ($content[0]);
    }
    $counter++;
    $handle = fopen (VAR_FILES . $np . $md5. '_count', 'w');
    fwrite ($handle, $counter);
    fclose ($handle);
    
    /* Create link. */
    $link_tmp_name =  VAR_LINKS . $md5 . rand (0, 10000) . '.tmp';
    $handle = fopen ($link_tmp_name, 'w');
    fwrite ($handle,
            $a['file_name'] . NL . $a['mime_type'] . NL . $size . NL .
            $a['key'] . NL . $a['time'] . NL . $md5 . NL . $a['onetime'] . NL .
            date ('U') . NL . $a['ip'] . NL . $delete_link_code . NL . ($crypted ? 'C' : 'O'));
    fclose ($handle);
    $md5_link = substr(base_16_to_64 (md5_file ($link_tmp_name)), 0, $link_name_length);
    $l = s2p ("$md5_link");
    if (!@mkdir (VAR_LINKS . $l, 0755, true) ||
        !rename ($link_tmp_name,  VAR_LINKS . $l . $md5_link))
        echo "Error";
    
    /* Clean async upload. */
    jirafeau_async_delete ($ref);
    return $md5_link . " " . $delete_link_code . " " . urlencode($crypt_key);
}


function
jirafeau_crypt_create_iv($base, $size)
{
    $iv = '';
    while (strlen ($iv) < $size)
        $iv = $iv . $base;
    $iv = substr($iv, 0, $size);
    return $iv;
}

/**
 * Crypt file and returns decrypt key.
 * @param $fp_src file path to the file to crypt.
 * @param $fp_dst file path to the file to write crypted file (could be the same).
 * @return decrypt key composed of the key and the iv separated by a point ('.')
 */
function
jirafeau_encrypt_file ($fp_src, $fp_dst)
{
    $fs = filesize ($fp_src);
    if ($fs === false || $fs == 0 || !(extension_loaded('mcrypt') == true))
        return '';

    /* Prepare module. */
    $m = mcrypt_module_open('rijndael-256', '', 'ofb', '');
    /* Generate key. */
    $crypt_key = jirafeau_gen_random (10);
    $md5_key = md5($crypt_key);
    $iv = jirafeau_crypt_create_iv ($md5_key, mcrypt_enc_get_iv_size($m));
    /* Init module. */
    mcrypt_generic_init($m, $md5_key, $iv);
    /* Crypt file. */
    $r = fopen ($fp_src, 'r');
    $w = fopen ($fp_dst, 'c');
    while (!feof ($r))
    {
        $enc = mcrypt_generic($m, fread ($r, 1024));
        if (fwrite ($w, $enc) === false)
            return '';
    }
    fclose ($r);
    fclose ($w);
    /* Cleanup. */
    mcrypt_generic_deinit($m);
    mcrypt_module_close($m);
    return $crypt_key;
}

/**
 * Decrypt file.
 * @param $fp_src file path to the file to decrypt.
 * @param $fp_dst file path to the file to write decrypted file (could be the same).
 * @param $k string composed of the key and the iv separated by a point ('.')
 * @return key used to decrypt. a string of length 0 is returned if failed.
 */
function
jirafeau_decrypt_file ($fp_src, $fp_dst, $k)
{
    $fs = filesize ($fp_src);
    if ($fs === false || $fs == 0 || extension_loaded('mcrypt') == false)
        return false;

    /* Init module */
    $m = mcrypt_module_open('rijndael-256', '', 'ofb', '');
    /* Extract key and iv. */
    $crypt_key = $k;
    $md5_key = md5($crypt_key);
    $iv = jirafeau_crypt_create_iv ($md5_key, mcrypt_enc_get_iv_size($m));
    /* Decrypt file. */
    $r = fopen ($fp_src, 'r');
    $w = fopen ($fp_dst, 'c');
    while (!feof ($r))
    {
        $dec = mdecrypt_generic($m, fread ($r, 1024));
        if (fwrite ($w, $dec) === false)
            return false;
    }
    fclose ($r);
    fclose ($w);
    /* Cleanup. */
    mcrypt_generic_deinit($m);
    mcrypt_module_close($m);
    return true;
}

/**
 * Check if Jirafeau is password protected for visitors.
 * @return true if Jirafeau is password protected, false otherwise.
 */
function
jirafeau_has_upload_password ($cfg)
{
    return count ($cfg['upload_password']) > 0;
}

/**
 * Challenge password for a visitor.
 * @param $password password to be challenged
 * @return true if password is valid, false otherwise.
 */
function
jirafeau_challenge_upload_password ($cfg, $password)
{
    if (!jirafeau_has_upload_password($cfg))
        return false;
    forEach ($cfg['upload_password'] as $p)
        if ($password == $p)
            return true;
    return false;
}

/**
 * Test if visitor's IP is authorized to upload.
 * @param $ip IP to be challenged
 * @return true if IP is authorized, false otherwise.
 */
function
jirafeau_challenge_upload_ip ($cfg, $ip)
{
    if (count ($cfg['upload_ip']) == 0)
        return true;
    forEach ($cfg['upload_ip'] as $i)
    {
        if ($i == $ip)
            return true;
        // CIDR test for IPv4 only.
        if (strpos ($i, '/') !== false)
        {
            list ($subnet, $mask) = explode('/', $i);
            if ((ip2long ($ip) & ~((1 << (32 - $mask)) - 1) ) == ip2long ($subnet))
                return true;
        }
    }
    return false;
}

/** Tell if we have some HTTP headers generated by a proxy */
function
has_http_forwarded()
{
    return
        !empty ($_SERVER['HTTP_X_FORWARDED_FOR']) ||
        !empty ($_SERVER['http_X_forwarded_for']);
}

/**
 * Generate IP list from HTTP headers generated by a proxy
 * @return  array of IP strings
 */
function
get_ip_list_http_forwarded()
{
    $ip_list = array();
    if (!empty ($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $l = explode (',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($l === FALSE)
            return array();
        foreach ($l as $ip)
            array_push ($ip_list, preg_replace ('/\s+/', '', $ip));
    }
    if (!empty ($_SERVER['http_X_forwarded_for']))
    {
        $l = explode (',', $_SERVER['http_X_forwarded_for']);
        foreach ($l as $ip)
        {
            // Separate IP from port
            $ipa = explode (':', $ip);
            if ($ipa === FALSE)
                continue;
            $ip = $ipa[0];
            array_push ($ip_list, preg_replace ('/\s+/', '', $ip));
        }
    }
    return $ip_list;
}

/**
 * Get the ip address of the client from REMOTE_ADDR
 * or from HTTP_X_FORWARDED_FOR if behind a proxy
 * @returns the client ip address
 */
function
get_ip_address($cfg)
{
    $remote = $_SERVER['REMOTE_ADDR'];
    if (count ($cfg['proxy_ip']) == 0 || !has_http_forwarded ())
        return $remote;

    $ip_list = get_ip_list_http_forwarded ();
    if (count ($ip_list) == 0)
        return $remote;

    foreach ($cfg['proxy_ip'] as $proxy_ip)
    {
        if ($remote != $proxy_ip)
            continue;
        // Take the last IP (the one which has been set by the defined proxy).
        return end ($ip_list);
    }
    return $remote;
}

/**
 * Convert hexadecimal string to base64
 */
function hex_to_base64($hex)
{
    $b = '';
    foreach (str_split ($hex, 2) as $pair)
        $b .= chr (hexdec ($pair));
    return base64_encode ($b);
}

/**
 * Read alias informations
 * @return array containing informations.
 */
function
jirafeau_get_alias ($hash)
{
    $out = array ();
    $link = VAR_ALIAS . s2p ("$hash") . $hash;

    if (!file_exists ($link))
        return $out;
    
    $c = file ($link);
    $out['md5_password'] = trim ($c[0]);
    $out['ip'] = trim ($c[1]);
    $out['update_date'] = trim ($c[2]);
    $out['destination'] = trim ($c[3], NL);
   
    return $out;
}

/** Create an alias to a jirafeau's link.
 * @param $alias alias name
 * @param $destination reference of the destination
 * @param $password password to protect alias
 * @param $ip client's IP
 * @return  a string containing the edit code of the alias or the string "Error"
 */
function
jirafeau_alias_create ($alias, $destination, $password, $ip)
{
    /* Check that alias and password are long enough. */
    if (strlen ($alias) < 8 ||
        strlen ($alias) > 32 ||
        strlen ($password) < 8 ||
        strlen ($password) > 32)
        return 'Error';

    /* Check that destination exists. */
    $l = jirafeau_get_link ($destination);
    if (!count ($l))
        return 'Error';

    /* Check that alias does not already exists. */
    $alias = md5 ($alias);
    $p = VAR_ALIAS . s2p ($alias);
    if (file_exists ($p))
        return 'Error';
    
    /* Create alias folder. */
    @mkdir ($p, 0755, true);
    if (!file_exists ($p))
        return 'Error';
    
    /* Generate password. */
    $md5_password = md5 ($password);

    /* Store informations. */
    $p .= $alias;
    $handle = fopen ($p, 'w');
    fwrite ($handle,
            $md5_password . NL .
            $ip . NL .
            date ('U') . NL .
            $destination . NL);
    fclose ($handle);

    return 'Ok';
}

/** Update an alias.
 * @param $alias alias to update
 * @param $destination reference of the new destination
 * @param $password password to protect alias
 * @param $new_password optional new password to protect alias
 * @param $ip client's IP
 * @return "Ok" or "Error" string
 */
function
jirafeau_alias_update ($alias, $destination, $password,
                       $new_password, $ip)
{
    $alias = md5 ($alias);
    /* Check that alias exits. */
    $a = jirafeau_get_alias ($alias);
    if (!count ($a))
        return 'Error';

    /* Check that destination exists. */
    $l = jirafeau_get_link ($a["destination"]);
    if (!count ($l))
        return 'Error';

    /* Check password. */
    if ($a["md5_password"] != md5 ($password))
        return 'Error';

    $p = $a['md5_password'];
    if (strlen ($new_password) >= 8 &&
        strlen ($new_password) <= 32)
        $p = md5 ($new_password);
    else if (strlen ($new_password) > 0)
        return 'Error';

    /* Rewrite informations. */
    $p = VAR_ALIAS . s2p ($alias) . $alias;
    $handle = fopen ($p, 'w');
    fwrite ($handle,
            $p . NL .
            $ip . NL .
            date ('U') . NL .
            $destination . NL);
    fclose ($handle);
    return 'Ok';
}

/** Get an alias.
 * @param $alias alias to get
 * @return alias destination or "Error" string
 */
function
jirafeau_alias_get ($alias)
{
    $alias = md5 ($alias);
    /* Check that alias exits. */
    $a = jirafeau_get_alias ($alias);
    if (!count ($a))
        return 'Error';

    return $a['destination'];
}

function
jirafeau_clean_rm_alias ($alias)
{
    $p = s2p ("$alias");
    if (file_exists (VAR_ALIAS . $p . $alias))
        unlink (VAR_ALIAS . $p . $alias);
    $parse = VAR_ALIAS . $p;
    $scan = array();
    while (file_exists ($parse)
           && ($scan = scandir ($parse))
           && count ($scan) == 2 // '.' and '..' folders => empty.
           && basename ($parse) != basename (VAR_ALIAS)) 
    {
        rmdir ($parse);
        $parse = substr ($parse, 0, strlen($parse) - strlen(basename ($parse)) - 1);
    }
}

/** Delete an alias.
 * @param $alias alias to delete
 * @param $password password to protect alias
 * @return "Ok" or "Error" string
 */
function
jirafeau_alias_delete ($alias, $password)
{
    $alias = md5 ($alias);
    /* Check that alias exits. */
    $a = jirafeau_get_alias ($alias);
    if (!count ($a))
        return "Error";

    /* Check password. */
    if ($a["md5_password"] != md5 ($password))
        return 'Error';

    jirafeau_clean_rm_alias ($alias);
    return 'Ok';
}


function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
/***************
function generate tiny url 
Parameter : 1 url
retun : tiny url  
*/
function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
}


function s42_remove_ending_slash ($path)
{
    //return $path . ((substr ($path, -1) == '/') ? '' : '');
	if(substr($path, -1) == '/') {
    $string = substr($path, 0, -1);
	 return $string;
    }else{
	 return	$path;
	}
}

function getToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION["token"])) {
        $token = $_SESSION['token'];
        $token_time = $_SESSION['token_time'];
    }else{
        $token = setToken();
    }
    return $token;
}

function setToken() {
    if (!isset($_SESSION)) {
        session_start();
    }    
    $token = md5(uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
    return $token;
}

function getFormToken() {
    return '<input type="hidden" name="token" value="'.setToken().'"/> ';
}

function validateToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_POST["token"])) {
        if (isset($_SESSION["token"]) && $_POST["token"] == $_SESSION["token"]) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}



