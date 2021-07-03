<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$message="";
require_once 'ip.php';
$activity=new text_activity();
$add=new func($activity);
$validation=new validation();
$contacts=new user_info($activity);
	$ip=$_SESSION['ip'];
	$csrf=$add->real_escape($_POST['csrf']);
	$fname=$add->real_escape($_POST['fname']);
	$mobile=$add->real_escape($_POST['mobile']);
	$subject=$add->real_escape($_POST['subject']);
	$description=$add->real_escape($_POST['description']);
	$email=$add->real_escape($_POST['email']);
	$check_field= $validation->field_check($_POST,array('fname','csrf','subject','email','mobile','description'));
	$fname_check=$validation->fname_check($fname);
	$mobile_check=$validation->mobile_check($mobile);
	$subject_check=$validation->user_bio($subject);
	$description_check=$validation->user_bio($description);
	$email_check=$validation->email_check($email);
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
	elseif(!$mobile_check){
		echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Mobile No.! must be number"
		]);
	}
	elseif(!$subject_check){	
		echo json_encode([
			"status"=>"error",
			"data"=>"Maximum 250 character"
		]);
	}
	elseif(!$description_check){	
		echo json_encode([
			"status"=>"error",
			"data"=>"Maximum 250 character"
		]);
	}	
	elseif(!$email_check){
	echo json_encode([
			"status"=>"error",
			"data"=>"Invalid Email"
		]);
	}else{

		if($csrf!=$_SESSION['csrf']){
			echo json_encode([
				"status"=>"error",
				"data"=>"csrf token missing!"
			]);
		}
			else{
				$contact=$contacts->contact($fname,$mobile,$email,$subject,$description,$ip);
				if($contact){
				$html = '<div>Hi I am '.$fname.'.<br /> For regarding &nbsp;'.$subject.':<br /><q>'.$description.'</q><br />'.$email.'</div>';
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

				$mail->addAddress('arvindparkash1999@gmail.com');

				$mail->addReplyTo(EMAIL);

				$mail->isHTML(true);

				$mail->Subject= $subject;
				$mail->Body=$html;
					if(!$mail->send()){
						echo json_encode([
							"status"=>"error",
							"data"=>"Sorry Message could not be sent"
						]);
					}else{
						echo json_encode([
							"status"=>"success",
							"data"=>"Form successfully Submited"
							]);
					}
				}
			}
	}
?>