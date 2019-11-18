<?php

require_once("inc/init.php");


if (isset($_SESSION['uid']))
    header('Location:index.php');
    

$userClass = new UserClass();

$errorMessage = "" ;

if (!empty($_POST['submitloginform'])) {
 
    $username=$_POST['username'];
    $password=$_POST['userpassword'];
  
 if(strlen(trim($username))>1 && strlen(trim($password))>1 ){
  
  $uid=$userClass->userLogin($username,$password);
        if($uid){
            if ($uid){
                $url='index.php';
                header("Location: $url"); // Page redirecting to index.php 
                
            }
  }
  else{
   $msg = "The username or password you entred is incorrect Or make sure your account is confirmed." ;
  }
 }
} 

?>

<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="icon/in.png">
  </head>
  <body id="grad">
  <div class="topnav" id="myTopnav">
  	<a href="index.php"><h2 class="camagru">Camagru</h2></a>
    </div>
        <div class="container">
                <div class="row">
                <div class="card col-lg-6 offset-lg-3 p-4">
                        <aside class="">
                        <article class="card-body">
                                <a href="register.php" class="float-right btn btn-outline-danger">Register</a>
                        <h4 class="card-title mb-4 mt-1">Login</h4>
                        <div class="errorMsg"><?php echo $msg; ?></div>
                        <br>
                             <form method="post" action="" name="login">
                            <div class="form-group">
                                <label>Your username</label>
                                <input name="username" class="form-control" placeholder="Username" type="Username">
                            </div> 
                            <div class="form-group">
                                <a class="float-right btn-outline-danger " href="forgotpassword.php">Forgot?</a>
                                <label>Your password</label>
                                <input name="userpassword" class="form-control" placeholder="******" type="password">
                    
                            </div> 
                            <div class="form-group">
                                <input name="submitloginform" type="submit" class="btn btn-danger btn-block" value="Login">
                            </div>                                                            
                        </form>
                        </article>
                        <div class="copyright">
			     <p>© 2019. All rights reserved | Design by
				   <a style="color:white;">Srazik</a>
            </p>
		</div>
                </div>      
                </div>    
            </div>
        </div>
  </body>
</html>