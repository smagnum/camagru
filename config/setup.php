<?php
$setup=1;
include 'database.php';

try
{

  /*
  ** Create database
  */

  $dbConnection->query('CREATE DATABASE IF NOT EXISTS db_camagru');
  /*
  ** Select database
  */
  $dbConnection->query('USE db_camagru');
  /*
  ** Create permanent user table - post verification
  */
  $dbConnection->query(
    'CREATE TABLE IF NOT EXISTS user (
    `UID` int(3) PRIMARY KEY AUTO_INCREMENT,
    `USERNAME` varchar(255) NOT NULL,
    `EMAILID` varchar(255) NOT NULL,
    `PASSWORD` varchar(255) NOT NULL,
    `JOINDATE` varchar(255) NOT NULL,
    `TOKEN` varchar(255) NOT NULL,
    `confirm` int(11) NOT NULL DEFAULT 0,
    `cmt` int(11) NOT NULL DEFAULT 0)
  
');
echo "Table 'user' created successfully<br/>";
$dbConnection->query(
  'CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `ver` int(11) NOT NULL DEFAULT 0)
  
');
echo "Table 'posts' created successfully<br/>";
$dbConnection->query(
  'CREATE TABLE IF NOT EXISTS `likes` (
  `id_like` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL)
  
');
echo "Table 'likes' created successfully<br/>";
$dbConnection->query(
  'CREATE TABLE IF NOT EXISTS `comment` (
  `id_com` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `comnt` varchar(255) NOT NULL)
');
echo "Table 'comment' created successfully<br/>";
}
catch (PDOException $e)
{
	echo $e;
  die('<h1 style="text-align: center;">Something terrible has happend with the db</h2>');
  //die('FATAL ERROR: ' . $e->getMessage()); //for debugging
}
?>