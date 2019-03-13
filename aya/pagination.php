


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

// $conn=mysqli_connect("localhost","root","","cafeteria");
// if (mysqli_connect_errno()){
//     echo "Failed to connect to MySQL: " . mysqli_connect_error();
//     die();
// }
include "dbConnection.php";

// $total_pages_sql = "SELECT COUNT(*) FROM Products";
// $result = mysqli_query($conn,$total_pages_sql);
// $total_rows = mysqli_fetch_array($result)[0];

$stmt_1 = $con->prepare("SELECT COUNT(*) FROM Products");
$stmt_1->execute();
$total_rows = $stmt_1->fetch()[0];

$total_pages = ceil($total_rows / $no_of_records_per_page);

// $sql = "SELECT * FROM Products LIMIT $offset, $no_of_records_per_page";
// $res_data = mysqli_query($conn,$sql);
// while($row = mysqli_fetch_array($res_data)){
//     echo '<div class="col-lg-3">';
//     echo '<img alt="'.$row['price'].'" name="'.$row['name'].'" class="imgSize" id="'.$row['id'].'" src="'.$row['img_path'].'" /><br>';
//     echo  '<strong class="productName">'.$row['name'].'</strong><br>';
//     echo '<strong> price:</strong><strong class="price">'.$row['price'].'</strong><strong> EGP</strong>';
//     echo ' </div>';
// }

$stmt_2 = $con->prepare("SELECT * FROM Products LIMIT :from_1, :to_1");
$stmt_2->bindParam(':from_1',$offset , \PDO::PARAM_INT);
$stmt_2->bindParam(':to_1',$no_of_records_per_page , \PDO::PARAM_INT);
// $stmt_2->execute(array($offset, $no_of_records_per_page));
$stmt_2->execute();
while($row = $stmt_2->fetch()){
    echo '<div class="col-lg-3">';
    echo '<img alt="'.$row['price'].'" name="'.$row['name'].'" class="imgSize" id="'.$row['id'].'" src="'.$row['img_path'].'" /><br>';
    echo  '<strong class="productName">'.$row['name'].'</strong><br>';
    echo '<strong> price:</strong><strong class="price">'.$row['price'].'</strong><strong> EGP</strong>';
    echo ' </div>';
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
