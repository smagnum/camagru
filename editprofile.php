<?php
require_once("inc/init.php");
checkLogin();

function isEmail($var)
	{
		return filter_var($var, FILTER_VALIDATE_EMAIL);
	}

	
//change email
if (isset($_POST['saveprofile']))
{
	$v = $_SESSION['uid'];
	$email = $_POST['email'];
	$error = 0;

	if (!isEmail($email))
		$em = "The email you entred is incorrect.";
	else if (strlen($email) > 50)
		$eml = "Your Email is too long";
	else
	{
		$req = $dbConnection->prepare("SELECT `EMAILID` FROM `user` WHERE `UID` = :id ");
		$req->bindParam(':id', $_SESSION['uid']);
    	$req->execute();
    	if($req->rowCount() == 1)
    	{
        	try
        	{
				$update = $dbConnection->prepare("UPDATE `user` SET `EMAILID` = :EMAILID WHERE `UID` = :id ");
				$update->bindParam(':EMAILID', $email);
				$update->bindParam(':id', $_SESSION['uid']);
				$update->execute();
				header('Location: index.php');
        	}
        	catch(PDOExeption $e)
        	{
        	    die($e->getMessage());
        	}
		}
	}
	
	$username = $_POST['username'];

	if (strlen($username) > 50){
		$error = 1;
		$um = "Your Username is too long";
	}


	if (!$error && !empty($username))
	{
		
		$req = $dbConnection->prepare("SELECT `USERNAME` FROM `user` WHERE `UID` = :id");
		$req->bindParam(':id', $_SESSION['uid']);
		$req->execute();
		if($req->rowCount() == 1)
		{
			
			try
			{
				$update = $dbConnection->prepare("UPDATE `user` SET `USERNAME` = :USERNAME WHERE `UID` = :id LIMIT 1");
				$update->bindParam(':USERNAME', $username);
				$update->bindParam(':id', $_SESSION['uid']);
				$update->execute();
				header('Location: index.php');
				
			}
			catch(PDOExeption $e)
			{
				die($e->getMessage());
			}
			
		}
		
	}
	$error = 0;

	$currentpassword = $_POST['currentpassword'];
	$newpassord = $_POST['newpassword'];
	$confirmnewpassord = $_POST['confirmnewpassword'];

	$uppercass = preg_match("/[A-Z]/", $newpassord);
	$lowercass = preg_match("/[a-z]/", $newpassord);
  	$number = preg_match("/[0-9]/", $newpassord);


	

	if (strlen($newpassord) < 8 || !$uppercass || !$lowercass || !$number )
	{
		$error = 1;
		$msg = "Password must be at least 8 characters long contain a number and an uppercase letter.";
	}
	if (strlen($newpassord) > 50)
	{
		$error = 1;
		$msg = "Your Password is too long";
	}
	if ($newpassord != $confirmnewpassord)
	{
		$error = 1;
		$msg = "Your new Password and confirm new password do not match ";
	}
	if(!$error)
	{
		$req = $dbConnection->prepare("SELECT PASSWORD FROM user WHERE UID = :id AND PASSWORD LIKE :PASSWORD");
		$req->bindParam(':id', $_SESSION['uid']);
		$req->bindParam(':PASSWORD',  hash('whirlpool', $currentpassword));
    	$req->execute();
    	if($req->rowCount() == 1)
    	{
        	try
        	{
				$update = $dbConnection->prepare("UPDATE user SET PASSWORD = :PASSWORD WHERE UID = :id ");
				$update->bindParam(':PASSWORD',  hash('whirlpool', $newpassord));
				$update->bindParam(':id', $_SESSION['uid']);
				$update->bindParam(':PASSWORD', hash('whirlpool', $confirmnewpassord));
				$update->execute();
				header('Location: index.php');
        	}
        	catch(PDOExeption $e)
        	{
        	    die($e->getMessage());
			}
		}
		else
			$pm = "The password you entred is incorrect.";
	}
}


?>

<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/edit.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="icon/in.png">
  </head>
  <body id="grad">
	
  <div class="topnav" id="myTopnav">
  	<a href="index.php"><h2 class="camagru">Camagru</h2></a>
		<a href="logout.php" class="logout" ><i class="fa fa-sign-out"></i>Logout</a>

</div>


<div class="container">
<div class="row">
<div class="card col-lg-12">
    <article class="card-body">
  <h1 class="page-header">Edit Profile</h1>
  <div class="row">
    <!-- left column -->
    <div class="col-md-4 col-sm-6 col-xs-12">
    </div>
    <!-- edit form column -->
    <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
    <br>
      <h3>Personal info :</h3>

      <form class="form" method="POST">
        <div class="form-group">
        <p class="msg_err"><?php if (isset($em)) echo $em; else if (isset($eml)) echo $eml ?><p>
          <label class="col-lg-3 control-label">Email:</label>
          <div class="col-lg-8">
            <input class="fname form-control" placeholder="Your Email" name="email" type="text" disabled>
            <input type="checkbox" onclick="myFunction()"  class ="check">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label>
          <div class="col-md-8">
            <input class="form-control fname" placeholder="username" name="username"  type="text" disabled>
            <input type="checkbox" onclick="myFunction()"  class ="check">
          </div>
		</div>
        <div class="form-group">
        <p class="msg_err"><?php if (isset($pm)) echo $pm ?><p>
          <label class="col-md-3 control-label">Current password:</label>
          <div class="col-md-8">
			<input class="form-control fname" placeholder="Current Password" name="currentpassword" type="password" disabled>
			<input type="checkbox" onclick="myFunction()"  class ="check">
          </div>
        </div>
        <div class="form-group">
        <p class="msg_err"><?php if (isset($msg)) echo $msg ?><p>
          <label class="col-md-3 control-label">Your New Password:</label>
          <div class="col-md-8">
            <input class="form-control fname" placeholder="Your New Password" name="newpassword"  type="password" disabled>
            <input type="checkbox" onclick="myFunction()"  class ="check">
          </div>
        </div>
        <div class="form-group">
        <p class="msg_err"><?php if (isset($pm)) echo $pm ?><p>
          <label class="col-md-3 control-label">Confirm Your New password:</label>
          <div class="col-md-8">
            <input class="form-control fname" placeholder="Confirm Your New Password" name="confirmnewpassword" type="password" >
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="box col-md-8">
          <button type="submit" class="b" name="saveprofile">Save changes</button>
            
            <a href="index.php" class="btn btn-outline-danger"><i class="fa fa-remove"></i> Cancel</a>
          </div>

        </form>
        </div>
    </div>
  </div>
  <script src="js/edit.js"></script>
</div>
<div class="copyright">
			     <p class="cop">© 2019. All rights reserved | Design by
				   <a style="color:white;">Srazik</a>
            </p>
		</div>
</body>
</html>
