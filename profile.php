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
$profile=new func($activity);
$blogs=new blogs($activity);
$share=new share($activity);
$validation=new validation();
if(isset($_GET['uname'])){
		$uname=$profile->real_escape($_GET['uname']);		
}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ViVinam: Profile</title>
  <?php require_once 'link.php'; ?>
  <style type="text/css">
		.profile-left{position: sticky;top:0px;min-height: 800px;}
	 .profile-right{position: sticky;top:0px;min-height: 800px;}
	</style>
</head>
<body>
<!--This is nav-bar container responsive and this open via on click at bar icon-->
<!--Responsive sidenav container begin-->
<div class='sidenav' id='sidenav'>
  <a href="javascript:void(0)" class="closebtn" id="close-sidenav">&times;</a>
  <a class="open-pass-c" id="open-pass-c">Change Password</a>
  <a id="delete_acccount" class="delete_acccount">Delete Account</a>
  <a id="delete_acccount" class="open-change-u-c">Change Username</a>
  <div class='about-us'>
    <a href="about">About Us</a>
    <a href="contact">Contact Us</a>
    <a href="term">Term &amp; Policy</a>
    <a href="cookie">Cookie</a>
    <a href="user/logout">Logout</a>
  </div>
  <div class="sidenav-social-icon">
    <div class="icon">
      <a href="#" title="follow on facebook"><i class="fab fa-facebook"></i></a>
      <a href="#" title="follow on instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" title="follow on twitter"><i class="fab fa-twitter"></i></a>
      <a href="#" title="follow on youtube"><i class="fab fa-youtube"></i></a>
      <a href="#" title="follow on google+"><i class="fab fa-google-plus"></i></a>
      <a href="#" title="follow on blogger"><i class="fab fa-blogger"></i></a>
      <a href="#" title="follow on linkedin"><i class="fab fa-linkedin"></i></a>
    </div>
  </div>
</div>
<div class="pass-cont" id="delete_acccount-c">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="delete-user">
      <div class="pass-img">
        <span class="delete-close pass-close" id="delete-close" title="Close From!">&times;</span>
      </div>
      <h3>Delete your account</h3>
        <div class="c-pass-message" id="c-delete-message">
        </div>
        <div class="pass-blog-c">
          <label for="email_d"><b>Eamil</b></label><span class="Err" id="Email_dErr"> * </span>
          <input type="text" name="email_d" id="email_d" placeholder="Enter Eamil.." />
          <input type="hidden" name="csrfj" value="<?=$share->csrf_tokenj(); ?>" />
          <label for="uname_d"><b>Useraname</b></label><span class="Err" id="Uname_dErr"> * </span>
          <input type="text" name="uname_d" id="uname_d"  placeholder="Enter Useraname" />
          <label for="pass_d"><b>Password</b></label><span class="Err" id="Pass_dErr"> * </span>
          <input  type="password" name="pass_d" id="pass_d"  placeholder="Enter Password" />
          <label for="captcha"><b>Enter Below Captcha</b></label><span class="Err" id="Captcha_dErr"> * </span>  
          <input type="text" name="captcha" id="captcha"  placeholder="Enter below captcha" />
          <img src="captcha.php" alt="captcha" />
        </div>
      <div class="pass-blog-c"><button type="submit" name="submit">Delete</button></div>
    </form>
  </div>
</div>
<div class="open-modal-img" id="open-modal-img">
  <span class="close-image" id="close-image">&times;</span>
  <img class="user-image" id="user-img01" />
</div>
<!--topnav file-->
<?php 
// require_once 'topnav.php'; ?>
<!-- topnav file end-->
<div class="profile-row">
<!--Left column  profile-->
  <div class="profile-left">
<?php require_once 'Left.php'; ?>
  </div>
<!--Left column end-->
<!--middle column start-->
<div class="profile-middle">
<!--this is top profile-->
<?php
	$profile->profile($uname,$user_bio=null);			
?>
<!--top profile end-->
<!--follow edit start-->
	<div class="user-action">
  	<?php if($_SESSION['user_login']['uname']==$uname): ?>
  		<div class="top-a">
  			<a href="#">Activity</a><a href="#" id="open-edit">Edit</a><a href="#" class="setting-open"><i class="fas fa-cog"></i> Setting</a>
  		</div>
  	<?php endif; ?>
    <div class="top-follow">
  		<span>Follower</span><span>Friend</span><span>Follow</span>
  		<span>300</span><span>25</span><span>10</span>
  	</div>
  	<div class="img-row">
  		<div class="img-column">
  		  <div class="img-column-cont">
          No Friends
        </div>
  			<a href="#">Friends</a>
  		</div>
      <?=$profile->show_pic($uname); ?>
  	</div>
  	<hr />
	</div>
	<!--follow edit end-->
	<!--middle blog contianer  c start-->
  <!--top user bio container-->
	<?php if($_SESSION['user_login']['uname']==$uname): ?>
	<div class="m-user-bio user-post">
	<!--this is image with date and name-->
  <?= $share->m_pro_image(); ?>
  <!--uesr name and date follow -->
  	<div class="m-user m-user-name post-data">
  		<form id="post-p-mind" action="">
  			<textarea name="post-text" id="post-text" placeholder="What's thinking"></textarea>
  				<div class="image-upload">
  					<label for="file-input">
  						<div class="custom-image"><i class="fas fa-image"></i></div>
  					</label>
  						<input id="file-input" type="file" name="file-input"/>
              <input type="hidden" name="csrfi" id="csrfi" value="<?=$share->csrf_tokeni();  ?>" />
  						<button type="submit" name="sub-post" id="sub-posta" class="sub-posta">Post</button>
  				</div>
  		</form>
  	</div>
  <!--user nmae date end-->
	</div>
	<?php endif;?>
	<div class="middle-blog-con m-slides" id="middle-blog-con">
  <?php echo $blogs->show_profile_data($uname); ?>
  </div>
  <!--middle blog contianer c end-->
  <!--this is edit form--> 
  <?=$share->edit_form(); ?> 
<!--edit form end-->
</div>
	<!--middle column end-->
	<!--right column start -->
	<div class="side profile-right">
    <?php require_once 'right.php'; ?>
  </div>
	<!--right column end-->
</div>
<!--popup boxes-->
<div class="full-share-box" id="o-p-image">
  <div class="share-box">
    <span id="cancel-pro" class="cancel" title="Hide box!">&times;</span>
    <h3>Upload Your Image</h3>
    <hr />
    <div class="m-user m-user-name post-data">
      <form id="img-upload-pro" action="">
        <div class="image-upload">
          <label for="i-u-p">
            <div class="custom-image" title="Choose Image"><span>Choose Image</span> <i class="fas fa-image"></i></div>
          </label>
          <input id="i-u-p" type="file" name="i-u-p" />
          <input type="hidden" name="csrfa" value="<?=$blogs->csrf_token_a();?>" />
          <input type="hidden" name="i-u-pt" value="i-u-pt" />
        </div>
        <hr />
        <div class="upload-button">
          <button type="submit" name="sub-postd" id="img-pro-u" class="sub-posta">Upload</button>
        </div>
      </form>
    </div>
  </div>  
</div>
<div class="full-share-box" id="open-i-img">
  <div class="share-box">
    <span id="cancel-image" class="cancel">&times;</span>
    <h3>Upload Your Image</h3>
    <hr />
    <div class="m-user m-user-name post-data">
      <form id="img-upload-image" action="">
        <div class="image-upload">
          <label for="i-u-i">
          <div class="custom-image" title="Choose Image"><span>Choose Image</span> <i class="fas fa-image"></i></div>
          </label>
          <input id="i-u-i" type="file" name="i-u-i" />
          <input type="hidden" name="csrfb" value="<?=$blogs->csrf_token_b();?>" />
          <input type="hidden" name="i-u-it" value="i-u-it" />
        </div>
        <hr />
        <div class="upload-button">
          <input type="submit" name="sub-postc" id="img-img" class="sub-posta" value="Upload" /> 
        </div>
      </form>
    </div>
  </div>  
</div>
<!--popub boxes -->
<div class="full-edit-share-box" id="a-i-u" >
  <div class="f-share-box">
    <h3 id="upload-message"></h3>
    <div class="f-s-bio">
     <div class="m-user m-user-bio post-data">
        <?php if(isset($_SESSION['user_login']['id'])):
        echo $share->user_bio_data();    
        endif; ?>     
        <form id="post-share1">
          <textarea name="post-upload-text" id="post-upload-text" placeholder="Write about this!"></textarea>
          <input type="hidden" name="image-u-f" id="image-u-f" value="" />
          <input type="hidden" name="image-name" id="image-name" value="" />
          <input type="hidden" id="csrfe" name="csrfe" value="<?=$blogs->csrf_token_e();?>" />
        </form>
      </div>
      <hr />
    </div>
    <div class="progress-cont">
      <div class="progress-bar" id="progress-bar">
        <span id="couting"></span>
      </div>
    </div>
    <div class="upload-i-cont">
      <img src="" id="upload-image" />
    </div> 
 
    <div class="share-buttons-div" id="upload-buttons">
    <hr />
    <button type="button" id="post-upload"   class="share-button share-post-b">Post</button>
    <button class="share-cancel share-button" id="cancel-upload">Cancel</button>
    </div>
  </div>
</div>
<div class="full-share-box" id="main-full-share">
  <div class="share-box" id="share-box">
    <div class="m-user m-user-bio post-data">
      <?php if(isset($_SESSION['user_login']['id'])):
      echo $share->user_bio_data();    
      endif; ?>     
      <form id="post-share">
        <textarea name="post-share-text" id="post-share-text" placeholder="Write about this"></textarea>
        <input type="hidden" id="csrfh" name="csrfh" value="<?=$share->csrf_tokenh();?>" />
      </form>
    </div> 
    <hr />
  </div>  
</div>
 <div class="pass-cont" id="pass-cont-c">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="Change-Pass" autocomplete="on">
      <div class="pass-img">
        <span class="pass-close pass-close" id="pass-close" title="Close From!">&times;</span>
      </div>
      <h3>Change your Passowrd</h3>
      <div class="c-pass-message" id="c-pass-message"></div>
        <div class="pass-blog-c">
          <label for="oldpsw"><b>Old Password</b></label><span class="Err" id="CopswErr"> * </span>
          <input autocomplete="on" type="password" name="oldpsw" id="oldpsw" class="input-field" placeholder="Enter Old Password" />
          <input type="hidden" name="csrf" value="<?=$blogs->csrf_token_c(); ?>" />
          <label for="newpsw"><b>New Password</b></label><span class="Err" id="CnpswErr"> * </span>
          <input  autocomplete="on" type="password" name="newpsw" id="newpsw" class="input-field" placeholder="Enter New Password" />
          <label for="conpsw"><b>Confirm Password</b></label><span class="Err" id="CcpswErr"> * </span>
          <input  autocomplete="on" type="password" name="conpsw" id="conpsw" class="input-field" placeholder="Enter Confirm  Password" />
        </div>
        <div class="pass-blog-c">
          <button type="submit" name="submit">Change</button>
        </div>
    </form>
  </div>
</div>
<div class="pass-cont" id="change-user-cont">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="Change-User">
      <div class="pass-img">
        <span class="pass-close pass-close" id="user-close" title="Close From!">&times;</span>
      </div>
      <h3>Change your Passowrd</h3>
      <div class="c-pass-message" id="c-user-message"></div>
      <div class="pass-blog-c">
        <label for="olduser"><b>Old Username</b></label><span class="Err" id="CuserErr"> * </span>
        <input type="text" name="olduser" id="olduser" class="input-field" placeholder="Enter Old Useraname" />
        <input type="hidden" name="csrfs" value="<?=$blogs->csrf_token_s(); ?>" />
        <label for="newuser"><b>New Username</b></label><span class="Err" id="CnewErr"> * </span>
        <input type="text" name="newuser" id="newuser" class="input-field" placeholder="Enter New Username" />
        <label for="conuser"><b>Confirm Username</b></label><span class="Err" id="CcuserErr"> * </span>
        <input type="text" name="conuser" id="conuser" class="input-field" placeholder="Enter Confirm  Username" />
      </div>
      <div class="pass-blog-c">
        <button type="submit" name="submit">Change</button>
      </div>
    </form>
  </div>
</div>
<!--footer file-->
<?php 
require_once 'footer.php'; ?>
<!--end footer file-->
 <!--script start-->
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<script type="text/javascript" src="script.js"></script>
<!--script end-->
</body>
</html>