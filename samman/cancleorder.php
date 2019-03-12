<?php
$rowID = $_POST['cancle'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = mysqli_connect($servername,$username,$password,"ITI_Cafeteria");
    $cancle = "DELETE FROM Orders WHERE id = $rowID ";
    var_dump($cancle);
    if ($conn->connect_errno) {
        trigger_error($conn->connect_error);
    }else{
        $display = $conn->query($cancle);
         header('Location: myorder.php');
    }
    var_dump($display)
?>