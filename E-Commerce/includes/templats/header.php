<!DOCTYPE html>
<html>
<head>
<meta charset ="UTF-8"/>
<title><?php echo getTitle();?></title>
<!-- fontawsem link cdn-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--jquery link cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--bootstrap link cdn -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="stylesheet" href="front/css/front.css" />
</head>
<body>

<div class="upper-bar">
<div class="container">
<?php
if(isset($_SESSION['user'])){  
  ?>
       <div class="dropdown "> 
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <?php echo $_SESSION['user'];?>
       </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
    <li><a class="dropdown-item" href="newAdd.php">New Item</a></li>
    <li><a class="dropdown-item" href="profile.php#adds">My Adds</a></li>
    <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
  </ul>
</div>

<?php
  $usercase=checkUser($sessionUser);
  if($usercase==1){
     //echo "you are not activated";
  }
  else{

  }
   }
 else {?>
 <a href="login.php?action=login" class='login-link btn btn-primary'>Login</a>
or
 <a href="login.php?action=signup" class='signup-link btn btn-success'>SignUp</a>
<?php }?>
  <!--
<span class=" login-link"><a href="login.php">Login</a></span>
<span class=" signup-link"><a href="login.php">SignUp</a></span>
-->
</div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
  <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo"Homepage"?></a>
    <nav class="navbar navbar-expand-sm navbar-custom sticky-top ">
            <div class="container">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <!--to make the elemnts in the right-->
              <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                <ul class="navbar-nav ml-auto">
                <?php 
                  foreach(getCat('parent=0') as $cat){
                     
                 echo" <li class='nav-item'><a class='nav-link py-0 ' href='categories.php?pageid=".$cat['ID']."&pagename=".str_replace(' ','-',$cat['Name'])."'>".$cat['Name']."</a></li>";
                  }
                  ?>
                  <!--
                  <li class="nav-item">
                    <a class="nav-link py-0  " href="Items.php"><?php /*echo lang('items')*/?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="members.php?action=manage&UserID=<?php /*echo $_SESSION['UserID']?>"><?php echo lang('members')*/?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="comments.php"><?php/* echo lang('comments')*/?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="#"><?php /*echo lang('statistics')*/?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="#"><?php/* echo lang('logs')*/?></a>
                  </li>
                  -->
                 <!--
                  <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
       </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="members.php?action=Edit&UserID=<?php/* echo $_SESSION['UserID']*/?>">Edit Profile</a></li>
    <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
    <li><a class="dropdown-item" href="#">Settings</a></li>
    <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
  </ul>
</div>
-->
</div>
  </div>
  </div>
</nav>

