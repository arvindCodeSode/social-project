<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);
$validation=new validation();
$output="";
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
elseif(isset($_POST['user_id']) AND !empty($_POST['user_id'])){
	$user_id=$blogs->real_escape($_POST['user_id']);
	$data=$share->friends_list($user_id);
	$last_id=$_SESSION['user_last_id'];
	if($data){
		echo json_encode([
			"status"=>"success",
			"data"=>$data,
			"last_id"=>$last_id
		]);
	}else{
		echo json_encode([
			"status"=>"error",
			"data"=>"No More Data"
		]);
	}
}
else{
	echo json_encode([
		"status"=>"error",
		"data"=>"No more data"
	]);
}