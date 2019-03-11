<?php
session_start();
include 'init.php'; 
include $tpl . 'header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
    
       //check if user exist in the db
       $stmt = $con->prepare("SELECT name, password FROM user WHERE name = ? AND password = ? ");
       $stmt->execute(array($username , $hashedPass));
       $count = $stmt->rowCount();
       echo $count;

       if(isset($_SESSION['User']) && $count > 0 )
       {
           header('location:test1.php');
       }
       else{
        header('location:test2.php');
        }
}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
<h4 class="text-center">Login</h4>
<input class="form-control" type="text" name="user"  placeholder="Enter your name" autocomplete="off" />
<input class="form-control" type="password" name="pass"  placeholder="Enter your Password" autocomplete="new-password" />
<input class="btn btn-primary btn-block" type="submit" value="login" />

</form>

<?php include $tpl . 'footer.php';?>