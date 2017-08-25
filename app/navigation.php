<?


	$sec = getUserData($_SESSION['username'],"sec_type") ;
	$type = getUserData($_SESSION['username'],"view_type") ;


	print("<table width=100% height=1 cellpadding=0 cellspacing=0>");
	
	print("<tr><td><img src=img/small_logo.jpg>");
	print("<tr><td>");
	

	
	
	
	
	print("<table align=center width=100% border=0 cellspacing=0 cellpadding=4><tr bgcolor=".MAIN_NAV_BG."><td>");
	
	print("<a href=home.php> <font color=".MAIN_NAV_TEXT.">Home</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");

	switch ($type) {
	
		case "all" :
			print("<a href=customers.php> <font color=".MAIN_NAV_TEXT.">Customers</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
			print("<a href=suppliers.php> <font color=".MAIN_NAV_TEXT.">Suppliers</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
		break ;
		
		case "customer" :
			print("<a href=customers.php> <font color=".MAIN_NAV_TEXT.">Customers</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
		break ;
		
		case "supplier" :
			print("<a href=suppliers.php> <font color=".MAIN_NAV_TEXT.">Suppliers</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
		break ;
	
	}
	
	print("<a href=inventory_search.php> <font color=".MAIN_NAV_TEXT.">Inventory</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
	if ($sec == "admin") {
	
		print("<a href=users.php> <font color=".MAIN_NAV_TEXT.">Users</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
		print("<a href=settings.php> <font color=".MAIN_NAV_TEXT.">Settings</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
		
	}
	
	print("<a href=options.php> <font color=".MAIN_NAV_TEXT.">Options</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
	print("<a href=modules.php> <font color=".MAIN_NAV_TEXT.">Modules</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
	print("<a href=cplanner.php> <font color=".MAIN_NAV_TEXT.">Calender</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
	print("<a href=javascript:popup(\"error/error.php\",500,300)> <font color=".MAIN_NAV_TEXT.">Log Error</font></a> <font color=".MAIN_NAV_TEXT."></font>");
	
	print("<td align=right>");
	
	print(" <a href=help.php> <font color=".MAIN_NAV_TEXT.">Help</font></a> <font color=".MAIN_NAV_TEXT.">|</font>");
	
	print("<a href=logout.php> <font color=".MAIN_NAV_TEXT.">Logout</font></a>");
	
	print("</tr></table>");

	
	
	
//	print("</table>");
	
	
	
?>