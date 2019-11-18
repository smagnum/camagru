<?php
include("./config/database.php");

if (isset($_GET["token"]))
   {    
       $token = $_GET["token"];
       $req = $dbConnection->prepare("SELECT confirm FROM user WHERE TOKEN='$token'");
       $req->bindParam(':token', $token);
       $req->execute();
       if($req->rowCount() > 0)
       {
          try
           {
               $update = $dbConnection->prepare("UPDATE user SET `confirm` = 1 WHERE TOKEN='$token'");
               $update->execute();
           }
           catch(PDOExeption $e)
           {
               die($e->getMessage());
           }
   }
   }
   else
   {
       die("Something went Wrong");
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
                
                            <div class="form-group">
							<h3 class="qwe">Your account has been verified.<br> You can now login</h3>
							<img class="ok" src="icon/ok.png" >
							<br>
                			</div> 
                <div class="form-group">
								<a href="login.php"><button type="submit" class="btn btn-danger btn-block" name="login">Login</button></a>
                            </div>  
                            <div class="copyright">
			     <p>© 2019. All rights reserved | Design by
			<a style="color:white;">Srazik</a>
                        </p>
                </div>                                      
        </body>
</html>