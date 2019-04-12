<?php
//@error_reporting(0);
define ('JIRAFEAU_ROOT', dirname (__FILE__) . '/');

require (JIRAFEAU_ROOT . 'lib/config.original.php');
require (JIRAFEAU_ROOT . 'lib/config.local.php');
require (JIRAFEAU_ROOT . 'lib/settings.php');
require (JIRAFEAU_ROOT . 'lib/functions.php');
require (JIRAFEAU_ROOT . 'lib/lang.php');

/*
*  * PREVENT Abuse
*   */
if (!isset($_POST) || count($_POST) == 0) {
	        die("No POST data found...");
}

if (!validateToken()) {
	        die("CSRF detected...");
}

If(!isset($cfg)){
	global $cfg;
	$cfg['main_color']="#134953";
	$cfg['main_color_light']="#01cefe";
}
if($cfg['typekit_fontreplacement']==1){
	$typekit_normal = $cfg['typekit_normal'];
	$typekit_bold = $cfg['typekit_bold'];
	$typekit_optional = $cfg['typekit_optional'];	
}else{
	$cfg['typekit_normal']="Arial";
	$cfg['typekit_bold']="Arial";
	$cfg['typekit_optional']="Arial";
	$typekit_normal = $cfg['typekit_normal'];
	$typekit_bold = $cfg['typekit_bold'];
	$typekit_optional = $cfg['typekit_optional'];
}

$friend_Emails = $_POST['friend_Emails'];
$toString = implode($friend_Emails,', ');
	
	
	$your_Email = $_POST['your_Email'];
	$snd_msg = $_POST['snd_msg'];
	
	$file_links = $_POST['file_links'];
	$h = $_POST['web_root'].'f.php?h='.$_POST['file_links'].'&d=1';
	
	// SEND generate_number with Email link
	$generate_number  = $_POST['generate_number'];
	
	//$direct_Dwnload_url = get_tiny_url($h);
	$direct_Dwnload_url =  $_POST['web_root'].'f.php?h='.$generate_number.'&mail=1'; 
	
	//$del_url = $_POST['web_root'].'f.php?h='.$_POST['file_links'].'&del=1';
	$del_url =  $_POST['web_root'].'f.php?h='.$generate_number.'&del=1';
	
	
	
	
	
	
	$send_lnk="";
	$files_html  = "";
	$totals      = 0;	
	$link_nameArr = explode("@",$file_links);
	foreach($link_nameArr as $link_name){
		
		$plain_Dwnload_url =  $_POST['web_root'].'f.php?h='.$link_name .'&plain=1'; 
		$zip_Dwnload_url =  $_POST['web_root'].'f.php?h='.$link_name .'&singleZip=1'; 
			
	  $links = jirafeau_get_link ($link_name);
	 

		if($cfg['downloadMode'] == 'zipFiles'){	  
		  $files_html .='<div style="width:100%;float:left;margin:0 0 1% 0;" class="links_innner"><span style="width:82%;word-break:break-all;color:'.$cfg['main_color'].';float:left;font-family:'.$typekit_optional.';">'.$links['file_name'].'</span>  <span style="width:18%;text-align:right;color:'.$cfg['main_color_light'].';float:right;font-family:'.$typekit_optional.';">'.jirafeau_human_size($links['file_size']).'</span></div>';
		}else{
			
		 $files_html .='<div style="width:100%;float:left;margin:0 0 1% 0;" class="links_innner"><span style="width:82%;word-break:break-all;color:'.$cfg['main_color'].';float:left;font-family:'.$typekit_optional.';">'.$links['file_name'].'</span>  <span style="width:18%;text-align:right;color:'.$cfg['main_color_light'].';float:right;font-family:'.$typekit_optional.';"><a href="'.$plain_Dwnload_url.'">'.jirafeau_human_size($links['file_size']).'</a></span></div>';
		}
	  
	  $totals += $links['file_size']; 
	}
	//echo $files_html;
	//echo jirafeau_human_size($totals);
	
	$send_lnk .= '<html><head><title>Send Links</title></head>'.
	             '<body style="float:left">'.
				 '<div style="width:100%;float:left">'.		
				 
				  '<div style="float:left;padding:2%;width:96%">'.
	               '<p style="width:100%;margin:0px;padding-bottom:0px;color:'.$cfg['main_color_light'].'!important;font-size: 32px;text-decoration:none;font-family:'.$typekit_normal.';">'.$your_Email.'</p>'.
	               '<p style="width:100%;margin:0px;font-family:'.$typekit_normal.';color:'.$cfg['main_color'].'; font-size: 32px;">sent you some files </p>'.
	               '<p style="width:100%;color:'.$cfg['main_color'].';font-family:'.$typekit_normal.';font-size: 17px;">'.$snd_msg.'</p>';
				   
			   if($cfg['downloadMode'] == 'zipFiles'){
					  $send_lnk .=  '<p><a style="margin:0px;width:40%;text-align:center;background:'.$cfg['main_color'].';color:'.$cfg['main_color_light'].';padding:10px;text-decoration:none;font-weight:bold;font-size:17px;float:left;font-family:'.$typekit_bold.';cursor:pointer;" href="'.$direct_Dwnload_url.'">Download</a></p>';
				   }
				   
	    $send_lnk .=    '</div>'; 
		 
     $send_lnk1 = "";
	 $send_lnk1 .= '<div style="width:96%;float:left;padding:0 2%;">'.
				   '<p style="color:'.$cfg['main_color'].';font-weight:bold;float:left;width:100%;text-align:right;border-bottom:1px solid '.$cfg['main_color_light'].';padding-bottom: 5px;margin-top:0px;font-family:'.$typekit_bold.';">'.count($link_nameArr).' Files (Total: '.formatSizeUnits($totals).') </p>'.		
				   '<p>'.$files_html.'</p>'.				   
				   '</div>'. 
				   
	               '<div style="width:96%;float:left;border-top:1px solid '.$cfg['main_color'].';padding-top:1%;margin:4% 2%;">
				   <abbr style="color:'.$cfg['main_color'].';float:left;text-decoration:none;cursor:default;font-family:'.$typekit_optional.';" title="s42.transfer">s42.transfer</abbr>
				    
				    <a style="color:'.$cfg['main_color'].';font-family:'.$typekit_optional.';text-decoration:none;float:right;" href="'.rtrim($cfg['web_root'], '/') . '/tos.php">'.t("&nbsp;| Terms").'</a><a style="color:'.$cfg['main_color'].';text-decoration:none;float:right;font-family:'.$typekit_optional.';" href="https://www.gnu.org/licenses/agpl.html"><abbr style="text-decoration:none;"  title="Affero General Public License">AGPL</abbr>v3</a>
			</div>
			</div>
				   </body></html>';	
				 
	   $send_lnks = $send_lnk.$send_lnk1;	


/************************** SENDER MAIL TEXT ******************/
/************************** SENDER MAIL TEXT ******************/
		
	 $send_lnk_sender .= '<html><head><title>Send Links</title></head>'.
	             '<body style="float:left">'.
				 '<div style="width:100%;float:left">'.		
				 
				  '<div style="float:left;padding:2%;width:96%">'.
	               
	               '<p style="width:100%;margin:0px;font-family:'.$typekit_normal.';color:'.$cfg['main_color'].'; font-size: 32px;">Files successfully sent to  </p>'.
				   '<p style="width:100%;margin:0px;padding-bottom:0px;color:'.$cfg['main_color_light'].'!important;font-size: 32px;text-decoration:none;font-family:'.$typekit_normal.';">'.$toString.'</p>'.
	               '<p style="width:100%;color:'.$cfg['main_color'].';font-family:'.$typekit_normal.';font-size: 17px;">'.$snd_msg.'</p>'.
	               '<p style="width:100%; float:left;"><a style="margin:0px;width:40%;text-align:center;background:'.$cfg['main_color'].';color:'.$cfg['main_color_light'].';padding:10px;text-decoration:none;font-weight:bold;font-size:17px;float:left;font-family:'.$typekit_bold.';cursor:pointer;" href="'.$direct_Dwnload_url.'">Download</a></p>'.
				   
	               '<p style="width:100%;"><a style="margin:0px;width:40%;text-align:center;background:'.$cfg['main_color'].';color:'.$cfg['main_color_light'].';padding:10px;text-decoration:none;font-weight:bold;font-size:17px;float:left;font-family:'.$typekit_bold.';cursor:pointer;" href="'.$del_url.'">DELETE File(s)</a></p>'.
	              '</div>'; 
     $send_lnk1_sender = "";
	 $send_lnk1_sender .= '<div style="width:96%;float:left;padding:0 2%;">'.
				   '<p style="color:'.$cfg['main_color'].';font-weight:bold;float:left;width:100%;text-align:right;border-bottom:1px solid '.$cfg['main_color_light'].';padding-bottom: 5px;margin-top:0px;font-family:'.$typekit_bold.';">'.count($link_nameArr).' Files (Total: '.formatSizeUnits($totals).') </p>'.		
				   '<p>'.$files_html.'</p>'.				   
				   '</div>'. 
				   
	               '<div style="width:96%;float:left;border-top:1px solid '.$cfg['main_color'].';padding-top:1%;margin:4% 2%;">
				   <abbr style="color:'.$cfg['main_color'].';float:left;text-decoration:none;cursor:default;font-family:'.$typekit_optional.';" title="s42.transfer">s42.transfer</abbr>
				    
				    <a style="color:'.$cfg['main_color'].';font-family:'.$typekit_optional.';text-decoration:none;float:right;" href="'.rtrim($cfg['web_root'], '/') . '/tos.php">'.t("&nbsp;| Terms").'</a><a style="color:'.$cfg['main_color'].';text-decoration:none;float:right;font-family:'.$typekit_optional.';" href="https://www.gnu.org/licenses/agpl.html"><abbr style="text-decoration:none;"  title="Affero General Public License">AGPL</abbr>v3</a>
			</div>
			</div>
				   </body></html>';	 
				 
$send_lnks_sender = $send_lnk_sender.$send_lnk1_sender;

/************************** SENDER MAIL TEXT ******************/
$send_lnks_sender = wordwrap($send_lnks_sender, 70);
$send_lnks = wordwrap($send_lnks, 70);
/************************** SENDER MAIL TEXT ******************/
		
	   
		$subject_sender = 'Thanks for using s42.transfer - file sent to '. count($friend_Emails) . ' contact(s)' ;	
		$subject = $your_Email .' has sent you file(s) via s42.transfer';
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		// More headers		
		$headers .= 'From: '.$cfg['sender_name'].'<'.$your_Email.'>' . "\r\n";
		//$headers = "From: $name <$email>\r\n" 
		
		if (isset($cfg['smtp_host']) && !empty($cfg['smtp_host'])) {
                                require_once('./lib/vendor/phpmailer/PHPMailerAutoload.php');
                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->CharSet = 'UTF-8';

                                $mail->Host       = $cfg['smtp_host']; // SMTP server example
                                $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                if (isset($cfg['smtp_auth']) && $cfg['smtp_auth'] !== false) {
                                        $mail->SMTPAuth   = true;                  // enable SMTP authentication
                                        $mail->Port       = $cfg['smtp_port'];                    // set the SMTP port for the GMAIL server
                                        $mail->Username   = $cfg['smtp_user']; // SMTP account username example
                                        $mail->Password   = $cfg['smtp_pass'];        // SMTP account password example
                                }
                                if (isset($cfg['smtp_tls']) && $cfg['smtp_tls'] !== false) {
                                        $mail->SMTPSecure = 'tls';
                                }

                                $mail->setFrom($your_Email, $cfg['sender_name']);
                                $mail->addAddress($your_Email);               // Name is optional
                                $mail->addReplyTo($your_Email);
//                              $mail->addCC('cc@example.com');
//                              $mail->addBCC('bcc@example.com');
				foreach($friend_Emails as $f_email){
                        		$mail->addBCC($f_email);
                		}
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = $subject;
                                $mail->Body    = $send_lnks;
//                              $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                                if(!$mail->send()) {
				      $results = false;
//                                    echo 'Message could not be sent.';
//                                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                                } else {
                                      $results = true;
				}

				/************************** Send Mail to sender*/
				$senderMail = new PHPMailer();
				$senderMail->IsSMTP();
                                $senderMail->CharSet = 'UTF-8';

                                $senderMail->Host       = $cfg['smtp_host']; // SMTP server example
                                $senderMail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                if (isset($cfg['smtp_auth']) && $cfg['smtp_auth'] !== false) {
                                        $senderMail->SMTPAuth   = true;                  // enable SMTP authentication
                                        $senderMail->Port       = $cfg['smtp_port'];                    // set the SMTP port for the GMAIL server
                                        $senderMail->Username   = $cfg['smtp_user']; // SMTP account username example
                                        $senderMail->Password   = $cfg['smtp_pass'];        // SMTP account password example
                                }
                                if (isset($cfg['smtp_tls']) && $cfg['smtp_tls'] !== false) {
                                        $senderMail->SMTPSecure = 'tls';
                                }

                                $senderMail->setFrom($your_Email, $cfg['sender_name']);
                                $senderMail->addAddress($your_Email);               // Name is optional
                                $senderMail->addReplyTo($your_Email);
                                $senderMail->isHTML(true);                                  // Set email format to HTML
                                $senderMail->Subject = $subject_sender;
                                $senderMail->Body    = $send_lnks_sender;
				if(!$senderMail->send()) {
                                      $results = false;
                                } else {
                                      $results = true;
                                }
                } else {	// if no external MTA is definded
			foreach($friend_Emails as $f_email){
                        	$results = mail($f_email,$subject,$send_lnks,$headers);
                	}
			/************************** Send Mail to sender*/
        	        $results_sender = mail($your_Email,$subject_sender,$send_lnks_sender,$headers);
                	/************************** Send Mail to sender*/
		}	
		
		if($results){
			echo 1;
		}else{
			echo 0;
		}
		
?>		
