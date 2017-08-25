<?

	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Inventory",0) ) ;	
	
	$sql_inv = $_SESSION['sql_inv'] ;
	
	$conn = connect() ;
	
	$query = odbc_do($conn, $sql_inv) ;
	
	$page = "inventory" ;
	
	if (!$query) {
	
		print("<font color=red size=1 face=Verdana><b>". odbc_errormsg() ."</b></font>") ;
		
	} else {
	
		$x=0 ;

		$tempCompany = "" ;
		
		print("<br><b><font color=".TEXT_HEADING.">Search Inventory : </font></b><br>");		
		
		print("<br><table width=100% cellspacing=1 cellpadding=2 border=0 bgcolor=#DDDDDD>");
		
		print("<tr bgcolor=#DDDDDD>
		<td><b>COMPANY NAME</b>
		<td><b>COMPANY CODE</b>
		<td><b>DOCUMENT NUMBER</b>
		<td><b>DATE</b>
		<td><b>ITEM CODE</b>
		<td><b>DESCRIPTION</b>
		<td><b>STOCK QUANTITY</b>
		<td><b>PRICE</b>
		</tr>") ;

		while (odbc_fetch_row($query)) 
		{
		
			$x++ ;
			
			$company = rtrim(odbc_result($query, 1)) ;
			$company_name = getCompanyName($company,$_GET['type']) ;
			$number = odbc_result($query, 2) ;
			$date = odbc_result($query, 3) ;
			$description = odbc_result($query, 4) ;
			$unitused = odbc_result($query, 8);
			$qty = convertToFloat(odbc_result($query, 5) * $unitused) ;
			$amount = "R ".convertToFloat(odbc_result($query, 6) * 1.14) ;
			$item = odbc_result($query, 7);

			
			print( createTableRow($x,false) ) ;
			
			print("<td>".$company_name."
				   <td>".$company."
				   <td>".$number."
				   <td>".$date."
				   <td>".$item."
				   <td>".$description."
				   <td>".$qty."
				   <td>".$amount);		   

		
		}
		
		print("</table><br><br>");
		
		if ($x==0) {
		
			print("<br><br><br><center>Sorry, but there are no documents !<br><br><br></center>") ;
		}  

			
	}

	odbc_close($conn);
	print("</table>");

	include "foot.php" ;
?>

