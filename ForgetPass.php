<?php
  session_start();
  //print_r($_SESSION);
  $noHeader = '';
  include 'init.php';
  ?>

<section>
  <div class="container">
    <div class="login-form">
      <h1>Sign In</h1>
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        <input type="text" name="user" placeholder="Enter your email" autocomplete="off" />
        <input type="submit" name="" value="Reset Password">
      </form>
    </div>
  </div>
</section>






