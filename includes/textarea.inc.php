<?php

// Check to see what page is calling this file
if (isset($_SESSION['page'])) {
	
	require 'dbh.inc.php'; // Use common database login file
	
	$page = $_SESSION['page']; // Set page variable for future use
	
	$sql = "SELECT Content FROM Editor WHERE Page = ? ORDER BY Created DESC LIMIT 1" ; // Set query for last saved data for this page
	$stmt = mysqli_stmt_init($conn); // Initialize the query for MySQL
	// Check for good connection, capture error if not
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		unset($_SESSION['page']);
		exit();
	}
	// Execute MySQL query
	else {
		mysqli_stmt_bind_param($stmt, "s", $page);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		// If content exists in the result, assign it to the variable
		if ($row = mysqli_fetch_assoc($result)) {
			$content = $row['Content'];
		}
		// Otherwise give generic error
		else {
			$content = "<p>Oops!  We couldn't find the content for this page</br><p>Please try again later.</p>";
		}
	}
	// Don't leave database connections open!
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	// If no session is running, take us back to the home page to start a session.
	header("Location: ../index.php");
	exit();
}