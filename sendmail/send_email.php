<?php
  session_start();
  $noHeader = '';

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $dsn    = 'mysql:host=sql2.freemysqlhosting.net;dbname=sql2283363';
    $user   = 'sql2283363';
    $pass   = 'tF7%wG1*';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', );
    try {
        $con = new PDO($dsn,$user,$pass ,$option);
        $con ->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo 'faild to connect' . $e->getMessage();
    }

    $username = $_POST['user'];

    //check if user exist in the db
    $stmt = $con->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute(array($username));

    $val_code = "0123456789zxcvbnmqwertyuioplkjhgfdsa";
    $_POST['shuffled'] = str_shuffle($val_code);
    $_POST['shuffled'] = substr($_POST['shuffled'], 0, 8);
    $to = $username;
    $subject = "new password";
    $txt = "Your new password is :   ".password_hash($_POST['shuffled']);
    $txt .= "\n";
    $txt .= "please login with your new password   ";
    $headers = 'From: awadmohamed@gmail.com' . "\r\n" .
          'MIME-Version: 1.0' . "\r\n" .
          'Content-type: text/html; charset=utf-8';
    $m=mail($to,$subject,$txt,$headers);
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

