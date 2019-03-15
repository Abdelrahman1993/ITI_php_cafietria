<?php

    include('init.php');
    if(!isset($_SESSION['User']))
      {
        header('Location:index.php');
      }
    ?>
    <div class="container" >
        <h1> All Products </h1>
            <a href="add_product.php">
                <button class="addProductbutton">Add Product</button>
            </a>
        <table class="table table-dark" style="border: 2px solid black">
            <thead class="head-dark">
                <tr>
                    <th scope="col"> <h4 class="col">Products</h4></th>
                    <th scope="col"><h4 class="">Price</h4></th>
                    <th scope="col"><h4 class="">image</h4></th>
                    <th scope="col"><h4 class="">Action</h4></th>
                </tr>
            </thead>
            <tbody>
<?php
  $stmt = $con->prepare("SELECT * FROM Products");
  $stmt->execute();
    while($row= $stmt->fetch())
    {
?>
        <tr>
            <th scope="row"><?= $row['name'] ?></th>
            <td><?= $row['price'] ?></td>
            <td>
                <img src="<?= $row['img_path']?>" width="100" height="100">
            </td>
            <td><?= $row['status']?>
                <a href="editProduct.php?id='<?=$row['id']?>'"><button>Edit</button></a>
                <a href="deleteProduct.php?id='<?=$row['id']?>'"><button>Delete</button></a>
            </td>
        </tr>
<?php

    }
?>
            </tbody>
        </table>
    </div>
</body>
</html>
