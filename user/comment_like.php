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
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{

	// [dataCommentId] => 31
 //    [dataPostId] => 25
 //    [action] => likes
	$html="";	
	$dataCommentId=$blogs->real_escape($_POST['dataCommentId']);
	$dataPostId=$blogs->real_escape($_POST['dataPostId']);
	$action=$blogs->real_escape($_POST['action']);
	if(!empty($action) AND !empty($dataCommentId) AND !empty($dataPostId)){
		$post_status=$blogs->comment_status($action,$dataPostId,$dataCommentId);
		if($post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->comment_update_like($dataCommentId,$dataPostId ,'decrement');
		}
		elseif(!$post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->comment_update_like($dataCommentId,$dataPostId,'increment');
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