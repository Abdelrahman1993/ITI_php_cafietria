<?php
  session_start();
  $noHeader = '';
  include 'init.php';
  echo "0000<br>";
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    echo "1111<br>";
    $user_email = $_POST['user'];
    $stmt_1 = $con->prepare("SELECT * FROM User where email= ?");
    $stmt_1->execute(array($user_email));
    echo "2222<br>";
    $val_code = "0123456789zxcvbnmqwertyuioplkjhgfdsa";
    $_POST['shuffled'] = str_shuffle($val_code);
    $_POST['shuffled'] = substr($_POST['shuffled'], 0, 8);
    echo "3333<br>";
    $to = $user_email;
    $subject = "new password";
    $txt = "Your new password is : ".password_hash($_POST['shuffled']);
    $txt .= "\n";
    $txt .= "please login with your new password   ";
    $headers = 'From: https://cafeteriait.herokuapp.com' . "\r\n" .
          'MIME-Version: 1.0' . "\r\n" .
          'Content-type: text/html; charset=utf-8';
    $m=mail($to,$subject,$txt,$headers);
    echo "3333<br>";
    echo "444";
    if($m)
    {
      echo'Check your inbox in mail';
      $stmt_1 = $con->prepare("update User set password = ? where email= ?");
      $stmt_1->execute(array($_POST['shuffled'], $user_email));
      header('Location:index.php');
    }
    else
    {
     echo'mail is not send';
    }
  }
?>

