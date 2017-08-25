<?

	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print("<script>docheck();</script>");

	print( createHeading("Customers",0) ) ;	
	
	$sql_invoice = $_SESSION['sql_invoice'] ;
	
	$conn = connect() ;
	
	$query = odbc_do($conn, $sql_invoice) ;
	
	$general_type = "customer" ;	
	
	$page = "customers_compile_docs" ;

	if (!$query) {
	
		print("<font color=red size=1 face=Verdana><b>". odbc_errormsg() ."</b></font>") ;
		
	} else {
	
		$x=0 ;

		print("<form id=form_id name=myform method=post action=".$page.".php>");
		
		$tempCompany = "" ;
		
		print("<br><table width=100% cellspacing=1 cellpadding=2 border=0 bgcolor=#DDDDDD>");
		print("<tr bgcolor=#DDDDDD>
		<td width=20><b>SEND</b>
		<td><b>COMPANY</b>
		<td><b>CODE</b>
		<td><b>DOC.</b>
		<td><b>DATE</b>
		<td><b>AMOUNT</b>
		<td><b>TYPE</b>
		<td><b>E-MAIL</b>
		</tr>") ;

		while (odbc_fetch_row($query)) 
		{
		
			$x++ ;
			
			$company = rtrim(odbc_result($query, 3)) ;
			$company_name = getCompanyName($company,$general_type) ;
			$number = odbc_result($query, 2) ;
			$date = odbc_result($query, 4) ;
			$amount = "R ".convertToFloat(odbc_result($query, 28) * 1.14) ;
			$type = odbc_result($query, 1) ;
			$type_name = getNoteType($type) ;
			$extra = "";
			
			if ($company_name != $tempCompany) {
				$tempCompany = $company_name ;
				$extra = " <input type=checkbox name='email[]' value='".$company."'><input value=' Alternate E-Mail' type=text size=40 name='email_".$company."'>" ;				
			} else {
				$extra = " <input type=checkbox disabled><input value='' type=text size=40 disabled>" ;				
			}
			
			print( createTableRow($x,false) ) ;
			
			print("<td><input type=\"checkbox\" name=\"area[]\" value='".$number.",".$company.",".$type_name."' checked>") ;
			print("<td>".$company_name."<td>".$company."<td>".$number."<td>".$date."<td>".$amount."<td>".$type_name."<td>".$extra);

		
		}
		
		print("</table>");
		
		if ($x==0) {
		
			print("<br><br><br><center>Sorry, but there are no documents !<br><br><br></center>") ;
		}  

			
	}

	odbc_close($conn);
	print("</table>");

?>

<blockquote><br>
<input type=submit value='Compile Documents >>'> 
	<select name=doc_type> <option value='none'>Override Format</option><option value='PDF'>PDF</option><option value='HTML'>HTML</option></select>
	<input type=button value="Check All" onClick="select_all('area', '1');">
	<input type=button value="Uncheck All" onClick="select_all('area', '0');">
	</form>
</div>
</blockquote>
<?
	include "foot.php" ;
?>

