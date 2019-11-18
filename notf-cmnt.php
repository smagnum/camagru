<?php

require_once("inc/init.php");
   
checkLogin();


$idd = $_SESSION['uid'];

$select = $dbConnection->prepare("SELECT cmt FROM `user` WHERE `UID` = :id");
$select->bindParam(':id', $idd);
$select->execute();
$cmt = $select->fetchColumn();


if (isset($_POST['d']))
{
	$select = $dbConnection->prepare("SELECT * FROM `user` WHERE `UID` = :id");
	$select->bindParam(':id', $idd);
	$select->execute();
	$res = $select->fetch(PDO::FETCH_OBJ);

	$number_row = $select->rowCount();
	if($number_row > 0)
	{
		try
		{
			$update = $dbConnection->prepare("UPDATE `user` SET `cmt` = 0 WHERE `UID` = :id");
			$update->bindParam(':id', $idd);
			$update->execute();
			header('Location:index.php');
		}
		catch(PDOExeption $e)
		{
			die($e->getMessage());
		}
	}
}
else if (isset($_POST['a']))
{
	$select = $dbConnection->prepare("SELECT * FROM `user` WHERE `UID` = :id");
	$select->bindParam(':id', $idd);
	$select->execute();
	$res = $select->fetch(PDO::FETCH_OBJ);

	$number_row = $select->rowCount();
	if($number_row > 0)
	{
		try
		{
			$update = $dbConnection->prepare("UPDATE `user` SET `cmt` = 1 WHERE `UID` = :id");
			$update->bindParam(':id', $idd);
			$update->execute();
			header('Location:index.php');
		}
		catch(PDOExeption $e)
		{
			die($e->getMessage());
		}
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
	  <a href="logout.php" class="logout" ><i class="fa fa-sign-out"></i> Logout</a>
</div>



<section>
    <form method="POST">
    <?php
    if ($cmt == 1)
        echo '<center><button type="submit" class="bt" name="d">Desactiver</button></center>';
    else if ($cmt == 0)
        echo '<center><button type="submit" class="bt" name="a">Activer</button></center>';
    ?>
    </form>
</section>

<div class="copyright">
			     <p>© 2019. All rights reserved | Design by
				   <a style="color:white;">Srazik</a>
            </p>
		</div>
</body>
</html>