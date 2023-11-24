<?php
session_start();
if (!isset($_SESSION['page'])){
	$_SESSION['page']='home';
}
$page = $_SESSION['page'];

session_destroy();

session_start();
$_SESSION['page'] = $page;

header("Location: ../".$_SESSION['page'].".php");