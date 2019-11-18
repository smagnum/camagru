<?php
Class UserClass{
      function DBConnect(){

            $DB_DSN = 'localhost:3306'; // set the hostname
            $DB_NAME ="db_camagru" ; // set the database name
            $DB_USER ="root" ; // set the mysql username
            $DB_PASSWORD ="root";  // set the mysql password
            
            
            try {
            $dbConnection = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            $dbConnection->exec("set names utf8");
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
            
            }
            catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            }
            } 
      
// logic and validation for user registration page
public function userRegistration($username,$email,$password){

try{
$dbConnection = $this->DBConnect();
$stmt = $dbConnection->prepare('SELECT * FROM `user` WHERE `EMAILID` = :EMAILID OR `USERNAME` = :USERNAME');
$stmt->bindParam(":EMAILID", $email,PDO::PARAM_STR);
$stmt->bindParam(':USERNAME', $username,PDO::PARAM_STR ); 
$stmt->execute();

$Count = $stmt->rowCount();
if($Count == 0){
// insert the new record when match not found...
$stmt = $dbConnection->prepare('INSERT INTO `user`(USERNAME,EMAILID,PASSWORD,JOINDATE,TOKEN) 
VALUES(:USERNAME,:EMAILID,:PASSWORD,:JOINDATE,:TOKEN)');
$joindate =  date("F j, Y, g:i a");

$hash_password= hash('whirlpool', $password); //Password encryption
$token = hash('whirlpool', $email);
$stmt->bindParam(':USERNAME', $username,PDO::PARAM_STR ); 
$stmt->bindParam(':EMAILID', $email,PDO::PARAM_STR); 
$stmt->bindParam(':PASSWORD', $hash_password,PDO::PARAM_STR); 
$stmt->bindParam(':JOINDATE', $joindate,PDO::PARAM_STR); 
$stmt->bindParam(':TOKEN', $token,PDO::PARAM_STR);
$stmt->execute();
if($stmt)
			{
				$to = $email;
				$subject = "Email Verfication";
				$message = "Thanks for signing up! Mr <strong>$username</strong>
                        Your account has been created, you can login with the following credentials after you have activated your account.
                        <br> Please <a href='http://localhost/token.php?token=$token'>Confirm Your Email</a>";
				$headers = "From: no-reply@camagru.com";
				$headers .= ": Camagru-Team"."\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";

				if(mail($to,$subject,$message,$headers))
				{
					header('Location: active.php');
				}
			}

$Count = $stmt->rowCount();

if($Count  == 1 ) {
$uid=$dbConnection->lastInsertId(); // Last inserted row id
$dbConnection = null;

return true;  

}
else{
$dbConnection = null;
return false; 
}
 
}
else{
 //echo "Email-ID already exits";
$dbConnection = null;
return false; 
}
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 
} 
 
// logic and validation for user login page
public function userLogin($username,$password){
 
 try{
  $dbConnection = $this->DBConnect();
        $stmt = $dbConnection->prepare('SELECT * FROM `user` 
  WHERE `USERNAME` = :USERNAME and `PASSWORD` = :PASSWORD and `confirm` = 1');
  $hash_password= hash('whirlpool', $password); 
  $stmt->bindParam(":USERNAME", $username,PDO::PARAM_STR);
  $stmt->bindParam(":PASSWORD", $hash_password,PDO::PARAM_STR);
  $stmt->execute();

  $Count = $stmt->rowCount();
  $data = $stmt->fetch(PDO::FETCH_OBJ);
  if($Count == 1){
   session_start();
   $_SESSION['uid']=$data->UID; // Storing user session value
   $_SESSION['uname']=$data->USERNAME; // Storing user session value
   $dbConnection = null ;
            return true;
      
  }
  else{
   $dbConnection = null ;
            return false ;
   
  }
  
 }
 catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
 }
 
} 
 
}
?>