<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	$page = "settings" ;

	print( createHeading("Settings",0) ) ;	

	if (!isset($_GET['set'])) {
	
		print("<br><b><font color=".TEXT_HEADING.">Settings : </font></b><br><br>");
		print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd height=200>");
		print("<tr bgcolor=white><td valign=middle>");
		print("<br><form action=".$page.".php method=GET>");
		print("<table width=100% border=0>");
		print("<tr><td align=center><a href=settings.php?set=general><img src=img/settings_general.jpg border=0></a>
				   <td align=center><a href=settings.php?set=document><img src=img/settings_document.jpg border=0></a>
				   <td align=center><a href=settings.php?set=email><img src=img/settings_mail.jpg border=0></a>
				   <td align=center><a href=settings.php?set=error><img src=img/settings_error.jpg border=0></a></tr>");
		print("<tr><td align=center><br><a href=settings.php?set=general><b>General Settings</b></a>
				   <td align=center><br><a href=settings.php?set=document><b>Document Settings</b></a>
				   <td align=center><br><a href=settings.php?set=email><b>Mail Settings</b></a>
				   <td align=center><br><a href=settings.php?set=error><b>Error Viewer</b></a></tr></table>");
	
	} else {
	
		$set = $_GET['set'] ;
		
		switch ($set) {
		
		
		
			case "errorfix" :
			$id = $_GET['id'] ;
			@mysql_query("UPDATE error SET fixed = 'yes' , fdate = CURDATE() WHERE id = '$id'") ;
			print("<script>window.location='settings.php?set=error';</script>");
			break ;
			
			
			
		
			case "error" :			
					
			print("<br><b><font color=".TEXT_HEADING.">Reported Errors : </font></b><br><br>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td valign=middle>");
			print("<br>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0>");
			print("<tr><td><b>ID</b><td><b>Category</b><td><b>Content</b><td><b>Date</b><td><b>User</b><td>");			
			$error_query = mysql_query("SELECT * FROM error ORDER BY date") ;
			while ($get_error = mysql_fetch_row($error_query)) {
				if ($get_error['5']=="yes") {
					print("<tr bgcolor=#ededed><td><font color=#aaaaaa>".$get_error['0']."</font><td><font color=#aaaaaa>".$get_error['1']."</font><td><font color=#aaaaaa>".$get_error['2']."</font><td><font color=#aaaaaa>".$get_error['3']."</font><td><font color=#aaaaaa>".$get_error['4']."</font><td><b><font color=#aaaaaa>Fixed</font></b>");			
				} else {
					print("<tr><td>".$get_error['0']."<td>".$get_error['1']."<td>".$get_error['2']."<td>".$get_error['3']."<td>".$get_error['4']."<td> <a href=settings.php?id=".$get_error['0']."&set=errorfix><b><font color=red>Fixed ?</font></b></a>");			
				}
			}	
			print("</table><center><br></center></form>");			
			break ;
			
			
			
			
		
			case "general" :
			
			switch ( getAssistSettings('cache') ) {
				case "none" :
					$cache_value = "No Limit" ;
					break ;
				case "10" :
					$cache_value = "10 MB" ;
					break ;
				case "20" :
					$cache_value = "20 MB" ;
					break ;
				case "30" :
					$cache_value = "30 MB" ;
					break ;
				case "0" :
					$cache_value = "No Cache" ;
					break ;
			}
		
			print("<br><b><font color=".TEXT_HEADING.">General Settings : </font></b><br><br>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td valign=middle>");
			print("<br><form action=".$page.".php method=GET name=f>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0>");
			print("<input type=hidden name=set value=set_general>");
			print("<tr><td valign=top align=center colspan=2><b>Books for this year : </b>");			
			print("<tr><td valign=top align=right width=50%>DSN : <td><input type=text name=dsn size=20 value='".getAssistSettings('dsn')."'>");			
			print("<tr><td valign=top align=right>Username : <td><input type=text name=username size=20 value='".getAssistSettings('dsn_user')."'>");
			print("<tr><td valign=top align=right>Password : <td><input type=text name=password size=20 value='".getAssistSettings('dsn_pass')."'>");
			print("<tr><td valign=top align=center colspan=2><b>Books for last year : </b>");
			print("<tr><td valign=top align=right width=50%>DSN : <td><input type=text name=dsn2 size=20 value='".getAssistSettings('dsn2')."'>");			
			print("<tr><td valign=top align=right>Username : <td><input type=text name=username2 size=20 value='".getAssistSettings('dsn2_user')."'>");
			print("<tr><td valign=top align=right>Password : <td><input type=text name=password2 size=20 value='".getAssistSettings('dsn2_pass')."'>");	
			print("<tr><td valign=top align=center colspan=2>&nbsp;");			
			print("<tr><td valign=top align=right>Size of cache : <td valign=top><select name=cache><option value='".getAssistSettings('cache')."'>".$cache_value."</option><option value=0>No Cache</option><option value=10>10 MB</option><option value=20>20 MB</option><option value=30>30 MB</option><option value='none'>No Limit</option></select>");
			print("<tr><td valign=top align=right>Company Reminder : <td><textarea rows=5 cols=43 name=flash>".getAssistSettings('message')."</textarea>");		
			print("<tr><td valign=top align=right>Admin E-Mail Address :<td><input type=text name=admin_email size=40 value='".getAssistSettings('admin_email')."'>");
			print("<tr><td valign=top align=right>Update Inventory : <td><input type=button value=Update onclick=javascript:popup('inventory_update.php',300,300)>");
			print("</table><center><br><input type=submit value='Set Changes'><br><br></center></form>");			
			break ;
			
		case "set_general" :
		
				$dsn = $_GET['dsn'] ;
				$username = $_GET['username'] ;
				$password = $_GET['password'] ;
				
				$dsn2 = $_GET['dsn2'] ;
				$username2 = $_GET['username2'] ;
				$password2 = $_GET['password2'] ;
				
				$flash = $_GET['flash'] ;
				$cache = $_GET['cache'] ;
				$admin_email = $_GET['admin_email'] ;
				
				$query = mysql_query("UPDATE settings SET dsn = '$dsn', username='$username', password='$password', flash='$flash', admin_01 = '$admin_email', cache = '$cache', dsn2 = '$dsn2', dsn2_user = '$username2', dsn2_pass = '$password2' WHERE anchor=1") ;

				if ($query) {
					print("<script>window.location='".$page.".php';</script>");
				} else {
					print("<font color=red><b>".mysql_error()."</b></font>");
				}
				
			break ;
			
			case "document" :
			print("<br><b><font color=".TEXT_HEADING.">Document Settings : </font></b><br><br>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td valign=middle>");
			print("<br><form action=".$page.".php method=GET name=f>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0>");
			print("<input type=hidden name=set value=set_document>");
			print("<tr><td valign=top align=right width=50%>Company Name :<td><input type=text name=company size=50 value='".getAssistSettings('cname')."'></tr>");
			print("<tr><td valign=top align=right>VAT No. : <td><input type=text name=vat size=40 value='".getAssistSettings('vat')."'>");
			print("<tr><td valign=top align=right>CK No. : <td><input type=text name=ck size=40 value='".getAssistSettings('ck')."'>");
			print("<tr><td valign=top align=right>Address Line 1 :	<td><input type=text name=ad1 size=50 value='".getAssistSettings('ad01')."'>");
			print("<tr><td valign=top align=right>Address Line 2 :	<td><input type=text name=ad2 size=50 value='".getAssistSettings('ad02')."'>");
			print("<tr><td valign=top align=right>Telephone Details Line :<td><input type=text name=tel size=30 value='".getAssistSettings('tel')."'></tr>");
			print("<tr><td valign=top align=right>Fax Details Line :<td><input type=text name=fax size=30 value='".getAssistSettings('fax')."'></tr>");
			print("<tr><td valign=top align=right>E-Mail Details Line :<td><input type=text name=email size=50 value='".getAssistSettings('email')."'></tr>");
			print("<tr><td valign=top align=right>URL Details Line :<td><input type=text name=url size=50 value='".getAssistSettings('url')."'></tr>");
			print("<tr><td valign=top align=right>Preferred Format :<td><select name=pformat><option value='".getAssistSettings('pdf')."'>".getAssistSettings('pdf')."</option><option value='PDF'>PDF</option><option value='HTML'>HTML</option></select></tr>");			
			print("<tr><td valign=top align=right>Logo Image : <td><input type=text name=logo_new size=40 value='".getAssistSettings('img')."'> <input type=button value=' Choose Image ' onclick=javascript:popup('gallery.php',600,300)></tr>");
			print("<tr><td valign=top align=right><td><input type=button value=' Add New Images ' onclick=javascript:popup('img_man.php',300,300)>");	
			print("</table><center><br><input type=submit value='Set Changes'><br><br></center></form>");			
			break ;
			
		case "set_document" :
		
				$company = $_GET['company'] ;								
				$vat = $_GET['vat'] ;	
				$ck = $_GET['ck'] ;	
				$ad1 = $_GET['ad1'] ;	
				$ad2 = $_GET['ad2'] ;
				$tel = $_GET['tel'] ;	
				$fax = $_GET['fax'] ;	
				$email = $_GET['email'] ;	
				$url = $_GET['url'] ;	
				$logo_new = $_GET['logo_new'] ;	
				$pformat = $_GET['pformat'] ;
				
				$query = mysql_query("UPDATE settings SET VAT = '$vat', CK = '$ck', address_01 = '$ad1', address_02 = '$ad2', tel = '$tel', fax = '$fax', email = '$email', URL = '$url', logo_img = '$logo_new', company = '$company', prefer_format = '$pformat' WHERE anchor=1") ;

				if ($query) {
					print("<script>window.location='".$page.".php';</script>");
				} else {
					print("<font color=red><b>".mysql_error()."</b></font>");
				}
				
			break ;
			
			case "email" :
			print("<br><b><font color=".TEXT_HEADING.">E-Mail Settings : </font></b><br><br>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
			print("<tr bgcolor=white><td valign=middle>");
			print("<br><form action=".$page.".php method=GET name=f>");
			print("<table width=100% cellspacing=1 cellpadding=3 border=0>");
			print("<input type=hidden name=set value=set_email>");
			print("<tr><td valign=top align=right width=50%>Mail Server :<td><input type=text name=mail_host size=40 value='".getAssistSettings('mail_host')."'>");
			print("<tr><td valign=top align=right>iAssist Mail Server Address :<td><input type=text name=mail_server_address size=40 value='".getAssistSettings('mail_server')."'>");
			print("<tr><td valign=top align=right>Mail Server Username :<td><input type=text name=mail_user size=40 value='".getAssistSettings('mail_user')."'>");
			print("<tr><td valign=top align=right>Mail Server Pass :<td><input type=text name=mail_pass size=40 value='".getAssistSettings('mail_pass')."'>");
			print("</table><center><br><input type=submit value='Set Changes'><br><br></center></form>");			
			break ;
			
		case "set_email" :
		
				$host = $_GET['mail_host'] ;
				$m_server = $_GET['mail_server_address'] ;
				$m_user = $_GET['mail_user'] ;
				$m_pass = $_GET['mail_pass'] ;

				$query = mysql_query("UPDATE settings SET host = '$host', server_address = '$m_server', mail_user = '$m_user', mail_pass = '$m_pass' WHERE anchor=1") ;

				if ($query) {
					print("<script>window.location='".$page.".php';</script>");
				} else {
					print("<font color=red><b>".mysql_error()."</b></font>");
				}
				
			break ;
		
		}



	}

	print("</table>");
	include "foot.php" ;
?>

