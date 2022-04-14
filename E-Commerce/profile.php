<?php
session_start();
$pagetitle='Profile';
   include "init.php";

  if (isset($_SESSION['user'])){
    $getuser=$con->prepare("select * from users where UserName=?");
    $getuser->execute(array($sessionUser));
    $info=$getuser->fetch();
    ?>

<h1 class="text-center">Welcome to my profile</h1>
<div class="myInformation info2">
<div class="container">
<div class="card">
  <h5 class="card-header bg-primary">myInfo</h5>
  <div class="card-body">
    <ul class=" list-unstyled card-text">
    <li>
    <i class="fa fa-unlock-alt fa-fw"></i>
      <span>Name</span>:<?php echo $info['UserName'];?></li>
    <li>
    <i class="fa fa-envelope"></i>
      <span>Email</span>:<?php echo $info['Email'];?></li>
    <li>
    <i class="fa fa-user"></i>
      <span>Full Name</span>:<?php echo $info['FullName'];?></li>
    <li>
    <i class="fa fa-calendar"></i>
      <span>Register Date</span>:<?php echo $info['Date'];?></li>
    <li>
    <i class="fa fa-tags"></i>
      <span>Favourite category</span>:<?php echo $info['UserName'];?></li>
   </ul>
    <a href="#" class="btn btn-dark">Edit</a>
  </div>
</div>
      </div>
    </div>
    <div id= "adds" class="myAds info">
<div class="container">
<div class="card">
  <h5 class="card-header bg-primary">My Items</h5>
  <div class="card-body">
    <h5 class="card-title">The Latest Eight Ads</h5>
    <div class="card-text">
    <div class="row">
    <?php
       $item=getItem('Member_ID',($info['UserID']),1); 
       if(!empty($item)){
       foreach($item as $items){
           echo "<div class='col-sm-6 col-md-3'>";
           echo "<div class='img-thumbnail item-box'>";
           echo "<span class='price-tag'>".'$'. $items['Price']."</span>";
           echo "<img class='image-responsive img-rounded' src ='pexels.jpg' width = '100%' height = '200' alt=''/>";
           echo "<div class='caption'>";
           echo '<h3><a href="items.php?ItemID='.$items['Item_ID'].'">'.$items['Name'].'</h3></a>';
           echo "<p>".$items['Description']."</p>";
           echo "<div class='date'>".$items['AddDate']."</div>";

           echo "</div>";
           echo "</div>";
           echo "</div>";
       }
      }
      else{ 
          echo "<h4>Sorry, There is no adds to show</h4> ";

      }
    ?>
    </div>
    </div>
  </div>
</div>

<div    class="myAds info">
<div class="container">
<div class="card">
  <h5 class="card-header bg-primary">my NOT APPROVED Items</h5>
  <div class="card-body">
    <h5 class="card-title">The Latest Eight Ads</h5>
    <div class="card-text">
    <div class="row">
    <?php
       $item=getItem('Member_ID',($info['UserID']),0); 
       if(!empty($item)){
       foreach($item as $items){
           echo "<div class='col-sm-6 col-md-3'>";
           echo "<div class='img-thumbnail item-box'>";
           echo "<span class='price-tag'>".'$'. $items['Price']."</span>";
           echo "<img class='image-responsive img-rounded' src ='pexels.jpg' width = '100%' height = '200' alt=''/>";
           echo "<div class='caption'>";
           echo '<h3><a href="items.php?ItemID='.$items['Item_ID'].'">'.$items['Name'].'</h3></a>';
           echo "<p>".$items['Description']."</p>";
           echo "<div class='date'>".$items['AddDate']."</div>";

           echo "</div>";
           echo "</div>";
           echo "</div>";
       }
      }
      else{ 
          echo "<h4>Sorry, There is no adds to show</h4> ";

      }
    ?>
    </div>
    </div>
   
  </div>
</div>
      </div>
    </div>


      </div>
    </div>
    <div class="myComments info">
<div class="container">
<div class="card">
  <h5 class="card-header bg-primary">myComments</h5>
  <div class="card-body">
  
    <a href="#" class="btn btn-dark">Go somewhere</a>
  </div>
</div>
      </div>
    </div>
<?php 
 }
else{
  header('Location:login.php');
  exit();
}
  
 include $tpl."footer.php";
?>