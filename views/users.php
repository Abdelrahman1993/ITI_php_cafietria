<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/users.css">
</head>
<body>

<div class="tab">
        <a href="Go to home page.php "><h2>Home</h2></a>
        <a href="products.php"><h2>Products</h2></a>
        <a href="users.php"><h2>Users</h2></a>
        <a href="go to orders.php"><h2>Manual Order</h2></a>
        <a href="go to checks.php"><h2>Checks</h2></a>
        <a href="go to admin.php">
        <img id="userImg" src="images/admin.png" width="40" height="40" />
        <h2>ISLAM</h2>
        </a>
</div>


<h1> All Users </h1>
<p align="right">
    <a href="addUser.php" >
        <button class="addUserButton">Add User</button>
    </a>
</p>

<?php

require_once('models/user.php');
$user=new User();
$users_res=$user->getAllUsers();
echo '<table border=1 class="t01" >';
echo "<tr>
  <td>Name</td>
  <td>Room</td>
  <td>Image</td>
  <td>Ext</td>
  <td>Action</td>
  </tr>";

$rowid;
while($row= $users_res->fetch(PDO::FETCH_ASSOC))
{
    echo "<tr>";
    foreach ($row as $key => $value)
    {
      if($key=="name")
      {
        if($value=="Deleted")
            break;
      }

        if($key=="id")
            $rowid=$value;
    
        else if($key=="img_path")
                echo ' <td> <img src="'.$value.'" width="100" height="100"/> </td> ';
        else
              echo "<td>$value</td>";
        }
        echo "<td>
              <a href= editUser.php?id=$rowid><button>Edit</button></a>
              <a href= deleteUser.php?id=$rowid><button>Delete</button></a>
             </td></tr>";
    }
    echo "</table>";
?>


</body>
</html>
