<?

	require_once("headers.php") ;
	
	$conn = connect() ;	

	$code = $_GET['code'] ; 	
	$general_type = "customer" ;
	$search = "Customer" ;
	$odbc_table = "CustomerMaster" ;
	$odbc_code = "CustomerCode" ;
	$page = "customers_notes" ;
	$pastel_note_type = 1 ;
	$note_table = "notes" ;

	print ( createHeading("Customer Details",$code) ) ;
		
	$company = new companyDetails ;
	$company->setVar($odbc_table,$odbc_code,$general_type,$pastel_note_type) ;
	$company->setCode($code) ;
	$company->makeODBCSelect() ;
	$company->fillVar() ;
	$company->fillNotes();
	
	$note = $company->getItem("notes") ;
	
	if (!isset($_GET['type'])) {
		$type="view" ;
	} else {
		$type=$_GET['type'] ;
	}
	
	
	if ($type=="view") {
	
		print("<br><b><font color=".TEXT_HEADING.">View Notes : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		print("<table width=100% cellspacing=0 cellpadding=5 border=0>");
		if (sizeof($note)==0) {
			print("<tr><td valign=top colspan=3>No Notes");
		} else {
			for ( $y=1 ; $y <= sizeof($note) ; $y++ ) {
				$valn = explode(",",$note[$y]) ;
				print("<tr><td valign=top>".$valn['1']."<td valign=top>R".$valn['2']."<td valign=top><font color=red><b>".$valn['3']."</b></font><td width=60><a href=".$page.".php?type=del&code=".$code."&id=".$valn['0']."><b>Del</b></a> | <a href=".$page.".php?type=edit&code=".$code."&id=".$valn['0']."><b>Edit</b></a>");
			}
		}	
		print("</table>");
		print("</table><br>");
		
		
	}

	if ($type=="add") {
	
		print("<br><b><font color=".TEXT_HEADING.">Add Note : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		
		print("<script>var dp_cal ;     
				window.onload = function () {
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('sdate'),'/');
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'),'/');
		   };</script>");
	
		print("<form action='".$page.".php' method=GET><center>
		<table width=100% border=0 cellspacing=0>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Comments :<td><textarea cols=40 rows=5 name=content></textarea>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Paid Amount : <td><input type=text size=25 name=amount> ( R )</tr>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Notify Start :<td><input type=text size=25 name=sdate id=sdate>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Notify End :<td><input type=text size=25 name=edate id=edate>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Visible to all users ? <td><input type=checkbox size=25 name=see><tr></table>
		
		<input type=hidden name=type value='add_note'>
		<input type=hidden name=code value='".$code."'><br>
		
		<input type=submit value='         Add Note ?         '><br><br>
		</center></form>");
		
		print("</table><br>");
		
	}

	if ($type=="edit") {

		$id = $_GET['id'] ;
		
		print("<br><b><font color=".TEXT_HEADING.">Edit Note : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
		
		print("<script>var dp_cal ;     
				window.onload = function () {
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('sdate'));
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'));
		   };</script>");
	
		print("<form action='".$page.".php' method=GET><center>
		<table width=100% border=0 cellspacing=0>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Comments :<td><textarea cols=40 rows=5 name=content>".getNoteData($id,'content') ."</textarea>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Paid Amount : <td><input type=text size=25 name=amount value='".getNoteData($id,'amount') ."'> ( R )</tr>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Notify Start :<td><input type=text size=25 name=sdate id=sdate value='".getNoteData($id,'start_date') ."'>
		<tr><td align=right valign=top><td><br>
		<tr><td align=right valign=top>Notify End :<td><input type=text size=25 name=edate id=edate value='".getNoteData($id,'end_date') ."'>
		<tr><td align=right valign=top><td><br>");
		
		if (getNoteData($id,'see_all')=="yes") {
			print("<tr><td align=right valign=top>Visible to all users ? <td><input type=checkbox size=25 name=see checked><tr></table>");
		} else {
			print("<tr><td align=right valign=top>Visible to all users ? <td><input type=checkbox size=25 name=see><tr></table>");
		}
		
		print("<input type=hidden name=type value='edit_note'>
		<input type=hidden name=id value='".getNoteData($id,'id') ."'>
		<input type=hidden name=code value='".$code."'><br>
		
		<input type=submit value='         Edit Note ?         '><br><br>
		</center></form>");
		
		print("</table><br>");
		
	}

	if ($type=="add_note") {

		$content = $_GET['content'] ;
		$amount = $_GET['amount'] ;	
		$sdate = $_GET['sdate'] ;
		$edate = $_GET['edate'] ;
				
		if (isset($_GET['see'])) {
			$see = "yes" ;
		} else {
			$see = "no" ;
		}

		if ((($amount/$amount)==1) || ($amount=="")) {

			$addNoteQuery = mysql_query("INSERT INTO $note_table (type,code,user,content,amount,start_date,end_date,created_date,see_all) VALUES ('$general_type','$code','$username','$content','$amount','$sdate','$edate',NOW(),'$see')") ;
			
			if (!$addNoteQuery) {
				print(mysql_error());
			} else {
				print("<script>window.opener.location=window.opener.location ;</script>");
				print("<script>window.location=\"".$page.".php?code=".$code."&type=view\";</script>");
	
			}
		
		} else {
		
			print("<script>alert('Sorry, invalid paid amount type!');window.history.back();</script>") ;
			exit ;
		

		}
		
	}

	if ($type=="edit_note") {
	
		$id = $_GET['id'] ;
	
		$content = $_GET['content'] ;
		$amount = $_GET['amount'] ;	
		$sdate = $_GET['sdate'] ;
		$edate = $_GET['edate'] ;
				
		if (isset($_GET['see'])) {
			$see = "yes" ;
		} else {
			$see = "no" ;
		}

		if ((($amount/$amount)==1) || ($amount=="")) {

			$addNoteQuery = mysql_query("UPDATE $note_table SET type='$general_type', code='$code', user='$username',content='$content',amount='$amount',start_date='$sdate',end_date='$edate', see_all='$see' WHERE id = '$id'") ;
			
			if (!$addNoteQuery) {
				print(mysql_error());
			} else {
				print("<script>window.opener.location=window.opener.location ;</script>");
				print("<script>window.location=\"".$page.".php?code=".$code."&type=view\";</script>");
	
			}
		
		} else {
		
			print("<script>alert('Sorry, invalid paid amount type!');window.history.back();</script>") ;
			exit ;
		

		}
	}
	
	if ($type=="del") {
	
		$id = $_GET['id'] ;
					
		$delNoteQuery = mysql_query("DELETE FROM $note_table WHERE id = '$id'") ;
		
		if (!$delNoteQuery) {
			print(mysql_error());
		} else {
			print("<script>window.opener.location=window.opener.location ;</script>");
			print("<script>window.location=\"".$page.".php?type=view&code=".$code."\";</script>");
		}
	}
	
	print("<tr><td><b><blockquote><a href=\"".$page.".php?type=add&code=".$code."\">Add Note</a></b> | <b><a href=\"".$page.".php?type=view&code=".$code."\">View Notes</a></b></blockquote></tr></table>");
	

			

?>
