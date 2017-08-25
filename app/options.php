<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	$page = "options" ;

	print( createHeading("Options",0) ) ;	

	if (!isset($_GET['set'])) {

		print("<br><b><font color=".TEXT_HEADING.">Options : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td valign=middle>");
		print("<br><form action=".$page.".php method=GET>");
		print("<input type=hidden name=set value=yes>");
		print("<table width=100% border=0>");
		print("<tr><td valign=top align=right width=50%>Display Results :<td><input type=text name=dis size=20 value='".getUserData($username,"display_limit")."'></tr>");
		print("<tr><td valign=top align=right>Highlight zero total clients ? <td>");

		if ( getUserData($username,"zeroclients") == 1 ) {
			print("<select name=zero><option value=1>Yes</option><option value=0>No</option></select></tr>");
		} else {
			print("<select name=zero><option value=0>No</option><option value=1>Yes</option></select></tr>");
		}

		print("<tr><td valign=top align=right>Highlight clients with amounts above zero for this period and on :<td>");
		print("<select name=highlight>
			<option value='".getUserData($username,"highlight")."'>".getUserData($username,"highlight")."</option>
			<option value=''>None</option>
			<option value='current'>Current</option>
			<option value='30'>30</option>
			<option value='60'>60</option>
			<option value='90'>90</option>
			<option value='120'>120</option>
			<option value='150'>150</option>
		</select></tr>");
		
		print("</table><center><br><input type=submit value='Set Changes'></center><br></form>");


	} else {

		$dis = $_GET['dis'] ;
		$zero = $_GET['zero'] ;
		$highlight = $_GET['highlight'] ;
		
		$query = mysql_query("UPDATE users SET display_limit='$dis', zeroclients='$zero', highlight_from='$highlight' WHERE username = '$username'") ;

		if ($query) {
			print("<script>window.location='".$page.".php';</script>");
		} else {
			print("<font color=red><b>".mysql_error()."</b></font>");
		}

	}

	print("</table>");

	include "foot.php" ;
?>

