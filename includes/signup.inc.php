<?php
if(isset($_POST['signup-submit'])) {
	
	require 'dbh.inc.php';
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['pass1'];
	$checkPW = $_POST['pass2'];
	
	if(empty($username) || empty($email) || empty($password) || empty($checkPW)) {
		header("Location: ../signup.php?error=emptyfields&username=".$username."&email=".$email);
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
		header("Location: ../signup.php?error=invalidemailusername");
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header("Location: ../signup.php?error=invalidemail&username=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
		header("Location: ../signup.php?error=invalidusername&email=".$email);
		exit();
	}
	else if($password !== $checkPW) {
		header("Location: ../signup.php?error=passwordcheck&username=".$username."&email".$email);
		exit();
	}
	else {
		$sql = "SELECT UserName FROM Login WHERE UserName=? OR Email=?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../signup.php?error=sqlierror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "ss", $username, $email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if ($resultCheck > 0) {
				header("Location: ../signup.php?error=taken&email=".$email);
				exit();
			}
			else {
				$sql = "INSERT INTO Login (UserName, Email, Password) VALUES (?,?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else {
					$hashedPWD = password_hash($password, PASSWORD_BCRYPT);
					mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPWD);
					mysqli_stmt_execute($stmt);
				}
				header("Location: ../signup.php?signup=success");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../signup.php");
	exit();
}