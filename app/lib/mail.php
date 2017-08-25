<?
	function doMail($subject,$content,$extra,$email,$company,$files) {
	
		$user_email = getUserData($_SESSION['username'],'email') ;
		$mail_host = getAssistSettings('mail_host') ;
		$mail_server = getAssistSettings('mail_server') ;
		$mail_user = getAssistSettings('mail_user') ;
		$mail_pass = getAssistSettings('mail_pass') ;

		$mail = new PHPMailer();	
		
		$mail->From     = $mail_server ;
		$mail->FromName = $user_email ;
		$mail->Host     = $mail_host ;
		$mail->Mailer   = "smtp";
		
		if ( ( $mail_user == "" ) && ( $mail_pass == "") ) {
			$mail->Username = $mail_user ;
			$mail->Password = $mailPass ;
		}
		
		$mail->Subject = $subject;
		$mail->IsHTML(true);  
		
		$mail->Body    = $content;
		$mail->AltBody = strip_tags($content);
		
		$company = $company ;
		$email = $email ;
		$files = $files ;
		
		$email_csv = explode(",",$email);
		
		if ( sizeof($email_csv) >= 2 ) {
		
			for ($x = 0 ; $x < sizeof($email_csv) ; $x++) {
				$mail->AddAddress($email_csv[$x]);
			}
			
		} else {
		
			$mail->AddAddress($email);
			
		}
		
		for ($y = 0 ; $y < sizeof($files) ; $y++ ) {
				
			$file_whole = explode(",",$files[$y]);
			$file_id = $file_whole['0'] ;
			$file_name = $file_whole['1'] ;
			
			if ( $company == $file_id ) {
			
				$mail->AddAttachment($file_name);
				
			}
			
		}

		$mail->AddAttachment($extra);

		if(!$mail->Send()) {
			return "<img src=img/no.gif> Sorry, email for ".$company." did not send - your settings may possibly be wrong.<br>" ;
		} else {
			return "<img src=img/yes.gif> Email for ".$company." successfully sent !<br>" ;
		}

		$mail->ClearAddresses();
		$mail->ClearAttachments();

	}
	
	
	function get_odbc_email($email_id,$general_type) {
	
		$conn = connect() ;
		
		if ($general_type == "customer") {
		
			$sql = "SELECT * FROM DeliveryAddresses WHERE CustomerCode = '".$email_id."'" ;
			$connect = odbc_do($conn,$sql) ;
			return odbc_result($connect, 13);
			
		} else {
		
			$sql = "SELECT * FROM SupplierMaster WHERE SupplCode = '".$email_id."'" ;
			$connect = odbc_do($conn,$sql) ;
			return odbc_result($connect, 120);
			
		}
	}
	
?>