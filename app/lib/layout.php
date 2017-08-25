<?



	function createHeading($text,$code) {
	
		$sub_menu = "" ;
		
		$sec = getUserData($_SESSION['username'],"sec_type") ;
		$type = getUserData($_SESSION['username'],"view_type") ;
		
		

		switch ($code) {
		
			case "close" :
			
				$sub_menu = "<a href='javascript:window.close()'><font color=".SUB_NAV_TEXT.">Close (x)</font></a>" ;
				
			break ;
			
			case "home" :
			
				$sub_menu = "" ;
				
			break ;
			
		}
	
		switch ($text) {
		
			case "Calender" : 
			$sub_menu = "<font color=".SUB_NAV_TEXT.">
							<a href=cplanner.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
							<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
						 </font>" ;
			break ;
			

		
			case "Customer Details" : 
			
					if (($sec=="admin") || ($sec=="power")) {

						$sub_menu = "<font color=".SUB_NAV_TEXT.">
										<a href=customers_main.php?code=".$code."><font color=".SUB_NAV_TEXT.">Main</font></a> | 
										<a href=customers_invoice.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Invoice</font></a> | 
										<a href=customers_statement.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Statement</font></a> | 
										<a href=customers_rules.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Rules</a> | 
										<a href=customers_analysis.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Stock Analysis</a> |
										<a href=customers_notes.php?code=".$code."><font color=".SUB_NAV_TEXT.">Notes</font></a> | 
										<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a> | 
										<a href='javascript:window.close()'><font color=".SUB_NAV_TEXT.">Close (x)</font></a>
									</font>" ;
									
					} else {
					
						$sub_menu = "<font color=".SUB_NAV_TEXT.">
										<a href=customers_main.php?code=".$code."><font color=".SUB_NAV_TEXT.">Main</font></a> | 
										<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a> | 
										<a href='javascript:window.close()'><font color=".SUB_NAV_TEXT.">Close (x)</font></a>
									</font>" ;
									
					}

			break ;
			
			
			
			
			
			
			
			
			
			
			case "Supplier Details" : 
			
				if (($sec=="admin") || ($sec=="power")) {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=suppliers_main.php?code=".$code."><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=suppliers_invoice.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Invoice</font></a> | 
									<a href=suppliers_statement.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Statement</font></a> | 
									<a href=suppliers_rules.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Rules</a> | 
									<a href=suppliers_analysis.php?var_code=".$code."><font color=".SUB_NAV_TEXT.">Stock Analysis</a> |
									<a href=suppliers_notes.php?code=".$code."><font color=".SUB_NAV_TEXT.">Notes</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a> |
									<a href='javascript:window.close()'><font color=".SUB_NAV_TEXT.">Close (x)</font></a>
								</font>" ;	
								
				} else {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=suppliers_main.php?code=".$code."><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a> |
									<a href='javascript:window.close()'><font color=".SUB_NAV_TEXT.">Close (x)</font></a>
								</font>" ;	
												
				}

			break ;
			
			
			
			
			
			
			
			
			
			

			case "Customers" : 
			
				if (($sec=="admin") || ($sec=="power")) {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=customers.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=customers_invoice.php><font color=".SUB_NAV_TEXT.">Invoice</font></a> | 
									<a href=customers_statement.php><font color=".SUB_NAV_TEXT.">Statement</font></a> | 
									<a href=customers_rules.php><font color=".SUB_NAV_TEXT.">Rules</a> | 
									<a href=customers_analysis.php><font color=".SUB_NAV_TEXT.">Stock Analysis</a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								 </font>" ;
								 
				} else {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=customers.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								 </font>" ;
								 
				}
				
				
			break ;
			
			
			
			
			
			
			
			
			
			case "Suppliers" : 
			
				if (($sec=="admin") || ($sec=="power")) {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=suppliers.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=suppliers_invoice.php><font color=".SUB_NAV_TEXT.">Invoice</font></a> | 
									<a href=suppliers_statement.php><font color=".SUB_NAV_TEXT.">Statement</font></a> | 
									<a href=suppliers_rules.php><font color=".SUB_NAV_TEXT.">Rules</a> | 
									<a href=suppliers_analysis.php><font color=".SUB_NAV_TEXT.">Stock Analysis</a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								 </font>" ;
								 
				} else {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=suppliers.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								 </font>" ;
								 
				}
				
			break ;
			
			
			
			
			
			
			
			
			
			case "Settings" : 
			
				$sub_menu = "<font color=".SUB_NAV_TEXT.">
								<a href=settings.php><font color=".SUB_NAV_TEXT.">Main</font></a> | 
								<a href=settings.php?set=general><font color=".SUB_NAV_TEXT.">General</font></a> | 
								<a href=settings.php?set=document><font color=".SUB_NAV_TEXT.">Document</font></a> | 
								<a href=settings.php?set=email><font color=".SUB_NAV_TEXT.">E-Mail</font></a> | 
								<a href=settings.php?set=error><font color=".SUB_NAV_TEXT.">Errors</font></a> |							
								<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
							</font>" ;
							
			break ;
			
			case "Options" : 
			$sub_menu = "<font color=".SUB_NAV_TEXT."><a href=options.php><font color=".SUB_NAV_TEXT.">Main</font></a>" ;
			break ;
			
			case "Modules" : 
			$sub_menu = "<font color=".SUB_NAV_TEXT."><a href=modules.php><font color=".SUB_NAV_TEXT.">Main</font></a></font>" ;
			break ;	
			
			case "Users" : 
			$sub_menu = "<font color=".SUB_NAV_TEXT."><a href=users.php><font color=".SUB_NAV_TEXT.">Main</font></a>" ;
			break ;
			
			
			
			
			
			
			
			
			
			case "Inventory" : 
			
				if (($sec=="admin") || ($sec=="power")) {			
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=inventory_search.php><font color=".SUB_NAV_TEXT.">Search</font></a> | 
									<a href=inventory_stock.php><font color=".SUB_NAV_TEXT.">Stock Analysis</font></a> | 
									<a href=inventory_order.php><font color=".SUB_NAV_TEXT.">Stock Order Analysis</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								</font>" ;
								
				} else {
				
					$sub_menu = "<font color=".SUB_NAV_TEXT.">
									<a href=inventory_search.php><font color=".SUB_NAV_TEXT.">Search</font></a> | 
									<a href=javascript:window.history.back()><font color=".SUB_NAV_TEXT.">Back</font></a>
								</font>" ;				
				
				}
				
			break ;
			
			
			
			
			
			
			
			
			
			case "Help" : 
			$sub_menu = "<font color=".SUB_NAV_TEXT."><a href=http://www.iassist.co.za/help.php target=_blank><font color=".SUB_NAV_TEXT.">Go there ></font></a>" ;
			break ;




			
		} 

		$all_text = "<table align=center width=100% border=0 cellspacing=0 cellpadding=5>
					 <tr><td bgcolor=".TITLE_NAV_BG."><font size=4 color=".TITLE_NAV_TEXT."><b>".$text."</b></font></tr>
					 <tr><td bgcolor=".SUB_NAV_BG.">".$sub_menu."</tr><tr><td></tr></table></table>" ;
					 
		return $all_text ;
		
		
		
	}
	

	function createTableRow($x,$is_red) {
	
			if ($is_red) {
				$color1 = "red" ;
				$color2 = "red" ;
			} else {
				$color1 = "white" ;
				$color2 = "#efefef" ;
			}
			
			if (fmod($x,2)) {
				return "<tr bgcolor=".$color1." height=1>";
			} else {
				return "<tr bgcolor=".$color2." height=1>";
			}
			
	}
	
	


?>