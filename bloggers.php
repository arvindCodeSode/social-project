<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
	header("Location:user/home");
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
	<title></title>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
 		<?=$share->bloggers_list();?>
 <script type="text/javascript" src="public/js/compress.js"></script>
 <script type="text/javascript" src="public/js/demo_js.js"></script>
</body>
</html>