<!DOCTYPE html>
<html>
<head>
	<title> All Products</title>
	<link rel="stylesheet" type="text/css" href="css/pro.css">
</head>
<body>
	<div class="tab">
		<a href="Go to home page.php ">Home</a>
		<a href="go to products page.php">Products</a>
		<a href="go to users page.php">Users</a>
		<a href="go to orders.php">Manual Order</a>
		<a href="go to checks.php">Checks</a>

		<img id="userImg" src="imgs/user.png" width="40" height="40"/>
		<label name="UserName">Admin</label>
	</div>

<h1> All Products </h1>
<p align="right"><a href="Go to add product page" >Add_Product</a> </p>


<?php

              echo '<table border=1 class="productsTable">';
              echo "<tr>
                <td>Product</td>
                <td>Price</td>
                <td>image</td>
                <td>Action</td>
                </tr>";
             
              echo "<tr>
                <td>Product1</td>
                <td>Price1</td>
                <td>image1</td>
                <td>Action</td>
                </tr>";
              echo "<tr>
                <td>Product2</td>
                <td>Price2</td>
                <td>image2</td>
                <td>Action</td>
                </tr>";
              echo "<tr>
                <td>Product3</td>
                <td>Price3</td>
                <td>image3</td>
                <td>Action</td>
                </tr>";

		         echo "</table>";

?>

</body>
</html>
