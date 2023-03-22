<?
	@session_start();
	$fonts = array(
	'timesbd.ttf'
	);
	$chars = "1234567890";
	$length = strlen($chars) - 1;
	$x = 0;
	$img = imagecreate(75, 15);
	$color['1'] = ImageColorAllocate($img, 255, 255, 255);
	$color['2'] = ImageColorAllocate($img, 0, 0, 0);
	for($i = 0; $i < 90; $i++)
	{
		imagesetpixel($img, rand(0,75), rand(0,15), $color['2']);
	}
	$randtext = "";
	for($i = 0; $i < 6; $i++){
   		$rand = rand(0, $length);
   		$randchar = $chars[$rand];
   		$randtext .= $randchar;
   		ImageTTFText($img, rand(11,12), 0, rand(2+$x,4+$x), rand(13,14), $color['2'], $fonts[rand(0, count($fonts) - 1)], $randchar);
   		$x += 12;
	}
	setcookie("randtext", "$randtext", time() + 900);
	header('Content-Type: image/png');
	Imagepng($img);
	ImageDestroy($img);
?>
