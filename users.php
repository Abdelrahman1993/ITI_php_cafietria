<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }
    require_once('model/user.php');
    $user=new User();
    $users_res=$user->getAllUsers();
?>
<div class="container" >
    <h1> All Users </h1>

    <a href="addUser.php" >
        <button class="addUserButton">Add User</button>
    </a>
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
while($row= $users_res->fetch(PDO::FETCH_ASSOC))
{
    ?>
    <tr>
        <th><?=$row['name']?></th>
        <td>
            <img src="<?= $row['img_path']?>" width="100" height="100">
        </td>
        <td><?=$row['room_id']?></td>
        <td><?=$row['ext']?></td>
        <td>
            <a href="editUser.php?id='<?=$row['id']?>'"><button>Edit</button></a>
            <a href="deleteUser.php?id='<?=$row['id']?>'"><button>Delete</button></a>
        </td>
    </tr>
<?php
}
?>
        </tbody>
    </table>
</div>

</body>
</html>
