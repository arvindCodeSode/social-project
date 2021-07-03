<?php
class validation{
	public function field_check($data,$field){
		$msg='';
		foreach ($field as $value) {
			if(empty($data[$value])){
				$msg.="$value is empty<br />";
			}
		}
		return $msg;
	}
	public function field_check_ajax($data,$field){
		$msg='';
		foreach ($field as $value) {
			if(empty($data[$value])){
				$msg.="$value is empty\r\n";
			}
		}
		return $msg;
	}
	public function fname_check($fname){
		if((strlen($fname)<=50)){
			return true;
		}elseif(preg_match("/^[a-zA-Z\s]+$/", $fname)){
			return true; 
		}else{
			return false;
		}
	}
	public function mobile_check($mobile){
		if((strlen($mobile)<=10) || (strlen($mobile)>9)){
			return true;
		}elseif(preg_match("/^[0-9]+$/", $mobile)){
			return true; 
		}else{
			return false;
		}
	 }
	public function email_check($email){
		if(preg_match("/^[a-zA-Z]+(\.|_)?[a-zA-Z0-9]*@[a-zA-Z0-9]*[a-zA-Z]\.[a-z]{2,4}$/", $email)){
			return true;
		}else{
			return false;
		}
	 }
	 public function uname_check($uname){
		if(strlen($uname)>2){
			return true;
		}else{
			return false;
		}
	 }
	public function password_check($password){
		if(strlen($password)>=6){
			return true;
		}else{
			return false;
		}
	 }
	 public function user_bio($user_bio){
	 	if(strlen($user_bio) <= 250){
	 		return true;
	 	}else{
	 		return false;
	 	}
	 }
	 public function field($field){
	 	if(strlen($field) <= 50){
	 		return true;
	 	}else{
	 		return false;
	 	}
	 }

}
?>