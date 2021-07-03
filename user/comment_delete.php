<?php
ob_start();
session_start();
session_regenerate_id( true );
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
	if(!empty($_POST['comment_id']) AND !empty($_POST['post_id']) AND !empty($_POST['csrfr'])){
		$comment_id=$func->real_escape($_POST['comment_id']);
		$csrfr=$func->real_escape($_POST['csrfr']);
		$post_id=$func->real_escape($_POST['post_id']);
		$comment_owner=$func->comment_owner($comment_id,$post_id);
	    if($comment_owner['user_id']==$_SESSION['user_login']['id']){
			$comment_delete=$func->comment_delete($comment_id,$post_id);
			if($comment_delete){
				echo json_encode([
					"status"=>"success",
					"data"=>"You'r successfully deleted the comment!"
				]);
			}
			else{
				echo json_encode([
					"status"=>"error",
					"data"=>"Error! Comment not deleted"
				]);
			}
		}
		else {
		echo json_encode([
			"status"=>"authorized",
			"data"=>"Sorry You are not authorized to delete this Comment"
		    ]);
		}

	}
}

?>