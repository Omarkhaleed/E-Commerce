<?php
ob_start();
/*  manage the memebers*/
$pagetitle = 'Members';
session_start();
 if(isset($_SESSION['username'])){
  
    include "init.php";
    $action=isset ($_GET['action']) ? $_GET['action'] :'manage';


    if($action=='manage'){// manage member page
    // not activated members
    $query='';
    if(isset($_GET['page']) && $_GET['page']=='pending'){
      $query='AND RegStatus= 0';
     $stmt=$con->prepare("SELECT * FROM users WHERE GroupID!=1 $query");
     $stmt->execute();
     $rows=$stmt->fetchAll();
     $count=$stmt->rowCount();
    }
    else {
     $query='AND RegStatus= 1';
     $stmt=$con->prepare("SELECT * FROM users WHERE GroupID!=1 $query");
     $stmt->execute();
     $rows=$stmt->fetchAll();
     $count=$stmt->rowCount();
    }
    ?>
    <h1 class="text-center">Manage member page </h1>
    <div class="container">
    <?php if ( $count > 0 ){?>
    <a href="members.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> new member</a>
    <div class="table-responsive">
    <table class=" mainTable  text-center table table-bordered">
    <tr>
       <td>#ID</td>
       <td>UserName</td>
       <td>Email</td>
       <td>FullName</td>
       <td>RegisterdDate</td>
       <td>Controll</td>
  </tr>
  <?php
    foreach($rows as $row){
      echo "<tr>";
      echo "<td>".$row['UserID']."</td>";
      echo "<td>".$row['UserName']."</td>";
      echo "<td>".$row['Email']."</td>";
      echo "<td>".$row['FullName']."</td>";
      echo "<td>".$row['Date']."</td>";
      echo "<td>";
      echo "<a href='members.php?action=Edit&UserID=".$row['UserID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
      echo " ";
      echo "<a href='members.php?action=Delete&UserID=".$row['UserID']."'class='btn btn-danger delete confirm'><i class='fa fa-close'></i>Delete</a>";
      echo " ";
       if($row['RegStatus']==0){
       echo "<a href='members.php?action=Activate&UserID=".$row['UserID']."'class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
       }
      "</td>";
      echo "</tr>";

    }
  }
    else{
      echo "<div class='container'>";
      $Msg="<div class='alert alert-danger'>"." Sorry,There is no members"."</div>";
      echo "<a href='Items.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> new member</a>";
      redirectHome($Msg);
      echo "</div>";
    }
      ?>
    </div>
  </div>
     
        
    <?php 
    }
    elseif($action=='Add'){//add members page
      ?>
      
        <!--form to edit personal settings-->
        <h1 class="text-center">ADD YOUR  NEW MEMBER</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <form class="form-example " id="form-login"  action="?action=Insert" method="POST"> 
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">UserName</label>
    <input type="name"  name="UserName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="" required="required">
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">Password</label>
		<input type="password" name="passsword" class=" password form-control" autocomplete="new-password" placeholder="password should be complex "  required="required">
    <i class="show-pass fa fa-eye fa-2x"></i>
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">Email</label>
    <input type="Email"  name="Email"class="form-control" id="exampleInputPassword1"  placeholder="Email should be professional" required="required">
    
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">FullName</label>
    <input type="name"  name="FullName"class="form-control" id="exampleInputPassword1"  required="required">
  </div>
<!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class=" bb btn btn-primary btn-block"> Add member</button>
      </div>
    </div>
</form>
    </div>
    </div>
    </div>
      <?php
    }

    elseif($action=='Insert'){
      //insert memeber's data in database
      
       if($_SERVER['REQUEST_METHOD']=='POST'){
         $name=$_POST['UserName'];
         $pas=$_POST['passsword'];
         $email=$_POST['Email'];
         $full=$_POST['FullName'];

         $pasw=sha1($_POST['passsword']);
        

         echo "<h1 class='text-center'>ADD your new member </h1>";
      // echo '<div class="container h-100>';
         echo '<div class="d-flex justify-content-center">';
         echo '<div class=" col-sm-8">';
          
         /*
         ////
         ////
         ////
         */ 
        // validate the form 
        // the first check (errors)
         $array_errors=array();
         if(strlen($name)>8){
            $array_errors[]="sorry  username <strong>can't be this size</strong></div>";
        }
          if(strlen($name)<3){
            $array_errors[]="sorry  username <strong> can't be this size </strong> </div>";
          }
          if(empty($email)){
            $array_errors[]="sorry  email <strong>can't be empty</strong> </div>";
          }
    
          if(empty($full)){
            $array_errors[]="sorry  fullname <strong>can't be empty</strong> </div>";
          }
    
          if(empty($pas)){
            $array_errors[]="sorry  password <strong>can't be empty</strong> </div>";
          }
          foreach($array_errors as $error){
            echo "<div class='alert alert-danger'>".$error;
          }
            
           
          if(empty($array_errors)){
            // the second check (if the user exist)
            $check=checkItem("UserName","Email","users",$name,$email);
            if($check==1){
              $Msg="<div class='alert alert-danger'>"."Sorry This Member Alraedy Exist"."</div>";
              redirectHome($Msg,"Back");
            }
            else{
              // the second way to secure data in pdo => using :name
         $stmt=$con->prepare("INSERT INTO users (UserName,Passsword,Email,FullName,RegStatus,Date)
         VALUES(:u_name,:p_ass,:e_mail,:f_name,1,now())");
         $stmt->execute(array(
         'u_name'=>$name,
         'p_ass'=>$pasw,
         'e_mail'=>$email,
         'f_name'=>$full));
        $Msg="<div class='alert alert-success'>".$stmt->rowCount().'  Record Inserted </div>';
        redirectHome($Msg,"Back");
         }
       }
      }
       else{
         echo "<div class='container'>";
         $Msg="<div class='alert alert-danger'>Sorry You Can't Browse This Page Directly</div>";
          redirectHome($Msg);
          echo "</div>";
       }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
  
      
    elseif($action=='Edit'){
      // check  if get user id  numeric and it is exist

  $UserID=isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1 ");
    $stmt->execute(array($UserID));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count >0 ){  ?>
      
        <!--form to edit personal settings-->
        <h1 class="text-center">EDIT YOUR DATA</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <form class="form-example " id="form-login"  action="?action=Update" method="POST"> 
    <input type="hidden" name="UserID" value="<?php echo $UserID ?>"/>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">UserName</label>
    <input type="name"  name="UserName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $row['UserName'] ?>" placeholder="" required="required">
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">Password</label>
		<input type="password" name="newpasssword" class="form-control" autocomplete="new-password" placeholder="write the old password If You Dont Want To Change" required="required" >
   
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">Email</label>
    <input type="Email"  name="Email"class="form-control" id="exampleInputPassword1" value="<?php echo $row['Email'] ?>" placeholder="" required="required">
  </div>
  <div class="form-group ">
    <label for="exampleInputPassword1">FullName</label>
    <input type="name"  name="FullName"class="form-control" id="exampleInputPassword1" value="<?php echo $row['FullName'] ?>" value= placeholder="" required="required">
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
} elseif($action=='Update'){ //update page

   //echo "<div class=' text-center container>";
   echo "<h1 class='text-center'>EDIT YOUR DATA</h1>";
  // echo '<div class="container h-100>';
   echo '<div class="d-flex justify-content-center">';
   echo '<div class=" col-sm-8">';
  
   if($_SERVER['REQUEST_METHOD']=='POST'){
     $id=$_POST['UserID'];
     $name=$_POST['UserName'];
     $email=$_POST['Email'];
     $full=$_POST['FullName'];
     $pasw=sha1($_POST['newpasssword']);
      
     /*
     ////
     ////
     ////
     */ 
    // validate the form 
     $array_errors=array();
     if(strlen($name)>15){
        $array_errors[]="sorry  username <strong>can't be this size</strong></div>";
    }
      if(strlen($name)<3){
        $array_errors[]="sorry  username <strong> can't be this size </strong> </div>";
      }
      if(empty($email)){
        $array_errors[]="sorry  email <strong>can't be empty</strong> </div>";
      }

      if(empty($full)){
        $array_errors[]="sorry  fullname <strong>can't be empty</strong> </div>";
      }

      if(empty($pasw)){
        $array_errors[]="sorry  password <strong>can't be empty</strong> </div>";
      }
      foreach($array_errors as $error){
        echo "<div class=' redMessage alert alert-danger'>".$error;
      }
        

      if(empty($array_errors)){
        $check=checkItem("UserName","Email","users",$name,$email);
        if($check==1){
          $Msg="<div class='redMessage alert alert-danger'>"."Sorry This Member Alraedy Exist"."</div>";
          redirectHome($Msg,"Back");
        }
        else{
        // the first way to secure the data in pdo  => ?
     $stmt=$con->prepare("UPDATE users  SET UserName=?,Passsword=?, Email=?, FullName=? WHERE UserID=? ");
     $stmt->execute(array($name,$pasw,$email,$full,$id));
      $Msg="<div class=' greenMessage alert alert-success'>".$stmt->rowCount().'  Record Updated </div>';
        redirectHome($Msg,'Back');
        }

    }
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
 echo "<h1 class='text-center'>Delete  member page </h1>";
  echo "<div class='container'>";
  $UserID=isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1 ");
    $stmt->execute(array($UserID));
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count>0 ){
       $stmt=$con->prepare("DELETE FROM users WHERE UserID=:Zuser");
       $stmt->bindParam(":Zuser", $UserID);
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
elseif ($action=="Activate"){
  echo "<h1 class='text-center'> Activate member page </h1>";
   echo "<div class='container'>";
   $UserID=isset($_GET['UserID']) && is_numeric($_GET['UserID'])? intval($_GET['UserID']) : 0;
           // select all data for this id
     $stmt=$con->prepare("SELECT * FROM users WHERE UserID=?");
     $stmt->execute(array($UserID));
     $count=$stmt->rowCount();
     //if there is id show the form 
      if($count>0 ){
        $stmt=$con->prepare("UPDATE users  SET RegStatus =1 WHERE UserID=? ");
        $stmt->execute(array($UserID));
        $Msg="<div class='alert alert-success'>".$stmt->rowCount().'  Record Activated </div>';
        redirectHome($Msg);
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