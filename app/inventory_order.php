<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Inventory",0) ) ;	
		
	$page = "inventory_order" ;
	
	$store_list = getStores() ;	
	
	
	
	

	
	
	if ((!isset($_GET['inv_code_start'])) || (($_GET['inv_code_start']=="") || ($_GET['inv_code_end']==""))) {	
	
	
	
	
		print("<br><b><font color=".TEXT_HEADING.">Stock Order Analysis : </font></b><br><br>");
		print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
		
		print("<form method=GET action='".$page.".php'>");
		
		print("<br>");
		
		print("<table width=100% cellspacing=0 cellpadding=4 border=0>");
		
		print(" <tr><td align=right width=50%>Inventory Code Start : <td><input type=text name=inv_code_start size=10 id=inv_code_start> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_start\",300,300)><img src=img/search_icon.gif border=0></a>			
				<tr><td align=right>Inventory Code End : <td><input type=text name=inv_code_end size=10 id=inv_code_end> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_end\",300,300)><img src=img/search_icon.gif border=0></a>			
				<tr><td align=right>Store : <td><select name=store>".$store_list."</select>
				</table><center><Br><input type=submit value='Analyze'></center><br></form>");
				
		print("</table><br>");
		
		
		
		
				

	} else {
	
	
		print("<bR>");
		
		$conn = connect() ;
		

	
	
	
	

	
		
			
		if ($_GET['inv_code_start'] != "") {
		
			$sqlQuery[] = "ItemCode >= '".$_GET['inv_code_start']."'" ;
			
		}
		
		if ($_GET['inv_code_end'] != "") {
		
			$sqlQuery[] = "ItemCode <= '".$_GET['inv_code_end']."'" ;
			
		}	

		if ($_GET['store']=="") {
		
			$storeArray = getStoresArray() ;
			
			for ($sx = 0 ; $sx < sizeof($storeArray) ; $sx++) {
			
				$sqlQuery[] = "StoreCode <> '".$storeArray[$sx]."'" ;
				
			}
			
		} else {
	
			$sqlQuery[] = "StoreCode = '".$_GET['store']."'" ;
		
		}








		
		
		$search_query = join(" AND ",$sqlQuery) ;

		$sql = "SELECT ReorderLevel,
					   MaximumLevel,
					   OpeningQty,
					   ActualQty,
					   ItemCode FROM MultiStoreTrn WHERE ".$search_query." ORDER BY ItemCode" ;	

		$query = odbc_do($conn,$sql) ;

		if ( !$query ) { print(odbc_errormsg()); }
		
		


		

		
		while (odbc_fetch_row($query)) {
		
			print("<b><font color=".TEXT_HEADING.">Stock Order Analysis For ".$itemcode." </font></a></b><br><br>");
			
			print("<table  width=90% id=mat cellspacing=1 cellpadding=10 border=0 bgcolor=white align=center ><tr bgcolor=white><td>");				

			print("ReorderLevel : : <b>".odbc_result($query,1)."</b><br>");
			print("MaximumLevel : <b>".odbc_result($query,2)."</b><br>") ;
			print("OpeningQty : <b>".odbc_result($query,3)."</b><br>");
			print("ActualQty : <b>".odbc_result($query,4)."</b><br>");
			print("ItemCode : <b>".odbc_result($query,5)."</b><br><br>");
			
			print("</table><br>");

		}
		
		
		
		
		
		
		
		
		

		
		odbc_close($conn);
		
		
	}
				
	print("</table><br><bR>");
	

	include "foot.php" ;
?>

