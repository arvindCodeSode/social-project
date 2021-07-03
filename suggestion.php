<?php
ob_start();
session_start();
function __autoload($class){
	require_once "classes/$class.php";
}
require_once 'user/ip.php';
$activity=new text_activity();
$blogs=new blogs($activity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Vivinam: Suggestion</title>
  <?php require_once 'link.php'; ?>
	<style type="text/css">
		html,body{margin: 0;padding: 0;font-family: Relaway,Helvetica,Arial; background-color: #f1f1f1;}
		textarea{width: 100%;resize: vertical;height: 100px;}
	</style>
</head>
<body>
<div class="register-container">
	<div class="regis-row">
		<div class="regis-column regis-left">
			<div class="top-line">
				<p id="demo"></p>
				<h1>Suggestion Us</h1>
				<hr />
			</div>
		<div class="r-cont">
			<div id="reg-message">
			</div>
			<form id="suggestion-form" class="action-form" method="post" enctype="multipart/form-data">
				<!-- <label for="fname">Full Name </label> --><span class="Err" id="fnameErr">  </span>
				<div class="input-container">
				<i class="fas fa-user f-icon"></i><input class="input-field" type="text" name="fname" id="fname" placeholder="Full Name.." />
				</div>
				<input type="hidden" id="csrf" name="csrf" value="<?=$blogs->csrf_token(); ?>">
				<span class="Err" id="imgErr"> * Required (Screenshot)  </span>
				<div class="input-container screenshot">
				<label for="images">
					<i class="fas fa-image f-icon"></i>
				 </label>
				<input type="file" class="input-field hideimages" name="images" id="images" multiple="multiple" />
				</div>
<!-- 				<label for="subject">Suggestion</label> --><span class="Err" id="SubErr"> * 250 words </span>
				<div class="input-container">
				<i class="fas fa-edit f-icon"></i><textarea name="subject" id="subject" rows="2" placeholder="Write here.." class="input-field"></textarea>
				</div>
				<div class="input-submit">
				<input type="submit" name="register" class="reg-submit" id="reg-submit" value="Suggestion"  autocomplete="on" />
				</div>
			</form>
		</div>
		</div>
		<div class="regis-column regis-right">
  <?php require_once 'r-left.php'; ?>	
		</div>
	</div>
<?php
require_once 'footer.php';
?>
</div>
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<!--script end-->
</body>
</html>


