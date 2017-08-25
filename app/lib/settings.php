<?

	function getAssistSettings($which) {
	
		$query = mysql_query("SELECT * FROM settings") or die(mysql_error());

		$getSettings = mysql_fetch_row($query) ;
	
		switch ($which) {
		
			case "cache" :
				return $getSettings['24'] ;
				break ;
				
			case "admin_email" :
				return $getSettings['17'] ;
				break ;
				
			case "dsn" :
				return $getSettings['0'] ;
				break ;
				
			case "dsn_user" :
				return $getSettings['1'] ;
				break ;
				
			case "dsn_pass" :
				return $getSettings['2'] ;
				break ;	
				
			case "message" :
				return $getSettings['7'] ;
				break ;	
				
			case "pdf" :
				return $getSettings['23'] ;
				break ;		
				
			case "mail_host" :
				return $getSettings['19'] ;
				break ;	
				
			case "mail_server" :
				return $getSettings['20'] ;
				break ;	
				
			case "mail_user" :
				return $getSettings['21'] ;
				break ;	
				
			case "mail_pass" :
				return $getSettings['22'] ;
				break ;	
				
			case "vat" :
				return $getSettings['8'] ;
				break ;	
				
			case "ck" :
				return $getSettings['9'] ;
				break ;		
				
			case "ad01" :
				return $getSettings['10'] ;
				break ;	
				
			case "ad02" :
				return $getSettings['11'] ;
				break ;	
				
			case "tel" :
				return $getSettings['12'] ;
				break ;
				
			case "fax" :
				return $getSettings['13'] ;
				break ;	
				
			case "email" :
				return $getSettings['14'] ;
				break ;					
			case "url" :
				return $getSettings['15'] ;
				break ;	
				
			case "img" :
				return $getSettings['16'] ;
				break ;	
				
			case "cname" :
				return $getSettings['18'] ;
				break ;
				
			case "dsn2" :
				return $getSettings['25'] ;
			break ;
			
			case "dsn2_user" :
				return $getSettings['26'] ;
			break ;
			
			case "dsn2_pass" :
				return $getSettings['27'] ;
			break ;
		}
		
	}
	
?>