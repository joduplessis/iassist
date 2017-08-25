<?
	require_once('../config/var.php');	
	require_once('../lib/database.php');
	require_once('../lib/settings.php');
	
	if (!db_connect()) {
		print(mysql_error()) ;
		exit ;
	}
	
	$type = $_GET['type'] ;
	$val = $_GET['val'] ;	
	
	switch ($type) {
	
		case "cname":
		
			$x = 1 ;
			$conn = connect() ;	
			$sql = "SELECT TOP 10 CustomerDesc FROM CustomerMaster WHERE CustomerDesc LIKE '%".$val."%'" ;
			$do = odbc_do($conn,$sql) ;
			echo '<table width=100% cellspacing=2 bgcolor=#eeeeee>' ;
			
			while(odbc_fetch_row($do)) {
				print("<tr id='row".$x."' onMouseOver=\"document.getElementById('row".$x."').style.backgroundColor='#dddddd'\" onMouseOut=\"document.getElementById('row".$x."').style.backgroundColor='#eeeeee'\" onClick=\"document.getElementById('query').value = document.getElementById('row".$x."_val').value ; document.getElementById('search-results').style.display='none';\"><td><input type=hidden name=none id='row".$x."_val' value='".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."'>".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."</tr>");
				$x++ ;
			}
			
			if ($x==1) {
				print("<tr id='row".$x."'><td><input type=hidden name=none id='row".$x."_val' value='There are no matches.'>There are no matches.</tr>");
			}
			
			echo '</table>' ;
			odbc_close($conn) ;
			
		break ;
		
		case "ccode":
		
			$x = 1 ;
			$conn = connect() ;	
			$sql = "SELECT TOP 10 CustomerCode FROM CustomerMaster WHERE CustomerCode LIKE '%".$val."%'" ;
			$do = odbc_do($conn,$sql) ;
			echo '<table width=100% cellspacing=2 bgcolor=#eeeeee>' ;
			
			while(odbc_fetch_row($do)) {
				print("<tr id='row".$x."' onMouseOver=\"document.getElementById('row".$x."').style.backgroundColor='#dddddd'\" onMouseOut=\"document.getElementById('row".$x."').style.backgroundColor='#eeeeee'\" onClick=\"document.getElementById('query').value = document.getElementById('row".$x."_val').value ; document.getElementById('search-results').style.display='none';\"><td><input type=hidden name=none id='row".$x."_val' value='".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."'>".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."</tr>");
				$x++ ;
			}
			
			if ($x==1) {
				print("<tr id='row".$x."'><td><input type=hidden name=none id='row".$x."_val' value='There are no matches.'>There are no matches.</tr>");
			}
			
			echo '</table>' ;
			odbc_close($conn) ;
			
		break ;
		
		
		
		
		case "sname":
		
			$x = 1 ;
			$conn = connect() ;	
			$sql = "SELECT TOP 10 SupplDesc FROM SupplierMaster WHERE SupplDesc LIKE '%".$val."%'" ;
			$do = odbc_do($conn,$sql) ;
			echo '<table width=100% cellspacing=2 bgcolor=#eeeeee>' ;
			
			while(odbc_fetch_row($do)) {
				print("<tr id='row".$x."' onMouseOver=\"document.getElementById('row".$x."').style.backgroundColor='#dddddd'\" onMouseOut=\"document.getElementById('row".$x."').style.backgroundColor='#eeeeee'\" onClick=\"document.getElementById('query').value = document.getElementById('row".$x."_val').value ; document.getElementById('search-results').style.display='none';\"><td><input type=hidden name=none id='row".$x."_val' value='".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."'>".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."</tr>");
				$x++ ;
			}
			
			if ($x==1) {
				print("<tr id='row".$x."'><td><input type=hidden name=none id='row".$x."_val' value='There are no matches.'>There are no matches.</tr>");
			}
			
			echo '</table>' ;
			odbc_close($conn) ;
			
		break ;
		
		case "scode":
		
			$x = 1 ;
			$conn = connect() ;	
			$sql = "SELECT TOP 10 SupplCode FROM SupplierMaster WHERE SupplCode LIKE '%".$val."%'" ;
			$do = odbc_do($conn,$sql) ;
			echo '<table width=100% cellspacing=2 bgcolor=#eeeeee>' ;
			
			while(odbc_fetch_row($do)) {
				print("<tr id='row".$x."' onMouseOver=\"document.getElementById('row".$x."').style.backgroundColor='#dddddd'\" onMouseOut=\"document.getElementById('row".$x."').style.backgroundColor='#eeeeee'\" onClick=\"document.getElementById('query').value = document.getElementById('row".$x."_val').value ; document.getElementById('search-results').style.display='none';\"><td><input type=hidden name=none id='row".$x."_val' value='".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."'>".rtrim(mysql_real_escape_string(odbc_result($do, 1)))."</tr>");
				$x++ ;
			}
			
			if ($x==1) {
				print("<tr id='row".$x."'><td><input type=hidden name=none id='row".$x."_val' value='There are no matches.'>There are no matches.</tr>");
			}
			
			echo '</table>' ;
			odbc_close($conn) ;
			
		break ;
		
		
		case "inv":
		
			$x = 1 ;
			$sql = "SELECT code FROM inv_codes WHERE code LIKE '%".$val."%' LIMIT 1,10" ;
			$do = mysql_query($sql) ;
			
			echo '<table width=100% cellspacing=2 bgcolor=#eeeeee>' ;
			
			while($list = mysql_fetch_row($do)) {
				print("<tr id='row".$x."' onMouseOver=\"document.getElementById('row".$x."').style.backgroundColor='#dddddd'\" onMouseOut=\"document.getElementById('row".$x."').style.backgroundColor='#eeeeee'\" onClick=\"document.getElementById('query').value = document.getElementById('row".$x."_val').value ; document.getElementById('search-results').style.display='none';\"><td><input type=hidden name=none id='row".$x."_val' value='".rtrim(mysql_real_escape_string($list['0']))."'>".rtrim(mysql_real_escape_string($list['0']))."</tr>");
				$x++ ;
			}
			
			if ($x==1) {
				print("<tr id='row".$x."'><td><input type=hidden name=none id='row".$x."_val' value='There are no matches.'>There are no matches.</tr>");
			}
			
			echo '</table>' ;
			
		break ;

	}		

	

		
		
		


	
	
	
	




?>