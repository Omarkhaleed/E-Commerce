<?php

/*if(isset($_SESSION['username'])){
header('Location:Dashboard.php');
}
*/
ob_start();
session_start();
$pagetitle='Home page';
   include "init.php";
  ?>

<div class="container">
  <h1 class="text-center"> Show Categoty</h1>
  <div class="row">
  <?php
  $item=getAllFrom('items'); 
  foreach($item as $items){
      echo "<div class='col-sm-6 col-md-3'>";
      echo "<div class='img-thumbnail item-box'>";
      echo "<span class='price-tag'>".$items['Price']."</span>";
      echo "<img class='image-responsive' src ='pexels.jpg' alt=''/>";
      echo "<div class='caption'>";
      echo '<h3><a href="items.php?ItemID='.$items['Item_ID'].'">'.$items['Name'].'</h3></a>';
      echo "<p>".$items['Description']."</p>";
      echo "<div class='date'>".$items['AddDate']."</div>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
  } 
  ?> 
  </div>
  </div>  

<?php

   include $tpl."footer.php";
   ob_end_flush();
?>