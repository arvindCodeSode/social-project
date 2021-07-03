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
  <?php require_once 'link.php'; ?>
	<title>ViVinam: Contact</title>
	<style type="text/css">
html,body{margin: 0;padding: 0;font-family: Relaway,Helvetica,Arial; background-color: #f1f1f1;}
textarea{width: 100%;resize: vertical;height: 100px;}
#img-loader{display: none;}	
	</style>
</head>
<body>
<div class="register-container">
	<div class="regis-row">
		<div class="regis-column regis-left">
				<div class="top-line">
				<h1>Contact Us</h1>
				<hr />
				</div>
			<div class="r-cont">
				<div id="reg-message" >
				<img src="image/loader.gif" id="img-loader">	
				</div>

				<form id="contact-form" class="action-form" method="post" enctype="multipart/form-data">
					<!-- <label for="fname">Full Name </label> --><span class="Err" id="fnameErr">  </span>
					<div class="input-container">
						<i class="fas fa-user f-icon"></i><input type="text" name="fname" id="fname" placeholder="Full Name.." class="input-field" />
					</div>
					<!-- <label for="mobile">Mobile</label> --><span class="Err" id="mErr">  </span>
					<div class="input-container">
						<i class="fas fa-phone-alt f-icon"></i><input type="text" name="mobile" id="mobile" placeholder="Mobile No..">
					</div>
				<input type="hidden" id="csrf" name="csrf" value="<?=$blogs->csrf_token(); ?>">
					<!-- <label for="email">Email id</label> --><span class="Err" id="emailErr">  </span>
					<div class="input-container">
						<i class="fas fa-envelope f-icon"></i><input type="text" name="email" id="email" class="input-field" placeholder="Your Email.." />
					</div>
					<div class="input-container">
						<i class="far fa-comment f-icon"></i><input type="text" name="subject" id="subject" class="input-field" placeholder="Subject.." />
					</div>
					<!-- <label for="subject">Subject</label> --><span class="Err" id="descErr"> *(250 words optional) </span>
					<div class="input-container">
					<i class="fas fa-edit f-icon"></i><textarea name="description" id="description" placeholder="Write description here.." class="input-field"></textarea>
					</div>
					<div class="input-submit">
					<input type="submit" name="register" class="reg-submit" id="reg-submit" value="Contact Us"  autocomplete="on" />
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


