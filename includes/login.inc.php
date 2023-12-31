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
	// Set the 'page' session variable to a default value ('home' in this case)
    $_SESSION['page'] = 'home';
}

// Check if the login form is submitted
if (isset($_POST['login-submit'])) {
	
	// Include the database connection file
    require "dbh.inc.php";
	
	// Retrieve user input from the login form
    $emailusername = $_POST['username'];
	$password = $_POST['password'];
	
	// Check if the username or email and password fields are empty
    if (empty($emailusername) || empty($password)) {
		// Redirect the user with an error message for empty fields
        header("Location: ../".$_SESSION['page'].".php?error=emptyfields&username=".$emailusername);
		exit();
	} else {
		// Prepare and execute a query to retrieve user information
        $sql = "SELECT * FROM logins WHERE username=? OR email=?";
		$stmt = mysqli_stmt_init($conn);
		
		// Check for SQL query preparation errors
        if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
			exit();
		} else {
			// Bind parameters, execute the query, and get the result
            mysqli_stmt_bind_param($stmt, "ss", $emailusername, $emailusername);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			
			// Check if a user with the provided credentials exists
            if ($row = mysqli_fetch_assoc($result)) {
				// Verify the password
                $pwdCheck = password_verify($password, $row['password']);
				
				// Check if the password is incorrect
                if ($pwdCheck == false) {
					header("Location: ../".$_SESSION['page'].".php?error=wrongpwd");
					exit();
				} elseif ($pwdCheck == true) {
					// Set user session variables on successful login
                    $_SESSION['userID'] = $row['id'];
					$_SESSION['userName'] = $row['username'];
					$_SESSION['email'] = $row['email'];
					
					// Retrieve additional information for executive users
                    $sql = "SELECT * FROM executives WHERE login_id=".$_SESSION['userID'];
					$stmt = mysqli_stmt_init($conn);
					
					// Check for SQL query preparation errors
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
						header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
						exit();
					} else {
						// Execute the query and get the result
                        mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						
						// Check if the user is an executive and set the 'executive' session variable
                        if ($row = mysqli_fetch_assoc($result)) {
							$_SESSION['executive'] = $row['title'];
						}
					}
					
					// Redirect the user with a success message
                    header("Location: ../".$_SESSION['page'].".php?login=success");
					exit();
				} else {
					// Redirect the user with an error message for wrong password
                    header("Location: ../".$_SESSION['page'].".php?error=wrongpwd");
				}
			} else {
				// Redirect the user with an error message for no user found
                header("Location: ../".$_SESSION['page'].".php?error=nouser");
				exit();
			}
		}
	}
	
	// Close prepared statement and database connection
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	// Redirect the user to the home page if the login form is not submitted
    header("Location: ../".$_SESSION['page'].".php");
	exit();
}
?>