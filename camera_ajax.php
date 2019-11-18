<?php
    require_once("inc/init.php");
    date_default_timezone_set('Africa/Casablanca');
   
    checkLogin();

$emoji = "";
$fp = "";
$msg = "";
//add post
function add_post($user_id,$image,$date_creation)
{
  global $dbConnection;

  $cmd = $dbConnection->prepare("INSERT INTO `posts` (id_user, image, date_creation) values (:id_user,:image,:date_creation)");
  //$cmd->execute([$user_id,"upload/".$image,$date_creation]);
  $cmd->bindParam(':id_user', $user_id);
  $cmd->bindParam(':image', $image);
  $cmd->bindParam(':date_creation', $date_creation);
  $cmd->execute();
}

if (isset($_POST['sticker']) && $_POST['sticker'])
{
  $emoji = $_POST['sticker'];
	if (in_array($_POST['sticker'], ['E1','E2','E3','E4','E5','E6'])) {
		$emoji = "img/" . $_POST['sticker'] . ".png";
	}
}

// Camera
$allowed = array('jpg', 'jpeg', 'png');
if (isset($_POST['imgBase64']) && isset($_POST['extension']) && (in_array($_POST['extension'], $allowed) || $_POST['extension'] == '0'))
{
  $extension = $_POST['extension'];
	$dontCheck = false;
	if ($extension == '0') {
		$extension = 'jpeg';
		$dontCheck = true;
	}
  $rawData = $_POST['imgBase64'];
  $baseType = $extension == 'jpg' ? 'jpeg' : $extension;
  $rawData = str_replace('data:image/'.$baseType.';base64,', '', $rawData);
  $rawData = str_replace(' ', '+', $rawData);
  $unencoded = base64_decode($rawData);
  $datime = date("Y-m-d-H.i.s", time() ) ; # - 3600*7
  $userid  = $_SESSION['uid'] ;
  
  // Name & save the image file 
  $fp = 'upload/'.$datime.'-'.$userid.'.'.$extension;
  file_put_contents($fp, $unencoded);
 
  if (1) {
    //  Sticker
    if (!empty($emoji))
    {
      $fp_image = $extension == 'png' ? imagecreatefrompng($fp) : imagecreatefromjpeg($fp);
      $current_image = imagecreatefrompng($emoji);
      
      imagecopy($fp_image, $current_image, 50, 50, 0, 0, 128, 128);
      imagepng($fp_image, $fp);
    }
    add_post($_SESSION["uid"],$fp,$datime); //adding posts
  
    
    $req = $dbConnection->prepare("SELECT `ver` FROM posts WHERE `ver` = 0 AND  `image` = :img");
    $req->bindParam(':img', $fp);
    $req->execute();
    if($req->rowCount() == 1)
    {
      try
      {
        $isSnap = $dontCheck ? 1 : 0;
        $update = $dbConnection->prepare("UPDATE posts SET `ver` = 1 WHERE  `image` = :img");
        $update->bindParam(':img', $fp);
        $update->execute();
      }
      catch(PDOExeption $e)
        {
          die($e->getMessage());
        }
      }
    } else {
      $msg = "Your file is invalid for some reason. Please check again before uploading.";
    }
  }


?>