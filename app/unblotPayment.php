<?

	require_once("headers.php") ;

	$id = $_GET['id'] ;
	
	$delete = mysql_query("DELETE FROM paid WHERE id = '$id'") ;
	
	if ($delete) {
		print("<script>window.history.back();</script>");
	} else {
		print(mysql_error());
	}

?>