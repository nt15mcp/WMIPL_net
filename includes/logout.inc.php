<?php
/**
 * Session Reset and Redirect
 *
 * PHP script to reset the session, redirect the user to the page
 * they were on before the session was destroyed, and maintain the 'page' value.
 * This script is often used to handle user logouts or other session management tasks.
 */

// Start a new session or resume the existing session
session_start();

// Check if the 'page' session variable is not set
if (!isset($_SESSION['page'])){
	// Set the 'page' session variable to a default value ('home' in this case)
    $_SESSION['page']='home';
}

// Store the current value of the 'page' session variable in the $page variable
$page = $_SESSION['page'];

// Destroy the current session (this will clear all session data)
session_destroy();

// Start a new session (a new session is started after destroying the current one)
session_start();


// Restore the value of the 'page' session variable from the $page variable
$_SESSION['page'] = $page;

// Redirect the user to the page corresponding to the 'page' session variable
header("Location: ../".$_SESSION['page'].".php");
?>