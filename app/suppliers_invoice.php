<?

	require_once("headers.php") ;
	
	if (!isset($_GET['var_code'])) {
		require_once("navigation.php");
		print( createHeading("Suppliers",0) ) ;	
	} else {
		print ( createHeading("Supplier Details",$_GET['var_code']) ) ;
	}
	

	
	$general_type = "supplier" ;	
	$search = "Supplier" ;
	$page = "suppliers" ;
	
	$given_code = "" ;
	if (isset($_GET['var_code'])) {
		$given_code = $_GET['var_code'] ;
	}
	
		if ($general_type == "customer") {
	
			$full_doc_type = "(DocumentType='3' OR DocumentType='4' OR DocumentType='5' OR DocumentType='102' OR DocumentType='101')" ;
			
	} else if ($general_type == "supplier") {
	
			$full_doc_type = "(DocumentType='7' OR DocumentType='8' OR DocumentType='9' OR DocumentType='10' OR DocumentType='106')" ;
			
	}
	
	$doc_type_options = "<option value='3'>Invoice</option><option value='4'>Credit Note</option>
						 <option value='5'>Debit Note</option><option value='102'>Sales Order</option>
						 <option value='101'>Quotation</option>";
	$year = date('Y');
	
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
	

	

	
	if (!isset($_GET['typedoc'])) {

		print("<script>var dp_cal ;     
			window.onload = function () {
			dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('sdate'),'/');
			dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'),'/');
		   };</script>");
		
		print("<br><b><font color=".TEXT_HEADING.">Search Invoice : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		print("<br><form action=".$page."_invoice.php method=GET>");
		
		if (isset($_GET['code'])) {
			print("<input type=hidden name=close_window value=1>");
		}
		
		print("<table align=center width=100% border=0 cellspacing=0 cellpadding=3>");
		print("<tr><td valign=middle width=50% align=right>Account Name :<td><input type=text name=name size=40 id=name> <a href=javascript:popup(\"ajax/get_".$page."_name.php?field=name\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		print("<tr><td valign=middle width=50% align=right>Account Code :<td><input type=text name=code size=20 value='".$given_code."' id=code> <a href=javascript:popup(\"ajax/get_".$page."_code.php?field=code\",300,300)><img src=img/search_icon.gif border=0></a></tr>");
		print("<tr><td valign=top align=right>Document Type :<td><select name=typedoc[] size=6 MULTIPLE WIDTH=200 STYLE='width: 300px'>");
		print("<option value='all' selected>All</option>");
		print($doc_type_options);
		print("</select>");
		print("<tr><td valign=top align=right>Period : <td><select name=period><option value=''></option>".$period_list."</select>");
		print("<tr><td valign=top align=right>Start Date :<td><input type=text size=25 name=sdate id=sdate>");
		print("<tr><td valign=top align=right>End Date :<td><input type=text size=25 name=edate id=edate>");
		print("<tr><td valign=top align=right><td><br><input type=submit value='Get Invoice'><br><br></tr></table></form>");

	} else {

		$sqlStartQuery = "SELECT * FROM HistoryHeader WHERE" ;
		$sqlMiddleQuery = Array();
		$sql1 = "" ;
		$sqlEndQuery = "ORDER BY CustomerCode" ;

		if ($_GET['name'] != "") {
		
			$ccode = getCompanyCode($_GET['name'],$general_type);
			
			$sqlMiddleQuery[] = "CustomerCode = '".$ccode."'" ;
			
		}
		
		if ($_GET['code'] != "") {
		
			$sqlMiddleQuery[] = "CustomerCode = '".$_GET['code']."'" ;
			
		}
		
		if ($_GET['period'].$_GET['period'] != "") {
		
			$sqlMiddleQuery[] = "PPeriod LIKE '".$_GET['period']."'" ;
			
		}

		if ($_GET['sdate'] != "") {
		
			$sqlMiddleQuery[] = "DocumentDate >= '".$_GET['sdate']."'" ;
			
		}
		
		if ($_GET['edate'] != "") {
		
			$sqlMiddleQuery[] = "ClosingDate <= '".$_GET['edate']."'" ;
			
		}

		if (!in_array("all",$_GET['typedoc'])) {
		
			for ($type_count = 0 ; $type_count < sizeof($_GET['typedoc']) ; $type_count++) {
			
				$sqlMiddleQuery[] = "DocumentType = '".$_GET['typedoc'][$type_count]."'" ;
				
			}
			
		} else {
		
			$sqlMiddleQuery[] = $full_doc_type ; 
			
		}
		
		$sqlMiddleSection = join(" AND ",$sqlMiddleQuery);
		
		if ($sqlMiddleSection == "") {
		
			print("<script>window.history.back();</script>");
			
		} else {
		
			$sql = $sqlStartQuery . " " . $sqlMiddleSection . " " . $sqlEndQuery ;
			
			$_SESSION['sql_invoice'] = $sql ;
			
			if ($_GET['close_window'] == 1) {
					print("<script>window.close();opener.location='".$page."_invoice_get.php';</script>");	
			} else {
					print("<script>window.location='".$page."_invoice_get.php';</script>");	
			}
			
		}

	}
	print("</table>");

	include "foot.php" ;
?>