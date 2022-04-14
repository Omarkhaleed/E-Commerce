<?php
  
include "connect.php";
// Routes
$tpl='includes/templats/';
$lang='includes/languages/';
$func='includes/functions/';
$js= 'front/js/';
//include the important files
include $func.'function.php';
include $lang."english.php";
include $lang."arabic.php";
include $tpl."header.php";

//include navbar in all pages except the page with $noNavbar variabler
if(!isset($noNavbar)){
include $tpl."navbar.php";
}
?>