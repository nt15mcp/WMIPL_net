<?php
/**
 * Text Submission Script
 *
 * PHP script to handle the submission of text content to the database. Starts a session,
 * retrieves user input from the form, inserts the data into the 'pages' table in the database,
 * and redirects the user accordingly based on the success or failure of the operation.
 */
// Start a new session or resume the existing session
session_start();

// Check if the 'text-submit' form is submitted
if (isset($_POST['text-submit'])) {
	
	// Include the database connection file
    require 'dbh.inc.php';
	
	// Retrieve user input from the form
    $page = $_SESSION['page'];
	$user = $_SESSION['userID'];
	$content = $_POST['content'];
	
	// Prepare and execute a query to insert text content into the 'pages' table
    $sql = "INSERT INTO pages (page, content, user_id, created_at) VALUES (?, ?, ?, Now())";
	$stmt = mysqli_stmt_init($conn);
	
	// Check for SQL query preparation errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
		// Redirect the user with an error message for SQL query errors
        header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		unset($_SESSION['page']);
		exit();
	} else {
		// Bind parameters, execute the query, and handle the result
        mysqli_stmt_bind_param($stmt, "ssi", $page, $content, $user);
		mysqli_stmt_execute($stmt);
		
		// Check for database errors and print any error messages
        echo mysqli_error($conn);
		
		// Redirect the user with a success message
        header("Location: ../".$_SESSION['page'].".php?edit=succuss");
		unset($_SESSION['page']);
		exit();
	}
	
	// Close prepared statement and database connection
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else {
	// Redirect the user to the index page if the form is not submitted
    header("Location: ../index.php");
	exit();
}