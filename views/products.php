<!DOCTYPE html>
<html>
<head>
	<title> All Products</title>
	<link rel="stylesheet" type="text/css" href="css/products.css">
</head>
<body>
	<div class="tab">
		<a href="Go to home page.php "><h2>Home</h2></a>
		<a href="products.php"><h2>Products</h2></a>
		<a href="users.php"><h2>Users</h2></a>
		<a href="go to orders.php"><h2>Manual Order</h2></a>
		<a href="go to checks.php"><h2>Checks</h2></a>
	<a href="go to admin.php">
		<img id="userImg" src="images/admin.png" width="40" height="40" />
		<h2>Admin</h2>
	</a>

	</div>

<h1> All Products </h1>
<p align="right">
	<a href="addProduct.php" >
		<button class="addProductbutton">Add Product</button>
	</a>
</p>

<?php
require_once('models/products.php');
$product=new Product();
$pros=$product->getAllProducts();
echo '<table border=1 class="t01">';
echo "<tr>
    <td>Product</td>
    <td>Price</td>
    <td>image</td>
    <td>Action</td>
    </tr>";

$rowid;
$is_available;

while($row= $pros->fetch(PDO::FETCH_ASSOC))
{

	if($row['quantity']!=-1)
	{
		echo "<tr>";
		foreach ($row as $key => $value)
		{
		    if($key=="id")
				$rowid=$value;
	                        
	        else if($key=="quantity")
	        {
	          if($value >0)
	            $is_available="available";
	          else
	            $is_available="unavailable";
	        }
	        else if($key=="imagepath")
	            echo ' <td> <img src="'.$value.'" width="100" height="100"/> </td> ';

	        else
	          echo "<td>$value</td>";
		}
        echo "<td>".$is_available."
	          <a href= editProduct.php?id=$rowid><button>Edit</button></a>
	          <a href= deleteProduct.php?id=$rowid><button>Delete</button></a>
          	 </td></tr>";
	}

}
 echo "</table>";

?>
</body>
</html>
