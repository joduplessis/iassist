<?

	require_once("headers.php") ;
	
	$conn = connect() ;	

	$code = $_GET['code'] ; 	
	$general_type = "customer" ;
	$search = "Customer" ;
	$odbc_table = "CustomerMaster" ;
	$odbc_code = "CustomerCode" ;
	$pastel_note_type = 1 ;
	
	print ( createHeading("Customer Details",$code) ) ;
	
	$company = new companyDetails ;
	$company->setVar($odbc_table,$odbc_code,$general_type,$pastel_note_type) ;
	$company->setCode($code) ;
	$company->makeODBCSelect() ;
	$company->fillVar() ;
	$company->fillPastelNotes();
	$company->fillNotes();
	
	$pnote = $company->getItem("pastel_notes") ;
	$note = $company->getItem("notes") ;
	
	print("<br><b><font color=".TEXT_HEADING.">Viewing details for ".$company->getItem("name")." : </font></b><br><br>");
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td>");
	print("<table width=100% cellspacing=0 cellpadding=5 border=0>");
	print("<tr>");
	print("<td align=right valign=top width=100><b>".$search." Name : </b><td valign=top>".$company->getItem("name"));
		print("<td align=right valign=top width=120><b>Rep : </b><td valign=top>".$company->getItem("rep"));
	print("<tr>");	
	print("<td align=right valign=top><b>Contact : </b><td valign=top>".$company->getItem("contact"));
		print("<td align=right valign=top><b>Cell : </b><td valign=top>".$company->getItem("cell"));
	print("<tr>");	
	print("<td align=right valign=top><b>Tel : </b><td valign=top>".$company->getItem("tel"));
		print("<td align=right valign=top><b>Fax : </b><td valign=top>".$company->getItem("fax"));
	print("<tr>");	
	print("<td align=right valign=top><b>Last Credited Date : </b><td valign=top>".$company->getItem("last_date_paid"));
		print("<td align=right valign=top><b>Last Amount Paid : </b><td valign=top>".$company->getItem("last_amount_paid"));
	print("<tr>");	
	print("<td align=right valign=top><b>Credit Limit : </b><td valign=top>".$company->getItem("credit_limit"));
		print("<td align=right valign=top><b>150+ Days : </b><td valign=top>".$company->getItem("150"));
	print("<tr>");	
	print("<td align=right valign=top><b>120 Days : </b><td valign=top>".$company->getItem("120"));
		print("<td align=right valign=top><b>60 Days : </b><td valign=top>".$company->getItem("60"));
	print("<tr>");	
	print("<td align=right valign=top><b>90 Days : </b><td valign=top>".$company->getItem("90"));
		print("<td align=right valign=top><b>30 Days : </b><td valign=top>".$company->getItem("30"));
	print("<tr>");	
	print("<td align=right valign=top><b>Current : </b><td valign=top>".$company->getItem("current"));
		print("<td align=right valign=top><b>Total : </b><td valign=top>".$company->getItem("total"));		
	print("</table>");
	print("</table><br>");
	
	

	print("<b><font color=".TEXT_HEADING.">General Notes : </font></b><br><br>");
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td>");
	print("<table width=100% cellspacing=0 cellpadding=5 border=0>");
	if (sizeof($note)==0) {
		print("<tr><td valign=top colspan=3>No Notes");
	} else {
		for ( $y=1 ; $y <= sizeof($note) ; $y++ ) {
			$valn = explode(",",$note[$y]) ;
			print("<tr><td valign=top>".$valn['1']."<td valign=top>R".$valn['2']."<td valign=top><font color=red><b>".$valn['3']."</b></font>");
		}
	}	
	print("</table>");
	print("</table><br>");
	

	
	print("<b><font color=".TEXT_HEADING.">Notes From Pastel : </font></b><br><br>");
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td>");
	print("<table width=100% cellspacing=0 cellpadding=5 border=0>");
	if (sizeof($pnote)==0) {
		print("<tr><td valign=top colspan=3>No Notes");
	} else {
		for ( $x=1 ; $x <= sizeof($pnote) ; $x++ ) {
			$val = explode(",",$pnote[$x]) ;
			print("<tr><td valign=top>".$val['0']."<td valign=top>".$val['1']."<td valign=top><font color=red><b>".$val['2']."</b></font>");
		}
	}
	print("</table>");
	print("</table><br>");
	
	
	
	$company->closeODBC() ;
	
?>