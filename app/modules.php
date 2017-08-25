<?

	require_once("headers.php") ;
	
	require_once("navigation.php");

	print( createHeading("Modules",0) ) ;	
	
	$conn = connect() ;	
	
	$page = "modules" ;

	if (!isset($_POST['type'])) {
	
	
	
	
	
	
	
		$sec = getUserData($_SESSION['username'],"sec_type") ;
		
		if ($sec == "admin") {
	
			print("<br><b><font color=".TEXT_HEADING.">Add Modules : </font></b><br><br>");
			print("<form action=".$page.".php method=POST enctype=\"multipart/form-data\">");
			print("<input type=hidden name=type value=add>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=0 border=0>");
			print("<tr><td>Name : <td><input type=text name=name size=10>");
			print("<td>Description : <td><input type=text name=description size=30>");
			print("<td>Load : <td><input type=file name=file size=20>");
			print("<td>Activation Code : <td><input type=text name=code size=20>");
			print("<td><input type=submit value='Add Module'></tr></table></table></form><br>");
		
		}
		
		
		
		
		
		
		
		
		

		print("<br><b><font color=".TEXT_HEADING.">View Modules : </font></b><br><br>");	
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=#DDDDDD>	
				<td><b>MODULE</b>
				<td><b>DESCRIPTION</b>
				<td></tr>") ;
				
		$query = mysql_query("SELECT * FROM modules") ;	
			
		if (mysql_num_rows($query)==0) {
		
			print( createTableRow(1,false) ) ;		
			
			print("<td colspan=5><center><br><br>Sorry, there are no modules yet!<Br><br><Br></center></tr></table>");
			
		} else {

			$x = 0;
			
			while ($list = mysql_fetch_row($query) ) {
			
				$x++ ;
			
				print( createTableRow($x,false) ) ;	
				
				$id = $list['0'] ;
				
				print("<td>".$list['1']."
					   <td>".$list['2']."
					   <td align=center width=65>
					   <a href='".$list['3']."'><b>Load</b></a> | 
					   <a href=".$page.".php?type=del&id=".$id."><b>Del</b></a></tr>") ;

			}
					
		}


	} else if ($_POST['type'] == "add") {
	
		$name = $_POST['name'] ;
		$description = $_POST['description'] ;
		$code = $_POST['code'] ;
		
		print("<br><b><font color=".TEXT_HEADING.">Modules : </font></b><br><br>");
		print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td height=200 align=center valign=middle>");
		
		if ( !parseCode($code) ) {
		
			print("<font color=red><b>Invalid activation code.</b></font>");		
		
		} else {
	
			if (is_uploaded_file($_FILES['file']['tmp_name']))	{

				if (copy($_FILES['file']['tmp_name'], 'modules/'.$_FILES['file']['name'])) {

					$file = "modules/".$_FILES['file']['name'] ;
					
					$query = mysql_query("INSERT INTO modules (title,description,location) VALUES ('$name','$description','$file')") ;
					
					if (!$query) {
						print("<font color=red><b>".mysql_error()."</b></font>");
					} else {
						print("<script>window.location='modules.php';</script>");
					}
					
				} else	{
				
					print("<font color=red><b>File did not load properly.</b></font>");
					exit();
					
				}

			} else {
			
					print("<font color=red><b>File did not load properly.</b></font>");
					exit();
					
			}
			
		}
		
		print("</table>");

	}
	
	if (isset($_GET['type'])) {
	
		if ($_GET['type']=="del") {

			$id = $_GET['id'] ;

			$query = mysql_query("DELETE FROM modules WHERE id = '$id'") ;

			if ($query) {
			
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

