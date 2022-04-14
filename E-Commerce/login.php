<?php 
ob_start();
session_start();
$pagetitle='Login';
/*if(isset($_SESSION['user'])){
header('Location:index.php');}
*/
include 'init.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['login'])){
  $username=$_POST['user'];
  $password=$_POST['passwordd'];
  $hashpass=sha1(($password));
  //$_SESSION['userdata']=$_POST['username'];
 
  //to check if admin exist in data base
  $stmt=$con->prepare("SELECT UserID, UserName, Passsword FROM users WHERE UserName= ? AND Passsword= ? ");
  $stmt->execute(array($username,$hashpass));
  $get=$stmt->fetch();
  $count=$stmt->rowCount();
   if($count >0 ){
   $_SESSION['user']=$username; // save session name 
   $_SESSION['uid']=$get['UserID']; // save the id of user 
       //register session name    
   header('Location:index.php');// to move to another page
   exit(); 
   }
  }

  else{
    $firstName=$_POST['FirstName'];
    $secondName=$_POST['SecondName'];
    $hashpass1=sha1($_POST['password1']);
    $hashpass2=sha1($_POST['password2']);
    $email=$_POST['Email'];
    $fullName=$firstName.$secondName;
    //$_SESSION['userdata']=$_POST['username'];
   
    //to check if admin exist in data base
    /*
    $stmt=$con->prepare("INSERT INTO users (UserName,Passsword,Email,FullName,RegStatus,Date)
   VALUES(:u_name,:p_ass,:e_mail,:f_name,0,now())");
    $stmt->execute(array(
    'u_name'=>$username,
    'p_ass'=>$hashpass,
    'e_mail'=>$email,
    'f_name'=>$full));
    $count=$stmt->rowCount();
    if($count >0 ){
     $_SESSION['user']=$username;
         //register session name    
     header('Location:index.php');// to move to another page
     exit(); 
     }
     
     else{
       */
     $formErrors=array();
     //FILTER_FLAG_STRIP_HIGH => to remove all characters that is greater than 127 in Ascii
     if (isset($firstName)){
      $filterFname=filter_var($firstName,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        if(strlen($filterFname)<3){
          $formErrors[]=" Name shoud be more than  2 character";
        }
     }
     if (isset($secondName)){
      $filterSname=filter_var($secondName,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        if(strlen($filterSname)<3){
          $formErrors[]=" Name shoud be more than 2 character";
        }
     }
     if (isset($hashpass1)&&isset($hashpass2)){
        if($hashpass1 !== $hashpass2){
          $formErrors[]="Sorry check your password";
        }
     }
     if (isset($email)){
         $filterEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
         if(filter_var($filterEmail,FILTER_VALIDATE_EMAIL)== false){
          $formErrors[]="Sorry your email is not validate";
        }
     }
     if(empty($formErrors)){
      // the second check (if the user exist)
      $check=checkItem("UserName","Email","users",$filterFname,$filterEmail);
      if($check==1){
        $formErrors[]=" Sorry This Member Alreday Exist !!!";
      }
      else{
        // the second way to secure data in pdo => using :name
            $stmt=$con->prepare("INSERT INTO users (UserName,Passsword,Email,FullName,RegStatus,Date)
            VALUES(:u_name,:p_ass,:e_mail,:f_name,0,now())");
            $stmt->execute(array(
            'u_name'=>$filterFname,
            'p_ass'=>$hashpass1,  
            'e_mail'=>$filterEmail,
            'f_name'=>$fullName));
            $sucessData="Congrats you are now member in our site";
            $sucessData2="  You will be move to the home page now";

   }
 }
     }

     //}

  }
  





?>


<?php
$action=isset($_GET['action']) ? $_GET['action'] :'manage';
 if($action=='login'){?>
<h1 class="text-center">Login</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
       <!-- Login form -->
    <form class="form-example " id="form-login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Your name</label>
    <input type="name"  name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="" required="required">
  </div>
  <div class="form-group ">
    <label class="control-label" for="exampleInputPassword1">Password</label>
		<input type="password" name="passwordd" class=" password form-control" autocomplete="new-password" placeholder=""  required="required">
    <i class="show-pass fa fa-eye fa-2x"></i>
  </div>
  <!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" name="login" class=" bb btn btn-primary btn-block">Continue</button>
      </div>
    </div>
</form>

<?php
}
else{?>

        <!-- Sign up  form -->
    <h1 class="text-center">SignUp</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <div class="The-Errors">
<?php
if(!empty($formErrors)){
  foreach($formErrors as $error){
    echo '<div class="  period Mssg alert alert-danger">'.$error. '</div>';
  }
}
  if (isset($sucessData)){
    echo '<div class="  alert alert-success">'.$sucessData. '</div>';
    echo '<div class="  alert alert-primary">'.$sucessData2. '</div>';
    header("refresh:2;url=index.php");
  }

?>
</div>
<form class="form-example  signup" id="form-login"  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">FirstName</label>
    <input  pattern=".{3,15}"
            title="User Name should be more than 2 chars"
    type="name"  name="FirstName" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="" required="required">
  </div>
  <div class="form-group ">
    <label  class="control-label" for="exampleInputPassword1">SecondName</label>
    <input  pattern=".{3,15}"
            title="User Name should be more than 2 chars"
     type="name"  name="SecondName"class="form-control" id="exampleInputPassword1"  required="required">
  </div>
  <div class="form-group ">
    <label  class="control-label"  for="exampleInputPassword1">Password</label>
		<input  minlength="4" type="password" name="password1" id="myInput"  class=" password form-control" autocomplete="new-password" placeholder=" At least 6 characters "  required="required">
    <!--<input type="checkbox" onclick="myFunction()"> Show Password-->
    <!--<i class="show-pass fa fa-eye fa-2x"></i>-->
  </div>
  <div class="form-group ">
    <label class="control-label"  for="exampleInputPassword1">Re-enter password</label>
		<input  minlength="4" type="password" name="password2" class=" password form-control" autocomplete="new-password" placeholder=" Enter a password again "  required="required">
    <i class="show-pass fa fa-eye fa-2x"></i>
  </div>
  <div class="form-group ">
    <label class="control-label" for="exampleInputPassword1">Email</label>
    <input type="text"  name="Email"class="form-control" id="exampleInputPassword1"  placeholder="Email should be professional" required="required">
    
   

  <!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" name="signup" class=" bb btn btn-success btn-block">Create your Amazon account</button>
      </div>
    </div>
</form>

</div>
</div>
<?php }?>

<?php include $tpl.'footer.php';
ob_end_flush();
?>