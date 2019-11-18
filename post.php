<?php
   
    require_once("inc/init.php");
   
    checkLogin();
   
    function get_nbr_like($dbConnection)
    {
        $select = $dbConnection->prepare("SELECT COUNT(*) FROM likes WHERE id_post = :id_post");
        $select->bindParam(':id_post', $_GET['post']);
        $select->execute();
        return ($select->fetchColumn());
    }


    function isUserLikedPost($dbConnection,$id_post)
    {
        $userLikedPost = 0;
        $select = $dbConnection->prepare("SELECT COUNT(*) FROM likes WHERE id_post = :id_post AND id_user=:id_user ");
        $select->bindParam(':id_post', $id_post);
        $select->bindParam(':id_user', $_SESSION['uid']);
        $select->execute();
       $likes = (int) intval($select->fetchColumn());
        if ($likes >= 1)
            return (1);
        return (0);
    }

    if (isset($_POST['like']))
    {
        if (!isUserLikedPost($dbConnection,$_GET['post']))
        {
            $select = $dbConnection->prepare("INSERT INTO likes(id_user, id_post) values(:id_user, :id_post)");
            $select->bindParam(':id_user', $_SESSION['uid']);
            $select->bindParam(':id_post', $_GET['post']);
            $select->execute();
        }
    }
    if (isset($_POST['unlike']))
    {
        $select = $dbConnection->prepare("DELETE FROM likes where id_post = :id_post AND id_user = :id_user");
        $select->bindParam(':id_user', $_SESSION['uid']);
        $select->bindParam(':id_post', $_GET['post']);
        $select->execute();
    }


    if (isset($_GET["post"]))
    {
        
        $stmt = $dbConnection->prepare("SELECT * FROM posts WHERE id_post = :id_post");
        $stmt->bindParam(':id_post', $_GET['post']);
        $stmt->execute();
        if ($stmt->rowCount() != 0)
        {
            if ($data = $stmt->fetch())
                $src = $data['image'];
                $date = $data['date_creation'];

                $select2 = $dbConnection->prepare("SELECT * FROM likes WHERE id_post = :id_post AND id_user = :id_user");
                $select2->bindParam(':id_post', $_GET['post']);
                $select2->bindParam(':id_user', $_SESSION['uid']);
                $select2->execute();
                $like = 0;
                if ($select2->rowCount() != 0)
                    $like = 1;
        }
    }

    // Get Email

    $select = $dbConnection->prepare("SELECT id_user FROM posts WHERE id_post = :id_post");
    $select->bindParam(':id_post', $_GET['post']);
    $select->execute();
    $UID = $select->fetchColumn();
    $select = $dbConnection->prepare("SELECT EMAILID FROM `user` WHERE `UID` = :id");
    $select->bindParam(':id', $UID);
    $select->execute();
    $email = $select->fetchColumn();

    ////cmt

    $select = $dbConnection->prepare("SELECT cmt FROM `user` WHERE `UID` = :id");
    $select->bindParam(':id', $UID);
    $select->execute();
    $cmt = $select->fetchColumn();
    
    /////commentaire
    if (isset($_POST['comnt']) && isset($_POST['add_cmt']))
    {
        if (strlen($_POST['comnt']) <= 100)
        {
            $cmd = $dbConnection->prepare("INSERT INTO comment(id_user, id_post, comnt) values(:id_user, :id_post, :comnt)");
            $cmd->bindParam(':id_user', $_SESSION['uid']);
            $cmd->bindParam(':id_post', $_GET['post']);
            $cmd->bindParam(':comnt', $_POST['comnt']);
            $cmd->execute();
            if($select && $cmt == 1)
            {
                $idPost = $_GET['post'];
                $to = $email;
                $subject = "Email Commentaire";
                $message = "Vous avez un nouveau commentaire";
                $headers = "From: no-reply@camagru.com";
                $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

                mail($to,$subject,$message,$headers);
            }
        }
        else
            $m = "Your Comment is too long";
    }

    //get username
    
    $stmt = $dbConnection->prepare('SELECT * FROM `user` WHERE UID LIKE :UID ');
    $stmt->bindParam(':UID', $_SESSION['uid']); 
    $stmt->execute();
    $username = '';
    while ($data = $stmt->fetch())
    {
      $username  =  $data['USERNAME'];     
    }
    

    // Delete
    if (isset($_POST['supp']))
    {
        $select = $dbConnection->prepare("DELETE FROM posts WHERE id_post = :id_post AND id_user = :uid");
        $select->bindParam(':id_post', $_GET['post']);
        $select->bindParam(':uid', $_SESSION['uid']);
        $select->execute();
        header('Location: index.php');
    }

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="js/navbar.js"></script>
  <link rel="shortcut icon" href="icon/in.png">
  </head>
  <body id="grad">

  <div class="topnav" id="myTopnav">
  <a href="index.php"><h2 class="camagru">Camagru</h2></a>
        <div class="menu_div">
        <a href="camera.php" class="active"><i class="fa fa-camera"></i> Camera</a>
        <div class="dropdown">
          <button class="dropbtn" ><?php echo $username; ?>
              <i class="fa fa-caret-down"></i>
          </button>
            <div class="dropdown-content" >
              <a href="editprofile.php"><i class="fa fa-edit"></i> Edit Profile</a>
              <a href="notf-cmnt.php"><i class="fa fa-bell"></i> Notification</a>
              <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
            </div>

      </div>
      </div>
      <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>


    <div class="container">
    <form method="POST">
        <label><?php echo $date ?></label>
        <?php
            if ($UID == $_SESSION['uid'])
                echo '<button class="p1" type="submit" name="supp"><i class="fa fa-trash" style="font-size:23px;color:red"></i></button>';
        ?>
        <img class="p9" src="<?php echo $src ?>"/>

        <?php

            if ($like == 0)
                echo '<button type="submit" name="like" class="like"><img src="icon/unlike.png" height="60%" width="60%" ></button>';
            else
                echo '<button type="submit" name="unlike" class="like"><img src="icon/like.png" height="60%" width="60%"></button>';
                
            echo get_nbr_like($dbConnection);
            if(get_nbr_like($dbConnection) <= 1)
            {
                    echo " like";
            }
            else
                    echo " likes";
            ?>
        <center>
                <p class="msg_err"><?php if (isset($m)) echo $m ?><p>
        </center>
            </form>
          <br>
          <form method="POST">
          	<input cols="50" type="text" name="comnt" class="co">
          	<button type="submit" name="add_cmt" class="addcom">Add</button>
            </form>
            
            <form class="comment">
              <?php
                $stmt = $dbConnection->prepare("SELECT comnt, USERNAME from comment,user where id_post = :id_post and UID = id_user  order by id_com desc ");
                $stmt->bindParam(':id_post',  $_GET['post']);
                $stmt->execute();
                while ($data = $stmt->fetch())
                {
                    echo '<p class="p"><span style="font-size:18px; color:red;"> ' . $data['USERNAME'] ." : </span>" . htmlspecialchars($data['comnt']) . '</p>';
                    
                }
              ?>
              </form>
        
        
            </form>
</div>

</div>
<div class="copyright">
			     <p>© 2019. All rights reserved | Design by
				   <a style="color:white;">Srazik</a>
            </p>
		</div>
</body>

</html>