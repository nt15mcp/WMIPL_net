<?php

if (isset($_POST["new-password-submit"])) {
	$selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$password = $_POST["password"];
	$pass1 = $_POST["pass1"];
	
	if (empty($password) || empty($pass1)) {
		header("Location: ../signup.php?error=invalidpassword");
		exit();
	}
	else if ($password !== $pass1) {
		header("Location: ../signup.php?error=invalidpassword");
		exit();
	}
	
	$currentDate = date("U");
	
	require 'dbh.inc.php';
	$sql = "SELECT * FROM Pwdreset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../signup.php?error=sqlierror");
		exit();	
	}
	else {
		mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
		mysqli_stmt_execute($stmt);
		
		$result = mysqli_stmt_get_result($stmt);
		if (!$row = mysqli_fetch_assoc($result)) {
			header("Location: ../signup.php?error=sqlierror");
			exit();
		}
		else {
			$tokenBin = hex2bin($validator);
			$tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
			
			if ($tokenCheck === false) {
				header("Location: ../signup.php?error=sqlierror");
				exit();
			}
			else if ($tokenCheck === true) {
				$email = $row["pwdResetEmail"];
				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
				
				$sql = "UPDATE Login SET Password=? WHERE Email=?";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlierror");
					exit();
				}
				else {
					mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
					mysqli_stmt_execute($stmt);
				}
				
				$sql = "DELETE FROM Pwdreset WHERE pwdResetEmail=?";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlierror");
					exit();
				}
				else {
					mysqli_stmt_bind_param($stmt, "s", $email);
					mysqli_stmt_execute($stmt);
					header("Location: ../signup.php?reset=success");
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../index.php");
	exit();
}