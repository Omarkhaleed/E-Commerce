<?php
   
   // version 1 
   /* title function echo the page title if the page contains the variable $pageTitle
   else  echo the defuilt title
   */
  function getTitle(){
      global $pagetitle;
      if(isset($pagetitle)){
          echo $pagetitle;
      }
      else
      {
          echo "default";
      }

  }
  /* version 2.0
  // Home Redirect Function if you entered the page directly from the url
  // $theMsg= [error message  or  success or warning ]
  // $url= the page that  you will go to it 
  //$seconds= the time before Redirecting
  */ 
      
  function getAllFrom($table){
    global $con;
    $getAll=$con->prepare("SELECT * FROM $table where parent=0 ");
    $getAll->execute();
    $All=$getAll->fetchAll();
    return $All;
}
  
   function redirectHome($Msg,$url=null,$seconds=3){
       if($url===null){
           $url="Dashboard.php";
           $link="Home page";
       }
       else
       {
           if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=''){
               $url=$_SERVER['HTTP_REFERER'];
               $link="previos page";
           }
           else{
               $url="Dashboard.php";
               $link="Home page";
           }
       }
    
    echo '<div class="d-flex justify-content-center">';
    echo '<div class=" col-sm-8">';
       echo $Msg;
       echo "<div class=' blueMessage alert alert-info'>You will be redirected to the $link after $seconds seconds.</div>";
       echo "</div>";
       echo "</div>";
       header("refresh:$seconds;url=$url");
       exit();
   }
     /*
     // check items function version 1
     take 3 arguments $select,$from,$value
     */
      function  checkItem($select1,$select2,$from,$value1,$value2){
          global $con;
          $statement=$con->prepare("SELECT $select1,$select2 FROM $from WHERE $select1=? AND $select2=?");
          $statement->execute(array($value1,$value2));
          $count=$statement->rowCount();
          return  $count;
      }
       //partly we make this function on one parameter to check
      function  checkItem1($select1,$from,$value1){
        global $con;
        $statement=$con->prepare("SELECT $select1 FROM $from WHERE $select1=?");
        $statement->execute(array($value1));
        $count=$statement->rowCount();
        return  $count;
    }
     
       
      /* count numbers of items v1.0*/
        
      function countItems($items,$table,$query){
       global $con;
       $state2=$con->prepare("SELECT COUNT($items) FROM  $table WHERE GroupID=0 AND $query");
        $state2->execute();
         return  $state2->fetchColumn();
      }
      // count numbers of items without condition
      function count_Items($items,$table,$case){
        global $con;
        $state1=$con->prepare("SELECT COUNT($items) FROM  $table where $case=1");
         $state1->execute();
         return  $state1->fetchColumn();
       }
     /* to get the number of latest items or members*/
       function getLatest($select,$table,$order,$limit=5){
           global $con;
           $getStmt=$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
           $getStmt->execute();
           $rows=$getStmt->fetchAll();
           return $rows;
       }
        /* to get the categories */
       function getCat($col="parent=Null"){
        global $con;
        $getCat=$con->prepare("SELECT * FROM categories where  $col ORDER BY ID ASC ");
        $getCat->execute();
        $Cats=$getCat->fetchAll();
        return $Cats;
    }



      ?>