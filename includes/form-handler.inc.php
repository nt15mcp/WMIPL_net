<?php
session_start();
if (isset($_POST['text-submit'])) {
	
	require 'dbh.inc.php';
	
	$page = $_SESSION['page'];
	$user = $_SESSION['userID'];
	$content = $_POST['content'];
	
	$sql = "INSERT INTO pages (page, content, executive_id, created_at) VALUES (?, ?, ?, Now())";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		unset($_SESSION['page']);
		exit();
	}
	else {
		mysqli_stmt_bind_param($stmt, "ssi", $page, $content, $user);
		mysqli_stmt_execute($stmt);
		echo mysqli_error($conn);
		header("Location: ../".$_SESSION['page'].".php?edit=succuss");
		unset($_SESSION['page']);
		exit();
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../index.php");
	exit();
}