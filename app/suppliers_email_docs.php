<?

	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Suppliers",0) ) ;	

	$general_type = "supplier" ;	
	$page = "suppliers" ;
	$odbc_table = "SupplierMaster" ;
	$odbc_code = "SupplCode" ;

	$subject = $_POST['subject'] ;
	if ($subject=="") {
		$subject = "iAssist Document Mail";
	}	
	
	$content = $_POST['content'] ;
	if ($content=="") {
		$content = "iAssist Document Mail";
	}	
	
	if (is_uploaded_file($_FILES['extra']['tmp_name']))
	{
		if (copy($_FILES['extra']['tmp_name'], 'extra/'.$_FILES['extra']['name'])) {
			$extra = "extra/".$_FILES['extra']['name'] ;
		} else	{
			print("<br><table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<br><tr bgcolor=white><td><font color=red><b>No extra document attached.</b></font></tr></table><br><bR>");
		}
	} else {
			print("<br><table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><font color=red><b>No extra document attached.</b></font></tr></table><br><br>");
	}

	$email = $_SESSION['emails'] ;
	$files = $_SESSION['files'] ;
	
	$email_codes = array_keys($email);
	
	print("<br><table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td>");

	for ($x = 0 ; $x < sizeof($email_codes) ; $x++ ) {
	
		$company = $email_codes[$x] ;
		$email = $email[$company] ;
	
		print( doMail($subject,$content,$extra,$email,$company,$files) );
		
	}

	print("</tr></table><br><br>");
	
	//print("<br><bR><center><input type=button value=Back onClick=\"window.location='".$page.".php'\"></center>");

	print("</table>");

	include "foot.php" ;
?>

