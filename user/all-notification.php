<?php
ob_start();
session_start();
session_regenerate_id( true );
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$validation=new validation();
$all=new all_notic($activity);
$func=new func($activity);
if(!isset($_SESSION['user_login']['id'])){
	echo json_encode([
		"status"=>"auth_required",
		"url"=>"login",
	]);
}
else{
	$html="";
	if(isset($_POST['view'])){
		$view=$func->real_escape($_POST['view']);
		$html.=$all->total_post_n($view);
		//ye mene comment like notification ke liye bana tha
		// $html.=$share->total_comment_n($_POST['view']);
		$row=$_SESSION['total_p_n'];
		echo json_encode([
			"status"=>"success",
			"data"=>$html,
			"unseen_notificaton"=>$row
		]);
	}
}

?>