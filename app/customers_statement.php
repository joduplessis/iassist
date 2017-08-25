<?

	require_once("headers.php") ;
	
	if (!isset($_GET['var_code'])) {
		require_once("navigation.php");
		print( createHeading("Customers",0) ) ;	
	} else {
		print ( createHeading("Customer Details",$_GET['var_code']) ) ;
	}
	
	$general_type = "customer" ;	
	$search = "Customer" ;
	$page = "customers" ;
	
	$given_code = "" ;
	if (isset($_GET['var_code'])) {
		$given_code = $_GET['var_code'] ;
	}
	
	if ($general_type == "customer") {
	
			$full_doc_type = "(HistoryHeader.DocumentType='3' OR HistoryHeader.DocumentType='4' OR HistoryHeader.DocumentType='5' OR HistoryHeader.DocumentType='102' OR HistoryHeader.DocumentType='101')" ;
			
	} else if ($general_type == "supplier") {
	
			$full_doc_type = "(HistoryHeader.DocumentType='7' OR HistoryHeader.DocumentType='8' OR HistoryHeader.DocumentType='9' OR HistoryHeader.DocumentType='10' OR HistoryHeader.DocumentType='106')" ;
			
	}
	
	$year = date('Y');
	$listCat = getCategories("Customer") ;
	
	$periodThisArray = returnPeriodArray("this") ;
	$periodLastArray = returnPeriodArray("last") ;
	
	$periods_this = getPeriodDate("periods_this") ;
	$periods_last = getPeriodDate("periods_last") ;
	
	$period_list = "" ;
	for ( $x=0 ; $x < $periods_last ; $x++ ) {
		$period_list .= "<option value='".$periodLastArray[$x]."'>Period ".($x+1)." : (last cycle)  ".datePeriod( getPeriodDate($periodLastArray[$x]) , "end" )."</option>" ;
	}	
	for ( $x=0 ; $x < $periods_this ; $x++ ) {
		$period_list .= "<option value='".$periodThisArray[$x]."'>Period ".($x+1)." (this cycle) : ".datePeriod( getPeriodDate($periodThisArray[$x]) , "end" )."</option>" ;
	}
	


			
	if (!isset($_GET['code'])) {
	

		print("<br><b><font color=".TEXT_HEADING.">Search Statement : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		
		print("<br><form action=".$page."_statement.php method=GET>");
		
		if (isset($_GET['code'])) {
			print("<input type=hidden name=close_window value=1>");
		}
		
		print("<table align=center width=100% border=0 cellspacing=0 cellpadding=3>");
		print("<tr><td valign=middle width=50% align=right>Account Name :<td><input type=text name=name size=40 id=name> <a href=javascript:popup(\"ajax/get_".$page."_name.php?field=name\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		print("<tr><td valign=middle width=50% align=right>Account Code :<td><input type=text name=code size=20 value='".$given_code."' id=code> <a href=javascript:popup(\"ajax/get_".$page."_code.php?field=code\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		
		if ($general_type=="customer") {
		
			print("<tr><td valign=top align=right>Categories :<td><select name=cat[] size=6 MULTIPLE WIDTH=200 STYLE='width: 300px'>");
			print("<option value='all' selected>All</option>".$listCat."</select>");
			
		}
		
		print("<tr><td valign=top align=right>Single Period : <td><select name=period><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>Start Period : <td><select name=speriod><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>End Period : <td><select name=eperiod><option value=''></option>".$period_list."</select>");
		
		print("<tr><td valign=top align=right><td><br><input type=submit value='Get Statement'><br><br></tr></table></form>");

	} else {
	
		$sqlMiddleQuery = array();
		$sql_item = array() ;
		$cat = "" ;

		if ($_GET['code'] != "") {
		
			$sqlMiddleQuery[] = "HistoryHeader.CustomerCode = '".$_GET['code']."'" ;
			
		}
		
		if ($_GET['name'] != "") {
			$sqlMiddleQuery[] = "HistoryHeader.CustomerCode = '".getCompanyCode( mysql_escape_string($_GET['name']) , $general_type )."'" ;
		}
		
		if ($_GET['period'] != "") {
		
			array_push($sqlMiddleQuery,"HistoryHeader.PPeriod = '".$_GET['period']."'") ;
			
		} else {
		
			if ($_GET['speriod'] != "") {
				array_push($sqlMiddleQuery,"HistoryHeader.PPeriod >= '".$_GET['speriod']."'") ;
			}
			
			if ($_GET['eperiod'] != "") {
				array_push($sqlMiddleQuery,"HistoryHeader.PPeriod <= '".$_GET['eperiod']."'") ;
			}
			
		}
			
		if (!in_array("all",$_GET['cat'])) {
		
			for ($x = 0 ; $x < sizeof($_GET['cat']) ; $x++) {
			
				array_push($sql_item,"CustomerMaster.Category = '".$_GET['cat'][$x]."'") ;

			}
			
			$cat = "(" . join(" OR ",$sql_item) . ")" ;
			
			if ($general_type == "customer") {	
		
				array_push($sqlMiddleQuery,$cat) ;
				
			}


		} 
		

		
		array_push($sqlMiddleQuery,$full_doc_type) ;
		
		$add_search = join(" AND ",$sqlMiddleQuery);
		
		
		if ($general_type=="customer") {
		
			$sql = "SELECT HistoryHeader.CustomerCode, HistoryHeader.PPeriod FROM HistoryHeader LEFT OUTER JOIN CustomerMaster ON HistoryHeader.CustomerCode = CustomerMaster.CustomerCode WHERE ".$add_search." ORDER BY HistoryHeader.PPeriod" ;	
	
		} else if ($general_type="supplier") {
		
			$sql = "SELECT HistoryHeader.CustomerCode, HistoryHeader.PPeriod FROM HistoryHeader WHERE ".$add_search." ORDER BY HistoryHeader.PPeriod" ;	
	
		} 	
		
		
		$_SESSION['sql_statement'] = $sql ;
		
		if ($_GET['close_window'] == 1) {
			print("<script>window.close();opener.location='".$page."_statement_get.php';</script>");
		} else {
			print("<script>window.location='".$page."_statement_get.php';</script>");
		}

	}
	print("</table>");

	include "foot.php" ;
?>