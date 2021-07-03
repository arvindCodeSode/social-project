<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$login=new func($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"error",
		"data"=>"user/login"
	]);
}
else{
	$uname=$_SESSION['user_login']['uname'];
	$fname=$login->real_escape($_POST['fname']);
	$user_bio=$login->real_escape($_POST['user-bio']);
	$mobile=$login->real_escape($_POST['mobile']);
	$location=$login->real_escape($_POST['location']);
	$profession=$login->real_escape($_POST['profession']);
	$csrf=$login->real_escape($_POST['csrfg']);
	$field_check=$validation->field_check_ajax($_POST,array('fname','user-bio','mobile','location','profession'));
	$user_check=$validation->user_bio($user_bio);
	$location_check=$validation->field($location);
	$profession_check=$validation->field($profession);
	$mobile_check=$validation->mobile_check($mobile);
	if(!$user_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Bio must be less than 200 character"
		]);
	}elseif(!$location_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"location must be less than 150 character"
		]);
	}elseif(!$profession_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"profession must be less than 150 character"
		]);
	}elseif(!$mobile_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Mobile No."
		]);
	}
	else{

		if($_POST['csrfg']==$_SESSION['csrfg']){
			$user_id=$login->real_escape($_SESSION['user_login']['id']);
			$update=$login->update($fname,$mobile,$user_bio,$location,$profession,$user_id);
			if($update){
				
				echo json_encode([
					"status"=>"success",
					"data"=>"successfully",
					"uname"=>$uname
				]);
			}else{
				echo json_encode([
					"status"=>"error",
					"data"=>"failed to edit data"
				]);
			}
		}
	}
}