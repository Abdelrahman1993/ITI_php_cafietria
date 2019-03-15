<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

require_once('model/user.php');
$prod=new User();
$prod->id=$_GET['id'];
$rownum=$prod->deleteUser();
header("location:users.php");
exit;
?>
