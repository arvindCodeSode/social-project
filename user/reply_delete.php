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
	if(!empty($_POST['reply_id']) AND !empty($_POST['comment_id']) AND !empty($_POST['post_id']) AND !empty($_POST['csrfr'])){
		$reply_id=$func->real_escape($_POST['reply_id']);
		$comment_id=$func->real_escape($_POST['comment_id']);
		$post_id=$func->real_escape($_POST['post_id']);
		$csrfr=$func->real_escape($_POST['csrfr']);
		$reply_owner=$func->reply_owner($reply_id,$comment_id,$post_id);
	    if($reply_owner['user_id']==$_SESSION['user_login']['id']){
			$reply_delete=$func->reply_delete($reply_id,$comment_id,$post_id);
			if($reply_delete){
				echo json_encode([
					"status"=>"success",
					"data"=>"You'r successfully deleted the reply!"
				]);
			}
			else{
				echo json_encode([
					"status"=>"error",
					"data"=>"Error! Reply not deleted"
				]);
			}
		}
		else {
		echo json_encode([
			"status"=>"authorized",
			"data"=>"Sorry You are not authorized to delete this reply"
		    ]);
		}

	}
}

?>