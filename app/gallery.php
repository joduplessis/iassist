<html>
<head>
<title>Gallery</title>

</head>
<link href=styles/program.css rel=stylesheet type=text/css>
<script language=javascript>
	function doit(x) {
		opener.document.f.logo_new.value = x ;
		window.close();
		
	}
</script>

<body>
<?


if ($handle = opendir("img_lib")) {

   $x = 1 ;

   print("<table width=100% cellspacing=1 cellpadding=3 bgcolor=#ededed><tr bgcolor=white>");

   while (false !== ($file = readdir($handle))) {

		$file = (String)$file ;

           	if ( ($file==".") || ($file=="..") || ($file=="Thumbs.db")) 
		{ 
		} else {
			print("<td bgcolor=white align=center><a href=javascript:doit('img_lib/".$file."')><img src='img.php?file=img_lib/".$file."' border=0></a></td>");
		}

		if (fmod($x,5) == 0) {
			print("</tr><tr>");
		}

		$x++ ;

	  }

}

	print("</table><br><br><center><a href=javascript:window.close()><b>Close(x)</b></a></center>");


?>



