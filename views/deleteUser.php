<?php
require_once('models/user.php');
$prod=new User();
$prod->id=$_GET['id'];
$rownum=$prod->deleteUser();
header("location:users.php");
exit;

?>
