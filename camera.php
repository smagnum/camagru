<?php
    require_once("inc/init.php");
   
    checkLogin();
    $t = 0;
    $msg = "";


?>



<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/camera.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="icon/in.png">
  </head>
  <body id="grad">
 
      <a href="logout.php" class="logout" ><i class="fa fa-sign-out"></i> Logout</a>
   <div class="topnav" id="myTopnav">
   
   <a href="index.php"><h2 class="camagru">Camagru</h2></a>
   
</div>

    <div class="container">
  <div class="row outerContainer">
    <div class="flex-center">
        <div class="right">
            <?php
              $uid = $_SESSION["uid"];
              $select = $dbConnection->prepare("SELECT * FROM posts WHERE id_user= $uid AND ver= 1 order by id_post desc");
              $select->execute();
              while ($res = $select->fetch())
              {
                echo '<div class="postes">
                  <a href="post.php?post=' . $res["id_post"] . '"><img id="postes" width="350" height="340" src="'. $res["image"] .'"/></a>
                  </div>';
              }
        ?>
      </div>

      <div class="card">
            <video id="video" autoplay></video>
            <?php
                if (isset($_POST['st1']))
                {
                  $t = 1;
                  echo '<img class="st1" id="stickers" src="img/1.png">';
                }
                else if (isset($_POST['st2']))
                {
                  $t = 1;
                  echo '<img class="st2" id="stickers" src="img/2.png">';
                }
                else if (isset($_POST['st3']))
                {
                  $t = 1;
                  echo '<img class="st3" id="stickers" src="img/3.png">';
                }
                else if (isset($_POST['st4']))
                {
                  $t = 1;
                  echo '<img class="st4" id="stickers" src="img/4.png">';
                }
                else if (isset($_POST['st5']))
                {
                  $t = 1;
                  echo '<img class="st5" id="stickers" src="img/5.png">';
                }
                else if (isset($_POST['st6']))
                {
                  $t = 1;
                  echo '<img class="st6" id="stickers" src="img/6.png">';
                }
                else if (isset($_POST['st7']))
                {
                  $t = 1;
                  echo '<img class="st7" id="stickers" src="img/7.png">';
                }
               ?> 
            <button id="snap" <?php if ($t == 0) echo 'disabled' ?>>Snap Photo</button>
            <canvas id="canvas" width="640px" height="480px"></canvas>
            <?php
                if (isset($_POST['st1']))
                {
                  echo '<img class="img/1.png" id="sticker" src="img/1.png">';
                }
                else if (isset($_POST['st2']))
                {
                  echo '<img class="img/2.png" id="sticker" src="img/2.png">';
                }
                else if (isset($_POST['st3']))
                {
                  echo '<img class="img/3.png" id="sticker" src="img/3.png">';
                }
                else if (isset($_POST['st4']))
                {
                  echo '<img class="img/4.png" id="sticker" src="img/4.png">';
                }
                else if (isset($_POST['st5']))
                {
                  echo '<img class="img/5.png" id="sticker" src="img/5.png">';
                }
                else if (isset($_POST['st6']))
                {
                  echo '<img class="img/6.png" id="sticker" src="img/6.png">';
                }
                else if (isset($_POST['st7']))
                {
                  echo '<img class="img/7.png" id="sticker" src="img/7.png">';
                }
          ?>
            <div class ="p1">
              <form method="POST">
              <div class = "emoji"> 
                <img src="img/1.png" alt="Smiley face" height="110" width="110" class ="p">
                <br>
                      <button type="checkbox" name="st1"   class ="k" value="img/1.png"></button>    
                  <br>
                      <img src="img/2.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st2"   class ="k" ></button>
                  <br>
                      <img src="img/3.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st3"   class ="k" ></button> 
                  <br>
                      <img src="img/4.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st4"   class ="k" ></button> 
                  <br>
                      <img src="img/5.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st5"   class ="k" ></button>
                  <br>
                      <img src="img/6.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st6"   class ="k" ></button>
                  <br>
                      <img src="img/7.png" alt="Smiley face" height="110" width="110" class ="p">
                  <br>
                      <button type="checkbox" name="st7"   class ="k" ></button> 
                </div>  
              </form> 
            </div>
          </div>
        </div>
      </div>
      <button type="button" class="upload btn btn-danger" name="upload_snap" id="up_file-1"><i class="fa fa-upload"></i> Upload</button>
      <a href="camera.php" class="upload btn btn-danger"><i class="fa fa-refresh"></i> clear</a>

      <div class=box> 
            <form>
              <p class="msg_err"><?php if (isset($msg)) echo $msg ?><p>
            </form>
        <input type="file" name="file" id="file">
        <button type="button" name="upload_file" id="up_file-2">Upload File</button> 
      </div>   
      <script src="js/camera.js"></script> 
    </div>

    <div class="copyright">
			     <p>© 2019. All rights reserved | Design by
				   <a style="color:white;">Srazik</a>
              </p>
		</div>
</body>

</html>
