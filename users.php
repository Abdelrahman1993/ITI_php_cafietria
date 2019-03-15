<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>
<div class="container" >
    <h1> All Users </h1>

    <p align="right">
      <a href="add_user.php" >
        <button class="addUserButton">Add User</button>
      </a>
    </p>
    <table class="table table-dark" style="border: 2px solid black">
        <thead class="head-dark">
        <tr>
            <th scope="col"> <h4 class="col">Name</h4></th>
            <th scope="col"><h4 class="">Image</h4></th>
            <th scope="col"><h4 class="">Room</h4></th>
            <th scope="col"><h4 class="">Ext</h4></th>
            <th scope="col"><h4 class="">Action</h4></th>
        </tr>
        </thead>
        <tbody>
<?php
 $tableName="User";
 include "pagination.php";
?>
        </tbody>
    </table>
</div>

</body>
</html>
