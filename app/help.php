<?
	require_once("headers.php") ;
	
	require_once("navigation.php") ;
	

	print( createHeading("Help",0) ) ;	

	
	$conn = connect() ;	


	

	
	print("<br><table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=5 border=0>");
	print("<tr><td><div align=justify>");
	
	print("
	
	For any questions, queries or comments. Please consult our website.<bR><br>Regards, iAssist Team.
	
	");
	
	print("</div></tr>");
	print("</table></table></form><br>");

	include "foot.php" ;
?>

