<?php
/*
@Author Raja Bose
@Created at 4th April 2017
It just control the connection for a database and close parameter
*/
//include("constant.php");
class DbConnect{

private $con;

//class constructor
public function __construct(){

}

//this method will connect to database
public function connect(){
  include_once dirname(__FILE__).'/constant.php';

 try{
 	 file_put_contents("logfile",DBNAME." ".DBUSERNAME." ".DBPASSWORD." ".HOST."\n",FILE_APPEND);
     $con = new PDO('mysql:host='.HOST.';dbname='.DBNAME, DBUSERNAME, DBPASSWORD);
     $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
     return $con;
}catch(PDOException $e){
  file_put_contents("logfile", $e->getMessage()."\n",FILE_APPEND);	
  //print "Error!:".$e->getMessage(). "</br>";
  echo $e->getMessage();
}

}

}

?>