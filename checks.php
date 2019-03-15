<?php
include('init.php');

if(!isset($_SESSION['User']))
  {
    header('Location:index.php');
  }

try
{

  if($_SERVER['REQUEST_METHOD']=='POST')
  {

    extract($_POST);
    if(! isset($dateFrom) ) {
      $dateFrom = '2019-03-01';

    }
    if(! isset($dateTo)) {
      $dateTo =  date("Y-m-d");
    }
    $query = "SELECT User.id As userID,name,SUM(cost) AS totalCost FROM Orders,User WHERE (Orders.user_id=User.id AND order_status='done' AND User.id=$userID)  GROUP BY user_id";
    $date=" AND order_date BETWEEN '$dateFrom' AND '$dateTo' ";

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
  // print_r ($users);
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
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<title>Multi-Level Accordion Menu | CodyHouse</title>

	<style>
		body
		{
			display: block;
			padding-right: 404px;
			background-color: #2B9597;
		}
		#name-total-amount
		{
			background-color: #53555E;
			color: #FFF;
			width:1000px;

			height: 50px;
			line-height: 50px;
			font-size: 25px;
			margin-bottom: -62px;
			font-weight: bold;
			margin-left: 236px;
		}
		#name
		{
			margin-left: 30px;
		}
		#total-amount
		{
			margin-left: 600px;
		}
		.c-amount
		{
			margin-left: 470px;
		}
		#order-date-amount
		{
			height: 50px;
			font-weight: bold;
			background-color: #53555E;
			font-size: 20px;
			line-height: 50px;

		}
		#order-date
		{
			margin-left: 40px;
		}
		#order-amount
		{
			margin-left: 625px;

		}
		.product-img
		{
			width: 100px;
			height: 100px;
		}
		.product-amount{
			float: right;
			margin-right: 7%;
			margin-top: 8%;
		}
		label
		{
			width: 1000px;
		}
		li
		{
			width: 1000px;
		}
		label
		{

		}
		.title-name{
			padding-left: 40%;
		}
		.date-from, .date-to
		{
			display: inline-block;
		}
		.order-date, .select-user
		{
			margin-left: 480px;
			height: 50px;
			color: white;
			background-color: #54555F;
			line-height: 50px;
			font-size: 20px;
			width: 550px;
			margin-bottom: 30px;
			border-radius: 10px;
		}
		.myheader
		{
			color: white;
			background-color: #54555F;
			height: 50px;
			line-height: 50px;
			width: 200px;
			margin-top: 30px;
			border-radius: 20px;
			margin-bottom: 30px;
			margin-left: 640px;

		}
		.c-name
		{
			display: inline-block !important;
			width:200px;
		}
		.products
		{
			background-color: #355;
   			width: 1000px;
    		min-height: 300px;
		}
		.product
		{
			display: inline-block;
			width:25%;
			height:200px;
			margin:20px;
		}
		.productPrice
		{
			font-size: 20px;
      position: relative;
      top: 26%;
      left: 30%
		}
		.productImg
		{
			margin-left: 78px;
      margin-top: 25px;
      width: 100px;
      height: 100px;
		}
		.productAmount
		{
			font-size: 20px;
      position: relative;
      top: 40%;
      left: 0%;
		}
		.productName
		{
			font-size: 22px;
      position: relative;
      top: 12%;
      left: 48%;
		}
		#select-user
		{
			width: 40%;
    	height: 30px;
		}

	</style>

</head>

<body>

	<h1 class="myheader">checks</h1>



	<form action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">


	<div class="order-date">
		<div class="date-from">
			<label for="dfrom">Date From: </label>
			<input type="date" id="dfrom" name="dateFrom" value="2019-3-7">
		</div>
		<div class="date-to">
			<label for="dto">Date To: </label>
			<input type="date" id="dto" name="dateTo" value="2019-3-20">
		</div>
	</div>

	<div class="select-user">
		<label>Select user:</label>
		<select id="select-user" name="userID" onchange="this.form.submit()">

			<option value="" >-----</option>

			<?php

				while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
					?>

					<option value="<?php echo $user['userID'] ?>" > <?php echo $user['name'] ?> </option>

				<?php
				}
			?>

		</select>

	</div>

	<div id="name-total-amount">
		<span id="name"> Name </span>
		<span id="total-amount"> Total amount </span>
	</div>


	</form>



	<ul class="cd-accordion-menu animated">
		<!-- start of name , total amount li group -->
		<?php $i=0; $j=0;?>
		<?php while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { $i++;

			?>



		<li class="has-children">
			<input type="checkbox" name="<?php echo 'group-'.$i; ?>" id="<?php echo 'group-'.$i; ?>">
			<label for="<?php echo 'group-'.$i; ?>">
				<span class="c-name"><?php echo $row['name']; ?></span>
				<span class="c-amount"><?php echo $row['totalCost']; ?></span>
			</label>
			<ul>
					<div id="order-date-amount">
							<span id="order-date">Order Date</span>
							<span id="order-amount">Amount</span>
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
						<span class="c-name"> <?php echo $order['order_date']; ?> </span>
						<span class="c-amount"> <?php echo $order['cost']; ?> </span>
					</label>

					<ul>
						<!-- star of listing products -->
						<div class="products">

						<?php
						$currentOrder=$order['id'];
						$products = $con->prepare("SELECT count, Products.id, img_path, price, name FROM orders_products, Products WHERE (product_id=Products.id AND order_id=$currentOrder)");
						$products->execute();
						while ($product = $products->fetch(PDO::FETCH_ASSOC))
						{?>

							<div class="product">
								<img src="<?php echo $product['img_path'] ?>" class="productImg">
                </br>
								<span class="productName"><?php echo $product['name'] ?> </span>
								<span class="productPrice"> Price : <?php echo $product['price'] ?> </span>
								<span class="productAmount"> Amount : <?php echo $product['count'] ?> </span>

							</div>
						<?php }
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