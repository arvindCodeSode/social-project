<?php
ob_start();
session_start();
session_regenerate_id( true );
if(isset($_SESSION['user_login']['id'])){
	header("Location:../home");
}
function __autoload($class){
	require_once "../classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ViVinam: Login</title>
	<meta charset="utf-8" />
	<meta name="description" content="Vivinam" />
	<meta name="keywords" content="Social Site, Vivinam, Vichar, Vicharam" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="../public/css/style.css" />
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<style type="text/css">
		html,body{margin: 0;padding: 0;font-family: Relaway,Helvetica,Arial; background-color: #ffffff;}
		.regis-column{
			width: 100%;
			height: 550px;
			margin: auto;
		}
		@media screen and (min-width: 500px){
			.regis-column{
				width: 70%;
			}
		}
		@media screen and (min-width: 1000px){
			.regis-column{
				width: 40%;
			}
		}
		.r-cont{text-align: center;height: 550px;background-color: #ffffff;}
		.loader{display: none;}
		#forgot-form-token{display: none;}

	</style>
</head>
<body>
<div class="register-container">
	<div class="regis-row">
		<div class="regis-column">
			<div class="r-cont">
			<h3>Reset Your Password</h3>
			<div id="message">

			</div>
				<form  class="action-form" id="forgot-form" method="post"  autocomplete="on">
					<!-- <label for="email">Email id</label> --><span class="Err" id="emailErr">  </span>
					<div class="input-container">
					<i class="fas fa-user f-icon"></i>	<input class="input-field" type="text" name="for-email"  id="for-email" placeholder="Enter Email"  autocomplete="on" />
					</div>
					<input type="hidden" name="csrf" value="<?=$blogs->csrf_token(); ?>" />
					<div class="input-submit">
					<input type="submit" name="login" class="reg-submit" id="reg-submit" value="Next"  autocomplete="on" />
					</div>
				</form>
					<div class="loader" id="loader">
						<img src="../image/loader.gif" />
					</div>
				<form  class="action-form" id="forgot-form-token" method="post"  autocomplete="on">
					<span class="Err" id="tokenErr">  </span>
					<div class="input-container">
					<input class="input-field" type="text" name="f-token"  id="f-token" placeholder="Please Enter OTP"   autocomplete="off" />
					</div>
					<input type="hidden" name="csrfs" value="<?=$blogs->csrf_token_s(); ?>" />
					<!-- <label for="cpassword">Confirm Password</label> --><span class="Err" id="passwordErr">  </span>
					<div class="input-container">
					<i  class="fas fa-lock f-icon"></i><input type="password" autocomplete="off" name="password" id="password" placeholder="Password.." />
					</div>
						<!-- <label for="cpassword">Confirm Password</label> --><span class="Err" id="cpasswordErr">  </span>
					<div class="input-container">
						<i  class="fas fa-lock f-icon"></i><input type="password" autocomplete="off" name="cpassword" id="cpassword" placeholder="Confirm Password.." />
					</div>
					<div class="input-submit">
					<input type="submit" name="login" class="reg-submit" id="reg-submi" value="Reset"  autocomplete="on" />
					</div>
				</form>
					<br /><br />
				</div>
			</div>
		</div>
	</div>
<footer>
    <div class="footer-top">
        <a href="#" title="follow on facebook"><i class='fab fa-facebook'></i></a>
        <a href="#" title="follow on instagram"><i class='fab fa-instagram'></i></a>
        <a href="#" title="follow on twitter"><i class='fab fa-twitter'></i></a>
        <a href="#" title="follow on youtube"><i class='fab fa-youtube'></i></a>
        <a href="#" title="follow on Google+"><i class='fab fa-google-plus'></i></a>
        <a href="#" title="follow on LinkedIn"><i class='fab fa-linkedin'></i></a>
        <a href="#" title="follow on blogger"><i class='fab fa-blogger'></i></a>
    </div>
    <div class="footer-middle">
        <a href="../about" title="About Us">About Us</a>
        <a href="../contact" title="Contact Us">Contact Us</a>
        <a href="../cookie" title="Cookie">Cookie</a>
        <a href="../term" title="Term and Policies">Term and Policies</a>
    </div>
    <div class="footer-middle suggestion">
        <a href="../suggestion" title="Suggestion">Suggestion</a>
        <a href="../report" title=" Report Problem Here">Report Problem here</a>
    </div>
    <div class="footer-bottom">
        <p>&copy;Copyright 2020-2021 Ek Nazriya Digital Media PVT. LTD.<br />
        &reg; Ek Nazriya</p>
    </div>
</footer>
</div>
<script type="text/javascript" src="../public/js/compress.js"></script>
<script type="text/javascript" src="../public/js/script.js"></script>
<script type="text/javascript">
</script>
<!--script end-->
</body>
</html>
