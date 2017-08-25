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
	
	$username = $_SESSION['username'] ;

	print("<head><title>Welcome to iAssist</title>");
	
	//print("<script language=javascript type=text/javascript src=jscripts/tiny_mce/tiny_mce.js></script>");
	
	print("<script type=text/javascript src=calender/epoch_classes.js></script>");
	print("<script language=javascript type=text/javascript src=jscripts/misc.js></script>");
	print("<script language=javascript type=text/javascript src=jscripts/analysis.js></script>");

	
	print("<link rel=stylesheet type=text/css href=calender/epoch_styles.css>");
	print("<link href=styles/program.css rel=stylesheet type=text/css>");
	print("<link href=styles/googlesuggestclone.css rel=styleSheet type=text/css>");
	print("<link href=styles/analysis.css rel=styleSheet type=text/css>");
	print("<link href=styles/themes/default.css rel=styleSheet type=text/css>");
	

	print("</head><body bgcolor=white leftmargin=5 topmargin=5 marginwidth=5 marginheight=5>");
	
?>