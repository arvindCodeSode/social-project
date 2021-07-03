<?php
ob_start();
	date_default_timezone_set("Asia/kolkata");
session_start();
if(isset($_SESSION['user_login']['id'])){
	header("Location:home.php");
}
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$func=new func($activity);
$blogs=new blogs($activity);
$validation=new validation();
if(isset($_GET['token']) && isset($_GET['dddd']) && !empty($_GET['dddd'])){
	$token=$func->real_escape($_GET['token']);
	$fetch=$func->fetch($token);
	if($fetch){
		if(isset($_SESSION['message'])){
			$_SESSION['message']="Account updated successfully";
			header("Location:login.php");
			setcookie("m","",time()-1000);
		}else{
			$_SESSION['message']="Account updated successfully";
			header("Location:login.php");
			setcookie("m","",time()-1000);
		}
	}else{
		$_SESSION['message']="Account Not updated! Invalid token";
		header("Location:register.php");
		setcookie("m","",time()-1000);
	}

}

?>