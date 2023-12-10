<?php
session_start();
if(isset($_POST['edit-submit'])){
	If(isset($_POST['zip'])){
		If(!is_numeric($_POST['zip']) || strlen($_POST['zip']) != 5){
			header("Location: ../edit.php?error=invalidzip");
			exit();
		}	
	}
	If(isset($_POST['phonesec'])){
		if(strlen(preg_replace("/[^0-9]/","",$_POST['phone'])) < 7) || strlen(preg_replace("/[^0-9]/","",$_POST['phone'])) > 11) || strlen(strlen(preg_replace("/[^0-9]/","",$_POST['phone'])) == 9 ) {
			header("Location: ../edit.php?error=invalidsecphone");
			exit();
		}
		if(strlen(preg_replace("/[^0-9]/","",$_POST['phone'])) == 11)) && (substr(preg_replace("/[^0-9]/","",$_POST['phone']),0,1) != 1) {
			header("Location: ../edit.php?error=invalidsecphone");
			exit();
		}
	}
	
	require "dbh.inc.php";
	$_SESSION['userName'] = $_POST['userName'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['firstname'] = $_POST['firstname'];
	$_SESSION['middlename'] = $_POST['middlename'];
	$_SESSION['lastname'] = $_POST['lastname'];
	$_SESSION['phone'] = if(strlen(preg_replace("/[^0-9]/", "", $_POST['phone'])) > 10){substr(preg_replace("/[^0-9]/", "", $_POST['phone']),1);}else{preg_replace("/[^0-9]/", "", $_POST['phone']);}
	$_SESSION['street'] = $_POST['street'];
	$_SESSION['street2'] = $_POST['street2'];
	$_SESSION['city'] = $_POST['city'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['zip'] = preg_replace("/[^0-9]/", "", $_POST['zip']);
	
	$sql = "UPDATE users SET firstname=?, middlename=?, lastname=?, phone=?, street=?, street2=?, city=?, state=?, zip=? WHERE login_id=".$_SESSION['userID'];
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../edit.php?error=sqlierror");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "sssssssssi", $_SESSION['firstname'], $_SESSION['middlename'], $_SESSION['lastname'], $_SESSION['phone'], $_SESSION['street'], $_SESSION['street2'], $_SESSION['city'], $_SESSION['state'], $_SESSION['zip']);
		mysqli_stmt_execute($stmt);
	}
	$sql = "UPDATE logins SET username=?, email=? WHERE login_id=".$_SESSION['userID'];
	$stmt=mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../edit.php?error=sqlierror");
		exit();
	}else{
	mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userName'], $_SESSION['email']);
	mysqli_stmt_execute($stmt);
	}
	header("Location: ../edit.php");
	exit();

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	header("Location: ../index.php");
	exit();
}
