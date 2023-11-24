<?php

$servername = "localhost";
//$dbusername = "id2898502_admin";
$dbusername = "adminer";
$dbpassword = "Br00ts!!";
//$dbpassword = "DefaultAdminPasswordWMIPL";
$database = "id2898502_wmipl";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $database);

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
	}