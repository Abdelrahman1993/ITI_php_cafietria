<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

include('dbConnection.php');
session_start();
$roomId="";
$err="e";
$admin;
$errFlag=0;
$mainPage=0;
$user_id=$_SESSION['User']['id'];
$admin=$_SESSION['User']['group_id'];

if(isset($_POST['submit'])){

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

        $stmt = $con->prepare("SELECT * FROM Room where ext =  ?");
        $stmt->execute(array($room));
        while ($row = $stmt->fetch()) {
          $roomId=$row['room_id'];
          echo "room = ".$roomId." cost = ".$cost ;
        }

        if($admin==1){
            $user_name=$_POST['user_name'];
            // $get_user = "SELECT * FROM User where name = '$user_name'";
            // if($result_user = mysqli_query($conn, $get_user)){
            //     if(mysqli_num_rows($result_user) > 0){
            //         while($row_user = mysqli_fetch_array($result_user)){
            //            $user_id=$row_user['id'];
            //            $sql= 'INSERT INTO Orders (order_status,cost,room_id,user_id,order_date,notes)
            //            VALUES ("Processing",'.$cost.','.$roomId.','.$user_id.',"'.date("Y-m-d  H:i:s",time()).'","'.$note.'")';           
            //            save_user_data($sql);   
            //     }
            //     }
            // }
            $stmt_1 = $con->prepare("SELECT * FROM User where name = ?");
            $stmt_1->execute(array($user_name));          
            while ($row_user = $stmt_1->fetch()) {
                $user_id=$row_user['id'];
                // $sql= 'INSERT INTO Orders (order_status,cost,room_id,user_id,order_date,notes)
                // VALUES ("Processing",'.$cost.','.$roomId.','.$user_id.',"'.date("Y-m-d  H:i:s",time()).'","'.$note.'")';           
                 $stmt_2 = $con->prepare("INSERT INTO Orders (order_status,cost,room_id,user_id,order_date)
                 VALUES ('Processing',?,?,?,?)");
                  if($stmt_2->execute(array($cost,$roomId,$user_id,date("Y-m-d  H:i:s",time())))){
                    save_user_data($con,$admin); 
                  }
            }   

        }else{
            $user_id=$_SESSION['User']['id'];
            $stmt_3 = $con->prepare("INSERT INTO Orders (order_status,cost,room_id,user_id,order_date)
                 VALUES ('Processing',?,?,?,?)");
                  if($stmt_3->execute(array($cost,$roomId,$user_id,date("Y-m-d  H:i:s",time())))){
                    save_user_data($con,$admin); 
                  }
    }
    }else{
        if($admin==1){
            header('Location:adminPage.php?err='.$err);

        }else{
            header('Location:userPage.php?err='.$err);

        }
        
    }  

}


function save_user_data($con,$admin){
       $lastID = $con->lastInsertId();
        $orderData =  json_decode($_POST['order_data'], true);
        foreach ($orderData as $k => $v) {
            echo $v;
            echo " ".$k;
            $stmt3 = $con->prepare("SELECT id FROM Products WHERE name = ?");
            $stmt3->execute(array($k));
            while ($rowData = $stmt3->fetch()) {
                $stmt2 = $con->prepare("INSERT INTO orders_products (order_id,product_id,count)
                VALUES (?,?,?)");
                if ($stmt2->execute(array($lastID,$rowData['id'],$v))) {
                          $mainPage=1;
                }
            } 
        }
    
    if($mainPage==1){
        if($admin==1){
            // echo "ADMIN";
              header('Location:adminPage.php');
              exit;
        }else{
            // echo "USER";
            header('Location:userPage.php');
            exit;
        }
    }else{
        echo "AIA";
    }



}



 