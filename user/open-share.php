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
$blogs=new blogs($activity);
$share=new share($activity);
$validation=new validation();
$output="";
if(isset($_POST['post_id'])){
	$post_id=$blogs->real_escape($_POST['post_id']);
	$data=$share->open_share($post_id);
	if($data){
		echo json_encode([
			"status"=>"success",
			"data"=>$data
		]);
	}else{
		echo json_encode([
			"status"=>"erro",
			"data"=>"not found"
		]);
	}
}
?>