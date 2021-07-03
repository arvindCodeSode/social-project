<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
    header("Location:user/login");
}
function __autoload($class){
	require_once "classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="ViVinam" />
 	<meta name="keywords" content="Social Site, ViVinam, Vichar, Vicharam" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>ViVinam: Adminstration</title>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<style type="text/css">
		.right-container{position: sticky;top: 0px;}
		.left-container{position: sticky;top:0;}
	</style>
</head>
<body>
<!--topnav file-->
<?php 
require_once 'topnav.php'; ?>
 <!-- topnav file end-->
<?php ?>
    
 <!--footer file-->
  <?php 
 require_once 'footer.php'; ?>
 <!--end footer file-->
 <!--script start-->

<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<!--script end-->
</body>
</html>