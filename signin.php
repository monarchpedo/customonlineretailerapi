<?php   
/*
@Author Raja Bose
@Created at 4th august 2017
it is used to place login in the app
*/
//include('connection.php');
class SignIn{
  
private $username;
private $email;
private $mobileNumber;
private $password;
private $userId;
private $con;

public function __construct(){
       
       include_once dirname(__FILE__).'/connection.php';
        
       $db =  new DbConnect();  
       $this->con = $db->connect();
}


public function signIn($username,$password,$loginType){
   $queryByEmail = "select * from  userdetail where email = :email and password = :password";
   $queryByPhone = "select *  from userdetail where mobileNumber = :mobileNumber and password = :password";

   if($loginType == 1){
      $emailCheck = $this->checkEmailOrUserName($username);
      if($emailCheck["count"]!=1){
        return 1;
      }
      $preparedQuery = $this->con->prepare($queryByEmail);
      $preparedQuery->bindParam(":email",$username);
      $preparedQuery->bindParam(":password",$password);
      $preparedQuery->execute();
      $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
      if(is_array($result)){
        return $result;
      }
      return null;
   }else if ($loginType == 2){
      $numberCheck = $this->checkNumber($username);
      if($numberCheck["count"]!=1){
        return 1;
      }
      $preparedQuery = $this->con->prepare($queryByPhone);
      $preparedQuery->bindParam(":mobileNumber",$username);
      $preparedQuery->bindParam(":password",$password);
      $preparedQuery->execute();
      $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
      if(is_array($fetch)){
        return $result;
      }
      return null;  
   }
}


public function logOut($userId){
  $time =  date('y-m-d H:i:s');
  $insertQuery = "Insert into `loginhistory`(`userId`,`logoutDate`) values(:userId,:time)";
  try{
  $preparedQuery = $this->con->prepare($insertQuery);
  $preparedQuery->bindParam(":userId",$userId);
  $preparedQuery->bindParam(":time",$time);
  $preparedQuery->execute();
  $result = $this->con->lastInsertId();
  return $result;
}catch(Exception $e){
   file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
  }
}


public function checkPasswordByNumber($mobileNumber,$password){
    $checkQuery = "select count(*) as count from `userdetail` where mobileNumber = :mobileNumber and password = :password";
    try{
    $preparedQuery = $this->con->prepare($checkQuery);
    $preparedQuery->bindParam(":mobileNumber",$mobileNumber);
    $preparedQuery->bindParam(":password",$password);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
 }catch(Exception $e){
  file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }
}


public function checkPasswordByEmail($email,$password){
  $checkQuery = "select count(*) as count from `userdetail` where email = :email and password = :password";
    try{
    $preparedQuery = $this->con->prepare($checkQuery);
    $preparedQuery->bindParam(":email",$email);
    $preparedQuery->bindParam(":password",$password);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
 }catch(Exception $e){
   file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }
}


public function checkEmailOrUserName($email){
  $query = "select count(*) as count from userdetail where  email = :email";
  try{
    $preparedQuery = $this->con->prepare($query);
    $preparedQuery->bindParam(":email",$email);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
 }catch(Exception $e){
  file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }
}

public function checkNumber($mobileNumber){
   $query = "select count(*) as count from userdetail where mobileNumber = :mobileNumber";
   try{
    $preparedQuery = $this->con->prepare($query);
    $preparedQuery->bindParam(":mobileNumber",$mobileNumber);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
 }catch(Exception $e){
  file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }
}
  
}
?>