<?php
ob_start();
/*  manage the memebers*/
$pagetitle = 'Comments';
session_start();
 if(isset($_SESSION['username'])){
    include "init.php";
    $action=isset ($_GET['action']) ? $_GET['action'] :'manage';

    if($action=='manage'){// manage member page
    // not activated members
    $stmt=$con->prepare("SELECT comments.*,
    items.Name AS item_name,
    users.UserName 
from   
    comments
    INNER JOIN
    items
    ON
     items.Item_ID=comments.itemID
     INNER JOIN
     users
     on
     users.UserID=comments.userID
     ");
     $stmt->execute();
     $rows=$stmt->fetchAll();
     $count=$stmt->rowCount();


    ?>
    <h1 class="text-center">Manage Comments page </h1>
    <div class="container">
    <?php
     if($count > 0){ ?>
    <div class="table-responsive">
    <table class=" mainTable  text-center table table-bordered">
    <tr>
       <td>#ID</td>
       <td>Comment</td>
       <td>ItemName</td>
       <td>UserName</td>
       <td>AddedDate</td>
       <td>Controll</td>
  </tr>
  <?php
    foreach($rows as $row){
      echo "<tr>";
      echo "<td>".$row['C_ID']."</td>";
      echo "<td>".$row['comment']."</td>";
      echo "<td>".$row['item_name']."</td>";
      echo "<td>".$row['UserName']."</td>";
      echo "<td>".$row['c_date']."</td>";
      echo "<td>";
      echo "<a href='comments.php?action=Edit&CID=".$row['C_ID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
      echo " ";
      echo "<a href='comments.php?action=Delete&CID=".$row['C_ID']."'class='btn btn-danger delete confirm'><i class='fa fa-close'></i>Delete</a>";
      echo " ";
       if($row['status']==0){
       echo "<a href='comments.php?action=Approve&CID=".$row['C_ID']."'class='btn btn-info approve'><i class='fa fa-check'></i>Approve</a>";
       }
      "</td>";
      echo "</tr>";

    }
  }
  else
  {
    echo "<div class='container'>";
    $Msg="<div class='alert alert-danger'>"." Sorry,There is no comments"."</div>";
    redirectHome($Msg);
    echo "</div>";
  }
      ?>
    </div>
  </div>
       
    <?php 
    }

elseif($action=='Edit'){
  // check  if get user id  numeric and it is exist

$CID=isset($_GET['CID']) && is_numeric($_GET['CID'])? intval($_GET['CID']) : 0;
      // select all data for this id
$stmt=$con->prepare("SELECT * FROM comments WHERE C_ID=? ");
$stmt->execute(array($CID));
$row=$stmt->fetch();
$count=$stmt->rowCount();
//if there is id show the form 
 if($count >0 ){  ?>
  
    <!--form to edit personal settings-->
  <h1 class="text-center">EDIT YOUR Comment</h1>
<div class="container h-100">
<div class="row h-100 justify-content-center align-items-center">
<div class=" col-sm-4">
<form class="form-example " id="form-login"  action="?action=Update" method="POST"> 
<input type="hidden" name="CID" value="<?php echo $CID ?>"/>
<div class="form-group ">
<label  class="control-label"for="exampleInputEmail1">Comment</label>
 <textarea  class="form-control "name="comment"><?php echo $row['comment'] ?></textarea>
</div>

<!--
<div class="form-check">
<input type="checkbox" class="form-check-input" id="exampleCheck1">
<label class="form-check-label" for="exampleCheck1">Check me out</label>
 </div>
-->
<div class="form-group">        
  <div class="col-sm-offset-7 col-sm-4">
    <button type="submit" class=" bb btn btn-primary btn-block">Submit</button>
  </div>
</div>
</form>
</div>
</div>
</div>
  <?php
}
// else show the error message
else {
  echo "<div class='container'>";
   $Msg="<div class='alert alert-danger'>"."There is no such ID"."</div>";
   redirectHome($Msg);
   echo "</div>";
}
} 

   
 elseif($action=='Update'){ //update page

   //echo "<div class=' text-center container>";
   echo "<h1 class='text-center'>Update YOUR DATA</h1>";
  // echo '<div class="container h-100>';
   echo '<div class="d-flex justify-content-center">';
   echo '<div class=" col-sm-8">';
  
   if($_SERVER['REQUEST_METHOD']=='POST'){
     $CID=$_POST['CID'];
     $comment=$_POST['comment'];
   
     ////
     ////
     ////
    // validate the form 
        // the first way to secure the data in pdo  => ?
     $stmt=$con->prepare("UPDATE comments  SET comment=? WHERE C_ID=? ");
     $stmt->execute(array($comment,$CID));
      $Msg="<div class='alert alert-success'>".$stmt->rowCount().'  Record Updated </div>';
      redirectHome($Msg,'Back');

   }
   else{
      $Msg="<div class='alert alert-danger'>sorry you cant visit this page directory</div>";
      redirectHome($Msg);
   }
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
elseif ($action=="Delete"){
 echo "<h1 class='text-center'>Delete  comment page </h1>";
  echo "<div class='container'>";
  $CID=isset($_GET['CID']) && is_numeric($_GET['CID'])? intval($_GET['CID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM comments WHERE C_ID=? ");
    $stmt->execute(array($CID));
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count>0 ){
       $stmt=$con->prepare("DELETE FROM comments WHERE C_ID=:Zuser");
       $stmt->bindParam(":Zuser", $CID);
       $stmt->execute();
       $Msg="<div class='alert alert-success'>".$stmt->rowCount().'  Record Deleted </div>';
       redirectHome($Msg,'back');
}
else{
  $Msg="<div class='alert alert-danger'>"."Sorry,This Member Doesn't Exist !! "."</div>";
  redirectHome($Msg);
}
echo "</div>";
}
elseif ($action=="Approve"){
  echo "<h1 class='text-center'> Activate comment page </h1>";
   echo "<div class='container'>";
   $CID=isset($_GET['CID']) && is_numeric($_GET['CID'])? intval($_GET['CID']) : 0;
           // select all data for this id
     $stmt=$con->prepare("SELECT * FROM comments WHERE C_ID=?");
     $stmt->execute(array($CID));
     $count=$stmt->rowCount();
     //if there is id show the form 
      if($count>0 ){
        $stmt=$con->prepare("UPDATE comments  SET status =1 WHERE C_ID=? ");
        $stmt->execute(array($CID));
        $Msg="<div class='alert alert-success'>".$stmt->rowCount().'  Record Activated </div>';
        redirectHome($Msg,'back');
 }
 else{
   $Msg="<div class='alert alert-danger'>"."Sorry,This Member Doesn't Exist !! "."</div>";
   redirectHome($Msg);
 }
 echo "</div>";
 }
    include $tpl."footer.php";
 /*else {
     header('Location:index.php');
     exit();
 }
 */

 }
ob_end_flush();

?>