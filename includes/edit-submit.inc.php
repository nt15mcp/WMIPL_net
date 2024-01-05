<?php
/**
 * Edit Profile Submission Script
 *
 * PHP script to handle the submission of edited user profile information.
 * Validates and sanitizes user input, performs checks on phone number and ZIP code,
 * updates user session variables, and updates the user profile information in the database.
 */

// Start a new session or resume the existing session
session_start();

// Check that the submission came from the right place
if(isset($_SESSION['page']) && $_SESSION['page'] != 'edit'){
	//Shouldn't be here, send them home
	header("Location:../index.php");
	exit();
}
// Check if the 'edit-submit' form is submitted
if(isset($_POST['edit-submit'])){
	
	// Check and validate ZIP code if provided
    if(isset($_POST['zip'])){
		if(!is_numeric($_POST['zip']) || strlen($_POST['zip']) != 5){
			// Redirect with an error message for invalid ZIP code
            header("Location: ../edit.php?error=invalidzip");
			exit();
		}	
	}
	
	// Check and validate secondary phone number if provided
    if(isset($_POST['phonesec'])){
		$phoneDigits = strlen(preg_replace("/[^0-9]/", "", $_POST['phone']));

        if ($phoneDigits < 7 || $phoneDigits > 11 || $phoneDigits == 9) {
            // Redirect with an error message for invalid secondary phone number
            header("Location: ../edit.php?error=invalidsecphone");
            exit();
        }

        if ($phoneDigits == 11 && substr(preg_replace("/[^0-9]/", "", $_POST['phone']), 0, 1) != 1) {
            // Redirect with an error message for invalid secondary phone number
            header("Location: ../edit.php?error=invalidsecphone");
            exit();
        }
	}
	
	// Include the database connection file
    require "dbh.inc.php";
	
	// Update user session variables with the edited information
    $_SESSION['userName'] = $_POST['userName'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['firstname'] = $_POST['firstname'];
	$_SESSION['middlename'] = $_POST['middlename'];
	$_SESSION['lastname'] = $_POST['lastname'];
	
	// Format and update phone number in session
    if(strlen(preg_replace("/[^0-9]/", "", $_POST['phone'])) > 10){
		$_SESSION['phone'] = substr(preg_replace("/[^0-9]/", "", $_POST['phone']),1);
	}else{
		$_SESSION['phone'] = preg_replace("/[^0-9]/", "", $_POST['phone']);
	}
	
	// Update session variables with address information
    $_SESSION['street'] = $_POST['street'];
	$_SESSION['street2'] = $_POST['street2'];
	$_SESSION['city'] = $_POST['city'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['zip'] = preg_replace("/[^0-9]/", "", $_POST['zip']);
	
	// Prepare and execute SQL query to update user profile information
	$sql = "UPDATE users SET firstname=?, middlename=?, lastname=?, phone=?, street=?, street2=?, city=?, state=?, zip=? WHERE login_id=".$_SESSION['userID'];
	$stmt = mysqli_stmt_init($conn);
	
	// Check for SQL query preparation errors
    if(!mysqli_stmt_prepare($stmt, $sql)){
		// Redirect with an error message for SQL query errors
        header("Location: ../edit.php?error=sqlierror");
		exit();
	}else{
		// Bind parameters and execute the query
        mysqli_stmt_bind_param($stmt, "sssssssssi", $_SESSION['firstname'], $_SESSION['middlename'], $_SESSION['lastname'], $_SESSION['phone'], $_SESSION['street'], $_SESSION['street2'], $_SESSION['city'], $_SESSION['state'], $_SESSION['zip']);
		mysqli_stmt_execute($stmt);
	}
	
	// Prepare and execute SQL query to update login information
    $sql = "UPDATE logins SET username=?, email=? WHERE login_id=".$_SESSION['userID'];
	$stmt=mysqli_stmt_init($conn);
	
	// Check for SQL query preparation errors
    if(!mysqli_stmt_prepare($stmt, $sql)){
		// Redirect with an error message for SQL query errors
        header("Location: ../edit.php?error=sqlierror");
		exit();
	}else{
		// Bind parameters and execute the query
		mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userName'], $_SESSION['email']);
		mysqli_stmt_execute($stmt);
	}
	// Redirect to the edit page after successful profile update
    header("Location: ../edit.php");
	exit();

	// Close prepared statement and database connection
    mysqli_stmt_close($stmt);
	mysqli_close($conn);
}else{
	// Redirect to the index page if the form is not submitted
    header("Location: ../index.php");
	exit();
}
