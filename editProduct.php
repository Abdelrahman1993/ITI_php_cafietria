<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Product</title>
  <link rel="stylesheet" type="text/css" href="css/products.css">
</head>
<body>
<form action="edit_current_product.php" method="post" enctype="multipart/form-data">

<center>
  <h1> Edit Product </h1>
<table>
  <?php
    $stmt = $con->prepare("SELECT * FROM Products where id=".$_GET['id']);
    $stmt->execute();
    while($row= $stmt->fetch()) {
      ?>
      <tr>
        <td><label>Product name</label></td>
        <td>
          <input type="text" name="product_name" required value="<?= $row['name']; ?>"/>
          <input type="hidden" name="product_id" required value="<?= $row['id']; ?>"/>
        </td>

      </tr>
      <tr>
        <td><label>Price</label></td>
        <td><input type="number" name="product_price" min="5" required
                   value="<?= $row['price']; ?>"/>EGP
        </td>
      </tr>
      <tr>
        <td><label>Category</label></td>
        <td>
          <select name="category" required>
            <?php
              $stmt1 = $con->prepare("SELECT * FROM Category");
              $stmt1->execute();
              while($row1= $stmt1->fetch())
              {
              ?>
                <option class="category" value="<?= $row1['id']; ?>"><?= $row1['name'] ?></option>';
            <?php
              }
            ?>
          </select>
        </td>

      </tr>
      <tr>
        <td><label>Status</label></td>

        <td><input type="text" name="product_quantity" min="0" required
                   value="<?=  $row['status'] ?>"/></td>
      </tr>
      <tr>
        <td><label>Product Picture</label></td>
        <td><input type="file" name="fileToUpload" accept='image/jpeg,image/jpg,image/png'></td>


        <td colspan="2"><img src="<?=  $row['img_path'] ?>" width="100" height="100"/></td>
      </tr>

      <tr>
        <td><input type="submit" name="btn_Save" value="Edit"></td>
        <td><input type="reset" name="btn_rest" value="Reset"></td>
      </tr>
      <?php
    }
  ?>
 <tr>
 	<td colspan="2"><label name="lblerror" style="color: red"> <?php

       if(!empty($_GET['errormsg']))
       {
       	$error= $_GET['errormsg'];
         echo $error;
       }
 	?> </label></td>
 </tr>
</table>
</center>
</form>
</body>
</html>
