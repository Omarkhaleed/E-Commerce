<?php
ob_start();
session_start();   
$pagetitle=' Show Items';
include 'init.php';

        // to sure that the ID is numeric
        $ItemID=isset($_GET['ItemID']) && is_numeric($_GET['ItemID'])? intval($_GET['ItemID']) : 0;
          // select all data for this id
          $stmt=$con->prepare("SELECT items.*,
                                      categories.Name AS cat_name,
                                      users.UserName 
                               from   
                                      items
                                      INNER JOIN
                                      categories
                                      ON
                                       categories.ID=items.Cat_ID
                                       INNER JOIN
                                       users
                                      ON
                                       users.UserID=items.Member_ID
                                        where Item_ID=?");
         $stmt->execute(array($ItemID));
         $count=$stmt->rowCount();
         if($count>0){
           $row=$stmt->fetch();
?>
                   <h1 class="text-center"><?php echo $row['Name']?></h1>
                   <div class="container">
                   <div class="card card-showItem">
                   <h5 class="card-header bg-primary">Details</h5>
                   <div class="myInformation info2">
                   <div class="card-body">
                    <div class="row">
                    <div class=" col-md-6">
                <ul class=" list-unstyled card-text">
                      <li>
                           <span>Name</span><?php echo $row['Name'];?></li>
                      <li>
                           <?php $status=array('unKnown','New','Like New ','Used','Very Old');?>
                           <span>Status</span><?php echo $status[$row['Status']];?></li>
                      <li>
                           <i class="fa fa-money fa-fw"></i>
                           <span>Price</span><?php echo $row['Price'];?></li>
                      <li>
                           <i class="fa fa-user"></i>
                           <span>Made in</span><?php echo $row['CountryMade'];?></li>
                      <li>
                           <i class="fa fa-tags"></i>
                           <span>Category</span><a href="categories.php?pageid=<?php echo $row['Cat_ID'];?>"><?php echo $row['cat_name'];?></li></a>
                      <li>
                           <i class="fa fa-calendar"></i>
                           <span>Added Date</span><?php echo $row['AddDate'];?></li>
                      <li>
                            <i class="fa fa-user"></i>
                            <span>Added By</span><a href="#" ><?php echo $row['UserName'];?></li></a>
                </ul>
             </div>
                       <div class=" col-md-6">
                       <div class='img-thumbnail item-box live-preview'>
                      <!--  in the class (img-thumbnail)--> <img class='image-responsive   rounded' src ='iphone2.jpg' width = '100%' height = '200' alt=''/>
                       <strong>Description</strong>:
                       <p><?php  echo$row['Description'] ;?><p>
                        </div>
                        </div>
                        
</div>
</div>
</div>
</div>
<hr class="custom-hr">
<!-- start add comment-->
<?php if (isset($_SESSION['user'])){?>
  <div class="row">
       <div class="col-md-offset-3">
            <div class="AddComments">
            <h3> Add your comment</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'].'?ItemID='.$row['Item_ID']?>" method="POST">
                 <textarea name='comment' required="required" ></textarea>
                 <input  class="btn btn-primary" type="submit"   value="Add comment">
                 </form>

                 <?php  
                 if($_SERVER['REQUEST_METHOD']=='POST'){
                      $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                      $itemID= $row['Item_ID'];
                     
               
                      if(!empty($comment)){

                         $stmt=$con->prepare("INSERT INTO comments(comment,status,c_date,itemID,userID)
                                              values(:zcomment,1, now() ,:zitemID,:zuserID)");

                         $stmt->execute(array(
                          
                            'zcomment'=>$comment,
                            'zitemID'=>$itemID,
                            'zuserID'=>$_SESSION['uid']
                         ));
                         $count=$stmt->rowCount();
                    }
                    if($count>0){
                         echo '<div class=" alert alert-success">added</div>';
                    }
                        
                      }
                      
                    }
                 ?>
         </div>
         </div>
         </div>
<?php   }else{
       echo "<a href='login.php?action=login'>login</a> or <a href='login.php?action=signup'>register</a> to add comment";
}
?>
<!-- end add comment-->
<!-- Show comments -->
  <hr class="custom-hr">
  <?php
     $stmt=$con->prepare("SELECT comments.*,
     users.UserName 
 from   
     comments
      INNER JOIN
      users
      on
      users.UserID=comments.userID
      where ItemID=?
      AND   status=1
      ");
      $stmt->execute(array($row['Item_ID']));
      $count=$stmt->rowCount();
      $comments=$stmt->fetchAll();
      if($count>0){
          foreach($comments as $comment){?>
               <div class="comment-box">
               <div class="row">
               <div class="col-sm-2 text-center">
               <img class=' rounded-circle d-block m-auto' src ='iphone2.jpg' alt=''/>
              <?php echo  $comment['UserName'];?>
              </div>
               <div class="col-sm-10">
                <p class="lead"><?php echo $comment['comment'].' '.$comment['c_date'];?></p>
                </div>
                 </div>
                </div>
                 <hr class='hr-custom'>
                 <?php }
     }

          else {

                echo " Sorry There is no such ID";
         }
     
include $tpl.'<footer.php';
ob_end_flush();
?>