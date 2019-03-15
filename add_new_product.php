<?php

  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    header('Location:/add_product.php');
  }
  require 'dbConnection.php';

  $product_name = $_POST['product_name'];
  $product_price = $_POST['price'];
  $cat_id = $_POST['category'];
  $product_status = 'available';

  $target_dir = "Layout/images/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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

  $stmt = $con->prepare("INSERT INTO Products (name, price, img_path, status, cat_id)
  VALUES (?,?,?,?,?)");
  if ($stmt->execute(array($product_name, $product_price, $target_file,
    $product_status, $cat_id))) {
    header('Location:products.php');
  }

?>