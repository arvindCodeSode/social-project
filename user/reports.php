<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
require_once 'ip.php';
$activity=new text_activity();
$blogs=new blogs($activity);
$validation=new validation();
$reports=new user_info($activity);
$output="";
if($_SESSION['csrf']==$_POST['csrf']){
	if(!empty($_POST['fname'])  AND !empty($_POST['subject']) AND !empty($_FILES['images']['name'])){
	$fname=$blogs->real_escape($_POST['fname']);
	$ip=$_SESSION['ip'];
	$subject=$blogs->real_escape($_POST['subject']);
	$images=$_FILES['images']['name'];
	$images=preg_replace("/\s/", "_", $images);
	$img_tmp=$_FILES['images']['tmp_name'];
	$img_size=$_FILES['images']['size'];
	$type=$_FILES['images']['type'];
	$img_type=strtolower(pathinfo($images,PATHINFO_EXTENSION));
	$images=pathinfo($images,PATHINFO_FILENAME);
	$array_type=['png','jpg','jpeg','gif'];
		if($img_size > 15730414){
				echo json_encode([
				"status"=>"error",
				"data"=>"file is to large"
			]);
		}
		elseif(in_array($img_type,$array_type)){
				$upload='../image';
				$validimages=$images.date("YmdHisa").".".$img_type;
				$upload=$upload."/".$validimages;
				$check_field= $validation->field_check($_POST,array('fname','subject'));
				$fname_check=$validation->fname_check($fname);
				$subject_check=$validation->user_bio($subject);
				if(!empty($check_field)){
					echo json_encode([
						"status"=>"error",
						"data"=>$check_field
					]);
				}
				elseif(!$fname_check){
				echo json_encode([
						"status"=>"error",
						"data"=>"Invalid Fname! must be alphawate"
					]);
				}
				elseif(!$subject_check){	
					echo json_encode([
						"status"=>"error",
						"data"=>"Maximum 250 character"
					]);
				}else{
					move_uploaded_file($img_tmp, $upload);
					$report=$reports->report($fname,$validimages,$type,$subject,$ip);
					if($report){
						echo json_encode([
							"status"=>"success",
							"data"=>"data successfully Submitted"
						]);
					}else{
						echo json_encode([
							"status"=>"error",
							"data"=>"Data not successfully Submitted"
						]);
					}
				}
		}
		else{
				echo json_encode([
					"status"=>"success",
					"data"=>"only jpg, jpeg, png and  gif allowed"
				]);
			}
	}
	else{
		echo json_encode([
			"status"=>"error",
			"data"=>"please fill the field"
		]);
	}
}else{
		echo json_encode([
			"status"=>"error",
			"data"=>"csrf token missing"
		]);
}
?>