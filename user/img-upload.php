<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$login=new func($activity);
$share=new share($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"error",
		"data"=>"user/login"
	]);
}else{
	$user_id=$_SESSION['user_login']['id'];
	if(!empty($_FILES['i-u-i']['name']) AND !empty($_POST['csrfb']) AND isset($_POST['i-u-it']) AND !empty($_POST['i-u-it']) ){
		if(!empty($_POST['csrfb']) AND $_SESSION['csrfb']==$_POST['csrfb']){
			$image=$_FILES['i-u-i']['name'];
			$image=preg_replace("/\s/", "_", $image);
			$img_tmp=$_FILES['i-u-i']['tmp_name'];
			$img_size=$_FILES['i-u-i']['size'];
			$type=$_FILES['i-u-i']['type'];
			$img_type=strtolower(pathinfo($image,PATHINFO_EXTENSION));
			$image=pathinfo($image,PATHINFO_FILENAME);
			$array_type=['png','jpg','jpeg','gif'];
			if($img_size >= 52428800 ){
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
					$upload=$login->upload($validImage,$user_id,$img_type,"a");
					if($upload){
					$img_select=$share->image_select();			
					echo json_encode([
					'status'=>"success",
					'data'=>$img_select['image'],
					"img"=>"img",
					"type"=>$type,
					'type1'=>$img_type
					]);
					}
					else{
						echo json_encode([
						"status"=>"error",
						"data"=>"sorry file is not uploaded"
						]);
					}
			}
			else{
					echo json_encode([
					"status"=>"error",
					"data"=>"only jpg, jpeg, png, and gif allowed"
				]);
			}
		}else{
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing"
			]);
		}

	}
	elseif(!empty($_FILES['i-u-p']['name']) AND !empty($_POST['csrfa']) AND isset($_POST['i-u-pt']) AND !empty($_POST['i-u-pt']) ){
		if(!empty($_POST['csrfa']) AND $_POST['csrfa']==$_SESSION['csrfa']){
			$image=$_FILES['i-u-p']['name'];
			$image=preg_replace("/\s/", "_", $image);
			$img_tmp=$_FILES['i-u-p']['tmp_name'];
			$img_size=$_FILES['i-u-p']['size'];
			$type=$_FILES['i-u-p']['type'];
			$img_type=strtolower(pathinfo($image,PATHINFO_EXTENSION));
			$image=pathinfo($image,PATHINFO_FILENAME);
			$array_type=['png','jpg','jpeg','gif'];
			if($img_size > 52428800){
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
					$upload=$login->upload($validImage,$user_id,$img_type,"b");
					if($upload){			
					$img_select=$share->image_select();
					echo json_encode([
					'status'=>"success",
					'data'=>$img_select['profile_image'],
					"img"=>"pro",
					"type"=>$type,
					'type1'=>$img_type
					]);
					}
					else{
						echo json_encode([
						"status"=>"error",
						"data"=>"sorry file is not uploaded"
						]);
					}
			}
			else{
				echo json_encode([
					"status"=>"error",
					"data"=>"only jpg, jpeg, png, and gif allowed"
				]);
			}
		}else{
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing"
			]);
		}
	}
}
?>