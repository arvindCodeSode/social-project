<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$change_user=new func($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{
	$old_user=$change_user->real_escape($_POST['olduser']);
	$new_user=$change_user->real_escape($_POST['newuser']);
	$con_user=$change_user->real_escape($_POST['conuser']);
	$csrf=$change_user->real_escape($_POST['csrfs']);
	$check_field= $validation->field_check_ajax($_POST,array('olduser','csrfs','newuser','conuser'));
	$old_check=$validation->uname_check($old_user);
	$new_check=$validation->uname_check($new_user);
	$con_check=$validation->uname_check($con_user);
		
	if(!empty($check_field)){
		echo json_encode([
			"status"=>"error",
			"data"=>$check_field
		]);
	}
	elseif(!$old_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Old Username"
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
		if($csrf!=$_SESSION['csrfs']){
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing!"
			]);
		}else{
			if($new_user==$con_user){
				$user_id=$change_user->real_escape($_SESSION['user_login']['id']);
				if($old_user[0]==chr(64)){
						$old_user=$old_user;
					}else{
						$old_user="@".$old_user;
				}
				$match_old_username=$change_user->old_username($user_id,$old_user);
				if($match_old_username){
						if($con_user[0]==chr(64)){
							$con_user=$con_user;
						}else{
							$con_user="@".$con_user;
						}
						$data=$change_user->change_username($con_user,$user_id);
					if($data){
						$_SESSION['user_login']['uname']=$con_user;
						echo json_encode([
							"status"=>"success",
							"data"=>"Username Changed!",
							"uname"=>$con_user
						]);
					}else{
						echo json_encode([
							"status"=>"error",
							"data"=>"failed to change the Username!"
						]);
						}	
				}
				else{
					echo json_encode([
						"status"=>"error",
						"data"=>"Old Username not matched!"
					]);

				}		
			}
			else{
					echo json_encode([
						"status"=>"error",
						"data"=>"Username and Confirm Username not matched!"
					]);

			}
		}
		
	}
}

?>