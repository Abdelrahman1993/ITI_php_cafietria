<?php
  session_start();
?>

<div class="container-fluid" >
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="adminPage.php">Cafateria</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="adminPage.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="users.php">Users</a></li>
                        <li><a href="adminPage.php">Manual Order</a></li>
                        <li><a href="orders.php">Orders</a></li>
                        <li><a href="checks.php">Checks</a></li>
                    </ul>

                    <div style="margin-left: 1000px; width:300px;">
                        <img src="Layout/images/4.png" width="50px" height="50px" />
                        <a><?php echo $_SESSION['User']['name'] ?></a> |
                        <a href="logout.php">logout</a>
                    </div>


                </nav>
            </div>

        </div>