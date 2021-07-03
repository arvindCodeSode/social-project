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
$profile=new func($activity);
$blogs=new blogs($activity);
$share=new share($activity);
$validation=new validation();
if(isset($_GET['uname'])){
		$uname=$profile->real_escape($_GET['uname']);		
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once 'link.php'; ?>
	<title>ViVinam: Picute</title>
	<style type="text/css">
	</style>
</head>
<body>
	<div class="all-row">
		<?=$profile->show_picture($uname); ?>
	</div>
	<div class="open-modal-img" id="open-modal-img">
            <span class="close-image" id="close-image">&times;</span>
            <img class="user-image" id="user-img01" />

   </div>
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
</body>
</html>