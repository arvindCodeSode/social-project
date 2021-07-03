<?php
date_default_timezone_set("Asia/kolkata");
require_once 'dbcon.php';
class blogs extends dbcon{
        private $activity;
        public function post($post_text=null,$files=null,$type=null){
            $user_id=$_SESSION['user_login']['id'];
            $sql="";
            $html="";
            if(!empty($post_text) AND empty($files)){
                $sql.="INSERT INTO `post_data`(`user_Id`, `post_text`,`post_image_text`,`type`) VALUES (?,?,?,?)";
            }
            elseif(empty($post_text) AND !empty($files)){
            $sql.="INSERT INTO `post_data`(`user_Id`, `post_text`,`post_image_text`,`type`) VALUES (?,?,?,?)";
            }
            elseif(!empty($post_text) AND !empty($files)){
                $sql.="INSERT INTO `post_data`(`user_Id`, `post_text`,`post_image_text`,`type`) VALUES (?,?,?,?)";
            }
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("isss",$user_id,$post_text,$files,$type);
            $stmt->execute();
            $last_insert_id=$this->connection->insert_id;
            if($last_insert_id){
                return true;
            }else{
                return false;
            }
        }

        public function show_data($last_id=null){
            $last_id=intval($last_id);
            $html = "";
            $sql  = "SELECT `fname`,`uname`, P.*,Uimg.*, SUM(likes) AS likes FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id < ? GROUP BY P.post_id ORDER BY P.post_id DESC LIMIT 20";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$last_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                while($data=$result->fetch_assoc()){
                    $com=$this->comment_count($data['post_id']);
                    $replys=$this->reply_count($data['post_id']);
                    $shares=$this->share_count($data['post_id']);
                    $comments=$com+$replys;
                    $_SESSION['top_count'][]=[
                        "cid"=>"comment_".$data['post_id'],
                        "sid"=>"share_".$data['post_id'],
                        "lid"=>"like_".$data['post_id'],
                        "comment_count"=>$comments,
                        "share_count"=>$shares,
                        "like_count"=>$data['likes']
                    ];
                    $html.='<!--middle blog contianer  c start-->';
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
                    $html.='<span class="user-name">'.ucwords($data['fname']);
                    $html.='</span></a><br>';                    
                    // $html.='<a class="m-user-bar"><span>&#35;</span></a>';
                    $html.='<div class="user-restrict-cont">';                 
                    $html.='<a class="m-user-bar" onclick="openRestrict(event)" title="click two time to open box!"><i class="fas fa-ellipsis-v"></i></a>';
                    $html.='<div class="user-restrict">';
                    $html.='<div class="restrict">';
                    if($_SESSION['user_login']['uname']==$data['uname']){
$html.='<a href="#" id="delete-post" onClick="postde('.$data['post_id'].', \''.$this->csrf_token_m().'\',event)">Delete</a>';                        
                    }else{
                    $html.='<a href="#"  id="hide-post" onClick="posthi('.$data['post_id'].', \''.$this->csrf_token_n().'\',event)">Hide</a>';
                    $html.='<a href="#" id="report-post" onClick="postre('.$data['post_id'].', \''.$this->csrf_token_o().'\',event)">Report</a>';
                    $html.='<a href="#" id="post-block-30" onClick="postblo_thi('.$data['post_id'].', \''.$this->csrf_token_p().'\',event)">block 30 days</a>';
                    $html.='<a href="#" id="post-block" onClick="postblo('.$data['post_id'].', \''.$this->csrf_token_q().'\',event)">block</a>';
                   }
                    $html.='<a onclick="closeRestrict(event)">Cancel</a>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    // $html.='<a class="m-follow"><span>Follow</span></a>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                    $html.='<!--this is blogs text and image container-->';
                    if($data['share_parent_id'] AND $data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">';
                        $share_text=explode("\\n", $data['share_text']);
                        $len=count($share_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$share_text[$i]."<br />";
                        }
                        $html.='</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_bio($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    elseif($data['share_parent_id'] AND !$data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">';
                        $share_text=explode("\\n", $data['share_text']);
                        $len=count($share_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$share_text[$i]."<br />";
                        }
                        $html.='</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_bio($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    //this is for share text
                    elseif(!$data['share_parent_id'] AND !$data['share_text']){
                        if($data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.="</div>";
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif($data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $len=count($post_text);
                            for($i=0;$i<$len;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                    }
                    if($data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                    }
                    elseif(!$data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';

                    }
                    elseif($data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> </span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share  empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                   
                    $_SESSION['last_id']=$data['post_id'];
                    //this is showing comment box
                    $html.=$this->show_comment($data['post_id']);
                    $html.='</div>';
                    $html.='<!--middle blogs text and image end-->';
                    $html.='</div><!--middle blog contianer c end--><hr>';
                }
                return $html;
            }
        }
        public function show_video($last_id=null){
                $last_id=intval($last_id);
            $html = "";
            $sql  = "SELECT `fname`,`uname`, P.*,Uimg.*, SUM(likes) AS likes FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id < ? GROUP BY P.post_id ORDER BY P.post_id DESC LIMIT 20";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$last_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                while($data=$result->fetch_assoc()){
                    $type=explode("/", $data['type']);
                    if($type[0]=="video"){
                    $com=$this->comment_count($data['post_id']);
                    $replys=$this->reply_count($data['post_id']);
                    $shares=$this->share_count($data['post_id']);
                    $comments=$com+$replys;
                    $html.='<!--middle blog contianer  c start-->';
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
                    $html.='<span class="user-name">'.ucwords($data['fname']);
                    $html.='</span></a><br>';                    
                    // $html.='<a class="m-user-bar"><span>&#35;</span></a>';
                    $html.='<div class="user-restrict-cont">';                 
                    $html.='<a class="m-user-bar" onclick="openRestrict(event)" title="click two time to open box!"><i class="fas fa-ellipsis-v"></i></a>';
                    $html.='<div class="user-restrict">';
                    $html.='<div class="restrict">';
                    if($_SESSION['user_login']['uname']==$data['uname']){
$html.='<a href="#" id="delete-post" onClick="postde('.$data['post_id'].', \''.$this->csrf_token_m().'\',event)">Delete</a>';                        
                    }else{
                    $html.='<a href="#"  id="hide-post" onClick="posthi('.$data['post_id'].', \''.$this->csrf_token_n().'\',event)">Hide</a>';
                    $html.='<a href="#" id="report-post" onClick="postre('.$data['post_id'].', \''.$this->csrf_token_o().'\',event)">Report</a>';
                    $html.='<a href="#" id="post-block-30" onClick="postblo_thi('.$data['post_id'].', \''.$this->csrf_token_p().'\',event)">block 30 days</a>';
                    $html.='<a href="#" id="post-block" onClick="postblo('.$data['post_id'].', \''.$this->csrf_token_q().'\',event)">block</a>';
                   }
                    $html.='<a onclick="closeRestrict(event)">Cancel</a>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    // $html.='<a class="m-follow"><span>Follow</span></a>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                    $html.='<!--this is blogs text and image container-->';
                    if($data['share_parent_id'] AND $data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">'.$data['share_text'].'</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_video($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    elseif($data['share_parent_id'] AND !$data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">'.$data['share_text'].'</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_video($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    //this is for share text
                    elseif(!$data['share_parent_id'] AND !$data['share_text']){
                        if($data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif($data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                    }
                    if($data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                    }
                    elseif(!$data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';

                    }
                    elseif($data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> </span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share  empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes  empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                   
                    $_SESSION['last_video_id']=$data['post_id'];
                    //this is showing comment box
                    $html.=$this->show_comment($data['post_id']);
                    $html.='</div>';
                    $html.='<!--middle blogs text and image end-->';
                    $html.='</div><!--middle blog contianer c end--><hr>';
                }
            }
                return $html;
            }

        }
        public function show_profile_data($uname){
            $html = "";
            $sql  = "SELECT `fname`,`uname`, P.*,Uimg.*, SUM(likes) AS likes FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE U.uname=? GROUP BY P.post_id ORDER BY P.post_id DESC LIMIT 20";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("s",$uname);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                while($data=$result->fetch_assoc()){
                    $com=$this->comment_count($data['post_id']);
                    $replys=$this->reply_count($data['post_id']);
                    $shares=$this->share_count($data['post_id']);
                    $comments=$com+$replys;
                    $html.='<!--middle blog contianer  c start-->';
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
                    $html.='<span class="user-name">'.ucwords($data['fname']);
                    $html.='</span></a><br>';                    
                    // $html.='<a class="m-user-bar"><span>&#35;</span></a>';
                    $html.='<div class="user-restrict-cont">';                 
                    $html.='<a class="m-user-bar" title="click two time to open!"  onclick="openRestrict(event)"><i class="fas fa-ellipsis-v"></i></a>';
                    $html.='<div class="user-restrict">';
                    $html.='<div class="restrict">';
                    if($_SESSION['user_login']['uname']==$data['uname']){
$html.='<a href="#" id="delete-post" onClick="postde('.$data['post_id'].', \''.$this->csrf_token_m().'\',event)">Delete</a>';                        
                    }else{
                    $html.='<a href="#"  id="hide-post" onClick="posthi('.$data['post_id'].', \''.$this->csrf_token_n().'\',event)">Hide</a>';
                    $html.='<a href="#" id="report-post" onClick="postre('.$data['post_id'].', \''.$this->csrf_token_o().'\',event)">Report</a>';
                    $html.='<a href="#" id="post-block-30" onClick="postblo_thi('.$data['post_id'].', \''.$this->csrf_token_p().'\',event)">block 30 days</a>';
                    $html.='<a href="#" id="post-block" onClick="postblo('.$data['post_id'].', \''.$this->csrf_token_q().'\',event)">block</a>';
                   }
                    $html.='<a onclick="closeRestrict(event)">Cancel</a>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='</div>';
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    // $html.='<a class="m-follow"><span>Follow</span></a>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                    $html.='<!--this is blogs text and image container-->';
                    if($data['share_parent_id'] AND $data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">'.$data['share_text'].'</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_bio($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    elseif($data['share_parent_id'] AND !$data['share_text']){
                        // $html.="<div class='share-full-c'>";
                        $html.='<div class="post-share-text">'.$data['share_text'].'</div>';
                        // $html.='<hr />';
                        $html.=$this->show_share_bio($data['share_parent_id']);
                        $html.='<div class="share-date">';
                        $html.='<button type="button" class=>Follow</button>';  
                        $html.='</div>';
                        $html.='</div>';
                        // $html.="<hr />";
                        $html.='<div class="middle-blog">';
                    }
                    elseif(!$data['share_parent_id'] AND !$data['share_text']){
                        if($data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img  class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif($data['post_text'] AND !$data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                            $html.='<!--this is middle image--><br>';
                            // $html.='<img src="dataimage/'.$data['post_image_text'].'">';
                            $html.='</div>';
                        }
                        elseif(!$data['post_text'] AND $data['post_image_text']){
                            $html.='<div class="middle-blog">';
                            $html.='<div class="post-i-t-c">';
                            // $html.='<div class="post-text">'.$data['post_text'].'</div>';
                            $html.='<!--this is middle image--><br>';
                            $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                            $html.='</div>';
                        }
                    }
                    if($data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                    }
                    elseif(!$data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';

                    }
                    elseif($data['likes'] AND !$comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> </span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND $comments AND !$shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share empty">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif(!$data['likes'] AND $comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"> '.$comments.'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                    elseif($data['likes'] AND !$comments AND $shares){
                        $html.='<!--user recation-->';
                        $html.='<div class="m-user-rec">';
                        $html.='<div class="user-rec user-like" id="user_like'.$data['post_id'].'">';
                        $html.='<a  id="like_'.$data['post_id'].'" onClick="likeOrDislike('.$data['post_id'].')"  class="likes empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                        $html.='<span class="counter">'.$data['likes'].'</span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-commect" id="user_count_'.$data['post_id'].'">';
                        $html.='<a onClick="openComment(event)" class="comment empty"  data-id="'.$data['post_id'].'">';
                        $html.='<i class="fas fa-comment-alt"></i><span class="comment-text"> Comment</span>';
                        $html.='<span class="counter" id="comment_'.$data['post_id'].'"></span>';
                        $html.='</a>';
                        $html.='</div>';
                        $html.='<div class="user-rec user-share">';
                        $html.='<a onclick="openShare(event)" class="share">';
                        $html.='<span class="share-text">Share</span>';
                        $html.='<span class="counter" id="share_'.$data['post_id'].'">'.$shares.'</span>';
                        $html.='</a>';
                        $html.='<div class="f-s-cont">';
                        if($data['share_parent_id']){
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['share_parent_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['share_parent_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['share_parent_id'].')" >Share on Message</a>';
                        }
                        else{
                        $html.='<a class="o-share only-share" onclick="openIShare(event,'.$data['post_id'].')" >Share Instantly</a>';
                        $html.='<a class="o-share t-share" onclick="openTShare(event,'.$data['post_id'].')">Share Own Timeline</a>';
                        $html.='<a class="o-share m-share" onclick="openMShare(event,'.$data['post_id'].')" >Share on Message</a>';
                        }
                        $html.='<a class="o-share m-share" onclick="closeShare(event)" >Cancel</a>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='</div>';
                        $html.='<!--user rectaion end-->';
                        
                    }
                     $html.=$this->show_comment($data['post_id']);
                     $html.='</div>';
                     $html.='<!--middle blogs text and image end-->';
                     $html.='</div><!--middle blog contianer c end-->';
                }
                return $html;
            }
            else{
                $html.='<div class="middle-blog-c" id="middle-blog-c">';
                $html.="<h4> You have no post </h4>";
                $html.="</div>";
                return $html;
            }
        }
        // public function show_total($last_id=null){
        //     $last_id=intval($last_id);
        //     $html = "";
        //     $sql  = "SELECT `fname`,`uname`, P.*,Uimg.*, SUM(likes) AS likes FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id < ? GROUP BY P.post_id ORDER BY P.post_id DESC LIMIT 20";
        //     $stmt=$this->connection->prepare($sql);
        //     $stmt->bind_param("i",$last_id);
        //     $stmt->execute();
        //     $result=$stmt->get_result();
        //     $total=[];
        //     if($result->num_rows>0){
        //         while($data=$result->fetch_assoc()){
        //             $com=$this->comment_count($data['post_id']);
        //             $replys=$this->reply_count($data['post_id']);
        //             $shares=$this->share_count($data['post_id']);
        //             $likes=$data['likes'];
        //             $total_rec=$com+$replys+$shares+$likes;
        //             $total[]=['total'=>$total_rec,'post_id'=>$data['post_id']];
                    
        //         }
        //         return $total;
        //     }
        // }
        public function show_share_bio($share_parent_id){
            $html = "";
            $sql  = "SELECT `fname`,`uname`,Uimg.*,P.* FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id=? GROUP BY P.post_id ORDER BY P.post_id DESC";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$share_parent_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                  $html.='<div class="share-box">';
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
                    $html.='<span class="user-name">'.ucwords($data['fname']);
                    $html.='</span></a><br>';
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                      if($data['post_text'] AND $data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                        $type=explode("/", $data['type']);
                        if($type[0]=="image"){
                            $html.='<img class="open-imgs"" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                        }
                        $html.='</div>';
                      }
                      elseif(!$data['post_text'] AND !$data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                        $html.='</div>';
                      }
                      elseif($data['post_text'] AND !$data['post_image_text']){
                        $html.='<div class="post-i-t-c" style="border-bottom:1px solid #555;">';
                             $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                        $html.='</div>';
                      }
                      elseif(!$data['post_text'] AND $data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                        $html.='<!--this is middle image-->';
                        $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                        $html.='</div>';

                    }                 
                return $html;
        }
    }
    public function show_share_video($share_parent_id){
    $html = "";
            $sql  = "SELECT `fname`,`uname`,Uimg.*,P.* FROM `user` U RIGHT JOIN `post_data` P ON U.user_id=P.user_Id LEFT JOIN `post_like` PL ON P.post_id=PL.post_id LEFT JOIN `user_image` Uimg ON Uimg.user_id=U.user_id WHERE P.post_id=? GROUP BY P.post_id ORDER BY P.post_id DESC";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$share_parent_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                  $html.='<div class="share-box">';
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
                    $html.='<span class="user-name">'.ucwords($data['fname']);
                    $html.='</span></a><br>';
                    $html.='<span>'.$data['uname'].'</span>';
                    $html.="<br />";
                    $html.='<span class="m-date">'.date("d-m-Y H:i:s", strtotime($data['post_date'])).'</span>';
                    $html.='</div>';
                    $html.='<!--user nmae date end-->';
                    $html.='</div>';
                      if($data['post_text'] AND $data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                        $type=explode("/", $data['type']);
                        if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                        }
                        $html.='</div>';
                      }
                      elseif(!$data['post_text'] AND !$data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                        $html.='</div>';
                      }
                      elseif($data['post_text'] AND !$data['post_image_text']){
                        $html.='<div class="post-i-t-c" style="border-bottom:1px solid #555;">';
                            $html.='<div class="post-text">';
                            $post_text=explode("\\r\\n", $data['post_text']);
                            $length=count($post_text);
                            for($i=0;$i<$length;$i++){
                            // $post_text=wordwrap($post_text[$i]);
                            $html.=$post_text[$i]."<br />";
                            }
                            $html.='</div>';
                        $html.='</div>';
                      }
                      elseif(!$data['post_text'] AND $data['post_image_text']){
                        $html.='<div class="post-i-t-c">';
                        $html.='<!--this is middle image-->';
                        $type=explode("/", $data['type']);
                            if($type[0]=="image"){
                            $html.='<img class="open-imgs" alt='.ucwords($data['fname']).' src="dataimage/'.$data['post_image_text'].'" />';
                            }
                            elseif($type[0]=="video"){
                            $html.='<video controls="controls" >';
                            $html.='<source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" />';
                            $html.='sorry your borsower does not support this feature';
                            $html.='</video>';
                           }
                        $html.='</div>';

                    }                 
                return $html;
        }
    }
        
        public function comment_post_sub($post_id,$commnet_post){
            $user_id=$_SESSION['user_login']['id'];
            $post_id=intval($post_id);
            $sql="INSERT INTO `post_comment`(`comment`, `post_id`, `user_id`) VALUES (?,?,?)";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("sii",$commnet_post,$post_id,$user_id);
            $stmt->execute();
            $last_insert_id=$this->connection->affected_rows;
            if($last_insert_id){
                return $this->show_update_comment($post_id);
            }else{
                return false;
            }
        }
        
        public function show_update_comment($post_id=null){
            $post_id=intval($post_id);
            $sql="SELECT P.post_id as P_postid,Uimg.image, PC.*, PC.user_id as PC_user_id,PC.post_id as PC_postid,CL.user_id as CL_user_id,CL.post_id AS CL_postid,SUM(CL.comment_like) AS comment_like,U.user_id AS U_userid,U.fname as fname, u.uname as uname,CR.reply_id,CR.reply FROM post_comment PC LEFT JOIN user U ON PC.user_id=U.user_id LEFT JOIN user_image UImg ON UImg.user_id=U.user_id LEFT JOIN post_data P On P.post_id=PC.post_id LEFT JOIN comment_like CL ON CL.comment_id=PC.comment_id LEFT JOIN comment_reply CR ON CR.post_id=PC.post_id AND CR.comment_id=PC.comment_id WHERE P.post_id=? GROUP BY PC.comment_id ORDER BY PC.comment_id DESC LIMIT 1";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                     $html.='<div class="comment-box">';
                     while($data=$result->fetch_assoc()){
                     $html.='<div class="fcb">';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img com-in-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost user-com-cont">';
                     $html.='<strong><a href="profile?uname='.$data['uname'].'">'.ucwords($data['fname']).'</a></strong> ';
                     $html.='<div class="c-data-con"> ';
                     $html.='<div class="c-f-d">'.date("d-m-Y H:i:sa", strtotime($data['comment_date'])).'</div>';
                     $html.='<span class="c-s-d" > '.date("d-m-Y", strtotime($data['comment_date'])).'</span>';
                     $html.='</div>';
                     $html.='<div class="comment-cont-text">';
                     $comment_text=explode("\\r\\n", $data['comment']);
                        $len=count($comment_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$comment_text[$i]."<br />";
                        }
                     $html.='</div>';
                     $html.='<div class="comment-like">';
                     $html.='<div class="c-like-c" id="c-like-c_'.$data['comment_id'].'">';
                      if(!$data['comment_like']){
                     $html.='<a onClick="commentLike('.$data['comment_id'].','.$post_id.')"  class="empty com-like"><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$data['comment_id'].'"></span></a>';                      
                     }
                     elseif($data['comment_like']){
                     $html.='<a class="com-like" onClick="commentLike('.$data['comment_id'].','.$post_id.')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$data['comment_id'].'">'.$this->count_comment_like($post_id,$data['comment_id']).'</span></a>';
                     }
                     $html.='</div>';
                     $html.='<a onClick="openReply(event,\''.ucwords($data['fname']).'\')" class="c-reply-icon" ><span class="r-icon">reply</span></a>';
                    if($_SESSION['user_login']['uname']==$data['uname']){
                        $html.='<a href="#" id="delete-comment" onClick="commentde('.$data['comment_id'].','.$post_id.', \''.$this->csrf_token_r().'\',event)"><i class="fas fa-trash-alt" title="delete!"></i></a>';
                     }
                     $html.='</div>';
                     $html.='<div class="reply-container">';
                     if($data['reply']){
                        $html.=$this->reply($data['comment_id'],$post_id);
                     }
                     else{
                     }
                     $html.="</div>";
                     $html.='</div>';
                     $html.=$this->login_user_for_reply($post_id,$data['comment_id']);
                     $html.='</div>';   
                     }
                     
                     $html.='</div>';
                     return $html;
            }

        }
        public function reply_post_sub($post_id,$comment_id,$commnet_post){
            $user_id=$_SESSION['user_login']['id'];
            $post_id=intval($post_id);
            $comment_id=intval($comment_id);
            $sql="INSERT INTO `comment_reply`(`reply`, `post_id`, `user_id`, `comment_id`) VALUES (?,?,?,?)";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("siii",$commnet_post,$post_id,$user_id,$comment_id);
            $stmt->execute();
            $last_insert_id=$this->connection->affected_rows;
            if($last_insert_id){
                return $this->show_update_reply($post_id,$comment_id);
            }else{
                return false;
            }
        }
        public function show_update_reply($post_id=null,$comment_id=null){
            $post_id=intval($post_id);
            $sql="SELECT CR.reply,CR.reply_date,CR.reply_id ,U.uname,U.fname,RL.reply_like,Uimg.image FROM comment_reply CR LEFT JOIN user U ON U.user_id=CR.user_id LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id LEFT JOIN reply_like RL ON CR.reply_id=RL.reply_id WHERE CR.post_id=? AND CR.comment_id=? GROUP BY CR.reply_id ORDER by CR.reply_id DESC LIMIT 1;";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$post_id,$comment_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                    $html.='<div class="user-reply">';
                     $html.='<div class="comment-box">';
                     while($data=$result->fetch_assoc()){
                     $html.='<div class="fcb">';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img com-in-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost user-com-cont">';
                     $html.='<strong><a href="profile?uname='.$data['uname'].'">'.ucwords($data['fname']).'</a></strong> ';
                     $html.='<div class="c-data-con"> ';
                     $html.='<div class="c-f-d">'.date("d-m-Y H:i:sa", strtotime($data['reply_date'])).'</div>';
                     $html.='<span class="c-s-d" > '.date("d-m-Y", strtotime($data['reply_date'])).'</span>';
                     $html.='</div>';
                     $html.='<div class="comment-cont-text">';
                     $comment_text=explode("\\r\\n", $data['reply']);
                        $len=count($comment_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$comment_text[$i]."<br />";
                        }
                     $html.='</div>';
                     $html.='<div class="reply-like">';
                     $html.='<div class="r-like-c" id="r-like-c_'.$data['reply_id'].'">';
                    if(!$data['reply_like']){
                     $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$data['reply_id'].')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c"></span></a>';                      
                     }
                     elseif($data['reply_like']){
                    $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$data['reply_id'].')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c">'.$this->count_reply_like($post_id,$comment_id,$data['reply_id']).'</span></a>';                   
                     }
                     $html.="</div>";
                     $html.='<a onClick="openReply(event,\''.ucwords($data['fname']).'\')" class="c-reply-icon"><span class="r-r-icon">reply</span></a>';
                     if($_SESSION['user_login']['uname']==$data['uname']){
                        $html.='<a href="#" id="delete-comment" onClick="replyde('.$data['reply_id'].','.$comment_id.','.$post_id.', \''.$this->csrf_token_r().'\',event)"><i class="fas fa-trash-alt" title="delete!"></i></a>';
                    }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='</div>';
                     }
                     
                     $html.='</div>';
                     $html.='</div>';
                     return $html;
            }

        }
        //this is showing comment for particular post
        public function show_comment($post_id=null){
            $post_id=intval($post_id);
            $sql="SELECT P.post_id as P_postid,Uimg.image, PC.*, PC.user_id as PC_user_id,PC.post_id as PC_postid,CL.user_id as CL_user_id,CL.post_id AS CL_postid,SUM(CL.comment_like) AS comment_like,U.user_id AS U_userid,U.fname as fname, u.uname as uname,CR.reply_id,CR.reply FROM post_comment PC LEFT JOIN user U ON PC.user_id=U.user_id LEFT JOIN user_image UImg ON UImg.user_id=U.user_id LEFT JOIN post_data P On P.post_id=PC.post_id LEFT JOIN comment_like CL ON CL.comment_id=PC.comment_id LEFT JOIN comment_reply CR ON CR.post_id=PC.post_id AND CR.comment_id=PC.comment_id WHERE P.post_id=? GROUP BY PC.comment_id ORDER BY PC.comment_id DESC LIMIT 5";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $html.='<div class="f-comm-cont">';
                $html.="<div class='comment-cont' id='comment-container'>";
                $html.='<div class="inner-c-cont">';
                while ($data=$result->fetch_assoc()) {
                    if(!$data['comment']){
                     $html.='</div>';
                     //this is show reply/comment section of login indiviual user
                     $html.=$this->login_user_for_comment($post_id) ;      
                     $html.='</div>';
                     $html.="</div>";
                    }elseif($data['comment']){      
                     $html.='<div class="comment-box">';
                     $html.='<div class="fcb">';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img com-in-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost user-com-cont">';
                     $html.='<strong><a href="profile?uname='.$data['uname'].'">'.ucwords($data['fname']).'</a></strong> ';
                     $html.='<div class="c-data-con"> ';
                     $html.='<div class="c-f-d">'.date("d-m-Y H:i:sa", strtotime($data['comment_date'])).'</div>';
                     $html.='<span class="c-s-d" > '.date("d-m-Y", strtotime($data['comment_date'])).'</span>';
                     $html.='</div>';
                     $html.='<div class="comment-cont-text">';
                     $comment_text=explode("\\r\\n", $data['comment']);
                        $len=count($comment_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$comment_text[$i]."<br />";
                        }
                     $html.='</div>';
                     $html.='<div class="comment-like">';
                     $html.='<div class="c-like-c" id="c-like-c_'.$data['comment_id'].'">';
                      if(!$data['comment_like']){
                     $html.='<a onClick="commentLike('.$data['comment_id'].','.$post_id.')"  class="empty com-like"><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$data['comment_id'].'"></span></a>';                      
                     }
                     elseif($data['comment_like']){
                     $html.='<a class="com-like" onClick="commentLike('.$data['comment_id'].','.$post_id.')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$data['comment_id'].'">'.$this->count_comment_like($post_id,$data['comment_id']).'</span></a>';
                     }
                     $html.='</div>';
                     $html.='<a onClick="openReply(event,\''.ucwords($data['fname']).'\')" class="c-reply-icon" ><span class="r-icon">reply</span></a>';
                    if($_SESSION['user_login']['uname']==$data['uname']){
                        $html.='<a href="#" id="delete-comment" onClick="commentde('.$data['comment_id'].','.$post_id.', \''.$this->csrf_token_r().'\',event)"><i class="fas fa-trash-alt" title="delete!"></i></a>';
                     }
                     $html.='</div>';
                     $html.='<div class="reply-container">';
                     if($data['reply']){
                        $html.=$this->reply($data['comment_id'],$post_id);
                     }
                     else{
                     }
                     $html.="</div>";
                     $html.='</div>';
                     //this is for online user reply of individual
                     $html.=$this->login_user_for_reply($post_id,$data['comment_id']);
                     $html.='</div>';
                     $html.='</div>';
                     
                    }               
                }
                     $html.='</div>';

                     $html.=$this->login_user_for_comment($post_id);
                     $html.='</div>';
                     $html.="</div>";


                }
                elseif($result->num_rows==0){
                $html.='<div class="f-comm-cont">';
                $html.="<div class='comment-cont' id='comment-container'>";
                $html.='<div class="inner-c-cont">';
                $html.="</div>";
                $html.=$this->login_user_for_comment($post_id);
                $html.='</div>';
                $html.="</div>";

                }
                return $html;
            }
        public function login_user_for_comment($post_id=null){
            $user_id=$_SESSION['user_login']['id'];
            $post_id=intval($post_id);
            $sql="SELECT U.*, UImg.* FROM user U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$user_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                    $data=$result->fetch_assoc();
                     $html.='<div class="comment-box login-user">';
                     $html.='<div class="log-user-com" >';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost">';
                     $html.='<form  enctype="multipart/form-data" class="comment-form" onSubmit="commentForm(event,this)">';
                     $html.='<input type="hidden" name="post_id" class="post_id" value="'.$post_id.'">';
                     $html.="<input type='hidden' name='csrf' value=".$this->csrf_token()." />";
                     $html.='<textarea spellcheck="no" class="com-text" name="commnet-post" placeholder="Write comment.."></textarea>';
                     $html.='<button type="submit" class="com-post-btn"><i class="fas fa-play"></i></button>';
                     $html.='</form>';   
                     $html.='</div>';    
                     $html.='</div>';
                     $html.='</div>';
                     return $html;
                    
            }
        }
        public function login_user_for_reply($post_id=null,$comment_id=null){
            $user_id=$_SESSION['user_login']['id'];
            $post_id=intval($post_id);
            $sql="SELECT U.*, UImg.* FROM user U LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id WHERE U.user_id=?";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$user_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                    $data=$result->fetch_assoc();
                     $html.='<div class="comment-box login-user reply-box">';
                     $html.='<div class="log-user-com" >';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost">';
                     $html.='<form  enctype="multipart/form-data" class="reply-form" onSubmit="replyForm(event,this)">';
                     $html.='<input type="hidden" class="post_id" name="post_id" value="'.$post_id.'">';
                     $html.='<input type="hidden" name="comment_id" value="'.$comment_id.'">';
                     $html.="<input type='hidden' name='csrf' value=".$this->csrf_token()." />";
                     $html.='<textarea spellcheck="no" class="com-text" name="commnet-post" placeholder="Write comment.."></textarea>';
                     $html.='<button type="submit" class="com-post-btn"><i class="fas fa-play"></i></button>';
                     $html.='</form>';   
                     $html.='</div>';    
                     $html.='</div>';
                     $html.='</div>';
                     return $html;
                    
            }
        }
        public function reply($comment_id=null,$post_id=null){
            $sql="SELECT CR.reply,CR.reply_date,CR.reply_id ,U.uname,U.fname,RL.reply_like,Uimg.image FROM comment_reply CR LEFT JOIN user U ON U.user_id=CR.user_id LEFT JOIN user_image Uimg ON U.user_id=Uimg.user_id LEFT JOIN reply_like RL ON CR.reply_id=RL.reply_id WHERE CR.post_id=? AND CR.comment_id=? GROUP BY CR.reply_id LIMIT 5";
            $html="";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$post_id,$comment_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                    $html.='<div class="user-reply">';
                    while($data=$result->fetch_assoc()){
                    if($data['reply']){      
                     $html.='<div class="comment-box">';
                     $html.='<div class="fcb">';
                     $html.='<div class="comment-col com-uimg">';
                     $html.='<div class="cu-img com-in-img">';
                     if($data['image']){
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/'.$data['image'].'"></a>';
                     }
                     else{
                     $html.='<a href="profile?uname='.$data['uname'].'"><img src="dataimage/img_avatar.png"></a>';
                     }
                     $html.='</div>';
                     $html.='</div>';
                     $html.='<div class="comment-col com-upost user-com-cont">';
                     $html.='<strong><a href="profile?uname='.$data['uname'].'">'.ucwords($data['fname']).'</a></strong> ';
                     $html.='<div class="c-data-con"> ';
                     $html.='<div class="c-f-d">'.date("d-m-Y H:i:sa", strtotime($data['reply_date'])).'</div>';
                     $html.='<span class="c-s-d" > '.date("d-m-Y", strtotime($data['reply_date'])).'</span>';
                     $html.='</div>';
                     $html.='<div class="comment-cont-text">';
                     $comment_text=explode("\\r\\n", $data['reply']);
                        $len=count($comment_text);
                        for($i=0;$i<$len;$i++){
                        // $post_text=wordwrap($post_text[$i]);
                        $html.=$comment_text[$i]."<br />";
                        }
                     $html.='</div>';
                     $html.='<div class="reply-like">';
                     $html.='<div class="r-like-c" id="r-like-c_'.$data['reply_id'].'">';
                    if(!$data['reply_like']){
                     $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$data['reply_id'].')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c"></span></a>';                      
                     }
                     elseif($data['reply_like']){
                    $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$data['reply_id'].')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c">'.$this->count_reply_like($post_id,$comment_id,$data['reply_id']).'</span></a>';                   
                     }
                     $html.="</div>";
                     $html.='<a onClick="openReply(event,\''.ucwords($data['fname']).'\')" class="c-reply-icon"  ><span class="r-r-icon">reply</span></a>';
                    if($_SESSION['user_login']['uname']==$data['uname']){
                        $html.='<a href="#" id="delete-comment" onClick="replyde('.$data['reply_id'].','.$comment_id.','.$post_id.', \''.$this->csrf_token_r().'\',event)"><i class="fas fa-trash-alt" title="delete!"></i></a>';
                    }

                     $html.='</div>';
                     $html.='</div>';
                     $html.='</div>';
                     $html.='</div>';
                     
                    }   

                    }
                    $html.='</div>';
                    return $html;

            }

        }
        public function comment_count($post_id=null){
            $sql="SELECT COUNT(PC.comment_id) AS comments FROM post_comment AS PC WHERE PC.post_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();

            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['comments'];
            }
        }
        public  function get_last_post_id(){
            $sql="SELECT `post_id` FROM `post_data` ORDER BY `post_id` DESC LIMIT 1";
            $stmt=$this->connection->prepare($sql);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['post_id'];   
            }
        }
        public  function get_last_video_id(){
            $sql="SELECT `post_id` FROM `post_data` WHERE type LIKE '%video%' ORDER BY `post_id` DESC LIMIT 1";
            $stmt=$this->connection->prepare($sql);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['post_id'];   
            }
        }
        public  function get_last_user_id(){
            $sql="SELECT `user_id` FROM `user` ORDER BY `user_id` DESC LIMIT 1";
            $stmt=$this->connection->prepare($sql);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['user_id'];   
            }
        }
        public function reply_count($post_id=null){
            $sql="SELECT COUNT(CR.reply_id) AS replys FROM comment_reply AS CR WHERE CR.post_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();

            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['replys'];
            }
        }
        public function share_count($post_id=null){
            $sql="SELECT COUNT(`share_parent_id`) as shares FROM post_data WHERE share_parent_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();

            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['shares'];
            }
        }
        public function count_comment_like($post_id=null,$comment_id=null){
            $sql="SELECT SUM(`comment_like`) as comment_like FROM `comment_like` WHERE post_id=? AND `comment_id`=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$post_id,$comment_id);
            $stmt->execute();
            $result=$stmt->get_result();

            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['comment_like'];
            }
        }
        public function count_reply_like($post_id=null,$comment_id=null,$reply_id=null){
            $sql="SELECT SUM(`reply_like`) as reply_like FROM `reply_like` WHERE comment_id=? AND post_id=? AND reply_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iii",$comment_id,$post_id,$reply_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data['reply_like'];
            }
        }
        public function csrf_token(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrf']=$random;
            return $random;
        }
        public function csrf_token_a(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfa']=$random;
            return $random;
        }
        public function csrf_token_b(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfb']=$random;
            return $random;
        }
        public function csrf_token_c(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfc']=$random;
            return $random;
        }
        public function csrf_token_d(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfd']=$random;
            return $random;
        }
        public function csrf_token_e(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfe']=$random;
            return $random;
        }
        public function csrf_token_m(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfm']=$random;
            return $random;
        }
         public function csrf_token_n(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfn']=$random;
            return $random;
        }
         public function csrf_token_o(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfo']=$random;
            return $random;
        }
         public function csrf_token_p(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfp']=$random;
            return $random;
        }
         public function csrf_token_q(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfq']=$random;
            return $random;
        }
        public function csrf_token_r(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfq']=$random;
            return $random;
        }
        public function csrf_token_s(){
            $random=bin2hex(random_bytes(32));
            $_SESSION['csrfs']=$random;
            return $random;
        }
        public function comment_status($action,$post_id,$comment_id){
            $user_id=$_SESSION['user_login']['id'];
            $sql="SELECT SUM(comment_like) as liked FROM `comment_like` WHERE post_id=? AND comment_id=? AND user_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iii",$post_id,$comment_id,$user_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data;
            }else{
                return false;
            }

        }
        public function reply_status($action,$post_id,$comment_id,$reply_id){
            $user_id=$_SESSION['user_login']['id'];
            $sql="SELECT SUM(`reply_like`) as liked FROM `reply_like` WHERE comment_id=? AND post_id=? AND reply_id=? AND user_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iiii",$comment_id,$post_id,$reply_id,$user_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data;
            }else{
                return false;
            }

        }
        public function reply_update_like($comment_id,$post_id,$reply_id ,$likes=null){
            $user_id=$_SESSION['user_login']['id'];
            $comment_id=intval($comment_id);
            $post_id=intval($post_id);
            $reply_id=intval($reply_id);
            $sql="";
            if($likes=="decrement"){

                $sql="DELETE FROM `reply_like` WHERE `comment_id`=? AND `reply_id`=? AND `post_id`=? AND `user_id`=?";
            }
            elseif($likes=="increment"){
                $sql="INSERT INTO `reply_like`(`comment_id`, `reply_id`, `post_id`, `user_id`, `reply_like`) VALUES (?,?,?,?,1)";
            }
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iiii",$comment_id,$reply_id,$post_id,$user_id);
            $stmt->execute();
            if($this->connection->affected_rows){
                $row=$this->fetch_updated_reply_like($post_id,$comment_id,$reply_id);
                return $row;
            }
            return false;
        }
        public  function fetch_updated_reply_like($post_id=null,$comment_id=null,$reply_id=null){
            $html="";
            $sql="SELECT SUM(`reply_like`) as reply_like FROM `reply_like` WHERE comment_id=? AND post_id=? AND reply_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iii",$comment_id,$post_id,$reply_id);
            $stmt->execute();
            $result=$stmt->get_result();
            while($data=$result->fetch_assoc()){
                    if(!$data['reply_like']){
                     $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$reply_id.')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c"></span></a>';                      
                     }
                     elseif($data['reply_like']){
                    $html.='<a class="empty r-like" onClick="replyLike('.$comment_id.','.$post_id.','.$reply_id.')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c">'.$data['reply_like'].'</span></a>';                   
                     }  

            }
            return $html;

        }

        public function comment_update_like($comment_id,$post_id ,$likes=null){
            $user_id=$_SESSION['user_login']['id'];
            $comment_id=intval($comment_id);
            $post_id=intval($post_id);
            $sql="";
            if($likes=="decrement"){

                $sql="DELETE FROM `comment_like` WHERE post_id=?  AND user_id=? AND comment_id=?";
            }
            elseif($likes=="increment"){
                $sql="INSERT INTO `comment_like`( `post_id`, `user_id`, `comment_id`, `comment_like`) VALUES (?,?,?,1)";
            }
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("iii",$post_id,$user_id,$comment_id);
            $stmt->execute();
            if($this->connection->affected_rows){
                $row=$this->fetch_updated_comment_like($post_id,$comment_id);
                return $row;
            }
            return false;
        }
        public  function fetch_updated_comment_like($post_id=null,$comment_id=null){
            $html="";
            $sql="SELECT SUM(comment_like) as comment_like FROM `comment_like` WHERE post_id=? AND comment_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$post_id,$comment_id);
            $stmt->execute();
            $result=$stmt->get_result();
            while($data=$result->fetch_assoc()){
                     if(!$data['comment_like']){
                     $html.='<a onClick="commentLike('.$comment_id.','.$post_id.')"  class="empty com-like"><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$comment_id.'"></span></a>';                      
                     }
                     elseif($data['comment_like']){
                     $html.='<a class="com-like" onClick="commentLike('.$comment_id.','.$post_id.')" ><span class="fa-thumbsup c-l-icon">like</span> <span class="c-l-c" id="comment-like_'.$comment_id.'">'.$data['comment_like'].'</span></a>';
                     }              

            }
            return $html;

        }
        public function post_status($action,$post_id){
            $user_id=$_SESSION['user_login']['id'];
            $sql="SELECT SUM(likes) as liked FROM `post_like` WHERE post_id=? AND user_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$post_id,$user_id);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $data=$result->fetch_assoc();
                return $data;
            }else{
                return false;
            }

        }
         public function    update_like($arg ,$likes=null){
            $user_id=$_SESSION['user_login']['id'];
            $post_id=$arg['post_id'];
            $action=$arg['action'];
            $sql="";
            if($likes=="decrement"){
                $sql="DELETE FROM `post_like` WHERE `user_id`=? AND `post_id`=?";
            }
            elseif($likes=="increment"){
                $sql="INSERT INTO `post_like`( `user_id`, `post_id`, `likes`) VALUES (?,?,1)";
            }
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("ii",$user_id,$post_id);
            $stmt->execute();
            if($this->connection->affected_rows){
                $row=$this->fetch_updated_row($post_id);
                return $row;
            }
            return false;
        }
        function fetch_updated_row($post_id){
            $html="";
            $sql="SELECT SUM(likes) as likes FROM `post_like` WHERE post_id=?";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("i",$post_id);
            $stmt->execute();
            $result=$stmt->get_result();
            while($data=$result->fetch_assoc()){
            if($data['likes']){
                     $html.='<a id="like_'.$post_id.'" onClick="likeOrDislike('.$post_id.')"  class="likes"  data-id="'.$post_id.'">';
                     $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                     $html.='<span class="counter">'.$data["likes"].'</span>';
                     $html.='</a>';
            }
            elseif(!$data['likes']){
                     $html.='<a id="like_'.$post_id.'" onClick="likeOrDislike('.$post_id.')" href="" class="likes empty"  data-id="'.$post_id.'">';
                     $html.='<i class="fas fa-thumbs-up"></i> <span class="like-text"> Like</span>';
                     $html.='</a>';
            }
        }
            return $html;

        }
        public function search($str){
            $html="";
            $str="%".$str."%";
            $sql="SELECT * FROM user WHERE fname LIKE ? LIMIT 10";
            $stmt=$this->connection->prepare($sql);
            $stmt->bind_param("s",$str);
            $stmt->execute();
            $result=$stmt->get_result();
            if($result->num_rows){
                $html.='<ul>';
                while($data=$result->fetch_assoc()){
                     $html.='<li><a href="profile?uname='.$data['uname'].'">'.ucwords($data['fname']).'</a></li>';
                }
                $html.="</ul>";
                return $html;
            }
        }
        public  function real_escape($data){
            return $this->connection->real_escape_string(stripslashes(trim(strip_tags($data))));
        }
        public function __construct(activity $log){
            parent::__construct();
            $this->activity=$log;
        }
}


  ?>
    
               
                
                
                    

                               
                
                
                    

                    