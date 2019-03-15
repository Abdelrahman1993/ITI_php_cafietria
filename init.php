<?php
include 'dbConnection.php';

$tpl = 'includes/template/' ; // template directory
$css = 'Layout/css/'; // css directory
$js  = 'Layout/js/'; // js directory


//include nav in all pages except the pages that not contains noHeader variable

include $tpl . 'header.php';
if(!isset($noHeader)) { include $tpl . 'navbar.php';}
