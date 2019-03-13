<?php
session_start();
require_once('products.php');
$check=false;

if($check)
{
	$_SESSION['proname']=$_POST['product_name'];
	$_SESSION['proprice']=$_POST['product_price'];
	$_SESSION['proquantity']=$_POST['product_quantity'];
	$_SESSION['procat']=$_POST['category'];
	$errors=$pherror.'</br> '.$nameerror;
	header("location:editProduct.php?errormsg=$errors");
	exit;
}
else
{
	$obj=new Product();
	$obj->id=$_SESSION['proid'];
	$obj->name=$_POST['product_name'];
	$obj->price=$_POST['product_price'];
	$obj->quantity=$_POST['product_quantity'];
	$obj->category_id=$_POST['category'];
	$obj->imagepath=$_SESSION['imgpath'];
	$test=$obj->editProduct();
	unset($_SESSION['proid']);
	unset($_SESSION['proname']);
	unset($_SESSION['proprice']);
	unset($_SESSION['proquantity']);
	unset($_SESSION['procat']);
	header("location:../products.php");
}

?>
