<?php
 ob_start();
session_start();
 if(isset($_SESSION['username'])){
    $pagetitle='Dashboard';
    include "init.php";
    /*start dashboard page*/
       // the function of getting latest items and users
      $numLatest=4;
      $latestUsers=getLatest('*','users','UserID',$numLatest);
      $numItems=4;
      $latestItems=getLatest('*','items','Item_ID',$numItems);
      $numcomments=4;
      $latestcomments=getLatest('*','comments','C_ID',$numcomments);
     ?>
     <div class="container home-stats text-center">
         <h1>Dashboard</h1>
         <div class="row">
             <div class="col-md-3">
                 <div class="stat tmembers">
                 <i class="fa fa-users"></i>
                 <div class="info">
                 <strong>Total Members</strong>
                     <span><a href="members.php"><?php echo countItems('UserID','Users','RegStatus=1')?></a></span>
                    </div>
                    </div>
             </div>
             <div class="col-md-3">
                 <div class="stat tpending">
                 <i class="fa fa-user-plus"></i>
                 <div class="info">
                     <strong>Pending Members</strong>
                    <span><a href="members.php?action=manage&page=pending"><?php echo countItems('UserID','Users','RegStatus=0')?></span></a>
                </div>
             </div>
 </div>
             <div class="col-md-3">
                 <div class="stat titems">
                 <i class="fa fa-tag"></i>
                 <div class="info">
                     <strong> Total Items</strong>
                     <span><a href="Items.php"><?php echo count_Items('Name','items','Approve')?></span></a>
                    </div>
 </div>
             </div>
             <div class="col-md-3">
                 <div class="stat tcomments">
                 <i class="fa fa-comments"></i>
                 <div class="info">
                     <strong>Total Comments</strong>
                     <span><a href="comments.php"><?php echo count_Items('C_ID','comments','status')?></span></a>
                    </div>
             </div>
 </div>
          </div>
     </div>

     <div class="container latest">
         <div class="row">
          <div class="col-sm-6">
            <div class="card">
                <div class="card-header  text-white bg-dark">
                    <i class="fa fa-users"></i>
                    latest <?php  echo $numLatest;?> registerd users
                </div>
                <div class="card-body">
                <ul class="list-unstyled latestUsers">
                    <?php 
                    if(!empty($latestUsers)){
                     foreach($latestUsers as $user){
                         echo "<li>".$user['Email']."</li>";
                     }
                    }
                    else
                    {
                        echo "There is no users";
                    }
                     
                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header text-white bg-dark">
                    <i class="fa fa-tag"></i>
                    latest <?php  echo $numItems;?> Items added
                </div>
                <div class="card-body">
                <ul class="list-unstyled latestUsers">
                    <?php 
                     if(!empty($latestItems)){
                     foreach($latestItems as $item){
                         echo "<li>".$item['Name'];
                         if($item['Approve']==0){
                            echo "<a href='Items.php?do=Approve&Item_ID=".$item['Item_ID']."'class='btn btn-info Activate  approve pull-right '><i class='fa fa-check'></i>Approve</a>";
                            }
                            echo "</li>";
                     }
                    }
                    else{

                        echo "There is no items";
                    }
                     
                    ?>
                    </ul>
                </div>
            </div>
        </div>
     </div>

     <div class="row">
          <div class="col-sm-6">
            <div class="card">
                <div class="card-header  text-white bg-dark">
                    <i class="fa fa-comments o"></i>
                    latest <?php  echo $numcomments;?> Comments
                </div>
                <div class="card-body">
                <ul class="list-unstyled latestUsers">
                    <?php  
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
                          $comments=$stmt->fetchAll();
                          foreach($comments as $comment){
                              echo '<div class="comment-box">';
                              echo '<a href="../profile.php"><span class="Member-name">'.$comment['UserName'].'</span></a>';
                              echo '<p class="Member-comment">'.$comment['comment'].'</p>';
                              echo '</div>';
                          }

                     
                    ?>
                    </ul>
                </div>
            </div>
 </div>


   <?php






    /*End dashboard page*/

    include $tpl."footer.php";
}
 else {
     header('Location:index.php');
     exit();
 }
 ob_end_flush();
?>