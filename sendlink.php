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
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/lang.php');
require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/config.local.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');

if (!isset ($_POST['h']) || empty ($_POST['h']))
{
    header ('Location: ' . $cfg['web_root']);
    exit;
}
if (!isset ($_POST['s']) || $_POST['s'] !=1)
{
    header ('Location: ' . $cfg['web_root']);
    exit;
}

/* Operations may take a long time.
 * Be sure PHP's safe mode is off.
 */
@set_time_limit(0);
/* Remove errors. */
//@error_reporting(0);

require (JIRAFEAU_ROOT . 'lib/template/header.php');
require (JIRAFEAU_ROOT . 'mailer.php');

$link_name1 = $_POST['h'];
$link_nameArr = explode('@',$link_name1);

/* $nbr = mt_rand(5, 15);
 $nbr  =  $nbr.time();
$cfg['generate_number'][$nbr] = $link_name1;
 //$cfg[$nbr] = $link_name1;
 jirafeau_export_cfg_custom($cfg);
 */
?>

<div id="mail_sent" class="mail_sent" style="display:none" >
			<div id="mail_sent_page" class="mail_sent_page">
				<span class="sent_image"></span>
				<span class="sent_txt">Email sent!</span>
				<span class="sent_txt_below">Take a look in your mailbox</span>				
			</div>	
</div>

<div id="sendLinks_wrapper">
<p class="send-links"> Share your file(s) </p>
    <a class="add_field_button" href="javascript:void(0);" >Add more emails</a>
   <form action="" method="post" name="snd_linkForm" id="snd_linkForm">  
     <div class="send_txt">
	    <input type="text" class="e_txt" name="friend_Emails[0]" placeholder="Friends email" />
	 </div>
	 <div class="email_wrapper">	 </div>
	 
     <div class="send_txt"><input type="text" class="e_txt" name="your_Email" placeholder="Your email" value="<?php if(isset($cfg['sender_email'])){echo $cfg['sender_email']; }?>"/></div>
     <div class="send_txt send_area"><textarea name="snd_msg" placeholder="Message"></textarea></div>
	 
	 <input type="hidden" name="file_links" value="<?php echo $link_name1; ?>"/>
	 <input type="hidden" name="web_root" value="<?php echo $cfg['web_root']; ?>"/>
	 <input type="hidden" name="generate_number" value="<?php echo $_POST['generate_number']; ?>"/>
      <?php echo getFormToken();?>
	<?php 
		$counter = 0;
		$total = 0;
		$html = "";
	   foreach($link_nameArr as $link_name){
		   $link = jirafeau_get_link ($link_name);
		   $html .= '<div class="f_list_inner"><span class="snd_fileName">'.$link['file_name'].'</span><span class="snd_fileSize">'.formatSizeUnits($link['file_size']).'</span></div>';
				 
		   $counter++;		   
		   $total+= $link['file_size'];
		 }
		//echo $counter;
		?>
		<div class="send_txt-total"><span class="txt-total"><?php echo $counter.'&nbsp;files (Total '.formatSizeUnits($total);  ?>)</span></div>
		<div class="send_txt f_list"><?php  echo $html;			?></div>
		<div id="mail_result"></div>
		<div class="submit_send"><input type="submit" value="Send" name="send_btn" id="send_btn"/></div> 
		
	</form>
	
    
 
</div>

<?php

require (JIRAFEAU_ROOT . 'lib/template/footer.php');			

?>

