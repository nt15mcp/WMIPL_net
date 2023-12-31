<?php
/**
 * User Login Script
 *
 * PHP script to handle user login functionality. Starts a session, checks for
 * valid login credentials in the database, and redirects the user accordingly.
 */

	// Start a new session or resume the existing session
	session_start();

	// Check if the 'page' session variable is not set
	if(!isset($_SESSION['page'])){
		// Shouldn't be here, send them home
		header("Location: ../index.php");
	}

	// Check if the login form is submitted
	if (isset($_POST['login-submit'])) {
		
		// Include the database connection file
		require "dbh.inc.php";
		
		// Retrieve user input from the login form
		$emailusername = filter_input(INPUT_POST,'username',FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);
		
		// Check if the username or email and password fields are empty
		if (is_null($emailusername) || is_null($password)) {
			// Redirect the user with an error message for empty fields
			$_SESSION['error'] = 'login_error';
			header("Location: ../".$_SESSION['page'].".php");
			exit();
		} else {
			// Prepare and execute a query to retrieve user information
			$sql = "SELECT * FROM logins WHERE username=:username OR email=:email";
			
			$stmt = $conn->prepare($sql);
			// Bind parameters, execute the query, and get the result
			$stmt -> bindParam(':username', $emailusername, PDO::PARAM_STR);
			$stmt -> bindParam(':email', $emailusername, PDO::PARAM_STR);
			$stmt -> execute();

			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			
			// Check if a user with the provided credentials exists
			if ($result) {
				// Verify the password
				$pwdCheck = password_verify($password, $result['password']);
				
				// Check if the password is incorrect
				if (!$pwdCheck) {
					$_SESSION['error'] = 'login_error';
					header("Location: ../".$_SESSION['page'].".php");
					exit();
				} elseif ($pwdCheck) {
					// Set user session variables on successful login
					$_SESSION['userID'] = $result['id'];
					$_SESSION['userName'] = $result['username'];
					$_SESSION['email'] = $result['email'];
					
					// Retrieve additional information for executive users
					$sql = "SELECT * FROM executives WHERE login_id=:userId";
					$stmt = $conn->prepare($sql);
					// Bind parameters, execute the query, and get the result
					$stmt -> bindParam(':userId', $_SESSION['userID'], PDO::PARAM_INT);
					$stmt -> execute();
					
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					// Check if the user is an executive and set the 'executive' session variable
					if ($result) {
						$_SESSION['executive'] = $result['title'];
					}
					// Close prepared statement and database connection
					$stmt = null;
					$conn = null;
					// Redirect the user
					header("Location: ../".$_SESSION['page'].".php");
					exit();
				}
			} else {
				// Redirect the user with an error message for no user found
				$_SESSION['error'] = 'login_error';
				header("Location: ../".$_SESSION['page'].".php");
				exit();
			}
		}
	} else {
		// Redirect the user to the home page if the login form is not submitted
		header("Location: ../".$_SESSION['page'].".php");
		exit();
	}
?>