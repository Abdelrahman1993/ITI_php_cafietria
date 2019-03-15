<?php

  session_start();
  include 'dbConnection.php';
  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

  $stmt = $con->prepare("delete from Products where id = ".$_GET['id']);
  $stmt->execute();
  header("location:products.php");
?>
