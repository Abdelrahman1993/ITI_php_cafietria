<div class="container-fluid" >
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Cafateria</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="AddUser.php?action=Add">Users</a></li>
                        <li><a href="#">Manual Order</a></li>
                        <li><a href="#">Checks</a></li>
                    </ul>
                    <div style="margin-left: 1000px; width:300px;">
                        <img src="./images/person.png" width="50px" height="50px" />
                        <a  ><?php echo $_SESSION['User'] ?></a>
                        <a href="logout.php">LogOut</a>
                    </div>
                </nav>
            </div>

        </div>