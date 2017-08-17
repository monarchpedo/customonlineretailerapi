<?php
/*
@Author Raja Bose
@Created at 4th august 2017
it is used to store the new user and update the uesr properties
*/
//include("connection.php");
class SignUp{
	  private $username;
    private $email;
    private $mobileNumber;
    private $userId;
    private $userType; 
    private $createdDate;
    private $modifiedData;
    private $con;

 public function __construct(){
 	   include_once dirname(__FILE__).'/connection.php';
 	   $db =  new DbConnect();
     try{ 
 	   $this->con = $db->connect();
     //file_put_contents("logfile", $this->con."\n",FILE_APPEND);
   }catch(Exception $e){
     //file_put_contents("logfile", $app->request->post($fields)."\n",FILE_APPEND)
     throw new Exception($e);
     
   }
 	   //$this->username = $array['username'];
       //$this->email = $array['email'];
       //$this->mobileNumber = $array['mobileNumber'];
       //$this->password = $array['password'];
       //$this->userId = $array["userId"];
       //$this->userType = $array["userType"];
   }
 

 public function saveUser($username,$email,$password,$mobileNumber,$userType){
   $insertQuery = "insert into userdetail(username,email,password,mobileNumber,createdDate,modifiedDate,userType) values(:username,:email,:password,:mobileNumber,:createdDate,:modifiedDate,:userType)";
   try{
   	 $emailCheck = $this->checkEmailExits($email); 
   	 $oldEmailCheck = $this->checkEmailInOldData($email);
   	 if($emailCheck["count"]>=1 || $oldEmailCheck["count"]>=1){
   	 	return 1;
   	 }
     $phoneCheck = $this->checkNumberExist($mobileNumber);
     $oldPhoneCheck =  $this->checkNumberInOldData($mobileNumber);
     if($phoneCheck["count"]>=1 || $oldPhoneCheck["count"]>=1){
     	return 1;
     }

     $time = date('Y-m-d H:i:s');
     $preparedQuery = $this->con->prepare($insertQuery);
     $preparedQuery->bindParam(":username",$username,PDO::PARAM_STR);
     $preparedQuery->bindParam(":email",$email,PDO::PARAM_STR);
     $preparedQuery->bindParam(":mobileNumber",$mobileNumber,PDO::PARAM_STR);
     $preparedQuery->bindParam(":password",$password,PDO::PARAM_STR);
     $preparedQuery->bindParam(":createdDate",$time,PDO::PARAM_STR);
     $preparedQuery->bindParam(":modifiedDate",$time,PDO::PARAM_STR);
     $preparedQuery->bindParam(":userType",$userType,PDO::PARAM_STR);
     $preparedQuery->execute();
     $result = $this->con->lastInsertId();
     file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
     return $result;
   }catch(PDOException $e){
   	 file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
   }
 }


 public function checkUserExist(){
  
 }


 public function checkNumberExist($mobileNumber){
   $query = "select count(*) as count from userdetail where mobileNumber = :mobileNumber";
   try{
    $preparedQuery = $this->con->prepare($query);
    $preparedQuery->bindParam(":mobileNumber",$mobileNumber);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
    return $result;
 }catch(Exception $e){
 	 file_put_contents("logfile", $e->getMessage()."\n",FILE_APPEND);
  }
 }

 public function checkEmailExits($email){
  $query = "select count(*) as count from userdetail where  email = :email";
  try{
    $preparedQuery = $this->con->prepare($query);
    $preparedQuery->bindParam(":email",$email);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
    return $result;
 }catch(Exception $e){
 	 file_put_contents("logfile", $e->getMessage()."\n",FILE_APPEND);
 }
 }

public  function checkEmailInOldData($email){
 	$query = "select count(*) as count from old_user_data where email = :email";
 try{	
 	$preparedQuery = $this->con->prepare($query);
 	$preparedQuery->bindParam(":email",$email);
 	$preparedQuery->execute();
 	$result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
  file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
 	return $result;
 }catch(Exception $e){
 	file_put_contents("logfile",$e->getMessage()."\n");
 }
 }

 public function checkNumberInOldData($mobileNumber){
 	$query = "select count(*) as count from old_user_data where mobileNumber = :mobileNumber";
 try{	
 	$preparedQuery = $this->con->prepare($query);
 	$preparedQuery->bindParam(":mobileNumber",$mobileNumber);
 	$preparedQuery->execute();
 	$result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
  file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
 	return $result;
 }catch(Exception $e){
 	file_put_contents("logfile",$e->getMessage()."\n");
 }
 }


 public function getUserByUserId($userId){

 	$query = "select * from userdetail where userId = :userid";
 try{	
 	$preparedQuery = $this->con->prepare($query);
 	$preparedQuery->bindParam(":userid",$userId);
 	$preparedQuery->execute();
 	$result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
  file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
 	return $result;
 }catch(Exception $e){
 	file_put_contents("logfile",$e->getMessage()."\n");
 }
 }

 public function deleteUser($userId){
 	$query = "delete from userdata where userid = :userid";
 try{	
 	$preparedQuery = $this->con->prepare($query);
 	$preparedQuery->bindParam(":userid",$userId);
 	$result = $preparedQuery->execute();
 	return $result;
 }catch(Exception $e){
 	file_put_contents("logfile",$e->getMessage()."\n");
 }
 }


}

?>