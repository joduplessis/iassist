<?

function makeInvoice($doc,$company,$given_format,$header,$odbc_table,$odbc_code,$general_type) {

	$conn = connect() ;
	
	$header = $header ;	
	$doc = $doc ;
	$company = $company ;
	$format = $given_format ;
	$odbc_table = $odbc_table ;
	$odbc_code = $odbc_code ;
	$general_type = $general_type ;

	if (!$conn) { 
		return "<font color=red><b>".odbc_errormsg()."</b></font>"; 
		exit ;
	}

	$var_sql_lines = "SELECT * FROM HistoryLines WHERE DocumentNumber = '".$doc."' ORDER BY LinkNum" ;
	$sql_lines = odbc_do($conn, $var_sql_lines) ;

	$var_sql_header = "SELECT * FROM HistoryHeader WHERE DocumentNumber = '".$doc."'" ;
	$sql_header = odbc_do($conn, $var_sql_header) ;
	
	$var_sql_master = "SELECT PostAddress01,PostAddress02,PostAddress03,PostAddress04,PostAddress05,ExemptRef FROM ".$odbc_table." WHERE ".$odbc_code." = '".$company."'" ;
	$sql_master = odbc_do($conn, $var_sql_master) ;
		
	if ( ($sql_master) && ($sql_header) && ($sql_lines) ) {
	
// GETTING DATA FOM CUSTOMER / SUPPLIER MASTER
		
		$company_name = getCompanyName($company,$general_type) ;
		$address_line01 = odbc_result($sql_master, 1) ;
		$address_line02 = odbc_result($sql_master, 2) ;
		$address_line03 = odbc_result($sql_master, 3) ;
		$address_line04 = odbc_result($sql_master, 4) ;
		$address_line05 = odbc_result($sql_master, 5) ;
		$tex_ref = odbc_result($sql_master, 6) ;

		
// GETTING DATA FOM HISTORY HEADER

		$date = odbc_result($sql_header, 4) ;
		$orderNumber = odbc_result($sql_header, 5) ;
		$salesCode = odbc_result($sql_header, 6) ;

		$msg01 = odbc_result($sql_header, 9) ;
		$msg02 = odbc_result($sql_header, 10) ;
		$msg03 = odbc_result($sql_header, 11) ;

		$total = odbc_result($sql_header, 28) ;
		$totalTax = odbc_result($sql_header, 30) ;
		
		$delAddress01 = odbc_result($sql_header, 12) ;
		$delAddress02 = odbc_result($sql_header, 13) ;
		$delAddress03 = odbc_result($sql_header, 14) ;
		$delAddress04 = odbc_result($sql_header, 15) ;
		$delAddress05 = odbc_result($sql_header, 16) ;
		$freight = odbc_result($sql_header, 38) ;

// GETTING DATA FOM HISTORY LINES

		$x_lines = 0 ;
		$pulled_list = array(); 
		$lines_HTML = "" ;
		
		while (odbc_fetch_row($sql_lines)) {
			
			$x_lines++ ;
						
			$userID = odbc_result($sql_lines, 1) ;
			$docType = odbc_result($sql_lines, 2) ;
			$itemCode = rtrim(odbc_result($sql_lines, 4)) ;
			$description = odbc_result($sql_lines, 14) ;
			$qty = odbc_result($sql_lines, 16) ;
			$unitUsed = odbc_result($sql_lines, 10) ;
			$unitPrice = odbc_result($sql_lines, 17) ;
			$discountPercentage = odbc_result($sql_lines, 13) ;
			$taxAmount = odbc_result($sql_lines, 21) ;
			$discountAmount = odbc_result($sql_lines, 23) ;
			
			if ($itemCode == "'") {
			
				$lines_HTML .= "<tr bgcolor=white>
									<td colspan=8 align=left>
										<font size=2><br><b>".$description."</b></font>
									</td>
								</tr>" ;
				
				$new_pulled_list = array('code'=>'', 
										 'description'=>$description, 
										 'quantity'=>'', 
										 'unit'=>'', 
										 'unitprice'=>'', 
										 'disc'=>'', 
										 'tax'=>'', 
										 'net'=>'');
					 
				array_push($pulled_list, $new_pulled_list) ;
				
			} else {	
			
				$lines_HTML .= "<tr bgcolor=white><td align=center><font size=2>".$itemCode."</font>
									<td align=center><font size=2>".$description."</font>
									<td align=center><font size=2>".convertToFloat($qty)."</font>
									<td align=center><font size=2>".$unitUsed."</font>
									<td align=center><font size=2>".convertToFloat($unitPrice)."</font>
									<td align=center><font size=2>".convertToFloat(($discountPercentage/100))."</font>
									<td align=center><font size=2>".convertToFloat($taxAmount)."</font>
									<td align=center><font size=2>".convertToFloat($discountAmount)."</font>
								</tr>" ;
								
				$new_pulled_list = array('code'=>$itemCode, 
										 'description'=>$description, 
										 'quantity'=>convertToFloat($qty), 
										 'unit'=>$unitUsed, 
										 'unitprice'=>convertToFloat($unitPrice), 
										 'disc'=>convertToFloat(($discountPercentage/100)), 
										 'tax'=>convertToFloat($taxAmount), 
										 'net'=>convertToFloat($discountAmount)) ;
								 
				array_push($pulled_list, $new_pulled_list) ;
												
			}								
					
		}
		
		$settings_pdf = getAssistSettings('pdf') ;
		
		if ($format == "none") {
		
			if ( get_rule($company,$general_type,'pdf') != false ) {
			
				$PDF_verdict = get_rule($company,$general_type,'pdf') ;
				
			} else {
			
				$PDF_verdict = $settings_pdf ;
				
			}
			
		} else {
		
			$PDF_verdict = $format ;
		
		}

// GET DATA FOR MAIN DETAILS 

		$vat = getAssistSettings('vat')  ;
		$ck = getAssistSettings('ck')  ;
		$ad01 = getAssistSettings('ad01')  ;
		$ad02 = getAssistSettings('ad02') ;
		$tel = getAssistSettings('tel') ;
		$fax = getAssistSettings('fax') ;
		$email = getAssistSettings('email') ;
		$url = getAssistSettings('url') ;
		$img = getAssistSettings('img') ;
		$companyName = getAssistSettings('cname') ;

		
// PDF CREATION

		if ( strtolower($PDF_verdict) == "pdf" ) {
		
			$dir = './pdf_files';
			$fname = $dir.'/'.$doc.'.pdf';
			
			if (!is_file($fname)) {
			
				$pdf =& new Cezpdf();
		
				$pdf->selectFont('./fonts/Helvetica.afm');
				
				$pdf->ezStartPageNumbers(300,10,10,'','',1);
				
					$pdf->ezColumnsStart(array('num'=>2,'gap'=>100));
					
					$pdf->ezImage($img,0,150);
				
					$pdf->ezColumnsStop() ;
				
				$pdf->addText(299,800,24,"<b>".$header."</b>");
				
				$pdf->addText(299,785,8,"DATE : ".$date);
				$pdf->addText(299,775,8,"DOCUMENT No : ".$doc);
				$pdf->addText(299,765,8,$ad01);
				$pdf->addText(299,755,8,$ad02);
				$pdf->addText(299,745,8,"Tel : ".$tel.", Fax : ".$fax);
				$pdf->addText(299,735,8,$url.", ".$email);
				$pdf->addText(299,725,8,"VAT No. ".$vat.", CK No. ".$ck);
				
	
// TOP SECTION

				$company_name_temp =  "<b><i>".$company_name."</i></b>" ;
				$top_details = array(
								array('account'=>$company_name_temp, 'order'=>'<b><i>SPECIAL INSTRUCTIONS :</i></b>'),
								array('account'=>'', 'order'=>''),
								array('account'=>$address_line01, 'order'=>$delAddress01),
								array('account'=>$address_line02, 'order'=>$delAddress02),
								array('account'=>$address_line03, 'order'=>$delAddress03),
								array('account'=>$address_line04, 'order'=>$delAddress04),
								array('account'=>$address_line05, 'order'=>$delAddress05),
								array('account'=>'', 'order'=>''),
								array('account'=>'', 'order'=>$freight),
							);
						
				$options_top = array('fontSize' => 8,
								   'showLines'=>1,
								   'showHeadings'=>0,					   
								   'shaded'=>0,
								   'cols'=>array( 'order'=>array('width'=>265) ),
								   'xPos'=>'center',
								   'xOrientation'=>'center',
								   'width'=>530
								) ;
								   
				$pulled_list_top = array('account'=>'CODE','order'=>'DESCRIPTION') ;
								 
				$pdf->ezTable($top_details , $pulled_list_top , '' ,$options_top);				

		
			
// SECTION ABOVE MAIN ENTRIES LIST
			
				$minor_details = array(
							array('account'=>$company, 'order'=>$orderNumber, 'sales'=>$salesCode, 'tax'=>$tex_ref),			
						);
						
				$options_minor = array('fontSize' => 8,
								   'showLines'=>1,
								   'showHeadings'=>1,
								   'shaded'=>0,
								   'xPos'=>'center',
								   'xOrientation'=>'center',
								   'width'=>530) ;
								 
				$minor_details_title = array('account'=>'ACCOUNT No.', 
									   'order'=>'ORDER No.',
									   'sales'=>'SALES CODE',
									   'tax'=>'TAX Ref.') ;
				
				$pdf->ezTable($minor_details , $minor_details_title , ' ' , $options_minor);
			
			
// MAIN HISTORY LINES ENTRIES
			
					
				$options_list = array('fontSize' => 8,
								 'showLines'=>1,
								 'showHeadings'=>1,
								 'shaded'=>1,
								 'xPos'=>'center',
								 'xOrientation'=>'center',
								 'width'=>530) ;
								 
				$pulled_list_title = array('code'=>'CODE', 
									 'description'=>'DESCRIPTION', 
									 'quantity'=>'QUANTITY', 
									 'unit'=>'UNIT', 
									 'unitprice'=>'UNIT PRICE', 
									 'disc'=>'DISC %', 
									 'tax'=>'TAX', 
									 'net'=>'NETT PRICE') ;
				
				$pdf->ezTable($pulled_list , $pulled_list_title , ' ' , $options_list);

// BOTTOM SECTION
			
				$bottom_details = array(
								array('account'=>$msg01, 'order'=>'TOTAL NETT PRICE', 'sales'=>convertToFloat($total)),
								array('account'=>$msg02, 'order'=>'AMOUNT EXCL. TAX', 'sales'=>convertToFloat($total)),
								array('account'=>$msg03, 'order'=>'TAX', 'sales'=>convertToFloat($totalTax)),
								array('account'=>'', 'order'=>'<b>TOTAL</b>', 'sales'=>convertToFloat($totalTax+$total))
							);
						
				$options_bottom = array('fontSize' => 8,
								   'showLines'=>1,
								   'showHeadings'=>0,
								   'cols'=>array( 'order'=>array('width'=>150), 'sales'=>array('width'=>100) ), 
								   'shaded'=>0,
								   'xPos'=>'center',
								   'xOrientation'=>'center',
								   'width'=>530) ;
								   
				$pulled_list_bottom = array('account'=>'CODE', 
									 'order'=>'DESCRIPTION', 
									 'sales'=>'NETT PRICE') ;
								 
				$pdf->ezTable($bottom_details , $pulled_list_bottom , ' ' ,$options_bottom);

				$pdfcode = $pdf->output();

				$fp = fopen($fname,'w');
				fwrite($fp,$pdfcode);
				fclose($fp);
				
			}
			
			print("<img src=img/yes.gif> <a href='".$fname."' target=_blank>Document ".$doc." compiled into ".$PDF_verdict." format successfully.</a><Br>");			
		
			return $fname ;

		}
		
// HTML CREATION

		if ( strtolower($PDF_verdict) == "html" ) {
		
			$dir = './html_files';
			$fname = $dir.'/'.$doc.'.html';
			
			if (!is_file($fname)) {
		
				$htmlcode = "<html>
								<head>
									<title>Document ".$doc.", iAssist.</title>
									<style>
										td {
											font-family: verdana;
										}
									</style>
								</head>
							<body bgcolor=white>
							<table width=100% bgcolor=#777777 cellpadding=10 cellspacing=1>
								<tr bgcolor=white>
									<td width=50% align=center valign=middle><font size=3><b>".$companyName."</b></font><br><br><font size=1><br>".$ad01."<br>".$ad02."<Br>
												Phone : ".$tel."<Br>Fax : ".$fax."<br>E-Mail : ".$email."<br>".$url."
												<br>VAT No. ".$vat.", CK No. ".$ck."</font>
				 
									<td align=center valign=middle>
										<table width=100% bgcolor=white cellpadding=8 cellspacing=1>
											<tr>
												<td colspan=2 align=center><h2>".$header."</h2>
									<!--	<tr>
												<td colspan=2 align=center><h3>SUBJECT TO OUR CONDITIONS OF SALE ON BOTTOM</h3> -->
												
											<tr>
												<td align=center><font size=2><b>DATE</b></font>
												<td align=center><font size=2><b>DOCUMENT No.</b></font>
											<tr>
												<td align=center><font size=1>".$date."</font>
												<td align=center><font size=1>".$doc."</font>
										</table>
								</tr>
								<tr bgcolor=white>
									<td width=50% align=left valign=top>
											<font size=2>".$company_name."<br>
														 ".$address_line01."<br>
														 ".$address_line02."<br>
														 ".$address_line03."<br>
														 ".$address_line04."<br>
														 ".$address_line05."
											</font>
									<td width=50% align=left valign=top>
											<font size=2><b><i>Special Instructions : </i></b><br>
											<table width=100%>
												<tr>
													<td align=left valign=top><font size=2>".$delAddress01."<br>
																						   ".$delAddress02."<br>
																						   ".$delAddress03."<br>
																						   ".$delAddress04."<br>
																						   ".$delAddress05."<br></font>
													<td align=right valign=top><font size=2>Via : ".$freight."</font>
												</tr>
											</table>
								</tr>	
								<tr bgcolor=white>
									<td colspan=2 valign=top>
											<table width=100%>
												<tr bgcolor=#efefef>
													<td align=center><font size=2><b>ACCOUNT No.</b></font>
													<td align=center><font size=2><b>ORDER No.</b></font>
													<td align=center><font size=2><b>SALES CODE</b></font>
													<td align=center><font size=2><b>TAX Ref.</b></font>
												<tr bgcolor=white>
													<td align=center><font size=2>".$company."</font>
													<td align=center><font size=2>".$orderNumber."</font>
													<td align=center><font size=2>".$salesCode."</font>
													<td align=center><font size=2>".$tex_ref."</font>										
											</table>		
								</tr>
								<tr bgcolor=white>
									<td colspan=2 valign=top>
											<table width=100%>
												<tr bgcolor=#efefef>
													<td align=center><font size=2><b>CODE</b></font>
													<td align=center><font size=2><b>DESCRIPTION</b></font>
													<td align=center><font size=2><b>QUANTITY</b></font>
													<td align=center><font size=2><b>UNIT</b></font>
													<td align=center><font size=2><b>UNIT PRICE</b></font>
													<td align=center><font size=2><b>DISC %</b></font>
													<td align=center><font size=2><b>TAX</b></font>
													<td align=center><font size=2><b>NETT PRICE</b></font></tr>
													".$lines_HTML."
											</table>
								</tr>
								<tr bgcolor=white>
									<td width=50% align=left valign=top>
											<font size=2>".$msg01."<br>
														 ".$msg02."<br>
														 ".$msg03."<br>
											</font>
									<td width=50% align=left valign=top>
											<table width=100%>
												<tr>
													<td align=left valign=top><font size=2><b>TOTAL NETT PRICE</b></font>
													<td align=right valign=top><font size=2>".convertToFloat($total)."</font>
												<tr>
													<td align=left valign=top><font size=2><b>AMOUNT EXCL. VAT</b></font>
													<td align=right valign=top><font size=2>".convertToFloat($total)."</font>												
												<tr>
													<td align=left valign=top><font size=2><b>TAX</b></font>
													<td align=right valign=top><font size=2>".convertToFloat($totalTax)."</font>
												<tr>
													<td align=left valign=top><font size=2><b>TOTAL</b></font>
													<td align=right valign=top><font size=2><b>".convertToFloat($totalTax+$total)."</b></font>	
											</table>
								</tr>																	
							</table><br><font face=verdana size=1 color=#cccccc>Compiled by iAssist 1.0</font>
							</body>
							</html>";


				$fp = fopen($fname,'w');
				fwrite($fp,$htmlcode);
				fclose($fp);
				
			}
			
			print("<img src=img/yes.gif> <a href='".$fname."' target=_blank>Document ".$doc." compiled into ".$PDF_verdict." format successfully.</a><br>") ;			
			
			return $fname ;
	
		} 

	} else {

		print("<img src=img/no.gif> Document ".$doc." failed : ".odbc_errormsg()."<br>") ;			
		return false ;
		
	}

}


?>