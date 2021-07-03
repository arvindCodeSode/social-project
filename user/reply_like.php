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
	$CommentId=$blogs->real_escape($_POST['CommentId']);
	$PostId=$blogs->real_escape($_POST['PostId']);
	$replyId=$blogs->real_escape($_POST['replyId']);
	$action=$blogs->real_escape($_POST['action']);
	if(!empty($action) AND !empty($CommentId) AND !empty($PostId) AND !empty($replyId) ){
		$post_status=$blogs->reply_status($action,$PostId,$CommentId,$replyId);
		if($post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->reply_update_like($CommentId,$PostId ,$replyId,'decrement');
		}
		elseif(!$post_status['liked'] AND $_POST['action']=="likes"){
			$html=$blogs->reply_update_like($CommentId,$PostId,$replyId,'increment');
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