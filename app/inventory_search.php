<?

	require_once("headers.php") ;
	
	require_once("navigation.php");

	print( createHeading("Inventory",0) ) ;	
	
	$acc_type_customer = "(HistoryLines.DocumentType='3' OR HistoryLines.DocumentType='4' OR HistoryLines.DocumentType='5' OR HistoryLines.DocumentType='101' OR HistoryLines.DocumentType='102')" ;
	
	$acc_type_supplier = "(HistoryLines.DocumentType='7' OR HistoryLines.DocumentType='8' OR HistoryLines.DocumentType='9' OR HistoryLines.DocumentType='10' OR HistoryLines.DocumentType='106')" ;
	
	$year = date('Y');
	$page = "inventory" ;
	

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
	


			
	if (!isset($_GET['acc_type'])) {
	
		print("<script>var dp_cal ;     
		window.onload = function () {
		dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('sdate'),'/');
		dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'),'/');
	   };</script>");
	
		print("<br><b><font color=".TEXT_HEADING.">Search Inventory : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		
		print("<br><form action=".$page."_search.php method=GET>");
		
		print("<table align=center width=100% border=0 cellspacing=0 cellpadding=3>");
		
		print("<tr><td valign=middle width=50% align=right>Account Type :<td>");
		
		print("<select name=acc_type id=acc_type onChange='setButtonImages(document.getElementById(\"acc_type\").value)'>");
		
		
		
		
		
		
		
		
		
		
		
		$viewtype = getUserData($_SESSION['username'],"view_type") ;
		
		switch ($viewtype) {
		
			case "all" :
				print("<option value=customer>Customer</option>");
				print("<option value=supplier>Supplier</option>");
				print("</select></tr>");
				print("<tr id=c_name_image><td valign=middle width=50% align=right>Account Name :<td><input type=text name=cusname size=40 id=cusname> <a href=javascript:popup(\"ajax/get_customers_name.php?field=cusname\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
				print("<tr id=c_code_image><td valign=middle width=50% align=right>Account Code :<td><input type=text name=cuscode size=20 id=cuscode> <a href=javascript:popup(\"ajax/get_customers_code.php?field=cuscode\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
				print("<tr id=s_name_image style=\"display:none\"><td valign=middle width=50% align=right>Account Name :<td><input type=text name=supname size=40 id=supname> <a href=javascript:popup(\"ajax/get_suppliers_name.php?field=supname\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
				print("<tr id=s_code_image style=\"display:none\"><td valign=middle width=50% align=right>Account Code :<td><input type=text name=supcode size=20 id=supcode> <a href=javascript:popup(\"ajax/get_suppliers_code.php?field=supcode\",300,300)><img src=img/search_icon.gif border=0 ></a></tr>");	
			break ;
			
			case "customer" :
				print("<option value=customer>Customer</option>");
				print("</select></tr>");
				print("<tr id=c_name_image><td valign=middle width=50% align=right>Account Name :<td><input type=text name=cusname size=40 id=cusname> <a href=javascript:popup(\"ajax/get_customers_name.php?field=cusname\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
				print("<tr id=c_code_image><td valign=middle width=50% align=right>Account Code :<td><input type=text name=cuscode size=20 id=cuscode> <a href=javascript:popup(\"ajax/get_customers_code.php?field=cuscode\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
			break ;	
			
			case "supplier" :
				print("<option value=supplier>Supplier</option>");
				print("</select></tr>");
				print("<tr id=s_name_image><td valign=middle width=50% align=right>Account Name :<td><input type=text name=supname size=40 id=supname> <a href=javascript:popup(\"ajax/get_suppliers_name.php?field=supname\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
				print("<tr id=s_code_image><td valign=middle width=50% align=right>Account Code :<td><input type=text name=supcode size=20 id=supcode> <a href=javascript:popup(\"ajax/get_suppliers_code.php?field=supcode\",300,300)><img src=img/search_icon.gif border=0 ></a></tr>");	
			break ;	
			
		}

		
		
		
		
				
		
		
	
		print("<tr><td valign=middle width=50% align=right>Inventory Code Start : <td><input type=text name=inv_code_start size=20 id=inv_code_start> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_start\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		print("<tr><td valign=middle width=50% align=right>Inventory Code End :   <td><input type=text name=inv_code_end   size=20 id=inv_code_end> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_end\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		
		print("<tr><td valign=top align=right>Single Period : <td><select name=period><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>Start Period : <td><select name=speriod><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>End Period : <td><select name=eperiod><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>Start Date :<td><input type=text size=25 name=sdate id=sdate>");
		print("<tr><td valign=top align=right>End Date :<td><input type=text size=25 name=edate id=edate>");
		print("<tr><td valign=top align=right><td><br><input type=submit value='Search Inventory'><br><br></tr></table></form>");

	} else {
	
		$sqlMiddleQuery = array();
		$sql_item = array() ;
		$cat = "" ;
		
		
		
		
		
		
		
		if ($_GET['acc_type'] == "customer") {

			array_push($sqlMiddleQuery,$acc_type_customer) ;
			
			if ($_GET['cuscode'] != "") {
			
				$sqlMiddleQuery[] = "HistoryLines.CustomerCode = '".$_GET['cuscode']."'" ;
				
			}
			
			if ($_GET['cusname'] != "") {
			
				$sqlMiddleQuery[] = "HistoryHeader.CustomerCode = '".getCompanyCode( mysql_escape_string($_GET['cusname']) , $_GET['acc_type'] )."'" ;
				
			}
		
		} else {
		
			array_push($sqlMiddleQuery,$acc_type_supplier) ;
			
			if ($_GET['supcode'] != "") {
			
				$sqlMiddleQuery[] = "HistoryLines.CustomerCode = '".$_GET['supcode']."'" ;
				
			}
			
			if ($_GET['supname'] != "") {
			
				$sqlMiddleQuery[] = "HistoryHeader.CustomerCode = '".getCompanyCode( mysql_escape_string($_GET['supname']) , $_GET['acc_type'] )."'" ;
				
			}
			
		}


		
		
		
		
		
		
		if ($_GET['inv_code_start'] != "") {
		
			$sqlMiddleQuery[] = "HistoryLines.ItemCode >= '".$_GET['inv_code_start']."'" ;
			
		}
		
		if ($_GET['inv_code_end'] != "") {
		
			$sqlMiddleQuery[] = "HistoryLines.ItemCode <= '".$_GET['inv_code_end']."'" ;
			
		}
		
		
		
		
		
		
		

		
		
		if ($_GET['sdate'] != "") {
		
			if ($_GET['sdate'] != "") {
			
				array_push($sqlMiddleQuery,"HistoryLines.DDate >= '".$_GET['sdate']."'") ;
				
			}
			
			if ($_GET['edate'] != "") {
			
				array_push($sqlMiddleQuery,"HistoryLines.DDate <= '".$_GET['edate']."'") ;
				
			}
			
			
		} else {
		
			if ($_GET['period'] != "") {
			
				array_push($sqlMiddleQuery,"HistoryLines.PPeriod = '".$_GET['period']."'") ;
				
			} else {
			
				if ($_GET['speriod'] != "") {
					array_push($sqlMiddleQuery,"HistoryLines.PPeriod >= '".$_GET['speriod']."'") ;
				}
				
				if ($_GET['eperiod'] != "") {
					array_push($sqlMiddleQuery,"HistoryLines.PPeriod <= '".$_GET['eperiod']."'") ;
				}
				
			}
			
		}
		
		
		
		
		
		
			
		$add_search = join(" AND ",$sqlMiddleQuery);
		
		$sql = "SELECT HistoryLines.CustomerCode, HistoryLines.DocumentNumber, HistoryLines.DDate, HistoryLines.Description, HistoryLines.Qty, HistoryLines.InclusivePrice, HistoryLines.ItemCode, HistoryLines.UnitUsed FROM HistoryLines LEFT OUTER JOIN HistoryHeader ON HistoryLines.DocumentNumber = HistoryHeader.DocumentNumber WHERE ".$add_search." ORDER BY HistoryLines.DDate" ;	

		$_SESSION['sql_inv'] = $sql ;
		
		print("<script>window.location='".$page."_search_get.php?type=".$_GET['acc_type']."';</script>");

		
		
		
		
	}
	print("</table>");

	include "foot.php" ;
?>