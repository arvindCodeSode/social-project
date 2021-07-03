<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login.php",
	]);
}
else{
	$html="";
	$action=$blogs->real_escape($_POST['action']);
	$post_id=$blogs->real_escape($_POST['post_id']);
	if(!empty($action) AND !empty($post_id)){
		$post_status=$blogs->post_status($action,$post_id);
		if($post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->update_like($_POST ,'decrement');
		}
		elseif(!$post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->update_like($_POST,'increment');
		}
		if(!empty($html)){
			echo json_encode([
			"status"=>"success",
			"data"=>$html
			]);
		}
	}
}

?>