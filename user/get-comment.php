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
if(isset($_POST['post_id'])){
	$post_id=$blogs->real_escape($_POST['post_id']);
	$comment=$blogs->comment_count($post_id);
	$reply=$blogs->reply_count($post_id);
	$data=$comment+$reply;
	if($data){
		echo $data;
	}else{
		echo "0";
	}
}


?>