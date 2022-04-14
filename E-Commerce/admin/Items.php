<?php

	/*
	================================================
	== categories Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();
	
	$pagetitle = 'Items';
	if (isset($_SESSION['username'])) {
       
		include 'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
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
								  on
								  users.UserID=items.Member_ID
								  ");
     $stmt->execute();
     $items=$stmt->fetchAll();
	 $count=$stmt->rowCount();
    ?>
    <h1 class="text-center">Manage items page </h1>
    <div class="container">
	<?php if ( $count > 0){?>
	<a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> new item</a>
    <div class="table-responsive">
    <table class=" mainTable  text-center table table-bordered">
    <tr>
       <td>#ID</td>
       <td>Name</td>
       <td>Description</td>
       <td>Price</td>
       <td>AddingDate</td>
	   <td>Category</td>
	   <td>Member</td>
       <td>Controll</td>
  </tr>
  <?php
    foreach($items as $item){
		global $itemName;
		$itemName=$item['Name'];
      echo "<tr>";
      echo "<td>".$item['Item_ID']."</td>";
      echo "<td>".$item['Name']."</td>";
      echo "<td>".$item['Description']."</td>";
      echo "<td>".$item['Price']."</td>";
      echo "<td>".$item['AddDate']."</td>";
	  echo "<td>".$item['cat_name']."</td>";
	  echo "<td>".$item['UserName']."</td>";
      echo "<td>";
      echo "<a href='Items.php?do=Edit&ItemID=".$item['Item_ID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
      echo " ";
      echo "<a href='Items.php?do=Delete&ItemID=".$item['Item_ID']."'class='btn btn-danger delete confirm'><i class='fa fa-close'></i>Delete</a>";
      echo " ";
	  if($item['Approve']==0){
		echo "<a href='Items.php?do=Approve&Item_ID=".$item['Item_ID']."'class='btn btn-info Activate'><i class='fa fa-check'></i>Approve</a>";
		}
		if($item['Approve']==1){
			echo "<a href='Items.php?do=ShowComments&Item_ID=".$item['Item_ID']."'class='btn btn-info Activate'><i class='fa fa-comments'></i>Comments</a>";
			}
      "</td>";
      echo "</tr>";

    }
}
else{
	echo "<div class='container'>";
    $Msg="<div class=' redMessage alert alert-danger'>"." Sorry,There is no items"."</div>";
	echo "<a href='Items.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> new item</a>";
    redirectHome($Msg);
    echo "</div>";
}
	?>
	</div>
	</div>
		<?php

}elseif ($do == 'Add') { ?>

<h1 class="text-center"> ADD YOUR NEW Item</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <form class="form-example " id="form-login"  action="?do=Insert" method="POST"> 
		<!-- start name field  -->
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Name</label>
    <input type="name"  name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Name of The Item" required="required">
  </div>
  <!-- start description field  -->
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Description</label>
    <input type="name"  name="Description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Description of The Item" required="required">
  </div>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Price</label>
    <input type="name"  name="Price" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  required="required">
  </div>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Country</label>
    <input type="name"  name="Country" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Country of Made" required="required">
  </div>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Status</label>
     <select class="form-control" name="Status">
	 <option value="0">...</option>
	 <option value="1">New</option>
	 <option value="2">Like New</option>
	 <option value="3">Used</option>
	 <option value="4">Very Old</option>
	 </select>
  </div>
      
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Member</label>
     <select class="form-control" name="member">
	 <option value="0">...</option>
	<?php
	$stmt=$con->prepare("SELECT * FROM users");
	$stmt->execute();
	$users=$stmt->fetchAll();
	foreach($users as $user){
		echo "<option value='".$user["UserID"]."'>".$user["UserName"]."</option>";
	}
	?>
	 </select>
  </div>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Category</label>
     <select class="form-control" name="Category">
	 <option value="0">...</option>
	<?php
	$stmt2=$con->prepare("SELECT * FROM  categories");
	$stmt2->execute();
	$cats=$stmt2->fetchAll();
	foreach($cats as $cat){
		echo "<option value='".$cat["ID"]."'>".$cat["Name"]."</option>";
	}
	?>
	 </select>
  </div>
<!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class=" bb btn btn-primary btn-block"><i class="fa fa-plus"></i> Add Item</button>
      </div>
    </div>
</form>
    </div>
    </div>
    </div>
          <?php
		}
		elseif ($do == 'Insert') {
               
			//insert item's data in database
      
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$name      = $_POST['name'];
				$desc      = $_POST['Description'];
				$price     = $_POST['Price'];
				$country   = $_POST['Country'];
				$status    = $_POST['Status'];
				$member    = $_POST['member'];
				$category  = $_POST['Category'];

	   
				echo "<h1 class='text-center'>ADD your new Item </h1>";
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
		   
				 if($status==0){
				   $array_errors[]="sorry  you must choose the <strong>status</strong> </div>";
				 }
				 if($member==0){
					$array_errors[]="sorry  you must choose the <strong>member</strong> </div>";
				  }
				  if($category==0){
					$array_errors[]="sorry  you must choose the <strong>category</strong> </div>";
				  }
				 foreach($array_errors as $error){
				    $Msg="<div class=' redMessage alert alert-danger'>".$error;
				   redirectHome($Msg,"Back");
				 }
				   
				  
				 if(empty($array_errors)){
					 // the second way to secure data in pdo => using :name
				$stmt=$con->prepare("INSERT INTO items (Name,Description,Price,CountryMade,Status,Cat_ID,Member_ID,AddDate)
				VALUES(:u_name,:d_esc,:price,:country,:statues,:cat,:member,now())");
				$stmt->execute(array(
				'u_name'=>$name,
				'd_esc'=>$desc,
				'price'=>$price,
				'country'=>$country,
				'statues'=>$status,
				'cat'=>$category,
				'member'=>$member));
				
			   $Msg="<div class=' greenMessage alert alert-success'>".$stmt->rowCount().'  Record Inserted </div>';
			   redirectHome($Msg,"Back");
				}
			 }
			  else{
				echo "<div class='container'>";
				$Msg="<div class='redMessage alert alert-danger'>Sorry You Can't Browse This Page Directly</div>";
				 redirectHome($Msg);
				 echo "</div>";
			  }
			   echo "</div>";
			   echo "</div>";
			   echo "</div>";
		   }

	    elseif ($do == 'Edit') {
        // to sure that the ID is numeric
		$ItemID=isset($_GET['ItemID']) && is_numeric($_GET['ItemID'])? intval($_GET['ItemID']) : 0;
			// select all data for this id
	  $stmt=$con->prepare("SELECT * FROM items WHERE Item_ID=?");
	  $stmt->execute(array($ItemID));
	  $row=$stmt->fetch();
	  $count=$stmt->rowCount();
	  //if there is id show the form 
	   if($count >0 ){  ?>
		
		  <!--form to edit personal settings-->
		  <h1 class="text-center">EDIT YOUR DATA</h1>
	  <div class="container h-100">
	  <div class="row h-100 justify-content-center align-items-center">
	  <div class=" col-sm-4">
	  <form class="form-example " id="form-login"  action="?do=Update" method="POST"> 
	  <input type="hidden" name="ItemID" value="<?php echo $ItemID ?>"/>
	<div class="form-group ">
	  <label  class="control-label"for="exampleInputEmail1">Name</label>
	  <input type="name"  name="Name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $row['Name'] ?>" placeholder="" required="required">
	</div>
	<div class="form-group ">
	  <label for="exampleInputPassword1">Description</label>
		  <input type="name" name="Description" class="form-control"  placeholder=""  value="<?php echo $row['Description'] ?>" required="required" >
	 
	</div>
	<div class="form-group ">
	  <label for="exampleInputPassword1">Price</label>
	  <input type="name"  name="price"class="form-control" id="exampleInputPassword1" value="<?php echo $row['Price'] ?>" placeholder="" required="required">
	</div>
	<div class="form-group ">
	  <label for="exampleInputPassword1">Country</label>
	  <input type="name"  name="country"class="form-control" id="exampleInputPassword1" value="<?php echo $row['CountryMade'] ?>"  required="required">
	</div>
	<div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Status</label>
     <select class="form-select" aria-label="Default select example"  name="Status">
	
	 <option value="1" <?php if($row['Status']==1) echo "selected";?> >New</option>
	 <option value="2" <?php if($row['Status']==2) echo "selected";?>>Like New</option>
	 <option value="3" <?php if($row['Status']==3) echo "selected";?>>Used</option>
	 <option value="4" <?php if($row['Status']==4) echo "selected";?>>Very Old</option>
	 </select>
  </div>
      
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Member</label>
     <select class="form-select" aria-label="Default select example" name="member">

	<?php
	$stmt=$con->prepare("SELECT * FROM users");
	$stmt->execute();
	$users=$stmt->fetchAll();
	foreach($users as $user){
		echo "<option value='".$user["UserID"]."'";
		if($row['Member_ID']==$user["UserID"])
	    echo "selected";echo">".$user["UserName"]."</option>";
	}
	?>
	 </select>
  </div>
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Category</label>
     <select class="form-select" aria-label="Default select example" name="Category">
	 <option value="0">...</option>
	<?php
	$stmt2=$con->prepare("SELECT * FROM  categories");
	$stmt2->execute();
	$cats=$stmt2->fetchAll();
	foreach($cats as $cat){
		echo "<option value='".$cat["ID"]."'";
		if($row['Cat_ID']==$cat["ID"]) 
		echo "selected"; echo">".$cat["Name"]."</option>";
	}
	?>
	 </select>
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
		 $Msg="<div class=' redMessage alert alert-danger'>"."There is no such ID"."</div>";
		 redirectHome($Msg);
		 echo "</div>";
	}
	
		} elseif ($do == 'Update') {
            
			//echo "<div class=' text-center container>";
			echo "<h1 class='text-center'>Update YOUR DATA</h1>";
			// echo '<div class="container h-100>';
			 echo '<div class="d-flex justify-content-center">';
			 echo '<div class=" col-sm-8">';
			
			 if($_SERVER['REQUEST_METHOD']=='POST'){
				$id         =$_POST['ItemID'];
				$name       = $_POST['Name'];
				$desc       = $_POST['Description'];
				$price      = $_POST['price'];
				$country    = $_POST['country'];
				$status     = $_POST['Status'];
				$member     = $_POST['member'];
				$cat        = $_POST['Category'];
					// the second check (if the user exist)
				
				
				  // the first way to secure the data in pdo  => ?
			   $stmt=$con->prepare("UPDATE 
			                        items  
								    SET
								    Name=?,
								    Description=?, 
								    Price=?,
								    CountryMade=?,
									Status=?,
									Cat_ID=?,
									Member_ID=?   
									WHERE Item_ID=? ");
			   $stmt->execute(array($name,$desc,$price,$country,$status,$cat,$member,$id));
				$Msg="<div class='greenMessage alert alert-success'>".$stmt->rowCount().'  Record Updated </div>';
				  redirectHome($Msg,'Back');
			 
			}
			 else{
				$Msg="<div class='redMessage alert alert-danger'>sorry you cant visit this page directory</div>";
				redirectHome($Msg);
			 }
			  echo "</div>";
			  echo "</div>";
			  echo "</div>";

		} elseif ($do == 'Delete') {
			echo "<h1 class='text-center'>Delete  member page </h1>";
  echo "<div class='container'>";
  $ItemID=isset($_GET['ItemID']) && is_numeric($_GET['ItemID'])? intval($_GET['ItemID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM items WHERE Item_Id=? ");
    $stmt->execute(array($ItemID));
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count>0 ){
       $stmt=$con->prepare("DELETE FROM Items WHERE Item_ID=:Zitem");
       $stmt->bindParam(":Zitem", $ItemID);
       $stmt->execute();
       $Msg="<div class='greenMessage alert alert-success'>".$stmt->rowCount().'  Record Deleted </div>';
       redirectHome($Msg);
}
else{
  $Msg="<div class=' redMessage alert alert-danger'>"."Sorry,This Member Doesn't Exist !! "."</div>";
  redirectHome($Msg);
}
echo "</div>";

		}

		elseif ($do=="Approve"){
			echo "<h1 class='text-center'> Approve member page </h1>";
			 echo "<div class='container'>";
			 $ItemID=isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID'])? intval($_GET['Item_ID']) : 0;
					 // select all data for this id
			   $stmt=$con->prepare("SELECT * FROM items WHERE Item_ID=?");
			   $stmt->execute(array($ItemID));
			   $count=$stmt->rowCount();
			   //if there is id show the form 
				if($count>0 ){
				  $stmt=$con->prepare("UPDATE items  SET Approve =1 WHERE 	Item_ID=? ");
				  $stmt->execute(array($ItemID));
				  $Msg="<div class=' greenMessage alert alert-success'>".$stmt->rowCount().'  Record Approved </div>';
				  redirectHome($Msg);
		   }
		   else{
			 $Msg="<div class=' redMessage alert alert-danger'>"."Sorry,This Item Doesn't Exist !! "."</div>";
			 redirectHome($Msg);
		   }
		   echo "</div>";
		   }

		   else if($do='ShowComments'){
			$ItemID=isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID'])? intval($_GET['Item_ID']) : 0;
			// manage member page
				// not activated members
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
				 where itemID=?");
				 $stmt->execute(array($ItemID));
				 $rows=$stmt->fetchAll();
				 $count=$stmt->rowCount();
			
			
				?>
				<h1 class="text-center">Manage Comments </h1>
	      		<div class="container"> 	
				<?php
				
				 if($count > 0){?>
					
				<div class="table-responsive">
				<table class=" mainTable  text-center table table-bordered">
				<tr>
				   <td>Comment</td>
				   <td>UserName</td>
				   <td>AddedDate</td>
				   <td>Controll</td>
			  </tr>
			  <?php
				foreach($rows as $row){
				  echo "<tr>";
				  echo "<td>".$row['comment']."</td>";
				  echo "<td>".$row['UserName']."</td>";
				  echo "<td>".$row['c_date']."</td>";
				  echo "<td>";
				  echo "<a href='comments.php?action=Edit&CID=".$row['C_ID']."'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
				  echo " ";
				  echo "<a href='comments.php?action=Delete&CID=".$row['C_ID']."'class='btn btn-danger delete confirm'><i class='fa fa-close'></i>Delete</a>";
				  echo " ";
				   if($row['status']==0){
				   echo "<a href='comments.php?action=Approve&CID=".$row['C_ID']."'class='btn btn-info approve'><i class='fa fa-check'></i>Approve</a>";
				   }
				  "</td>";
				  echo "</tr>";
			
				}
			  }
			  else
			  {
				echo "<div class='container'>";
				$Msg="<div class='alert alert-danger'>"." Sorry,There is no comments"."</div>";
				redirectHome($Msg);
				echo "</div>";
			  }
				  ?>
				</div>
			  </div>
				   
				<?php 
				}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>