<?php
require_once("inc/init.php");
if (isset($_POST['fog']))
{
	$email = $_POST['email'];
	$token = hash('whirlpool',$email);

	$select = $dbConnection->prepare("SELECT * FROM user WHERE EMAILID LIKE :EMAILID");
        $select->bindParam(':EMAILID', $email);
        $select->execute();
        $number_row = $select->rowCount();

	if($number_row > 0)
	{
		$to = $email;
		$subject = "Change The Password";
		$message = "Please click here to  <a href='http://localhost/pass.php?token=$token'>Change</a> your password";
		$headers = "From: camagru@gmail.com";
		$headers .= "MIME-Version: Camagru"."\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
		if(mail($to,$subject,$message,$headers))
		{
                        header('Location: change.php');
		}
	}
	else
		$msg = "The email you entred is incorrect.";
}
?>
<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
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
                <article class="card-body">
                <a href="login.php" class="float-right btn btn-outline-danger">Return</a>
                <br>
                <form class="form" method="POST">
                            <div class="form-group">
                            <label>Reset Password</label>
                            <p class="msg_err"><?php if (isset($msg)) echo $msg ?><p>
                        <input name="email" class="form-control" placeholder="Email" type="email" required>
                        </div> 
                        <div>
                                <button type="submit" class="btn btn-danger btn-block" name="fog">Send reset password link</button>
                        </div>  
                </form>
                <footer>
                        <div class="copyright">
                        <h2 class="cop">© 2019. All rights reserved | Design by
                            <a href="#" class="btn-outline-danger" class="a" target="_blank">Srazik</a>
                        </h2>
                        </div>
                </footer>   
                </article>
                <div class="copyright">
			     <p>© 2019. All rights reserved | Design by
			<a style="color:white;">Srazik</a>
                        </p>
                </div>                
        </body>
</html>