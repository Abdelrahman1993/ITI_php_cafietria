<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/myorder.css"> <!-- Resource style -->
    <title>my order</title>

</head>

<body>
<div class="container">
    <!--start of the head and date-->
    <div class="orderDate">
        <div>
            <h1>my order</h1>
        </div>
        <div class="row">
            <div class="col-5 offset-1">
                <input type="date" class="form-control">
            </div>
            <div class="col-5">
                <input type="date" class="form-control">
            </div>
        </div>
    </div>
    <!--end of the head and date-->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection


    $conn = mysqli_connect($servername,$username,$password,"ITI_Cafeteria");
    $data = "SELECT id,order_status,cost,room_id FROM Orders
              where user_id = '1'";

    if ($conn->connect_errno) {
        trigger_error($conn->connect_error);
    }else{
        $display = $conn->query($data);
        // header('Location: mypage.php');
    }


    ?>
    <div class="row">
        <div class="col-12">
            <ul class="cd-accordion-menu animated container">
                <li>
                    <div class="row head_menu">
                        <div class="col-md-3 col_trainings">order date</div>
                        <div class="col-md-3 col_downloads">staus</div>
                        <div class="col-md-3 col_project">amount</div>
                        <div class="col-sm-3 mx-auto col_contact">action</div>
                    </div>
                </li>
                <?php
                $GroupNum =0;

                while($row = $display->fetch_assoc()) {
                    ?>
                    <li class="has-children">
                        <input type="checkbox" name="<?php echo $GroupNum ?>" id="<?php echo $GroupNum?>">
                        <label class="row container-fluid" for="<?php echo $GroupNum ?>">
                            <div class="row">
                                <div class="col-md-3 col_trainings">
                                    <?php echo $row['id'] ?>
                                </div>
                                <div class="col-md-3 col_downloads">
                                    <?php echo $row['order_status'] ?>
                                </div>
                                <div class="col-md-3 col_project">
                                    <?php echo $row['cost'] ?>
                                </div>
                                <div class="col-sm-3 mx-auto col_contact">
                                    <?php echo $row['room_id'] ?>
                                </div>
                            </div>
                        </label>
                        <?php
                        $orderData = "SELECT * FROM Products
                        WHERE
                        id IN 
                        (SELECT product_id FROM orders_products)
                        AND 
                        ".$row['id']." IN 
                        (SELECT order_id FROM orders_products)";
                        if ($conn->connect_errno) {
                            trigger_error($conn->connect_error);
                        }else{
                            $orderDataRow = $conn->query($orderData);
                        }
                        ?>
                        <ul>
                            <div class="row rowOfProd">
                            <?php
                            while($proData = $orderDataRow->fetch_assoc()) {
                                $orderProData = "SELECT * FROM orders_products";
                                if ($conn->connect_errno) {
                                    trigger_error($conn->connect_error);
                                }else{
                                    $orderId = $conn->query($orderProData);
                                }
                                while($orderID = $orderId->fetch_assoc()) {
//                                echo "==========================";
                                if ($row['id'] == $orderID['product_id'] &&
                                    $proData['id']== $orderID['order_id'] ) {

                                    ?>
                                    <div class="col-3 prodData">
                                        <h5>
                                            <?php echo $proData['price'] ?>
                                        </h5>
                                        <img src="<?= $proData['img_path'] ?>">
                                        <h4>
                                            3 <?php echo $proData['name'] ?>
                                        </h4>
                                    </div>
                                    <?php
                                }
                            }
                            }?>
                            </div>
                        </ul>
                    </li>
                    <?php
                    $GroupNum++;

                }
                ?>

            </ul> <!-- cd-accordion-menu -->
        </div>
    </div>
</div>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/myorder.js"></script> <!-- Resource jQuery -->
</body>

</html>