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
       $query = "select * from uorder where orderId = :orderId";
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



   public function saveOrder($userId,$orderName,$deliveryAddress,$totalItem,$mobileNumber,$totalPrice){
      $insertQuery = "insert into uorder(userId,orderName,deliveryAddress,totalItem,totalPrice,mobileNo,orderDate) values(
       :userId,:orderName,:deliveryAddress,:totalItem,:totalPrice,:mobileNo,:orderDate)";
      try{
         $date = date('y-m-d  H::i:s');
         $prepareQuery = $this->con->prepare($insertQuery);
         $prepareQuery->bindParam(":userId",$userId);
         $prepareQuery->bindParam(":orderName",$orderName);
         $prepareQuery->bindParam(":totalItem",$totalItem);
         $prepareQuery->bindParam(":totalPrice",$totalPrice);
         $prepareQuery->bindParam(":deliveryAddress",$deliveryAddress);
         $prepareQuery->bindParam(":orderedDate",$date);
         $prepareQuery->bindParam(":mobileNo",$mobileNumber);
         $prepareQuery->bindParam(":orderDate",$date);
         $prepareQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
   }



   public function getAllOrder($userId,$offset){
       $limit = 10;
       $query = "select * from uorder where userId = :userId LIMIT $offset,$limit ORDER BY orderDate DESC";
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
      $query = "select * from uorder where orderId = :orderId";
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
       $deleteOrder = "delete from uorder where orderId = :orderId";
       try{
       $prepareQuery = $this->con->prepare($deleteOrder); 
       $prepareQuery->bindParam(":orderId",$orderId);
       $result = $prepareQuery->execute();
       return $result;
     }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND); 
     }
   }




   public function cancelOrder($orderId,$merchantId){
    $updateQuery = "update umcart set status = 'cancelled' where orderId = :orderId and merchantId = :merchantId";
      try{
      $prepareQuery = $this->con->prepare($updateQuery);
      $prepareQuery->bindParam(":orderId",$orderId);
      $prepareQuery->bindParam(":merchantId",$merchantId);
      $result = $prepareQuery->execute();
      return $result;
      }catch(Exception $e){
         file_put_contents("E:/log/startupdata/error.log",$e->getMessage()."\n",FILE_APPEND);
      }
   }




   public function updateStatus($orderId,$merchantId){
      $updateQuery = "update umcart set status = 'completed' where orderId = :orderId and merchantId = :merchantId";
      try{
      $prepareQuery = $this->con->prepare($updateQuery);
      $prepareQuery->bindParam(":orderId",$orderId);
      $prepareQuery->bindParam(":merchantId",$merchantId);
      $result = $prepareQuery->execute();
      return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
   }




   public function  saveUMCart($orderId,$merchantId,$merchantName,$totalItem,$totalPrice,$status){
       $date = date('y-m-d H:i:s'); 
       $insertQuery = "Insert into umcart(orderId,merchantId,merchantName,totalItem,totalPrice,status) values(
        :orderId,:merchantId,:merchantName,:totalItem,:totalPrice,:status) ";
       try{
          $result = 0;
          $prepareQuery = $this->con->prepare($insertQuery);
          $prepareQuery->bindParam(":orderId",$orderId);
          $prepareQuery->bindParam(":merchantName",$merchantName);
          $prepareQuery->bindParam(":totalPrice",$totalPrice);
          $prepareQuery->bindParam(":merchantId",$merchantId);
          $prepareQuery->bindParam(":totalItem",$totalItem);
          $prepareQuery->bindParam(":status",$status);
          $prepareQuery->execute();
          $result = $prepareQuery->lastInsertId();
          return $result;
     }catch(Exception $e){
       file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
   }


   public function  saveUPCart($mcartId,$productName,$productId,$quantity,$price){
       $date = date('y-m-d H:i:s'); 
       $insertQuery = "Insert into upcart(mcartId,productName,productId,quantity,price) values(:mcartId,:productName,:productId,:quantity,:price) ";
       try{
          $result = 0;
          $prepareQuery = $this->con->prepare($insertQuery);
          $prepareQuery->bindParam(":mcartId",$mcartId);
          $prepareQuery->bindParam(":productId",$productId);
          $prepareQuery->bindParam(":productName",$productName);
          $prepareQuery->bindParam(":quantity",$quantity);
          $prepareQuery->bindParam(":price",$price);
          $prepareQuery->execute();
          $result = $prepareQuery->lastInsertId();
          return $result;
     }catch(Exception $e){
       file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
   }



   public function getUMCartById($orderId){
       $query = "select * from umcart where orderId = :orderId";
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

    
    public function getUPCartById($mcartId){
       $query = "select * from upcart where mcartId = :mcartId";
       try{
        $prepareQuery = $this->con->prepare($query);
        $prepareQuery->bindParam(":mcartId",$mcartId);
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