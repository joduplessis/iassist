<?
	require_once("headers.php") ;
	
	require_once("navigation.php");
	
	print( createHeading("Inventory",0) ) ;	
		
	$page = "inventory_stock" ;
	
	$current_period = getCurrentPeriod() ;
	$periods_this = getPeriodDate("periods_this") ;
	$periods_last = getPeriodDate("periods_last") ;
	
	$period_list = "" ;
	$store_list = getStores() ;	
	

	
	
	if ((!isset($_GET['inv_code_start'])) || (($_GET['inv_code_start']=="") || ($_GET['inv_code_end']==""))) {	
	
		print("<br><b><font color=".TEXT_HEADING.">Stock Analysis : </font></b><br><br>");
		print("<table width=100% id=mat cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd><tr bgcolor=white><td>");
		
		print("<form method=GET action='".$page.".php'>");
		
		print("<br>");
		
		print("<table width=100% cellspacing=0 cellpadding=4 border=0>");
		
		print(" <tr><td align=right width=50%>Inventory Code Start : <td><input type=text name=inv_code_start size=10 id=inv_code_start> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_start\",300,300)><img src=img/search_icon.gif border=0></a>			
				<tr><td align=right>Inventory Code End : <td><input type=text name=inv_code_end size=10 id=inv_code_end> <a href=javascript:popup(\"ajax/get_inv_code.php?field=inv_code_end\",300,300)><img src=img/search_icon.gif border=0></a>			
				<tr><td align=right>Scope : <td><select name=scope><option value='this_cycle'>This year so far</option><option value='last_cycle'>All of last cycle.</option><option value='".$periods_this."'>Last ".$periods_this." Periods</option><option value='".($periods_this/2)."'>Last ".($periods_this/2)." Periods</option></select>
				<tr><td align=right>Use books from last year : <td><input name=last_books value=1 type=checkbox>
				<tr><td align=right>Store : <td><select name=store>".$store_list."</select>
				<tr><td align=right>Weighted Average : <td><select name=ave><option value=''>None</option><option value=1>1 Period</option><option value=2>2 Periods</option><option value=3>3 Periods</option><option value=4>4 Periods</option></select>
				</table><center><Br><input type=submit value='Analyze'></center><br></form>");
				
		print("</table><br>");
				

	} else {
	
	
		print("<bR>");
		
		$conn = connect() ;
		
		$search_query = "" ;
		
		$sqlQuery = array() ;
		$code_ranges = array() ;
		
		$weighted_average = 0;
		
		if ($_GET['ave'] != "") {
		
			$weighted_average = $_GET['ave'] ;
			
		}
		
		$scope = $_GET['scope'] ;
		
		if ($_GET['store']=="") {
		
			$storeArray = getStoresArray() ;
			for ($sx = 0 ; $sx < sizeof($storeArray) ; $sx++) {
				$sqlQuery[] = "StoreCode <> '".$storeArray[$sx]."'" ;
			}
			
		} else {
	
			$sqlQuery[] = "StoreCode = '".$_GET['store']."'" ;
		
		}
			
		if ($_GET['inv_code_start'] != "") {
		
			$sqlQuery[] = "ItemCode >= '".$_GET['inv_code_start']."'" ;
			
		}
		
		if ($_GET['inv_code_end'] != "") {
		
			$sqlQuery[] = "ItemCode <= '".$_GET['inv_code_end']."'" ;
			
		}		
		
		$search_query = join(" AND ",$sqlQuery) ;

		$sql = "SELECT QtySellThis01,
					   QtySellThis02,
					   QtySellThis03,
					   QtySellThis04,
					   QtySellThis05,
					   QtySellThis06,
					   QtySellThis07,
					   QtySellThis08,
					   QtySellThis09,
					   QtySellThis10,
					   QtySellThis11,
					   QtySellThis12,
					   QtySellThis13,
					   QtySellLast,
					   ItemCode FROM MultiStoreTrn WHERE ".$search_query." ORDER BY ItemCode" ;	

		$query = odbc_do($conn,$sql) ;

		if ( !$query ) { print(odbc_errormsg()); }
		
		
		
		
		
		
		
		print("<form action=inventory_stock_update.php method='POST'>");
		
		
		
		while (odbc_fetch_row($query)) {
		
							
			$month_val = array() ;
			
			$month_val_final = array() ;	
		
			$avg = odbc_result($query, 14) / $periods_last ;
			
			$itemcode = rtrim(odbc_result($query, 15)) ;

			print("<b><font color=".TEXT_HEADING.">Stock Analysis For ".$itemcode." </font></a></b><br><br>");
			print("<table  width=90% id=mat cellspacing=1 cellpadding=10 border=0 bgcolor=white align=center ><tr bgcolor=white><td>");			
		
		
		
	

// getting values for this year
			for ($y = 1 ; $y <= $periods_this  ; $y++) {
			
				$month_val[$y] = odbc_result($query, $y) ;
				
			}

	
		
		
// getting values for last year
			if (isset($_GET['last_books'])) {
			
						print("Using books from last year.");
			
						$conn_lastyear = connect_lastyear() ;		

						$query_lastyear = odbc_do($conn_lastyear,$sql) ;

						if (!$query_lastyear) { print(odbc_errormsg()); }

						$c = 1 ;
						
						for ($y = 0 ; $y > ($periods_last*-1)  ; $y--) {
						
							$month_val[$y] = odbc_result($query_lastyear, $c) ;
							$c++ ;
							
						}
						
			} else {
			
						print("Using average in books from this year.");
						
						for ($y = 0 ; $y > ($periods_last*-1) ; $y--) {
						
							$month_val[$y] = convertToFloat($avg) ;
							
						}
				
			}
		
		
		
		
		
		
			$total_avg = 0 ;
			$scope_desc = "" ;
			
			switch ($scope) {
			
			
				case "this_cycle" :
				$w_end = $current_period ;
				$w_start = 1 ;
				for ( $x = $w_start ; $x <= $w_end ; $x++ ) {
					$month_val_final[$x] = $month_val[$x] ;
				}
				$scope_desc = "this cycle so far" ;
				break ;
				
				
				case "last_cycle" :
				$w_start = 0 ;
				$w_end = $periods_last * -1  ;
				for ( $x = $w_start ; $x > $w_end ; $x-- ) {
					$month_val_final[$x] = $month_val[$x] ;
				}
				$scope_desc = "last cycle" ;
				break ;
				
				
				case $periods_this :
				$w_start = $current_period ;
				$w_end = $current_period - $periods_this ;
				for ( $x = $w_start ; $x > $w_end ; $x-- )  {
					$month_val_final[$x] = $month_val[$x] ;
				}
				$scope_desc = "last ".$periods_this." periods" ;
				break ;
				
				
				case ($periods_this/2) :
				$w_start = $current_period ;
				$w_end = $current_period - ( $periods_this / 2 )  ;
				for ( $x = $w_start ; $x > $w_end ; $x-- )  {
					$month_val_final[$x] = $month_val[$x] ;
				}	
				$scope_desc = "last ".($periods_this/2)." periods" ;			
				break ;
				
			}
				



			
			
			
			
			sort($month_val_final,SORT_NUMERIC) ;

			for ($f = 0 ; $f < $weighted_average ; $f++ ) {

				array_shift($month_val_final) ;
				array_pop($month_val_final) ;
				
			}
			
			
			for ($g = 0 ; $g < sizeof($month_val_final); $g++ ) {
		
				$new_array_keys = array_keys($month_val_final) ;
				$value = $month_val_final[$new_array_keys[$g]] ;
				$total_avg += $value ;
				
			}
			
			$total_avg = convertToFloat(($total_avg / sizeof($month_val_final))) ;
			
			

			

			print("<br>Average Sold : <b>".$total_avg."</b> units per month.<br>");
			print("Current period : <b>".$current_period."</b>.<br>") ;
			print("Scope of anaylysis : <b>".$scope_desc."</b>.<br>");
			print("Weighted average done by <b>".$weighted_average."</b> months.<br><br>");
			print("Months of stock to keep : <input type=checkbox name='stlist[]' value='".$itemcode."'> <input value=' Min' type=text size=5 name='min_".$itemcode."' > / <input value=' Max' type=text size=5 name='max_".$itemcode."' > <input type=hidden size=5 name='avg_".$itemcode."' value='".$total_avg."'> <br>");
																											

			
			
			print("</table><br>");
			
			
		}
		
		print("<center><bR><br><input type=submit value='          Update Stock          '></form></center>");
		
		odbc_close($conn);
		
		
	}
				
	print("</table><br><bR>");
	

	include "foot.php" ;
?>

