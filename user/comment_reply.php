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
$output="";
if(!empty($_POST['commnet-post']) AND ($_POST['commnet-post']!="") AND !empty($_POST['post_id']) AND ($_POST['commnet-post']!="") AND !empty($_POST['csrf']) AND !empty($_POST['comment_id'])){
	$commnet_post=$blogs->real_escape($_POST['commnet-post']);
	$csrf=$blogs->real_escape($_POST['csrf']);
	$post_id=$blogs->real_escape($_POST['post_id']);
	$comment_id=$blogs->real_escape($_POST['comment_id']);
	$commnet=$blogs->reply_post_sub($post_id,$comment_id,$commnet_post);
	$reply=$blogs->reply_count($post_id);
	$comment=$blogs->comment_count($post_id);
	$data=$comment+$reply;
	if ($commnet AND $data) {
	echo json_encode([
		"status"=>"success",
		"data"=>$commnet,
		"totalComment"=>$data
		]);
	}
	else{
		echo json_encode([
			"status"=>"error",
			"data"=>"falied to comment",
			"totalComment"=>$data
		]);
	}
}
else{
	echo json_encode([
		"status"=>"error",
		"data"=>"please fill the data"
	]);
}
?>