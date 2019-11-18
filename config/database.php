<?php

$DB_DSN = 'localhost'; // set the hostname
$DB_NAME ="db_camagru" ; // set the database name
$DB_USER ="root" ; // set the mysql username
$DB_PASSWORD ="root";  // set the mysql password

if(!isset($setup) || $setup!= 1)
{
    try {
    $dbConnection = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $dbConnection->exec("set names utf8");
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;

    }
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
else{
    try {
        $dbConnection = new PDO("mysql:host=$DB_DSN;", $DB_USER, $DB_PASSWORD);
        $dbConnection->exec("set names utf8");
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    
        }
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
}

?>