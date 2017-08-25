<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	$page = "users" ;

	print( createHeading("Users",0) ) ;	

		if ( !isset( $_GET['type'] ) ) {
		
			print("<script>
				   var dp_cal ;     
				   window.onload = function () {
						dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'));
				   };
				   </script>");		
		
			print("<br><b><font color=".TEXT_HEADING.">Add User : </font></b><br><br>");
			
			print("<form action=".$page.".php method=GET> <input type=hidden name=type value=add>");
			
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=3 border=0>");
			
			print("<tr>");
			print("<td>Username : <td><input type=text name=username size=15 id=aname>");
			print("<td>Password : <td><input type=text name=password size=15 id=aname>");
			print("<td>Name : <td><input type=text name=name size=15 id=aname>");
			print("<td>Surname : <td><input type=text name=surname size=15 id=aname>");
			print("<td rowspan=2 valign=middle align=center><input type=submit value='Add User'>");
			print("<tr>");
			print("<td>E-Mail : <td><input type=text name=email size=15>");
			print("<td>Expiry Date : <td><input type=text name=edate size=15 id=edate>");
			print("<td>View Type : <td><select name=view_type><option value='all'>All</option><option value=supplier>Suppliers</option><option value=customer>Customers</option></select>");
			print("<td>User Type : <td><select name=user_type><option value='admin'>Admin</option><option value=power>Power</option><option value=basic>Basic</option></select>");
			print("</table></table></form><br>");		

			$query = mysql_query("SELECT * FROM users") ;

			print("<br><b><font color=".TEXT_HEADING.">Users : </font></b><br><br>");
			print("<form action=".$page.".php method=GET> <input type=hidden name=type value=add>");

			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			
			print("<tr bgcolor=#DDDDDD>	
					<td><b>USERNAME</b>
					<td><b>PASSWORD</b>
					<td><b>SECURITY</b>
					<td><b>NAME</b>
					<td><b>SURNAME</b>
					<td><b>E-MAIL</b>
					<td><b>VIEW TYPE</b>
					<td><b>DATE CREATED</b>
					<td><b>EXPIRY DATE</b>
					<td></tr>") ;
					
			$x = 0;
			
			while ($user_list = mysql_fetch_row($query) ) {
			
				$x++ ;
				
				print( createTableRow($x,false) ) ;	

				print("<td>".getUserData($user_list['1'],"username"));
				print("<td>".getUserData($user_list['1'],"password"));
				print("<td>".getUserData($user_list['1'],"sec_type"));
				print("<td>".getUserData($user_list['1'],"name"));
				print("<td>".getUserData($user_list['1'],"surname"));
				print("<td>".getUserData($user_list['1'],"email"));
				print("<td>".getUserData($user_list['1'],"view_type"));
				print("<td>".getUserData($user_list['1'],"date_created"));
				print("<td>".getUserData($user_list['1'],"date_expire"));

				
				print("<td width=60 align=right>
					<a href='users.php?type=del&id=".$user_list['0']."'> <b>Del</b></a> | 
					<a href='users.php?type=edit&id=".$user_list['1']."'> <b>Edit</b></a>");

			}
			
			print("</table></form>");

		} else if ($_GET['type']=="del") {
		
	
			$id = $_GET['id'] ;
	
			$query = mysql_query("DELETE FROM users WHERE id='$id'") ;

			if ($query) {
				print("<script>window.location='users.php';</script>");
			} else {
				print("<font color=red><b>".mysql_error()."</b></font>");
			}
			

		} else if ($_GET['type'] == "add") {
		

			$username = $_GET['username'] ;
			$password = $_GET['password'] ;
			$name = $_GET['name'] ;
			$surname = $_GET['surname'] ;
			$edate = $_GET['edate'] ;
			$email = $_GET['email'] ;
			$view_type = $_GET['view_type'] ;
			$user_type = $_GET['user_type'] ;
			
			$query = mysql_query("INSERT INTO users (username,password,name,surname,date_created,date_expire,sec_type,email,display_limit,zeroclients,highlight_from,view_type) VALUES ('$username','$password','$name','$surname',CURDATE(),'$edate','$user_type','$email','12','1','','$view_type')") ;

			if ($query) {
				print("<script>window.location='users.php';</script>");
			} else {
				print("<font color=red><b>".mysql_error()."</b></font>");
			}
			

		} else if ($_GET['type'] == "edit") {

			$name = $_GET['id'] ;
			$id = getUserData($id,'id') ;
			
			print("<script>
			   var dp_cal ;     
			   window.onload = function () {
					dp_cal  = new Epoch('epoch_popup','popup',document.getElementById('edate'));
			   };
			   </script>");	
			   
			print("<br><b><font color=".TEXT_HEADING.">Edit User : </font></b><br><br>");
			print("<form action=".$page.".php method=GET> <input type=hidden name=id value=".$id."><input type=hidden name=type value=edit_this>");
			print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td><br><table width=100% cellspacing=0 cellpadding=3 border=0>");
			print("<tr><td align=right width=50%>Username : <td><input type=text name=username size=15 id=aname value=".getUserData($name,'username').">");
			print("<tr><td align=right>Password : <td><input type=text name=password size=15 id=aname value=".getUserData($name,'password').">");
			print("<tr><td align=right>Name : <td><input type=text name=name size=15 id=aname value='".getUserData($name,'name')."'>");
			print("<tr><td align=right>Surname : <td><input type=text name=surname size=15 id=aname value='".getUserData($name,'surname')."'>");
			print("<tr><td align=right>E-Mail : <td><input type=text name=email size=15 value=".getUserData($name,'email').">");
			print("<tr><td align=right>View Type : <td><select name=view_type><option value='".getUserData($name,'view_type')."'>".getUserData($name,'view_type')."</option><option value='all'>All</option><option value=supplier>Suppliers</option><option value=customer>Customers</option></select>");
			print("<tr><td align=right>User Type : <td><select name=user_type><option value='".getUserData($name,'sec_type')."'>".getUserData($name,'sec_type')."</option><option value='admin'>Admin</option><option value=power>Power</option><option value=basic>Basic</option></select>");
			print("<tr><td align=right>Expiry Date : <td><input type=text name=edate size=15 id=edate value=".getUserData($name,'date_expire').">");
			print("</table><br><center><input type=submit value='Edit User'></center><br></table></form><br>");	
			
		} else if ($_GET['type'] == "edit_this") {
		
		
			$id = $_GET['id'] ;
			$username = $_GET['username'] ;
			$password = $_GET['password'] ;
			$name = $_GET['name'] ;
			$surname = $_GET['surname'] ;
			$edate = $_GET['edate'] ;
			$email = $_GET['email'] ;
			$view_type = $_GET['view_type'] ;
			$user_type = $_GET['user_type'] ;
			
			$query = mysql_query("UPDATE users SET username='$username',password='$password',name='$name',surname='$surname',date_expire='$edate',sec_type='$user_type',email='$email',view_type='$view_type' WHERE id='$id'") ;

			if ($query) {
				print("<script>window.location='users.php';</script>");
			} else {
				print("<font color=red><b>".mysql_error()."</b></font>");
			}

		}


	include "foot.php" ;
?>

