<?

	$file = $_GET['file'] ;

	header("Content-type: image/jpeg");

	$first = ImageCreateFromJPEG($file) or die("couldn't open image");
	
	$size = floor ( imagesx($first) / imagesy($first) ) ;
	
	if ($size==1) {
		$second = imagecreatetruecolor(100,75) or die("couldn't create image");
		ImageCopyResized($second,$first,0,0,0,0,100,75,imagesx($first),imagesy($first)) or die("coudln't resize image");
	} else {
		$second = imagecreatetruecolor(75,100) or die("couldn't create image");
		ImageCopyResized($second,$first,0,0,0,0,75,100,imagesx($first),imagesy($first)) or die("coudln't resize image");
	}

	ImageJPEG($second) or die("couldn't save image"); 

	ImageDestroy($second);
	ImageDestroy($first);
?>