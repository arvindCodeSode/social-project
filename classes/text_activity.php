<?php
class text_activity implements activity{
	public function log($activity){
		file_put_contents("../user/user_activity.txt", $activity, FILE_APPEND);
	}
}
?>