<?php
  session_start();
  //print_r($_SESSION);
  $noHeader = '';
  include 'init.php';
  ?>

<section>
  <div class="container">
    <div class="login-form">
      <h1>forget password</h1>
      <h4 style="color: white;">we will send your new password to your email</h4>
      <form action="mail.php" method="POST">
        <input type="email" name="user" placeholder="Enter your email" autocomplete="off" />
        <input type="submit" name="submit" value="Reset Password">
      </form>
      <a href="index.php">login page<a>
    </div>
  </div>
</section>

