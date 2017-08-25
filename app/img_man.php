<link href=styles/program.css rel=stylesheet type=text/css>
<body bgColor=white leftmargin="5" topmargin="5" marginwidth="5" marginheight="5">


<?

if (isset($_POST['temp'])) {


	if (is_uploaded_file($_FILES['image']['tmp_name']))
	{

		$dir = "img_lib" ;

		if (copy($_FILES['image']['tmp_name'], $dir.'/'.$_FILES['image']['name'])) {

			print("<br><table width=500 border=0 cellspacing=1 cellpadding=0 bgcolor=#ababab align=center>
			<tr bgcolor=#cbcbcb><td width=38%><div align=right><b><font color=#5C410E size=1 face=Verdana><br>
			<center><h3>Uploaded File :</h3>Successfull !<br><br> ... redirecting</center></font></b>
			</div><br><br></td></tr></table></form><script>window.close();</script>");
		
		} else	{

			print("<br><table width=500 border=0 cellspacing=1 cellpadding=0 bgcolor=#ababab align=center>
			<tr bgcolor=#cbcbcb><td width=38%><div align=right><b><font color=#5C410E size=1 face=Verdana><br>
			<center><h3>Uploaded File :</h3><font color=red>Not Successfull !</font></center></font></b>
			</div><br><br></td></tr></table></form>");

			exit();
		}

	} else {
		echo 'No File Selected';
	}


} else {	
	
	print("<form enctype='multipart/form-data' method=POST action='img_man.php'>
		<table width=100% id=mat cellspacing=1 cellpadding=0 border=0 bgcolor=#dddddd height=100%>
		<tr bgcolor=white><td><table width=100% cellspacing=0 cellpadding=0 border=0><tr><td width=38%> 
		<div align=right><b><center><bR>Upload Images</center><br>
		<center><input type=hidden name=temp value=up>
		<input type=file name=image size=30><br><br>
		<input type=submit value='Upload File Now'><br><br>Maximum filesize is 5 MB.</center></font></b></div><br><br>
		</td></tr></table></form>");
}

?>
<center><a href=javascript:window.close()><font face=verdana size=1><b>Close(x)</b></font></a></center><br>
</div>
</body>