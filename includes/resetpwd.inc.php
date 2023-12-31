<?php
/**
 * New Password Submission
 *
 * This script handles the submission of a new password for a user who has initiated a password reset.
 * It validates the input, checks the token, updates the user's password in the database,
 * and deletes the password reset entry after a successful password change.
 *
 */

if (isset($_POST["new-password-submit"])) {
	// Retrieve data from the form submission
    $selector = $_POST["selector"];
	$validator = $_POST["validator"];
	$password = $_POST["password"];
	$pass1 = $_POST["pass1"];
	
	// Validate password fields
    if (empty($password) || empty($pass1)) {
		header("Location: ../signup.php?error=invalidpassword");
		exit();
	} else if ($password !== $pass1) {
		header("Location: ../signup.php?error=invalidpassword");
		exit();
	}
	
	// Get the current date
    $currentDate = date("U");
	
	// Include the database helper
    require 'dbh.inc.php';
	
	// Check if the token is valid and not expired
    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires>=?";
	$stmt = mysqli_stmt_init($conn);
	
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../signup.php?error=sqlierror");
		exit();	
	} else {
		mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
		mysqli_stmt_execute($stmt);
		
		$result = mysqli_stmt_get_result($stmt);
		
		// Check if the row exists
        if (!$row = mysqli_fetch_assoc($result)) {
			header("Location: ../signup.php?error=sqlierror");
			exit();
		} else {
			// Verify the password reset token
            $tokenBin = hex2bin($validator);
			if(!password_verify($tokenBin, $row["pwdResetToken"])){
				header("Location: ../signup.php?error=sqlierror");
				exit();
			} else {
				$email = $row["pwdResetEmail"];
				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
				
				// Update the password for the user
				$sql = "UPDATE logins SET password=? WHERE email=?";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlierror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
					mysqli_stmt_execute($stmt);
				}
				
				// Delete the password reset entry
                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../signup.php?error=sqlierror");
					exit();
				} else {
					mysqli_stmt_bind_param($stmt, "s", $email);
					mysqli_stmt_execute($stmt);
					header("Location: ../signup.php?reset=success");
					exit();
				}
			}
		}
	}

	// Close database connections
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else {
	// Redirect to the home page if the form is not submitted
    header("Location: ../index.php");
	exit();
}
?>