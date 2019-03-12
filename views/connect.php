<?php
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = '01111451253';
$database   = 'ITI_Cafeteria';

$con=mysqli_connect($server, $username,  $password, $database);
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>