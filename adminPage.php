<?php

include('init.php');

if(!isset($_SESSION['User']))
{
  header('Location:index.php');
}
?>

    <div class="container-fluid" id="wrapper">
        <div class="row">
            <div id="side-bar" class="col-lg-4">
            <form method="post" action="saveOrder.php" >
            <input type="hidden" name="order_data" id="order_data">
                <div id="orders">


                </div>

                <div>
                    <span class="orderName">Notes :</span><br>
                    <textarea id="notes" name="notes" ></textarea>
                </div>
                <div>
                    <span class="orderName">Room : </span>
                    <select name="room" class="form-control form-control-sm">
                        <option selected>Select your Room</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM Room");
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            echo '<option value="'.$row['ext'].'" >'.$row['ext'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <br>
                    <div>
                    <strong style="display: inline;">Add to User : </strong>
                    <select name="user_name" class="form-control form-control-sm">
                        <!-- <option selected>Select User </option> -->
                        <?php
                            $stmt = $con->prepare("SELECT * FROM User WHERE id <> ?");
                            $stmt->execute(array($_SESSION['User']['id']));
                            while ($row = $stmt->fetch()) {
                                echo '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
                            }
                        ?>
                    </select><br>
                    </div>

                <hr class="style5">
                <br>
                <div class="confirm">
                    <span class="orderName">EGP </span>
                    <input id="priceInput" type="hidden" name="cost" value="">
                    <strong name="cost" id="totalPrice">0</strong>
                    <br><br>
                    <button type="submit" name="submit" class="btn btn-primary">Confirm
                    </button>
                </div>
                </form>
            </div>
            <form class="navbar-form navbar-brand" style="margin-right: 5px" action="/action_page.php">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control" placeholder="Search" name="search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

            <div class="col-lg-7">
              

                <hr class="style5">
               
                <div class="row">
                    <h1>Orders</h1>
                   <?php
                    $tableName ="Products";
                    include "pagination.php";
                    //  $stmt = $con->prepare("SELECT * FROM Products");
                    //  $stmt->execute();
                    //  while ($row = $stmt->fetch()) {
                    //     echo '<div class="col-lg-3">';
                    //     echo '<img alt="'.$row['price'].'" name="'.$row['name'].'" class="imgSize" id="'.$row['id'].'" src="'.$row['img_path'].'" /><br>';
                    //     echo  '<strong class="productName">'.$row['name'].'</strong><br>';
                    //     echo '<strong> price:</strong><strong class="price">'.$row['price'].'</strong><strong> EGP</strong>';
                    //     echo ' </div>';
                    //  }
                   ?>
            </div>
            </div>
        </div>
    </div>
    <script src="Layout/js/adminPage.js"></script>
