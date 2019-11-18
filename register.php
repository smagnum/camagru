<?php
require_once("inc/init.php");

$userClass = new UserClass();

$errorMessage = "" ;
$sucessMessage = "" ;
if (!empty($_POST['submitregistrationform'])) {
 
$username=$_POST['username'];
$email=$_POST['emailid'];

$conf_password = 1;
//$password=$_POST['userpassword']!=['userpassword1'];
if ($password=$_POST['userpassword']!= $password=$_POST['userpassword1'])
 {
    $conf_password = 0;
 }
 $password=$_POST['userpassword'];
 $p = $password;

 $uppercass = preg_match("/[A-Z]/", $p);
 $lowercass = preg_match("/[a-z]/", $p);
 $number = preg_match("/[0-9]/", $p);
 if (strlen($p) < 8 || !$uppercass || !$lowercass || !$number)
		$msg = "Password must be at least 8 characters long contain a number and an uppercase letter .";
    else
//$date= date();
/* Regular expression check */
$username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
// $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
if ($username_check && $email_check && $conf_password){

    $uid=$userClass->userRegistration($username,$email,$password);

 if ($uid){
 }
}
else {
    $errorMessage = "Please enter the valid details";
}
}

?>


<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="icon/in.png">
  </head>
  <body id="grad">
  <div class="topnav" id="myTopnav">
  	<a href="index.php"><h2 class="camagru">Camagru</h2></a>
    </div>
        <div class="container">
                <div class="row">
                <div class="card col-lg-6 offset-lg-3 p-4 ">
                        <article class="card-body">
                                <a href="login.php" class="float-right btn btn-outline-danger">Login</a>
                        <h4 class="card-title mb-4 mt-1">Register</h4>
                             <form method="post" action="" name="register">
                            <div class="form-group">
                                <label>Username</label>
                                <div class="row">
                                        <div class="col-xs-6 col-md-6 ">
                                            <input class="form-control" name="username" placeholder="username" type="text"
                                                required autofocus />
                                        </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label>Your Email</label>
                                <input class="form-control" name="emailid" placeholder="Your Email" type="email" autocomplete="off"/>
                                <p class="msg_err"><?php if (isset($msg)) echo $msg ?><p>
                                <input class="form-control" name="userpassword" placeholder="New Password" type="password" autocomplete="off" />
                                <br>
                                <input class="form-control" name="userpassword1" placeholder="Re-enter New Password" type="password" autocomplete="off"/>
                                <div class="errorMsg"><?php echo $errorMessage; ?></div>
                                <div class="sucessMsg"><?php echo $sucessMessage; ?></div>
                            </div>  
                            <div class="form-group">
                                <input type="submit" class="btn btn-danger btn-block" name="submitregistrationform" value="Register">  
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
  </body>
</html>