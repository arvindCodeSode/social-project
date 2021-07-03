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
$func=new func($activity);
if(!empty($_POST['commnet-post']) AND ($_POST['commnet-post']!="") AND !empty($_POST['post_id']) AND ($_POST['commnet-post']!="") AND !empty($_POST['csrf'])){
	$commnet_post=$blogs->real_escape($_POST['commnet-post']);
	$csrf=$blogs->real_escape($_POST['csrf']);
	$post_id=$blogs->real_escape($_POST['post_id']);
	$commnet=$blogs->comment_post_sub($post_id,$commnet_post);
	$comment=$blogs->comment_count($post_id);
	$reply=$blogs->reply_count($post_id);
	$data=$comment+$reply;
	if ($commnet AND $data) {
	echo json_encode([
		"status"=>"success",
		"data"=>$commnet,
		"totalComment"=>$data
		]);
	}else{
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