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
    <title>Add Users</title>
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
  </head>
  <body>

 <div class="container ">
    <h1 class="">Add Product</h1>
    <form class="p-5" method="POST" action="add_new_product.php" enctype="multipart/form-data">

      <div class="form-group row">
          <div class="col-lg-2">
            <label for="example-text-input" class="col-sm-2 col-form-label">
                Product
            </label>
          </div>
        <div class="col-lg-10">
          <input name="product_name" class="form-control" type="text" id="example-text-input">
        </div>
      </div>

      <div class="form-group row">
        <div class="col-lg-2">
            <label for="example-number-input" class="col-sm-2 col-form-label">
                Price
            </label>
        </div>
        <div class="col-lg-10">
            <input name="price" class="form-control" type="number" min="1" value="" id="example-number-input">
        </div>
      </div>

      <div class="form-group row">
        <div class="col-lg-2">
          <label for="col-sm-2 col-form-label" class="col-2 col-form-label">Category</label>
        </div>

        <div class="col-lg-10">
          <select name="category" class="form-control ">
            <?php
              $stmt = $con->prepare("SELECT * FROM Category");
              $stmt->execute();
              while ($row = $stmt->fetch()) {
                echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
              }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="example-number-input" class="col-lg-2 col-form-label">
            Product image
        </label>

          <div class="col-lg-10">

<!--              <div class="input-group-prepend col-lg-1 ">-->
<!--                  <span class="input-group-text border-danger bg-danger text-white" id="inputGroupFile01">-->
<!--                      Upload-->
<!--                  </span>-->
<!--              </div>-->

              <div class="custom-file col-lg-10">
                  <input name="fileToUpload" type="file" class=""
                         id="inputGroupFile01" aria-describedby="inputGroupFile01">
                  <label class=" " for="inputGroupFile01">
                      Choose file
                  </label>
              </div>
          </div>

      </div>

      <div class="form-group row .text-center d-flex justify-content-center mb-3">
           <button type="submit" class="btn btn-danger m-2 col-lg-offset-4">
               Submit
           </button>
           <button type="reset" class="btn btn-danger m-2">
               Reset
           </button>
      </div>

    </form>
  </div>




    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>