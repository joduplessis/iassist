<?

	session_start();
	
	require_once('../config/var.php');	
		
	require_once('../lib/database.php');
	require_once('../lib/misc.php');
	require_once('../lib/user.php');
	require_once('../lib/settings.php');
	require_once('../lib/layout.php');
	
	$username = $_SESSION['username'] ;	

	
	if (!db_connect()) {
		print(mysql_error()) ;
		exit ;
	}
	
	

	
?>

<html>
    <head>
        <title>Log Error</title>
		
		<link rel="StyleSheet" type="text/css" href="../styles/program.css" />
		
    </head>
	
    <body topmargin=5 leftmargin=5>
	
<?

	print( createHeading("Log Error", "close") ) ;	

	if (isset($_GET['suc'])) {
		print("<br><center><b>Error successfully logged.</b></center><br><br>");
	}
	
	if (isset($_GET['q'])) {
	
		$cat = $_GET['cat'] ;
		$q = $_GET['q'] ;
	
		$query = mysql_query("INSERT INTO error(section,description,date,user) VALUES('$cat','$q',CURDATE(),'$username')");
		if (!$query) {
			print(mysql_error()) ;
		} else {
			print("<script>window.location='error.php?suc=yes';</script>");
		}

		
	} else {
	

		print("<form method=get id=f action=error.php>");
		print("<table width=100% border=0 cellpadding=5 cellspacing=0>");
		print("<tr><td width=28% align=right>Category : <td><select name=cat>");
		print("<option value='Home'>Home</option>");
		print("<option value='Customers - Main'>Customers - Main</option>");
		print("<option value='Customers - Invoice'>Customers - Invoice</option>");
		print("<option value='Customers - Statement'>Customers - Statement</option>");
		print("<option value='Customers - Rules'>Customers - Rules</option>");
		print("<option value='Customers - Stock Analysis'>Customers - Stock Analysis</option>");
		print("<option value='Customers - Notes'>Customers - Notes</option>");
		print("<option value='Customers - Search'>Customers - Search</option>");
		print("<option value='Suppliers - Main'>Suppliers - Main</option>");
		print("<option value='Suppliers - Invoice'>Suppliers - Invoice</option>");
		print("<option value='Suppliers - Statement'>Suppliers - Statement</option>");
		print("<option value='Suppliers - Rules'>Suppliers - Rules</option>");
		print("<option value='Suppliers - Stock Analysis'>Suppliers - Stock Analysis</option>");
		print("<option value='Suppliers - Notes'>Suppliers - Notes</option>");
		print("<option value='Suppliers - Search'>Suppliers - Search</option>");
		print("<option value='Inventory - Search'>Inventory - Search</option>");
		print("<option value='Inventory - Stock Analysis'>Inventory - Stock Analysis</option>");
		print("<option value='Users'>Users</option>");
		print("<option value='Options'>Options</option>");
		print("</select>");
		print("<tr><td align=right valign=top>Description : <td><textarea cols=50 rows=7 name=q></textarea>");
		print("<tr><td><td><input type=submit value='Log Error Report'>");
		print("</table>");        
        print("</form>");	



	}
	
?>

    </body>
	</html>