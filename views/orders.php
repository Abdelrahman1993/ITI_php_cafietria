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
      require './connect.php';
      $sql = "select * from Orders";
      if ($result = mysqli_query($con, $sql)) {
        $rows_count = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
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
                    $sql = "select * from Room where id = ".$row['room_id'];
                    if ($result = mysqli_query($con, $sql)) {
                      while ($row1 = mysqli_fetch_assoc($result)) {
                        echo $row1['ext'];
                      }
                        /* free result set */
                        $result->free();
                    }
                    else {
                      echo mysqli_error($con);
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
          $sql = "select * from orders_products where order_id = ".$row['id'];
          if ($result = mysqli_query($con, $sql)) {
            while ($row1 = mysqli_fetch_assoc($result)) {
              $sql1 = "select * from Products where id = ".$row1['product_id'];
              if ($result1 = mysqli_query($con, $sql1)) {
                while ($row2 = mysqli_fetch_assoc($result1)) {
                  echo '<div style="display: inline-block" class="card m-3" style="width: 18rem;">';
                    echo '<img class="card-img-top" width="25%" height="150px" src="images/4.png" alt="Card image cap">';
                    echo '<div class="card-body">';
                      echo '<h5 class="card-title">'.$row2['name'].'</h5>';
                      echo '<p class="card-text">9</p>';
                    echo '</div>';
                  echo '</div>';
                }
                $result->free();
              }
              else {
                echo mysqli_error($con);
              }
            }
            $result->free();
          }
          else {
            echo mysqli_error($con);
          }
          ?>
          </div>
        </div>
     <?php
        }
        /* free result set */
        $result->free();
      }
      else{
        echo mysqli_error($con);
      }
      mysqli_close($con);
     ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>