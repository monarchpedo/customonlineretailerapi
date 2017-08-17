<?php
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 Order controller for order paragamatic in raw form 
 */

 //include("connection.php");
 class Order{
   
   private $orderId;
   private $userId;
   private $productId;
   private $quantity;
   private $totalPrice;
   private $status;
   private $orderedDate;
   private $delieveredDate;
   private $con;

   
   public function __construct(){
       include_once dirname(__FILE__).'/connection.php';
       $db =  new DbConnect();
       $this->con = $db->connect();
       //$this->orderId = $array["orderId"];
       //$this->userId = $array["userId"];
       //$this->productId = $array["productId"];
       //$this->quantity = $array["quantity"];
       //$this->totalPrice =  $array["totalPrice"];
       //$this->status = $array["status"];
       //$this->orderedDate = $array["orderedDate"];
       //$this->delieveredDate = $array["delieveredDate"];
   }




   public function getOrderById($orderId){
       $query = "select * from orderdata where orderId = :orderId";
       try{
         $prepareQuery = $this->con->prepare($query);
         $prepareQuery->bindParam(":orderId",$this->orderId);
         $prepareQuery->execute();
         $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
         return $result;
       }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }
   }



   public function saveOrder($userId,$cartId,$quantity,$totalPrice,$status){
      $insertQuery = "insert into orderdata(userId,productId,quantity,totalPrice,status,orderedDate,delieveredDate) values(:userId,:productId,:quantity,:totalPrice,:status,:orderedDate,:delieveredDate)";
      try{
         $date = date('y-m-d  H::i:s');
         $prepareQuery = $this->con->prepare($insertQuery);
         $prepareQuery->bindParam(":userId",$userId);
         $prepareQuery->bindParam(":productId",$cartId);
         $prepareQuery->bindParam(":quantity",$quantity);
         $prepareQuery->bindParam(":totalPrice",$totalPrice);
         $prepareQuery->bindParam(":status",$status);
         $prepareQuery->bindParam(":orderedDate",$date);
         $prepareQuery->bindParam(":delieveredDate",$date);
         $prepareQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
   }



   public function getAllOrder($userId){
       $query = "select * from orderdata where userId = :userId";
       try{
       $prepareQuery = $this->con->prepare($query);
       $prepareQuery->bindParam(":userId",$userId);
       $prepareQuery->execute();
       $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
     
       }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }          
   }



   public function getOrderByOrderId($orderId){
      $query = "select * from orderdata where orderId = :orderId";
       try{
       $prepareQuery = $this->con->prepare($query);
       $prepareQuery->bindParam(":orderId",$orderId);
       $prepareQuery->execute();
       $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
     
       }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }          
   }



   public function deleteOrder($orderId){
       $deleteOrder = "delete from orderdata where orderId = :orderId";
       try{
       $prepareQuery = $this->con->prepare($deleteOrder); 
       $prepareQuery->bindParam(":orderId",$orderId);
       $result = $prepareQuery->execute();
       return $result;
     }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND); 
     }
   }




   public function cancelOrder($orderId){
    $updateQuery = "update orderdata set status = 'cancelled' where orderId = :orderId";
      try{
      $prepareQuery = $this->con->prepare($updateQuery);
      $prepareQuery->bindParam(":orderId",$orderId);
      $result = $prepareQuery->execute();
      return $result;
      }catch(Exception $e){
         file_put_contents("E:/log/startupdata/error.log",$e->getMessage()."\n",FILE_APPEND);
      }
   }




   public function updateStatus($orderId){
      $updateQuery = "update orderdata set status = 'completed' where orderId = :orderId";
      try{
      $prepareQuery = $this->con->prepare($updateQuery);
      $prepareQuery->bindParam(":orderId",$orderId);
      $result = $prepareQuery->execute();
      return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
   }




   public function  saveCart($userId,$orderId,$productId,$quantity){
       $date = date('y-m-d H:i:s'); 
       $insertQuery = "Insert into cartdata(userId,orderId,productId,quantity,addedDate) values(:userId,:orderId,:productId,:quantity,:addedDate) ";
       try{
          $result = 0;
          $prepareQuery = $this->con->prepare($insertQuery);
          foreach($cartArray as $key => $cart){
          $prepareQuery->bindParam(":userId",$userId);
          $prepareQuery->bindParam(":orderId",$orderId);
          $prepareQuery->bindParam(":productId",$productId);
          $prepareQuery->bindParam(":quantity",$quantity);
          $prepareQuery->bindParam(":addedDate",$date);
          $prepareQuery->execute();
          $result = $prepareQuery->lastInsertId();
          return $result;
     }catch(Exception $e){
       file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
   }



   public function getCartDetailsByOrderId($orderId){
       $query = "select * from cartdata where orderId = :orderId";
       try{
        $prepareQuery = $this->con->prepare($query);
        $prepareQuery->bindParam(":orderId",$orderId);
        $prepareQuery->execute();
        $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
        return $result;
       }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }
   }



   public function deleteCart($cartId){
    $deleteQuery = "delete from cartdata where cartId = :cartId";
    try{
     $prepareQuery =  $this->con->prepare($deleteQuery);
     $prepareQuery->bindParam(":cartId",$cartId);
     $result = $prepareQuery->execute();
     return $result;
    }catch(Exception $e){
       file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
    }
   }

 } 
 ?>