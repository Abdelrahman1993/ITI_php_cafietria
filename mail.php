<?php

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

    $val_code = "0123456789zxcvbnmqwertyuioplkjhgfdsa";
    $_POST['shuffled'] = str_shuffle($val_code);
    $_POST['shuffled'] = substr($_POST['shuffled'], 0, 8);

    //check if user exist in the db
    $stmt = $con->prepare("SELECT * FROM User WHERE email = ?");
    $stmt->execute(array($username));
    while ($row = $stmt->fetch()) {

      require './vendor/autoload.php';
      $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = TRUE;
        $mail->Username = "a.abdelfatah.100@gmail.com";
        $mail->Password = "bxxpyhkudxpsxllt";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->From = "a.abdelfatah.100@gmail.com";
        $mail->FromName = "ITI Cafeteria";
      try {
         /* Set the mail sender. */
         $mail->setFrom('a.abdelfatah.100@gmail.com', 'ITI Cafeteria');
         /* Add a recipient. */
         $mail->addAddress($username);
         /* Set the subject. */
         $mail->Subject = 'ITI Cafeteria Password';
         /* Set the mail message body. */
      //    $mail->Body = "This is your password for ITI Cafeteria :".$result[0]['password'];
          $mail->Body = 'this is your new password:  '.$_POST['shuffled'];
         /* Finally send the mail. */
         $mail->send();

         $stmt_1 = $con->prepare("update User set password = ? where email= ?");
          $stmt_1->execute(array(password_hash($_POST['shuffled'], PASSWORD_DEFAULT), $username));
          header('Location:index.php');

      }
      catch (Exception $e)
      {
         echo $e->errorMessage();
      }
      catch (\Exception $e)
      {
         echo $e->getMessage();
      }
    }
  }
?>