<?php
include('dbConnection.php');
session_start();
$user_id=$_SESSION['userId'];
$roomId="";
$err="e";
$errFlag=0;

if(isset($_POST['submit'])){
    // echo "hello dddd = ".$_POST['order_data'];
    // echo "<br>";
    
    // print_r($orderData);
//    echo $_POST['notes'];
    echo "<br>";
    if(isset($_POST['room'])&&!empty($_POST['room'])){
        $room=$_POST['room'];
        }else{
            $err .="1";
            $errFlag=1; 
        }
    if(isset($_POST['room'])&&$_POST['cost']!=0){
        $cost=$_POST['cost'];
    }else{
        $err .="2";
        $errFlag=1;
        
    }
    if($errFlag==0){
        $room=$_POST['room'];
        $cost=$_POST['cost'];
        $note= $_POST['notes'];
        $timestamp = time();
        $sql = "SELECT * FROM Room where ext = '$room'";
        if($result = mysqli_query($conn, $sql)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                   $roomId=$row['id'];
                   echo "room = ".$roomId." cost = ".$cost ;
                }
                
            }
        }
        $sql= 'INSERT INTO Orders (order_status,cost,room_id,user_id,order_date,notes)
               VALUES ("Processing",'.$cost.','.$roomId.','.$user_id.',"'.date("Y-m-d  H:i:s",time()).'","'.$note.'")';
            if($result = mysqli_query($conn, $sql)){
                $lastID = mysqli_insert_id($conn);
                $orderData =  json_decode($_POST['order_data'], true);
                foreach ($orderData as $k => $v) {
                    echo $v;
                    echo "ssss";
                    $productId='SELECT id FROM Products WHERE name="'.$k.'";';
                    if($ProductIdRes=mysqli_query($conn, $productId)){
                        if(mysqli_num_rows($ProductIdRes) > 0){
                            while($rowData = mysqli_fetch_array($ProductIdRes)){
                            $sql2= 'INSERT INTO orders_products (order_id,product_id,count)
                            VALUES ('.$lastID.','.$rowData['id'].','.$v.')';
                            if($result = mysqli_query($conn, $sql2)){
                                // echo "done";
                                header('Location:userPage.php');
                                 exit;
                            }else{
                                echo mysqli_error($conn);
                            }
                           
                            }
                        }
                       
                    }else{
                        echo mysqli_error($conn);
                    }
                       
                     
                }
            

                
            }else{
                echo mysqli_error($conn);
            }


    }else{
        
         header('Location:userPage.php?err='.$err);
    }  

}




 