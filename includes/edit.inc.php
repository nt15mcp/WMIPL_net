<?php
session_start();
if(isset($_POST['edit-profile'])){
	require "dbh.inc.php";
	$sql = "SELECT * FROM User WHERE LoginID=".$_SESSION['userID'];
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		exit();
	}else{
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
			if ($row = mysqli_fetch_assoc($result)) {
				$_SESSION['firstname'] = $row['Firstname'];
				$_SESSION['middlename'] = $row['Middlename'];
				$_SESSION['lastname'] = $row['Lastname'];
				$_SESSION['phonepri'] = $row['Phone_Pri'];
				$_SESSION['phonesec'] = $row['Phone_Sec'];
				$_SESSION['street'] = $row['Street'];
				$_SESSION['street2'] = $row['Street2'];
				$_SESSION['city'] = $row['City'];
				$_SESSION['state'] = $row['State'];
				$_SESSION['zip'] = $row['Zip'];
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
