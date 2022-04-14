<?php

	/*
	================================================
	== categories Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pagetitle = 'Categorios';

	if (isset($_SESSION['username'])) {

		include 'init.php';
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
			$sort='ASC';
			$sort_array=array('ASC','DESC');
			if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
				$sort=$_GET['sort'];
			}
		$stmt=$con->prepare("SELECT * FROM categories where parent=0 ORDER BY Ordering $sort");
		$stmt->execute();
		$cats=$stmt->fetchALL();
		$count=$stmt->rowCount();
		?>
		 <h1 class="text-center">Manage Category page</h1>
		 <?php if ( $count > 0){?>
		<div class="container categories">
		<a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> new category</a>
		<div class="row">
          <div class="col-sm-10">
            <div class="card">
                <div class="card-header  text-white bg-dark">
                    <i class="fa fa-edit"></i>Manage Categories list
					<div class=" option pull-right">
						<i class="fa fa-sort"></i> Ordering: [
						<a class="<?php if($sort=='ASC'){echo"active";}?>"href="?sort=ASC">ASC</a> |
						<a  class="<?php if($sort=='DESC'){echo"active";}?>"href="?sort=DESC">DESC</a> ]
						<i class="fa fa-eye"></i> View: [
						<span class="active" data-view="full">Full</span> |
						<span data-view="classic">Classic</span> ]	
		            </div>
                </div>
                <div class="card-body">
					<?php
					foreach($cats as $cat){
						echo "<div class='cat'>";
						echo "<div class='hidden_buttons'>";
						echo "<a href='categories.php?do=Edit&CatID=".$cat['ID']."' class='btn  btn-primary'><i class='fa fa-edit'></i>Edit</a>";
						echo "<a href='categories.php?do=Delete&CatID=".$cat['ID']."' class='btn btn-danger'><i class='fa fa-close'></i>Delete</a>";
						echo "</div>";
						echo "<h3>".$cat['Name'].'</h3>';
						echo "<div class='fullview'>";
						echo "<p>"; if($cat['Description']==''){ echo "there is no desc";}else {echo $cat['Description'];} echo "<p>";
						if($cat['Visibility']==1){ echo '<span class="Visibility"><i class="fa fa-eye"></i> Hidden</span>';}
						if($cat['AllowComments']==1){ echo'<span class="commentting"><i class="fa fa-close"></i> Comment Disable</span>';}
						if($cat['AllowAds']==1){ echo'<span class="Ads"><i class="fa fa-close"></i> Ads Disabled</span>';}
						echo "</div>";
						echo "<h1 class='h1-parent'>child categories</h1>";
						$getcat=getCat("parent={$cat['ID']}");
						foreach( $getcat as $c){
							echo "<li> <a href='categories.php?do=Edit&CatID=".$c['ID']."'>".$c['Name']."</a></li>";
				} 
						echo "</div>";
						echo "<hr>";
						
				}
			}else{
					echo "<div class='container'>";
                   $Msg="<div class='redMesage alert alert-danger'>"." Sorry,There is no categories"."</div>";
				   echo "<a href='categories.php?do=Add' class='btn btn-primary'><i class='fa fa-plus'></i> new category</a>";
                    redirectHome($Msg);
                    echo "</div>";
				}


                    ?>
		</div>
		</div>
		</div>
		</div>
		<?php

		} elseif ($do == 'Add') { ?>

<h1 class="text-center">ADD YOUR NEW Category</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <form class="form-example " id="form-login"  action="?do=Insert" method="POST"> 
		<!-- start name field  -->
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Name</label>
    <input type="name"  name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Name of category" required="required">
  </div>
  <!-- start description field  -->
  <div class="form-group ">
    <label for="exampleInputPassword1">Description</label>
		<input type="text" name="description" class=" password form-control" autocomplete="new-password" placeholder="The description of the category">
  </div>
  <!-- start ordering field  -->
  <div class="form-group ">
    <label for="exampleInputPassword1">Orderig</label>
    <input type="text"  name="ordering"class="form-control" id="exampleInputPassword1"  placeholder="Allocate the number of your category" >
  </div>
   <!-- start type of category field  -->
   <div class="form-group ">
                           <label  class="control-label"for="exampleInputEmail1">Main category</label>
                            <select class="form-control" name="parent" required="required">
                       	 <option value="0">None</option>
                       	<?php
                       $cats=getAllFrom('categories');
                       	foreach($cats as $cat){
                       		echo "<option value='".$cat["ID"]."'>".$cat["Name"]."</option>";
                       	}
                       	?>
                       	 </select>
                    </div>
  <!-- start visibility field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Visible</label>
    <div>
		<input id="vis-yes" type="radio" name="visibility" value="0" checked>
		<label for="vis-yes">Yes</label>
	</div>
	<div>
	   <input id="vis-no" type="radio" name="visibility" value="1" >
		<label for="vis-no">No</label>
	</div>
  </div>
  <!-- start allow-comment field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Allow Commenting</label>
    <div>
		<input id="comment-yes" type="radio" name="commenting" value="0" checked>
		<label for="comment-yes">Yes</label>
	</div>
	<div>
	   <input id="comment-no" type="radio" name="commenting" value="1" >
		<label for="comment-no">No</label>
	</div>
  </div>
  <!-- start allow-Ads field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Allow Ads</label>
    <div>
		<input id="ads-yes" type="radio" name="ads" value="0" checked>
		<label for="ads-yes">Yes</label>
	</div>
	<div>
	   <input id="ads-no" type="radio" name="ads" value="1" >
		<label for="ads-no">No</label>
	</div>
  </div>
<!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class=" bb btn btn-primary btn-block"> Add Category</button>
      </div>
    </div>
</form>
    </div>
    </div>
    </div>
          <?php
		}
		elseif ($do == 'Insert') {
               
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$name    = $_POST['name'];
				$desc    = $_POST['description'];
				$order   = intval($_POST['ordering']);
				$parent  = intval($_POST['parent']);
				$visible = $_POST['visibility'];
				$comment = $_POST['commenting'];
				$ads     = $_POST['ads'];

				echo "<h1 class='text-center'>Insert your new category </h1>";
			 // echo '<div class="container h-100>';
				echo '<div class="d-flex justify-content-center">';
				echo '<div class=" col-sm-8">';

				   $check=checkItem1("Name","categories",$name);
				   if($check==1){
					 $Msg="<div class='redMessage alert alert-danger'>"."Sorry This Category Alraedy Exist"."</div>";
					 redirectHome($Msg,"Back");
				   }
				   else{
					 // the second way to secure data in pdo => using :name
				$stmt=$con->prepare("INSERT INTO categories (Name,Description,Ordering,parent,Visibility,AllowComments,AllowAds)
				VALUES(:z_name,:z_desc,:z_order,:zparent,:z_visibility,:z_comments,:z_ads)");
				$stmt->execute(array(
				'z_name'       =>$name,
				'z_desc'       =>$desc,
				'z_order'      =>$order,
			    'zparent'      =>$parent,
				'z_visibility' =>$visible,
				'z_comments'   =>$comment,
				'z_ads'        =>$ads
			));
			   $Msg="<div class='greenMessage alert alert-success'>".$stmt->rowCount().'  Record Inserted </div>';
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

	$CatID=isset($_GET['CatID']) && is_numeric($_GET['CatID'])? intval($_GET['CatID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM categories WHERE ID=? ");
    $stmt->execute(array($CatID));
    $cat=$stmt->fetch();
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count >0 ){  ?>
      
        <!--form to edit personal settings-->
	r<h1 class="text-center">Edit YOUR Category</h1>
    <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
    <div class=" col-sm-4">
    <form class="form-example " id="form-login"  action="?do=Update" method="POST"> 
	<input type="hidden" name="CatID" value="<?php echo $CatID ?>"/>
		<!-- start name field  -->
  <div class="form-group ">
    <label  class="control-label"for="exampleInputEmail1">Name</label>
    <input type="name"  name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  placeholder="Name of category" required="required" value="<?php echo $cat['Name'];?>">
  </div>
  <!-- start description field  -->
  <div class="form-group ">
    <label for="exampleInputPassword1">Description</label>
		<input type="text" name="description" class=" password form-control" autocomplete="new-password" placeholder="The description of the category" value="<?php echo $cat['Description'];?>">
  </div>
  <!-- start ordering field  -->
  <div class="form-group ">
    <label for="exampleInputPassword1">Orderig</label>
    <input type="text"  name="ordering"class="form-control" id="exampleInputPassword1"  placeholder="Allocate the number of your category" value="<?php echo $cat['Ordering'];?>" >
  </div>
  <!-- start visibility field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Visible</label>
    <div>
		<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility']==0){echo "checked";}?>>
		<label for="vis-yes">Yes</label>
	</div>
	<div>
	   <input id="vis-no" type="radio" name="visibility" value="1"   <?php if($cat['Visibility']==1){echo "checked";}?> >
		<label for="vis-no">No</label>
	</div>
  </div>
  <!-- start allow-comment field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Allow Commenting</label>
    <div>
		<input id="comment-yes" type="radio" name="commenting" value="0" <?php if($cat['AllowComments']==0){echo "checked";}?>>
		<label for="comment-yes">Yes</label>
	</div>
	<div>
	   <input id="comment-no" type="radio" name="commenting" value="1"   <?php if($cat['AllowComments']==1){echo "checked";}?>>
		<label for="comment-no">No</label>
	</div>
  </div>
  <!-- start allow-Ads field  -->
  <div class="form-group ">
  <label for="exampleInputPassword1">Allow Ads</label>
    <div>
		<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['AllowAds']==0){echo "checked";}?>>
		<label for="ads-yes">Yes</label>
	</div>
	<div>
	   <input id="ads-no" type="radio" name="ads" value="1"   <?php if($cat['AllowAds']==1){echo "checked";}?>>
		<label for="ads-no">No</label>
	</div>
  </div>
<!--
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
     </div>
    -->
  <div class="form-group">        
      <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class=" bb btn btn-primary btn-block">Save</button>
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
       $Msg="<div class='alert alert-danger'>"."There is no such ID"."</div>";
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
				$id      =$_POST['CatID'];
				$name    = $_POST['name'];
				$desc    = $_POST['description'];
				$order   = intval($_POST['ordering']);
				$visible = $_POST['visibility'];
				$comment = $_POST['commenting'];
				$ads     = $_POST['ads'];
					// the second check (if the user exist)

				  // the first way to secure the data in pdo  => ?
			   $stmt=$con->prepare("UPDATE 
			                        categories  
								    SET
								    Name=?,
								    Description=?, 
								    Ordering=?,
								    Visibility=?,
								    AllowComments=?,
									AllowAds=?
									WHERE ID=? ");
			   $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));
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
	echo "<h1 class='text-center'>Delete  category page </h1>";
   echo "<div class='container'>";
    $CatID=isset($_GET['CatID']) && is_numeric($_GET['CatID'])? intval($_GET['CatID']) : 0;
          // select all data for this id
    $stmt=$con->prepare("SELECT * FROM categories WHERE Id=? ");
    $stmt->execute(array($CatID));
    $count=$stmt->rowCount();
    //if there is id show the form 
     if($count>0 ){
       $stmt=$con->prepare("DELETE FROM categories WHERE ID=:Zcat");
       $stmt->bindParam(":Zcat", $CatID);
       $stmt->execute();
       $Msg="<div class='greenMessage alert alert-success'>".$stmt->rowCount().'  Record Deleted </div>';
       redirectHome($Msg,'Back');

		}
	}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>