<?php
class dbcon{
	const host='localhost';
	const user='root';
	const password='';
	const dbname='nazriya';
	protected $connection;
	// public function __construct(){
	// 	if(!isset($this->connection)){
	// 		$this->connection=new mysqli(self::host,self::user,self::password,self::dbname);
	// 		if(!$this->connection){
	// 			die('Cannot connect');
	// 		}
	// 	}
	// 	return $this->connection;
	// }
	public function __construct(){
		$this->connection=mysqli_init();
		if(!$this->connection){
			die("Cannot connect");
		}
		if(!mysqli_real_connect($this->connection,self::host,self::user,self::password,self::dbname)){
			die("Connect Error:");
		}
		$this->connection->set_charset("utf8");
		return $this->connection;
	}
}
?>