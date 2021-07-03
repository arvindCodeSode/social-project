   <div class="left-container">
      <div class="left-cont" id="left-cont">
          <?php if(isset($_SESSION['user_login']['id'])):
          echo $share->left_image_data();  
          endif; ?>
          <hr />
      </div>
      <div class="left-sidenav">
          <div class="popup-cont"><a class="get-home"><i class="fas fa-home"></i>&nbsp;&nbsp;Home <span class="noti-no home-noti"> </span></a></div>
          <div class="popup-cont"><a class="get-profile" href="profile?uname=<?=htmlspecialchars($_SESSION['user_login']['uname']);?>"><i class="fas fa-user"></i>&nbsp;&nbsp;&nbsp;Profile</a></div>
          <div class="popup-cont"><a class="get-friends"  href="<?=htmlspecialchars('friends'); ?>"><i class="fas fa-users"></i>&nbsp; Friends <span class="noti-no friends-noti"> 1</span></a></div>
          <div class="popup-cont"><a class="get-not"  ><i class="fas fa-bell"></i>&nbsp;&nbsp; Notification <span class="noti-no notification-noti" id="fetch-noti"> </span></a></div>
          <!-- <div class="popup-cont"><a class="get-trends"><span style="padding-right:10px;">HO</span>Trends <span class="noti-no trends-noti"> </span></a>
                             </div> -->
          <div class="popup-cont"><a class="get-video"><i class="fas fa-video"></i>&nbsp; Video <span class="noti-no video-noti"> 1</span></a>
                </div>
          <div class="popup-cont">
          <a href=""; class="setting-open"  ><i class="fas fa-cog"></i>&nbsp; Security and setting</a>
          <!-- <div class="popup"></div> -->
          </div>
          <div class="popup-cont">
              <a href="" id="more-popup-btn" ><i class="fas fa-list"></i>&nbsp; More</a>
            <div class="more-popup popup">
                <a href="" >Activity</a>
                <a href="user/logout.php"  >Logout</a>
            </div>
          </div>
      </div>
    </div>