<html>
<head>
<title>Gallery</title>

</head>
<style>
body {
	background: #D9D9CB;
}

</style>
<script language=javascript>
	function doit(x) {
		opener.document.f.src.value = x ;
		window.close();
		
	}
</script>

<body>
<?


if ($handle = opendir("../../../../lib")) {

   $x = 1 ;

   print("<table width=100% cellspacing=1 cellpadding=0 bgcolor=#BFBFA7><tr>");

   while (false !== ($file = readdir($handle))) {

		$file = (String)$file ;

           	if ( ($file==".") || ($file=="..") || ($file=="Thumbs.db")) 
		{ 
		} else {
			print("<td bgcolor=#F0F0EE align=center><a href=javascript:doit('lib/".$file."')><img src='img.php?file=../../../../lib/".$file."' border=0></a></td>");
		}

		if (fmod($x,5) == 0) {
			print("</tr><tr>");
		}

		$x++ ;

	  }

}

	print("</table>");


?>



