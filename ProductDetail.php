<?php
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 *it is used to save product and get product detail
 */

 //include("connection.php");
 class Product{
   
    private $con;

    function  __construct(){
         include_once dirname(__FILE__).'connection.php';
         $db =  new DbConnect();
         $this->con = $db->getConnect();
    }


    public function getproductByproductId($productId){
         $query = "select * from productdata where productId = :productId";
         try{
         $preparedQuery = $this-con->prepare($query);
         $preparedQuery->bindParam(":productId",$productId);
         $preparedQuery->execute();
         $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
         if(is_array($result)){
            return $result;
         }
         return null;
     }catch(Exception $e){
     	file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
    }



    public function getAllProductsByMerchantId($merchantId){
      $query = "select * from productdata where merchantId = :merchantId";
         try{
         $prparedQuery = $this-con->prepare($query);
         $preparedQuery->bindParam(":merchantId",$merchantId);
         $preparedQuery->execute();
         $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
         if(is_array($result)){
           return $result;
         }
         return null;
     }catch(Exception $e){
     	file_put_contents("logfie",$e->getMessage()."\n",FILE_APPEND);
     }
   }



   public function saveProduct($productName,$productDescription,$price,$merchantId,$quantity,$unit){
     
     $time = date('Y-m-d H:i:s'); 
     $insertQuery = "Insert into productdata('productName','productDescription','price','merchantId','addedDate','quantity','unit') values(:productName,:productDescription,:price,:merchantId,:addedDate,:quantity,:unit)";
     try{
         $preparedQuery = $this->con->prepare($insertQuery);
         $preparedQuery->bindParam(':productName',$productName);
         $preparedQuery->bindParam(':productDescription',$productDescription);
         $preparedQuery->bindParam(':price',$price);
         $preparedQuery->bindParam(':merchantId',$merchantId);
         $preparedQuery->bindParam(':addedDate',$time);
         $preparedQuery->bindParam(':quantity',$quantity);
         $preparedQuery->bindParam(':unit',$unit);
         $preparedQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
     }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     }
 }



  public function  updateProduct(){

  }



  public function  deleteProductByprodcutId($productId){
	$query = "delete from productdata where productId = :productId";
	try{
	 $preparedQuery = $this->con->prepare($query);
	 $preparedQuery->bindParam(':productId',$productId);
	 $result = $preparedQuery->execute();	
     return $result;
	}catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
	}
 }




  public function deleteProductByMerchantId($merchantId){
	$query = "delete from productdata where merchantId = :merchantId";
	try{
       $preparedQuery = $this->con->prepare($query);
       $preparedQuery->bindParam(':merchantId',$merchantId);
       $result = $preparedQuery->execute();
       return $result;
	}catch(Exception $e){
		file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
	}
 }

  public function getAllProductsByName($productName){
    $query = "select * from productdata where productName like ? OR productDescription like ?";
    try{
       $preparedQuery = $this->con->prepare($query);
       $preparedQuery->bindParam(1,"$productName%",PDO::PARAM_STR);
       $preparedQuery->bindParam(2,"$productName%",PDO::PARAM_STR);
       $preparedQuery->execute();
       $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
    }catch(Exception $e){
        file_put_contents("logfile", $e->getMessage()."\n",FILE_APPEND);
    }
  } 


}
