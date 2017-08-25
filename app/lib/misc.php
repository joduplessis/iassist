<?
	function getCategories($where) {

		$conn = connect() ;
		
		$query = "SELECT * FROM ".$where."Categories" ;
	
		$do = odbc_do($conn, $query) ;

		$list = "" ;

		while (odbc_fetch_row($do)) 
		{
		
			$sm_code = rtrim(odbc_result($do, 1)) ;
			$sm_desc = rtrim(odbc_result($do, 2)) ;

			$list .= "<option value='".$sm_code ."'>".$sm_desc."</option>" ;

		}  
		
		return $list ;

	}
	
	
	function clearCache($val,$path) {
	
		$path = "pdf_files" ;
		$total = 0 ;
		$handle = opendir($path);
		$cache = $val * 1024 * 1024 ;
		$setDel = false ;
		
		if ($handle) {
		
			while (false !== ($file = readdir($handle))) 	{ 
			
				if (($file!=".")||($file!="..")) {
				
					$full_file = $path."/".$file ;
					
					if ($setDel) {
					
						unlink($full_file) ;
						
					} else {
					
						$filesizes = filesize($path."/".$file) ;
						$total += $filesizes ;
						
						if ($total > $cache) {
						
							$setDel = true ;
							unlink($full_file) ;
							
						}
						
					}
					
				}
				
			}
			
		}

	}

	function getNoteType($type) {
		switch ($type) {
				case 3 : 
					return "Invoice" ;
					break ;
				case 4 : 
					return "Credit Note" ;
					break ;

				case 106 : 
					return "Purchase Order" ;
					break ;
				case 7 : 
					return "Goods Recieved Note" ;
					break ;

				case 9 : 
					return "Return Note" ;
					break ;
				case 10 : 
					return "Debit Note" ;
					break ;

				case 5 : 
					return "Debit Note" ;
					break ;

				case 8 : 
					return "Suppliers Invoice" ;
					break ;

				case 102 : 
					return "Sales Order" ;
					break ;
				case 101 : 
					return "Quotation" ;
					break ;

				default : 
					return "Unknown" ;
					break ;
			}
		
	}
	

	
	function convertToFloat($number) {
			return sprintf("%.2f",$number);  
	}
	
	function getToday() {
		return date('Y')."-".date('m')."-".date('d') ;
	}
	
	function getCompanyName($code,$type) {
	
		$conn = connect() ;
		
		$getData = "" ;
		
		if ($type=="customer") {
		
			$query = "SELECT * FROM CustomerMaster WHERE CustomerCode = '".$code."'" ;
			$do = odbc_do($conn,$query) ;
			$getData = odbc_result($do, 3) ;
			
		} else if ($type=="supplier") {
		
			$query = "SELECT * FROM SupplierMaster WHERE SupplCode = '".$code."'" ;
			$do = odbc_do($conn,$query) ;
			$getData = odbc_result($do, 2) ;
		}
								
		return $getData ;
		
		odbc_close($conn);
		
	}
	
	
	function getCompanyCode($code,$type) {
	
		$conn = connect() ;
		
		$getData = "" ;
		
		if ($type=="customer") {
		
			$query = "SELECT * FROM CustomerMaster WHERE CustomerDesc = '".$code."'" ;
			$do = odbc_do($conn,$query) ;
			$getData = odbc_result($do, 2) ;
			
		} else if ($type=="supplier") {
		
			$query = "SELECT * FROM SupplierMaster WHERE SupplDesc = '".$code."'" ;
			$do = odbc_do($conn,$query) ;
			$getData = odbc_result($do, 1) ;
		}
								
		return $getData ;
		
		odbc_close($conn);
		
	}


	
	function getFromDAddress($number,$where) {
	
		$conn = connect() ;

		$sql = "SELECT * FROM DeliveryAddresses WHERE CustomerCode = '".$number."'" ;

		$getDetails = odbc_do($conn, $sql) ;

		if (!$getDetails) {
		
			print("<font color=red><b>". odbc_errormsg() ."</b></font>") ;
			exit ;
			
		} else {
		
			switch ($where) {
				case "rep" :
				$value = trim(odbc_result($getDetails, 3)) ;
				break ;
				case "contact" :
				$value = trim(odbc_result($getDetails, 4)) ;
				break ;
				case "tel" :
				$value = trim(odbc_result($getDetails, 5)) ;
				break ;
				case "fax" :
				$value = trim(odbc_result($getDetails, 7)) ;
				break ;
				case "cell" :
				$value = trim(odbc_result($getDetails, 6)) ;
				break ;
			}
	
			if ($value == "") {
				return "N/A" ;
			} else {
				return  $value ;			
			}
				
		}
		odbc_close($conn);	
	}
	
	function getRealRep($rep) {
	
		$conn = connect() ;	
		
		$getSalesman = "SELECT * FROM SalesmanMaster WHERE Code = '".$rep."'" ;

		$getGuy = odbc_do($conn, $getSalesman) ;

		if (!$getGuy) {

			print("<font color=red><b>". odbc_errormsg() ."</b></font>") ;
			
		} else {

			return odbc_result($getGuy, 2) ;			
			
		}
		
		odbc_close($conn);		
		
	}
	
	function isBlocked($company,$blocked) {
		if ($blocked == "") {
			return $company . " <span class='style1'> &nbsp;B&nbsp; </span> ";
		} else {
			return $company ;
		}
	}
	
	function getCurrent($ccode,$ctype) {
	
		$conn = connect() ;	
				
		if ($ctype == "customer") {
		
			$period_query = "SELECT * FROM LedgerParameters" ;
			$period_do = odbc_do($conn, $period_query) ;
			$date_hold = array();
			
			//last year
			$date_hold[odbc_result($period_do, 23)] = 17  ;
			$date_hold[odbc_result($period_do, 24)] = 18  ;
			$date_hold[odbc_result($period_do, 25)] = 19  ;
			$date_hold[odbc_result($period_do, 26)] = 20  ;
			$date_hold[odbc_result($period_do, 27)] = 21  ;
			$date_hold[odbc_result($period_do, 28)] = 22  ;
			$date_hold[odbc_result($period_do, 29)] = 23  ;
			$date_hold[odbc_result($period_do, 30)] = 24  ;
			$date_hold[odbc_result($period_do, 31)] = 25  ;
			$date_hold[odbc_result($period_do, 32)] = 26  ;
			$date_hold[odbc_result($period_do, 33)] = 27  ;
			$date_hold[odbc_result($period_do, 34)] = 28  ;
			// this year
			$date_hold[odbc_result($period_do, 11)] = 4  ;
			$date_hold[odbc_result($period_do, 12)] = 5  ;
			$date_hold[odbc_result($period_do, 13)] = 6  ;
			$date_hold[odbc_result($period_do, 14)] = 7  ;
			$date_hold[odbc_result($period_do, 15)] = 8  ;
			$date_hold[odbc_result($period_do, 16)] = 9  ;
			$date_hold[odbc_result($period_do, 17)] = 10  ;
			$date_hold[odbc_result($period_do, 18)] = 11  ;
			$date_hold[odbc_result($period_do, 19)] = 12  ;
			$date_hold[odbc_result($period_do, 20)] = 13  ;
			$date_hold[odbc_result($period_do, 21)] = 14  ;
			$date_hold[odbc_result($period_do, 22)] = 15  ;
			
			$today = date('Y')."-".date('m')."-01" ;

			$place = $date_hold[$today] ;
			
			$query = "SELECT * FROM CustomerMaster WHERE CustomerCode = '".$ccode."'" ;
			
			$do = odbc_do($conn, $query) ;
			
			$cur = odbc_result($do, $place) ;
			
			return $cur ;
			
		} else if ($ctype == "supplier") {
		
			$period_query = "SELECT * FROM LedgerParameters" ;
			$period_do = odbc_do($conn, $period_query) ;
			$date_hold = array();
			
			//last year
			$date_hold[odbc_result($period_do, 23)] = 16  ;
			$date_hold[odbc_result($period_do, 24)] = 17  ;
			$date_hold[odbc_result($period_do, 25)] = 18  ;
			$date_hold[odbc_result($period_do, 26)] = 19  ;
			$date_hold[odbc_result($period_do, 27)] = 20  ;
			$date_hold[odbc_result($period_do, 28)] = 21  ;
			$date_hold[odbc_result($period_do, 29)] = 22  ;
			$date_hold[odbc_result($period_do, 30)] = 23  ;
			$date_hold[odbc_result($period_do, 31)] = 24  ;
			$date_hold[odbc_result($period_do, 32)] = 25  ;
			$date_hold[odbc_result($period_do, 33)] = 26  ;
			$date_hold[odbc_result($period_do, 34)] = 27  ;
			// this year
			$date_hold[odbc_result($period_do, 11)] = 3  ;
			$date_hold[odbc_result($period_do, 12)] = 4  ;
			$date_hold[odbc_result($period_do, 13)] = 5  ;
			$date_hold[odbc_result($period_do, 14)] = 6  ;
			$date_hold[odbc_result($period_do, 15)] = 7  ;
			$date_hold[odbc_result($period_do, 16)] = 8  ;
			$date_hold[odbc_result($period_do, 17)] = 9  ;
			$date_hold[odbc_result($period_do, 18)] = 10  ;
			$date_hold[odbc_result($period_do, 19)] = 11  ;
			$date_hold[odbc_result($period_do, 20)] = 12  ;
			$date_hold[odbc_result($period_do, 21)] = 13  ;
			$date_hold[odbc_result($period_do, 22)] = 14  ;
			
			$today = date('Y')."-".date('m')."-01" ;

			$place = $date_hold[$today] ;
			
			$query = "SELECT * FROM SupplierMaster WHERE SupplCode = '".$ccode."'" ;
			
			$do = odbc_do($conn, $query) ;
			$cur = odbc_result($do, $place) ;
			
			return $cur ;
		}
		
	}
	
	function getPaidResult($type,$amount,$number,$ctype) {

		$amount = convertToFloat($amount) ;
		
		if ($amount == 0) {
		
			return "R ".$amount."" ;

		} else {
		
			$getPayInfo = mysql_query("SELECT * FROM paid WHERE type = '".$type."' AND number = '".$number."' AND amount = '".$amount."' AND ctype = '".$ctype."'") or die(mysql_error()) ;
			
			if ( (mysql_num_rows($getPayInfo)==0) || (!$getPayInfo) ) {
				
				return "<a href='blotPayment.php?type=".$type."&number=".$number."&amount=".$amount."&where=customer'> R ".$amount."</a>" ;
				
			} else {
			
				$getArray = mysql_fetch_row($getPayInfo) ;
				return "<a href='unblotPayment.php?id=".$getArray['0']."'><span style='background-color:#960000'><font color=white><s>R ".$amount."</s></font></span></a>" ;

			}
		}
	}
	
	function getIsPaidTotal($number,$where,$month,$year) {
		
		$query = mysql_query("SELECT * FROM paid WHERE number = '$number' AND ctype = '$where'") or die(mysql_error());
		$count = mysql_num_rows($query) ;
		$amount = 0 ;
		
		if ($count != 0) {
			while ($getNote = mysql_fetch_row($query)) {
				$date = explode("-",$getNote['5']) ;
				if (($date['0']==$year) && ($date['1']==$month)) {
					$amount += $getNote['4'] ;
				}
			}
		}
	
		return $amount ;
		
	}
	
	function isThisRed($username,$number,$oneFifty,$oneTwenty,$ninety,$sixty,$thirty,$current,$total) {
	
		$zeroclients = getUserData($username,"zeroclients") ;
		$highlight = getUserData($username,"highlight") ;
		
		if ( ( $zeroclients==1 ) && ( $total==0 ) ) {
		
			return true ;
			
		} else {
			
			$end_total = 0 ;
		
			switch ($highlight) {

				case "current" :
					$end_total += ($oneFifty + $oneTwenty + $ninety + $sixty + $thirty + $current) ;
					break;
				case "150" :
					$end_total += $oneFifty  ;
					break;
				case "120" :
					$end_total += ($oneFifty + $oneTwenty ) ;
					break;
				case "90" :
					$end_total += ($oneFifty + $oneTwenty + $ninety ) ;
					break;
				case 60 :
					$end_total += ( $oneFifty + $oneTwenty + $ninety + $sixty ) ;
					break;
				case "30" :
					$end_total += ($oneFifty + $oneTwenty + $ninety + $sixty + $thirty ) ;
					break;
				default :
					return false ;
					break;
			}	

			if ($end_total == 0) {
				return true ;
			} else {
				return false ;
			}		

		}
		
	}
	
	function getSalesManList() {
	
		$conn = connect() ;
		
		if (!$conn) { 
			return false ;
		}
		
		$sqlQuery = "SELECT * FROM SalesmanMaster ORDER BY Description" ;
		$sqlQueryDo = odbc_do($conn, $sqlQuery) ;

		$list = "" ;

		while (odbc_fetch_row($sqlQueryDo)) 
		{
		
			$sm_code = odbc_result($sqlQueryDo, 1) ;
			$sm_desc = odbc_result($sqlQueryDo, 2) ;
			$number_other = rtrim($sm_code) ;

			$list .= "<option value='".$number_other."'>".$sm_desc."</option>";

		}  
		
		return $list ;

	}	
	
	function broughtForward($company,$period,$master,$masterCode) {
		
		$conn = connect() ;
		
		$query = "SELECT * FROM ".$master."Master WHERE ".$masterCode."Code = '".$company."'" ;
		$do = odbc_do($conn, $query) ;
		
		$total = 0 ;

		if ($period != 1) {
			$desPeriod = $period-1 ;
		} else {
			$desPeriod = $period ;
		}
		
		if ($master == "Customer") {
			$inc = 0 ;
		} else {
			$inc = 1 ;
		}
		
		switch ($desPeriod) {
		
			case 112 :
			$total = $total + odbc_result($do, (15-$inc)) ;
			
			case 111 :
			$total = $total + odbc_result($do, (14-$inc)) ;
			
			case 120 :
			$total = $total + odbc_result($do, (13-$inc)) ;
			
			case 109 :
			$total = $total + odbc_result($do, (12-$inc)) ;
			
			case 108 :
			$total = $total + odbc_result($do, (11-$inc)) ;
			
			case 107 :
			$total = $total + odbc_result($do, (10-$inc)) ;
			
			case 106 :
			$total = $total + odbc_result($do, (9-$inc)) ;
			
			case 105 :
			$total = $total + odbc_result($do, (8-$inc)) ;
			
			case 104 :
			$total = $total + odbc_result($do, (7-$inc)) ;
			
			case 103 :
			$total = $total + odbc_result($do, (6-$inc)) ;
			
			case 102 :
			$total = $total + odbc_result($do, (5-$inc)) ;
			
			case 101 :
			$total = $total + odbc_result($do, (4-$inc)) ;
			
			case 12 :
			$total = $total + odbc_result($do, (28-$inc)) ;
			
			case 11 :
			$total = $total + odbc_result($do, (27-$inc)) ;
			
			case 10 :
			$total = $total + odbc_result($do, (26-$inc)) ;
			
			case 9 :
			$total = $total + odbc_result($do, (25-$inc)) ;
			
			case 8 :
			$total = $total + odbc_result($do, (24-$inc)) ;
			
			case 7 :
			$total = $total + odbc_result($do, (23-$inc)) ;
			
			case 6 :
			$total = $total + odbc_result($do, (22-$inc)) ;
			
			case 5 :
			$total = $total + odbc_result($do, (21-$inc)) ;
			
			case 4 :
			$total = $total + odbc_result($do, (20-$inc)) ;
			
			case 3 :
			$total = $total + odbc_result($do, (19-$inc)) ;
			
			case 2 :
			$total = $total + odbc_result($do, (18-$inc)) ;
			
			case 1 :
			$total = $total + odbc_result($do, (17-$inc)) ;
			
		}
		
		return $total ;
		
	}
	
	function getPeriodDate($val) {
	
		$conn = connect() ;
		$sql = "SELECT NumberPeriodsThis,NumberPeriodsLast,PerStartLast01,PerStartLast02,PerStartLast03,PerStartLast04,PerStartLast05,PerStartLast06,PerStartLast07,PerStartLast08,PerStartLast09,PerStartLast10,PerStartLast11,PerStartLast12,PerStartLast13,PerStartThis01,PerStartThis02,PerStartThis03,PerStartThis04,PerStartThis05,PerStartThis06,PerStartThis07,PerStartThis08,PerStartThis09,PerStartThis10,PerStartThis11,PerStartThis12,PerStartThis13 FROM LedgerParameters" ;
		$query = odbc_do($conn, $sql) ;
		
		switch ($val) {
			case "periods_this" :
			return odbc_result($query,1) ;
			break ;
			case "periods_last" :
			return odbc_result($query,2) ;
			break ;
			case "1" :
			return odbc_result($query,3) ;
			break ;
			case "2" :
			return odbc_result($query,4) ;
			break ;
			case "3" :
			return odbc_result($query,5) ;
			break ;
			case "4" :
			return odbc_result($query,6) ;
			break ;
			case "5" :
			return odbc_result($query,7) ;
			break ;
			case "6" :
			return odbc_result($query,8) ;
			break ;
			case "7" :
			return odbc_result($query,9) ;
			break ;
			case "8" :
			return odbc_result($query,10) ;
			break ;
			case "9" :
			return odbc_result($query,11) ;
			break ;
			case "10" :
			return odbc_result($query,12) ;
			break ;
			case "11" :
			return odbc_result($query,13) ;
			break ;
			case "12" :
			return odbc_result($query,14) ;
			break ;
			case "13" :
			return odbc_result($query,15) ;
			break ;
			case "101" :
			return odbc_result($query,16) ;
			break ;
			case "102" :
			return odbc_result($query,17) ;
			break ;
			case "103" :
			return odbc_result($query,18) ;
			break ;
			case "104" :
			return odbc_result($query,19) ;
			break ;
			case "105" :
			return odbc_result($query,20) ;
			break ;
			case "106" :
			return odbc_result($query,21) ;
			break ;
			case "107" :
			return odbc_result($query,22) ;
			break ;
			case "108" :
			return odbc_result($query,23) ;
			break ;
			case "109" :
			return odbc_result($query,24) ;
			break ;
			case "110" :
			return odbc_result($query,25) ;
			break ;
			case "111" :
			return odbc_result($query,26) ;
			break ;
			case "112" :
			return odbc_result($query,27) ;
			break ;
			case "113" :
			return odbc_result($query,28) ;
			break ;
		}
		
	
	}
	
	function returnPeriodArray($var) {
	
		if ($var == "this") {
	
			$periodArray = array() ;
			
			$periodArray[] = "101" ;
			$periodArray[] = "102" ;
			$periodArray[] = "103" ;
			$periodArray[] = "104" ;
			$periodArray[] = "105" ;
			$periodArray[] = "106" ;
			$periodArray[] = "107" ;
			$periodArray[] = "108" ;
			$periodArray[] = "109" ;
			$periodArray[] = "110" ;
			$periodArray[] = "111" ;
			$periodArray[] = "112" ;
			$periodArray[] = "113" ;
			
			return $periodArray  ;
			
		} else if ($var=="last") {
		
			$periodArray = array() ;
			
			$periodArray[] = "1" ;
			$periodArray[] = "2" ;
			$periodArray[] = "3" ;
			$periodArray[] = "4" ;
			$periodArray[] = "5" ;
			$periodArray[] = "6" ;
			$periodArray[] = "7" ;
			$periodArray[] = "8" ;
			$periodArray[] = "9" ;
			$periodArray[] = "10" ;
			$periodArray[] = "11" ;
			$periodArray[] = "12" ;
			$periodArray[] = "13" ;
			
			return $periodArray  ;
			
		}
		
	}
	
	
	function datePeriod($date,$when) {
	
		$getDate = explode("-",$date) ;
		
		$month = $getDate['1'] ;
		$year = $getDate['0'] ;		
		
		$days = array();
		$days['01'] = "January" ;
		$days['02'] = "February" ;
		$days['03'] = "March" ;
		$days['04'] = "April" ;
		$days['05'] = "May" ;
		$days['06'] = "June" ;
		$days['07'] = "July" ;
		$days['08'] = "August" ;
		$days['09'] = "September" ;
		$days['10'] = "October" ;
		$days['11'] = "November" ;
		$days['12'] = "December" ;
		
		
		if ($when == "start") {
			return $year."-".$month."-01" ;
		} 
		
		if ($when == "end") {
			return $days[$month]." ".$year ;
		}
	
	
	
	}
	
	
	
		function getCurrentPeriod() {
	
			$conn = connect() ;	
					
			$period_query = "SELECT CurrentPeriod FROM LedgerParameters" ;
			
			$period_do = odbc_do($conn, $period_query) ;
			
			return odbc_result($period_do,1) ;
			
			odbc_close($conn);
		
		}
		

?>
	
