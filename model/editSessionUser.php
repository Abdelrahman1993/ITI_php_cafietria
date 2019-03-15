<?php

session_start();
require_once('user.php');
$check=false;

if(isset($_POST['user_name']))
{
  $uname=trim($_POST['user_name']);
  if(empty($uname))
  {
	$check=true;
  	$err="Enter User Name";
  }
}

if($check)
{
	$_SESSION['usrname']=$_POST['user_name'];
	$_SESSION['room_number']=$_POST['rooms'];
	$errors='</br> '.$err;
    header("location:editUser.php?errormsg=$errors");
 	exit;
}
else
{
	$eusr=new User();
	$eusr->name=$_POST['user_name'];
	$eusr->room_num=$_POST['rooms'];
	$eusr->extra_room=$_POST['exrooms'];
	$eusr->id=$_SESSION['userid'];
 	$t=$eusr->Edit_User();
	header("location:../users.php");
	


}





?>

