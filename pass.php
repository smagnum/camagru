<?php
require_once("inc/init.php");
if (isset($_GET['token']) && isset($_POST['fog']))
{
    
	$token = $_GET['token'];
    $p = $_POST['password'];
    

	$password = $_POST['password'];
	$uppercass = preg_match("/[A-Z]/", $p);
	$lowercass = preg_match("/[a-z]/", $p);
    $number = preg_match("/[0-9]/", $p);

	if (strlen($p) < 8 || !$uppercass || !$lowercass || !$number)
        $msg = "Password must be at least 8 characters long contain a number and an uppercase letter.";
    else if (strlen($p) > 50)
		$msg = "Your Password is too long";
    else
    {

		$req = $dbConnection->prepare("SELECT PASSWORD FROM user WHERE TOKEN LIKE :TOKEN");
        $req->bindParam(':TOKEN', $token);
        $req->execute();
		if($req->rowCount() == 1)
		{
            
        	try
       		{
               
            	$update = $dbConnection->prepare("UPDATE user SET PASSWORD = :PASSWORD WHERE TOKEN LIKE :TOKEN");
                $update->bindParam(':PASSWORD',  hash('whirlpool', $password));
                $update->bindParam(':TOKEN', $token);
                $update->execute();
                header('Location: login.php');
        	}
        	catch(PDOExeption $e)
        	{
        	    die($e->getMessage());
            }
           
        }
         
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
                            <div class="form-group">
                                <div class="row">
                                </div>
                            </div>
                            <form class="form" method="POST">
                            <div class="form-group">
                                <label>Password Reset</label>
                                <p class="msg_err"><?php if (isset($msg)) echo $msg ?><p>
                                <input class="form-control" name="password" placeholder="new password" type="password" required/>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-block" name="fog">Reset Password</button>
                            </div>
                        </form>
                        </article>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
			     <p>© 2019. All rights reserved | Design by
			<a style="color:white;">Srazik</a>
                        </p>
                </div>          
  </body>
</html>


