<?php
  session_start();
  use \PHPMailer\Exception;
  include 'PHPMailer/src/Exception.php';
  include 'PHPMailer/src/PHPMailer.php';
  include 'PHPMailer/src/SMTP.php';

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

    echo  $username;

    $val_code = "0123456789zxcvbnmqwertyuioplkjhgfdsa";
    $_POST['shuffled'] = str_shuffle($val_code);
    $_POST['shuffled'] = password_hash(substr($_POST['shuffled'], 0, 8));

    //check if user exist in the db
    $stmt = $con->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute(array($username));
    while ($row = $stmt->fetch()) {
      $mail = new PHPMailer(TRUE);

      $mail->SMTPSecure = 'ssl'; //secure transfer enabled

      $mail->setFrom('zaza_cafe@outlook.com', 'ITI Cafe Admin');
      $mail->addAddress($username);
      $mail->Subject = 'Reset password';
      $mail->Body = 'this is your new password:  '.$_POST['shuffled'];

      $mail->IsSMTP();
      $mail->Host = 'smtp-mail.outlook.com';
      $mail->SMTPAuth = true;

      $mail->Username = 'zaza_cafe@outlook.com';
      $mail->Password = 'M+e=2018';

      $mail->Port = 587;


      echo "ccccccccccc";

      $send=$mail->send();
      echo "dddddddd";
      if(!$send) {
        echo 'Email is not sent.';
        echo 'Email error: ' . $mail->ErrorInfo;
      } else {
        echo 'Email has been sent.';
      }


      /////////////////////////////
//      $to = $username;
//      $subject = "new password";
//      $txt = "Your new password is :   " . $_POST['shuffled'];
//      $txt .= "\n";
//      $txt .= "please login with your new password   ";
//
//      $m = mail($to, $subject, $txt);
//      if ($m) {
//        echo 'Check your inbox in mail';
//        $stmt_1 = $con->prepare("update User set password = ? where email= ?");
//        $stmt_1->execute(array($_POST['shuffled'], $user_email));
//        header('Location:index.php');
//      } else {
//        echo 'mail is not send';
//      }
    }
  }
?>

