<?php

  if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

?>

<?php
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 3;
$offset = ($pageno-1) * $no_of_records_per_page;

  //include "dbConnection.php";
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

      echo '<div class="col-sm-6  col-md-3">';
		 	echo '<div class="thumbnail item-box">';
		 	echo '<span class="price-tag">'.'price '.$row['price'].'</span>';
		 	echo  '<img class="img-responsive imgSize" name="'.$row['name'].'"
                id="'.$row['id'].'" src="'.$row['img_path'].'" alt="'.$row['price'].'"/><br>';
		 	echo '<div  class="caption">';

		 	echo '<p class="productName">'.$row['name'].'</p>';
		 	echo '</div>';
		 	echo '</div>';
		  echo '</div>';

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
    while ($row = $stmt_2->fetch()) {
 ?>
     <div class="table-responsive " >
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
                <?php
                  $stmt15 = $con->prepare("SELECT name FROM User where id = ?");
                  $stmt15->execute(array($row['user_id']));
                  while ($row15 = $stmt15->fetch()) {
                    echo $row15['name'];
                  }
//                  echo $row['user_id']
                ?>
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
              <?php
              if($row['order_status'] != "done") {
                ?>
                <button onclick = "update_order(event, <?= $row['id']; ?>)" class="btn btn-danger font-weight-bold" >
                <h5 class="font-weight-bold" >
                    deliver
                </h5 >
              </button >
              <?php
              } else {
                ?>

                <button class="btn btn-danger font-weight-bold" >
                <h5 class="font-weight-bold" >
                    done
                </h5 >
                </button >
              <?php
              }
              ?>
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
          <div style="display: inline-block ; background-color: #5bc0de ; border: #3c3f45 ; border-style: solid;    border-color: #ff0d74;  "  >
          <img class="card-img-top" width="100px" height="100px" src="<?=$row3['img_path']?>" alt="Card image cap">
              <div class="card-body">
                  <h5 class="card-title" style="background-color: #ff0d74 ">Name : <?=$row3['name']?></h5>
                  <h5 class="card-title" style="background-color: #4cae4c">Count :<?=$row2['count']?></h5>
              </div>
          </div>
          <?php
          }
      }
      ?>
      <h6 style="font-size: 20px;">Total:  <?=$row['cost'] ?></h6>
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

<script>
 let update_order = (event, id) => {
   console.log(event.target);
   event.target.children[0].innerHTML = "out for delivery";
   setTimeout(()=>{
    event.target.children[0].innerHTML = "done";
     let xmlhttp = new XMLHttpRequest();
     xmlhttp.open("GET", "update_order.php?q=" + id, true);
     xmlhttp.send();
   }, 60000);
  // console.log(id);
 }

</script>