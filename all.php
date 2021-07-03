<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
    header("Location:user/login");
}
function __autoload($class){
	require_once "classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);
$all=new user_info($activity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once 'link.php'; ?>
	<title>ViVinam: Admin Dashboard</title>
	<style type="text/css">
	.right-container{
    position: sticky;
    top: 0px;
}
.left-container{
    position: sticky;
    top:0;
}
.table table{
	width: 95%;
	margin: auto;
	text-align: center;
	table-layout: fixed;
	margin-bottom: 20px;
}
.table .report-img{
	width: 50px;
	height: 50px;
}
.table table th{
	padding: 10px;
	font-size: 1.1em;
}
.table table,th,td{
	border: 1px solid;
	border-collapse: collapse;
}
	</style>
</head>
<body>
<!--topnav file-->
<?php 
require_once 'topnav.php'; ?>
 <!-- topnav file end-->
<?php ?>
    <div class="table suggestion-table">
    	<h2>Suggestion</h2>
    	<hr />
    	<?=$all->show_sug();?>	
    </div>
    <div class="table eport-table">
    	<h2>Report</h2>
    	<hr />
    	<?=$all->show_contact();?>
    </div>
    <div class="table contact-table">
    	<h2>Contact</h2>
    	<hr />
    	<?=$all->show_report();?>
    </div>
 <!--footer file-->
  <?php 
 require_once 'footer.php'; ?>
 <!--end footer file-->
 <!--script start-->
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<!--script end-->
</body>
</html>