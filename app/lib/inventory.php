<?
	function updateMinMax($code,$min,$max) {
	
		$conn = connect() ;
		$sql = "UPDATE MultiStoreTrn SET ReorderLevel = '".$min."', MaximumLevel = '".$max."' WHERE ItemCode = '".$code."'" ;
		$query = odbc_do($conn,$sql);
		if (!$query) {
			return false ;
		}
		
		return true ;
		
	
	}
	
	function makeCategories() {
	
		$list = "" ;
		
		$conn = connect() ;
		
		$query = "SELECT * FROM InventoryCategory" ;
		
		$do = odbc_do($conn,$query) ;
		
		if (!$do) { print(odbc_errormsg()); } 
		
		$list.= "<option value=''>All</option>" ;		
		
		while (odbc_fetch_row($do)) {
		
			$list.= "<option value='".odbc_result($do,1)."'>".odbc_result($do,2)."</option>" ;
			
		}
		
		return $list ;
		
		odbc_close($conn);
		
	}
	
	function getInvItem($code,$field) {
	
		$conn = connect() ;
	
		$query = "SELECT * FROM Inventory WHERE ItemCode = '".$code."'" ;
		
		$do = odbc_do($conn,$query) ;
		
		if (!$do) { print(odbc_errormsg()); } 
		
		switch ($field) {
			case "description" :
			return odbc_result($do, 3) ;	
			break ;
		}
		
		odbc_close($conn);
		
	}
	
	function getLinesItem($itemcode,$code,$general_type,$field) {
	
		$conn = connect() ;
	
		$full_doc_type = "" ;
		
		if ($general_type == "customer") {
			$full_doc_type = "(DocumentType='3' OR DocumentType='4' OR DocumentType='5' OR DocumentType='102' OR DocumentType='101')" ;
		} else if ($general_type == "supplier") {
			$full_doc_type = "(DocumentType='7' OR DocumentType='8' OR DocumentType='9' OR DocumentType='10' OR DocumentType='106')" ;
		}
		
		$sql = "SELECT * FROM HistoryLines WHERE ".$full_doc_type." AND ItemCode = '".$itemcode."' AND CustomerCode = '".$code."' ORDER BY DDate DESC" ;
		
		$query = odbc_do($conn, $sql) ;
		
		switch ($field) {
			case "last_purchased" :
			return odbc_result($query, 9) ;
			break ;
		}


		
		odbc_close($conn);	
		
	}

	function getStores() {
	
		$list = "" ;
		
		$conn = connect() ;
		
		$query = "SELECT * FROM MultiStore" ;
		
		$do = odbc_do($conn,$query) ;
		
		if (!$do) { print(odbc_errormsg()); } 
		
		$list.= "<option value=''>All</option>" ;		
		
		while (odbc_fetch_row($do)) {
		
			$list.= "<option value='".odbc_result($do,1)."'>".odbc_result($do,2)."</option>" ;
			
		}
		
		return $list ;
		
		odbc_close($conn);
		
	}
	
	function getStoresArray() {
	
		$list = array() ;
		
		$conn = connect() ;
		
		$query = "SELECT * FROM MultiStore" ;
		
		$do = odbc_do($conn,$query) ;
		
		if (!$do) { print(odbc_errormsg()); } 
		
		while (odbc_fetch_row($do)) {
		
			$list[]= odbc_result($do,1) ;
			
		}
		
		return $list ;
		
		odbc_close($conn);
		
	}
	

?>