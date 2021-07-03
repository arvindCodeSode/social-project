<?php
ob_start();
session_start();
//session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
	header("Location:login");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$validation=new validation();
$func=new func($activity);
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{
	if(!empty($_POST['post_id']) AND !empty($_POST['csrfm'])){
		$post_id=$func->real_escape($_POST['post_id']);
		$csrfm=$func->real_escape($_POST['csrfm']);
		$post_owner=$func->post_owner($post_id);
	    if($post_owner['user_Id']==$_SESSION['user_login']['id']){
			$post_delete=$func->post_delete($post_id);
			if($post_delete){
				echo json_encode([
					"status"=>"success",
					"data"=>"You'r successfully deleted post!"
				]);
			}
			else{
				echo json_encode([
					"status"=>"error",
					"data"=>"Error! Post not deleted"
				]);
			}
		}
		else {
		echo json_encode([
			"status"=>"authorized",
			"data"=>"Sorry You are not authorized to delete this post"
		    ]);
		}

	}
}

?>