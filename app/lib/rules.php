<?
	
	function get_rule($company,$general_type,$field) {
	
		$query = mysql_query("SELECT * FROM rules WHERE cust_id = '$company' AND type='$general_type'");
		if (mysql_num_rows($query)==0) {
			return false ;
		} else {
			$getField = mysql_fetch_row($query) ;
			switch ($field) {
				case "pdf" : 
				return $getField['2'] ;	
				break;
				case "email" : 
				return  $getField['4'] ;	
				break;
			}
		}
		
	}
	
	function get_rule_by_id($id,$field) {
	
		$query = mysql_query("SELECT * FROM rules WHERE id = '$id'");
		if (mysql_num_rows($query)==0) {
			return false ;
		} else {
			$getField = mysql_fetch_row($query) ;
			switch ($field) {
				case "code" : 
				return $getField['1'] ;	
				break;
				case "name" : 
				return $getField['3'] ;	
				break;
				case "pdf" : 
				return $getField['2'] ;	
				break;
				case "email" : 
				return  $getField['4'] ;	
				break;
				case "type" : 
				return  $getField['5'] ;	
				break;
			}
		}
		
	}

?>