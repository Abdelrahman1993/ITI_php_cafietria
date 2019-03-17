<?php

  if($_SERVER['REQUEST_METHOD'] != 'POST')
  {
    header('Location:add_user.php');
  }

  $errors = "";
  if(!isset($_POST['user_name']) || empty($_POST['user_name'])){
    $errors .= "1";
  }
  if(!isset($_POST['user_pass']) || empty($_POST['user_pass'])
    || $_POST['user_pass'] != $_POST['confirm_pass'])
  {
    $errors .= '4';
  }
  if(!isset($_POST['user_email']) || empty($_POST['user_email'])
      || !filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL))
  {
    $errors .= '5';
  }
  if(!empty($errors))
  {
    header('Location:add_user.php?errors=e'.$errors);
  }


  $user_name = $_POST['user_name'];
  $user_email = $_POST['user_email'];
  $user_pass = password_hash($_POST['user_pass'], PASSWORD_DEFAULT);
  $room_num = $_POST['room_num'];
  $ext = $_POST['ext'];



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

  include 'dbConnection.php';

  $stmt = $con->prepare("INSERT INTO User (name, email, password, img_path, room_id, group_id)
  VALUES (?,?,?,?,?,?)");
  if ($stmt->execute(array($user_name, $user_email, $user_pass, $target_file,
    $room_num, 0))) {
    header('Location:users.php');
  }
  echo "kkkkkkkk";
?>