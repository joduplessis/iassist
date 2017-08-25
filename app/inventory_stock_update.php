<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Inventory",0) ) ;	

	
	print("<br><b><font color=".TEXT_HEADING.">Stock Update : </font></b><br><br>");
	
	print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
	
	print("<br>");
	
	print("<table width=100% cellspacing=0 cellpadding=4 border=0>");
	print("<tr><td>");
	
	
	$y = 0;
	
	
	if (isset($_POST['stlist'])) {
	
		$stock_list = $_POST['stlist'] ;
		
		for ($x = 0 ; $x < sizeof ($stock_list) ; $x++) {
		
			$y++ ;
		
			$itemcode = $stock_list[$x] ;
			
			$min_var = "min_".$itemcode ;
			$max_var = "max_".$itemcode ;
			$avg_var = "avg_".$itemcode ;
			
			$min = $_POST[$min_var] ;
			$max = $_POST[$max_var] ;
			$avg = $_POST[$avg_var] ;

			
			$up = updateMinMax( $itemcode, convertToFloat($min*$avg), convertToFloat($max*$avg) ) ;
			
			if (!$up) {
				print("<font color=red><b>Sorry, but item '".$itemcode."' could not update. Please check that you have sufficient rights to update Pervasive.</b></font><br>");
			}
		
		}
	
	}
	
	if ($y == 0) {
		print("<center>Sorry, no items checked.</center>");
	}
	
	
	print("</table><br>");
			
	print("</table><br>");
				

			

	

	include "foot.php" ;
?>

