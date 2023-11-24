<?php

if (isset($_SESSION['page'])) {
	
	require 'dbh.inc.php';
	
	$page = $_SESSION['page'];
	
	$sql = "SELECT Content FROM Editor WHERE Page = ? ORDER BY Created DESC LIMIT 1" ;
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: ../".$_SESSION['page'].".php?error=sqlierror");
		unset($_SESSION['page']);
		exit();
	}
	else {
		mysqli_stmt_bind_param($stmt, "s", $page);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($row = mysqli_fetch_assoc($result)) {
			$content = $row['Content'];
		}
		else {
			$content = "<p>Oops!  We couldn't find the content for this page</br><p>Please try again later.</p>";
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else {
	header("Location: ../index.php");
	exit();
}