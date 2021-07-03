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
$share=new share($activity);
$validation=new validation();
$output="";
if(isset($_POST['post_id']) AND isset($_POST['share_data'])){

	$post_id=$blogs->real_escape($_POST['post_id']);
	$share_data=$blogs->real_escape($_POST['share_data']);
	$data=$share->post_share($post_id,$share_data);
	$totalShare=$blogs->share_count($post_id);
	if($data){
		 $last_id=$blogs->get_last_post_id()+1;
        $last_id=$blogs->real_escape($last_id);
		$blog=$blogs->show_data($last_id);
		echo json_encode([
			"status"=>"success",
			"data"=>$blog,
			"totalShare"=>$totalShare
		]);
	}else{
		echo json_encode([
			"status"=>"erro",
			"data"=>"not found"
		]);
	}
}
?>