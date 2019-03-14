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
    <title>Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
   <div class="bg-warning text-black w-75 .h-100 m-5 mb-4 border-danger rounded mx-auto pt-4 bg-warning">
     <h1 class="font-weight-bold d-flex justify-content-center mb-3">Orders</h1>
     <?php
        $stmt = $con->prepare("SELECT * FROM Orders");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
     ?>
         <div class="border-danger" style="border: 2px solid black">
           <table class="table">
             <thead class="thead-dark">
              <tr>
                <th scope="col"> <h4 class="font-weight-bold m-1">#</h4></th>
                <th scope="col"><h4 class="font-weight-bold m-1">Order Date</h4></th>
                <th scope="col"><h4 class="font-weight-bold m-1">Name</h4></th>
                <th scope="col"><h4 class="font-weight-bold m-1">Room</h4></th>
                <th scope="col"><h4 class="font-weight-bold m-1">Ext.</h4></th>
                <th scope="col"><h4 class="font-weight-bold m-1">Action</h4></th>
              </tr>
            </thead>
            <tbody>
              <tr>

                <th scope="row" ><h4 class="font-weight-bold m-1">1</h4></th>
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
                echo '<div style="display: inline-block" class="card m-3" style="width: 18rem;">';
                  echo '<img class="card-img-top" width="25%" height="150px" src="'.$row3['img_path'].'" alt="Card image cap">';
                  echo '<div class="card-body">';
                    echo '<h5 class="card-title">'.$row3['name'].'</h5>';
                    echo '<p class="card-text">'.$row2['count'].'</p>';
                  echo '</div>';
                echo '</div>';
              }
          }
        ?>
          </div>
        </div>
     <?php
      }
     ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>