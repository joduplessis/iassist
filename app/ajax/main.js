

	

	function login() {
	
		var query = document.getElementById("query").value;
		   
		if ( (query == null) || (query == "")) return;
		  
		var url = "sendmail.php?email=" + email ;
		  
		xmlHttp.open("GET", url, true);
		
		xmlHttp.onreadystatechange = result;
		
		xmlHttp.send(null);
	  
	}
	
	function result() {
	
		if (xmlHttp.readyState == 4) {
		  
			var response = xmlHttp.responseText;
			
			var win = document.getElementById("search-results") ;
				
			win.style.display = 'inline';
			win.style.width = '300px';
			win.style.height = '1px';
			win.style.left = '225px';
			win.style.top = '200px';
			win.style.position = 'absolute' ;
			win.style.backgroundColor = '#eeeeee';
			win.style.border = 'solid 0px #cccccc';
			win.style.padding = '0px';
			win.innerHTML = '<table width=100 height=200><tr><td>' + response + '</table>';

		}
	  
	}
