<?php

//$dsn    = 'mysql:host=localhost;dbname=ITI_Cafeteria';
//$user   = 'root';
//$pass   = '01111451253'
$dsn    = 'mysql:host=sql2.freemysqlhosting.net;dbname=sql2283363';
$user   = 'sql2283363';
$pass   = 'tF7%wG1*';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', );
try {
    $con = new PDO($dsn,$user,$pass ,$option);
    $con ->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo 'faild to connect' . $e->getMessage();
}