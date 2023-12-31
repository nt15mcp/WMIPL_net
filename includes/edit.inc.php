<?php
/**
 * Edit Profile Script
 *
 * PHP script to handle the retrieval of user profile data from the database
 * for the purpose of editing. Starts a session, retrieves user profile information
 * based on the user's session ID, and redirects to the edit page with the retrieved data.
 */

// Start a new session or resume the existing session
session_start();

// Check if the 'edit-profile' form is submitted
if(isset($_POST['edit-profile'])){
	
	// Include the database connection file
    require "dbh.inc.php";
	
	// Prepare and execute a query to select user profile data based on the session ID
    $sql = "SELECT * FROM users WHERE login_id=".$_SESSION['userID'];
	$stmt = mysqli_stmt_init($conn);
	
	// Check for SQL query preparation errors
    if(!mysqli_stmt_prepare($stmt, $sql)){
		// Redirect the user with an error message for SQL query errors
        header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		exit();
	} else {
		// Execute the query and retrieve the result
        mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
			
		// Check if user profile data is found and set session variables
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
		
		// Redirect the user to the edit page
		header("Location: ../edit.php");
		exit();
	}
	
	// Close prepared statement and database connection
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else {
	// Redirect the user to the index page if the form is not submitted
    header("Location: ../index.php");
	exit();
}
