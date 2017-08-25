<?

	session_start();
	
	require_once('../config/var.php');	
	require_once('../lib/database.php');
	require_once('../lib/misc.php');
	require_once('../lib/settings.php');
	require_once('../lib/user.php');
	require_once('../lib/layout.php');
	
	$username = $_SESSION['username'] ;	
	
	if (!db_connect()) {
		print(mysql_error()) ;
		exit ;
	}
	
?>

<html>
    <head>
        <title>Get Name</title>
		
		<link rel="StyleSheet" type="text/css" href="googlesuggestclone.css" />
		<link rel="StyleSheet" type="text/css" href="../styles/program.css" />
		
		<script language=javascript type=text/javascript src=make_ajax.js></script>
		<script language=javascript type=text/javascript src=make_events.js></script>	
		<script language=javascript type=text/javascript src=make_window.js></script>	
		
    </head>
	
    <body topmargin=5 leftmargin=5>
	
<?

	print( createHeading("Get Supplier Name", "close") ) ;	
	print("<br><center>(search as you type)<br><br>");	
	
	if (isset($_GET['q'])) {
	
		print("<script>
				opener.document.getElementById('".$_GET['field']."').value= '".$_GET['q']."' ;
				window.close() ;
				</script>");
		
	} else {
	
		print("<form method=get id=f action=get_customers_name.php name=form>
				<input type=hidden name=field value='".$_GET['field']."'>
				<input type=text name=q id=query autocomplete=off size=30  onKeyUp=displayunicode(event,'sname')>
				<input type=submit value=Select><br>
				<span id=search-results></span></form>");
				
		print("<script>document.form.query.focus();</script>");
		
	}
	
    print("</body></html>");


?>