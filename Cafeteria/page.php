<?php
 
$action = '';

if(isset($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    $action = 'Home';
}


if ($action == 'Home')
{
    echo "you are in home page";
    echo '<a href="page.php?action=AddUsers">Add new user +</a>';
}
elseif ($action =='Products')
{
    echo "you are in products page";
}
elseif ($action == 'Add')
{
    echo "you are in add user page";
}
else{ echo " err there is no page with this name";}


?>