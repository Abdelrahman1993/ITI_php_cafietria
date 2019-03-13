<?php
session_start();
print_r($_SESSION);
$noHeader = '';
include 'init.php'; 
if($_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
    
       //check if user exist in the db
       $stmt = $con->prepare("SELECT name, password FROM user WHERE name = ? AND password = ? AND GroupID = 1 ");
       $stmt->execute(array($username , $hashedPass));
       $count = $stmt->rowCount();
    if($count > 0)
    {
        $_SESSION['User'] = $username;
        header('location:AdminBoard.php');
        exit();
    }elseif($count = 0){
        $_SESSION['User'] = $username;
        header('location:UserAccout.php');
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