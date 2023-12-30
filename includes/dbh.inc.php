<?php

$ini = parse_ini_file('/home/u437830502/domains/wmipl.net/Configs/app.ini');
// $ini = parse_ini_file('C:\xampp\htdocs\wmipl_net\app.ini');
$servername = $ini['db_server'];
$dbusername = $ini['db_user'];
$dbpassword = $ini['db_pword'];
$database = $ini['db_name'];

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $database);

if(!$conn){
	die("Connection failed: ".mysqli_connect_error());
	}