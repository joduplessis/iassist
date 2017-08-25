<?

	function parseCode($code) {
	
		$week = 604800 ;
		$end = time() ;
		$start = ($current - $week) ;
		
		if (($code <= $end) && ($code >= $start)) {
		
			return true ;
			
		} else {
		
			return false ;
			
		}
		
	}




	






?>