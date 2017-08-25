<?
	require_once("headers.php") ;
	
	
	if (!isset($_GET['var_code'])) {
		require_once("navigation.php");
		print( createHeading("Customers",0) ) ;	
	} else {
		print ( createHeading("Customer Details",$_GET['var_code']) ) ;
	}
	
	$conn = connect() ;	

	$general_type = "customer" ;
	$search = "Customer" ;
	$page = "customers_rules" ;
	$ppage = "customers" ;
	

	if (isset($_GET['var_code'])) {
	
		if (isset($_GET['add_var_code'])) {
		
			$name = $_GET['add_name'] ;
			$email = $_GET['email'] ;
			$format = $_GET['format'] ;
			$code = getCompanyCode($name,$general_type) ;

			if ($name != "") {

				$setSetQuery = mysql_query("INSERT INTO rules (cust_id,pdf_html,cust_name,email,type) VALUES ('$code','$format','$name','$email','$general_type')") ;

				if ($setSetQuery) {
				
					print("<script>window.location='".$ppage."_main.php?code=".$code."';</script>");
					
				} else {
				
					print("<font color=red><b>".mysql_error()."</b></font>");
					exit ;
					
				}
				
			} else {
			
				print("<script>window.location='".$page.".php';</script>");
				
			}
		
		
		
		} else {
		
			print("<br><b><font color=".TEXT_HEADING.">Add Rule : </font></b><br><br>");
			print("<form action=".$page.".php method=GET> <input type=hidden name=var_code value=".$_GET['var_code']."><input type=hidden name=add_var_code>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=5 border=0>");
			print("<tr><td width=50% align=right>".$search." Name : <td><input type=text name=add_name size=20 id=add_name value='".getCompanyName($_GET['var_code'],$general_type)."'> <a href=javascript:popup(\"ajax/get_".$ppage."_name.php?field=add_name\",300,300)><img src=img/search_icon.gif border=0></a>");
			print("<tr><td align=right>E-Mail Formatting : <td><select name=format><option value=''></option><option value=pdf>PDF</option><option value=html>HTML</option></select>");
			print("<tr><td align=right>E-Mail Address : <td><input type=text name=email size=30>");
			print("<tr><td colspan=2 align=center><input type=submit value='Add Rule'></tr></table></table></form><br>");
			
		}
		
	} else {
	

		if (!isset($_GET['type'])) {
		

// SEARCH CRITERIA START

			$joinedArrayQuery = "" ;
			$add_on_query_get = "" ;
			$add_on_query = array() ;
			
			if ( isset($_GET['name']) ) {
			
				if ( $_GET['name'] != "" ) { 
				
					array_push($add_on_query,"cust_name LIKE '%".$valueNAME."%'")  ; 
					
					$add_on_query_get .= "&name=".$_GET['name']  ; 
					
				}
				
			}
			
			if ( isset($_GET['aname']) ) { 
			
				if ( $_GET['aname'] != "" ) { 
				
					array_push($add_on_query,"cust_name LIKE '".$_GET['aname']."%'")  ; 
					
					$add_on_query_get .= "&aname=".$_GET['aname']  ; 
					
				}
				
			}
			
			if ( isset($_GET['code']) ) { 
			
				if ( $_GET['code'] != "" ) { 
				
					
					array_push($add_on_query,"cust_id LIKE '%".$_GET['code']."%'")  ; 
					
					$add_on_query_get .= "&code=".$_GET['code']  ; 
					
				}
				
			}
			
			if ( isset($_GET['email']) ) { 	
			
				if ( $_GET['email'] != "" ) { 
				
					array_push($add_on_query,"email LIKE '%".$_GET['email']."%'")  ; 
					
					$add_on_query_get .= "&email=".$_GET['email']  ; 
					
				}
				
			}
			
			if ( isset($_GET['format']) ) { 
			
				if ( $_GET['format'] != "" ) { 
				
					array_push($add_on_query,"pdf_html LIKE '%".$_GET['format']."%'")  ; 
					
					$add_on_query_get .= "&format=".$_GET['format']  ; 
					
				}
				
			}
			
			$joinedArrayQuery = join(" OR ",$add_on_query) ;	
			
			if ( ( $add_on_query_get != "" ) ) {
			
				$sql = "SELECT * FROM rules WHERE ".$joinedArrayQuery." AND type = '".$general_type."'" ;
				$query = mysql_query($sql) ;
				
			} else {
			
				$query = mysql_query("SELECT * FROM rules WHERE type = '$general_type'") ;
				
			}
			
			print("<br><b><font color=".TEXT_HEADING.">Add Rule : </font></b><br><br>");
			print("<form action=".$page.".php method=GET> <input type=hidden name=type value=add>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=0 border=0>");
			print("<tr><td>".$search." Name : <td><input type=text name=add_name size=20 id=add_name> <a href=javascript:popup(\"ajax/get_".$ppage."_name.php?field=add_name\",300,300)><img src=img/search_icon.gif border=0></a>");
			print("<td>E-Mail Formatting : <td><select name=format><option value=''></option><option value=pdf>PDF</option><option value=html>HTML</option></select>");
			print("<td>E-Mail Address : <td><input type=text name=email size=30>");
			print("<td><input type=submit value='Add Rule'></tr></table></table></form><br>");
			
			// THIS IS THE TOP SEARCH BOX	

			print("<br><b><font color=".TEXT_HEADING.">Rule Search : </font></b><br><br>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
			print("<form method=GET action='".$page.".php'>");
			print("<table width=100% cellspacing=0 cellpadding=0 border=0>");
			print(" <td>".$search." Name : <input type=text size=20 name=name id=name> <a href=javascript:popup(\"ajax/get_".$ppage."_name.php?field=name\",300,300)><img src=img/search_icon.gif border=0></a>
					<td>".$search." Code : <input type=text size=5 name=code id=code> <a href=javascript:popup(\"ajax/get_".$ppage."_code.php?field=code\",300,300)><img src=img/search_icon.gif border=0></a>
					<td>E-Mail : <input type=text size=10 name=email id=amount>
					<td>Format : <select name=format><option value=''></option><option value='pdf'>PDF</option><option value='html'>HTML</option></select>
					<td align=right><input type=submit value=Search></form></table></table><br>");
					
					
			print("<table cellspacing=1 cellpadding=2 border=0 bgcolor=#dddddd align=center>
					 <tr bgcolor=white>
						 <td align=center width=20><a href='".$page.".php?aname=a'>A</a>
					</td><td align=center width=20><a href='".$page.".php?aname=b'>B</a>
					</td><td align=center width=20><a href='".$page.".php?aname=c'>C</a>
					</td><td align=center width=20><a href='".$page.".php?aname=d'>D</a>
					</td><td align=center width=20><a href='".$page.".php?aname=e'>E</a>
					</td><td align=center width=20><a href='".$page.".php?aname=f'>F</a>
					</td><td align=center width=20><a href='".$page.".php?aname=g'>G</a>
					</td><td align=center width=20><a href='".$page.".php?aname=h'>H</a>
					</td><td align=center width=20><a href='".$page.".php?aname=i'>I</a>
					</td><td align=center width=20><a href='".$page.".php?aname=j'>J</a>
					</td><td align=center width=20><a href='".$page.".php?aname=k'>K</a>
					</td><td align=center width=20><a href='".$page.".php?aname=l'>L</a>
					</td><td align=center width=20><a href='".$page.".php?aname=m'>M</a>
					</td><td align=center width=20><a href='".$page.".php?aname=n'>N</a>
					</td><td align=center width=20><a href='".$page.".php?aname=o'>O</a>
					</td><td align=center width=20><a href='".$page.".php?aname=p'>P</a>
					</td><td align=center width=20><a href='".$page.".php?aname=q'>Q</a>
					</td><td align=center width=20><a href='".$page.".php?aname=r'>R</a>
					</td><td align=center width=20><a href='".$page.".php?aname=s'>S</a>
					</td><td align=center width=20><a href='".$page.".php?aname=t'>T</a>
					</td><td align=center width=20><a href='".$page.".php?aname=u'>U</a>
					</td><td align=center width=20><a href='".$page.".php?aname=v'>V</a>
					</td><td align=center width=20><a href='".$page.".php?aname=w'>W</a>
					</td><td align=center width=20><a href='".$page.".php?aname=x'>X</a>
					</td><td align=center width=20><a href='".$page.".php?aname=y'>Y</a>
					</td><td align=center width=20><a href='".$page.".php?aname=z'>Z</a>
					</td></tr></table>");

			
			print("<br><b><font color=".TEXT_HEADING.">View Rules : </font></b><br><br>");	
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=#DDDDDD>	
					<td><b>COMPANY NAME</b>
					<td><b>COMPANY CODE</b>
					<td><b>FORMAT</b>
					<td><b>E-MAIL</b>
					<td></tr>") ;
				
			if (mysql_num_rows($query)==0) {
			
				print( createTableRow(1,false) ) ;				
				print("<td colspan=5><center><br><br>Sorry, there are no rules yet!<Br><br><Br></center></tr></table>");
				
			} else {

				$x = 0;
				
				while ($list = mysql_fetch_row($query) ) {
				
					$x++ ;
				
					print( createTableRow($x,false) ) ;	
					
					$id = $list['0'] ;
					
					print("<td>".$list['3']."
						   <td>".$list['1']."
						   <td>".$list['2']."
						   <td>".$list['4']."
						   <td align=right width=60>
						   <a href=".$page.".php?type=del&id=".$id."><b>Del</b></a> | 
						   <a href=".$page.".php?type=edit&id=".$id."><b>Edit</b></a> </tr>") ;

				}
						
			}


		} else if ($_GET['type']=="del") {

			$id = $_GET['id'] ;

			$setSetQuery = mysql_query("DELETE FROM rules WHERE id = '$id'") ;

			if ($setSetQuery) {
			
				print("<script>window.location='".$page.".php';</script>");
				
			} else {
			
				print("<font color=red><b>".mysql_error()."</b></font>");
				exit ;
				
			}

		} else if ($_GET['type'] == "add") {

			$name = $_GET['add_name'] ;
			$email = $_GET['email'] ;
			$format = $_GET['format'] ;
			$code = getCompanyCode($name,$general_type) ;

			if ($name != "") {

				$setSetQuery = mysql_query("INSERT INTO rules (cust_id,pdf_html,cust_name,email,type) VALUES ('$code','$format','$name','$email','$general_type')") ;

				if ($setSetQuery) {
				
					print("<script>window.location='".$page.".php';</script>");
					
				} else {
				
					print("<font color=red><b>".mysql_error()."</b></font>");
					exit ;
					
				}
				
			} else {
			
				print("<script>window.location='".$page.".php';</script>");
				
			}


		} elseif ($_GET['type'] == "edit") {

			$id = $_GET['id'] ;
			
			$name = get_rule_by_id($id,'name') ;
			$format = get_rule_by_id($id,'pdf') ;
			$email = get_rule_by_id($id,'email') ;

			$getUserData = mysql_query("SELECT * FROM customer_rules WHERE id = '$id'") or die(mysql_query());
			
			$getUser = mysql_fetch_row($getUserData) ;
			
			print("<br><b><font color=".TEXT_HEADING.">Edit Rule : </font></b><br><br>");
			print("<form action=".$page.".php method=GET><input type=hidden name=type value=edit_this><input type=hidden name=id value='".$id."'>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><table width=100% cellspacing=1 cellpadding=3 border=0>");
			print("<tr><td align=right width=50%>".$search." Name : <td><input type=text name=name size=30 id=name value='".$name."'> <a href=javascript:popup(\"get_name.php?ctype=".$search."\",400,200)><img src=img/search_icon.gif border=0></a>");
			print("<tr><td align=right>E-Mail Formatting : <td><select name=format><option value=''></option><option value=''".$format."''>'".$format."'</option><option value=pdf>PDF</option><option value=html>HTML</option></select>");
			print("<tr><td align=right>E-Mail Address : <td><input type=text name=email size=30 value='".$email."'>");
			print("<tr><td><br><input type=submit value='Edit Rule'></tr></table></table></form><br>");

		} elseif ($_GET['type'] == "edit_this") {

			$id = $_GET['id'] ;
			$name = $_GET['name'] ;
			$email = $_GET['email'] ;
			$format = $_GET['format'] ;
			$code = getCompanyCode($name,$general_type) ;
			
			$setSetQuery = mysql_query("UPDATE rules SET cust_id = '$code' , pdf_html = '$format' , email = '$email' , cust_name = '$name' , type = '$general_type' WHERE id = '$id'") ;

			if ($setSetQuery) {
			
				print("<script>window.location='".$page.".php';</script>");
				
			} else {
			
				print("<font color=red><b>".mysql_error()."</b></font>");
				exit ;
				
			}

		}
	
	}

	print("</table>");

	include "foot.php" ;
?>

