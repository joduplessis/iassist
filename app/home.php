<?

	require_once("headers.php") ;
	require_once("navigation.php");
	
	print( createHeading("Welcome <i>".$username."</i>","home") ) ;

	print("<table width=100% cellspacing=1 cellpadding=3 border=0>");
	print("<tr>");
	print("<td valign=top width=260><br><b><font color=".TEXT_HEADING.">Tools : </font></b><br><br>");
	
	
	
	
	
	
	
	
	
	
	
	?>
	
	<form name="Keypad" action="">

	<table border=0 width=50 height=60 cellpadding=5 cellspacing=1 bgcolor=#dddddd>

	<tr bgcolor=white>
		<td colspan=7 align=middle><input name="ReadOut" type="Text" size=35 value="0" width=100%></td>
	</tr>

	<tr bgcolor=white>
		<td><input name="btnSeven" type="Button" value="  7  " onclick="NumPressed(7)"></td>
		<td><input name="btnEight" type="Button" value="  8  " onclick="NumPressed(8)"></td>
		<td><input name="btnNine" type="Button" value="  9  " onclick="NumPressed(9)"></td>
		<td><input name="btnNeg" type="Button" value=" +/- " onclick="Neg()"></td>
		<td align="middle"><input name="btnPercent" type="Button" value="  % " onclick="Percent()"></td>
	</tr>
	<tr bgcolor=white>
		<td><input name="btnFour" type="Button" value="  4  " onclick="NumPressed(4)"></td>
		<td><input name="btnFive" type="Button" value="  5  " onclick="NumPressed(5)"></td>
		<td><input name="btnSix" type="Button" value="  6  " onclick="NumPressed(6)"></td>
		<td align=middle><input name="btnPlus" type="Button" value="  +  " onclick="Operation('+')"></td>
		<td align=middle><input name="btnMinus" type="Button" value="   -   " onclick="Operation('-')"></td>
	</tr>
	<tr bgcolor=white>
		<td><input name="btnOne" type="Button" value="  1  " onclick="NumPressed(1)"></td>
		<td><input name="btnTwo" type="Button" value="  2  " onclick="NumPressed(2)"></td>
		<td><input name="btnThree" type="Button" value="  3  " onclick="NumPressed(3)"></td>
		<td align=middle><input name="btnMultiply" type="Button" value="  *  " onclick="Operation('*')"></td>
		<td align=middle><input name="btnDivide" type="Button" value="   /   " onclick="Operation('/')"></td>
	</tr>

	<tr bgcolor=white>
		<td><input name="btnZero" type="Button" value="  0  " onclick="NumPressed(0)"></td>
		<td><input name="btnDecimal" type="Button" value="   .  " onclick="Decimal()"></td>
		<td><input name="btnEquals" type="Button" value="  =  " onclick="Operation('=')"></td>
		<td><input name="btnClear" type="Button" value="  C  " onclick="Clear()"></td>
		<td><input name="btnClearEntry" type="Button" value="  CE " onclick="ClearEntry()"></td>
	</tr>

	</table>

	</form>

	
	<?	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	print("<script language=javascript type=text/javascript src=jscripts/calc.js></script>");	
	
	print("<td valign=top>");
	
		print("<br><b><font color=".TEXT_HEADING.">My Notices : </font></b><br><br>");	
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=#DDDDDD>	
				<td><b>USER</b>
				<td><b>COMPANY</b>
				<td><b>CONTENT</b></tr>");
		
		switch ( getUserData($username,"view_type") ) {
			case "customer" : 
			$query = mysql_query("SELECT * FROM notes WHERE start_date <= '".getToday()."' AND end_date >= '".getToday()."' AND (user = '".$username."' OR see_all='yes') AND type = 'customer'") ;
			break;
			case "supplier" : 
			$query = mysql_query("SELECT * FROM notes WHERE start_date <= '".getToday()."' AND end_date >= '".getToday()."' AND (user = '".$username."' OR see_all='yes') AND type = 'supplier'") ;
			break;
			case "all" : 
			$query = mysql_query("SELECT * FROM notes WHERE start_date <= '".getToday()."' AND end_date >= '".getToday()."' AND (user = '".$username."' OR see_all='yes')") ;
			break;
		}
		
		$querynum = mysql_num_rows($query);

		if ( !$query ) {
		
			print("<tr><td height=50 valign=middle align=center><b>". mysql_error() ."</b></tr>") ;
			
		} else if ( $querynum == 0 ) {
		
			print("<tr><td height=50 valign=middle align=center bgcolor=white colspan=3>Sorry, you have no notices today!</tr>") ;
			
		} else {
		
			$x=0 ;
		
			while ( $getList = mysql_fetch_row($query) ) 
			{
			
				$id = $getList['0'] ;
				$type = getNoteData($id,"type") ;
				$number = getNoteData($id,"code") ;
				
				$x++ ;

				print( createTableRow($x++, false) );
		
				print("<td><a href=javascript:popup(\"".$type."s_notes.php?code=".$number."\",500,550)>".getNoteData($id,"user")."</a>");		
				print("<td><a href=javascript:popup(\"".$type."s_notes.php?code=".$number."\",500,550)>".getCompanyName(getNoteData($id,"code"),getNoteData($id,"type"))."</a>");
				print("<td><a href=javascript:popup(\"".$type."s_notes.php?code=".$number."\",500,550)>".getNoteData($id,"content")."</a></tr></table>");		
				
			} 

		}
		
	print("</table>");		
	print("<br>");
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	print("<br><b><font color=".TEXT_HEADING.">My Fixed Errors : </font></b><br><br>");	
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=#DDDDDD><td><b>LOGGED DATE</b><td><b>CATEGORY</b><td><b>DESCRIPTION</b><td><b>FIXED DATE</b></tr>");
	
	//$get_errors = mysql_query("SELECT section,date,description FROM error WHERE user = '$username' AND fixed = 'yes'") ;
	
	$get_errors = mysql_query("SELECT section,date,description,fdate FROM error WHERE ( DATE_SUB(CURDATE(),INTERVAL 30 DAY) <= fdate ) AND user = '$username' AND fixed = 'yes'") or die (mysql_error()); 
	
	$x = 0 ;
	
	while ($get_err = mysql_fetch_row($get_errors)) {
	
		print( createTableRow($x, false) );
		
		print("<td valign=top>".$get_err['1']."<td valign=top>".$get_err['0']."<td valign=top>".$get_err['2']."<td valign=top>".$get_err['3']);
		
		$x++ ;
		
	}	
	
	if ($x==0) {
	
		print("<tr bgcolor=white><td colspan=4 align=center><br>Sorry, but there are no fixed errors yet.<br><br>");
		
	}
	
	
	
	print("</table>");
	
	print("<br>");
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	print("<br><b><font color=".TEXT_HEADING.">My Noticeboard : </font></b><br><br>");	
	print("<table width=100% cellspacing=1 cellpadding=10 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td><marquee>".getAssistSettings('message')."</marquee>");
	print("</table>");
	
	print("</table>");
		
	
	// HERE WE CHECK THE CHACHE AND LIMITS AND STUFF
	
	clearCache(getAssistSettings("cache"),"pdf_files") ;
	clearCache(getAssistSettings("cache"),"html_files") ;

	include "foot.php" ;

?>

