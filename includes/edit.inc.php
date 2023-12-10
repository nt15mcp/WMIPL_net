<?php
session_start();
if(isset($_POST['edit-profile'])){
	require "dbh.inc.php";
	$sql = "SELECT * FROM users WHERE login_id=".$_SESSION['userID'];
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		exit();
	}else{
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)) {
				$_SESSION['firstname'] = $row['firstname'];
				$_SESSION['middlename'] = $row['middlename'];
				$_SESSION['lastname'] = $row['lastname'];
				$_SESSION['phone'] = $row['phone'];
				$_SESSION['street'] = $row['street'];
				$_SESSION['street2'] = $row['street2'];
				$_SESSION['city'] = $row['city'];
				$_SESSION['state'] = $row['state'];
				$_SESSION['zip'] = $row['zip'];
			}
		header("Location: ../edit.php");
		exit();
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	header("Location: ../index.php");
	exit();
}
