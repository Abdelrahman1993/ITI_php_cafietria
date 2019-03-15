<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>


<h1> All Users </h1>
<p align="right">
    <a href="addUser.php" >
        <button class="addUserButton">Add User</button>
    </a>
</p>

<?php

require_once('model/user.php');
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

while($row= $users_res->fetch(PDO::FETCH_ASSOC))
{
    echo "<tr>";
		echo '<td>'.$row['name'].'</td>';
		echo '<td>'.$row['room_id'].'</td>';
		echo ' <td><img src="'.$row['img_path'].'" width="100" height="100"/> </td> ';
    echo "<td>".$row['ext'];
    echo '<td>';
    echo '<a href="editUser.php?id='.$row['id'].'"><button>Edit</button></a>';
    echo '<a href="deleteUser.php?id='.$row['id'].'"><button>Delete</button></a>';
    echo '</td></tr>';
}
    echo "</table>";
?>

</body>
</html>
