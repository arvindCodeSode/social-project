<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$change_pass=new func($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{
	$old_psw=$change_pass->real_escape($_POST['oldpsw']);
	$new_psw=$change_pass->real_escape($_POST['newpsw']);
	$con_psw=$change_pass->real_escape($_POST['conpsw']);
	$csrf=$change_pass->real_escape($_POST['csrf']);
	$check_field= $validation->field_check_ajax($_POST,array('oldpsw','csrf','newpsw','conpsw'));
	$old_check=$validation->password_check($old_psw);
	$new_check=$validation->password_check($new_psw);
	$con_check=$validation->password_check($con_psw);
		
	if(!empty($check_field)){
		echo json_encode([
			"status"=>"error",
			"data"=>$check_field
		]);
	}
	elseif(!$old_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Old Password"
			]);

	}
	elseif(!$new_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Follow the rule!"
			]);
	}
	elseif(!$con_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"follow the rule"
		]);
	}else{
		if($csrf!=$_SESSION['csrfc']){
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing!"
			]);
		}else{
			if($new_psw==$con_psw){
				$user_id=$change_pass->real_escape($_SESSION['user_login']['id']);
				$user_name=$change_pass->real_escape($_SESSION['user_login']['uname']);
				$match_old_password=$change_pass->old_password($old_psw,$user_id,$user_name);
				if($match_old_password){
						$data=$change_pass->change_password($con_psw,$user_name,$user_id);
					if($data){
						echo json_encode([
							"status"=>"success",
							"data"=>"Password Changed!"
						]);
					}else{
						echo json_encode([
							"status"=>"error",
							"data"=>"failed to change the password!"
						]);
						}	
				}
				else{
					echo json_encode([
						"status"=>"error",
						"data"=>"Old Password not matched!"
					]);

				}		
			}else{
				echo json_encode([
						"status"=>"error",
						"data"=>"Password and Confirm Password not matched!"
				]);
			}
		}
		
	}
}

?>