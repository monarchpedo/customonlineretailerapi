<?php
 /*
*@Author Raja Bose
Self Software developer
 */
/*
 {
	'userId':
	'orderName':
	'deliveryAddress':
	'totalItem':
	'mobileNo':
	'totalPrice':
	'mcart':[{
	   'merchantId':
	   'merchantName';
	   'totalItem':
	   'totalPrice';
	   'status':
	   'pcart':[{
	      'productName':
	      'productId':
	      'quantity':
	      'price':
	   }]
	}]
 }
*/
include_once 'order.php';
include_once 'MerchantOrder.php';
class OrderService{
  
  private $order;
  private $merchantOrder;
  private $orderParam = array('userId','orderName','deliveryAddress','totalItem','mobileNo','totalPrice','mcart');
  private $mcartParam = array('merchantId','merchantName','totalItem','totalPrice','status','pcart');
  private $pcartParam = array('productId','productName','quantity','price');
  public function __construct(){
       $order =  new Order();
       $merchantOrder =  new MerchantOrder();
  }


  public function saveMerchantOrder($orderId,$userId,$merchantId,$orderName,$totalPrice,$deliveryAddress,$mobileNo,$totalItem,$status){
         $result = $this->merchantOrder->saveOrder($orderId,$userId,$merchantId,$orderName,$totalPrice,$deliveryAddress,$mobileNo,$totalItem,$status);    
  }

  public function  saveCustomerOrder($userId,$orderName,$deliveryAddress,$totalItem,$mobileNo,$totalPrice){
          $result = $this->order->saveOrder($userId,$orderName,$deliveryAddress,$totalItem,$mobileNo,$totalPrice);
  }

 public function  saveCustomerPCart($mcartId,$productName,$productId,$quantity,$price){
      $result = $this->order->saveUPCart($mcartId,$productName,$productId,$quantity,$price);
 }
 
 public function saveMerchantProduct($morderId,$productId,$productName,$quantity){
        $result = $this->merchantOrder->saveCart($morderId,$productId,$productName,$quantity);
  }

 public function saveCustomerMCart($orderId,$merchantId,$merchantName,$totalItem,$totalPrice,$status){
       $result =  $this->order->saveUMCart($orderId,$merchantId,$merchantName,$totalItem,$totalPrice,$status);
 }


 public function saveOrderDetails($app){
   if($this->verifyOrderRequirePrameters($app) == 1){
   	    $idArray =  array();
   	    $idArray['orderId'] = 0;
   	    $idArray['mcartId'] = array();
   	    $idArray['morderId'] =  array();
        $userId = $app->request->post('userId');
        $orderName = $app->request->post('orderName');
        $deliveryAddress = $app->request->post('deliveryAddress');
        $totalItem = $app->request->post('totalItem');
        $totalPrice = $app->request->post('totalPrice');
        $mobileNo = $app->request->post('mobileNo');
        $mcart = $app->request->post('mcart');
        $mcart = json_decode($mcart);
        for($i=0;$i<count($mcart);$i++){
        	if(verifyMcartRequireParam($mcart[$i])){
                 $merchantId = $mcart[$i]['merchantId'];
                 $merchantName = $mcart[$i]['merchantName'];
                 $mTotalItem = $mcart[$i]['totalItem'];
                 $mTotalPrice = $mcart[$i]['totalPrice'];
                 $status = $mcart[$i]['status'];
                 $pcart = $mcart[$i]['pcart'];
                 $mcartId = 0;
                 $morderId = 0;
                 for($j=0;$j<count($pcart);$j++){
                 	if(verifyPcartRequireParam($pcart[$j])){
                      if($idArray['orderId'] == 0){
                          $orderId = $this->saveCustomerOrder($userId,$orderName,$deliveryAddress,$totalItem,$mobileNo,$totalPrice);
                          $idArray['orderId'] = $orderId;
                          if($idArray['orderId'] == 0){
                          	return 0;
                          }
                      }
                      if($mcartId == 0){
                      	$mcartId = $this->saveCustomerMCart($orderId,$merchantId,$merchantName,$mtotalItem,$mtotalPrice,$status);
                      	if($mcartId == 0){
                      		$this->deleteDataOnTable($idArray);
                      		return 0;
                      	}
                      	array_push($idArray['mcartId'],$mcartId);
                      	$morderId = $this->saveMerchantOrder($orderId,$userId,$merchantId,$orderName,$mtotalPrice,$deliveryAddress,$mobileNo,$mtotalItem,$status);
                      	if($morderId == 0){
                      		$this->deleteDataOnTable($idArray);
                      		return 0;
                      	}
                      	array_push($idArray['morderId'],$morderId);
                      }
                      $productId = $pcart[$j]['productId'];
                      $productName = $pcart[$j]['productName'];
                      $quantity = $pcart[$j]['quantity'];
                      $price = $pcart[$j]['price'];
                      $pcartId = $this->saveCustomerPCart($mcartId,$productName,$productId,$quantity,$price);
                      if($pcartId == 0){
                      	$this->deleteDataOnTable($idArray);
                      	return 0;
                      }
                      $merchantCartId = $this->saveMerchantProduct($morderId,$productId,$productName,$quantity);
                      if($merchantCartId == 0){
                      	$this->deleteDataOnTable($idArray);
                      	return 0;
                      }
                 	}else{
                 		return 0;
                 	}
                 }
        	} else{
        	return 0;
          }
        }
        return $orderId;
   }else{ 
     return 0;
   }
 }

 public function verifyOrderRequirePrameters($app){
    for($i=0;$i<count($this->orderParam);$i++) {
    	if(null === $app->request->post($this->orderParam[$i]) || strlen(trim($app->request->post($this->orderParam[$i]))) <= 0 ){
    		return 0;
    	}
    }
    return 1;
 }

 public function verifyMcartRequireParam($cart){
     for($i=0;$i<count($this->mcartParam);$i++){
     	if( !isset($cart[$this->mcartParam[$i]]) || strlen(trim($cart[$this->mcartParam[$i]])) <= 0 ){
    		return 0;
    	}
     }
     return 1;
 }


 public function verifyPcartRequireParam($pcart){
      for($i=0;$i<count($this->pcartParam);$i++){
     	if(!isset($pcart[$this->pcartParam[$i]]) || strlen(trim($pcart[$this->pcartParam[$i]])) <= 0 ){
    		return 0;
    	}
     }
     return 1;
 }

 public function deleteCustomerOrder($orderId){
       $id = $this->order->deleteOrder($orderId);
       $id1 = $this->order->deleteMCart($orderId);
 }

 public function deleteCustomerCart($mcartId){
    $id =  $this->order->delete->deletePCart($mcartId);
 }

 public function deleteMerchantOrder($morderId){
     $id =  $this->merchantOrder->deleteOrder($morderId);
     $id1 =  $this->merchantOrder->deleteCart($morderId);
 }


 public function deleteDataOnTable($idArray){
 	 $this->deleteCustomerOrder($idArray['orderId']);
 	 for($i=0;$i<count($idArray['mcartId']);$i++){
       $this->deleteMerchantOrder($idArray['morderId'][$i]);
       $this->deleteCustomerCart($idArray['mcartId'][$i]);
 	 } 
 }

}



?>