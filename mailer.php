<?php	
	
	function mailer_postdata($to,$your_Email,$subject,$send_lnk ){
		
		$to = $to ;
		$your_Email = $your_Email ;
		$subject =  $subject;
		$send_lnk = $send_lnk ;
		
		//ob_start();
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers		
		$headers .= 'From: <'.$your_Email.'>' . "\r\n";
		

		$send = mail($to,$subject,$send_lnk,$headers);
		if($send){
		     return 1;
		   }
		else{
		 return 0;
		}
		//ob_end_flush();
	}

	
	
	function formatSizeUnitsbytes($bytes)
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
	
	
	
	
	
	
	
?>