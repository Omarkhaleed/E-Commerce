<?php
session_start();
$pagetitle=' Create new item';
include "init.php";

if (isset($_SESSION['user'])){
    
  if($_SERVER['REQUEST_METHOD']=='POST'){
      
    $title    =$_POST['name'];
    $desc     =$_POST['Description'];
    $price     =$_POST['Price'];
    $country   =$_POST['Country'];
    $status    =$_POST['Status'];
    $category  =$_POST['Category'];


    $formErrors=array();
     if (isset($title)){
      $filtertitle=filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        if(strlen($filtertitle)<3){
          $formErrors[]=" Name shoud be more than  2 character";
        }
     }
     if (isset($desc)){
      $filterdesc=filter_var($desc,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        if(strlen($filterdesc)<8){
          $formErrors[]=" Name shoud be more than 2 character";
        }
     }
     if (isset($price)){
         $filterprice=filter_var($price,FILTER_SANITIZE_NUMBER_INT);
         if($filterprice<=0){
          $formErrors[]="Sorry the price shoud be positive value";
        }
     }
     if (isset($country)){
      $filtercountry=filter_var($country,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        if(strlen($filtercountry)<2){
          $formErrors[]=" Name shoud be more than 2 character";
        }
     }
     if (isset($status)){
      $filterstatus=filter_var($status,FILTER_SANITIZE_NUMBER_INT);
      if($filterstatus<=0){
       $formErrors[]="Sorry the price shoud be positive value";
     }
  }
  if (isset($category)){
    $filtercategory=filter_var($category,FILTER_SANITIZE_NUMBER_INT);
    if($filtercategory<=0){
     $formErrors[]="Sorry the price shoud be positive value";
   }
}
     
     
     if(empty($formErrors)){
      // the second check (if the user exist)
        // the second way to secure data in pdo => using :name
				$stmt=$con->prepare("INSERT INTO items (Name,Description,Price,CountryMade,Status,Cat_ID,Member_ID,AddDate)
				VALUES(:u_name,:d_esc,:price,:country,:statues,:cat,:member,now())");
				$stmt->execute(array(
				'u_name'=>$filtertitle,
				'd_esc'=>$desc,
				'price'=>$price,
				'country'=>$country,
				'statues'=>$status,
				'cat'=>$category,
				'member'=>$_SESSION['UserID']));
            $sucessData="Congrats you added your item  in our site";
            $sucessData2="  You will be move to the home page now";

 }
}
 ?>   
                   <h1 class="text-center"><?php echo $pagetitle ?></h1>
                  
                   <div class="myComments info">
                   <div class="container">
                   <div class="The-Errors-items">
<?php
if(!empty($formErrors)){
  foreach($formErrors as $error){
    echo '<div class="   Mssg alert alert-danger">'.$error. '</div>';
  }
}
  if (isset($sucessData)){
    echo '<div class="  alert alert-success">'.$sucessData. '</div>';
    echo '<div class="  alert alert-primary">'.$sucessData2. '</div>';
    //header("refresh:2;url=index.php");
  }
?>
</div>
                   <div class="card">
                   <h5 class="card-header bg-primary">Details</h5>
                   <div class="card-body">
                    <div class="row">
                    <div class=" col-md-8">
                    <div class=" col-md-8">
                   <form class="form-example " id="form-login"  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST"> 
             		<!-- start name field  -->
               <div class="form-group ">
                 <label  class="control-label"for="exampleInputEmail1">Name</label>
                 <input type="name"  name="name" class="form-control live-name" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Name of The Item" required="required" date-class=".live-title">
               </div>
               <!-- start description field  -->
               <div class="form-group ">
                 <label  class="control-label"for="exampleInputEmail1">Description</label>
                 <input type="name"  name="Description" class="form-control live-desc" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Description of The Item" required="required" date-class=".live-desc">
               </div>
               <div class="form-group ">
                 <label  class="control-label"for="exampleInputEmail1">Price</label>
                 <input type="name"  name="Price" class="form-control live-price" id="exampleInputEmail1" aria-describedby="emailHelp"  required="required" date-class=".live-price">
               </div>
               <div class="form-group ">
                 <label  class="control-label"for="exampleInputEmail1">Country</label>
                 <input type="name"  name="Country" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Country of Made" required="required">
               </div>
                      <div class="form-group ">
                        <label  class="control-label"for="exampleInputEmail1">Status</label>
                         <select class="form-control" name="Status" required="required">
                     	 <option value="0">...</option>
                     	 <option value="1">New</option>
                     	 <option value="2">Like New</option>
                     	 <option value="3">Used</option>
                     	 <option value="4">Very Old</option>
                     	 </select>
                         </div>
                    <div class="form-group ">
                           <label  class="control-label"for="exampleInputEmail1">Category</label>
                            <select class="form-control" name="Category" required="required">
                       	 <option value="0">...</option>
                       	<?php
                       $cats=getAllFrom('categories');
                       	foreach($cats as $cat){
                       		echo "<option value='".$cat["ID"]."'>".$cat["Name"]."</option>";
                       	}
                       	?>
                       	 </select>
                    </div>
                      <div class="form-group">        
                   <div class="col-sm-offset-7 col-sm-4">
                   <button type="submit" class=" bb btn btn-primary btn-block"><i class="fa fa-plus"></i> Add Item</button>
                   </div>
                 </div>
             </form>
             </div>
             </div>
                       <div class=" col-md-4">
                       <div class='img-thumbnail item-box live-preview'>
                       <span class='price-tag live-price'>$</span>
                       <img class='image-responsive rounded' src ='iphone2.jpg' width = '370' height = '200' alt=''/>
                       <div class='caption'>
                        <h3 class="live-title">test</h3>
                        <p  class="live-desc"> description</p>
                        </div>
                        </div>    
                        </div>
                        </div>
</div>
</div>
</div>
</div>
</div>
<?php }
else{
header('Location:login.php');
exit();
}

include $tpl."footer.php";
?>