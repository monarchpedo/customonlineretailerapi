<?php
/*
@Author Raja Bose
@Created at 4th august 2017
it controls the main page or home page of anroid app for displaying available products
*/
//include("connection.php");
class MerchantDetail{
  private $merchantId;
  private $merchantName;
  private $merchantDescription;
  private $city;
  private $country;
  private $con;

 public function __construct(){
     include_once dirname(__FILE__).'/connection.php';
     $db = new DbConnect();
     $this->con = $db->connect();
     //$this->merchantId = $array["merchantId"];
     //$this->merchantName = $array["merchantName"];
     //$this->merchantDescription = $array["merchantDescription"];
 }

 public function saveMerchant($merchantName,$merchantDescription,$userId,$locality,$city,$pincode,$state,$country,$latitude,$longitude){
    $time = date('y-m-d H:i:s');
    $insertQuery = "Insert into merchantdata(merchantName,merchantDescription,addedDate,userId,locality,city,pincode,state,country,latitude,longitude) values(:merchantName,:merchantDescription,:addedDate,:userId,:locality,:city,:pincode,:state,:country,:latitude,:longitude)";
   try{ 
    $checkMerchantCount = $this->checkMerchantName($merchantName);
    if($checkMerchantCount["count"] >= 1){
    	return 0;
    }
    $preparedQuery = $this->con->prepare($insertQuery);
    $preparedQuery->bindParam(":merchantName",$merchantName);
    $preparedQuery->bindParam(":merchantDescription",$merchantDescription);
    $preparedQuery->bindParam(":addedDate",$time);
    $preparedQuery->bindParam(":userId",$userId);
    $preparedQuery->bindParam(":locality",$locality);
    $preparedQuery->bindParam(":city",$city);
    $preparedQuery->bindParam(":pincode",$pincode);
    $preparedQuery->bindParam(":state",$state);
    $preparedQuery->bindParam(":country",$country);
    $preparedQuery->bindParam(":latitude",$latitude);
    $preparedQuery->bindParam(":longitude",$longitude);
    $preparedQuery->execute();
    $result = $this->con->lastInsertId();
    return $result;
  }catch(Exception $e){
    file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
  } 
 }

 public function getMerchant($merchantId){
    $query = "select * from merchantdata where merchantId = :merchantId";
    try{
    $preparedQuery  = $this->con->prepare($query);
    $preparedQuery->bindParam(":merchantId",$merchantId);
    $preparedQuery->execute();
    $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
    return $result;
   }catch(Exception $e){
     file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
   } 
 }

 public function deleteMerchant($merchantId){
     $deleteQuery = "delete from merchantdata where merchantId = :merchantId";
     try{
     $preparedQuery = $this->con->prepare($deleteQuery);
     $preparedQuery->bindParam(":merchantId",$merchantId);
     $result = $preparedQuery->execute();
     return $result;
     }catch(Exception $e){
     	file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
 }

 public function getAllMerchants(){
    $query = "select * from merchantdata";    
    try{
      $preparedQuery = $this->con->prepare($query);
      $preparedQuery->execute();
      $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
      return $result;
    }catch(Exception $e){
    	file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
    }
 }

 public function checkMerchantName($merchantName){
 	 $checkName = "select count(*) as count from merchantdata where merchantName = :merchantName";
 	try{ 
 	 $preparedQuery = $this->con->prepare($checkName);
 	 $preparedQuery->bindParam(":merchantName",$merchantName);
 	 $preparedQuery->execute();
 	 $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
 	 return $result;
 }catch(Exception $e){
     file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }

}


public function getMerchantByCity($cityName){
  $query = "select * from merchantdata where city = :cityName";
  try{ 
   $preparedQuery = $this->con->prepare($query);
   $preparedQuery->bindParam(":cityName",$cityName);
   $preparedQuery->execute();
   $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
   return $result;
 }catch(Exception $e){
     file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
 }

} 


}

?>