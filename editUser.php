<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }
?>

<form action="edit_current_user.php" method="post" enctype="multipart/form-data">
<center>
<table>
 <tr>
 	<h1>Edit User</h1>

 </tr>
  <?php
    $stmt = $con->prepare("SELECT * FROM User where id=".$_GET['id']);
    $stmt->execute();
    while($row= $stmt->fetch()) {
      ?>
 <tr>
 	<td><label>Name</label></td>
 	<td><input type="text" name="user_name" required  value="<?= $row['name']; ?>"/></td>
 	<td><input type="hidden" name="user_id" required  value="<?= $row['id']; ?>"/></td>
 </tr>

 <tr>
 	<td><label>Room Number</label></td>
 	<td>
 		<select  name="room_num" required>
      <?php
        $stmt1 = $con->prepare("SELECT * FROM Room");
        $stmt1->execute();
        while($row1= $stmt1->fetch())
        {
      ?>
          <option value="<?= $row1['room_id']; ?>"><?= $row1['room_id'] ?></option>';
      <?php
        }
      ?>
 		</select>
 	</td>
 </tr>

  <tr>
 	<td><label>make admin</label></td>
 	<td>
 		<select  name="admin" required>
      <option value="1">yes</option>
      <option value="0">no</option>
 		</select>
 	</td>
 </tr>
<tr>
<td><label>User Picture</label></td>
  <td><input type="file" name="fileToUpload"  accept='image/jpeg,image/jpg,image/png' ></td>
<td> <img src="<?= $row['img_path']; ?>" width="150" height="150" /></td>

 </tr>
 <tr>
 	<td><input type="submit" name="btn_Save" value="Edit"></td>
 	<td><input type="reset" value="Reset" name="btn_rest"></td>
 </tr>
   <?php
    }
  ?>
 <tr>
 	<td colspan="2"> <center><label name="lblerror" style="color: red"> <?php

       if(!empty($_GET['errormsg']))
       {
       	$error= $_GET['errormsg'];
         echo $error;
       }
 	?> </label></center></td>
 </tr>
</table>
</center>

</form>
</body>
</html>
