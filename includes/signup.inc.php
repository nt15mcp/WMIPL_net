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
// Start a new session or resume the existing session
session_start();

// See if the post is coming from the right location
if(!isset($_SESSION['page']) && $_SESSION['page'] != 'signup'){
	// Shouldn't be here, send them home
	header('Location: ../index.php');
	exit();
}

// Verify the post is set
if(isset($_POST['signup-submit'])) {
	
	require 'dbh.inc.php'; // Use common database login file
	
	$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
	$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
	$password = filter_input(INPUT_POST,'pass1', FILTER_SANITIZE_SPECIAL_CHARS);
	$checkPW = filter_input(INPUT_POST,'pass2',FILTER_SANITIZE_SPECIAL_CHARS);
	
	if(empty($username) || empty($email) || empty($password) || empty($checkPW)) {
		// Redirect with error message if any fields are empty
		$_SESSION['error'] = 'empty_fields';
		if($username){$_SESSION['username']=$username;}
		if($email){$_SESSION['email']=$email;}
		header("Location: ../signup.php");
		exit();
	} else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)){
		// Redirect with error message if email and username are both invalid
		$_SESSION['error'] = 'invalid_email_username';
		if($username){$_SESSION['username']=$username;}
		if($email){$_SESSION['email']=$email;}
		header("Location: ../signup.php");
		exit();
	} else if($password !== $checkPW) {
		// Redirect with error message if passwords do not match
		$_SESSION['error'] = 'passwords_not_match';
		if($username){$_SESSION['username']=$username;}
		if($email){$_SESSION['email']=$email;}
		header("Location: ../signup.php");
		exit();
	} else {
		$sql = "SELECT COUNT(*) FROM logins WHERE username=:username OR email=:email";
		$stmt = $conn->prepare($sql);
		$stmt -> bindParam(':username', $username, PDO::PARAM_STR);
		$stmt -> bindParam(':email', $email, PDO::PARAM_STR);
		$stmt -> execute();

		if($stmt->fetchColumn() > 0){
			// Redirect with error message if username or email is already taken
			$_SESSION['error'] = 'exists';
			if($username){$_SESSION['username']=$username;}
			if($email){$_SESSION['email']=$email;}
			header("Location: ../signup.php");
			exit();
		} else {
			$sql = "INSERT INTO logins (username, email, password) VALUES (:username,:email,:password)";
			$stmt = $conn->prepare($sql);
			$hashedPWD = password_hash($password, PASSWORD_BCRYPT);
			$stmt -> bindParam(':username', $username, PDO::PARAM_STR);
			$stmt -> bindParam(':email', $email, PDO::PARAM_STR);
			$stmt -> bindParam(':password', $hashedPWD, PDO::PARAM_STR);
			$stmt -> execute();
		
			// Redirect to signup success page
			unset($_SESSION['error']);
			$_SESSION['success'] = 1;
			header("Location: ../signup.php");
			exit();
		}
	}
	$stmt = null;
	$conn = null;
}
else {
	// Redirect to the signup page if the form is not submitted
	header("Location: ../signup.php");
	exit();
}
?>