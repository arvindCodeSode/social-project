<?php
date_default_timezone_set("Asia/kolkata");
require_once 'dbcon.php';
class user_info extends dbcon{
		private $activity;
    public function contact($fname,$mobile,$email,$subject,$description,$ip=null){
      $sql="INSERT INTO `contact`( `name`, `mobile`, `emailid`, `subject`,`description`,`ip`) VALUES (?,?,?,?,?,?)";
      $stmt=$this->connection->prepare($sql);
      $stmt->bind_param("sisssi",$fname,$mobile,$email,$subject,$description,$ip);
      $stmt->execute();
      if($this->connection->insert_id){
        return true;
      } 
      return false;
    }
   public function suggestion($fname,$image,$type,$subject,$ip=null){
      $sql="INSERT INTO `suggest`(`name`,  `suggest`, `image`, `type`, `ip`) VALUES (?,?,?,?,?)";
      $stmt=$this->connection->prepare($sql);
      $stmt->bind_param("ssssi",$fname,$subject,$image,$type,$ip);
      $stmt->execute();
      if($this->connection->insert_id){
        return true;
      } 
      return false;
    }
    public function report($fname,$image,$type,$report,$ip=null){
      $sql="INSERT INTO `report`(`name`, `image`, `type`, `report`, `ip`) VALUES (?,?,?,?,?)";
      $stmt=$this->connection->prepare($sql);
      $stmt->bind_param("ssssi",$fname,$image,$type,$report,$ip);
      $stmt->execute();
      if($this->connection->insert_id){
        return true;
      } 
      return false;
    }
    public function show_sug(){
      $sql="SELECT * FROM `suggest`";
      $stmt=$this->connection->prepare($sql);
      $stmt->execute();
      $html="";
      $result=$stmt->get_result();
      if($result->num_rows>0){
          $html.='<table><caption>Suggestion:</caption><tr><th>Id</th><th>Name</th><th>Subject</th><th>Action</th></tr>';
        while($data=$result->fetch_assoc()){
          $html.='<tr>
          <td>'.$data['suggestId'].'</td><td>'.$data['name'].'</td><td>'.$data['suggest'].'</td><td><a href="suggestId='.$data['suggestId'].'">Delete</a></td></tr>';
        }
        $html.='</table>';
        return $html;
      }
      return false;
    }
    public function show_contact(){
      $sql="SELECT * FROM `contact`";
      $stmt=$this->connection->prepare($sql);
      $stmt->execute();
       $html="";
      $result=$stmt->get_result();
      if($result->num_rows>0){
          $html.='<table><caption>Suggestion:</caption><tr><th>Id</th><th>Name</th><th>Mobile</th><th>Eamil</th><th>Subject</th><th>Action</th></tr>';
        while($data=$result->fetch_assoc()){
          $html.='<tr>
          <td>'.$data['contactId'].'</td><td>'.$data['name'].'</td><td>'.$data['mobile'].'</td><td>'.$data['emailid'].'</td><td>'.$data['subject'].'</td><td><a href="contactId='.$data['contactId'].'">Delete</a></td></tr>';
        }
        $html.='</table>';
        return $html;
      }
      return false;
    }
    public function show_report(){
      $sql="SELECT * FROM `report`";
      $stmt=$this->connection->prepare($sql);
      $stmt->execute();
      $html="";
      $result=$stmt->get_result();
      if($result->num_rows>0){
          $html.='<table><caption>Suggestion:</caption><tr><th>Id</th><th>Name</th><th>Image</th><th>Report</th><th>Action</th></tr>';
        while($data=$result->fetch_assoc()){
          $html.='<tr>
          <td>'.$data['reportId'].'</td><td>'.$data['name'].'</td><td><img class="report-img open-imgs" src="image/'.$data['image'].'" /></td><td>'.$data['report'].'</td><td><a href="reportId='.$data['reportId'].'">Delete</a></td></tr>';
        }
        $html.='</table>';
        return $html;
      }
      return false;
    }
    public function admin_login($email,$password){
      $password=crypt($password,"$6$6000$");
      $sql2="SELECT * FROM `admin` WHERE `email`=? AND  `password`=?";
      $stmt2=$this->connection->prepare($sql2);
      $stmt2->bind_param("ss",$email,$password);
      $stmt2->execute();
      $result=$stmt2->get_result();
      if($result->num_rows > 0){
        $data=$result->fetch_assoc();

        if($data['password']==$password){
          $this->activity->log("Admin Login: ".$data['name']." $email Login at ".date("d-m-Y H:i:sa")."\r\n");
          return $data;         
        }else{
          return false;
        }

      }else{return false;}

    }
		public function __construct(activity $log){
			parent::__construct();
			$this->activity=$log;
		}
}

?>