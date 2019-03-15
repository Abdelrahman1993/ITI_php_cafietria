<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>


<head>
    <title>Cafateria</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<?php
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 3;
$offset = ($pageno-1) * $no_of_records_per_page;

include "dbConnection.php";
if($tableName=="Products"){
    $stmt_1 = $con->prepare("SELECT COUNT(*) FROM $tableName");
    $stmt_1->execute();
    $total_rows = $stmt_1->fetch()[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    
    $stmt_2 = $con->prepare("SELECT * FROM $tableName LIMIT :from_1, :to_1");
    $stmt_2->bindParam(':from_1',$offset , \PDO::PARAM_INT);
    $stmt_2->bindParam(':to_1',$no_of_records_per_page , \PDO::PARAM_INT);
    $stmt_2->execute();
    while($row = $stmt_2->fetch()){
        echo '<div class="col-lg-3">';
        echo '<img alt="'.$row['price'].'" name="'.$row['name'].'" class="imgSize" id="'.$row['id'].'" src="'.$row['img_path'].'" /><br>';
        echo  '<strong class="productName">'.$row['name'].'</strong><br>';
        echo '<strong> price:</strong><strong class="price">'.$row['price'].'</strong><strong> EGP</strong>';
        echo ' </div>';
    }
}else if($tableName=="ProductsPage"){
    $stmt_1 = $con->prepare("SELECT COUNT(*) FROM Products");
    $stmt_1->execute();
    $total_rows = $stmt_1->fetch()[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    
    $stmt_2 = $con->prepare("SELECT * FROM Products LIMIT :from_1, :to_1");
    $stmt_2->bindParam(':from_1',$offset , \PDO::PARAM_INT);
    $stmt_2->bindParam(':to_1',$no_of_records_per_page , \PDO::PARAM_INT);
    $stmt_2->execute();

      while($row= $stmt_2->fetch())
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

}elseif ($tableName=="User") {
$stmt_1 = $con->prepare("SELECT COUNT(*) FROM User");
$stmt_1->execute();
$total_rows = $stmt_1->fetch()[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$stmt_2 = $con->prepare("SELECT User.id, name, img_path, User.room_id, ext FROM User, 
Room where User.room_id=Room.room_id LIMIT :from_1, :to_1");
$stmt_2->bindParam(':from_1',$offset , \PDO::PARAM_INT);
$stmt_2->bindParam(':to_1',$no_of_records_per_page , \PDO::PARAM_INT);
$stmt_2->execute();
//////
while($row= $stmt_2->fetch())
{
?>
        <tr>
        <th><?=$row['name']?></th>
        <td>
        <img src="<?= $row['img_path']?>" width="100" height="100">
        </td>
        <td><?=$row['room_id']?></td>
        <td><?=$row['ext']?></td>
        <td>
        <a href="editUser.php?id='<?=$row['id']?>'"><button>Edit</button></a>
        <a href="deleteUser.php?id='<?=$row['id']?>'"><button>Delete</button></a>
        </td>
        </tr>
<?php
}
}else if($tableName=="Orders"){
    $stmt_1 = $con->prepare("SELECT COUNT(*) FROM Orders");
    $stmt_1->execute();
    $total_rows = $stmt_1->fetch()[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    
    $stmt_2 = $con->prepare("SELECT * FROM Orders LIMIT :from_1, :to_1");
    $stmt_2->bindParam(':from_1',$offset , \PDO::PARAM_INT);
    $stmt_2->bindParam(':to_1',$no_of_records_per_page , \PDO::PARAM_INT);
    $stmt_2->execute();



    // $stmt = $con->prepare("SELECT * FROM Orders");
    // $stmt->execute();
    while ($row = $stmt_2->fetch()) {
 ?>
     <div class="border-danger" style="border: 2px solid black">
       <table class="table">
         <thead class="thead-dark">
          <tr>
            <th scope="col"><h4 class="font-weight-bold m-1">Order Date</h4></th>
            <th scope="col"><h4 class="font-weight-bold m-1">Name</h4></th>
            <th scope="col"><h4 class="font-weight-bold m-1">Room</h4></th>
            <th scope="col"><h4 class="font-weight-bold m-1">Ext.</h4></th>
            <th scope="col"><h4 class="font-weight-bold m-1">Note</h4></th>
            <th scope="col"><h4 class="font-weight-bold m-1">Action</h4></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <h4 class="font-weight-bold m-1">
                <?php echo $row['order_date'] ?>
              </h4>
            </td>
            <td>
              <h4 class="font-weight-bold m-1">
                <?php echo $row['user_id'] ?>
              </h4>
            </td>
            <td>
              <h4 class="font-weight-bold m-1">
                <?php echo $row['room_id'] ?>
              </h4>
            </td>
            <td>
              <h4 class="font-weight-bold m-1">
                <?php
                  $stmt1 = $con->prepare("SELECT * FROM Room where room_id = ?");
                  $stmt1->execute(array($row['room_id']));
                  while ($row1 = $stmt1->fetch()) {
                    echo $row1['ext'];
                  }
                ?>
              </h4>
            </td>
            <td>
              <h4 class="font-weight-bold m-1">
<!--                    --><?php //echo $row['note'] ?>
              </h4>
            </td>
            <td>
              <button type="submit" class="btn btn-danger font-weight-bold">
                <h5 class="font-weight-bold">
                  delever
                </h5>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
      <?php
      $stmt2 = $con->prepare("SELECT * FROM orders_products where order_id = ?");
      $stmt2->execute(array($row['id']));
      while ($row2 = $stmt2->fetch()) {

        $stmt3 = $con->prepare("select * from Products where id = ?");
        $stmt3->execute(array($row2['product_id']));

          while ($row3 = $stmt3->fetch()) {
              ?>
          <div style="display: inline-block" class="card m-3" style="width: 18rem;">
          <img class="card-img-top" width="25%" height="150px" src="<?=$row3['img_path']?>" alt="Card image cap">
              <div class="card-body">
                  <h5 class="card-title"><?=$row3['name']?></h5>
                  <p class="card-text"><?=$row2['count']?></p>
              </div>
          </div>
          <?php
          }
      }
      ?>
      <h6 style="font-size: 20px;">Total:-  <?=$row['cost'] ?></h6>
      </div>
    </div>
 <?php
  }
}

?>

<ul class="pagination">
<li><a href="?pageno=1">First</a></li>
<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
</li>
<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
</li>
<li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
</ul>