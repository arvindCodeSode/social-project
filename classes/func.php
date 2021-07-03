<?php
date_default_timezone_set("Asia/kolkata");
require_once 'dbcon.php';
class func extends dbcon{
		private $activity;
		public function show_picture($uname=""){
			$uname=htmlspecialchars(trim(stripslashes($uname)));
			$sql="SELECT P.post_image_text,P.type FROM user U LEFT JOIN post_data P ON P.user_Id=U.user_id WHERE U.uname=? ORDER BY P.`post_id` DESC";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$uname);
			$stmt->execute();
			$result=$stmt->get_result();
			$html="";
			if($result->num_rows>0){
				while($data=$result->fetch_assoc()){
					if(!empty($data['post_image_text'])){
						$type=explode("/", $data['type']);
						if($type[0]=="image"){
						$html.='<div class="all-column"><div class="image"><img class="open-imgs" src="dataimage/'.$data['post_image_text'].'" /></div></div>';
						}elseif($type[0]=="video"){
						$html.='<div class="all-column"><div class="image"><video controls="controls"><source src="dataimage/'.$data['post_image_text'].'" type="'.$data['type'].'" /></video></div></div>';
						}
					}
				}
				return $html;
			}
			return false;
		}
		
		public function show_pic($uname=""){
			$uname=htmlspecialchars(trim(stripslashes($uname)));
			$sql="SELECT Uimg.`image` FROM `user_image` Uimg LEFT JOIN `user` U ON U.`user_id`=Uimg.`user_id` WHERE U.`uname`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$uname);
			$stmt->execute();
			$result=$stmt->get_result();
			$html="";
			if($result->num_rows>0){
				$data=$result->fetch_assoc();
				if($data['image']){
				$html.='<div class="img-column"> <div class="img-column-cont"><a href="all-picture?uname='.$uname.'"><img src="dataimage/'.$data['image'].'" /></a></div><a href="all-picture?uname='.$uname.'">Picture</a></div>';
				}return $html;
			}
			else{
				$html.='<div class="img-column"><div class="img-column-cont">No Picture</div>';
				$html.='<a href="#">Picture</a></div>';
				return $html;
			}
		}
		public function email_availabel($email){
			$msg="";
			$sql="SELECT * FROM user WHERE email=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$stmt->store_result();
			$row=$stmt->num_rows;
			if($row==1){
				return true;
			}else{
				return false;
			}
			$stmt->close();
		}
		public function data_match(){
			$user_id=htmlspecialchars(trim(stripcslashes($_SESSION['user_login']['id'])));
			$sql2="SELECT * FROM `user` WHERE `user_id`=?";
			$stmt2=$this->connection->prepare($sql2);
			$stmt2->bind_param("i",$user_id);
			$stmt2->execute();
			$result=$stmt2->get_result();
			if($result->num_rows > 0){
				$data=$result->fetch_assoc();
					return $data;					
			}else{
				return false;
			}
		}
		public function delete_data($email,$uname,$password){
			$user_id=$_SESSION['user_login']['id'];
			$sql="DELETE FROM `user` WHERE `email`=? AND `uname`=? AND `user_id`=? AND `password`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("sssi",$email,$uname,$user_id,$password);
			$stmt->execute();
			if($this->connection->affected_rows){
				$this->activity->log("User Delete: ".$email." ".$uname." ".$user_id." Delete at ".date("d-m-Y H:i:sa")."\r\n");

				return true;
			}else{
				return false;
			}

		}
		public function uname_availabel($uname){
			$msg="";
			$sql="SELECT * FROM user WHERE uname=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$uname);
			$stmt->execute();
			$stmt->store_result();
			$row=$stmt->num_rows;
			if($row==1){
				return true;
			}else{
				return false;
			}
			$stmt->close();
		}
		public function register($fname,$uname,$email,$password,$cpassword,$token,$ip){
			$cpassword=crypt($cpassword,"$6$6000$");
			$join_date=date("Y-m-d H:i:s");
			$status=0;
			$sql1="INSERT INTO `user`(`fname`, `email`, `uname`, `password`,`token`, `status`, `join_date`,`ip`) VALUES (?,?,?,?,?,?,?,?)";
			$stmt1=$this->connection->prepare($sql1);
			$stmt1->bind_param("ssssssss",$fname,$email,$uname,$cpassword,$token,$status,$join_date,$ip);
			$stmt1->execute();
			$last_insert_id=$this->connection->insert_id;
			if($last_insert_id){
				$_SESSION['lastId']=$last_insert_id;
			$this->activity->log("User ".$fname." email ".$email." Created at::-".date("d-m-Y H:i:sa \r\n"));
				return $last_insert_id;
			}
			else{
				return false;
			}
			$stmt1->close();

		}
		public function login($email,$password){
			$password=crypt($password,"$6$6000$");
			$sql2="SELECT U.*,Uimg.profile_image, Uimg.image FROM `user` U LEFT JOIN `user_image` Uimg  ON U.user_id=Uimg.user_id WHERE `email`=? OR `uname`=? OR `mobile`=?";
			$stmt2=$this->connection->prepare($sql2);
			$stmt2->bind_param("sss",$email,$email,$email);
			$stmt2->execute();
			$result=$stmt2->get_result();
			if($result->num_rows > 0){
				$data=$result->fetch_assoc();

				if($data['password']==$password){
					$this->activity->log("User Login: ".ucwords($data['fname'])." $email Login at ".date("d-m-Y H:i:sa")."\r\n");
					return $data;					
				}else{
					return false;
				}

			}else{return false;}

		}
		public function logout(){
			if(isset($_SESSION['user_log']['name'])){
			$this->activity->log("User Logout: ".$_SESSION['user_log']['name']." ".$_SESSION['user_log']['email']."::Logout at ".date("d-m-Y H:i:sa")."\r\n");
			$_SESSION['user_log']="";
			unset($_SESSION['user_log']);
			header("Location:login");}
			elseif(isset($_SESSION['user_login']['name'])){
			$this->activity->log("User Logout: ".$_SESSION['user_login']['name']." ".$_SESSION['user_login']['email']."::Logout at ".date("d-m-Y H:i:sa")."\r\n");
			$_SESSION['user_login']="";
			unset($_SESSION['user_login']);
			header("Location:login");}
		}
		public function profile($uname,$user_bio=null){
			$html="";
			$sql="SELECT Uimg.*,U.* FROM user_image Uimg RIGHT JOIN user U on U.user_id=Uimg.user_id WHERE U.uname=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$uname);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows==1){
				$data=$result->fetch_assoc();
				$html.='<div class="user-profile-c">';
				$html.='<!--top profile image-->';
				$html.='<div class="user-profile-b-img">';
				if(!$data['profile_image']){
				$html.='<img class="open-imgs" alt="'.ucwords($data['fname']).'" src="dataimage/img_snow.jpg" id="user-cover-image">';
				}
				else{
				$html.='<img   class="open-imgs" alt="'.ucwords($data['fname']).'"  src="dataimage/'.$data['profile_image'].'" id="user-cover-image">';
				}
				$html.='</div>';
				$html.='<!--center image name username date-->';
				$html.='<div class="user-image">';
				$html.='<div class="user-img">';
				if($_SESSION['user_login']['uname']==$data['uname']){
				$html.='<button class="open-image" id="open-image-form" title="upload image!"><i class="fas fa-image"></i></button>';
				}
				if(!$data['image']){
				$html.='<img  class="open-imgs" alt="'.ucwords($data['fname']).'"  src="dataimage/img_avatar.png" id="user-pro-image">';
				}
				else{
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
					$html.='<img  class="open-imgs" alt="'.ucwords($data['fname']).'"  src="dataimage/'.$data['image'].'" id="user-pro-image">';
					}else{
					$html.='<img  class="open-imgs" alt="'.ucwords($data['fname']).'" height="100%"  src="dataimage/'.$data['image'].'" id="user-pro-image">';
					}
				}
				$html.='</div>';
				$html.='<div class="user-name">';
				$html.='<span class="name">'.ucwords($data['fname']).'</span><br>';
				$html.='<span>'.$data['uname'].'</span>';
				$html.='<div class="join"><br>';
				$html.='<div class="join-date join-d">';
				$html.='<span>Join Date '.date("d-m-Y", strtotime($data['join_date'])).'</span>';
				$html.='</div>';
				$html.='</div>';
				$html.='<hr>';
				$html.='<div class="user-description">';
				$html.='<div class="fetch-bio">';
				if(!$data['user_bio']){
				}
				else{
					$user_bioa=explode("\\r\\n", $data['user_bio']);
					$length=count($user_bioa);
					for($i=0;$i<$length;$i++){
// $user_bioa=wordwrap($user_bioa[$i],14);
$html.=$user_bioa[$i]."<br />";
					}
				}
$html.='</div>';

				if($data['location']){
				$html.="<div class='from'>From: ".$data['location']."</div>";					
				}
				if($data['profession']){
				$html.="<div class='work'>Works as: ".$data['profession']."</div>";					
				}
				$html.='</div>';
				$html.='</div>';
				$html.='<hr>';
				$html.='</div>';
				if($_SESSION['user_login']['uname']==$data['uname']){
				$html.='<button class="open-pro-form" id="open-pro-form" title="upload profile image!"><i class="fas fa-image"></i></button>';
				}
				$html.='<!--center image name username date end-->';
				$html.='</div>';
				echo  $html;
			}
		}
		public function old_password($password,$user_id,$uname){
			$password=crypt($password,"$6$6000$");
			$sql="SELECT * FROM `user` WHERE password=?  AND `user_id`=? AND `uname`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("sis",$password,$user_id,$uname);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}
		public function old_username($user_id,$uname){
			$sql="SELECT * FROM `user` WHERE `user_id`=? AND `uname`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("is",$user_id,$uname);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				return true;
			}else{
				return false;
			}
		}

		public function change_password($password,$username,$user_id){
			$user_id=intval($user_id);
			$password=crypt($password,"$6$6000$");
			$sql="UPDATE `user` SET `password`=? WHERE `user_id`=? AND `uname`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("sis",$password,$user_id,$username);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
			
		}
		public function change_username($username,$user_id){
			$sql="UPDATE `user` SET `uname`=? WHERE `user_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("si",$username,$user_id);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
			
		}
		public function upload($image,$user_id,$type,$action){
			$sql="SELECT * FROM `user_image_p` WHERE user_id=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("i",$user_id);
			$stmt->execute();
			$result=$stmt->get_result();

			if($result->num_rows==0){
				if($action=="a"){
					$sql1="INSERT INTO `user_image_p`(`user_id`,`image`,`type1`) VALUES (?,?,?)";
				}elseif($action=="b"){
					$sql1="INSERT INTO `user_image_p`(`user_id`, `profile_image`,`type1`) VALUES (?,?,?)";
				}
				$stmt1=$this->connection->prepare($sql1);
				$stmt1->bind_param("iss",$user_id,$image,$type);
				$stmt1->execute();
				if($this->connection->affected_rows){
					return true;
				}else{
					return false;
				}

			}elseif($result->num_rows>0){
				if($action=="a"){
					$sql1="UPDATE `user_image_p` SET  `image`=? , `type1`=? WHERE `user_id`=?";
				}elseif($action=="b"){
					$sql1="UPDATE `user_image_p` SET `profile_image`=? , `type1`=? WHERE `user_id`=?";
				}
				$stmt1=$this->connection->prepare($sql1);
				$stmt1->bind_param("ssi",$image,$type,$user_id);
				$stmt1->execute();
				if($this->connection->affected_rows){
					return true;
				}else{
					return false;
				}
			}
		}
		public function image_upload($image,$user_id,$type,$action){
			$sql="SELECT * FROM `user_image` WHERE user_id=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("i",$user_id);
			$stmt->execute();
			$result=$stmt->get_result();

			if($result->num_rows==0){
				if($action=="img"){
					$sql1="INSERT INTO `user_image`(`user_id`,`image`,`type1`) VALUES (?,?,?)";
				}elseif($action=="pro"){
					$sql1="INSERT INTO `user_image`(`user_id`, `profile_image`,`type1`) VALUES (?,?,?)";
				}
				$stmt1=$this->connection->prepare($sql1);
				$stmt1->bind_param("iss",$user_id,$image,$type);
				$stmt1->execute();
				if($this->connection->affected_rows){
					return true;
				}else{
					return false;
				}

			}elseif($result->num_rows>0){
				if($action=="img"){
					$sql1="UPDATE `user_image` SET  `image`=? , `type1`=? WHERE `user_id`=?";
				}elseif($action=="pro"){
					$sql1="UPDATE `user_image` SET `profile_image`=? , `type1`=? WHERE `user_id`=?";
				}
				$stmt1=$this->connection->prepare($sql1);
				$stmt1->bind_param("ssi",$image,$type,$user_id);
				$stmt1->execute();
				if($this->connection->affected_rows){
					return true;
				}else{
					return false;
				}
			}
		}
		public function update($fname,$mobile=null,$user_bio=null,$location=null,$profession=null,$user_id){
			$sql="UPDATE `user` SET `fname`=?, `mobile`=?, `user_bio`=?, `location`=?, `profession`=?  WHERE `user_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("sisssi",$fname,$mobile,$user_bio,$location,$profession,$user_id);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
		}
		public function post_owner($post_id=null){
			$sql="SELECT `user_Id` FROM `post_data` WHERE `post_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("i",$post_id);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				return $result->fetch_assoc();
			}else{
				return false;
			}
		}
		public function comment_owner($comment_id=null,$post_id=null){
			$sql="SELECT `user_id` FROM `post_comment` WHERE `comment_id`=? AND `post_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("ii",$comment_id,$post_id);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				return $result->fetch_assoc();
			}else{
				return false;
			}
		}
		public function reply_owner($reply_id=null,$comment_id=null,$post_id=null){
			$sql="SELECT `user_id` FROM `comment_reply` WHERE `reply_id`=? AND `comment_id`=? AND `post_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("iii",$reply_id,$comment_id,$post_id);
			$stmt->execute();
			$result=$stmt->get_result();
			if($result->num_rows>0){
				return $result->fetch_assoc();
			}else{
				return false;
			}
		}
		public function post_delete($post_id=null){
			$user_id=$_SESSION['user_login']['id'];
			$sql="DELETE  FROM `post_data` WHERE `post_id`=? AND `user_Id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("ii",$post_id,$user_id);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
		}
		public function comment_delete($comment_id=null,$post_id=null){
			$user_id=$_SESSION['user_login']['id'];
			$sql="DELETE  FROM `post_comment` WHERE `comment_id`=? AND `user_id`=? AND `post_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("iii",$comment_id,$user_id,$post_id);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
		}
		public function reply_delete($reply_id=null,$comment_id=null,$post_id=null){
			$user_id=$_SESSION['user_login']['id'];
			$sql="DELETE  FROM `comment_reply` WHERE `reply_id`=? AND `user_id`=? AND `comment_id`=? AND `post_id`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("iiii",$reply_id,$user_id,$comment_id,$post_id);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;
			}else{
				return false;
			}
		}
		public function fetch($token=""){
			$sql="UPDATE `user` SET `status`=1 WHERE `token`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$token);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;;
			}
			return false;
		}
		public function fetch_email($email=""){
			$sql="SELECT * FROM `user` WHERE `email`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("s",$email);
			$stmt->execute();
			$result=$stmt->get_result();
			return $result;
		}
		public function reset_password($password,$id,$email){
			$password=crypt($password,"$6$6000$");
			$sql="UPDATE `user` SET `password`=? WHERE `user_id`=? AND `email`=?";
			$stmt=$this->connection->prepare($sql);
			$stmt->bind_param("sis",$password,$id,$email);
			$stmt->execute();
			if($this->connection->affected_rows){
				return true;;
			}
			return false;
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