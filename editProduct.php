<?php

  include('init.php');

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

require_once('model/products.php');
require_once('model/category.php');
$category=new Category();
$allCatogries=$category->getCategories();

if(!empty($_GET['id']))
{
    $_SESSION['proid']=$_GET['id'];
    $product=new Product();
    $product->id=$_GET['id'];
    $productWithId=$product->getProduct();
    while($row=$productWithId->fetch(PDO::FETCH_ASSOC))
    {
      foreach ($row as $key => $value)
      {
        if($key=="name")
            $_SESSION['proname']=$value;
        else if($key=="price")
            $_SESSION['proprice']=$value;
        else if($key=="status")
            $_SESSION['proquantity']=$value;
        else if($key=="category_id")
            $_SESSION['procat']=$value;
        else if($key=="img_path")
            $_SESSION['imgpath']=$value;
      }

    }
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
 <tr>
 	<td><label>Product</label></td>
 	<td><input type="text" name="product_name" required  
    value=" <?php if(isset($_SESSION['proname'])){echo $_SESSION['proname'];}?>"/></td>
 </tr>
  <tr>
 	<td><label>Price</label></td>
 	<td><input type="number" name="product_price" min="0"  required  
    value="<?php echo $_SESSION['proprice'];?>" />EGP</td>
 </tr>
 <tr>
 	<td><label>Category</label></td>
 	<td>
 		<select name="category" required>
    <?php
        $cid;
        $catnam;
        while ($row=$allCatogries->fetch(PDO::FETCH_ASSOC))
        {
            foreach ($row as $key => $value)
            {
              if($key=='id')
                  $cid=$value;
              else if($key=='name')
                  $catnam=$value;              
            }
          echo '<option class="category"  name="category" value=" ';
          echo $cid.' " ';
          if(isset($_SESSION['procat']))
          {
            if($cid==$_SESSION['procat'])
              echo 'selected="selected"';
          }
          echo '>'.$catnam.'</option> ';

        }
    ?>
 		</select>
 	</td>

 </tr>
  <tr>
 	<td><label>Status</label></td>
 	<td><input type="text" name="product_quantity" min="0"  required
    value="<?php echo $_SESSION['proquantity'];?>" /></td>
 </tr>
  <tr>
  <td><label>Product Picture</label></td>
  <td><input type="file" name="fileToUpload"  accept='image/jpeg,image/jpg,image/png' ></td>

<td colspan="2"> <img src="<?php echo $_SESSION['imgpath'];?>" width="100" height="100"/> </td>
 </tr>
 
 <tr>
 	<td><input type="submit" name="btn_Save" value="Edit"></td>
 	 <td><input type="reset" name="btn_rest" value="Reset"></td> 
 </tr>
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
