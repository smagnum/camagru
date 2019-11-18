<?php
require_once("inc/init.php");
?>

<html>
  <head>
    <title>Camagru</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/fg.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Satisfy&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="icon/in.png">
  <script src="js/navbar.js"></script>
  </head>
  <body id="grad">


<?php
include_once("views/menu.php");
?>
<div id="container">
  <?php
		global $dbConnection;
      $stmt = $dbConnection->prepare("SELECT * FROM posts order by id_post desc LIMIT 0, 5");
        $stmt->execute();
          while ($data = $stmt->fetch())
          {
              echo '<div class="postes">
            <a href="post.php?post=' . $data["id_post"] . '"><img class="d" src="'. $data["image"] .'"/></a>
            </div>';
          }
  ?>
</div>

<script>
		const con = document.getElementById('container');
		var limit_start = 5;
		window.addEventListener("scroll", function () {

				if (window.scrollY + window.innerHeight >= con.clientHeight) {
				var xhttp = new XMLHttpRequest();
				var params = "limit_start=" + limit_start;
				xhttp.open("POST", "get_posts.php", true);
				xhttp.withCredentials = true;
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.onreadystatechange = function () {
					if (this.readyState == 4 && this.status == 200) 
					{
						if (this.responseText == "0")
							nb = this.responseText;
						else
							con.innerHTML += this.responseText;
					}
				}
				xhttp.send(params);
				limit_start += 5;

			}
		});
	</script>
	    <div class="copyright">
		<p class="cop">© 2019. All rights reserved | Design by
		<a style="color:white;">Srazik</a>
		</p>
		                </div>
</body>
</html>
