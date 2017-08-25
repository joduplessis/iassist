<?

	function userCheck($username,$password) {
	
		$query = mysql_query ("SELECT * FROM users WHERE username = '$username' AND password = '$password'") ;
		
		if ((!$query) or (mysql_num_rows($query)==0)) {
		
			return false ;
			
		} else {
		
			return true ;
			
		}
	}
	
	function userCheckOnlyName($username) {
		$query = mysql_query ("SELECT * FROM users WHERE username = '$username'") ;
		if ((!$query) or (mysql_num_rows($query)==0)) {
			return false ;
		} else {
			return true ;
		}
	}
	
	function getUserData($user,$field) {
	
		$query = mysql_query("SELECT * FROM users WHERE username = '$user'") ;
		
		if ( ( !$query ) or ( mysql_num_rows($query) == 0 ) ) {
		
			return false ;
			
		} else {
		
			$value = "" ;
			
			$getField = mysql_fetch_row($query) ;
			
			switch ($field) {
				case "id" :
				$value = $getField['0'] ;
				break ;
				case "username" :
				$value = $getField['1'] ;
				break ;
				case "password" :
				$value = $getField['2'] ;
				break ;
				case "name" :
				$value = $getField['3'] ;
				break ;
				case "surname" :
				$value = $getField['4'] ;
				break ;
				case "date_created" :
				$value = $getField['5'] ;
				break ;	
				case "date_expire" :
				$value = $getField['6'] ;
				break ;					
				case "sec_type" :
				$value = $getField['7'] ;
				break ;				
				case "email" :
				$value = $getField['8'] ;
				break ;				
				case "display_limit" :
				$value = $getField['9'] ;
				break ;				
				case "zeroclients" :
				$value = $getField['10'] ;
				break ;	
				case "highlight" :
				$value = $getField['11'] ;
				break ;	
				case "view_type" :
				$value = $getField['12'] ;
				break ;

				
			}
			
			return $value ;
			
		}	
		
	}
	
	function getUserNumber() {
		$query = mysql_query("SELECT * FROM users") ;
		if ((!$query) or (mysql_num_rows($query)==0)) {
			return false ;
		} else {
			return mysql_num_rows($query) ;
		}
	}
?>