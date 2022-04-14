<?php
   
      $action='';
      if(isset($_GET['action'])){
          $action=$_GET['action'];
      }
      else{
          $action='manage';
      }

      if($action=='manage'){
          echo "welcome in manage page";
          echo '<a href="Dashboard.php?action=Insert">ADD new category</a>';
      }
      elseif($action=='Insert'){
        echo "welcome in ADD page";
        
    }
    elseif($action=='delete'){
        echo "welcome in delete page";
    }
    else 
    {
        echo "sorry you are not allowed";
    }
?>