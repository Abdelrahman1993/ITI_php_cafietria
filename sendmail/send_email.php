<?php
include_once '../dbConnection.php';
if(isset($_POST['submit']))
{
    $user_id = $_POST['user_id'];
    $result = mysqli_query($conn,"SELECT * FROM User where id='". $_POST['user_id']."'");
    $row = mysqli_fetch_assoc($result);
    $fetch_user_id=$row['id'];
    $email_id=$row['email'];
    $password=$row['password'];
    if($user_id==$fetch_user_id) {
      $to = $email_id;
      $subject = "Password";
      $txt = "Your password is : $password.";
      $headers = 'From: monem7242@gmail.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
      echo $to;
      echo'<br>';
      echo $password;
      echo'<br>';
      $m=mail($to,$subject,$txt,$headers);
      if($m)
      {
        echo'Check your inbox in mail';
      }
      else
      {
       echo'mail is not send';
      }
    }
    else{
      echo 'invalid userid';
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
 input{
 border:1px solid olive;
 border-radius:5px;
 }
 h1{
  color:darkgreen;
  font-size:22px;
  text-align:center;
 }

</style>
</head>
<body>
<h1>Forgot Password<h1>
<form action='' method='post'>
<table cellspacing='5' align='center'>
<tr><td>user id:</td><td><input type='text' name='user_id'/></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>
</form>
</body>
</html>
