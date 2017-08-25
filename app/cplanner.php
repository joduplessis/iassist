<?

	require_once("headers.php") ;
	require_once("navigation.php") ;
	
	print( createHeading("Calender",0) ) ;	

	$page = "cplanner" ;
	







	print("<br><b><font color=".TEXT_HEADING.">Calender : </font></b><br><br>");
	print("<table width=100% cellspacing=1 cellpadding=3 border=0 bgcolor=#dddddd>");
	print("<tr bgcolor=white><td>");

	
	

	if (isset($submit)) {



		if ($submit == "Prev") {
		
			$month_now--;
			
		} else {
		
			$month_now++; }

			$date = getdate(mktime(0,0,0,$month_now,1,$year_now));

	} else {
	
		$date = getdate();
		
	}

	$month_num = $date["mon"];
	$month_name = $date["month"];
	$year = $date["year"];
	$date_today = getdate(mktime(0,0,0,$month_num,1,$year));
	$first_week_day = $date_today["wday"];
	$cont = true;
	$today = 27;

	while (($today <= 32) && ($cont)) {
	
		$date_today = getdate(mktime(0,0,0,$month_num,$today,$year));

		if ($date_today["mon"] != $month_num) {
		
			$lastday = $today - 1;
			$cont = false;
			
		}

		$today++;
		
	}

	// allow for form submission to the script for forward and backwards

	print("<form action=cplanner.php method=POST name=calendar>");
	print("<input type=hidden name=month_now value=".$month_num.">");
	print("<input type=hidden name=year_now value=".$year.">");
	print("<table width=100%>");
	print("<tr><td><input type=submit name=submit value=Prev></td>");
	print("<td align=right><input type=submit name=submit value=Next></td></tr>");
	print("</table></form>");

	print("<table align=center width=100% border=0 cellspacing=1 cellpadding=3 height=100>");
	print("
	<tr bgcolor=#dddddd height=1><td colspan=7><b>".$month_name." ".$year."</b></td></tr>
	<tr bgcolor=#dddddd height=1>
		<td width=14%>Sunday</td>
		<td width=14%>Monday</td>
		<td width=14%>Tuesday</td>
		<td width=14%>Wednesday</td>
		<td width=14%>Thursday</td>
		<td width=15%>Friday</td>
		<td width=15%>Saturday</td></tr>");

	// begin placement of days according to their beginning weekday

	$day = 1;
	$wday = $first_week_day;
	$firstweek = true;
	
	while ( $day <= $lastday) {
	
		if ($firstweek) {
		
			echo "<tr height=50 bgcolor=#eeeeee>";
			
			for ($i=1; $i<=$first_week_day; $i++) {
			
				echo "<td>  </td>";
				
			}
			
			$firstweek = false;
		
		}
		
		if ($wday==0) {
		
			echo "<tr height=50 bgcolor=#eeeeee>";
			
		}

		// make each day linkable to the following result.php page


		if ( intval($month_num) < 10) { $new_month_num = "0$month_num"; }
		elseif (intval($month_num) >= 10) { $new_month_num = $month_num; }
		if ( intval($day) < 10) { $new_day = "0$day"; }
		elseif (intval($day) >= 10) { $new_day = $day; }
		$link_date = "$year-$new_month_num-$new_day";
		
		
		print("<td valign=top><b>".$day."</b><Br>");
		
			
		$query = mysql_query("SELECT type, code FROM notes WHERE user = '$username' AND created_date = '$link_date'") ;
		while ($get_note = mysql_fetch_row($query)) {
		
			print("<a href=javascript:popup(\"".$get_note['0']."s_notes.php?code=".$get_note['1']."\",500,550)>");
			print(getCompanyName($get_note['1'],$get_note['0']));
			print("</a><br>");
			
		}
		

		if ($wday==6) {
		
			echo "</tr>";
		
		}

		$wday++;
		$wday = $wday % 7;
		$day++;
	
	}
	
	echo"</table>";
	
	

	
	print("</table>");
	
	
	
	
	
	
		
		


	
	

	include "foot.php" ;
?>