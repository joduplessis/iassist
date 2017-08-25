<?
	require_once("headers.php") ;
	
	
	$query = mysql_query("DELETE FROM inv_codes") or die(mysql_error()) ;
	
	$conn = connect() ;
	$odbc_query = odbc_do($conn,"SELECT * FROM Inventory ORDER BY ItemCode") ;
	$odbc_num = 0 ; 
	
	while (odbc_fetch_row($odbc_query)) {

		$sql = "INSERT INTO inv_codes (code) VALUES ('".mysql_escape_string(odbc_result($odbc_query,2))."')" ;
		
		mysql_query($sql) or die(mysql_error()) ;
	}
	

	odbc_close($conn) ;
	
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd height=100%>");
	print("<tr bgcolor=white><td><table align=center width=100% border=0 cellspacing=0 cellpadding=3 height=100%>");
	print("<tr><td align=center valign=middle><a href=javascript:window.close()><font color=red><b>Inventory updated.<br><br>Click here to close.</b></font></a>");
	print("</tr></table>");

	include "foot.php" ;
?>