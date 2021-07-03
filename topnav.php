<!--header start-->
<!-- <header> -->
	<!--top nav social icon-->
	<!-- <nav class="top-social-icon"><span>Follow on us:</span>
		<a href="#"><i class="fa fa-facebook">fa</i></a>
		<a href="#"><i class="fa fa-instagra">In</i></a>
		<a href="#"><i class="fa fa-twitter">Tw</i></a>
		<a href="#"><i class="fa fa-youtub">Yo</i></a>
		<a href="#"><i class="fa fa-goggle">G+</i></a>
	</nav>
</header> -->

	<!--end  social icon-->
	<!--start brand name-->
	<!-- <div class="brand-container">
		<a class="brand-name">Nazriya</a>
	</div> -->
	<!--start brand name-->

	<!--start top nav-->
<div class="top-nav">
	<ul class="top-menu">
	   <li><a>VV</a></li>
    <li><a>ViVinam</a></li>
    <li><a>Message</a></li>
    <div class="top-name">
      <li class="top-nav-name"><a href="profile?uname=<?php echo htmlspecialchars($_SESSION['user_login']['uname']);?>"><?=$_SESSION['user_login']['name']?></a></li>
      <li class="top-nav-image"><a href="profile?uname=<?php echo htmlspecialchars($_SESSION['user_login']['uname']);?>" ><?=$share->m_pro_image();?></a></li>
    </div>
	</ul>
</div>
	<!--end top nav-->	
  <!--This is nav-bar container responsive and this open via on click at bar icon-->
        <!--Responsive sidenav container begin-->
<div class='sidenav' id='sidenav'>
  <a href="javascript:void(0)" class="closebtn" id="close-sidenav">&times;</a>
  <a href="profile?uname=<?php echo htmlspecialchars($_SESSION['user_login']['uname']);?>"><i class="fas fa-user"></i> <span> Profile</span></a>
  <a class="open-pass-c" id="open-pass-c">Change Password</a>
  <a href="profile?uname=<?php echo htmlspecialchars($_SESSION['user_login']['uname']);?>">Edit Profile</a>
  <a id="delete_acccount" class="delete_acccount">Delete Account</a>
  <a id="chagge-user" class="open-change-u-c">Change Username</a>
    <div class='about-us'>
      <a href="about">About Us</a>
      <a href="contact">Contact Us</a>
      <a href="term">Term &amp; Policy</a>
      <a href="cookie">Cookie</a>
      <a href="admin.php">Adminstration</a>
      <a href="user/logout.php">Logout</a>
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
<div class="pass-cont" id="pass-cont-c">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="Change-Pass" autocomplete="off">
      <div class="pass-img">
        <span class="pass-close pass-close" id="pass-close" title="Close From">&times;</span>
      </div>
      <h3>Change your Passowrd</h3>
      <div class="c-pass-message" id="c-pass-message"></div>
      <div class="pass-blog-c">
        <label for="oldpsw"><b>Old Password</b></label><span class="Err" id="CopswErr"> * </span>
        <input type="password" name="oldpsw" id="oldpsw"  placeholder="Enter Old Password" autocomplete="off" />
        <input type="hidden" name="csrf" value="<?=$blogs->csrf_token_c(); ?>" />
        <label for="newpsw"><b>New Password</b></label><span class="Err" id="CnpswErr"> * </span>
        <input type="password" name="newpsw" id="newpsw"  placeholder="Enter New Password" autocomplete="off" />
        <label for="conpsw"><b>Confirm Password</b></label><span class="Err" id="CcpswErr"> * </span>
        <input type="password" name="conpsw" id="conpsw"  placeholder="Enter Confirm  Password" autocomplete="off" />
      </div>
      <div class="pass-blog-c">
        <button type="submit" name="submit">Change</button>
      </div>
    </form>
  </div>
</div>
<div class="pass-cont" id="change-user-cont">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="Change-User"  autocomplete="off">
      <div class="pass-img">
        <span class="pass-close pass-close" id="user-close" title="Close From">&times;</span>
      </div>
      <h3>Change your Passowrd</h3>
      <div class="c-pass-message" id="c-user-message"></div>
      <div class="pass-blog-c">
        <label for="olduser"><b>Old Username</b></label><span class="Err" id="CuserErr"> * </span>
        <input type="text" name="olduser" id="olduser"  placeholder="Enter Old Useraname" autocomplete="off" />
        <input type="hidden" name="csrfs" value="<?=$blogs->csrf_token_s(); ?>" />
        <label for="newuser"><b>New Username</b></label><span class="Err" id="CnewErr"> * </span>
        <input type="text" name="newuser" id="newuser"  placeholder="Enter New Username" autocomplete="off" />
        <label for="conuser"><b>Confirm Username</b></label><span class="Err" id="CcuserErr"> * </span>
        <input type="text" name="conuser" id="conuser"  placeholder="Enter Confirm  Username" autocomplete="off" />
      </div>
      <div class="pass-blog-c">
        <button type="submit" name="submit">Change</button>
      </div>
    </form>
  </div>
 </div>
<div class="pass-cont" id="delete_acccount-c">
  <div class="pass-c">
    <form class="pass-modal pass-animate" id="delete-user" autocomplete="off">
      <div class="pass-img">
        <span class="delete-close pass-close" id="delete-close" title="Close From">&times;</span>
      </div>
      <h3>Delete your account</h3>
      <div class="c-pass-message" id="c-delete-message"></div>
        <div class="pass-blog-c">
          <label for="email_d"><b>Eamil</b></label><span class="Err" id="Email_dErr"> * </span>
          <input type="text" name="email_d" id="email_d"  placeholder="Enter Eamil.." autocomplete="off" />
          <input type="hidden" name="csrfj" value="<?=$share->csrf_tokenj(); ?>" />
          <label for="uname_d"><b>Useraname</b></label><span class="Err" id="Uname_dErr"> * </span>
          <input type="text" name="uname_d" id="uname_d"  placeholder="Enter Useraname"  autocomplete="off" />
          <label for="pass_d"><b>Password</b></label><span class="Err" id="Pass_dErr"> * </span>
          <input  type="password" name="pass_d" id="pass_d" placeholder="Enter Password"  autocomplete="off" />
          <label for="captcha"><b>Enter Below Captcha</b></label><span class="Err" id="Captcha_dErr"> * </span>  
          <input type="text" name="captcha" id="captcha"  placeholder="Enter below captcha" autocomplete="off" />
          <img src="captcha.php" alt="captcha" />
        </div>
        <div class="pass-blog-c">
          <button type="submit" name="submit">Delete</button>
        </div>
    </form>
  </div>
</div>
<div class="open-modal-img" id="open-modal-img">
  <span class="close-image" id="close-image">&times;</span>
  <img class="user-image" id="user-img01" />
</div>