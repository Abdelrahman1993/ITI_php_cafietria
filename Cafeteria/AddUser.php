<?php
session_start();
if(isset($_SESSION['User']))
{
  include 'init.php';
  
  $action = '';

if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    $action = 'Home';
}

if($action == 'Home')
   {echo "home page";}
   elseif($action == 'Add')
   {
     echo "welcome to add user page";
   }



    
}else{
  header('location:index.php');
  exit();
}

