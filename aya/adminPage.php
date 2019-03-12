<?php
include('dbConnection.php');
session_start();
$_SESSION['userId'] = 4;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cafateria</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container-fluid" id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Cafateria</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Users</a></li>
                        <li><a href="#">Manual Order</a></li>
                        <li><a href="#">Checks</a></li>
                    </ul>

                    <div style="margin-left: 1000px; width:300px;">
                        <img src="./images/person.png" width="50px" height="50px" />
                        <a href="#">Admin</a>
                    </div>


                </nav>
            </div>

        </div>

        <div class="row">
            <div id="side-bar" class="col-lg-4">
            <form method="post" action="saveOrder.php" >
                <div id="orders">


                </div>

                <div>
                    <span class="orderName">Notes :</span><br>
                    <textarea id="notes"></textarea>
                </div>
                <div>
                    <span class="orderName">Room : </span>
                    <select class="form-control form-control-sm">
                        <option selected>Select your Room</option>
                        <?php
                        $sql= "select * from Room";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){ 
                                while($row = mysqli_fetch_array($result)){
                                    echo '<option value="'.$row['ext'].'" >'.$row['ext'].'</option>';
                                    
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <br>
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


            <div class="col-lg-7">
                <strong style="display: inline;">Add to User : </strong>
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

                <select class="form-control form-control-sm">
                    <option selected>Select User </option>
                    <?php
                           $sql= "select * from User";
                           if($result = mysqli_query($conn, $sql)){
                               if(mysqli_num_rows($result) > 0){ 
                                   while($row = mysqli_fetch_array($result)){
                                    echo '<option value="'.$row['name'].'" >'.$row['name'].'</option>';
                                   }
                               }
                           }
                    ?>
                </select><br>
                <hr class="style5">
               
                <div class="row">
                    <h1>Orders</h1>
                   <?php
                        $sql= "select * from Products";
                        if($result = mysqli_query($conn, $sql)){
                            if(mysqli_num_rows($result) > 0){ 
                                while($row = mysqli_fetch_array($result)){
                                    echo '<div class="col-lg-3">';
                                    echo '<img alt="'.$row['price'].'" name="'.$row['name'].'" class="imgSize" id="'.$row['id'].'" src="'.$row['img_path'].'" /><br>';
                                    echo  '<strong class="productName">'.$row['name'].'</strong><br>';
                                    echo '<strong> price:</strong><strong class="price">'.$row['price'].'</strong><strong> EGP</strong>';
                                    echo ' </div>';
                                }
                            }
                        }
                   ?>
            </div>
            </div>
        </div>
    </div>
    <script src="userPage.js"></script>
</body>
</html>