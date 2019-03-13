<?php

include('init.php');

if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>

<h1> All Products </h1>
<p align="right">
	<a href="add_product.php">
		<button class="addProductbutton">Add Product</button>
	</a>
</p>

<?php
require_once('model/products.php');
$product=new Product();
$pros=$product->getAllProducts();
echo '<table border=1 class="t01">';
echo "<tr>
    <td>Product</td>
    <td>Price</td>
    <td>image</td>
    <td>Action</td>
    </tr>";

while($row= $pros->fetch(PDO::FETCH_ASSOC))
{
		echo "<tr>";
		echo '<td>'.$row['name'].'</td>';
		echo '<td>'.$row['price'].'</td>';
		echo ' <td><img src="'.$row['img_path'].'" width="100" height="100"/> </td> ';
    echo "<td>".$row['status'];
    echo '<a href="editProduct.php?id='.$row['id'].'"><button>Edit</button></a>';
    echo '<a href="deleteProduct.php?id='.$row['id'].'"><button>Delete</button></a>';
    echo '</td></tr>';
}
 echo "</table>";

?>
</body>
</html>
