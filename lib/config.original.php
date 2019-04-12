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
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
 
/*
 * default configuration
 * if you want to change this, overwrite in a config.local.php file
 */
global $cfg;
 
/* Don't forget the ending '/' */
$cfg['web_root'] = '';
$cfg['var_root'] = '';

/* Lang choice between 'auto', 'en' and 'fr'.
 * 'auto' mode will take the user's browser informations.
 * Will take english if user's langage is not available.
 */
$cfg['lang'] = 'auto';
/* Select your style :) See media folder */
//$cfg['style'] = 'courgette';
$cfg['style'] = 'latest';
/* Propose a preview link if file type is previewable. */
$cfg['preview'] = true;
/* Encryption feature. disable it by default.
 * By enabling it, file-level deduplication won't work.
 */
$cfg['enable_crypt'] = false;
/* Split length of link refenrece. */
$cfg['link_name_length'] = 8;
/* Upload password(s). Empty array disable password authentification.
 * $cfg['upload_password'] = array();               // No password
 * $cfg['upload_password'] = array('psw1');         // One password
 * $cfg['upload_password'] = array('psw1', 'psw2'); // Two passwords
 * ... and so on
 */
$cfg['upload_password'] = array();
/* List of IP allowed to upload a file.
 * If list is empty, then there is no upload restriction based on IP
 * Elements of the list can be a single IP (e.g. "123.45.67.89") or
 * an IP range (e.g. "123.45.0.0/16").
 * Note that CIDR notation is available for IPv4 only for the moment.
 */
$cfg['upload_ip'] = array();
/* An empty admin password will disable the classic admin password
 * authentication.
 */
$cfg['admin_password'] = '';
/* If set, let's the user to be authenticated as administrator.
 * The user provided here is the user authenticated by HTTP authentication.
 * Note that s42transfer does not manage the HTTP login part, it just check
 * that the provided user is logged.
 * If admin_password parameter is also set, admin_password is ignored.
 */
$cfg['admin_http_auth_user'] = '';
/* Select different options for availability of uploaded files.
 * Possible values in array:
 * 'minute': file is available for one minute
 * 'hour': file available for one hour
 * 'day': file available for one day
 * 'week': file available for one week
 * 'month': file is available for one month
 * 'year': file available for one year
 * 'none': unlimited availability
 */
$cfg['availabilities'] = array ('minute' => true,
                                'hour' => true,
                                'day' => true,
                                'week' => true,
                                'month' => true,
                                'year' => true,
                                'none' => true);
/* Set maximal upload size expressed in MB.
 * 0 mean unlimited upload size.
 */
$cfg['maximal_upload_size'] = 0;
/* If your s42transfer is behind some reverse proxies, you can set there IPs
 * so s42transfer get visitor's IP from HTTP_X_FORWARDED_FOR instead of
 * REMOTE_ADDR.
 * for example:
 * $cfg['proxy_ip'] = array('12.34.56.78');
 */
$cfg['proxy_ip'] = array();

/**** Admin Fields*/
//Sharing fields
$cfg['sharing_enable']=false;
$cfg['sender_email']="";
$cfg['sender_name']="";


//TypeKit
$cfg['typekit_fontreplacement']='0';
$cfg['typekit_code']='<script src="https://use.typekit.net/osp8soz.js"></script><script>try{Typekit.load({async: true});}catch(e){}</script>';
$cfg['typekit_normal']="adelle-sans";
$cfg['typekit_bold']="adelle-sans";
$cfg['typekit_optional']="adelle-sans";

//Design
$cfg['main_color']="#134953";
$cfg['main_color_light']="#01cefe";

$cfg['bg_gradient_color1']="#04cdf7"; 
$cfg['bg_gradient_color2']="#66b754";

$cfg['logo']="Logo_Normal.png";
$cfg['logo_resolation']="Logo_Retina.png";
$cfg['favicon']="favicon.png";
$cfg['touchicon']="S42_Touchicon_neu_144.png";

$cfg['temp1']="100";
$cfg['temp2']="";
$cfg['temp3']="";
$cfg['temp4']="";
$cfg['temp5']="";

//Security password protection
$cfg['security_enable']=false;
$cfg['sec_user']="";
$cfg['sec_pwd']="";
$cfg['login_auth'] = false;

//Set download mode
$cfg['downloadMode']= "zipFiles";
$cfg['allow_downloadMode']= "zip";

//external SMTP Server
$cfg['smtp_host'] = '';
$cfg['smtp_user'] = '';
$cfg['smtp_pass'] = '';
$cfg['smtp_port'] = '';
$cfg['smtp_auth'] = false;
$cfg['smtp_tls'] = false;

//Rezipped file
$cfg['re_zipped'] = false;
//Show - Hide download link in frontend
$cfg['show_download_link'] = true;

//JIRAFEAU_CFG

define ('JIRAFEAU_ROOT1', dirname (__FILE__) . '/');
define ('JIRAFEAU_CFG1', JIRAFEAU_ROOT1.'config.local.php');

$cfg['JIRAFEAU_CFG1']=JIRAFEAU_CFG1;




/* Installation is done ? */
$cfg['installation_done'] = false;

/* Try to include user's local configuration. */
if ((basename (__FILE__) != 'config.local.php')
    && file_exists (JIRAFEAU_ROOT.'lib/config.local.php'))
{
    require (JIRAFEAU_ROOT.'lib/config.local.php');
}

?>
