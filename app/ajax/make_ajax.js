
	var xmlHttp = false;
	
	try {
		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e2) {
			try {
				  xmlHttp = new XMLHttpRequest();
			} catch (e3) {
				    xmlHttp = false;
			}
		}
	}
	
	if (!xmlHttp) {
		alert("Warning - your browser will not allow you to be added to the newsletter mailing list.");
	}