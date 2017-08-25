<?
	class companyDetails {
	
		/*
		This class basically gets company information. There are a few details to note though . 
		You first call setVar with the DB & field details. You then call makeODBCSelect() and
		create a connection to the database. you populate the class data with fillVar($code,$type)
		and get data using getItem . you close the connection using closeODBC()
		
		You can set the code in a different area - just so you can change that without effecting the
		working of the rest of the class.
		
		This class is primarily for the customer_main and supplier_main areas . using it in the 
		main customer areas is a bit tricky. 
		*/
	
		var $code ;
		var $odbc_table ;
		var $odbc_code ;
		var $conn ;
		var $odbc_query ;
		
		var $type ;
		var $note_type ;
		
		var $c_name ;
		var $c_contact ;
		var $c_rep ;
		var $c_cell ;
		var $c_tel ;
		var $c_fax ;
		var $c_last_date_paid ;
		var $c_last_amount_paid ;
		var $c_credit_limit ;
		var $one_fifty ;
		var $one_twenty ;
		var $ninety ;
		var $sixty ;
		var $thirty ;
		var $current ;
		var $total ;
		var $tax ;
		var $blocked ;
		
		var $pastel_notes ;
		var $notes ;
		
		function makeODBCSelect() {
		
			$table = $this->odbc_table ;
			$code = $this->code ;
			$field = $this->odbc_code ;
			
			$sql = "SELECT * FROM ".$table." WHERE ".$field." = '".$code."'" ;
			$query = odbc_do($this->conn,$sql) ;
			$this->odbc_query = $query ;

			if (!$query) {
				print("<font color=red><b>".odbc_errormsg()."</b></font>") ;
				return false ;
			} else {
				return true ;
			}
		}
		
		function setCode($code) {
			$this->code = $code ;
			return true ;
		}
		
		function setVar($table,$o_code,$type,$ntype) {
			$this->conn = connect() ;
			$this->odbc_table =$table ;
			$this->odbc_code = $o_code ;
			$this->type = $type ; 
			$this->pastel_notes = array() ;
			$this->notes = array() ;
			$this->note_type = $ntype ;
			return true ;
		}
		
		function fillVar() {
		
			if ($this->type=="customer") {
				$odbcFieldPositions = array() ;
				$odbcFieldPositions['company'] = 3 ;	
				$odbcFieldPositions['blocked'] = 68 ;		
				$odbcFieldPositions['oneFifty'] = 110 ;
				$odbcFieldPositions['oneTwenty'] = 111 ;
				$odbcFieldPositions['ninety'] = 112 ;	
				$odbcFieldPositions['sixty'] = 113 ;
				$odbcFieldPositions['thirty'] = 114 ;
				$odbcFieldPositions['c_last_date_paid'] = 66 ;
				$odbcFieldPositions['c_last_amount_paid'] = 67 ;
				$odbcFieldPositions['c_credit_limit'] = 75 ;
				$odbcFieldPositions['tax'] = 62 ;
				$odbcFieldPositions['blocked'] = 68 ;
				
				$this->c_contact = getFromDAddress($this->code,"contact") ;
				$this->c_rep = getRealRep(rtrim(getFromDAddress($this->code,"rep"))) ;
				$this->c_cell = getFromDAddress($this->code,"cell") ;
				$this->c_tel = getFromDAddress($this->code,"tel") ; 
				$this->c_fax = getFromDAddress($this->code,"fax") ;
				
			} 
			
			if ($this->type=="supplier") {
				$odbcFieldPositions = array() ;
				$odbcFieldPositions['company'] = 2 ;	
				$odbcFieldPositions['blocked'] = 66 ;		
				$odbcFieldPositions['oneFifty'] = 114 ;
				$odbcFieldPositions['oneTwenty'] = 115 ;
				$odbcFieldPositions['ninety'] = 116 ;	
				$odbcFieldPositions['sixty'] = 117 ;
				$odbcFieldPositions['thirty'] = 118 ;
				$odbcFieldPositions['c_last_date_paid'] = 64 ;
				$odbcFieldPositions['c_last_amount_paid'] = 65 ;
				$odbcFieldPositions['c_credit_limit'] = 73 ;
				$odbcFieldPositions['tax'] = 61 ;
				$odbcFieldPositions['blocked'] = 66;
				
				$this->c_contact = odbc_result($this->odbc_query,74)  ;
				$this->c_rep = "Supplier" ;
				$this->c_cell = odbc_result($this->odbc_query,76) ;
				$this->c_tel = odbc_result($this->odbc_query,75) ; 
				$this->c_fax = odbc_result($this->odbc_query,77) ;
				
			} 
			
			$this->c_name = odbc_result($this->odbc_query,$odbcFieldPositions['company']) ; 
			$this->c_last_date_paid = odbc_result($this->odbc_query,$odbcFieldPositions['c_last_date_paid']) ;
			$this->c_last_amount_paid = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['c_last_amount_paid'])) ;
			$this->c_credit_limit = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['c_credit_limit'])) ;
			$this->one_fifty = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['oneFifty'])) ;
			$this->one_twenty = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['oneTwenty'])) ;
			$this->ninety = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['ninety'])) ;
			$this->sixty = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['sixty'])) ;
			$this->thirty = convertToFloat(odbc_result($this->odbc_query,$odbcFieldPositions['thirty'])) ;
			$this->current = convertToFloat(getCurrent($this->odbc_code,$this->type)) ;
			$this->total = convertToFloat($this->one_fifty + $this->ninety + $this->sixty + $this->thirty + $this->current) ;
			$this->tax = odbc_result($this->odbc_query,$odbcFieldPositions['tax']) ;
			$this->blocked = odbc_result($this->odbc_query,$odbcFieldPositions['blocked']) ;			
		}
		
		function fillPastelNotes() {
		
			$number = $this->code ;
			$ntype = $this->note_type ;
			
			$sqlQuery = "SELECT * FROM Notes WHERE Code = '".$number."' AND NoteType = '".$ntype."' ORDER BY NoteID DESC" ;
			
			$query = odbc_do($this->conn, $sqlQuery) ;

			$x=0 ;
			
			$note_array = array() ;

			while (odbc_fetch_row($query)) {

				$date= odbc_result($query, 5) ;
				$heading = odbc_result($query, 4) ;
				$content = odbc_result($query, 9) ;

				$x++;
				
				$note_array[$x] = $date.",".$heading.",".$content ;

			}

			$this->pastel_notes = $note_array ;
			
		}
		
		function fillNotes() {
		
			$number = $this->code ;
			$type = $this->type ;
	
			$query = mysql_query("SELECT * FROM notes WHERE code = '$number' AND type = '$type' ORDER BY created_date DESC") or die(mysql_error());

			$x=0 ;
					
			$note_array = array() ;
		
			while ($getNote = mysql_fetch_row($query)) {
			
				$x++ ;
			
				$note_array[$x] = getNoteData($getNote['0'],'id').",".
								  getNoteData($getNote['0'],'created_date').",".
				   convertToFloat(getNoteData($getNote['0'],'amount')).",".
								  getNoteData($getNote['0'],'content') ;
				
			}	
			
			$this->notes = $note_array ;

		}
			
		function getItem($val) {
		
			switch ($val) {
			
				case "name" :
				return $this->c_name ; 
				break ;
				
				case "last_date_paid" :
				return $this->c_last_date_paid  ;
				break ;
				
				case "last_amount_paid" :
				return $this->c_last_amount_paid ;
				break ;
				
				case "credit_limit" :
				return $this->c_credit_limit ;
				break ;
				
				case "150" :
				return $this->one_fifty ;
				break ;
				
				case "120" :
				return $this->one_twenty ;
				break ;
				
				case "90" :
				return $this->ninety ;
				break ;
				
				case "60" :
				return $this->sixty ;
				break ;
				
				case "30" :
				return $this->thirty ;
				break ;
				
				case "current" :
				return $this->current ;
				break ;
				
				case "total" :
				return $this->total ;
				break ;
				
				case "tax" :
				return $this->tax ;
				break ;
				
				case "contact" :
				return $this->c_contact ;
				break ;
				
				case "rep" :
				return $this->c_rep ;
				break ;
				
				case "cell" :
				return $this->c_cell ;
				break ;
				
				case "tel" :
				return $this->c_tel ; 
				break ;
				
				case "fax" :
				return $this->c_fax ;			
				break ;
				
				case "notes" :
				return $this->notes ;			
				break ;
				
				case "pastel_notes" :
				return $this->pastel_notes ;			
				break ;

				case "blocked" :
				return $this->blocked ;			
				break ;				
			}			
		}
		
		function closeODBC() {
			odbc_close($this->conn) ;
			return true ;
		}
	
	}

?>