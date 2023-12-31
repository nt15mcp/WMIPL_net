<?php
/**
 * User Signup Handling
 *
 * This script handles user signup requests submitted via a form. It performs input validation,
 * checks for duplicate usernames or emails in the database, hashes passwords securely,
 * and inserts the new user into the database if all checks pass. It uses a common database
 * login file (dbh.inc.php) for database connection.
 *
 * Note: This script redirects users to the signup page with appropriate error messages if
 * any issues are encountered during the signup process.
 *
 */

if(isset($_POST['signup-submit'])) {
	
	require 'dbh.inc.php'; // Use common database login file
	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['pass1'];
	$checkPW = $_POST['pass2'];
	
	if(empty($username) || empty($email) || empty($password) || empty($checkPW)) {
		// Redirect with error message if any fields are empty
		header("Location: ../signup.php?error=emptyfields&username=".$username."&email=".$email);
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
		// Redirect with error message if email and username are both invalid
		header("Location: ../signup.php?error=invalidemailusername");
		exit();
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// Redirect with error message if email is invalid
		header("Location: ../signup.php?error=invalidemail&username=".$username);
		exit();
	}
	else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
		// Redirect with error message if username is invalid
		header("Location: ../signup.php?error=invalidusername&email=".$email);
		exit();
	}
	else if($password !== $checkPW) {
		// Redirect with error message if passwords do not match
		header("Location: ../signup.php?error=passwordcheck&username=".$username."&email".$email);
		exit();
	}
	else {
		$sql = "SELECT username FROM logins WHERE username=? OR email=?";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			// Redirect with error message if there is an issue with the SQL query
			header("Location: ../signup.php?error=sqlierror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt, "ss", $username, $email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if ($resultCheck > 0) {
				// Redirect with error message if username or email is already taken
				header("Location: ../signup.php?error=taken&email=".$email);
				exit();
			}
			else {
				$sql = "INSERT INTO logins (username, email, password) VALUES (?,?, ?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt, $sql)){
					// Redirect with error message if there is an issue with the SQL query
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else {
					$hashedPWD = password_hash($password, PASSWORD_BCRYPT);
					mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPWD);
					mysqli_stmt_execute($stmt);
				}
				// Redirect to signup success page
				header("Location: ../signup.php?signup=success");
				exit();
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	// Redirect to the signup page if the form is not submitted
	header("Location: ../signup.php");
	exit();
}
?>