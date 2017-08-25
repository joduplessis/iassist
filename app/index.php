<?

	
	session_start();
	
	require_once('lib/class.smtp.php');
	require_once('lib/class.phpmailer.php');
	require_once('lib/class.pdf.php');
	require_once('lib/class.ezpdf.php');
	
	require_once('config/var.php');
	
	require_once('lib/user.php');
	require_once('lib/settings.php');	
	require_once('lib/database.php');
	require_once('lib/misc.php');
	require_once('lib/notes.php');
	require_once('lib/rules.php');
	require_once('lib/company.class.php');
	require_once('lib/invoices.php');
	require_once('lib/statements.php');
	require_once('lib/modules.php');
	require_once('lib/inventory.php');
	require_once('lib/mail.php');	
	require_once('lib/layout.php');
	
	if (!db_connect()) {
		print(mysql_error()) ;
		exit ;
	}
	
	print("<head><title>Welcome to iAssist</title>");

	print("<script type=text/javascript src=calender/epoch_classes.js></script>");
	print("<script language=javascript type=text/javascript src=jscripts/misc.js></script>");
	print("<script language=javascript type=text/javascript src=jscripts/analysis.js></script>");

	
	print("<link rel=stylesheet type=text/css href=calender/epoch_styles.css>");
	print("<link href=styles/program.css rel=stylesheet type=text/css>");
	print("<link href=styles/googlesuggestclone.css rel=styleSheet type=text/css>");
	print("<link href=styles/analysis.css rel=styleSheet type=text/css>");
	print("<link href=styles/themes/default.css rel=styleSheet type=text/css>");
	

	print("</head><body bgcolor=white leftmargin=5 topmargin=5 marginwidth=5 marginheight=5>");
	
	
	$_SESSION['username'] = "" ;
	
	
	if (!isset($_POST['username']) || !isset($_POST['password'])) {
	
		$admin = getAssistSettings("admin_email") ;
		print("<br><bR>");
		print("<center>");
		print("<form action=index.php method='POST'>");
		print("<table width=400 height=300 cellspacing=1 cellpadding=50 bgcolor=#dddddd>");
		print("<tr bgcolor=white><td align=center valign=middle>");
		print("<img src=img/splash.jpg><br><br><br>");
		print("Username : <input name=username type=text size=20><br><Br>");
		print("Password : <input name=password type=password size=20><br><Br>");
		print("<input type=submit name=Submit value=Login><br><br><br>");
		print("<a href='mailto:".$admin."'>Not logging in correctly ?</a><br>");
		print("iAssist © is a product of FiREFLY Digital Development");
		print("</form>");
		print("</center>");

	} else {
	
		$username = $_POST['username'] ;
		$password = $_POST['password'] ;	
		
		if ( !userCheck($username,$password) ) {
		
			print("<script>alert('Sorry, but your login details are not correct. If you feel they are; please contact your iAssist administrator.');window.location='index.php';</script>");
			
		} else {

			$_SESSION['username'] = $username ;
			print("<script>window.location='home.php';</script>");

		}

	}
	
?>


