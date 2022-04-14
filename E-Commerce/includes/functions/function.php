<?php

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
/* to get the categories */
function getCat($col="parent=Null"){
    global $con;
    $getCat=$con->prepare("SELECT * FROM categories where  $col ORDER BY ID ASC ");
    $getCat->execute();
    $Cats=$getCat->fetchAll();
    return $Cats;
}
/* to get  all the categories */
function getAllFrom($table){
    global $con;
    $getAll=$con->prepare("SELECT * FROM $table ");
    $getAll->execute();
    $All=$getAll->fetchAll();
    return $All;
}
/* to get the items */

function getItem($colName,$value,$case){
    global $con;
    $getItem=$con->prepare("SELECT * FROM items where $colName=? AND Approve=$case ORDER BY Item_ID DESC limit 8 ");
    $getItem->execute(array($value));
    $items=$getItem->fetchAll();
    return $items;
} 
/* check the member is exist or no */
function  checkItem($select1,$select2,$from,$value1,$value2){
    global $con;
    $statement=$con->prepare("SELECT $select1,$select2 FROM $from WHERE $select1=? AND $select2=?");
    $statement->execute(array($value1,$value2));
    $count=$statement->rowCount();
    return  $count;
}
/* function to check if the user is not activated */
  function checkUser($user){
      global $con;
    $stmt=$con->prepare("SELECT username, RegStatus FROM users WHERE UserName= ? AND RegStatus=0 ");
    $stmt->execute(array($user));
    $status=$stmt->rowCount();
    return $status;
  }





?>