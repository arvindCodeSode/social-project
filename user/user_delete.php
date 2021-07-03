<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$delete_user=new func($activity);
$validation=new validation();
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{
	$csrfj=$delete_user->real_escape($_POST['csrfj']);
	if($csrfj==$_SESSION['csrfj']){
		$email_d=$delete_user->real_escape($_POST['email_d']);
		$uname_d=$delete_user->real_escape($_POST['uname_d']);
		$captcha=$delete_user->real_escape($_POST['captcha']);
		$password=$delete_user->real_escape($_POST['pass_d']);
		$password=crypt($password,"$6$6000$");
		$check_field= $validation->field_check_ajax($_POST,array('email_d','csrfj','uname_d','captcha','pass_d'));
		$data_match=$delete_user->data_match();
		if($uname_d[0]==chr(64)){
			$uname_d=$uname_d;
		}else{
			$uname_d="@".$uname_d;
		}
		if(!empty($check_field)){
			echo json_encode([
				"status"=>"error",
				"data"=>$check_field
			]);
		}
		elseif($data_match['email']!=$email_d){
			echo json_encode([
				"status"=>"email",
				"data"=>" * email not matched!"
				]);
		}
		elseif($data_match['uname']!=$uname_d){
			echo json_encode([
				"status"=>"uname",
				"data"=>" * Username not matched!"
				]);
		}
		elseif($data_match['password']!=$password){
			echo json_encode([
				"status"=>"password",
				"data"=>"password not matched"
			]);
		}
		else{
			if($captcha!=$_SESSION['code']){
				echo json_encode([
					"status"=>"captcha",
					"data"=>" * Capthca not matching!"
				]);
			}else{

				$delete_data=$delete_user->delete_data($email_d,$uname_d,$password);
				if($delete_data){
					session_unset();
					session_destroy();
					echo json_encode([
						"status"=>"success",
						"url"=>"register"
					]);
				}else{
					echo json_encode([
						"status"=>"error",
						"data"=>"There was a problem data not deleted"
					]);
				}
			}
			
		}

	}else{
		echo json_encode([
			"status"=>"error",
			"data"=>"csrf not matching or missing!"
		]);
	}
}

?>