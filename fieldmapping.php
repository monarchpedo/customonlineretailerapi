<?php 
 
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 *it is used to save product and get product detail
 */
 class Mapping{
   private $tableFieldMapping =  array();
   $tableFieldMapping['offerdata'] = array("offerId","userId","merchantName","offerDescription","city","Latitude","Longitude","addedDate");
   $tableFieldMapping['morder'] = array("morderId","orderId","userId","merchantId","orderName","deliveryAddress","totalItem","totalPrice","mobileNumber","status","orderDate");
   $tableFieldMapping['mcart'] = array("cartId","morderId","productName","productId","quantity");
   $tableFieldMapping['uorder'] = array("orderId","userId","orderName","deliveryAddress","totalItem","totalPrice","mobileNo","orderDate");
   $tableFieldMapping['umcart'] = array("mcartId","orderId","merchantId","merchantName","totalItem","totalPrice","status");
   $tableFieldMapping['upcart'] = array("pcartId","mcartId","productName","productId","quantity","price");
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