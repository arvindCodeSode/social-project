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
$admin=new user_info($activity);
if(isset($_POST['login'])){
	$csrf=$login->real_escape($_POST['csrf']);
	$email=$login->real_escape($_POST['email']);
	$password=$login->real_escape($_POST['password']);
	$check_field= $validation->field_check($_POST,array('email','csrf','password'));
	if($check_field!=null){
		header("Location:../admin?mess=".$check_field."");
	}else{
		if($csrf!=$_SESSION['csrf']){
			header("Location:../admin?mess=Csrf token missing!");
		}else{
			$login=$admin->admin_login($email,$password);
			if($login){
			header("Location:../all");
			}else{
			header("Location:../admin?mess=Email and Password not matched");
			}
		}
	}
		
}else{
	header("Location:../admin?mess=Please fill the field");
}
?>