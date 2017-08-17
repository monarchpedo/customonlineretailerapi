<?php
/*
@Author Raja Bose
@Created at 4th august 2017
it controls the resource handling of the client request for put,post,delete,get and patch operations
*/

require_once 'signin.php';
require_once 'signup.php';
require_once 'merchant.php';
require_once 'order.php';
require_once 'ProductDetail.php';
require_once 'ordercomplete.php';
require 'vendor/autoload.php';
require_once 'vendor/slim/slim/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config('debug', true);

function echoResponse($status_code, $response, $app){
    //Getting app instance

    //$app = new Slim\Slim();

    //Setting http response code
    $app->status($status_code);

    //Setting http message or content type to json
    $app->response->headers->set('Content-Type', 'application/json');

    $app->response->write( json_encode($response));
}



 function verifyRequiredParams($required_fields,$app){
  //Assuming there is no error
  $error = false;

  //Error fields are blank
  $error_fields = "";

  //Getting the request parameters 
  $request_params = array();

    //Hnadling PUT request parameters
  //if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        
        //Getting the app instance 
  $app = \Slim\Slim::getInstance();

 // parse_str($app->request->getBody(),$request_params);
 // $request_params = $data;
 // }

  //Looping through all parameters
  foreach($required_fields as $fields){

    //if(!isset($request_params[$fields]) || strlen(trim($request_params[$fields]))<=0){
    if( null === $app->request->post($fields) || strlen(trim($app->request->post($fields))) <=0){  
      $error = true;
      //file_put_contents("logfile", "raja".$request_params."\n",FILE_APPEND);
      //Concatnating the missing parameters  in error fileds 
      $error_fields .= $fields.',';
      //file_put_contents("logfile", $app->request->post($fields)."\n",FILE_APPEND);

    }

  }

  if($error){
    //Creating response array
    $response = array();

    //Getting app instance 
    $app = \Slim\Slim::getInstance();

    //Adding values to a response 
    $response["error"] = true;
    $resonse["message"] = 'Required fields(s) '. substr($error_fields,0,-2).'is missing or empty';

    echoResponse(400,$response,$app);


    //Stopping  the app 
    $app->stop();

  }
 }


 //method to authenticate api key
 function authenticate(\Slim\Route $route){
     //Getting request headers
   $headers =  apache_request_headers();
   $response = array();
   $app = \Slim\Slim::getInstance();
     if(!isset($headers["Authorization"])){
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response,$app);
        $app->stop();
     } 
 }


/*
*Url: http://localhost/startupapp/v1/user/
*mehtod : POST
*parameters: username,email,password,mobileNumuber,userType
*/
 $app->post('/user/',function () use($app){
     //$data = json_decode($app->request->getBody(),true);
     verifyRequiredParams(array('username','email','password','mobileNumber','userType'),$app);
     $response = array();  
     $username = $app->request->post('username');    
     $email = $app->request->post('email');
     $password = $app->request->post('password');
     $mobileNumber = $app->request->post('mobileNumber');
     $userType = $app->request->post('userType');
     $signUp = new SignUp();
     $result = $signUp->saveUser($username,$email,$password,$mobileNumber,$userType);
     if($result !=0 ){
      $response["error"] = false;
      $response["userId"] = $result;
      echoResponse(201,$response,$app);
     }
     else if ($result == 1 || $result == 0){
        $response["error"] = true;
        $response["message"] = "oops there is some system error";
        echoResponse(200,$response,$app);
     }

   });

 /*
*Url: http://localhsot/startupapp/v1/user/:id
*method : GET
*parameters : userid 
 */

 $app->get('/user/:id',function ($userId)  use($app){
   $signUp = new SignUp();
   $result = $signUp->getUserByUserId($userId);
   $response = array();
   $response['error'] = false;
   $response['user'] = array();
   file_put_contents("logfile", print_r($result,true)."\n",FILE_APPEND);
      $temp = array();
      $temp['userId'] = $result["userId"];
      $temp['username'] = $result["username"];
      $temp['email'] = $result["email"];
      $temp['createdDate'] =  $result["createdDate"];
      $temp['userType'] = $result["userType"];
      array_push($response['user'],$temp);  
     echoResponse(200,$response,$app);
 });

 /*
*Url: http://localhost/startupapp/v1/user/:id
* method: PUT
* parameters: username,password,email,mobileNumber
 */
 
 $app->put('/user/:id',function ($userId)  use($app){
 
 });


  /*
*Url: http://localhost/startupapp/v1/user/:id
* method: DELETE
 */

$app->delete('user/:id',function ($userId) use ($app){
    $signUp =  new SignUp();
    $result = $signUp->deleteUser($userId);
    $response = array();
    $response['error'] = false;
    if($result == 0){
      $response['error'] = true;
      $response['message'] = "user can not be deleted";
      echoResponse(200,$response,$app);
    }
    else if($result == 1){
        $response['message'] = "users is now unregistered";
        echoResponse(200,$response,$app);
    }
  });

  /*
  *Url: http://localhost/startupapp/v1/user/login/
   *method : POST
   * parameters: username,passwor(int)dtrim( 
  */

  $app->post('/user/login',function () use ($app){
     verifyRequiredParams(array('username','password','loginType'),$app);
     $username = $app->request->post('username');    
     $password = $app->request->post('password');
     $loginType =(int) trim($app->request->post('loginType'));
     $signIn = new SignIn();
     $response = array();
     $response['error'] = false;
     $result = $signIn->signIn($username,$password,$loginType);
     if($result == 1){
      $response['error'] = true;
      $response['message'] = "invalid username or password";
        echoResponse(204,$response,$app);
     }
     else if(isset($result)){
          $temp = array();
          $response['userdetail'] = array();
          $temp['userId'] = $result["userId"];
          $temp['username'] = $result["username"];
          $temp['email'] = $result["email"];
          $temp['createdDate'] =  $result["createdDate"];
          $temp['userType'] = $result["userType"];  
          array_push($response['userdetail'],$temp);
          echoResponse(201,$response,$app);
     }
  });

/*
  *Url: http://localhost/startupapp/v1/merchant/
   *method : POST
   * parameters:merchantName,merchantDesciption
  */

$app->post('/merchant/',function  () use($app){
    verifyRequiredParams(array('merchantName','merchantDescription'),$app);
    $merchantName = $app->request->post('merchantName');
    $merchantDescription = $app->request->post('merchantDescription');
    $response =  array();
    $response['error'] = false;
    $merchant = new MerchantDetail();
    $result = $merchant->saveMerchant($merchantName,$merchantDescription);
    if($result == 0){
       $response['error'] = true;
       $response['message'] = "merchant data is not valid";
       echoResponse(201,$response,$app);
     }
     else if($result != 0){
      $response['merchnantId'] = $result;
      echoResponse(201,$response,$app);
     }
    });
 
 /*
  *Url: http://localhost/startupapp/v1/merchant/:id
   *method : GET
   * parameters:merchantId
  */
 $app->get('/merchant/:id',function ($merchantId) use($app){
     $merchant =  new MerchantDetail();
     $result = $merchant->getMerchant($merchantId);
     $response = array();
     $response['error'] = false;
     if(!isset($result)){
         $response['error'] = true;
         $response['message'] = "merchant is not availabel";
         echoResponse(204,$response,$app); 
     }
     else{
        $response['MerchantDetail'] = array();
        $temp = array();
        /*$temp['merchantName'] = $result['merchantName'];
        $temp['merchantId'] = $result['merchantId'];
        $remp['merchantDescription'] = $result['merchantDescription'];
        $temp['addedDate'] = $result['addedDate'];*/
        array_push($response['MerchantDetail'],$result);
        echoResponse(200,$response,$app);
     }
 });

 /*
  *Url: http://localhost/startupapp/v1/merchant/:id
   *method : PUT
   * parameters:merchantId
  */
 $app->put('/merchant/:id',function ($merchantId) use ($app){
  
 });

 /*
  *Url: http://localhost/startupapp/v1/merchant/:id
   *method : DELETE
   * parameters:merchantId
  */
 $app->delete('/merchant/:id',function ($merchantId) use ($app){
     $merchant = new MerchantDetail();
     $response = array();
     $response['error'] = false;
     $result = $merchant->deleteMerchant($merchantId);
     if($result == 0){
        $response['error'] = true;
        $response['message'] = "merchnat has not been deleted";
        echoResponse(204,$response,$app);
     }else if($result = 1){
        $response['message'] = "merchant has been removed.";
        echoResponse(201,$response,$app);
     }
 });


/*
*URL: http://localhost/startupapp/v1/merchant/all
*method = GET
*/
$app->get('/merchant/all',function () use ($app){
    $merchant =  new MerchantDetail();
    $response =  array();
    $response['error'] = false;
    $result = $merchant->getAllMerchants();
    if(!isset($result)){
       $error['error'] = true;
       $response['message'] = "no merchant are availabel rightnow";
       echoResponse(200,$response);
    }
    else if(isset($result)){
      $response['MerchantDetail'] = array();
      array_push($response['MerchantDetail'],$result);
      echoResponse(200,$response,$app);
    }
});


/*
*URL: http://localhost/startupapp/v1/product/
*method = POST
*parameters:productName,productDescription,price,merchantId 
*/

$app->post('/product',function () use ($app){
   verifyRequiredParams(array('productName','productDescription','price','merchantId'),$app);
   $product =  new Product();
   $response = array();
   $response['error'] = false;
   $productName = $app->request->post('productName');
   $productDescription = $aapp->request->post('productDescription');
   $price = $app->request->post('price');
   $merchantId = $app->request->post('merchantId');
   $result = $product->saveProduct($productName,$productDescription,$price,$merchantId);
   if($result == 0){
     $response['error'] = true;
     $response['message'] = "product has not been  added to merchnat dashboard"; 
     echoResponse(204,$response,$app);
   }
   else if($result !=0 ){
     $response['error'] = false;
     $response['productId'] = $result;
     echoResponse(201,$response,$app);
   }
});


/*
*URL: http://localhost/startupapp/v1/product/
*method = PUT
*parameters:productName,productDescription,price,merchantId 
*/
$app->put('',function () use ($app){

});


/*
*URL: http://localhost/startupapp/v1/product/
*method = GET 
*/
$app->get('/product:id',function ($productId) use ($app){
   $product = new Product();
   $response = array();
   $response['error'] = false;
   $result = $product->getProductByProductId($productId);
   if(isset($result)){
       $response['products'] = array();
       array_push($response['products'], $result);
       echoResponse(200,$response,$app);
   }
   else if(!isset($result)){
       $response['error'] = true;
       $response['message'] = "productId is not valid";
       echoResponse(200,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/product/
*method = GET 
parameter: merchantId
*/

$app->get('/product/merchant:id',function ($merchantId) use ($app){
   $product = new ProductDetail();
   $response =  array();
   $response['error'] = false;
   $result = $product->getProductByMerchantId($merchantId);
   if(isset($result)){
       $response['products'] = array();
       array_push($response['products'], $result);
       echoResponse(200,$response,$app);
   }
   else if(!isset($result)){
       $response['error'] = true;
       $response['message'] = "productId is not valid";
       echoResponse(204,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/order/
*method = POST
parameter: userId,productId,quantity,totalPrice,status
*/

$app->post('/order/',function () use ($app){
     verifyRequiredParams(array('userId','quantity','totalPrice','status'),$app);
     $userId = $app->request->post('userId');
    // $cartId = $app->request->post('cartId');
     $quantity = $app->request->post('quantity');
     $totalPrice = $app->request->post('price');
     $status = $app->request->post('status');
     $response = array();
     $response['error'] = false;
     $order = new Order();
     $result = $order->saveOrder($userId,$cardId,$quantity,$totalPrice,$status);
     if($result == 0){
      $response['error'] = true;
      $response['message'] = "order has not been accepted";
      echoResponse(204,$response,$app);
     }
     else if($result != 0){
         $response['orderId'] = $result;
         echoResponse(201,$response,$app);
     }

});

/*
*URL: http://localhost/startupapp/v1/order/
*method = PUT
parameter: userId,productId,quantity,totalPrice,status
*/
$app->put('/order/:id',function ($orderId) use ($app){
  
});


/*
*URL: http://localhost/startupapp/v1/order/user/:id
*method = GET
parameter: userId,productId,quantity,totalPrice,status
*/
$app->get('/order/user/:id',function ($userId) use ($app){
  $response =  array();
  $response['error'] = false;
  $order =  new Order();
  $result = $order->getAllOrder($userId);
  if(!isset($result)){
    $response['error'] = true;
    $response['message'] = "no order yet been ordered";
    echoResponse(204,$response,$app);
  }
  else if(isset($result)){
    $response['order'] = array();
    array_push($response['order'], $result);
    echoResponse(200,$response,$app);
  }
});


/*
*URL: http://localhost/startupapp/v1/order/:id
*method = GET
parameter: userId,productId,quantity,totalPrice,status
*/
$app->get('/order/:id',function ($orderId) use ($app){
   $response = array();
   $response['error'] = false;
   $order =  new Order();
   $result = $order->getOrderByOrderId($orderId);
   if(!isset($result)){
      $response['error'] = true;
      $response['error'] = "No order exit for this query";
      echoResponse(204,$response,$app);
   }
   else if(isset($result)){
     $response['order'] = array();
     array_push($response['order'], $result);
     echoResponse(200,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/order/:id
*method = DELETE
parameter: userId,productId,quantity,totalPrice,status
*/
$app->delete('/order/:id',function ($orderId) use ($app){
   $response = array();
   $response['error'] = false;
   $order =  new Order();
   $result = $order->deleteOrder($orderId);
   if($result==0){
      $response['error'] = true;
      $response['error'] = "No order exit for this query";
      echoResponse(204,$response,$app);
   }
   else if($result!=0){
     $response['message'] = "order has been deleted";
     echoResponse(201,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/order/:id
*method = PUT
parameter: status
*/
$app->put('/order/:id',function ($orderId) use ($app){
   $response = array();
   $response['error'] = false;
   $order =  new Order();
   $result = $order->updateStatus($orderId);
   if($result == 0){
      $response['error'] = true;
      $response['error'] = "No order exit for this query";
      echoResponse(204,$response,$app);
   }
   else if($result != 0 ){
     $response['message'] = "order has been updated";
     echoResponse(201,$response,$app);
   }
});


/*
*URL: http://localhost/startupapp/v1/order/cancel/:id
*method = PUT
parameter: status
*/
$app->put('/order/cancel/:id',function ($orderId) use ($app){
   $response = array();
   $response['error'] = false;
   $order =  new Order();
   $result = $order->cancelOrder($orderId);
   if($result == 0){
      $response['error'] = true;
      $response['error'] = "No order exit for this query";
      echoResponse(204,$response,$app);
   }
   else if($result != 0){
     $response['message'] = "order has been deleted";
     echoResponse(201,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/order/cart
*method = POST
parameter: userId,productId,quantity,totalPrice,status
*/
$app->post('/order/cart/',function () use ($app){
   verifyRequiredParams(array('userId','orderId','productId','quantity'),$app);
   $userId = $app->request->post('userId');
   $orderId = $app->request->post('orderId');
   $productId = $app->request->post('productId');
   $quantity = $app->request->post('quantity');
   //$date = date('Y-m-d h:i:s');
   $response['error'] = false;
   $order = new Order();
   $result = $order->saveCart($userId,$orderId,$productId,$quantity);
   if($result == 0){
      $response['error'] = true;
      $response['message'] = "error in saving cart of order,please try again";
      echoResponse(204,$response,$app);
   }
   else if($result != 0){
      $response['cartId'] = $result;
      $response['message'] = "cart has been saved for order";
      echoResponse(201,$response,$app);
   }
});

/*
*URL: http://localhost/startupapp/v1/order/cart
*method = PUT
parameter: userId,productId,quantity,totalPrice,status
*/
$app->put('/order/cart/:id',function ($cartId) use ($app){

});

/*
*URL: http://localhost/startupapp/v1/order/cart/:id
*method = GET
parameter: userId,productId,quantity,totalPrice,status
*/
$app->get('/order/cart/:id',function ($orderId) use ($app){
  $order = new Order();
  $response = array();
  $response['error'] = false;
  $result = $order->getCartDetailsbyOrderId($orderId);
  if(!isset($result)){
     $response['error'] = true;
     $response['message'] = "No cart data availabel for order";
     echoResponse(204,$response,$app);
  }
  else if(isset($result)){
     $response['cart'] = array();
     array_push($response['cart'], $result);
     echoResponse(200,$response,$app);
  }
});

/*
*URL: http://localhost/startupapp/v1/order/
*method = DELETE
parameter: userId,productId,quantity,totalPrice,status
*/
$app->delete('/order/cart/:id',function ($cartId) use ($app){
     $response = array();
     $response['error'] =  false;
     $order = new Order();
     $result = $order->deleteCart($cartId);
     if($result == 0){
       $response['error'] = true;
       $response['message'] = "no cart availabel for order to be deleted";
       echoResponse(204,$response,$app);
     }
     else if($result != 0){
       $response['message']  = "cart has been deleted";
       echoResponse(201,$response,$app);
     }
});

$app->run();
?>