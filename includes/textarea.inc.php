<?php
/**
 * Dynamic Content Retrieval
 *
 * This script is responsible for retrieving the content associated with a specific page
 * from the database. It checks the current session for the 'page' variable to determine
 * which page is making the request. It uses a common database login file (dbh.inc.php).
 * The retrieved content is stored in the $content variable.
 *
 * Note: This script assumes that the 'page' variable is set in the session, and it
 * redirects to the respective page with an error message if there are issues with
 * database connection or if the content retrieval fails.
 *
 */

// Check to see what page is calling this file
if (isset($_SESSION['page'])) {
	
	require 'dbh.inc.php'; // Use common database login file
	
	$page = $_SESSION['page']; // Set page variable for future use
	
	$sql = "SELECT content FROM pages WHERE page = :page ORDER BY created_at DESC LIMIT 1" ; // Set query for last saved data for this page
	$stmt = $conn->prepare($sql); // Initialize the query for MySQL
	$stmt -> bindParam(':page', $page, PDO::PARAM_STR);
	$stmt -> execute();

	// Get the resulting array
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result){
		$content = $result['content'];
	} else {
		// Otherwise give generic error
		$content = "<p>Oops!  We couldn't find the content for this page</br><p>Please try again later.</p>";
	}

	// Close database connections to avoid leaving them open
	$stmt = null;
	$conn = null;
}
else {
	// If no session is running, take us back to the home page to start a session.
	header("Location: ../index.php");
	exit();
}
?>