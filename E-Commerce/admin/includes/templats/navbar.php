
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
  <div class="container">
    <a class="navbar-brand" href="#"><?php echo lang('name')?></a>
    <nav class="navbar navbar-expand-sm navbar-custom sticky-top ">
            <div class="container">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <!--to make the elemnts in the right-->
              <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                    <a class="nav-link py-0  " href="Dashboard.php"><?php echo lang('home')?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link py-0  " href="categories.php"><?php echo lang('cat')?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link py-0  " href="Items.php"><?php echo lang('items')?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="members.php?action=manage&UserID=<?php echo $_SESSION['UserID']?>"><?php echo lang('members')?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="comments.php"><?php echo lang('comments')?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="#"><?php echo lang('statistics')?></a>
                  </li>
                  <li class="nav-item  ">
                    <a class="nav-link  py-0 " href="#"><?php echo lang('logs')?></a>
                  </li>
                 
                  <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <?php /*echo $_SESSION['username'];*/  echo "Admin";?>
       </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="members.php?action=Edit&UserID=<?php echo $_SESSION['UserID']?>">Edit Profile</a></li>
    <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
    <li><a class="dropdown-item" href="#">Settings</a></li>
    <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
  </ul>
</div>
</div>
  </div>
  </div>
</nav>