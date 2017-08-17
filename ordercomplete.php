<?php 
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 Order controller for order paragamatic in raw form 
 */
class Orderpayment{
  private  $userId;
  private $orderId;
  private $totalPrice;
  private $paidDate;
  private $con;

  public function  __construct($array){
      include_once dirname(__FILE__).'connection.php';
      $db =  new DbConnect();
      $this->con = $db->connect();
      $this->userId = $array["userId"];
      $this->orderId = $array["orderId"];
      $this->totalPrice = $array["totalPrice"];
      $this->paidDate = $array["paidDate"];
  }

  public function savePayment(){
  	 $time = date();
  	 $insertQuery = "Insert into paymentdata(userId,orderId,totalPrice,paidDate) values(:userId,:orderId,:totalPrice,:paidDate)";
  	 try{
       $prepareQuery = $this->con->prepare($insertQuery);
       $prepareQuery->bindParam(":userId",$this->userId);
       $prepareQuery->bindParam(":orderId",$this->orderId);
       $prepareQuery->bindParam("totalPrice",$this->totalPrice);
       $prepareQuery->bindParam("paidDate",$time);
       $result = $prepareQuery->execute();
       return $result;
  	 }catch(Exception $e){
  	 	put_file_contents("E:/log/startupdata/error.log",$e->getMessage()."\n");
  	 }
  }

}

?>