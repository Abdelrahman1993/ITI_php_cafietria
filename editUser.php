<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }


require_once('model/user.php');
$rom=new User();
$rooms=$rom->getRooms();
$exrom=new User();
$extr_rooms=$exrom->getRoomsExt();

if(!empty($_GET['id']))
{

  $_SESSION['userid']=$_GET['id'];
   $usr=new User();
   $usr->id=$_GET['id'];
   $usr_data=$usr->getUser();

       while($row= $usr_data->fetch(PDO::FETCH_ASSOC))
         {

	       foreach ($row as $key => $value)
              {
                   if($key=="name")
                   {
                    $_SESSION['usrname']=$value;
                   }
                   else if($key=="room_number")
                   {
                    $_SESSION['romnum']=$value;
                   }
                  else if($key=="ext")
                   {
                    $_SESSION['extranum']=$value;
                   }
                    else if($key=="img_path")
                     {
                      $_SESSION['img']=$value;
                     }

                  }
          }
}
?>

<form action="edit_current_user.php" method="post" enctype="multipart/form-data">
<center>
<table>
 <tr>
 	<h1>Edit User</h1>

 </tr>
 <tr>
 	<td><label>Name</label></td>
 	<td><input type="text" name="user_name" required  value=" <?php if(isset($_SESSION['usrname'])){echo $_SESSION['usrname'];}?>"/></td>
 </tr>

 <tr>
 	<td><label>Room Number</label></td>
 	<td>
 		<select  name="room_num" required>
      <?php
        while ($row=$rooms->fetch(PDO::FETCH_ASSOC))
         {
            foreach ($row as $key => $value) {
              echo '<option class="rooms"  name="rooms" value=" ';
              echo $value.' " ';
              if(isset($_SESSION['romnum']))
              {
                 if($_SESSION['romnum']==$value)
                  echo 'selected="selected"';
              }
              echo '>'.$value.'</option> ';
            }
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
<td> <img src="<?php echo $_SESSION['img']; ?>" width="150" height="150" /></td>

 </tr>
 <tr>
 	<td><input type="submit" name="btn_Save" value="Edit"></td>
 	<td><input type="reset" value="Reset" name="btn_rest"></td>
 </tr>
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
