<?
	require_once("headers.php") ;
	
	if (!isset($_GET['var_code'])) {
	
		require_once("navigation.php");
		print( createHeading("Customers",0) ) ;	
		
	} else {
	
		print ( createHeading("Customer Details",$_GET['var_code']) ) ;
		
	}
	
	$given_code = "" ;
	
	if (isset($_GET['var_code'])) {
		$given_code = $_GET['var_code'] ;
	}
	
	$general_type = "customer" ;
	$search = "Customer" ;
	$page = "customers_analysis" ;
	$ppage = "customers" ;
	
	$cat = makeCategories() ;
	
	if ($general_type == "customer") {
	
			$full_doc_type = "(HistoryLines.DocumentType='3' OR HistoryLines.DocumentType='4' OR HistoryLines.DocumentType='5' OR HistoryLines.DocumentType='102' OR HistoryLines.DocumentType='101')" ;
			
	} else if ($general_type == "supplier") {
	
			$full_doc_type = "(HistoryLines.DocumentType='7' OR HistoryLines.DocumentType='8' OR HistoryLines.DocumentType='9' OR HistoryLines.DocumentType='10' OR HistoryLines.DocumentType='106')" ;
			
	}
	
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
	

	
	if (!isset($_GET['code']) ) {	
	
	
	
		print("<br><b><font color=".TEXT_HEADING.">".$search." Inventory Analysis : </font></b><br><br>");
		print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
		
		print("<script>var dp_cal ;     
				window.onload = function () {
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('sdate'),'/');
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'),'/');
			   };</script>");
		
		print("<form method=GET action='".$page.".php'>");
		
		print("<br>");
		
		print("<table width=100% cellspacing=0 cellpadding=4 border=0>");
		
		print(" <tr><td align=right width=50%>".$search." Name : <td><input type=text size=30 name=name id=name> <a href=javascript:popup(\"ajax/get_".$ppage."_name.php?field=name\",300,300)><img src=img/search_icon.gif border=0></a>
				<tr><td align=right>".$search." Code : <td><input type=text size=30 name=code id=code> <a href=javascript:popup(\"ajax/get_".$ppage."_code.php?field=code\",300,300)><img src=img/search_icon.gif border=0></a>
				<tr><td align=right>Inventory Code Start : <td><input type=text name=inv_code_start size=20 id=inv_code_start> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_start\",300,300)><img src=img/search_icon.gif border=0></a>			
				<tr><td align=right>Inventory Code End : <td><input type=text name=inv_code_end size=20 id=inv_code_end> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_end\",300,300)><img src=img/search_icon.gif border=0></a>
				<tr><td align=right valign=top>Inventory Categories<td><select name=inv_cat size=10 MULTIPLE>".$cat."</select>
				<tr><td align=right>Single Period : <td><select name=period><option value=''></option>".$period_list."</select>
				<tr><td align=right>Start Period : <td><select name=speriod><option value=''></option>".$period_list."</select>
				<tr><td align=right>End Period : <td><select name=eperiod><option value=''></option>".$period_list."</select>
				<tr><td align=right>Start Date : <td><input type=text size=15 name=sdate id=sdate> 
				<tr><td align=right>End Date : <td><input type=text size=15 name=edate id=edate> 
				</table><center><Br><input type=submit value='Analyze'></center><br></form>");
				
		print("</table><br>");
		
		
		
				

	} else {
	
	
		$search_query = "" ;
		
		$sqlMiddleQuery = array() ;
		
		$list_itemcode = array() ;
		$list_unitused =  array() ;
		$list_desc =  array();
		$list_date =  array() ;
		$list_price =  array() ;
		$list_qty =  array() ;
		
		$new_list_itemcode = array() ;
		$new_list_unitused =  array() ;
		$new_list_desc =  array();
		$new_list_date =  array() ;
		$new_list_price =  array() ;
		$new_list_qty =  array() ;		
	
	
		print("<br><b><font color=".TEXT_HEADING.">Analysis : </font></b><br><br>");	
		
		print("<table width=100% cellspacing=0 cellpadding=4 border=0 bgcolor=#DDDDDD><tr bgcolor=#DDDDDD>
		<td width=4%><img src='img/spacer.gif' name='ddIT".$x."Button' id='ddIT".$x."Button'>
		<td width=16%><b>LAST PURCHASED DATE</b>
		<td width=16%><b>ITEMCODE</b>
		<td width=16%><b>DESCRIPTION</b>
		<td width=16%><b>UNITS / QTY</b>
		<td width=16%><b>QTY PURCHASED</b>
		<td width=16%><b>PRICE / UNIT</b>
	   </tr></table>");
	   

		
		if (isset($_GET['inv_cat'])) {
				if ($_GET['inv_cat'] != "") {
			
				for ($y=0;$y < sizeof($_GET['inv_cat']);$y++) {
			
					$sqlMiddleQuery[] = "Inventory.Category = '".$_GET['inv_cat'][$y]."'" ;
				
				}
				
			}
		}
		
		if ($_GET['code'] != "") {
		
			$sqlMiddleQuery[] = "HistoryLines.CustomerCode = '".$_GET['code']."'" ;
			
		}
		
		if ($_GET['name'] != "") {
		
			$sqlMiddleQuery[] = "HistoryLines.CustomerCode = '".getCompanyCode( mysql_escape_string($_GET['name']) , $general_type )."'" ;
			
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
		

		
		$search_query = join(" AND ", $sqlMiddleQuery) ;	
		
		$conn = connect() ;	
		
		if ($_GET['name']=="") {
		
			$company_code = rtrim( $_GET['code'] ) ;
			
		} else {
		
			$company_code = getCompanyCode( mysql_escape_string($_GET['name']) , $general_type ) ;
			
		}
		
		
		
		
		
		
		$sql = "SELECT HistoryLines.ItemCode, HistoryLines.UnitUsed, HistoryLines.UnitPrice, Qty FROM HistoryLines WHERE ".$full_doc_type." AND ".$search_query." AND ItemCode <> '''' ORDER BY ItemCode" ;
			
		$query = odbc_do($conn,$sql) ;
		
		if (!$query) { print(odbc_errormsg()); }
		
		print("<dl class='expandMenu'>");	
		
		
		
		

		
		
		while ( odbc_fetch_row($query) ) {
		
			$list_itemcode[] = rtrim(odbc_result($query, 1)) ;
			$list_unitused[] = rtrim(odbc_result($query, 2)) ;
			$list_desc[] = getInvItem(rtrim(odbc_result($query, 1)),"description") ;
			$list_date[] = rtrim(getLinesItem(rtrim(odbc_result($query, 1)),$company_code,$general_type,"last_purchased")) ;
			$list_price[] = rtrim(odbc_result($query, 3)) ;
			$list_qty[] = rtrim(odbc_result($query, 4)) ;
			
		}
		

		
		for ($x = 0 ; $x < sizeof ($list_itemcode) ; $x++) {
		
			if ( !in_array($list_itemcode[$x], $new_list_itemcode) ) {
			
				$new_list_itemcode[] = $list_itemcode[$x] ;
				$new_list_unitused[] = $list_unitused[$x] ;
				$new_list_desc[] = $list_desc[$x];
				$new_list_date[] = $list_date[$x] ;
				$new_list_price[] = $list_price[$x] ;
				$new_list_qty[] = $list_qty[$x] ;

			}
			
		}		
		
		
		
		
		
		
		
		
		

		for ($y = 0 ; $y < sizeof ($new_list_itemcode) ; $y++) {
		
			$itemcode = $new_list_itemcode[$y] ;
			$unitused = $new_list_unitused[$y] ;
			$description = $new_list_desc[$y] ;
			$last_date_purchased = $new_list_date[$y] ;
			$price_p_unit = $new_list_price[$y] ;
			$qty_pur = $new_list_qty[$y] ;
			
			print("<dt id='dtIT".$y."' onclick='showHideSwitch(\"ddIT".$y."\")'>");
			
			print("<table width=100% cellspacing=0 cellpadding=0 border=0><tr>
				<td width=4%><img src='img/arrow_down.gif' name='ddIT".$y."Button' id='ddIT".$y."Button'>
				<td width=16%>".$last_date_purchased."
				<td width=16%>".$itemcode."
				<td width=16%>".$description."
				<td width=16%>".$unitused."
				<td width=16%>".convertToFloat($qty_pur)."
				<td width=16%>".convertToFloat($price_p_unit)."
				</tr></table>
				</dt>");
			
			

			
			
			
			
			
			print("<dd class='hideSwitch' id='ddIT".$y."'>");
		
			print("<table width=100%>
					<tr>
					<td><b>DATE</b>
					<td><b>INVOICE NUMBER</b>
					<td><b>QTY</b>
					<td><b>EXC. AMOUNT</b>
					<td><b>INC. AMOUNT</b>
					</tr>");
					
					



					
			$sql_sub = "SELECT HistoryLines.DDate, 
							   HistoryLines.DocumentNumber, 
							   HistoryLines.Qty, 
							   HistoryLines.UnitPrice,
							   HistoryLines.InclusivePrice								   
							   FROM HistoryLines LEFT OUTER JOIN Inventory ON 
							   HistoryLines.ItemCode = Inventory.ItemCode WHERE 
							   ".$full_doc_type." AND 
							   ".$search_query." AND 
							   HistoryLines.ItemCode = '".$itemcode."' 
							   ORDER BY HistoryLines.DDate DESC" ;
							   
							   
							   
							   
							   
							   
			$query_sub = odbc_do($conn, $sql_sub) ;
			
			if (!$query_sub) { print(odbc_errormsg()); }
			
			
			
			
			
			
			
			
			while ( odbc_fetch_row($query_sub) ) {
			

				$qty_unit = odbc_result($query_sub,3) * $unitused ;
				$unit_price = odbc_result($query_sub,4) / $unitused ;

				print("<tr bgcolor=white>
						<td>".odbc_result($query_sub,1)."
						<td>".odbc_result($query_sub,2)."
						<td>".$qty_unit."
						<td>R".convertToFloat($unit_price*$unitused)."
						<td>R".convertToFloat(odbc_result($query_sub,5))."
						</tr>");
						
						
	
							
			}
			
			
				
			print("</table>");
			
			print("</dd>");
			


			
			
			
			
			
		}
		
		
		
		
		
		print("</dl>");
		
		odbc_close($conn);
		
		if ($x == 0) {
		
			print( createTableRow($x,false) ) ;	
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd> <tr bgcolor=white><td>");
			print("<center><br><br>Sorry, but no results were returned.<br><br><br></center></tr></table>");
			
		}
		
	}
				
	print("</table>");
	

	include "foot.php" ;
?>

