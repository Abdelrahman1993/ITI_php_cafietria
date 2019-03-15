<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

  include 'dbConnection.php';
  $rowID = $_POST['cancle'];
  echo $rowID;
  $cancle = $con->prepare("DELETE FROM Orders WHERE id = $rowID ");
  $cancle->execute();
  header('Location: myorder.php');
?>