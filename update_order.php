<?php

  echo "<h1>kkkkkkkkkkkkkkkkkk</h1>";

  include "dbConnection.php";
  $stmt = $con->prepare('update Orders set order_status = "done" where id = ?');
  $stmt->execute(array($_GET['q']));
?>