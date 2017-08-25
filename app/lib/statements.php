<?

function makeStatement($company,$given_format,$period,$odbc_table,$odbc_code,$general_type) {

	$conn = connect() ;

	$period = $period ;	
	$company = $company ;
	$format = $given_format ;
	$odbc_table = $odbc_table ;
	$odbc_code = $odbc_code ;
	$general_type = $general_type ;
	$lines_HTML = "" ;
	
	if ( !$conn ) { 
		print("<font color=red size=1><b>Sorry, DOC #".$doc_id." has failed, please contact iAssist administator ! <br>::odbc_msg::".odbc_errormsg()."::</b></font><br>"); 
	}

	$sqlQueryHeader = "SELECT * FROM LedgerTransactions WHERE AccNumber = '".$company."' AND PPeriod = '".$period."' ORDER BY DDate" ;
	$sqlQueryDoHeader = odbc_do($conn, $sqlQueryHeader) ;
	
	$var_sql_master = "SELECT PostAddress01,PostAddress02,PostAddress03,PostAddress04,PostAddress05,ExemptRef FROM ".$odbc_table." WHERE ".$odbc_code." = '".$company."'" ;
	$sql_master = odbc_do($conn, $var_sql_master) ;
		
	if ( ($sqlQueryDoHeader) && ($sql_master) ) {
	
// GETTING DATA FOM CUSTOMER / SUPPLIER MASTER

		$company_name = getCompanyName($company,$general_type) ;
		$address_line01 = odbc_result($sql_master, 1) ;
		$address_line02 = odbc_result($sql_master, 2) ;
		$address_line03 = odbc_result($sql_master, 3) ;
		$address_line04 = odbc_result($sql_master, 4) ;
		$address_line05 = odbc_result($sql_master, 5) ;
		$tex_ref = odbc_result($sql_master, 6) ;
		
// GETTING DATA FROM HISTORY HEADER

		$x_lines = 0 ;
		
		$pulled_list = array(); 
		
		while (odbc_fetch_row($sqlQueryDoHeader)) {
		
			$x_lines++ ;
						
			$date = odbc_result($sqlQueryDoHeader, 7) ;			
			$reference = odbc_result($sqlQueryDoHeader, 9) ;			
			$description = odbc_result($sqlQueryDoHeader, 18) ;			 
			$amount = convertToFloat(odbc_result($sqlQueryDoHeader, 11));
		
			$startDatePeriod = datePeriod($date,"start") ;
			$endDatePeriod = datePeriod($date,"end") ;
			
			if ($x_lines == 1) {
			
				$new_pulled_extra = array('date'=>$startDatePeriod,
										 'reference'=>'',
										 'description'=>'Brought Forward', 
										 'amount'=>convertToFloat(broughtForward($company,$period,"Customer","Customer"))) ;
							 
				array_push($pulled_list, $new_pulled_extra) ;	
				
				$x_lines++ ;
				
			}
			
				$lines_HTML .= "<tr bgcolor=white>
						<td align=center><font size=2>".$date."</font>
						<td align=center><font size=2>".$reference."</font>						
						<td align=center><font size=2>".$description."</font>
						<td align=center><font size=2>".convertToFloat($amount)."</font></tr>" ;
						
			
			
						
						
			$new_pulled_list = array('date'=>$date,
							 'reference'=>$reference,
							 'description'=>$description, 
							 'amount'=>convertToFloat($amount)) ;
							 
			array_push($pulled_list, $new_pulled_list) ;
												
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

		
			
// GET DATA FOR MAIN DETAILS FROM mySQL

		$getMain = mysql_query("SELECT * FROM settings") ;
		
		$getComMain = mysql_fetch_row($getMain) ;
		
		if (!$getComMain) {
		
			print(mysql_error."<br><br>Please report this to the admin!");
			
		} else {
		
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
			
		}
		
// PDF CREATION

		if ( strtolower($PDF_verdict) == "pdf" ) {
		
			$dir = './pdf_files';
			$fname = $dir.'/'.$company.$period.'.pdf';
			
			if ( (!is_file($fname)) || (is_file($fname)) ) {
			
				$pdf =& new Cezpdf();
				$pdf->selectFont('./fonts/Helvetica.afm');
				$pdf->ezStartPageNumbers(300,10,10,'','',1);
				$pdf->ezColumnsStart(array('num'=>2,'gap'=>100));
				$pdf->ezImage($img,0,150);
				$pdf->ezColumnsStop() ;

				$pdf->addText(299,800,24,"<b>STATEMENT</b>");
				$pdf->addText(299,785,8,"DATE : ".$date);
				$pdf->addText(299,775,8,"ACCOUNT No : ".$company);
				$pdf->addText(299,765,8,$ad01);
				$pdf->addText(299,755,8,$ad02);
				$pdf->addText(299,745,8,"Tel : ".$tel.", Fax : ".$fax);
				$pdf->addText(299,735,8,$url.", ".$email);
				$pdf->addText(299,725,8,"VAT No. ".$vat.", CK No. ".$ck);
				
// TOP SECTION

				$company_name_temp =  "<b><i>".$company_name."</i></b>" ;
				
				$vatreg = "Vat Reg No: ".$tex_ref ;
				
				$top_details = array(
								array('account'=>$company_name_temp, 'order'=>$company_name_temp),
								array('account'=>$address_line01, 'order'=>$address_line01),
								array('account'=>$address_line02, 'order'=>$address_line02),
								array('account'=>$address_line03, 'order'=>$address_line03),
								array('account'=>$address_line04, 'order'=>$address_line04),
								array('account'=>$address_line05, 'order'=>$address_line05),
								array('account'=>$vatreg, 'order'=>$vatreg),
							);
						
				$options_top = array('fontSize' => 8,
								   'showLines'=>0,
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
			
				$minor_details = array(array('account'=>$company, 'date'=>$endDatePeriod));
						
				$options_minor = array('fontSize' => 8,
									   'showLines'=>0,
									   'showHeadings'=>1,
									   'shaded'=>0,
									   'xPos'=>'center',
									   'xOrientation'=>'center',
									   'width'=>530) ;
								 
				$minor_details_title = array('account'=>'<b><i>ACCOUNT No.</i></b>','date'=>'<b><i>DATE</i></b>') ;
				
				$pdf->ezTable($minor_details , $minor_details_title , ' ' , $options_minor);
			
			
// MAIN HISTORY LINES ENTRIES
			
					
				$options_list = array('fontSize' => 8,
								 'showLines'=>1,
								 'showHeadings'=>1,
								 'shaded'=>1,
								 'xPos'=>'center',
								 'xOrientation'=>'center',
								 'width'=>530) ;
								 
				$pulled_list_title = array( 
									 'date'=>'DATE', 
									 'reference'=>'REFERENCE', 
									 'description'=>'DESCRIPTION', 
									 'amount'=>'AMOUNT') ;
				
				$pdf->ezTable($pulled_list , $pulled_list_title , ' ' , $options_list);

// BOTTOM SECTION

				$age_array = getAgeArray($company,$period,$general_type) ;	
			
				$bottom_details = array(array('120'=>$age_array['120'], '90'=>$age_array['90'], '60'=>$age_array['60'], '30'=>$age_array['30'], 'current'=>$age_array['current'], 'amountpaid'=>convertToFloat(0), 'totaldue'=>$age_array['total']));
						
				$options_bottom = array('fontSize' => 8,
								   'showLines'=>1,
								   'showHeadings'=>1,
								   'cols'=>array( 'order'=>array('width'=>150), 'sales'=>array('width'=>100) ), 
								   'shaded'=>0,
								   'xPos'=>'center',
								   'xOrientation'=>'center',
								   'width'=>530) ;

	
				$pulled_list_bottom = array(
											'120'=>'120+ DAYS', 
											'90'=>'90 DAYS', 
											'60'=>'60 DAYS', 
											'30'=>'30 DAYS', 
											'current'=>'CURRENT', 
											'amountpaid'=>'AMOUNT PAID', 
											'totaldue'=>'TOTAL DUE') ;
								 
				$pdf->ezTable($bottom_details , $pulled_list_bottom , ' ' ,$options_bottom);

				$pdfcode = $pdf->output();

				$fp = fopen($fname,'w');
				fwrite($fp,$pdfcode);
				fclose($fp);
				
			}
			
			print("<img src=img/yes.gif> <a href='".$fname."' target=_blank>Document ".$company.$period." compiled into ".$PDF_verdict." format successfully.</a><br>") ;			
			return $fname ;

		}
		
// HTML CREATION

		if ( strtolower($PDF_verdict) == "html" ) {
		
			$dir = './html_files';
			$fname = $dir.'/'.$company.$period.'.html';
			
			if (!is_file($fname)) {
		
				$htmlcode = "<html>
								<head>
									<title>Document ".$doc_id.", iAssist.</title>
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
												<td colspan=2 align=center><h2>".$doc_type."</h2>
									<!--	<tr>
												<td colspan=2 align=center><h3>SUBJECT TO OUR CONDITIONS OF SALE ON BOTTOM</h3> -->
												
											<tr>
												<td align=center><font size=2><b>DATE</b></font>
												<td align=center><font size=2><b>DOCUMENT No.</b></font>
											<tr>
												<td align=center><font size=1>".$date."</font>
												<td align=center><font size=1>".$doc_id."</font>
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
													<td align=right valign=top><font size=2>Via : </font>
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
			
			print("<img src=img/yes.gif> <a href='".$fname."' target=_blank>Document ".$company.$period." compiled into ".$PDF_verdict." format successfully.</a><br>") ;			
			return $fname ;
	
		} 

	} else {

		print("<img src=img/no.gif> Document ".$company.$period." failed : ".odbc_errormsg()."<br>") ;	
		return false ;
		
	}

}

function getAgeArray($company,$period,$general_type) {	

	if ($general_type == "customer") {
		$table = "CustomerMaster" ;
		$field = "CustomerCode" ;
		$gdc = "D" ;
	} else {
		$table = "SupplierMaster" ;
		$field = "SupplCode" ;
		$gdc = "C" ;
	}
	
	$conn = connect() ;
	$periods_last = getPeriodDate("periods_last") ;
	$period_level = 1 ;
	
	$onetwenty = 0 ;
	$ninety = 0 ;
	$sixty = 0 ;
	$thirty = 0 ;
	$current = 0 ;
	$total = 0 ;
	$min = 0 ;	
	
	$sql_first = "SELECT BalanceLast01 FROM ".$table." WHERE ".$field." = '".$company."'";
	$query_first = odbc_do($conn, $sql_first) ;
	$total = odbc_result($query_first, 1) ;
		
		
		

		
		
		
	while ($period_level <= $period) {
	

		$current = 0;
		$sql_current_plus = "SELECT Amount FROM LedgerTransactions WHERE PPeriod = '".$period_level."' AND Amount > '0' AND AccNumber = '".$company."' AND GDC = '".$gdc."'";
		$query_current_plus = odbc_do($conn, $sql_current_plus) ;
		while (odbc_fetch_row($query_current_plus)) {
			$current += odbc_result($query_current_plus, 1) ;
		}

	
		$onetwenty = $min + $onetwenty  ;
		if ($onetwenty<0) { 
			$min = $onetwenty ;
			$onetwenty = 0 ;
		} else {
			$min = 0 ;
		}
	
		$ninety = $min + $ninety ;
		if ($ninety<0) { 
			$min = $ninety ;
			$ninety = 0 ;
		} else {
			$min = 0 ;
		}
	
		$sixty = $min + $sixty ;
		if ($sixty<0) { 
			$min = $sixty ;
			$sixty = 0 ;
		} else {
			$min = 0 ;
		}
	
		$thirty = $min + $thirty ;
		if ($thirty<0) { 
			$min = $thirty ;
			$thirty = 0 ;
		} else {
			$min = 0 ;
		}
			
				

		
		if ($period_level == 1) {
			$onetwenty = $total - $current ;
		} 

		if ($period_level != 1) {
			$total = $onetwenty + $ninety +	$sixty + $thirty + $current ;
		}
		
		
		
		
		

		
		
		

		$age_array = array() ;
		
		$age_array['120'] = convertToFloat($onetwenty) ;
		$age_array['90'] = convertToFloat($ninety) ;
		$age_array['60'] = convertToFloat($sixty) ;
		$age_array['30'] = convertToFloat($thirty) ;
		$age_array['current'] = convertToFloat($current) ;
		$age_array['total'] = convertToFloat($total) ;



		
		$onetwenty = $onetwenty + $ninety ;
		$ninety = $sixty;
		$sixty = $thirty;
		$thirty = $current ;

		
		
		
		
		if ($period_level==$periods_last) {
			$period_level = "101" ;
		} else {
			$period_level++ ;
		}
		
	
		$min = 0;	
		$sql_current_min = "SELECT Amount FROM LedgerTransactions WHERE PPeriod = '".$period_level."' AND Amount < '0' AND AccNumber = '".$company."' AND GDC = '".$gdc."'";
		$query_current_min = odbc_do($conn, $sql_current_min) ;
		while (odbc_fetch_row($query_current_min)) {
			$min += odbc_result($query_current_min, 1) ;
		}	


		
	
	}
		

	return $age_array ;
	
}
?>