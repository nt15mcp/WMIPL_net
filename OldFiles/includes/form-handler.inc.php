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

// Verify that the submission is coming from one of my pages and the submission entity is logged in with permissions
if (!isset($_SESSION['page']) || !isset($_SESSION['executive'])){
	// Shouldn't be here, send them home
	header("Location:../index.php");
	exit();
}
// Check if the 'text-submit' form is submitted
if (isset($_POST['text-submit'])) {
	
	// Include the database connection file
    require 'dbh.inc.php';
	
	// Retrieve user input from the form
    $page = $_SESSION['page'];
	$user = $_SESSION['userID'];
	$content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_SPECIAL_CHARS);
	
	// Prepare and execute a query to insert text content into the 'pages' table
    $sql = "INSERT INTO pages (page, content, user_id, created_at) VALUES (:page, :content,:user_id , Now())";
	$stmt = $conn->prepare($sql);
	// Bind parameters, execute the query, and handle the result
    $stmt -> bindParam(':page', $page, PDO::PARAM_STR);
	$stmt -> bindParam(':content', $content, PDO::PARAM_STR);
	$stmt -> bindParam(':user_id', $user, PDO::PARAM_int);
	$stmt -> execute();
	$_SESSION['success'] = 1;
	// Close prepared statement and database connection
    $stmt = null;
	$conn = null;
    header("Location: ../".$_SESSION['page'].".php");
} else {
	// Redirect the user to the index page if the form is not submitted
    header("Location: ../index.php");
	exit();
}