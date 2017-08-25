<?


	function db_connect() {
	
		$host = MYSQL_SERVER ;
		$username = MYSQL_USERNAME ;
		$password = MYSQL_PASSWORD ;
		$database = MYSQL_DATABASE ;
	
		$connect = mysql_connect($host, $username, $password) ;

		if ($connect) {

			$select_db = mysql_select_db($database);

			if ($select_db) {

				return true ;

			} else {

				return false ;

			}			

		} else {

			return false ;

		}

	}
	 
	function connect() {
	
		$DSN = getAssistSettings("dsn");
		$username = getAssistSettings("dsn_user");
		$password = getAssistSettings("dsn_pass");

		$conn = odbc_connect($DSN,$username,$password);
		
		return $conn ;

	}
	
	function connect_lastyear() {
	
		$DSN = getAssistSettings("dsn2");
		$username = getAssistSettings("dsn2_user");
		$password = getAssistSettings("dsn2_pass");

		$conn = odbc_connect($DSN,$username,$password);
		
		return $conn ;
		
	}
	 
?>