<?php
  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    header('Location:/add_product.php');
  }
  require './connect.php';

  $product_name = $_POST['product_name"'];
  $product_price = $_POST['price'];
  $cat_id = $_POST['category'];
  $product_image = $_POST['product_image'];
  $product_status = 'available';


  $sql = "insert into Products (name, price, img_path, status, cat_id) values(?, ?, ?, ?, ?)";

  if ($stmt = mysqli_prepare($con, $sql))
  {
    mysqli_stmt_bind_param($stmt, "sissi", $product_name, $product_price,
      $product_image, $product_status, $cat_id);
    $res = mysqli_stmt_execute($stmt);
    // Fetch data here
    mysqli_stmt_close($stmt);
    if (!$res){
      echo mysqli_error($con);
      die('Invalid query: ' . mysqli_error());
    }
    else {
      mysqli_close($con);
      header('Location:/add_product.php');
    }
  }
  mysqli_close($con);
?>