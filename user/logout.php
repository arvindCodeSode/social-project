<?php
ob_start();
session_start();
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$logout=new func($activity);
$logout->logout();
$_SESSION['message']="";
unset($_SESSION['message']);
if(!isset($_SESSION['user_login']['id'])){
	header("Location:login");
}

?>