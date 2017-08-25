<?

	$file = $_GET['file'] ;

	header("Content-type: image/jpeg");

	$first = ImageCreateFromJPEG($file) or die("couldn't open image");
		

		for ($x = 1 ; $x < 1000 ; $x++) {

		$xsize = imagesx($first) ;
		$ysize = imagesy($first) ;
		
		$xsize = $xsize / $x ;
		$ysize = $ysize / $x ;
		
		if (($xsize<=100)||($ysize<=100)) {
		
			$newx = $xsize ;
			$newy = $ysize ;
			break ;
			
		}
		
	}

	
	$second = imagecreatetruecolor($newx,$newy) or die("couldn't create image");
	
	ImageCopyResized($second,$first,0,0,0,0,$newx,$newy,imagesx($first),imagesy($first)) or die("coudln't resize image");

	ImageJPEG($second) or die("couldn't save image"); 

	ImageDestroy($second);
	
	ImageDestroy($first);
	

?>