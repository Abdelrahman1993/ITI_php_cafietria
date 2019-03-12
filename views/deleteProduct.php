<?php
require_once('models/products.php');
$prod=new Product();
$prod->id=$_GET['id'];
$rownum=$prod->deleteProduct();
header("location:products.php");
exit;
?>
