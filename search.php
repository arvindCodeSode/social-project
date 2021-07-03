<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
    header("Location:user/login.php");
}
function __autoload($class){
	require_once "classes/$class.php";
}
$activity=new text_activity();
$search=new blogs($activity);
$validation=new validation();
if(isset($_POST['search'])){
	if(!empty($_POST['search']) AND $_POST['search']!==""){
		$str=$_POST['search'];
		$str=$search->real_escape($str);
		$search_result=$search->search($str);
		if($search_result){
			// print_r($search_result);
			echo json_encode([
			"success"=>"success",
			"data"=>$search_result
			]);
		}else{
			echo json_encode([
				"error"=>"error",
				"data"=>"<ul><li><a>No Result Found</a></li></ul>"
			]);
		}

	}
}
?>