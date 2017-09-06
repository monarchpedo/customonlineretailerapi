<?php 
 
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 *it is used to save product and get product detail
 */
 class Mapping{
   private $tableFieldMapping =  array();
   $tableFieldMapping['offerdata'] = array("offerId","userId","merchantName","offerDescription","city","Latitude","Longitude","addedDate");
   $tableFieldMapping['merchantorderdata'] = array("merchantOrderId","orderId","userId","merchantId","quantity","totalPrice","status","orderedDate","delieveredDate");
   $tableFieldMapping['orderdata'] = array("orderId","userId","quantity","totalPrice","status","orderedDate","delieveredDate");
   $tableFieldMapping['cartdata'] = array("cartId","userId","orderId","productId","merchantId","quantity","addedDate");
   $tableFieldMapping['loginhistory'] = array("id","userId","logoutDate");
   $tableFieldMapping['merchantdata'] = array("merchantId","userId","merchantName","merchantDescription","Latitude","Longitude","city","state","locality","country","pincode","addedDate");
   $tableFieldMapping['old_user_data'] = array("id","userId","email","mobileNumber","addedDate");
   $tableFieldMapping['paymentdata'] = array("payId","userId","orderId","merchantId","totalPrice","paidDate");
   $tableFieldMapping['productdata'] = array("productId","productName","productDescription","price","quantity","unit","merchantId","addedDate");
   $tableFieldMapping['userdetail'] = array("userId","username","email","password","mobileNumber","createdDate","modifiedDate","userType");

   private $updateQuery = "";
   private $bindParam = array();

   public function __construct()
   {
   	# code...
   }

   public function setMapping($app,$tableName){
   	  $this->updateQuery = "update $tableName set";
      foreach($this->tableFieldMapping[$tableName] as $value) {
      	 if(null !== $app->request->put($value)){
      	   $this->updateQuery. = " ".$value."= :".$value.",";
           $this->bindParam[":".$value] = $app->request->put($value);
      	}
      }
   }


   public function getUpdateQuery(){
     $query =  substr($this->updateQuery, 0, strlen($this->updateQuery)-1);
     return $query;
   }

   public  function  getBindParam(){
   	 return $this->bindParam;
   }


 }

?>