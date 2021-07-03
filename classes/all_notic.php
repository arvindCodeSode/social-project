<?php
date_default_timezone_set("Asia/kolkata");
require_once 'dbcon.php';
class all_notic extends dbcon{
		private $activity;
  public function total_post_n($view=null){
    $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
    $sql="SELECT * FROM `post_data` WHERE `user_Id`=? ORDER BY `post_id` DESC";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $fetch="";
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
          $fetch.=$this->post_s_n($data['post_id'],$view);
      }
      return $fetch;
    }else{
      return false;
    }
  }
  // public function total_comment_n($user_id,$view=null){
  //   $user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_login']['id'])));
  //   $sql="SELECT * FROM `post_comment` WHERE `user_id`=? ORDER BY `comment_id` DESC";
  //   $stmt=$this->connection->prepare($sql);
  //   $stmt->bind_param("i",$user_id);
  //   $stmt->execute();
  //   $fetch="";
  //   $result=$stmt->get_result();
  //   if($result->num_rows>0){
  //     while($data=$result->fetch_assoc()){
  //         $fetch.=$this->comment_s_n($data['comment_id'],$view);
  //     }
  //     return $fetch;
  //   }else{
  //     return false;
  //   }
  // }
  public function post_s_n($post_id=null,$view=null){
    if($view!=""){
    $sql3="UPDATE `post_comment` SET `comment_status`=1 WHERE `post_id`=? AND `comment_status`=0  ORDER BY `comment_id` DESC";
    $stmt3=$this->connection->prepare($sql3);
    $stmt3->bind_param("i",$post_id);
    $stmt3->execute();
    $sql4="UPDATE `post_like` SET `post_like_status`=1 WHERE `post_id`=? AND `post_like_status`=0 ORDER BY `like_co_id` DESC";
    $stmt4=$this->connection->prepare($sql4);
    $stmt4->bind_param("i",$post_id);
    $stmt4->execute();
    }
    else{
      $sql="SELECT * FROM `post_comment` WHERE `post_id`=?   ORDER BY `comment_id` DESC  LIMIT 50";
      $stmt=$this->connection->prepare($sql);
      $stmt->bind_param("i",$post_id);
      $stmt->execute();
      $result=$stmt->get_result();
      $html="";
      static $row1;
      if($result->num_rows>0){
        while($data=$result->fetch_assoc()){
            $image_txt=$this->user_notification_image($data['user_id']);
            if($image_txt['uname']!=$_SESSION['user_login']['uname']){
                $row1+=$this->p_s_c($post_id);
                $html.='<div class="notification-cont"><div class="m-user-bio"><div class="m-user m-user-image">';
              if($image_txt['image']){
                $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
                <img src="dataimage/'.$image_txt['image'].'"></div></a>';
              } else{
               $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
               <img src="dataimage/img_avatar.png"></div></a>';
              }
              $html.='</div><div class="m-user m-user-name">
                <p><a href="#" data-status="'.$data['comment_status'].'"><strong style="color: #980303">'.$image_txt['fname'].'</strong> <i style="color:#008000;">comments</i> to your post <q style="color: #0c8a2d">'.wordwrap($data['comment'],50).'.. </q></a> </p></div></div></div><hr />';
          }
        }
      }
      $sql1="SELECT * FROM `post_like` WHERE `post_id`=? ORDER BY `like_co_id` DESC  LIMIT 50";
      $stmt1=$this->connection->prepare($sql1);
      $stmt1->bind_param("i",$post_id);
      $stmt1->execute();
      $result1=$stmt1->get_result();
      static $row2;
      $rowa='0';
      if($result1->num_rows > 0){
        while($data=$result1->fetch_assoc()){
           $image_txt=$this->user_notification_image($data['user_id']);
            if($image_txt['uname']!=$_SESSION['user_login']['uname']){
              $row2+=$this->c_s_c($post_id);
              $html.='<div class="notification-cont"><div class="m-user-bio"><div class="m-user m-user-image">';
              if($image_txt['image']){
                $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
                <img src="dataimage/'.$image_txt['image'].'"></div></a>';
              }else{
              $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
              <img src="dataimage/img_avatar.png"></div></a>';
              }
              $html.='</div><div class="m-user m-user-name">
              <p><a href="#" data-status="'.$data['post_like_status'].'"><strong style="color: #980303">'.$image_txt['fname'].'</strong> <i style="color:#008000;">Likes </i>  your post </a> </p></div></div></div><hr />';
          }
        }
      }

      static $row;
      $row=$row1+$row2;
      $_SESSION['total_p_n']=$row;
      return $html;
    } 
  }
  public function p_s_c($post_id=""){
    $sql="SELECT * FROM `post_like` WHERE `post_like_status`=0  AND  `post_id`=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$post_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      return 1;
    }

  }
  public function c_s_c($post_id=""){
    $sql="SELECT * FROM `post_comment` WHERE `comment_status`=0 AND `post_id`=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$post_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      return 1;
    }
  }
  // public function comment_s_n($comment_id=null,$view=null){
  // if($view!=""){
  //   $sql3="UPDATE `comment_like` SET `like_status`=1 WHERE `comment_id`=? AND `like_status`=0  ORDER BY `comment_like_id` DESC";
  //   $stmt3=$this->connection->prepare($sql3);
  //   $stmt3->bind_param("i",$post_id);
  //   $stmt3->execute();
  //   $sql4="UPDATE `comment_reply` SET `reply_status`=1 WHERE `comment_id`=? AND `reply_status`=0 ORDER BY `reply_id` DESC";
  //   $stmt4=$this->connection->prepare($sql4);
  //   $stmt4->bind_param("i",$post_id);
  //   $stmt4->execute();
  //   }
  //   else{
  //     $sql="SELECT * FROM `comment_like` WHERE `comment_id`=? ORDER BY `comment_like_id` DESC LIMIT 20";
  //     $stmt=$this->connection->prepare($sql);
  //     $stmt->bind_param("i",$comment_id);
  //     $stmt->execute();
  //     $result=$stmt->get_result();
  //     $html="";
  //     static $row1;
  //     if($result->num_rows>0){
  //       while($data=$result->fetch_assoc()){
  //           $image_txt=$this->user_notification_image($data['user_id']);
  //           if($image_txt['uname']!=$_SESSION['user_login']['uname']){
  //               $row1+=$this->rl_s_c($comment_id);
  //               $html.='<div class="notification-cont"><div class="m-user-bio"><div class="m-user m-user-image">';
  //             if($image_txt['image']){
  //               $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
  //               <img src="dataimage/'.$image_txt['image'].'"></div></a>';
  //             } else{
  //              $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
  //              <img src="dataimage/img_avatar.png"></div></a>';
  //             }
  //             $html.='</div><div class="m-user m-user-name">
  //               <p><a href="#" data-status="'.$data['like_status'].'"><strong style="color: #980303">'.$image_txt['fname'].'</strong> like  your comment</a> </p></div></div></div><hr />';
  //         }
  //       }
  //     }
  //     $sql1="SELECT * FROM `comment_reply` WHERE `comment_id`=? ORDER BY `reply_id` DESC  LIMIT 20";
  //     $stmt1=$this->connection->prepare($sql1);
  //     $stmt1->bind_param("i",$comment_id);
  //     $stmt1->execute();
  //     $result1=$stmt1->get_result();
  //     static $row2;
  //     $rowa='0';
  //     if($result1->num_rows > 0){
  //       while($data=$result1->fetch_assoc()){
  //          $image_txt=$this->user_notification_image($data['user_id']);
  //           if($image_txt['uname']!=$_SESSION['user_login']['uname']){
  //             $row2+=$this->r_s_c($comment_id);
  //             $html.='<div class="notification-cont"><div class="m-user-bio"><div class="m-user m-user-image">';
  //             if($image_txt['image']){
  //               $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
  //               <img src="dataimage/'.$image_txt['image'].'"></div></a>';
  //             }else{
  //             $html.='<a href="profile?uname='.$image_txt['uname'].'"><div class="image">
  //             <img src="dataimage/img_avatar.png"></div></a>';
  //             }
  //             $html.='</div><div class="m-user m-user-name">
  //             <p><a href="#" data-status="'.$data['reply_status'].'"><strong style="color: #980303">'.$image_txt['fname'].'</strong> <i style="color:#008000;">Reply </i> on your comment  <q style="color: #0c8a2d">'.$data['reply'].'</q> </a> </p></div></div></div><hr />';
  //         }
  //       }
  //     }

  //     static $row;
  //     $row=$row1+$row2;
  //     $_SESSION['total_c_n']=$row;
  //     return $html;
  //   }
  // }
  // public function r_s_c($comment_id=""){
  //   $sql="SELECT * FROM `comment_reply` WHERE `reply_status`=0  AND  `comment_id`=?";
  //   $stmt=$this->connection->prepare($sql);
  //   $stmt->bind_param("i",$comment_id);
  //   $stmt->execute();
  //   $result=$stmt->get_result();
  //   if($result->num_rows>0){
  //     return 1;
  //   }

  // }
  // public function rl_s_c($comment_id=""){
  //   $sql="SELECT * FROM `comment_like` WHERE `like_status`=0 AND `comment_id`=?";
  //   $stmt=$this->connection->prepare($sql);
  //   $stmt->bind_param("i",$comment_id);
  //   $stmt->execute();
  //   $result=$stmt->get_result();
  //   if($result->num_rows>0){
  //     return 1;
  //   }
  // }
  public function user_notification_image($user_id){
    $sql="SELECT Uimg.image ,U.fname,U.uname FROM user U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.`user_id`=?";
    $stmt=$this->connection->prepare($sql);
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0){
      while($data=$result->fetch_assoc()){
          return $data;
      }
    }
    return false;
  }
		public function __construct(activity $log){
			parent::__construct();
			$this->activity=$log;
		}
}

?>