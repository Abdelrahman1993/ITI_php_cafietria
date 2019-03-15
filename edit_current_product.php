<?php

  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    header('Location:products.php');
  }
  session_start();
  require 'dbConnection.php';

  $product_id = $_POST['product_id'];

  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $cat_id = $_POST['category'];
  $product_status = $_POST['product_quantity'];


  $target_dir = "Layout/images/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  echo $target_file;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }

  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }


  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }

  echo $product_id;

  $stmt = $con->prepare("update Products set name = ?, price = ?, img_path = ?, status = ?,
                        cat_id = ? where id = ?");
  if ($stmt->execute(array($product_name, $product_price, $target_file,
    $product_status, $cat_id, $product_id))) {
    header('Location:products.php');
  }

?>