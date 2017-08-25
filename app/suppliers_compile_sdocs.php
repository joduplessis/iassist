<?

	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Suppliers",0) ) ;	

	$general_type = "supplier" ;	
	$page = "suppliers_email_docs" ;
	$odbc_table = "SupplierMaster" ;
	$odbc_code = "SupplCode" ;
	
	
	
	if ($general_type == "customer") {
	
			$full_doc_type = "(DocumentType='3' OR DocumentType='4' OR DocumentType='5' OR DocumentType='102' OR DocumentType='101')" ;
			
	} else if ($general_type == "supplier") {
	
			$full_doc_type = "(DocumentType='7' OR DocumentType='8' OR DocumentType='9' OR DocumentType='10' OR DocumentType='106')" ;
			
	}
	
	$_SESSION['emails'] = array() ;
	$_SESSION['files'] = array() ;
	
	$form = "<form action=".$page.".php method=POST enctype='multipart/form-data'>
			<table width=100% border=0 cellpadding=2 cellspacing=1 bgcolor=#FFFFFF>
		          <tr bgcolor=#FFFFFF> 
		            <td width=120><div align=right>Subject : </div></td>
		            <td><input name=subject type=text id=towns size=40 maxlength=80></td>
		          </tr>
				  <tr bgcolor=#FFFFFF><td valign=top>&nbsp;</td><td></td></tr>
				  <tr bgcolor=#FFFFFF> 
		            <td valign=top><div align=right>E-Mail Content : </div></td>
		            <td><textarea id=elm1 name=content cols=60 rows=10></textarea></td>
				  </tr>
				  <tr bgcolor=#FFFFFF><td valign=top>&nbsp;</td><td></td></tr>
				  <tr bgcolor=#FFFFFF> 
		            <td valign=top><div align=right>Extra Attachment : </div></td>
		            <td><input name=extra type=file id=extra></td>
		          </tr>
				  <tr bgcolor=#FFFFFF> 
		            <td></td>
					<td><br><input type=submit value='Send Documents'> <input type=button value=Back onclick='javascript:window.history.back()'></td></form>
				</table><br>" ;
				
				
// here we get the emails entered on the previous page - we still need to check for rules and everything else
// but the emails take priority

	if (isset($_POST['email'])) {
	
		$email_array = $_POST['email'] ;	

		for ($y = 0 ; $y < sizeof($email_array) ; $y++) {
		
			$email_id = $email_array[$y] ;
			
			$email_field = "email_".$email_id ;
			
			$mail_address = $_POST[$email_field] ;

			if ( !isset($_SESSION['emails'][$email_id]) ) {	
			
				if ($mail_address != "") {
				
					$_SESSION['emails'][$email_id] = $mail_address ;
					
				} 
				
			}
			
		}	
		
	}				

	
// here we create the documents

	print("<table width=100% cellspacing=1 cellpadding=20 border=0>");
	print("<tr bgcolor=white><td width=50% valign=top>");
	
	$given_format = "" ;
	
	if (isset($_POST['area'])) {
	
		$given_format = $_POST['doc_type'] ;
		$anchor = 0 ;
		$doc = "" ;
		print("<table width=100% cellspacing=1 cellpadding=20 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td>");
			
		for ($x = 0 ; $x < sizeof($_POST['area']) ; $x++) {
		
			$invoice_list = explode(",",$_POST['area'][$x]) ;
			
			$company = $invoice_list['0'] ;
			
			$period = $invoice_list['1'] ;
			
			if ($doc=="") {
			
				$doc = time() ;
				
			}
			
			
			
		
			$file = makeStatement($company,$given_format,$period,$odbc_table,$odbc_code,$general_type) ;
			
			$get_rule = get_rule($company,$general_type,'email') ;	
			
			$get_odbc_mail = get_odbc_email($company,$general_type);
			
			if ( !isset($_SESSION['emails'][$company]) ) {
			
				if ($get_rule != false) {
				
					$_SESSION['emails'][$company] = $get_rule ;
					
				} else if ($get_odbc_mail != "") {
				
					$_SESSION['emails'][$company] = $get_odbc_mail ;
					
				} else {
				
					$_SESSION['emails'][$company] = "" ;
					
				}
				
			}

			if ($file != false) {
			
				$_SESSION['files'][$x] = $company.",".$file ;
				
			}
			
			$anchor++ ;	
			
			
		}
		
		
		
		
		
		
		
		
		if (isset($_POST['invoices'])) {
		
				$conn = connect() ;
			
				for ($z = 0 ; $z < sizeof($_POST['invoices']) ; $z++) {
					
					$get_inv_data = explode(",",$_POST['invoices'][$z]) ;
					$invcompany = $get_inv_data['0'] ;
					$pperiod = $get_inv_data['1'] ;
					
					$sql = "SELECT DocumentNumber, DocumentType FROM HistoryHeader WHERE PPeriod = ".$pperiod." AND ".$full_doc_type." AND CustomerCode = '".$invcompany."' ORDER BY DocumentDate" ;
					
					$query = odbc_do($conn,$sql);
					
					print("<blockquote>");
					
					print("<b>Document ".$invcompany.$pperiod."</b><br><br>");
					
					while (odbc_fetch_row($query)) {
					
						$doc = odbc_result($query, 1) ;
						$header = getNoteType(odbc_result($query, 2)) ;
						$ifile = makeInvoice($doc,$invcompany,$given_format,$header,$odbc_table,$odbc_code,$general_type) ;
						
						if ($file != false) {
							$_SESSION['files'][$anchor] = $invcompany.",".$ifile ;
						}
						
						$anchor++ ;
					
					}
					
					print("</blockquote>");
					
				}	

				odbc_close($conn);
				
			}
		
		
		
		

		
		
		
		
		print("</table><br>");
		
	}

	print("<td valign=top align=right>".$form."</table>");
		print("</table>");
		
	include "foot.php" ;
	
?>