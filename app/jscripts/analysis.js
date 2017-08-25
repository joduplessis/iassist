<!--
function getCookie(name) {
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
    begin = dc.indexOf(prefix);
    if (begin != 0) return null;
  } else
    begin += 2;
  var end = document.cookie.indexOf(";", begin);
  if (end == -1)
    end = dc.length;
  return unescape(dc.substring(begin + prefix.length, end));
}

// LIST ALL SHOW/HIDE ELEMENT IDS HERE
menus_array = new Array ('ddIT', 'ddLegal', 'ddMining', 'ddEnergy', 'ddChemicals', 'ddConstruction', 'ddAviation', 'ddServices');
menus_status_array = new Array ();// remembers state of switches
img_close = 'img/arrow_up.gif';
img_open = 'img/arrow_down.gif';

function showHideSwitch (theid) {
  if (document.getElementById) {
    var switch_id = document.getElementById(theid);
    var imgid = theid+'Button';
    var button_id = document.getElementById(imgid);
    if (menus_status_array[theid] != 'show') {
      button_id.setAttribute ('src', img_close);
      switch_id.className = 'showSwitch';
	  menus_status_array[theid] = 'show';
	  document.cookie = theid+'=show';
    }else{
      button_id.setAttribute ('src', img_open);
      switch_id.className = 'hideSwitch';
	  menus_status_array[theid] = 'hide';
	  document.cookie = theid+'=hide';
    }
  }
}
function resetMenu () { // read cookies and set menus to last visited state
  if (document.getElementById) {
    for (var i=0; i<menus_array.length; i++) {
      var idname = menus_array[i];
      var switch_id = document.getElementById(idname);
      var imgid = idname+'Button';
      var button_id = document.getElementById(imgid);
      if (getCookie(idname) == 'show') {
	    button_id.setAttribute ('src', img_close);
        switch_id.className = 'showSwitch';
	    menus_status_array [idname] = 'show';
	  }else{
	    button_id.setAttribute ('src', img_open);
        switch_id.className = 'hideSwitch';
	    menus_status_array [idname] = 'hide';
	  }
    }
  }
}
//-->