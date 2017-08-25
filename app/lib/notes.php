<?


	function getNoteData($id,$field) {
	
		$query = mysql_query("SELECT * FROM notes WHERE id = '$id'") ;
		
		if ( ( !$query ) or ( mysql_num_rows($query) == 0 ) ) {
		
			return false ;
			
		} else {
		
			$value = "" ;
			
			$getField = mysql_fetch_row($query) ;
			
			switch ($field) {
				case "id" :
				$value = $getField['0'] ;
				break ;
				case "type" :
				$value = $getField['1'] ;
				break ;
				case "code" :
				$value = $getField['2'] ;
				break ;
				case "user" :
				$value = $getField['3'] ;
				break ;
				case "content" :
				$value = $getField['4'] ;
				break ;
				case "amount" :
				$value = $getField['5'] ;
				break ;	
				case "start_date" :
				$value = $getField['6'] ;
				break ;					
				case "end_date" :
				$value = $getField['7'] ;
				break ;				
				case "created_date" :
				$value = $getField['8'] ;
				break ;				
				case "see_all" :
				$value = $getField['9'] ;
				break ;				
			
			}
			
			return $value ;
			
		}	
		
	}

	function giveNoteAmount($number,$where) {
	
		$query = mysql_query("SELECT * FROM notes WHERE code = '$number' AND type = '$where'") or die(mysql_error());
		$noteCount = mysql_num_rows($query) ;
		$amount = 0 ;
		
		if ($noteCount != 0) {
			while ($getNote = mysql_fetch_row($query )) {
				$amount += $getNote['5'] ;
			}
		}
	
		return $amount ;

	}
	
	function hasNote($number,$type) {
	
		$query = mysql_query("SELECT * FROM notes WHERE code = '$number' AND type = '$type'") or die(mysql_error());
		$notes = mysql_num_rows($query) ;
		if ($notes == 0) {
			return false ;
		} else {
			return true ;
		}
	


	}







?>