<?php

  session_start();
  include 'dbConnection.php';
  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

  $stmt = $con->prepare("delete from User where id = ".$_GET['id']);
  $stmt->execute();
//  var_dump($stmt);
//  exit();
  header("location:users.php");
?>
