<?php 
ob_start();
date_default_timezone_set("Asia/Kolkata");
session_start();
session_regenerate_id( true );
if(isset($_SESSION['user_login']['id'])){
	header("Location:../home");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$func=new func($activity);
$validation=new validation();
require_once 'PHPMailerAutoload.php';
require_once 'crade.php';
if(isset($_POST['for-email']) && !empty($_POST['for-email']) && isset($_POST['csrf']) && !empty($_POST['csrf']) && $_POST['action']=="fetch_email"){
	$csrf=$func->real_escape($_POST['csrf']);
	if($_SESSION['csrf']==$csrf){
		$email=$func->real_escape($_POST['for-email']);	
		$email_check=$validation->email_check($email);
		$field_check=$validation->field_check($_POST,array("for-email"));
		if(!empty($field_check)){
			echo json_encode(["status"=>"error","data"=>$field_check]);
		}elseif(!$email_check){
			echo json_encode(["status"=>"error","data"=>"Invalid email"]);
		}else{
			$fetch=$func->fetch_email($email);
			if($fetch->num_rows > 0 OR $fetch->num_rows==1){
				$result=$fetch->fetch_assoc();
				$_SESSION['user']=[
					"id"=>$result['user_id'],
					"email"=>$result['email'],
					"name"=>$result['fname']
				];
			$_SESSION['f_token']=mt_rand(10000,99999);
			$_SESSION['token-time']=date("d-m-Y H:i:s",(time()+60*60*2));
	 		$html = "<div>You have requested a password reset for your user account at ViVinum. Please Enter this otp in site to reset Own password.: <br />".$_SESSION['f_token']."<br /><br /><strong>Please note this otp is valid for 2 hours.</strong></div>";
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

				$mail->Subject= "Reset Your Password";
				$mail->Body=$html;
					if(!$mail->send()){
					echo json_encode(["status"=>"error","data"=>"Message Could not be sent!"]);		
					}else{
					echo json_encode(["status"=>"success","data"=>"Please Check Your email to reset Your Password! <br />Please Enter OTP"]);
				}


			}else{

				echo json_encode([
						"status"=>"error",
						"data"=>"Sorry Email Not found  in our server! Please try valid again!"
					]);
			}
		}
	}else{
		echo json_encode(["status"=>"error","data"=>"csrf token missing!"]);
	}
}
elseif($_POST['action']=="reset"  && isset($_POST['csrfs']) && isset($_POST['f-token']) && isset($_POST['password']) && !empty($_POST['password']) && !empty($_POST['cpassword']) && !empty($_POST['f-token'])){
	$csrfs=$func->real_escape($_POST['csrfs']);
	if($csrfs==$_SESSION['csrfs']){
		$password=$func->real_escape($_POST['password']);
		$cpassword=$func->real_escape($_POST['cpassword']);
		$f_token=$func->real_escape($_POST['f-token']);
		$currTime=date("d-m-Y H:i:s",time());
		if($f_token==$_SESSION['f_token']){
			if($_SESSION['token-time']>=$currTime){
			$password_check=$validation->password_check($password);
			$cpassword_check=$validation->password_check($cpassword);
			$field=$validation->field_check($_POST,array("password","cpassword","f-token","csrfs"));

			if(!empty($field)){
			echo json_encode(["status"=>"error","data"=>$field]);
			}elseif(!$password_check){
				echo json_encode(["status"=>"error","data"=>"invalid password"]);
			}elseif(!$cpassword_check){
				echo json_encode(["status"=>"error","data"=>"invalid Confirm password"]);
			}
			else{
				if($password==$cpassword){
						$resets=$func->reset_password($password,$_SESSION['user']['id'],$_SESSION['user']['email']);
						if($resets){
				 		$html = "<div> <strong>Hi ".$_SESSION['user']['name']."</strong>. <br /> You have Successfully changed your password.<br /> For any query Please Contact Our Team.<br /><a href='http://localhost/project2/contact'>Click here</a><br /><br /><br /> Thankyou  </div>";
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

							$mail->addAddress($_SESSION['user']['email']);

							$mail->addReplyTo(EMAIL);

							$mail->isHTML(true);

							$mail->Subject= "Successfully Reset Password";
							$mail->Body=$html;
								if(!$mail->send()){
								echo json_encode(["status"=>"error","data"=>"Message Could not be sent!"]);		
								}else{
									echo json_encode(["status"=>"success"]);
								}

						}else{
							echo json_encode(["status"=>"error","data"=>"There was a problem password not reset!"]);		
						}
					}else{
						echo json_encode(["status"=>"cpswErr","data"=>"Password and Confirm Password not matched!"]);		

					}			
				}
			}else{
				echo json_encode(["status"=>"error","data"=>"Sorry Time expires Please try agian!"]);		
			}
		}else{
			echo json_encode(["status"=>"tknErr","data"=>"Invalid OTP"]);
		}
	}else{
		echo json_encode(["status"=>"error","data"=>"csrf token missing!"]);		
	}
}else{
	echo json_encode(["status"=>"error","data"=>"please enter all  input!"]);

}
?>


































