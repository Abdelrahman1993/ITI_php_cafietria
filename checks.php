<?php
include('init.php');
if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }
try
{
	$start = '2019-03-01';
	$end =  date("Y-m-d");
  if($_SERVER['REQUEST_METHOD']=='POST')
  {
		extract($_POST);
		if(isset($startDate) && !empty($startDate)){
			$start = $startDate;
		}
		if(isset($startDate) && !empty($startDate)){
			$end = $endDate;
		}

    $query = "SELECT User.id As userID,name,SUM(cost) AS totalCost FROM Orders,User WHERE (Orders.user_id=User.id AND order_status='done' AND User.id=$userID)  GROUP BY user_id";
    $date=" AND order_date BETWEEN '$start' AND '$end' ";
  }
  else
  {
    $query = "SELECT User.id As userID,name,SUM(cost) AS totalCost FROM Orders,User WHERE (Orders.user_id=User.id AND order_status='done')  GROUP BY user_id";
  }
  $statement = $con->prepare($query);
  $statement->execute();
  $queryusers="SELECT DISTINCT name, User.id As userID from User, Orders WHERE User.id=Orders.user_id";
  $users = $con->prepare($queryusers);
  $users->execute();
  if(! isset($date))
  {
    $date="";
  }
}
catch(PDOException $e)
    {
      echo "Connection failed: " . $e->getMessage();
	}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='https://fonts.googleapis.com/css?family=Jaldi:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<title>Multi-Level Accordion Menu | CodyHouse</title>

	<style>
		.productImg
		{
			margin-left: 78px;
      margin-top: 25px;
      width: 100px;
      height: 100px;
		}
		.colorSize{
		font-size: 22px;
		color: white;
	}
	.product-name, .product-price, .product-count
	{
		font-size: 18px;
    color: white;
    margin: 8px;
    margin-left: -15px
	}
	</style>

</head>
<body>
	<div class="container">
		<h1 class="text-center h2 text-muted" >checks</h1>
	</div>

	<ul class="cd-accordion-menu animated container-fluid">
		<!-- start of name , total amount li group -->
		<form name="orderForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

					 <div class="row">
							 <div class="col-lg-4">
									 <input name="startDate" type="date" class="col-lg-12 btn-lg" value="<?= $start ?>" >
							 </div>
							 <div class="col-lg-4">
									 <input name="endDate" type="date" class="col-lg-12 btn-lg" value="<?= $end ?>" >
							 </div>
							 <div class="col-lg-4">
										 <div class="col-rm-10">
										 <select class="col-lg-12 btn-lg" name="userID" onchange="this.form.submit()">
											 <option selected>select user</option>
											 <?php
											 while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
												 ?>
												 <option value="<?php echo $user['userID'] ?>" > <?php echo $user['name'] ?> </option>
											 <?php
											 }
										 ?>
										 </select>
								 </div>
							 </div>
					 </div>

			 </form>
			 <div class="row">
				<div class="col-md-1"></div>
                <div class="col-lg-7">
                    <h3 class="col-lg-12 btn-lg colorSize"> Name</h3>
								</div>

                <div class="col-lg-4">
									<h3 class="col-lg-12 btn-lg colorSize" style="font-color: white;"> Total amount</h3>
                </div>

				</div>

		<?php $i=0; $j=0;?>
		<?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { $i++;
			?>


		<li class="has-children">
			<input type="checkbox" name="<?php echo 'group-'.$i; ?>" id="<?php echo 'group-'.$i; ?>">
			<label for="<?php echo 'group-'.$i; ?>">
			<div class="row">

				<div class="col-md-8 col_trainings">
					<?php echo $row['name']; ?>
				</div>
				<div class="col-md-4 col_downloads">
						<?php echo $row['totalCost']; ?>
				</div>
			</div>

			</label>
			<ul>
			<div class="row">
				<div class="col-md-1"></div>

				<div class="col-md-7 col_trainings colorSize">
					<h1>Order Date</h1>
				</div>

				<div class="col-md-4 col_downloads colorSize">
					<h1>Amount</h1>
				</div>
			</div>

				<!-- start of order date, amount sub-group -->
				<?php
				$currentUserID=$row['userID'];
				$orders = $con->prepare("SELECT id,order_date, cost from Orders WHERE user_id = $currentUserID $date");
				//SELECT id,order_date, cost from Orders WHERE user_id =1 AND order_date BETWEEN '2019-3-1' AND '2019-3-15'
				$orders->execute();
				while ($order = $orders->fetch(PDO::FETCH_ASSOC))
				{
				  $j++;
				?>
				<li class="has-children">
					<input type="checkbox" name="<?php echo 'sub-group-'.$j; ?>" id="<?php echo 'sub-group-'.$j; ?>">
					<label for="<?php echo 'sub-group-'.$j; ?>">

						<div class="row">
							<div class="col-md-4"><?php echo $order['order_date']; ?></div>
							<div class="col-md-4 col-md-offset-4"><?php echo $order['cost']; ?></div>
						</div>
					</label>

					<ul>
						<!-- star of listing products -->
						<div class="row">

						<?php
						$currentOrder=$order['id'];
						$products = $con->prepare("SELECT count, Products.id, img_path, price, name FROM orders_products, Products WHERE (product_id=Products.id AND order_id=$currentOrder)");
						$products->execute();
						while ($product = $products->fetch(PDO::FETCH_ASSOC))
						{?>
							<div class="col-md-2 prodData">

									<img width="60" height="60" src="<?= $product['img_path'] ?>">
									<div class="product-name">
										<?php echo $product['name']; ?>
</div>
									<div class="product-price">
										Price: <?php echo $product['price']; ?>
</div>
									<div class="product-count">
									Count: <?php echo $product['count']; ?>
									</div>

							</div>

						<?php
						}
						?>

						</div>
						<!-- End of listing products -->
					</ul>
				</li>



				<?php } ?>
				<!-- end of order date, amount sub-group -->

			</ul>
		</li>
		<?php } ?>
		<!-- end of name , total amount li -->


	</ul> <!-- cd-accordion-menu -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>

</html>


