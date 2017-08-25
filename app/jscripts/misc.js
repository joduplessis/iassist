	function setList(sel,page,other) {
			var listVal = sel.options[sel.options.selectedIndex].value ;
			window.location = "" + page + ".php?page=" + listVal + other + "" ;
	}

	function popup(page,x,y) {
	   	window.open(page,'','resizable=no,menubar=no,toolbar=no,location=no,scrollbars=yes,width=' + x + ',height=' + y + '');
	}


	function setButtonImages(type) {
	
		if (type=="supplier") {
		
			body_code_s = document.getElementById('s_code_image');
			body_name_s = document.getElementById('s_name_image');	
			body_code_c = document.getElementById('c_code_image');
			body_name_c = document.getElementById('c_name_image');			
			
			try {
				body_code_s.style.display=  'table-row';
				body_name_s.style.display=  'table-row';
			} catch(e) {
				body_code_s.style.display = 'block';
				body_name_s.style.display=  'block';
			}

			body_code_c.style.display=  'none';
			body_name_c.style.display=  'none';
			
			
		}
		
		if (type=="customer") {
		
			body_code_s = document.getElementById('s_code_image');
			body_name_s = document.getElementById('s_name_image');	
			body_code_c = document.getElementById('c_code_image');
			body_name_c = document.getElementById('c_name_image');			
			
			try {
				body_code_c.style.display=  'table-row';
				body_name_c.style.display=  'table-row';
			} catch(e) {
				body_code_c.style.display = 'block';
				body_name_c.style.display=  'block';
			}

			body_code_s.style.display=  'none';
			body_name_s.style.display=  'none';
			
			
		}
	
		
	}
	
	function showAdvanced() {
	
		e = document.getElementById('advanced');
		
		if (typeof(e.hidden) == "undefined") e.hidden = 1;
		
		if (e.hidden == 0) {
			e.hidden = 1;
			e.style.display = 'none';
		} else {
			e.hidden = 0;
			e.style.display = 'block';
		}

			
	}
	
// check box script from here ///////////////////////////
	
	function docheck() {
		if (window.addEventListener) {
			window.addEventListener("load", prepare, false);
		} else if (window.attachEvent) {
			window.attachEvent("onload", prepare)
		} else if (document.getElementById) {
			window.onload = prepare;
		}
	}


	var formblock ;
	var forminputs ;

	function prepare() {
		formblock = document.getElementById('form_id');
		forminputs = formblock.getElementsByTagName('input');	
	}

	function select_all(name, value) {
	for (i = 0; i < forminputs.length; i++) {
	// regex here to check name attribute
	var regex = new RegExp(name, "i");
	if (regex.test(forminputs[i].getAttribute('name'))) {
	if (value == '1') {
	forminputs[i].checked = true;
	} else {
	forminputs[i].checked = false;
	}
	}
	}
	}

// check box script ends here  ///////////////////////////

	function showstock(el) {
	
		e = document.getElementById(el);
		
		if (typeof(e.hidden) == "undefined") e.hidden = 1;
		
		if (e.hidden == 0) {
			e.hidden = 1;
			e.style.display = 'none';
		} else {
			e.hidden = 0;
			e.style.display = 'block';
		}

			
	}
	


