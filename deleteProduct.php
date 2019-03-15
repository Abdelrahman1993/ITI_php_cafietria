<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

require_once('model/products.php');
$prod=new Product();
$prod->id=$_GET['id'];
$rownum=$prod->deleteProduct();
header("location:products.php");
exit;
?>
