<?

	require_once("headers.php") ;

	$type = $_GET['type'] ;
	$number = $_GET['number'] ;
	$amount = $_GET['amount'] ;
	$where = $_GET['where'] ;
	
	$sql = "INSERT INTO paid (number,type,amount,date,ctype) VALUES ('".$number."','".$type."','".$amount."',CURDATE(),'".$where."')" ;

	$insert = mysql_query($sql) ;
	
	if ($insert) {
	
		print("<script>window.history.back()</script>");
		
	} else {
	
		print(mysql_error());
		
	}


?>