<?php
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 *it is used to save product and get product detail
 */

 //include("connection.php");
 class MerchantOrder{
   
    private $con;

    function  __construct(){
         include_once dirname(__FILE__).'connection.php';
         $db =  new DbConnect();
         $this->con = $db->getConnect();
    }


    public function saveOrder($orderId,$userId,$merchantId,$orderName,$totalPrice,$deliveryAddress,$mobileNo,$totalItem,$status){
       $insertQuery = "insert into morder(orderId,userId,merchantId,orderName,totalPrice,deliveryAddress,mobileNo,totalItem,status,orderDate) values(:orderId,:userId,:merchantId,:orderName,:totalPrice,:deliveryAddress,:mobileNo,:totalItem,:status,:orderDate)";
       try{
         $date = date('y-m-d  H:i:s');
         $prepareQuery = $this->con->prepare($insertQuery);
         $prepareQuery->bindParam(":orderId",$orderId);
         $prepareQuery->bindParam(":userId",$userId);
         $prepareQuery->bindParam(":merchantId",$merchantId);
         $prepareQuery->bindParam(":totalItem",$totalItem);
         $prepareQuery->bindParam(":totalPrice",$totalPrice);
         $prepareQuery->bindParam(":status",$status);
         $prepareQuery->bindParam(":orderName",$orderName);
         $prepareQuery->bindParam(":deliveryAddress",$deliveryAddress);
         $prepareQuery->bindParam(":mobileNo",$mobileNo);
         $prepareQuery->bindParam(":orderDate",$date);
         $prepareQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
    }


    public function saveCart($morderId,$productId,$productName,$quantity){
       $insertQuery = "insert into mcart($morderId,$productId,$productName,$quantity,orderDate) values(:morderId,:productId,:productName,:quantity)";
       try{
         $date = date('y-m-d  H:i:s');
         $prepareQuery = $this->con->prepare($insertQuery);
         $prepareQuery->bindParam(":morderId",$morderId);
         $prepareQuery->bindParam(":productId",$productId);
         $prepareQuery->bindParam(":productName",$productName);
         $prepareQuery->bindParam(":quantity",$quantity);
         $prepareQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
    }



    public function getOrderSortByDate($merchantId,$offset){
      $limit = 20;
      $query  = "select * from morder where merchantId = :merchantId LIMIT $offset,$limit ORDER BY orderedDate DESC";
      try{
       $prepareQuery = $this->con->prepare($query);
       $prepareQuery->bindParam(":merchantId",$merchantId);
       $prepareQuery->execute();
       $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
     
       }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }  
    }

    public function  updateOrder(){

    }


    public function deleteOrder($morderId){
        $deleteOrder = "delete from morder where morderId = :morderId";
       try{
       $prepareQuery = $this->con->prepare($deleteOrder); 
       $prepareQuery->bindParam(":morderId",$morderId);
       $result = $prepareQuery->execute();
       return $result;
     }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND); 
     }    
    }


    public function cancelOrder($orderId){
      $updateQuery = "update morder set status = 'cancelled' where orderId = :orderId";
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
      $updateQuery = "update morder set status = 'completed' where orderId = :orderId";
      try{
      $prepareQuery = $this->con->prepare($updateQuery);
      $prepareQuery->bindParam(":orderId",$orderId);
      $result = $prepareQuery->execute();
      return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
    }

?>