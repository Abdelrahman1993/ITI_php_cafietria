<?php
include('dbConnection.php');
session_start();
$user_id=$_SESSION['userId'];
$roomId="";

if(isset($_POST['submit'])&&isset($_POST['cost'])&&isset($_POST['room'])){
    $room=$_POST['room'];
    $cost=$_POST['cost'];
    $sql = "SELECT * FROM Room where ext = '$room'";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
               $roomId=$row['id'];
               echo "room = ".$roomId." cost = ".$cost ;
            }
            
        }
    }
    $sql= 'INSERT INTO Orders (order_status,cost,room_id,user_id)
           VALUES ("NO",'.$cost.','.$roomId.','.$user_id.')';
        if($result = mysqli_query($conn, $sql)){
            header('Location:page1.php');
            exit;
        }else{
            echo mysqli_error($conn);
        }
}
 