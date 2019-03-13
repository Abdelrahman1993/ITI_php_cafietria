<?php
session_start();

require_once('models/user.php');
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

<htm></!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
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

<form action="./models/editSessionUser.php" method="post"  >

<table>
 <tr>
 	<h1> Edit User </h1>

 </tr>
 <tr>
 	<td><label>Name</label></td>
 	<td><input type="text" name="user_name" required  value=" <?php if(isset($_SESSION['usrname'])){echo $_SESSION['usrname'];}?>"/></td>
 </tr>

 <tr>
 	<td><label>Room Number</label></td>
 	<td>
 		<select  name="rooms" required>

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
  <td><label>Extra Rooms</label></td>
  <td>
    <select  name="exrooms"   required>

          <?php
              while ($exrow=$extr_rooms->fetch(PDO::FETCH_ASSOC))
               {
                      foreach ($exrow as $key => $value) {

                       echo '<option class="exrooms"  name="exrooms" value=" ';
                       echo $value.' " ';

                       if(isset($_SESSION['extranum']))
                        {
                          if($_SESSION['extranum']==$value)
                             echo 'selected="selected"';
                        }

                        echo '>'.$value.'</option> ';

                      }
               }
             ?>


    </select>
  </td>
<td> <img src="<?php echo   $_SESSION['img']; ?>" width="150" height="150" /></td>
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


</form>
</body>
</html>
