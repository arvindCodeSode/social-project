<?php
date_default_timezone_set("Asia/kolkata");
require_once 'dbcon.php';
class share extends dbcon{
    private $activity;
    public function ipp($ip=""){
    
      $sql="INSERT INTO `ip`(`ip`) VALUES (?)";
      $stmt=$this->connection->prepare($sql);
      $stmt->bind_param("s",$ip);
      $stmt->execute();
    }
    public function open_share($post_id=null){
    $post_id=intval($post_id);
    $html="";
    $sql  = "SELECT `fname`,`uname`, P.*,Uimg.*, SUM(likes) AS likes FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id=? GROUP BY P.post_id ORDER BY P.post_id DESC";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$post_id);
    $stmt->execute();
    $result=$stmt->get_result();
      if($result->num_rows>0){
        $data=$result->fetch_assoc();
                    $html.='<div class="middle-blog-c" id="middle-blog-c">';
                    $html.='<!--top user bio container-->';
                    $html.='<div class="m-user-bio">';
                    $html.='<!--this is image with date and name-->';
                    $html.='<div class="m-user m-user-image">';
                    if($data['image']){
                    $html.='<a href="profile?uname='.$data['uname'].'">';
                    $html.='<div class="image">';
                    $html.='<img src="dataimage/'.$data['image'].'"></div></a>';
                    }
                    else{
                    $html.='<a href="profile?uname='.$data['uname'].'">';
                    $html.='<div class="image">';
                    $html.='<img src="dataimage/img_avatar.png"></div></a>';
                    }
                    
                    $html.='</div>';
                    $html.='<!--uesr name and date follow -->';
                    $html.='<div class="m-user m-user-name">';
                    $html.='<a href="profile?uname='.$data['uname'].'">';
                    $html.='<span class="user-name">'.ucwords(ucwords($data['fname']));
                    $html.='</span></a><br>';                    
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    $html.='<a class="m-follow"><span>Follow</span></a>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                    $html.='<!--this is blogs text and image container-->';
                    $html.='<div class="middle-blog">';
                if($data['post_text'] AND $data['post_image_text']){
                     $html.='<div class="post-text">';
                        $post_text=explode("\\n", $data['post_text']);
                        $length=count($post_text);
                        for($i=0;$i<$length;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$post_text[$i]."<br />";
                      }
                      $html.="</div>";
                      $html.='<!--this is middle image--><br>';
                      // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                      $type=explode("/", $data['type']);
                      if($type[0]=="image"){
                      $html.='<img class="open-imgs" src="dataimage/'.$data['post_image_text'].'" />';
                      }
                      elseif($type[0]=="video"){
                      $html.='<video controls="controls" >';
                      $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                      $html.='sorry your borsower does not support this feature';
                      $html.='</video>';
                      }
                }
                elseif(!$data['post_text'] AND $data['post_image_text']){
                   // $html.='<div>'.$data['post_text'].'</div>';
                     $html.='<!--this is middle image--><br>';
                     // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                      $type=explode("/", $data['type']);
                      if($type[0]=="image"){
                      $html.='<img class="open-imgs" src="dataimage/'.$data['post_image_text'].'" />';
                      }
                      elseif($type[0]=="video"){
                      $html.='<video controls="controls" >';
                      $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                      $html.='sorry your borsower does not support this feature';
                      $html.='</video>';
                      }
                }
                elseif($data['post_text'] AND !$data['post_image_text']){
                    $html.='<div class="post-text">';
                      $post_text=explode("\\n", $data['post_text']);
                      $length=count($post_text);
                      for($i=0;$i<$length;$i++){
                      // $post_text=wordwrap($post_text[$i]);
                      $html.=$post_text[$i]."<br />";
                    }
                    $html.="</div>";
                    $html.='<!--this is middle image--><br>';
                     // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                }
                  $html.='</div>';
                  $html.='<hr>';
                  $html.='<div class="share-buttons-div">';
                  $html.='<button type="button" onclick="shareNow(event,'.$data['post_id'].')" class="share-button share-post-b">Post</button>';
                  $html.='<button class="share-cancel share-button" onclick="cancelShare(event)">Cancel</button>';
                  $html.='</div>';
                  $html.='</div>';
                  return $html;

    }
  }
  public function post_share($share_parent_id,$share_data=null){
    $share_parent_id=intval($share_parent_id);
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    if(!empty($share_data)){
     $sql="INSERT INTO `post_data`(`user_Id`, `share_parent_id`, `share_text`) VALUES (?,?,?)";
    }
    elseif(empty($share_data)){
      $sql="INSERT INTO `post_data`(`user_Id`, `share_parent_id`, `share_text`) VALUES (?,?,?)";
    }
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("iis",$user_id,$share_parent_id,$share_data);
    $stmt->execute();
    $last_insert_id=$this->connection->insert_id;
    if($last_insert_id){
      return true;
    }else{
       return false;
    }

  }
  public function user_bio_data(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
        $html.='<div class="m-user m-user-image">';
        $html.='<a href="profile?uname='.$data['uname'].'">';
        if($data['image']){
        $html.='<div class="image"><img src="dataimage/'.$data['image'].'" /></div></a></div>';               
        }
        else{
        $html.='<div class="image"><img src="dataimage/img_avatar.png" /></div></a></div>';               
        }              
        $html.='<div class="m-user m-user-name"><a href="profile?uname='.$data['uname'].'">';
        $html.='<span class="user-name">'.ucwords(ucwords($data['fname']));
        $html.='</span></a><br />';
        $html.='<span>'.$data['uname'].'</span>';
        $html.='</div>';
      }
      return $html;
    }
  }
  public function left_image_data(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname`, Uimg.`type1` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
          $html.='<div class="left-user-nmae user-name">';
          $html.='<!--this is image with date and name-->';
          $html.='<div class="left-user left-user-image">';
          if($data['image']){
            if($data['type1']=="jpg" || $data['type1']=="jpeg"){
              $image=imagecreatefromjpeg("dataimage/".$data['image']);
            }
            elseif($data['type1']=="png"){
              $image=imagecreatefrompng("dataimage/".$data['image']);
            }
            elseif($data['type1']=="gif"){
              $image=imagecreatefromgif("dataimage/".$data['image']);
            }

          if(imagesx($image)<=800){
            $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"  alt="'.ucwords(ucwords($data['fname'])).'" id="left-pro-img"></a>';
          }else{
            $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'" height="100%"  alt="'.ucwords(ucwords($data['fname'])).'" id="left-pro-img"></a>';
          }

        }else{
          $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"  alt="'.ucwords(ucwords($data['fname'])).'" id="left-pro-img"></a>';
        }
          $html.='</div> ';
          $html.='<div class="left-user-uname">';
          $html.='<a href="profile?uname='.$data['uname'].'">'.ucwords(ucwords($data['fname'])).'</a>';
          $html.='</div>';
          $html.='</div>';
      }
      return $html;
    }
  }
  public function m_top_image(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
      $html.='<div class="m-top-name">';
      $html.='<a href="profile?uname='.$data['uname'].'">'.ucwords(ucwords($data['fname'])).'</a></div><!--this is image with date and name--><div class="m-user m-user-image">';
        if($data['image']){
        $html.='<a href="profile?uname='.$data['uname'].'"><div class="image"><img src="dataimage/'.$data['image'].'"  alt="'.ucwords(ucwords($data['fname'])).'" /></div></a></div>';

      }else{
        $html.='<a href="profile?uname='.$data['uname'].'"><div class="image"><img src="dataimage/img_avatar.png"   alt="'.ucwords(ucwords($data['fname'])).'" /></div></a></div>';
      }
      return $html;
    }
  }
}
 public function m_pro_image(){
  if(isset($_SESSION['user_login']['id'])){
      $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
        $html.='<div class="m-user m-user-image">';
        if($data['image']){
        $html.='<a href="profile?uname='.$data['uname'].'"><div class="image"><img src="dataimage/'.$data['image'].'"  alt="'.ucwords(ucwords($data['fname'])).'"  id="m-pro-img" /></div></a></div>';

      }else{
        $html.='<a href="profile?uname='.$data['uname'].'"><div class="image"><img src="dataimage/img_avatar.png" alt="'.ucwords(ucwords($data['fname'])).'"  id="m-pro-img" /></div></a></div>';
      }
    }
     return $html;
    }
  }
}
public function friends_list($last_id){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname`,U.`profession`,U.`user_id` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.`user_id`< ? ORDER BY U.`user_id` DESC LIMIT 5";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$last_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
        $html.='<div class="friends-list">';
        $html.='<div class="friends-images">';
        $html.='<div class="fri-img-c">';
        if($data['image']){
        $html.='<a href="profile?uname='.$data['uname'].'" title="'.ucwords(ucwords($data['fname'])).'!"><img src="dataimage/'.$data['image'].'" /></a> ';                                             
        }else{
        $html.='<a href="profile?uname='.$data['uname'].'" title="'.ucwords(ucwords($data['fname'])).'!" ><img /></a> ';                                   
        }
        $html.='</div></div><div class="friends-names"><span class="hide">&times;</span><div class="fri-name-c">';
        $html.='<a href="profile?uname='.$data['uname'].'" title="'.ucwords(ucwords($data['fname'])).'!">'.ucwords(ucwords($data['fname'])).'</a>';
        if($data['profession']){
        $html.='<div>'.$data['profession'].'</div>';          
        }
        $html.='<div id="follow"><button><a href="#" id="follow-user" class="follow-user follow" title="follow!">Follow</a></button>';
        $html.='<button> <a title="connect!" href="#" id="connecting" class="follow-user connecting" title="close!">Connect</a></button>';
        $html.='</div></div></div></div><hr class="hide-hr" />';
        $_SESSION['user_last_id']=$data['user_id'];
      
    }
    return $html;
  }
}
public function bloggers_list(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $html="";
    $sql="SELECT U.`fname` ,U.`uname`,U.`profession`,U.`user_id` ,Uimg.`image` FROM `user` U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id";
    $stmt=$this->connection->prepare($sql);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
          $html.='<div class="popular-blogggers-c">';
          $html.='<div class="popular-blogggers" id="popular-blogggers">';
          $html.='<a href="profile?uname='.$data['uname'].'" target="_top" title="'.ucwords(ucwords($data['fname'])).'!">';
          if($data['image']){
          $html.='<div class="image"><img src="dataimage/'.$data['image'].'" alt="'.ucwords(ucwords($data['fname'])).'" title="'.ucwords(ucwords($data['fname'])).'!"></div>';            
          }else{
          $html.='<div class="image"></div>';
          }
          $html.='<span class="blogger-name">'.ucwords(ucwords($data['fname'])).' </span></a>';
          $html.='<span class="close-bloggers" id="close-bloggers" title="Hide Blogger!">&times;</span>';
          $html.='</div><div class="connect">';
          $html.='<a href="#" id="follow" class="follow">Follow</a><a href="#" id="connect" class="connecting">Connect</a>';
          $html.='</div></div>';
    }
    return $html;
  }
}
  public function image_select(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $sql="SELECT * FROM `user_image_p` WHERE user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      return $result->fetch_assoc();
    }

  }
   public function images(){
    $user_id=$_SESSION['user_login']['id'];
    $sql="SELECT * FROM `user_image` WHERE user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      return $result->fetch_assoc();
    }

  }
  public function find_images(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $sql="SELECT * FROM `user_image` WHERE user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $html="";
    $result=$stmt->get_result();
    if($result->num_rows>0){
      $data=$result->fetch_assoc();
      $html.='<!--top profile image--><div class="user-profile-b-img">';
      if(!$data['profile_image']){
      $html.='<img src="dataimage/img_snow.jpg" id="cover-form-img">';
      }else{
      $html.='<img src="dataimage/'.$data['profile_image'].'" id="cover-form-img">';
      }
      $html.='</div><!--center image name username date--><div class="user-image"><div class="user-img" >';
      if(!$data['image']){
      $html.='<img src="dataimage/img_avatar.png" id="pro-form-img">';
      }else{
      $html.='<img src="dataimage/'.$data['image'].'" id="pro-form-img">';
      }
      $html.='</div>';
      $html.='</div>';
      return $html;
    }
  }
  public function edit_form(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $sql="SELECT * FROM `user` WHERE `user_Id`=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $html="";
    $result=$stmt->get_result();
    if($result->num_rows>0){
      $data=$result->fetch_assoc();
      $html.='<div class="full-edit-share-box" id="full-edit-share-box"><div class="eidt-close">'; 
      $html.='<span class="e-close-b"  id="e-close-b" title="hide form!">&times;</span></div><div class="f-share-box" >';
      $html.='<div class="user-profile-c">'.$this->find_images().'<div class="user-message-c"><h4 class="user-message" id="user-message"> </h4></div>';
      $html.='<!--center image name username date end--><form id="edit-profile"><div class="form-field">';
      $html.='<label for="name"><b>Name </b></label><span class="Err" id="fnameErr"> * </span>';
      if(ucwords($data['fname'])){
      $html.='<input type="text" id="fname" value="'.ucwords(ucwords($data['fname'])).'" name="fname" placeholder="Name..."><span class="word-counter">1/50</span></div>';
      }else{
      $html.='<input type="text" id="fname" name="fname" placeholder="Name..."><span class="word-counter">1/50</span></div>';
      }
      $html.='<div class="form-field"><label for="mobile"><b>Mobile No. </b></label><span class="Err" id="mobileErr"> * (optional )  </span>';
      if($data['mobile']){
      $html.='<input type="text" id="mobile" maxlength="11" value="'.$data['mobile'].'" name="mobile" placeholder="Mobile No..."><span class="word-counter">1/10</span></div>';
      }else{
      $html.='<input type="text" id="mobile" name="mobile" placeholder="Mobile..."><span class="word-counter">1/10</span></div>';
      }      
      $html.='<div class="form-field"><label for="user-bio"><b>Bio </b></label><span class="Err" id="bioErr"> * (optional )  </span>';
      if($data['user_bio']){
      $html.='<textarea name="user-bio" id="user-bio" value="'.$data['user_bio'].'" placeholder=" Add bio..."></textarea><span class="word-counter">1/150</span></div>';
      }else{
      $html.='<textarea name="user-bio" id="user-bio" placeholder=" Add bio..."></textarea><span class="word-counter">1/150</span></div>';
      }
      $html.='<div class="form-field">';
      $html.='<label for="location"><b>Location </b></label><span class="Err" id="locationErr"> * (optional) </span>';
      if($data['location']){
      $html.='<input type="text" id="location" name="location" value="'.$data['location'].'" placeholder="Location..."><span class="word-counter">1/50</span>';
      }else{
      $html.='<input type="text" id="location" name="location"  placeholder="Location..."><span class="word-counter">1/50</span>';
      }
      $html.='</div><div class="form-field">';
      $html.='<label for="profession"><b>Profession </b></label><span class="Err" id="professionErr"> * ( optional )</span>';
      if($data['profession']){
      $html.='<input type="text" id="profession" name="profession" value="'.$data['profession'].'" placeholder="Profession..."><span class="word-counter">1/50</span>';
      }else{
      $html.='<input type="text" id="profession" name="profession" placeholder="Profession..."><span class="word-counter">1/50</span>';
      }
      $html.='</div><div class="form-field"><input type="hidden" name="csrfg" value="'.$this->csrf_tokeng().'"></div><div class="form-field">';
      $html.='<input type="submit" name="submit" value="Submit" id="edit-profile-sub">';
      $html.='</div></form></div></div></div>';
      return $html;
    }
  }
  public function delete_Img(){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $sql="DELETE FROM `user_image_p` WHERE user_id=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    if($this->connection->affected_rows){
      return true;
    }else{
      return false;
    }
  }
    public function csrf_tokeng(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfg']=$random;
            return $random;
    }
    public function csrf_tokenh(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfh']=$random;
            return $random;
    }
    public function csrf_tokeni(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfi']=$random;
            return $random;
    }
    public function csrf_tokenj(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfj']=$random;
            return $random;
    }
    public function csrf_tokenk(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfl']=$random;
            return $random;
    }

    public function __construct(activity $log){
      parent::__construct();
      $this->activity=$log;
    }
}

?>