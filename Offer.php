<?php
 /*
 @Author Raja Bose
 @Created at 4th august 2017
 *it is used to save product and get product detail
 */

 //include("connection.php");
 class Offer{
   
    private $con;

    function  __construct(){
         include_once dirname(__FILE__).'connection.php';
         $db =  new DbConnect();
         $this->con = $db->getConnect();
    }


     public function saveOffer($userId,$merchantName,$offerDescription,$city,$latitude,$longitude){
         $insertQuery = "insert into offerdata(userId,merchantName,offerDescription,city,latitude,longitude,addedDate) values(:userId,:merchantName,:offerDescription,:city,:latitude,:longitude,:addedDate)";
       try{
         $date = date('y-m-d  H::i:s');
         $prepareQuery = $this->con->prepare($insertQuery);
         $prepareQuery->bindParam(":userId",$userId);
         $prepareQuery->bindParam(":merchantName",$merchantName);
         $prepareQuery->bindParam(":offerDescription",$offerDescription);
         $prepareQuery->bindParam(":city",$city);
         $prepareQuery->bindParam(":latitude",$latitude);
         $prepareQuery->bindParam(":longitude",$longitude);
         $prepareQuery->bindParam(":addedDate",$date);
         $prepareQuery->execute();
         $result = $this->con->lastInsertId();
         return $result;
      }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
      }
     }

     /*delete offer of merchant by offerId*/
     public function deleteOfferByOfferId($offerId){
       $deleteOrder = "delete from offerdata where offerId = :offerId";
       try{
       $prepareQuery = $this->con->prepare($deleteOrder); 
       $prepareQuery->bindParam(":offerId",$offerId);
       $result = $prepareQuery->execute();
       return $result;
     }catch(Exception $e){
         file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND); 
     }

     }

    /*offer of merchant inside 1 month for merchant*/
     public function getOfferByMerchnatName($merchantName,$offset){
        $limit = 100;
        $query = "select * from offerdata where merchantName = :merchantName LIMIT $offset,$limit ORDER BY addedDate DESC";
        try{
       $prepareQuery = $this->con->prepare($query);
       $prepareQuery->bindParam(":merchantName",$merchantName);
       $prepareQuery->execute();
       $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
     
       }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }
     }

    /*offer of all merchant within city for 1 months offer*/
     public function getOfferByCity($city,$offset){
     	$limit = 100;
        $query = "select * from offerdata where city = :city LIMIT $offset,$limit ORDER BY addedDate DESC";
       try{
       $prepareQuery = $this->con->prepare($query);
       $prepareQuery->bindParam(":city",$city);
       $prepareQuery->execute();
       $result = $prepareQuery->fetch(PDO::FETCH_ASSOC);
       return $result;
     
       }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
       }          
     }


     /*delete all offer of merchant*/
     public function deleteOffer($merchantName){
          $deleteOffer = "delete from offerdata where merchantName = :merchantName";
          try{
           $prepareQuery = $this->con->prepare($deleteOffer);
           $prepareQuery->bindParam(":merchantName",$merchantName);
           $result = $prepareQuery->execute();
           return $result;
          }catch(Exception $e){
               file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
          }
     }

    
     /*delete offer of merchant By date range*/
     public function deleteOfferByDate($merchantName,$endTime){
          $deleteOffer = "delete from offerdata where merchantName = :merchantName and addedDate <= :endTime";
          try{
           $prepareQuery = $this->con->prepare($deleteOffer);
           $prepareQuery->bindParam(":merchantName",$merchantName);
           $prepareQuery->bindParam(":endTime",$endTime);
           $result = $prepareQuery->execute();
           return $result;
          }catch(Exception $e){
               file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
          } 
     }


     public function updateOffer($query,$fields){
     	 $updateQuery = $query." where offerId = :offerId";
     	 try{
              $prepareQuery = $this->con->prepare($updateQuery);
              foreach ($fields as $key => $value) {
              	 $prepareQuery->bindParam($key,$value);
              }
              $result =  $prepareQuery->execute();
              return $result;
     	 }catch(Exception $e){
           file_put_contents("logfile",$e->getMessage()."\n",FILE_APPEND);
     	 }

     }

}

?>
