<?

	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print("<script>docheck();</script>");

	print( createHeading("Suppliers",0) ) ;	
	
	$sql_statement = $_SESSION['sql_statement'] ;

	$conn = connect() ;
	
	$query = odbc_do($conn, $sql_statement) ;
	
	$general_type = "supplier" ;	
	
	$page = "suppliers_compile_sdocs" ;
	
	if (!$query) {
	
		print("<font color=red size=1 face=Verdana><b>". odbc_errormsg() ."</b></font>") ;
		
	} else {
	
		$x=0 ;

		print("<form id=form_id name=myform method=post action=".$page.".php>");
		
		$tempCompany = "" ;
		$tempPeriod = 0 ;
		print("<br><table width=100% cellspacing=1 cellpadding=2 border=0 bgcolor=#DDDDDD>");
		print("<tr bgcolor=#DDDDDD>
		<td width=20><b>SEND</b>
		<td width=120><b>ATTACH INVOICES</b>
		<td><b>COMPANY NAME</b>
		<td><b>COMPANY CODE</b>
		<td><b>PERIOD START</b>
		<td><b>E-MAIL</b>
		</tr>") ;

		while (odbc_fetch_row($query)) 
		{
		
	
			$company = rtrim(odbc_result($query, 1)) ;
			$company_name = getCompanyName($company,$general_type) ;
			$period = odbc_result($query, 2) ;
			
				
			if ($company_name != $tempCompany) {
			
				$tempCompany = $company_name ;
				$extra = " <input type=checkbox name='email[]' value='".$company."'><input value=' Alternate E-Mail' type=text size=40 name='email_".$company."'>" ;				
				
			} else {
			
				$extra = " <input type=checkbox disabled><input value='' type=text size=40 disabled>" ;				
				
			}
			
			
			if ($period != $tempPeriod) {
			
					$x++ ;
				
					print( createTableRow($x,false) ) ;
			
					print("<td><input type=\"checkbox\" name=\"area[]\" value='".$company.",".$period."' checked>") ;
					
					print("<td><input type=\"checkbox\" name=\"invoices[]\" value='".$company.",".$period."'>") ;
					
					print("<td>".$company_name."<td>".$company."<td>".getPeriodDate($period)."<td width=250>".$extra);
					
					$tempPeriod = $period ;

			}
			


		
		}
		
		print("</table>");
		
		if ($x==0) {
		
			print("<br><br><br><center>Sorry, but there are no documents !<br><br><br></center>") ;
			
		}  

			
	}
	print("</table>");

	odbc_close($conn);

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

