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
$func=new func($activity);
$share=new share($activity);
$output="";
$user_id=$blogs->real_escape($_SESSION['user_login']['id']);
$uname=$blogs->real_escape($_SESSION['user_login']['uname']);
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login"
	]);
}
if(!empty($_POST['csrfe']) AND $_POST['csrfe']==$_SESSION['csrfe']){
	if(isset($_POST['post_u_text']) AND !empty($_POST['post_u_text']) AND !empty($_POST['image_u_f']) AND !empty($_POST['image_name']) AND !empty($_POST['type']) ){
		$post_text=$blogs->real_escape($_POST['post_u_text']);
		$image_u_f=$blogs->real_escape($_POST['image_u_f']);
		$image_name=$blogs->real_escape($_POST['image_name']);
		$type=$blogs->real_escape($_POST['type']);
		$type1=$blogs->real_escape($_POST['type1']);
		$post=$blogs->post($post_text,$image_name,$type);
		$img_upload=$func->image_upload($image_name,$user_id,$type1,$image_u_f);
		$delet=$share->delete_Img();
		if($post AND $img_upload AND $delet){
			$blog=$blogs->show_profile_data($uname);
			$image=$share->images();;
			if($image_u_f=="img"){
				echo json_encode([
			    'status'=>"success",
			    'image_img'=>"img",
			    "image_name"=>$image['image'],
				'data'=>$blog
				]);
			}
			elseif($image_u_f=="pro"){
				echo json_encode([
			    'status'=>"success",
			    'image_img'=>"pro",
			    "image_name"=>$image['profile_image'],
				'data'=>$blog
				]);
			}
		}
		else{
			echo json_encode([
			"status"=>"error",
			"data"=>"Sorry there was an problem! Post not uploade!"
			]);
		}
	}
	elseif(empty($_POST['post_u_text']) AND !empty($_POST['image_u_f']) AND !empty($_POST['image_name']) AND !empty($_POST['type']) ){
		$post_text=$blogs->real_escape($_POST['post_u_text']);
		$image_u_f=$blogs->real_escape($_POST['image_u_f']);
		$image_name=$blogs->real_escape($_POST['image_name']);
		$type=$blogs->real_escape($_POST['type']);
		$type1=$blogs->real_escape($_POST['type1']);
			$post=$blogs->post($post_text=null,$image_name,$type);
			$img_upload=$func->image_upload($image_name,$user_id,$type1,$image_u_f);
			$delet=$share->delete_Img();		
			if($post AND $img_upload AND $delet){			
				$blog=$blogs->show_profile_data($uname);
				$image=$share->images();
				if($image_u_f=="img"){
				echo json_encode([
			    'status'=>"success",
			    'image_img'=>"img",
			    "image_name"=>$image['image'],
				'data'=>$blog
					]);
				}
				elseif($image_u_f=="pro"){
					echo json_encode([
				    'status'=>"success",
				    'image_img'=>"pro",
				    "image_name"=>$image['profile_image'],
					'data'=>$blog
					]);
				}
			}
			else{
				echo json_encode([
				"status"=>"error",
				"data"=>"Sorry there was an problem! Post not uploaded!"
				]);
			}	
		}
}
else{
	echo json_encode([
		"status"=>"error",
		"data"=>"csrf token missing"
	]);
}
?>