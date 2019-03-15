<?php

  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    header('Location:/users.php');
  }
  session_start();
  require 'dbConnection.php';

  $user_id = $_POST['user_id'];

  $user_name = $_POST['user_name'];
  $room_num = $_POST['room_num'];
  $admin = $_POST['admin'];


  $target_dir = "Layout/images/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  echo $target_file;
  echo '<br>';
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

  echo $user_id;

  $stmt = $con->prepare("update User set name = ?, img_path = ?, room_id = ?,
                        group_id = ? where id = ?");
  if ($stmt->execute(array($user_name, $target_file,
    $room_num, $admin, $user_id))) {
    header('Location:users.php');
  }

?>