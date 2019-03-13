<?php
session_start();
$noHeader = '';
if(isset($_SESSION['User']))
{
    include 'init.php';
}
