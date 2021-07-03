<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
	header("Location:login");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogsc=new blogsc($activity);
$output="";
if(isset($_POST['post_id'])){
	$post_id=htmlspecialchars(strip_tags(trim(stripslashes(intval($_POST['post_id'])))));
	$show_comment=$blogsc->show_comment($post_id);
	if($show_comment){
		echo json_encode([
			"status"=>"success",
			"data"=>$show_comment
		]);
	}
}
?>