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
if($_SESSION['csrfi']==$_POST['csrfi']){
	if(isset($_POST['post-text']) AND !empty($_POST['post-text']) AND empty($_FILES['file-input']['name'])){
	$post_text=$blogs->real_escape($_POST['post-text']);

	$post=$blogs->post($post_text);
	if($post){
        $last_id=$blogs->get_last_post_id()+1;
        $last_id=$blogs->real_escape($last_id);
		$blog=$blogs->show_data($last_id);
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
	$array_type=['png','jpg','jpeg','gif','mp4','webm','ogg'];
	if($img_size > 115730414 ){
		echo json_encode([
			"status"=>"error",
			"data"=>"file is to large"
		]);
	}
	elseif(in_array($img_type,$array_type)){
		$upload='../dataimage';
		$validImage=$image.date("YmdHisa").".".$img_type;
		$upload=$upload."/".$validImage;
		move_uploaded_file($img_tmp, $upload);
		$post=$blogs->post($post_text=null,$validImage,$type);
		if($post){	
		$last_id=$blogs->get_last_post_id()+1;
        $last_id=$blogs->real_escape($last_id);		
		$blog=$blogs->show_data($last_id);
		echo json_encode([
		'status'=>"success",
		'data'=>$blog
		]);
		}
		else{
		echo json_encode([
			"status"=>"error",
			"data"=>"falied to post"
		]);
		}
	}
	else{
		echo json_encode([
		"status"=>"success",
		"data"=>"only jpg, jpeg, png, webm, ogg, webm   and gif allowed"
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
	$array_type=['png','jpg','jpeg','gif','mp4','webm','ogg'];
	if($img_size > 115730414){
			echo json_encode([
			"status"=>"error",
			"data"=>"file is to large"
		]);
	}
		elseif(in_array($img_type,$array_type)){
			$upload='../dataimage';
			$validImage=$image.date("YmdHisa").".".$img_type;
			$upload=$upload."/".$validImage;
			move_uploaded_file($img_tmp, $upload);
			$post=$blogs->post($post_text,$validImage,$type);
				if($post){			
				$last_id=$blogs->get_last_post_id()+1;
		        $last_id=$blogs->real_escape($last_id);		
				$blog=$blogs->show_data($last_id);
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
				"data"=>"only jpg, jpeg, png, mp4, webm, ogg and gif allowed"
			]);
		}
	}
	else{
		echo json_encode([
			"error"=>"error",
			"data"=>"please fill the field"
		]);
	}
}else{
		echo json_encode([
			"error"=>"error",
			"data"=>"csrf token missing"
		]);
}
?>


 application/msword