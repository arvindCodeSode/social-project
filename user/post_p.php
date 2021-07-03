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
$uname=$_SESSION['user_login']['uname'];
$activity=new text_activity();
$blogs=new blogs($activity);
$validation=new validation();
if($_SESSION['csrfi']==$_POST['csrfi']){
	if(isset($_POST['post-text']) AND !empty($_POST['post-text']) AND empty($_FILES['file-input']['name'])){
	$post_text=$blogs->real_escape($_POST['post-text']);

	$post=$blogs->post($post_text);
	if($post){
		$blog=$blogs->show_profile_data($uname);
		echo json_encode([
		'status'=>"success",
		'data'=>$blog
		]);
	}
	else{
		echo json_encode([
		"status"=>"error",
		]);
	}
}
elseif(!empty($_FILES['file-input']['name']) AND !empty($_FILES['file-input']['type']) AND empty($_POST['post-text'])){
	$image=$_FILES['file-input']['name'];
	$image=preg_replace("/\s/", "_", $image);
	$img_tmp=$_FILES['file-input']['tmp_name'];
	$img_size=$_FILES['file-input']['size'];
	$type=$_FILES['file-input']['type'];
	$img_type=strtolower(pathinfo($image,PATHINFO_EXTENSION));
	$image=pathinfo($image,PATHINFO_FILENAME);
	$array_type=['png','jpg','jpeg','gif','webm','ogg','mp4'];
	if($img_size > 115730414){
		$output.="file is too large";
	}
	elseif(in_array($img_type,$array_type)){
		$upload='../dataimage';
		$validImage=$image.date("YmdHisa").".".$img_type;
		$upload=$upload."/".$validImage;
		move_uploaded_file($img_tmp, $upload);
		$post=$blogs->post($post_text=null,$validImage,$type);
		if($post){			
		$blog=$blogs->show_profile_data($uname);
		echo json_encode([
		'status'=>"success",
		'data'=>$blog
		]);
		}
		else{
			echo json_encode([
			"status"=>"error",
			"data"=>"failed to post"
			]);
		}
	}
	else{
		echo json_encode([
		"status"=>"success",
		"data"=>"only jpg, jpeg, png, webm, mp4, ogg and gif allowed"
	]);
	}
}
elseif(!empty($_POST['post-text'])  AND !empty($_FILES['file-input']['name'])){
	$post_text=$blogs->real_escape($_POST['post-text']);
	$image=$_FILES['file-input']['name'];
	$image=preg_replace("/\s/", "_", $image);
	$img_tmp=$_FILES['file-input']['tmp_name'];
	$img_size=$_FILES['file-input']['size'];
	$type=$_FILES['file-input']['type'];
	$img_type=strtolower(pathinfo($image,PATHINFO_EXTENSION));
	$image=pathinfo($image,PATHINFO_FILENAME);
	$array_type=['png','jpg','jpeg','gif','webm','ogg','mp4'];
	if($img_size >115730414 ){
		$output.="file is too large";
	}
	elseif(in_array($img_type,$array_type)){
		$upload='../dataimage';
		$validImage=$image.date("YmdHisa").".".$img_type;
		$upload=$upload."/".$validImage;
		move_uploaded_file($img_tmp, $upload);
		$post=$blogs->post($post_text,$validImage,$type);
		if($post){	
		$blog=$blogs->show_profile_data($uname);
		echo json_encode([
		'status'=>"success",
		'data'=>$blog
		]);
		}
		else{
			echo json_encode([
			"status"=>"error",
			"data"=>"failed to post"
			]);
		}
	}
	else{
		echo json_encode([
		"status"=>"success",
		"data"=>"only jpg, jpeg, png,ogg, mp4, webm and gif allowed"
	]);
	}
}
else{
	echo json_encode([
		"error"=>"error",
		"data"=>"please fill the field"

	]);
}
}
else{
		echo json_encode([
			"error"=>"error",
			"data"=>"csrf token missing"
		]);
}
?>