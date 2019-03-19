<?php

  $noHeader="";
  include('init.php');
  session_start();
  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

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


<div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="userPage.php">Cafateria</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="userPage.php">Home</a></li>
                        <li><a href="myorder.php">My Orders</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" action="/action_page.php">
                        <div class="input-group">
                            <input type="text" id="search" class="form-control" placeholder="Search" name="search">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div style="margin-left: 1000px; width:300px;">
                        <img src="Layout/images/4.png" width="50px" height="50px" />
                        <a href="#">
                        <?php echo $_SESSION['User']['name']; ?>
                        </a>
                        <a href="logout.php">
                         Logout
                        </a>
                    </div>

                </nav>
            </div>
        </div>

<div class="container">
<div class="row">

            <div>
                <h1>my order</h1>
            </div>

            <form name="orderForm" method="post" action="myorder.php">
                <p class="search_input">
                <div class="row">
                    <div class="col-lg-4 offset-1">
                        <input name="startDate" type="date" class="col-lg-12 btn-lg" value="<?= $start ?>" >
                    </div>
                    <div class="col-lg-4">
                        <input name="endDate" type="date" class="col-lg-12 btn-lg" value="<?= $end ?>" >
                    </div>
                    <div class="col-lg-4">
                        <input type="submit" value="filter"  name="submit" class="col-lg-12 btn-lg">
                    </div>
                </div>
                </p>
            </form>
        </div>
</div>

<div class="container">
    <!--start of the head and date-->

    <!--end of the head and date-->
    <?php

    try {
        $results = $con->prepare("SELECT id,order_status,cost,room_id,order_date FROM Orders
                  where (order_date BETWEEN '$start' AND '$end')
                  AND user_id = ".$_SESSION['User']['id']);
        $results->execute();
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }


        $data = "SELECT id,order_status,cost,room_id,order_date FROM Orders
                  where (order_date BETWEEN '$start' AND '$end')
                  AND user_id = '2'  ";
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
                                <div class="col-lg-3 col_trainings">
                                    <?php echo $row['order_date'] ?>
                                </div>
                                <div class="col-lg-3 col_downloads">
                                    <?php echo $row['order_status'] ?>
                                </div>
                                <div class="col-lg-3 col_project">
                                    <?php echo $row['cost'] ?>
                                </div>
                                <div class="col-lg-3 mx-auto col_contact">

                                    <?php
                                        if($row['order_status']=="done"){
                                            ?>
                                            <p>done</p>
                                        <?php
                                        }else{
                                            ?>
                                        <form name="orderForm" method="POST" action="cancleorder.php">
                                            <input  type="submit" value="cancle">
                                            <input name="cancle" type="hidden" value="<?= $row['id'] ?>">
                                        </form>
                                    <?php
                                        }
                                        ?>

                                </div>
                            </div>
                        </label>
                        <?php
                        $orderData = $con->prepare("SELECT * FROM Products
                        WHERE
                        id IN 
                        (SELECT product_id FROM orders_products)
                        AND 
                        ".$row['id']." IN 
                        (SELECT order_id FROM orders_products)");
                        $orderData->execute();

                        ?>
                        <ul>
                            <div class="row rowOfProd">
                            <?php
                            while($proData = $orderData->fetch()) {
                                $orderProData = $con->prepare("SELECT * FROM orders_products");
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
                                            <img width="50" height="50" src="<?= $proData['img_path'] ?>">
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
<?php include $tpl . 'footer.php';?>
<script src="Layout/js/myorder.js"></script> <!-- Resource jQuery -->

