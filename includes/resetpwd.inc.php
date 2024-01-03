<?php
/**
 * New Password Submission
 *
 * This script handles the submission of a new password for a user who has initiated a password reset.
 * It validates the input, checks the token, updates the user's password in the database,
 * and deletes the password reset entry after a successful password change.
 *
 */
// Start a new session or resume the existing one
session_start();
// Check to see if the submission came from the right place
if(!isset($_SESSION['page']) && $_SESSION['page'] != 'resetPwd'){
	// Shouldn't be here, send them home
	header("Location:../index.php");
	exit();
}

if (isset($_POST["new-password-submit"])) {
	// Retrieve data from the form submission
    $selector = filter_input(INPUT_POST,'selector',FILTER_SANITIZE_SPECIAL_CHARS);
	$validator = filter_input(INPUT_POST,'validator',FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
	$pass1 = filter_input(INPUT_POST,'pass1',FILTER_SANITIZE_SPECIAL_CHARS);
	
	// Validate password fields
    if (empty($password) || empty($pass1)) {
		$_SESSION['error'] = 'invalid_password';
		$_SESSION['selector'] = $selector;
		$_SESSION['validator'] = $validator;
		header("Location: ../pwdreset.php");
		exit();
	} else if ($password !== $pass1) {
		$_SESSION['error'] = 'invalid_password';
		$_SESSION['selector'] = $selector;
		$_SESSION['validator'] = $validator;
		header("Location: ../pwdreset.php");
		exit();
	}
	
	// Get the current date
    $currentDate = date("U");
	
	// Include the database helper
    require 'dbh.inc.php';
	
	// Check if the token is valid and not expired
    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=:selector AND pwdResetExpires>=:expires";
	$stmt = $conn->prepare($sql);
	// Bind parameters, execute the query, and get the results
	$stmt -> bindParam(':selector', $selector, PDO::PARAM_STR);
	$stmt -> bindParam(':expires', $currentDate, PDO::PARAM_STR);
	$stmt -> execute();
	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	// Check if the row exists
	if (!$result) {
		$_SESSION['error'] = 'No valid entry';
		header("Location: ../signup.php");
		exit();
	} else {
		// Verify the password reset token
		$tokenBin = hex2bin($validator);
		if(!password_verify($tokenBin, $result["pwdResetToken"])){
			$_SESSION['error'] = 'No valid entry';
			header("Location: ../signup.php?");
			exit();
		} else {
			$email = $result["pwdResetEmail"];
			$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
			
			// Update the password for the user
			$sql = "UPDATE logins SET password=:password WHERE email=:email";
			$stmt = $conn->prepare($sql);
			$stmt -> bindParam(':password', $hashedPassword, PDO::PARAM_STR);
			$stmt -> bindParam(':email', $email, PDO::PARAM_STR);
			$stmt -> execute();
			
			// Delete the password reset entry
			$sql = "DELETE FROM pwdreset WHERE pwdResetEmail=:email";
			$stmt = $conn->prepare($sql);
			$stmt -> bindParam(':email', $email, PDO::PARAM_STR);
			$stmt -> execute();
			$_SESSION['reset'] = 1;
			header("Location: ../signup.php");
			exit();
		}
	}

	// Close database connections
    $stmt = null;
	$conn = null;
} else {
	// Redirect to the home page if the form is not submitted
    header("Location: ../index.php");
	exit();
}
?>