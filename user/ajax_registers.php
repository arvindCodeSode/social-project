<?php
ob_start();
session_start();
session_regenerate_id( true );
if(isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"login",
		"data"=>"../home"
	]);
}
function __autoload($class){
	require_once "../classes/$class.php";
}
require_once 'ip.php';
$ip=$_SESSION['ip'];
$message="";
$activity=new text_activity();
$add=new func($activity);
$validation=new validation();
	$csrf=$add->real_escape($_POST['csrf']);
	$fname=$add->real_escape($_POST['fname']);
	// $mobile=$add->real_escape($_POST['mobile']);
	$uname=$add->real_escape($_POST['uname']);
	$email=$add->real_escape($_POST['email']);
	$password=$add->real_escape($_POST['password']);

	$cpassword=$add->real_escape($_POST['cpassword']);
	$check_field= $validation->field_check($_POST,array('fname','csrf','uname','email','password','cpassword'));
	$fname_check=$validation->fname_check($fname);
	// $mobile_check=$validation->mobile_check($mobile);
	$uname_check=$validation->uname_check($uname);
	$email_check=$validation->email_check($email);
	$password_check=$validation->password_check($password);
	$cpassword_check=$validation->password_check($cpassword);
	// $cpassword_check=$validation->cpassword_check($cpassword);
		
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
	// elseif(!$mobile_check){
	// 	echo json_encode([
	// 		"status"=>"error",
	// 		"data"=>"Invalid Mobile No.! must be number"
	// 	]);
	// }
	elseif(!$uname_check){	
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Username"
		]);
	}
	
	elseif(!$email_check){
	echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Email"
		]);
	}
	elseif(!$password_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Password"
		]);
	}
	elseif(!$cpassword_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Confirm Password"
		]);
	}else{

		if($csrf!=$_SESSION['csrf']){
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing!"
			]);
		}else{
				if($password==$cpassword){
				$email_availabel=$add->email_availabel($email);
				if($email_availabel){
					echo json_encode([
						"status"=>"error",
						"data"=>"Enter Email Already Exists"
					]);
				}
				else{
					$uname_availabel=$add->uname_availabel($uname);
					if($uname_availabel){
						echo json_encode([
							"status"=>"error",
							"data"=>"Sorry This Username Already Exists! Try Differet"
						]);

					}else{
						$uname="@".$uname;
						$token=sha1($email);
						$addd=$add->register($fname,$uname,$email,$password,$cpassword,$token,$ip);
						if($addd){
							$lastId=sha1($addd);
							$url = 'http://' . $_SERVER['SERVER_NAME'] . '/project2/user/verify.php?dddd='.$lastId.'&token=' .$token;
		 					$html = '<div>Thanks for registering with ViVinum.<br /> Please click below this to complete your registration:<br />'.$url.'</div>';
							require_once 'PHPMailerAutoload.php';
							require_once 'crade.php';
							$mail=new PHPMailer;

							// $mail->SMTPDebug=4;

							$mail->isSMTP();

							$mail->Host="smtp.gmail.com";

							$mail->SMTPAuth=true;

							$mail->Username=EMAIL;

							$mail->Password=PASS;

							$mail->SMTPSecure="tls";

							$mail->Port=587;

							$mail->setFrom(EMAIL,"ViVinum");

							$mail->addAddress($email);

							$mail->addReplyTo(EMAIL);

							$mail->isHTML(true);

							$mail->Subject= "Confirm your email";
							$mail->Body=$html;
								if(!$mail->send()){
									echo json_encode([
										"status"=>"error",
										"data"=>"Sorry Message could not be sent"
									]);
								}else{
									$_SESSION['message']="Congratulation, Your registration done on our site. Please check your email to verify";
									setcookie("m","Congratulation, Your registration done on our site. Please check your email to verify",time()+(86400*365));
									echo json_encode([
										"status"=>"success",
										"url"=>"login"
										]);

								}
						}else{
								echo json_encode([
									"status"=>"error",
									"data"=>"There was an probled data not submmited"
									]);
						}	
					}
				}
				
			}else{
				echo json_encode([
				"status"=>"error",
				"data"=>"Password and Confirm Password not matched"
			]);

			}
		}

		
}

?>