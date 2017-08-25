<?

	require_once("headers.php") ;
	require_once("navigation.php");

	print( createHeading("Customers",0) ) ;	
	
	if ( !isset($_GET['page']) ) { 
		$page = 1 ; 
	} else { 
		$page = $_GET['page'] ; 
	}
	
	$limitFactor = getUserData($username,"display_limit") ;
	$start_point = ($limitFactor * $page) - ($limitFactor-1) ;	
	
	$general_type = "customer" ;
	$search = "Customer" ;
	$tpage = "customers" ;
	$pastel_note_type = 1 ;
	
	$odbc_table = "CustomerMaster" ;
	$odbc_code = "CustomerCode" ;
	$odbc_desc = "CustomerDesc" ;
	
	$add_on_query_get = "" ;
	$add_on_query = array() ; 
	$add_search = "" ; 	
	
// SEARCH START
	
	if ( isset($_GET['name']) ) { 
	
		if ( $_GET['name'] != "" ) { 
			
			array_push($add_on_query, $odbc_table.".".$odbc_desc." LIKE '%".$_GET['name']."%'")  ; 
			$add_on_query_get .= "&name=".$_GET['name']  ; 
			
		}
		
	}
	
	if ( isset($_GET['aname']) ) { 
	
		if ( $_GET['aname'] != "" ) { 
		
			array_push($add_on_query,$odbc_table.".".$odbc_desc." LIKE '".$_GET['aname']."%'")  ; 
			
			$add_on_query_get .= "&aname=".$_GET['aname']  ; 
			
		}
		
	}
	
	if ( isset($_GET['code']) ) {
 	
		if ( $_GET['code'] != "" ) { 
		
			array_push($add_on_query,$odbc_table.".".$odbc_code." LIKE '%".$_GET['code']."%'")  ; 
			
			$add_on_query_get .= "&code=".$_GET['code']  ; 
			
		}
		
	}
	
	if ( isset($_GET['amount']) ) { 
	
		if ( $_GET['amount'] != "" ) { 
		
			array_push($add_on_query,"(".$odbc_table.".Ageing01 LIKE '%".$_GET['amount']."%' OR ".$odbc_table.".Ageing02 LIKE '%".$_GET['amount']."%' OR ".$odbc_table.".Ageing03 LIKE '%".$_GET['amount']."%' OR ".$odbc_table.".Ageing04 LIKE '%".$_GET['amount']."%' OR ".$odbc_table.".Ageing05 LIKE '%".$_GET['amount']."%')")  ; 
			
			$add_on_query_get .= "&amount=".$_GET['amount']  ; 
			
		}
		
	}
	
	if ( isset($_GET['cdate']) ) {
 	
		if ( $_GET['cdate'] != "" ) { 
		
			array_push($add_on_query,$odbc_table.".LastCrDate LIKE '%".$_GET['cdate']."%'")  ; 
			
			$add_on_query_get .= "&cdate=".$_GET['cdate']  ;
			
		}
		
	}
	
// ADVANCED SEARCH START
	
	if ( isset($_GET['last_amount']) ) { 
	
		if ( $_GET['last_amount'] != "" ) { 
		
			array_push($add_on_query,$odbc_table.".LastCrAmount LIKE '%".$_GET['last_amount']."%'")  ; 
			
			$add_on_query_get .= "&last_amount=".$_GET['last_amount']  ; 
			
		}
		
	}
	
	if ( isset($_GET['c_limit']) ) { 
	
		if ( $_GET['c_limit'] != "" ) {
		
			array_push($add_on_query,$odbc_table.".CreditLimit LIKE '%".$_GET['c_limit']."%'")  ; 
			
			$add_on_query_get .= "&c_limit=".$_GET['c_limit']  ; 
			
		}
		
	}
	
	if ( isset($_GET['period']) ) { 
	
		if ( $_GET['period'] != "" ) { 
		
			array_push($add_on_query,$odbc_table.".".$_GET['period']." <> 0")  ; 
			
			$add_on_query_get .= "&period=".$_GET['period']  ; 
			
		}
		
	}
	
	if ($general_type =="customer") {
	
		if ( isset($_GET['rep']) ) {
	 	
			if ( $_GET['rep'] != "" ) { 
			
				array_push($add_on_query,"DeliveryAddresses.".$odbc_code." LIKE '%".$_GET['rep']."%'")  ; 
				
				$add_on_query_get .= "&rep=".$_GET['rep']  ; 
				
			}
			
		}
	
		if ( isset($_GET['tel']) ) {
		
			if ( $_GET['tel'] != "" ) { 
			
				array_push($add_on_query,"DeliveryAddresses.Telephone LIKE '%".$_GET['tel']."%'")  ;
				
				$add_on_query_get .= "&tel=".$_GET['tel']  ; 
				
			}
			
		}
		
		if ( isset($_GET['cell']) ) { 
		
			if ( $_GET['cell'] != "" ) { 
			
				array_push($add_on_query,"DeliveryAddresses.Cell LIKE '%".$_GET['cell']."%'")  ; 
				
				$add_on_query_get .= "&cell=".$_GET['cell']  ; 
				
			}
			
		}
		
		if ( isset($_GET['fax']) ) { 
		
			if ( $_GET['fax'] != "" ) { 
			
				array_push($add_on_query,"DeliveryAddresses.Fax LIKE '%".$_GET['fax']."%'")  ; 
				
				$add_on_query_get .= "&fax=".$_GET['fax']  ; 
				
			}
			
		}
		
	} else if ($general_type =="supplier") {
	
		if ( isset($_GET['tel']) ) { 
		
			if ( $_GET['tel'] != "" ) { 
			
				array_push($add_on_query,$odbc_table.".Telephone LIKE '%".$_GET['tel']."%'")  ;
				
				$add_on_query_get .= "&tel=".$_GET['tel']  ; 
				
			}
			
		}
		
		if ( isset($_GET['cell']) ) { 	
		
			if ( $_GET['cell'] != "" ) { 
			
				array_push($add_on_query,$odbc_table.".Cellphone LIKE '%".$_GET['cell']."%'")  ; 
				
				$add_on_query_get .= "&cell=".$_GET['cell']  ; 
				
			}
			
		}
		
		if ( isset($_GET['fax']) ) { 	
		
			if ( $_GET['fax'] != "" ) { 
			
				array_push($add_on_query,$odbc_table.".Fax LIKE '%".$_GET['fax']."%'")  ; 
				
				$add_on_query_get .= "&fax=".$_GET['fax']  ; 
				
			}
			
		}
	
	}

// ADVANCED SEARCH END
		
	$add_search = join(" OR ",$add_on_query) ;
	
// SEARCH  END

	print("<script>
		   var dp_cal ;     
		   window.onload = function () {
				dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('cdate'));
		   };
		   </script>");
		   
// THIS IS THE TOP SEARCH BOX	

	print("<br><b><font color=".TEXT_HEADING.">".$search." Search : </font></b><br><br>");
	print("<table width=100% id=mat cellspacing=1% cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
	print("<form method=GET action='".$tpage.".php'>");
	
	print("<table width=100% cellspacing=0 cellpadding=0 border=0 id=advanced style=\"display:none\">");
	print(" <td width=250>Period (Non-Zero Amounts) : <select name=period><option value=''></option>
				<option value='Ageing01'>150+ Days</option>
				<option value='Ageing02'>120 Days</option>
				<option value='Ageing03'>90 Days</option>
				<option value='Ageing04'>60 Days</option>
				<option value='Ageing05'>30 Days</option></select>
			<td width=200>Last Amount Paid : <input type=text size=10 name=last_amount>
			<td width=170>Credit Limit : <input type=text size=10 name=climit>
			<td width=120>Tel : <input type=text size=7 name=tel>
			<td width=120>Cell : <input type=text size=7 name=cell>
			<td>Fax : <input type=text size=7 name=fax>
			</table>");
			
	print("<table width=100% cellspacing=0 cellpadding=0 border=0>");
	print(" <td>".$search." Name : <input type=text size=10 name=name id=name> 
					<a href=javascript:popup(\"ajax/get_".$tpage."_name.php?field=name\",300,300)>
					<img src=img/search_icon.gif border=0></a>
			<td>".$search." Code : <input type=text size=5 name=code id=code> 
					<a href=javascript:popup(\"ajax/get_".$tpage."_code.php?field=code\",300,300)>
					<img src=img/search_icon.gif border=0></a>
			<td>Amount : <input type=text size=10 name=amount id=amount>
			<td>Last Credited Date : <input type=text size=10 name=cdate id=cdate>
			<td>Rep : <select name=rep><option value=''></option>".getSalesManList()."</select>
			<td align=right><input type=submit value=Search>");
			
	print("</form>");
	print("</table><br><a href=javascript:showAdvanced()>+ Advanced Search</a><Br>");
	
	print("</table><br>");
	
// THIS IS THE ALPHABET

	print("<table cellspacing=1 cellpadding=2 border=0 bgcolor=#dddddd align=center>
			 <tr bgcolor=white>
				 <td align=center width=20><a href='".$tpage.".php?aname=a'>A</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=b'>B</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=c'>C</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=d'>D</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=e'>E</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=f'>F</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=g'>G</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=h'>H</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=i'>I</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=j'>J</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=k'>K</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=l'>L</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=m'>M</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=n'>N</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=o'>O</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=p'>P</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=q'>Q</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=r'>R</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=s'>S</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=t'>T</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=u'>U</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=v'>V</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=w'>W</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=x'>X</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=y'>Y</a>
			</td><td align=center width=20><a href='".$tpage.".php?aname=z'>Z</a>
			</td></tr></table>");
			
// START OF GENERAL LAYOUT

	print("<b><font color=".TEXT_HEADING.">".$search." List : </font></b><br><br>");	
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd id=normal_table>");
	print("<tr bgcolor=#DDDDDD>	
			<td><b>COMPANY NAME</b>
			<td><b>150+ DAYS</b>
			<td><b>120 DAYS</b>
			<td><b>90 DAYS</b>
			<td><b>60 DAYS</b>
			<td><b>30 DAYS</b>
			<td><b>CURRENT</b>
			<td><b>TOTAL</b></tr>") ;
			
	if ( ( $add_on_query_get != "" ) ) {
	
		if ($general_type == "customer") {
	
			$sql = "SELECT ".$odbc_table.".".$odbc_code.", ".$odbc_table.".".$odbc_desc.", ".$odbc_table.".Ageing01, ".$odbc_table.".Ageing02, ".$odbc_table.".Ageing03, ".$odbc_table.".Ageing04, ".$odbc_table.".Ageing05, ".$odbc_table.".Blocked FROM ".$odbc_table." LEFT OUTER JOIN DeliveryAddresses ON ".$odbc_table.".".$odbc_code." = DeliveryAddresses.".$odbc_code." WHERE ".$add_search." ORDER BY ".$odbc_table.".".$odbc_code ;	

		} else {
		
			$sql = "SELECT ".$odbc_code.",".$odbc_desc.",Ageing01,Ageing02,Ageing03,Ageing04,Ageing05,Blocked FROM ".$odbc_table." ORDER BY ".$odbc_code ;
		
		}
		
	} else {
	
		$sql = "SELECT ".$odbc_code.",".$odbc_desc.",Ageing01,Ageing02,Ageing03,Ageing04,Ageing05,Blocked FROM ".$odbc_table." ORDER BY ".$odbc_code ;	
		
	}
	
	$conn = connect() ;		
	$query = odbc_do($conn, $sql) ;
	
	if (!$query) {
		
		print("<font color=red><b>". odbc_errormsg() ."</b></font>") ;
		exit ;
			
	} else {
	
		$x = 0 ;
		
		while ( odbc_fetch_row($query) ) {

			$x++ ;
		
			if ( ( $x >= $start_point ) && ( $x <= ( $start_point + $limitFactor ) ) ) {
			
				$number = rtrim(odbc_result($query, 1)) ;
				$company = rtrim( isBlocked( odbc_result($query, 2) , odbc_result($query, 8) ) )  ;
				$oneFifty = odbc_result($query, 3) ;
				$oneTwenty = odbc_result($query, 4) ;
				$ninety = odbc_result($query, 5) ;
				$sixty = odbc_result($query, 6) ;
				$thirty = odbc_result($query, 7) ;
				$current = getCurrent($number,$general_type) ;
				$total = $oneFifty+$oneTwenty+$ninety+$sixty+$thirty+$current ;
		
				$noteAmount = giveNoteAmount($number,$general_type) ;
				$newTotal = $noteAmount + getIsPaidTotal($number,$general_type,date('m'),date('Y')) ;
				
				if (isThisRed($username,$number,$oneFifty,$oneTwenty,$ninety,$sixty,$thirty,$current,$total)) {
					print( createTableRow($x,true) ) ;
				} else {
					print( createTableRow($x,false) ) ;
				}
				
				$companyString = $number." - ".$company ;
				
				if ($noteAmount != 0) {
					$companyString = $companyString." <img src=img/note_home.gif border=0>" ;
				}

				if ( hasNote($number,$general_type) ) {
					$companyString = $companyString." <img src=img/notes.gif border=0>" ;
				}				
				
				print("<td><a href=javascript:popup(\"".$tpage."_main.php?code=".$number."\",500,550)>".$companyString."</a>");
				print("<td>".getPaidResult(150,$oneTwenty,$number,$general_type) );
				print("<td>".getPaidResult(120,$oneTwenty,$number,$general_type) );
				print("<td>".getPaidResult(90,$ninety,$number,$general_type) );
				print("<td>".getPaidResult(60,$sixty,$number,$general_type) );
				print("<td>".getPaidResult(30,$thirty,$number,$general_type) );
				print("<td>".getPaidResult(0,$current,$number,$general_type) );
				print("<td>R ".convertToFloat($total)) ;
				
				if ($newTotal != 0) {
					print("<font color=red>( R ".(convertToFloat($total - $newTotal))." )</font>") ;
				}
				
			}
		
		}
		
	}

	odbc_close($conn);

	print("</table><Br>");
	
	if ( $x == 0 ) {

		print("<center><b><font color=red>Sorry, but your query returned no results.</font></b><br><br><br></center>");

	} else {
	
		$lastPage = ceil( $x / $limitFactor ) ;
		
		if ($lastPage==0) {
			$lastPage++ ;
		}

		if ($page != 1) {
			print("<input type=button value=Back onclick=window.location=\"".$tpage.".php?page=".($page-1).$add_on_query_get."\"> ");
		}

		if ($page != $lastPage) {
			print("<input type=button value=Next onclick=window.location=\"".$tpage.".php?page=".($page+1).$add_on_query_get."\"> ");
		}
		
		print("<select onchange=\"setList(this,'".$tpage."','".$add_on_query_get."')\">");
		print("<option value='".$page."'>".$page."</option>");
		for ($selectPage = 1 ; $selectPage <= $lastPage ; $selectPage++) {
			print("<option value='".$selectPage."'>".$selectPage."</option>");
		}
		print("</select>");
		
		print(" Page ".$page." of ".$lastPage.".");
	
	}
	print("</table>");
	
	include "foot.php" ;
?>


