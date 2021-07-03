<?php
session_start();
header("Content-type:image/jpeg");
$random=bin2hex(random_bytes(10));
$captcha=substr($random, 0,5);
$text=$_SESSION['code']=$captcha;
$font_size=25;
$width=120;
$height=40;
$image=imagecreate($width, $height);
$r=mt_rand(100,200);
$g=mt_rand(100,200);
$b=mt_rand(100,200);
$black=imagecolorallocate($image, $r, $g, $b);
$r=mt_rand(0,100);
$g=mt_rand(0,100);
$b=mt_rand(0,100);
$color=imagecolorallocate($image, $r, $g, $b);
for($i=0;$i<10;$i++){
	$x1=mt_rand(0,100);
	$y1=mt_rand(0,100);
	$x2=mt_rand(0,100);
	$y2=mt_rand(0,100);
	imageline($image, $x1, $y1, $x2, $y2, $color);
}
$font=dirname(__FILE__).'/font.ttf';
imagettftext($image, $font_size, 0, 15, 30, $color,$font , $text);
imagejpeg($image);


?>