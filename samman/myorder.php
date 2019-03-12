<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/myorder.css"> <!-- Resource style -->
    <title>my order</title>

</head>

<body>
<?php
    if($_POST){
        $start = $_POST['startDate'];
        $end = $_POST ['endDate'];
        if($start == "" || $end == ""){
            $start = '2019-03-01';
            $end =  date("Y-m-d");
        }
    }else{
        $start = '2019-03-01';
        $end =  date("Y-m-d");

    }
?>
<div class="container">
    <!--start of the head and date-->
    <div class="orderDate">
        <div>
            <h1>my order</h1>
        </div>

        <form name="orderForm" method="post" action="myorder.php">
            <p class="search_input">
            <div class="row">
                <div class="col-4 offset-1">
                    <input name="startDate" type="date" class="form-control" value="<?= $start ?>" >
                </div>
                <div class="col-4">
                    <input name="endDate" type="date" class="form-control" value="<?= $end ?>" >
                </div>
                <div class="col-3">
                    <input type="submit" value="filter" name="submit" class="">
                </div>
            </div>
            </p>
        </form>
    </div>
    <!--end of the head and date-->
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        // Create connection
//        $conn = mysqli_connect($servername,$username,$password,"ITI_Cafeteria");

    try {
        $conn = new PDO("mysql:host=$servername;dbname=ITI_Cafeteria", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $results = $conn->prepare("SELECT id,order_status,cost,room_id,order_date FROM Orders
                  where (order_date BETWEEN '$start' AND '$end')
                  AND user_id = '2'  ");
        $results->execute();
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }



        $data = "SELECT id,order_status,cost,room_id,order_date FROM Orders
                  where (order_date BETWEEN '$start' AND '$end')
                  AND user_id = '2'  ";

//        if ($conn->connect_errno) {
//            trigger_error($conn->connect_error);
//        }else{
//            $display = $conn->query($data);
//        }
    ?>
    <div class="row">
        <div class="col-12">
            <ul class="cd-accordion-menu animated container">
                <li>
                    <div class="row head_menu">
                        <div class="col-md-3 col_trainings">order date</div>
                        <div class="col-md-3 col_downloads">staus</div>
                        <div class="col-md-3 col_project">cost</div>
                        <div class="col-sm-3 mx-auto col_contact">action</div>
                    </div>
                </li>
                <?php

                $GroupNum =0;
                while($row = $results->fetch()) {
                    ?>
                    <li class="has-children">
                        <input type="checkbox" name="<?php echo $GroupNum ?>" id="<?php echo $GroupNum?>">
                        <label class="row container-fluid" for="<?php echo $GroupNum ?>">
                            <div class="row">
                                <div class="col-md-3 col_trainings">
                                    <?php echo $row['order_date'] ?>
                                </div>
                                <div class="col-md-3 col_downloads">
                                    <?php echo $row['order_status'] ?>
                                </div>
                                <div class="col-md-3 col_project">
                                    <?php echo $row['id'] ?>
                                </div>
                                <div class="col-sm-3 mx-auto col_contact">
                                    <form name="orderForm" method="post" action="cancleorder.php">
                                    <?php
                                        if($row['order_status']=="done"){
                                            ?>
                                            <p>done</p>
                                        <?php
                                        }else{
                                            ?>

                                    <input  type="submit" value="cancle">
                                    <input name="cancle" type="hidden" value="<?= $row['id'] ?>">
                                    <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </label>
                        <?php
                        $orderData = $conn->prepare("SELECT * FROM Products
                        WHERE
                        id IN 
                        (SELECT product_id FROM orders_products)
                        AND 
                        ".$row['id']." IN 
                        (SELECT order_id FROM orders_products)");
                        $orderData->execute();
//                        if ($conn->connect_errno) {
//                            trigger_error($conn->connect_error);
//                        }else{
//                            $orderDataRow = $conn->query($orderData);
//                        }
                        ?>
                        <ul>
                            <div class="row rowOfProd">
                            <?php
                            while($proData = $orderData->fetch()) {
                                $orderProData = $conn->prepare("SELECT * FROM orders_products");
                                $orderProData->execute();
//                                if ($conn->connect_errno) {
//                                    trigger_error($conn->connect_error);
//                                }else{
//                                    $orderId = $conn->query($orderProData);
//                                }
                                while($orderID = $orderProData->fetch()) {
                                    if ($row['id'] == $orderID['order_id'] &&
                                        $proData['id']== $orderID['product_id'] ) {

                                        ?>
                                        <div class="col-3 prodData">
                                            <h5>
                                                <?php echo $orderID['count']*$proData['price'] ?>
                                            </h5>
                                            <img src="<?= $proData['img_path'] ?>">
                                            <h4>
                                                <?php
                                                    echo $orderID['count'];
                                                    echo " : " ;
                                                    echo $proData['name']
                                                ?>
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