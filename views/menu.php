<?php
    $stmt = $dbConnection->prepare('SELECT * FROM `user` WHERE UID LIKE :UID ');
    $stmt->bindParam(':UID', $_SESSION['uid']); 
    $stmt->execute();
    $username = '';
    while ($data = $stmt->fetch())
    {
      $username  =  $data['USERNAME'];     
    }
?>
    <div class="topnav" id="myTopnav">
    <a href="index.php"><h2 class="camagru">Camagru</h2></a>
        <div class="menu_div">
        <?php if (isLogged()) { ?>
        <a href="camera.php" class="active"><i class="fa fa-camera"></i> Camera</a>
        <?php } ?>
        <div class="dropdown">
          <button class="dropbtn" > <?php echo $username; ?>
              <i class="fa fa-caret-down"></i>
          </button>
            <div class="dropdown-content" >

        <?php if (isLogged()) { ?>
              <a href="editprofile.php"><i class="fa fa-edit"></i> Edit Profile</a>
              <a href="notf-cmnt.php"><i class="fa fa-bell"></i> Notification</a>
              <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        <?php }else{ ?>
              <a href="login.php"><i class="fa fa-sign-in"></i> Login</a>
              <a href="register.php"><i class="fa fa-sign-in"></i> Register</a>
         <?php } ?>
            </div>

        </div>
      </div>
      <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>