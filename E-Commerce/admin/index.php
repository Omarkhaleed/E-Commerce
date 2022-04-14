<?php
session_start();
$noNavbar="";
$pagetitle='Login';
/*if(isset($_SESSION['username'])){
header('Location:Dashboard.php');
}
*/
include "init.php";

//to check if user comming from HTTP post request
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    //$_SESSION['userdata']=$_POST['username'];
    $hashpass=sha1(($password));
    //to check if admin exist in data base
    $stmt=$con->prepare("SELECT  UserID,UserName, Passsword FROM users WHERE UserName= ? AND Passsword= ? AND GroupID=1 LIMIT 1 ");
    $stmt->execute(array($username,$hashpass));
    $row=$stmt->fetch();
    $count=$stmt->rowCount();
     if($count >0 ){
     $_SESSION['username']=$username;
     $_SESSION['UserID']=$row['UserID']; //register session name    
     header('Location:Dashboard.php');// to move to another page
     exit(); 
     }
}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input  class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off" />
    <input  class="form-control"type="password" name="pass" placeholder="password" autocomplete="new-password" />
    <div class="col-sm-offset-8 col-sm-4">
    <button type="submit" class=" bb form-control btn btn-primary">Login</button>
    </div>
    </form>
   

<?php
include $tpl."footer.php";
?>