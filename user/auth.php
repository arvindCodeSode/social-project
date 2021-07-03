<?php
ob_start();
session_start();
session_regenerate_id( true );
if(isset($_SESSION['user_login']['id'])){
	header("Location:../home");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$login=new func($activity);
$validation=new validation();
if(isset($_POST['login'])){
	$csrf=$login->real_escape($_POST['csrf']);
	$email=$login->real_escape($_POST['email']);
	$password=$login->real_escape($_POST['password']);
	$check_field= $validation->field_check($_POST,array('email','csrf','password'));
	if($check_field!=null){
		header("Location:login?mess=".$check_field."");
	}else{
		if($csrf!=$_SESSION['csrf']){
			header("Location:login?mess=Csrf token missing!");
		}else{
			$login=$login->login($email,$password);
			if($login){
				$_SESSION['user_login']=[
					'id'=>$login['user_id'],
					'profile_image'=>$login['profile_image'],
					'image'=>$login['image'],
					'name'=>ucwords($login['fname']),
					'email'=>$login['email'],
					'uname'=>$login['uname']
				];
				if(!empty($_POST['remember'])){
					$cemal=convert_uuencode($email);
					setcookie("a",$cemal,time()+86400*365,"/");
					
				}else{
					if(isset($_COOKIE['a'])){
						setcookie("a","",time()-10000,"/");
					}
				}
				if(isset($_SESSION['message']) AND !empty($_SESSION['message'])){
					$html = '<div>Hi  '.$login['fname'].' Thankyou for joining us.<br />Your warm welcome in our ViVinum world <br /><br /> For any query Contact us at <br /> <a href="http://localhost/project2/contact">Contact</a> </div>';
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

				$mail->addAddress($login['email']);

				$mail->addReplyTo(EMAIL);

				$mail->isHTML(true);

				$mail->Subject= "Successfully Registerd";
				$mail->Body=$html;
					if(!$mail->send()){
						echo json_encode([
							"status"=>"error",
							"data"=>"Sorry Message could not be sent"
						]);
					}else{
						echo json_encode([
							"status"=>"success",
							"url"=>"login"
							]);
					}
					unset($_SESSION['message']);
				}
			header("Location:../home");
			}else{
			header("Location:login?mess=Email and Password not matched");
			}
					
		}
	}
}
else{
	header("Location:../login?mess=Please fill the field");
}
?>