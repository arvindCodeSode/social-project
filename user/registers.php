<?php
ob_start();
date_default_timezone_set("Asia/kolkata");
session_start();
session_regenerate_id( true );
if(isset($_SESSION['user_login']['id'])){
	header("Location:home.php");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
require_once 'ip.php';
$ip=$_SESSION['ip'];
$activity=new text_activity();
$add=new func($activity);
$blogs=new blogs($activity);
$validation=new validation();
if(isset($_POST['register'])){
	$fname=$add->real_escape($_POST['fname']);
	$csrf=$add->real_escape($_POST['csrf']);
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

		header("Location:register?mess=".$check_field."");
	}
	elseif(!$fname_check){
		header("Location:register?mess=invaid fname");

	}
	// elseif(!$mobile_check){
	// 	$message.="invalid mobile Number<br />";
	// 	header("Location:register.php?mess=invalid mobile Number");
	// }
	elseif(!$uname_check){
		header("Location:register?mess=invalid Username");
	}
	
	elseif(!$email_check){
		header("Location:register?mess=invlid email");
	}
	elseif(!$password_check){
		header("Location:register?mess=invalid password");
	}
	elseif(!$cpassword_check){
		header("Location:register?mess=invalid cpassword");
	}else{

		if($csrf!=$_SESSION['csrf']){
			header("Location:register?mess=csrf token missing!");
		}
		else{
			if($password==$cpassword){
			$email_availabel=$add->email_availabel($email);
			if($email_availabel){
				header("Location:register?mess=Enter email already exists");
			}
			else{
				$uname_availabel=$add->uname_availabel($uname);
				if($uname_availabel){
					header("Location:register?mess=Sorry this Username name already exists! try differet");
					

				}else{
					$uname="@".$uname;
					$token=sha1($email);
					$addd=$add->register($fname,$uname,$email,$password,$cpassword,$token,$ip);
					if($addd){
						$lastId=sha1($addd);
						$url = 'http://' . $_SERVER['SERVER_NAME'] . '/project2/user/verify.php?dddd='.$lastId.'token=' .$token;
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

						$mail->setForm(EMAIL,"ViVinum");

						$mail->addAddress($email);

						$mail->addReplyTo(EMAIL);

						$mail->isHTML(true);

						$mail->Subject= "Confirm your email";
						$mail->Body=$html;
							if(!$mail->send()){
								header("Location:register?mess=Message could not be sent");
							}else{
								$_SESSION['message']="Congratulation, Your registration done on our site. Please check your email to verify";
								setcookie("m","Congratulation, Your registration done on our site. Please check your email to verify",time()+(86400*365));
								header("Location:login");
							}
						}else{
					header("Location:register?mess=There was problem data does't  submmited");

					}	
				}
			}
			
		}else{
		header("Location:register?mess=Password and Confirm Password not matched");
		}
		
	}
		}
}
?>