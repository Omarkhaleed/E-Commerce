<?php


ini_set('display_errors','On');
  error_reporting(E_ALL);
include "admin/connect.php";
// Routes
/*
$tpl='admin/includes/templats/';
$lang='admin/includes/languages/';
$func='admin/includes/functions/';
$func2='includes/functions/';
$js= 'admin/front/js/';
//include the important files
include $func.'function.php';
include $func2.'function.php';
include $lang."english.php";
include $lang."arabic.php";
include $tpl."header.php";

*/
    $sessionUser='';
	if(isset($_SESSION['user'])){
		$sessionUser=$_SESSION['user'];
	}
    $tpl 	= 'includes/templats/'; // Template Directory
	$lang 	= 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'front/css/'; // Css Directory
	$js 	= 'front/js/'; // Js Directory

	// Include The Important Files

	include $func . 'function.php';
	include $lang . 'english.php';
	include $tpl . 'header.php';

//include navbar in all pages except the page with $noNavbar variabler
?>